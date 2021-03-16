<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('login.login');
});
Route::get('/pdf', function () {
	Fpdf::AddPage();
	Fpdf::SetFont('Courier', 'B', 38);
	Fpdf::Cell(50, 25, 'Hello Worlda!');
	Fpdf::Output();
});
// LOGIN PAGE
Route::get('login', 'LoginController@index');
Route::post('login', 'LoginController@authenticate');
// END LOGIN PAGE
// FORGET_PASSWORD
Route::any('forgetpassword', 'LoginController@forgetpassword');
Route::any('formValidation', 'LoginController@formValidation');
Route::any('addeditprocess', 'LoginController@addeditprocess');
// END_FORGET_PASSWORD
// LOGOUT PROCESS
Route::get('logout', 'Auth\AuthController@logout');
// Route::get('logout', 'LoginController@logout');
// END LOGOUT PROCESS
//Master User
Route::group(['prefix'=>'User', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'UserController@index');
	Route::any('addedit', 'UserController@addedit');
	Route::any('formValidation', 'UserController@formValidation');
	Route::any('addeditprocess', 'UserController@addeditprocess');
	Route::any('view', 'UserController@view');
	Route::any('changepassword', 'UserController@changepassword');
	Route::any('passwordchangeprocess', 'UserController@passwordchangeprocess');
});
//Staff
Route::group(['prefix'=>'Staff', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'StaffController@index');
	Route::any('staffaddedit', 'StaffController@staffaddedit');
	Route::any('staffaddeditprocess', 'StaffController@addeditprocess');
	Route::any('view', 'StaffController@view');
	Route::any('importpopup', 'StaffController@importpopup');
	Route::any('importprocess', 'StaffController@importprocess');
	Route::any('rejoin', 'StaffController@rejoin');
	Route::any('resign', 'StaffController@resign');
	Route::any('resignadd', 'StaffController@resignadd');
	Route::get('update_mail', 'StaffController@update_mail');
});
//NonStaff
Route::group(['prefix'=>'NonStaff', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'NonStaffController@index');
	Route::any('nonstaffadd', 'NonStaffController@nonstaffadd');
	Route::any('nonstaffaddeditprocess', 'NonStaffController@nonstfaddeditprocess');
	Route::any('nonstaffview', 'NonStaffController@nonstaffview');
});

//NonStaff
Route::group(['prefix'=>'salarEmp', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'SalarycalcAndSalaryplusController@index');
	Route::any('addeditemp', 'SalarycalcAndSalaryplusController@addeditemp');
	Route::any('salindex', 'SalarycalcAndSalaryplusController@salindex');
});


// Home
Route::group(['prefix'=>'Menu', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::get('index', 'MenuController@index');
	Route::get('indexNew', 'MenuController@indexNew');
});

// Setting
Route::group(['prefix'=>'Setting', 'middleware' => 'auth'], function() {
Route::any('index', 'SettingController@index');
Route::get('changelanguage', 'AjaxController@index');
Route::get('singletextpopup', 'SettingController@singletextpopup');
Route::any('SingleFieldaddedit', 'SettingController@SingleFieldaddedit');
Route::get('twotextpopup', 'SettingController@twotextpopup');
Route::get('twoFieldaddedit', 'SettingController@twoFieldaddedit');
Route::get('selectthreefieldDatasforbank', 'SettingController@selectthreefieldDatas');
Route::get('selectthreefieldDatas', 'SettingController@selectthreefieldDatas');
Route::get('threeFieldaddeditforbank', 'SettingController@threeFieldaddeditforbank');
Route::get('threeFieldaddedit', 'SettingController@threeFieldaddedit');
Route::any('uploadpopup', 'SettingController@uploadpopup');
Route::any('useNotuse', 'SettingController@useNotuse');
Route::any('settingpopupupload', 'SettingController@settingpopupupload');
Route::any('eighttextpopup', 'SettingController@eighttextpopup');
Route::get('onetextpopup', 'SettingController@onetextpopup');
Route::get('oneFieldaddedit', 'SettingController@oneFieldaddedit');
});


//Staff -> Salary Calculation
Route::group(['prefix'=>'salarycalc','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'SalarycalcController@index');
	Route::any('view', 'SalarycalcController@view');
	Route::any('edit', 'SalarycalcController@edit');
	Route::any('addedit', 'SalarycalcController@addedit');
	Route::any('addeditprocess', 'SalarycalcController@addeditprocess');
	Route::any('multieditprocess', 'SalarycalcController@multieditprocess');
	Route::any('multiregister', 'SalarycalcController@multiregister');
	Route::any('salarypopup', 'SalarycalcController@salarypopup');
	Route::any('empselectprocess', 'SalarycalcController@empselectprocess');
	Route::any('mailsendprocess', 'SalarycalcController@mailsendprocess');
	Route::any('salarydownload', 'SalarycalcController@salarydownload');
	Route::any('history', 'SalarycalcController@history');
	Route::any('getdataExists', 'SalarycalcController@getdataExists');
	Route::any('dataReg', 'SalarycalcController@dataReg');
	Route::get('getlastmonthdet', 'SalarycalcController@getlastmonthdet');
});
//Staff -> Salary Calculation Plus
Route::group(['prefix'=>'salarycalcplus','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'SalarycalcplusController@index');
	Route::any('view', 'SalarycalcplusController@view');
	Route::any('edit', 'SalarycalcplusController@edit');
	Route::any('addedit', 'SalarycalcplusController@addedit');
	Route::any('addeditprocess', 'SalarycalcplusController@addeditprocess');
	Route::any('multieditprocess', 'SalarycalcplusController@multieditprocess');
	Route::any('multiregister', 'SalarycalcplusController@multiregister');
	Route::any('salarypopup', 'SalarycalcplusController@salarypopup');
	Route::any('empselectprocess', 'SalarycalcplusController@empselectprocess');
	Route::any('contractemppopup', 'SalarycalcplusController@contractemppopup');
	Route::any('contractempselproces', 'SalarycalcplusController@contractempselproces');
	Route::any('mailsendprocess', 'SalarycalcplusController@mailsendprocess');
	Route::any('history', 'SalarycalcplusController@history');
	Route::any('getdataExists', 'SalarycalcplusController@getdataExists');
	Route::any('dataReg', 'SalarycalcplusController@dataReg');
	Route::get('getsalamount', 'SalarycalcplusController@getajaxtotamt');
	Route::get('getlastmonthdet', 'SalarycalcplusController@getlastmonthdet');
	Route::any('salarydownloadprocess', 'SalarycalcplusController@salarydownloadprocess');
	Route::any('transferdetailsdownload', 'SalarycalcplusController@transferdetailsdownload');
	Route::any('salaryplusdownload', 'SalarycalcplusController@salaryplusdownload');
	Route::any('salaryplusPayrollSingleDownload', 'SalarycalcplusController@salaryplusPayrollSingleDownload');
	Route::any('gensenDownload', 'SalarycalcplusController@gensenDownload');
	Route::any('getTransferedAmount', 'SalarycalcplusController@getTransferedAmount');
	// Start Madasamy Code 22/05/20
	Route::any('historyTotal', 'SalarycalcplusController@historyTotal');
	Route::any('salarypluspdfdownload', 'SalarycalcplusController@salarypluspdfdownload');
	// End Madasamy Code 22/05/20
});

//Staff -> Contract Employee Sastha
Route::group(['prefix'=>'contractEmp','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'ContractEmpController@index');
	Route::any('contractemppopup', 'ContractEmpController@contractemppopup');
	Route::any('empselectprocess', 'ContractEmpController@empselectprocess');
	Route::any('history', 'ContractEmpController@history');
	Route::any('historyTotal', 'ContractEmpController@historyTotal');
	Route::any('view', 'ContractEmpController@view');
	Route::any('addedit', 'ContractEmpController@addedit');
	Route::any('edit', 'ContractEmpController@edit');
	Route::any('addeditprocess', 'ContractEmpController@addeditprocess');
	Route::any('getTransferedAmount', 'ContractEmpController@getTransferedAmount');
	Route::any('getdataExists', 'ContractEmpController@getdataExists');
	Route::any('dataReg', 'ContractEmpController@dataReg');
	Route::get('getlastmonthdet', 'ContractEmpController@getlastmonthdet');
	Route::any('mailsendprocess', 'ContractEmpController@mailsendprocess');
	// Download Process
	Route::any('transferdetailsdownload', 'ContractEmpController@transferdetailsdownload');
	Route::any('salaryplusdownload', 'ContractEmpController@salaryplusdownload');
	Route::any('salarypluspdfdownload', 'ContractEmpController@salarypluspdfdownload');
	Route::any('salarydownloadprocess', 'ContractEmpController@salarydownloadprocess');
	Route::any('salaryplusPayrollSingleDownload', 'ContractEmpController@salaryplusPayrollSingleDownload');
	Route::any('gensenDownload', 'ContractEmpController@gensenDownload');
});

// Salary Bank
Route::group(['prefix'=>'SalBank','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'SalBankController@index');
	Route::any('addressIndex', 'SalBankController@addressIndex');
	Route::any('familyIndex', 'SalBankController@familyIndex');
	Route::any('importpopup', 'SalBankController@importpopup');
	Route::any('importprocess', 'SalBankController@importprocess');
});

// Basic Calculation
Route::group(['prefix'=>'BasicCalc','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'BasicCalcController@index');
	Route::any('view', 'BasicCalcController@view');
	Route::any('addedit', 'BasicCalcController@addedit');
	Route::any('edit', 'BasicCalcController@edit');
	Route::any('addBasic', 'BasicCalcController@addBasic');
	Route::any('addeditprocess', 'BasicCalcController@addeditprocess');
	Route::get('update_mail', 'BasicCalcController@update_mail');
});

// Start Madasamy Code 22/05/20
Route::group(['prefix'=>'totalexp','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'TotalexpController@index');
	Route::any('travelExpense', 'TotalexpController@travelExpense');

});

Route::group(['prefix'=>'Expenses', 'middleware' => 'auth'], function()
{
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'ExpensesController@index');
	Route::any('regpopup', 'ExpensesController@regpopup');
	Route::any('addeditpd', 'ExpensesController@addeditpd');
	Route::any('view', 'ExpensesController@view');
	Route::any('history', 'ExpensesController@history');
	Route::any('addedit', 'ExpensesController@addedit');
	Route::any('Detedit', 'ExpensesController@Detedit');
	Route::any('edit', 'ExpensesController@edit');
	Route::any('getsubsubject', 'ExpensesController@getsubsubject');
	Route::any('checkmonth', 'ExpensesController@checkmonth');
	Route::any('formValidation', 'ExpensesController@formValidation');
	Route::any('addeditprocess', 'ExpensesController@addeditprocess');

});

Route::group(['prefix'=>'Travelexp', 'middleware' => 'auth'], function()
{
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'TravelexpController@index');
	Route::any('view', 'TravelexpController@view');
	Route::any('history', 'TravelexpController@history');
	Route::any('regpopup', 'TravelexpController@regpopup');
	Route::any('addeditpd', 'TravelexpController@addeditpd');
	Route::any('addedit', 'TravelexpController@addedit');
	Route::any('edit', 'TravelexpController@edit');
	Route::any('Detedit', 'TravelexpController@Detedit');
	Route::any('formValidation', 'TravelexpController@formValidation');
	Route::any('addeditprocess', 'TravelexpController@addeditprocess');
	Route::any('Download', 'TravelexpController@Download');
});

Route::group(['prefix'=>'insurance','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'InsuranceController@index');   
});

Route::group(['prefix'=>'Leavedtls','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'LeavedtlsController@index');

});

Route::group(['prefix'=>'Gensendtls','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'GensendtlsController@index');
	Route::any('view', 'GensendtlsController@view');
	Route::any('gensenDownload', 'GensendtlsController@gensenDownload');
	Route::any('salarydeductionpopup', 'GensendtlsController@salarydeductionpopup');
	Route::any('deductionselectprocess', 'GensendtlsController@deductionselectprocess');
	Route::any('gensenViewDwld', 'GensendtlsController@gensenViewDwld');
	Route::any('gensenindexDwld', 'GensendtlsController@gensenindexDwld');
});

Route::group(['prefix'=>'Visa', 'middleware' => 'auth'], function()
{
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'VisaController@index');
    Route::any('addedit', 'VisaController@addedit');
    Route::any('edit', 'VisaController@edit');
    Route::any('formValidation', 'VisaController@formValidation');
    Route::any('searchValidation', 'VisaController@searchValidation');
    Route::any('addeditprocess', 'VisaController@addeditprocess');
    Route::any('view', 'VisaController@view');
    Route::any('viewlist', 'VisaController@viewlist');
    Route::any('webcampopup', 'VisaController@webcampopup');
    Route::any('applydatepopup', 'VisaController@applydatepopup');
    Route::any('addeditpopup', 'VisaController@addeditpopup');
    Route::any('applydatepopupedit', 'VisaController@applydatepopupedit');
    Route::any('downloadexcel', 'VisaController@downloadexcel');
    Route::any('rotation', 'VisaController@rotation');
    Route::any('saveImage', 'VisaController@saveImage');

    Route::any('Download', 'VisaController@Download');
});

Route::group(['prefix'=>'Sales','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'SalesController@index');
    Route::any('addeditpopup', 'SalesController@addeditpopup');
    Route::any('addeditpopupEdit', 'SalesController@addeditpopupEdit');
    Route::any('addedit', 'SalesController@addedit');

});

Route::group(['prefix'=>'NewVisa','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'NewVisaController@index');
    Route::any('view', 'NewVisaController@view');
    Route::any('addeditpopup', 'NewVisaController@addeditpopup');

});

Route::group(['prefix'=>'FamilyVisa','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('familyView', 'FamilyVisaController@familyView');
    Route::any('singleView', 'FamilyVisaController@singleView');
    Route::any('addEdit', 'FamilyVisaController@addEdit');
    Route::any('addeditprocess', 'FamilyVisaController@addeditprocess');
    Route::any('getSubRelation', 'FamilyVisaController@getSubRelation');
    Route::any('getBasicDetails', 'FamilyVisaController@getBasicDetails');

});

Route::group(['prefix'=>'Family','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'FamilyController@index');
    Route::any('familyView', 'FamilyController@familyView');
    Route::any('getSubRelation', 'FamilyController@getSubRelation');
    Route::any('addEdit', 'FamilyController@addEdit');
    Route::any('addeditprocess', 'FamilyController@addeditprocess');
    Route::any('importpopup', 'FamilyController@importpopup');
	Route::any('importprocess', 'FamilyController@importprocess');

});

Route::group(['prefix'=>'Document','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'DocumentController@index');
    Route::any('addedit', 'DocumentController@addedit');
    Route::any('addeditprocess', 'DocumentController@addeditprocess');
    Route::any('fileDownloadProcess', 'DocumentController@fileDownloadProcess');
    Route::any('getPrevDocName', 'DocumentController@getPrevDocName');

});

Route::group(['prefix'=>'EsiMyNo','middleware' => 'auth'], function() {
    Route::get('changelanguage', 'AjaxController@index');
    Route::any('index', 'EsiMyNoController@index');
    Route::any('addEdit', 'EsiMyNoController@addEdit');
    Route::any('addeditprocess', 'EsiMyNoController@addeditprocess');

});


// End Madasamy Code 22/05/20

Route::group(['prefix'=>'contract','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'ContractController@index');
	Route::any('viewlist', 'ContractController@viewlist');
	Route::any('singleview', 'ContractController@singleview');
	Route::any('addedit', 'ContractController@addedit');
	Route::any('edit', 'ContractController@edit');
	Route::any('formValidation', 'ContractController@formValidation');
	Route::any('addeditprocess', 'ContractController@addeditprocess');
	Route::any('empcontractdownload', 'ContractController@empcontractdownload');
	Route::any('salarycertify', 'ContractController@salarycertify');
	Route::any('salarycertifyhistory', 'ContractController@salarycertifyhistory');
	Route::any('salarycertifydownload', 'ContractController@salarycertifydownload');
});

// Route::group(['prefix'=>'RequiredDocument','middleware' => 'auth'], function() {
//     Route::get('changelanguage', 'AjaxController@index');
//     Route::any('index', 'RequiredDocumentController@index');
//     Route::any('addedit', 'RequiredDocumentController@addedit');
//     Route::any('addeditprocess', 'RequiredDocumentController@addeditprocess');
//     Route::any('fileDownloadProcess', 'RequiredDocumentController@fileDownloadProcess');

// });
