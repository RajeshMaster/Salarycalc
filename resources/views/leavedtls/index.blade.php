@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp

{{ HTML::script('resources/assets/js/leavedtls.js') }}

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
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_5">
		{{ Form::open(array('name'=>'leaveIndex', 'id'=>'leaveIndex', 'url' => 'Leavedtls/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,

		  'method' => 'POST')) }}


		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}

		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}

		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}

		{{ Form::hidden('sortOptn',$request->basicsort , array('id' => 'sortOptn')) }}
	 	
	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}

		{{ Form::hidden('Emp_ID', '' , array('id' => 'Emp_ID')) }}

		{{ Form::hidden('editcheck', '' , array('id' => 'editcheck')) }}

		{{ Form::hidden('firstname','' , array('id' => 'firstname')) }}

		{{ Form::hidden('lastname','' , array('id' => 'lastname')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('selYear', $selectedYear, array('id' => 'selYear')) }}
		{{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
		{{ Form::hidden('changeFlagValue', $request->changeFlagValue , array('id' => 'changeFlagValue')) }}
		{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
		{{ Form::hidden('flg', "" , array('id' => 'flg')) }}

		<div class="row hline pm0">

			<div class="col-xs-12">

				<img class="pull-left box35 mt15" src="{{ URL::asset('resources/assets/images/timesheet.jpg') }}">

				<h2 class="pull-left pl5 mt15 CMN_mw150">

						{{ trans('messages.lbl_leave_details') }}

				</h2>

				
			</div>

		</div>

		<div class="mt30 mb15">
          {{ Helpers::displayYear($prev_yrs,$cur_year,$total_yrs,$curtime) }}
        </div>

	<div class="box100per pr10 pl10 mt6">
		{{ Form::select('basicsort', $array, $request->basicsort,
		                            array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mt10 mb15',
		                           'id' => 'basicsort',
		                           'name' => 'basicsort'))
		                }}
	</div>

	<div class="pt10 minh340">

		<table class="tablealternate CMN_tblfixed">

			<colgroup>
				<col width="4%">
				<col width="6%">
				<col>
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
			</colgroup>

			<thead class="CMN_tbltheadcolor">

				<tr>

					<th class="vam">{{ trans('messages.lbl_sno') }}</th>

					<th class="vam">{{ trans('messages.lbl_empid') }}</th>

					<th class="vam">{{ trans('messages.lbl_name') }}</th>

					<th class="vam">{{ trans('messages.lbl_total') }}</th>

					<?php
		          		$month_array = array('1' => '1月',
		          								'2' => '2月',
		          								'3' => '3月',
		          								'4' => '4月',
		          								'5' => '5月',
		          								'6' => '6月',
		          								'7' => '7月',
		          								'8' => '8月',
		          								'9' => '9月',
		          								'10' => '10月',
		          								'11' => '11月',
		          								'12' => '12月',
		          							);
			          	foreach ($month_array as $value) {
							echo '<th class="vam">'.$value.'</th>';
			          	}
			         ?>

				</tr>

			</thead>

			<tbody>
				@if(count($get_emp_det)!="")

	 				@for ($i = 0; $i < count($get_emp_det); $i++)

						<tr>
							<td class="bor_rightbot_none text-center">
								{{ ($empdetails->currentpage()-1) * $empdetails->perpage() + $i + 1 }}
							</td>

							<td class="tac">
								<a href="javascript:;" style="color:blue;font-size: 13px;cursor: pointer;">{{ $get_emp_det[$i]['Emp_ID'] }}
								</a>
							</td>

							<td title="{{ empnameontitle($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],50) }}">
								{{ empnamelength($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],13) }}
							</td>

							@php 
								$leaveVal = explode(",",$get_emp_det[$i]['leave_cnt']);
								$Month = explode(",",$get_emp_det[$i]['Months']);

								$total = '';
								$leave = array();
								foreach ($leaveVal as $key => $value) {
									$leave[$Month[$key]] = $value;
									$total += $value;
								}

								if(isset($total) && $total != 0){
									echo '<td class="text-center" style="color: #d92027;font-weight: bold;">'.$total.'</td>';
								} else {
									echo '<td></td>';
								}

								for($k=1; $k<=12; $k++ ){
									if(isset($leave[$k]) && $leave[$k] != 0){
										echo '<td class="text-center">'.$leave[$k].'</td>';
									} else {
										echo '<td class="text-center"></td>';
									}
								}

							@endphp
							
						</tr>

					@endfor

				@else

						<tr>

							<td class="text-center colred" colspan="16">

								{{ trans('messages.lbl_nodatafound') }}

							</td>

						</tr>

				@endif

			</tbody>

		</table>

	</div>

	<div class="text-center">

		@if(!empty($empdetails->total()))

			<span class="pull-left mt20">

				{{ $empdetails->firstItem() }} ~ {{ $empdetails->lastItem() }} / {{ $empdetails->total() }}

			</span>


			{{ $empdetails->links() }}

			<div class="CMN_display_block flr mr10">

				{{ $empdetails->linkspagelimit() }}

			</div>	

		@endif 
	</div>

		{{ Form::close() }}

	</article>
</div>
@endsection