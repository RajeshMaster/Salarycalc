@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/contract.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
<!-- article to select the main&sub menu -->
<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
	{{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 
						'class' => 'form-horizontal',
						'files'=>true,
						'url' => 'contract/salarycertifydownload?time='.date('YmdHis'), 
						'method' => 'POST')) }}
	{{ csrf_field() }}
	{{ Form::hidden('contractsort',$request->contractsort , array('id' => 'contractsort')) }}
	{{ Form::hidden('sortOptn',$request->contractsort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
	{{ Form::hidden('contract_id', $request->contract_id , array('id' => 'contract_id')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
	{{ Form::hidden('Total', $request->Total , array('id' => 'Total')) }}
	{{ Form::hidden('Gender', $request->Gender , array('id' => 'Gender')) }}
	{{ Form::hidden('doj', $request->doj , array('id' => 'doj')) }}
	{{ Form::hidden('reason', $request->reason , array('id' => 'reason')) }}
	{{ Form::hidden('flgchk', '1' , array('id' => 'flgchk')) }}
	{{ Form::hidden('salCertification_id', '' , array('id' => 'salCertification_id')) }}
	<div class="row hline">
		<div class="col-sm-8">
			<img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
			<h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_salarycertifyhistory')}}</h2>
		</div>
	</div>
	<!-- Session msg -->
	@if(Session::has('message'))
		<div align="center" class="mt10 alertboxalign">
			<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('message') }}
			</p>
		</div>
	@endif
	<!-- Session msg -->
	<div class="box100per pr10 pl10 mt10">
		<div class="mt10">
			<a href="javascript:gotoBack2('salarycertify','{{$request->mainmenu}}');"
				class="btn btn-info box80"><span class="fa fa-arrow-left"></span>
				{{ trans('messages.lbl_back') }}</a>
		</div>
		<div class="fwb mt5">
			{{ trans('messages.lbl_empid').':' }}
			<span class="mr40" style="color:{{ getEmpIDColor( $request->contractid ) }}">
				{{ $request->contractid }} 
			</span>
			{{ trans('messages.lbl_name').':' }}
			<span style="color:#9C0000">
				{{ $request->empname }}
			</span>
		</div>
		<table class="tablealternate CMN_tblfixed mt5">
			<colgroup>
				<col width="5%">
				<col width="15%">
				<col width="">
				<col width="14%">
				<col width="10%">
			</colgroup>
			<thead class="CMN_tbltheadcolor">
				<tr>
					<th rowspan="2" style="vertical-align: middle;" title="S.No">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Date/Time">
						{{ trans('messages.lbl_datetime') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Reason">
						{{ trans('messages.lbl_reason') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Created By">
						{{ trans('messages.lbl_createdby') }}
					</th>
					<th rowspan="2" style="vertical-align: middle;" title="Download">
						{{ trans('messages.lbl_download') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($certifyhistory as $key => $data)
					<tr>
						<td class="text-center">
							{{	$key + 1 }}
						</td>
						<td title="{{ $data->Ins_Dt}}">
							{{ $data->Ins_Dt}}
						</td>
						<td title="{{ $data->reason }}">
							{{ $data->reason }}
						</td>
						<td title="{{ $data->createdby }}">
							{{ $data->createdby }}
						</td>
						<td align="center">
							<a href="javascript:fnhistory('{{$data->id}}', '{{$data->contract_id}}', '{{$data->reason}}');" class="fa fa-download td_n"></a>
						</td>

					</tr>

				@empty
					<tr>
						<td class="text-center fr" colspan="5">
							{{ trans('messages.lbl_nodatafound') }}
						</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>
	{{ Form::close() }}
</article>
</div>
@endsection