@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/basiccalc.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var dates = '<?php echo date('Y-m-d'); ?>';
	$(document).ready(function() {
		setDatePicker("year_month_from");
		//this calculates values automatically 
	    calculateSum();

	    $(".txt").on("keydown keyup", function() {
	        calculateSum();
	    });
	});

	function getnewdate(date){
		$("#year_month_from").val(date);
	}

</script>
<style type="text/css">
	.clr_brown{
		 color: #9C0000 ! important;
	}
	.clr_blue1{
		 color: blue ! important;
	}
	.alertboxalign {
		margin-top: 5px !important;
		margin-bottom: -50px !important;
	}
	.alert {
		display:inline-block !important;
		height:30px !important;
		padding:5px !important;
	}
</style>

<div class="CMN_display_block" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_4">
		@if(isset($detedit))
		    {{ Form::model($detedit, ['name'=>'addeditbasiccalc', 
									'id'=>'addeditbasiccalc', 
									'url' => 'BasicCalc/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
									'files' => true,
									'method' => 'POST']) }}
		@else
			{{ Form::open(array('name'=>'addeditbasiccalc', 
						'id'=>'addeditbasiccalc', 
						'url' => 'BasicCalc/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files' => true,
						'method' => 'POST')) }}
		@endif
			{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
			{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
	    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
	    	{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
			{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
			{{ Form::hidden('editcheck',$request->editcheck , array('id' => 'editcheck')) }}
			{{ Form::hidden('id',null, array('id' => 'id')) }}
	    	<div class="row hline pm0">
				<div class="col-xs-12">
					<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
					<h2 class="pull-left pl5 mt10">
						{{ trans('messages.lbl_basic_cal') }}
					</h2>
					<h2 class="pull-left mt10">・</h2>
					<h2 class="pull-left mt10">
						@if($request->editcheck == 1)
							<span class="red">
								{{ trans('messages.lbl_update') }}
							</span>
						@else
							<span class="green">
								{{ trans('messages.lbl_register') }}
							</span>
						@endif
					</h2>
				</div>
			</div>
			<div id="errorSectiondisplay" align="center" class="box100per"></div>
			<div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
				<fieldset>
					<div class="col-xs-12 mt10">
						<div class="col-xs-3 text-right clr_blue">
							<label>{{ trans('messages.lbl_employeeid') }}</label>
						</div>
						<div class="col-xs-9"><label class="fwb" style="color:blue;">
							{{ $request->Emp_ID }}
						    {{ Form::hidden('Emp_ID',$request->Emp_ID, array('id' => 'Emp_ID')) }}
							</label>
						</div>
					</div>
					<div class="col-xs-12 mt10">
						<div class="col-xs-3 text-right clr_blue">
							<label>{{ trans('messages.lbl_empName') }}</label>
						</div>
						<div class="col-xs-9">
							<label class="clr_brown fwb">
								{{ strtoupper($request->lastname.' '.$request->firstname) }}
							</label>
						</div>
					</div>
					<div class="col-xs-12 mt10">
						<div class="col-xs-3 mt5 text-right clr_blue">
							<label>{{ trans('messages.lbl_basic_amount') }}<span class="fr ml2 red"> * </span></label>
						</div>
						<div class="col-xs-9">
							{{ Form::text('basic_amount',null,array(

										'id'=>'basic_amount',

										'name' => 'basic_amount',

										'maxlength' => '15',

										'style'=>'text-align:right;padding-right:4px;',

										'onkeypress' => 'return isNumberKey(event)',

										'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',

										'class'=>'box18per ime_mode_disable',

										'data-label' => trans('messages.lbl_basic_amount'))) }}
						</div>
					</div>
					<div class="col-xs-12 mt10">
						<div class="col-xs-3 mt5 text-right clr_blue">
							<label>{{ trans('messages.lbl_increment_amount') }}<span class="fr ml2 red"> * </span></label>
						</div>
						<div class="col-xs-9">
							{{ Form::text('increment_amount',null,array(

										'id'=>'increment_amount',

										'name' => 'increment_amount',

										'maxlength' => '15',

										'style'=>'text-align:right;padding-right:4px;',

										'onkeypress' => 'return isNumberKey(event)',

										'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',

										'class'=>'box18per ime_mode_disable',

										'data-label' => trans('messages.lbl_increment_amount'))) }}
						</div>
					</div>

					@if(isset($detedit) &&  $detedit['newStartDate'] != '')
						<div class="col-xs-12 mt15">
							<div class="col-xs-3 text-right clr_blue">
								<label>New Start Date</label>
							</div>

							<div class="col-xs-9">
								<label>{{ $detedit['newStartDate'] }}</label>
							</div>
						</div>
					@endif

					<div class="col-xs-12 mt10">
						<div class="col-xs-3 mt5 text-right clr_blue">
							<label>{{ trans('messages.lbl_from_date') }}<span class="fr ml2 red"> * </span></label>
						</div>
						<div class="col-xs-9">
							{{ Form::text('year_month_from',null,array(

										'id'=>'year_month_from',

										'name' => 'year_month_from',

										'class'=>'box12per year_month_from form-control',

										'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',

										'data-label' => trans('messages.lbl_from_date'),

										'maxlength' => '10')) }}
							<label class="fa fa-calendar fa-lg" for="year_month_from" aria-hidden="true"></label>
							@if(isset($detedit) &&  $detedit['newStartDate'] != '')
								<a href="javascript:getnewdate('{{ $detedit['newStartDate'] }}');" class="anchorstyle ml5">
									<img title="Set Salary Date" class="box15" src="{{ URL::asset('resources/assets/images/add_date.png') }}">
								</a>
							@endif
						</div>
					</div>

					<div class="col-xs-12 mt10 mb5">
						<div class="col-xs-3 mt5 text-right clr_blue">
							<label>{{ trans('messages.lbl_tot_month') }}<span class="fr ml2 red"> * </span></label>
						</div>
						<div class="col-xs-9">
							<?php $month_array = array('1' => '1',
			          							'2' => '2',
			          							'3' => '3',
			          							'4' => '4',
			          							'5' => '5',
			          							'6' => '6',
			          							'7' => '7',
			          							'8' => '8',
			          							'9' => '9',
			          							'10' => '10',
			          							'11' => '11',
			          							'12' => '12');
			          		?>

							{{ Form::select('totalmonth',array('' => '')+ $month_array,null,array(

										'id'=>'totalmonth',

										'name' => 'totalmonth',

										'class'=>'widthauto ime_mode_active',

										'maxlength' => 10,

										'data-label' => trans('messages.lbl_tot_month'))) }}
						</div>
					</div>

					<div class="col-xs-12 mt5 mb10">
						<div class="col-xs-3 mt5 text-right clr_blue">
							<label>{{ trans('messages.lbl_HRA') }}<span class="fr ml2 red"> * </span></label>
						</div>
						<div class="col-xs-9">
							{{ Form::text('hra',null,array(

										'id'=>'hra',

										'name' => 'hra',

										'maxlength' => '15',

										'style'=>'text-align:right;padding-right:4px;',

										'onkeypress' => 'return isNumberKey(event)',

										'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',

										'class'=>'box18per ime_mode_disable',

										'data-label' => trans('messages.lbl_HRA'))) }}
						</div>
					</div>


				</fieldset>
			</div>
			<div class="col-xs-12 pl5 pr5">
				<fieldset style="background-color: #DDF1FA;">
					<div class="form-group">
						<div align="center" class="mt5">
							@if($request->editcheck == 1)
								<button type="submit" class="btn btn-warning add box100 addeditprocess ml5">
									<i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
								</button>
							@else
								<button type="submit" class="btn btn-success add box100 addeditprocess ml5">
									<i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
								</button>
							@endif
							<a href="javascript:basicCalcRegCancel('{{ $request->mainmenu }}','{{ $request->editcheck }}');" class="btn btn-danger box100 white">
								<i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
							</a>

						</div>
					</div>
				</fieldset>
			</div>
	    {{ Form::close() }}

	    {{ Form::open(array('name'=>'addeditCancel', 
						'id'=>'addeditCancel', 
						'url' => 'BasicCalc/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files' => true,
						'method' => 'POST')) }}
			{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
			{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
	    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
	    	{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
			{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
			{{ Form::hidden('editcheck',$request->editcheck , array('id' => 'editcheck')) }}
			{{ Form::hidden('id',null, array('id' => 'id')) }}
		{{ Form::close() }}

	</article>
</div>
@endsection