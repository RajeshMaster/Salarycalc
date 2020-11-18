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

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">
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
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_visa') }}</h2>
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
	    <div class="ml10 mt10 box50per pull-left">
	      <a href="javascript:gotoBack('index', '');"
	        class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
	      <!-- <a onclick="javascript:edit();" class="btn btn-warning box80 mr2"><span class="fa fa-edit"></span>{{ trans('messages.lbl_edit') }}</a> -->
	      <a class="btn btn-warning" href="javascript:gotoBack('viewlist', '');">
	        <i class="fa fa-history" aria-hidden="true"></i> {{ trans('messages.lbl_history') }}
	      </a>
	      @foreach($Validity as $key=>$Validnoday)
	        @if($Validnoday->Validity < 90 && ($Validnoday->applydate != "0000-00-00" && $Validnoday->applydate !="" ))
	            <a onclick="javascript:applydate('applydatepopupedit','{{ $request->mainmenu }}',2);" class="btn btn-warning box120"><span class="fa fa-calendar"></span> Apply Date</a>
	            {{ Form::hidden('appdtedit', 'edit' , array('id' => 'appdtedit')) }}
	        @elseif($Validnoday->Validity < 90 && ($Validnoday->applydate == "0000-00-00" || $Validnoday->applydate =="" ))
	            <a onclick="javascript:applydate('applydatepopup','{{ $request->mainmenu }}',1);" class="btn btn-info box120"><span class="fa fa-calendar"></span> Apply Date</a>
	        @endif
	      @endforeach
	  	</div>
	      
	    <div class="ml10 mt10 mr5 box27per pull-right">
	      	<a href="javascript:familyVisa('{{ $request->visaid }}');" class="pull-left mt5 fwb">
                {{ trans('messages.lbl_myfamilyDetails') }}
          	</a>
	        <a onclick="return confirmdownload();" href="{{ url('Visa/Download?empid='.$visadetails[0]->user_id.'&id='.$request->id) }}" class="btn btn-success box190 pull-right">
	          <span class="fa fa-file-excel-o"></span>&emsp;{{ trans('messages.lbl_exceldownload') }}
	        </a>
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

    @foreach($visadetails as $key=>$user)
      {{ Form::hidden('id', $user->id , array('id' => 'id')) }}
	    <div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
			<fieldset>
	          
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_employeeid') }}</label>
					</div>
					<div class="col-xs-9 fwb" style="color:{{ getEmpIDColor( $user->user_id ) }}">
						<span>
							{{ strtoupper( $user->user_id ) }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_empName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb clr_brown">
				    {{ empnamelength($user->LastName, $user->FirstName, 200) }}
				    {{ Form::hidden('empname', empnamelength($user->LastName, $user->FirstName, 200) , array('id' => 'empname')) }}
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
		              <label>{{ trans('messages.lbl_Start_date') }}</label>
		            </div>
		            <div>
		              <span class="col-xs-9 fwb">
		                {{ $user->StDate }}
		              </span>
		            </div>
		        </div>

		        <div class="col-xs-12 mt10">
		            <div class="col-xs-3 text-right clr_blue">
		              <label>{{ trans('messages.lbl_enddate') }}</label>
		            </div>
		            <div>
		              <span class="col-xs-9 fwb">
		                {{ $user->EdDate }}
		              </span>
		            </div>
		        </div>

		        <div class="col-xs-12 mt10">
		            <div class="col-xs-3 text-right clr_blue">
		              <label>{{ trans('messages.lbl_status') }}</label>
		            </div>
		            <div>
		              <span class="col-xs-9 fwb">
		                {{ $user->VisaNM }}
		              </span>
		            </div>
		        </div>

		        <div class="col-xs-12 mt10">
		            <div class="col-xs-3 text-right clr_blue">
		              <label>{{ trans('messages.lbl_position') }}</label>
		            </div>
		            <div>
		              <span class="col-xs-9 fwb">
		                {{ $user->VisaPosNM }}
		              </span>
		            </div>
		        </div>

		        <div class="col-xs-12 mt10">
		            <div class="col-xs-3 text-right clr_blue">
		              <label>{{ trans('messages.lbl_address') }}</label>
		            </div>
		            <span class="col-xs-9 fwb">
			              {{ ($japanAddress) ? $japanAddress : '-' }}
			        </span>
			    </div>

		        @if ($user->Ins_DT != "0000-00-00" && $user->Ins_DT != "" && $user->Ins_DT != null)
		          <div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_registerdate') }}</label>
					</div>
					<span class="col-xs-9 fwb">
						{{ $user->Ins_DT }}
					</span>
		          </div>
		        @endif

	    	</fieldset>
	    </div>

	    @if ($user->applydate != "0000-00-00" && $user->applydate != "")
		    <fieldset>
		    	<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_applieddate') }}</label>
					</div>
					<span class="col-xs-9 fwb">
						{{ $user->applydate }}
					</span>
		        </div>

		        <div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_appliedplace') }}</label>
					</div>
					<span class="col-xs-9 fwb">
						@if($user->appliedplace == '1' )
		                {{ trans('messages.lbl_tokyo') }}
		              @else
		                {{ trans('messages.lbl_osaka') }}
		              @endif
					</span>
		        </div>

		    </fieldset>
		@endif
		
		@if ($user->returneddate != "0000-00-00" && $user->returneddate != "")
		      <fieldset>
		      <div class="col-md-3 text-right clr_blue">
		        <label>{{ trans('messages.lbl_returneddate') }}</label>
		      </div>
		      <div class="mb5">
		          <div class="CMN_div_inblock">
		              {{ $user->returneddate }}
		          </div>
		      </div>    
		      <div class="col-md-3 text-right clr_blue">
		        <label>{{ trans('messages.lbl_returnedplace') }}</label>
		      </div>
		      <div class="mb5">
		          <div class="CMN_div_inblock">
		              @if($user->returnedplace == '1' ) 
		                {{ trans('messages.lbl_toindia') }}
		              @else
		                {{ trans('messages.lbl_tojapan') }}
		              @endif
		          </div>
		      </div>
		    </fieldset>
	    @endif	

	    <div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
			<fieldset>
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_citizen') }}</label>
					</div>
					<span class="col-xs-9 fwb">
						@php
							if ($empArray['citizenShip'] == 1){ $citizen = trans('messages.lbl_india'); }
					      	elseif($empArray['citizenShip'] == 2){ $citizen = trans('messages.lbl_japan'); }
					      		else{ $citizen = '-'; }
						@endphp
						{{ strtoupper($citizen) }}
					</span>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_dob') }}</label>
					</div>
					<span class="col-xs-9 fwb">
						{{ $empArray['DOB'] }}
					</span>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_gender') }}</label>
					</div>
					<span class="col-xs-9 fwb clr_brown">
						{{ ($empArray['Gender'] == 1) ? trans('messages.lbl_male') : trans('messages.lbl_female') }}
					</span>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_maritalstatus') }}</label>
					</div>
					<span class="col-xs-9 fwb clr_brown">
						@if($empArray['MartialStatus'] == 1)
							{{ trans('messages.lbl_single') }}
						@elseif($empArray['MartialStatus'] == 2)
							{{ trans('messages.lbl_married') }}
						@else NILL
						@endif
					</span>
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
						<label>{{ trans('messages.lbl_mobileno') }} ・ {{ trans('messages.lbl_japan') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
						{{ ((isset($empArray['Mobile1'])) && $empArray['Mobile1'] != '') ? $empArray['Mobile1'] : '-' }}
						</span>
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
							@if(isset($certificate[0]))
								{{ $certificate[0]->certificate_name }} ( {{ $certificate[0]->year.'-'.sprintf('%02d',$certificate[0]->month) }} )
							@else -
							@endif
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_designation') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ $empArray['Designation'] }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue mt4">
						<label>{{ trans('messages.lbl_experience') }}</label>
					</div>
					<div class="col-xs-9">
						<table>
							@if((isset($experience['DOJ_SS'])) && ($experience['DOJ_SS']!='0000-00-00') && ($experience['resignDateSS'] != '0000-00-00'))
							<tr>
								<td class="fwb" style="border:none;">
								 	{{ $experience['DOJ_SS'] }} ～ {{ $experience['resignDateSS'] }}
								</td>
								<td style="border:none;"></td>
								<td class="fwb" style="border:none;">
									Sathi Systems Pvt Ltd., India
								</td>
							</tr>
							@endif
							<tr>
								@if((isset($experience['DOJ_MB'])) && ($experience['DOJ_MB'] != '0000-00-00'))
									<td class="fwb" style="border:none;">
										 {{ $experience['DOJ_MB'] }} ～  現在
									</td>
									<td style="border:none;"></td>
									<td class="fwb" style="border:none;">
										株式会社　Microbit
									</td>
								@else 
									<td class="fwb"> - </td>
								@endif
							</tr>
						</table>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_contract') }} {{ trans('messages.lbl_amount') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ ($contractAmount != '') ? '¥ '.$contractAmount : '-' }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_total') }} {{ trans('messages.lbl_experience') }}</label>
					</div>
					<div class="col-xs-9">
						<span class="fwb">
							{{ ($expYears != '') ? ($expYears > 1)? $expYears.' Years' : $expYears.' Year'  : '-' }}
						</span>
					</div>
				</div>

			</fieldset>
		</div>

		<div class="col-xs-12 pl5 pr5" ondragstart="return false;" ondrop="return false;">
			<fieldset>
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue mt4">
						<label>{{ trans('messages.lbl_myfamilyDetails') }}</label>
					</div>
						<div class="col-xs-9">
						@if(isset($myFamilyDetails[0]))
							<table>
								<tr>
									<td class="fwb clr_blue" style="border:none;">
										{{ trans('messages.lbl_relationship') }}
									</td>

									<td class="fwb clr_blue" style="border:none;">
										{{ trans('messages.lbl_name') }}
									</td>

									<td class="fwb clr_blue" style="border:none;">
										{{ trans('messages.lbl_dob') }}
									</td>

									<td class="fwb clr_blue" style="border:none;">
										{{ trans('messages.lbl_nationality') }}
									</td>

									<td class="fwb clr_blue" style="border:none;">
										{{ trans('messages.lbl_visacardno') }}
									</td>
								</tr>
								@foreach($myFamilyDetails as $key=>$family)
									<tr>
										<td class="fwb" style="border:none;">
						                    {{ $relationArr[$family->Emp_Relation] }}
										</td>

										<td class="fwb" style="border:none;">
											{{ strtoupper($family->FirstName.' '.$family->LastName) }}
										</td>

										<td class="fwb" style="border:none;">
											{{ $family->DOB }}
										</td>

										<td class="fwb" style="border:none;">
											@if($family->Nationality == 1)
							                    {{ trans('messages.lbl_india') }}
						                    @elseif($family->Nationality == 2)
						                      	{{ trans('messages.lbl_japan') }}
						                    @else
						                    	{{ $family->NationalityOthers }}
						                    @endif
										</td>

										<td class="fwb" style="border:none;">
											{{ $family->CardNo }}
										</td>
									</tr>
								@endforeach
							</table>
								
						@else <label>-</label>
						</div>
						@endif
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