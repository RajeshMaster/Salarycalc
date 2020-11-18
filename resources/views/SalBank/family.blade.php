@extends('layouts.app')

@section('content')
@php use App\Http\eradate @endphp

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/salbank.js') }}

{{ HTML::style('resources/assets/css/sidebar-bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/switch.js') }}
{{ HTML::script('resources/assets/js/hoe.js') }}
{{ HTML::style('resources/assets/css/extra.css') }}
{{ HTML::style('resources/assets/css/hoe.css') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

<script type="text/javascript">
    $(document).ready(function() {
	    var singlesearch = document.getElementById("singlesearch");
	    singlesearch.addEventListener("keyup", function(event) {
		    if (event.keyCode === 13) {
		        event.preventDefault();
		        document.getElementById("advsearch").click();
		   	}
	    });
    });
  </script> 

<script type="text/javascript">

	var datetime = '<?php echo date('Ymdhis'); ?>';
	function mulclick(divid){
	     if($('#'+divid).css('display') == 'block'){
	      document.getElementById(divid).style.display = 'none';
	      document.getElementById(divid).style.height= "240px";
	    }else {
	      document.getElementById(divid).style.display = 'block';
	    }
   }
</script>

<style type="text/css">

	.alertboxalign {
    	margin-bottom: -50px !important;
	}

	.alert {
	    display:inline-block !important;
	    height:30px !important;
	    padding:5px !important;
	}

	.fb{
		color: gray !important;
	}
	.sort_asc {
		background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
	}
	.sort_desc {
		background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
	}

	table { border-bottom: 1px solid #ddd ! important }
	table tr { background-color: white !important; }

	.alternatebg_fam_color{background: #e5f4f9 !important;}

	.bor_rightbot_none {
		border-bottom: none ! important;
  		border-top: none ! important;
  	}

  	.bor_none {border:none ! important; border-right: 1px solid #ddd ! important;}

</style>

<div class="CMN_display_block" id="main_contents">

<!-- article to select the main&sub menu -->

<article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_4">

	{{ Form::open(array('name'=>'familyIndex', 'id'=>'familyIndex', 'url' => 'SalBank/familyIndex?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,
		  'method' => 'POST')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('sortOptn',$request->familysort , array('id' => 'sortOptn')) }}
	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	 	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}

		<div class="row hline pm0">

		<div class="col-xs-12">

			<img class="pull-left box35 mt15 mr10" src="{{ URL::asset('resources/assets/images/family.png') }}">

			<h2 class="pull-left pl5 mt15 CMN_mw150">

					{{ trans('messages.lbl_family_details') }}

			</h2>

		</div>

	</div>

	<div class="box100per pr10 pl10 mt6">

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
		<div class="box27per pr10 pl10 mt6 pull-right tar" id="importLink" style="<?php echo $sortMargin; ?>">

		{{ Form::select('familysort', $array, $request->familysort,
		                            array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mb10',
		                           'id' => 'familysort',
		                           'name' => 'familysort'))
		                }}
		</div>

	<div class="pt10 minh400">

		<table class="tablealternate CMN_tblfixed">
       	<colgroup>
	       	<col width="4%">
	        <col width="7%">
			<col>
			<col width="12%">
	        <col width="20%">
	        <col width="20%">
	        <col width="18%">
       	</colgroup>
       	<thead class="CMN_tbltheadcolor">
       		<tr>
       			<th style="vertical-align: middle;">{{ trans('messages.lbl_sno') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_empid') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_empName') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_relation') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_name') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_kananame') }}</th>
	            <th style="vertical-align: middle;">{{ trans('messages.lbl_dob') }}</th>
       		</tr>
       	</thead>
       	<tbody>
        @forelse($familydata as $count => $data)
       		<tr @if ($count+1 & 1)
       			@else 
       				class="alternatebg_fam_color" 
       			@endif>
       			<td class="bor_rightbot_none text-center">
       				{{ ($familydata->currentpage()-1) * $familydata->perpage() + $count + 1 }}
       			</td>
	    		<td class="bor_none text-center">
	    			<a href="javascript:;" style="color:{{ getEmpIDColor( $data->Emp_ID ) }}">
	    				{{ $data->Emp_ID }}
    				</a>
				</td>
	    		<td class="bor_none" style="text-transform: uppercase;">
	    			{{ mb_substr($data->LastName,0,20,'utf-8') }}.
	    			{{ mb_substr($data->FirstName,0,1,'utf-8') }}
    			</td>
			    <td class="pl10">
			    	{{ trans('messages.lbl_father') }}
		    	</td>
	    		<td title="{{ $data->FatherName }}">
	    			{{ singlefieldlength($data->FatherName,23) }}
				</td>
	    		<td title="{{ $data->FatherkanaName }}">
    				{{ singlefieldlength($data->FatherkanaName,12) }}
				</td>
	    		<td class="text-center">
	    		@if( $data->FatherDOB=="0000-00-00" || $data->FatherDOB=="")
	    		@else

	    			@php
		    			$F_DOB_eraDate = getEraDate($data->FatherDOB);
					@endphp

	    			{{ $F_DOB_eraDate['japerainjap'].'&emsp;'.$F_DOB_eraDate['japeraineng'].'&emsp;'.$data->FatherDOB }}

	    			<B>({{ date('Y') - date('Y',strtotime($data->FatherDOB)) }})</B>
	    		@endif
	    		</td>
	    		
       		</tr>
       		<tr @if ($count+1 & 1)
       			@else 
       				class="alternatebg_fam_color" 
       			@endif>
       			<td class="bor_rightbot_none"></td>
	    		<td class="bor_none"></td>
	    		<td class="bor_none"></td>
			    <td class="pl10">
			    	{{ trans('messages.lbl_mother') }}
		    	</td>
	    		<td title="{{ $data->MotherName }}">
	    			{{ singlefieldlength($data->MotherName,23) }}
    			</td>
	    		<td title="{{ $data->MotherkanaName }}">
	    			{{ singlefieldlength($data->MotherkanaName,12) }}
    			</td>
	    		<td class="text-center">
	    		@if( $data->MotherDOB=="0000-00-00" || $data->MotherDOB=="")
	    		@else
	    			@php
		    			$M_DOB_eraDate = getEraDate($data->MotherDOB);
					@endphp

	    			{{ $M_DOB_eraDate['japerainjap'].'&emsp;'.$M_DOB_eraDate['japeraineng'].'&emsp;'.$data->MotherDOB }}

	    			<B>({{ date('Y') - date('Y',strtotime($data->MotherDOB)) }})</B>
    			@endif
	    		</td>
	    		
       		</tr>
       		
       		@for($i=1;$i<=$data->YoungerBrother;$i++)

       			@if(date('Y') - date('Y',strtotime($data->{'YoungerBrother'.$i.'DOB'})) < 21 )

		       		<tr @if ($count+1 & 1)
		       			@else 
		       				class="alternatebg_fam_color" 
		       			@endif>
		       			<td class="bor_rightbot_none"></td>
			    		<td class="bor_none"></td>
			    		<td class="bor_none"></td>
					    <td class="pl10">
					    	{{ trans('messages.lbl_youngerBrother') }} {{ $i }}
				    	</td>
			    		<td title="{{ $data->{'YoungerBrother'.$i.'Name'} }}">
			    			{{ singlefieldlength($data->{'YoungerBrother'.$i.'Name'},23) }}
		    			</td>
			    		<td title="{{ $data->{'YoungerBrother'.$i.'KanaName'} }}">
			    			{{ singlefieldlength($data->{'YoungerBrother'.$i.'KanaName'},12) }}
		    			</td>
			    		<td class="text-center">
			    		@if( $data->{'YoungerBrother'.$i.'DOB'}=="0000-00-00" || $data->{'YoungerBrother'.$i.'DOB'}=="")
			    		@else
			    			@php
			    				$YB_DOB_eraDate = '';
				    			$YB_DOB_eraDate = getEraDate($data->{'YoungerBrother'.$i.'DOB'});
							@endphp

			    			{{ $YB_DOB_eraDate['japerainjap'].'&emsp;'.$YB_DOB_eraDate['japeraineng'].'&emsp;'.$data->{'YoungerBrother'.$i.'DOB'} }}

			    			<B>({{ date('Y') - date('Y',strtotime($data->{'YoungerBrother'.$i.'DOB'})) }})</B>
		    			@endif
			    		</td>
			    		
		       		</tr>
		       	@endif
       		@endfor
       		
       		@for($i=1;$i<=$data->YoungerSister;$i++)

       			@if(date('Y') - date('Y',strtotime($data->{'YoungerSister'.$i.'DOB'})) < 21 )
		       		<tr @if ($count+1 & 1)
		       			@else 
		       				class="alternatebg_fam_color" 
		       			@endif>
		       			<td class="bor_rightbot_none"></td>
			    		<td class="bor_none"></td>
			    		<td class="bor_none"></td>
					    <td class="pl10">
					    	{{ trans('messages.lbl_youngerSister') }} {{ $i }}
				    	</td>
			    		<td title="{{ $data->{'YoungerSister'.$i.'Name'} }}">
			    			{{ singlefieldlength($data->{'YoungerSister'.$i.'Name'},23) }}
		    			</td>
			    		<td title="{{ $data->{'YoungerSister'.$i.'KanaName'} }}">
			    			{{ singlefieldlength($data->{'YoungerSister'.$i.'KanaName'},12) }}
		    			</td>
			    		<td class="text-center">
			    		@if( $data->{'YoungerSister'.$i.'DOB'}=="0000-00-00" || $data->{'YoungerSister'.$i.'DOB'}=="")
			    		@else
			    			@php
			    				$YS_DOB_eraDate = '';
				    			$YS_DOB_eraDate = getEraDate($data->{'YoungerSister'.$i.'DOB'});
							@endphp

			    			{{ $YS_DOB_eraDate['japerainjap'].'&emsp;'.$YS_DOB_eraDate['japeraineng'].'&emsp;'.$data->{'YoungerSister'.$i.'DOB'} }}

			    			<B>({{ date('Y') - date('Y',strtotime($data->{'YoungerSister'.$i.'DOB'})) }})</B>
		    			@endif
			    		</td>
			    		
		       		</tr>
		       	@endif

       		@endfor

       		<!-- @if(isset($data->wifeName))
	       		<tr @if ($count+1 & 1)
	       			@else 
	       				class="alternatebg_fam_color" 
	       			@endif>
	       			<td class="bor_rightbot_none"></td>
		    		<td class="bor_none"></td>
		    		<td class="bor_none"></td>
				    <td class="pl10">
				    	{{ trans('messages.lbl_wife') }}
			    	</td>
		    		<td title="{{ $data->MotherName }}">
		    			{{ singlefieldlength($data->wifeName,23) }}
	    			</td>
		    		<td title="{{ $data->MotherkanaName }}">
		    			{{ singlefieldlength($data->wifeKanaName,12) }}
	    			</td>
		    		<td class="text-center">
		    		@if( $data->wifeDOB=="0000-00-00" || $data->wifeDOB=="")
		    		@else
		    			@php
			    			$W_DOB_eraDate = getEraDate($data->wifeDOB);
						@endphp

		    			{{ $W_DOB_eraDate['japerainjap'].'&emsp;'.$W_DOB_eraDate['japeraineng'].'&emsp;'.$data->wifeDOB }}

		    			<B>({{ date('Y') - date('Y',strtotime($data->wifeDOB)) }})</B>
	    			@endif
		    		</td>
		    		
	       		</tr>
	       	@endif

	       	@if(isset($data->daughterName))
	       		<tr @if ($count+1 & 1)
	       			@else 
	       				class="alternatebg_fam_color" 
	       			@endif>
	       			<td class="bor_rightbot_none"></td>
		    		<td class="bor_none"></td>
		    		<td class="bor_none"></td>
				    <td class="pl10">
				    	{{ trans('messages.lbl_daughter') }}
			    	</td>
		    		<td title="{{ $data->MotherName }}">
		    			{{ singlefieldlength($data->daughterName,23) }}
	    			</td>
		    		<td title="{{ $data->MotherkanaName }}">
		    			{{ singlefieldlength($data->daughterKanaName,12) }}
	    			</td>
		    		<td class="text-center">
		    		@if( $data->daughterDOB=="0000-00-00" || $data->daughterDOB=="")
		    		@else
		    			@php
			    			$D_DOB_eraDate = getEraDate($data->daughterDOB);
						@endphp

		    			{{ $D_DOB_eraDate['japerainjap'].'&emsp;'.$D_DOB_eraDate['japeraineng'].'&emsp;'.$data->daughterDOB }}

		    			<B>({{ date('Y') - date('Y',strtotime($data->daughterDOB)) }})</B>
	    			@endif
		    		</td>
		    		
	       		</tr>
	       	@endif

	       	@if(isset($data->sonName))
	       		<tr @if ($count+1 & 1)
	       			@else 
	       				class="alternatebg_fam_color" 
	       			@endif>
	       			<td class="bor_rightbot_none"></td>
		    		<td class="bor_none"></td>
		    		<td class="bor_none"></td>
				    <td class="pl10">
				    	{{ trans('messages.lbl_son') }}
			    	</td>
		    		<td title="{{ $data->MotherName }}">
		    			{{ singlefieldlength($data->sonName,23) }}
	    			</td>
		    		<td title="{{ $data->MotherkanaName }}">
		    			{{ singlefieldlength($data->sonKanaName,12) }}
	    			</td>
		    		<td class="text-center">
		    		@if( $data->sonDOB=="0000-00-00" || $data->sonDOB=="")
		    		@else
		    			@php
			    			$S_DOB_eraDate = getEraDate($data->sonDOB);
						@endphp

		    			{{ $S_DOB_eraDate['japerainjap'].'&emsp;'.$S_DOB_eraDate['japeraineng'].'&emsp;'.$data->sonDOB }}

		    			<B>({{ date('Y') - date('Y',strtotime($data->sonDOB)) }})</B>
	    			@endif
		    		</td>
		    		
	       		</tr>
	       	@endif -->

       		@empty
	        <tr>
	          <td class="text-center" colspan="7" style="color: red;">
	            {{ trans('messages.lbl_nodatafound') }}
	          </td>
	        </tr>
       	@endforelse
       </tbody>
    </table>

	</div>

	<div class="text-center">

		@if(!empty($familydata->total()))

			<span class="pull-left mt10">

				{{ $familydata->firstItem() }} ~ {{ $familydata->lastItem() }} / {{ $familydata->total() }}

			</span>


			{{ $familydata->links() }}

			<div class="CMN_display_block flr mr10">

				{{ $familydata->linkspagelimit() }}

			</div>	

		@endif 

	</div>

	<!-- SEARCH -->
        <div style="top: 136px!important;position: fixed;" 
        	@if ($request->searchmethod == 1 || $request->searchmethod == 2) 
                    	class="open CMN_fixed pm0" 
                   	@else 
                    	class="CMN_fixed pm0 pr0" 
                   	@endif 
                    	id="styleSelector">
        	<div class="selector-toggle">
              	<a id="sidedesignselector" href="javascript:void(0)"></a>
          	</div>
          	 <ul>
              <span>
                  <li style="">
                      <p class="selector-title">{{ trans('messages.lbl_search') }}</p>
                  </li>
              </span>
                <li class="theme-option ml6">
                  <div class="box100per mt5"  onKeyPress="return checkSubmitsingle(event)">


                    {!! Form::text('singlesearch', $request->singlesearch,
                          array('','class'=>' form-control ml2 box60per','style'=>'height:30px;','id'=>'singlesearch')) !!}

                    {{ Form::button('<i class="fa fa-search" aria-hidden="true"></i>', 
                        array('class'=>'ml2 search box15per btn btn-info btn-sm', 
                              'type'=>'button',
                              'name' => 'advsearch',
                              'id' => 'advsearch',
                              'onclick' => 'javascript:usinglesearch();',
                              'style'=>'border: none;' 
                              )) }}
                  	<a href="javascript:clearsearch()" title="Clear Search" class="pull-left">
		            	<img class="box30" src="{{ URL::asset('resources/assets/images/clearsearch.png') }}">
		          	</a>
                    <br>          
                  <div>
                </li>
            </ul>
            
        </div>

		{{ Form::close() }}

</article>

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