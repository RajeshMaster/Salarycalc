<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class SalBank extends Model {

	public static function fnGetBankDetails($request){
	  	$db = DB::connection('mysql_MB');

	  	$query = $db->TABLE('emp_mstemployees AS emp')
	  				->SELECT('emp.Emp_ID',
  							 'emp.LastName',
  							 'emp.FirstName',
  							 'mb.AccNo',
  							 'mstBnk.BankName',
  							 'mstBrch.BranchName',
  							 'mstBrch.BranchNo');

			$joincondition = $query->leftJoin('mstbank AS mb', function($join){
					                        $join->on('mb.user_id', '=', 'emp.Emp_ID');
					                        $join->on('mb.mainFlg', '=',DB::raw('1'));
					                        $join->on('mb.Location', '=',DB::raw('2'));
					                });

			$query = $query ->leftJoin('mstbanks AS mstBnk' , 'mstBnk.id' ,'=','mb.BankName')
                		    ->leftJoin('mstbankbranch AS mstBrch', function($join){
			                            $join->on('mstBrch.id', '=', 'mb.BranchName');
			                            $join->on('mstBrch.BankId', '=','mb.BankName');
                         			})
                		    ->WHERE([['emp.delFlg', '=', 0],
							 			['emp.Title', '=', 2],
							 		  	['emp.resign_id', '=', 0],
							 		  	['emp.Emp_ID', 'NOT LIKE', '%NST%']]);

  			$query = $query	->groupBy('emp.Emp_ID') 
							->orderBy($request->banksort, $request->sortOrder)
					  		->paginate($request->plimit);

		return $query;
	}

	public static function fnGetAddressDetails($request){
	  	
	  	$db = DB::connection('mysql_MB');
		$query = $db->TABLE('emp_mstemployees AS emp')
					  ->SELECT('emp.Emp_ID','emp.FirstName','emp.LastName','alien.id','alien.user_id',
								DB::raw("CONCAT('〒',addr.pincode,' ', addr.jpstate,'',addr.jpaddress,'-',addr.roomno,'号') AS full_address"))
					  ->leftJoin('mstalien as alien', function($join){
						        $join->on('emp.Emp_ID' ,'=','alien.user_id')
								      ->on('alien.EdDate', '=', DB::raw("(Select MAX(EdDate) from mstalien where user_id = emp.Emp_ID)"));
						})
					  ->leftJoin('mstaddress as addr' , 'alien.Address' ,'=','addr.id')
					  ->where([['emp.delFlg', '=', 0],
					 		  ['emp.resign_id', '=', 0],
					 		  ['emp.Title', '=', 2],
					 		  ['emp.Emp_ID', 'NOT LIKE', '%NST%']]);
					  
		$query = $query ->orderBy($request->addresssort, $request->sortOrder)
				  		->paginate($request->plimit);

		return $query;
	}

	public static function fnGetFamilyDetails($request){

	
	  	$db = DB::connection('mysql_MB');

	  	$query = $db->table('emp_mstemployees')
					 ->select('*')
					 ->where([['delFlg', '=', 0],
					 		  ['resign_id', '=', 0],
					 		  ['Emp_ID', 'NOT LIKE', '%NST%']]);

		$query = $query->where('Title', '=', 2);
		if ($request->singlesearch != '') {
			$query = $query->where(function($joincont) use ($request) {
                    	$joincont->where('Emp_ID', 'LIKE', '%' . $request->singlesearch . '%')
                    		 	 ->orwhere('Lastname', 'LIKE', '%' . $request->singlesearch . '%');
            });
        }

	  	// $query= $db->table('emp_mstemployees as emp')
				// 		->SELECT('emp.*',
				// 				DB::raw("CONCAT(wife.FirstName,' ',wife.LastName) AS wifeName"),
				// 				DB::raw("CONCAT(son.FirstName,' ',son.LastName) AS sonName"),
				// 				DB::raw("CONCAT(daughter.FirstName,' ',daughter.LastName) AS daughterName"),
				// 				DB::raw("CONCAT(wife.Kana_FirstName,' ',wife.Kana_LastName) AS wifeKanaName"),
				// 				DB::raw("CONCAT(son.Kana_FirstName,' ',son.Kana_LastName) AS sonKanaName"),
				// 				DB::raw("CONCAT(daughter.Kana_FirstName,' ',daughter.Kana_LastName) AS daughterKanaName"),
				// 				'wife.DOB as wifeDOB',
				// 				'son.DOB as sonDOB',
				// 				'daughter.DOB as daughterDOB'
				// 			)

				// 		->leftJoin('myfamily_details as wife', function($join){
				// 		        $join->on('emp.Emp_ID', '=', 'wife.Emp_ID')
				// 				     ->where('wife.Emp_Relation', '=', 1);
				// 		})	
				// 		->leftJoin('myfamily_details as son', function($join){
				// 		        $join->on('emp.Emp_ID', '=', 'son.Emp_ID')
				// 				     ->where('son.Emp_Relation', '=', 2);
				// 		})	
				// 		->leftJoin('myfamily_details as daughter', function($join){
				// 		        $join->on('emp.Emp_ID', '=', 'daughter.Emp_ID')
				// 				     ->where('daughter.Emp_Relation', '=', 3);
				// 		})	
				// 		->where([['emp.delFlg', '=', 0],
				// 		 		  ['emp.resign_id', '=', 0],
				// 		 		  ['emp.Title', '=', 2],
				// 		 		  ['emp.Emp_ID', 'NOT LIKE', '%NST%']]);

		$query = $query	 ->orderBy($request->familysort, $request->sortOrder)
					  		 ->paginate($request->plimit);
							// ->toSql();
       //                       dd($query);
		return $query;
	}

}