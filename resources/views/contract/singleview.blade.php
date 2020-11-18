@extends('layouts.app')
@section('content')

{{ HTML::script('resources/assets/js/contract.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
<!-- article to select the main&sub menu -->
	<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
		{{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 'url' => 'Contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
		{{ csrf_field() }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('contractsort',$request->contractsort , array('id' => 'contractsort')) }}
		{{ Form::hidden('sortOptn',$request->contractsort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
		{{ Form::hidden('contract_id', $request->contract_id , array('id' => 'contract_id')) }}
		{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
		{{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		<div class="row hline">
			<div class="col-sm-8">
				  <img class="pull-left box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
				  <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_contractview') }}</h2>
				<h2 class="pull-left mt15">・</h2> 
				<h2 class="pull-left mt15" style="color:blue;">{{ trans('messages.lbl_view') }}</h2>
			</div>
		</div>
		<div class="ml10 mt10">
			@if(Session::has('message'))
				<div align="center" class="alertboxalign">
					<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
						{{ Session::get('message') }}
					</p>
				</div>
			@endif
			<a href="javascript:gotoBack('viewlist','{{$request->mainmenu}}');"
				class="btn btn-info box80">
				<span class="fa fa-arrow-left"></span>&nbsp;
				{{ trans('messages.lbl_back') }}</a>
			<a onclick="javascript:fncontractedit('{{$request->contract_id}}','{{$request->mainmenu}}');" class="btn btn-warning box80">
				<span class="fa fa-edit"></span>&nbsp;
				{{ trans('messages.lbl_edit') }}</a>
			<a onclick="javascript:fncontractdownload('{{$request->mainmenu}}','{{$request->contract_id}}');" class="btn btn-success box165">
				<span class="fa fa-download"></span>&nbsp;
				{{ trans('messages.lbl_contract') }} {{ trans('messages.lbl_download') }}</a>
			<a  href="javascript:fnsalarycertify('{{$request->contract_id}}','{{$request->byindex}}');" class="btn btn-primary box165">
				<span class="fa fa-edit pr5"></span>
				{{ trans('messages.lbl_salarycertify') }}
			</a>
		</div>
		<div>
			@foreach($contractdetails as $key=>$user)
				<fieldset>
				<div class="col-md-7 ">
					<div class="col-md-12 mt10">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_empid') }}</label>
						</div>
						<div class="box100per fwb" style="color:{{ getEmpIDColor( $empdet[0]->Emp_ID ) }}">
							<span>
								{{ strtoupper( $empdet[0]->Emp_ID ) }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_firstName') }}</label>
						</div>
						<div class="box100per fwb" style="color:#9C0000">
							{{ strtoupper($empdet[0]->FirstName) }}
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_lastName') }}</label>
						</div>
						<div class="box100per fwb" style="color:#9C0000">
							{{ strtoupper($empdet[0]->LastName) }}
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_Start_date') }}</label>
						</div>
						<div>
							<span>
								{{ $user->StartDate }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_enddate') }}</label>
						</div>
						<div>
							<span>
								{{ $user->EndDate}}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_salary') }}</label>
						</div>
						<div class="text-left">
							<span title="{{ moneyFormatJAP($user->Salary) }}">
								¥ {{  moneyFormatJAP($user->Salary) }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_travelex1') }}</label>
						</div>
						<div class="text-left">
							<span title="{{ moneyFormatJAP($user->Travel_Expense) }}">
								¥ {{ moneyFormatJAP($user->Travel_Expense) }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_acco') }}</label>
						</div>
						<div class="text-left">
							<span title="{{ moneyFormatJAP($user->Accommodation) }}">
								¥ {{ moneyFormatJAP($user->Accommodation) }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_ta') }}</label>
						</div>
						<div>
							<span>
								@if (strpos($user->Total, ',') == false)
									¥ {{ moneyFormatJAP($user->Total) }}
								@else
									¥ {{ $user->Total }}
								@endif
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_cnd') }}</label>
						</div>
						<div>
							<span>
								{{ $user->Contract_date }}
							</span>
						</div>
					</div>
					<div class="col-md-12 mt5">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_remarks') }}</label>
						</div>
						<div class="col-md-5" style="padding-left: 0px">
							@if($user->Remarks!="")
								{!! nl2br(e($user->Remarks)) !!}
							@elseif($user->Remarks=="")
								NIL
							@endif 
						</div>
					</div>
					<div class="col-md-12 mt5 mb10">
						<div class="col-md-6 text-right clr_blue">
							<label>{{ trans('messages.lbl_registered_date') }}</label>
						</div>
						<div class="col-md-5" style="padding-left: 0px">
							@if($user->Created_Date != "")
								{{ substr($user->Created_Date,0,10) }}
							@elseif($user->Created_Date == "")
								NIL
							@endif 
						</div>
					</div>
				</div>
				</fieldset>
			@endforeach
		</div>
	{{ Form::close() }}
	</article>
</div>
@endsection