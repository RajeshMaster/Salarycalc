<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Input;
use Carbon;
use Session;
use DB;
use Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
class contract extends Model {
	public static function contractindex($request){
		$db = DB::connection('mysql_MB');
		if ($request->contractsort == "") {
			$request->contractsort = "Emp_ID";
		}
		$query = $db->table('emp_mstemployees AS emp')
					 ->select('emp.FirstName','emp.LastName','emp.Emp_ID AS Emp_id')
					 ->where('emp.delFlg', '=', 0)
					 ->where('emp.resign_id', '=', 0)
					 ->where('emp.Title', '=', 2)
					 ->where('emp.Emp_id', 'NOT LIKE', '%NST%');
			if ($request->searchmethod == 1) {
				// SINGLE SEARCH
				$query = $query->where(function($joincont) use ($request) {
							$joincont->where('emp.Emp_id', 'LIKE', '%' . trim($request->singlesearch) . '%')
							->orWhere('emp.LastName', 'LIKE', '%' . trim($request->singlesearch) . '%')
							->orWhere('emp.FirstName', 'LIKE', '%' . trim($request->singlesearch) . '%');
						});
			} else if ($request->searchmethod == 2) {
				// MULTI SEARCH
				if (!empty($request->msearchempid)) {
					$query = $query->where('emp.Emp_ID', 'LIKE', '%' . trim($request->msearchempid) . '%');
				}
				if (!empty($request->msearchempname)) {
					$query = $query->where(function($joincont) use ($request) {
							$joincont->where('emp.LastName', 'LIKE', '%' . trim($request->msearchempname) . '%')
								->orWhere('emp.FirstName', 'LIKE', '%' . trim($request->msearchempname) . '%');
						});
				}
			}
			$query = $query->groupBy('emp.Emp_id')
							->orderBy($request->contractsort, $request->sortOrder)
							->paginate($request->plimit);
		return $query;
	}
	public static function fnGetAllContractDetails($empId){
		$db = DB::connection('mysql');
		$query= $db->table('mstcontract')
					->where('Emp_id',$empId)
					->orderBy('Created_Date','DESC')
					->limit(1)
					->get();

		return $query;
	}
	public static function getContractempDetails($request) {
		$db = DB::connection('mysql_MB');
		$query = $db->TABLE('emp_mstemployees AS emp')
					->SELECT('emp.Emp_ID','emp.FirstName','emp.LastName','emp.Gender')
					->where('emp.Emp_ID', '=', $request->contractid)
					->get();
		return $query;
	}
	public static function getContractDetails($request,$limit) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mstcontract')
					->SELECT('mstcontract.StartDate','mstcontract.Id as contract_id','mstcontract.EndDate','mstcontract.Salary','mstcontract.Travel_Expense','mstcontract.Accommodation','mstcontract.Total','mstcontract.Contract_date','mstcontract.Remarks','mstcontract.Created_Date')
					->where('mstcontract.Emp_id', '=', $request->contractid)
					->take($limit)
					->orderBy('Created_Date', 'desc')
					->get();
		return $query;
	}
	public static function getContractDetailsview($request,$limit,$empid,$contid) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mstcontract')
					->SELECT('mstcontract.Emp_id','mstcontract.StartDate','mstcontract.EndDate','mstcontract.Salary','mstcontract.Travel_Expense','mstcontract.Accommodation','mstcontract.Total','mstcontract.Contract_date','mstcontract.Remarks','mstcontract.Created_Date')
					->where('mstcontract.Emp_id', '=', $empid)
					->where('mstcontract.Id', '=', $contid)
					->take($limit)
					->get();
				// ->toSQL();
				// dd($query);
		return $query;
	}
	public static function insertcontractRec($request,$data) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$Salary = preg_replace('/,/', '', $request->Salary);
		$Travel_Expense = preg_replace('/,/','', $request->Travel_Expense);
		$Accommodation = preg_replace('/,/','', $request->Accommodation);
		$Total = number_format($request->Total);
		$db = DB::connection('mysql');
		$insert=$db->table('mstcontract')
				->insert([
					'Emp_id' => $request->contractid,
					'Id' => '',
					'StartDate' => $request->StartDate,
					'EndDate' => $request->CoEndDate,
					'Salary' => $Salary,
					'Travel_Expense' => $Travel_Expense,
					'Accommodation' => $Accommodation,
					'Total' => $Total,
					'Contract_date' => $request->Contract_date,
					'Remarks' => $request->Remarks,
					'Delete_flg' => 0,
					'Update_Date' =>date('YmdHis'),
					'Created_Date' =>date('YmdHis'),
					'Created_Name' => $name
				]);
		return $insert;
	}
	public static function updateContractRec($request,$data) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$Salary = preg_replace('/,/', '', $request->Salary);
		$Travel_Expense = preg_replace('/,/', '', $request->Travel_Expense);
		$Accommodation = preg_replace('/,/', '', $request->Accommodation);
		$Total = number_format(str_replace(',', '', $request->Total));
		$db = DB::connection('mysql');
		if(!isset($request->contractid) && !isset($request->id)) {
			$request->contractid=old('contractid');
			$request->id = old('id');
		}
		$update=$db->table('mstcontract')
				->where('Emp_id', $request->contractid)
				->where('Id', $request->contract_id)
				->update([
					'StartDate' => $request->StartDate,
					'EndDate' => $request->CoEndDate,
					'Salary' => $Salary,
					'Travel_Expense' => $Travel_Expense,
					'Accommodation' => $Accommodation,
					'Total' => $Total,
					'Contract_date' => $request->Contract_date,
					'Remarks' => $request->Remarks,
					'Update_Date' =>date('YmdHis'),
					'Update_Name' => $name]
			  );
		return $update;
	}
	public static function getlatContractDet($request) {
		$db = DB::connection('mysql');
		$latDetails = $db->TABLE('mstcontract')
							->Select('*')
							->orderBy('Id','DESC')
							->get();
		return $latDetails;
	}
	public static function ContractDetedit($request) {
		$db = DB::connection('mysql');
		if(!isset($request->contractid) && !isset($request->contract_id)) {
			$request->contractid=old('contractid');
			$request->contract_id=old('contract_id');
		}
		$Details = $db->TABLE('mstcontract')
						->WHERE('Emp_id', '=', $request->contractid)
						->WHERE('id', '=', $request->contract_id)
						->get();
	return $Details;
	}
	public static function getempdtls($request){
		$db = DB::connection('mysql_MB');
		$query = $db->TABLE('emp_mstemployees AS emp')
					->SELECT('emp.Emp_ID','emp.FirstName',
						'emp.LastName','emp.KanaFirstName','emp.KanaLastName',
						'emp.Gender','emp.DOB','alien.id','alien.user_id',
						DB::raw("CONCAT('〒',addr.pincode,' ', addr.jpstate,'',addr.jpaddress,'-',addr.roomno,'号') AS full_address"))
					->leftJoin('mstalien as alien', function($join){
						$join->on('emp.Emp_ID' ,'=','alien.user_id')
							      ->on('alien.EdDate', '=', DB::raw("(Select MAX(EdDate) from mstalien where user_id = emp.Emp_ID)"));
					})
					->leftJoin('mstaddress as addr' , 'alien.Address' ,'=','addr.id')
					->where('emp.Emp_ID','=',$request->contractid)
					->get();
		return $query;
	}
	public static function getcontractdtls($request){
		$query=DB::table('mstcontract')
				->select('*')
				->where('Id','=',$request->contract_id)
				->where('Emp_id','=',$request->contractid)
				//->toSQL();
				//dd($query);  
				->get();

		return $query;
	}
	public static function fnGetPassport($request){
		$db = DB::connection('mysql_MB');
		$query = $db->table('mstpassport')
				->select('*')
				->where('user_id', '=', $request->contractid)
				->orderBy('DOE','DESC')
				->limit(1)
				->get();
		return $query;
	}
	public static function getscertifyhistory($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mstcontract')
						->SELECT('StartDate',
								'EndDate',
								'Contract_date',
								'Total',
								'Created_Date')
						->where('mstcontract.Id',$request->contract_id)
						->where('mstcontract.Emp_id',$request->contractid)
						->orderBy('Created_Date', 'DESC')
						->get();
						// ->toSql();
						// dd($query);
		return $query;
	}
	public static function getSalCertifyHistory($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mstcontract')
						->SELECT('mstcontract.StartDate',
								'mstcontract.EndDate',
								'mstcontract.Contract_date',
								'salarycertification.contract_id',
								'salarycertification.Total',
								'mstcontract.Created_Date')
						->LEFTJOIN('salarycertification', 'mstcontract.id' ,'=','salarycertification.contract_id')
						->where('mstcontract.Id',$request->contract_id)
						->where('mstcontract.Emp_id',$request->contractid)
						->where('salarycertification.id',$request->salCertification_id)
						->orderBy('Created_Date', 'DESC')
						->get();

		return $query;
	}
	public static function getinsertcertifyhistory($request) {
		$name = Session::get('LastName').' '.Session::get('FirstName');
		$db = DB::connection('mysql');
		$query =  $db->TABLE('salarycertification') 
					->insert([
						'id' => '',
						'userid' => $request->contractid,
						'contract_id' => $request->contract_id,
						'reason' => $request->txt_reason,
						'Total' => $request->Total,
						'Ins_Dt' =>date('Ymdhis'),
						'delflg' => 0,
						'createdby' => $name
					]);
		return $query;
	}
	public static function getsalarycertifyhistory($request) {
		$db = DB::connection('mysql_MB');
		$query = $db->TABLE('emp_mstemployees')
						->SELECT('Emp_ID',
								'FirstName',
								'LastName',
								'KanaFirstName',
								'KanaLastName',
								'Gender',
								'DOJ',
								'DOB',
								'CreatedBy')
						->where('Emp_ID', '=', $request->contractid)
						->get();
						// ->toSql();
						// dd($query);
		return $query;
	}
	public static function getcertifyhistory($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('salarycertification')
					->SELECT('id','contract_id','reason','total','Ins_Dt','createdby')
					->where('userid', '=', $request->contractid)
					->where('delflg', '=', 0)
					->orderBy('Ins_Dt', 'DESC')
					->get();
		return $query;
	}
}