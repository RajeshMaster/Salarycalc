<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Model\Totalexp;
use App\Model\Staff;
use App\Http\Common;
use Session;
use Carbon;
use Config;
use DB;
use Redirect;
use DateTime;
use Auth;
ini_set('max_execution_time', 0);
/*use Mail;
use View;
use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Cell;
use PHPExcel_Style_Conditional;
use PHPExcel_Style_Color;*/


Class TotalexpController extends Controller {

	public function index(Request $request) {
		
		if (!isset($request->expsort)) {
		$request->expsort = "Emp_ID";
		} 
		if (!isset($request->sortOrder)) {
		  $request->sortOrder = "asc";
		}
		if ($request->sortOrder == "asc") {
		  $request->sortstyle="sort_asc";
		} else {
		  $request->sortstyle="sort_desc";
		}
		$sortarray = [$request->expsort=>$request->expsort,'Emp_ID'=>trans('messages.lbl_empid'),'Date'=>trans('messages.lbl_date')];
		if(Session::get('Travelexpselmon') !=""){
		$request->selMonth = Session::get('Travelexpselmon');
		$request->selYear = Session::get('Travelexpselyr');
		}

		$empdetails=array();
      	$date = Totalexp::fnGetLocalTravelCalenderBar();

      	$total_yrs = array(); 
	       if ($date[0] != "") {
	        $prev_yrs = $date[0];
	        $total_yrs1 = array_unique($date[1]);
	        asort($total_yrs1);
	        foreach ($total_yrs1 AS $key => $value) {
	          array_push($total_yrs, $value);
	        }
	      } else {
	        $prYrMn =explode('-', date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01')))));
	        $prev_yrs=$prYrMn;
	        array_push($total_yrs, $prYrMn[0]);
	      }
	      $cur_year=date('Y');
	      $cur_month=date('m')-1;
	      $curtime = date('YmdHis');
	      if ($cur_month == 0) {
	        $cur_year = $cur_year - 1;
	        $cur_month = 12;
	      }
	      if (isset($request->selMonth) && !empty($request->selMonth)) {
	        $selectedMonth=$request->selMonth;
	        $selectedYear=$request->selYear;
	        $cur_month=$selectedMonth;
	        $cur_year=$selectedYear;
	      } else {
	        $selectedMonth=$cur_month;
	        $selectedYear=$cur_year;
	      }
	      $pass_date = $selectedYear . "-" . substr("0" . $selectedMonth, -2);
	      $fetchloctraveltot = Totalexp::fetchloctraveltot($pass_date);
	      $fetchexptot = Totalexp::fetchexptot($pass_date);
	      $employees = Totalexp::index($request,$pass_date);

	      if($request->totcount == '1' || !isset($request->totcount)) {
	        $totexpcount = count($employees); 
	        $request->totexpcount = $totexpcount;
	      } else {
	        $totexpcount = $request->totexpcount;
	      }
	      $i = 0;

      	  $salaryTrvTotal = "";
		  $salaryExpTotal = "";
	      foreach($employees as $key=>$emp) {
	          $empdetails[$i]['revert'] = 0;
	          $empdetails[$i]['submit'] = 0;
	          $empdetails[$i]['submitloc'] = 0;
	          $empdetails[$i]['submitex'] = 0;
	          $empdetails[$i]['paid'] = 0;
	          $empdetails[$i]['confirm'] = 0;
	          $empdetails[$i]['confirmloc'] = 0;
	          $empdetails[$i]['confirmex'] = 0;
	          $empdetails[$i]['Emp_ID'] = $emp->Emp_ID;
	          $empdetails[$i]['FirstName'] = $emp->FirstName;
	          $empdetails[$i]['LastName'] = $emp->LastName;
	          $loctravel = Totalexp::fetchloctravel($emp->Emp_ID,$pass_date);
	          foreach($loctravel as $key=>$emploc) {
	            $empdetails[$i]['locid'] = $emploc->id;
	            $empdetails[$i]['grandtotalloc'] = $emploc->grandtotal;
	            $empdetails[$i]['paid_dateloc'] = $emploc->paid_date;
	            $empdetails[$i]['confirmFlgloc'] = $emploc->confirmFlg;
	            $empdetails[$i]['revertFlg'] = $emploc->revertFlg;
	            $empdetails[$i]['created_timeloc'] = $emploc->created_time;
	            $empdetails[$i]['dofsubmissionloc'] = $emploc->dofsubmission;
	          }
	          $loctravel = Totalexp::fetchexpense($emp->Emp_ID,$pass_date);
	          foreach($loctravel as $key=>$empexp) {
	            $empdetails[$i]['exid'] = $empexp->id;
	            $empdetails[$i]['grandtotalex'] = $empexp->grandtotal;
	            $empdetails[$i]['paid_dateex'] = $empexp->Paid_Date;
	            $empdetails[$i]['confirmFlgex'] = $empexp->confirmFlg;
	            $empdetails[$i]['revertFlg'] = $empexp->revertFlg;
	            $empdetails[$i]['created_timeex'] = $empexp->Ins_DT;
	            $empdetails[$i]['dofsubmissionex'] = $empexp->Dof_Submission;
	          }

	          // Fetch data from SalaryCalc Registration - Madasamy 07/09 
	          $salaryRegData = Totalexp::fetchSalaryRegData($emp->Emp_ID,$selectedYear,$selectedMonth);
	          if (isset($salaryRegData[0])) {
		          $salaryTrvTotal = Totalexp::fetchTrainDailyTotal($selectedYear,$selectedMonth);
		          $salaryExpTotal = Totalexp::fetchExpensesTotal($selectedYear,$selectedMonth);
				  foreach($salaryRegData as $key=>$salaryData) {
		            $empdetails[$i]['sal_train_daily'] = $salaryData->train_daily;
		            $empdetails[$i]['sal_others'] = $salaryData->others;
		          }
	          } else {
	          		$empdetails[$i]['sal_train_daily'] = 0;
		            $empdetails[$i]['sal_others'] = 0;
	          }

	          if(isset($empdetails[$i]['dofsubmissionloc']) 
	              && !isset($empdetails[$i]['dofsubmissionex'])) {
	              if($empdetails[$i]['dofsubmissionloc'] != "" 
	                && $empdetails[$i]['dofsubmissionloc'] != "0000-00-00") {
	                  $empdetails[$i]['submit'] = 1;
	                  $empdetails[$i]['submitloc'] = 1;
	                  if($empdetails[$i]['confirmFlgloc'] == "1") {
	                      $empdetails[$i]['confirm'] = 1;
	                  }
	              } else {
	                  $empdetails[$i]['submit'] = 0;
	              } 
	              if( ($empdetails[$i]['dofsubmissionloc'] != "" 
	                && $empdetails[$i]['dofsubmissionloc'] != "0000-00-00")
	                && ($empdetails[$i]['paid_dateloc'] == ""
	                  || $empdetails[$i]['paid_dateloc'] == "0000-00-00"
	                  ) ) {
	                $empdetails[$i]['revert'] = 1;
	              } else {
	                $empdetails[$i]['revert'] = 0;
	              }
	          } else if(isset($empdetails[$i]['dofsubmissionex']) && !isset($empdetails[$i]['dofsubmissionloc'])) {
	              if($empdetails[$i]['dofsubmissionex'] != "" 
	                  && $empdetails[$i]['dofsubmissionex'] != "0000-00-00") {
	                  $empdetails[$i]['submit'] = 1;
	                  $empdetails[$i]['submitex'] = 1;
	                  if($empdetails[$i]['confirmFlgex'] == "1") {
	                      $empdetails[$i]['confirm'] = 1;
	                  }
	              } else {
	                  $empdetails[$i]['submit'] = 0;
	              } 
	              if( ($empdetails[$i]['dofsubmissionex'] != "" 
	                && $empdetails[$i]['dofsubmissionex'] != "0000-00-00")
	                && ($empdetails[$i]['paid_dateex'] == ""
	                  || $empdetails[$i]['paid_dateex'] == "0000-00-00"
	                  ) ) {
	                $empdetails[$i]['revert'] = 1;
	              } else {
	                $empdetails[$i]['revert'] = 0;
	              }
	          } else if(isset($empdetails[$i]['dofsubmissionex']) && isset($empdetails[$i]['dofsubmissionloc'])) {
	              if($empdetails[$i]['dofsubmissionloc'] != "" 
	                && $empdetails[$i]['dofsubmissionloc'] != "0000-00-00"){
	                  $empdetails[$i]['submitloc'] = 1;
	              }
	              if($empdetails[$i]['dofsubmissionex'] != "" 
	                && $empdetails[$i]['dofsubmissionex'] != "0000-00-00"){
	                  $empdetails[$i]['submitex'] = 1;
	              } 
	              if(($empdetails[$i]['dofsubmissionloc'] != "" 
	                && $empdetails[$i]['dofsubmissionloc'] != "0000-00-00") || 
	                $empdetails[$i]['dofsubmissionex'] != "" 
	                && $empdetails[$i]['dofsubmissionex'] != "0000-00-00") {
	                  $empdetails[$i]['submit'] = 1;
	                  if($empdetails[$i]['confirmFlgloc'] == "1" || $empdetails[$i]['confirmFlgex'] == "1") {
	                      $empdetails[$i]['confirm'] = 1;
	                  }
	              } else {
	                  $empdetails[$i]['submit'] = 0;
	              } 
	              if((($empdetails[$i]['dofsubmissionloc'] != "" 
	                && $empdetails[$i]['dofsubmissionloc'] != "0000-00-00")
	                && ($empdetails[$i]['paid_dateloc'] == ""
	                  || $empdetails[$i]['paid_dateloc'] == "0000-00-00"
	                  ))
	                || (($empdetails[$i]['dofsubmissionex'] != "" 
	                && $empdetails[$i]['dofsubmissionex'] != "0000-00-00")
	                && ($empdetails[$i]['paid_dateex'] == ""
	                  || $empdetails[$i]['paid_dateex'] == "0000-00-00"
	                  ))
	                ) {
	                $empdetails[$i]['revert'] = 1;
	              } else {
	                $empdetails[$i]['revert'] = 0;
	              }
	          }
	          if(isset($empdetails[$i]['paid_dateloc']) && !isset($empdetails[$i]['paid_dateex'])) {
	            if($empdetails[$i]['paid_dateloc'] != "" 
	              && $empdetails[$i]['paid_dateloc'] != "0000-00-00") {
	                $empdetails[$i]['paid'] = 1;
	            } else {
	                $empdetails[$i]['paid'] = 0;
	            } 
	          } else if(isset($empdetails[$i]['paid_dateex']) && !isset($empdetails[$i]['paid_dateloc'])) {
	            if($empdetails[$i]['paid_dateex'] != "" 
	              && $empdetails[$i]['paid_dateex'] != "0000-00-00") {
	                $empdetails[$i]['paid'] = 1;
	            } else {
	                $empdetails[$i]['paid'] = 0;
	            } 
	          } else if(isset($empdetails[$i]['paid_dateloc']) && isset($empdetails[$i]['paid_dateex'])) {
	            if(($empdetails[$i]['paid_dateloc'] != "" 
	              && $empdetails[$i]['paid_dateloc'] != "0000-00-00") || 
	              $empdetails[$i]['paid_dateex'] != "" 
	              && $empdetails[$i]['paid_dateex'] != "0000-00-00") {
	                $empdetails[$i]['paid'] = 1;
	            } else {
	                $empdetails[$i]['paid'] = 0;
	            } 
	          }
	          if(isset($empdetails[$i]['confirmFlgloc']) && !isset($empdetails[$i]['confirmFlgex'])) {
	            if($empdetails[$i]['confirmFlgloc'] == "1") {
	                $empdetails[$i]['confirmloc'] = 1;
	            } else {
	                $empdetails[$i]['confirm'] = 0;
	            } 
	          } else if(isset($empdetails[$i]['confirmFlgex']) && !isset($empdetails[$i]['confirmFlgloc'])) {
	            if($empdetails[$i]['confirmFlgex'] == "1") {
	                $empdetails[$i]['confirmex'] = 1;
	            } else {
	                $empdetails[$i]['confirm'] = 0;
	            } 
	          } else if(isset($empdetails[$i]['confirmFlgloc']) && isset($empdetails[$i]['confirmFlgex'])) {
	            if($empdetails[$i]['confirmFlgloc'] == "1") {
	                $empdetails[$i]['confirmloc'] = 1;
	            }
	            if($empdetails[$i]['confirmFlgex'] == "1") {
	                $empdetails[$i]['confirmex'] = 1;
	            }
	            if($empdetails[$i]['confirmFlgloc'] == "1" || 
	                $empdetails[$i]['confirmFlgex'] == "1") {
	            } else {
	                $empdetails[$i]['confirm'] = 0;
	            } 
	          }
	        $i++;
	      }
	      if ($request->expsort != "Emp_ID") {
	        $sortEmployeeArry = array();
	        foreach ($empdetails as $key => $row) {
	            if(isset($row['created_timeex'])){
	            $sortEmployeeArry[$key] = $row['created_timeex'];
	            } else {
	              $changetoyrmn =date("Y-m-d", strtotime($row['created_timeloc']));
	              $sortEmployeeArry[$key] = $changetoyrmn;
	            }
	        }
	        if (!empty($sortEmployeeArry)) {
	          if ($request->sortstyle == 'sort_asc') {
	            array_multisort($sortEmployeeArry, SORT_ASC, $empdetails);
	          } else {
	            array_multisort($sortEmployeeArry, SORT_DESC, $empdetails);
	          }
	        }
	      }

		return view('totalexp.index',['request' => $request,
                                      'prev_yrs' => $prev_yrs,
                                      'cur_year' => $cur_year,
                                      'cur_month' => $cur_month,
                                      'total_yrs' => $total_yrs,
                                      'curtime' => $curtime,
                                      'sortarray' => $sortarray,
                                      'employees' => $employees,
                                      'totexpcount' => $totexpcount,
                                      'fetchexptot' => $fetchexptot,
                                      'salaryTrvTotal' => $salaryTrvTotal,
                                      'salaryExpTotal' => $salaryExpTotal,
                                      'pass_date' => $pass_date,
                                      'fetchloctraveltot' => $fetchloctraveltot,
                                      'empdetails' => $empdetails]);
	}


	function history(Request $request) {
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		$salary_det=SalaryCalc::getsalaryDetailsnodelflg($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetailsnodelflg($request,'2');
		$g_query=SalaryCalc::salaryDetailhistory($request);
		$k = 0;
		$get_det = array();
		foreach ($g_query as $key => $value) {
			$get_det[$k]['Emp_ID'] = $value->Emp_ID;
			$get_det[$k]['FirstName'] = $value->FirstName;
			$get_det[$k]['LastName'] = $value->LastName;
			$get_det[$k]['EmpName'] = ucwords(strtolower($value->LastName))
				. ".".ucwords(mb_substr($value->FirstName, 0, 1, 'utf-8'));
			$get_det[$k]['Salary'] = $value->Salary;
			$get_det[$k]['Deduction'] = $value->Deduction;
			$get_det[$k]['Transferred'] = $value->Transferred;
			$get_det[$k]['mailFlg'] = $value->mailFlg;
			$get_det[$k]['year'] = $value->year;
			$get_det[$k]['month'] = $value->month;
			$k++;
		}
		return view('salarycalc.history',['salary_det' => $salary_det,
												'salary_ded' => $salary_ded,
												'get_det' => $get_det,
												'g_query' => $g_query,
												'request' => $request]);
	}

	function salarypopup(Request $request) {
		$employeeUnselect = SalaryCalc::getAllEmpDetails($request);
		$employeeSelect = SalaryCalc::getAllFilteredEmpDetails($request);
		return view('salarycalc.salarypopup',['employeeUnselect' => $employeeUnselect,
												'employeeSelect' => $employeeSelect,
												'request' => $request]);
	}

	function empselectprocess(Request $request) {
		$insert=SalaryCalc::InsertEmpFlrDetails($request);
		if($insert){
			Session::flash('success', 'Employees Selected Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		}else {
			Session::flash('type', 'Employees Selected Unsucessfully!!'); 
			Session::flash('type', 'alert-danger'); 
		}
		Session::flash('selMonth', $request->month); 
		Session::flash('selYear', $request->year); 
		$request->selected = "";
		$request->removed = "";
		return Redirect::to('salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function view(Request $request) {
		if(Session::get('Emp_ID') !="" && Session::get('id') !="") {
			$request->id =  Session::get('id');
			$request->Emp_ID =  Session::get('Emp_ID');
			$request->firstname =  Session::get('firstname');
			$request->lastname =  Session::get('lastname');
			$request->editcheck =  Session::get('editcheck');
			$request->selYear =  Session::get('selYear');
			$request->selMonth =  Session::get('selMonth');
		}
		if (!isset($request->Emp_ID)) {
			return Redirect::to('salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
		$detedit = SalaryCalc::salarycalcview($request);
		return view('salarycalc.view',['request' => $request/*,
											'total' => $total*/,
											'salary_det' => $salary_det,
											'salary_ded' => $salary_ded,
											'detedit' => $detedit[0]]);
	}

	public function edit(Request $request) {
		if (!isset($request->Emp_ID)) {
			return Redirect::to('salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$detedit = array();
		$details = SalaryCalc::salarycalcview($request);
		foreach ($details as $key => $value) {
			$detedit['id'] = $value->id;
			$detedit['Emp_ID'] = $value->Emp_ID;
			$detedit['date'] = $value->date;
			$detedit['year'] = $value->year;
			$detedit['month'] = $value->month;
			$sal = explode('##', mb_substr($value->Salary, 0, -2));
			foreach ($sal as $key1 => $value1) {
				if ($value1 != '') {
					$sal_final = explode('$', $value1);
					$detedit += array('salary_'.$sal_final[0] => ($sal_final[1] != '') ?number_format($sal_final[1]):'');
				}
			}
			$ded = explode('##', mb_substr($value->Deduction, 0, -2));
			foreach ($ded as $key2 => $value2) {
				if ($value2 != '') {
					$ded_final = explode('$', $value2);
					$detedit += array('deduction_'.$ded_final[0] => ($ded_final[1] != '') ? number_format($ded_final[1]): '');
				}
			}
			$detedit['transferred'] = number_format($value->Transferred);
		}
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
		return view('salarycalc.addedit',['request' => $request,
											'salary_det' => $salary_det,
											'salary_ded' => $salary_ded,
											'detedit' => $detedit]);
	}

	public function addedit(Request $request) {
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
		return view('salarycalc.addedit',['request' => $request,
											'salary_det' => $salary_det,
											'salary_ded' => $salary_ded]);
	}

	public function getdataExists(Request $request) {
		$dataExist = SalaryCalc::fnGetDataExistsCheck($request);
		$countdata = count($dataExist);
		print_r($countdata);exit();
  	}

	public function addeditprocess(Request $request) {
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
		if($request->editcheck == 1) {
			$update = SalaryCalc::fnsalarycalcupd($request,$salary_det,$salary_ded);
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			Session::flash('id', $request->id); 
		} else {
			$insert = SalaryCalc::fnsalarycalcadd($request,$salary_det,$salary_ded);
			$getid = SalaryCalc::fngetid();
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			Session::flash('id', $getid); 
		}
		$date = explode("-", $request->date);
		Session::flash('editcheck', '2'); 
		Session::flash('Emp_ID', $request->Emp_ID); 
		Session::flash('firstname', $request->firstname); 
		Session::flash('lastname', $request->lastname); 
		Session::flash('selMonth', $request->month); 
		Session::flash('selYear', $request->selYear);  
		Session::flash('prevcnt', $request->prevcnt); 
		Session::flash('nextcnt', $request->nextcnt); 
		Session::flash('account_val', $request->account_val); 
		Session::flash('previou_next_year', $request->previou_next_year);
		return Redirect::to('salarycalc/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
	
	function multieditprocess(Request $request){
		$get_det = array();
		$detedit = array();
		
		// Get Previous Month
		if ($request->multiflg_reg == 1 && $request->no_flg == '') {
			$prev_month_year_month=date("Y-m",strtotime("-1 month",strtotime(date($request->selYear."-".$request->selMonth,strtotime("now") ) )));
			$prev_month_year_month_explode = explode("-", $prev_month_year_month);
			$request->selYear = $prev_month_year_month_explode[0];
			$request->selMonth = $prev_month_year_month_explode[1];

		}
		$emplimit_array = array('5'=>'5',
								'10'=>'10',
								'15'=>'15',
								'20'=>'20',
								'25'=>'25',
								'50'=>'50');
		if ($request->emp_limit=="") {
			$request->emp_limit = 25;
		}
		
		$g_query = SalaryCalc::salaryDetail($request,$request->selYear,$request->selMonth,1);
		$k = 0;
		foreach ($g_query as $key => $value) {
			if ($value->Salary == "" && $value->Deduction == "") {
				if ($k < $request->emp_limit) {
					$get_det[$k]['id'] = $value->id;
					$get_det[$k]['Emp_ID'] = $value->Emp_ID;
					$get_det[$k]['FirstName'] = $value->FirstName;
					$get_det[$k]['LastName'] = $value->LastName;
					$k++;
				}
			}
		}

		// For Previous Data Getting Process
		if ($request->salflg == 1) {
			$prev_month_ts = strtotime($request->selYear.'-'. substr("0" . $request->selMonth , -2).' -1 month');
			$prev_month = date('Y-m', $prev_month_ts);
			$last_month_year = explode('-', $prev_month);

			$split_array = explode(',', $request->hdn_salid_arr);

			foreach ($g_query as $key => $value) {
				if ($value->Salary == "") {
					$single_data = $g_query = SalaryCalc::salaryDetail($request,$last_month_year[0],$last_month_year[1],1,$value->Emp_ID);
					foreach ($single_data as $key1 => $value1) {
						$Salary = explode('##', mb_substr($value1->Salary, 0, -2));
						foreach ($Salary as $key2 => $value2) {
							$sal_final = explode('$', $value2);
							for ($i=0; $i < count($split_array); $i++) { 
								if ($split_array[$i] == $sal_final[0]) {
									$detedit['salary_'.$value1->Emp_ID.'_'.$sal_final[0]] = (isset($sal_final[1]) && $sal_final[1] != '') ?number_format($sal_final[1]):'';
								}
							}
						}
						$Deduction = explode('##', mb_substr($value1->Deduction, 0, -2));
						foreach ($Deduction as $key3 => $value3) {
							$ded_final = explode('$', $value3);
							for ($j=0; $j < count($split_array); $j++) { 
								if ($split_array[$j] == $ded_final[0]) {
									$detedit['Deduction_'.$value1->Emp_ID.'_'.$ded_final[0]] = (isset($ded_final[1]) && $ded_final[1] != '') ?number_format($ded_final[1]):'';
								}
							}
						}
					}
				}
			}
		}
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
		return view('salarycalc.multiedit',[
											'g_query'=>$g_query,
											'salary_det'=>$salary_det,
											'salary_ded'=>$salary_ded,
											'get_det'=>$get_det,
											'detedit'=>$detedit,
											'emplimit_array'=>$emplimit_array,
											'request' => $request]);
	}

	public function multiregister(Request $request) {	
		/*$query_date = $request->selYear.'-'.$request->selMonth.'-1';
		$date = new DateTime($query_date);
		// Last day of month
		$date->modify('last day of this month');
		$lastday = $date->format('Y-m-d');
		$request->date_hdn = $lastday;*/
		$salary_det=SalaryCalc::getsalaryDetails($request,'1');
		$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
			$insert = Salarycalc::multiadd($request,$salary_det,$salary_ded);
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			$date = explode("-", $request->date_hdn);
			// $chkmonth =" " . substr("0" . $date);
			Session::flash('selMonth', $request->month); 
			Session::flash('selYear', $request->selYear);
			return Redirect::to('salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function mailsendprocess(Request $request) {
		$hdn_empid = explode(',', $request->hdn_empid_arr);
		foreach ($hdn_empid as $key => $value) {
			$month_name = date("F", mktime(0, 0, 0, $request->selMonth, 10));
			$salary_details=SalaryCalc::getsalaryempDetails($request,$value);
			if ($salary_details[0]->mailFlg != '1') {
				$salary_det=SalaryCalc::getsalaryDetails($request,'1');
				$salary_ded=SalaryCalc::getsalaryDetails($request,'2');
				$arr1 = array();
	    		$arr2 = array();
	    		$sal_arr = array();
	    		if ($salary_details[0]->Salary != '') {
					$Salary = explode('##', mb_substr($salary_details[0]->Salary, 0, -2));
					foreach ($Salary as $key => $value) {
						$sal_final = explode('$', $value);
						$arr1[$key] = $sal_final[0];
						$arr2[$sal_final[0]] = $sal_final[1];
					}
	    		}
	    		if(count($salary_det) != "") {
	        		foreach ($salary_det as $key1 => $value1) {
	        			$sal_arr[$value1->Salarayid] = $value1->Salarayid;
	        		}
	    		}
	    		$arr3 = array();
	    		$arr4 = array();
	    		$ded_arr = array();
	    		if ($salary_details[0]->Deduction != '') {
					$Deduction = explode('##', mb_substr($salary_details[0]->Deduction, 0, -2));
					foreach ($Deduction as $key => $value1) {
						$ded_final = explode('$', $value1);
						$arr3[$key] = $ded_final[0];
						$arr4[$ded_final[0]] = $ded_final[1];
					}
	    		}
	    		if(count($salary_ded) != "") {
	        		foreach ($salary_ded as $key2 => $value2) {
	        			$ded_arr[$value2->Salarayid] = $value2->Salarayid;
	        		}
	    		}
	    		if ($salary_details[0]->Emailpersonal != '') {
	    			$send = Mail::send('salarycalc/mailtemplate',compact(
												'arr1',
												'arr2',
												'sal_arr',
												'arr3',
												'arr4',
												'ded_arr',
												'salary_det',
												'salary_ded',
												'salary_details',
												'month_name',
												'request'), 
							function($message) use ($request,$month_name,$salary_details) {
							$message->from('staff@microbit.co.jp','HR INDIA');
							$message->to($salary_details[0]->Emailpersonal)->subject('Salary Details_'.$request->selYear.'_'.$month_name.' : Reg');
						});
					if ($send) {
						$salary_details=SalaryCalc::updateMailFlg($request,$salary_details[0]->Emp_ID);
					}
	    		}
    		}
			
		}
		Session::flash('success', 'Mail Sent Sucessfully!'); 
		Session::flash('type', 'alert-success');
		Session::flash('selMonth', $request->selMonth); 
		Session::flash('selYear', $request->selYear);
		return Redirect::to('salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	function salarydownload(Request $request) {
		// print_r($_REQUEST);exit();
		$template_name = 'resources/assets/uploadandtemplates/templates/salary_details.xls';
        $tempname = "Salary_".$request->selMonth.'_'.$request->selYear;
        $excel_name=$tempname;
		Excel::load($template_name, function($objTpl) use($request) {
			$objTpl->setActiveSheetIndex(0);
        	$objTpl->getActiveSheet(0)->setSelectedCells('A1');

        	$hdn_empid = explode(',', $request->hdn_empid_arr);
	        $empdetails=SalaryCalc::fnGetEmployeeDetails($request,$hdn_empid);
	        $x = 5;
	        $y = 1;
	        $z = $x + count($empdetails);
	        	// print_r($empdetails);exit();
	        $objTpl->getActiveSheet()->getStyle('A4:E4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	foreach ($empdetails as $key => $value) {
        		$objTpl->getActiveSheet()->getRowDimension($x)->setRowHeight(28);
        		$objTpl->getActiveSheet()->getStyle('A'.$x.':E'.$x)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        		$objTpl->getActiveSheet()->getStyle('A'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        		$objTpl->getActiveSheet()->getStyle('A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->getStyle('B'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->getStyle('B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->getStyle('C'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->getStyle('D'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->getStyle('E'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objTpl->getActiveSheet()->setCellValue('A'.$x, $y);
	            $objTpl->getActiveSheet()->getStyle('B'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	            $objTpl->getActiveSheet()->setCellValue('B'.$x, $value->Emp_ID);
	            $objTpl->getActiveSheet()->getStyle('E'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	            $objTpl->getActiveSheet()->setCellValue('C'.$x, $value->FirstName.' '.$value->LastName);
	            $objTpl->getActiveSheet()->setCellValue('D'.$x, $value->KanaFirstName.' '.$value->KanaLastName);
	            $objTpl->getActiveSheet()->setCellValue('E'.$x, number_format($value->Transferred));
            	$objTpl->getActiveSheet()->getStyle('E'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	            $x++;
	            $y++;
        	}
	        $objTpl->getActiveSheet()->getStyle('A4:E4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
        	$objTpl->getActiveSheet()->setTitle('Salary_'.$request->selMonth.'_'.$request->selYear);
        	$flpath='.xls';
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="'.$flpath.'"');
        	header('Cache-Control: max-age=0');
        })->setFilename($excel_name)->download('xls');
	}

}