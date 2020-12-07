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
// use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Cell;
use PHPExcel_Style_Conditional;
use PHPExcel_Style_Color;
use Maatwebsite\Excel\Facades\Excel;

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
			$request->sortstyle = "sort_asc";
		} else {  
			$request->sortstyle = "sort_desc";
		}
		if (Session::get('selYear') != "") {
			$request->selYear = Session::get('selYear');
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
			// $salary_ded = Gensendtls::getsalaryDetailsnodelflg($request,'2');
			$salary_ded = Gensendtls::getAllSelDedDtls($request);

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
		// $salary_ded = Gensendtls::getsalaryDetailsnodelflg($request,'2');
		$salary_ded = Gensendtls::getAllSelDedDtls($request);

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

	public function gensenDownload(Request $request) {
		ini_set('max_execution_time', '300'); 
		ini_set('memory_limit', '300M'); 
		$template_name = 'resources/assets/uploadandtemplates/templates/gensen_details.xlsx';
		$excel_name = 'Gensen_'.$request->empid;

		Excel::load($template_name, function($objPHPExcel) use($request) {

			$companyDetails = Gensendtls::fnGetCompanyDetails($request);
			$empdetail = Gensendtls::fnGetEmpDetail($request);
			$firstname = ($empdetail[0]->FirstName) ? $empdetail[0]->FirstName : "" ;
			$lastname = ($empdetail[0]->LastName) ? $empdetail[0]->LastName : "" ;
			$DOB = str_replace("-","/",($empdetail[0]->DOB) ? $empdetail[0]->DOB : "");
			$FatherDOB = str_replace("-","/",($empdetail[0]->FatherDOB) ? $empdetail[0]->FatherDOB : "");
			$MotherDOB = str_replace("-","/",($empdetail[0]->MotherDOB) ? $empdetail[0]->MotherDOB : "");

			$return_address = ($empdetail[0]->Address1) ? $empdetail[0]->Address1 : "" ;
			if (is_numeric(trim($return_address))) {
				$oldAddress = Gensendtls::fnGetAddressMB($return_address);
				if (isset($oldAddress[0])) {
					$return_address = '〒'.$oldAddress[0]->pincode.' '.$oldAddress[0]->jpstate.$oldAddress[0]->jpaddress.' - '.$oldAddress[0]->roomno;
				} else {
					$return_address = '';
				}
			} else {
				$return_address = $return_address;
			}

			$address = $return_address." ".$firstname." ".$lastname; 

			$tot1 = 0;
			$salary_det = Gensendtls::getsalaryDetailsnodelflg($request,'1');
			// Total For Salary Details
			$g_query1 = Gensendtls::salaryDetailhistory($request,1,$request->empid);
			$a = 0;
			$get_master_tot = array();
			$tot_travel_amt = '';
			foreach ($g_query1 as $key => $value) {
				//For Travel,Salary Amount & Transferred Details
				if ($value->Travel != '') {
					$tot_travel_amt += $value->Travel;
				}
				//For Salary Details
				$arr1 = array();
				$arr2 = array();
				$sal_arr = array();
				$val1 = '';
				if ($value->Salary != '') {
					$Salary = explode('##', mb_substr($value->Salary, 0, -2));
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
				$a++;
			}
			
			// Salary Details
			$salaryDetails = array();
			foreach ($get_master_tot as $key => $value) {
				foreach ($value as $key_sid => $amount) {
					$salaryDetails[$key_sid][] = $amount;
				}
			}

			$temp_salaryDetails = array();
			foreach ($salaryDetails as $key => $value) {
				$b = '';
				foreach ($value as $key_sid => $amount) {
					$b += $amount;
				}
				$temp_salaryDetails[$key] = $b;
			}

			if(count($salary_det) != '0') {
				for ($i = 0; $i < count($salary_det); $i++) {
					if(isset($temp_salaryDetails[$salary_det[$i]->Salarayid]) && $temp_salaryDetails[$salary_det[$i]->Salarayid] != '0') {
						$tot1 += $temp_salaryDetails[$salary_det[$i]->Salarayid];
					}
				}
			}
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue("M11", ($empdetail[0]->KanaFirstName) ? $empdetail[0]->KanaFirstName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("N11", ($empdetail[0]->KanaLastName) ? $empdetail[0]->KanaLastName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("M12", $firstname);
			$objPHPExcel->getActiveSheet()->setCellValue("N12", $lastname);
			$objPHPExcel->getActiveSheet()->setCellValue("O12", $DOB);
			$objPHPExcel->getActiveSheet()->getStyle("M13")->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue("M13", $address);
			$objPHPExcel->getActiveSheet()->setCellValue("D17", ($empdetail[0]->FatherName) ? $empdetail[0]->FatherName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("E17", ".");
			$objPHPExcel->getActiveSheet()->setCellValue("F17", ($empdetail[0]->FatherkanaName) ? $empdetail[0]->FatherkanaName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("J17", $FatherDOB);
			$objPHPExcel->getActiveSheet()->setCellValue("D18", ($empdetail[0]->MotherName) ? $empdetail[0]->MotherName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("E18", ".");
			$objPHPExcel->getActiveSheet()->setCellValue("F18", ($empdetail[0]->MotherkanaName) ? $empdetail[0]->MotherkanaName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("J18", $MotherDOB);
			$objPHPExcel->getActiveSheet()->setCellValue("V21", $tot1);
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setSelectedCells("A1");
		})->setFilename($excel_name)->download('xlsx');
	}

	public static function salarydeductionpopup(Request $request) {

		$deductionUnselect = Gensendtls::getAllDeselDedDtls($request);
		$deductionSelect = Gensendtls::getAllSelDedDtls($request);

		return view('gensendtls.salarydeductionpopup',[
									'deductionUnselect' => $deductionUnselect,
									'deductionSelect' => $deductionSelect,
									'request' => $request
								]);
	}

	public static function deductionselectprocess(Request $request) {

		$insert = Gensendtls::insSelDedDtls($request);
		if($insert){
			Session::flash('success', 'Salary Deduction Selected Sucessfully!');
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('type', 'Salary Deduction Selected Unsucessfully!!');
			Session::flash('type', 'alert-danger'); 
		}
		Session::flash('selYear', $request->selYear); 

		return Redirect::to('Gensendtls/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function gensenViewDwld(Request $request) {
		$template_name='resources/assets/uploadandtemplates/templates/gensen_Payment.xlsx';
		$excel_name = 'Gensen_'.$request->selYear."_".$request->empid;
		
		Excel::load($template_name, function($objPHPExcel) use($request) {

			$empdetail = Gensendtls::fnGetEmpDetail($request);
			$firstname = ($empdetail[0]->FirstName) ? $empdetail[0]->FirstName : "" ;
			$lastname = ($empdetail[0]->LastName) ? $empdetail[0]->LastName : "" ;
			$DOB = str_replace("-","/",($empdetail[0]->DOB) ? $empdetail[0]->DOB : "");
			$FatherDOB = str_replace("-","/",($empdetail[0]->FatherDOB) ? $empdetail[0]->FatherDOB : "");
			$MotherDOB = str_replace("-","/",($empdetail[0]->MotherDOB) ? $empdetail[0]->MotherDOB : "");
			$return_address = ($empdetail[0]->Address1) ? $empdetail[0]->Address1 : "" ;

			if (is_numeric(trim($return_address))) {
				$oldAddress = Gensendtls::fnGetAddressMB($return_address);
				if (isset($oldAddress[0])) {
					$return_address = '〒'.$oldAddress[0]->pincode.' '.$oldAddress[0]->jpstate.$oldAddress[0]->jpaddress.' - '.$oldAddress[0]->roomno;
				} else {
					$return_address = '';
				}
			} else {
				$return_address = $return_address;
			}

			$address = $return_address." ".$firstname." ".$lastname; 
			
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue("C6", $request->empid);
			$objPHPExcel->getActiveSheet()->setCellValue("C9", ($empdetail[0]->KanaFirstName) ? $empdetail[0]->KanaFirstName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("D9", ($empdetail[0]->KanaLastName) ? $empdetail[0]->KanaLastName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("C10", $firstname);
			$objPHPExcel->getActiveSheet()->setCellValue("D10", $lastname);
			$objPHPExcel->getActiveSheet()->setCellValue("E10", $DOB);
			$objPHPExcel->getActiveSheet()->getStyle("C11")->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue("C11", $address);
			$objPHPExcel->getActiveSheet()->setCellValue("C15", ($empdetail[0]->FatherName) ? $empdetail[0]->FatherName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("D15", ($empdetail[0]->FatherkanaName) ? $empdetail[0]->FatherkanaName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("E15", $FatherDOB);
			$objPHPExcel->getActiveSheet()->setCellValue("C16", ($empdetail[0]->MotherName) ? $empdetail[0]->MotherName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("D16", ($empdetail[0]->MotherkanaName) ? $empdetail[0]->MotherkanaName : "");
			$objPHPExcel->getActiveSheet()->setCellValue("E16", $MotherDOB);

			$SalaryPaytot = 0;
			$SalaryDedtot = 0;
			// Salary Payament
			$salary_det = Gensendtls::getsalaryDetailsnodelflg($request,'1');
			$salary_ded = Gensendtls::getAllSelDedDtls($request);
			// Total For Salary Details
			$salquery = Gensendtls::salaryDetailhistory($request,1,$request->empid);
			$a = 0;
			$get_master_tot = array();
			$get_master_tot1 = array();
			foreach ($salquery as $salkey => $salvalue) {
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
			$temp_salaryDetails = array();
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
			$temp_salaryDetails_DD = array();
			foreach ($salaryDetails_DD as $tempkey_DD => $tempvalue_DD) {
				$c = '';
				foreach ($tempvalue_DD as $key_sid_DD => $amount_DD) {
					$c += $amount_DD;
				}
				$temp_salaryDetails_DD[$tempkey_DD] = $c;
			}

			if(count($salary_det) != '0') {
				for ($i = 0; $i < count($salary_det); $i++) {
					if(isset($temp_salaryDetails[$salary_det[$i]->Salarayid]) && $temp_salaryDetails[$salary_det[$i]->Salarayid] != '0') {
						$SalaryPaytot += $temp_salaryDetails[$salary_det[$i]->Salarayid];
					}
				}
			}
			if(count($salary_ded) != '0') {
				for ($j = 0; $j < count($salary_ded); $j++) {
					if(isset($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] != '0') {
						$SalaryDedtot += $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid];
					}
				} 
			}

			// Insurance
			$insuranceTot = 0;
			$k = 0;
			$get_ins_det = array();
			$insuranceTotal = Gensendtls::fnGetInstotDtls($request,$request->empid);
			if (isset($insuranceTotal[0])) {
				$get_ins_det[$k]['Amounts'] = $insuranceTotal[0]->Amounts;
				$get_ins_det[$k]['Months'] = $insuranceTotal[0]->months;
			}
			if(count($get_ins_det) != '0') {
				for ($k = 0; $k < count($get_ins_det); $k++) {
					if(strlen($get_ins_det[$k]['Amounts'] > 2)){
						$AmountVal = explode(",",$get_ins_det[$k]['Amounts']);
						$Month = explode(",",$get_ins_det[$k]['Months']);
						$Amount = array();
						foreach ($AmountVal as $key => $value) {
							if (array_key_exists($Month[$key], $Amount)) {
								$Amount[$Month[$key]] += $value;
							} else {
								$Amount[$Month[$key]] = $value;
							}
							$insuranceTot += $value;
						}
					}
				}
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue("B19", $SalaryPaytot);
			$objPHPExcel->getActiveSheet()->setCellValue("C19", $SalaryDedtot);
			$objPHPExcel->getActiveSheet()->setCellValue("D19", $insuranceTot);

			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setSelectedCells("A1");
		})->setFilename($excel_name)->download('xlsx');
	}

	public function gensenindexDwld(Request $request) {

		$template_name='resources/assets/uploadandtemplates/templates/gensen_Payment.xlsx';
		if ($request->selYear == "") {
			$selYear = date('Y');
		}
		$excel_name = 'Gensen_'.$request->selYear;

		Excel::load($template_name, function($objPHPExcel) use($request) {

			$gensenDtls = Gensendtls::getGensenDetail($request,1);
			$i = 6;

			foreach ($gensenDtls as $key => $value) {

				$request->empid = $value->Emp_ID;
				$empdetail = Gensendtls::fnGetEmpDetail($request);
				$firstname = ($empdetail[0]->FirstName) ? $empdetail[0]->FirstName : "" ;
				$lastname = ($empdetail[0]->LastName) ? $empdetail[0]->LastName : "" ;
				$DOB = str_replace("-","/",($empdetail[0]->DOB) ? $empdetail[0]->DOB : "");
				$FatherDOB = str_replace("-","/",($empdetail[0]->FatherDOB) ? $empdetail[0]->FatherDOB : "");
				$MotherDOB = str_replace("-","/",($empdetail[0]->MotherDOB) ? $empdetail[0]->MotherDOB : "");
				$return_address = ($empdetail[0]->Address1) ? $empdetail[0]->Address1 : "" ;
				if (is_numeric(trim($return_address))) {
					$oldAddress = Gensendtls::fnGetAddressMB($return_address);
					if (isset($oldAddress[0])) {
						$return_address = '〒'.$oldAddress[0]->pincode.' '.$oldAddress[0]->jpstate.$oldAddress[0]->jpaddress.' - '.$oldAddress[0]->roomno;
					} else {
						$return_address = '';
					}
				} else {
					$return_address = $return_address;
				}

				$address = $return_address." ".$firstname." ".$lastname; 

				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Emp no");
				$objPHPExcel->getActiveSheet()->getStyle('B'.$i, "Emp no")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle('B'.$i, "Emp no")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $request->empid);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$i, $request->empid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle('C'.$i, $request->empid)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 3;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Kana");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Kana")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Kana")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, ($empdetail[0]->KanaFirstName) ? $empdetail[0]->KanaFirstName : "");
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, ($empdetail[0]->KanaFirstName) ? $empdetail[0]->KanaFirstName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, ($empdetail[0]->KanaLastName) ? $empdetail[0]->KanaLastName : "");
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, ($empdetail[0]->KanaLastName) ? $empdetail[0]->KanaLastName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$i, "生年月日");
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, "生年月日")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, "生年月日")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 1;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Name");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Name")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Name")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $firstname);
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, $firstname)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $lastname);
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, $lastname)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $DOB);
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, $DOB)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 1;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Address");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Address")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Address")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':E'.$i);
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(28);
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, $address)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $address);
				$i = $i + 3;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Person");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Person")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Person")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, "Name");
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, "Name")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, "Name")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, "Kana Name");
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, "Kana Name")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, "Kana Name")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$i, "DOB");
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, "DOB")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, "DOB")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 1;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Father");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Father")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Father")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, ($empdetail[0]->FatherName) ? $empdetail[0]->FatherName : "");
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, ($empdetail[0]->FatherName) ? $empdetail[0]->FatherName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, ($empdetail[0]->FatherkanaName) ? $empdetail[0]->FatherkanaName : "");
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, ($empdetail[0]->FatherkanaName) ? $empdetail[0]->FatherkanaName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $FatherDOB);
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, $FatherDOB)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 1;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Mother");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Mother")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Mother")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, ($empdetail[0]->MotherName) ? $empdetail[0]->MotherName : "");
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, ($empdetail[0]->MotherName) ? $empdetail[0]->MotherName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, ($empdetail[0]->MotherkanaName) ? $empdetail[0]->MotherkanaName : "");
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, ($empdetail[0]->MotherkanaName) ? $empdetail[0]->MotherkanaName : "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $MotherDOB);
				$objPHPExcel->getActiveSheet()->getStyle("E".$i, $MotherDOB)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

				$SalaryPaytot = 0;
				$SalaryDedtot = 0;
				// Salary Payament
				$salary_det = Gensendtls::getsalaryDetailsnodelflg($request,'1');
				$salary_ded = Gensendtls::getAllSelDedDtls($request);
				// Total For Salary Details
				$salquery = Gensendtls::salaryDetailhistory($request,1,$request->empid);
				$a = 0;
				$get_master_tot = array();
				$get_master_tot1 = array();
				foreach ($salquery as $salkey => $salvalue) {
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
				$temp_salaryDetails = array();
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
				$temp_salaryDetails_DD = array();
				foreach ($salaryDetails_DD as $tempkey_DD => $tempvalue_DD) {
					$c = '';
					foreach ($tempvalue_DD as $key_sid_DD => $amount_DD) {
						$c += $amount_DD;
					}
					$temp_salaryDetails_DD[$tempkey_DD] = $c;
				}

				if(count($salary_det) != '0') {
					for ($l = 0; $l < count($salary_det); $l++) {
						if(isset($temp_salaryDetails[$salary_det[$l]->Salarayid]) && $temp_salaryDetails[$salary_det[$l]->Salarayid] != '0') {
							$SalaryPaytot += $temp_salaryDetails[$salary_det[$l]->Salarayid];
						}
					}
				}
				if(count($salary_ded) != '0') {
					for ($j = 0; $j < count($salary_ded); $j++) {
						if(isset($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] != '0') {
							$SalaryDedtot += $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid];
						}
					} 
				}

				// Insurance
				$insuranceTot = 0;
				$k = 0;
				$get_ins_det = array();
				$insuranceTotal = Gensendtls::fnGetInstotDtls($request,$request->empid);
				if (isset($insuranceTotal[0])) {
					$get_ins_det[$k]['Amounts'] = $insuranceTotal[0]->Amounts;
					$get_ins_det[$k]['Months'] = $insuranceTotal[0]->months;
				}
				if(count($get_ins_det) != '0') {
					for ($k = 0; $k < count($get_ins_det); $k++) {
						if(strlen($get_ins_det[$k]['Amounts'] > 2)){
							$AmountVal = explode(",",$get_ins_det[$k]['Amounts']);
							$Month = explode(",",$get_ins_det[$k]['Months']);
							$Amount = array();
							foreach ($AmountVal as $key => $value) {
								if (array_key_exists($Month[$key], $Amount)) {
									$Amount[$Month[$key]] += $value;
								} else {
									$Amount[$Month[$key]] = $value;
								}
								$insuranceTot += $value;
							}
						}
					}
				}

				$i = $i + 2;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, "Salary");
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, "Salary")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle('B'.$i, "Salary")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, "Deduction");
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, "Deduction")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, "Deduction")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, "Insurance");
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, "Insurance")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BFBFBF');
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, "Insurance")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 1;
				$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $SalaryPaytot);
				$objPHPExcel->getActiveSheet()->getStyle("B".$i, $SalaryPaytot)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $SalaryDedtot);
				$objPHPExcel->getActiveSheet()->getStyle("C".$i, $SalaryDedtot)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $insuranceTot);
				$objPHPExcel->getActiveSheet()->getStyle("D".$i, $insuranceTot)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$i = $i + 3;
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setSelectedCells("A1");
		})->setFilename($excel_name)->download('xlsx');
	}

}