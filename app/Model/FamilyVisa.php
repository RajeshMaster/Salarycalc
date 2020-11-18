<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class FamilyVisa extends Model {

	public static function fnGetEmpDetails($Emp_ID){

	  	$db = DB::connection('mysql_MB');

  		$query = $db->table('emp_mstemployees')
  				->select('id',
  						'Emp_ID',
  						'FirstName',
  						'LastName',
  						'MartialStatus')
  				->where('Emp_ID', '=', $Emp_ID)
  				->get();
  		 		  
		return $query;
	}

	public static function fnGetVisaDetails($request,$flg){

	  	$db = DB::connection('mysql');
  		$query = $db->table('familyvisa_details')
  				->select('*');

			if($flg == 0){
				$query = $query->where('Emp_ID', '=', $request->Emp_ID)
								->where('delFlg', '=', 0);
			} else {
				$query = $query->where('id', '=', $request->id)
								->where('delFlg', '=', 0);
			}
  				
  			$query = $query->orderBy('EdDate','DESC')
							->get();  		 		  

		return $query;
	}

	public static function getEmpVisaAddress($Emp_ID) {
      $db = DB::connection('mysql_MB');
      $visaAddress = $db->table('mstalien as mst')
      						->SELECT('mst.Address', DB::raw("CONCAT('〒',addr.pincode,' ', addr.jpstate,'',addr.jpaddress,'-',addr.roomno,'号') AS full_address"))
      						->leftJoin('mstaddress as addr' , 'addr.id' ,'=','mst.Address')
                            ->WHERE('mst.user_id', '=', $Emp_ID)
                            ->orderBy('mst.EdDate', 'DESC')
                            ->limit(1)
                            ->get();      

      return $visaAddress;

    }

    public static function insertFamilyVisaRec($request,$gender){

	  	$db = DB::connection('mysql');
  		$insert=$db->table('familyvisa_details')
  				   ->insert(['Emp_ID' => $request->Emp_ID,
			               'Emp_Relation' => $request->Emp_Relation,
			               'Gender' => $gender,
			               'Nationality' => $request->Nationality,
			               'NationalityOthers' => $request->NationalityOthers,
			               'FirstName' => $request->FirstName,
			               'LastName' => $request->LastName,
			               'Kana_FirstName' => $request->Kana_FirstName,
			               'Kana_LastName' => $request->Kana_LastName,
			               'DOB' => $request->DOB,
			               'CardNo' => $request->CardNo,
			               'NoYears' => ($request->NoYears + 1),
			               'StDate' => $request->StDate,
			               'EdDate' => $request->EdDate,
			               'VisaStatus' => $request->VisaStatus,
			               'Address' => $request->Address,
			               'CreatedBy' => Auth::user()->username,
			               'CreatedDateTime' => date('Y-m-d H:i:s')
			           ]);
      	return $insert;
	}

	public static function updateFamilyVisaRec($request,$gender) {

      $db = DB::connection('mysql');
      $update=$db->table('familyvisa_details')
              ->where('Emp_ID', $request->Emp_ID)
              ->where('id', $request->id)
              ->update(['Emp_Relation' => $request->Emp_Relation,
		               'Gender' => $gender,
		               'Nationality' => $request->Nationality,
		               'NationalityOthers' => $request->NationalityOthers,
		               'FirstName' => $request->FirstName,
		               'LastName' => $request->LastName,
		               'Kana_FirstName' => $request->Kana_FirstName,
		               'Kana_LastName' => $request->Kana_LastName,
		               'DOB' => $request->DOB,
		               'CardNo' => $request->CardNo,
		               'NoYears' => ($request->NoYears + 1),
		               'StDate' => $request->StDate,
		               'EdDate' => $request->EdDate,
		               'VisaStatus' => $request->VisaStatus,
		               'Address' => $request->Address,
		               'UpdatedBy' => Auth::user()->username,
		               'UpdatedDateTime' => date('Y-m-d H:i:s')
			           ]);
      return $update;
    }

    public static function getlatFamilyVisaDet() {
      $db = DB::connection('mysql');
      $latDetails = $db->table('familyvisa_details')->max('id');
      return $latDetails;
    }

    public static function getEmpRelationInJapan($Emp_ID){
    	$db = DB::connection('mysql');
     	$query = $db->table('emp_family_details')
     						  ->Select('relationType')
     						  ->Where('Emp_ID','=',$Emp_ID)
     						  ->Where('liveInJapan','=',1)
     						  ->groupBy('relationType')
     						  ->get();

     		$relationInJapan = array();
     		foreach ($query as $key => $value) {
     			$relationInJapan[$value->relationType] = $value->relationType;
     		}

     	return $relationInJapan;
    }

    public static function fnGetBasicDetails($request){
    	$db = DB::connection('mysql');
     	$query = $db->table('emp_family_details')
     						  ->Select('FirstName',
     									'LastName',
     									'Kana_FirstName',
     									'Kana_LastName',
     									'DOB')
     						  ->Where([['Emp_ID','=',$request->Emp_ID],
							 			['relationType', '=', $request->relationType],
							 		  	['subRelationType', '=', $request->subRelationType]])
     						  ->get();
     	return $query;
    }

    public static function fnGetSubRelations($request){
    	$db = DB::connection('mysql');
     	$query = $db->table('emp_family_details')
     						  ->Select('subRelationType')
     						  ->Where([['Emp_ID','=',$request->Emp_ID],
							 			['relationType', '=', $request->relationType]])
     						  ->orderBy('DOB')
     						  ->get();
     	return $query;
    }


	

}