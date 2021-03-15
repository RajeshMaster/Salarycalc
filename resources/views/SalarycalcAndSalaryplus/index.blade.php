@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script('resources/assets/js/SalarycalcAndSalaryplus.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';

</script>
<style type="text/css">
	
	.btn-gray {
 		 background-color: gray;
  		 border-color: white;
	}
	.btn-red {
		background-color: red;
	  	border-color: white;
	  	color: white;
	}
	.bg_lightgrey {
	    background-color:#D3D3D3    ! important;
	}
	
</style>

<div class="CMN_display_block" id="main_contents" style="width: 100%;">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_8">
		{{ Form::open(array('name'=>'SalarycalcAndSalaryplus',
							'id'=>'SalarycalcAndSalaryplus',
							'url'=>'salarEmp/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
							'files'=>true,
							'method' => 'POST' )) }}
			{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
			{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
			{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
			{{ Form::hidden('prevcnt', $request->prevcnt, array('id' => 'prevcnt')) }}
			{{ Form::hidden('nextcnt', $request->nextcnt, array('id' => 'nextcnt')) }}
			{{ Form::hidden('account_val', $account_val, array('id' => 'account_val')) }}
			{{ Form::hidden('previou_next_year', $request->previou_next_year, 
								array('id' => 'previou_next_year')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('get_prev_yr', '' , array('id' => 'get_prev_yr')) }}

		<!-- Start Heading -->
		<div class="row hline pm0">
			<div class="col-xs-12">
				<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
				<h2 class="pull-left pl5 mt10">
					{{ trans('messages.lbl_salarylist') }}
				</h2>
			</div>
		</div>
		<!-- End Heading -->

		<div class="box100per pr10 pl10 ">
			<div class="mt10 mb10">
				{{ Helpers::displayYear_MonthEst($account_period, $year_month, $db_year_month, $date_month, $dbnext, $dbprevious, $last_year, $current_year, $account_val) }}
			</div>
		</div>
	
	<div class="pt10 pl10 pr10 ">

		<div style="display: inline-block;width: 45%;"  class="mt10 mb10 ml10 mr10">
			SalaryCalc
			<table class="tablealternate mt10 mb10">
				<colgroup>
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="">
				</colgroup>

				<thead class="CMN_tbltheadcolor">
					<tr>
						<th class="vam">
							{{ trans('messages.lbl_sno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_yearmonth') }}</th>
						<th class="vam">
							{{ trans('messages.lbl_empno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_totamt') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_transferred') }}</th>
					</tr>
				<tbody>
					@php $i = 1; @endphp
					@foreach($salaryCalcArrVal AS $key => $value)
						<tr>
							<td>
								{{ $i }}
							</td>
							<td class="tac">
								{{ $value->year_mon }}
							</td>
							<td class="tac">
								{{ $value->Emp_ID }}
							</td>
							<td class="tac">
								@php 
									$totamount = $value->Basic + $value->hra + $value->train_daily + $value->others 
								@endphp
								{{ $totamount }}
							</td>
							<td class="tac">
								{{ $value->Transferred }}
							</td>
						</tr>
						@php $i++; @endphp
					@endforeach
					@if(count($salaryCalcArrVal) == 0)
					<td colspan="5">
						<div class="text-center fr">
							{{ trans('messages.lbl_nodatafound') }}
						</div>
					</td>
					@endif
				</tbody>
			</table>
		</div>

		<div style="display: inline-block;width: 45%;" class="mt10 mb10 ml10 mr10">
			SalaryCalcPlus
			<table class="tablealternate mt10 mb10">
				<colgroup>
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="">
				</colgroup>

				<thead class="CMN_tbltheadcolor">
					<tr>
						<th class="vam">
							{{ trans('messages.lbl_sno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_yearmonth') }}</th>
						<th class="vam">
							{{ trans('messages.lbl_empno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_amount') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_totamt') }}</th>
					</tr>
				<tbody>
					@php $i = 1; @endphp
					@foreach($empArrVal AS $key => $value)
						<tr>
							<td>
								{{ $i }}
							</td>
							<td class="tac">
								{{ $value->year_mon }}
							</td>
							<td class="tac">
								{{ $value->Emp_ID }}
							</td>
							<td class="tac">
								{{ Form::text('salAmt'.$i, 0,
									array('id'=>'salAmt'.$i,
										'name' => 'salAmt'.$i,
										'style'=>'text-align:right;padding-right:4px;',
										'autocomplete' =>'off',
										'class'=>'box96per ime_mode_disable ml7 numonly',
										'onblur' => 'return fnSetZero11(this.id);',
										'onfocus' => 'return fnRemoveZero(this.id);',
										'onclick' => 'return fnRemoveZero(this.id);',
										'onkeyup'=>'return fnMoneyFormat(this.id,"jp");',
										'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
										'data-label' => trans('messages.lbl_amount'))) 
								}}
							</td>
							<td class="tac">
								@php 
									$amount = $value->salamt + $value->Travel
								@endphp
								{{ $amount }}
							</td>
						</tr>
						@php $i++; @endphp
					@endforeach
					@if(count($empArrVal) == 0)
					<td colspan="5">
						<div class="text-center fr">
							{{ trans('messages.lbl_nodatafound') }}
						</div>
					</td>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>

	{{ Form::close() }}

	

	

	</article>
</div>
@endsection