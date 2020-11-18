<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Leavedtls;

use DB;

use Input;

use Redirect;

use Session;

use Illuminate\Support\Facades\Validator;

class LeavedtlsController extends Controller {

	function index(Request $request) { 

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

		$empdetails=Leavedtls::fnGetEmployeeDetails($request);

		$k = 0;
		$get_emp_det = array();
		foreach ($empdetails as $key => $value) {
			
			$get_emp_det[$k]['Emp_ID'] = $value->Emp_Id;
			$empName = Leavedtls::fnGetEmpName($value->Emp_Id);
			if (isset($empName[0])) {
				$firstName = $empName[0]->FirstName;
				$lastName = $empName[0]->LastName;
			} else {
				$firstName = '';
				$lastName = '';
			}

			$get_emp_det[$k]['FirstName'] = $firstName;
			$get_emp_det[$k]['LastName'] = $lastName;
			$get_emp_det[$k]['leave_cnt'] = $value->leave_cnt;
			$get_emp_det[$k]['Months'] = $value->months;
			$k++;
		}

		$cur_year = date('Y');
		$curtime = date('YmdHis');
		$yearArr = Leavedtls::getYears();

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
			$selectedYear=$request->selYear;
			$cur_year=$selectedYear;
		} else {
			$selectedYear=$cur_year;
		}

		return view('leavedtls.index',['empdetails' => $empdetails,
										'get_emp_det' => $get_emp_det,
										'request' => $request,
										'array' => $array,
										'selectedYear' => $selectedYear,
										'cur_year' =>  $cur_year,
										'curtime' =>  $curtime,
										'prev_yrs' =>  $prev_yrs,
										'total_yrs' =>  $total_yrs,
										'selectedYear' =>  $selectedYear
									]);

	}


}