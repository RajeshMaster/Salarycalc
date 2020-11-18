<?php

namespace App\Http\Common;

	class settingscommon {

		public static function getDbFieldsforProcess() {

			return array(

						/*'mstsalary'=>array('labels'=>

												array('heading'=>trans('messages.lbl_salary_det'),

												 	'field1lbl'=>trans('messages.lbl_salary_det')),

			    	  							 	'selectfields'=>array('id','Name','Ins_DT','delflg'),

		 										 	'displayfields'=>array('id','Name','Ins_DT',

		 										 							'delflg'),

		 										 	'insertfields'=>array('location','Name',

		 										 						'delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy','Salarayid'),

		 										 	'updatefields'=>array('Name','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('delflg'),

		 										 	'commitfields'=>array('Salarayid')),

						'mstsalaryplus'=>array('labels'=>

												array('heading'=>trans('messages.lbl_salary_det'),

												 	'field1lbl'=>trans('messages.lbl_salary_det')),

			    	  							 	'selectfields'=>array('id','Name','Ins_DT','delflg'),

		 										 	'displayfields'=>array('id','Name','Ins_DT',

		 										 							'delflg'),

		 										 	'insertfields'=>array('location','Name',

		 										 						'delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy','Salarayid'),

		 										 	'updatefields'=>array('Name','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('delflg'),

		 										 	'commitfields'=>array('Salarayid')),*/
						'salc_visa_document'=>array('labels'=>

											   array('heading'=>trans('messages.lbl_document_details'),

												 	// 'field1lbl'=>trans('messages.lbl_registered_date'),

												 	'field1lbl'=>trans('messages.lbl_document_name')),

			    	  							 	'selectfields'=>array('id','document_name','Ins_DT','delflg'),

		 										 	'displayfields'=>array('id','document_name','delflg'),

		 										 	'insertfields'=>array('document_name','delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy'),

		 										 	'updatefields'=>array('document_name','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('delflg'),

		 										 	'commitfields'=>array('id')),
						'mstsalary'=>array('labels'=>

											   array('heading'=>trans('messages.lbl_salary_det'),

												 	'field1lbl'=>trans('messages.lbl_salary_det'),

													'field2lbl'=>trans('messages.lbl_nickname')),

			    	  							 	'selectfields'=>array('id','Name',

			    	  							 		'nick_name','Ins_DT','delflg'),

		 										 	'displayfields'=>array('id','Name',

		 										 		'nick_name','delflg'),

		 										 	'insertfields'=>array('location','Name',

		 										 		'nick_name','delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy','Salarayid'),

		 										 	'updatefields'=>array('Name',

		 										 		'nick_name','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('delflg'),

		 										 	'commitfields'=>array('Salarayid')),
						'mstsalaryplus'=>array('labels'=>

											   array('heading'=>trans('messages.lbl_salary_det'),

												 	'field1lbl'=>trans('messages.lbl_salary_det'),

													'field2lbl'=>trans('messages.lbl_nickname')),

			    	  							 	'selectfields'=>array('id','Name',

			    	  							 		'nick_name','Ins_DT','delflg'),

		 										 	'displayfields'=>array('id','Name',

		 										 		'nick_name','delflg'),

		 										 	'insertfields'=>array('location','Name',

		 										 		'nick_name','delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy','Salarayid'),

		 										 	'updatefields'=>array('Name',

		 										 		'nick_name','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('delflg'),

		 										 	'commitfields'=>array('Salarayid')),
						'olddbdetailsregistration'=>array('labels'=>

												array('heading'=>trans('messages.lbl_database_reg'),

			    	 								'field1lbl'=>trans('messages.lbl_database_name'),

													'field2lbl'=>trans('messages.lbl_usernamesign'),

													'field3lbl'=>trans('messages.lbl_password')),

			    	  							 	'selectfields'=>array('id',

			    	  							 	'DBName','UserName','Password','Delflg',

			    	  							 	'Ins_DT'),

		 										 	'displayfields'=>array('id','DBName','UserName','Password','Delflg','Ins_DT'),

		 										 	'insertfields'=>array('DBName','UserName',

		 										 		'Password','Delflg','Ins_DT','Up_DT','CreatedBy','UpdatedBy'),

		 										 	'updatefields'=>array('DBName','UserName','Password','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('Delflg'),

		 										 	'commitfields'=>array('id'),

		 										 	'selectboxfields'=>array('id',

		 										 	'DBName')),
						'company_details'=>array('labels'=>

												array('heading'=>trans('messages.lbl_company_details'),

			    	 								'field1lbl'=>trans('messages.lbl_database_name'),

													'field2lbl'=>trans('messages.lbl_usernamesign'),

													'field8lbl'=>trans('messages.lbl_ceo')),

			    	  							 	'selectfields'=>array('id','companyNumber','companyName'

			    	  							 		,'companyBranch','capital','address','TEL','CEO','referencenumber'),

		 										 	'displayfields'=>array('id','companyNumber','companyName'
		 										 		,'companyBranch','capital','address','TEL','CEO','referencenumber','delflg'),

		 										 	'insertfields'=>array('companyNumber','companyName'
		 										 		,'companyBranch','capital','address','TEL','CEO','referencenumber','delflg'
		 										 		,'Ins_DT','Up_DT','CreatedBy','UpdatedBy'),

		 										 	'updatefields'=>array('companyNumber','companyName','companyBranch'
		 										 		,'capital','address','TEL'
		 										 		,'CEO','Up_DT','UpdatedBy'),

												 	'usenotusefields'=>array('Delflg'),

		 										 	'commitfields'=>array('id')),
			    );

		}

	}

?>