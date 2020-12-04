<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
use Config;

class Gensendtls extends Model {

	public static function getGensenDetail($request, $flg) {
		if ($request->selYear != "") {
			$selYear = $request->selYear;
		} else {
			$selYear = date('Y');
		}
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					 ->select('*')
					 ->where('date','LIKE', $selYear.'%');
		$query = $query ->groupBy('Emp_ID');
		if ($flg == 0) {
			$query = $query->orderBy($request->basicsort, $request->sortOrder)
							->paginate($request->plimit);
		} else {
			$query = $query->orderBy('year','DESC')
							->orderBy('month','DESC')
							->get();
		}
		return $query;
	}

	public static function fnGetEmpDtls($Emp_ID){
		$db = DB::connection('mysql_MB');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->where('Emp_ID','=',$Emp_ID)
					->get();
		return $query;
	}

	public static function getYears() {
		$years = DB::table('inv_salaryplus_main')
							->select(DB::raw("SUBSTRING(date, 1, 4) AS years"))
							->groupBy(DB::raw("SUBSTRING(date, 1, 4)"))
							->get();
	 	return $years;
	}

	public static function fnGetInstotDtls($request,$empId){

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
					->leftJoin('emp_mstemployees as employees', function($join) {
							$join->on('employees.Emp_Id', '=', 'expenses.Emp_ID');
						})
					->where([
							['expenses.Emp_ID', '=', $empId],
							['expenses.Date', 'LIKE', $selYear.'%'],
							['expenses.main_sub', '=', 7 ],
							['expenses.su_sub', '=', 17 ]
						]);
		$query = $query	->groupBy('expenses.Emp_ID') 
						->get();
						// ->tosql();
						// dd($query);
		return $query;
	}

	public static function getsalaryDetailsnodelflg($request,$flg) {
		$db = DB::connection('mysql');
		$query = $db->table('mstsalaryplus')
					->select('id','Name','nick_name','location','Salarayid')
					->where('location','=',$flg)
					->orderBy('Salarayid', 'ASC')
					->get();
		return $query;
	}

	public static function salaryDetailhistory($request, $flg,$Emp_ID) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					 ->select('*')
					 ->where('Emp_ID','=', $Emp_ID)
					 ->where('date','LIKE', $request->selYear.'%')
					 ->orderBy('year','DESC')
					 ->orderBy('month','DESC')
					 ->get();
					
		return $query;
	}

	public static function fnGetstaffDetail($request){
		
		if (!empty($request->Emp_ID)) {
			$db = DB::connection('mysql_MB');
			$query = $db->table('emp_mstemployees as emp')
						->SELECT('emp.*',
								'mb.AccNo',
								'mstBnk.BankName',
								'mstBrch.BranchName',
								'mstBrch.BranchNo',
								DB::raw("CONCAT('〒',addr.pincode,' ', addr.jpstate,'',addr.jpaddress,'-',addr.roomno,'号') AS full_address"))
						->leftJoin('mstalien as alien', function($join){
								$join->on('emp.Emp_ID' ,'=','alien.user_id')
									  ->on('alien.EdDate', '=', DB::raw("(Select MAX(EdDate) from mstalien where user_id = emp.Emp_ID)"));
								})
						->leftJoin('mstaddress as addr' , 'alien.Address' ,'=','addr.id');
						$joincondition = $query->leftJoin('mstbank AS mb',function($join){
													$join->on('mb.user_id', '=', 'emp.Emp_ID');
													$join->on('mb.mainFlg', '=',DB::raw('1'));
													$join->on('mb.Location', '=',DB::raw('2'));
											});

						$query = $query ->leftJoin('mstbanks AS mstBnk','mstBnk.id','=','mb.BankName')
										->leftJoin('mstbankbranch AS mstBrch', function($join){
											$join->on('mstBrch.id', '=', 'mb.BranchName');
											$join->on('mstBrch.BankId', '=','mb.BankName');
										})
							
						->WHERE('emp.Emp_ID', '=', $request->Emp_ID)
						->get();
		} else {
			$query = "";
		}
		return $query;
	}


	public static function fnGetCompanyDetails($request){
	  
	  $db = DB::connection('mysql');
	  $query = $db->table('company_details')
						->select('id','companyNumber','companyName','companyBranch',
								'capital','address','TEL','CEO','referencenumber')
						->where('id', '=', 1)
						->get();
	  return $query;
	}

	public static function fnGetEmpDetail($request){
		$db = DB::connection('mysql_MB');
		$query = $db->table('emp_mstemployees'.' AS emp')
					->SELECT('emp.*')
					->LEFTJOIN('mstaddress AS ma', 'ma.id' ,'=','emp.Address1')
					->where('Emp_ID', '=', $request->empid)
					->get();
		return $query;
	}

	public static function fnGetAddressMB($address) {
		$db = DB::connection('mysql_MB');
		$query= $db->table('mstaddress')
						->SELECT('*')
						->WHERE('id', '=', $address)
						->limit(1)
						->get();
		return $query;

	}

	public static function getAllDeselDedDtls($request) {

		$db = DB::connection('mysql');
		$selectedEmployees = $db->table('salaryplus_deduction')
								->SELECT('Deduction')
								->WHERE('year','=', $request->year)
								->ORDERBY('Deduction', 'ASC')
				 	 			->GET();
 	 	$hdn_deduction = array();
 		foreach ($selectedEmployees as $k => $v) {
			$hdn_deduction[$k] = $v->Deduction;
		}

		$query = $db->TABLE('mstsalaryplus')
							->SELECT('Name','Salarayid')
							->WHERE('delflg', '=', 0)
							->WHERE('location', '=', 2)
							->where('Salarayid', 'NOT LIKE', '%SD%')
							->whereNotIn('Salarayid', $hdn_deduction);
		$query = $query ->orderBy('Name', 'ASC')
							->get();
		return $query;
	}

	public static function getAllSelDedDtls($request) {

		$db = DB::connection('mysql');
		$selectedEmployees = $db->table('salaryplus_deduction')
					->SELECT('Deduction','mstsalaryplus.Name')
					->LEFTJOIN('mstsalaryplus', 'mstsalaryplus.Salarayid','=','salaryplus_deduction.Deduction')
					->WHERE('year','=', $request->year)
					->ORDERBY('Deduction', 'ASC')
	 	 			->GET();
 	 	return $selectedEmployees;
	}

	public static function insSelDedDtls($request) {

		$db = DB::connection('mysql');
		$deldetails = $db->TABLE('salaryplus_deduction')
						->WHERE('year', '=', $request->year)
						->DELETE();
		$rows = array();
		for ($i = 0;$i < count($request->selected); $i++) {
			$rows[] = array('id' => '',
							'Deduction' => $request->selected[$i],
							'delflg' => 0,
							'year' => $request->year,
							'create_date' => date('Y-m-d H:i:s'),
							'create_by' => Auth::user()->username,
							'update_date' => date('Y-m-d H:i:s'),
							'update_by' => Auth::user()->username);
		}

		DB::TABLE('salaryplus_deduction')->INSERT($rows);
		
		return true;
	}

}