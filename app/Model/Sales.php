<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class Sales extends Model {

	public static function fnGetSalesDetails($request){

	  	$db = DB::connection('mysql');
  		$query = $db->table('sales_details')
  				->select('*')  				
  				->where('delFlag','=',0);

  		 	$query = $query	->orderBy('id', 'DESC')
				  		 	->paginate($request->plimit);

		return $query;
	}

	public static function getSales($request){

	  	$db = DB::connection('mysql');
  		$query = $db->table('sales_details')
  				->select('*')  				
  				->where('delFlag','=',0)
  				->where('id','=',$request->id)
  				->get();

		return $query;
	}

	public static function salesInsert($request){
		
		$db = DB::connection('mysql');
		$insert = $db->table('sales_details')
					 ->insert(['period' => $request->period,
					 		   'salesAmount' => $request->salesAmount,
				               // 'salesAmount' => str_replace(",", "", $request->salesAmount),
				               'createdDateTime' => date('Y-m-d h:m:s'),
				               'createdBy' => Auth::user()->username]);

      	return $insert;

	}

	public static function salesUpdate($request){

		$db = DB::connection('mysql');
		$update = $db->table('sales_details')
					 ->where('id', $request->salesId)
					 ->update(['period' => $request->period,
					 		   'salesAmount' => $request->salesAmount,
							   'updatedDateTime' => date('Y-m-d h:m:s'),
							   'updatedBy' => Auth::user()->username]);

		return $update;

	}

}