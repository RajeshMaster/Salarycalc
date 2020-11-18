@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}

{{ HTML::style('resources/assets/css/sidebar-bootstrap.min.css') }}

{{ HTML::script('resources/assets/js/familyvisa.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
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

	.fb{ color: gray !important; }
	
	.sort_asc {
		background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
	}
	.sort_desc {
		background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
	}
	.modal{ background: none !important; }

</style>

<div class="CMN_display_block" id="main_contents">

<!-- article to select the main&sub menu -->

<article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_5">

	{{ Form::open(array('name'=>'familyVisaIndex', 'id'=>'familyVisaIndex', 'url' => 'FamilyVisa/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,

		  'method' => 'POST')) }}


		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}

		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}

		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}

		{{ Form::hidden('sortOptn',$request->familyVisasort , array('id' => 'sortOptn')) }}

	 	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}

	 	{{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}

		<div class="row hline pm0">

		<div class="col-xs-12">

			<img class="pull-left box35 mt15" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">

			<h2 class="pull-left pl5 mt15 CMN_mw150">

					{{ trans('messages.lbl_family_visaDetails') }}

			</h2>

		</div>

	</div>

	<div class="box100per pr10 pl10 mt6">


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

		<div class="box27per pr10 pl10 mt6 pull-right tar">
			
		<!-- <a href="javascript:importpopupenable('{{ $request->mainmenu }}');" style="color:blue;" class="mr10 mt2 pb15 box30">
			<img class="box22 mr7 mb5" src="{{ URL::asset('resources/assets/images/copy.png') }}">{{ trans('messages.lbl_import_expenses') }}
		</a> -->

		{{ Form::select('familyVisasort', $array, $request->familyVisasort,
		                            array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mb15',
		                           'id' => 'familyVisasort',
		                           'name' => 'familyVisasort'))
		                }}
		</div>

	<div class="pt10 minh400">

		<table class="tablealternate CMN_tblfixed">

			<colgroup>

				<col width="4%">

				<col width="11%">

				<col width="30%">

				<col>


			</colgroup>

			<thead class="CMN_tbltheadcolor">

				<tr>

					<th class="vam">{{ trans('messages.lbl_sno') }}</th>

					<th class="vam">{{ trans('messages.lbl_empid') }}</th>

					<th class="vam">{{ trans('messages.lbl_name') }}</th>

					

				</tr>

			</thead>

			<tbody>

				@if(count($empdetails)!="")

	 				@for ($i = 0; $i < count($empdetails); $i++)

						<tr>

							<td class="bor_rightbot_none text-center">

								{{ ($empdetails->currentpage()-1) * $empdetails->perpage() + $i + 1 }}

							</td>

							<td class="tac">
								<a style="color:{{ getEmpIDColor( $empdetails[$i]->Emp_ID ) }};" href="javascript:gotoView('familyvisa','{{ $empdetails[$i]->Emp_ID }}');">
									{{ $empdetails[$i]->Emp_ID }}
								</a>
							</td>

							<td title="{{ empnameontitle($empdetails[$i]->LastName, $empdetails[$i]->FirstName,50) }}">

								{{ empnamelength($empdetails[$i]->LastName, $empdetails[$i]->FirstName,20) }}

							</td>

						</tr>

					@endfor

				@else

						<tr>

							<td class="text-center colred" colspan="7">

								{{ trans('messages.lbl_nodatafound') }}

							</td>

						</tr>

				@endif

			</tbody>

		</table>

	</div>

	<div class="text-center">

		@if(!empty($empdetails->total()))

			<span class="pull-left mt10">

				{{ $empdetails->firstItem() }} ~ {{ $empdetails->lastItem() }} / {{ $empdetails->total() }}

			</span>


			{{ $empdetails->links() }}

			<div class="CMN_display_block flr mr10">

				{{ $empdetails->linkspagelimit() }}

			</div>	

		@endif 
	</div>

		{{ Form::close() }}
		<div id="importpopup" class="modal fade">
		    <div id="login-overlay">
		        <div class="modal-content">
		            <!-- Popup will be loaded here -->
		        </div>
		    </div>
		</div>

</article>

</div>

@endsection