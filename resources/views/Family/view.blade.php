@extends('layouts.app')

@section('content')
@php use App\Http\eradate @endphp

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/family.js') }}
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

  <article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_4">
  {{ Form::open(array('name'=>'myfamilyView', 'id'=>'myfamilyView', 'url' => 'Family/view?time='.date('YmdHis'),'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}

    {{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}
    {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
    {{ Form::hidden('editChk', $request->editChk , array('id' => 'editChk')) }}

    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/family.png') }}">
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
		    <a href="javascript:gotoIndex();"
		        class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
		    </a>	  
		    @if($empdetails->MartialStatus == 2)
			    <a onclick="javascript:addFamilyMember('{{ $empdetails->Emp_ID }}');" class="btn btn-success box80 mr2">
			    	<span class="fa fa-plus">&nbsp;</span>{{ trans('messages.lbl_add') }}
			    </a>
			@endif
	    </div>

	    <div class="col-xs-12 pl5 pr5 mb50" ondragstart="return false;" ondrop="return false;">
			<fieldset>
	          
				<div class="col-xs-12 mt20">
					<div class="col-xs-3 text-right clr_blue">
						<label>{{ trans('messages.lbl_employeeid') }}</label>
					</div>
					<div class="col-xs-9 fwb" style="color:{{ getEmpIDColor( $empdetails->Emp_ID ) }}">
						<span>
							{{ strtoupper($empdetails->Emp_ID) }}
						</span>
					</div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_empName') }}</label>
				  </div>
				  <div class="col-xs-9 fwb clr_brown">
				    {{ strtoupper($empdetails->FirstName.' '.$empdetails->LastName) }}
				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_maritalstatus') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">

				  		@if($empdetails->MartialStatus == 1)
				    		{{ trans('messages.lbl_single') }}
				    	@elseif($empdetails->MartialStatus == 2)
				    		{{ trans('messages.lbl_married') }}
				    	@else NILL
				    	@endif

				  </div>
				</div>

				<div class="col-xs-12 mt10">
				  <div class="col-xs-3 text-right clr_blue">
				    <label>{{ trans('messages.lbl_address') }}</label>
				  </div>
				  <div class="col-xs-9 fwb">

				  		@if($empdetails->full_address != '')
				    		{{ $empdetails->full_address }}
				    	@else NILL
				    	@endif

				  </div>
				</div>


				<fieldset class="col-xs-11 mt30 ml40" style="display: inline-block;">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b class="clr_blue">{{ trans('messages.lbl_family') }}</b></legend>

					<table class="tablealternate CMN_tblfixed mt30 mb30">
						<colgroup>
							<col width="10%">
							<col width="25%">
							<col width="25%">
							<col width="20%">
							<col width="10%">
							<!-- <col width="10%"> -->
						</colgroup>
	                  	<thead class="CMN_tbltheadcolor">
		                    <tr>
		                      <th>{{ trans('messages.lbl_relation') }}</th>
		                      <th>{{ trans('messages.lbl_name') }}</th>
		                      <th>{{ trans('messages.lbl_kananame') }}</th>
		                      <th>{{ trans('messages.lbl_dob') }}</th>
		                      <th>{{ trans('messages.lbl_livein_japan') }}</th>
		                      <!-- <th></th> -->
		                    </tr>
	                  	</thead>
	                  	<tbody>

	              			@forelse($family as $key=>$value)
	           
				                <tr>

				                    <td class="pl5"> {{ $value['relation'] }} </td>
				                    <td class="pl5" title="{{ $value['name'] }}">
				                    	{{ singlefieldlength($value['name'],25) }}
				                    </td>
				                    <td class="pl5" title="{{ $value['kanaName'] }}">
				                    	{{ singlefieldlength($value['kanaName'],18) }}
				                    </td>
									<td class="text-center">

										@if( $value['DOB'] =="0000-00-00" || $value['DOB'] =="")
							    		@else

							    			@php
								    			$DOB_eraDate = getEraDate($value['DOB']);
											@endphp

							    			{{ $DOB_eraDate['japerainjap'].'&emsp;'.$DOB_eraDate['japeraineng'].'&emsp;'.$value['DOB'] }}

							    			<B>({{ date('Y') - date('Y',strtotime($value['DOB'])) }})</B>
							    		@endif

									</td>

				                    <td class="text-center">
				                    	@if($value['liveInJapan'] == 1)
				                    		<i class="fa fa-check-square-o" aria-hidden="true"></i>
				                    	@else
				                    		<i class="fa fa-square-o" aria-hidden="true"></i>
				                    	@endif
				                    </td>

				                    <!-- @php
				                    	$id = '';
				                    	$id = $value['id'];
				                    @endphp

				                    <td class="text-center">
				                    	<a href="javascript:editMember('{{ $id }}')">
				                    		<i class="fa fa-pencil-square-o" style="color:red;" aria-hidden="true"></i>
				                    	</a>
				                    </td> -->
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
				</fieldset>

			@if($empdetails->MartialStatus == 2)
				<fieldset class="col-xs-11 mt30 ml40" style="display: inline-block;">
				<legend align="left" 
				style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -13px;margin-bottom: 0px !important;margin-left: -5px !important;">
					<b class="clr_blue">{{ trans('messages.lbl_myfamily') }}</b></legend>

						<table class="tablealternate CMN_tblfixed mt30 mb30">
			                  <colgroup>
			                    <col width="10%">
			                    <col width="25%">
			                    <col width="25%">
			                    <col width="20%">
			                    <col width="10%">
			                    <col width="10%">
			                  </colgroup>
	                  	<thead class="CMN_tbltheadcolor">
		                    <tr>
		                      <th>{{ trans('messages.lbl_relation') }}</th>
		                      <th>{{ trans('messages.lbl_name') }}</th>
		                      <th>{{ trans('messages.lbl_kananame') }}</th>
		                      <th>{{ trans('messages.lbl_dob') }}</th>
		                      <th>{{ trans('messages.lbl_livein_japan') }}</th>
		                      <th></th>
		                    </tr>
	                  	</thead>
	                  	<tbody>
	              			@forelse($myFamily as $key=>$value1)
	           
				                <tr>
				                    <td class="pl5"> {{ $value1['relation'] }} </td>
				                    <td class="pl5"> {{ $value1['name'] }}	</td>
				                    <td class="pl5"> {{ $value1['kanaName'] }}	</td>
									<td class="text-center"> 
										@if( $value1['DOB'] =="0000-00-00" || $value1['DOB'] =="")
							    		@else

							    			@php
								    			$DOB_eraDate = getEraDate($value1['DOB']);
											@endphp

							    			{{ $DOB_eraDate['japerainjap'].'&emsp;'.$DOB_eraDate['japeraineng'].'&emsp;'.$value1['DOB'] }}

							    			<B>({{ date('Y') - date('Y',strtotime($value1['DOB'])) }})</B>
							    		@endif
									</td>

				                    <td class="text-center">

				                    	@if($value1['liveInJapan'] == 1)
				                    		<i class="fa fa-check-square-o" aria-hidden="true"></i>
				                    	@else
				                    		<i class="fa fa-square-o" aria-hidden="true"></i>
				                    	@endif
				                    </td>

				                    @php
				                    	$id1 = '';
				                    	$id1 = $value1['id'];
				                    @endphp

				                    <td class="text-center">
				                    	<a href="javascript:editMember('{{ $id1 }}')">
				                    		<i class="fa fa-pencil-square-o" style="color:red;" aria-hidden="true"></i>
				                    	</a>
				                    </td>
				                </tr>
				            @empty
				                <tr>
				                  <td class="text-center fr" colspan="6">
				                    {{ trans('messages.lbl_nodatafound') }}
				                  </td>
				                </tr>
				            @endforelse
		            </tbody>
		            </table>
				</fieldset>
			@endif

	    	</fieldset>
	    </div>

	    
	</div>
      
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