<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ Session::get('systemname') }}</title>
		{{ HTML::style('resources/assets/css/menu.css') }}
		{{ HTML::style('resources/assets/css/common.css') }}
		{{ HTML::style('resources/assets/css/font-awesome.min.css') }}
		{{ HTML::style('resources/assets/css/decoration.css') }}
		{{ HTML::style('resources/assets/css/minheight.css') }}
		{{ HTML::style('resources/assets/css/widthbox.css') }}
		{{ HTML::style('resources/assets/css/paddingmargin.css') }}
		{{ HTML::style('resources/assets/css/bootstrap.min.css') }}
		{{ HTML::style('resources/assets/css/AdminLTE.css') }}
		{{ HTML::style('resources/assets/css/_all-skins.min.css') }}

		{{ HTML::script('resources/assets/js/jquery.min.js') }}
		{{ HTML::script('resources/assets/js/bootstrap.min.js') }}
		{{ HTML::script('resources/assets/js/jquery.plugin.js') }}
		{{ HTML::script('resources/assets/js/common.js') }}
		{{ HTML::script('resources/assets/js/jquery.form-validator.min.js') }}
		@if (Session::get('languageval') == 'en')
			{{ HTML::script('resources/assets/js/english.js') }}
		@elseif(empty(Session::get('languageval')))
			{{ HTML::script('resources/assets/js/japanese.js') }}
		@else
			{{ HTML::script('resources/assets/js/japanese.js') }}
		@endif
		{{ HTML::script('resources/assets/js/render.js') }}
</head>
<style type="text/css">
	.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url({{ URL::asset('resources/assets/images/loading.gif') }}) center no-repeat;
		background-size: 10%;
		background-color: rgba(255, 255, 255, .5);
	}
	.shadowforimage {
		box-shadow: 5px 5px 2px #888888;
	}
	html {
		height: 40% !important;
   		display: table;
   		margin: auto;
   		padding: 0px;
	}
	body {
		display: table-cell;
   		margin: auto;
   		overflow-y: scroll !important;
	}
</style>
<body class="check CMN_cursor_wait response" style="width: 1185px;min-height: 200px !important ;border: 1px solid white;max-width: 1350px !important">
	<div id="fixeddiv" class="CMN_menu_stretch" style="background-color: #F0F0F0 !important;">
	<div class="se-pre-con" id="se-pre-con"></div>
		<div class="CMN_header_wrap_wrap mb5">
			<div class="CMN_header_wrap">
				<div id="CMN_logo_area" style="margin-top: 4px;margin-bottom: 10px;margin-left: 2px;">
					<img class="logo logosize shadowforimage" style="height:40px;" src="{{ URL::asset('resources/assets/images/microbit_logo.jpg') }}">
				</div>
				<div id="CMN_user_area">
					<div id="CMN_user_date" style="padding-right:10px;background-color: #F0F0F0 !important;vertical-align: middle;">
							@if(Session::get('Gender') == "2")
								<img class="img25px" src="{{ URL::asset('resources/assets/images/female.png') }}">
							@else
								<img class="img25px" src="{{ URL::asset('resources/assets/images/male.png') }}">
							@endif
							<span class="CMN_user_name">{{ Session::get('LastName')." ".Session::get('FirstName') }}</span>
					</div>
				</div>
				<div id="CMN_btn_area">
						<div class="CMN_div_logout" style="margin-top: 6px;">
							<a href="{{ url('logout') }}" class="btn btn-primary">Sign out</a>
						</div>
				</div>
			</div>
		</div>
		<!-- main_tab -->
		<div class="CMN_header_wrap_wrap" style="background-color: #F0F0F0 !important;">
			<div class="CMN_header_wrap">
				<nav id="CMN_gmenu">
					<ul class="" style="padding: 0px;">
						<li class="home jop_btn">
							<a class="pageload" href="{{ url('Menu/index?mainmenu=home&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_home') }}</a>
						</li>
						<li class="btn_expenses jop_btn">
							<a class="pageload" href="{{ url('salarycalc/index?mainmenu=salarycalc&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_salary') }}</a>
						</li>
						<li class="btn_staffexpenses jop_btn">
							<a href="{{ url('totalexp/index?mainmenu=TotalExpenses&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_expenses') }}</a>
						</li>
						@if(Session::get('userclassification') == 4)
						<li class="btn_staff jop_btn">
							<a class="pageload" href="{{ url('Staff/index?mainmenu=staff&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_staff') }}</a>
						</li>
						@endif
					<!-- Madasamy 16/06 -->	
						<li class="btn_visa jop_btn">
							<a href="{{ url('Visa/index?mainmenu=visa&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_visa') }}</a>
						</li>
					<!-- Madasamy 16/06 -->
						<li class="btn_master jop_btn">
							<a href="{{ url('User/index?mainmenu=user&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_master') }}</a>
						</li>
						@if(Session::get('userclassification') == 4 || Session::get('userclassification') == 1)
						<li class="btn_setting jop_btn">
							<a href="{{ url('Setting/index?mainmenu=Setting&time='.date('Ymdhis')) }}">
							{{ trans('messages.lbl_setting') }}</a>
						</li>
						@endif

					</ul>
				</nav>
			</div>
		</div>
		<!-- end_main_tab -->
		<!-- sub_tab -->
		<div class="sub_menu_size" style="background-color: #F0F0F0 !important;font-weight: normal;">
				<!-- language_icon -->
			<div class="langIcon" style="">
				{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
				@if (Session::get('setlanguageval') == 'en')
					{!! Form::image('resources/assets/images/languageiconen.png', '', 
						 array('class' => 'pull-right search box2per pr5 langimg11', 
							'onclick' => 'javascript:return changelanguage()','style'=>'min-width:35px;cursor:pointer;')) !!}
				@elseif(empty(Session::get('setlanguageval')))
					{!! Form::image('resources/assets/images/languageiconjp.png', '', 
						 array('class' => 'pull-right search box2per pr5 langimg11', 
							'onclick' => 'javascript:return changelanguage()','style'=>'min-width:35px;cursor:pointer;')) !!}
				@else
					{!! Form::image('resources/assets/images/languageiconjp.png', '', 
						 array('class' => 'pull-right search box2per pr5 langimg11', 
							'onclick' => 'javascript:return changelanguage()','style'=>'min-width:35px;cursor:pointer;')) !!}
				@endif
			</div>
			<div id="salesDiv" class="CMN_sub_gmenu">
			@if (isset($request->mainmenu) && ($request->mainmenu == "salarycalc" || $request->mainmenu == "salarycalcplus" || $request->mainmenu == "contractEmp" || $request->mainmenu == "basic_calc" || $request->mainmenu == "leave" || $request->mainmenu == "gensendtls" || $request->mainmenu == "salarEmp"))
			<!-- Expenses Sub -->
				@if(Session::get('userclassification') == 4)
				<div id="expenses_sub_1">
					<a href="{{ url('salarycalc/index?mainmenu=salarycalc&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_salary_cal') }}</a>
				</div>
				<div id="expenses_sub_3">
					<a href="{{ url('salarycalcplus/index?mainmenu=salarycalcplus&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_salary_calplus') }}</a>
				</div>
				<div id="expenses_sub_7">
					<a href="{{ url('contractEmp/index?mainmenu=contractEmp&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_conEmployee') }}</a>
				</div>
				<div id="expenses_sub_4">
					<a href="{{ url('BasicCalc/index?mainmenu=basic_calc&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_basic_cal') }}</a>
				</div>
				<div id="expenses_sub_5">
					<a href="{{ url('Leavedtls/index?mainmenu=leave&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_leave_details') }}
					</a>
				</div>
				<div id="expenses_sub_6">
					<a href="{{ url('Gensendtls/index?mainmenu=gensendtls&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_gensen') }}
					</a>
				</div>
				<div id="expenses_sub_8">
					<a href="{{ url('salarEmp/index?mainmenu=salarEmp&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_salarylist') }}</a>
				</div>
				@endif
				
			<!-- //Expenses sub -->
			@endif

			@if (isset($request->mainmenu) && ($request->mainmenu == "TotalExpenses"|| $request->mainmenu == "insurance" || $request->mainmenu == "expenses_exp" || $request->mainmenu == "expenses_travel" || $request->mainmenu == "expenses_total" )) 
			<!-- Total Exp Sub -->
				<div id="totexp_sub_1">
					<a href="{{ url('totalexp/index?mainmenu=TotalExpenses&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_total_expenses') }}</a>
				</div>
				<div id="totexp_sub_2">
					<a href="{{ url('insurance/index?mainmenu=insurance&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_insurence') }}</a>
				</div>
			<!-- //Total Exp Sub -->
			@endif


			@if (isset($request->mainmenu) && ($request->mainmenu == "staff"|| $request->mainmenu == "nonstaff" || $request->mainmenu == "sal_bank" || $request->mainmenu == "address" || $request->mainmenu == "family" || $request->mainmenu == "myfamily" || $request->mainmenu == "esi_myno" )) 
			<!-- Staff Sub -->
				<div id="staff_sub_1">
					<a href="{{ url('Staff/index?mainmenu=staff&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_staff') }}</a>
				</div>
				<div id="staff_sub_8">
					<a href="{{ url('NonStaff/index?mainmenu=nonstaff&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_nonstaff') }}</a>
				</div>
				<div id="staff_sub_2">
					<a href="{{ url('SalBank/index?mainmenu=sal_bank&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_bank') }}</a>
				</div>
				<div id="staff_sub_3">
					<a href="{{ url('SalBank/addressIndex?mainmenu=address&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_address') }}</a>
				</div>
				<div id="staff_sub_4">
					<a href="{{ url('Family/index?mainmenu=family&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_family_details') }}</a>
				</div>
				<div id="staff_sub_5">
					<a href="{{ url('EsiMyNo/index?mainmenu=esi_myno&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_esi_myno') }}</a>
				</div>
			<!-- //Staff Sub -->
			@endif
			<!-- Start Madasamy 16/06 -->	
			@if (isset($request->mainmenu) && ($request->mainmenu == "visa") || ($request->mainmenu == "contract" || $request->mainmenu == "sales" || $request->mainmenu == "newvisa" || $request->mainmenu == "familyvisa" || $request->mainmenu == "RequiredDocument" || $request->mainmenu == "Document")) 
			<!-- Visa Sub -->
				<div id="visa_sub_1">
					<a href="{{ url('Visa/index?mainmenu=visa&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_visa_extension') }}</a>
				</div>
				<div id="visa_sub_2">
					<a href="{{ url('contract/index?mainmenu=contract&time='.date('Ymdhis')) }}" 
					style="text-decoration:none;color:white;">{{ trans('messages.lbl_contract') }}</a>
				</div>

				<div id="visa_sub_3">
					<a class="pageload" href="{{ url('Sales/index?mainmenu=sales&time='.date('Ymdhis')) }}" 
						style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_sale') }}</a>
				</div>

				<div id="visa_sub_4">
					<a class="pageload" href="{{ url('NewVisa/index?mainmenu=newvisa&time='.date('Ymdhis')) }}"
						style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_new_visa') }}</a>
				</div>

				<!-- <div id="visa_sub_5">
					<a class="pageload" href="{{ url('RequiredDocument/index?mainmenu=RequiredDocument&time='.date('Ymdhis')) }}"
						style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_required_document') }}</a>
				</div> -->

				<div id="visa_sub_6">
					<a class="pageload" href="{{ url('Document/index?mainmenu=Document&time='.date('Ymdhis')) }}"
						style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_document') }}</a>
				</div>
				
			<!-- //Visa Sub -->
			@endif
			<!-- End Madasamy 16/06 -->	
			@if (isset($request->mainmenu) && ($request->mainmenu == "user" || $request->mainmenu == "Bank_invoice")) 
			<!-- Master Sub -->
				<div id="master_sub_1">
					<a class="pageload" href="{{ url('User/index?mainmenu=user&time='.date('Ymdhis')) }}" 
						style="text-decoration:none;color:white;">
					{{ trans('messages.lbl_user') }}</a>
				</div>

			<!-- //Master Sub -->
			@endif
			@if (isset($request->mainmenu) && $request->mainmenu == "Ourdetail")
			<!-- Master Sub -->
				<div id="our_details_sub_1">
					<a href="{{ url('Ourdetail/index?mainmenu=Ourdetail&time='.date('Ymdhis')) }}" style="text-decoration:none;color:white;">{{ trans('messages.lbl_ourdetails') }}</a>
				</div>
			<!-- //Master Sub -->
			@endif
			<?php if ($request->mainmenu == "Setting") {?>
			<!-- Setting Sub -->
				<div id="setting_sub_1">
					<a href="#" style="text-decoration:none;color:white;">{{ trans('messages.lbl_setting') }}</a>
				</div>
			<!-- // Setting Sub -->
			<?php }?>
			</div>
		</div>
	<!-- end_sub_tab -->
	</div>
	<!-- Content Wrapper. Contains page content -->
	<div id="sectiondiv" class="bg_white" style="min-width: 700px;margin-top:0px;">
		@yield('content')
	</div>
</body>
</html>