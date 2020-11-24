@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/salarycalc.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
	var dates = '<?php echo date('Y-m-10'); ?>';
	// Get Salary Date
	var date = new Date(dates);
	var saldate = '';
	switch(date.getDay()){
	    case 0: saldate = '<?php echo date('Y-m-08'); ?>'; break;
	    case 6: saldate = '<?php echo date('Y-m-09'); ?>'; break;
	    default: saldate = dates;
	    
	}
	// End Salary Date
	$(document).ready(function() {
		setDatePicker("saldate");
		//this calculates values automatically 
	    calculateSum();

	    $(".txt").on("keydown keyup", function() {
	        calculateSum();
	    });
	});
	function negativeamt(id,amt) {
		var amt = $('#'+id).val();
		amt = $('#'+id).val().replace(/[^0-9]/gi, '');
		//amt = Number(amt.trim().replace(/[, ]+/g, ""));
		if (amt == "") {
			$('#'+id).focus();  
			$('#'+id).val('-');
		} else {
			$('#'+id).focus(); 
			if (amt>0) {
				value1 = amt;
				tot = value1.toLocaleString();
				amount = "-"+tot;
				document.getElementById(""+id).value = amount;
			}
		}
	}
	function calculateSum() {
	    var sum = 0;
	    //iterate through each textboxes and add the values
	    $(".txt").each(function() {
	    	var remnum = Number(this.value.trim().replace(/[, ]+/g, ""));
	        //add only if the value is number
	        if (!isNaN(remnum) && this.value.length != 0) {
	            sum += parseFloat(remnum);
	            // $(this).css("background-color", "#FEFFB0");
	        }
	        else if (this.value.length != 0){
	            // $(this).css("background-color", "red");
	        }
	    });
	    var isNeg = sum < 0;
	    var amount = isNeg ? sum : Math.abs(sum.toFixed(0));
		var tot = amount.toLocaleString();
		var tott = tot;
		$("#totamt").text(tott);
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
	.modal {

      position: fixed;

      top: 50% !important;

      left: 50%;

      transform: translate(-50%, -50%);

   }
</style>
<div class="CMN_display_block" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_1">
		@if(isset($detedit))
		    {{ Form::model($detedit, ['name'=>'addeditsalarycalc', 
									'id'=>'addeditsalarycalc', 
									'url' => 'salarycalc/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
									'files' => true,
									'method' => 'POST']) }}
	    	{{ Form::hidden('datecheck',isset($detedit['date']) , array('id' => 'datecheck')) }}
		@else
			{{ Form::open(array('name'=>'addeditsalarycalc', 
						'id'=>'addeditsalarycalc', 
						'url' => 'salarycalc/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files' => true,
						'method' => 'POST')) }}
		@endif
	    		<input type="hidden" name="selMonth" id="selMonth" value="<?php echo $request->selMonth ?>">
	    		<input type="hidden" name="selYear" id="selYear" value="<?php echo $request->selYear ?>">
	    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
	    	@if(isset($emp_array['Emp_ID']))
	    		<input type="hidden" name="Emp_ID" id="Emp_ID" value="<?php echo $emp_array['Emp_ID'] ?>">
	    		<input type="hidden" name="firstname" id="firstname" value="<?php echo $emp_array['firstname'] ?>">
	    		<input type="hidden" name="lastname" id="lastname" value="<?php echo $emp_array['lastname'] ?>">
	    		<input type="hidden" name="stop_next" id="stop_next" value="<?php echo $emp_array['stop_next'] ?>">
	    	@else
	    		{{ Form::hidden('stop_next','' , array('id' => 'stop_next')) }}
	    		{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
				{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
				{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
	    	@endif
	    	@if(isset($stop_next) && $stop_next != '')
	    		<input type="hidden" name="stop_next_hdn" id="stop_next_hdn" value="<?php echo $stop_next ?>">
	    	@endif
	    	{{ Form::hidden('id',$request->id , array('id' => 'id')) }}
	    	{{ Form::hidden('prevcnt', $request->prevcnt, array('id' => 'prevcnt')) }}
			{{ Form::hidden('nextcnt', $request->nextcnt, array('id' => 'nextcnt')) }}
			{{ Form::hidden('account_val', $request->account_val, array('id' => 'account_val')) }}
			{{ Form::hidden('previou_next_year', $request->previou_next_year, 
								array('id' => 'previou_next_year')) }}
			{{ Form::hidden('editcheck', $request->editcheck, array('id' => 'editcheck')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('get_prev_yr', $request->get_prev_yr , array('id' => 'get_prev_yr')) }}
	    	<div class="row hline pm0">
				<div class="col-xs-12">
					<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
					<h2 class="pull-left pl5 mt10">
						{{ trans('messages.lbl_salary_calc') }}
					</h2>
					<h2 class="pull-left mt10">・</h2>
					<h2 class="pull-left mt10">
						@if($request->editcheck == 3)
							<span class="blue">
								{{ trans('messages.lbl_copy') }}
							</span>
						@elseif($request->editcheck == 1)
							<span class="red">
								{{ trans('messages.lbl_edit') }}
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
			<div class="col-xs-6">
				<fieldset class="col-xs-12 mt20 ml10" style="display: inline-block;">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_empdetails') }}</b></legend>
				<div class="col-xs-12 pm0 pull-right mb20 pl10 pr10 mt13 fwb">
			        {{ trans('messages.lbl_employeeid').':' }}
			          <span class="mr40 ml12" style="color:blue;">
			            {{ $request->Emp_ID }}
			          </span>
			            {{ trans('messages.lbl_empName').':' }}
			          <span style="color:#9C0000;margin-left: 10px">
			          	{{ empnamelength($request->lastname, $request->firstname,14) }}
			          </span>
			    </div>
				</fieldset>
				<fieldset class="col-xs-12 ml10">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_salary_det') }}</b></legend>
					<div class="col-xs-12" style="margin-top: 0px;">
						<div class="col-xs-12 mt5">
							<div class="col-xs-7 text-right clr_blue">
								<label>{{ trans('messages.lbl_basic') }}</label>
							</div>
							<div class="col-xs-5">
								@if(isset($detedit['Basic']) && $detedit['Basic'] != '')
									{{ $detedit['Basic'] }}
									{{ Form::hidden('Basic', $detedit['Basic'] , array('id' => 'Basic','class' => 'txt')) }}
								@elseif(isset($detedit_imp['Basic']) && $detedit_imp['Basic'] != '')
									<span id="span_Basic">{{ $detedit_imp['Basic'] }}</span>
									{{ Form::hidden('Basic', $detedit_imp['Basic'] , array('id' => 'Basic','class' => 'txt')) }}
								@else
									<span id="span_Basic">0</span>
									{{ Form::hidden('Basic', '' , array('id' => 'Basic','class' => 'txt')) }}
								@endif
							</div>
						</div>
						<div class="col-xs-12 mt5">
							<div class="col-xs-7 text-right clr_blue">
								<label title="House Rent Allowance">{{ trans('HRA') }}</label>
							</div>
							<div class="col-xs-5">
								@if(isset($detedit['hra']) && $detedit['hra'] != '')
									{{ $detedit['hra'] }}
									{{ Form::hidden('hra', $detedit['hra'] , array('id' => 'hra','class' => 'txt')) }}
								@elseif(isset($detedit_imp['hra']) && $detedit_imp['hra'] != '')
									<span id="span_hra">{{ $detedit_imp['hra'] }}</span>
									{{ Form::hidden('hra', $detedit_imp['hra'] , array('id' => 'hra','class' => 'txt')) }}
								@else
									<span id="span_hra">0</span>
									{{ Form::hidden('hra', '' , array('id' => 'hra','class' => 'txt')) }}
								@endif
							</div>
						</div>
				 		<div class="col-xs-12 mt5">
							<div class="col-xs-7 text-right clr_blue">
								<label>{{ trans('messages.lbl_train_daily') }}</label>
							</div>
							<div class="col-xs-5">
								@if(isset($detedit['train_daily']) && $detedit['train_daily'] != '')
									{{ $detedit['train_daily'] }}
									{{ Form::hidden('train_daily', $detedit['train_daily'] , array('id' => 'train_daily','class' => 'txt')) }}
								@elseif(isset($detedit_imp['train_daily']) && $detedit_imp['train_daily'] != '')
									<span id="span_train_daily">{{ $detedit_imp['train_daily'] }}</span>
									{{ Form::hidden('train_daily', $detedit_imp['train_daily'] , array('id' => 'train_daily','class' => 'txt')) }}
								@else
									<span id="span_train_daily">0</span>
									{{ Form::hidden('train_daily', '' , array('id' => 'train_daily','class' => 'txt')) }}
								@endif
							</div>
						</div>
						<div class="col-xs-12 mt5 mb10">
							<div class="col-xs-7 text-right clr_blue">
								<label>{{ trans('messages.lbl_Others') }}</label>
							</div>
							<div class="col-xs-5">
								@if(isset($detedit['others']) && $detedit['others'] != '')
									{{ $detedit['others'] }}
									{{ Form::hidden('others', $detedit['others'] , array('id' => 'others','class' => 'txt')) }}
								@elseif(isset($detedit_imp['others']) && $detedit_imp['others'] != '')
									<span id="span_others">{{ $detedit_imp['others'] }}</span>
									{{ Form::hidden('others', $detedit_imp['others'] , array('id' => 'others','class' => 'txt')) }}
								@else
									<span id="span_others">0</span>
									{{ Form::hidden('others', '' , array('id' => 'others','class' => 'txt')) }}
								@endif
							</div>
						</div>
						@if(count($salary_det)!="")
							@php($len = count($salary_det))
			 				@for ($m = 0; $m < count($salary_det); $m++)
			 					<div class="col-xs-12 mt5 @if($m == $len - 1) mb10 @endif">
									<div class="col-xs-7 text-right clr_blue">
										<label>{{ $salary_det[$m]->Name }}</label>
									</div>
									<div class="col-xs-5">
										{{ Form::text('salary_'.$salary_det[$m]->Salarayid,null,array('id'=>'salary_'.$salary_det[$m]->Salarayid,
												'name' => 'salary_'.$salary_det[$m]->Salarayid,
												'class'=>'txt Basic ime_mode_disable form-control box67per numonly',
												'maxlength' => '10',
												'style'=>'text-align:right;',
												'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
												'onkeyup'=>'fnMoneyFormat(this.id,"jp");',
												'onkeydown'=>'fnMoneyFormat(this.id,"jp");',
												'data-label' => $salary_det[$m]->Name)) }} 
									</div>
								</div>
			 				@endfor
				 		@endif
					</div>
				</fieldset>
			</div>
			<div style="float: right;" class="col-xs-6">
				<fieldset class="col-xs-12 mt20" style="display: inline-block;">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_saldate') }}</b></legend>
				<div class="col-xs-12 pm0 pull-right mb10 pl20 pr10 mt10 fwb">
			          <span class="" style="color:brown;">
			            {{ $request->selYear }}
			          </span>
			          <span class="mr40 ">{{ trans('messages.lbl_year') }}</span>
			        
			          <span class="mr40" style="margin-left: 10px">
			          	<?php
			          		$month_array = array(
			          								'' => '',
			          								'1' => '1月分',
			          								'2' => '2月分',
			          								'3' => '3月分',
			          								'4' => '4月分',
			          								'5' => '5月分',
			          								'6' => '6月分',
			          								'7' => '7月分',
			          								'8' => '8月分',
			          								'9' => '9月分',
			          								'10' => '10月分',
			          								'11' => '11月分',
			          								'12' => '12月分',
			          							);
			          	?>
			          	@if(isset($detedit))
							{{ Form::select('month', $month_array, null, array('id' => 'month',															'data-label' => trans('messages.lbl_monthnumb'))) }}
						@else
							{{ Form::select('month', $month_array, $request->selMonth, 
									array('id' => 'month',															'data-label' => trans('messages.lbl_monthnumb'))) }}
						@endif
			          </span>
			          {{ trans('messages.lbl_saldate') }}<span class="fr ml2">*</span>
			          <span class="mr40" style="margin-left: 10px">
			          		{{ Form::text('date',null,array('id'=>'date', 
																'name' => 'date',
																'data-label' => trans('messages.lbl_saldate'),
																'class'=>'box20per form-control pl5 saldate')) }}
						<label class="mt10 ml2 fa fa-calendar fa-lg" for="date" aria-hidden="true"></label>
						<a href="javascript:getdate();" class="anchorstyle">
						<img title="Set Salary Date" class="box15" src="{{ URL::asset('resources/assets/images/add_date.png') }}"></a>
			          </span>
			    </div>
				</fieldset>
				<fieldset class="col-xs-12">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_salary_ded') }}</b></legend>
					<div class="col-xs-12" style="margin-top: 0px;">
						@if(count($salary_ded)!="")
							@php($len1 = count($salary_ded))
			 				@for ($n = 0; $n < count($salary_ded); $n++)
			 					<div class="col-xs-12 mt5 @if($n == $len1 - 1) mb10 @endif">
									<div class="col-xs-5 text-right clr_blue">
										<label>{{ $salary_ded[$n]->Name }}</label>
									</div>
									<div class="col-xs-7">
										{{ Form::text('deduction_'.$salary_ded[$n]->Salarayid,null,array('id'=>'deduction_'.$salary_ded[$n]->Salarayid,
												'name' => 'deduction_'.$salary_ded[$n]->Salarayid,
												'style'=>'text-align:right;color:red;',
												'class'=>'txt ESI ime_mode_disable form-control box37per numonly',
												'maxlength' => '10',
												'onfocus' => 'return fnRemoveZero(this.id);',
												'onclick' => 'return fnRemoveZero(this.id);',
												'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
												'onkeyup'=>'return fnMoneyFormatNegative(this.id,"jp");negativeamt(this.id,this.value)',
												'data-label' => trans('messages.lbl_esi'))) }}
									</div>
								</div>
			 				@endfor
			 			@endif
					</div>
				</fieldset>
				<fieldset class="col-xs-12 mt20">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_transferred') }}</b></legend>
					<div class="col-xs-12" style="margin-top: 0px;">
						<div class="col-xs-12 mt10">
							<div class="col-xs-5 text-right clr_blue">
								<label>{{ trans('messages.lbl_totamt') }}</label><span class="fr ml2"></span>
							</div>
							<div class="col-xs-7">
								<span id="totamt" class="fwb clr_blue1" style="font-size: 120%">
								</span>
								<span class="fwb" style="font-size: 120%;">円</span>
							</div>
							</div>
							<div class="col-xs-12 mt10 mb10">
							<div class="col-xs-5 text-right clr_blue">
								<label>{{ trans('messages.lbl_transferred') }}</label>@if($request->editcheck != 2)<span class="fr ml2">*</span>@endif
							</div>
							<div class="col-xs-7">
								{{ Form::text('transferred',null,array('id'=>'transferred',
										'name' => 'transferred',
										'style'=>'text-align:right;',
										'class'=>'ime_mode_disable form-control box37per numonly',
										'maxlength' => '10',
										'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
										'onkeyup'=>'return fnMoneyFormat(this.id,"jp");',
										'data-label' => trans('messages.lbl_transferred'))) }}
								<a onclick="javascript:gotoamount();" class="btn btn-primary box140 white ml5" style="padding: 3px 3px;">{{trans('messages.lbl_get_tot_amount')}}
								</a>
							</div>
							</div>
					</div>
				</fieldset>
				<fieldset class="col-xs-12 mt20">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_leave') }}</b></legend>
					<div class="col-xs-12" style="margin-top: 0px;">
						<div class="col-xs-12 mt10 mb10">
							<div class="col-xs-5 text-right clr_blue">
								<label>{{ trans('messages.lbl_leave') }}</label>
							</div>
							<div class="col-xs-7">
								{{ Form::text('leave_cnt',null,array('id'=>'leave_cnt',
										'name' => 'leave_cnt',
										'class'=>'ime_mode_disable form-control box25per numonly',
										'maxlength' => '10',
										'onkeypress'=>'return event.charCode >=6 && event.charCode <=58')) }}
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset class="col-xs-12 mt20">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b>{{ trans('messages.lbl_remarks') }}</b></legend>
					<div class="col-xs-12" style="margin-top: 0px;">
						<div class="col-xs-12 mt10 mb10">
							<div class="col-xs-3 text-right clr_blue">
								<label>{{ trans('messages.lbl_remarks') }}</label><span class="fr ml2"></span>
							</div>
							<div class="col-xs-9">
								{{ Form::textarea('remarks',null,array('id'=>'remarks',
										'name' => 'remarks',
										'class' => 'box100per form-control',
										'size' => '30x4',
										'data-label' => trans('messages.lbl_remarks'))) }}
							</div>
						</div>
					</div>
				</fieldset>
			</div>
			<fieldset class="col-xs-12 mt1 ml25" style="background-color: #DDF1FA;width: 97% !important;">
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
						<a onclick="javascript:gotoindex('index','{{$request->mainmenu}}');" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
						</a>
						<!-- @if($request->editcheck == 0)
						<a onclick="javascript:getlastmonthdetails();" class="btn btn-primary box170 white"> {{trans('Get Last Month Details')}}
						</a>
						@endif -->
					</div>
				</div>
			</fieldset>
	    {{ Form::close() }}


	    <!-- History Section Start -->
		<div class="box100per mt10">

			<div class="col-xs-12">
				<h2 class="pull-left pl5 mt15">
					{{ trans('messages.lbl_salhistory') }}
				</h2>
			</div>

			@if(count($get_det)!="")
				<div class="minh400 box99per pl10 pr10 ml10 mb50 mt40 pt35">
					<div style="border: 1px solid white;overflow-x: auto;" id="sidebar">
						@php $count = 52; @endphp
						@if(count($salary_det1)!="")
			 				@for ($i = 0; $i < count($salary_det1); $i++)
			 					@if(isset($temp_salaryDetails[$salary_det1[$i]->Salarayid]) && $temp_salaryDetails[$salary_det1[$i]->Salarayid] != '0')
			 						@php $count += 13; @endphp
		 						@endif
			 				@endfor
		 				@endif
		 				@if(count($salary_ded1)!="")
			 				@for ($i = 0; $i < count($salary_ded1); $i++)
			 					@if(isset($temp_salaryDetails_DD[$salary_ded1[$i]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded1[$i]->Salarayid] != '0')
			 						@php $count += 13; @endphp
		 						@endif
			 				@endfor
		 				@endif
		 				@if($count<100)
		 				@endif

						<table class="tablealternate CMN_tblfixed" style="width: <?php echo $count; ?>% !important;">
							
							<thead class="CMN_tbltheadcolor">
								<tr>
									<th rowspan="2" class="vam" style="width: 5%;">{{ trans('messages.lbl_sno') }}</th>
									<th rowspan="2" class="vam">{{ trans('messages.lbl_date') }}</th>
									<th rowspan="2" class="vam">{{ trans('messages.lbl_paymentdate') }}</th>
									@php($sal_det_cnt = '')
									@if($tot_basic_amt != '')
				 						@php($sal_det_cnt += 1)
									@endif
									@if($tot_hra_amt != '')
				 						@php($sal_det_cnt += 1)
									@endif
				 					@if($tot_train_amt != '')
				 						@php($sal_det_cnt += 1)
									@endif
									@if($tot_exp_amt != '')
				 						@php($sal_det_cnt += 1)
									@endif
									@if(count($salary_det1)!="")
						 				@for ($i = 0; $i < count($salary_det1); $i++)
						 					@if(isset($temp_salaryDetails[$salary_det1[$i]->Salarayid]) && $temp_salaryDetails[$salary_det1[$i]->Salarayid] != '0')
				 								@php($sal_det_cnt += 1)
						 					@endif
						 				@endfor
						 			@endif
						 			@if($sal_det_cnt != '')
										<th rowspan="1" colspan="<?php echo $sal_det_cnt; ?>" class="vam">{{ trans('messages.lbl_salary_det') }}</th>
						 			@endif
						 			@php($sal_ded_cnt = '')
				 					@if(count($salary_ded1)!="")
						 				@for ($j = 0; $j < count($salary_ded1); $j++)
						 					@if(isset($temp_salaryDetails_DD[$salary_ded1[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded1[$j]->Salarayid] != '0')
				 								@php($sal_ded_cnt += 1)
						 					@endif
						 				@endfor
						 			@endif
				 					@if($sal_ded_cnt!="")
					 					<th rowspan="1" colspan="<?php echo $sal_ded_cnt; ?>" class="vam">{{ trans('messages.lbl_salary_ded') }}</th>
						 			@endif
									<th rowspan="2" class="vam">{{ trans('messages.lbl_totamt') }}</th>
									<th rowspan="2" class="vam">{{ trans('messages.lbl_transferred') }}</th>
								</tr>
								<tr>
									@if($tot_basic_amt != '')
					 				<th class="vam">
				 						{{ trans('messages.lbl_basic') }}
				 					</th>
				 					@endif
									@if($tot_hra_amt != '')
				 					<th class="vam">
				 						{{ trans('messages.lbl_HRA') }}
				 					</th>
				 					@endif
				 					@if($tot_train_amt != '')
				 					<th class="vam">
				 						{{ trans('messages.lbl_train_daily') }}
				 					</th>
				 					@endif
				 					@if($tot_exp_amt != '')
				 					<th class="vam">
				 						{{ trans('messages.lbl_Others') }}
				 					</th>
				 					@endif
									@if(count($salary_det1)!="")
						 				@for ($i = 0; $i < count($salary_det1); $i++)
						 					@if(isset($temp_salaryDetails[$salary_det1[$i]->Salarayid]) && $temp_salaryDetails[$salary_det1[$i]->Salarayid] != '0')
							 					<th class="vam">
							 						<label title="{{ (isset($salary_det1[$i]->nick_name) && $salary_det1[$i]->nick_name != '')?$salary_det1[$i]->Name:'' }}" style="margin-bottom: 0px !important;">{{ (isset($salary_det1[$i]->nick_name) && $salary_det1[$i]->nick_name != '')?$salary_det1[$i]->nick_name:$salary_det1[$i]->Name }}</label>
							 					</th>
					 						@endif
						 				@endfor
					 				@endif
					 				@if(count($salary_ded1)!="")
						 				@for ($j = 0; $j < count($salary_ded1); $j++)
						 					@if(isset($temp_salaryDetails_DD[$salary_ded1[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded1[$j]->Salarayid] != '0')
							 					<th class="vam">
							 						<label title="{{ (isset($salary_ded1[$j]->nick_name) && $salary_ded1[$j]->nick_name != '')?$salary_ded1[$j]->Name: ''}}" style="margin-bottom: 0px !important;">{{ (isset($salary_ded1[$j]->nick_name) && $salary_ded1[$j]->nick_name != '')?$salary_ded1[$j]->nick_name:$salary_ded1[$j]->Name }}</label>
							 					</th>
					 						@endif
						 				@endfor
					 				@endif
								</tr>
							</thead>

							<tbody>
							@if(count($get_det)!="")
					   		 @for ($i = 0; $i < count($get_det); $i++)
								<tr>
									<td class="text-center">
			                    		{{ $i + 1 }}
			                    	</td>
			                    	<td class="tac">
			                    			{{ $get_det[$i]['year'].'-'.date('m',mktime(0, 0, 0, $get_det[$i]['month'])) }} 
						   			</td>
						   			<td class="tac">
						   				{{ $get_det[$i]['date'] }} 
						   			</td>
			                    	<?php
			                    		$arr1 = array();
			                    		$arr2 = array();
			                    		$sal_arr = array();
			                    		$val1 = '';
			                    		if ($get_det[$i]['Salary'] != '') {
						 					$Salary = explode('##', mb_substr($get_det[$i]['Salary'], 0, -2));
						 					foreach ($Salary as $key => $value) {
						 						$sal_final = explode('$', $value);
					 							$arr1[$key] = $sal_final[0];
					 							$arr2[$sal_final[0]] = $sal_final[1];
						 					}
			                    		}
			                    		if(count($salary_det1) != "") {
				                    		foreach ($salary_det1 as $key1 => $value1) {
				                    			$sal_arr[$value1->Salarayid] = $value1->Salarayid;
				                    		}
			                    		}
			                    		$salresult_a=array_intersect($sal_arr,$arr1);
			                    		$salresult_b=array_diff($sal_arr,$arr1);
			                    		$salresult = array_merge($salresult_a,$salresult_b);
			                    		ksort($salresult);
						 			?>
						 			@if($tot_basic_amt != '')
						 			<td class="text-right pr10">
			                    		@php $val1 += $get_det[$i]['Basic'] @endphp
						 				{{ ($get_det[$i]['Basic'] != '') ? number_format($get_det[$i]['Basic']): '' }}
						 			</td>
						 			@endif
						 			@if($tot_hra_amt != '')
						 			<td class="text-right pr10">
			                    		@php $val1 += $get_det[$i]['hra'] @endphp
						 				{{ ($get_det[$i]['hra'] != '') ? number_format($get_det[$i]['hra']): '' }}
						 			</td>
						 			@endif
						 			@if($tot_train_amt != '')
						 			<td class="text-right pr10">
			                    		@php $val1 += $get_det[$i]['train_daily'] @endphp
						 				{{ ($get_det[$i]['train_daily'] != '') ? number_format($get_det[$i]['train_daily']): '' }}
						 			</td>
						 			@endif
						 			@if($tot_exp_amt != '')
						 			<td class="text-right pr10">
			                    		@php $val1 += $get_det[$i]['others'] @endphp
						 				{{ ($get_det[$i]['others'] != '') ? number_format($get_det[$i]['others']): '' }}
						 			</td>
						 			@endif
			                    	@if(count($salary_det1)!="")
						 				@foreach ($salresult as $key2 => $value2)
							 				@if(isset($temp_salaryDetails[$key2]) && $temp_salaryDetails[$key2] != '0')
				                    			@if($key2 == isset($arr2[$key2]))
				                    			@php $val1 += $arr2[$key2] @endphp
				                    				<td class="text-right pr10"> {{ ($arr2[$key2] != '') ? number_format($arr2[$key2]): '' }}</td>
				                    			@else
				                    				<td></td>
				                    			@endif
			                    			@endif
			                    		@endforeach
					 				@endif
					 				<?php
			                    		$arr3 = array();
			                    		$arr4 = array();
			                    		$ded_arr = array();
			                    		$val2 = '';
			                    		if ($get_det[$i]['Deduction'] != '') {
						 					$Deduction = explode('##', mb_substr($get_det[$i]['Deduction'], 0, -2));
						 					foreach ($Deduction as $key => $value1) {
						 						$ded_final = explode('$', $value1);
					 							$arr3[$key] = $ded_final[0];
					 							$arr4[$ded_final[0]] = $ded_final[1];
						 					}
			                    		}
			                    		if(count($salary_ded1) != "") {
				                    		foreach ($salary_ded1 as $key2 => $value2) {
				                    			$ded_arr[$value2->Salarayid] = $value2->Salarayid;
				                    		}
			                    		}
			                    		$dedresult_a=array_intersect($ded_arr,$arr3);
			                    		$dedresult_b=array_diff($ded_arr,$arr3);
			                    		$dedresult = array_merge($dedresult_a,$dedresult_b);
			                    		ksort($dedresult);
						 			?>
						 			@if(count($salary_ded1)!="")
						 				@foreach ($dedresult as $key2 => $value2)
						 					@if(isset($temp_salaryDetails_DD[$key2]) && $temp_salaryDetails_DD[$key2] != '0')
				                    			@if($key2 == isset($arr4[$key2]))
				                    			@php $val2 += $arr4[$key2] @endphp
				                    				<td class="text-right pr10" style="color: red;"> {{ ($arr4[$key2] != '') ? number_format($arr4[$key2]) : '' }}</td>
				                    			@else
				                    				<td></td>
				                    			@endif
			                    			@endif
			                    		@endforeach
		                			@else
		                				<td></td>
					 				@endif
									<td class="text-right pr10">
										<?php 
											$calc = '0';
											$calc = $val1 + $val2;
										 ?>
										@if($calc != 0)
											{{ number_format($calc) }}
										@endif
									</td>
									<td class="text-right pr10">
										@if($get_det[$i]['Transferred'] != '')
											{{ number_format($get_det[$i]['Transferred']) }}
										@endif
									</td>
		                    	</tr>
		                    	@endfor
		                    	@else
									<tr>
										@php($colspan = 6)
										@if(count($salary_det1) == 0 && count($salary_ded1) == 0)
											@php($colspan = 6)
										@elseif(count($salary_det1) != 0 && count($salary_ded1) == 0)
											@php($colspan = 5 + count($salary_det1))
										@elseif(count($salary_det1) == 0 && count($salary_ded1) != 0)
											@php($colspan = 5 + count($salary_ded1))
										@elseif(count($salary_det1) != 0 && count($salary_ded1) != 0)
											@php($colspan = 4 + count($salary_det1) + count($salary_ded1))
										@endif
										<td class="text-center fr" colspan="<?php echo $colspan; ?>">
										{{ trans('messages.lbl_nodatafound') }}</td>
									</tr>
								@endif
						</tbody>
					</table>
				</div>
			</div>
			@else

				<div class="col-xs-12 mb50">
					<div class="text-center fr">{{ trans('messages.lbl_nodatafound') }}</div>
				</div>

			@endif

		</div>

		<!-- History Section End -->

	
	    {{ Form::open(array('name'=>'salaryplusaddeditcancel', 'id'=>'salaryplusaddeditcancel', 'url' => 'salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }} 
			{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
			{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
	    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
	    	@if(isset($emp_array['Emp_ID']))
	    		<input type="hidden" name="Emp_ID" id="Emp_ID" value="<?php echo $emp_array['Emp_ID'] ?>">
	    		<input type="hidden" name="firstname" id="firstname" value="<?php echo $emp_array['firstname'] ?>">
	    		<input type="hidden" name="lastname" id="lastname" value="<?php echo $emp_array['lastname'] ?>">
	    	@else
	    		{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
				{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
				{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
	    	@endif
	    	@if(isset($stop_next) && $stop_next != '')
	    		<input type="hidden" name="stop_next_hdn" id="stop_next_hdn" value="<?php echo $stop_next ?>">
	    	@endif
	    	{{ Form::hidden('id',$request->id , array('id' => 'id')) }}
	    	{{ Form::hidden('prevcnt', $request->prevcnt, array('id' => 'prevcnt')) }}
			{{ Form::hidden('nextcnt', $request->nextcnt, array('id' => 'nextcnt')) }}
			{{ Form::hidden('account_val', $request->account_val, array('id' => 'account_val')) }}
			{{ Form::hidden('previou_next_year', $request->previou_next_year, 
								array('id' => 'previou_next_year')) }}
			{{ Form::hidden('editcheck', $request->editcheck, array('id' => 'editcheck')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('get_prev_yr', $request->get_prev_yr , array('id' => 'get_prev_yr')) }}
		{{ Form::close() }}
		<div id="salconfirmpopup" class="modal fade">
		<div id="login-overlay">
			<div class="modal-content">
				<!-- Popup will be loaded here -->
				<div class="modal-content">

				    <div class="modal-header" style="padding: 3px !important;">

				        <div class="col-md-12" style="padding-left: 15px;">

				          <h2 style="font-size:30px;" class="modal-title custom_align">{{ trans('Do You Want to Take Next Record?') }}</h2>

				        </div>

				    </div>
				    {{ Form::open(array('name'=>'hiddenform', 'id'=>'hiddenform', 

    'url' => 'salarycalc/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),

                      'method' => 'POST')) }}

		     		{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
					{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
			    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
			    	@if(isset($emp_array['Emp_ID']))
			    		<input type="hidden" name="Emp_ID" id="Emp_ID" value="<?php echo $emp_array['Emp_ID'] ?>">
			    		<input type="hidden" name="firstname" id="firstname" value="<?php echo $emp_array['firstname'] ?>">
			    		<input type="hidden" name="lastname" id="lastname" value="<?php echo $emp_array['lastname'] ?>">
			    	@else
			    		{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
						{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
						{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
			    	@endif
			    	@if(isset($stop_next) && $stop_next != '')
			    		<input type="hidden" name="stop_next_hdn" id="stop_next_hdn" value="<?php echo $stop_next ?>">
			    	@endif
			    	{{ Form::hidden('hdn_id',$request->id , array('id' => 'hdn_id')) }}
					{{ Form::hidden('next_record',''  , array('id' => 'next_record')) }}
					{{ Form::hidden('get_prev_yr', $request->get_prev_yr , array('id' => 'get_prev_yr')) }}
				    <div class="modal-body" style="padding: 1px !important;">
				    	<center class="mt10 mb10">

				          <button id="add"

				                  onclick="javascript:getnextrecordclick();"

				                  class="btn btn-success CMN_display_block box100">{{ trans('messages.lbl_next') }}

				          </button>

				          <button  

				          onclick="javascript:gotoviewpage();"

				           class="btn btn-danger CMN_display_block box100">{{ trans('messages.lbl_close') }}

				          </button>


				        </center>
				    </div>
				    {{ Form::close() }}
			    </div>
			</div>
		</div>
	</div>
	</article>
</div>
@endsection