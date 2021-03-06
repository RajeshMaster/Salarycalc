<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Illuminate\Database\Query\Builder;

class SalaryDetails extends Model{

	public static function fnGetAccountPeriod() {
		$db = DB::connection('mysql');
		$query = $db->table('dev_kessandetails')
					->where('delflg','=',0)
					->get();
		return $query;	
	}

	public static function fnGetmnthRecord($from_date, $to_date) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->SELECT('year_mon AS date','year','month')
					->WHERE('year_mon','>=',$from_date,' AND','year_mon','<',$to_date)
					->WHERE('delFlg','=',0)
					->ORDERBY('year_mon', 'ASC')
	 	 			->GET();
	 	return $query;
	}

	public static function fnGetmnthRecordPrevious($from_date) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->SELECT(DB::raw("SUBSTRING(year_mon, 1, 7) AS date"))
					->WHERE('delFlg','=',0)
					->WHERE('year_mon','<=',$from_date)
					->ORDERBY('year_mon', 'ASC')
	 	 			->GET();
	 	return $query;
	}

	public static function fnGetmnthRecordNext($to_date) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->SELECT(DB::raw("SUBSTRING(date, 1, 7) AS date"))
					->WHERE('delFlg','=',0)
					->WHERE('date','>=',$to_date)
					->ORDERBY('date', 'ASC')
	 	 			->GET();
	 	return $query;
	}

	public static function fnGetEmpIdList($request,$year,$month){
		$db = DB::connection('mysql');
		$empIdArr = array($request->empIdArr);
		$query = $db->table('inv_salaryplus_main')
					->select('*');
		if ($empIdArr != array() && $request->searchmethod == 3) {
			$query = $query->whereIn('Emp_ID',$empIdArr)
							->orderBy("year",'DESC')
							->orderBy("month",'DESC')
							->get();
		} else {
			$query = $query->where('year','=', $year)
							->where('month','=', $month)
							->orderBy("Emp_ID",'ASC')
							->get();
		}
		return $query;
	}

	public static function fnGetSalaryCalcList($request,$empId,$year,$month){
		$db = DB::connection('mysql_Invoice');
		$year_mon = $year."-".$month;
		$yearMnth = date("Y-m", strtotime("1 months", strtotime($year_mon)));
		$query = $db->table('acc_cashregister')
					->select('*')
					->where('pageFlg','=', 2)
					->WHERE('Emp_ID','=',$empId)
					->WHERE(DB::raw("SUBSTRING(date, 1, 7)"),'=', $yearMnth)
					->get();
					
		return $query;
	}

	public static function fnSalaryCalcList($year,$month){
		$db = DB::connection('mysql');
		$query = $db->table('inv_salary_main')
					->select('*')
					->where('year','=', $year)
					->where('month','=', $month)
					->orderBy("Transferred",'DESC')
					->get();
		return $query;
	}

	public static function getsalaryDetails($request,$flg) {
		$db = DB::connection('mysql');
		$query = $db->table('mstsalaryplus')
					->select('id','Name','nick_name','location','Salarayid')
					->where('location','=',$flg)
					->where('delflg','=',0)
					->orderBy('Salarayid', 'ASC')
					->get();
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

	public static function fnGetEmpSalHistory($Emp_ID,$year,$month = ''){
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					 ->select('*')
					 ->where('Emp_ID','=', $Emp_ID);
			if ($month !== "") {
				$query = $query ->where('year','=', $year)
								->where('month','=', $month);
			} else {
				$query = $query ->where('date','LIKE', $year.'%');
			}			 
			$query = $query ->orderBy('date')
					 		->get();
		return $query;
	}

	public static function fnGetEmpName($Emp_ID){
		$db = DB::connection('mysql_MB');
		$query = $db->table('emp_mstemployees')
					->select('FirstName','LastName','KanaFirstName','KanaLastName','resign_id','resigndate')
					->where('Emp_ID','=',$Emp_ID)
					->get();
		return $query;
	}

	public static function fnGetmailFlg($Emp_ID){
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->select('mailFlg')
					->where('Emp_ID','=', $Emp_ID)
					->orderBy('id','DESC')
					->limit(1)
					->get();

		if (isset($query[0]->mailFlg)) {
			return $query[0]->mailFlg;
		} else {
			return 0;
		}
	}

	public static function updEmpId($request,$year,$month) {

		$name = Session::get('FirstName').' '.Session::get('LastName');

		for ($i = 0; $i < $request->totVal; $i++) { 

			$id = "salId".$i;
			$empid = "salempId".$i;

			if ($request->$id !=""&& $request->$empid !=""&& $year !=""&& $month != "") {
				$update = DB::table('inv_salaryplus_main')
							->where('id',$request->$id)
							->where('year',$year)
							->where('month',$month)
							->update([
								'Emp_ID' => $request->$empid,
								'empFlg' => 0,
								'UpdatedDateTime' => date('Y-m-d H:i:s'),
								'UpdatedBy' => $name
							]);
			}

		}

		return true;
	}
}