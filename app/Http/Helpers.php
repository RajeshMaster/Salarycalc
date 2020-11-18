<?php
namespace App\Http;
use stdClass;
use Session;
use DB;
use Config;
use Input;
use File;
use DateTime;
class Helpers {
	public static function array_to_obj($array, &$obj) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$obj->$key = new stdClass();
				self::array_to_obj($value, $obj->$key);
			} else {
				$obj->$key = $value;
			}
	 	 }
		return $obj;
	}
	public static function displayYear_MonthEst($account_period, $year_month, $db_year_month, $seldate, 
													$dbnext, $dbprevious, $lastyear, $currentyear, $account_val) {
			//SYSTEM CURRENT YEAR
			if (empty($seldate)) {
				$sys_cur_month=date('n');
				$sys_cur_year=date('Y');
			} else {
				$split_seldate = explode('-', $seldate);
				$sys_cur_month=$split_seldate[1];
				$sys_cur_year=$split_seldate[0];
			}
			$n_mnt = "";
			$n_yr = "";
			$p_filename = "";
			$n_filename = "";
			$nextcnt = count($dbnext);
			if (count($dbnext) > 0) {
				$splitval = explode('-', current($dbnext));
				$n_mnt = $splitval[1];
				$n_yr = $splitval[0];
				$n_filename = "nextenab.png";
			} else {
				$n_filename = "nextdisab.png";
			}

			$p_mnt = "";
			$p_yr = "";
			$prevcnt = count($dbprevious);
			if (count($dbprevious) > 0) {
				$splitval = explode('-', end($dbprevious));
				$p_mnt = $splitval[1];
				$p_yr = $splitval[0];
				$p_filename = "previousenab.png";
			} else {
				$p_filename = "previousdisab.png";
			} 
			if($prevcnt!=0){
				$style="style='cursor:pointer'";
			}else{
				$style="style='cursor:default'";
			}
			if($nextcnt!=0){
				$style1="style='cursor:pointer'";
			}else{
				$style1="style='cursor:default'";
			}

			$count_yrs=count($year_month);
			//YEAR ROW
			echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:0px;height:25px;\"><div style=\"margin-top:2px;\">&nbsp;&nbsp;";
			echo "<span $style><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15' onclick = 'return getData($p_mnt,$p_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val - 1))';></span>&nbsp;";
			echo "<b>".$account_val."&nbsp;期</b>&nbsp;";
			echo "<span $style1><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15' onclick = 'return getData($n_mnt,$n_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val + 1))';></span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

			foreach ($year_month AS $year => $montharr) {
				if ($year == $sys_cur_year) {
					echo "<span class=\"currentheader\">&nbsp;".$year."年&nbsp;</span>&nbsp";
				} else {
					echo "&nbsp;&nbsp;".$year."年&nbsp;";
				}
				foreach ($montharr AS $month => $monthval) {
					if ($month == $sys_cur_month) {
						echo "<span class=\"currentheader\">&nbsp;".$month."月&nbsp;</span>&nbsp";
					} else if (isset($db_year_month[$year][$month]) && $month == $db_year_month[$year][$month]) {
						$mon = substr("0" . $month, -2);
						echo "<span class=\"spnOver\"><a href=\"javascript:getData('$mon','$year', 0, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, $account_val);\" class=\"bordera\">&nbsp;".$month."月&nbsp;</a></span>";
					} else {
						echo "&nbsp;".$month."月&nbsp;";
					}
				}
				echo "&nbsp;&nbsp;";
			}
			echo "</div></div>";
		}
		//年月public 
		public static function displayYear_Monthtimesheet($account_period, $year_month, $db_year_month, $seldate, $dbnext, $dbprevious, $lastyear, $currentyear, $account_val) {
			//SYSTEM CURRENT YEAR
			if (empty($seldate)) {
				$sys_cur_month=date('n');
				$sys_cur_year=date('Y');
			} else {
				$split_seldate = explode('-', $seldate);
				$sys_cur_month=$split_seldate[1];
				$sys_cur_year=$split_seldate[0];
			}
			$n_mnt = "";
			$n_yr = "";
			$p_filename = "";
			$n_filename = "";
			$nextcnt = count($dbnext);
			if (count($dbnext) > 0) {
				$splitval = explode('-', current($dbnext));
				$n_mnt = $splitval[1];
				$n_yr = $splitval[0];
				$n_filename = "nextenab.png";
			} else {
				$n_filename = "nextdisab.png";
			}
			$p_mnt = "";
			$p_yr = "";
			$prevcnt = count($dbprevious);
			if (count($dbprevious) > 0) {
				$splitval = explode('-', end($dbprevious));
				$p_mnt = $splitval[1];
				$p_yr = $splitval[0];
				$p_filename = "previousenab.png";
			} else {
				$p_filename = "previousdisab.png";
			}
			if($prevcnt!=0){
				$style="style='cursor:pointer'";
			}else{
				$style="style='cursor:default'";
			}
			if($nextcnt!=0){
				$style1="style='cursor:pointer'";
			}else{
				$style1="style='cursor:default'";
			}
			$count_yrs=count($year_month);
			//YEAR ROW
			echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:0px;height:25px;\"><div style=\"margin-top:2px;\">&nbsp;&nbsp;";
			echo "<span $style><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15' onclick = 'return getData($p_mnt,$p_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val - 1))';></span>&nbsp;";
			echo "<b>".$account_val."&nbsp;期</b>&nbsp;";
			echo "<span $style1><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15' onclick = 'return getData($n_mnt,$n_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val + 1))';></span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			foreach ($year_month AS $year => $montharr) {
				if ($year == $sys_cur_year) {
					echo "<span class=\"currentheader\">&nbsp;".$year."年&nbsp;</span>&nbsp";
				} else {
					echo "&nbsp;&nbsp;".$year."年&nbsp;";
				}
				foreach ($montharr AS $month => $monthval) {
					if (isset($db_year_month[$year][$month])) {
						$db_year_month[$year][$month] = $db_year_month[$year][$month];
					} else {
						$db_year_month[$year][$month] = "";
					}
					if ($month == $sys_cur_month) {
						echo "<span class=\"currentheader\">&nbsp;".$month."月&nbsp;</span>&nbsp";
					} else if ($month == $db_year_month[$year][$month]) {
						$mon = substr("0" . $month, -2);
						echo "<span class=\"spnOver\"><a href=\"javascript:getData('$mon','$year', 0, 
						$prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, $account_val);\" 
						class=\"bordera\">&nbsp;".$month."月&nbsp;</a></span>";
					} else {
						echo "&nbsp;".$month."月&nbsp;";
					}
				}
				echo "&nbsp;&nbsp;";
			}
			echo "</div></div>";
		}
	public static function displayYear_Monthpayment($account_period, $year_month, 								$db_year_month, $seldate,$dbnext, $dbprevious, $lastyear,$currentyear, $account_val) {
			//SYSTEM CURRENT YEAR
			if (empty($seldate)) {
				$sys_cur_month=date('n');
				$sys_cur_year=date('Y');
			} else {
				$split_seldate = explode('-', $seldate);
				$sys_cur_month=$split_seldate[1];
				$sys_cur_year=$split_seldate[0];
			}
			$n_mnt = "";
			$n_yr = "";
			$p_filename = "";
			$n_filename = "";
			$nextcnt = count($dbnext);
			if (count($dbnext) > 0) {
				$splitval = explode('-', current($dbnext));
				$n_mnt = $splitval[1];
				$n_yr = $splitval[0];
				$n_filename = "nextenab.png";
			} else {
				$n_filename = "nextdisab.png";
			}

			$p_mnt = "";
			$p_yr = "";

			$prevcnt = count($dbprevious);
			if (count($dbprevious) > 0 && isset($dbprevious[1])) {
				$splitval = explode('-', end($dbprevious));
				$p_mnt = $splitval[1];
				$p_yr = $splitval[0];
				$p_filename = "previousenab.png";
			} else {
				$p_filename = "previousdisab.png";
			} 
			if($prevcnt!=0){
				$style="style='cursor:pointer'";
			}else{
				$style="style='cursor:default'";
			}
			if($nextcnt!=0){
				$style1="style='cursor:pointer'";
			}else{
				$style1="style='cursor:default'";
			}

			$count_yrs=count($year_month);
			//YEAR ROW
			echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:0px;height:25px;\"><div style=\"margin-top:2px;\">&nbsp;&nbsp;";
			echo "<span $style><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15' onclick = 'return getData($p_mnt,$p_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val - 1))';></span>&nbsp;";
			echo "<b>".$account_val."&nbsp;期</b>&nbsp;";
			echo "<span $style1><img style=\"vertical-align:middle;padding-bottom:3px;\" src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15' onclick = 'return getData($n_mnt,$n_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val + 1))';></span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

			foreach ($year_month AS $year => $montharr) {
				if ($year == $sys_cur_year) {
					echo "<span class=\"currentheader\">&nbsp;".$year."年&nbsp;</span>&nbsp";
				} else {
					echo "&nbsp;&nbsp;".$year."年&nbsp;";
				}
				foreach ($montharr AS $month => $monthval) {
					if ($month == $sys_cur_month) {
						echo "<span class=\"currentheader\">&nbsp;".$month."月&nbsp;</span>&nbsp";
					} else if (isset($db_year_month[$year][$month]) && $month == $db_year_month[$year][$month]) {
						$mon = substr("0" . $month, -2);
						echo "<span class=\"spnOver\"><a href=\"javascript:getData('$mon','$year', 0, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, $account_val);\" class=\"bordera\">&nbsp;".$month."月&nbsp;</a></span>";
					} else {
						echo "&nbsp;".$month."月&nbsp;";
					}
				}
				echo "&nbsp;&nbsp;";
			}
			echo "</div></div>";
		}
	public static function ordinalize($num) {
		$suff = 'th';
        if ( ! in_array(($num % 100), array(11,12,13))){
            switch ($num % 10) {
                case 1:  $suff = 'st'; break;
                case 2:  $suff = 'nd'; break;
                case 3:  $suff = 'rd'; break;
            }
            return "{$num}{$suff}";
        }
        return "{$num}{$suff}";
	}
	function singlefieldlength($stringname, $len=null)
    {
        if (mb_strlen($stringname,'UTF-8')> $len) {
            $stringname=mb_substr($stringname, 0, $len,'UTF-8')."...";
            return $stringname;
        }
        return $stringname;
    }
    public static function fnGetTaxDetails($quotdate) {
    	$Estimate = db::table('dev_taxdetails')
									->select('*')
									->where('Startdate','<=',$quotdate)
									->WHERE('delflg',0)
									->orderBy('Startdate', 'DESC')
									->orderBy('Ins_TM', 'DESC')
									->LIMIT(1)
									->get();
			return $Estimate;
    }
    public static function displayYearMon_view($search_flg,$totalRec,$currentRec,
													$date_month,$get_view,$curTime,$order,$sort,$invid) {
			//SYSTEM CURRENT YEAR
			if (empty($date_month)) {
				$sys_cur_month=date('n');
				$sys_cur_year=date('Y');
			} else {
				$split_seldate = explode('-', $date_month);
				$sys_cur_month=$split_seldate[1];
				$sys_cur_year=$split_seldate[0];
			}
			$p_filename = "";
			$n_filename = "";
			
			if ($totalRec > $currentRec) {
				$n_filename = "nextenab.png";
				$stylePre = "style='cursor:pointer'";
			} else {
				$n_filename = "nextdisab.png";
				$stylePre = "style='cursor:default'";
			}
			if ( 1 < $currentRec ) {
				$p_filename = "previousenab.png";
				$stylePost = "style='cursor:pointer'";
			} else {
				$p_filename = "previousdisab.png";
				$stylePost = "style='cursor:default'";
			}
			if ( $order == "DESC" ) {
				$currentRec1 = $currentRec+1;
			} else{
				$currentRec1 = $currentRec-1;
			}
			if (isset($get_view[$currentRec - 1]['id'])) {
				$get_view[$currentRec - 1]['id'] = $get_view[$currentRec - 1]['id'];
			} else {
				$get_view[$currentRec - 1]['id'] = 0;
			}
			if (isset($get_view[$currentRec + 1]['id'])) {
				$get_view[$currentRec + 1]['id'] = $get_view[$currentRec + 1]['id'];
			} else {
				$get_view[$currentRec + 1]['id'] = 0;
			}
			$get_viewleft = $get_view[$currentRec - 1]['id'];
			$get_viewright = $get_view[$currentRec + 1]['id'];
			if (!empty($search_flg)) {
				$mon_select_val= "<b>".$currentRec."/".$totalRec."&nbsp;</b>&nbsp;";
			}else{
				$mon_select_val= "<b>".$sys_cur_month."&nbsp;月分"." ".$currentRec."/".$totalRec."&nbsp;</b>&nbsp;";
			}
			//YEAR ROW
			//echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:-18px;height:20px;\"><div style=\"background-color: #FFFFFF;margin-top:2px;\">&nbsp;&nbsp;";
			if ($currentRec == 1) {
				echo "<span $stylePost><img class='vam' src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15'></span>&nbsp;";
			} else {
				echo "<span $stylePost><img class='vam' src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15' onclick = 'return getData_view($totalRec,$currentRec-1,$date_month,$get_viewleft,$curTime,$invid)';></span>&nbsp;";
			}

			    echo $mon_select_val;

			if ($currentRec == $totalRec) {
				echo "<span $stylePre><img class='vam' src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15'></span>&nbsp;";
			} else {
				echo "<span $stylePre><img class='vam' src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15' onclick = 'return getData_view($totalRec,$currentRec+1,$date_month,$get_viewright,$curTime,$invid)';></span>&nbsp;";
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
    public static function fnfetchinvoicebalance($did){
    	$db=DB::connection('mysql');
		$query=$db->TABLE($db->raw("(SELECT invoice_id,id,totalval,paid_id,
						(SELECT SUM(replace(deposit_amount, ',', '')) 
						FROM dev_payment_registration WHERE invoice_id = '$did') 
						as deposit_amount FROM dev_payment_registration 
						WHERE invoice_id = '$did' ORDER BY id DESC) as tb1"))
					->get();
		return $query;
    }
    public static function checkTELFAX($str) {
			$rval = "";
			if (!empty($str)) {
				if (strlen($str) == 10) {
					$rval = substr($str, 0, 2) . '-' . substr($str, 2, 4) . '-' . substr($str, 6);
					return $rval;
				} else if (strlen($str) == 11) {
					$rval = substr($str, 0, 3) . '-' . substr($str, 3, 4) . '-' . substr($str, 7);
					return $rval;
				} else {
					return $str;
				}
			} else {
				return $str;
			}
		}
	public static function displayYear_MonthEst1($account_period, $year_month, $db_year_month, $seldate, $dbnext, $dbprevious, $lastyear, $currentyear, $account_val) {
			if (empty($seldate)) {
				$sys_cur_month=date('n');
				$sys_cur_year=date('Y');
			} else {
				$split_seldate = explode('-', $seldate);
				$sys_cur_month=$split_seldate[1];
				$sys_cur_year=$split_seldate[0];
			}
			$n_mnt = "";
			$n_yr = "";
			$p_filename = "";
			$n_filename = "";
			$nextcnt = count($dbnext);
			if (count($dbnext) > 0) {
				$splitval = explode('-', current($dbnext));
				$n_mnt = $splitval[1];
				$n_yr = $splitval[0];
				$n_filename = "nextenab.png";
			} else {
				$n_filename = "nextdisab.png";
			}
			$p_mnt = "";
			$p_yr = "";
			$prevcnt = count($dbprevious);
			if (count($dbprevious) > 0) {
				$splitval = explode('-', end($dbprevious));
				$p_mnt = $splitval[1];
				$p_yr = $splitval[0];
				$p_filename = "previousenab.png";
			} else {
				$p_filename = "previousdisab.png";
			}
			$count_yrs=count($year_month);
			echo "<span style='cursor:pointer'><img src='" . '../resources/assets/images/' . $p_filename . "' width='15' height='15' onclick = 'return getData($p_mnt,$p_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val - 1))';></span>&nbsp;";
			echo "<b>".$account_val."&nbsp;期</b>&nbsp;";
			echo "<span style='cursor:pointer'><img src='" . '../resources/assets/images/' . $n_filename . "' width='15' height='15' onclick = 'return getData($n_mnt,$n_yr, 1, $prevcnt, $nextcnt, $account_period,$lastyear, $currentyear, ($account_val + 1))';></span>&nbsp;";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	// Start Madasamy Code 23/05/20
	public static function displayYear_Month($prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime){
      //SYSTEM CURRENT YEAR
      $months[] = "";
      $sys_cur_month=date('m');
      $sys_cur_year=date('Y');
      $count_yrs=count($total_yrs);
      //YEAR ROW
      echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:-18px;\"><div style=\"background-color: white;margin-top:0px;\">&nbsp;&nbsp;";
      if($count_yrs==0) {
        echo "<b>1&nbsp;年間</b>&nbsp;&nbsp;";
      } else {
        echo "<b>".$count_yrs."&nbsp;年間</b>&nbsp;&nbsp;";
      }
      if($count_yrs==0){
        echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$sys_cur_year."年&nbsp;</span>&nbsp;＞＞";
      } else if($count_yrs==1){
        echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$total_yrs[0]."年&nbsp;</span>&nbsp;＞＞";
      } else if($count_yrs<=2){
        $cnt=$count_yrs-1;
        echo "<span>＜＜</span>";
        for($year=0;$year<$count_yrs;$year++){
          if($cur_year==$total_yrs[$year]){
            echo "<span class=\"currentheader\">&nbsp;".$cur_year."年&nbsp;</span>&nbsp;";
          } else {
            $yr=$total_yrs[$year];
            echo "<span class=\"spnOver\"><a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">&nbsp;".$yr."年&nbsp;</a></span>&nbsp;";
          }
        }
        echo "<span>＞＞</span>";
      } else if($count_yrs>2){
        //FIND THE INDEX OF THE SELECTED YEAR
        $inx=0;
        $cnt=$count_yrs;
        for($year=0;$year<$count_yrs;$year++){
          if($cur_year==$total_yrs[$year]){
            $inx=$year;
          }
        }
        if($inx==0){            //FIRST YEAR
          echo "<span>＜＜</span>";
          echo "<span class=\"currentheader \">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>&nbsp;";
          $yr=$total_yrs[$inx+1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>";
          $yr=$total_yrs[$inx+2];
          /*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
           $yr=$total_yrs[$inx+3];*/
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
        }else if($inx==$cnt-1){       //LAST YEAR
          $yr=$total_yrs[$inx-2];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
          /*$yr=$total_yrs[$inx-2];
           echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";*/
          $yr=$total_yrs[$inx-1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
          echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
          echo "<span>＞＞</span>";
        }else{                //OTHERWISE
          // else if for no previous year identification(updated on 2019-12-26).
          if($inx-2 >= 0) {
            $yr=$total_yrs[$inx-2]; 
          } else if($inx-1 == 0) {
            // $yr = $total_yrs[$inx-1]; 
            $yr = ""; 
          } else  {
            $yr=$total_yrs[$inx]; 
          }
          if($yr==''){
            echo "<span>＜＜</span>";
          }else{
            echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
          }
          $yr=$total_yrs[$inx-1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
          echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
          $yr=$total_yrs[$inx+1];
          /*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
           $yr=$total_yrs[$inx+2];*/
          if($yr==''){
            echo "<span>＞＞</span>";
          }else{
            echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
          }
        }
      }
      echo "&nbsp;&nbsp;";
      //FIND THE MONTHS WHICH HAS DATA FOR SELECTED YEAR
      for($i=0;$i<count($prev_yrs);$i++){
        if($cur_year==$prev_yrs[$i][0]){
          $months=$prev_yrs[$i];
        }
      }
      //MONTH ROW
      for($month=1;$month<=12;$month++){
        if($month==$cur_month){
          echo "&nbsp;<span class=\"currentheader\">&nbsp;".$month."月&nbsp;</span>&nbsp;";
        }else if(count($months)<1 || array_search($month, $months)==NULL){
          
          echo "&nbsp;&nbsp;".$month."月&nbsp;";
        }else if(($month<$cur_month)&&($month<=$sys_cur_month)){
          
          $mon=str_pad($month,2,"0",STR_PAD_LEFT);
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
        }else if($month<=$sys_cur_month){
          
          $mon=str_pad($month,2,"0",STR_PAD_LEFT);
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
        }else if($cur_year<$sys_cur_year){
          
          $mon=str_pad($month,2,"0",STR_PAD_LEFT);
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
        }else{
          
          echo $month."月&nbsp;";
        }
      }
      echo "</div></div>";
    }

    public static function workinghourscalculation($user_id,$date)
    {
      $actual_val="";
      $submit="";
      $workplace="";
      $createdate="";
      $upload_path="";
      $array=array(0,0,0,0,0,0,0,0,0,0);
      $extra=0;
      $db = DB::connection('mysql_MB');
      $query=$db->table('tbl_time_sheet_download')
                   ->SELECT('*')
                   ->WHERE('emp_id','=',$user_id)
                   ->WHERE('workdate', 'LIKE', $date . '%')
                   ->get();
      foreach ($query as $key => $val) {
        $start=$val->starttime;
        $end=$val->endtime;
        $nonstart=$val->non_work_starttime;
        $nonend=$val->non_work_endtime;
        $section=$val->section;
        if ($val->section != "" && $val->section != 'null') {
          $array[$section]++;
        }
        if (!empty($val->workingplace)) {
          $workplace=$val->workingplace;
        }
        if (!empty($val->submit_date)) {
          $submit=$val->submit_date;
        }    
        $result=self::calval($start,$end,$nonstart,$nonend);
        $workdate=$val->workdate;
        $timestamp = strtotime($workdate);
        $temp=date('N', $timestamp);
        $createdate=$val->created_date;
        $upload_path=$val->upload_path;
        if(($temp==6 && ($val->starttime!='' && $val->starttime!='00:00:00' ) && ($val->endtime!=''  && $val->endtime!='00:00:00')) 
          || ($temp==7 && ($val->starttime!='' && $val->starttime!='00:00:00' ) && ($val->endtime!=''  && $val->endtime!='00:00:00')))
          {
            $extra++;
          }
          $actual_val=$actual_val+$result[4]; 
      }
      $arr=array($array,$actual_val,$workplace,$extra,$createdate,$submit,$upload_path);
      return $arr;
    }

	public static function toConvertDoubleByteValWareki($date) {
		$aucVal = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
		$dbVal = array('０','１','２','３','４','５','６','７','８','９');
		$return_date = '';

		if (strlen($date) == 21) {
			$w_year = substr($date, 0, 6);
			$nen = substr($date , 8, 3);
			$mon = substr($date, 13, 3);
			$day = substr($date, 18, 3);

			$num_val = substr($date, 6, 2) . substr($date, 11, 2) . substr($date, 16, 2);

			for ($i = 0; $i < strlen($num_val); $i++) {
				if (in_array(substr($num_val, $i, 1), $aucVal)) {
					$key = array_search(substr($num_val, $i, 1), $aucVal);
					$return_date .= $dbVal[$key];
				}
			}
			$return_date = $w_year . " " . substr($return_date, 0, 6) . $nen . " " . substr($return_date, 6, 6) . $mon . " " . substr($return_date, 12, 6) . $day;
			return $return_date;
		} else {
			return $date;
		}
	}

    public static function fnYMChangeWareki($sYMD) {
      $aNengo     = array("＊＊", "明治", "大正", "昭和", "平成", "令和", "＊＊");
      $aNengoYYYY = array(0000, 1868, 1912, 1926, 1989, 2019, 9999);
      $aNengoYMD  = array(00000000, 18680908, 19120730, 19261225, 19890108, 20190501, 99991231);

      if (strlen($sYMD) != 8) {
        return $sYMD;
      } else {
        foreach ($aNengo as $i => $value) {
          if ($aNengoYMD[$i] > substr($sYMD, 0, 8)) {
            return $aNengo[$i-1] .substr(("0" . (substr($sYMD, 0, 4) - $aNengoYYYY[$i-1] + 1)), strlen("0" . (substr($sYMD, 0, 4) - $aNengoYYYY[$i-1] + 1)) - 2, 2) . "年" .substr($sYMD, 4, 2) . "月" . substr($sYMD, 6, 2) . "日";
          }
        }
      }

      return "";
    }

    public static function fnGetTravelMode($index){
        if (Session::get('languageval') == "en") {
          $travel_mode_array = array(1 => "Train", 2 => "Subway", 3 => "Bus", 4 => "Taxi", 
                         6 => "Train & Bus", 5 => "Others");
        } else {
          $travel_mode_array = array(1 => "電車", 2 => "地下鉄", 3 => "バス", 4 => "タクシー", 6 => "電車とバス", 5 => "その他");
        }
      return $travel_mode_array[$index];
    }
    public static function getceryear($id) {
      $romannum = array('0'=> "NIL",'1'=> "I",'2'=> "II",'3'=> "III",'4'=> "IV",'5'=> "V",'6'=> "VI",'7'=> "VII",'8'=> "VIII",'9'=> "IX",'10'=> "X");
      
      return $romannum[$id];
    // return array('1'=>$msg = "I",'2'=>$msg = "II",'3'=>$msg = "III",'4'=>$msg = "IV",'5'=>$msg = "V",'6'=>$msg = "VI",'7'=>$msg = "VII",'8'=>$msg = "VIII",'9'=>$msg = "IX",'10'=>$msg = "X");
    }
    private static function calval($workstart,$workend,$nonstart,$nonend)
    {
      $detuctionhours = "";
      $nonworktime = "";
      $deductionminutes = "";
      $startTime = $workstart;
      $endTime   = $workend;
      $permissionstart=$nonstart;
      $permissionend=$nonend;
      //$diff = $endTime - $startTime;
      //$temp=abs($diff);
      //$difference=$temp/60;
      /////////////////////////////////////////
      if (isset($startTime)) {
        $startTimeArray = explode(':',$startTime);
        $startInputHrs = $startTimeArray[0];
        $startInputMins = $startTimeArray[1];
        $dumi = $startTimeArray[2];
      } else {
        $startInputHrs ="00";
        $startInputMins = "00";
        $dumi = "00";
      }
      if (isset($endTime)) {
        $endTimeArray = explode(':',$endTime);
        $endInputHrs = $endTimeArray[0];
        $endInputMins = $endTimeArray[1];
        $dumy = $endTimeArray[2];
      } else {
        $endInputHrs = "00";
        $endInputMins = "00";
        $dumy = "00";
      }
      $startMin = $startInputHrs*60 + $startInputMins;
      $endMin = $endInputHrs*60 + $endInputMins;
      ///////////////////////////////////////////////////
      if ($permissionend) {
        $nonstartTimeArray = explode(':',$permissionstart);
        $nonstartInputHrs = $nonstartTimeArray[0];
        $nonstartInputMins = $nonstartTimeArray[1];
        $nonendTimeArray = explode(':',$permissionend);
        $nonendInputHrs = $nonendTimeArray[0];
        $nonendInputMins = $nonendTimeArray[1];
        $nonstartMin = $nonstartInputHrs*60 + $nonstartInputMins;
        $nonendMin = $nonendInputHrs*60 + $nonendInputMins;
        $nonworktime;
         if ($nonendMin < $nonstartMin) {
            $nonminutesPerDay = 24*60; 
            $nonworktime = $nonminutesPerDay - $nonstartMin;  // Minutes till midnight
            $nonworktime += $nonendMin; // Minutes in the next day
        } else {
          $nonworktime = $nonendMin - $nonstartMin;
        }
      } 
      $lunch=13*60;
      $break1=19*60;
      $break2=22*60;
      $late=22*60 + 30;
      $latenight=0;
      $overtime=0;
      $tem;
      $deduction=0;
      $result=0;
      if ($endMin   < $startMin) {
         $minutesPerDay = 24*60;
        $result = $minutesPerDay - $startMin; // Minutes till midnight
        $result += $endMin; /// Minutes in the next day
      } else {
        if ($endMin > $break2) {
          if ($endMin > $break2 && $endMin < 1350 && $startMin < 840) {
            if($startMin > 780 && $startMin < 840) {
              if($endMin > $break2 && $endMin < 1350) {
                $tem2 = $endMin - $break2;
                $tem2=$tem2+30;
              } else {
                $tem2 = 60;
              }
               $lb=840-$startMin;
               $result = $endMin - $startMin - ($tem2+$lb);
               $overtime=$result - 8*60;
               $latenight=$endMin - $late;
               $latenight=$latenight<0?'':$latenight;
               $overtime=$overtime - $latenight;
            } else {
              $tem2=$endMin - $break2;
              $result = $endMin - $startMin - ($tem2+90);
              $overtime=$result - 8*60;
              $latenight=$endMin - $late;
              $latenight=$latenight<0?'':$latenight;
              $overtime=$overtime - $latenight;
            }        
          } else if($startMin >= 840 && $endMin < 1350) {
             $tem5=$endMin - $break2;
             $result = $endMin - $startMin - (30+$tem5);
             $overtime=$result - 8*60;
             $overtime=$overtime<0?'':$overtime; 
             $latenight=$endMin - $late;   
             $latenight=$latenight<0?'':$latenight;

          }
          else if($startMin >= 840 && $endMin > 1350) {
             $result = $endMin - $startMin - (60);                
             $overtime=$result - 8*60;              
             $overtime=$overtime<0?'':$overtime; 
             $latenight=$endMin - $late;          
          } else {
            $result = $endMin - $startMin - 120;
            $overtime=$result - 8*60;
            $latenight=$endMin - $late;
            $latenight=$latenight<0?'':$latenight;
            $overtime=$overtime - $latenight;   
          }
        } else if ($endMin  > $break1) {
          if (($endMin > $break1 && $endMin < 1170)||($startMin > 780)) {
            if($startMin > 780 && $startMin < 840) {
              if($endMin > $break1 && $endMin < 1170) {
                $tem1=$endMin - $break1;
              } else {
                $tem1=30;
              }
               $lb=840-$startMin;
               $result = $endMin - $startMin - ($tem1+$lb);
               $overtime=$result - 8*60;
               $overtime=$overtime<0?'':$overtime;
            } else if($startMin >= 840) {
              $tem1=$endMin - $break1;
              $result = $endMin - $startMin - ($tem1);
              $overtime=$result - 8*60;
              $overtime=$overtime<0?'':$overtime;  
            
            } else {
              $tem1=$endMin - $break1;
              $result = $endMin - $startMin - ($tem1+60);
              $overtime=$result - 8*60;
              $overtime=$overtime<0?'':$overtime;
            }
          } else {
            $result = $endMin - $startMin - 90;
            $overtime=$result - 8*60;
            $overtime=$overtime<0?'':$overtime;   
          }
        
      } else if ($endMin > $lunch) {
        if ($endMin > $lunch && $endMin < 14 * 60) {
          $tem=$endMin - $lunch;
          $result = $endMin - $startMin - $tem;
          //$overtime=$result - 8*60;
        } else if($startMin >= 840) {
          $tem1=$endMin - $break1;
          $result = $endMin - $startMin - ($tem1);
          $overtime=$result - 8*60;
          $overtime=$overtime<0?'':$overtime;  
          
        } else {
          $result = $endMin - $startMin - 60;
          $overtime=$result - 8*60;   
          $overtime=$overtime<0?'':$overtime;       
        }

      } else {
        $result = $endMin - $startMin;
        $overtime= $result - 8*60;
        $overtime=$overtime<0?'':$overtime;
      }

    }
         
   //Non Working 
    if ($nonworktime > 0) {
      //echo $nonworktime;
      $result = $result - $nonworktime;
      //$overtime = $overtime - $nonworktime;
      //$latenight = $latenight - $nonworktime;
      $nonminutes = $nonworktime % 60;
      $nonhours = ($nonworktime - $nonminutes) / 60;
    }
    if ($result < 480) {
      //echo $result;
      $deduction= 8*60 - $result;
      $deduction=$deduction<480?$deduction:"0:0";
      $deductionminutes = $deduction % 60;
      $detuctionhours = ($deduction - $deductionminutes) / 60;
      $detuctionhours=str_pad($detuctionhours,2,"0",STR_PAD_LEFT);
      $deductionminutes=str_pad($deductionminutes,2,"0",STR_PAD_LEFT);
    }
    if($endMin > 1560) {
      if (($endMin > 26*60) && ($endMin < 29 * 60)) {
        $morning=$endMin - 26*60;
        $result =$result - $morning;
        $latenight=$latenight - $morning;
      } else {
        $result =  $result - 180;
        $latenight=$latenight - 180;
      }
    }
    //RESULT 
    $actualminutes = $result % 60;
    $actualhours = ($result - $actualminutes)/60;
    $actualhours=str_pad($actualhours,2,"0",STR_PAD_LEFT);
    $actualminutes=str_pad($actualminutes,2,"0",STR_PAD_LEFT);
    $actual=$actualhours.":".$actualminutes;
    $overminutes = $overtime % 60;
    $overhours = ($overtime - $overminutes)/60;
    $overhours=str_pad($overhours,2,"0",STR_PAD_LEFT);
    $overminutes=str_pad($overminutes,2,"0",STR_PAD_LEFT);
    $over=$overhours.":".$overminutes;
    $lateminutes = $latenight % 60;
    $latehours = ($latenight - $lateminutes)/60;
    $latehours=str_pad($latehours,2,"0",STR_PAD_LEFT);
    $lateminutes=str_pad($lateminutes,2,"0",STR_PAD_LEFT);
    $la=$latehours.":".$lateminutes;
    $dut=$detuctionhours.":".$deductionminutes;
    $arr=array($actual,$over,$la,$dut,$result,$overtime,$latenight,$deduction);
  return $arr;
  }

  public static function displayYear($prev_yrs,$cur_year,$total_yrs,$curtime){
      //SYSTEM CURRENT YEAR
      $months[] = "";
      $sys_cur_month=date('m');
      $sys_cur_year=date('Y');
      $count_yrs=count($total_yrs);
      //YEAR ROW
      echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:-18px;\"><div style=\"background-color: white;margin-top:0px;\">&nbsp;&nbsp;";
      if($count_yrs==0) {
        echo "<b>1&nbsp;年間</b>&nbsp;&nbsp;";
      } else {
        echo "<b>".$count_yrs."&nbsp;年間</b>&nbsp;&nbsp;";
      }
      if($count_yrs==0){
        echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$sys_cur_year."年&nbsp;</span>&nbsp;＞＞";
      } else if($count_yrs==1){
        echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$total_yrs[0]."年&nbsp;</span>&nbsp;＞＞";
      } else if($count_yrs<=2){
        $cnt=$count_yrs-1;
        echo "<span>＜＜</span>";
        for($year=0;$year<$count_yrs;$year++){
          if($cur_year==$total_yrs[$year]){
            echo "<span class=\"currentheader\">&nbsp;".$cur_year."年&nbsp;</span>&nbsp;";
          } else {
            $yr=$total_yrs[$year];
            echo "<span class=\"spnOver\"><a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">&nbsp;".$yr."年&nbsp;</a></span>&nbsp;";
          }
        }
        echo "<span>＞＞</span>";
      } else if($count_yrs>2){
        //FIND THE INDEX OF THE SELECTED YEAR
        $inx=0;
        $cnt=$count_yrs;
        for($year=0;$year<$count_yrs;$year++){
          if($cur_year==$total_yrs[$year]){
            $inx=$year;
          }
        }
        if($inx==0) {            //FIRST YEAR
          echo "<span>＜＜</span>";
          echo "<span class=\"currentheader \">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>&nbsp;";
          $yr=$total_yrs[$inx+1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>";
          /*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
           $yr=$total_yrs[$inx+3];*/
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
        } else if($inx==$cnt-1){       //LAST YEAR
          $yr=$total_yrs[$inx-1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
          /*$yr=$total_yrs[$inx-2];
           echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";*/
          $yr=$total_yrs[$inx-1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
          echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
          echo "<span>＞＞</span>";
        } else {                //OTHERWISE
          if($inx-2 > 0) {
            $yr = $total_yrs[$inx-1]; 
          } else {
            $yr = $total_yrs[$inx-1]; 
          }
          if($yr==''){
            echo "<span>＜＜</span>";
          }else {
            echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
          }
          $yr=$total_yrs[$inx-1];
          echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
          echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
          $yr=$total_yrs[$inx+1];
          /*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
           $yr=$total_yrs[$inx+2];*/
          if($yr==''){
            echo "<span>＞＞</span>";
          }else{
            echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
          }
        }
      }
      echo "&nbsp;&nbsp;";
      echo "</div></div>";
    }
    public static function checkNationalHolidays($year , $month ,$date) {
	    $month = (int)$month;
	    $date = (int)$date;
	    $db = DB::connection('mysql_MB');
	    $sql= $db->table('mst_national_holiday')
	            ->SELECT(DB::raw('COUNT("id") AS id'))
	            ->where('year','=',$year)
	            ->where('month','=',$month)
	            ->where('date','=',$date)
	            ->where('delFlag','=',0)
	            ->get();
	    $status = false;
	    if($sql[0]->id == 1){
	      $status = true;
	    }
	    return $status;
	}
}