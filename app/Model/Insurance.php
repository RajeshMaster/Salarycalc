<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class Insurance extends Model {

	public static function fnGetEmployeeDetails($request){

		if ($request->selYear != "") {
			$selYear = $request->selYear;
		} else {
			$selYear = date('Y');
		}

	  	$db = DB::connection('mysql_MB');

	  	$query = $db->table('mstexpenses_dtl as expenses')
	  				->select('employees.Emp_Id',
							 'employees.FirstName',
							 'employees.LastName',
							 DB::raw('GROUP_CONCAT(Amount ORDER BY expenses.Date,expenses.Ins_TM) as Amounts'),
							 DB::raw('GROUP_CONCAT(Month(Date) ORDER BY expenses.Date,expenses.Ins_TM) as months'))

	  				->leftJoin('emp_mstemployees as employees', function($join)
				        {
				            $join->on('employees.Emp_Id', '=', 'expenses.Emp_ID');
				        })
	  				->where([['expenses.Date', 'LIKE', $selYear.'%'],
					 			['expenses.main_sub', '=', 7 ],
					 			['expenses.su_sub', '=', 17 ]
					 		]);

			$query = $query	->groupBy('expenses.Emp_ID') 
							->orderBy($request->basicsort, $request->sortOrder)
					  		->paginate($request->plimit);
					  		 // ->tosql();
					  		 // dd($query);
			return $query;
	}

	public static function getYears() {

		$db = DB::connection('mysql_MB');
		$years = $db->table('mstexpenses_dtl as expenses')
							->select(DB::raw('YEAR(Date) as years'))
							->where('expenses.main_sub', '=', 7 )
							->groupBy(DB::raw('YEAR(Date)'))
							->get();
	 	return $years;
	}

}