<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Carbon\Carbon ;
use stdClass;
use Session;

class Travelexp extends Model{

   public static function index($request,$pass_date) {

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
      $employees = $employees->RIGHTJOIN(DB::raw("(SELECT *, SUM(amount1 * trip1) AS grandtotal FROM (SELECT *, IF (trip = 3, 1, trip) AS trip1, IF (use_flg = 1, 0, amount) AS amount1 FROM tbl_localtravel WHERE CASE WHEN tbl_localtravel.trip!='3' THEN SUBSTRING(date, 1, 7) = '".$pass_date."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$pass_date."' ELSE SUBSTRING(date, 1, 7) = '".$pass_date."' END END ORDER BY Emp_ID ASC, date DESC) AS tbl_localtravel GROUP BY Emp_ID) AS loc"), function($join)
                                  {
                                    $join->on('loc.Emp_ID', '=', 'emp.Emp_ID');
                                  });
      $employees = $employees->WHERE('emp.delFlg', '=', 0);
                             // ->WHERE('emp.resign_id', '=', 0);
      $employees = $employees->where(function($joincont) use ($request) {
                                  $joincont->where('emp.Title', '=', 2)
                                           ->orWhere('emp.Title', '=', 3);
                                  });
      $employees = $employees->ORDERBY('loc.created_time', 'DESC')->paginate($request->plimit);
      return $employees;
   }


   public static function fnGetLocalTravelCalenderBar($request) {

      $db = DB::connection('mysql_MB');
      $date =$db->SELECT("(SELECT CASE WHEN trip='3' 
                  THEN 
                  CASE 
                    WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 4) 
                    ELSE SUBSTRING(date, 1, 4)
                  END
                  ELSE SUBSTRING(date, 1, 4)
                  END
                  AS year, 
                  CASE WHEN trip='3' 
                  THEN 
                  CASE 
                    WHEN month IS NOT NULL THEN SUBSTRING(month, 6, 2) 
                    ELSE SUBSTRING(date, 6, 2)
                  END
                  ELSE 
                  SUBSTRING(date, 6, 2) END AS month
                  FROM tbl_localtravel
                  GROUP BY CASE 
                  WHEN trip='3' 
                  THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(date, 1, 7) END ASC)");
  
      $dataAll=array();
      $prYrMn =explode('-', date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01')))));
        $object = new stdClass;
        $object->year = $prYrMn[0];
        $object->month = $prYrMn[1];
        $k = 0;
      foreach ($date as $datevalue) {
        $dataAll[]=$datevalue;
        /*if( $k == 0 ) {
          $arr = (object) $cursheet;
          array_push($dataAll,$arr);
        } $k++;*/
      }
      array_push($dataAll, $object);
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
    $update=$db->table('tbl_localtravel')
              ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
              ->WHERE('Emp_ID','=', $request->empid)
              ->update(
              ['paid_date' => $request->paid_date]
            );
    return $update;
  }


  public static function paiddate($request) {
    $db = DB::connection('mysql_MB');
    $paiddate=$db->table('tbl_localtravel')
                ->select('paid_date')
                ->where('id', $request->travelid)
                ->get();
    return $paiddate;
  }


  public static function fetchloctraveltot($pass_date) {

    $db = DB::connection('mysql_MB');
    $localtraveltotal = $db->SELECT(DB::raw('SELECT SUM(amount1 * trip1) AS grandtotals from (SELECT *, IF (trip = 3, 1, trip) AS trip1, IF (use_flg = 1, 0, amount) AS amount1 FROM tbl_localtravel WHERE CASE WHEN trip != 3 THEN SUBSTRING(date,1,7) = "'.$pass_date.'" ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month,1,7) = "'.$pass_date.'" ELSE SUBSTRING(date,1,7) = "'.$pass_date.'" END END) AS tbl_localtravel '));
    return $localtraveltotal;
  }


  public static function getlocaltravelemp($request) {

      $db = DB::connection('mysql_MB');
      $employees = $db->table('tbl_localtravel')
                    ->SELECT('tbl_localtravel.*')
                    ->WHERE('delflg', '=', '0')
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERERAW(DB::raw("CASE WHEN trip != '3' THEN SUBSTRING(date, 1, 7) = '".$request->pass_date."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$request->pass_date."' ELSE SUBSTRING(date, 1, 7) = '".$request->pass_date."' END END"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->ORDERBY('date', 'ASC')
                    ->get();
                    // ->toSql();dd($employees);
      return $employees;
   }


   public static function getlocaltravelempwomp($request) {

      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE('tbl_localtravel')
                    ->SELECT('tbl_localtravel.*')
                    ->WHERE('use_flg', '=', 0)
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERERAW(DB::raw("CASE WHEN trip != '3' THEN SUBSTRING(date, 1, 7) = '".$request->pass_date."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$request->pass_date."' ELSE SUBSTRING(date, 1, 7) = '".$request->pass_date."' END END"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->ORDERBY('date', 'ASC')
                    ->get();
      return $employees;
   }

   public static function getdof($request) {
      $db = DB::connection('mysql_MB');
      $passdate = date('Y-m', strtotime(date('Y-m')." -1 month"));
      $employees = $db->TABLE('tbl_localtravel')
                    ->SELECT('dofsubmission')
                    ->WHERE('delflg', '=', 0)
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERERAW(DB::raw("CASE WHEN trip != '3' THEN SUBSTRING(date, 1, 7) = '".$passdate."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$passdate."' ELSE SUBSTRING(date, 1, 7) = '".$passdate."' END END"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->GROUPBY('Emp_ID')
                    ->ORDERBY('date', 'ASC')
                    ->get();
      return $employees;
   }

   public static function dateofsub($request,$passdate) {
    // $passdate = date('Y-m', strtotime(date('Y-m')." -1 month"));
      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE('tbl_localtravel')
                    ->SELECT('tbl_localtravel.*')
                    ->WHERE('delflg', '=', 0)
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERERAW(DB::raw("CASE WHEN trip != '3' THEN SUBSTRING(date, 1, 7) = '".$passdate."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$passdate."' ELSE SUBSTRING(date, 1, 7) = '".$passdate."' END END"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->GROUPBY('Emp_ID')
                    ->ORDERBY('date', 'ASC')
                    ->get();
      return $employees;
   }


   public static function getdofgf($request) {
      $passdate = date('Y-m', strtotime(date('Y-m')." -1 month"));
      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE('tbl_localtravel')
                    ->SELECT('dofsubmission')
                    ->WHERE('delflg', '=', 0)
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERERAW(DB::raw("CASE WHEN trip != '3' THEN SUBSTRING(date, 1, 7) = '".$passdate."' ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$passdate."' ELSE SUBSTRING(date, 1, 7) = '".$passdate."' END END"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->GROUPBY('Emp_ID')
                    ->ORDERBY('date', 'ASC')
                    ->get();
      return $employees;
  }

  public static function fnGetEmpDetails($request) {
      // if(substr($request->empid, 0,2) == "MB") {
        $db = DB::connection('mysql_MB');
      // }  else {
        // $db = DB::connection('mysql_SS');
      // }

      if ($request->traexpid == "") {
        $var = $request->empid;          
      } else {
        $var = $request->traexpid; 
      }
     $employees = $db->TABLE('emp_mstemployees AS emp')
                    ->SELECT('emp.*','des.*')
                    ->Join('sysdesignationtypes AS des', 'emp.Designation', '=', 'des.DesignationCD')
                    ->WHERE('emp.Emp_ID', '=', $request->traexpid)
                    ->get();
      return $employees;
  }

  public static function usenotuse($request) {
    if($request->useflg == "1"){
      $use_flg = "0";
    } else {
      $use_flg = "1";
    }
    $db = DB::connection('mysql_MB');
    $update=$db->table('tbl_localtravel')
          ->where('id', $request->travelid)
          ->update(
          ['use_flg' => $use_flg]
        );
    return $update;
  }


  public static function submitrec($request) {

    $db = DB::connection('mysql_MB');
    $update=$db->table('tbl_localtravel')
        ->WHERERAW(DB::raw("Emp_ID = '".$request->traexpid."' AND CASE WHEN tbl_localtravel.trip!='3' THEN SUBSTRING(date, 1, 7) = '".$request->pass_date."' ELSE CASE 
          WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$request->pass_date."' ELSE SUBSTRING(date, 1, 7) = '".$request->pass_date."' END END"))
        ->update(
        ['dofsubmission' => date('Y-m-d'),
        'revertFlg' => '0']
      );
    return $update;
  }


  public static function confirmrec($request) {

    $db = DB::connection('mysql_MB');
    $update=$db->table('tbl_localtravel')
        ->WHERERAW(DB::raw("Emp_ID = '".$request->traexpid."' AND CASE WHEN tbl_localtravel.trip!='3' THEN SUBSTRING(date, 1, 7) = '".$request->pass_date."' ELSE CASE 
          WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$request->pass_date."' ELSE SUBSTRING(date, 1, 7) = '".$request->pass_date."' END END"))
        ->update(
        ['confirmFlg' => '1']
      );
    return $update;
  }


  public static function fnprevyears($request) {

    $db = DB::connection('mysql_MB');
    $datequery =$db->SELECT("(SELECT CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(date, 1, 7) END dates
        FROM tbl_localtravel WHERE Emp_ID = '".$request->traexpid."' AND 
        CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) < '".$request->pass_date."' 
        ELSE SUBSTRING(date, 1, 7) < '".$request->pass_date."' END GROUP BY dates ORDER BY dates DESC)");
    $array = json_decode(json_encode($datequery), True);
    return $array;
  }


  public static function fnnextyears($request) {

    $db = DB::connection('mysql_MB');
    $datequery =$db->SELECT("(SELECT CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(date, 1, 7) END dates
        FROM tbl_localtravel WHERE Emp_ID = '".$request->traexpid."' AND 
        CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) > '".$request->pass_date."' 
        ELSE SUBSTRING(date, 1, 7) > '".$request->pass_date."' END GROUP BY dates ORDER BY dates ASC)");
    $array = json_decode(json_encode($datequery), True);
    return $array;
  }


  public static function history($request) {
    if(!isset($request->plimit) || $request->plimit =="" ) {
        $request->plimit = 100;
    }
    if($request->travelsort != 'date' || !isset($request->travelsort) ) {
      $request->sortOrderdef = "desc";
    } else {
      $request->sortOrderdef = $request->sortOrder;
    }

    $db = DB::connection('mysql_MB');
    $history = $db->TABLE(DB::raw('(SELECT *, IF (trip = 3, 1, trip) trip1 FROM tbl_localtravel) AS tbl_localtravel'))
                    ->SELECT('tbl_localtravel.*',
                      DB::RAW("(trip1 * amount) AS totalval"),
                      DB::RAW("SUBSTRING(created_time, 1, 10) AS date1"),
                      DB::RAW("CASE WHEN (month !='99' AND month !='') THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(date, 1, 7) END AS date_month")
                      )
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERE('use_flg', '=' , 0)
                    ->ORDERBY('date_month', $request->sortOrderdef)
                    ->ORDERBY($request->travelsort, $request->sortOrder)
                    ->paginate($request->plimit);
    return $history;
  }


  public static function historygrandtotal($request) {

    $db = DB::connection('mysql_MB');
    $historygrandtotal = $db->TABLE(DB::raw('(SELECT *, IF (trip = 3, 1, trip) trip1 FROM tbl_localtravel) AS tbl_localtravel'))
                    ->SELECT(DB::RAW("sum(trip1 * amount) AS grandtotal"))
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERE('use_flg', '=', 0)
                    ->get();
    return $historygrandtotal;
  }


  public static function historymnthtotal($empid,$passdate) {

    $db = DB::connection('mysql_MB');
    $historymnthtotal =$db->SELECT("(SELECT SUM(CASE WHEN (tbl_localtravel.trip = 2) THEN tbl_localtravel.amount * 2 ELSE tbl_localtravel.amount END ) AS SUM,CASE WHEN (tbl_localtravel.month !='') THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(Date, 1, 7) END AS date_month FROM tbl_localtravel WHERE Emp_ID='".$empid."' AND use_flg = 0 AND CASE WHEN (tbl_localtravel.month !='') THEN SUBSTRING(month, 1, 7)='".$passdate."' ELSE SUBSTRING(Date, 1, 7)='".$passdate."' END GROUP BY CASE WHEN (tbl_localtravel.month !='') THEN SUBSTRING(month, 1, 7) ELSE SUBSTRING(Date, 1, 7) END)");
    return $historymnthtotal;
  }


  public static function fntoupdatedelflag($request){

    $db = DB::connection('mysql_MB');
    $updatedb=$db->table('mstexpenses_dtl')
          ->where('id', $request->localtravel)
          ->update(
          ['Del_Flg' => '1',
           'Up_DT' => date('Ymd'),
           'Up_TM' => date('his'),
           'UpdatedBy' => Auth::user()->FirstName]
        );
    return $updatedb;
  }


  public static function fngetdateofsubmission($request) {

      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE('tbl_localtravel')
                    ->SELECT('dofsubmission','paid_date','confirmFlg')
                    ->WHERE('Emp_ID', '=', $request->traexpid)
                    ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
                    ->get();
                    return $employees;
  }


  public static function register($request) {
    $multidates = explode(",",$request->multi_date);
    if($request->trip != 3 ) {
      $request->enddate = null;
      $request->month = null;
    }
    // Set this Value because of restrict copying the record to next month it submits default
    $request->pass_date = date('Y-m',strtotime($request->date));
    $checkforsubmit = self::fngetdateofsubmission($request);
    $submissiondate = null;
    $paymentdate = null;
    $confirmation = 0;
    foreach ($checkforsubmit as $key => $value) {
      if ($value->dofsubmission != "" && $value->dofsubmission != "0000-00-00") {
        $submissiondate = $value->dofsubmission;
      }
      if ($value->paid_date != "" && $value->paid_date != "0000-00-00") {
        $paymentdate = $value->paid_date;
      }
      if ($value->confirmFlg != 0) {
        $confirmation = $value->confirmFlg;
      }
    }

    if($request->mode_of_travel != 5 ) {
      $request->others = "";
    }

    if($request->trip == 3 ) {
      $stdate = explode("-",$request->date);
      $year_month = explode("-",$request->enddate);
      if(strlen($request->month) == 1 ) {
        $request->month = "0".$request->month;
      }
      if($stdate[0] != date('Y')  && $request->month == "01") {
        // $stdate[0] = $stdate[0] + 1;
        $request->month = $stdate[1];
      } else if($stdate[0] == date('Y')  && $request->month == "12" && $request->month != date('m')) {
          $stdate[0] = $stdate[0] - 1;
      }
      $request->month =  $stdate[0]."-".$request->month."-"."1";
    }

    $request->amount = preg_replace('/,/', '', $request->amount);
    if($request->dateselection == 1 ) {

      $db = DB::connection('mysql_MB');
      $insert=$db->table('tbl_localtravel')->insert(
            ['date' => $request->date,
             'client' => $request->client,
             'mode_of_travel' => $request->mode_of_travel,
             'travel_from' => $request->travel_from,
             'travel_to' => $request->travel_to,
             'amount' => $request->amount,
             'trip' => $request->trip,
             'dofsubmission' => $submissiondate,
             'paid_date' => $paymentdate,
             'confirmFlg' => $confirmation,
             'delflg' => '0',
             'Emp_ID' => $request->traexpid,
             'others' => $request->others,
             'month' => $request->month,
             'enddate' => $request->enddate,
             'updated_time' => date('Ymdhis'),
             'created_time' => date('Ymdhis'),
             'created_by' => Auth::user()->FirstName]
          );
    } else {
      for ($i = 0; $i < count($multidates); $i++) {
        $insert=$db->table('tbl_localtravel')->insert(
            ['date' => $multidates[$i],
             'client' => $request->client,
             'mode_of_travel' => $request->mode_of_travel,
             'travel_from' => $request->travel_from,
             'travel_to' => $request->travel_to,
             'amount' => $request->amount,
             'trip' => $request->trip,
             'dofsubmission' => $submissiondate,
             'paid_date' => $paymentdate,
             'confirmFlg' => $confirmation,
             'delflg' => '0',
             'Emp_ID' => $request->traexpid,
             'others' => $request->others,
             'month' => $request->month,
             'enddate' => null,
             'updated_time' => date('Ymdhis'),
             'created_time' => date('Ymdhis'),
             'created_by' => Auth::user()->FirstName]
          );
      }
    }
    return $insert;
  }

  public static function Detedit($request) {

    $db = DB::connection('mysql_MB');
    $Details = $db->TABLE('tbl_localtravel')
                      ->WHERE('id', '=', $request->travelid)
                      ->get();
    return $Details;
  }

  public static function editrec($request) {
    if($request->trip != 3 ) {
      $request->enddate = null;
      $request->month = null;
    }
    if($request->mode_of_travel != 5 ) {
      $request->others = "";
    }
    if($request->trip == 3 ) {
      $stdate = explode("-",$request->date);
      $year_month = explode("-",$request->enddate);
      if(strlen($request->month) == 1) {
        $request->month = "0".$request->month;
      }
      if($stdate[0] != date('Y')  && $request->month == "01") {
        // $stdate[0] = $stdate[0] + 1;
        $request->month = $stdate[1];
      } else if($stdate[0] == date('Y')  && $request->month == "12" && $request->month != date('m')) {
          $stdate[0] = $stdate[0] - 1;
      }
      $request->month =  $stdate[0]."-".$request->month."-"."1";
    }
    $request->amount = preg_replace('/,/', '', $request->amount);
    $db = DB::connection('mysql_MB');
    $updatedb=$db->table('tbl_localtravel')
          ->where('id', $request->travelid)
          ->update(
          ['date' => $request->date,
           'client' => $request->client,
           'mode_of_travel' => $request->mode_of_travel,
           'travel_from' => $request->travel_from,
           'travel_to' => $request->travel_to,
           'amount' => $request->amount,
           'trip' => $request->trip,
           'delflg' => '0',
           'Emp_ID' => $request->traexpid,
           'others' => $request->others,
           'month' => $request->month,
           'enddate' => $request->enddate,
           'updated_time' => date('Ymdhis'),
           'updated_by' => Auth::user()->FirstName]
        );
    return $updatedb;
  }
}