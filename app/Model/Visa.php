<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Session;
use Carbon\Carbon;
class Visa extends Model
{
   public static function visalist($request) {
      $db = DB::connection('mysql_MB');
        $joincondition = "";
        $wherecondition = "";
        if($request->mainmenu != "contractemp_visa") {
          $employee_tableName = "emp_mstemployees ";
        } else {
          $employee_tableName = "mst_contractemployees ";
        }
        if($request->visasort == "") {
          $request->visasort ='EdDate';
          $request->plimit ='50';
        }
        $employees = $db->table(DB::raw('(SELECT * FROM (SELECT * FROM mstalien WHERE EdDate IS NOT NULL ORDER BY EdDate DESC) AS t GROUP BY user_id) AS ma'))
                    ->SELECT('ma.id', 
                             'emp.Emp_ID AS user_id', 
                             'emp.FirstName', 
                             'emp.LastName', 
                             'emp.resign_id',
                             'ma.CardNo', 
                             'ma.NoYears', 
                             'ma.StDate', 
                             'ma.EdDate', 
                             'ma.VisaStatus', 
                             'ma.VisaPosition',
                              DB::raw("(SELECT SUM((Image1 IS NOT NULL AND Image1<>'')+(Image2 IS NOT NULL AND Image2<>'')+ (Image3 IS NOT NULL AND Image3<>'')+(Image4 IS NOT NULL AND Image4<>'')+ (Image5 IS NOT NULL AND Image5<>'')) as total FROM mstalien sub_ma WHERE sub_ma.id=ma.id) AS noOfImg"),
                              DB::raw("DATEDIFF(IFNULL(ma.EdDate,CURDATE()),CURDATE()) as Validity"),
                              'vs.VisaNM', 
                              'vp.VisaPosNM',
                              DB::raw("DATEDIFF(NOW(), ma.applydate) AS days_diff") );
        if ($request->filterval == 2) {
          // SATHISYS FILTER
          $join = "RIGHTJOIN";
          $wherecondition = $employees->where('emp.title', '=', 3)
                                      ->where('emp.resign_id', '=', 0);
          $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                          $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                          ->where( function($joincont) {
                                        $joincont->whereNull('ma.returnedplace')
                                                 ->orWhere('ma.returnedplace','=',2);
                                        })
                                    ->whereNull('ma.returnstatus');
                                      });
        } else if ($request->filterval == 3) {
          // COMPLETED FILTER
          $join = "LEFTJOIN";
          $wherecondition = $employees->where( function($joincont) {
                            $joincont->where('emp.title', '=', 1)
                                     ->orWhere('emp.title', '=', 2)
                                     ->orWhere('emp.title', '=', 3);
                            })
                       ->where( function($joincont) {
                            $joincont->where('emp.resign_id', '=', 1)
                                     ->orWhere('ma.returnedplace', '=', 1);
                            });
          $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                          $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                          ->where( function($joincont) {
                                        $joincont->whereNull('ma.returnedplace')
                                                 ->orWhere('ma.returnedplace','=',1);
                                        });
                                      });
        } else if ($request->filterval == 4) { 
          $join = "RIGHTJOIN";
          $wherecondition = $employees->where( function($joincont) {
                                    $joincont->where('emp.title', '=', 1)
                                             ->orWhere('emp.title', '=', 2)
                                             ->orWhere('emp.title', '=', 3);
                                    });
          $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                          $joins->on('ma.user_id', '=', 'emp.Emp_ID');
                                      });
        } else  {
          //EXISTING FILTER
          $join = "RIGHTJOIN";
          $wherecondition = $employees->where( function($joincont) {
                                    $joincont->where('emp.title', '=', 1)
                                             ->orWhere('emp.title', '=', 2);
                                    })
                               ->where('emp.resign_id', '=', 0);
          $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                          $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                          ->where( function($joincont) {
                                        $joincont->whereNull('ma.returnedplace')
                                                 ->orWhere('ma.returnedplace','=',2);
                                        })
                                        ->whereNull('ma.returnstatus');
                                      });
        }
        $employees = $employees->leftJoin('visastatus AS vs', 'vs.VisaCD', '=', 'ma.VisaStatus')
                               ->leftJoin('visaposition AS vp', 'vp.VisaPosCD', '=', 'ma.VisaPosition');
        if ($request->searchmethod == 1) {
          // SINGLE SEARCH
          $employees = $employees->where(function($joincont) use ($request) {
                                    $joincont->where('emp.Emp_ID', 'LIKE', '%' . trim($request->singlesearch) . '%')
                                             ->orWhere('emp.LastName', 'LIKE', '%' . trim($request->singlesearch) . '%')
                                             ->orWhere('emp.FirstName', 'LIKE', '%' . trim($request->singlesearch) . '%')
                                             ->orWhere('ma.CardNo', 'LIKE', '%' . trim($request->singlesearch) . '%')
                                             ->orWhere('ma.StDate', 'LIKE', '%' . $request->singlesearch . '%')
                                             ->orWhere('ma.EdDate', 'LIKE', '%' . $request->singlesearch . '%')
                                             ->orWhere('vs.VisaNM', 'LIKE', '%' . trim($request->singlesearch) . '%')
                                             ->orWhere('vp.VisaPosNM', 'LIKE', '%' . trim($request->singlesearch) . '%');
                                    });
        } else if ($request->searchmethod == 2) {
            // MULTI SEARCH
          if (!empty($request->msearchempid)) {
             $employees = $employees->where('emp.Emp_ID', 'LIKE', '%' . trim($request->msearchempid) . '%');
          }
          if (!empty($request->msearchempname)) {
              $employees = $employees->where(function($joincont) use ($request) {
                                    $joincont->where('emp.LastName', 'LIKE', '%' . trim($request->msearchempname) . '%')
                                             ->orWhere('emp.FirstName', 'LIKE', '%' . trim($request->msearchempname) . '%');
                                    });
          }
          if(!empty($request->msearchstdate) && !empty($request->msearcheddate)) {
            $employees = $employees->whereBetween('ma.EdDate', [$request->msearchstdate, $request->msearcheddate]);
          }
          if(!empty($request->msearchstdate) && empty($request->msearcheddate)) {
             $employees = $employees->where(function($joincont) use ($request) {
                                    $joincont->where('ma.EdDate', '>=', $request->msearchstdate);
                                             // ->where(DB::raw('curdate()'), '<=', $request->msearchstdate);
                                    });
          }
          if(!empty($request->msearcheddate) && empty($request->msearchstdate)) {
              $employees = $employees->where('ma.EdDate', '<=', $request->msearcheddate);
              // $employees = $employees->where(DB::raw('curdate()'), '<=', $request->msearcheddate);
          }
      }
      $employees = $wherecondition;
      /* Doubt */
      // if  condition below not for 'ALL' and 'EXISTING' 
      if ($request->filterval == 2 || $request->filterval == 3) {
        if($request->mainmenu != "contractemp_visa") {
          $employees = $employees->where('emp.citizenShip', '=', 1);
        }
      }
      $employees = $employees->where('ma.CardNo','!=','')
                             ->where('emp.Emp_ID', 'not like', 'SS%')
                             ->where('emp.delFlg', '=', 0)
                             ->groupBy('emp.Emp_ID')
                             ->orderBy($request->visasort, $request->sortOrder)
                             // ->toSql();
                             // dd($employees);
                             ->paginate($request->plimit);
      //dd($employees);
     return $employees;
   }

    public static function getVisaStatus() {
        $db = DB::connection('mysql_MB');
        $visaStatus = $db->table('visastatus')->SELECT('VisaCD', 'VisaNM')->WHERE('DelFlg', '=', 0)
                                                                          ->orderBy('Order_id', 'ASC')
                                                                          ->lists('VisaNM','VisaCD');
        return $visaStatus;
    }

    public static function getVisaPosition() {
      $db = DB::connection('mysql_MB');
        $visaPosition = $db->table('visaposition')->SELECT('VisaPosCD', 'VisaPosNM')->WHERE('DelFlg', '=', 0)
                                                                          ->orderBy('Order_id', 'ASC')
                                                                          ->lists('VisaPosNM','VisaPosCD');
        return $visaPosition;
    }

    public static function getVisaPlace() {
       $db = DB::connection('mysql_MB');
        $visaPlace = $db->table('visaplace')
                          ->SELECT('id', 'visaplace')->WHERE('DelFlg', '=', 0)
                          ->orderBy('id', 'ASC')
                          ->lists('visaplace','id');
        return $visaPlace;
    }

    public static function getVisaAddress() {
     $db = DB::connection('mysql_MB');
      $visaAddress = $db->table('mstaddress')->SELECT('id',
                            DB::raw("CONCAT('〒',pincode,'', jpstate,'',jpaddress,'-',roomno,'号') AS full_address"))
                            ->WHERE('delFLg', '=', 0)
                            ->orderBy('pincode', 'ASC')
                            ->lists('full_address','id');
      return $visaAddress;
     /* $sql="SELECT id,pincode,jpstate,jpaddress,roomno FROM mstaddress 
            WHERE delFLg='0' ORDER BY pincode ASC";
      return $sql;*/
    }

    public static function getVisaDetails($request,$limit,$page) {
      $db = DB::connection('mysql_MB');
      if($request->mainmenu != "contractemp_visa" && $request->mainmenu != "contractemp_emp") {
        $employee_tableName = "emp_mstemployees";
      } else {
        $employee_tableName = "mst_contractemployees";
      }
      $VisaDetails = $db->table('mstalien')
                      ->SELECT('mstalien.*','ma.pincode','ma.jpstate','ma.jpaddress','ma.roomno','ma.jpbuildingname','ma.state','ma.address','ma.buildingname','vs.VisaNM','vp.VisaPosNM','nm.LastName','nm.FirstName',
                        DB::raw("DATEDIFF(IFNULL(EdDate,CURDATE()),CURDATE()) as Validity"))
                      ->leftJoin('mstaddress AS ma', 'ma.id', '=', 'mstalien.Address')
                      ->leftJoin('visastatus AS vs', 'vs.VisaCD', '=', '`mstalien`..VisaStatus')
                      ->leftJoin('visaposition AS vp', 'vp.VisaPosCD', '=', '`mstalien`..VisaPosition')
                      ->leftJoin($employee_tableName.' AS nm', 'nm.Emp_ID', '=', '`mstalien`..user_id')
                      ->where('user_id', '=', $request->visaid);
                        if (!empty($request->id) && $page == '1') {
                            $VisaDetails = $VisaDetails->where('mstalien.id','=',$request->id);
                        }
      $VisaDetails = $VisaDetails->orderBy('EdDate', 'DESC')
                      ->take($limit)
                      ->get();
      return $VisaDetails;
    }

    public static function getVisavalidity($request) {
       $db = DB::connection('mysql_MB');
      $validity = $db->table('mstalien')
                        ->SELECT('*',DB::raw("DATEDIFF(IFNULL(EdDate,CURDATE()),CURDATE()) as Validity"))
                        ->WHERE('user_id', '=', $request->visaid)
                        ->WHERE('id', '=', $request->id)
                        ->get();
      return $validity;
    }

    public static function VisaDetedit($request) {
       $db = DB::connection('mysql_MB');
      if(!isset($request->visaid) && !isset($request->id)) {
        $request->visaid=old('visaid');
        $request->id=old('id');
      }
      $Details = $db->table('mstalien')
                        ->WHERE('user_id', '=', $request->visaid)
                        ->WHERE('id', '=', $request->id)
                        ->get();
      return $Details;
    }

    public static function getVisaempDetails($request) {
        if(Session::get('screenType') == "SATHISYS" || Session::get('screenType') == "SATHIINSTITUTE") {
          $db = DB::connection('mysql_SS');
        } else {
          $db = DB::connection('mysql_MB');
        }
        if($request->mainmenu == "contractemp_visa" || $request->mainmenu == "contractemp_emp") {
            $employee_tableName = "mst_contractemployees";
        } else {
            $employee_tableName = "emp_mstemployees";
        }
        $VisaempDetails = $db->TABLE($employee_tableName)
                        ->SELECT('Emp_ID','LastName','FirstName')
                        ->WHERE('Emp_ID', '=', $request->visaid)
                        ->take(1)
                        ->get();
        return $VisaempDetails;
    }

    public static function insertVisaRec($request) {
      $db = DB::connection('mysql_MB');
      // for($i=1;$i<=5;$i++) {
      //   if (!isset($data['fileName'.$i])) {
      //     $data['fileName'.$i]="";
      //   }
      // }
      $insert=$db->table('mstalien')->insert(
              ['user_id' => $request->visaid,
               'CardNo' => $request->CardNo,
               'StDate' => $request->StDate,
               'EdDate' => $request->EdDate,
               'VisaStatus' => $request->VisaStatus,
               'VisaPosition' => $request->VisaPosition,
               'Address' => $request->Address,
               'NoYears' => ($request->NoYears + 1),
               // 'rdoImg1' => $request->rdoImg1,
               // 'rdoImg2' => $request->rdoImg2,
               // 'rdoImg3' => $request->rdoImg3,
               // 'rdoImg4' => $request->rdoImg4,
               // 'rdoImg5' => $request->rdoImg5,
               // 'Image1' => $data['fileName1'],
               // 'Image2' => $data['fileName2'],
               // 'Image3' => $data['fileName3'],
               // 'Image4' => $data['fileName4'],
               // 'Image5' => $data['fileName5'],
               'Ins_DT' => date('Ymd'),
               'Up_DT' => date('Ymd'),
               'Ins_TM' => date('His'),
               'UP_TM' => date('His'),
               'CreatedBy' => Auth::user()->FirstName]
            );
      return $insert;
    }

    public static function updateVisaRec($request) {
      $db = DB::connection('mysql_MB');
      // for($i=1;$i<=5;$i++) {
      //   if (!isset($data['fileName'.$i])) {
      //     $data['fileName'.$i]="";
      //   }
      // }
      if(!isset($request->visaid) && !isset($request->id)) {
        $request->visaid=old('visaid');
        $request->id=old('id');
      }
      $update=$db->table('mstalien')
              ->where('user_id', $request->visaid)
              ->where('id', $request->id)
              ->update(
              ['CardNo' => $request->CardNo,
               'StDate' => $request->StDate,
               'EdDate' => $request->EdDate,
               'VisaStatus' => $request->VisaStatus,
               'VisaPosition' => $request->VisaPosition,
               'Address' => $request->Address,
               'NoYears' => ($request->NoYears + 1),
               // 'rdoImg1' => $request->rdoImg1,
               // 'rdoImg2' => $request->rdoImg2,
               // 'rdoImg3' => $request->rdoImg3,
               // 'rdoImg4' => $request->rdoImg4,
               // 'rdoImg5' => $request->rdoImg5,
               // 'Image1' => $data['fileName1'],
               // 'Image2' => $data['fileName2'],
               // 'Image3' => $data['fileName3'],
               // 'Image4' => $data['fileName4'],
               // 'Image5' => $data['fileName5'],
               'Up_DT' => date('Ymd'),
               'UP_TM' => date('His'),
               'CreatedBy' => Auth::user()->FirstName]
            );
      return $update;
    }

    public static function getlatVisaDet() {
      $db = DB::connection('mysql_MB');
      $latDetails = $db->table('mstalien')->max('id');
      return $latDetails;
    }

    public static function applydateinsert($request) {
      $db = DB::connection('mysql_MB');
      if($request->visapurpose == '1') {
        $request->returneddate=NULL;
        $request->returnedplace=NULL;
        $request->returnstatus=NULL;
      } else {
        $request->applydate=NULL;
        $request->appliedplace=NULL;
        $request->returnstatus='1';
      }
      $update=$db->table('mstalien')
              ->where('user_id', $request->visaid)
              ->where('id', $request->id)
              ->update(
              ['applydate' => $request->applydate,
               'appliedplace' => $request->appliedplace,
               'returneddate' => $request->returneddate,
               'returnedplace' => $request->returnedplace,
               'visapurpose' => $request->visapurpose,
               'returnstatus' => $request->returnstatus]
            );
      return $update;

    }

    public static function fetchVisaDetails($request,$flg,$srt,$odr,$mainmenu) {
        $db = DB::connection('mysql_MB');
          $joincondition = "";
          $wherecondition = "";
          if($request->mainmenu != "contractemp_visa") {
            $employee_tableName = "emp_mstemployees ";
          } else {
            $employee_tableName = "mst_contractemployees ";
          }
          if($request->visasort == "") {
            $request->visasort ='EdDate';
            $request->plimit ='50';
          }
          $employees = $db->table(DB::raw('(SELECT * FROM (SELECT * FROM mstalien WHERE EdDate IS NOT NULL ORDER BY EdDate DESC) AS t GROUP BY user_id) AS ma'))
                      ->SELECT('ma.id', 
                               'emp.Emp_ID AS user_id',     
                               'emp.FirstName', 
                               'emp.LastName', 
                               'emp.KanaFirstName',   
                               'emp.KanaLastName', 
                               'emp.Gender', 
                               'emp.DOB', 
                               'emp.resign_id',
                               'ma.CardNo',  
                               'ma.NoYears',
                               'ma.applydate', 
                               'ma.appliedplace', 
                               'ma.StDate', 
                               'ma.EdDate', 
                               'ma.VisaStatus', 
                               'ma.VisaPosition',
                                DB::raw("(SELECT SUM((Image1 IS NOT NULL AND Image1<>'')+(Image2 IS NOT NULL AND Image2<>'')+ (Image3 IS NOT NULL AND Image3<>'')+(Image4 IS NOT NULL AND Image4<>'')+ (Image5 IS NOT NULL AND Image5<>'')) as total FROM mstalien sub_ma WHERE sub_ma.id=ma.id) AS noOfImg"),
                                DB::raw("DATEDIFF(IFNULL(ma.EdDate,CURDATE()),CURDATE()) as Validity"),
                                'vs.VisaNM', 
                                'vp.VisaPosNM',
                                DB::raw("DATEDIFF(NOW(), ma.applydate) AS days_diff") );
          if ($request->filterval == 2) {
            // SATHISYS FILTER
            $join = "RIGHTJOIN";
            $wherecondition = $employees->where('emp.title', '=', 3)
                                        ->where('emp.resign_id', '=', 0);
            $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                            $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                            ->where( function($joincont) {
                                          $joincont->whereNull('ma.returnedplace')
                                                   ->orWhere('ma.returnedplace','=',2);
                                          })
                                      ->whereNull('ma.returnstatus');
                                        });
          } else if ($request->filterval == 3) {
            // COMPLETED FILTER
            $join = "LEFTJOIN";
            $wherecondition = $employees->where( function($joincont) {
                              $joincont->where('emp.title', '=', 1)
                                       ->orWhere('emp.title', '=', 2)
                                       ->orWhere('emp.title', '=', 3);
                              })
                         ->where( function($joincont) {
                              $joincont->where('emp.resign_id', '=', 1)
                                       ->orWhere('ma.returnedplace', '=', 1);
                              });
            $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                            $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                            ->where( function($joincont) {
                                          $joincont->whereNull('ma.returnedplace')
                                                   ->orWhere('ma.returnedplace','=',1);
                                          });
                                        });
          } else  {
            //EXISTING FILTER
            $join = "RIGHTJOIN";
            $wherecondition = $employees->where( function($joincont) {
                                      $joincont->where('emp.title', '=', 1)
                                               ->orWhere('emp.title', '=', 2);
                                      })
                                 ->where('emp.resign_id', '=', 0);
            $employees = $employees->$join($employee_tableName.'AS emp', function ($joins){
                                            $joins->on('ma.user_id', '=', 'emp.Emp_ID')
                                            ->where( function($joincont) {
                                          $joincont->whereNull('ma.returnedplace')
                                                   ->orWhere('ma.returnedplace','=',2);
                                          })
                                          ->whereNull('ma.returnstatus');
                                        });
          }
          $employees = $employees->leftJoin('visastatus AS vs', 'vs.VisaCD', '=', 'ma.VisaStatus')
                                 ->leftJoin('visaposition AS vp', 'vp.VisaPosCD', '=', 'ma.VisaPosition');
          if ($request->searchmethod == 1) {
            // SINGLE SEARCH
            $employees = $employees->where(function($joincont) use ($request) {
                                      $joincont->where('emp.Emp_ID', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('emp.LastName', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('emp.FirstName', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('ma.CardNo', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('ma.StDate', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('ma.EdDate', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('vs.VisaNM', 'LIKE', '%' . $request->singlesearch . '%')
                                               ->orWhere('vp.VisaPosNM', 'LIKE', '%' . $request->singlesearch . '%');
                                      });
          } else if ($request->searchmethod == 2) {
              // MULTI SEARCH
            if (!empty($request->msearchempid)) {
               $employees = $employees->where('emp.Emp_ID', 'LIKE', '%' . $request->msearchempid . '%');
            }
            if (!empty($request->msearchempname)) {
                $employees = $employees->where(function($joincont) use ($request) {
                                      $joincont->where('emp.LastName', 'LIKE', '%' . $request->msearchempname . '%')
                                               ->orWhere('emp.FirstName', 'LIKE', '%' . $request->msearchempname . '%');
                                      });
            }
            if(!empty($request->msearchstdate) && !empty($request->msearcheddate)) {
              $employees = $employees->whereBetween('ma.EdDate', [$request->msearchstdate, $request->msearcheddate]);
            }
            if(!empty($request->msearchstdate) && empty($request->msearcheddate)) {
               $employees = $employees->where(function($joincont) use ($request) {
                                      $joincont->where('ma.EdDate', '>=', $request->msearchstdate);
                                               // ->where(DB::raw('curdate()'), '<=', $request->msearchstdate);
                                      });
            }
            if(!empty($request->msearcheddate) && empty($request->msearchstdate)) {
                $employees = $employees->where('ma.EdDate', '<=', $request->msearcheddate);
                // $employees = $employees->where(DB::raw('curdate()'), '<=', $request->msearcheddate);
            }
        }
        $employees = $wherecondition;
        if($request->mainmenu != "contractemp_visa") {
          $employees = $employees->where('emp.citizenShip', '=', 1);
        }
        $employees = $employees->where('emp.Emp_ID', 'not like', 'SS%')
                               ->where('emp.delFlg', '=', 0)
                               ->groupBy('emp.Emp_ID')
                               ->orderBy('emp.Emp_ID', 'ASC')
                               // ->toSql();
                               // dd($employees);
                               ->get();
              return $employees;
    }

    public static function updateimagevalue($request,$filename1) {
        if(Session::get('screenType') == "SATHISYS" || Session::get('screenType') == "SATHIINSTITUTE" || $request->mainmenu == "candidates_passport") {
            $db = DB::connection('mysql_SS');
        } else if(Session::get('screenType') == "MICROBIT") {
           $db = DB::connection('mysql_MB');
        }
        if ($request->filecnt == 1) {
        $update = $db->table('mstalien')
                            ->where('id', $request->id)
                            ->update([
                              'Image1' => $filename1]);
        } elseif ($request->filecnt == 2) {
          $update = $db->table('mstalien')
                            ->where('id', $request->id)
                            ->update([
                              'Image2' => $filename1]);
        } elseif ($request->filecnt == 3) {
          $update = $db->table('mstalien')
                            ->where('id', $request->id)
                            ->update([
                              'Image3' => $filename1]);
        } elseif ($request->filecnt == 4) {
          $update = $db->table('mstalien')
                            ->where('id', $request->id)
                            ->update([
                              'Image4' => $filename1]);
        } elseif ($request->filecnt == 5) {
          $update = $db->table('mstalien')
                            ->where('id', $request->id)
                            ->update([
                              'Image5' => $filename1]);
        }

      return $update;
    }

    public static function FetchVisadetailsplace($request) {
      $db = DB::connection('mysql_MB');
      $query = $db->table('visaplace')
          ->select('id',
                   'visaplace')
          ->where('DelFlg', '=', 0)
          ->get();
    return $query;
            // $sql="SELECT id,visaplace FROM visaplace WHERE DelFlg='0'";
            // $cards = DB::select($sql);
            // return $cards;
    }

    // vengad 04/07/2020
    public static function fnGetCompanyDetails($dbname){
      
      $db = DB::connection($dbname);
      $query = $db->table('company_details')
          ->select('id',
                    'companyNumber',
                    'companyName',
                    'companyBranch',
                    'capital',
                    'address',
                    'TEL',
                    'CEO',
                    'referencenumber')
          ->where('id', '=', 1)
          ->get();
      return $query;
    }

    public static function fnGetSalesDetails($dbname){
      
      $db = DB::connection($dbname);
      $query = $db->table('sales_details')
          ->select('*')
          ->where('delFlag', '=', 0)
          ->orderBy('id', 'DESC')
          ->get();
      return $query;
    }

  // Madasamy 28/06
    public static function fnGetEmployee($Emp_ID,$dbname){
      
      $db = DB::connection($dbname);
      $query = $db->table('emp_mstemployees')
          ->select('id',
                    'Emp_ID',
                    'Old_ID',
                    'DOJ',
                    'FirstName',
                    'LastName',
                    'DOB',
                    'Gender',
                    'Designation',
                    'MartialStatus',
                    'citizenShip',
                    'Mobile1',
                    'citizenShip',
                    'resigndate')
          ->where('Emp_ID', '=', $Emp_ID)
          ->get();
    return $query;
  }

  public static function fnGetPassport($Emp_ID){
    $query= ''; 
      $db = DB::connection('mysql_MB');
      $query = $db->table('mstpassport')
          ->select('*')
          ->where('user_id', '=', $Emp_ID)
          ->orderBy('DOE','DESC')
          ->limit(1)
          ->get();
    return $query;
  }

  public static function fnGetAliencard($id){
      
      $db = DB::connection('mysql_MB');
      $query = $db->table('mstalien')
          ->select('*')
          ->where('id', '=', $id)
          ->get();
    return $query;
  }

  public static function fnGetJapanAddress($id){
      $db = DB::connection('mysql_MB');
      $query = $db->table('mstaddress')
          ->select('*')
          ->where('id', '=', $id)
          ->get();
      return $query;
    
  }

  public static function selectdesignation($designation) {
    $db = DB::connection('mysql_MB');
    $query= $db->table('sysdesignationtypes')
          ->SELECT('DesignationNM')
          ->where('DelFlg', '=', 0)
          ->where('DesignationCD', '=', $designation)
          ->get();
    return $query;
  }

  public static function fnGetEducation($Emp_ID){
    $query= ''; 
      $db = DB::connection('mysql_MB');
      $query = $db->table('emp_msteducations')
          ->select('*')
          ->where('employee_id', '=', $Emp_ID)
          ->orderBy('complete_year','DESC')
          ->orderBy('complete_month','DESC')
          ->limit(1)
          ->get();
    return $query;
  }

  public static function fnGetCertificate($Emp_ID){
      $db = DB::connection('mysql_MB');
      $query = $db->table('emp_mstcertificates as A')
          ->select('B.certificate_name',
               'A.result',
               'A.year',
               'A.month')
          ->leftJoin('emp_certification as B','A.certificate_name','=','B.id')
          ->where('A.employee_id', '=', $Emp_ID)
          ->where('A.certificatetype', '=', 3)
          ->where('A.result', '=', 0)
          ->orderBy('A.year','DESC')
          ->orderBy('A.month','DESC')
          ->limit(1)
          ->get();
    return $query;
  }

  public static function fnGetContractAmount($Emp_ID){
      $db = DB::connection('mysql');
      $query = $db->table('mstcontract')
          ->select('Total')
          ->where('Emp_id', '=', $Emp_ID)
          ->orderBy('EndDate','DESC')
          ->limit(1)
          ->get();
    if (isset($query[0]->Total)) {
      return $query[0]->Total;
      } else {
        return '';
      }
  }

  public static function fnGetVisaStatus($VisaCD){

      $db = DB::connection('mysql_MB');
      $query = $db->table('visastatus')
          ->select('VisaNM')
          ->where('VisaCD', '=', $VisaCD)
          ->get();
      if (isset($query[0]->VisaNM)) {
      return $query[0]->VisaNM;
      } else {
        return '';
      }
  }

  public static function fnGetVisaPosition($VisaPosCD){

      $db = DB::connection('mysql_MB');
      $query = $db->table('visaposition')
          ->select('VisaPosNM')
          ->where('VisaPosCD', '=', $VisaPosCD)
          ->get();
    if (isset($query[0]->VisaPosNM)) {
      return $query[0]->VisaPosNM;
      } else {
        return '';
      }
  }

  public static function fnGetMyFamilyDetails($Emp_ID){

      $db = DB::connection('mysql');
      $sql = "SELECT * FROM(select * from `familyvisa_details` where Emp_ID = '".$Emp_ID."' order by EdDate desc) as my_table_tmp group by DOB";
      $query = $db->select($sql);
      return $query;
  }

  public static function fnGetEmployeeCount($flg){

      $db = DB::connection('mysql_MB');
      $query = $db->table('emp_mstemployees')
                  ->Select(DB::raw('count(Emp_ID) as TotEmp'))
                  ->WHERE([['delFlg', '=', 0],
                            ['Title', '=', 2],
                            ['resign_id', '=', 0]]);
          
          if ($flg == 1) {
            $query = $query->WHERE('citizenShip','!=','2');
          }
                  
          $query = $query->get();
      
      return $query[0]->TotEmp;
  }



}