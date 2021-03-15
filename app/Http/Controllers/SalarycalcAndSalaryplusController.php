<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\SalarycalcAndSalaryplus;
use App\Http\Common;
use Session;
use Carbon;
use Redirect;
use DateTime;
use Input;
use Auth;
use View;

Class SalarycalcAndSalaryplusController extends Controller {
	
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
		} else { 
			if ($request->get_prev_yr == 1) {
				$prev_month_ts = strtotime($request->selYear.'-'. substr("0" . $request->selMonth , -2).' -1 month');
				$date_month = date('Y-m', $prev_month_ts);
			} else {
				$date_month = $request->selYear . "-" . substr("0" . $request->selMonth , -2);
			}
		}
		$last=date('Y-m', strtotime('last month'));
		$last1 = date($date_month , strtotime($last . " last month"));
		$lastdate = explode('-',$last1);
		$lastyear =$lastdate[0];
		$lastmonth =$lastdate[1];
		$request->selMonth = $lastmonth;
		$request->selYear = $lastyear;
		$g_accountperiod = SalarycalcAndSalaryplus::fnGetAccountPeriod();
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
			if (date('m') > $account_close_mn) {
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
		
		$exp_query = SalarycalcAndSalaryplus::fnGetmnthRecord($from_date, $to_date);
		foreach ($exp_query as $key => $res1) {
			$concat = $res1->year.'-'.$res1->month;
			//array_push($dbrecord, $res1['start_date']);
			array_push($dbrecord, $concat);
		}

		$lastMonthAsLink = date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01'))));
			array_push($dbrecord, $lastMonthAsLink);
		$exp_query1 = SalarycalcAndSalaryplus::fnGetmnthRecordPrevious($from_date);
		foreach ($exp_query1 as $key => $res2) {
			array_push($dbprevious, $res2->date);
		}
		$dbprevious = array_unique($dbprevious);

		$exp_query2 = SalarycalcAndSalaryplus::fnGetmnthRecordNext($to_date);
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
		$empArrVal = SalarycalcAndSalaryplus::fnGetEmpIdList($lastyear,$lastmonth);
		$salaryCalcArrVal = SalarycalcAndSalaryplus::fnGetSalaryCalcList($lastyear,$lastmonth);

		if ($request->get_prev_yr != 1) {
			$prev_month_ts = strtotime($date_month.' +1 month');
			$date_month = date('Y-m', $prev_month_ts);
		} else {
			$prev_month_ts = strtotime($date_month.' +1 month');
			$date_month = date('Y-m', $prev_month_ts);
		}

		$empArr = array();
		foreach ($empArrVal as $key => $value) {
			$empArr[] = $value->Emp_ID;
		}

		$salaryCalcempArr = array();
		foreach ($salaryCalcArrVal as $key => $salvalue) {
			$salaryCalcempArr[] = $salvalue->Emp_ID;
		}

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
		
		return view('SalarycalcAndSalaryplus.index',['request' => $request,
											'empArrVal'=>$empArrVal,
											'salaryCalcArrVal'=>$salaryCalcArrVal,
											'account_val'=>$account_val,
											'account_period'=> $account_period,
											'year_month'=> $year_month,
											'db_year_month'=> $db_year_month,
											'date_month'=> $date_month,
											'dbnext'=> $dbnext,
											'dbprevious'=> $dbprevious,
											'last_year'=> $last_year,
											'current_year'=> $current_year]);
	}

}