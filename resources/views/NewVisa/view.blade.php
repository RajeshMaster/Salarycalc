@extends('layouts.app')

@section('content')
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/visa.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}

  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>

  <style type="text/css">
    .viewPic3by2{
	    display: block;
	    max-width:180px;
	    max-height:180px;
	    width: auto;
	    height: auto;
    }
    .clr_brown{
		 color: #9C0000 ! important;
	}
  </style>

<div class="" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_4">
  {{ Form::open(array('name'=>'visaform', 'id'=>'visaform', 'url' => 'Visa/index?time='.date('YmdHis'),'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
    {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    {{ Form::hidden('visasort',$request->visasort , array('id' => 'visasort')) }}
    {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('visaid', $request->visaid , array('id' => 'visaid')) }}
    {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('singlesearch', $request->singlesearch , array('id' => 'singlesearch')) }}
    {{ Form::hidden('msearchempid', $request->msearchempid , array('id' => 'msearchempid')) }}
    {{ Form::hidden('msearchempname', $request->msearchempname , array('id' => 'msearchempname')) }}
    {{ Form::hidden('msearchstdate', $request->msearchstdate , array('id' => 'msearchstdate')) }}
    {{ Form::hidden('msearcheddate', $request->msearcheddate , array('id' => 'msearcheddate')) }}
    {{ Form::hidden('file', '' , array('id' => 'file')) }}
    {{ Form::hidden('path', '' , array('id' => 'path')) }}
    {{ Form::hidden('rotateval', '' , array('id' => 'rotateval')) }}
    {{ Form::hidden('updateflg', '' , array('id' => 'updateflg')) }}
    {{ Form::hidden('filecnt', '' , array('id' => 'filecnt')) }}
    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml5 mr5 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_new_visa') }}</h2>
            <h2 class="pull-left mt15">・</h2> 
            <h2 class="pull-left mt15" style="color:blue;">{{ trans('messages.lbl_view') }}</h2>
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
    <div class="">
	    <div class="ml10 mt10">
	      <a href="javascript:gotoBack('index', '');"
	        class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>

	        <a onclick="javascript:;" href="javascript:;" class="btn btn-success box170 pull-right">
	          <span class="fa fa-file-excel-o"></span>&emsp;{{ trans('messages.lbl_exceldownload') }}
	        </a>
	    </div>
    @foreach($singleview as $key=>$user)
      {{ Form::hidden('Emp_ID', $user->Emp_ID , array('Emp_ID' => 'Emp_ID')) }}
	    <div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
			<fieldset>
	          
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_employeeid') }}</label>
					</div>
					<div class="col-xs-9 fwb" style="color:{{ getEmpIDColor( $user->Emp_ID ) }}">
						<span>
							{{ strtoupper( $user->Emp_ID ) }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_firstName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
				  	{{ ($user->FirstName != '') ? strtoupper($user->FirstName) : 'NILL' }}
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_kanaFirstName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
				  		{{ ($user->KanaFirstName != '') ? $user->KanaFirstName : 'NILL' }}
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_lastName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
				  	{{ ($user->LastName != '') ? strtoupper($user->LastName) : 'NILL' }}
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_kanaLastName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
				  		{{ ($user->KanaLastName != '') ? $user->KanaLastName : 'NILL' }}
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_citizen') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
						@if(isset($citizentype[$user->citizenShip]))
							{{ $citizentype[$user->citizenShip] }}
						@else
							{{ "NILL" }}
						@endif
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_dob') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
						{{ $user->DOB }}
						@if($user->DOB!="")
							<span class="box100per fwb">({{ birthday($user->DOB) }})</span>
						@else  
							{{ "NILL" }}    
						@endif
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_gender') }}</label>
				  </div>
				  <div class="col-xs-9 fwb clr_brown">
						@if($user->Gender=="1")
							{{trans('messages.lbl_male')}}
						@elseif($user->Gender=="2")
							{{trans('messages.lbl_female')}}
						@else
							{{ "NILL" }}
						@endif
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_maritalstatus') }}</label>
				  </div>
				  <div class="col-xs-9 fwb clr_brown">
						@if($user->MartialStatus=="1")
							{{trans('messages.lbl_single')}}
						@elseif($user->MartialStatus=="2")
							{{trans('messages.lbl_married')}}
						@else
							{{ "NILL" }}    
						@endif
				  </div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_hometown') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ (isset($passport[0]->PlaceofBirth)) ? $passport[0]->PlaceofBirth : '-' }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_mobileno') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
						@if($user->Mobile!="")
							@if (strpos($user->Mobile, '-') != false)
							{{ $user->Mobile }}
							@else
							{{ substr($user->Mobile,0,5)."-".substr($user->Mobile,5,10) }}
							@endif
						@else
							{{"NILL"}}
						@endif
				  </div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_passportno') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ (isset($passport[0]->PassportNo)) ? $passport[0]->PassportNo : '-' }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_passport') }}・{{ trans('messages.lbl_dateofexpiry') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ (isset($passport[0]->DOE)) ? $passport[0]->DOE : '-' }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_university') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ ((isset($education['university'])) && $education['university'] != '') ? strtoupper($education['university']) : '-' }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_specific') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb clr_brown">
							@if($education['specification'] != '')
								{{ strtoupper($education['specification']) }}
							@else -
							@endif
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_department') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb clr_brown">
							@if($education['department'] != '')
								{{ strtoupper($education['department']) }}
							@else -
							@endif
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_graduationDate') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							@if($education['complete_year'] != '')
								{{ $education['complete_year'].' - '.sprintf('%02d', $education['complete_month']) }}
							@else -
							@endif
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>JLPT {{ trans('messages.lbl_certificate') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							@if(isset($certificate['name']))
								{{ $certificate['name'] }} ( {{ $certificate['year'].'-'.sprintf('%02d',$certificate['month']) }} )
							@else -
							@endif
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt5">
					<div class="col-xs-3 text-right clr_blue mt4">
						<label>{{ trans('messages.lbl_experience') }}</label>
					</div>
					<div class="col-xs-9">
						@if((isset($experience['DOJ_SS'])) && ($experience['DOJ_SS']!='0000-00-00'))
							<table style="padding:0%">
								<tr>
									<td class="fwb" style="border:none;">
									 	{{ $experience['DOJ_SS'] }} ～  現在
									</td>
									<td style="border:none;"></td>
									<td class="fwb" style="border:none;">
										Sathi Systems Pvt Ltd., India
									</td>
								</tr>
							</table>
						@endif
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_total') }} {{ trans('messages.lbl_experience') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ ($experience['years'] != '') ? ($experience['years'] > 1) ? $experience['years'].' Years' : $experience['years'].' Year'  : '-' }}
						</span>
					</div>
				</div>

				

	    	</fieldset>
	    </div>
		

		<div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
			<fieldset>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_india') }} {{ trans('messages.lbl_address') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">
						@if($user->Address!="")
							{!! nl2br(e($user->Address)) !!}
						@else
							{{ "NILL" }}
						@endif
				  </div>
				</div>

			</fieldset>
		</div>


	</div>


    
      
    @endforeach
    </div>
    {{ Form::close() }}
  </article>
</div>

<div id="applydatepopup" class="modal fade">
    <div id="login-overlay">
        <div class="modal-content">
            <!-- Popup will be loaded here -->
        </div>
    </div>
</div>

@endsection