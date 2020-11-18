@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/contract.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	$(document).ready(function() {
		setDatePicker("from_date");
		setDatePicker("to_date");
	});
</script>
<style type="text/css">
	b { 
		font-weight: bold;
	}
</style>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
<!-- article to select the main&sub menu -->
<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
	<div class="row hline">
		<div class="col-sm-8">
			<img class="pull-left box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
			<h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_contractview') }}</h2>
			<h2 class="pull-left mt15">・</h2> 
			@if(isset($detedit))
			<h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
			@else
			<h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
			@endif
		</div>
	</div>
	@if(isset($detedit))
		 {{ Form::model($detedit, array('name'=>'contractform','files'=>true, 'method' => 'POST','class'=>'form-horizontal','url' => 'contract/addeditprocess?time='.date('YmdHis') ) ) }}
		{{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
		{{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
	@else
		{{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 
						'class' => 'form-horizontal',
						'files'=>true,
						'url' => 'contract/addeditprocess?time='.date('YmdHis'), 
						'method' => 'POST')) }}
		{{ Form::hidden('confirm','1', array('id' => 'confirm')) }}
	@endif
	{{ csrf_field() }}
	{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
	{{ Form::hidden('contract_id', $request->contract_id , array('id' => 'contract_id')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('sortOptn',$request->banksort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder',$request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('filterview', $request->filterview, array('id' => 'filterview')) }}
	{{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
	{{ Form::hidden('Total', $request->Total, array('id' => 'Total')) }}
	{{ Form::hidden('totalWithcomma', $request->totalWithcomma, array('id' => 'totalWithcomma')) }}
	{{ Form::hidden('contractsort',$request->contractsort , array('id' => 'contractsort')) }}
	{{ Form::hidden('CoEndDate','' , array('id' => 'CoEndDate')) }}
	@if(Session::has('error'))
		<div class="alert-box success" style="text-align: center;color: red;">
			{{ Session::get('error') }}
		</div>
	@endif
	<div>
	<fieldset>
		<div class="form-group">
				<label for="Emp_ID" class="col-md-3 control-label clr_blue" style="padding-right:25px;">{{ trans('messages.lbl_employeno') }}</label>
			<div class="col-xs-9">
				<label for="Emp_ID" class="control-label fwb" style="color:{{ getEmpIDColor( $request->contractid ? $request->contractid : old('contractid') ) }}">
					{{ $request->contractid ? $request->contractid : old('contractid') }}
				</label>
			</div>
		</div>
		<div class="form-group">
				<label for="Emp_ID" class="col-md-3 control-label clr_blue" 
				style="padding-right:25px;">{{ trans('messages.lbl_empName') }}</label>
			<div class="col-xs-9">
				<label for="Emp_ID" class="control-label fwb" style="color:{{ getEmpIDColor( $request->empname ? $request->empname : old('empname') ) }}">
				{{ $request->empname ? $request->empname : old('empname') }}</label>
			</div>
		</div>
		<div class="form-group" style="border: 3px">
			<label for="emp_name" class="col-md-3 control-label clr_blue">
				{{ trans('messages.lbl_pow') }}<span class="fr ml2"> * </span></label>
			<div class="col-xs-9" >
				{{ Form::text('StartDate',null,array('id'=>'StartDate', 
										 'name' => 'StartDate',
										 'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
										 'class'=>'box12per pull-left form-control to_date dateField',
										 'data-label' => trans('messages.lbl_pow'),
										 'onChange'=>'javascript:setEnddate();',
										 'maxlength' => 10 )) }}
				<label class="mt10 ml4 fa fa-calendar fa-lg pull-left" 
					for="StartDate" aria-hidden="true"></label>
				<label class="mt5 ml4 pull-left mr5" >~</label>
				 	{{ Form::text('EndDate',null,array('id'=>'EndDate', 
											 'name' => 'EndDate',
											 'style'=>'ime-mode:disabled;background-color:#eee9e9;',
											 'class'=>'box12per pull-left form-control',
											 'disabled'=>'disabled',
											 'onfocus'=>'this.blur();')) }}
			</div>
		</div>
		<div class="form-group"> 
			<label for="Salary" class="col-md-3 control-label clr_blue">
				<span class="fr ml2">  </span>
			</label>
			<div class="col-xs-9" style="display: inline-block;padding-left: 25px;">
				@if(isset($detedit))
					{{ Form::checkbox('check',null, false,array('id'=>'check',
									  'name' => 'check',
									  'class' => 'check',
									  'onClick' => 'checkenable()',
									  'checked' => 'checked',
											'maxlength' => 7)) }}
					{{ Form::text('numyear',null,array(
							'id'=>'numyear',
							'name' => 'numyear',
							'class'=>'box10per form-control numyear',
							'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
							'onkeyup'=>'javascript:setEnddate();',
							'data-label' => trans('messages.lbl_NoofYears'),
							'maxlength' =>2)) }} 
				@else
					{{ Form::checkbox('check','', false,array('id'=>'check',
									  'name' => 'check',
									  'class' => 'check',
									  'onClick' => 'checkenable()',
											'maxlength' => 7)) }}
					{{ Form::text('numyear',null,array(
							'id'=>'numyear',
							'name' => 'numyear',
							'class'=>'box10per form-control numyear',
							'onkeypress'=>'return numberonly(event)',
							'onkeyup'=>'javascript:setEnddate();',
							'disabled'=>'disabled',
							'data-label' => trans('messages.lbl_NoofYears'),
							'maxlength' =>2)) }} 
				@endif
				<label class="mt10 ml4" aria-hidden="true">年</label>
			</div>
		</div>
		<div class="form-group"> 
			<label for="Salary" class="col-md-3 control-label clr_blue">
				{{ trans('messages.lbl_salary') }}<span class="fr ml2"> * </span>
			</label>
			<div class="col-xs-9">
				{{ Form::text('Salary',null,array(
							'id'=>'Salary',
							'name' => 'Salary',
							'class'=>'Salary box15per form-control salary',
							'onkeypress'=>'return numberonly(event)',
							'style'=>'text-align:right;',
							'maxlength' => 8,
							'data-label' => trans('messages.lbl_salary'),
							'onkeyup'=>'return fnMoneyFormatWithoutleadingzero(this.name, this.value,"jp")')) }}
				<label class="mt10 ml4" aria-hidden="true">円</label>
			</div>
		</div>
		<div class="form-group">
			<label for="TotalExpenses" id="TotalExpenses" class="col-md-3 control-label clr_blue">
				{{ trans('messages.lbl_travelex1') }}<span class="fr ml2"> * </span>
			</label>
			<div class="col-xs-9">
				{{ Form::text('Travel_Expense',null,array(
							'id'=>'Travel_Expense',
							'name' => 'Travel_Expense',
							'class'=>'Salary box15per form-control travel',
							'onkeypress'=>'return numberonly(event)', 'style'=>'text-align:right;',
							'data-label' => trans('messages.lbl_travelex1'),
							'maxlength' => 7,
							'onkeyup'=>'return fnMoneyFormatWithoutleadingzero(this.name, this.value,"jp")')) }}
				<label class="mt10 ml4" aria-hidden="true">円</label>
			</div>
		</div>
		<div class="form-group">
			<label for="Accommodation" class="col-md-3 control-label clr_blue">
				{{ trans('messages.lbl_acco') }}<span class="fr ml2"> * </span>
			</label>
			<div class="col-xs-9">
				{{ Form::text('Accommodation',null,array('id'=>'Accommodation', 
						'name' => 'Accommodation',
						'class'=>' number_format box15per form-control accommodation',
						'onkeypress'=>'return numberonly(event)','style'=>'text-align:right;',
						'data-label' => trans('messages.lbl_acco'),
						'maxlength' => 7,
						'onkeyup'=>'return fnMoneyFormatWithoutleadingzero(this.name, this.value,"jp")'))}}
				<label class="mt10 ml4" aria-hidden="true">円</label>
			</div>
		</div>
		<div class="form-group">
			<label for="Total" class="col-md-3 control-label clr_blue" style="padding-right:25px;">
				{{ trans('messages.lbl_ta') }}
			</label>
			<div class="col-xs-9" id="forinsert" style="display: visible">
			<span id="sum" title="moneyFormatIND($money)" readonly class="text-right box15per pr15" style="display: inline-block;font-weight: bold;font-size: 15px;">
			  <b>
				@if(isset($detedit))
					{{ $detedit->Total }}
				@else
					@if($request->Salary != "" || $request->Travel_Expense != "" || $request->Accommodation != "")
						{{ $request->totalWithcomma ? $request->totalWithcomma : old('totalWithcomma') }}
					@else
						{{ "0" }}
					@endif
				@endif
			  </b>
			</span>
				<label class="mt10 ml4" aria-hidden="true">円</label>
			</div>
			<div class="col-xs-9" id="forup" style="display: none;">
				<span id="sum" title="moneyFormatIND($money)" readonly class="text-right box18per pr15" style="display: inline-block;">
					{{ moneyFormatIND('$detedit->Total') }}</span>
				<label class="mt10 ml4" aria-hidden="true">円</label>
			</div>
		</div>
		<div class="form-group">
			<label for="Contract_date" class="col-md-3 control-label clr_blue">
				{{ trans('messages.lbl_dateofcontract') }}<span class="fr ml2"> * </span>
			</label>
			<div class="col-xs-9">
				{{ Form::text('Contract_date',null,array(
									'id'=>'Contract_date', 
									'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
									'name' => 'Contract_date',
									'class'=>'box12per pull-left form-control to_date contractdate',
									'data-label' => trans('messages.lbl_dateofcontract'),
									'maxlength' => 10)) }}
				<label class="mt10 ml4 fa fa-calendar fa-lg" for="Contract_date" aria-hidden="true"></label>
			</div>
		</div>
		<div class="form-group">
			<label for="remarks" class="col-md-3 control-label clr_blue" style="padding-right:25px;">
				{{ trans('messages.lbl_remarks') }}
			</label>
			<div class="col-xs-9">
				{{ Form::textarea('Remarks',null,array(
								'id'=>'Remarks', 
								'name' => 'Remarks',
								'class' => 'box65per form-control','size' => '60x5')) }}
			</div>
		</div>
	</fieldset>
	<fieldset style="background-color: #DDF1FA;">
		<div class="form-group">
			<div align="center" class="mt5">
				@if(isset($detedit))
				<button type="submit" class="btn edit btn-warning box100 addeditprocess">
					<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
				</button>
				<a href="javascript:cancel('singleview','{{$request->mainmenu}}');" class="btn add btn-danger box100"><span class="fa fa-remove"></span>&nbsp;{{ trans('messages.lbl_cancel') }} </a>
				@else
				<button type="submit" class="btn btn-success box100 addeditprocess">
					<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register') }} 
				</button>
				<a href="javascript:cancel('viewlist','{{$request->mainmenu}}');" class="btn btn-danger box100"><span class="fa fa-remove"></span>&nbsp;{{ trans('messages.lbl_cancel') }} </a>
				@endif
			</div>
		</div>
	</fieldset>
	</div>
{{ Form::close() }}
{{ Form::open(array('name'=>'contractformcancel', 'id'=>'contractformcancel', 
					'url' => 'contract/addeditprocess?time='.date('YmdHis'),
					'files'=>true,'method' => 'POST')) }}
{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
{{ Form::close() }}
<script type="text/javascript">
	//Script for Cancel Check//
	var cancel_check = true;
	$('input, select, textarea').bind("change keyup paste", function() {
		cancel_check = false;
	});
</script>
	</article>
</div>
@endsection