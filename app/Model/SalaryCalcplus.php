<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Illuminate\Database\Query\Builder;

class SalaryCalcplus extends Model{
	
	public static function fnGetdetailsfromemp() {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main_emp')
					->where('delflg','=',0)
					->count();
		return $query;
	}

	public static function fninsertdetailsfromemp($request) {
		
		$name = Session::get('FirstName').' '.Session::get('LastName');
		if (!isset($request->selMonth)) { 
			$month = date("m", strtotime("-1 months", strtotime(date('Y-m-01'))));
		} else{
			$month = $request->selMonth;
		}
		if (!isset($request->selYear)) { 
			$year = date('Y');
		} else{
			$year = $request->selYear;
		}
		$db = DB::connection('mysql_MB');
		$getempdetails = $db->table('emp_mstemployees')
							->select('Emp_ID')
							->where('delFlg','=',0)
							->where('resign_id','=',0)
							->where('Title','=',2)
							->where('Emp_ID', 'NOT LIKE', '%NST%')
							->groupby('Emp_ID')
							->get();

		foreach ($getempdetails as $key => $value) {
			$empid = $value->Emp_ID;
			$insert=DB::table('inv_salaryplus_main_emp')
					->insert(array('id'	=>	'', 
									'Emp_Id'	=>	$empid, 
									'delflg'	=>	'0', 
									'year'	=>	$year,
									'month'=>	$month,
									'create_date'	=>	date('Y-m-d'),
									'create_by'	=>	$name,
									'update_date'	=>	date('Y-m-d'),
									'update_by'	=>	$name));
		}
	}

	public static function getTempDetails($request) {
		if (!isset($request->selMonth)) { 
			$month = date("m", strtotime("-1 months", strtotime(date('Y-m-01'))));
		} else{
			$month = $request->selMonth;
		}
		if (!isset($request->selYear)) { 
			$year = date('Y');
		} else{
			$year = $request->selYear;
		}
		$db = DB::connection('mysql');
		$query=$db->table('inv_salaryplus_main_emp')
					->SELECT('*')
					->where('month','=',$month)
					->where('year','=',$year)
					->where('delFLg','=',0)
					->get();
		$querycount = count($query);
		return $querycount;
	}

	public static function getEmpDetailsId($request) {

		$name = Session::get('FirstName').' '.Session::get('LastName');
		$empid = array();
		if (!isset($request->selMonth)) { 
			$month = date("m", strtotime("-1 months", strtotime(date('Y-m-01'))));
		} else{
			$month = $request->selMonth;
		}
		if (!isset($request->selYear)) { 
			$year = date('Y');
		} else{
			$year = $request->selYear;
		}
		$db = DB::connection('mysql');
		$query=$db->table('inv_salaryplus_main_emp')
					->SELECT('Emp_Id')
					->whereRaw("year = (SELECT year FROM inv_salaryplus_main_emp ORDER BY id DESC LIMIT 1) 
						AND month = (SELECT month FROM inv_salaryplus_main_emp ORDER BY id DESC LIMIT 1)")
					->get();

		foreach ($query as $key => $value) {
			$empid = $value->Emp_Id;
			$insert=DB::table('inv_salaryplus_main_emp')
					->insert(array('id'	=>	'', 
									'Emp_Id'	=>	$empid, 
									'delflg'	=>	'0', 
									'year'	=>	$year,
									'month'=>	$month,
									'create_date'	=>	date('Y-m-d'),
									'create_by'	=>	$name,
									'update_date'	=>	date('Y-m-d'),
									'update_by'	=>	$name));
		}
	}

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

	public static function salaryDetail($request,$lastyear,$lastmonth,$flg,$empid = null){
		$db = DB::connection('mysql');
		$query = $db->TABLE(
					$db->raw("
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year = ".$lastyear." 
							AND invsal.month= ".$lastmonth." 
						WHERE salemp.year = ".$lastyear." 
							AND salemp.month = ".$lastmonth.") as tbl"));

						if ($empid != '') {
							$query = $query->WHERE('Emp_ID','=',$empid);
						}
						$query = $query ->orderBy('Emp_ID','ASC')
			        			->get();
	 	return $query;
	}

	public static function getAllEmpDetails($request,$flg) {
		if(($request->year != "")&&($request->month != "")) {
			$year = $request->year;
			$month = $request->month ;
		} else {
			$previous = date('Y-m', strtotime('first day of last month'));
			$splitPrevious = explode("-", $previous);
			$year=$splitPrevious[0];
			$month=$splitPrevious[1];
		}

		$db = DB::connection('mysql');
		$selectedEmployees = $db->table('inv_salaryplus_main_emp')
				->SELECT('Emp_ID')
				->WHERE('year','=', $year)
				->WHERE('month','=',$month)
				->ORDERBY('Emp_ID', 'ASC')
 	 			->GET();
 	 	$hdn_empid = array();
 		foreach ($selectedEmployees as $k => $v) {
			$hdn_empid[$k] = $v->Emp_ID;
		}

		$db_mb = DB::connection('mysql_MB');
		$employees = $db_mb->TABLE('emp_mstemployees')
							->SELECT('Emp_ID','FirstName','LastName','resign_id','resigndate')
							->WHERE('delFLg', '=', 0)
							// ->WHERE('resign_id', '=', 0)
							->WHERE('Title', '=', 2)
							->where('Emp_ID', 'NOT LIKE', '%NST%');
			if ($flg == 0) {
				$employees = $employees ->whereNotIn('Emp_ID', $hdn_empid);
			} else if ($flg == 1) {
				$employees = $employees ->whereIn('Emp_ID', $hdn_empid);
			}
			$employees = $employees ->orderBy('Emp_ID', 'ASC')
									->get();
		return $employees;
	}

	public static function InsertEmpFlrDetails($request) {
		$db = DB::connection('mysql');
		$deldetails = $db->TABLE('inv_salaryplus_main_emp')->WHERE('year', '=', $request->year)
						->WHERE('month', '=', $request->month)->DELETE();
		$rows = array();
		for ($i=0;$i<count($request->selected);$i++) {
			$rows[] = array('id' => '',
			'Emp_Id' => $request->selected[$i],
			'delflg' => 0,
			'year' => $request->year,
			'month' => $request->month,
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => Auth::user()->username,
			'update_date' => date('Y-m-d H:i:s'),
			'update_by' => Auth::user()->username);
		}
		DB::TABLE('inv_salaryplus_main_emp')->INSERT($rows);
		return true;
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

	public static function getsalaryDetailsnoloc($request) {
		$db = DB::connection('mysql');
		$query = $db->table('mstsalaryplus')
					->select('id','Name','nick_name','location','Salarayid')
					->where('delflg','=',0)
					->orderBy('location', 'ASC')
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

	public static function fnGetDataExistsCheck($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->select('*')
					->where('Emp_ID','=',$request->Emp_ID)
					->where('year','=',$request->selYear)
					->where('month','=',$request->month)
					->get();
		return $query;
	}

	public static function multiadd($request,$salary_det,$salary_ded) {
		$insert = '';
		$name = Session::get('FirstName').' '.Session::get('LastName');
		for ($i=0; $i < $request->count; $i++) {
			$Emp_ID = 'Emp_ID'.$i;
			$transferred = 'transferred_'.$request->$Emp_ID;
			$transferred_new = str_replace(",", "", $request->$transferred);
			$salary_final = '';
			foreach ($salary_det as $key => $value) {
				$detail = 'salary_'.$request->$Emp_ID.'_'.$value->Salarayid;
				$salaryDet = $request->$detail;
				if ($salaryDet != '') {
					$salary_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDet).'##';
				}
			}
			$deduction_final = '';
			foreach ($salary_ded as $key => $value) {
				$detail1 = 'Deduction_'.$request->$Emp_ID.'_'.$value->Salarayid;
				$salaryDed = $request->$detail1;
				if ($salaryDed != '') {
					$deduction_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDed).'##';
				}
			}
			if ($salary_final !="" || $deduction_final != "") {
				$insert=DB::table('inv_salaryplus_main')
					->insert(
						['id' => '',
						'Emp_ID' => $request->$Emp_ID,
						'date' => $request->txt_startdate,
						'Salary' => !empty($salary_final) ? $salary_final : '',
						'Deduction' => !empty($deduction_final) ? $deduction_final : '',
						'Transferred' => !empty($transferred_new) ? $transferred_new : 0,
						'year' => $request->selYear,
						'month' => $request->month,
						'delFlg' => 0,
						'CreatedBy' => $name,
						'UpdatedBy' => $name,
						'CreatedDateTime' => date('Y-m-d H:i:s'),
						'UpdatedDateTime' => date('Y-m-d H:i:s')]);
			}
		}
		return $insert;
	}

	public static function fnsalarycalcadd($request,$salary_det,$salary_ded) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$salary_final = '';
		foreach ($salary_det as $key => $value) {
			$detail = 'salary_'.$value->Salarayid;
			$salaryDet = $request->$detail;
			if ($salaryDet != '') {
				$salary_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDet).'##';
			}
		}
		$deduction_final = '';
		foreach ($salary_ded as $key => $value) {
			$detail1 = 'deduction_'.$value->Salarayid;
			$salaryDed = $request->$detail1;
			if ($salaryDed != '') {
				$deduction_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDed).'##';
			}
		}
		$Travel = str_replace(",", "", $request->Travel);
		$salamt = str_replace(",", "", $request->salamt);
		if ($salary_final !="" || $deduction_final != "" || $Travel != "" || $salamt != "") {
			$insert=DB::table('inv_salaryplus_main')
				->insert(
					['id' => '',
					'Emp_ID' => $request->Emp_ID,
					'date' => $request->date,
					'Salary' => !empty($salary_final) ? $salary_final : '',
					'Deduction' => !empty($deduction_final) ? $deduction_final : '',
					'Travel' => !empty($Travel) ? $Travel : '',
					'salamt' => !empty($salamt) ? $salamt : '',
					'year' => $request->selYear,
					'month' => $request->month,
					'year_mon' => $request->selYear.'-'.$request->month.'-10',
					'remarks' => $request->remarks,
					'delFlg' => 0,
					'CreatedDateTime' => date('Y-m-d H:i:s'),
					'UpdatedDateTime' => date('Y-m-d H:i:s'),
					'CreatedBy' => $name,
					'UpdatedBy' => $name]
			);
		}
		return $insert;
	}

	public static function fnsalarycalcupd($request,$salary_det,$salary_ded) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$salary_final = '';
		foreach ($salary_det as $key => $value) {
			$detail = 'salary_'.$value->Salarayid;
			$salaryDet = $request->$detail;
			if ($salaryDet != '') {
				$salary_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDet).'##';
			}
		}
		$deduction_final = '';
		foreach ($salary_ded as $key => $value) {
			$detail1 = 'deduction_'.$value->Salarayid;
			$salaryDed = $request->$detail1;
			if ($salaryDed != '') {
				$deduction_final .= $value->Salarayid.'$'.str_replace(",", "", $salaryDed).'##';
			}
		}
		$Travel = str_replace(",", "", $request->Travel);
		$salamt = str_replace(",", "", $request->salamt);
		$update=DB::table('inv_salaryplus_main')
			->where('id',$request->id)
			->update(
				['date' => $request->date,
				'Salary' => !empty($salary_final) ? $salary_final : '',
				'Deduction' => !empty($deduction_final) ? $deduction_final : '',
				'Travel' => !empty($Travel) ? $Travel : '',
				'salamt' => !empty($salamt) ? $salamt : '',
				'remarks' => $request->remarks,
				'year' => $request->selYear,
				'month' => $request->month,
				'year_mon' => $request->selYear.'-'.$request->month.'-10',
				'mailFlg' => '0',
				'UpdatedDateTime' => date('Y-m-d H:i:s'),
				'UpdatedBy' => $name]
		);
		return $update;
	}

	public static function fngetid() {
		$Details = DB::TABLE('inv_salaryplus_main')
						->max('id');
		return $Details;
	}

	public static function salarycalcview($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->SELECT('*')
					->WHERE('id', '=', $request->id)
					->WHERE('Emp_ID', '=', $request->Emp_ID)
					->WHERE('year', '=', $request->selYear)
					->WHERE('month', '=', $request->selMonth)
					->get();
	 	return $query;
	}

	public static function salarycalcplusview_tot($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					->SELECT('*')
					->WHERE('Emp_ID', '=', $request->Emp_ID)
					->WHERE('year', '=', $request->selYear)
					->WHERE('month', '=', $request->selMonth)
					->get();
	 	return $query;
	}

	public static function salaryDetailhistory($request, $flg) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					 ->select('*')
					 ->where('Emp_ID','=', $request->Emp_ID)
					 ->where('date','LIKE', $request->selYear.'%')
					 ->orderBy('year','DESC')
					 ->orderBy('month','DESC');

					if ($flg == 0) {
						$query = $query->paginate($request->plimit);
			        } else {
			        	$query = $query->get();
			        }
		return $query;
	}

	public static function getbasichraDetails($empid,$yearmonth) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_basic_salary as basic')
					->select('basic.*',DB::raw('(basic.basic_amount + basic.increment_amount) as tot_basicAmount'))
					->where('basic.activeFlg','=', 0)
					->where('basic.Emp_ID','=', $empid)
					->WHERERAW("SUBSTRING(basic.year_month_from,1,7) <='$yearmonth'")
					->WHERERAW("SUBSTRING(basic.year_month_to,1,7) >='$yearmonth'")
    				->get();
		return $query;
	}

	public static function salaryDetail_Empid($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main')
					 ->select('*')
					 ->where('Emp_ID','=', $request->Emp_ID)
					 ->orderBy('year','DESC')
					 ->orderBy('month','DESC')
    				 ->get();
		return $query;
	}

	// vengad 06/07/2020
    public static function fnGetCompanyDetails($request){
      
      $db = DB::connection('mysql');
      $query = $db->table('company_details')
          ->select('id',
                    'companyNumber',
                    'companyName',
                    'companyBranch',
                    'capital',
                    'address',
                    'TEL',
                    'CEO',
                    'referencenumber')
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

	public static function inv_salary_main_transferedamt($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_salary_main')
					->SELECT('Transferred')
					->WHERE('Emp_ID', '=', $request->Emp_ID)
					->WHERE('year', '=', $request->selYear)
					->WHERE('month', '=', $request->selMonth)
					->get();
	 	return $query;
	}

	public static function getYears($request) {

		$db = DB::connection('mysql');
		$years = $db->table('inv_salaryplus_main')
							->select(DB::raw('YEAR(date) as years'))
							->where('Emp_ID','=', $request->Emp_ID)
							->groupBy(DB::raw('YEAR(date)'))
							->get();
	 	return $years;
	}

	// Start Madasamy 31/07/2020
	public static function getYearsTotalHistory($request) {
		$db = DB::connection('mysql');
		$years = $db->table('inv_salaryplus_main_emp')
					->select(DB::raw('year as years'))
					->groupBy("year")
					->get();
	 	return $years;
	}

	public static function fnGetEmpId($request){
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main_emp')
					->select('Emp_ID')
					->where('year','LIKE', $request->selYear.'%')
					->groupby("Emp_ID")
					->orderBy("Emp_ID")
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

	public static function fnGetEmpIdList($year,$month){
		$db = DB::connection('mysql');
		$query = $db->table('inv_salaryplus_main_emp')
					->select('Emp_ID')
					->where('year','=', $year)
					->where('month','=', $month)
					->orderBy("Emp_ID")
					->get();
		return $query;
	}
	
	// End Madasamy 31/07/2020

	public static function fnGetInsuranceTotal($request){
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
					->where([['expenses.Date', 'LIKE', $selYear.'%'],
								['expenses.main_sub', '=', 7 ],
								['expenses.su_sub', '=', 17 ]
							]);
		$query = $query	->groupBy('expenses.Emp_ID')
						->get();
		return $query;
	}
}