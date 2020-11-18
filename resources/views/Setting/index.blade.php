@extends('layouts.app')

@section('content')

{{ HTML::script('resources/assets/js/Setting.js') }}

{{ HTML::script('resources/assets/js/lib/additional-methods.min.js') }}

<style type="text/css">

	.alertboxalign {

	    	margin-bottom: -60px !important;

	}

	.alert {

		    display:inline-block !important;

		    height:30px !important;

		    padding:5px !important;

		    margin-top: 10px !important;

	}

</style>
<script type="text/javascript">
	function underconstruction() {
		alert("Under Construction");return;
	}
</script>

<div class="CMN_display_block" id="main_contents">

	<!-- article to select the main&sub menu -->

	<article id="setting" class="DEC_flex_wrapper" data-category="setting setting_sub_1">

		<div class="row hline">

			<div class="col-xs-12" style="padding-left: 5px;">

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

				<img class="pull-left box35 mt10 ml10" src="{{ URL::asset('resources/assets/images/setting.jpg') }}">

				<h2 class="pull-left pl5 mt10 CMN_mw150">

					{{ trans('messages.lbl_setting') }}

				</h2>

			</div>

        </div>

        <div class="col-xs-12">

        	<div class="col-xs-6 mb20">

        		@if(Session::get('userclassification') != 1)

        		<div>

	        		<div class="mt20 box475" 

	        			style="background-color: #43C0E8">

	        			<label class="mt2 ml5"> 

	        				{{ trans('messages.lbl_salary') }}

	        			</label> 

	        		</div>
	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        		<label class="ml40 mt20">>>&nbsp;&nbsp;

	        			{{ trans('messages.lbl_salary_calc') }}

	        		</label> 

	        		<div>

	        		@php

	        			$tbl_name = 'mstsalary'

	        		@endphp

	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        			href="javascript:settingpopupsinglefield('twotextpopup',

	        				'{{ $tbl_name }}','{{ 1 }}');">

	        				{{ trans('messages.lbl_salary_det') }}

	        			</a></br>


	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        				href="javascript:settingpopupsinglefield('twotextpopup',

	        				'{{ $tbl_name }}','{{ 2 }}');">

	        				{{ trans('messages.lbl_salary_ded') }}

	        			</a>

	        		</div>

	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        		<label class="ml40 mt20">>>&nbsp;&nbsp;

	        			{{ trans('messages.lbl_salary_calc') }}+

	        		</label> 

	        		<div>

	        		@php

	        			$tbl_name = 'mstsalaryplus'

	        		@endphp

	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        			href="javascript:settingpopupsinglefield('twotextpopup',

	        				'{{ $tbl_name }}','{{ 1 }}');">

	        				{{ trans('messages.lbl_salary_det') }}

	        			</a></br>


	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        				href="javascript:settingpopupsinglefield('twotextpopup',

	        				'{{ $tbl_name }}','{{ 2 }}');">

	        				{{ trans('messages.lbl_salary_ded') }}

	        			</a>

	        		</div>

	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        	</div>

	        	@endif


        	</div>

        	<div class="col-xs-6 pl40">

        		@if(Session::get('userclassification') != 1)

	        	<div>

	        		<div class="mt20 box455" 

	        			style="background-color: #43C0E8">

	        			<label class="mt2 ml5"> 

	        				Import Database Registeration

	        			</label> 

	        		</div>

	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        		<label class="ml40 mt20">>>&nbsp;&nbsp;

	        			{{ trans('messages.lbl_database_reg') }}

	        		</label>

	        		<div>

						@php

							$tbl_name = 'olddbdetailsregistration'

						@endphp

	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        				href="javascript:settingpopupsinglefield('selectthreefieldDatas',

	        				'{{ $tbl_name }}');">

	        				{{ trans('messages.lbl_database_reg') }}

	        			</a>

	        		</div>

	        		<div class="" style="border-bottom:1px solid #136E83;margin-top: 20px;"></div>

	        	</div>
	        	<!-- Document Start -->
	        	<div>

	        		<div class="mt20 box475" 

	        			style="background-color: #43C0E8">

	        			<label class="mt2 ml5"> 

	        				{{ trans('messages.lbl_document') }}

	        			</label> 

	        		</div>
	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        		<label class="ml40 mt20">>>&nbsp;&nbsp;

	        			{{ trans('messages.lbl_required_document') }}

	        		</label> 

	        		<div>

	        		@php

	        			$tbl_name = 'salc_visa_document'

	        		@endphp

	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        			href="javascript:settingpopupsinglefield('onetextpopup',

	        				'{{ $tbl_name }}','{{ 1 }}');">

	        				{{ trans('messages.lbl_visa') }}

	        			</a>

	        		</div>

	        	</div>
	        	<!-- Document End -->

	        	@endif

        	</div>

        </div>

        <!-- Company Start -->
        <div class="col-xs-12">

        	<div class="col-xs-6 mb20">

        		@if(Session::get('userclassification') != 1)

        		<div>

	        		<div class="mt20 box475" 

	        			style="background-color: #43C0E8">

	        			<label class="mt2 ml5"> 

	        				{{ trans('messages.lbl_company') }}

	        			</label> 

	        		</div>
	        		<div class="mt4" style="border-bottom:1px solid #136E83;"></div>

	        		<label class="ml40 mt20">>>&nbsp;&nbsp;

	        			{{ trans('messages.lbl_company') }}

	        		</label> 

	        		<div>

	        		@php

	        			$tbl_name = 'company_details'

	        		@endphp

	        			<a class="mt20 ml80 btn-link" style="color:blue;" 

	        			href="javascript:settingpopupsinglefield('eighttextpopup',

	        				'{{ $tbl_name }}','{{ 1 }}');">

	        				{{ trans('messages.lbl_company_details') }}

	        			</a>

	        		</div>

	        	</div>

	        	@endif


        	</div>
        </div>
        <!-- Company End -->

	</article>

</div>

<div id="showpopup" class="modal fade" style="width: 775px;">

    <div id="login-overlay">

        <div class="modal-content">

            <!-- Popup will be loaded here -->

        </div>

    </div>

</div>

@endsection

 <?php if(isset($_REQUEST['frompopup'])=="1") {?>

  <!--   <script type="text/javascript">

    $(document).ready(function(){

	    $("#banklink").trigger('click'); 

	});

    </script> -->

    <?php }?>