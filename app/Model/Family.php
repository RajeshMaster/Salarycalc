<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class Family extends Model {

	public static function fnGetAllFamilyDetails($empArr){

		$db = DB::connection('mysql');
	  	$query= $db->table('emp_family_details')
	  				->whereIn('Emp_ID',$empArr)
	  				->orderBy('relationType')
		  			->orderBy('DOB')
	  				->get();

		return $query;
	}

	public static function fnGetAllEmpDetails($request){
	  	$db = DB::connection('mysql_MB');

	  	$query = $db->TABLE('emp_mstemployees')
	  				->SELECT('Emp_ID',
  							 'LastName',
  							 'FirstName',
  							 'MartialStatus')
                	->WHERE([['delFlg', '=', 0],
				 			['Title', '=', 2],
				 		  	['resign_id', '=', 0],
				 		  	['Emp_ID', 'NOT LIKE', '%NST%']]);

            if ($request->singlesearch != '') {
				$query = $query->where(function($joincont) use ($request) {
	                    	$joincont->where('Emp_ID', 'LIKE', '%' . $request->singlesearch . '%')
	                    		 	 ->orwhere('Lastname', 'LIKE', '%' . $request->singlesearch . '%');
	            });
	        }

  			$query = $query ->orderBy($request->familysort, $request->sortOrder)
					  		->paginate($request->plimit);

		return $query;
	}

	public static function fnGetEmpDetails($request){

	  	$db = DB::connection('mysql_MB');

  		$query = $db->TABLE('emp_mstemployees AS emp')
				  ->SELECT('emp.Emp_ID','emp.FirstName','emp.LastName','emp.MartialStatus','alien.id','alien.user_id',
							DB::raw("CONCAT('〒',addr.pincode,' ', addr.jpstate,'',addr.jpaddress,'-',addr.roomno,'号') AS full_address"))
				  ->leftJoin('mstalien as alien', function($join){
					        $join->on('emp.Emp_ID' ,'=','alien.user_id')
							      ->on('alien.EdDate', '=', DB::raw("(Select MAX(EdDate) from mstalien where user_id = emp.Emp_ID)"));
					})
				  ->leftJoin('mstaddress as addr' , 'alien.Address' ,'=','addr.id')
  				  ->where('Emp_ID', '=', $request->Emp_ID)
  				  ->get();
  		 		  
		return $query;
	}

	public static function fnGetFamilyDetails($request,$flg){

	  	$db = DB::connection('mysql');
  		$query = $db->table('emp_family_details')
  				->select('*')
  				->where('Emp_ID', '=', $request->Emp_ID)
  				// ->where('activeFlg', '=', 0)
  				->where('delFlg', '=', 0);

  			if($flg == 0){
		  		$query = $query ->orderBy('relationType')
		  						->orderBy('DOB');
  			} else if($flg == 1 && isset($request->id)) {
  				$query = $query ->where('id','=', $request->id);
  			}
  		// 		->orderByRaw(
				//      "CASE 
				//      	WHEN relationType = 5 THEN DOB
				//      	WHEN relationType = 6 THEN DOB
				//       END"
				// )
  		$query = $query->get();						  		 		  

		return $query;
	}

    public static function insertFamilyRec($request,$gender,$relCount){

	  	$db = DB::connection('mysql');
  		$insert=$db->table('emp_family_details')
  				   ->insert(['Emp_ID' => $request->Emp_ID,
			               'relationType' => $request->relationType,
			               'subRelationType' => $relCount,
			               'FirstName' => $request->FirstName,
			               'LastName' => $request->LastName,
			               'Kana_FirstName' => $request->Kana_FirstName,
			               'Kana_LastName' => $request->Kana_LastName,
			               'Gender' => $gender,
			               'DOB' => $request->DOB,
			               'liveInJapan' => (($request->liveInJapan) ? 1 : 0),
			               'CreatedBy' => Auth::user()->username,
			               'CreatedDateTime' => date('Y-m-d H:i:s'),
			               'regFlg' => 1
			           ]);
      	return $insert;
	}

	public static function updateFamilyRec($request,$gender,$relCount) {

      $db = DB::connection('mysql');
      $update=$db->table('emp_family_details')
              ->where('Emp_ID', $request->Emp_ID)
              ->where('id', $request->id)
              ->update(['relationType' => $request->relationType,
		               'subRelationType' => (($relCount) ? $relCount : $request->subRelationType),
		               'FirstName' => $request->FirstName,
		               'LastName' => $request->LastName,
		               'Kana_FirstName' => $request->Kana_FirstName,
		               'Kana_LastName' => $request->Kana_LastName,
		               'Gender' => $gender,
		               'DOB' => $request->DOB,
		               'liveInJapan' => (($request->liveInJapan) ? 1 : 0),
		               'UpdatedBy' => Auth::user()->username,
		               'UpdatedDateTime' => date('Y-m-d H:i:s')
			           ]);
      return $update;
    }

    public static function fnOldDbDetails(){
		$db = DB::connection('mysql');
		$result= DB::table('olddbdetailsregistration')
						->SELECT('*')
						->WHERE('Delflg', '=', 0)
						->lists('DBName','id');
		return $result;
	}

	public static function fnGetConnectionQuery($request){
		$db = DB::connection('mysql');
		$query= $db->table('olddbdetailsregistration')
						->SELECT('*')
						 ->where([['Delflg', '=', 0],
					 		     ['id', '=', $request->contentsel]])
						->get();
		return $query;
	} 

	public static function fnGetSubRelation($Emp_ID,$relationType,$subRelation){
		$db = DB::connection('mysql');
		$query = $db->table('emp_family_details')
					->select('*')
					->where([['Emp_ID', '=', $Emp_ID],
					 		  ['relationType', '=', $relationType],
					 		  ['subRelationType', '=', $subRelation],
					 		  ['regFlg', '=', 1]
					 	])
					->get();
		return $query;
	}

	public static function fnGetRelCount($Emp_ID,$relationType){
		$db = DB::connection('mysql');
		$query = $db->table('emp_family_details')
					->select('*')
					->where([['Emp_ID', '=', $Emp_ID],
					 		  ['relationType', '=', $relationType]
					 	])
					->get();
		return count($query);
	}

    public static function fnImportProcess($request){

		$db = DB::connection('otherdb');
	  	$query = $db->table('emp_mstemployees')
					 ->select('*')
					 ->where([['delFlg', '=', 0],
					 		  ['resign_id', '=', 0],
					 		  ['title', '=', 2],
					 		  ['Emp_ID', 'NOT LIKE', '%NST%']
					 		])
					 ->orderBy('Emp_ID')
					 ->get();
		return $query;
	}

	public static function fnInsertOrUpdate($recordArr){

	  	$db = DB::connection('mysql');
  		$insert = $db->table('emp_family_details')
  					->updateOrInsert(
			              [
			                'Emp_ID' => $recordArr['Emp_ID'],
			                'relationType' => $recordArr['relationType'],
			                'subRelationType' => $recordArr['subRelationType']
			              ],
  				   		['Emp_ID' => $recordArr['Emp_ID'],
			               'relationType' => $recordArr['relationType'],
			               'subRelationType' => $recordArr['subRelationType'],
			               'FirstName' => '',
			               'LastName' => $recordArr['lastName'],
			               'Kana_FirstName' => '',
			               'Kana_LastName' => $recordArr['kanaLastName'],
			               'Gender' => $recordArr['gender'],
			               'DOB' => $recordArr['DOB'],
			               'CreatedBy' => Auth::user()->username,
			               'CreatedDateTime' => date('Y-m-d H:i:s')
			           ]);
      	return $insert;
	}



}