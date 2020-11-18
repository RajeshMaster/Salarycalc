@extends('layouts.app')
@section('content')
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/contract.js') }}
{{ HTML::script('resources/assets/js/hoe.js') }}
{{ HTML::style('resources/assets/css/hoe.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	function mulclick(divid){
		if($('#'+divid).css('display') == 'block'){
			document.getElementById(divid).style.display = 'none';
			document.getElementById(divid).style.height= "240px";
		} else {
			document.getElementById(divid).style.display = 'block';
		}
	}
</script>
<style type="text/css">
	.disabled {
		color: gray !important;
		cursor: not-allowed;
		pointer-events: none;
	}
	.fb{ color: gray !important; }
	.sort_asc {
		background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
	}
	.sort_desc {
		background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
	}
</style>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
<!-- article to select the main&sub menu -->
<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
	{{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 'url' => 'contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
	{{ csrf_field() }}
	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
	{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
	{{ Form::hidden('sortOptn',$request->contractsort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('userid',$request->userid, array('id' => 'userid')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	<div class="row hline">
		<div class="col-sm-8">
			<img class="pull-left box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
			<h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_contracdetails')}}</h2>
		</div>
	</div>
	<div class="box100per pr10 pl10 mt10">
		<div class="box100per pull-left">
			<div class="form-group mb10 pull-right moveleft nodropdownsymbol" id="moveleft">
				<a href="javascript:clearsearch();" title="Clear Search">
					<img class="pull-left box30 mr5" src="{{ URL::asset('resources/assets/images/clearsearch.png') }}">
				</a>
				{{ Form::select('contractsort', $sortarray,
								$request->contractsort,
								array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
								'id' => 'contractsort',
								'style' => $sortMargin,
								'name' => 'contractsort'))
				}}
			</div>
		</div>
		<div>
			<table class="tablealternate CMN_tblfixed">
				<colgroup>
					<col width="4%">
					<col width="7%">
					<col width="">
					<col width="10%">
					<col width="10%">
					<col width="8%">
					<col width="8%">
					<col width="8%">
					<col width="9%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<tr>
						<th rowspan="2" style="vertical-align: middle;" title="S.No">
							{{ trans('messages.lbl_sno') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Employee Id">
							{{ trans('messages.lbl_empid') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Employee Name">
							{{ trans('messages.lbl_name') }}
				 		</th>
						<th colspan="2" rowspan="1" style="border-bottom: none;" title="Period Of Work">
							{{ trans('messages.lbl_pow') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Salary">
							{{ trans('messages.lbl_salary') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Travel Expense">
							{{ trans('messages.lbl_travelexp') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Accommodation">
							{{ trans('messages.lbl_accom') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Total">
							{{ trans('messages.lbl_total') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Contract Date">
							{{ trans('messages.lbl_cd') }}
						</th>
						<th rowspan="2" style="vertical-align: middle;" title="Registered Date">
							{{ trans('messages.lbl_r_date') }}
						</th>
					</tr>
					<tr class="CMN_tbltheadcolor">
						<th title="Start Date">
							{{ trans('messages.lbl_Start_date') }}
						</th>
						<th title="End Date">
							{{ trans('messages.lbl_enddate') }}
						</th>
					</tr>
				</thead>
				<tbody>
					{{ $temp = ""}}
					{{--*/ $row = '0' /*--}}
					@forelse ($empArrVal as $count => $data)
						<!-- For Each Employee Contract -->
						@foreach($contractdata[$data->Emp_id] as $key => $value)
							@if(isset($value['Emp_id']))
								{{--*/ $loc = $value['Emp_id']  /*--}}
								@if($loc != $temp) 
									@if($row == 1)
										{{--*/ $style_tr = 'background-color: #e5f4f9;' /*--}}
										{{--*/ $row = '0' /*--}}
									@else
										{{--*/ $style_tr = 'background-color: #FFFFFF;' /*--}}
										{{--*/ $row = '1' /*--}}
									@endif
									{{--*/ $style_td = 'border-bottom: 1px solid lightgrey;' /*--}}
								@else
									{{--*/ $style_td = 'border-top: none;border-bottom: none;' /*--}}
								@endif
								<tr style="{{$style_tr}}">
									<td class="text-center"style="{{$style_td}}">
										{{($empArrVal->currentpage()-1) * $empArrVal->perpage() + $count + 1 }}
									</td>
									<td class="text-center" style="{{$style_td}}">
										@if($loc != $temp)
											<a style="color:#0000FF;" 
												href="javascript:list('{{ $data->Emp_id }}','{{ $request->mainmenu }}');">
												{{  $data->Emp_id }}
											</a>
										@endif
									</td>
									<td style="{{$style_td}}">
										@if($loc != $temp)
											{{ empnamelength($data->LastName, $data->FirstName,18) }}
										@endif
									</td>
									<td class="text-center">
										@if($value['StartDate'] != "")
											{{ date('Y', strtotime($value['StartDate'])) }}年{{ date('m', strtotime($value['StartDate'])) }}月{{ date('d', strtotime($value['StartDate'])) }}日
										@endif
									</td>
									<td class="text-center">
										@if($value['EndDate'] != "")
						  					{{ date('Y', strtotime($value['EndDate'])) }}年{{ date('m', strtotime($value['EndDate'])) }}月{{ date('d', strtotime($value['EndDate'])) }}日
										@endif
									</td>
									<td class="text-right" title="">
										@if (strpos($value['Salary'], ',') == false && $value['Salary'] != '')
											¥ {{ moneyFormatJAP($value['Salary']) }}
										@elseif($value['Salary'] != '') 
											¥ {{ $value['Salary'] }}
										@endif
									</td>
									<td class="text-right" title="">
										@if (strpos($value['Travel_Expense'], ',') == false && $value['Travel_Expense'] != '')
											¥ {{ moneyFormatJAP($value['Travel_Expense']) }}
										@elseif($value['Travel_Expense'] != '') 
											¥ {{ $value['Travel_Expense'] }}
										@endif
									</td>
									<td class="text-right" title="">
										@if (strpos($value['Accommodation'], ',') == false && $value['Accommodation'] != '')
											¥ {{ moneyFormatJAP($value['Accommodation']) }}
										@elseif($value['Accommodation'] != '') 
											¥ {{ $value['Accommodation'] }}
										@endif
									</td>
									<td class="text-right">
										@if (strpos($value['Total'], ',') == false && $value['Total'] != '')
											¥ {{ moneyFormatJAP($value['Total']) }}
										@elseif($value['Total'] != '') 
											¥ {{ $value['Total'] }}
										@endif
									</td>
									<td class="text-center">
										@if(isset($value['Contract_date']))
											{{ date('Y', strtotime($value['Contract_date'])) }}年{{ date('m', strtotime($value['Contract_date'])) }}月{{ date('d', strtotime($value['Contract_date'])) }}日
										@endif
									</td>
									<td class="text-center">
										@if(isset($value['Created_Date']))
											{{ date('Y', strtotime($value['Created_Date'])) }}年{{ date('m', strtotime($value['Created_Date'])) }}月{{ date('d', strtotime($value['Created_Date'])) }}日
										@endif
									</td>
								</tr>
								{{--*/ $temp = $loc /*--}}
							@else
								<tr>
									<td class="text-center">
										{{($empArrVal->currentpage()-1) * $empArrVal->perpage() + $count + 1 }}
									</td>
									<td class="text-center">
										<a style="color:#0000FF;" 
											href="javascript:list('{{ $data->Emp_id }}','{{ $request->mainmenu }}');">
											{{ $data->Emp_id }}
										</a>
									</td>
									<td>
										{{ empnamelength($data->LastName, $data->FirstName,18) }}
									</td>
									<td></td>
									<td ></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							@endif
						@endforeach
					@empty
						<tr>
							<td class="text-center fr" colspan="11">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr>
					@endforelse
				</tbody>  
			</table>
		</div>
	</div>
	<div class="text-center">
		@if(!empty($empArrVal->total()) && $empArrVal->total() != 0)
			<span class="pull-left mt24">{{ $empArrVal->firstItem() }} ~
				{{ $empArrVal->lastItem() }} / {{ $empArrVal->total() }}
			</span>
			{{ $empArrVal->links() }}
			<div class="CMN_display_block flr">
				{{ $empArrVal->linkspagelimit() }}
			</div>
		@endif 
	</div>
	<div @if ($request->singlesearch != "" || $request->searchmethod == 2) 
		class="open CMN_fixed mt120" 
		@else 
		class="CMN_fixed mt120" 
		@endif 
		id="styleSelector">
		<div class="selector-toggle" id="movesorting">
			<a href="javascript:void(0)" onclick="closepopover();"></a>
		</div>
		<ul>
			<li>
				<p class="selector-title">{{ trans('messages.lbl_contract_search') }}</p>
			</li>
			<li class="theme-option">
				<div class="box100per mt5 ml5" onKeyPress="return checkSubmitsingle(event)">
					{!! Form::text('singlesearch', trim($request->singlesearch),
						array('','class'=>'form-control ml2 box80per','style'=>'height:30px;','id'=>'singlesearch')) !!}
					{{ Form::button('<i class="fa fa-search" aria-hidden="true"></i> ', 
						array('class'=>'ml2 search box15per btn btn-info btn-sm', 
							'type'=>'button',
							'name' => 'advsearch',
							'id' => 'advsearch',
							'onclick'=> 'singlesearchclick();',
							'style'=>'border: none;' 
				)) }}
				</div>
			</li>
		</ul>
		<div class="mt5 ml12 pull-left mb5">
			<a onclick="mulclick('demo');" class="" style="font-family: arial, verdana;cursor: pointer;">{{ trans('messages.lbl_multi_search') }}</a>
		</div>
		<div>
			<ul id="demo" @if ($request->searchmethod == 2) class="collapse in ml5 pull-left" @else class="collapse ml5 pull-left"  @endif>
				<li class="theme-option" onKeyPress="return checkSubmitmulti(event)" style="display: block!important;">
					<span class="mt2">{{ trans('messages.lbl_empid') }}</span>
					<div class="mt5 box88per">
						{!! Form::text('msearchempid', trim($request->msearchempid),
							array('',
							'id' => 'msearchempid',
							'style'=>'height:30px;','class'=>'box100per 
						')) !!}
					</div>
					<div class="mt5">
						<span class="pt3">{{ trans('messages.lbl_empName') }}</span>
						<div class="mt5 box88per">
							{!! Form::text('msearchempname', trim($request->msearchempname),
								array('',
									'id' => 'msearchempname',
									'style'=>'height:30px;','class'=>'box100per 
							')) !!}
						</div>
					</div>
					<div class="mt5 mb6">
						{{ Form::button('<i class="fa fa-search" aria-hidden="true"></i> '.trans('messages.lbl_search'),
								array('id' => 'addeditsearch','name' => 'addeditsearch','class'=>'mt10 btn btn-info btn-sm',
								'onclick' => 'javascript:return multiplesearch()',
								'type'=>'submit')) 
						}}
					</div>
				</li>
			</ul>
		</div> 
	</div>
{{ Form::close() }}
</article>
</div>
@endsection
