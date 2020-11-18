@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/basiccalc.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
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
		{{ Form::open(array('name'=>'basicCalcView', 
						'id'=>'basicCalcView', 
						'url' => 'BasicCalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files' => true,
						'method' => 'POST')) }}
	    	{{ Form::hidden('mainmenu',$request->mainmenu, array('id' => 'mainmenu')) }}
	    	{{ Form::hidden('Emp_ID',$request->Emp_ID , array('id' => 'Emp_ID')) }}
			{{ Form::hidden('editcheck', $request->editcheck, array('id' => 'editcheck')) }}
			{{ Form::hidden('firstname',$request->firstname , array('id' => 'firstname')) }}
			{{ Form::hidden('lastname',$request->lastname , array('id' => 'lastname')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}

	    	<div class="row hline pm0">
				<div class="col-xs-12">
					<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
					<h2 class="pull-left pl5 mt10">
						{{ trans('messages.lbl_basic_cal') }}
					</h2>
					<h2 class="pull-left mt10">・</h2>
					<h2 class="pull-left mt10">
						<span class="blue">
							{{ trans('messages.lbl_view') }}
						</span>
					</h2>
				</div>
			</div>

			<div class="col-xs-12 pm0">
				<!-- Session msg -->
				@if(Session::has('success'))
					<div align="center" class="alertboxalign" role="alert">
						<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
							{{ Session::get('success') }}
						</p>
					</div>
				@endif
				@php Session::forget('success'); @endphp
				<!-- Session msg -->
			</div>

			<div class="col-xs-12 mt10">
				<a href="javascript:gotoindexBasicCalc('{{ $request->mainmenu }}');" class="btn btn-info box80">
					<span class="fa fa-arrow-left"></span>&nbsp;{{ trans('messages.lbl_back') }}
				</a>
				<a href="javascript:fngotoedit('{{ $request->mainmenu }}');" class="btn btn-warning box100 ml10">
					<i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
				</a>
				<a href="javascript:fngotoAdd('{{ $request->mainmenu }}');" class="btn btn-success box80 ml10">
					<span class="fa fa-plus"></span>&nbsp;{{ trans('messages.lbl_add') }}
				</a>

				<div class="col-xs-6 mt10 pull-right">
					<div class="col-xs-2 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_salary') }} {{ trans('messages.lbl_mail') }}</label>
					</div>
					<div class="col-xs-3">
						{{ Form::checkbox('mailneed', 1, (isset($detedit->mail_need)) ? $detedit->mail_need : 1, ['id' => 'mailneed']) }}
								&nbsp;<label for="mailneed"><span class="grey fb">{{ trans('messages.lbl_notneed') }}</span></label>
					</div>
				</div>
			</div>


			<div class="col-xs-12 pm0 pull-right mb20 pl5 pr10 mt20 fwb">
	        	{{ trans('messages.lbl_employeeid').':' }}
	          <span class="mr40 ml12" style="color:blue;">
	            {{ $request->Emp_ID }}
	            {{ Form::hidden('Emp_ID',$request->Emp_ID, array('id' => 'Emp_ID')) }}
	          </span>
	            {{ trans('messages.lbl_empName').':' }}
	          <span class="mr40 ml12" style="color:#9C0000;margin-left: 10px">
	         	 {{ empnamelength($request->lastname, $request->firstname,25) }}
	          </span>
	    	</div>

	    @if(count($data_history)!="")
		
		    <div class="pt10 pl5 minh400" style="width: 80%;">
		    	<div>
					<table class="tablealternate CMN_tblfixed mt10 ">
						<colgroup>
							<col width="5%">
							<col width="12%">
							<col width="12%">
							<col width="12%">
							<col width="10%">
							<col width="12%">
							<col width="15%">
							<col width="10%">
						</colgroup>
						<thead class="CMN_tbltheadcolor">
							<tr>
								<th class="vam text-center">{{ trans('messages.lbl_sno') }}</th>
								<th class="vam text-center">{{ trans('messages.lbl_registerdate') }}</th>
								<th class="vam text-center">{{ trans('messages.lbl_date') }} ( {{ trans('messages.lbl_from') }} ) </th>
								<th class="vam text-center">{{ trans('messages.lbl_date') }} ( {{ trans('messages.lbl_to') }} ) </th>
								<th class="vam text-center">{{ trans('messages.lbl_period') }}</th>
								<th class="vam text-center">{{ trans('messages.lbl_basic_amount') }}</th>
								<th class="vam text-center">{{ trans('messages.lbl_increment_amount') }}</th>
								<th class="vam text-center">{{ trans('messages.lbl_HRA') }}</th>
							</tr>
						</thead>
					</table>
				</div>

				<style>
					.scrolldesign { height: 280px !important; }
				</style>
				<div class="scrolldesign">
					<table class="tablealternate CMN_tblfixed">
						<colgroup>
							<col width="5%">
							<col width="12%">
							<col width="12%">
							<col width="12%">
							<col width="10%">
							<col width="12%">
							<col width="15%">
							<col width="10%">
						</colgroup>
						<tbody style="height: 10px !important; overflow: auto; ">
		    				@for ($i = 0; $i < count($data_history); $i++)
			    				<tr @if ($i==0)
					       				style="color: #d92027;" 
					       			@endif>
									<td class="bor_rightbot_none text-center">{{ $i + 1 }} </td>

									<td class="bor_rightbot_none text-center">{{ substr($data_history[$i]->CreatedDateTime,0,10) }} </td>

									<td class="bor_rightbot_none text-center">{{ $data_history[$i]->year_month_from }} </td>

									<td class="bor_rightbot_none text-center">{{ $data_history[$i]->year_month_to }} </td>

									<td class="bor_rightbot_none text-center">{{ $data_history[$i]->total_month }} </td>
									
									<td class="bor_rightbot_none text-right">{{ number_format($data_history[$i]->basic_amount) }} </td>

									<td class="bor_rightbot_none text-right">{{ number_format($data_history[$i]->increment_amount) }} </td>

									<td class="bor_rightbot_none text-right">{{ number_format($data_history[$i]->hra) }} </td>

								</tr>
							@endfor
						</tbody>
				</table>
			</div>
		@endif

	    {{ Form::close() }}


	</article>
</div>
@endsection