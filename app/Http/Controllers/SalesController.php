<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Sales;

use App\Model\Visa;

use DB;

use Input;

use Redirect;

use Config;

use Session;

use Illuminate\Support\Facades\Validator;


class SalesController extends Controller {

	function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		$salesDetails = Sales::fnGetSalesDetails($request);

		return view('Sales.index',['salesDetails' => $salesDetails,
										'request' => $request]);

	}

	public function addeditpopup(Request $request) {

        return view('Sales.addeditpopup',['request' => $request]);

    }

    public function addeditpopupEdit(Request $request) {

      $idVal = Sales::getSales($request);

      $salesVal = array();
      if (isset($idVal[0])) {
	      $salesVal['period'] = $idVal[0]->period;
	      $salesVal['salesAmount'] = $idVal[0]->salesAmount;
      }

      return view('Sales.addeditpopup',['salesVal' => $salesVal,
                                         'request' => $request]);
    }

    public function addedit(Request $request) {

		if($request->editpage == "addpage") {
			$insert = Sales::salesInsert($request);
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success');
			} else {
				Session::flash('success', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		
		} else if($request->editpage == "editpage") {
			$update = Sales::salesUpdate($request);
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('success', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		
		return Redirect::to('Sales/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));

	}

}