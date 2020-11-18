<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\SalBank;

use App\Model\Staff;

use DB;

use Input;

use Redirect;

use Config;

use Session;

use Illuminate\Support\Facades\Validator;


class SalBankController extends Controller {

	function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->banksort == "") {
        	$request->banksort = "Emp_ID";
      	}
		if (empty($request->sortOrder)) {
        	$request->sortOrder = "asc";
      	}
      	if ($request->sortOrder == "asc") {  
      		$request->sortstyle="sort_asc";
      	} else {  
   			$request->sortstyle="sort_desc";
   		}

		$array = array("Emp_ID"=>trans('messages.lbl_empid'),
						"LastName"=>trans('messages.lbl_empName'));
		
		$empdetails=SalBank::fnGetBankDetails($request);

		return view('SalBank.index',['empdetails' => $empdetails,
										'array' => $array,
										'request' => $request]);

	}

	function addressIndex(Request $request) { 
		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->addresssort == "") {
        	$request->addresssort = "Emp_ID";
      	}
		if (empty($request->sortOrder)) {
        	$request->sortOrder = "asc";
      	}
      	if ($request->sortOrder == "asc") {  
      		$request->sortstyle="sort_asc";
      	} else {  
   			$request->sortstyle="sort_desc";
   		}

		$array = array("Emp_ID"=>trans('messages.lbl_empid'),
						"LastName"=>trans('messages.lbl_empName'));

		$empdetails=SalBank::fnGetAddressDetails($request);
		
		return view('SalBank.address',['empdetails' => $empdetails,
										'array' => $array,
										'request' => $request]);

	}

	function familyIndex(Request $request) { 
		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->familysort == "") {
        	$request->familysort = "Emp_ID";
      	}
		if (empty($request->sortOrder)) {
        	$request->sortOrder = "asc";
      	}
      	if ($request->sortOrder == "asc") {  
      		$request->sortstyle="sort_asc";
      	} else {  
   			$request->sortstyle="sort_desc";
   		}

		if ( $request->searchmethod == 1) {
          $sortMargin = "margin-right:220px;";
        } else {
          $sortMargin = "margin-right:0px;";
        }

		$array = array("Emp_ID"=>trans('messages.lbl_empid'),
						"LastName"=>trans('messages.lbl_empName'));

		$familydata =SalBank::fnGetFamilyDetails($request);

		return view('SalBank.family',['familydata' => $familydata,
										'array' => $array,
										'sortMargin' => $sortMargin,
										'request' => $request]);

	}

}