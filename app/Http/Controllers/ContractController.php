<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers;
use App\Http\Eradate;
use App\Http\Requests;
use App\Model\contract;
use DB;
use Validator;
use Input;
use Session;
use Carbon;
use Config;
use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use PHPExcel_Worksheet_MemoryDrawing;
use Redirect;
use PHPExcel;
use PHPExcel_IOFactory;
use File;
class ContractController extends Controller {
	public function index(Request $request) {
		// FILTER DISABLED
		$disabledemp = '';
		$disabledres = '';
		if ($request->page=="") {
			$request->page = 1;
		}
		if ($request->plimit=="") {
			$request->plimit = 50;
		} 
		// FILTERING PROCESS
		if ($request->filterval == 1) {
			$disabledemp = "disabled fb pl1";
		} else if ($request->filterval == 2) {
			$disabledres = "disabled fb ";
		} else {
			$request->filterval = 1 ;
			$disabledemp = "disabled fb pl1";
		}
		// END FILTERING PROCESS
		// SORTING PROCESS
		if (!isset($request->contractsort) || $request->contractsort == "") {
			$request->contractsort = "Emp_ID";
		}
		if (empty($request->sortOrder)) {
			$request->sortOrder = "asc";
		}
		if ($request->sortOrder == "asc") {  
				$request->sortstyle = "sort_asc";
		} else {
				$request->sortstyle = "sort_desc";
		}
		$sortarray = [$request->contractsort=>$request->contractsort,
					'Emp_id'=>trans('messages.lbl_empid'),
					'LastName'=>trans('messages.lbl_empName'),
					'EndDate'=>trans('messages.lbl_pow'),
					'Contract_date'=>trans('messages.lbl_cd')] ;
		// END SORTING PROCESS
		// Sort Position
		if ($request->searchmethod == 1 || $request->searchmethod == 2) {
			$sortMargin = "margin-right:220px;";
		} else {
			$sortMargin = "margin-right:0px;";
		}

		$empArrVal = contract::contractindex($request);
		$contractdataVal = array();
		foreach ($empArrVal as $key => $value) {
			$contractdataVal[$value->Emp_id] = contract::fnGetAllContractDetails($value->Emp_id);
		}

		$contractdata = array();
		foreach ($contractdataVal as $key => $value) {
			if (isset($value[0])) {
				$contractdata[$key][] = (array)$value[0];
			} else {
				$contractdata[$key][] = (array)$value;
			}
		}
		
		return view('contract.index', ['sortarray' => $sortarray,
										'contractdata' => $contractdata,
										'empArrVal' => $empArrVal,
										'sortMargin' => $sortMargin,
										'disabledemp' => $disabledemp,
										'disabledres' => $disabledres,
										'request' => $request
									 ]);

	}
	public function viewlist(Request $request) {
		if (Session::get('contract_id') != "" && Session::get('contractid') != "") {
			$request->contract_id = Session::get('contract_id');
			$request->contractid = Session::get('contractid');
		}
		if(!isset($request->contractid) && !isset($request->contract_id)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$contractdetails = contract::getContractDetails($request,'10');
		$empdet = contract::getContractempDetails($request);
		return view('contract.viewlist', ['contractdetails' => $contractdetails,
										'empdet' => $empdet,
										'request' => $request]);
	}
	public function singleview(Request $request) {
		if(Session::get('contractid') !="" && Session::get('contract_id') != "" && Session::get('empname') !=""){
			$request->contract_id = Session::get('contract_id');
			$request->contractid = Session::get('contractid');
			$request->empname = Session::get('empname');
		}
		if(!isset($request->contractid) && !isset($request->contract_id)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$empdet = contract::getContractempDetails($request);
		$contractdetails = contract::getContractDetailsview($request,'1',$request->contractid,$request->contract_id);
		return view('contract.singleview', ['contractdetails' => $contractdetails,
											'empdet' => $empdet,
											'request' => $request]);

	}
	public function edit(Request $request) {
		if(!isset($request->contractid)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$detedit = contract::ContractDetedit($request);
		$detedit[0]->Salary = number_format($detedit[0]->Salary);
		$date1 = $detedit[0]->StartDate;
		$detedit[0]->check = 'checked';
		$date2= $detedit[0]->EndDate;
		$detedit[0]->numyear = ($detedit[0]->EndDate)-($detedit[0]->StartDate);
		$detedit[0]->Travel_Expense = number_format($detedit[0]->Travel_Expense);
		$detedit[0]->Accommodation = number_format($detedit[0]->Accommodation);
		$detedit[0]->Total = $detedit[0]->Total;
		return view('contract.addedit', ['detedit' => $detedit[0],
										'request' => $request]);
	}
	public function addedit(Request $request) {
		if(!isset($request->contractid)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		return view('contract.addedit',['request' => $request]);
	}
	public function addeditprocess(Request $request) {
		$data = Input::except(array('_token'));
		if(isset($request->editpage)) {
			$update = Contract::updateContractRec($request,$data);
			if($update) {
				Session::flash('message', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 

			}
		} else {
			$insert = Contract::insertcontractRec($request,$data);
			if($insert) {
				Session::flash('message', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		if(isset($request->editpage)) {
			if(isset($request->contract_id)) {
				$request->contract_id = $request->contract_id;
			} else {
				$request->contract_id = old('contract_id');
			}
			Session::flash('contract_id', $request->contract_id); 
			Session::flash('contractid', $request->contractid ); 
			Session::flash('empname', $request->empname); 
			return Redirect::to('contract/singleview?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		} else {
			$contractId = Contract::getlatContractDet($request);
			if (isset($contractId[0])) {
				Session::flash('contract_id', $contractId[0]->Id); 
				Session::flash('contractid', $contractId[0]->Emp_id); 
			}
			return Redirect::to('contract/viewlist?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
	}
	public function empcontractdownload(Request $request){
		$template_name = 'resources/assets/uploadandtemplates/templates/contract.xls';
		$tempname = $request->empname;
		$excel_name = $tempname;
		Excel::load($template_name, function($objTpl) use($request) {
			$get_emp_dtls = contract::getempdtls($request);
			$get_passport_dtls = contract::fnGetPassport($request);
			// For Names
			if(isset($get_emp_dtls[0])) {
			$objTpl->getActiveSheet()->setCellValue('D5', strtoupper($get_emp_dtls[0]->FirstName).' '.strtoupper($get_emp_dtls[0]->LastName));
			$objTpl->getActiveSheet()->setCellValue('D6', $get_emp_dtls[0]->KanaFirstName.' '.$get_emp_dtls[0]->KanaLastName);
			// Gender
			if($get_emp_dtls[0]->Gender == 1){
				$gender ="男[Male]";
			} else if($get_emp_dtls[0]->Gender == 2) {
				$gender  = "女[Female]";
			} else {
				$gender = "NIL";
			}
			$objTpl->getActiveSheet()->setCellValue('F5', $gender);
			}	
			// For Passport
			$objTpl->getActiveSheet()->setCellValue('D7', (isset($get_passport_dtls[0]->PassportNo) && $get_passport_dtls[0]->PassportNo != '')?$get_passport_dtls[0]->PassportNo:'');
			// For DOB & Age
			if(!empty($get_emp_dtls[0]->DOB)){
				$date_split= explode('-', $get_emp_dtls[0]->DOB);
				$dob = $date_split[0].' 年'.$date_split[1].'月'.$date_split[2].'日';
				//年齢
				$age_disp = floor((time() - strtotime($get_emp_dtls[0]->DOB))/31556926);
				$age = $age_disp.' 歳';
			} else {
				$dob  ='';
				$age='';
			}
			$objTpl->getActiveSheet()->setCellValue('D8', $dob);
			$objTpl->getActiveSheet()->setCellValue('F8', $age);
			// For Address
			$objTpl->getActiveSheet()->setCellValue('D9', isset($get_emp_dtls[0]->full_address) ? $get_emp_dtls[0]->full_address : "");
			//contract Details
			$get_cnrt_dtls = contract::getcontractdtls($request);
			if(!empty($get_cnrt_dtls)){
				// For Contract Date
				$Contract_date_sub = explode('-', $get_cnrt_dtls[0]->Contract_date);
				$wareki_contract = $Contract_date_sub[0].$Contract_date_sub[1].$Contract_date_sub[2];
				$contract_date = self::to_wareki($wareki_contract);
				$cont_date_sub = '['.$Contract_date_sub[0].'/'.$Contract_date_sub[1].'/'.$Contract_date_sub[2].']';
				$cont_date = $contract_date.'   '.$cont_date_sub;

				// For Period Of Work
				$StartDate_sub = explode('-', $get_cnrt_dtls[0]->StartDate);
				$wareki_startdate = $StartDate_sub[0].$StartDate_sub[1].$StartDate_sub[2];
				$start_date_war = self::to_wareki($wareki_startdate);
				$EndDate_sub = explode('-', $get_cnrt_dtls[0]->EndDate);
				$wareki_enddate = $EndDate_sub[0].$EndDate_sub[1].$EndDate_sub[2];
				$end_date_war = self::to_wareki($wareki_enddate);
				$pow1 = $start_date_war.' ～ '.$end_date_war;
				$pow2 = '    ['.$StartDate_sub[0].'/'.$StartDate_sub[1].'/'.$StartDate_sub[2].' to '.$EndDate_sub[0].'/'.$EndDate_sub[1].'/'.$EndDate_sub[2].']';
				
				$StartDate = $get_cnrt_dtls[0]->StartDate;
				$EndDate = $get_cnrt_dtls[0]->EndDate;
				$Salary = number_format($get_cnrt_dtls[0]->Salary);
				$Accommodation = number_format($get_cnrt_dtls[0]->Accommodation);
				$Total = number_format(str_replace(',', '', $get_cnrt_dtls[0]->Total)).' 円';
			} else {
				$cont_date  ='';
				$pow1 = '';
				$pow2 = '';
				$StartDate = "";
				$EndDate = "";
				$Salary = "";
				$Accommodation = "";
				$Total = "";
			}
			// For Period Of Work
			$objTpl->getActiveSheet()->setCellValue('D14', $pow1);
			$objTpl->getActiveSheet()->setCellValue('F14', $pow2);

			// For Date of Contract
			$objTpl->getActiveSheet()->setCellValue('D40', $cont_date);
			// For Salary
			$salary_row_alter = "基本給　  ".$Salary."　円　「月」";
			$objTpl->getActiveSheet()->setCellValue('D26', $salary_row_alter);
			// For Total
			$objTpl->getActiveSheet()->setCellValue('E26', "合　計（手当含む）　 ".$Total);
			// For Accomdation
			$objTpl->getActiveSheet()->setCellValue('D28', "通勤   「別途」       　　　　　住居 ".$Accommodation."　円");
			// For Image
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objTpl->setActiveSheetIndex(0);
			$gdImage = imagecreatefromjpeg('resources/assets/images/signImg/sign.jpg');
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample_image');
			$objDrawing->setDescription('Sample_image');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setCoordinates('F47');
			$objDrawing->setResizeProportional(true);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setWorksheet($objTpl->getActiveSheet());
			$doubleborder_array = array('D6','D7','D9','D10','B12','D16','D18','D20','D22','D24','D30','D32','D34','D36','D42','D43','D44');
			foreach ($doubleborder_array as $key => $value) {
				$objTpl->getActiveSheet()->getStyle($value)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
			}
			$objTpl->getActiveSheet()->getStyle('B36')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
			$objTpl->getActiveSheet()->getStyle('D36')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
			
			$objTpl->setActiveSheetIndex(0);
			$objTpl->getActiveSheet(0)->setSelectedCells('A1');
			$objTpl->getActiveSheet()->setTitle(strtoupper(isset($get_emp_dtls[0]->LastName)) ? $get_emp_dtls[0]->LastName : "");
			$flpath='.xls';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$flpath.'"');
			header('Cache-Control: max-age=0');
		})->setFilename($excel_name)->download('xls');
	}
	public function to_wareki($seireki) {
		//年月日を文字列として結合
		if ("18680125" <= $seireki && $seireki <= "19120729") {
			$gg = "明治";
			// 明治
			$meiji = (substr($seireki,0,4) - 1868)+1;
			if($meiji === 1 ) {
				$yy = "元";
			} else {
				$yy = $meiji;
			}
		} elseif ($seireki >= "19120730" && $seireki <= "19261224") {
			$gg = "大正";
			// 大正
			$taisho = (substr($seireki,0,4) - 1912)+1;
			if($taisho === 1 ) {
				$yy = "元";
			} else {
				$yy = $taisho;
			}
		} elseif ($seireki >= "19261225" && $seireki <= "19890107") {
			$gg = "昭和";
			// 昭和
			$showa = (substr($seireki,0,4) - 1926)+1;
			if($showa === 1 ) {
				$yy = "元";
			} else {
				$yy = $showa;
			}
		} elseif ( "19890108" <= $seireki && $seireki <= "20190430" ) {
			$gg = "平成";
			// 平成
			$heisei = (substr($seireki,0,4) - 1989)+1;
			if($heisei === 1 ) {
				$yy = "元";
			} else {
				$yy = $heisei;
			}
		} else if ($seireki >= "20190501") {
			$gg = "令和";
			// 平成
			$reiwa = (substr($seireki,0,4) - 2019)+1;
			if($reiwa === 1 ) {
				$yy = "元";
			} else {
				$yy = $reiwa;
			}
		}
	  	$wareki = "{$gg}　{$yy}年　".substr($seireki, 4, 2)."月　".substr($seireki, 6, 2)."日";
		return $wareki;
	}
	public function salarycertify(Request $request) {
		if(!isset($request->contractid) && !isset($request->contract_id)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$salarycertify = contract::getsalarycertifyhistory($request);
		$salarycertificate = contract::getscertifyhistory($request);
		$salarycertify[0]->DOJ = Helpers::toConvertDoubleByteValWareki(Helpers::fnYMChangeWareki(str_replace('-', '', $salarycertify[0]->DOJ))) . " (DOJ : " . str_replace('-', '/', $salarycertify[0]->DOJ) . " )";
		$salarycertify[0]->DOB = date('Y年 m月 d日', strtotime($salarycertify[0]->DOB));
		$today = Helpers::toConvertDoubleByteValWareki(Helpers::fnYMChangeWareki(date('Ymd')));
		return view('contract.salarycertify',['salarycertify' => $salarycertify[0],
											'salarycertificate' => $salarycertificate[0],
											'today' => $today,
											'request' => $request]);

	}
	public function salarycertifyhistory(Request $request) {
		if(!isset($request->contractid) && !isset($request->contract_id)){
			return Redirect::to('contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$salary = contract::getsalarycertifyhistory($request);
		$certifyhistory = contract::getcertifyhistory($request);
		return view('contract.salarycertifyhistory',['salary' => $salary,
													'certifyhistory' => $certifyhistory,
													'request' => $request]);
	}
	public function salarycertifydownload(Request $request) {
		$template_name = 'resources/assets/uploadandtemplates/templates/salarycertificate.xls';
		Excel::load($template_name, function($objTpl) use($request) {
			if(isset($request->reason)) {
				$salaryEmp = contract::getsalarycertifyhistory($request);
				$salarycertify = contract::getSalCertifyHistory($request);
				$reason = $request->reason;
			} else {
				$salaryEmp = contract::getsalarycertifyhistory($request);
				$salarycertify = contract::getscertifyhistory($request);
				$reason = $request->txt_reason;
			}
			if(!empty($salaryEmp)) {
				$FirstName = $salaryEmp[0]->FirstName;
				$LastName = $salaryEmp[0]->LastName;
			} else {
				$FirstName = "";
				$LastName = "";
			}
			$name_lower = $FirstName.' '.$LastName;
			$name = strtoupper($name_lower);
			if (!isset($request->flgchk) && $request->flgchk != 1) {
				$result1 = contract::getinsertcertifyhistory($request);
			}
			$DOB = '';
			$DOB = date('Y年 m月 d日', strtotime($salaryEmp[0]->DOB));
			$DOJ = '';
			$DOJ = Helpers::toConvertDoubleByteValWareki(Helpers::fnYMChangeWareki(str_replace('-', '', $salaryEmp[0]->DOJ))) . " (DOJ : " . str_replace('-', '/', $salaryEmp[0]->DOJ) . " )";
			$today = Helpers::toConvertDoubleByteValWareki(Helpers::fnYMChangeWareki(date('Ymd')));
			$Total = $salarycertify[0]->Total;
			$gender = $salaryEmp[0]->Gender;
			if ($gender =="1") { 
				$gen_val = "Male";
			} else { 
				$gen_val = "Female"; 
			}
			$objTpl->getActiveSheet()->setCellValue("B6",$name);
			$objTpl->getActiveSheet()->setCellValue("B8",$DOB);
			$objTpl->getActiveSheet()->setCellValue("B15",$request->doj);
			$objTpl->getActiveSheet()->setCellValue("F16", $Total);
			$objTpl->getActiveSheet()->setCellValue("B22",$reason);
			$objTpl->getActiveSheet()->setCellValue("F25",$today);
			if ($gender == 1) {
				$objTpl->getActiveSheet()->setCellValue('F9', $gen_val); // gen_val
				$objTpl->getActiveSheet()->setCellValue('G8', '･女');
				$objTpl->getActiveSheet()->setCellValue('F8', '');
			} else {
				$objTpl->getActiveSheet()->setCellValue('G9', $gen_val); // gen_val
				$objTpl->getActiveSheet()->setCellValue('F8', '男･');
			}
			$gdImage = imagecreatefromjpeg('resources/assets/images/signImg/sign.jpg');
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample_image');
			$objDrawing->setDescription('Sample_image');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setResizeProportional(true);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(50);
			$objDrawing->setCoordinates('H33');
			$objDrawing->setWorksheet($objTpl->getActiveSheet());
			// For Gender Image
			if ($gender == 1) {
				$gdImage = imagecreatefromjpeg('resources/assets/images/signImg/Male.jpg');
			} else {
				$gdImage = imagecreatefromjpeg('resources/assets/images/signImg/Female.jpg');
			} 
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample_image');
			$objDrawing->setDescription('Sample_image');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(25);
			if ($gender == 1) {
				$objDrawing->setCoordinates('F8');
			} else {
				$objDrawing->setCoordinates('G8');
			}
			$objDrawing->setWorksheet($objTpl->getActiveSheet());
			$objTpl->setActiveSheetIndex(0);
			$objTpl->getActiveSheet(0)->setSelectedCells('A1');
			// $objTpl->getActiveSheet()->setTitle(strtoupper($request->empname) . "_");
			$flpath='.xls';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$flpath.'"');
			header('Cache-Control: max-age=0');
		})->setFilename($request->empname . "_" . date("MY"))->download('xls');
	}
}