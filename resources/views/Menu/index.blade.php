@extends('layouts.menulayout')
@section('content')
@if (Session::get('setlanguageval') == 'en')
	{{ HTML::script('resources/assets/js/english.js') }}
@elseif(empty(Session::get('setlanguageval')))
	{{ HTML::script('resources/assets/js/japanese.js') }}
@else
	{{ HTML::script('resources/assets/js/japanese.js') }}
@endif
<script type="text/javascript">
	function changelanguage() {
		// var err_changelanguage = "言語を変更しますか？。";
		if ($('#langvalue').val() == "jp") {
			var err_lang = "Do You Want To Change The Language?.";
		} else {
			var err_lang = "言語を変更しますか？。";
		}
		// var confm = confirm("Do You Want To Change The Language?.");
		if (!confirm(err_lang)) {
			return false;
		}
		$.ajax({
			type:'GET',
			url:'changelanguage',
			data: {
				langvalue: $('#langvalue').val()
			},
			success:function(data){
				location.reload(true);
			},
			error: function (data) {
				// alert(data.status);
			}
		});
	}
</script>
<style type="text/css">
.image_b {
    width: 150px;
    height: 40px;
    background-color: #0b93b3;
    background-repeat: no-repeat;
    color: #ffffff;
    padding-top: 10px;
    font-size: 15px;
    text-align: center;

}
.div_inline {
    display: inline-block;
}
.alinkEng {
    background: url(../resources/assets/images/resultset_next.png) no-repeat left center;
    height: 16px;
    vertical-align: text-bottom;
    font-size: 12px;
    padding-left: 16px;
}
#for_stretch_align {
   	display: table;
   	margin: auto;
   	width: 1185px !important;
}
</style>
{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
<div class="" id="for_stretch_align">
<!-- article to select the main&sub menu -->
		<div class="col-xs-12">
			
			@if(Auth::user()->userclassification == 4)
			<div class="col-xs-3" style="padding-left: 125px;">
			@else
			<div class="col-xs-4" style="padding-left: 117px;">
			@endif
				<div class="image_b div_inline mb15 mr120">{{ trans('messages.lbl_salary') }}</div>
				@if(Auth::user()->userclassification == 4)
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('salarycalc/index?mainmenu=salarycalc&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_salary_calc') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('salarycalcplus/index?mainmenu=salarycalcplus&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_salary_calplus') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('contractEmp/index?mainmenu=contractEmp&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_conEmployee') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('BasicCalc/index?mainmenu=basic_calc&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_basic_cal') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('Leavedtls/index?mainmenu=leave&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_leave_details') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('Gensendtls/index?mainmenu=gensendtls&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_gensen') }}
					</a>
				</div>
				@endif
			</div>

			@if(Auth::user()->userclassification == 4)
			<div class="col-xs-3" style="padding-left: 100px;">
			@else
			<div class="col-xs-3" style="padding-left: 125px;">
			@endif
				<div class="image_b div_inline mb15">{{ trans('messages.lbl_expenses') }}</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('totalexp/index?mainmenu=TotalExpenses&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_expenses') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('insurance/index?mainmenu=insurance&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_insurence') }}
					</a>
				</div>
			</div>

			@if(Auth::user()->userclassification == 4)
			<div class="col-xs-3" style="padding-left: 88px;">
				<div class="image_b div_inline mb15">{{ trans('messages.lbl_staff') }}</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('Staff/index?mainmenu=staff&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_staff') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('NonStaff/index?mainmenu=nonstaff&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_nonstaff') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('SalBank/index?mainmenu=sal_bank&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_bank') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('SalBank/addressIndex?mainmenu=address&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_address') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('Family/index?mainmenu=family&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_family_details') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" 
					href="{{ url('EsiMyNo/index?mainmenu=esi_myno&time='.date('Ymdhis')) }}" 
					style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_esi_myno') }}
					</a>
				</div>
			</div>
			<div class="col-xs-3" style="padding-left: 53px;">
				<div class="image_b div_inline mb15">{{ trans('messages.lbl_visa') }}</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('Visa/index?mainmenu=visa&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_visa_extension') }}
					</a>
				</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('contract/index?mainmenu=contract&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_contract') }}
					</a>
				</div>

				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('Sales/index?mainmenu=sales&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_sale') }}
					</a>
				</div>

				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('NewVisa/index?mainmenu=newvisa&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_new_visa') }}
					</a>
				</div>

				<!-- <div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('RequiredDocument/index?mainmenu=RequiredDocument&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_required_document') }}
					</a>
				</div> -->

				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('Document/index?mainmenu=Document&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_document') }}
					</a>
				</div>
			</div>

			@endif
			
		</div>
		@if(Auth::user()->userclassification == 4)
		<div class="col-xs-12 mt40 ml0">
		@else
		<div class="col-xs-12 mt40" style="padding-left: 100px;">
		@endif
			<div class="col-xs-3" style="padding-left: 125px;">
				<div class="image_b div_inline mb15">{{ trans('messages.lbl_master') }}</div>
				<div class="alinkEng ml20 mt5">
					<a class="pageload csrp btn-link" href="{{ url('User/index?mainmenu=user&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
						{{ trans('messages.lbl_user') }}
					</a>
				</div>

			</div>

			<div class="col-xs-3" style="padding-left: 100px;">
				<div class="image_b div_inline mb15">{{ trans('messages.lbl_setting') }}</div>
					<div class="alinkEng ml20 mt5">
						<a class="pageload csrp btn-link" href="{{ url('Setting/index?mainmenu=Setting&time='.date('Ymdhis')) }}" style="color:blue;font-size: 13px;">
							{{ trans('messages.lbl_setting') }}
						</a>
					</div>
				<div class="alinkEng ml20 mt5">
					{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
				@if (Session::get('setlanguageval') == 'en')
					<a class="csrp btn-link" href="javascript:;" onclick="javascript:return changelanguage();" style="color:blue;font-size: 13px;">
					{{ trans('messages.lbl_english') }}
					</a>
				@elseif(empty(Session::get('setlanguageval')))
					<a class="csrp btn-link" href="javascript:;" onclick="javascript:return changelanguage();" style="color:blue;font-size: 13px;">
					{{ trans('messages.lbl_japanese') }}
					</a>
				@else
					<a class="csrp btn-link" href="javascript:;" 
					onclick="javascript:return changelanguage();" style="color:blue;font-size: 13px;">
					{{ trans('messages.lbl_japanese') }}
					</a>
				@endif
					
				</div>
			</div>
		</div>
</div>
@endsection