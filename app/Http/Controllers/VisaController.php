<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Visa;
use DB;
use Crypt;
use Validator;
use Input;
use Redirect;
use stdClass;
use App\Http\Helpers;
use App\Http\Eradate;
use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use Config;
use Session;
use Carbon\Carbon;

class VisaController extends Controller
{
    public function index(Request $request)
    {
      $disabledex = '';
      $disabledss = '';
      $disabledcm = '';
      $disabledall = '';
      // PAGING PROCESS
      if (!isset($request->plimit)) {
          $request->plimit = 50;
      }
      // FILTERING PROCESS
      if (!isset($request->filterval) || $request->filterval == "") {
          $request->filterval = 1;
        }
      if ($request->filterval == 1) {
        $disabledex = "disabled fb";
      } elseif ($request->filterval == 2) {
        $disabledss = "disabled fb";
      } elseif ($request->filterval == 3) {
        $disabledcm = "disabled fb";
      } elseif ($request->filterval == 4) {
        $disabledall = "disabled fb";
      }
      // END FILTERING PROCESS
      // SORTING PROCESS
      if (!isset($request->visasort)) {
        $request->visasort = "EdDate";
      }
      if (!isset($request->sortOrder)) {
        $request->sortOrder = "asc";
      }
      if ($request->sortOrder == "asc") $request->sortstyle="sort_asc";
      else $request->sortstyle="sort_desc";
      $sortarray = ['EdDate'=>trans('messages.lbl_enddate'),
                    'user_id'=>trans('messages.lbl_empid'),
                    'LastName'=>trans('messages.lbl_empName'),
                    'StDate'=>trans('messages.lbl_Start_date')] ;
      // END SORTING PROCESS
      // SORT POSITION
      if ($request->searchmethod == 1 || $request->searchmethod == 2) {
        $sortMargin = "margin-right:220px;";
      } else {
        $sortMargin = "margin-right:0px;";
      }

      $employees = Visa::visalist($request);

      return view('Visa.list', ['emps' => $employees,
                                'sortarray' => $sortarray,
                                'disabledex' => $disabledex,
                                'disabledss' => $disabledss,
                                'disabledcm' => $disabledcm,
                                'disabledall' => $disabledall,
                                'sortMargin' => $sortMargin,
                                'request' => $request]);
    }

    public function view(Request $request) {

      if(Session::get('visadbid') !="" && Session::get('visaid') !=""){
        $request->id = Session::get('visadbid');
        $request->visaid = Session::get('visaid');
        // Session::forget('visadbid');
        // Session::forget('visaid');
      }

      $visadetails = Visa::getVisaDetails($request,'1','1');
      $Validity = Visa::getVisavalidity($request);
      if(!isset($request->visaid) && !isset($request->id)){
        return $this->index($request);
      }

  // Madasamy 28/06
      $empdetails = array();
      $employee = Visa::fnGetEmployee($request->visaid,'mysql_MB');
      $passport = Visa::fnGetPassport($request->visaid);
      $aliencard = Visa::fnGetAliencard($request->id);

      $myFamilyDetails = Visa::fnGetMyFamilyDetails($request->visaid);

      $japanAddress = '';
      if ($aliencard[0]->Address != '') {
        $japanAddress = Visa::fnGetJapanAddress($aliencard[0]->Address);
        if (isset($japanAddress[0])) {
          $japanAddress = '〒'.$japanAddress[0]->pincode.' '.$japanAddress[0]->jpstate.$japanAddress[0]->jpaddress.' - '.$japanAddress[0]->roomno.'号';
        }
      }

      $empArray = (array)$employee[0];

      if (is_numeric(trim($empArray['Designation']))) {
        $Designation=Visa::selectdesignation($empArray['Designation']);
          if (isset($Designation[0])) {
          $empArray['Designation'] = $Designation[0]->DesignationNM;
        } 
      }

      $DOJ_SS = '';
      $DOJ_MB = '';
      $experience = array();
      if (isset($empArray['Old_ID'])) {
          $dojSS = self::getExperienceDet($empArray['Old_ID'],$empArray['DOJ']);
          if (isset($dojSS['DOJ_SS']) && isset($dojSS['resignDateSS'])) {
            $experience['DOJ_SS'] = $dojSS['DOJ_SS'];
            $experience['resignDateSS'] = $dojSS['resignDateSS'];
          }
      }
      $experience['DOJ_MB']  = $empArray['DOJ'];

      $educationData = Visa::fnGetEducation($request->visaid);
      if (isset($educationData[0])) {
          $university = ($educationData[0]->university == 'Others') ? $educationData[0]->univothers : $educationData[0]->university;
          $department = ($educationData[0]->depatment == 'Others') ? $educationData[0]->deptothers : $educationData[0]->depatment;
          $specification = ($educationData[0]->specification != '') ? $educationData[0]->specification : '';
          $complete_year = $educationData[0]->complete_year;
          $complete_month = $educationData[0]->complete_month;
      }

      $education = array();
      $education['university'] = (isset($university)) ? $university : '';
      $education['specification'] = (isset($specification)) ? $specification : '';
      $education['department'] = (isset($department)) ? $department : '';
      $education['complete_year'] = (isset($complete_year)) ? $complete_year : '';
      $education['complete_month'] = (isset($complete_month)) ? $complete_month : '';

      $certificate = Visa::fnGetCertificate($request->visaid);

      $contractAmount = Visa::fnGetContractAmount($request->Emp_ID);

      $dateDiff = abs(strtotime((isset($experience['DOJ_SS'])) ? $experience['DOJ_SS'] : $experience['DOJ_MB']) - strtotime(date('Y-m-d')));
      $expYears = round(($dateDiff / (365*60*60*24)),1);

      return view('Visa.view', ['visadetails' => $visadetails,
                                'Validity' => $Validity,
                                'myFamilyDetails' => $myFamilyDetails,
                                'japanAddress' => $japanAddress,
                                'empArray' => $empArray,
                                'passport' => $passport,
                                'experience' => $experience,
                                'education' => $education,
                                'certificate' => $certificate,
                                'contractAmount' => $contractAmount,
                                'expYears' => $expYears,
                                'request' => $request]);

    }

    public function getExperienceDet($Old_ID,$mbDOJ){
      
        $dojSS = array();
        $employeeSS = Visa::fnGetEmployee($Old_ID,'mysql_SS');
        if (isset($employeeSS[0])) {
            
            if (isset($employeeSS[0]->Old_ID) && $employeeSS[0]->Old_ID != '') {
            
                $employeeTRN = Visa::fnGetEmployee($employeeSS[0]->Old_ID,'mysql_SS');
                if (isset($employeeTRN[0]->Old_ID) && $employeeTRN[0]->Old_ID != '') {

                    $employeeSTU = Visa::fnGetEmployee($employeeTRN[0]->Old_ID,'mysql_SS');
                    if (isset($employeeSTU[0]->DOJ) && $employeeSTU[0]->DOJ != '') {
                        $dojSS['DOJ_SS'] = $employeeSTU[0]->DOJ;
                    } else {
                        $dojSS['DOJ_SS'] = $employeeTRN[0]->DOJ;
                    }

                } else {
                    $dojSS['DOJ_SS'] = $employeeSS[0]->DOJ;
                }

            } else {
                $dojSS['DOJ_SS'] = $employeeSS[0]->DOJ;
            }

            if ($employeeSS[0]->resigndate != '') {
                $dojSS['resignDateSS'] = $employeeSS[0]->resigndate;
            } else {
                $dojSS['resignDateSS'] = date('Y-m-d', strtotime('last day of last month', strtotime($mbDOJ)));
            }

        }

        // if (isset($employeeSS[0]->Old_ID)) {

        //     $dojSS['resignDateSS'] = $employeeSS[0]->resigndate;
        //     $employeeTRN = Visa::fnGetEmployee($employeeSS[0]->Old_ID,'mysql_SS');
        //     if (isset($employeeTRN[0]->Old_ID)) {
        //       

        //       if (isset($employeeSTU[0]->Old_ID)) {
        //         $dojSS['DOJ_SS'] = $employeeSTU[0]->DOJ;
        //       } else {
        //         $dojSS['DOJ_SS'] = $employeeTRN[0]->DOJ;
        //       } 

        //     } else{
        //       $dojSS['DOJ_SS'] = $employeeSS[0]->DOJ;
        //     }
        // } 
        return $dojSS;
    }

    // public function getIndiaAddress($address){

  //  $indiaAddress ='';
  //  $zip = '';
  //  $address = preg_replace('{(\d)\s+(\d)}','\1\2',$address);
  //  $address = preg_replace('{\s*,\s*}',',',$address);

  //  if(preg_match('@.*,(.*?)(\d{6})@',$address,$matches)) {
  //      // $city = trim($matches[1]);
  //      $zip = trim($matches[2]);
  //  } else if (preg_match('/\b\d{3}(-\d{3})?\b/',$address,$matches)) {
  //    $zip = str_replace("-", "",$matches[0]);
  //  }

  //  if ($zip != '') {
  //    $query = json_decode(file_get_contents('https://api.postalpincode.in/pincode/'.$zip));
  //      if($query && $query[0]->Status == 'Success'){
  //      $post = $query[0]->PostOffice;
  //      $indiaAddress = strtoupper($post[0]->District.','.$post[0]->State);
  //      }
  //  }

  //  return $indiaAddress;
  // }

    public function viewlist(Request $request) {
      $visadetails = Visa::getVisaDetails($request,'100','2');
      $empdet = Visa::getVisaempDetails($request);
      if(!isset($request->visaid) && !isset($request->id)){
        return $this->index($request);
      }
      return view('Visa.listview', ['visadetails' => $visadetails,
                                    'empdet' => $empdet,
                                    'request' => $request]);
    }

    public function applydatepopup(Request $request) {
      $visaplace = Visa::getVisaPlace();
        return view('Visa.applydatepopup',['visaplace' => $visaplace,
                                           'request' => $request]);
    }

    public function applydatepopupedit(Request $request) {
      $applydateval = Visa::VisaDetedit($request);
      $visaplace = Visa::getVisaPlace();
      return view('Visa.applydatepopup',['visaplace' => $visaplace,
                                         'applydateval' => $applydateval[0],
                                         'request' => $request]);
    }

    public function addeditpopup(Request $request) {
      if($request->editpage == "editpage") {
        $messageval = "Updated";
      } else {
        $messageval = "Inserted";
      }
      $update = Visa::applydateinsert($request);
      if($update) {
        Session::flash('message', $messageval.'Sucessfully!'); 
        Session::flash('type', 'alert-success'); 
      } else {
        Session::flash('type', $messageval.'Unsucessfully!'); 
        Session::flash('type', 'alert-danger'); 
      }
      // return $this->view($request);
      Session::flash('visadbid', $request->id );
      Session::flash('visaid', $request->visaid );
      return Redirect::to('Visa/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
    }

    public static function downloadexcel(Request $request) {
        // $template_name = Config::get('constants.VISA_DOWNLOAD_PATH');
        $template_name = 'resources/assets/uploadandtemplates/templates/EmpVisadetails.xls';
        $tempname = "Visa_Details";
        $excel_name=$tempname."_". date('Y_m_d');
        Excel::load($template_name, function($objTpl) use($request) {
        $request->plimit = 1000;
        $getvisadetails = Visa::fetchVisaDetails($request,1,"user_id","ASC",$request->mainmenu);
        $common_appliedplace=visa::FetchVisadetailsplace($request);
         $cnt = 0;
        foreach ($getvisadetails as $taxdetails) {
           $fullname = $taxdetails->FirstName . " " . $taxdetails->LastName."\n";
           $kananame = $taxdetails->KanaFirstName . " " . $taxdetails->KanaLastName;
           $sex = "";
           $degntion = "";
           $visa_status = "";
           $appliedplace = "";
           $carnum = "";
            if($taxdetails->Gender == 1) {
              $sex="男";
            } else if($taxdetails->Gender == 2) {
              $sex="女";
            }

            if($taxdetails->VisaPosition == 1){      
              $degntion="システム開発";
            } else if($taxdetails->VisaPosition == 3) {
              $degntion = "人文知識・国際業務";
            } else if($taxdetails->VisaPosition == 2) {
              $degntion = "永住権";
            }
            if (isset($taxdetails->VisaStatus)) {
            if($taxdetails->VisaStatus==1){          
              $visa_status="技術";
            }
            else if($taxdetails->VisaStatus==2){
              $visa_status="投資家";
            }
            else if($taxdetails->VisaStatus==4){
              $visa_status = "人文知識・国際業務";
            }
          } else {
              $visa_status = "";
          }
            $applydate = "";
            if ($taxdetails->applydate != "0000-00-00") {
              $applydate = Helpers::fnYMChangeWareki(trim(str_replace('-', '', $taxdetails->applydate)));
            }

            $appliedplace = "";
            foreach ($common_appliedplace AS $key => $value) {
              if ($taxdetails->appliedplace == $value->id) {
                $appliedplace = trim($value->id);
                break;
              }
            }

            if ($appliedplace == 1) {
              $appliedplace = "東京申請中";
            } else if ($appliedplace == 2) {
              $appliedplace = "大阪申請中";
            }

            $date = str_replace('-', '/', $taxdetails->DOB);
            $date1 = str_replace('-', '/', $taxdetails->EdDate);
            if (!empty($taxdetails->CardNo)) {
            $cardnum1 = substr($taxdetails->CardNo, 0, 2);
            $cardnum2 = substr($taxdetails->CardNo, -2);
            $cardnum3 = substr($taxdetails->CardNo, 2, -2);
            $carnum = $cardnum1 . " " . $cardnum3 . " " . $cardnum2;
            } else {
              $carnum = " ";
            }
            $sr=$objTpl->getActiveSheet()->getRowDimension(4)->getRowHeight();;
            $objTpl->getActiveSheet()->getRowDimension((4+$cnt))->setRowHeight($sr);  
            $objTpl->getActiveSheet()->setTitle("従業員一覧");
            $objTpl->setActiveSheetIndex(0);  //set first sheet as active
            $objTpl->getActiveSheet()->setCellValue("A".(4+$cnt),('='.'ROW()'.'-3'));
            $objTpl->getActiveSheet()->setCellValue("B".(4+$cnt),stripslashes(strtoupper($fullname)).$kananame);
            $objTpl->getActiveSheet()->setCellValue("C".(4+$cnt),stripslashes($degntion));
            $objTpl->getActiveSheet()->setCellValue("D".(4+$cnt),stripslashes($sex));
            $objTpl->getActiveSheet()->setCellValue("E".(4+$cnt), $date);
            $objTpl->getActiveSheet()->setCellValueExplicit("F".(4+$cnt), $carnum);
            $objTpl->getActiveSheet()->setCellValue("G".(4+$cnt),$date1);
            $objTpl->getActiveSheet()->setCellValue("H".(4+$cnt),$visa_status);
            $objTpl->getActiveSheet()->setCellValue("I" . (4 + $cnt), $appliedplace . "\n" . $applydate);
          /*$objTpl->getActiveSheet()->duplicateStyle($objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt));
            //$objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getAlignment()->setWrapText(true);
            $objTpl->getActiveSheet()->getColumnDimension('A:I')->setAutoSize(true);
            $objTpl->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objTpl->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objTpl->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
            $objTpl->getActiveSheet()->getColumnDimension('D')->setWidth(10);*/
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getBorders()->getVertical ()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objTpl->getActiveSheet()->getStyle("E" .(4+$cnt))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objTpl->getActiveSheet()->getStyle("G" .(4+$cnt))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objTpl->getActiveSheet()->getStyle("A".(4+$cnt).":I".(4+$cnt))->getAlignment()->setWrapText(true);
                   $cnt++;
        }
        $objTpl->getActiveSheet(0)->setSelectedCells('A1');
        $dat = date("Ymd");
        $flpath=$dat.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$flpath.'"');
        header('Cache-Control: max-age=0');
        })->setFilename($excel_name)->download('xls');

    }


    // Madasamy 28/06

    public function Download(Request $request) {
        // $template_name = Config::get('constants.LOCALTRAVEL_DOWNLOAD_PATH');
        $employee = Visa::fnGetEmployee($request->empid,'mysql_MB');
        $template_name = 'resources/assets/uploadandtemplates/templates/visa_extension.xls';
        
        Excel::load($template_name, function($objPHPExcel) use($request) {
          $companyDetails = Visa::fnGetCompanyDetails('mysql');
          $salesDetails = Visa::fnGetSalesDetails('mysql');
          
          $salesData = array();
          foreach ($salesDetails as $k => $v) {
            $salesData[$k]['period'] = $v->period;
            $salesData[$k]['salesAmount'] = $v->salesAmount;
          }

          $totEmpCount = Visa::fnGetEmployeeCount(0);
          $foreignEmpCount = Visa::fnGetEmployeeCount(1);

          $employee = Visa::fnGetEmployee($request->empid,'mysql_MB');
          $passport = Visa::fnGetPassport($request->empid);
          $aliencard = Visa::fnGetAliencard($request->id);

          $myFamilyDetails = Visa::fnGetMyFamilyDetails($request->empid);

          $japanAddress = '';
          if ($aliencard[0]->Address != '') {
            $japanAddress = Visa::fnGetJapanAddress($aliencard[0]->Address);
            if (isset($japanAddress[0])) {
              $japanAddress = '〒'.$japanAddress[0]->pincode.' '.$japanAddress[0]->jpstate.$japanAddress[0]->jpaddress.' - '.$japanAddress[0]->roomno.'号';
            }
          }

          $empArray = (array)$employee[0];

          if (is_numeric(trim($empArray['Designation']))) {
            $Designation=Visa::selectdesignation($empArray['Designation']);
            if (isset($Designation[0])) {
              $empArray['Designation'] = $Designation[0]->DesignationNM;
            } 
          } 

          // // For Indian Employees
          // $indiaAddress = '';
          // if ($employee[0]->citizenShip == 1){
          //  if (isset($passport[0]->Address)) {
          //    $indiaAddress = self::getIndiaAddress($passport[0]->Address);
          //  }
          // }

          // For Experience Details with Dates
          $DOJ_SS = '';
          $DOJ_MB = '';
          $employeeSS = '';
          if (isset($empArray['Old_ID'])) {
            $dojSS = self::getExperienceDet($empArray['Old_ID'],$empArray['DOJ']);
            if (isset($dojSS['DOJ_SS']) && isset($dojSS['resignDateSS'])) {
                $DOJ_SS = $dojSS['DOJ_SS'];
                $resignDateSS = $dojSS['resignDateSS'];
            }
          } 
          $DOJ_MB = $empArray['DOJ'];

          $education = Visa::fnGetEducation($request->empid);
          $university = '';
          $department = '';
          $complete_year = '';
          $complete_month = '';
          if (isset($education[0])) {
            $university = ($education[0]->university == 'Others') ? $education[0]->univothers : $education[0]->university;
            $department = ($education[0]->depatment == 'Others') ? $education[0]->deptothers : $education[0]->depatment;
            $complete_year = $education[0]->complete_year;
          $complete_month = $education[0]->complete_month;
          }

          $certificate = Visa::fnGetCertificate($request->empid);
          $certDetail = '';
          if (isset($certificate[0])) {
            $level = substr($certificate[0]->certificate_name, 1,1);
            $certDetail = '日本語能力試験　'.$level.'級　合格　（'.$certificate[0]->year.'・'.sprintf('%02d',$certificate[0]->month).'）';  
          } 

          $contractAmount = Visa::fnGetContractAmount($request->empid);
          
          $dateDiff = abs(strtotime(($DOJ_SS != '') ? $DOJ_SS : $DOJ_MB) - strtotime(date('Y-m-d')));
          $expYears = round(($dateDiff / (365*60*60*24)),1);

        
          $borderBot[0] = array('G15','W15','AC15','AG15','G18','E24','U24','G27','G30','Y30','I33','X33','AD33','AH33','I36','Z36','I39','O39','S39','I42','I45','I48','I52');

          $borderBot[1] = array('F9','X9','G11','AA11','H20','Z20','AE20','AI20','P43','F59','AC59','G61','H64','Z64','F79','T79','D84','AB84','B55','D55','F55','H55','J55','T55','V55','X55','Z55','AB55');

          $borderBot[2] = array('F9','Y9','F24','V24','W24','X24','Y24','Z24','AA24','AB24','AC24','AD24','AE24','AF24','AG24','AH24','I27','AB31','AE33','G73','AA73','G76','AB76');

          $borderBot[3] = array('I7','AA7','G10','O13','I16','Z16','AA20','AD22');

          $borderBot[4] = array('E10','U10','V10','W10','X10','Y10','Z10','AA10','AB10','AC10','AD10','AE10','AF10','AG10','H13','AA17','AD19','G59','G62');

          $borderBot[5] = array('F7','K10','H13');

          foreach ($borderBot as $key => $arr) {
            
            $objPHPExcel->setActiveSheetIndex($key);

                // For Side Border
            if ($key == 0) {
              for ($i=59; $i < 78; $i++) { 
                $objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              }
            }

            if ($key == 1) {
               $objPHPExcel->getActiveSheet()->getStyle('H50')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $objPHPExcel->getActiveSheet()->getStyle('Z50')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            if ($key == 2) {
               $objPHPExcel->getActiveSheet()->getStyle('AB31')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
               $objPHPExcel->getActiveSheet()->getStyle('C18')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $objPHPExcel->getActiveSheet()->getStyle('Z23')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            if ($key == 3) {
               $objPHPExcel->getActiveSheet()->getStyle('AA20')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
               $objPHPExcel->getActiveSheet()->getStyle('C32')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            if ($key == 4) {
               $objPHPExcel->getActiveSheet()->getStyle('AA17')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            }

            // for double border
            if ($key == 5) {
              $borderDoubleBot = array('B19','X19','AC19','AG19');
                foreach ($borderDoubleBot as $value) {
                  $objPHPExcel->getActiveSheet()->getStyle($value)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
              }
            }

            // For Bottom border
              foreach ($arr as $value1) {
                  $objPHPExcel->getActiveSheet()->getStyle($value1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              }
          }

          // Sheet 1
          $objPHPExcel->setActiveSheetIndex(0);

          if (isset($empArray)) {
              if ($empArray['citizenShip'] == 1){ $citizen = 'INDIA'; }
                  elseif($empArray['citizenShip'] == 2){ $citizen = 'JAPAN'; }
                    else{ $citizen = ''; }

              $objPHPExcel->getActiveSheet()->setCellValue("G15", $citizen);
              $objPHPExcel->getActiveSheet()->setCellValue("W15", date('Y', strtotime($empArray['DOB'])));
              $objPHPExcel->getActiveSheet()->setCellValue("AC15", date('m', strtotime($empArray['DOB'])));
              $objPHPExcel->getActiveSheet()->setCellValue("AG15", date('d', strtotime($empArray['DOB'])));
              $objPHPExcel->getActiveSheet()->setCellValue("G18", strtoupper($empArray['FirstName'].' '.$empArray['LastName']));
              $objPHPExcel->getActiveSheet()->setCellValue("G27", ($japanAddress) ? $japanAddress : "");
              $objPHPExcel->getActiveSheet()->setCellValue("Y30", ($empArray['Mobile1'] != '') ? $empArray['Mobile1'] : '');
          }

          if (isset($passport[0])) {
              $objPHPExcel->getActiveSheet()->setCellValue("U24", strtoupper($passport[0]->PlaceofBirth));
              $objPHPExcel->getActiveSheet()->setCellValue("I33", $passport[0]->PassportNo);
              $objPHPExcel->getActiveSheet()->setCellValue("X33", date('Y', strtotime($passport[0]->DOE)));
              $objPHPExcel->getActiveSheet()->setCellValue("AD33", date('m', strtotime($passport[0]->DOE)));
              $objPHPExcel->getActiveSheet()->setCellValue("AH33", date('d', strtotime($passport[0]->DOE)));
          }

          if (isset($aliencard[0])) {
              $objPHPExcel->getActiveSheet()->setCellValue("I42", $aliencard[0]->CardNo);
              $objPHPExcel->getActiveSheet()->setCellValue("Z36", ($aliencard[0]->NoYears > 1) ? $aliencard[0]->NoYears.' Years' : $aliencard[0]->NoYears.' Year');
              $objPHPExcel->getActiveSheet()->setCellValue("I39", date('Y', strtotime($aliencard[0]->EdDate)));
              $objPHPExcel->getActiveSheet()->setCellValue("O39", date('m', strtotime($aliencard[0]->EdDate)));
              $objPHPExcel->getActiveSheet()->setCellValue("S39", date('d', strtotime($aliencard[0]->EdDate)));

              $visaStatus = Visa::fnGetVisaStatus($aliencard[0]->VisaStatus);
              $visaPosition = Visa::fnGetVisaPosition($aliencard[0]->VisaPosition);
              $objPHPExcel->getActiveSheet()->setCellValue("I36", $visaStatus);
              $objPHPExcel->getActiveSheet()->setCellValue("E24", ($visaPosition == 'S/w Engineer') ? 'Software Engineer' : $visaPosition);
          }

          if (isset($myFamilyDetails[0])) {
              $familyArr = array();
              $relationArr = array('1'=> '父',
                                   '2'=> '母',
                                   '3'=> '祖父',
                                   '4'=> '祖母',
                                   '5'=> '姉妹',
                                   '6'=> '兄弟',
                                   '7'=> '妻',
                                   '8'=> '息子',
                                   '9'=> '娘');

              foreach ($myFamilyDetails as $key => $family) {
                $familyArr[$key]['relation'] = $relationArr[$family->Emp_Relation];
                $familyArr[$key]['name'] = strtoupper($family->FirstName.' '.$family->LastName);
                $familyArr[$key]['dob'] = $family->DOB;
                $familyArr[$key]['nation'] = ($family->Nationality == 1) ? 'India' : (($family->Nationality == 2) ? 'Japan' : '');
                $familyArr[$key]['cardNo'] = $family->CardNo;
              }

              $rowVal = 63;
              foreach ($familyArr as $key => $cellVal) {
                  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowVal , $cellVal['relation']);
                  $objPHPExcel->getActiveSheet()->setCellValue("D".$rowVal, $cellVal['name']);
                  $objPHPExcel->getActiveSheet()->setCellValue("M".$rowVal, $cellVal['dob']);
                  $objPHPExcel->getActiveSheet()->setCellValue("Q".$rowVal, $cellVal['nation']);
                  $objPHPExcel->getActiveSheet()->setCellValue("AE".$rowVal, $cellVal['cardNo']);
                  $rowVal += 2; 
              }
          }

          // Sheet 2
          $objPHPExcel->setActiveSheetIndex(1);
          $objPHPExcel->getActiveSheet()->setCellValue("B3", 'For applicant, part 2  N ("Highly Skilled Professional(i)(a/b)" / "Highly Skilled Professional(ii)"（only in cases of change of status） /');
          // company details
          $objPHPExcel->getActiveSheet()->setCellValue("F9", ($companyDetails[0]->companyName) ? $companyDetails[0]->companyName : "");
          $objPHPExcel->getActiveSheet()->setCellValue("X9", ($companyDetails[0]->companyBranch) ? $companyDetails[0]->companyBranch : "");
          $objPHPExcel->getActiveSheet()->setCellValue("G11", ($companyDetails[0]->address) ? $companyDetails[0]->address : "");
          $objPHPExcel->getActiveSheet()->setCellValue("AA11", ($companyDetails[0]->TEL) ? $companyDetails[0]->TEL : "");

          $objPHPExcel->getActiveSheet()->setCellValue("H20", strtoupper($university));
          $objPHPExcel->getActiveSheet()->setCellValue("Z20", $complete_year);
          $objPHPExcel->getActiveSheet()->setCellValue("AE20", $complete_month);
          $objPHPExcel->getActiveSheet()->setCellValue("AI20", ($complete_year != '') ? '01' : '');
          $objPHPExcel->getActiveSheet()->setCellValue("AC33", strtoupper($department));
          $objPHPExcel->getActiveSheet()->setCellValue("P43", $certDetail);

          if ($DOJ_SS != '' && $resignDateSS != '') {
            $objPHPExcel->getActiveSheet()->setCellValue("B51", date('Y', strtotime($DOJ_SS)));
            $objPHPExcel->getActiveSheet()->setCellValue("D51", date('m', strtotime($DOJ_SS)));
            $objPHPExcel->getActiveSheet()->setCellValue("F51", date('Y', strtotime($resignDateSS)));
            $objPHPExcel->getActiveSheet()->setCellValue("H51", date('m', strtotime($resignDateSS)));
            $objPHPExcel->getActiveSheet()->setCellValue("J51", 'Sathi Systems Pvt Ltd., India');

            $objPHPExcel->getActiveSheet()->setCellValue("B53", date('Y', strtotime($DOJ_MB)));
            $objPHPExcel->getActiveSheet()->setCellValue("D53", date('m', strtotime($DOJ_MB)));
            $objPHPExcel->getActiveSheet()->setCellValue("J53", '株式会社　Microbit');
            
          } else {
            $objPHPExcel->getActiveSheet()->setCellValue("B51", date('Y', strtotime($DOJ_MB)));
            $objPHPExcel->getActiveSheet()->setCellValue("D51", date('m', strtotime($DOJ_MB)));
            $objPHPExcel->getActiveSheet()->setCellValue("J51", '株式会社　Microbit');
          }

              
          // Sheet 3
          $objPHPExcel->setActiveSheetIndex(2);
          $objPHPExcel->getActiveSheet()->setCellValue("B3", 'For organization, part 1  N ("Highly Skilled Professional(i)(a/b)" / "Highly Skilled Professional(ii)"（only in cases of change of status） /');

          $objPHPExcel->getActiveSheet()->setCellValue("F9", strtoupper($empArray['FirstName'].' '.$empArray['LastName']));
          $objPHPExcel->getActiveSheet()->setCellValue("Y9", $aliencard[0]->CardNo);
          $objPHPExcel->getActiveSheet()->setCellValue("F24", ($companyDetails[0]->companyName) ? $companyDetails[0]->companyName : "");
          $companyNumberCells = array('V24', 'W24', 'X24', 'Y24', 'Z24', 'AA24', 'AB24', 'AC24', 'AD24', 'AE24', 'AF24', 'AG24', 'AH24');
          for ($w=0; $w <strlen($companyDetails[0]->companyNumber) ; $w++) { 
            $objPHPExcel->getActiveSheet()->setCellValue($companyNumberCells[$w], substr($companyDetails[0]->companyNumber,$w,1));
          }
          $objPHPExcel->getActiveSheet()->setCellValue("I27", ($companyDetails[0]->companyBranch) ? $companyDetails[0]->companyBranch : "");
          $objPHPExcel->getActiveSheet()->setCellValue("G73", ($companyDetails[0]->address) ? $companyDetails[0]->address : "");
          $objPHPExcel->getActiveSheet()->setCellValue("AA73", ($companyDetails[0]->TEL) ? $companyDetails[0]->TEL : "");
          $objPHPExcel->getActiveSheet()->setCellValue("G76", ($companyDetails[0]->capital) ? $companyDetails[0]->capital : "");
          $objPHPExcel->getActiveSheet()->setCellValue("AB76", ($salesData[0]['salesAmount']) ? $salesData[0]['salesAmount'] : "");

          // Sheet 4
          $objPHPExcel->setActiveSheetIndex(3);
          $objPHPExcel->getActiveSheet()->setCellValue("B3", 'For organization, part 2  N("Highly Skilled Professional(i)(a/b)" / "Highly Skilled Professional(ii)"（only in cases of change of status） /');
          $objPHPExcel->getActiveSheet()->setCellValue("I7", $totEmpCount);
          $objPHPExcel->getActiveSheet()->setCellValue("AA7", $foreignEmpCount);

          $objPHPExcel->getActiveSheet()->setCellValue("O13", ($contractAmount != '') ? $contractAmount : '');
          $objPHPExcel->getActiveSheet()->setCellValue("I16", ($expYears > 1) ? $expYears.' Years' : $expYears.' Year');
          $objPHPExcel->getActiveSheet()->setCellValue("Z16", $empArray['Designation']);

          // Sheet 5
          $objPHPExcel->setActiveSheetIndex(4);
          $objPHPExcel->getActiveSheet()->setCellValue("B3", 'For organization, part 3  N ("Highly Skilled Professional(i)(a/b)" / "Highly Skilled Professional(ii)"（only in cases of change of status） /');

          // Sheet 6
          $objPHPExcel->setActiveSheetIndex(5);
          $objPHPExcel->getActiveSheet()->setCellValue("B3", 'For organization, part 4  N ("Highly Skilled Professional(i)(a/b)" / "Highly Skilled Professional(ii)"（only in cases of change of status） /');

          $objPHPExcel->getActiveSheet()->setCellValue("B19", ($companyDetails[0]->CEO) ? $companyDetails[0]->CEO : "");
          $objPHPExcel->getActiveSheet()->setCellValue("X19", date('Y'));
          $objPHPExcel->getActiveSheet()->setCellValue("AC19", date('m'));
          $objPHPExcel->getActiveSheet()->setCellValue("AG19", date('d'));

          $objPHPExcel->setActiveSheetIndex(0);
          $objPHPExcel->getActiveSheet()->setSelectedCells("A1");
        })->setFilename('Visa_Extension_'.$employee[0]->LastName)->download('xls');
    }


}