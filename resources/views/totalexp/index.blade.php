@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script('resources/assets/js/totexp.js') }}


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
	<article id="expenses" class="DEC_flex_wrapper " data-category="staffexpenses totexp_sub_1">
		{{ Form::open(array('name'=>'totalexpform', 'id'=>'totalexpform', 'url' => 'totalexp/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}

        {{ csrf_field() }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
        {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
        {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
        {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
        {{ Form::hidden('parentmonth', $request->parentmonth , array('id' => 'parentmonth')) }}
        {{ Form::hidden('parentyr', $request->parentyr , array('id' => 'parentyr')) }}
        {{ Form::hidden('totexpcount', $request->totexpcount , array('id' => 'totexpcount')) }}
        {{ Form::hidden('revertcondloc', '' , array('id' => 'revertcondloc')) }}
        {{ Form::hidden('revertcondexp', '' , array('id' => 'revertcondexp')) }}
        {{ Form::hidden('totcount', '1' , array('id' => 'totcount')) }}
        {{ Form::hidden('totexpind', '1' , array('id' => 'totexpind')) }}
        {{ Form::hidden('empid', ' ' , array('id' => 'empid')) }}
        {{ Form::hidden('traexpid', ' ' , array('id' => 'traexpid')) }}
        {{ Form::hidden('sortOrder',$request->sortOrder , array('id' => 'sortOrder')) }}
        <input type="hidden" id="sortOptn" value="<?php echo $request->expsort ?>">
        <input type="hidden" name="pass_date" id="pass_date" value="<?php echo $pass_date; ?>">

		<!-- Start Heading -->
		<div class="row hline pm0">
			<div class="col-xs-12">
				<img class="pull-left box40 mt5" src="{{ URL::asset('resources/assets/images/totalexpenses.png') }}">
				<h2 class="pull-left pl5 mt10">
					{{ trans('messages.lbl_total_expenses') }}
				</h2>
			</div>
		</div>
		<!-- End Heading -->
		<br>	
		<div class="mt10 mb10">
			{{ Helpers::displayYear_Month($prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime) }}
		</div>
		<div class="box100per pr10 pl10">
			<div class="form-group pull-right moveleft nodropdownsymbol mt5" id="moveleft">
            	{{ Form::select('expsort', $sortarray, $request->expsort,
                          array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
                              'id' => 'expsort',
                              'name' => 'expsort')) }}
          	</div>
			@if(Session::has('success'))
				<div align="center" class="alertboxalign mt5" role="alert">
					<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
		            {{ Session::get('success') }}
		          	</p>
				</div>
			@endif

		</div>

	<div class="minheight300">
		<table id="multiadd_table" class="tablealternate box100per mt10">
			<colgroup>
				<col width="6%">
				<col width="10%">
				<col width="44%">
				<col width="12%">
				<col width="12%">
				<col width="12%">
				<col width="12%">
				<col width="12%">
			</colgroup>
			<thead id="multiadd_thead"  class="CMN_tbltheadcolor">
				<tr>
				  <th class="vam sticky w_1 multiadd_th">{{ trans('messages.lbl_sno') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_empid') }}</th>
				  <th class="vam sticky2 multiadd_th" style="min-width: 205px;">{{ trans('messages.lbl_name') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_travel') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_expenses') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_totamt') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th" style="background-color: #f9cd88">{{ trans('messages.lbl_train_daily') }}</th>
				  <th class="vam sticky1 w_2 multiadd_th" style="background-color: #f9cd88">{{ trans('messages.lbl_Others') }}</th>
				</tr>
			</thead>
			<tbody>
				<tbody>
	            {{--*/ $traveltot = '0' /*--}}
	            {{--*/ $expensetot = '0' /*--}}
	            {{--*/ $bothtot = '0' /*--}}
	            @if($empdetails)
	            @for ($i = 0; $i < count($empdetails); $i++)
	            <tr>
	              <td class="text-center">
	                {{ $i + $employees->firstItem() }}
	              </td>
	              
	              <td class="text-center">
	              	<span style="color:{{ getEmpIDColor( $empdetails[$i]['Emp_ID'] ) }}">
		              {{ $empdetails[$i]['Emp_ID'] }} 
		            </span>
	                {{ Form::hidden('empiddb'.$i, $empdetails[$i]['Emp_ID'] , array('id' => 'empiddb'.$i)) }}
	              </td> 
	              <td class="text-left" @if(strlen($empdetails[$i]['LastName']) > 32))
		              title="{{ empnamelength($empdetails[$i]['LastName'], $empdetails[$i]['FirstName'], 150) }}" @endif> 
		                {{ empnamelength($empdetails[$i]['LastName'], $empdetails[$i]['FirstName'], 32) }}
	              </td>
		          <td class="text-right" @if(isset($empdetails[$i]['grandtotalloc'])) @if($empdetails[$i]['grandtotalloc'] > 0 ) style="color:blue" @endif @endif> 
		                @if(isset($empdetails[$i]['grandtotalloc']) && $empdetails[$i]['grandtotalloc'] != "0") 
		                  {{--*/ $traveltot += $empdetails[$i]['grandtotalloc'] /*--}}
		                  <a href="javascript:gototravel('{{ $empdetails[$i]['Emp_ID'] }}');" style="text-decoration:none;color:blue;">{{ number_format($empdetails[$i]['grandtotalloc']) }}</a>
		                @else
		                  {{ $empdetails[$i]['grandtotalloc'] = "0" }}
		                @endif 
	              </td>
	              <td class="text-right" @if(isset($empdetails[$i]['grandtotalex']))  @if($empdetails[$i]['grandtotalex'] > 0 ) style="color:blue" @endif  @endif> 
	                @if(isset($empdetails[$i]['grandtotalex']) && $empdetails[$i]['grandtotalex'] != "0")
	                  {{--*/ $expensetot += $empdetails[$i]['grandtotalex'] /*--}}
	                  <a href="javascript:gotoexpense('{{ $empdetails[$i]['Emp_ID'] }}');" style="text-decoration:none;color:blue;">{{ number_format($empdetails[$i]['grandtotalex']) }}</a>
	                @else 
	                 {{ $empdetails[$i]['grandtotalex'] = "0" }} 
	                @endif
	              </td>
	              <td class="text-right">
	                  {{--*/ $bothtot = '0' /*--}}
	                @if(isset($empdetails[$i]['grandtotalloc'])) 
	                  {{--*/ $bothtot += $empdetails[$i]['grandtotalloc'] /*--}}
	                @endif 
	                @if(isset($empdetails[$i]['grandtotalex'])) 
	                  {{--*/ $bothtot += $empdetails[$i]['grandtotalex']  /*--}}
	                @endif 
	                  {{ number_format($bothtot) }}
	              </td>

	              <!-- Data from SalaryCalc Registration Start - Madasamy 07/09  -->
	              @php 
	              		$salaryTrvAmt = ($empdetails[$i]['sal_train_daily'] > 0) ? $empdetails[$i]['sal_train_daily'] : 0;
	              		$salaryExpAmt = ($empdetails[$i]['sal_others'] > 0) ? $empdetails[$i]['sal_others'] : 0;
	              @endphp

		              @if($salaryTrvAmt != $empdetails[$i]['grandtotalloc'])
			              <td class="text-right" style="color: red;font-weight: bold;">
	           		  @else
		          	  	  <td class="text-right">
		              @endif
			            	{{ number_format($salaryTrvAmt) }}

			               	</td>

			          @if($salaryExpAmt != $empdetails[$i]['grandtotalex'])
			              <td class="text-right" style="color: red;font-weight: bold;">
	           		  @else
		          	  	  <td class="text-right">
		              @endif
			            	{{ number_format($salaryExpAmt) }}

			               	</td>
			       <!-- Data from SalaryCalc Registration End - Madasamy 07/09  -->

	            </tr>

	            @if($i == (count($empdetails)-1) )
	              <tr class="bg_lightgrey" style="font-weight:bold;">
	                <td colspan="3" class="text-right">{{ trans('messages.lbl_totamt') }}</td>
	                <td class="text-right">{{ number_format($fetchloctraveltot[0]->grandtotals) }}</td>
	                <td class="text-right">{{ number_format($fetchexptot[0]->expgrandtotals) }}</td>
	                <td class="text-right">
	                    {{--*/ $traexptot = $fetchloctraveltot[0]->grandtotals+$fetchexptot[0]->expgrandtotals /*--}}
	                    {{ number_format($traexptot) }}
	                </td>

	                <!-- Data from SalaryCalc Registration Start - Madasamy 07/09  -->
	                @php

	              		$salaryTrvTotalAmt = (isset($salaryTrvTotal[0]->train_dailyTot)) ? $salaryTrvTotal[0]->train_dailyTot : 0;
	              		$salaryExpTotalAmt = (isset($salaryExpTotal[0]->othersTot)) ? $salaryExpTotal[0]->othersTot : 0;
	
		            @endphp

		           	@if($salaryTrvTotalAmt != $fetchloctraveltot[0]->grandtotals)
		              <td class="text-right" style="color: red;font-weight: bold;background-color: #f9cd88">
		            @else
		          	  <td class="text-right" style="background-color: #f9cd88">
		            @endif
		            	{{ number_format($salaryTrvTotalAmt) }}

		               	</td>

		            @if($salaryExpTotalAmt != $fetchexptot[0]->expgrandtotals)
		              <td class="text-right" style="color: red;font-weight: bold;background-color: #f9cd88">
		            @else
		          	  <td class="text-right" style="background-color: #f9cd88">
		            @endif
		            	{{ number_format($salaryExpTotalAmt) }}
	                	</td>
					<!-- Data from SalaryCalc Registration End - Madasamy 07/09  -->

	                <td colspan="2" style="background-color: white;border-color: white;"></td>
	              </tr>
	            @endif
	            @endfor
	            @else
	            <tr>
	              <td class="text-center fr" colspan="8">
	                {{ trans('messages.lbl_nodatafound') }}
	              </td>
	            </tr>
	            @endif
			</tbody>
		</table>
	</div>	
	<div class="text-center">
        @if(!empty($employees->total()))
           <span class="pull-left mt24 ml15">{{ $employees->firstItem() }} ~ {{ $employees->lastItem() }} / {{ $totexpcount }}</span>
        {{ $employees->links() }}
	        <div class="CMN_display_block flr">
	        	{{ $employees->linkspagelimit() }}
	        </div>
         @endif 
     </div>
			
	{{ Form::close() }}

	</article>
</div>
@endsection