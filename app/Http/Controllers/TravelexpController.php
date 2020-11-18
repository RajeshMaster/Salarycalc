<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Travelexp;
use Input;
use App\Http\Helpers;
use Validator;
use Redirect;
use Session;
use DB;
use Crypt;
use stdClass;
use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use Config;
use Carbon\Carbon;

class TravelexpController extends Controller
{
    public function index(Request $request) {

      if(Session::get('Travelexpselmon') !=""){
        $request->selMonth = Session::get('Travelexpselmon');
        $request->selYear = Session::get('Travelexpselyr');
      }
      $date = Travelexp::fnGetLocalTravelCalenderBar($request);
      $total_yrs = array(); 
      if ($date[0] != "") {
        $prev_yrs = $date[0];
        $total_yrs1 = array_unique($date[1]);
        asort($total_yrs1);
        foreach ($total_yrs1 AS $key => $value) {
          array_push($total_yrs, $value);
        }
      } else {
        $prYrMn =explode('-', date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01')))));
        $prev_yrs=$prYrMn[1];
        array_push($total_yrs, $prYrMn[0]);
      }
      if(Session::get('pass_date') !=""){
       $prYrMn =explode('-',Session::get('pass_date'));
       $request->pass_date = Session::get('pass_date');
       $cur_month = $prYrMn[1];
       $cur_year= $prYrMn[0];
      } else {
       $cur_month=date('m')-1;
       $cur_year=date('Y');
      }
      $curtime = date('YmdHis');
      if ($cur_month == 0) {
        $cur_year = $cur_year - 1;
        $cur_month = 12;
      }
      if (isset($request->selMonth) && !empty($request->selMonth)) {
        $selectedMonth=$request->selMonth;
        $selectedYear=$request->selYear;
        $cur_month=$selectedMonth;
        $cur_year=$selectedYear;
      } else {
        $selectedMonth=$cur_month;
        $selectedYear=$cur_year;
      }
      $request->selMonth=$selectedMonth;
      $request->selYear=$selectedYear;
      /*if(Session::get('pass_date') !=""){
        $prYrMn =explode('-',Session::get('pass_date'));
        $request->pass_date = Session::get('pass_date');
        $cur_month = $prYrMn[1];
      }else {*/
         $pass_date = $selectedYear . "-" . substr("0" . $selectedMonth, -2);
         $request->pass_date = $pass_date;
      // $travelamout = Travelexp::fetchloctraveltot($pass_date);
      // $employees = Travelexp::index($request,$pass_date);
      if(Session::get('Travelexpempid') !=""){
        $request->selMonth = Session::get('Travelexpselmon');
        $request->selYear = Session::get('Travelexpselyr');
        $request->traexpid = Session::get('Travelexpempid');
        $request->pass_date = Session::get('Travelpass_date');
        $prYrMn =explode('-',Session::get('Travelpass_date'));
        $cur_month = $prYrMn[1];
      } else {
        $request->selMonth=substr($request->pass_date, 5, 2);
        $request->selYear=substr($request->pass_date, 0, 4);
      }
      $travelamout = Travelexp::fetchloctraveltot($pass_date);
      $employees = Travelexp::index($request,$pass_date);
      return view('travelexp.index', ['request' => $request,
                                      'prev_yrs' => $prev_yrs,
                                      'cur_year' => $cur_year,
                                      'cur_month' => $cur_month,
                                      'total_yrs' => $total_yrs,
                                      'curtime' => $curtime,
                                      'pass_date' => $pass_date,
                                      'travelamout' => $travelamout,
                                      'employees' => $employees]);
    }

    public function regpopup(Request $request) {
      $paiddate = Travelexp::paiddate($request);
      return view('travelexp.regpopup', ['paiddate' => $paiddate[0],
                                         'request' => $request]);
    }

    public function addeditpd(Request $request) {
      $updatepaidsate = Travelexp::updatepaidsate($request);
      if($updatepaidsate) {
        Session::flash('message', 'Updated Sucessfully!'); 
        Session::flash('type', 'alert-success');
      } else {
        Session::flash('type', 'Updated Unsucessfully!'); 
        Session::flash('type', 'alert-danger'); 
      }
      Session::flash('Travelexpselmon', $request->selMonth);
      Session::flash('Travelexpselyr', $request->selYear); 
      return Redirect::to('Travelexp/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
    }


    public function view(Request $request) {

      if(Session::get('Travelexpempid') !=""){
        $request->selMonth = Session::get('Travelexpselmon');
        $request->selYear = Session::get('Travelexpselyr');
        $request->traexpid = Session::get('Travelexpempid');
        $request->pass_date = Session::get('Travelpass_date');
      } else {
        $request->selMonth=substr($request->pass_date, 5, 2);
        $request->selYear=substr($request->pass_date, 0, 4);
      }
      if (isset($request->flagval)) {
          $request->selMonth = date('m');
          $request->selYear = date('Y');
          $request->pass_date = date('Y-m');
      }
      if(!isset($request->traexpid) && !isset($request->pass_date)){
        // return $this->index($request);
        return Redirect::to('totalexp/index?mainmenu=TotalExpenses&time='.date('YmdHis'));
      }
      if($request->travelid != "" && $request->useflg != ""){
        $usenotuse = Travelexp::usenotuse($request);
      }
      if($request->subcnfm != ""){
        if($request->subcnfm == 1){
          $subcnfm = Travelexp::submitrec($request);
          if($subcnfm) {
            Session::flash('message', 'Submitted Sucessfully!'); 
            Session::flash('type', 'alert-success');
          } else {
            Session::flash('type', 'Submitted Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
        } else {
          $subcnfm = Travelexp::confirmrec($request);
          if($subcnfm) {
            Session::flash('message', 'Confirmed Sucessfully!'); 
            Session::flash('type', 'alert-success');
          } else {
            Session::flash('type', 'Confirmed Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
        }
      }
      $employees = Travelexp::getlocaltravelemp($request);
      $exelcount = Travelexp::getlocaltravelempwomp($request);
      $fnGetEmpDetails = Travelexp::fnGetEmpDetails($request);
      $prevyears = Travelexp::fnprevyears($request);
      $nextyears = Travelexp::fnnextyears($request);
      $prevcount = count($prevyears);
      if($prevcount == 0) {
        $preval = '0';
      } else {
        $preval = end($prevyears[0]);
      }
      $nextcount = count($nextyears);
      if($nextcount == 0) {
        $nextval = '0';
      } else {
        $nextval = end($nextyears[0]);
      }
      return view('travelexp.details', ['employees' => $employees,
                                        'fnGetEmpDetails' => $fnGetEmpDetails,
                                        'preval' => $preval,
                                        'prevcount' => $prevcount,
                                        'nextval' => $nextval,
                                        'nextcount' => $nextcount,
                                        'exelcount' => $exelcount,
                                        'request' => $request]);
    }
    public function history(Request $request) {
      if (!isset($request->travelsort)) {
        $request->travelsort = "date";
      }
      if (!isset($request->sortOrder)) {
        $request->sortOrder = "desc";
      }
      if ($request->sortOrder == "asc") {
        $request->sortstyle="sort_asc";
      } else {
        $request->sortstyle="sort_desc";
      }
      $sortarray = [$request->travelsort=>$request->travelsort,
                    'date'=>trans('messages.lbl_date'),
                    'client'=>trans('messages.lbl_client'),
                    'Amount'=>trans('messages.lbl_amount')] ;
      if(!isset($request->traexpid) && !isset($request->pass_date)){
        // return $this->index($request);
        return Redirect::to('totalexp/index?mainmenu=TotalExpenses&time='.date('YmdHis'));
      }
      if(!isset($request->indexplimit) && $request->indexplimit == "" ){
        $request->indexplimit = $request->plimit;
        $request->indexpage = $request->page;
        $request->plimit = 100;
        $request->page = '';
      }
      $history = Travelexp::history($request);
      $historygrandtotal = Travelexp::historygrandtotal($request);
      $fnGetEmpDetails = Travelexp::fnGetEmpDetails($request);
      $empdetails=array();
      $i = 0;
      foreach($history as $key=>$emp) {
          $empdetails[$i]['id'] = $emp->id;
          $empdetails[$i]['date_month'] = $emp->date_month;
          $empdetails[$i]['date'] = $emp->date;
          $empdetails[$i]['others'] = $emp->others;
          $empdetails[$i]['client'] = $emp->client;
          $empdetails[$i]['mode_of_travel'] = $emp->mode_of_travel;
          $empdetails[$i]['travel_from'] = $emp->travel_from;
          $empdetails[$i]['travel_to'] = $emp->travel_to;
          $empdetails[$i]['totalval'] = $emp->totalval;
          $historymnthtotal = Travelexp::historymnthtotal($emp->Emp_ID,$emp->date_month);
          foreach($historymnthtotal as $key=>$monthtot) {
            $empdetails[$i]['SUM'] = $monthtot->SUM;
          }
          $i++;
      }
      return view('travelexp.history', ['history' => $history,
                                        'sortarray' => $sortarray,
                                        'fnGetEmpDetails' => $fnGetEmpDetails,
                                        'historygrandtotal' => $historygrandtotal,
                                        'empdetails' => $empdetails,
                                        'request' => $request]);
    }
    public function addedit(Request $request) {
      if (Session::get('languageval') == "en") {
        $travel_mode_array = array(1 => "Train", 2 => "Subway", 3 => "Bus", 4 => "Taxi", 
                       6 => "Train & Bus", 5 => "Others");
      } else {
        $travel_mode_array = array(1 => "電車", 2 => "地下鉄", 3 => "バス", 4 => "タクシー", 6 => "電車とバス", 5 => "その他");
      }
      if(!isset($request->traexpid) && !isset($request->pass_date)){
        return $this->index($request);
      }
       $current_year = date('Y');
      $current_month = date('m');
      $curnt_date = date('d');
      $last_year_month = date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01'))));
      $split_last_month = explode('-', $last_year_month);
      $last_year_month_maxdate = date('t', strtotime("-1 months", strtotime(date('Y-m-01'))));

      $prev_month_flg = self::isdofsubmission($request, $last_year_month);
      $prev_month_flg1 = self::isdofsubmission($request, date('Y-m'));
      $revert_flg = self::isrevert($request, $last_year_month);
      $last_year = $split_last_month[0];
      $last_month = $split_last_month[1];
      if ($prev_month_flg) {
        $last_year = $current_year;
        $last_month = $current_month;
        $last_year_month_maxdate = date('t', strtotime(date('Y-m-01')));
      }
      if ($prev_month_flg1) {
        $current_year = $request->last_year;
      }
      $amountfield = "";
      if (!empty($request->eamount)) {
          $amountfield = $request->eamount; 
      }
      $pre_month_flg = Travelexp::getdof($request);
      if($pre_month_flg) {
        if($pre_month_flg[0]->dofsubmission) {
          $month_array = array(date('n') => date('n')." 月");
        } else {
          $month_array = array(date('n', strtotime('-1 month')) => date('n', strtotime('-1 month'))." 月",date('n') => date('n')." 月");
        }
      } else {
          $month_array = array(date('n', strtotime('-1 month')) => date('n', strtotime('-1 month'))." 月",date('n') => date('n')." 月");
      }
      $fnGetEmpDetails = Travelexp::fnGetEmpDetails($request);
      return view('travelexp.addedit', ['travel_mode_array' => $travel_mode_array,
                                        'month_array' => $month_array,
                                        'prev_month_flg' => $prev_month_flg,
                                        'curnt_date' => $curnt_date,
                                        'fnGetEmpDetails' => $fnGetEmpDetails,
                                        'amountfield' => $amountfield,
                                        'revert_flg' => $revert_flg,
                                        'request' => $request]);
    }
    public static function isdofsubmission($request, $pass_date) {
      $get_details = Travelexp::dateofsub($request,$pass_date);
      $prev_month_flg = false;
      if(isset($get_details['0']->dofsubmission)) {
        if (!empty($get_details['0']->dofsubmission) && ($get_details['0']->dofsubmission != "0000-00-00")) {
          $prev_month_flg = true;
        }
      }
      return $prev_month_flg;
    }
    public static function isrevert($request, $pass_date) {
      $get_details = Travelexp::dateofsub($request,$pass_date);
      $revertFlg = false;
      if(isset($get_details['0']->revertFlg)) {
        if ($get_details['0']->revertFlg == 1) {
          $revertFlg = true;
        }
      }
      return $revertFlg;
    }
    public function formValidation(Request $request) {
      // print_r(json_encode($request->amount));exit;
        $rulesAppendmot = array();
        $rulesAppendtd = array();
        $rulesAppendtrip = array();
        $after = date('Y-m-d', strtotime(' +1 day'));
      // print_r(json_encode($request->amount));exit;
        if ($request->mode_of_travel == 5) {
          $rulesAppendmot = array(
               'others' => 'required',
                 );
        }
        if ($request->datselvalrad == 1) {
          $rulesAppendtd = array(
               'date' => 'required|date|before:' . $after,
                 );
        } else {
          $rulesAppendtd = array(
               'multi_date' => 'required',
                 );
        }
        if ($request->tripselvalrad == 3 && $request->date != "") {
          $rulesAppendtrip = array(
               'enddate' => 'required|date',
                 );
        }
      // print_r(json_encode($request->amount));exit;
        $commonRules = array(
           'trip' => 'required',
           'dateselection' => 'required', 
           'client' => 'required',
           'amount' => 'required',
           'mode_of_travel' => 'required',
           'travel_from' => 'required',
           'travel_to' => 'required',
             );
        $customizedNames = array(
           'trip' => trans('messages.lbl_traveltrip'),
           'date' => trans('messages.lbl_traveldate'), 
           'amount' => trans('messages.lbl_amount'), 
           'enddate' => trans('messages.lbl_traveldate'),
           'dateselection' => trans('messages.lbl_dateselection'),
           'client' => trans('messages.lbl_placepurpose'),
           'mode_of_travel' => trans('messages.lbl_modeoftravel'),
           'travel_from' => trans('messages.lbl_travelfrom'),
           'travel_to' => trans('messages.lbl_travelto'),
        );
      $rules=$rulesAppendtrip+$rulesAppendtd+$rulesAppendmot+$commonRules;
      // print_r(json_encode($rules));exit;
      $validator = Validator::make($request->all(), $rules);
      $validator->setAttributeNames($customizedNames);
      // print_r(json_encode($validator));exit;
      if ($validator->fails()) {
         // If validation falis redirect back to Register Screen.
          return response()->json($validator->messages(), 200);exit;
      } else {
        $success = true;
        echo json_encode($success);exit;
      }
    }
    public function addeditprocess(Request $request) {
      if (isset($request->localtravel)) {
        $updatedelflag = Travelexp::fntoupdatedelflag($request);
      }
      $register = Travelexp::register($request);
      if($register) {
        Session::flash('message', 'Registered Sucessfully!'); 
        Session::flash('type', 'alert-success');
      } else {
        Session::flash('type', 'Registered Unsucessfully!'); 
        Session::flash('type', 'alert-danger'); 
      }
      if($request->dateselection == 1 ) {
        if($request->trip == 3 ) {
          $dateval = date('Y-m-d');
        } else {
          $dateval = $request->date;
        }
      } else {
        $multidates = explode(",",$request->multi_date);
        $dateval = $multidates[count($multidates) - 1];
      }
      Session::flash('Travelexpempid', $request->traexpid);
      Session::flash('Travelexpempid', $request->traexpid);
      Session::flash('Travelpass_date', substr($dateval, 0, 7) );
      Session::flash('Travelexpselmon', substr($dateval, 5, 2) );
      Session::flash('Travelexpselyr', substr($dateval, 0, 4) );
      return Redirect::to('Travelexp/view?mainmenu=expenses_travel&time='.date('YmdHis'));
    }
    public function Detedit(Request $request) {
      if(!isset($request->travelid)){
        return (new static)->index($request);
      }
      if (Session::get('languageval') == "en") {
        $travel_mode_array = array(1 => "Train", 2 => "Subway", 3 => "Bus", 4 => "Taxi", 
                       6 => "Train & Bus", 5 => "Others");
      } else {
        $travel_mode_array = array(1 => "電車", 2 => "地下鉄", 3 => "バス", 4 => "タクシー", 6 => "電車とバス", 5 => "その他");
      }
      $prev_month_flg = Travelexp::getdof($request);
      $detedit = Travelexp::detedit($request);
      $detedit[0]->amount = number_format($detedit[0]->amount);
      if (!empty($detedit[0]->month)) {
        $month_exp = explode('-', $detedit[0]->month);
        $request->month = $month_exp[1];
      }
      if($prev_month_flg) {
        if($prev_month_flg[0]->dofsubmission) {
          $month_array = array(date('n') => date('n')." 月");
        } else {
          $month_array = array(date('n', strtotime('-1 month')) => date('n', strtotime('-1 month'))." 月",date('n') => date('n')." 月");
        }
      } else {
          $month_array = array(date('n', strtotime('-1 month')) => date('n', strtotime('-1 month'))." 月",date('n') => date('n')." 月");
      }
      $fnGetEmpDetails = Travelexp::fnGetEmpDetails($request);
      return view('travelexp.addedit', ['travel_mode_array' => $travel_mode_array,
                                        'month_array' => $month_array,
                                        'fnGetEmpDetails' => $fnGetEmpDetails,
                                        'detedit' => $detedit[0],
                                        'request' => $request]);
    }
    public function edit(Request $request) {
      $register = Travelexp::editrec($request);
      if($register) {
        Session::flash('message', 'Updated Sucessfully!'); 
        Session::flash('type', 'alert-success');
      } else {
        Session::flash('type', 'Updated Unsucessfully!'); 
        Session::flash('type', 'alert-danger');
      }
      Session::flash('Travelexpempid', $request->traexpid);
      Session::flash('Travelexpempid', $request->traexpid);
      Session::flash('Travelpass_date', substr($request->date, 0, 7) );
      Session::flash('Travelexpselmon', substr($request->date, 5, 2) );
      Session::flash('Travelexpselyr', substr($request->date, 0, 4) );
      return Redirect::to('Travelexp/view?mainmenu=expenses_travel&time='.date('YmdHis'));
    }
    public function Download(Request $request) {
      $template_name = 'resources/assets/uploadandtemplates/templates/local_travel_expenses.xls';
      Excel::load($template_name, function($objPHPExcel) use($request) {
      $employees = Travelexp::getlocaltravelempwomp($request);
      $fnGetEmpDetails = Travelexp::fnGetEmpDetails($request);
      $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active
      $objPHPExcel->getActiveSheet()->setCellValue("E5", substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月');
      $objPHPExcel->getActiveSheet()->setCellValue("E6",Helpers::fnYMChangeWareki(preg_replace('/-/', '', $employees[0]->dofsubmission)) );
      $objPHPExcel->getActiveSheet()->setCellValue("E7", $employees[0]->Emp_ID);
      $objPHPExcel->getActiveSheet()->setCellValue("Y6", $fnGetEmpDetails[0]->DesignationNM );
      $objPHPExcel->getActiveSheet()->setCellValue("Y7", empnamelength($fnGetEmpDetails[0]->LastName, $fnGetEmpDetails[0]->FirstName, 30)."\r\n".'('.$fnGetEmpDetails[0]->KanaLastName.')');
      $objPHPExcel->getActiveSheet()->getStyle("AG5")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle("AG6")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle("AG7")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getStyle("AG10")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $i = 0;
      $grandtotalval = 0; 
      foreach ($employees as $user) {
          if($user->mode_of_travel == 5) {
            $mot = $user->others;
          } else {
            $mot = Helpers::fnGetTravelMode($user->mode_of_travel);
          }
          if ($user->trip != 3) {
            $mode_val = $user->trip;
          } else {
            $mode_val = '1';
          }
        $objPHPExcel->getActiveSheet()->setCellValue("A".(11+$i), substr($user->date, 5, 2).'月');
        $objPHPExcel->getActiveSheet()->setCellValue("C".(11+$i), substr($user->date, 8, 2).'日');
        $objPHPExcel->getActiveSheet()->setCellValue("E".(11+$i), $user->client);
        $objPHPExcel->getActiveSheet()->setCellValue("I".(11+$i), $mot);
        $objPHPExcel->getActiveSheet()->setCellValue("N".(11+$i), $user->travel_from .' ~ '. $user->travel_to);
        $objPHPExcel->getActiveSheet()->setCellValue("Y".(11+$i), number_format($user->amount));
        $objPHPExcel->getActiveSheet()->setCellValue("AA".(11+$i), 'X');
        $objPHPExcel->getActiveSheet()->setCellValue("AB".(11+$i), $mode_val);
        $objPHPExcel->getActiveSheet()->setCellValue("AC".(11+$i), number_format($user->amount * $mode_val).'円');
        $grandtotalval += $user->amount * $mode_val;
        $objPHPExcel->getActiveSheet()->getStyle('A' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (11+$i) . ':B' . (11+$i));
        $objPHPExcel->getActiveSheet()->mergeCells('C' . (11+$i) . ':D' . (11+$i));
        $objPHPExcel->getActiveSheet()->mergeCells('E' . (11+$i) . ':H' . (11+$i));
        $objPHPExcel->getActiveSheet()->getStyle("E" . (11+$i))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('I' . (11+$i) . ':M' . (11+$i));
        $objPHPExcel->getActiveSheet()->getStyle("I" . (11+$i))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('N' . (11+$i) . ':X' . (11+$i));
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . (11+$i) . ':Z' . (11+$i));
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . (11+$i) . ':AF' . (11+$i));
        $objPHPExcel->getActiveSheet()->getStyle("A".(11+$i).":AC".(11+$i))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A' . (11+$i))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('I' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('N' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Y' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Y' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
        $objPHPExcel->getActiveSheet()->getStyle('AB' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AB' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("AA" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("AB" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("Y" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("E" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("AC" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $i++;
      }
      if($i == count($employees) ){
        $objPHPExcel->getActiveSheet()->mergeCells('A' . (11+$i) . ':AB' . (11+$i));
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . (11+$i) . ':AF' . (11+$i));
        $objPHPExcel->getActiveSheet()->setCellValue("A".(11+$i), "合　計 ( G.Total)");
        $objPHPExcel->getActiveSheet()->setCellValue("AC".(11+$i), number_format($grandtotalval).'円');
        $objPHPExcel->getActiveSheet()->getStyle("A".(11+$i).":AF".(11+$i))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A' . (11+$i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A' . (11+$i))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . (11+$i))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("AC" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("A" . (11+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
      $objPHPExcel->getActiveSheet()->setTitle("Travel Expenses");
      $objPHPExcel->getActiveSheet()->setSelectedCells("A1");
    })->setFilename($request->traexpid)->download('xls');
  }
}