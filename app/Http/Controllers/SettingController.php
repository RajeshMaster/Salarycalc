<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Setting;

use App\Model\Document;

use session;

use Redirect;

use App\Http\Common\settingscommon;

use Excel;

use PHPExcel_Worksheet_PageSetup;

use PHPExcel_Style_Fill;

use PHPExcel_IOFactory;

use PHPExcel_Shared_Date;

use ExcelToPHPCal;

use PHPExcel_Reader_Excel5;

use Input;



class SettingController extends Controller {

	function index(Request $request) { 

		return view('Setting.index',['request'=> $request]);

	}



	function singletextpopup(Request $request) {

		$getTableFields = settingscommon::getDbFieldsforProcess();

		if (($request->location == 2) && ($request->tablename == "mstbanks") ) {

			$tablename = $request->tablename.$request->location;

		} else {

			$tablename = $request->tablename;

		}

	 	$query = setting::selectOnefieldDatas($getTableFields[$tablename]['selectfields'],

	 										  $getTableFields[$tablename]['commitfields'][0],

	 										  $request);

		$requestAsJSONArray = json_encode($request->all());

		$headinglbl = $getTableFields[$tablename]['labels']['heading'];

		$field1lbl = $getTableFields[$tablename]['labels']['field1lbl'];

		$selectfiled  = $getTableFields[$tablename]['selectfields'];

		return view('Setting.singletextpopup',['getdetails' => $query,

												'request'=>$request,

												'headinglbl'=>$headinglbl,

												'field1lbl' => $field1lbl,

												'selectfiled' => $selectfiled,

												'getTableFields'=> $getTableFields,

												'requestAsJSONArray' => $requestAsJSONArray]);

	}

	

	function SingleFieldaddedit(Request $request) {

		if ($request->flag == 2) {

	 		echo $update_query=Setting::updateSingleField($request);

	 		exit();

		} 

		$tbl_name = $request->tablename;

		if (!empty($request->location)) {

			$location = $request->location;

			$orderidval = Setting::Orderidgenerateforbank($location,$tbl_name);

			// echo $orderid = $orderidval+1;

	 		// $ins_query=Setting::insertqueryforbank($tbl_name,$request);

	 		$orderidarray['orderid'] = $orderidval+1;

	 		$ins_query=Setting::insertqueryforbank($tbl_name,$request);

	 		$orderidval = Setting::Orderidgeneratefortotal($location,$tbl_name);

	 		$orderidarray['totalid'] = $orderidval;

	 		echo json_encode($orderidarray);

		} else {

			$orderidval = Setting::Orderidgenerate($tbl_name);

	 		$orderidarray['orderid'] = $orderidval+1;

	 		$ins_query=Setting::insertquery($tbl_name,$request);

	 		$location="";

	 		$orderidval = Setting::Orderidgenerateforbranchtotal($location,$tbl_name);

	 		$orderidarray['totalid'] = $orderidval;



	 		echo json_encode($orderidarray);



		}

	}

	public static function onetextpopup(Request $request) {

		$tbl_name = $request->tablename;

		$getTableFields = settingscommon::getDbFieldsforProcess();

		$query = setting::selectOnefieldDatasForVisa($getTableFields[$tbl_name]['selectfields'],

											  $getTableFields[$tbl_name]['commitfields'][0],

											  $request);

		$requestAsJSONArray = json_encode($request->all());

		$headinglbl = $getTableFields[$tbl_name]['labels']['heading'];

		$field1lbl = $getTableFields[$tbl_name]['labels']['field1lbl'];

		$selectfiled  = $getTableFields[$tbl_name]['selectfields'];

		return view('Setting.onefieldpopup',['query' => $query,

												'request'=>$request,

												'headinglbl'=>$headinglbl,

												'field1lbl' => $field1lbl,

												'selectfiled' => $selectfiled,

												'getTableFields'=> $getTableFields,

												'requestAsJSONArray' => $requestAsJSONArray]);

	}

	public static function twotextpopup(Request $request) {

		$tbl_name = $request->tablename;

		$getTableFields = settingscommon::getDbFieldsforProcess();

		$query = setting::selectOnefieldDatas($getTableFields[$tbl_name]['selectfields'],

											  $getTableFields[$tbl_name]['commitfields'][0],

											  $request);

		$requestAsJSONArray = json_encode($request->all());

		$headinglbl = $getTableFields[$tbl_name]['labels']['heading'];

		$field1lbl = $getTableFields[$tbl_name]['labels']['field1lbl'];

		$field2lbl = $getTableFields[$tbl_name]['labels']['field2lbl'];

		$selectfiled  = $getTableFields[$tbl_name]['selectfields'];

		return view('Setting.twofieldpopup',['query' => $query,

												'request'=>$request,

												'headinglbl'=>$headinglbl,

												'field1lbl' => $field1lbl,

												'field2lbl' => $field2lbl,

												'selectfiled' => $selectfiled,

												'getTableFields'=> $getTableFields,

												'requestAsJSONArray' => $requestAsJSONArray]);

	}

	public static function companyDetailsReg(Request $request) {
		echo $request->id;
		$usenotuse = "ok";
	}

	function oneFieldaddedit(Request $request) {

		if ($request->flag == 2) {

	 		$idAvailableCheck = Document::checkIdAvailableToUpdate($request->id);
	 		if (count($idAvailableCheck) == 0) {
	 			$update_query=Setting::updateoneField($request);
	 		} else {
	 			$update_query = "";
	 		}

	 		echo $update_query;

	 		// echo $update_query=Setting::updateoneField($request);

	 		// exit();

		} else {

			$tbl_name = $request->tablename;

			$orderidval = Setting::Orderidgenerate($tbl_name);

		 	$orderid = $orderidval;

		 	$ins_query=Setting::insertqueryonefield($tbl_name,$request,$orderid);

		 	echo $orderid;

		}

	}

	function twoFieldaddedit(Request $request) {

		if ($request->flag == 2) {

	 		echo $update_query=Setting::updatetwoField($request);

	 		exit();

		}

		$tbl_name = $request->tablename;
		// Start 2020-06-08 Updated by Easa
		if (!empty($request->location)) {

			$location = $request->location;

			$orderidval = Setting::Orderidgenerateforbank($location,$tbl_name);

			// echo $orderid = $orderidval+1;

	 		// $ins_query=Setting::insertqueryforbank($tbl_name,$request);

	 		$orderidarray['orderid'] = $orderidval+1;

	 		$ins_query=Setting::insertqueryforsalary($tbl_name,$request);

	 		$orderidval = Setting::Orderidgeneratefortotal($location,$tbl_name);

	 		$orderidarray['totalid'] = $orderidval;

	 		echo json_encode($orderidarray);

		// End 2020-06-08 Updated by Easa
		} else {

			$orderidval = Setting::Orderidgenerate($tbl_name);

		 	echo $orderid = $orderidval;

		 	$ins_query=Setting::insertquerytwofield($tbl_name,$request,$orderid);

		}

	}

	function selectthreefieldDatas(Request $request) {

		$getTableFields = settingscommon::getDbFieldsforProcess();

		$tablename = $request->tablename;

		$query = Setting::selectOnefieldDatas($getTableFields[$tablename]['selectfields'],

											  $getTableFields[$tablename]['commitfields'][0],

											  $request);


		$requestAsJSONArray = json_encode($request->all());

		$headinglbl = $getTableFields[$tablename]['labels']['heading'];

		$field1lbl = $getTableFields[$tablename]['labels']['field1lbl'];

		$field2lbl = $getTableFields[$tablename]['labels']['field2lbl'];

		$field3lbl = $getTableFields[$tablename]['labels']['field3lbl'];

		$selectfiled  = $getTableFields[$tablename]['selectfields'];

		return view('Setting.selectthreefieldDatas',['query'=>$query,

												'request'=>$request,

												'headinglbl'=>$headinglbl,

												'field1lbl' => $field1lbl,

												'field2lbl' => $field2lbl,

												'field3lbl' => $field3lbl,

												'selectfiled' => $selectfiled,

												'getTableFields'=> $getTableFields,

												'requestAsJSONArray' => $requestAsJSONArray]);

	}

	function threeFieldaddeditforbank(Request $request) {

		if ($request->flag == 2) {

	 		echo $update_query=Setting::updatethreeField($request);

	 		exit();

		} 

		$location = $request->location;

		$tbl_name = $request->tablename;

		if (!empty($location)) {

			$orderidval = Setting::Orderidgenerateforbranch($tbl_name,$location);

	 		$orderid = $orderidval+1;



	 		// $orderidarray['orderid'] = $orderidval+1;

	 		// $ins_query=Setting::insertqueryforbranch($tbl_name,$request);

	 		$ins_query=Setting::insertqueryforbranch($tbl_name,$request);

	 		$orderidval = Setting::Orderidgenerateforbranchtotal($location,$tbl_name);

	 		$orderidarray['totalid'] = $orderidval;

	 		$orderidarray['orderid'] = $orderid;

	 		

	 		echo json_encode($orderidarray);



		}

	}

	function threeFieldaddedit(Request $request) {

		if ($request->flag == 2) {

	 		echo $update_query=Setting::updatethreeField($request);

	 		exit();

		} 

		$tbl_name = $request->tablename;

		$orderidval = Setting::Orderidgeneratetext($tbl_name);
	 	$ins_query=Setting::insertqueryforbranch($tbl_name,$request);
		$lastid = Setting::Orderidgenerateforthreetext($tbl_name);

	 	$orderidarray['totalid'] = $lastid;
	 	// echo $orderid = $orderidval+1;
	 	$orderidarray['orderid'] = $orderidval+1;


	 		echo json_encode($orderidarray);
	}


	function useNotuse(Request $request) {

		$usenotuse = setting::updateUseNotUse($request);

	}

	public static function eighttextpopup(Request $request) {
		$response = array();
		$tbl_name = $request->tablename;
		$result = "";
		if (isset($request->id)) {
			$result = setting::getInsertUpdateCompanyDetails($request, $tbl_name);
		}
		

		$getTableFields = settingscommon::getDbFieldsforProcess();

		$query = setting::selectEightfieldDatas($getTableFields[$tbl_name]['selectfields'],

											  $getTableFields[$tbl_name]['commitfields'][0],

											  $request);
		$response['queryResult'] = $result;
	
		// $response['recordCnt'] = count($query);
	
		$requestAsJSONArray = json_encode($request->all());

		$headinglbl = $getTableFields[$tbl_name]['labels']['heading'];

		$field1lbl = $getTableFields[$tbl_name]['labels']['field1lbl'];

		$field2lbl = $getTableFields[$tbl_name]['labels']['field2lbl'];

		$selectfields  = $getTableFields[$tbl_name]['selectfields'];

		return view('Setting.eightfieldpopup',['query' => $query,

												'request'=>$request,

												'headinglbl'=>$headinglbl,

												'field1lbl' => $field1lbl,

												'field2lbl' => $field2lbl,

												'selectfields' => $selectfields,

												'getTableFields'=> $getTableFields,

												'response'=> $response,

												'requestAsJSONArray' => $requestAsJSONArray]);

	}

}