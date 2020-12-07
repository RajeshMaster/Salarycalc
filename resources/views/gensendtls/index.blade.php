@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script('resources/assets/js/gensendtls.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>
<style>
	.yrBorder{
		height: 22px !important;
	}
	.sort_asc {
		background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
	}
	.sort_desc {
		background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
	}
</style>
<div class="CMN_display_block" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_6">
		{{ Form::open(array('name'=>'gensenIndex', 'id'=>'gensenIndex', 
			'url' => 'Gensendtls/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,
		  	'method' => 'POST')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('sortOptn',$request->basicsort , array('id' => 'sortOptn')) }}
	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('Emp_ID', '' , array('id' => 'Emp_ID')) }}
		{{ Form::hidden('selYear', $selectedYear, array('id' => 'selYear')) }}
		{{ Form::hidden('flg', "" , array('id' => 'flg')) }}

		<div class="row hline pm0">
			<div class="col-xs-12">
				<img class="pull-left box35 mt15" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
				<h2 class="pull-left pl5 mt15 CMN_mw150">
					{{ trans('messages.lbl_gensen_details') }}
				</h2>
			</div>
		</div>

		<div class="mt30 mb15">
          {{ Helpers::displayYear($prev_yrs,$cur_year,$total_yrs,$curtime) }}
        </div>

        <!-- Session msg -->
		@if(Session::has('success'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
					{{ Session::get('success') }}
				</p>
			</div>
		@endif
		<!-- Session msg -->
		
		<div class="box100per pr10 pl10 mt6">
			<a class="pull-left" href="javascript:salarydeduction();">
				<img class="box19 mt10" src="{{ URL::asset('resources/assets/images/edit.png') }}"></a>
				<a href="javascript:salarydeduction();" class="pull-left ml5 anchorstyle mt5" title="{{ trans('messages.lbl_salary_ded') }}">
				{{ trans('messages.lbl_salary_ded') }}
			</a>
			{{ Form::select('basicsort', $array, $request->basicsort,
						array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mb15',
								'id' => 'basicsort',
								'name' => 'basicsort'))
			}}
			<a onclick="javascript:fndwldgensen(1);"
				class="btn btn-success box110 pull-right mr10">
				<span class="fa fa-file-excel-o"></span>&emsp;{{ trans('messages.lbl_gensen') }}
			</a>
			
		</div>

		<div class="pt10 minh340">
		<table class="tablealternate CMN_tblfixed">
			<colgroup>
				<col width="7%">
				<col width="13%">
				<col width="50%">
				<col width="10%">
				<col width="10%">
				<col width="10%">
			</colgroup>
			<thead class="CMN_tbltheadcolor">
				<tr>
					<th class="vam">{{ trans('messages.lbl_sno') }}</th>
					<th class="vam">{{ trans('messages.lbl_empid') }}</th>
					<th class="vam">{{ trans('messages.lbl_name') }}</th>
					<th class="vam">{{ trans('messages.lbl_totpay_amt') }}</th>
					<th class="vam">{{ trans('messages.lbl_totded_amt') }}</th>
					<th class="vam">{{ trans('messages.lbl_insurence') }}</th>
				</tr>
			</thead>
			<tbody>
				@if(count($get_emp_det) != 0)
	 			@for ($i = 0; $i < count($get_emp_det); $i++)
					<tr>
						<td class="bor_rightbot_none text-center">
							{{ ($gensenDtls->currentpage()-1) * $gensenDtls->perpage() + $i + 1 }}
						</td>
						<td class="tac">
							<a href="javascript:staffview('{{ $get_emp_det[$i]['Emp_ID'] }}');" style="color:blue;font-size: 13px;cursor: pointer;">
									{{ $get_emp_det[$i]['Emp_ID'] }}
							</a>
						</td>
						<td title="{{ empnameontitle($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],50) }}">
							{{ empnamelength($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],13) }}
						</td>
						@php
							$tot1 = 0;
							if(count($salary_det) != 0) { 
								for ($j = 0; $j < count($salary_det); $j++) {
									if(isset($temp_salaryDetails[$salary_det[$j]->Salarayid][$get_emp_det[$i]['Emp_ID']]) && $temp_salaryDetails[$salary_det[$j]->Salarayid][$get_emp_det[$i]['Emp_ID']] != '0'){
										$tot1 += $temp_salaryDetails[$salary_det[$j]->Salarayid][$get_emp_det[$i]['Emp_ID']];
									}
								}
							}
							if(isset($tot1)){
								echo '<td class="tar" style="color: #d92027;font-weight: bold;">'.number_format($tot1).'</td>';
							} else {
								echo '<td></td>';
							}
						@endphp
						@php
							$tot2 = 0;
							if(count($salary_ded) != 0) { 
								for ($k = 0; $k < count($salary_ded); $k++) {
									if(isset($temp_salaryDetails_DD[$salary_ded[$k]->Salarayid][$get_emp_det[$i]['Emp_ID']]) && $temp_salaryDetails_DD[$salary_ded[$k]->Salarayid][$get_emp_det[$i]['Emp_ID']] != '0'){
										$tot2 += $temp_salaryDetails_DD[$salary_ded[$k]->Salarayid][$get_emp_det[$i]['Emp_ID']];
									}
								}
							}
							if(isset($tot2)){
								$tot2 = preg_replace("/[^0-9]/", "", $tot2);
								echo '<td class="tar" style="color: #d92027;font-weight: bold;">'.number_format($tot2).'</td>';
							} else {
								echo '<td></td>';
							}
						@endphp
						@php 
							$total = 0;
							$Amount = array();
							if(isset($get_emp_det[$i]['Amounts'])) { 
							if(strlen($get_emp_det[$i]['Amounts'] > 2)){
								$AmountVal = explode(",",$get_emp_det[$i]['Amounts']);
								$Month = explode(",",$get_emp_det[$i]['Months']);
								foreach ($AmountVal as $key => $value) {
									if (array_key_exists($Month[$key], $Amount)) {
										$Amount[$Month[$key]] += $value;
									} else {
										$Amount[$Month[$key]] = $value;
									}
									$total += $value;
								}
							}
							}
							if(isset($total)){
								echo '<td class="tar" style="color: #d92027;font-weight: bold;">'.number_format($total).'</td>';
							} else {
								echo '<td></td>';
							}
						@endphp
					</tr>
				@endfor
				@else
					<tr>
						<td class="text-center colred" colspan="6">
							{{ trans('messages.lbl_nodatafound') }}
						</td>
					</tr>
				@endif
			</tbody>
		</table>
		</div>
		<div class="text-center">
			@if(!empty($gensenDtls->total()))
				<span class="pull-left mt20">
					{{ $gensenDtls->firstItem() }} ~ {{ $gensenDtls->lastItem() }} / {{ $gensenDtls->total() }}
				</span>
				{{ $gensenDtls->links() }}
				<div class="CMN_display_block flr mr10">
					{{ $gensenDtls->linkspagelimit() }}
				</div>	
			@endif 
		</div>
		{{ Form::close() }}
	</article>
</div>
<div id="salarydeductionpopup" class="modal fade">
	<div id="login-overlay">
		<div class="modal-content">
			<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection