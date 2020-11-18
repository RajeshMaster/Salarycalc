<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Session;
use Carbon\Carbon;
class Document extends Model{
	
    public static function getYears($request) {
   		$db = DB::connection('mysql');
		$years = $db->table('salc_required_document')
							->select(DB::raw('YEAR(registered_date) as years'))
							->groupBy(DB::raw('YEAR(registered_date)'))
							->get();
	 	return $years;
    }

	public static function getDocumentlist($request,$flg) {
		$db = DB::connection('mysql');
		$query = $db->table('salc_visa_document')
							->select('id', 'document_name')
							->where('delflg','=', 0);
							if ($flg == 1) {
								$query = $query ->where('id', '=', $request->document_name);
							}
			$query = $query ->get();

	 	return $query;
	}

	public static function getDocumentName($request) {
		$db = DB::connection('mysql');
		$query = $db->table('salc_visa_document')
							->select('id','document_name')
							->where('delflg','=', 0)
							->where('id', '=', $request->docId)
							->get();

	 	return $query;
	}

	public static function FnGetRecDocDetails($id,$request) {
		$db = DB::connection('mysql');
		$years = $db->table('salc_required_document')
							->select('*')
							->where('document_name','=', $id)
							->where('registered_date', 'LIKE', $request->selYear.'%')
							->limit(1)
							->get();
	 	return $years;
	}

	public static function singleDocumentDtls($request) {
			$db = DB::connection('mysql');
		$query = $db->table('salc_required_document')
							->select('id', 'registered_date', 'document_name', 'file_name', 'file_type', 'remarks')
							->where([['document_name','=',$request->docId]
								,['registered_date', 'LIKE', $request->selYear.'%']
								,['delflg','=',0]
							])
							->get();
	 	return $query;
	}

	public static function regDocumentChk($id,$year) {
			$db = DB::connection('mysql');
		$query = $db->table('salc_required_document')
							->select('*')
							->where([['document_name','=',$id]
									,['registered_date', 'LIKE', $year.'%']
									,['delflg','=',0]
							])
							->get();
	 	return $query;
	}

	public static function insertRec($request,$generatedFileName,$fileType) {
		$db = DB::connection('mysql');
  		$insert=$db->table('salc_required_document')
			   ->updateOrInsert([
			   		'id' => $request->id
	           	],
	       		[
	               'registered_date' => date('Y-m-d'),
			        'document_name' => $request->document_name,
					'file_name' => $generatedFileName,
			        'file_type' => $fileType,
			        'remarks' => $request->remarks,
			        'delflg' => 0,
			        'Ins_DT' => date('Y-m-d'),
					'Ins_TM' => date('h:i:s'),
					'Up_DT' => date('Y-m-d'),
					'UP_TM'=> date('h:i:s'),
					'CreatedBy' => Auth::user()->username,
					'UpdatedBy' => Auth::user()->username
	           ]);

      	return $insert;
	}

	public static function checkIdAvailableToUpdate($id) {
			$db = DB::connection('mysql');
		$query = $db->table('salc_required_document')
							->select('id', 'document_name')
							->where('document_name','=',$id)
							->where('delflg','=',0)
							->get();
	 	return $query;
	}

	public static function fnGetPrevDocName($request){
		$db = DB::connection('mysql');
		$query = $db->table('salc_required_document')
					->select('file_name','file_type')
					->where([['document_name','=',$request->docId]
								,['delflg','=',0]
							])
					->orderBy('registered_date','DESC')
					->limit(1)
					->get();

		return $query;
	}
}