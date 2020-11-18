@extends('layouts.app')

@section('content')
@php use App\Http\eradate @endphp

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/EsiMyNo.js') }}

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

<article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_5">

	{{ Form::open(array('name'=>'esiMyNoIndex', 'id'=>'esiMyNoIndex', 'url' => 'EsiMyNo/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,
		  'method' => 'POST')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('sortOptn',$request->familysort , array('id' => 'sortOptn')) }}
	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	 	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
	 	
	 	{{ Form::hidden('editFlg', "", array('id' => 'editFlg')) }}
	 	{{ Form::hidden('Emp_ID', "" , array('id' => 'Emp_ID')) }}

		<div class="row hline pm0">

		<div class="col-xs-12">

			<img class="pull-left box35 mt15 mr10" src="{{ URL::asset('resources/assets/images/insurance.png') }}">

			<h2 class="pull-left pl5 mt15 CMN_mw150">
					{{ trans('messages.lbl_esi_mynoDetails') }}
			</h2>

		</div>

	</div>
		
		@if(Session::has('message'))
			<div align="center" class="alertboxalign mt5" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
	            {{ Session::get('message') }}
	          	</p>
			</div>
		@endif
		<div class="box100per pr10 pl10 mt10 pull-right tar" id="importLink" style="<?php echo $sortMargin; ?>">


			{{ Form::select('esiMyNoSort', $array, $request->esiMyNoSort,
	                           array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mb10',
	                           'id' => 'esiMyNoSort',
	                           'name' => 'esiMyNoSort'))
	                }}

	        
		</div>

	<div class="pt10 minh400">

		<table class="tablealternate CMN_tblfixed">
       	<colgroup>
	       	<col width="4%">
	        <col width="7%">
			<col>
			<col width="20%">
	        <col width="12%">
	        <col width="23%">
       	</colgroup>
       	<thead class="CMN_tbltheadcolor">
       		<tr>
       			<th class="text-center">{{ trans('messages.lbl_sno') }}</th>
	            <th class="text-center">{{ trans('messages.lbl_empid') }}</th>
	            <th class="text-center">{{ trans('messages.lbl_empName') }}</th>
	            <th class="text-center">{{ trans('messages.lbl_myno') }}</th>
	            <th class="text-center">{{ trans('messages.lbl_esi_regdate') }}</th>
	            <th class="text-center">{{ trans('messages.lbl_esi_no') }}</th>
       		</tr>
       	</thead>
       	<tbody>

       		@if(count($esiMyNoData)!="")

      			@for ($i = 0; $i < count($esiMyNoData); $i++)

					<tr>
						<td class="text-center">
							{{ $i+1 }}
						</td>
						<td class="text-center">

							@if($esiMyNoData[$i]['myNo'] == "" && $esiMyNoData[$i]['esiRegDate'] == "" && $esiMyNoData[$i]['esiNo'] == "")
				                <a href="javascript:addEdit('0','{{ $esiMyNoData[$i]['Emp_ID'] }}');"  style="color:{{ getEmpIDColor( $esiMyNoData[$i]['Emp_ID'] ) }}">
					                {{ $esiMyNoData[$i]['Emp_ID'] }}
					            </a>
					        @else
					        	<a href="javascript:addEdit('1','{{ $esiMyNoData[$i]['Emp_ID'] }}');"  style="color:{{ getEmpIDColor( $esiMyNoData[$i]['Emp_ID'] ) }}">
					                {{ $esiMyNoData[$i]['Emp_ID'] }}
					            </a>
					        @endif
			            </td>

			            <td class="pl10" style="text-transform: uppercase;">
			    			{{ mb_substr($esiMyNoData[$i]['LastName'],0,20,'utf-8') }}.
			    			{{ mb_substr($esiMyNoData[$i]['FirstName'],0,1,'utf-8') }}
		    			</td>

			            <td class="text-center">
							{{ $esiMyNoData[$i]['myNo'] }}
						</td>

			            <td class="text-center">
			            	@if($esiMyNoData[$i]['esiRegDate'] != "0000-00-00")
								{{ $esiMyNoData[$i]['esiRegDate'] }}
							@endif
						</td>

						<td class="text-center">
							{{ $esiMyNoData[$i]['esiNo'] }}
						</td>

					</tr>
				 @endfor

	        @else
	            <tr>
	              <td class="text-center colred" colspan="5">
	                {{ trans('messages.lbl_nodatafound') }}
	              </td>
	            </tr>
	        @endif

    	
       </tbody>
    </table>

	</div>

	<div class="text-center">

		@if(!empty($empArrVal->total()))

			<span class="pull-left mt10">

				{{ $empArrVal->firstItem() }} ~ {{ $empArrVal->lastItem() }} / {{ $empArrVal->total() }}

			</span>


			{{ $empArrVal->links() }}

			<div class="CMN_display_block flr mr10">

				{{ $empArrVal->linkspagelimit() }}

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

<div id="importpopup" class="modal fade">
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