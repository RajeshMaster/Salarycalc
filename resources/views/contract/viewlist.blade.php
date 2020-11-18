@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/contract.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
<!-- article to select the main&sub menu -->
<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
	{{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 'url' => 'contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
	{{ csrf_field() }}
	{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
	{{ Form::hidden('contractsort',$request->contractsort , array('id' => 'contractsort')) }}
	{{ Form::hidden('sortOptn',$request->contractsort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
	{{ Form::hidden('contract_id', $request->contract_id , array('id' => 'contract_id')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('empname', empnamelength($empdet[0]->LastName, $empdet[0]->FirstName, 200) , array('id' => 'empname')) }}
	{{ Form::hidden('Gender', $request->Gender , array('id' => 'Gender')) }}
	<div class="row hline">
		<div class="col-sm-8">
			<img class="pull-left box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
			<h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_contracdetailss')}}
			</h2>
		</div>
	</div>
	<div class="box100per pr10 pl10 mt15">
		<div class="mt10">
			@if(Session::has('message'))
			  <div align="center" class="alertboxalign">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
					{{ Session::get('message') }}
				</p>
			  </div>
			@endif
			<a href="javascript:gotoBack1('index','{{$request->byindex}}');"
			  	class="btn btn-info box80"><span class="fa fa-arrow-left"></span>&nbsp;
			  	{{ trans('messages.lbl_back') }}</a>
			<a href="javascript:gotoRegister('addedit','{{$request->byindex}}');" 
				class="btn btn-success box100"><span class="fa fa-plus"></span>&nbsp;{{ trans('messages.lbl_add') }}</a>
		</div>
		<div class="fwb mt5">
			{{ trans('messages.lbl_empid').':' }}
			<span class="mr40" style="color:{{ getEmpIDColor( $empdet[0]->Emp_ID ) }}">
				{{ $empdet[0]->Emp_ID }} 
			</span>
			{{ trans('messages.lbl_empName').':' }}
			<span style="color:#9C0000">
				{{ empnamelength($empdet[0]->LastName, $empdet[0]->FirstName, 200) }}
			</span>
		</div>
		<table class="tablealternate CMN_tblfixed mt10">
			<colgroup>
				<col width="4%">
				<col width="12%">
				<col width="12%">
				<col width="7%">
				<col width="10%">
				<col width="10%">
				<col width="10%">
				<col width="">
				<col width="12%">
				<col width="12%">
			</colgroup>
			<thead class="CMN_tbltheadcolor">
				<tr>
					<th rowspan="2" style="vertical-align: middle;" title="S.No">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th colspan="2" rowspan="1" style="border-bottom: none;" title="Period Of Work">
						{{ trans('messages.lbl_pow') }}

					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Period Of Contract">
						{{ trans('messages.lbl_poc') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Salary Details">
						{{ trans('messages.lbl_salarydetails') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Travel Expenses">
						{{ trans('messages.lbl_travelex') }}
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
						{{ trans('messages.lbl_registered_date') }}
					</th>
				</tr>
				<tr class="CMN_tbltheadcolor">
					<th style="vertical-align: middle;" title="Start Date">
						{{ trans('messages.lbl_Start_date') }}
					</th>
					<th style="vertical-align: middle;" title="End Date">
						{{ trans('messages.lbl_enddate') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($contractdetails as $key => $data)
					{{ Form::hidden('Total', $data->Total , array('id' => 'Total')) }}
					{{ Form::hidden('Gender', $empdet[0]->Gender , array('id' => 'Gender')) }}
					<tr>
						<td class="text-center">
							{{ $key + 1 }}
						</td>
					 	<td class="text-center">
							<a href="javascript:gotoView1('{{ $data->contract_id }}','{{$request->byindex }}' ,1);">
								{{ date('Y', strtotime($data->StartDate)) }}年{{ date('m', strtotime($data->StartDate)) }}月{{ date('d', strtotime($data->StartDate)) }}日</a>
						</td>
						<td class="text-center">
							@if($data->EndDate!="")
								{{ date('Y', strtotime($data->EndDate)) }}年{{ date('m', strtotime($data->EndDate)) }}月{{ date('d', strtotime($data->EndDate)) }}日
							@endif
						</td>
						<td class="text-center">
							{{ date('Y',strtotime($data->EndDate)) - date('Y',strtotime($data->StartDate)) }}年
						</td>
						<td class="text-right" title="{{ moneyFormatJAP($data->Salary) }}">
							@if($data->Salary != '')
								¥ {{ moneyFormatJAP($data->Salary) }}
							@endif
						</td>
						<td class="text-right" title="{{ moneyFormatJAP($data->Travel_Expense) }}">
							@if($data->Travel_Expense != '')
								¥ {{ moneyFormatJAP($data->Travel_Expense) }}
							@endif
						</td>
						<td class="text-right" title="{{ moneyFormatJAP($data->Accommodation) }}">
							@if (strpos($data->Accommodation, ',') == false && $data->Accommodation != '')
								¥ {{ moneyFormatJAP($data->Accommodation) }}
							@elseif($data->Accommodation != '') 
								¥ {{ $data->Accommodation }}
							@endif
						</td>
						<td class="text-right" title="{{  moneyFormatJAP($data->Total) }}">
							@if (strpos($data->Total, ',') == false && $data->Total != '')
								¥ {{ moneyFormatJAP($data->Total) }}
							@elseif($data->Total != '') 
								¥ {{ $data->Total }}
							@endif
						</td>
						<td class="text-center">
							{{ date('Y', strtotime($data->Contract_date)) }}年{{ date('m', strtotime($data->Contract_date)) }}月{{ date('d', strtotime($data->Contract_date)) }}日
						</td>
						<td class="text-center">
							{{ date('Y', strtotime($data->Created_Date)) }}年{{ date('m', strtotime($data->Created_Date)) }}月{{ date('d', strtotime($data->Created_Date)) }}日
						</td>
					</tr>
				@empty
					<tr>
						<td class="text-center fr" colspan="10">
							{{ trans('messages.lbl_nodatafound') }}
						</td>
					</tr>
				@endforelse
			</tbody> 
		</table> 
	</div>
	{{ Form::close() }}
	@if($request->byindex=="2")
		{{ Form::open(array('name'=>'backtoview', 'id'=>'backtoview', 'url' => 'Employees/view?time='.date('YmdHis'),'method' => 'POST')) }}
	@else
		{{ Form::open(array('name'=>'backtoindex', 'id'=>'backtoindex', 'url' => 'Employees/index?time='.date('YmdHis'),'method' => 'POST')) }}
	@endif
	{{ csrf_field() }}
	{{ Form::hidden('mainmenu', 'employees_emp' , array('id' => 'mainmenu')) }}
	{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
	{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
	{{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('register', $request->register , array('id' => 'register')) }}
	{{ Form::hidden('employeesort', $request->employeesort , array('id' => 'employeesort')) }}
	{{ Form::hidden('defaultmainmenu', $request->defaultmainmenu , array('id' => 'defaultmainmenu')) }}
	{{ Form::close() }}
</article>
</div>
@endsection