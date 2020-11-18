<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class Leavedtls extends Model {

	public static function fnGetEmployeeDetails($request){

		if ($request->selYear != "") {
			$selYear = $request->selYear;
		} else {
			$selYear = date('Y');
		}

	  	$query = DB::table('inv_salary_main')
	  				->select('Emp_Id',
							 DB::raw('GROUP_CONCAT(leave_cnt ORDER BY month) as leave_cnt'),
							 DB::raw('GROUP_CONCAT(month ORDER BY month) as months'))
	  				->where('year', '=', $selYear);

			$query = $query	->groupBy('Emp_ID') 
							->orderBy($request->basicsort, $request->sortOrder)
					  		->paginate($request->plimit);
			return $query;
	}

	public static function getYears() {
		$years = DB::table('inv_salary_main')
							->select(DB::raw('year as years'))
							->groupBy(DB::raw('year'))
							->get();
	 	return $years;
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