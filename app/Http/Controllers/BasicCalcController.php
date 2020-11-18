<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\SalBasic;

use DB;

use Input;

use Redirect;

use Session;

use Illuminate\Support\Facades\Validator;

class BasicCalcController extends Controller {

	function index(Request $request) { 

		// PAGINATION

		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->basicsort == "") {
        	$request->basicsort = "year_month_to";
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
						"year_month_to"=>trans('messages.lbl_date'));

		$empdetails=SalBasic::fnGetEmployeeDetails($request);

		$k = 0;
		$get_emp_det = array();
		foreach ($empdetails as $key => $value) {

			$get_emp_det[$k]['Emp_ID'] = $value->Emp_Id;
			$empName = SalBasic::fnGetEmpName($value->Emp_Id);
			if (isset($empName[0])) {
				$firstName = $empName[0]->FirstName;
				$lastName = $empName[0]->LastName;
			} else {
				$firstName = '';
				$lastName = '';
			}

			$get_emp_det[$k]['FirstName'] = $firstName;
			$get_emp_det[$k]['LastName'] = $lastName;
			$get_emp_det[$k]['year_month_from'] = $value->year_month_from;
			$get_emp_det[$k]['year_month_to'] = $value->year_month_to;
			$get_emp_det[$k]['incAmount'] = $value->increment_amount;
			$get_emp_det[$k]['basicAmount'] = $value->basicAmount;
			$get_emp_det[$k]['hra'] = $value->hra;

			$checkdet[$k]['checkedit'] = SalBasic::datacheck($request,$value->Emp_Id);
			if (!empty($checkdet[$k]['checkedit'])) {
				$get_emp_det[$k]['editcheck'] = "1";
			} else {
				$get_emp_det[$k]['editcheck'] = "0";
			}
			$k++;
		}
		return view('BasicCalc.index',['empdetails' => $empdetails,
										'get_emp_det' => $get_emp_det,
										'request' => $request,
										'array' => $array,
										'sortMargin' =>  $sortMargin
									]);

	}

	public function view(Request $request) {
		if(Session::get('Emp_ID') !="" && Session::get('id') !="") {
			$request->id =  Session::get('id');
			$request->Emp_ID =  Session::get('Emp_ID');
			$request->firstname =  Session::get('firstname');
			$request->lastname =  Session::get('lastname');
			$request->editcheck =  Session::get('editcheck');
		}
		if (!isset($request->Emp_ID)) {
			return Redirect::to('BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$detedit = SalBasic::basiccalcview($request);
		$data_history = SalBasic::basiccalcview_history($request);
		return view('BasicCalc.view',['request' => $request,
									   'data_history' => $data_history,
									   'detedit' => $detedit[0]]);
	}

	public function addedit(Request $request) {
		if (!isset($request->Emp_ID)) {
			return Redirect::to('BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		return view('BasicCalc.addedit',['request' => $request]);
	}

	public function edit(Request $request) {
		if (!isset($request->Emp_ID)) {
			return Redirect::to('BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$deteditVal = SalBasic::basiccalcview($request);
		$detedit['basic_amount'] = number_format($deteditVal[0]->basic_amount);
		$detedit['increment_amount'] = number_format($deteditVal[0]->increment_amount);
		$detedit['year_month_from'] = $deteditVal[0]->year_month_from;
		$detedit['totalmonth'] = $deteditVal[0]->total_month;
		$detedit['hra'] = number_format($deteditVal[0]->hra);
		$detedit['id'] = number_format($deteditVal[0]->id);
		$detedit['newStartDate'] = '';
		return view('BasicCalc.addedit',['request' => $request,
											'detedit' => $detedit]);
	}

	// public function addeditprocess(Request $request) {
	// 	// For update and Add
	// 	if($request->editcheck == 2 || $request->editcheck == 1){

	// 		$getOldBasicDet = SalBasic::basiccalcview($request);
	// 		if(count($getOldBasicDet) > 0){
	// 			$updateActiveFlg = SalBasic::fnUpdateActiveFlg($getOldBasicDet[0]->id);
	// 		}
	// 	}
		
	// 	$insert = SalBasic::fnbasicadd($request);
	// 	$getid = SalBasic::fngetid();
	// 	if($insert) {
	// 		Session::flash('success', 'Inserted Sucessfully!'); 
	// 		Session::flash('type', 'alert-success'); 
	// 	} else {
	// 		Session::flash('success', 'Inserted Unsucessfully!'); 
	// 		Session::flash('type', 'alert-danger'); 
	// 	}
		
	// 	Session::flash('id', $getid); 
	// 	Session::flash('Emp_ID', $request->Emp_ID);
	// 	Session::flash('firstname', $request->firstname);
	// 	Session::flash('lastname', $request->lastname);
	// 	return Redirect::to('BasicCalc/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	// }

	public function addeditprocess(Request $request) {

		$getid = '';
		// For Salary mail check
		$mailFlg = '';
		if($request->editcheck == 1) {
			$mailcheck = SalBasic::checkMailFlg($request);
			if (!empty($mailcheck)) {
				$mailFlg = $mailcheck[0]->mailFlg;
			}
		} 
		
		if($request->editcheck == 2 || $request->editcheck == 0 || $mailFlg == 1){
			$getOldBasicDet = SalBasic::basiccalcview($request);
			if(count($getOldBasicDet) > 0){
				$updateActiveFlg = SalBasic::fnUpdateActiveFlg($getOldBasicDet[0]->id);
			}

			$insert = SalBasic::fnbasicadd($request);
			$getid = SalBasic::fngetid();
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		} elseif($mailFlg == 0 || $mailFlg == ''){
			$update = SalBasic::fnbasicUpdate($request);
			$getid = $request->id;
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		
		Session::flash('id', $getid); 
		Session::flash('Emp_ID', $request->Emp_ID);
		Session::flash('firstname', $request->firstname);
		Session::flash('lastname', $request->lastname);
		return Redirect::to('BasicCalc/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function addBasic(Request $request) {
		if (!isset($request->Emp_ID)) {
			return Redirect::to('BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$detedit = array();
		$getOldBasicDet = SalBasic::basiccalcview($request);
		$newBasic = $getOldBasicDet[0]->basic_amount + $getOldBasicDet[0]->increment_amount;
		$detedit['basic_amount'] = number_format($newBasic);
		$detedit['increment_amount'] = 0;
		$detedit['totalmonth'] = $getOldBasicDet[0]->total_month;
		$detedit['hra'] = number_format($getOldBasicDet[0]->hra);
		$detedit['newStartDate'] = date('Y-m-d', strtotime('+1 day', strtotime($getOldBasicDet[0]->year_month_to)));
		$request->editcheck = 2;
		return view('BasicCalc.addedit',['request' => $request,
											'detedit' => $detedit]);
	}

	function update_mail(Request $request){
		$getid = SalBasic::fnupdateMail($request);
		print_r($getid);exit();
	}

}