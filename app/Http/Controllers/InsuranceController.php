<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Insurance;

use DB;

use Input;

use Redirect;

use Session;

use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller {

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
	 //SORT POSITION
        if (!empty($request->singlesearch) || $request->searchmethod == 2) {
          $sortMargin = "margin-right:200px;";
        } else {
          $sortMargin = "margin-right:0px;";
        }
		$array = array("Emp_Id"=>trans('messages.lbl_empid'),
						"Date"=>trans('messages.lbl_date'));

		$empdetails=Insurance::fnGetEmployeeDetails($request);

		$k = 0;
		$get_emp_det = array();
		foreach ($empdetails as $key => $value) {
			$get_emp_det[$k]['Emp_ID'] = $value->Emp_Id;
			$get_emp_det[$k]['FirstName'] = $value->FirstName;
			$get_emp_det[$k]['LastName'] = $value->LastName;
			$get_emp_det[$k]['Amounts'] = $value->Amounts;
			$get_emp_det[$k]['Months'] = $value->months;
			$k++;
		}
		$total_yrs = array();
		$prev_yrs = array();
		$cur_year = date('Y');
		$curtime = date('YmdHis');
		$yearArr = Insurance::getYears();
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

		return view('insurance.index',['empdetails' => $empdetails,
										'get_emp_det' => $get_emp_det,
										'request' => $request,
										'array' => $array,
										'selectedYear' => $selectedYear,
										'sortMargin' =>  $sortMargin,
										'cur_year' =>  $cur_year,
										'curtime' =>  $curtime,
										'prev_yrs' =>  $prev_yrs,
										'total_yrs' =>  $total_yrs,
										'selectedYear' =>  $selectedYear
									]);

	}


}