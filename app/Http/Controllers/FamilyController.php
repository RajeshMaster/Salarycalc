<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Family;

use DB;

use Input;

use Redirect;

use Config;

use Session;

use Illuminate\Support\Facades\Validator;


class FamilyController extends Controller {

	function index(Request $request) { 

		// PAGINATION
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//SORTING PROCESS
        if ($request->familysort == "") {
        	$request->familysort = "Emp_ID";
      	}
		if (empty($request->sortOrder)) {
        	$request->sortOrder = "asc";
      	}
      	if ($request->sortOrder == "asc") {  
      		$request->sortstyle="sort_asc";
      	} else {  
   			$request->sortstyle="sort_desc";
   		}

		if ( $request->searchmethod == 1) {
          $sortMargin = "margin-right:220px;";
        } else {
          $sortMargin = "margin-right:0px;";
        }

		$array = array("Emp_ID"=>trans('messages.lbl_empid'),
						"LastName"=>trans('messages.lbl_empName'));

		$empArrVal =Family::fnGetAllEmpDetails($request);

		$empArr = array();
		foreach ($empArrVal as $key => $value) {
			$empArr[] = $value->Emp_ID;
		}

		$familydataVal =Family::fnGetAllFamilyDetails($empArr);

		$familydata = array();
		foreach ($familydataVal as $key => $value) {
			$familydata[$value->Emp_ID][] = (array)$value;
		}

		return view('Family.index',['familydata' => $familydata,
										'array' => $array,
										'empArrVal' => $empArrVal,
										'sortMargin' => $sortMargin,
										'request' => $request]);

	}

	public function familyView(Request $request) { 

		if(Session::get('myfamilyEmp_ID') != "" && $request->Emp_ID == '') {
			$request->Emp_ID =  Session::get('myfamilyEmp_ID');
		}

		$empdetails = Family::fnGetEmpDetails($request);
		$familyArr = Family::fnGetFamilyDetails($request,0);

		$relationArr = array('1'=> trans('messages.lbl_father'),
    						 '2'=> trans('messages.lbl_mother'),
    						 '3'=> trans('messages.lbl_grandFather'),
    						 '4'=> trans('messages.lbl_grandMother'),
    						 '5'=> trans('messages.lbl_sister'),
    						 '6'=> trans('messages.lbl_brother'),
    						 '7'=> trans('messages.lbl_wife'),
    						 '8'=> trans('messages.lbl_son'),
    						 '9'=> trans('messages.lbl_daughter'));

		$family = array();
		$myFamily = array();

		$i = 1; 
		$j = 1; 
		$k = 1; 
		$l = 1;
		foreach ($familyArr as $key => $value) {
			if ($value->relationType <= 6 ) {

				$family[$key]['id'] = $value->id;
				$family[$key]['relation'] = $relationArr[$value->relationType];
				if ($value->relationType == 5) {
					$family[$key]['relation'] = $relationArr[$value->relationType].' '.$i;
					$i++;
				} else if($value->relationType == 6){
					$family[$key]['relation'] = $relationArr[$value->relationType].' '.$j;
					$j++;
				}
				$family[$key]['name'] = $value->FirstName.' '.$value->LastName;
				$family[$key]['kanaName'] = $value->Kana_FirstName.' '.$value->Kana_LastName;
				$family[$key]['DOB'] = $value->DOB;
				$family[$key]['liveInJapan'] = $value->liveInJapan;

			} else {

				$myFamily[$key]['id'] = $value->id;
				$myFamily[$key]['relation'] = $relationArr[$value->relationType];
				if ($value->relationType == 8) {
					$myFamily[$key]['relation'] = $relationArr[$value->relationType].' '.$k;
					$k++;
				} else if($value->relationType == 9){
					$myFamily[$key]['relation'] = $relationArr[$value->relationType].' '.$l;
					$l++;
				}

				$myFamily[$key]['name'] = $value->FirstName.' '.$value->LastName;
				$myFamily[$key]['kanaName'] = $value->Kana_FirstName.' '.$value->Kana_LastName;
				$myFamily[$key]['DOB'] = $value->DOB;
				$myFamily[$key]['liveInJapan'] = $value->liveInJapan;
			}
		}

	// $compare = self::makeSortFunction('DOB');
	// usort($sister, $compare);


		return view('Family.view',['family' => $family,
									'myFamily' => $myFamily,
									'empdetails' => $empdetails[0],
									'request' => $request]);
	}

	// public function makeSortFunction($field){
	//     $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
	//     return create_function('$a,$b', $code);
	// }


	// public function getSubRelation(Request $request) {

	// 	if ($request->relationType == 5) {
	// 		$label = trans('messages.lbl_sister');  $count = 6;
	// 	} else if ($request->relationType == 6) {
	// 		$label = trans('messages.lbl_brother');	$count = 6;
	// 	} else if ($request->relationType == 8) {
	// 		$label = trans('messages.lbl_son');		$count = 2;
	// 	} else if ($request->relationType == 9) {
	// 		$label = trans('messages.lbl_daughter');$count = 2;
	// 	}

	// 	for ($i=1; $i <= $count ; $i++) { 
	// 		$arr[$i] = $label.' '.$i; 
	// 	}
 //      	$subRelArr = json_encode($arr);
 //      	echo $subRelArr;exit;
 //    }

////////////////////////////*Original addEdit for edit all data Start*///////////////////////////////////////

	// public function addEdit(Request $request) {

 //        $empdetails = Family::fnGetEmpDetails($request);

	// 	$detedit = array();
 //        if ($request->editChk == 1) {
 //        	$detedit = Family::fnGetFamilyDetails($request,1);
	// 	}

	// 	// all relations
 //    	$relation = array('1'=> trans('messages.lbl_father'),
 //    						 '2'=> trans('messages.lbl_mother'),
 //    						 '3'=> trans('messages.lbl_grandFather'),
 //    						 '4'=> trans('messages.lbl_grandMother'),
 //    						 '5'=> trans('messages.lbl_sister'),
 //    						 '6'=> trans('messages.lbl_brother'));

 //        if ($empdetails[0]->MartialStatus == 2) {
 //        	array_push($relation, trans('messages.lbl_wife'),trans('messages.lbl_son'),trans('messages.lbl_daughter'));
 //        }

 //        // check already reg relations
	// 	$familyArr = Family::fnGetFamilyDetails($request,0);
	// 	$regRel = array();

	// 	if (count($familyArr) > 0 && count($detedit) == 0) {
	// 		$multiRelArr = array('5','6','8','9'); // relation sis,bro,son,daugh
	// 		foreach ($familyArr as $key => $value) {
 //    			if (!in_array($value->relationType, $multiRelArr)){
 //    				$regRel[$key] = $relation[$value->relationType];
 //    			}
	// 			// if ($value->relationType != 5 && $value->relationType != 6) {
	// 			// 	$regRel[$key] = $relation[$value->relationType];
	// 			// }
	// 		}
	// 	}

	// 	$relationArr = array_diff($relation, $regRel);
 //        $subRelationArr = array();

 //        return view('Family.addedit', ['relationArr' => $relationArr,
 //        							   'subRelationArr' => $subRelationArr,
	// 	                               'empdetails' => $empdetails[0],
	// 	                               'detedit' => $detedit,
	// 	                               'request' => $request]);
 //    }
////////////////////////////*Original addEdit for edit all data End*///////////////////////////////////////


	/*Altered addedit for avoid edit MB data*/
    public function addEdit(Request $request) {

        $empdetails = Family::fnGetEmpDetails($request);

		$detedit = array();
        if ($request->editChk == 1) {
        	$detedit = Family::fnGetFamilyDetails($request,1);
		}

		// My Family relations
    	$relationArr = array('7'=> trans('messages.lbl_wife'),
    						 '8'=> trans('messages.lbl_son'),
    						 '9'=> trans('messages.lbl_daughter'));

        // check already reg relations
        if ($request->editChk != 1) {
			$familyArr = Family::fnGetFamilyDetails($request,0);
			foreach ($familyArr as $key => $value) {
				if ($value->relationType == 7) {
					unset($relationArr[7]);  // to avoid multiple register
				}
			}
		}
        
        $subRelationArr = array();

        return view('Family.addedit', ['relationArr' => $relationArr,
        							   'subRelationArr' => $subRelationArr,
		                               'empdetails' => $empdetails[0],
		                               'detedit' => $detedit,
		                               'request' => $request]);
    }

	public function addeditprocess(Request $request) {

		$maleArr = array('1','3','6','8');
		if(in_array($request->relationType, $maleArr)){
			$gender = 1;  //Male
		} else {
			$gender = 2;  //Female
		}

        if(isset($request->editpage)) {

        	$chkRelChange = Family::fnGetFamilyDetails($request,1);
	        $relCount = "";
        	if ($chkRelChange[0]->relationType != $request->relationType) {

        		$multiRelArr = array('5','6','8','9'); // relation sis,bro,son,daugh
	        	if (in_array($request->relationType, $multiRelArr)){
	        		$relCount = Family::fnGetRelCount($request->Emp_ID,$request->relationType);
	        		$relCount += 1;
	        	}
        	}

            $update = Family::updateFamilyRec($request,$gender,$relCount);
            if($update) {
              Session::flash('message', 'Updated Sucessfully!'); 
              Session::flash('type', 'alert-success'); 
            } else {
              Session::flash('type', 'Updated Unsucessfully!'); 
              Session::flash('type', 'alert-danger'); 
            }
            
        } else {

        	$multiRelArr = array('5','6','8','9'); // relation sis,bro,son,daugh
        	$relCount = "";
        	if (in_array($request->relationType, $multiRelArr)){
        		$relCount = Family::fnGetRelCount($request->Emp_ID,$request->relationType);
        		$relCount += 1;
        	}

            $insert = Family::insertFamilyRec($request,$gender,$relCount);
            if($insert) {
              Session::flash('message', 'Inserted Sucessfully!'); 
              Session::flash('type', 'alert-success'); 
            } else {
              Session::flash('type', 'Inserted Unsucessfully!'); 
              Session::flash('type', 'alert-danger'); 
            }
        }
 
        Session::put('myfamilyEmp_ID', $request->Emp_ID); 

        return Redirect::to('Family/familyView?mainmenu=myfamily&time='.date('YmdHis'));
    }


    function importpopup(Request $request){
		//For Get The DataBase List
		$getOldDbDetails = Family::fnOldDbDetails();
		return view('Family.importpopup',['getOldDbDetails'=> $getOldDbDetails,
										'request' => $request]);
	}

	function importprocess(Request $request){

		//Get The New DataBase Details
		$getConnectionQuery = Family::fnGetConnectionQuery($request);
		$dbName = $getConnectionQuery[0]->DBName;
		$dbUser = $getConnectionQuery[0]->UserName;
		$dbPass = $getConnectionQuery[0]->Password;
		Config::set('database.connections.otherdb.database', $dbName);
		Config::set('database.connections.otherdb.username', $dbUser);
		Config::set('database.connections.otherdb.password', $dbPass);
		try {
			$db = DB::connection('otherdb');
			$db->getPdo();
			if($db->getDatabaseName()){

				$familydata =Family::fnImportProcess($request);
				$columns = array();
				$columns['name'] = array('FatherName', 'MotherName','GrandFatherName', 'GrandMotherName'
									, 'YoungerBrother1Name', 'YoungerBrother2Name', 'YoungerBrother3Name'
									, 'YoungerBrother4Name', 'YoungerBrother5Name', 'YoungerBrother6Name'
									, 'YoungerSister1Name', 'YoungerSister2Name', 'YoungerSister3Name'
									, 'YoungerSister4Name', 'YoungerSister5Name', 'YoungerSister6Name'
									, 'ElderBrother1Name', 'ElderBrother2Name', 'ElderBrother3Name'
									, 'ElderBrother4Name', 'ElderBrother5Name', 'ElderBrother6Name'
									, 'ElderSister1Name', 'ElderSister2Name', 'ElderSister3Name'
									, 'ElderSister4Name', 'ElderSister5Name', 'ElderSister6Name'
								);
				$columns['kananame'] = array( 'FatherkanaName', 'MotherkanaName','GrandFatherkanaName', 'GrandMotherkanaName'
										, 'YoungerBrother1KanaName', 'YoungerBrother2KanaName', 'YoungerBrother3KanaName'
										, 'YoungerBrother4KanaName', 'YoungerBrother5KanaName', 'YoungerBrother6KanaName'
										, 'YoungerSister1KanaName', 'YoungerSister2KanaName', 'YoungerSister3KanaName'
										, 'YoungerSister4KanaName', 'YoungerSister5KanaName', 'YoungerSister6KanaName'
										, 'ElderBrother1kanaName', 'ElderBrother2kanaName', 'ElderBrother3kanaName'
										, 'ElderBrother4kanaName', 'ElderBrother5kanaName', 'ElderBrother6kanaName'
										, 'ElderSister1kanaName', 'ElderSister2kanaName', 'ElderSister3kanaName'
										, 'ElderSister4kanaName', 'ElderSister5kanaName', 'ElderSister6kanaName'
									);

				$columns['DOB'] = array( 'FatherDOB', 'MotherDOB','GrandFatherDOB', 'GrandMotherDOB'
										, 'YoungerBrother1DOB', 'YoungerBrother2DOB', 'YoungerBrother3DOB'
										, 'YoungerBrother4DOB', 'YoungerBrother5DOB', 'YoungerBrother6DOB'
										, 'YoungerSister1DOB', 'YoungerSister2DOB', 'YoungerSister3DOB'
										, 'YoungerSister4DOB', 'YoungerSister5DOB', 'YoungerSister6DOB'
										, 'ElderBrother1DOB', 'ElderBrother2DOB', 'ElderBrother3DOB'
										, 'ElderBrother4DOB', 'ElderBrother5DOB', 'ElderBrother6DOB'
										, 'ElderSister1DOB', 'ElderSister2DOB', 'ElderSister3DOB'
										, 'ElderSister4DOB', 'ElderSister5DOB', 'ElderSister6DOB'
									);

				$relationCount = 0;
				foreach ($familydata as $key => $value) {
					
					$sister = 1;
					$brother = 1;
					for ($i=0; $i < sizeof($columns['name']); $i++) {
						if ($columns['name'][$i] == 'FatherName') {
							$relationType = 1;
							$gender = 1;
						}

						if ($columns['name'][$i] == 'MotherName') {
							$relationType = 2;
							$gender = 2;
						}

						if ($columns['name'][$i] == 'GrandFatherName') {
							$relationType = 3;
							$gender = 1;
						}

						if ($columns['name'][$i] == 'GrandMotherName') {
							$relationType = 4;
							$gender = 2;
						}

						if (($columns['name'][$i] == 'ElderSister1Name') || ($columns['name'][$i] == 'ElderSister2Name')
						 || ($columns['name'][$i] == 'ElderSister3Name') || ($columns['name'][$i] == 'ElderSister4Name')
						 || ($columns['name'][$i] == 'ElderSister5Name') || ($columns['name'][$i] == 'ElderSister6Name')
						 || ($columns['name'][$i] == 'YoungerSister1Name') || ($columns['name'][$i] == 'YoungerSister2Name')
						 || ($columns['name'][$i] == 'YoungerSister3Name') || ($columns['name'][$i] == 'YoungerSister4Name')
						 || ($columns['name'][$i] == 'YoungerSister5Name') || ($columns['name'][$i] == 'YoungerSister6Name')) {
								$relationType = 5;
								$gender = 2;
						}

						if (($columns['name'][$i] == 'ElderBrother1Name') || ($columns['name'][$i] == 'ElderBrother2Name')
						 || ($columns['name'][$i] == 'ElderBrother3Name') || ($columns['name'][$i] == 'ElderBrother4Name')
						 || ($columns['name'][$i] == 'ElderBrother5Name') || ($columns['name'][$i] == 'ElderBrother6Name')
						 || ($columns['name'][$i] == 'YoungerBrother1Name') || ($columns['name'][$i] == 'YoungerBrother2Name')
						 || ($columns['name'][$i] == 'YoungerBrother3Name') || ($columns['name'][$i] == 'YoungerBrother4Name')
						 || ($columns['name'][$i] == 'YoungerBrother5Name') || ($columns['name'][$i] == 'YoungerBrother6Name')) {
								$relationType = 6;
								$gender = 1;
						}

						$recordArr = array();
						if ($value->$columns['name'][$i] != "" && $value->$columns['kananame'][$i] != "") {

							// echo $columns['name'][$i].' : '.$value->$columns['name'][$i].':'.$relationType;echo "<br/>";
							// echo $columns['kananame'][$i].' : '.$value->$columns['kananame'][$i].':'.$relationType;echo "<br/>";
							// echo $columns['DOB'][$i].' : '.$value->$columns['DOB'][$i].':'.$relationType;echo "<br/>";

							// $recordArr['subRelationType'] = "";
							// if ($relationType == 5) {
							// 	$relationCount = Family::fnGetSubRelation($value->Emp_ID,$relationType,$sister);
							// 	if ($relationCount) {
							// 		$sister = $relationCount[0]->subRelationType + 1;
							// 		$recordArr['subRelationType'] = $sister;
							// 	} else {
							// 		$recordArr['subRelationType'] = $sister;
							// 	}
							// 	$sister++;
							// }

							// if ($relationType == 6) {
							// 	$relationCount = Family::fnGetSubRelation($value->Emp_ID,$relationType,$brother);
							// 	if ($relationCount) {
							// 		$brother = $relationCount[0]->subRelationType + 1;
							// 		$recordArr['subRelationType'] = $brother;
							// 	} else {
							// 		$recordArr['subRelationType'] = $brother;
							// 	}
							// 	$brother++;
							// }

							$recordArr['subRelationType'] = "";
							if ($relationType == 5) {  // Sister
								$x = 1;
								while($x == 1){
									$relVal = Family::fnGetSubRelation($value->Emp_ID,$relationType,$sister);
									if (empty($relVal)) {
										$x++;
										$recordArr['subRelationType'] = $sister;
										$sister++;
										break;
									} else {
										$recordArr['subRelationType'] = $sister + 1;
										$sister++;
									}
								}
							}

							if ($relationType == 6) {  // Brother
								$y = 1;
								while($y == 1){
									$relVal = Family::fnGetSubRelation($value->Emp_ID,$relationType,$brother);
									if (empty($relVal)) {
										$y++;
										$recordArr['subRelationType'] = $brother;
										$brother++;
										break;
									} else {
										$recordArr['subRelationType'] = $brother + 1;
										$brother++;
									}
								}
							}

							$recordArr['relationType'] = $relationType;  
							$recordArr['Emp_ID'] = $value->Emp_ID;  
							$recordArr['lastName'] = $value->$columns['name'][$i];  
							$recordArr['kanaLastName'] = $value->$columns['kananame'][$i];  
							$recordArr['DOB'] = $value->$columns['DOB'][$i];
							$recordArr['gender'] = $gender;

							$insertOrUpdate = Family::fnInsertOrUpdate($recordArr);

						}
					}
				}

				Session::flash('success', 'Imported Sucessfully!'); 
				Session::flash('type', 'alert-success');

			} else {
				Session::flash('success', 'Invalid Db Connection'); 
				Session::flash('type', 'alert-danger'); 
			}
		} catch (\Exception $e) {
			echo $e->getmessage();exit;
	        Session::flash('success', 'Catch Error'); 
			Session::flash('type', 'alert-danger'); 
	    }
		return Redirect::to('Family/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
	

}