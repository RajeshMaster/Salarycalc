@extends('layouts.app')

@section('content')
@php use App\Http\eradate @endphp

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/family.js') }}

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

	{{ Form::open(array('name'=>'index', 'id'=>'index', 'url' => 'Family/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,
		  'method' => 'POST')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('sortOptn',$request->familysort , array('id' => 'sortOptn')) }}
	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	 	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}

	 	{{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}

		<div class="row hline pm0">

		<div class="col-xs-12">

			<img class="pull-left box35 mt15 mr10" src="{{ URL::asset('resources/assets/images/family.png') }}">

			<h2 class="pull-left pl5 mt15 CMN_mw150">

					{{ trans('messages.lbl_family_details') }}

			</h2>

		</div>

	</div>
		
		<div class="box100per pr10 pl10 mt6 pull-right tar" id="importLink" style="<?php echo $sortMargin; ?>">

			@if(Session::has('success'))
				<div align="center" class="alertboxalign mt5" role="alert">
					<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
		            {{ Session::get('success') }}
		          	</p>
				</div>
			@endif

			<span>
				<a href="javascript:importpopupenable('{{ $request->mainmenu }}');" style="color:blue;" class="mr10 pb15 box30"><img class="box22 mr7 mb5" src="{{ URL::asset('resources/assets/images/copy.png') }}">{{ trans('messages.lbl_import_expenses') }}</a>
				
			</span>

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
			<col width="10%">
	        <col width="18%">
	        <col width="23%">
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

    	<!-- For employee list wise -->
	    @forelse($empArrVal as $count => $data)

	    	@if(isset($familydata[$data->Emp_ID]))

	    		@php 
	    			$temp = '';
	    			$i = 1; 
					$j = 1; 
					$k = 1; 
					$l = 1;
	    		@endphp

	    		<!-- For Each Employee Family -->
		    	@foreach($familydata[$data->Emp_ID] as $key => $value)
		    	
			    	@php 
		    			$loc = $value['Emp_ID']; 
		    		@endphp

		    		@if($value['relationType'] == 5 && (date('Y') - date('Y',strtotime($value['DOB'])) > 21 ))
		    			<?php continue; ?>
		    		@endif

		    		@if($value['relationType'] == 6 && (date('Y') - date('Y',strtotime($value['DOB'])) > 21 ))
		    			<?php continue; ?>
		    		@endif

		    		@if($value['relationType'] == 3 || $value['relationType'] == 4)
		    			<?php continue; ?>
		    		@endif

		    		<tr @if ($count+1 & 1)
		       			@else 
		       				class="alternatebg_fam_color" 
		       			@endif>

			          	<td class="bor_rightbot_none text-center">
			          		@if($temp != $loc)
		    					{{ ($empArrVal->currentpage()-1) * $empArrVal->perpage() + $count + 1 }}
		    				@endif
		    			</td>

		    			<td class="bor_none text-center">

		    				@if($temp != $loc)

		    				<a href="javascript:gotoFamilyView('family','{{ $value['Emp_ID'] }}');" style="color:{{ getEmpIDColor( $value['Emp_ID'] ) }}">
			    				{{ $value['Emp_ID'] }}
		    				</a>

		    				@endif

			    		</td>

	    				<td class="bor_none" style="text-transform: uppercase;">
	    					@if($temp != $loc)
				    			{{ mb_substr($data->LastName,0,20,'utf-8') }}.
				    			{{ mb_substr($data->FirstName,0,1,'utf-8') }}
				    		@endif
		    			</td>

		    			<td>
		    				@if($value['relationType'] == 5)
		    					{{ $relationArr[$value['relationType']].' '.$i }}
		    						<?php $i++ ?>
		    				@elseif($value['relationType'] == 6)
		    					{{ $relationArr[$value['relationType']].' '.$j }}
		    						<?php $j++ ?>
		    				@elseif($value['relationType'] == 8)
		    					{{ $relationArr[$value['relationType']].' '.$k }}
		    						<?php $k++ ?>
		    				@elseif($value['relationType'] == 9)
		    					{{ $relationArr[$value['relationType']].' '.$l }}
		    						<?php $l++ ?>
		    				@else
		    					{{ $relationArr[$value['relationType']] }}
		    				@endif
		    			</td> 

		    			<td title="{{ $value['FirstName'].' '.$value['LastName'] }}">
		    				<!-- {{ singlefieldlength($value['FirstName'].' '.$value['LastName'],23) }} -->
		    				{{ singlefieldlength($value['LastName'],23) }}
		    			</td>

		    			<td title="{{ $value['Kana_FirstName'].' '.$value['Kana_LastName'] }}">
		    				<!-- {{ singlefieldlength($value['Kana_FirstName'].' '.$value['Kana_LastName'],18) }} -->
		    				{{ singlefieldlength($value['Kana_LastName'],15) }}
		    			</td>

			    		<td>
			    			@if( $value['DOB']=="0000-00-00" || $value['DOB']=="")
				    		@else

				    			@php
					    			$dob_eraDate = getEraDate($value['DOB']);
								@endphp

				    			{{ $dob_eraDate['japerainjap'].'&emsp;'.$dob_eraDate['japeraineng'].'&emsp;'.$value['DOB'] }}

				    			<B>({{ date('Y') - date('Y',strtotime($value['DOB'])) }})</B>
				    		@endif
			    		</td>

			        </tr>
			        @php 
			        	$temp = $loc;
			        @endphp

			    @endforeach

		   	@else
		    		<tr @if ($count+1 & 1)
		       			@else 
		       				class="alternatebg_fam_color" 
		       			@endif>
			          	<td class="bor_rightbot_none text-center">
		       				{{ ($empArrVal->currentpage()-1) * $empArrVal->perpage() + $count + 1 }}
		       			</td>

		    			<td class="bor_none text-center">
			    			<a href="javascript:gotoFamilyView('family','{{ $data->Emp_ID }}');" style="color:{{ getEmpIDColor( $data->Emp_ID ) }}">
			    				{{ $data->Emp_ID }}
		    				</a>
			    		</td>
			    		<td class="bor_none" style="text-transform: uppercase;">
			    			{{ mb_substr($data->LastName,0,20,'utf-8') }}.
			    			{{ mb_substr($data->FirstName,0,1,'utf-8') }}
		    			</td>
		    			<td></td>
		    			<td></td>
		    			<td></td>
		    			<td></td>
			        </tr>
			@endif

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