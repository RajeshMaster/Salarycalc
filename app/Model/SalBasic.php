<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class SalBasic extends Model {

	public static function fnGetEmployeeDetails($request){
	  	$db = DB::connection('mysql');
	  	$query = $db->table('inv_salary_main_emp as salary')
	  				->select(
	  						'salary.Emp_Id',
							 'basic.year_month_from',
							 'basic.year_month_to',
							 'basic.total_month',
							 'basic.activeFlg',
							 'basic.delFlg',
							 DB::raw('(basic.basic_amount + basic.increment_amount) as basicAmount'),
							 'basic.increment_amount',
							 'basic.hra')

	  				->leftJoin('inv_basic_salary as basic', function($join)
				        {
				            $join->on('salary.Emp_ID', '=', 'basic.Emp_ID');
				            $join->where('basic.activeFlg', '=', 0);
				        })
	  				->where([['salary.year', '=', date('Y')],
					 		  ['salary.month', '=', date("m",strtotime("-1 month"))]
					 		]);
	  		 		  
			$query = $query	 ->orderBy($request->basicsort, $request->sortOrder)
					  		 ->paginate($request->plimit);
			return $query;
	}

	public static function basiccalcview($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_basic_salary')
					->SELECT('*')
					->WHERE('activeFlg','=',0)
					->WHERE('Emp_ID','=',$request->Emp_ID)
	 	 			->GET();
	 	return $query;
	}

	public static function basiccalcview_history($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_basic_salary')
					->SELECT('*')
					// ->WHERE('activeFlg','=',1)
					->WHERE('Emp_ID','=',$request->Emp_ID)
					->orderBy('id','DESC')
	 	 			->GET();
	 	return $query;
	}

	public static function datacheck($request,$empid) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_basic_salary')
					->SELECT('Emp_ID')
					->WHERE('Emp_ID','=',$empid)
	 	 			->GET();
	 	return $query;
	}

	public static function fngetid() {
		$Details = DB::TABLE('inv_basic_salary')
						->max('id');
		return $Details;
	}

	public static function fnbasicadd($request) {

		$name = Session::get('FirstName').' '.Session::get('LastName');
		$last_Date = date('Y-m-d', strtotime("+".$request->totalmonth - 1 ." months", strtotime($request->year_month_from)));
		$final_date = date("Y-m-t", strtotime($last_Date));
		$insert=DB::table('inv_basic_salary')
				->insert(
					['id' => '',
					'Emp_ID' => $request->Emp_ID,
					'date' => date('Y-m-d'),
					'basic_amount' => str_replace(",", "", $request->basic_amount),
					'increment_amount' => str_replace(",", "", $request->increment_amount),
					'hra' => str_replace(",", "", $request->hra),
					'year_month_from' => $request->year_month_from,
					'year_month_to' => $final_date,
					'total_month' => $request->totalmonth,
					'delFlg' => 0,
					'CreatedDateTime' => date('Y-m-d H:i:s'),
					'UpdatedDateTime' => date('Y-m-d H:i:s'),
					'CreatedBy' => $name,
					'UpdatedBy' => $name]
			);
		return $insert;
	}

	public static function fnbasicUpdate($request) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$last_Date = date('Y-m-d', strtotime("+".$request->totalmonth - 1 ." months", strtotime($request->year_month_from)));
		$final_date = date("Y-m-t", strtotime($last_Date));

		$update=DB::table('inv_basic_salary')
			->where('id',$request->id)
			->update(
				['basic_amount' => str_replace(",", "", $request->basic_amount),
				'increment_amount' => str_replace(",", "", $request->increment_amount),
				'hra' => str_replace(",", "", $request->hra),
				'year_month_from' => $request->year_month_from,
				'year_month_to' => $final_date,
				'total_month' => $request->totalmonth,
				'UpdatedDateTime' => date('Y-m-d H:i:s'),
				'UpdatedBy' => $name]
		);
		return $update;
	}

	public static function fnUpdateActiveFlg($id) {
		$update=DB::table('inv_basic_salary')
			->where('id',$id)
			->update(['activeFlg' => 1]);
		return $update;
	}

	public static function checkMailFlg($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salary_main')
				->SELECT('mailFlg')
				->WHERE('Emp_ID','=',$request->Emp_ID)
				->orderBy('date','DESC')
				->limit(1)
 	 			->GET();
		return $query;
	}

	// For Salary Mail need or Not need - Madasamy 13/07
	public static function fnupdateMail($request) {
	 	$db = DB::connection('mysql');
		$update=DB::table('inv_basic_salary')
		->where('Emp_ID', $request->Emp_ID)
		->where('activeFlg','=',0)
		->update(['mail_need' => $request->mail_need]);
		return $update;
	}

	public static function fnGetEmpName($Emp_ID){
		$db = DB::connection('mysql_MB');
		$query = $db->table('emp_mstemployees')
					->select('FirstName','LastName','KanaFirstName','KanaLastName')
					->where('Emp_ID','=',$Emp_ID)
					->get();
		return $query;
	}

}