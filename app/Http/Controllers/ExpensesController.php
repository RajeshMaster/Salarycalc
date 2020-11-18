<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Expenses;
use App\Http\Helpers;
use Input;
use Validator;
use Redirect;
use Session;
use mimes;
use DB;
use Config;
use Carbon;
class ExpensesController extends Controller
{
    public function index(Request $request) {
      if(Session::get('Expselmon') !=""){
        $request->selMonth = Session::get('Expselmon');
        $request->selYear = Session::get('Expselyr');
        $request->empid = "";
      }
      if ($request->selMonth == "") {
         $request->empid = "";
      }
      $date = Expenses::fnGetExpensesCalenderBar($request);
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
        $prev_yrs=$prYrMn;
        array_push($total_yrs, $prYrMn[0]);
      } 
      $cur_year=date('Y');
      $cur_month=date('m')-1;
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
      $request->pass_date = $selectedYear . "-" . substr("0" . $selectedMonth, -2);
      $fetchexptot = Expenses::fetchexptot($request->pass_date);
      $employees = Expenses::emplist($request);
      return view('expenses.index', ['request' => $request,
                                      'prev_yrs' => $prev_yrs,
                                      'cur_year' => $cur_year,
                                      'cur_month' => $cur_month,
                                      'total_yrs' => $total_yrs,
                                      'curtime' => $curtime,
                                      'fetchexptot' => $fetchexptot,
                                      'employees' => $employees]);
    }
    public function regpopup(Request $request) {
      $paiddate = Expenses::paiddate($request);
      return view('expenses.regpopup', ['paiddate' => $paiddate[0],
                                         'request' => $request]);
    }
    public function addeditpd(Request $request) {
      $updatepaidsate = Expenses::updatepaidsate($request);
      if($updatepaidsate) {
        Session::flash('message', 'Updated Sucessfully!'); 
        Session::flash('type', 'alert-success');
      } else {
        Session::flash('type', 'Updated Unsucessfully!'); 
        Session::flash('type', 'alert-danger'); 
      }
      Session::flash('Expselmon', $request->selMonth);
      Session::flash('Expselyr', $request->selYear); 
      return Redirect::to('Expenses/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
    }
    public function view(Request $request) {
      if(Session::get('empid') !="" && Session::get('pass_date') !=""){
        $request->empid = Session::get('empid');
        $request->pass_date = Session::get('pass_date');
      }
      $request->pass_date =substr($request->pass_date, 0, 7);
      if($request->empid=="" && $request->pass_date==""){
        // return $this->index($request);
        return Redirect::to('totalexp/index?mainmenu=TotalExpenses&time='.date('YmdHis'));
      }
      if($request->subcnfm != ""){
        if($request->subcnfm == 1){
          $subcnfm = Expenses::submitrec($request);
          if($subcnfm) {
            Session::flash('message', 'Submitted Sucessfully!'); 
            Session::flash('type', 'alert-success');
          } else {
            Session::flash('type', 'Submitted Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
        } else {
          $subcnfm = Expenses::confirmrec($request);
          if($subcnfm) {
            Session::flash('message', 'Confirmed Sucessfully!'); 
            Session::flash('type', 'alert-success');
          } else {
            Session::flash('type', 'Confirmed Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
        }
      }
      $request->selMonth=substr($request->pass_date, 5, 2);
      $request->selYear=substr($request->pass_date, 0, 4);
      if (isset($request->flagval)) {
          $request->selMonth = date('m');
          $request->selYear = date('Y');
          $request->pass_date = date('Y-m');
      }
      $employees = Expenses::getEmpDetails($request);
      $exp_details = Expenses::fnGetExpenseDetails($request, $employees['0']->Emp_ID, true);
      $exp_detailstot = Expenses::expdetTot($request);
      $request->dofsubmission_flg = false;
      if (!empty($exp_details['0']->Dof_Submission) && ($exp_details['0']->Dof_Submission != "0000-00-00")) {
        $request->dofsubmission_flg = true;
      }
      $prevyears = Expenses::fnprevyears($request);
      $nextyears = Expenses::fnnextyears($request);
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
      $workingHrs = Helpers::workinghourscalculation($employees['0']->Emp_ID,$request->pass_date);
      if (isset($workingHrs[1]) && $workingHrs[1] != "") {
        $actualminutes = $workingHrs[1] % 60;
        $actualhours = ($workingHrs[1] - $actualminutes)/60;
        $request->totalWorkingHrs=$actualhours.":".str_pad($actualminutes, 2,"0",STR_PAD_LEFT);
      }
      $supportArray = array("1"=>"st","2"=>"nd","3"=>"rd","4"=>"th");
      Session::flash('Expselmon', $request->selMonth);
      Session::flash('Expselyr', $request->selYear); 
      return view('expenses.view', ['request' => $request,
                                      'preval' => $preval,
                                      'prevcount' => $prevcount,
                                      'nextval' => $nextval,
                                      'nextcount' => $nextcount,
                                      'employees' => $employees,
                                      'exp_detailstot' => $exp_detailstot,
                                      'exp_details' => $exp_details,
                                      'supportArray' => $supportArray]);
    }
    public function history(Request $request) {
        $historymnthtotal = array();
      if(!isset($request->empid) && !isset($request->pass_date)){
        // return $this->index($request);
        return Redirect::to('totalexp/index?mainmenu=TotalExpenses&time='.date('YmdHis'));
      }
      if (!isset($request->plimit)) {
        $request->plimit = 100;
        $request->index_plimit = 100;
      }
      if (!isset($request->expsort)) {
          $request->expsort = "Date";
      } 
      if (!isset($request->sortOrder)) {
          $request->sortOrder = "desc";
      } 
      if ($request->sortOrder == "asc") {
          $request->sortstyle="sort_asc";
      } else {
          $request->sortstyle="sort_desc";
      }
      $sortarray = [$request->expsort=>$request->expsort,'Date'=>trans('messages.lbl_date'),
                                                         'Amount' => trans('messages.lbl_amount')];
      $employees = Expenses::getEmpDetails($request);
      $exp_details = Expenses::getExpHistory($request, $employees['0']->Emp_ID);
      $total=array();
      $empdetails=array();
      $i = 0;
      foreach($exp_details as $key=>$emp) {
          $empdetails[$i]['id'] = $emp->id;
          $empdetails[$i]['date_month'] = $emp->date_month;
          $empdetails[$i]['Date'] = $emp->Date;
          if ($emp->Subject != "") {
            $empdetails[$i]['Subject'] = $emp->Subject;
          } else {
            $empdetails[$i]['Subject'] = $emp->mainSubSubject;
          }
          $empdetails[$i]['Amount'] = $emp->Amount;
          $empdetails[$i]['Remark'] = $emp->Remark;
          $empdetails[$i]['Month'] = $emp->Month;
          $empdetails[$i]['Bill_Image'] = $emp->Bill_Image;
          $historymnthtotal = Expenses::historymnthtotal($emp->Emp_ID,$emp->date_month);
          foreach($historymnthtotal as $key=>$monthtot) {
            $empdetails[$i]['SUM'] = $monthtot->SUM;
          }
          $i++;
      }
      $grantTotal = Expenses::getGrantTotal($request, $employees['0']->Emp_ID);
      Session::flash('Expselmon', $request->selMonth);
      Session::flash('Expselyr', $request->selYear); 
      return view('expenses.history', ['request' => $request,
                                       'sortarray' => $sortarray,
                                       'employees' => $employees,
                                       'exp_details' => $exp_details,
                                       'historymnthtotal' => $historymnthtotal,
                                       'empdetails' => $empdetails,
                                       'grantTotal' => $grantTotal]);
    }
    public function addedit(Request $request) {
      if(!isset($request->empid)){
        return $this->index($request);
      }
      $mainsub = array();
      $mainsubdt=Expenses::fnGetMainstdets($request);
      for ($i=0; $i < count($mainsubdt) ; $i++) { 
        if ($mainsubdt[$i]->main != "Others") {
            $mainsub[$mainsubdt[$i]->id] = $mainsubdt[$i]->main;
        }
      }
      for ($i=0; $i < count($mainsubdt) ; $i++) { 
        if ($mainsubdt[$i]->main == "Others") {
            $mainsub[$mainsubdt[$i]->id] = $mainsubdt[$i]->main;
        }
      }
      $su_sub=Expenses::fnGetSubdet($request);
      $employees = Expenses::getEmpDetails($request);
      // $subsubject=Expenses::fnGetSubdet();
      return view('expenses.addedit', ['request' => $request,
                                        'mainsub' => $mainsub,
                                        'employees' => $employees,
                                        'su_sub' => $su_sub]);
    }
    public function Detedit(Request $request) {
      if(!isset($request->empid)){
        return $this->index($request);
      }
      $arrayNotEditOthers=array();
      $mainsubdt=Expenses::fnGetMainstdet($request);
      // print_r($mainsubdt);
      // foreach ($mainsubdt as $key => $value) {
      //     if ($value != "Others") {
      //       $mainsub = $value;
      //     }
      // }
      // foreach ($mainsubdt as $key => $value) {
      //     if ($value == "Others") {
      //       $mainsub = $value;
      //     }
      // }
      // // for ($i=1; $i <= count($mainsubdt) ; $i++) { 
      // //   if ($mainsubdt[$i] != "Others" ) {
      // //       $mainsub[$i] = $mainsubdt[$i];
      // //   }
      // // }
      // for ($i=1; $i <= count($mainsubdt) ; $i++) { 
      //   if ($mainsubdt[$i] == "Others" ) {
      //       $mainsub[$i] = $mainsubdt[$i];
      //   }
      // }
      $su_sub=Expenses::fnGetSubdet($request);
      $detedit = Expenses::detedit($request);
      $detedit[0]->Amount = number_format($detedit[0]->Amount);
      $detedit[0]->Others = $detedit[0]->Subject;
      $request->expense_date = $detedit[0]->Date;
      $request->main_sub = $detedit[0]->main_sub;
      $request->su_sub = $detedit[0]->su_sub;
      $request->empid = $detedit[0]->Emp_ID;
      $fetchEditData = array();
      $fetchEditData = Expenses::fncheckmonth($request);
      $arrayUnique=array_diff($fetchEditData, explode(",", $detedit[0]->Month));
      $o=0;
      foreach ($arrayUnique as $key => $value) {
          $arrayNotEditOthers[$value] = $value;
          $o++;
      }
      $employees = Expenses::getEmpDetails($request);
      return view('expenses.addedit', ['detedit' => $detedit[0],
                                        'request' => $request,
                                        'mainsub' => $mainsubdt,
                                        'employees' => $employees,
                                        'su_sub' => $su_sub,
                                        'fetchEditData' => $fetchEditData,
                                        'arrayNotEditOthers' => $arrayNotEditOthers]);
    }
    public function edit(Request $request) {
      if(!isset($request->empid)){
        return $this->index($request);
      }
      $edit = Expenses::editrec($request);
      if($edit) {
        Session::flash('message', 'Updated Sucessfully!'); 
        Session::flash('type', 'alert-success');
      } else {
        Session::flash('type', 'Updated Unsucessfully!'); 
        Session::flash('type', 'alert-danger');
      }
      Session::flash('empid', $request->traexpid);
      Session::flash('Travelexpempid', $request->traexpid);
      Session::flash('Travelpass_date', substr($request->date, 0, 7) );
      Session::flash('Travelexpselmon', substr($request->date, 5, 2) );
      Session::flash('Travelexpselyr', substr($request->date, 0, 4) );
      return Redirect::to('Travelexp/view?mainmenu=expenses_travel&time='.date('YmdHis'));
    }
    public function getsubsubject(Request $request) {
      $su_sub=Expenses::fnGetSubdet($request);
      $subval=json_encode($su_sub);
      echo $subval;
    }
    public function checkmonth(Request $request) {
      $checkmonth=Expenses::fncheckmonth($request);
      $subval=json_encode($checkmonth);
      echo $subval;
    }
    public function formValidation(Request $request) {
        $rules1=array();
        $rules2=array();
        $dt = new Carbon\Carbon();
        $after = date('Y-m-d', strtotime(' +1 day'));
        $rules1 = array(
          'Date' => 'required|date|before:' . $after, 
          'main_sub' => 'required',
          'Amount' => 'required',
          'su_sub' => 'required');
        if ($request->main_sub == "1") {
          $rules2 = array(
            'Others' => 'required');
        }
        $rules=$rules1+$rules2;
        $customizedNames = array(
         'Date' => trans('messages.lbl_date'),
         'main_sub' => trans('messages.lbl_mainsubject'),
         'su_sub' => trans('messages.lbl_subsubject'),
         'month' => trans('messages.lbl_months'),
         'Amount' => trans('messages.lbl_amount'),
         'Remark' => trans('messages.lbl_remarks'),
         'Others' => trans('messages.lbl_others'));
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customizedNames);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
          $success = true;
          echo json_encode($success);exit;
        }
    }
    public function addeditprocess(Request $request) {
        $destinationPath = '../Com.sathisys/ss/emp/img/upload/Expences';
        if (Input::hasFile('Bill_Image')) { 
            $file=$request->Bill_Image;
            $getid = Expenses::fngetid($request);
            if ($request->useflg != "1") {
              $id = $getid+1;
            } else {
              $id = $request->id;
            }
            $extension = Input::file('Bill_Image')->getClientOriginalExtension();
            $filename1='Expenses'.$id.'.'.$extension;
            if(!is_dir($destinationPath)) {
              mkdir($destinationPath, 0777, true);
            }
            chmod($destinationPath, 0777);
            $file->move($destinationPath,$filename1);
            chmod($destinationPath."/".$filename1, 0777);
        } else {
          if($request->Bill_Image == "" && $request->useflg == "1") {
              $filename1=$request->Image;
          } else {
              $filename1 = "";
          }
        }
        if ($request->useflg != "1") {
          $insert = Expenses::InsertRec($request,$filename1);
          if($insert) {
            Session::flash('message', 'Inserted Sucessfully!'); 
            Session::flash('type', 'alert-success'); 
          } else {
            Session::flash('type', 'Inserted Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
          Session::flash('empid', $request->empid ); 
          Session::flash('pass_date', $request->Date ); 
          return Redirect::to('Expenses/view?mainmenu=expenses_exp&time='.date('YmdHis'));
        } else {
          $update = Expenses::UpdateRec($request,$filename1);
          if($update) {
            Session::flash('message', 'Updated Sucessfully!'); 
            Session::flash('type', 'alert-success'); 
          } else {
            Session::flash('type', 'Updated Unsucessfully!'); 
            Session::flash('type', 'alert-danger'); 
          }
          Session::flash('empid', $request->empid ); 
          Session::flash('pass_date', $request->Date ); 
          return Redirect::to('Expenses/view?mainmenu=expenses_exp&time='.date('YmdHis'));
        }
    }

}