@extends('layouts.app')

@section('content')
@php use App\Http\eradate @endphp

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/familyvisa.js') }}
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

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">
  {{ Form::open(array('name'=>'familyVisaView', 'id'=>'familyVisaView', 'url' => 'Visa/index?time='.date('YmdHis'),'method' => 'POST')) }}
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

    {{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}
    {{ Form::hidden('editChk', $request->editChk , array('id' => 'editChk')) }}

    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_myfamilyDetails') }}</h2>
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
		    <a href="javascript:gotoFamilyView('{{ $request->Emp_ID }}');"
		        class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
		    </a>	  

		    <a onclick="javascript:edit();" class="btn btn-warning box80 mr2"><span class="fa fa-edit"></span>{{ trans('messages.lbl_edit') }}</a>

	    </div>

		@php
	   		$relationArr = array('1'=> trans('messages.lbl_father'),
							 '2'=> trans('messages.lbl_mother'),
							 '3'=> trans('messages.lbl_grandFather'),
							 '4'=> trans('messages.lbl_grandMother'),
							 '5'=> trans('messages.lbl_sister'),
							 '6'=> trans('messages.lbl_brother'),
							 '7'=> trans('messages.lbl_wife'),
							 '8'=> trans('messages.lbl_son'),
							 '9'=> trans('messages.lbl_daughter'));
		@endphp

	    @foreach($visaDetails as $key=>$user)
	      {{ Form::hidden('id', $user->id , array('id' => 'id')) }}
		    <div class="col-xs-12 pl5 pr5 mb50" ondragstart="return false;" ondrop="return false;">
				<fieldset>
		          
					<div class="col-xs-12 mt20">
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
					    <label>{{ trans('messages.lbl_empName') }}</label>
					  </div>
					  <div class="col-xs-9 fwb clr_brown">
					    {{ $empdetails->FirstName }} {{ $empdetails->LastName }}
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_name') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
					    {{ $user->FirstName }} {{ $user->LastName }} 
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_kananame') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
					    {{ $user->Kana_FirstName }} {{ $user->Kana_LastName }} 
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_dob') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
					    @if( $user->DOB=="0000-00-00" || $user->DOB=="")
			    		@else

			    			@php
				    			$DOB_eraDate = getEraDate($user->DOB);
							@endphp

			    			{{ $DOB_eraDate['japeraineng'].'&emsp;'.$user->DOB }}

			    			<B>({{ date('Y') - date('Y',strtotime($user->DOB)) }})</B>
			    		@endif
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_nationality') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
					    @if($user->Nationality == 1)
		                    {{ trans('messages.lbl_india') }}
	                    @elseif($user->Nationality == 2)
	                      	{{ trans('messages.lbl_japan') }}
	                    @else
	                    	{{ $user->NationalityOthers }}
	                    @endif
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_gender') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
						    @if($user->Gender == 1)
		                      {{ trans('messages.lbl_male') }}
		                    @else
		                      {{ trans('messages.lbl_female') }}
		                    @endif
					  </div>
					</div>

					<div class="col-xs-12 mt10">
					  <div class="col-xs-3 text-right clr_blue">
					    <label>{{ trans('messages.lbl_relationship') }}</label>
					  </div>
					  <div class="col-xs-9 fwb">
		                    {{ $relationArr[$user->Emp_Relation] }}
					  </div>
					</div>

					<div class="col-xs-12 mt10">
						<div class="col-xs-3 text-right clr_blue">
						  <label>{{ trans('messages.lbl_visacardno') }}</label>
						</div>
						<div>
						  <span class="col-xs-9 fwb">
						    {{ $user->CardNo }}
						    {{ Form::hidden('cardno', $user->CardNo , array('id' => 'cardno')) }}
						  </span>
						</div>
					</div>

			        <div class="col-xs-12 mt10">
			            <div class="col-xs-3 text-right clr_blue">
			              <label>{{ trans('messages.lbl_no_in_years') }}</label>
			            </div>
			            <div>
			              <span class="col-xs-9 fwb">
			                @if ($user->NoYears >= "1.1")
			                  {{ $user->NoYears." yrs" }}
			                @else
			                  {{ $user->NoYears." yr" }}
			                @endif
			              </span>
			            </div>
			        </div>

			        <div class="col-xs-12 mt10">
			            <div class="col-xs-3 text-right clr_blue">
			              <label>{{ trans('messages.lbl_duration') }}</label>
			            </div>
			            <div>
			              <span class="col-xs-9 fwb">
			                {{ $user->StDate }} ～  {{ $user->EdDate }}
			              </span>
			            </div>
			        </div>

			        <div class="col-xs-12 mt10">
			            <div class="col-xs-3 text-right clr_blue">
			              <label>{{ trans('messages.lbl_address') }}</label>
			            </div>
			            <div>
			              <span class="col-xs-9 fwb">
			                @if(isset($address->full_address))
			                	{{ $address->full_address }}
			                @else
			                	NILL
			                @endif
			              </span>
			            </div>
			        </div>

			        <div class="col-xs-12 mt10">
			            <div class="col-xs-3 text-right clr_blue">
			              <label>{{ trans('messages.lbl_visastatus') }}</label>
			            </div>
			            <div>
			              <span class="col-xs-9 fwb">
			                {{ ($user->VisaStatus) ? $user->VisaStatus : '-' }}
			              </span>
			            </div>
			        </div>

			          <div class="col-xs-12 mt10 mb20">
						<div class="col-xs-3 text-right clr_blue">
							<label>{{ trans('messages.lbl_registerdate') }}</label>
						</div>
						<span class="col-xs-9 fwb">
							@if ($user->CreatedDateTime != "0000-00-00 00:00:00" && $user->CreatedDateTime != "")
		                        {{ substr($user->CreatedDateTime,0,11) }}
		                    @endif
						</span>
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

@php
	function getEraDate($dobDate){

		$eraDate = array();
		$empjapancalender = Eradate::geteradate($dobDate, 6);
		$empdobdate = explode('/', $empjapancalender);
			if (isset($empdobdate[3])) {
			$empdobdate[3] = $empdobdate[3];
		} else {
			$empdobdate[3] = "";
		}

		if (isset($empdobdate[0])) {
			$empdobdate[0] = $empdobdate[0];
		} else {
			$empdobdate[0] = "";
		}

		$eraDate['japerainjap'] = $empdobdate[3];
		$eraDate['japeraineng'] = $empdobdate[0];

		return $eraDate;

	}
	
@endphp

@endsection