@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/basiccalc.js') }}

{{ HTML::style('resources/assets/css/sidebar-bootstrap.min.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
</script>
<style type="text/css">

	.alertboxalign {
    	margin-bottom: -50px !important;
	}

	.alert {
	    display:inline-block !important;
	    height:30px !important;
	    padding:5px !important;
	}

	.fb{
		color: gray !important;
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

<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_4">

	{{ Form::open(array('name'=>'salbasicindex', 'id'=>'salbasicindex', 'url' => 'BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,

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

		{{ Form::hidden('increment_amount', 0 , array('id' => 'increment_amount')) }}

		<div class="row hline pm0">

			<div class="col-xs-12">

				<img class="pull-left box35 mt15" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">

				<h2 class="pull-left pl5 mt15 CMN_mw150">

						{{ trans('messages.lbl_basic_cal') }}

				</h2>

				
			</div>

		</div>

	<div class="box100per pr10 pl10 mt6">
		{{ Form::select('basicsort', $array, $request->basicsort,
		                            array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mt10 mb15',
		                           'id' => 'basicsort',
		                           'style' => $sortMargin,
		                           'name' => 'basicsort'))
		                }}

	<div class="pt10 minh400">

		<table class="tablealternate CMN_tblfixed">

			<colgroup>
				<col width="4%">
				<col width="10%">
				<col>
				<col width="10%">
				<col width="10%">
				<col width="8%">
				<col width="10%">
				<col width="10%">
				<col width="10%">
			</colgroup>

			<thead class="CMN_tbltheadcolor">

				<tr>

					<th class="vam">{{ trans('messages.lbl_sno') }}</th>

					<th class="vam">{{ trans('messages.lbl_empid') }}</th>

					<th class="vam">{{ trans('messages.lbl_name') }}</th>

					<th class="vam">{{ trans('messages.lbl_date') }} ( {{ trans('messages.lbl_from') }} )</th>

					<th class="vam">{{ trans('messages.lbl_date') }} ( {{ trans('messages.lbl_to') }} )</th>

					<th class="vam" title="{{ trans('messages.lbl_remainmonths') }}">{{ trans('messages.lbl_remainmonth') }}</th>

					<th class="vam">{{ trans('messages.lbl_cur_basic_amount') }}</th>

					<th class="vam">{{ trans('messages.lbl_increment') }}</th>
					
					<th class="vam">{{ trans('messages.lbl_HRA') }}</th>

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
								<a href="javascript:gotoaddedit('{{ $get_emp_det[$i]['Emp_ID'] }}','{{ $get_emp_det[$i]['editcheck'] }}','{{ $get_emp_det[$i]['FirstName'] }}','{{ $get_emp_det[$i]['LastName'] }}');" style="color:blue;font-size: 13px;cursor: pointer;">{{ $get_emp_det[$i]['Emp_ID'] }}
								</a>
							</td>

							<td title="{{ empnameontitle($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],50) }}">
								{{ empnamelength($get_emp_det[$i]['LastName'], $get_emp_det[$i]['FirstName'],20) }}
							</td>

							<td class="text-center">
								{{ $get_emp_det[$i]['year_month_from'] }}
							</td>

							<td class="text-center">
								{{ $get_emp_det[$i]['year_month_to'] }}
							</td>

							<td class="text-center">
								@if($get_emp_det[$i]['year_month_to'] != "")
									@php 
										$date1 = strtotime(date('Y-m-d'));
										$date2 = strtotime($get_emp_det[$i]['year_month_to']);
											$year1 = date('Y', $date1);
											$year2 = date('Y', $date2);
											$month1 = date('m', $date1);
											$month2 = date('m', $date2);
										$monthdiff = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
									@endphp

									@if($monthdiff < 0)
										<span style="color: red;">
									@else
										<span>
									@endif
										{{ $monthdiff }}
									</span>
									
								@endif									
							</td>							

							<td class="text-right">
								@if($get_emp_det[$i]['basicAmount'] > 0)
									{{ number_format($get_emp_det[$i]['basicAmount']) }}
								@endif
							</td>

							<td class="text-right">
								@if($get_emp_det[$i]['incAmount'] >= 0 && $get_emp_det[$i]['incAmount'] != "")
									{{ number_format($get_emp_det[$i]['incAmount']) }}
								@endif
							</td>

							<td class="text-right">
								@if($get_emp_det[$i]['hra'] > 0)
									{{ number_format($get_emp_det[$i]['hra']) }}
								@endif
							</td>

						</tr>

					@endfor

				@else

						<tr>

							<td class="text-center colred" colspan="7">

								{{ trans('messages.lbl_nodatafound') }}

							</td>

						</tr>

				@endif

			</tbody>

		</table>

	</div>

	<div class="text-center">

		@if(!empty($empdetails->total()))

			<span class="pull-left mt10">

				{{ $empdetails->firstItem() }} ~ {{ $empdetails->lastItem() }} / {{ $empdetails->total() }}

			</span>

		@endif 

		{{ $empdetails->links() }}

		<div class="CMN_display_block flr mr10">

			{{ $empdetails->linkspagelimit() }}

		</div>	

	</div>

		{{ Form::close() }}

</article>

</div>

@endsection