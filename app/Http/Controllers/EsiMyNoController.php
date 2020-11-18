<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\EsiMyNo;

use DB;

use Input;

use Redirect;

use Config;

use Session;

use Illuminate\Support\Facades\Validator;


class EsiMyNoController extends Controller {

	function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->esiMyNoSort == "") {
        	$request->esiMyNoSort = "Emp_ID";
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

		$empArrVal =EsiMyNo::fnGetAllEmpDetails($request);

		$esiMyNoData = array();
		foreach ($empArrVal as $key => $value) {
			$esiMyNoData[$key]['Emp_ID'] = $value->Emp_ID;
			$esiMyNoData[$key]['FirstName'] = $value->FirstName;
			$esiMyNoData[$key]['LastName'] = $value->LastName;

			$esiMyNo = EsiMyNo::fnGetEsiMyNoDetails($value->Emp_ID);
			$esiMyNoData[$key]['myNo'] = (isset($esiMyNo[0]->myNo)) ? $esiMyNo[0]->myNo : "";
			$esiMyNoData[$key]['esiRegDate'] = (isset($esiMyNo[0]->esiRegDate)) ? $esiMyNo[0]->esiRegDate : "";
			$esiMyNoData[$key]['esiNo'] = (isset($esiMyNo[0]->esiNo)) ? $esiMyNo[0]->esiNo : "";
		}

		return view('EsiMyNo.index',['esiMyNoData' => $esiMyNoData,
										'array' => $array,
										'empArrVal' => $empArrVal,
										'sortMargin' => $sortMargin,
										'request' => $request]);

	}

	public function addEdit(Request $request) {
        $empdetails = EsiMyNo::fnGetEmpDetails($request);

        $detedit = array();
        $detedit = EsiMyNo::fnGetEsiMyNoDetails($request->Emp_ID);

        return view('EsiMyNo.addedit', ['empdetails' => $empdetails[0],
		                               'detedit' => (isset($detedit[0])) ? $detedit[0] : "",
		                               'request' => $request]);
    }

	public function addeditprocess(Request $request) {

		if ($request->myNo != "") {
			$myNoArr = str_split(preg_replace('/[^0-9]/', '', $request->myNo));
			$myNo = "";
			foreach ($myNoArr as $key => $value) {
				if ($key <= 11) {
					if ($key == 4 || $key == 8) {
						$myNo = $myNo.' '.$value;
					} else {
						$myNo .= $value;
					}
				}
			}
			$request->myNo = $myNo;
		}

		if ($request->esiNo != "") {

			if (!preg_match('/[^a-zA-Z\d]/', $request->esiNo)) {

				$esiNoArr = str_split(preg_replace('/[^0-9]/', '', $request->esiNo));
				$esiNo = "";
				foreach ($esiNoArr as $key => $value) {
					if ($key <= 11) {
						if ($key == 4 || $key == 10) {
							$esiNo = $esiNo.'-'.$value;
						} else {
							$esiNo .= $value;
						}
					}
				}
				$request->esiNo = $esiNo;
			}
		}
		
		$update = EsiMyNo::insertOrUpdate($request);
		if($update) {
          Session::flash('message', 'Updated Sucessfully!'); 
          Session::flash('type', 'alert-success'); 
        } else {
          Session::flash('message', 'Updated Unsucessfully!'); 
          Session::flash('type', 'alert-danger'); 
        }

        return Redirect::to('EsiMyNo/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
        
    }


}