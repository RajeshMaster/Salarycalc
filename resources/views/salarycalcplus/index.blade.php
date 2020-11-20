@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script('resources/assets/js/salarycalcplus.js') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	$(document).ready(function() {

		$('#salarycalcindex input[type=checkbox]').attr('checked',false); 

  		var ht;
  		var lastWindowHeight = $(window).height();
        ht= $(window).height();
        if(ht!=lastWindowHeight) {
        	$("#sidebar").height(ht);
        }
        $('#multiadd_table tbody').scroll(function(e) { 
			$('#multiadd_table thead').css("left", -$("tbody").scrollLeft()); //fix the thead relative to the body scrolling
			$('#multiadd_table thead th:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
			$('#multiadd_table thead th:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the second cell of the header
			$('#multiadd_table thead th:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the third cell of the header
			$('#multiadd_table thead th:nth-child(4)').css("left", $("tbody").scrollLeft()); //fix the third cell of the header
			$('tbody td:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
			$('tbody td:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the second column of tdbody
			$('tbody td:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the third column of tdbody
			$('tbody td:nth-child(4)').css("left", $("tbody").scrollLeft()); //fix the third column of tdbody
		});

	});

	$(window).bind('resize', function () { 
  		var ht;
  		var lastWindowHeight = $(window).height();
        ht= $(window).height();
        if(ht!=lastWindowHeight) {
        	$("#sidebar").height(ht);
        }
	});

</script>
<style type="text/css">
	.alertboxalign { margin-bottom: -35px !important; }
	.alert {
		display:inline-block !important;
		height:30px !important;
		padding:5px !important;
	}
	.btn-gray {
 		 background-color: gray;
  		 border-color: white;
	}
	.btn-red {
		background-color: red;
	  	border-color: white;
	  	color: white;
	}
	.bg_lightgrey {
	    background-color:#D3D3D3    ! important;
	}
	table td.multiadd_td {
		padding: 3px;
	}

	table#multiadd_table {
	  position: relative;
	  width: auto;
	  /*min-width: 1184px;*/
	  /*max-width: 358px;*/
	  max-width: 1184px;
	  overflow: hidden;
	  border-collapse: collapse;
	}

	/*thead*/
	thead#multiadd_thead {
	  position: relative;
	  display: block; /*seperates the header from the body allowing it to be positioned*/
	  width: 1184px;
	  max-width: 358px;
	  overflow: visible;
	}

	thead th.multiadd_th {
	  min-width: 120px;
	  height: 32px;
	}

	/*tbody*/
	tbody#multiadd_tbody {
	  position: relative;
	  display: block; /*seperates the tbody from the header*/
	  /*width: 1184px;*/
	  min-width: 358px;
	  max-width: 1184px;
	  min-height: 50px;
	  /*max-height: 350px;*/
	  max-height: 525px;
	  overflow: auto;
	}

	tbody td.multiadd_td, thead th.multiadd_th 	{
	  /*width: 120px;*/
	  min-width: 90px;
	}

	thead th.w_1, tbody td.w_1 {
		width: 40px;
		min-width: 40px;
	}
	thead th.w_2, tbody td.w_2 {
		width: 75px;
		min-width: 75px;
	}

	th.sticky {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}
	thead th.sticky {
		z-index: 5;
	}
	td.sticky {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}
	tbody td.sticky {
		z-index: 5;
	}

	th.sticky1 {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}
	thead th.sticky1 {
		z-index: 5;
	}
	td.sticky1 {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}
	tbody td.sticky1 {
		z-index: 5;
	}

	th.sticky2 {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}

	thead th.sticky2 {
		z-index: 5;
	}

	td.sticky2 {
		position: -webkit-sticky;
		position: relative;
		left: 0;
		z-index: 2;
		background: #ccc;
	}

	tbody td.sticky2 {
		z-index: 5;
	}

</style>

<div class="CMN_display_block" id="main_contents" style="width: 100%;">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_3">
		{{ Form::open(array('name'=>'salarycalcindex',
							'id'=>'salarycalcindex',
							'url'=>'salarycalcplus/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
							'files'=>true,
							'method' => 'POST' )) }}
			{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
			{{ Form::hidden('tblchg', $request->tblchg , array('id' => 'tblchg')) }}
			{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
			{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
			{{ Form::hidden('prevcnt', $request->prevcnt, array('id' => 'prevcnt')) }}
			{{ Form::hidden('nextcnt', $request->nextcnt, array('id' => 'nextcnt')) }}
			{{ Form::hidden('account_val', $account_val, array('id' => 'account_val')) }}
			{{ Form::hidden('previou_next_year', $request->previou_next_year, 
								array('id' => 'previou_next_year')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('hiddenplimit', '' , array('id' => 'hiddenplimit')) }}
	    	{{ Form::hidden('hiddenpage', '' , array('id' => 'hiddenpage')) }}
			{{ Form::hidden('id','' , array('id' => 'id')) }}
			{{ Form::hidden('Emp_ID','' , array('id' => 'Emp_ID')) }}
			{{ Form::hidden('editcheck','' , array('id' => 'editcheck')) }}
			{{ Form::hidden('firstname','' , array('id' => 'firstname')) }}
			{{ Form::hidden('lastname','' , array('id' => 'lastname')) }}
			{{ Form::hidden('mutlireg','' , array('id' => 'mutlireg')) }}
	    	{{ Form::hidden('empname', '' , array('id' => 'empname')) }}
	    	{{ Form::hidden('total', '' , array('id' => 'total')) }}
			{{ Form::hidden('multiflg','' , array('id' => 'multiflg')) }}
			{{ Form::hidden('editflg', '' , array('id' => 'editflg')) }}
			{{ Form::hidden('hdn_empid_arr', '' , array('id' => 'hdn_empid_arr')) }}
			{{ Form::hidden('salflg', '' , array('id' => 'salflg')) }}
			{{ Form::hidden('hdn_salid_arr', '' , array('id' => 'hdn_salid_arr')) }}
			{{ Form::hidden('multiflg_reg', '' , array('id' => 'multiflg_reg')) }}
			{{ Form::hidden('sal_det_count', count($salary_det) , array('id' => 'sal_det_count')) }}
			{{ Form::hidden('sal_ded_count', count($salary_ded) , array('id' => 'sal_ded_count')) }}
			{{ Form::hidden('get_prev_yr', '' , array('id' => 'get_prev_yr')) }}
			<!-- used for common excel dwld -->
			{{ Form::hidden('payrollExcel', '' , array('id' => 'payrollExcel')) }}
			<!-- used for common excel dwld -->
			<!-- used for common excel dwld -->
			{{ Form::hidden('payrollPdf', '' , array('id' => 'payrollPdf')) }}
			<!-- used for common excel dwld -->

		<!-- Start Heading -->
		<div class="row hline pm0">
				<div class="col-xs-12">
					<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
					<h2 class="pull-left pl5 mt10">
						{{ trans('messages.lbl_salary_calc') }}+
					</h2>
				</div>
			</div>
		<!-- End Heading -->

		<div class="box100per pr10 pl10 ">
			<div class="mt10 mb10">
				{{ Helpers::displayYear_MonthEst($account_period, $year_month, $db_year_month, $date_month, $dbnext, $dbprevious, $last_year, $current_year, $account_val) }}
			</div>
		</div>
		
		<div class="col-xs-12 mt5 pm0 pull-left pl10">

			<a class="pull-left" href="javascript:salaryselectpopup_main();">
	          	<img class="box19" src="{{ URL::asset('resources/assets/images/edit.png') }}"></a>
				<a href="javascript:salaryselectpopup_main();" class="pull-left pr10 ml5 anchorstyle" title="{{ trans('messages.lbl_cempsel') }}">
				{{ trans('messages.lbl_cempsel') }}
			</a>
			
			<!-- <div style="display: inline-block;" class="mr10 mb10 pull-right">
				<a href="javascript:multi_reg_calc();" class="btn btn-success" title="Multiple Register" style="color: white;">
					{{ trans('messages.lbl_multi_register') }}
				</a>
			</div> -->

			<div style="display: inline-block;" class="mr10 mb10 pull-right">

				<a href="javascript:historyTotal('{{ $request->mainmenu }}');" class="btn btn-warning" title="History Total" style="color: white;"><span class="fa fa-history"></span>
					{{ trans('messages.lbl_salhistory').' '.trans('messages.lbl_total') }}
				</a>&nbsp;

				<a href="javascript:transferdetailsdownload('{{ $request->mainmenu }}');" class="btn btn-primary" title="Download" style="color: white;"><span class="fa fa-download"></span>
					{{ trans('messages.lbl_transferdetails') }}
				</a>&nbsp;

				<a href="javascript:salaryplusdownload('{{ $request->mainmenu }}');" class="btn btn-primary" title="Download" style="color: white;"><span class="fa fa-download"></span>
					{{ trans('messages.lbl_salledger') }}
				</a>&nbsp;
				<a href="javascript:salarypluspdfdownload('{{ $request->mainmenu }}');" class="btn btn-primary" title="Download" style="color: white;"><span class="fa fa-download"></span>
					{{ trans('messages.lbl_pdfdownload') }}
				</a>
			</div>
		</div>

		@if($salArr != "")
			<table id="multiadd_table" class="tablealternate mb50">
				<thead id="multiadd_thead"  class="CMN_tbltheadcolor">
				<tr>
					<th rowspan="3" class="vam sticky w_1 multiadd_th">{{ trans('messages.lbl_sno') }}</th>
					<th rowspan="3" class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_empno') }}</th>
					<th rowspan="3" class="vam sticky2 multiadd_th" style="min-width: 205px;">{{ trans('messages.lbl_name') }}</th>
					<th rowspan="3" class="vam sticky w_1 multiadd_th" style="min-width: 40px;">{{ Form::checkbox('checkall', 1,'',['id' => 'checkall']) }}</th>

					@php($sal_det_cnt = '')
					@if(count($salary_det)!="")
		 				@for ($i = 0; $i < count($salary_det); $i++)
		 					@if(isset($temp_salaryDetails[$salary_det[$i]->Salarayid]) && $temp_salaryDetails[$salary_det[$i]->Salarayid] != '0')
 								@php($sal_det_cnt += 1)
		 					@endif
		 				@endfor
		 			@endif

 					@if($sal_det_cnt != '')
					<th rowspan="1" colspan="<?php echo $sal_det_cnt; ?>" class="vam multiadd_th">{{ trans('messages.lbl_salary_det') }}</th>
					<th rowspan="2" colspan="1" class="vam multiadd_th" style="min-width: 110px;background-color: #f39c1280 !important">{{ trans('messages.lbl_totpay_amt') }}</th>
					@endif

					@php($sal_ded_cnt = '')
 					@if(count($salary_ded)!="")
		 				@for ($j = 0; $j < count($salary_ded); $j++)
		 					@if(isset($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] != '0')
 								@php($sal_ded_cnt += 1)
		 					@endif
		 				@endfor
		 			@endif
 					@if($sal_ded_cnt!="")
	 				<th rowspan="1" colspan="<?php echo $sal_ded_cnt; ?>" class="vam multiadd_th">{{ trans('messages.lbl_salary_ded') }}</th>
	 				<th rowspan="2" colspan="1" class="vam multiadd_th" style="min-width: 110px;background-color: #f39c1280 !important">{{ trans('messages.lbl_totded_amt') }}</th>
		 			@endif

		 			@php($sal_trv_cnt = '')
					@if($tot_travel_amt != '')
 						@php($sal_trv_cnt += 1)
 						<th rowspan="2" colspan="1" class="vam multiadd_th">{{ trans('messages.lbl_travel_exp') }}</th>
 						<th rowspan="2" colspan="1" class="vam multiadd_th" style="min-width: 110px;background-color: #f39c1280 !important">{{ trans('messages.lbl_total') }}</th>
					@endif
					<th rowspan="2" colspan="1" class="vam multiadd_th" style="min-width: 120px;background-color: #00a65a45 !important;">{{ trans('messages.lbl_grandtot') }}</th>
				</tr>
				<tr>
					@if(count($salary_det)!="")
		 				@for ($i = 0; $i < count($salary_det); $i++)
		 					@if(isset($temp_salaryDetails[$salary_det[$i]->Salarayid]) && $temp_salaryDetails[$salary_det[$i]->Salarayid] != '0')
			 					<th class="vam multiadd_th">
			 						<label title="{{ (isset($salary_det[$i]->nick_name) && $salary_det[$i]->nick_name != '')?$salary_det[$i]->Name:'' }}" style="margin-bottom: 0px !important;">{{ (isset($salary_det[$i]->nick_name) && $salary_det[$i]->nick_name != '')?$salary_det[$i]->nick_name:$salary_det[$i]->Name }}</label>
			 					</th>
	 						@endif
		 				@endfor
	 				@endif
	 				@if(count($salary_ded)!="")
		 				@for ($j = 0; $j < count($salary_ded); $j++)
		 					@if(isset($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] != '0')
			 					<th class="vam multiadd_th">
			 						<label title="{{ (isset($salary_ded[$j]->nick_name) && $salary_ded[$j]->nick_name != '')?$salary_ded[$j]->Name: ''}}" style="margin-bottom: 0px !important;">{{ (isset($salary_ded[$j]->nick_name) && $salary_ded[$j]->nick_name != '')?$salary_ded[$j]->nick_name:$salary_ded[$j]->Name }}</label>
			 					</th>
	 						@endif
		 				@endfor
	 				@endif
				</tr>
				<tr>
					@php $tot_over_amt = '' @endphp
	 				@php($tot1 = '')
					@if(count($salary_det)!="")
		 				@for ($i = 0; $i < count($salary_det); $i++)
		 					@if(count($salArr)!="")
			 					@if(isset($temp_salaryDetails[$salary_det[$i]->Salarayid]) && $temp_salaryDetails[$salary_det[$i]->Salarayid] != '0')
				 					<th class="vam multiadd_th">
				 						<span id="totalSDspan<?php echo $i ?>" class="text-right multiadd_td" style="color:blue;">
	 										@php($tot1 += $temp_salaryDetails[$salary_det[$i]->Salarayid])
											@php $tot_over_amt += $temp_salaryDetails[$salary_det[$i]->Salarayid] @endphp
					 						{{ number_format($temp_salaryDetails[$salary_det[$i]->Salarayid]) }}
		   		 						</span>
				 					</th>
			 					@endif
		 					@endif
		 				@endfor
	 				@endif
	 				@if($sal_det_cnt != '')
					<th class="vam multiadd_th" style="color:blue;background-color: #f39c1280 !important;">
						{{ number_format($tot1) }}
					</th>
	 				@endif
	 				@php($tot2 = '')
	 				@if(count($salary_ded)!="")
		 				@for ($j = 0; $j < count($salary_ded); $j++)
		 					@if(count($salArr)!="")
			 					@if(isset($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) && $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] != '0')
				 					<th class="vam multiadd_th">
				 						<span id="totalDDspan<?php echo $j ?>" class="text-right multiadd_td" style="color:red;">
	 										@php($tot2 += $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid])
											@php $tot_over_amt += $temp_salaryDetails_DD[$salary_ded[$j]->Salarayid] @endphp
					 						{{ number_format($temp_salaryDetails_DD[$salary_ded[$j]->Salarayid]) }}
		   		 						</span>
				 					</th>
		 						@endif
		 					@endif
		 				@endfor
		 			@else
		 				<th class="vam multiadd_th" style="min-width: 287px;"></th>
	 				@endif
	 				@if($sal_ded_cnt != '')
					<th class="vam multiadd_th" style="color:red;background-color: #f39c1280 !important;">
						{{ number_format($tot2) }}
					</th>
	 				@endif
					@if($tot_travel_amt != '')
					<th class="vam multiadd_th" style="color:blue;">
						@php $tot_over_amt += $tot_travel_amt @endphp
 						{{ number_format($tot_travel_amt) }}
					</th>
					<th class="vam multiadd_th" style="color:blue;background-color: #f39c1280 !important;">
 						{{ number_format($tot_travel_amt) }}
					</th>
	 				@endif
 					<th class="vam multiadd_th" style="color:blue;background-color: #00a65a45 !important;">
 						@if($tot_over_amt != '')
 							{{ number_format($tot_over_amt) }}
 						@endif
 					</th>
				</tr>
				</thead>
				<tbody id="multiadd_tbody">
					@php $sNo = 1 @endphp
					@foreach($salArr as $key => $sal)
						@if(isset($sal['LastName']))
						@php 
		                  $resignYear = substr($sal['resigndate'], 0,4);
		                  $resignMnth = substr($sal['resigndate'], 5,2);
                		@endphp
                		@if($sal['resign_id'] == 0 || $resignYear > $request->selYear || ($resignYear == $request->selYear && $resignMnth >= $request->selMonth))
						<tr>
							<td class="text-center sticky w_1 multiadd_td">
	                    		{{ $sNo }}
	                    	</td>
				   			<td class="sticky1 tac multiadd_td w_2">
	                    		<a class="colbl fwb anchorstyle" href="javascript:fngotohistory('{{ $sal['Emp_ID'] }}','{{ $request->mainmenu }}','{{ $sal['FirstName'] }}','{{ $sal['LastName'] }}')">
	                    			{{ $sal['Emp_ID'] }}
	                    		</a>
				   			</td>

				   			@php 
				   				$editChk = ($sal['salExist']) ? 1 : 0 ;
				   			@endphp
				   			<td class="sticky2 multiadd_td" style="min-width: 205px;">
	                    		<a class="colbl anchorstyle"  href="javascript:fngotoadd('{{ $sal['id'] }}','{{ $sal['Emp_ID'] }}','{{ $editChk }}','{{ $request->mainmenu }}','{{ $sal['FirstName'] }}','{{ $sal['LastName'] }}');" title="{{ empnameontitle($sal['LastName'], $sal['FirstName'],50) }}">
	                    			{{ empnamelength($sal['LastName'], $sal['FirstName'],14) }}
	                    		</a>
	                    	</td>

				   			<td class="text-center sticky w_1 multiadd_td">
                    		<?php if ($sal['totSalary'] != "") { ?>
								{{ Form::checkbox('salarycheck', $sal['Emp_ID'],0,['id' => 'salarycheck','class' => 'checkbox','style' => 'display:inline-block','data-name-empid' => $sal['LastName'],'data-mailflg' => $sal['mailFlg']]) }}
							<?php } ?>	
							</td>

				   			@php($x = 0)
				   			@foreach ($salresult as $key2 => $value2)
				   				@if(isset($temp_salaryDetails[$key2]) && $temp_salaryDetails[$key2] != '0')
				   					@if($sal['salExist'])
					   					@if($key2 == isset($sal['salDetTotal'][$key2]))
					   						<td class="text-right pr10 multiadd_td SD_{{ $x }}"> {{ ($sal['salDetTotal'][$key2] != '') ? number_format($sal['salDetTotal'][$key2]): '0' }}</td>
					   					@else
					   						<td class="text-right pr10 multiadd_td">{{"0"}}</td>
					   					@endif
					   				@else
					   					<td class="text-right pr10 multiadd_td"></td>
					   				@endif
				   				@endif
				   				@php($x++)
				   			@endforeach

				   			@if($sal_det_cnt != '')
					   			<td class="text-right pr10 multiadd_td" style="min-width: 110px;background-color: #f39c1280 !important">
						   			@if($sal['totSalary'] != "" && $sal['salExist'])
						   				{{ number_format($sal['totSalary'])}}
						   			@else
					   				@endif
					   			</td>
					   		@endif

			   				@php($y = 0)
			   				@foreach ($dedresult as $key2 => $value2)
				   				@if(isset($temp_salaryDetails_DD[$key2]) && $temp_salaryDetails_DD[$key2] != '0')
					   				@if($sal['salExist'])
					   					@if($key2 == isset($sal['dedDetTotal'][$key2]))
					   						<td class="text-right pr10 multiadd_td DD_{{ $y }}" style="color: red;"> {{ ($sal['dedDetTotal'][$key2] != '') ? number_format($sal['dedDetTotal'][$key2]): '0' }}</td>
					   					@else
					   						<td class="text-right pr10 multiadd_td" style="color:red;">{{"0"}}</td>
					   					@endif
					   				@else
					   					<td class="text-right pr10 multiadd_td"></td>
					   				@endif
				   				@endif
				   				@php($y++)
				   			@endforeach
					   	
				   			@if($sal_ded_cnt != '')
					   			<td class="text-right pr10 multiadd_td" style="min-width: 110px;color: red;background-color: #f39c1280 !important;">
						   			@if($sal['totDetuct'] != "" && $sal['salExist'])
						   					{{ number_format($sal['totDetuct'])}}
						   			@else
					   				@endif
					   			</td>
					   		@endif

					   		@if($tot_travel_amt != '')
					   			<td class="text-right pr10 multiadd_td">
					   				@if($sal['totTravel'] != "" && $sal['salExist'])
					   					{{ number_format($sal['totTravel'])}}
						   			@elseif($sal['totTravel'] == "" && $sal['salExist'])
						   				0
					   				@endif
				   				</td>

				   				<td class="text-right pr10 multiadd_td" style="min-width: 110px;background-color: #f39c1280 !important">
					   				@if($sal['totTravel'] != "" && $sal['salExist'])
						   					{{ number_format($sal['totTravel']) }}
						   			@elseif($sal['totTravel'] == "" && $sal['salExist'])
						   				0
					   				@endif
				   				</td>
				   			@endif

				   			<td class="text-right pr10 multiadd_td" style="min-width: 110px;background-color: #00a65a45 !important;">
			   					@if($sal['grandTotal'] != "" && $sal['salExist'])
				   					{{ number_format($sal['grandTotal']) }}
			   					@else
			   					@endif
				   			</td>

			   			</tr>
			   			@endif
			   			@endif
			   		@php $sNo++ @endphp
					@endforeach
				</tbody>
			</table>
		@else
			<div class="text-center fr">{{ trans('messages.lbl_nodatafound') }}</div>
		@endif
	{{ Form::close() }}

	<div id="salarypopup" class="modal fade">
		<div id="login-overlay">
			<div class="modal-content">
				<!-- Popup will be loaded here -->
			</div>
		</div>
	</div>

	</article>
</div>
@endsection