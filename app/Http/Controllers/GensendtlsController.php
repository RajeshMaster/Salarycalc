<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Gensendtls;
use DB;
use Input;
use Redirect;
use Session;
use Illuminate\Support\Facades\Validator;

class GensendtlsController extends Controller {

	public function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		//SORTING PROCESS
		if ($request->basicsort == "") {
			$request->basicsort = "Emp_ID";
		}
		if (empty($request->sortOrder)) {
			$request->sortOrder = "asc";
		}
		if ($request->sortOrder == "asc") {  
			$request->sortstyle="sort_asc";
		} else {  
			$request->sortstyle="sort_desc";
		}
	 
		$array = array("Emp_Id"=>trans('messages.lbl_empid'));
		$gensenDtls = Gensendtls::getGensenDetail($request,0);
		$total = '0';
		$k = 0;
		$get_emp_det = array();
		$salary_det = array();
		$salaryDetails = array();
		$temp_salaryDetails = array();
		$salary_ded = array();
		$salaryDetails_DD = array();
		$temp_salaryDetails_DD = array();
		$tot_travel_amt = array();
		foreach ($gensenDtls as $key => $value) {
			$get_emp_det[$k]['Emp_ID'] = $value->Emp_ID;
			$empName = Gensendtls::fnGetEmpDtls($value->Emp_ID);
			if (isset($empName[0])) {
				$firstName = $empName[0]->FirstName;
				$lastName = $empName[0]->LastName;
			} else {
				$firstName = '';
				$lastName = '';
			}
			$get_emp_det[$k]['FirstName'] = $firstName;
			$get_emp_det[$k]['LastName'] = $lastName;
			// Insurance
			$insuranceTotal = Gensendtls::fnGetInstotDtls($request,$value->Emp_ID);
			if (isset($insuranceTotal[0])) {
				$get_emp_det[$k]['Amounts'] = $insuranceTotal[0]->Amounts;
				$get_emp_det[$k]['Months'] = $insuranceTotal[0]->months;
			}
			// Salary Payament
			$salary_det = Gensendtls::getsalaryDetailsnodelflg($request,'1');
			$salary_ded = Gensendtls::getsalaryDetailsnodelflg($request,'2');

			// Total For Salary Details
			$salquery = Gensendtls::salaryDetailhistory($request,1,$value->Emp_ID);
			$a = 0;
			$get_master_tot = array();
			$get_master_tot1 = array();
			$tot_travel_amt[$value->Emp_ID] = 0;
			foreach ($salquery as $salkey => $salvalue) {
				// print_r($salvalue->Travel);
				// For Travel,Salary Amount & Transferred Details
				if ($salvalue->Travel != '') {
					$tot_travel_amt[$value->Emp_ID] += $salvalue->Travel;
				} 
				//For Salary Details
				$arr1 = array();
				$arr2 = array();
				$sal_arr = array();
				$val1 = '';
				if ($salvalue->Salary != '') {
					$Salary = explode('##', mb_substr($salvalue->Salary, 0, -2));
					foreach ($Salary as $key => $value_key) {
						$sal_final = explode('$', $value_key);
						$arr1[$key] = $sal_final[0];
						$arr2[$sal_final[0]] = $sal_final[1];
					}
				}
				if(count($salary_det) != "") {
					foreach ($salary_det as $key1 => $value1) {
						$sal_arr[$value1->Salarayid] = $value1->Salarayid;
					}
				}
				$salresult_a = array_intersect($sal_arr,$arr1);
				$salresult_b = array_diff($sal_arr,$arr1);
				$salresult = array_merge($salresult_a,$salresult_b);
				ksort($salresult);
				if(count($salary_det) != "" && is_array($salresult)) {
					$x = 0;
					foreach ($salresult as $key2 => $value2) {
						if ($key2 != '') {
							if($key2 == isset($arr2[$key2])) {
								$val1 += $arr2[$key2];
								$get_master_tot[$a][$key2] = $arr2[$key2];
							} else {
								$get_master_tot[$a][$key2] = 0;
							}
						}
						$x++;
					}
				}
				// Salary Deduction
				$arr3 = array();
				$arr4 = array();
				$ded_arr = array();
				$val2 = '';
				if ($salvalue->Deduction != '') {
					$Deduction = explode('##', mb_substr($salvalue->Deduction, 0, -2));
					foreach ($Deduction as $key => $value1) {
						$ded_final = explode('$', $value1);
						$arr3[$key] = $ded_final[0];
						$arr4[$ded_final[0]] = $ded_final[1];
					}
				}
				if(count($salary_ded) != 0) {
					foreach ($salary_ded as $key2 => $value2) {
						$ded_arr[$value2->Salarayid] = $value2->Salarayid;
					}
				}
				$dedresult_a = array_intersect($ded_arr,$arr3);
				$dedresult_b = array_diff($ded_arr,$arr3);
				$dedresult = array_merge($dedresult_a,$dedresult_b);
				ksort($dedresult);
				if(count($salary_ded) != 0) {
					$y = 0;
					foreach ($dedresult as $key2 => $value2) {
						if ($key2 != '') {
							if($key2 == isset($arr4[$key2])) {
								$val2 += $arr4[$key2];
								$get_master_tot1[$a][$key2] = $arr4[$key2];
							}
						}
						$y++;
					}
				}
				$a++;
			}

			// Salary Details
			$salaryDetails = array();
			foreach ($get_master_tot as $totkey => $totvalue) {
				foreach ($totvalue as $key_sid => $amount) {
					$salaryDetails[$key_sid][] = $amount;
				}
			}
			foreach ($salaryDetails as $tempkey => $tempvalue) {
				$b = '';
				foreach ($tempvalue as $key_sid => $amount) {
					$b += $amount;
				}
				$temp_salaryDetails[$tempkey][$value->Emp_ID] = $b;
			}

			// Salary Deduction
			$salaryDetails_DD = array();
			foreach ($get_master_tot1 as $totkey_DD => $totvalue_DD) {
				foreach ($totvalue_DD as $key_sid_DD => $amount_DD) {
					$salaryDetails_DD[$key_sid_DD][] = $amount_DD;
				}
			}
			foreach ($salaryDetails_DD as $tempkey_DD => $tempvalue_DD) {
				$c = '';
				foreach ($tempvalue_DD as $key_sid_DD => $amount_DD) {
					$c += $amount_DD;
				}
				$temp_salaryDetails_DD[$tempkey_DD][$value->Emp_ID] = $c;
			}

			$k++;
		}

		$cur_year = date('Y');
		$curtime = date('YmdHis');
		$yearArr = Gensendtls::getYears();
		$prev_yrs = array();
		$total_yrs = array();

		foreach ($yearArr as $value) {
			$prev_yrs[] = $value->years;
			$total_yrs[] = $value->years;
		}

		if (!in_array($cur_year, $total_yrs)) {
			array_push($total_yrs,$cur_year);
		}

		if (isset($request->selYear) && !empty($request->selYear)) {
			$selectedYear = $request->selYear;
			$cur_year = $selectedYear;
		} else {
			$selectedYear = $cur_year;
		}

		return view('gensendtls.index',[
									'request' => $request,
									'gensenDtls' => $gensenDtls,
									'get_emp_det' => $get_emp_det,
									'tot_travel_amt' => $tot_travel_amt,
									'salary_det' => $salary_det,
									'temp_salaryDetails' => $temp_salaryDetails,
									'salary_ded' => $salary_ded,
									'temp_salaryDetails_DD' => $temp_salaryDetails_DD,
									'selectedYear' => $selectedYear,
									'cur_year' =>  $cur_year,
									'array' => $array,
									'curtime' =>  $curtime,
									'prev_yrs' =>  $prev_yrs,
									'total_yrs' =>  $total_yrs,
								]);

	}

	public function view(Request $request) {
		if(!isset($request->Emp_ID)){
			return Redirect::to('Gensendtls/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$file = "../resources/assets/images/upload/";
		$noimage = "../resources/assets/images";
		$src = "";
		$staffdetail = Gensendtls::fnGetstaffDetail($request);
		$companyDetails = Gensendtls::fnGetCompanyDetails($request);
		$total = '0';
		$get_emp_det = array();
		$salary_det = array();
		$salaryDetails = array();
		$temp_salaryDetails = array();
		$salary_ded = array();
		$salaryDetails_DD = array();
		$temp_salaryDetails_DD = array();
		$tot_travel_amt = array();
		// Insurance
		$insuranceTotal = Gensendtls::fnGetInstotDtls($request,$request->Emp_ID);
		if (isset($insuranceTotal[0])) {
			$get_emp_det['Amounts'] = $insuranceTotal[0]->Amounts;
			$get_emp_det['Months'] = $insuranceTotal[0]->months;
		}
		// Salary Payament
		$salary_det = Gensendtls::getsalaryDetailsnodelflg($request,'1');
		$salary_ded = Gensendtls::getsalaryDetailsnodelflg($request,'2');

		// Total For Salary Details
		$salquery = Gensendtls::salaryDetailhistory($request,1,$request->Emp_ID);
		$a = 0;
		$get_master_tot = array();
		$get_master_tot1 = array();
		$tot_travel_amt = 0;
		foreach ($salquery as $salkey => $salvalue) {
			// print_r($salvalue->Travel);
			// For Travel,Salary Amount & Transferred Details
			if ($salvalue->Travel != '') {
				$tot_travel_amt += $salvalue->Travel;
			} 
			//For Salary Details
			$arr1 = array();
			$arr2 = array();
			$sal_arr = array();
			$val1 = '';
			if ($salvalue->Salary != '') {
				$Salary = explode('##', mb_substr($salvalue->Salary, 0, -2));
				foreach ($Salary as $key => $value_key) {
					$sal_final = explode('$', $value_key);
					$arr1[$key] = $sal_final[0];
					$arr2[$sal_final[0]] = $sal_final[1];
				}
			}
			if(count($salary_det) != "") {
				foreach ($salary_det as $key1 => $value1) {
					$sal_arr[$value1->Salarayid] = $value1->Salarayid;
				}
			}
			$salresult_a = array_intersect($sal_arr,$arr1);
			$salresult_b = array_diff($sal_arr,$arr1);
			$salresult = array_merge($salresult_a,$salresult_b);
			ksort($salresult);
			if(count($salary_det) != "" && is_array($salresult)) {
				$x = 0;
				foreach ($salresult as $key2 => $value2) {
					if ($key2 != '') {
						if($key2 == isset($arr2[$key2])) {
							$val1 += $arr2[$key2];
							$get_master_tot[$a][$key2] = $arr2[$key2];
						} else {
							$get_master_tot[$a][$key2] = 0;
						}
					}
					$x++;
				}
			}
			// Salary Deduction
			$arr3 = array();
			$arr4 = array();
			$ded_arr = array();
			$val2 = '';
			if ($salvalue->Deduction != '') {
				$Deduction = explode('##', mb_substr($salvalue->Deduction, 0, -2));
				foreach ($Deduction as $key => $value1) {
					$ded_final = explode('$', $value1);
					$arr3[$key] = $ded_final[0];
					$arr4[$ded_final[0]] = $ded_final[1];
				}
			}
			if(count($salary_ded) != 0) {
				foreach ($salary_ded as $key2 => $value2) {
					$ded_arr[$value2->Salarayid] = $value2->Salarayid;
				}
			}
			$dedresult_a = array_intersect($ded_arr,$arr3);
			$dedresult_b = array_diff($ded_arr,$arr3);
			$dedresult = array_merge($dedresult_a,$dedresult_b);
			ksort($dedresult);
			if(count($salary_ded) != 0) {
				$y = 0;
				foreach ($dedresult as $key2 => $value2) {
					if ($key2 != '') {
						if($key2 == isset($arr4[$key2])) {
							$val2 += $arr4[$key2];
							$get_master_tot1[$a][$key2] = $arr4[$key2];
						}
					}
					$y++;
				}
			}
			$a++;
		}

		// Salary Details
		$salaryDetails = array();
		foreach ($get_master_tot as $totkey => $totvalue) {
			foreach ($totvalue as $key_sid => $amount) {
				$salaryDetails[$key_sid][] = $amount;
			}
		}
		foreach ($salaryDetails as $tempkey => $tempvalue) {
			$b = '';
			foreach ($tempvalue as $key_sid => $amount) {
				$b += $amount;
			}
			$temp_salaryDetails[$tempkey] = $b;
		}

		// Salary Deduction
		$salaryDetails_DD = array();
		foreach ($get_master_tot1 as $totkey_DD => $totvalue_DD) {
			foreach ($totvalue_DD as $key_sid_DD => $amount_DD) {
				$salaryDetails_DD[$key_sid_DD][] = $amount_DD;
			}
		}
		foreach ($salaryDetails_DD as $tempkey_DD => $tempvalue_DD) {
			$c = '';
			foreach ($tempvalue_DD as $key_sid_DD => $amount_DD) {
				$c += $amount_DD;
			}
			$temp_salaryDetails_DD[$tempkey_DD] = $c;
		}

		return view('gensendtls.view',[
									'staffdetail' => $staffdetail,
									'file' => $file,
									'src' => $src,
									'noimage' => $noimage,
									'companyDetails' => $companyDetails,
									'request' => $request,
									'get_emp_det' => $get_emp_det,
									'tot_travel_amt' => $tot_travel_amt,
									'salary_det' => $salary_det,
									'temp_salaryDetails' => $temp_salaryDetails,
									'salary_ded' => $salary_ded,
									'temp_salaryDetails_DD' => $temp_salaryDetails_DD,
								]);
	}
}