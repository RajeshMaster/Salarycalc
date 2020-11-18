@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp

{{ HTML::script('resources/assets/js/document.js') }}

<script type="text/javascript">
  var datetime = '<?php echo date('Ymdhis'); ?>';
</script>

<style>
	.yrBorder{
		height: 22px !important;
	}
	.sort_asc {
		background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
	}
	.sort_desc {
		background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
	}
</style>

<div class="CMN_display_block" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_6">
		{{ Form::open(array('name'=>'frmdocumentindex', 'id'=>'frmdocumentindex', 'url' => 'Document/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,

		  'method' => 'POST')) }}


		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		
		{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
		{{ Form::hidden('docId', '' , array('id' => 'docId')) }}
		{{ Form::hidden('selYear', $selectedYear, array('id' => 'selYear')) }}

		<div class="row hline pm0">
			<div class="col-xs-12">
				<img class="pull-left box30 mt15 mr5" src="{{ URL::asset('resources/assets/images/contractImg.png') }}">
				<h2 class="pull-left pl5 mt15 CMN_mw150">
					{{ trans('messages.lbl_document') }}
				</h2>
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

		<div class="mt40 mb10">
          {{ Helpers::displayYear($prev_yrs,$cur_year,$total_yrs,$curtime) }}
        </div>

		<div class="pt10 minh340">

			<table class="tablealternate CMN_tblfixed">

				<colgroup>
					<col width="4%">
			        <col width="15%">
			        <col width="10%">
			        <col width="15%">
			        <col width="14%">
				</colgroup>

				<thead class="CMN_tbltheadcolor">
					<tr>
						<th class="vam">{{ trans('messages.lbl_sno') }}</th>
			        	<th class="vam">{{ trans('messages.lbl_document_name') }}</th>
			        	<th class="vam">{{ trans('messages.lbl_registered_date') }}</th>
			        	<th class="vam">{{ trans('messages.lbl_file') }}</th>
			        	<th class="vam">{{ trans('messages.lbl_remarks') }}</th>
					</tr>
				</thead>

				<tbody>

					@if(count($docDetails)!="")

	          			@for ($i = 0; $i < count($docDetails); $i++)

							<tr>
								<td class="text-center">
									{{ $i+1 }}
								</td>
								<td>
									@if($docDetails[$i]['file_name'] != "")
						                <a href="javascript:addedit('1','{{ $docDetails[$i]['docId'] }}');" class="ml5">
							                {{ $docDetails[$i]['docName'] }}
							            </a>
							        @else
							        	<a href="javascript:addedit('0','{{ $docDetails[$i]['docId'] }}');" class="ml5">
							                {{ $docDetails[$i]['docName'] }}
							            </a>
							        @endif
					            </td>

					            <td class="text-center">
					            	{{ $docDetails[$i]['registered_date'] }}
					            </td>

					            <td class="pl20">

					            @if($docDetails[$i]['file_type'] != "")
					            	@if($docDetails[$i]['file_type'] == 3)
					                  {{--*/ $src = '/pdf.png'; /*--}}
					                @else
					                  {{--*/ $src = '/excel_a.png'; /*--}}
					                @endif

					                <a href="javascript:fileDownload('{{ $docDetails[$i]['docId'] }}')" >
					                  <img class="box20 mr10" src="{{ URL::asset('resources/assets/images') }}{{ $src }}">{{ $docDetails[$i]['file_name'] }}
					                </a>
					            @endif

					            </td>

					            <td class="pl20">
					            	{{ $docDetails[$i]['remarks'] }}
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

			

		</div>

		{{ Form::close() }}

		{{ Form::open(array('name'=>'frmdwnld',
              'id'=>'frmdwnld',
              'url' => 'Document/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
              'files'=>true,
              'method' => 'POST')) }}
	    {{ Form::hidden('id', '' , array('id' => 'id')) }}
	    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	    {{ Form::hidden('selYear', $selectedYear, array('id' => 'selYear')) }}
	    {{ Form::close() }}

	</article>
</div>
@endsection