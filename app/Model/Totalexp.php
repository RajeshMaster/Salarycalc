<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Carbon\Carbon;
class Totalexp extends Model{

   public static function index($request,$pass_date) {
      $db = DB::connection('mysql_MB');
      if(!isset($request->plimit) || $request->plimit =="" ) {
        $request->plimit = 50;
      }

        $employees = $db->TABLE(DB::raw('(SELECT Emp_ID, Date AS date FROM mstexpenses_dtl WHERE Del_Flg = 0 AND SUBSTRING(Date, 1, 7) = "'.$pass_date.'" GROUP BY Emp_ID UNION SELECT Emp_ID, date FROM tbl_localtravel WHERE CASE WHEN tbl_localtravel.trip != 3 THEN SUBSTRING(date, 1, 7) = "'.$pass_date.'" ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = "'.$pass_date.'" ELSE SUBSTRING(date, 1, 7) = "'.$pass_date.'" END END GROUP BY Emp_ID) AS loc'))
                  ->select('loc.Emp_ID','emp.FirstName','emp.LastName');
        $employees = $employees->leftJoin('emp_mstemployees AS emp', 'loc.Emp_ID', '=', 'emp.Emp_ID')
                  ->WHERE('emp.delFlg', '=', 0);
                  // ->WHERE('emp.resign_id', '=', 0);
        $employees = $employees->where(function($joincont) use ($request) {
                      $joincont->where('emp.Title', '=', 2)
                               ->orWhere('emp.Title', '=', 3);
                      })
                  ->GROUPBY('loc.Emp_ID')
                  ->ORDERBY('Emp_ID', $request->sortOrder)
                  ->paginate($request->plimit);
      return $employees;
   }

   public static function fnGetLocalTravelCalenderBar() {
        $db = DB::connection('mysql_MB');
        $dateex = $db->TABLE('mstexpenses_dtl')
                    ->SELECT(DB::raw("SUBSTRING(Date, 1, 4) AS year"), 
                            DB::raw("SUBSTRING(Date, 6, 2) AS month"))
                    ->WHERE('Del_Flg', '=', 0)
                    ->GROUPBY(DB::raw("SUBSTRING(Date, 1, 7)"));
        $date = $db->TABLE('tbl_localtravel')
                    ->SELECT(DB::raw("SUBSTRING(Date, 1, 4) AS year"), 
                            DB::raw("SUBSTRING(Date, 6, 2) AS month"))
                    ->GROUPBY(DB::raw("SUBSTRING(Date, 1, 7)"))
                    ->UNION($dateex)
                    ->ORDERBY('year', 'ASC')
                    ->get();
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
      if($request->table == "tbl_localtravel"){
        $columnname = "paid_date";
      } else {
        $columnname = "Paid_Date";
      }
      $update = $db->table($request->table)
              ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
              ->WHERE('Emp_ID','=', $request->empid)
              ->update([$columnname => $request->paid_date]);
      return $update;
  }


  public static function updatecfpaidsate($request) {
    $db = DB::connection('mysql_MB');
    if($request->locid != ""){
      $update=$db->table('tbl_localtravel')
                ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
                ->WHERE('Emp_ID','=', $request->empid)
                ->update(
                ['paid_date' => $request->paid_date]
              );
    }
    if($request->exid != ""){
      $update = $db->table('mstexpenses_dtl')
              ->WHERE('date', 'LIKE', '%' . $request->pass_date . '%')
              ->WHERE('Emp_ID','=', $request->empid)
              ->update(
              ['Paid_Date' => $request->paid_date]
            );
    } 
    return $update;
  }


  public static function paiddate($request) {
    $db = DB::connection('mysql_MB');
    if($request->table == "tbl_localtravel"){
      $columnname = "paid_date";
    } else {
      $columnname = "Paid_Date";
    }
    $paiddate = $db->table($request->table)
                ->select($columnname.' AS paid_date')
                ->where('id', $request->id)
                ->get();
    return $paiddate;
  }


  public static function revertreg($request) {
    $db = DB::connection('mysql_MB');
    if($request->revert1 != ""){
      $update = $db->table('tbl_localtravel')
          ->WHERERAW(DB::raw("Emp_ID = '".$request->empiddb."' AND CASE WHEN tbl_localtravel.trip!='3' THEN SUBSTRING(date, 1, 7) = '".$request->date."' ELSE CASE 
            WHEN month IS NOT NULL THEN SUBSTRING(month, 1, 7) = '".$request->date."' ELSE SUBSTRING(date, 1, 7) = '".$request->date."' END END"))
          ->update(
          ['dofsubmission' => null,
          'confirmFlg' => '0',
          'revertFlg' => '1']
        );
    }
    if($request->revert2 != ""){
      $update = $db->table('mstexpenses_dtl')
                ->WHERERAW(DB::raw("Emp_ID = '".$request->empiddb."' AND SUBSTRING(Date, 1, 7) = '".$request->date."'"))
                ->update(
                ['Dof_Submission' => null,
                'confirmFlg' => '0',
                'revertFlg' => '1']
              );
    } 
    return $update;
  }


  public static function fetchloctravel($empid,$pass_date) {
      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE(DB::raw('(SELECT *, IF (trip = 3, 1, trip) AS trip1, IF (use_flg = 1, 0, amount) AS amount1 FROM tbl_localtravel WHERE CASE WHEN trip != 3 THEN SUBSTRING(date,1,7) = "'.$pass_date.'" ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month,1,7) = "'.$pass_date.'" ELSE SUBSTRING(date,1,7) = "'.$pass_date.'" END END AND Emp_ID = "'.$empid.'" ORDER BY Emp_ID ASC, date DESC) AS tbl_localtravel'))
                ->SELECT('tbl_localtravel.*',DB::raw('SUM(amount1 * trip1) AS grandtotal'))
                ->GROUPBY('tbl_localtravel.Emp_ID')
                ->ORDERBY('tbl_localtravel.created_time', 'DESC')
                ->get();
      return $employees;
  }


  public static function fetchexpense($empid,$pass_date) {
      $db = DB::connection('mysql_MB');
      $employees = $db->TABLE(DB::raw('(SELECT * FROM mstexpenses_dtl WHERE SUBSTRING(Date, 1, 7) = "'.$pass_date.'" AND Emp_ID = "'.$empid.'" ORDER BY Emp_ID ASC, Date DESC) AS mstexpenses_dtl'))
                  ->SELECT('mstexpenses_dtl.*',DB::raw('SUM(Amount) AS grandtotal'))
                  ->GROUPBY('mstexpenses_dtl.Emp_ID')
                  ->ORDERBY('mstexpenses_dtl.Ins_DT', 'DESC')
                  ->ORDERBY('mstexpenses_dtl.Ins_TM', 'DESC')
                  ->get();
      return $employees;
  }


  public static function fetchloctraveltot($pass_date) {
      $db = DB::connection('mysql_MB');
      $localtraveltotal = $db->SELECT(DB::raw('SELECT SUM(amount1 * trip1) AS grandtotals from (SELECT IF (trip = 3, 1, trip) AS trip1, IF (use_flg = 1, 0, amount) AS amount1 FROM tbl_localtravel as loc left join `emp_mstemployees` as `emp` on `loc`.`Emp_ID` = `emp`.`Emp_ID` WHERE CASE WHEN trip != 3 THEN SUBSTRING(date,1,7) = "'.$pass_date.'" ELSE CASE WHEN month IS NOT NULL THEN SUBSTRING(month,1,7) = "'.$pass_date.'" ELSE SUBSTRING(date,1,7) = "'.$pass_date.'" END END and `emp`.`delFlg` = 0 and (`emp`.`Title` = 2 or `emp`.`Title` = 3)) AS tbl_localtravel '));
      return $localtraveltotal;
  }


  public static function fetchexptot($pass_date) {
      $db = DB::connection('mysql_MB');
      $exptotal = $db->SELECT(DB::raw('SELECT SUM(Amount) AS expgrandtotals FROM (SELECT Amount FROM mstexpenses_dtl as loc left join `emp_mstemployees` as `emp` on `loc`.`Emp_ID` = `emp`.`Emp_ID` WHERE SUBSTRING(Date, 1, 7) = "'.$pass_date.'" and `emp`.`delFlg` = 0  and (`emp`.`Title` = 2 or `emp`.`Title` = 3) ) as exp'));
      return $exptotal;
  }

  // For SalaryReg Data - Madasamy 09/07
  public static function fetchSalaryRegData($Emp_ID,$year,$month) {
      $db = DB::connection('mysql');
      $query = $db->table('inv_salary_main')
                  ->Select('train_daily',
                            'others')
                  ->Where('Emp_ID','=',$Emp_ID)
                  ->Where('year','=',$year)
                  ->Where('month','=',$month)
                  ->get();
      return $query;
  }

  public static function fetchTrainDailyTotal($year,$month) {
      $db = DB::connection('mysql');
      $query = $db->table('inv_salary_main')
                  ->Select(DB::raw('SUM(train_daily) as train_dailyTot'))
                  ->Where('year','=',$year)
                  ->Where('month','=',$month)
                  ->get();
      return $query;
  }

  public static function fetchExpensesTotal($year,$month) {
      $db = DB::connection('mysql');
      $query = $db->table('inv_salary_main')
                  ->Select(DB::raw('SUM(others) as othersTot'))
                  ->Where('year','=',$year)
                  ->Where('month','=',$month)
                  ->get();
      return $query;
  }

}