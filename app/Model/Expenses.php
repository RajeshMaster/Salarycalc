<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Session;
use Carbon\Carbon ;
class Expenses extends Model{

   public static function emplist($request) {

      $db = DB::connection('mysql_MB');
      if(!isset($request->plimit) || $request->plimit =="" ) {
        $request->plimit = 50;
      }
      $employees = $db->TABLE('emp_mstemployees AS emp')
                    ->SELECT('emp.id AS empid', 
                             'emp.Emp_ID AS Empid', 
                             'emp.*', 
                             'loc.*', 
                             'loc.id AS loc_id');
      $employees = $employees->JOIN(DB::raw("(SELECT *,SUM(Amount) AS grandtotal FROM (
                                                SELECT * FROM mstexpenses_dtl WHERE SUBSTRING(Date, 1, 7) = '$request->pass_date' AND Del_Flg = '0'
                                                ORDER BY Emp_ID ASC,Date DESC ) AS mstexpenses_dtl 
                                              GROUP BY Emp_ID ) AS loc"),function($join)
                                              {
                                                $join->on('loc.Emp_ID', '=', 'emp.Emp_ID');
                                              });
      $employees = $employees->WHERE('emp.delFlg', '=', 0);
                             // ->WHERE('emp.resign_id', '=', 0);
      $employees = $employees->where(function($joincont) use ($request) {
                                  $joincont->where('emp.Title', '=', 2)
                                           ->orWhere('emp.Title', '=', 3);
                                  });
      $employees = $employees->ORDERBY('loc.Ins_DT', 'DESC')
                             ->ORDERBY('loc.Ins_TM', 'DESC')
                             ->paginate($request->plimit);

      return $employees;
   }


   public static function fnGetExpensesCalenderBar($request) {

      $db = DB::connection('mysql_MB');
      $date = $db->TABLE('mstexpenses_dtl')
                    ->SELECT(DB::raw("SUBSTRING(Date, 1, 4) AS year,SUBSTRING(Date, 6, 2) AS month"))
                    ->WHERE('Del_Flg',0);
                    if (!empty($request->pass_date) && !empty($request->empid)) {
                      $date = $date->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $request->pass_date)
                                   ->WHERE('Emp_ID', '=', $request->empid)
                                   ->ORDERBY('Date','Asc');
                    } else {
                      $date = $date->GROUPBY(DB::raw("SUBSTRING(Date, 1, 7) ASC"));
                    }
                    $date = $date->get();
      $cursheet=array();
      $dataAll=array();
      $prYrMn =explode('-', date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01')))));
      $cursheet['year']=$prYrMn[0];
      $cursheet['month']=$prYrMn[1];
      $k = 0;
      foreach ($date as $datevalue) {
        $dataAll[]=$datevalue;
        if( $k == 0 ) {
          $arr = (object) $cursheet;
          array_push($dataAll,$arr);
        } $k++;
      }
      if(count($dataAll) != 0){      
        $i=-1;
        $j=1;
        $first_yr=0;
        $first_month=0;
        for($yr=0;$yr<count($dataAll);$yr++) {
          $prev=$dataAll[$yr]->year;
          if($prev!=$first_yr){
            $i++;
            $prev_yrs[$i][0]=$prev;
            $first_yr=$prev;
            $first_month=0;
            $j=1;
          }
          $prevmon=$dataAll[$yr]->month;

          if($prevmon!=$first_month){
            $prev_yrs[$i][$j]=$prevmon;
            $j++;
            $first_month=$prevmon;
          }
        }
        $cur_year_flg = "0";
        for($i=0;$i<count($prev_yrs);$i++){
          if($prev_yrs[$i][0] == date("Y"))
          {
            $cur_year_flg = "1";
          }
        }
        $previous[0]=$prev_yrs;
        //Get Total Years for all data
        for($i=0;$i<count($prev_yrs);$i++){
          $yrs[$i]=$prev_yrs[$i][0];
        }
        if((date("d")=="31") && (date("m")=="12")) {
          $yrs[$i]=$yrs[$i-1]+1;
        }
        $previous[1]=$yrs;
        return $previous;
      }
  }


  public static function updatepaidsate($request) {

    $db = DB::connection('mysql_MB');
    $update=$db->table('mstexpenses_dtl')
          ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
          ->WHERE('Emp_ID','=', $request->empid)
          ->update( ['Paid_Date' => $request->Paid_Date] );
    return $update;
  }


  public static function paiddate($request) {

    $db = DB::connection('mysql_MB');
    $paiddate=$db->table('mstexpenses_dtl')
                ->select('Paid_Date')
                ->where('id', $request->expid)
                ->get();
    return $paiddate;
  }


  public static function getEmpDetails($request) {

    if ($request->empid == "") {
      $var = $request->traexpid;
    } else {
      $var = $request->empid;
    }

    if(Session::get('screenType') == "SATHISYS" || Session::get('screenType') == "SATHIINSTITUTE") {
        $db = DB::connection('mysql_SS');
        $employee_tableName = "emp_mstemployees";
    } else {
      $db = DB::connection('mysql_MB');
      $employee_tableName = "emp_mstemployees";
    }

    $sql = $db->TABLE('emp_mstemployees AS emp')
                ->SELECT('emp.*')
                ->WHERE('emp.Emp_ID', '=', $var)
                ->get();
    return $sql;
  }

  public static function fnGetExpenseDetails($request,$empid, $paging_flg = false) {

    $db= DB::connection('mysql_MB');
    if(!isset($request->plimit) || $request->plimit =="" ) {
        $request->plimit = 50;
    }
    if(Session::get('screenType') == "SATHISYS" || Session::get('screenType') == "SATHIINSTITUTE" || Session::get('screenType') == "MICROBIT") {
      $db= DB::connection('mysql_MB');
      $employee_tableName = "mstexpenses_dtl";
    }

    $query = $db->TABLE('mstexpenses_dtl AS mst')
                   ->SELECT('mst.*',
                            'main.main AS main_sub',
                            'sub.sub AS su_sub ')
                   ->LEFTJOIN('staff_set_expensemain AS main','mst.main_sub','=','main.id')
                   ->LEFTJOIN('staff_set_expensesub AS sub','mst.su_sub','=','sub.id')
                   ->WHERE('Del_Flg',0);
    $query = $query->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $request->pass_date);
    $query = $query->WHERE('mst.Emp_ID', '=', $empid)
                   ->ORDERBY('Date','Asc')
                   ->paginate($request->plimit);
                   // dd($query);
    return $query;
  }


  public static function fetchexptot($pass_date) {
    $db = DB::connection('mysql_MB');
    $exptotal = $db->SELECT(DB::raw('SELECT SUM(Amount) AS expgrandtotals 
              FROM (SELECT * FROM mstexpenses_dtl WHERE SUBSTRING(Date, 1, 7) = "'.$pass_date.'" AND Emp_ID != "") as exp'));
    return $exptotal;
  }


  public static function expdetTot($request) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('mstexpenses_dtl')
                  ->SELECT(DB::raw('SUM(Amount) AS TotAmount'))
                  ->WHERE('Del_Flg',0);
    $query = $query->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $request->pass_date);
    $query = $query->WHERE('Emp_ID', '=', $request->empid)
                   ->get();

    return $query;
  }


  public static function submitrec($request) {

    $db = DB::connection('mysql_MB');
    $update=$db->table('mstexpenses_dtl')
                     ->WHERE('Emp_ID', '=', $request->empid);
    $update = $update->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $request->pass_date)
                      ->update(['Dof_Submission' => date('Y-m-d'),
                            'revertFlg' => '0']);
    return $update;
  }


  public static function confirmrec($request) {

    $db = DB::connection('mysql_MB');
    $update=$db->table('mstexpenses_dtl')
                      ->WHERE('Emp_ID', '=', $request->empid);
    $update = $update->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $request->pass_date)
                      ->update(['confirmFlg' => '1']);

    return $update;
  }


  public static function fnprevyears($request) {

    $db = DB::connection('mysql_MB');
    $datequery =$db->SELECT("(SELECT SUBSTRING(Date, 1, 7) AS Date
        FROM mstexpenses_dtl WHERE Emp_ID = '".$request->empid."' AND SUBSTRING(Date, 1, 7) < '".$request->pass_date."' 
        GROUP BY Date ORDER BY Date DESC)");
    $array = json_decode(json_encode($datequery), True);
    return $array;
  }


  public static function fnnextyears($request) {

    $db = DB::connection('mysql_MB');
    $datequery = $db->SELECT("(SELECT SUBSTRING(Date, 1, 7) AS Date
        FROM mstexpenses_dtl WHERE Emp_ID = '".$request->empid."' AND SUBSTRING(Date, 1, 7) > '".$request->pass_date."' 
        GROUP BY Date ORDER BY Date ASC)");
    $array = json_decode(json_encode($datequery), True);
    return $array;
  }


  public static function getExpHistory($request,$empid) {

    $db = DB::connection('mysql_MB');
    if($request->expsort == "") {
      $request->expsort ='Date';
      $request->sortOrder ='DESC';
      $request->sortstyle="sort_desc";
      $datmonorder = "DESC";
      $request->plimit ='100';
    } else {
      if($request->expsort == "Date" && $request->sortOrder == "asc") {
        $datmonorder = "asc";
      } else {
        $datmonorder = "desc";
      }
    }
    if (empty($request->plimit)) {
      $request->plimit = "100";
    }
    $query = $db->TABLE('mstexpenses_dtl AS mst')
                ->SELECT('mst.*',
                    DB::raw('SUBSTRING(Date, 1, 7) AS date_month'),
                    DB::raw('CONCAT(main.main,"->",sub.sub) AS mainSubSubject')
                  )
                ->LEFTJOIN('staff_set_expensemain AS main','mst.main_sub','=','main.id')
                ->LEFTJOIN('staff_set_expensesub AS sub', function($join)
                  {
                      $join->on('mst.main_sub','=','sub.mainid');
                      $join->on('mst.su_sub','=','sub.id');
                  })
                ->WHERE('Emp_ID', '=', $empid)
                ->ORDERBY('date_month',$datmonorder)
                ->ORDERBY($request->expsort,$request->sortOrder)
                ->paginate($request->plimit);
                // dd($query);
    return $query;
  }

  public static function getGrantTotal($request,$empid) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('mstexpenses_dtl')
                  ->SELECT(DB::raw('SUM(Amount) AS SUM'))
                  ->WHERE('Emp_ID', '=', $empid)
                  ->get();

    return $query;
  }


  public static function historymnthtotal($empid, $yrMn) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('mstexpenses_dtl')
                  ->SELECT(DB::raw('SUM(Amount) AS SUM'),
                           DB::raw('SUBSTRING(Date, 1, 7) AS date_month'))
                  ->WHERE('Emp_ID', '=', $empid);
    $query = $query->WHERE(DB::raw("SUBSTRING(Date, 1, 7)"),'=', $yrMn);
    $query = $query->GROUPBY(DB::raw("SUBSTRING(Date, 1, 7) ASC"));
    $query = $query->ORDERBY('date_month','desc')->get();

    return $query;
  }


  public static function fnGetMainstdet($request) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('staff_set_expensemain')
                   ->SELECT('id','main')
                   ->WHERE('DelFlg',0)
                   ->ORDERBY('Order_id', 'ASC')
                   ->lists('main','id');
    return $query;
  }


  public static function fnGetMainstdets($request) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('staff_set_expensemain')
                   ->SELECT('id','main')
                   ->WHERE('DelFlg',0)
                   ->ORDERBY('Order_id', 'ASC')
                   ->get();
                   // dd($query);
    return $query;
  }

  public static function fnGetSubdet($request) {

    $db = DB::connection('mysql_MB');
    $query=$db->table('staff_set_expensesub')
                   ->SELECT('sub','id','mainid')
                   ->WHERE('DelFlg',0)
                   ->WHERE('mainid', $request->mainid)
                   ->ORDERBY('Order_id', 'ASC')
                   ->get();
    return $query;
  }


  public static function fncheckmonth($request) {

    $db = DB::connection('mysql_MB');
    if ($request->expDate != "") {
      $dtemon = substr($request->expDate, 0, 4);
    } else {
      $dtemon = substr($request->expense_date, 0, 4);
    }
    $query=$db->table('mstexpenses_dtl')
                  ->SELECT('*');
    $query = $query->WHERE(DB::raw("SUBSTRING(Date, 1, 4)"),'=', $dtemon);
    $query = $query->WHERE('main_sub', '=', $request->main_sub)
                   ->WHERE('su_sub', '=', $request->su_sub)
                   ->WHERE('Emp_ID', '=', $request->empid)
                   ->get();
                   // dd($query);
    $montharr = array();
    $monselval = "";
    foreach ($query as $key => $value) {
      if ($value->Month !=99 && $value->Month != "") {
        $ressplit = explode(',', $value->Month);
        for ($i=0; $i < count($ressplit); $i++) { 
          if (!in_array($ressplit[$i], $montharr)) {
            $monselval = $monselval.$ressplit[$i].",";
          }
        }
      }
    }
    $monselval = substr($monselval, 0, -1);
    $countloanName = explode(',', $monselval);
    return $countloanName;
  }


  public static function fngetid($request) {

      $db = DB::connection('mysql_MB');
      $getid = $db->table('mstexpenses_dtl')->max('id');

      return $getid;
  }


  public static function detedit($request) {

    $db = DB::connection('mysql_MB');
    $query = $db->TABLE('mstexpenses_dtl')
                      ->WHERE('id', '=', $request->id)
                      ->get();
    return $query;
  }


  public static function fngetdateofsubmission($request) {

    $db = DB::connection('mysql_MB');
    $employees = $db->TABLE('mstexpenses_dtl')
                    ->SELECT('Dof_Submission','Paid_Date','ConfirmFlg')
                    ->WHERE('Emp_ID', '=', $request->empid)
                    ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
                    ->get();
    return $employees;
  }


  public static function InsertRec($request,$image_name) {

    $UserType=Session::get('UserType');
    // Set this Value because of restrict copying the record to next month it submits default
    $request->pass_date = date('Y-m',strtotime($request->Date));
    $checkforsubmit = self::fngetdateofsubmission($request);
    $submissiondate = null;
      $paymentdate = null;
      $confirmation = 0;
    foreach ($checkforsubmit as $key => $value) {
        if ($value->Dof_Submission != "" && $value->Dof_Submission != "0000-00-00") {
          $submissiondate = $value->Dof_Submission;
        }
        if ($value->Paid_Date != "" && $value->Paid_Date != "0000-00-00") {
          $paymentdate = $value->Paid_Date;
        }
        if ($value->ConfirmFlg != 0) {
          $confirmation = $value->ConfirmFlg;
        }
      }
    $yr_mon = '';
    for ($i=0; $i <count($request->month); $i++) {
      $yr_mon .= $request->month[$i].",";
    }
    $yr_mon = substr($yr_mon, 0, -1);
    if($UserType == 1) {
      $adminflg = 1;
    } else {
      $adminflg = 0;
    }
    $request->Amount = preg_replace('/,/', '', $request->Amount);

    $db = DB::connection('mysql_MB');
    $insert = $db->table('mstexpenses_dtl')->insert(
                              ['Emp_ID' => $request->empid,
                              'Subject' => $request->Others,
                              'main_sub' => $request->main_sub,
                              'su_sub' => $request->su_sub,
                              'Bill_Image' => $image_name,
                              'Amount' => $request->Amount,
                              'Dof_Submission' => $submissiondate,
                              'ConfirmFlg' => $confirmation,
                              'Paid_Date' => $paymentdate,
                              'Remark' => $request->Remark,
                              'Ins_DT' => date('Ymd'),
                              'Ins_TM' => date('His'),
                              'Up_DT' => date('Ymd'),
                              'Up_TM' => date('His'),
                              'CreatedBy' => Auth::user()->FirstName,
                              'Del_Flg' => '0',
                              'Date' => $request->Date,
                              'Month' => $yr_mon,
                              'Admin_Flg' => $adminflg]
                            );
    return $insert;
    
  } 


  public static function UpdateRec($request,$image_name) {

    $UserType=Session::get('UserType');
    $yr_mon = '';
    for ($i=0; $i <count($request->month); $i++) {
      $yr_mon .= $request->month[$i].",";
    }
    $yr_mon = substr($yr_mon, 0, -1);
    if($UserType == 1) {
      $adminflg = 1;
    } else {
      $adminflg = 0;
    }
    $request->Amount = preg_replace('/,/', '', $request->Amount);

    $db = DB::connection('mysql_MB');
    $update=$db->table('mstexpenses_dtl')
                          ->where('id', $request->id)
                          ->update(
                            ['Emp_ID' => $request->empid,
                              'Subject' => $request->Others,
                              'main_sub' => $request->main_sub,
                              'su_sub' => $request->su_sub,
                              'Bill_Image' => $image_name,
                              'Amount' => $request->Amount,
                              'Remark' => $request->Remark,
                              'Up_DT' => date('Ymd'),
                              'Up_TM' => date('His'),
                              'CreatedBy' => Auth::user()->FirstName,
                              'Del_Flg' => '0',
                              'Date' => $request->Date,
                              'Month' => $yr_mon,
                              'Admin_Flg' => $adminflg]
                          );
    return $update;
  }
}