<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\FamilyVisa;

use DB;

use Input;

use Redirect;

use Config;

use Session;

use Illuminate\Support\Facades\Validator;


class FamilyVisaController extends Controller {

	function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->familyVisasort == "") {
        	$request->familyVisasort = "Emp_ID";
      	}
		if (empty($request->sortOrder)) {
        	$request->sortOrder = "asc";
      	}
      	if ($request->sortOrder == "asc") {  
      		$request->sortstyle="sort_asc";
      	} else {  
   			$request->sortstyle="sort_desc";
   		}

		$array = array("Emp_ID"=>trans('messages.lbl_empid'),
						"LastName"=>trans('messages.lbl_empName'));
		
		$empdetails=FamilyVisa::fnGetEmpDetails($request);

		return view('FamilyVisa.index',['array' => $array,
										'empdetails' => $empdetails,
										'request' => $request]);

	}

	function familyView(Request $request) { 

		if (!isset($request->Emp_ID)) {
			$request->Emp_ID = $request->visaid;
		}

		if(Session::get('familyVisaEmp_ID') != "" && $request->Emp_ID == '') {
			$request->Emp_ID =  Session::get('familyVisaEmp_ID');
		}

		// Get all visa
		$visaDetails = FamilyVisa::fnGetVisaDetails($request,0);
		$empdetails = FamilyVisa::fnGetEmpDetails($request->Emp_ID);

		return view('FamilyVisa.listview',['visaDetails' => $visaDetails,
											'empdetails' => $empdetails[0],
											'request' => $request]);
	}

	function singleView(Request $request) { 

		if(Session::get('familyVisaId') != "" && Session::get('familyVisaEmp_ID') != "" && $request->Emp_ID == '') {
			$request->id =  Session::get('familyVisaId');
			$request->Emp_ID =  Session::get('familyVisaEmp_ID');
		}

		if (!isset($request->Emp_ID)) {
			$request->Emp_ID = $request->visaid;
		}

		// Get single visa
		$visaDetails = FamilyVisa::fnGetVisaDetails($request,1);
		$empdetails = FamilyVisa::fnGetEmpDetails($request->Emp_ID);
		$address = FamilyVisa::getEmpVisaAddress($request->Emp_ID);

		return view('FamilyVisa.view',['visaDetails' => $visaDetails,
											'address' => $address[0],
											'empdetails' => $empdetails[0],
											'request' => $request]);
	}

	public function addEdit(Request $request) {

        if (!isset($request->Emp_ID)) {
			$request->Emp_ID = $request->visaid;
		}

        $empdet = FamilyVisa::fnGetEmpDetails($request->Emp_ID);
        
        $address = FamilyVisa::getEmpVisaAddress($request->Emp_ID);

		if ($address[0]->Address == 0) {
			Session::flash('message', 'Please update your Visa Address...'); 
            Session::flash('type', 'alert-danger'); 
            
            Session::put('familyVisaEmp_ID', $request->Emp_ID); 
			return Redirect::to('FamilyVisa/familyView?mainmenu=familyvisa&time='.date('YmdHis'));
		}

		$detedit = array();
        // $Emp_Relation = array('1'=> trans('messages.lbl_wife'),'2'=> trans('messages.lbl_son'),'3'=> trans('messages.lbl_daughter'));
		// all relations
    	$Emp_Relation = array('1'=> trans('messages.lbl_father'),
    						 '2'=> trans('messages.lbl_mother'),
    						 '3'=> trans('messages.lbl_grandFather'),
    						 '4'=> trans('messages.lbl_grandMother'),
    						 '5'=> trans('messages.lbl_sister'),
    						 '6'=> trans('messages.lbl_brother'));

        if ($empdet[0]->MartialStatus == 2) {
        	array_push($Emp_Relation, trans('messages.lbl_wife'),trans('messages.lbl_son'),trans('messages.lbl_daughter'));
        }

        // To get relation live in japan
        $empRelationInJapan = FamilyVisa::getEmpRelationInJapan($request->Emp_ID);
        $Emp_Relation = array_intersect_key($Emp_Relation, $empRelationInJapan);

        if (empty($empRelationInJapan)) {
        	Session::flash('message', 'No one living in Japan...'); 
            Session::flash('type', 'alert-danger'); 
            
            Session::put('familyVisaEmp_ID', $request->Emp_ID); 
			return Redirect::to('FamilyVisa/familyView?mainmenu=familyvisa&time='.date('YmdHis'));
        }


        $Nationality = array('1'=> trans('messages.lbl_indian'),'2'=> trans('messages.lbl_japanese'),'3' => trans('messages.lbl_Others'));


        if ($request->editChk == 1) {
        	$detedit = FamilyVisa::fnGetVisaDetails($request,1);
		}

        return view('FamilyVisa.addedit', ['address' => $address,
	        								'Emp_Relation' => $Emp_Relation,
	        								'Nationality' => $Nationality,
		                                   	'empdet' => $empdet[0],
		                                   	'detedit' => $detedit,
		                                   	'request' => $request]);
    }

	public function addeditprocess(Request $request) {

       	if (!isset($request->Emp_ID)) {
			$request->Emp_ID = $request->visaid;
		}

		$maleArr = array('1','3','6','8');
		if(in_array($request->Emp_Relation, $maleArr)){
			$gender = 1;  //Male
		} else {
			$gender = 2;  //Female
		}

        if(isset($request->editpage)) {
            $update = FamilyVisa::updateFamilyVisaRec($request,$gender);
            if($update) {
              Session::flash('message', 'Updated Sucessfully!'); 
              Session::flash('type', 'alert-success'); 
            } else {
              Session::flash('type', 'Updated Unsucessfully!'); 
              Session::flash('type', 'alert-danger'); 
            }
        } else {
            $insert = FamilyVisa::insertFamilyVisaRec($request,$gender);
            if($insert) {
              Session::flash('message', 'Inserted Sucessfully!'); 
              Session::flash('type', 'alert-success'); 
            } else {
              Session::flash('type', 'Inserted Unsucessfully!'); 
              Session::flash('type', 'alert-danger'); 
            }
        }

        if(!isset($request->editpage)) {
          	$request->id = FamilyVisa::getlatFamilyVisaDet();
        } 

        Session::put('familyVisaId', $request->id ); 
        Session::put('familyVisaEmp_ID', $request->Emp_ID); 

        return Redirect::to('FamilyVisa/singleView?mainmenu=familyvisa&time='.date('YmdHis'));
    }

    public function getSubRelation(Request $request) {

    	$getSubRelation = FamilyVisa::fnGetSubRelations($request);
    	
		if ($request->relationType == 5) {
			$label = trans('messages.lbl_sister');  $count = 6;
		} else if ($request->relationType == 6) {
			$label = trans('messages.lbl_brother');	$count = 6;
		} else if ($request->relationType == 8) {
			$label = trans('messages.lbl_son');		$count = 2;
		} else if ($request->relationType == 9) {
			$label = trans('messages.lbl_daughter');$count = 2;
		}

		$i = 1;
		foreach ($getSubRelation as $key => $value) {
    		$arr[$key]['subRelationType'] = $value->subRelationType;
    		$arr[$key]['stringVal'] = $label.' '.$i;
    		$i++;
    	}

      	$subRelArr = json_encode($arr);
      	echo $subRelArr;exit;
    }

    public function getBasicDetails(Request $request) {

    	$basicDetails = FamilyVisa::fnGetBasicDetails($request);
    	$basicDetailsArr = json_encode($basicDetails);
		echo $basicDetailsArr;exit;

    }
    
}