<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\SalaryDetails;
use App\Http\Common;
use Session;
use Carbon;
use Redirect;
use DateTime;
use Input;
use Auth;
use View;

Class SalaryDetailsController extends Controller {
	
	public function index(Request $request) {
		if(Session::get('selYear') !="") {
			$request->selYear =  Session::get('selYear');
			$request->selMonth =  Session::get('selMonth');
		}
		if ($request->tblchg == "") {
			$request->tblchg = 0;
		}
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		
		$year_month = array();
		$db_year_month = array();
		$dbrecord = array();
		$dbnext = array();
		$dbprevious = array();
		$account_val ="";
		$displayArray = array();
		$get_det = array();
		$g_query_tot = array();

		if (!isset($request->selMonth)) { 
			$date_month = date('Y-m', strtotime("last month"));
			$current = date('Y-m');
		} else { 
			if ($request->get_prev_yr == 1) {
				$prev_month_ts = strtotime($request->selYear.'-'. substr("0" . $request->selMonth , -2).' -1 month');
				$date_month = date('Y-m', $prev_month_ts);
				$current = date('Y-m',strtotime($request->selYear.'-'. substr("0" . $request->selMonth , -2)));
			} else {
				$date_month = $request->selYear . "-" . substr("0" . $request->selMonth , -2);
				$current = date('Y-m',strtotime($request->selYear.'-'. substr("0" . $request->selMonth , -2).'1 month'));
			}
		}
		$last=date('Y-m', strtotime('last month'));
		$last1 = date($date_month , strtotime($last . " last month"));
		$lastdate = explode('-',$last1);
		$lastyear = $lastdate[0];
		$lastmonth = $lastdate[1];
		
		$currentdate = explode('-',$current);
		$currentyear = $currentdate[0];
		$currentmonth = $currentdate[1];
		$request->selMonth = $lastmonth;
		$request->selYear = $lastyear;
		$g_accountperiod = SalaryDetails::fnGetAccountPeriod();
		$account_close_yr = $g_accountperiod[0]->Closingyear;
		$account_close_mn = $g_accountperiod[0]->Closingmonth;
		$account_period = intval($g_accountperiod[0]->Accountperiod);

		$splityear = explode('-', $request->previou_next_year); 
		if ($request->previou_next_year != "") { 
			if (intval($splityear[1]) > $account_close_mn) {
				$last_year = intval($splityear[0]);
				$current_year = intval($splityear[0]) + 1;
			} else {
				$last_year = intval($splityear[0]) - 1;
				$current_year = intval($splityear[0]);
			}
		} else if ($request->selYear) {
			if ($request->selMonth >= $account_close_mn) {
				$current_year = intval($request->selYear) + 1;
				$last_year = intval($request->selYear);
			} else {
				$current_year = intval($request->selYear);
				$last_year = intval($request->selYear) - 1;
			}
		} else {
			if (date('m') > $account_close_mn) {
				$current_year = date('Y')+1;
				$last_year = date('Y');
			} else {
				$current_year = date('Y');
				$last_year = date('Y') - 1;
			}
		}
		if ($account_close_mn == 12) {
			for ($i = 1; $i <= 12; $i++) {
				$year_month[$current_year][$i] = $i;
			}
		} else {
			for ($i = ($account_close_mn + 1); $i <= 12; $i++) {
				$year_month[$last_year][$i] = $i;
			}
			for ($i = 1; $i <= $account_close_mn; $i++) {
				$year_month[$current_year][$i] = $i;
			}
		}
		$year_month_day = $current_year . "-" . $account_close_mn . "-01";
		$maxday = Common::fnGetMaximumDateofMonth($year_month_day);
		$from_date = $last_year . "-" . substr("0" . $account_close_mn, -2). "-01"/* . substr("0" . $maxday, -2)*/;
		$to_date = $current_year . "-" . substr("0" . ($account_close_mn + 1), -2) . "-01";
		
		$exp_query = SalaryDetails::fnGetmnthRecord($from_date, $to_date);
		foreach ($exp_query as $key => $res1) {
			$concat = $res1->year.'-'.$res1->month;
			//array_push($dbrecord, $res1['start_date']);
			array_push($dbrecord, $concat);
		}

		$lastMonthAsLink = date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01'))));
			array_push($dbrecord, $lastMonthAsLink);
		$exp_query1 = SalaryDetails::fnGetmnthRecordPrevious($from_date);
		foreach ($exp_query1 as $key => $res2) {
			array_push($dbprevious, $res2->date);
		}
		$dbprevious = array_unique($dbprevious);

		$exp_query2 = SalaryDetails::fnGetmnthRecordNext($to_date);
		foreach ($exp_query2 as $key => $res3) {
			array_push($dbnext, $res3->date);
		}
		//START PREVIOUS AND FUTURE MONTH LINK WITHOUT DATA IN THE DB
		$fu_date = date('Y')."-0".(date('m')+1);
		$pre_date = date('Y')."-0".(date('m')-1);
		$cur_date = date('Y')."-0".(date('m'));
		if (!in_array($pre_date, $dbrecord)) {
			array_push($dbrecord, $pre_date);
		}
		if (!in_array($cur_date, $dbrecord)) {
			array_push($dbrecord, $cur_date);
		}
		if (!in_array($fu_date, $dbrecord)) {
			array_push($dbrecord, $fu_date);
		}
		$dbrecord = array_unique($dbrecord);
		foreach ($dbrecord AS $dbrecordkey => $dbrecordvalue) {
			$split_val = explode("-",$dbrecordvalue);
			$db_year_month[$split_val[0]][intval($split_val[1])] = intval($split_val[1]);
		}
		
		$split_date = explode('-', $date_month);

		$account_val = Common::getAccountPeriod($year_month, $account_close_yr, $account_close_mn, $account_period);
		$empArrVal = SalaryDetails::fnGetEmpIdList($request,$lastyear,$lastmonth);

		if ($request->get_prev_yr != 1) {
			$prev_month_ts = strtotime($date_month.' +1 month');
			$date_month = date('Y-m', $prev_month_ts);
		} else {
			$prev_month_ts = strtotime($date_month.' +1 month');
			$date_month = date('Y-m', $prev_month_ts);
		}

		$empArr = array();
		$salary_det = SalaryDetails::getsalaryDetailsnodelflg($request,'1');
		$salary_ded = SalaryDetails::getsalaryDetailsnodelflg($request,'2');
		$i = 0;
		foreach ($empArrVal as $key => $value) {

			// SalaryPlus Salary Details
			$arr1 = array();
			$arr2 = array();
			$salArr = array();
			$salary = "";
			if ($value->Salary != "") {
				$salaryVal = explode('##', mb_substr($value->Salary, 0, -2));
				foreach ($salaryVal as $salKey => $salVal) {
					$salFinal = explode('$', $salVal);
					$arr1[$key] = $salFinal[0];
					$arr2[$salFinal[0]] = $salFinal[1];
				}
			}
			foreach ($salary_det as $key1 => $det) {
				$salArr[$det->Salarayid] = $det->Salarayid;
			}
			$salresult_a = array_intersect($salArr,$arr1);
			$salresult_b = array_diff($salArr,$arr1);
			$salresult = array_merge($salresult_a,$salresult_b);
			ksort($salresult);
			if(count($salary_det) != "" && is_array($salresult)) {
				$x = 0;
				foreach ($salresult as $key2 => $value2) {
					if ($key2 != '') {
						if($key2 == isset($arr2[$key2])) {
							$salary += $arr2[$key2];
						} 
					} 
					$x++;
				}
			}
			

			// SalaryPlus Deduction Details
			$arr3 = array();
			$arr4 = array();
			$dedArr = array();
			$deduction = "";
			if ($value->Deduction != "") {
				$deductionVal = explode('##', mb_substr($value->Deduction, 0, -2));
				foreach ($deductionVal as $dedKey => $dedVal) {
					$dedFinal = explode('$', $dedVal);
					$arr3[$dedKey] = $dedFinal[0];
					$arr4[$dedFinal[0]] = $dedFinal[1];
				}
			}
			foreach ($salary_ded as $key3 => $value3) {
				$ded_arr[$value3->Salarayid] = $value3->Salarayid;
			}
			$dedresult_a = array_intersect($ded_arr,$arr3);
			$dedresult_b = array_diff($ded_arr,$arr3);
			$dedresult = array_merge($dedresult_a,$dedresult_b);
			ksort($dedresult);
			if(count($salary_ded)!="") {
				$y = 0;
				foreach ($dedresult as $key4 => $value4) {
					if ($key4 != '') {
						if($key4 == isset($arr4[$key4])) {
							$deduction += $arr4[$key4];
						}
					}
					$y++;
				}
			}
			
			$empArr[$i]['Amt'] = array_push($empArr,array($salary + $deduction + $value->Travel));
			$empArr[$i][$value->id]['Salary'] = $salary;
			$empArr[$i][$value->id]['Deduction'] = $deduction;
			$empArr[$i][$value->id]['TotalAmt'] = $salary + $deduction + $value->Travel;
			$empArr[$i]['id'] = $value->id;
			$empArr[$i]['date'] = $value->date;
			$empArr[$i]['Emp_ID'] = $value->Emp_ID;
			$empArr[$i]['yearmonth'] = $value->year."-".$value->month;
			$salaryCalcArrVal = SalaryDetails::fnGetSalaryCalcList($request,$value->Emp_ID,$value->year,$value->month);
			if (isset($salaryCalcArrVal[0])) {
				$empArr[$i]['paidAmount'] = $salaryCalcArrVal[0]->amount;
			}
			$i++;
		}
		// rsort($empArr);

		// For Year Bar Logic
		$db_year_month_new = array();
		foreach ($db_year_month as $key_yr => $value_mn) {
			foreach ($value_mn as $key_sub => $value_sub) {
				if ($value_sub == 12) {
					$db_year_month_new[$key_yr+1]['1'] = 1;
				} else if ($value_sub != 0) {
					$db_year_month_new[$key_yr][$key_sub+1] = $value_sub + 1;
				}
			}
		}
		$db_year_month = $db_year_month_new;
		
		return view('SalaryDetails.index',[	'request' => $request,
											'empArrVal'=>$empArrVal,
											'empArr'=>$empArr,
											'account_val'=>$account_val,
											'account_period'=> $account_period,
											'year_month'=> $year_month,
											'db_year_month'=> $db_year_month,
											'date_month'=> $date_month,
											'dbnext'=> $dbnext,
											'dbprevious'=> $dbprevious,
											'last_year'=> $last_year,
											'current_year'=> $current_year
										]);
	}

}