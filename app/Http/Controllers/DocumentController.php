<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\User;
use App\Model\Document;
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
use Carbon;

class DocumentController extends Controller
{
    public function index(Request $request)
    {

    	if (empty($request->selYear)) {
			$request->selYear =  date('Y');
		}

    	// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
    	$employees = array();

    	// year bar process
		$cur_year = date('Y');
		$curtime = date('YmdHis');
		$yearArr = Document::getYears($request);
		$prev_yrs = array();
		$total_yrs = array();

		foreach ($yearArr as $value) {
			$prev_yrs[] = $value->years;
			$total_yrs[] = $value->years;
		}

		if (!in_array($cur_year, $total_yrs)) {
		    array_push($total_yrs,$cur_year);
		}

		if (isset($request->selYear) && !empty($request->selYear)) {
			$selectedYear=$request->selYear;
			$cur_year=$selectedYear;
		} else {
			$selectedYear=$cur_year;
		}

		$documentlist = Document::getDocumentlist($request,0); // For all documents

		$docDetails = array();
		foreach ($documentlist as $key => $value) {
			$docDetails[$key]['docName'] = $value->document_name;
			$docDetails[$key]['docId'] = $value->id;

			$reqDocDetails = Document::FnGetRecDocDetails($value->id,$request);
			if (isset($reqDocDetails[0])) {
				$docDetails[$key]['registered_date'] = $reqDocDetails[0]->registered_date;
				$docDetails[$key]['file_name'] = $reqDocDetails[0]->file_name;
				$docDetails[$key]['file_type'] = $reqDocDetails[0]->file_type;
				$docDetails[$key]['remarks'] = $reqDocDetails[0]->remarks;
			} else {
				$docDetails[$key]['registered_date'] = "";
				$docDetails[$key]['file_name'] = "";
				$docDetails[$key]['file_type'] = "";
				$docDetails[$key]['remarks'] = "";
			}
		}

    	return view('Document.index', ['documentlist' => $documentlist
    										, 'docDetails' =>  $docDetails
    										, 'cur_year' =>  $cur_year
    										, 'curtime' =>  $curtime
    										, 'prev_yrs' =>  $prev_yrs
    										, 'total_yrs' =>  $total_yrs
    										, 'selectedYear' =>  $selectedYear
                                  			, 'request' => $request]);
    }

    public function addedit(Request $request){

    	// $documentDtls = Document::getDocumentlist($request,0);  
    	// $documentName = array();
    	// foreach ($documentDtls as $k => $value) {

    	// 	if($request->editflg == 0){
    	// 		$regDoc = Document::regDocumentChk($value->id,$request->selYear);
    	// 		if (empty($regDoc)) {
	    // 			$documentName[$value->id] = $value->document_name;
    	// 		}

    	// 	} else {
    	// 		$documentName[$value->id] = $value->document_name;
    	// 	}

    	// }

    	$documentName = Document::getDocumentName($request);
    	$detedit = array();
    	if($request->editflg == 1){
			$detedit = Document::singleDocumentDtls($request);
		}

    	return view('Document.addedit',['documentName' => $documentName,
										'detedit' => $detedit,
										'request' => $request]);
    }

    public function addeditprocess(Request $request) {

    	$generatedFileName = ($request->file_name_temp) ? $request->file_name_temp : '';
    	$fileType = ($request->file_type) ? $request->file_type : '';

    	if ($request->document_name_atdb != '') {
    		if($request->document_name != $request->document_name_atdb){
	    		$fileType2 = explode("_",$request->file_name_temp);
	    		$tempType = explode(".",$fileType2[1]);
	    		$docDtls = Document::getDocumentlist($request,1);  // For single document
	    		$generatedFileName = $request->selYear.'_'.$docDtls[0]->document_name.".".$tempType[1];

	    		$path="resources/assets/documents/";
	    		$oldPath = $path.$request->file_name_temp;
	    		$newPath = $path.$generatedFileName;
	    		rename($oldPath,$newPath);
	    	}
    	}
    	
    	if ($_FILES["file_name"]["name"] != "") {

    		$ifile = $_FILES["file_name"]["name"];
			$fileType = explode(".",$ifile);
			$docDtls = Document::getDocumentlist($request,1);  // For single document
	    	if (isset($docDtls[0])) {
	    		$generatedFileName = $request->selYear.'_'.$docDtls[0]->document_name.".".end($fileType);
	    	} else {
	    		$generatedFileName = $request->selYear;
	    	}

			$path="resources/assets/documents";
			if(!is_dir($path)) {
	          mkdir($path, true);
	        }
	        chmod($path, 0777);
	        $path=$path."/";
	        
	        if ($request->file_name_temp != '') {
	    		unlink($path."/".$request->file_name_temp);
	    	}

	    	if(move_uploaded_file($_FILES['file_name']['tmp_name'],$path.$generatedFileName)){
	    		chmod($path.$generatedFileName,0777);
	    		if (file_exists($path.$generatedFileName)) {
					
					if ($fileType[1] == 'xls') {
						$fileType = 1;
					}elseif ($fileType[1] == 'xlsx') {
						$fileType = 2;
					}else{
						$fileType = 3;
					}
	    		}
	    	} else {
	    		Session::flash('message', 'Sorry, There was a problem uploading your file.'); 
	        	Session::flash('type', 'alert-danger');
	    	}

    	}

    	$insert = Document::insertRec($request,$generatedFileName,$fileType);
		if($request->id!="") {
			Session::flash('message', 'Updated Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('message', 'Inserted Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		}
		return Redirect::to('Document/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function fileDownloadProcess(Request $request) {

		// $detedit = Document::singleDocumentDtls($request);
		$detedit = Document::regDocumentChk($request->id,$request->selYear);
		$filepath = $detedit[0]->file_name;
		$path="resources/assets/documents/";

		if (!empty($filepath) && file_exists($path.$filepath)) {
			$filetodwld = $path.$filepath;
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$filepath");
			header("Content-Type: application/zip");
			header("Content-Transfer-Encoding: binary");
			readfile($filetodwld);
			exit;
		} else {
			// echo 'The file does not exist.';
			Session::flash('message', 'The file does not exist.'); 
	        Session::flash('type', 'alert-danger');
		}
		return Redirect::to('Document/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public function getPrevDocName(Request $request){
		$document = Document::fnGetPrevDocName($request);
		$documentArr = array();
		if (isset($document[0])) {
			$documentArr['file_name'] = $document[0]->file_name; 
			$documentArr['file_type'] = $document[0]->file_type;
			$documentArr = json_encode($documentArr);
			echo $documentArr;exit;
		} else {
			echo "empty";exit;
		}
	}

}