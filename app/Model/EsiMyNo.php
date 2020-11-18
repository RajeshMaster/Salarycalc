<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class EsiMyNo extends Model {

	public static function fnGetEsiMyNoDetails($Emp_ID){

		$db = DB::connection('mysql');
	  	$query= $db->table('emp_esimyno_details')
	  				->Select('*')
	  				->where('Emp_ID','=',$Emp_ID)
	  				->get();

		return $query;
	}

	public static function fnGetAllEmpDetails($request){
	  	$db = DB::connection('mysql_MB');

	  	$query = $db->TABLE('emp_mstemployees')
	  				->SELECT('Emp_ID',
  							 'LastName',
  							 'FirstName')
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

  			$query = $query ->orderBy($request->esiMyNoSort, $request->sortOrder)
					  		->paginate($request->plimit);

		return $query;
	}

	public static function fnGetEmpDetails($request){

	  	$db = DB::connection('mysql_MB');
  		$query =  $db->TABLE('emp_mstemployees')
	  				->SELECT('Emp_ID',
  							 'LastName',
  							 'FirstName')
	  				->Where('Emp_ID', '=', $request->Emp_ID)
	  				->get();
  		 		  
		return $query;
	}


	public static function insertOrUpdate($request) {
		$db = DB::connection('mysql');
  		$insert = $db->table('emp_esimyno_details')
			         ->updateOrInsert([
					   		'Emp_ID' => $request->Emp_ID
			           	],
			       		[
					        'Emp_ID' => $request->Emp_ID,
							'Emp_Name' => $request->Emp_Name,
					        'myNo' => $request->myNo,
					        'esiRegDate' => $request->esiRegDate,
					        'esiNo' => $request->esiNo,
					        'createdBy' => Auth::user()->username,
							'createdDateTime' => date('Y-m-d h:i:s'),
							'updatedBy' => Auth::user()->username,
							'updatedDateTime'=> date('Y-m-d h:i:s'),
			           ]);	

      	return $insert;
	}



}