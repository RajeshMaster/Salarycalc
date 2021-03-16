@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script('resources/assets/js/SalarycalcAndSalaryplus.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
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
			{{ Form::hidden('totVal', '' , array('id' => 'totVal')) }}

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
			Accounting
			<table class="tablealternate mt10 mb10">
				<colgroup>
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="">
					<col width="10%">
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
						<th class="vam"></th>
					</tr>
				<tbody>
					@php $i = 0; @endphp
					@foreach($salaryCalcArrVal AS $key => $value)
						<tr>
							<td>
								{{ $i+1 }}
							</td>
							<td class="tac">
								{{ $value->date }}
							</td>
							<td class="tac">
								{{ $value->emp_ID }}
							</td>
							<td class="tac">
								{{ $value->amount }}
							</td>
							<td class="tac">
								@php
									if(isset($empArr[$i]['id'])) {
										$id = $empArr[$i]['id'];
									} else {
										$id = "";
									}
								@endphp
								<input  type = "checkbox" 
										class = "empIdCheck" 
										name = "empIdCheck"
										id = "empIdCheck<?php echo $i; ?>" 
										value = "<?php echo $i; ?>"
										onclick = "employeeCheck('{{ $i }}','{{ $value->emp_ID }}','{{ $id }}')" >
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
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
				</colgroup>

				<thead class="CMN_tbltheadcolor">
					<tr>
						<th class="vam">
							{{ trans('messages.lbl_sno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_id') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_yearmonth') }}</th>
						<th class="vam">
							{{ trans('messages.lbl_empno') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_totamt') }}</th>
						<th class="vam" >
							{{ trans('messages.lbl_employeeid') }}</th>
					</tr>
				<tbody>
					@for ($j = 0; $j < count($empArr); $j++)
						<tr>
							<td>
								{{ $j+1 }}
							</td>
							<td class="tac">
								@if(isset($empArr[$j]['id']))
									{{ $empArr[$j]['id'] }}
								@endif
								{{ Form::hidden('salId'.$j, '' , 
									array('id' => 'salId'.$j)) }}
							</td>
							<td class="tac">
								@if(isset($empArr[$j]['date']))
									{{ $empArr[$j]['date'] }}
								@endif
							</td>
							<td class="tac">
								@if(isset($empArr[$j]['Emp_ID']))
									{{ $empArr[$j]['Emp_ID'] }}
								@endif
							</td>
							<td class="tac">
								@if(isset($empArr[$j]['id']))
									@if(isset($empArr[$j][$empArr[$j]['id']]['TotalAmt']))
										{{ $empArr[$j][$empArr[$j]['id']]['TotalAmt'] }}
									@endif
								@endif
							</td>
							<td class="tac">
								{{ Form::text('salempId'.$j, '',
									array('id'=>'salempId'.$j,
										'name' => 'salempId'.$j,
										'style'=>'text-align:right;padding-right:4px;',
										'autocomplete' =>'off',
										'class'=>'ime_mode_disable ml7',
										'data-label' => trans('messages.lbl_amount'))) 
								}}
							</td>
							
						</tr>
					@endfor
					@if(count($empArrVal) == 0)
					<td colspan="6">
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
	<div class = "vam tac">
		<a href="javascript:addeditemployee('{{ count($empArr) }}');"
			class="btn btn-warning">
			<i class="fa fa-edit mr5"></i>{{ trans('messages.lbl_update') }}
		</a>
	</div>

	

	</article>
</div>
@endsection