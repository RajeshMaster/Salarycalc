@extends('layouts.app')
@section('content')

{{ HTML::script('resources/assets/js/salarycalc.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}

<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var dates = '<?php echo date('Y-m-d'); ?>';
	var dates_sal = '<?php echo date('Y-m-10'); ?>';
	// Get Salary Date
	var date1 = new Date(dates_sal);
	var saldate = '';
	switch(date1.getDay()){
	    case 0: saldate = '<?php echo date('Y-m-08'); ?>'; break;
	    case 6: saldate = '<?php echo date('Y-m-09'); ?>'; break;
	    default: saldate = dates_sal;
	    
	}
	// End Salary Date
	$(document).ready(function() {

		$('#date').val(dates);
		$('#date_hdn').val(dates);
		setDatePicker("txt_startdate");
	    calculateSum();

	    $(".totalclick").on("keydown keyup", function() {
	    	// var suffix = this.id.match(/\d+/); // 123456
	    	var suffix = $(this).attr('data-id'); // 123456
			// alert($(this).attr('data-id'));
	        calculateSum(suffix);
	    });

	});
	function negativeamt(id,amt) {
		var amt = $('#'+id).val();
		amt = $('#'+id).val().replace(/[^0-9]/gi, '');
		//amt = Number(amt.trim().replace(/[, ]+/g, ""));
		if (amt == "") {
			$('#'+id).focus();  
			$('#'+id).val('-');
		} else {
			$('#'+id).focus(); 
			if (amt>0) {
				value1 = amt;
				tot = value1.toLocaleString();
				amount = "-"+tot;
				document.getElementById(""+id).value = amount;
			}
		}
	}
	function calculateSum(suffix) {

	    var sum = 0;
	    //iterate through each textboxes and add the values
	    $(".txt"+suffix).each(function() {
	    	var remnum = Number(this.value.trim().replace(/[, ]+/g, ""));
	        //add only if the value is number
	        if (!isNaN(remnum) && this.value.length != 0) {
	            sum += parseFloat(remnum);
	            // $(this).css("background-color", "#FEFFB0");
	        }
	        else if (this.value.length != 0){
	            // $(this).css("background-color", "red");
	        }
	    });
	    var isNeg = sum < 0;
	    var amount = isNeg ? sum : Math.abs(sum.toFixed(0));
		var tot = amount.toLocaleString();
		$("#totalspan"+suffix).text(tot);
	}

	$(document).ready(function() {
		$('#copyamountval').click(function() {
		    if ($(this).is(':checked')) {
		    	var totempcount = $('#count').val();
		    	for (var i = 0; i <= (totempcount-1); i++) {
		    		// alert($('#totalspan'+i).text());
		    		$('.transferred_'+i).val($('#totalspan'+i).text());
		    	}
		    }
		});
		$('#multiadd_table tbody').scroll(function(e) { 
			$('#multiadd_table thead').css("left", -$("tbody").scrollLeft()); //fix the thead relative to the body scrolling
			$('#multiadd_table thead th:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
			$('#multiadd_table thead th:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the second cell of the header
			$('#multiadd_table thead th:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the third cell of the header
			$('tbody td:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
			$('tbody td:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the second column of tdbody
			$('tbody td:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the third column of tdbody
		});
	});
</script>
<style type="text/css">
	.clr_blue1{
		 color: blue ! important;
	}

	table td.multiadd_td {
		padding: 3px;
	}

	table#multiadd_table {
	  position: relative;
	  width: 1184px;
	  overflow: hidden;
	  border-collapse: collapse;
	}


	/*thead*/
	thead#multiadd_thead {
	  position: relative;
	  display: block; /*seperates the header from the body allowing it to be positioned*/
	  width: 1184px;
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
	  width: 1184px;
	  min-height: 60px;
	  max-height: 350px;
	  overflow: auto;
	}

	tbody td.multiadd_td, thead th.multiadd_th 	{
	  min-width: 120px;
	}

	thead th.w_1, tbody td.w_1 {
		min-width: 40px;
	}
	thead th.w_2, tbody td.w_2 {
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
<div class="CMN_display_block" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_1">
		@if(isset($detedit))
		    {{ Form::model($detedit, ['name'=>'frmmultireg', 
									'id'=>'frmmultireg', 
									'url' => 'salarycalc/multiregister?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
									'files' => true,
									'method' => 'POST']) }}
		@else
			{{ Form::open(array('name'=>'frmmultireg',
								'id'=>'frmmultireg',
								'url'=>'salarycalc/multiregister?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
								'files'=>true,
								'method' => 'POST' )) }}
		@endif
		{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
		{{ Form::hidden('tblchg', $request->tblchg , array('id' => 'tblchg')) }}
		{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
		{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
		{{ Form::hidden('emp_limit', $request->emp_limit, array('id' => 'emp_limit')) }}
		{{ Form::hidden('salflg', $request->salflg, array('id' => 'salflg')) }}
		{{ Form::hidden('multiflg_reg', $request->multiflg_reg, array('id' => 'multiflg_reg')) }}
		{{ Form::hidden('no_flg', $request->no_flg, array('id' => 'no_flg')) }}
		{{ Form::hidden('date_hdn', '', array('id' => 'date_hdn')) }}
		{{ Form::hidden('count', count($get_det), array('id' => 'count')) }}
		{{ Form::hidden('get_prev_yr', $request->get_prev_yr , array('id' => 'get_prev_yr')) }}
		<div class="row hline pm0">
			<div class="col-xs-12">
				<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/salary_1.png') }}">
				<h2 class="pull-left pl5 mt10">
					{{ trans('messages.lbl_salary_calc') }} <span>・</span><span class="green">{{ trans('messages.lbl_multireg') }}</span></h2>
			</div>
		</div>
		<div class="col-xs-12">
      		<div class="col-xs-12 pm0 pull-left mb10 pl10 pr10 mt20 fwb">
	        	{{ trans('messages.lbl_year').':' }}
	          	<span class="mr40 ml12" style="color:brown;">
	            {{ $request->selYear }}
	          	</span>
             	{{ trans('messages.lbl_month').':' }}
             	@if($request->salflg == 1)
	             	<span class="mr40 ml12" style="color:brown;">
		            	{{ $request->selMonth }}
		          	</span>
             	@else
    				{{ Form::selectRange('month', 1, 12, $request->selMonth, array('id' => 'month', 'onchange' => 'monthchangecalc(this.value)')) }}
    			@endif
    			<label class="ml22">{{ trans('messages.lbl_saldate') }}<span class="fr ml2 red"> * </span></label>
    			{{ Form::text('txt_startdate','',array(

												'id'=>'txt_startdate',

												'name' => 'txt_startdate',

												'class'=>'box9per txt_startdate form-control ml12',

												'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',

												'style' => 'display:inline-block',

												'data-label' => trans('messages.lbl_Date'),

												'maxlength' => '10')) }}
			<label class="fa fa-calendar fa-lg" for="txt_startdate" aria-hidden="true"></label>
			<a href="javascript:getdate_multicheck();" class="anchorstyle">
						<img title="Get Salary Date" class="box15" src="{{ URL::asset('resources/assets/images/add_date.png') }}"></a>
				<div style="display: inline-block;float: right;">
					<label class="ml22">{{ trans('messages.lbl_employee_limit') }}</label>
					{{ Form::select('emplimit_arr', $emplimit_array, $request->emp_limit, array('id' => 'emplimit_arr', 'onchange' => 'emplimitchangecalc(this.value)')) }}
	      		</div>
      		</div>
		</div>
		<!-- <div class="box100per pl10 pr10 mt10" style="overflow-x: auto;">
			<div style="border: 1px solid white;" id="sidebar"> -->
				@php $count = 43; @endphp
				@if(count($salary_det)!="")
	 				@for ($i = 0; $i < count($salary_det); $i++)
	 					@php $count += 10; @endphp
	 				@endfor
 				@endif
 				@if(count($salary_ded)!="")
	 				@for ($j = 0; $j < count($salary_ded); $j++)
	 					@php $count += 10; @endphp
	 				@endfor
 				@endif
 				@if($count<100)
 					@php $count = 100; @endphp
 				@endif
 				<table id="multiadd_table" class="tablealternate">
				<colgroup>
					<col width="4%">
					<col width="7%">
					<col width="18%">
					@if(count($salary_det)!="")
		 				@for ($i = 0; $i < count($salary_det); $i++)
		 					<col width="10%">
		 				@endfor
	 				@endif
	 				@if(count($salary_ded)!="")
		 				@for ($j = 0; $j < count($salary_ded); $j++)
		 					<col width="10%">
		 				@endfor
	 				@endif
					<col width="7%">	
					<col width="8%">	
				</colgroup>
				<thead id="multiadd_thead" class="CMN_tbltheadcolor">
					<tr id="">
						<th rowspan="2" class="vam sticky w_1 multiadd_th">{{ trans('messages.lbl_sno') }}</th>
						<th rowspan="2" class="vam sticky1 w_2 multiadd_th">{{ trans('messages.lbl_empno') }}</th>
						<th rowspan="2" class="vam sticky2 w_3 multiadd_th" style="min-width: 205px;">{{ trans('messages.lbl_name') }}</th>
	 					<th rowspan="1" colspan="<?php echo count($salary_det)+2; ?>" class="vam multiadd_th">{{ trans('messages.lbl_salary_det') }}</th>
	 					<th rowspan="1" colspan="<?php echo count($salary_ded); ?>" class="vam multiadd_th">{{ trans('messages.lbl_salary_ded') }}</th>
						<th rowspan="2" class="vam multiadd_th"></th>
						@php($style_tran = '')
						@if(count($salary_det) =="" && count($salary_ded) =="")
							@php($style_tran = 'min-width:195px;')
						@endif
						<th rowspan="2" class="vam multiadd_th" style="<?php echo $style_tran;?>">{{ trans('messages.lbl_transferred') }}<br>{{ Form::checkbox('copyamountval', 1,'',['id' => 'copyamountval']) }}</th>
					</tr>
					<tr>
						@if(count($salary_det)!="")
			 				@for ($i = 0; $i < count($salary_det); $i++)
			 					<th class="vam multiadd_th">{{ $salary_det[$i]->Name }}</th>
			 				@endfor
			 				<th class="vam multiadd_th">
		 						{{ trans('messages.lbl_train_daily') }}
		 					</th>
		 					<th class="vam multiadd_th">
		 						{{ trans('messages.lbl_Others') }}
		 					</th>
			 			@else
			 				<th class="vam multiadd_th" style="min-width: 310px;"></th>
		 				@endif
		 				@if(count($salary_ded)!="")
			 				@for ($j = 0; $j < count($salary_ded); $j++)
			 					<th class="vam multiadd_th">{{ $salary_ded[$j]->Name }}</th>
			 				@endfor
			 			@else
			 				<th class="vam multiadd_th" style="min-width: 310px;"></th>
		 				@endif
					</tr>
				</thead>
				<tbody id="multiadd_tbody">
					@if (count($get_det) > 0)
						@for ($i = 0; $i < count($get_det); $i++)
						<tr id="row<?php echo $i ?>">
							<td class="text-center sticky w_1 multiadd_td">
								{{  $i + 1 }}
								<input type="hidden" name="count" id="count" value="<?php echo count($get_det); ?>">
							</td>
				             <td class="sticky1 tac w_2 multiadd_td">
				             	 {{ $get_det[$i]['Emp_ID'] }}
								{{ Form::hidden('Emp_ID'.$i, $get_det[$i]['Emp_ID'], array('id' => 'Emp_ID'.$i)) }}
				             </td>
				             <td class="sticky2 w_3 multiadd_td" style="min-width: 205px;">
				             	{{ empnamelength($get_det[$i]['LastName'], $get_det[$i]['FirstName'],20) }}
				             </td>
	                    	@if(count($salary_det)!="")
				 				@for ($m = 0; $m < count($salary_det); $m++)
				 					<td class="text-right pr10 multiadd_td">
			                    		{{ Form::text('salary_'.$get_det[$i]['Emp_ID'].'_'.$salary_det[$m]->Salarayid,null,array('id'=>'salary_'.$get_det[$i]['Emp_ID'].'_'.$salary_det[$m]->Salarayid, 'name' => 'salary_'.$get_det[$i]['Emp_ID'].'_'.$salary_det[$m]->Salarayid,'maxlength' => '14','style'=>'text-align:right;padding-right:4px;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormat(this.id,"jp")','data-id'=>$i,'class'=>'txt'.$i.' totalclick box99per form-control')) }}
									</td>
				 				@endfor
				 			@else
				 				<td class="multiadd_td" style="min-width: 310px;"></td>
			 				@endif
			 				<td class="text-right pr10 multiadd_td">
	                    		{{ Form::text('train_'.$get_det[$i]['Emp_ID'],null,array('id'=>'train_'.$get_det[$i]['Emp_ID'], 'name' => 'train_'.$get_det[$i]['Emp_ID'],'maxlength' => '14','style'=>'text-align:right;padding-right:4px;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormat(this.id,"jp")','data-id'=>$i,'class'=>'txt'.$i.' totalclick box99per form-control')) }}
							</td>
							<td class="text-right pr10 multiadd_td">
	                    		{{ Form::text('others_'.$get_det[$i]['Emp_ID'],null,array('id'=>'others_'.$get_det[$i]['Emp_ID'], 'name' => 'others_'.$get_det[$i]['Emp_ID'],'maxlength' => '14','style'=>'text-align:right;padding-right:4px;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormat(this.id,"jp")','data-id'=>$i,'class'=>'txt'.$i.' totalclick box99per form-control')) }}
							</td>
			 				@if(count($salary_ded)!="")
				 				@for ($n = 0; $n < count($salary_ded); $n++)
				 					<td class="text-right pr10 multiadd_td">
			                    		{{ Form::text('Deduction_'.$get_det[$i]['Emp_ID'].'_'.$salary_ded[$n]->Salarayid,null,array('id'=>'Deduction_'.$get_det[$i]['Emp_ID'].'_'.$salary_ded[$n]->Salarayid,'name' => 'Deduction_'.$get_det[$i]['Emp_ID'].'_'.$salary_ded[$n]->Salarayid,'maxlength' => '14','style'=>'text-align:right;padding-right:4px;color:red;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormatNegative(this.id,"jp");negativeamt(this.id,this.value)','data-id'=>$i,'class'=>'txt'.$i.' totalclick box99per form-control')) }}
									</td>
				 				@endfor
				 			@else
				 				<td class="multiadd_td" style="min-width: 310px;"></td>
			 				@endif
							<td class="text-right pr10 multiadd_td">
	                    		<span id="totalspan<?php echo $i ?>" class="clr_blue1 totamt" style="font-size:10px;">
								</span>
								<span class="" style="font-size:10px;">円</span>
							</td>
							<td class="text-right pr10 multiadd_td">
			                    		{{ Form::text('transferred_'.$get_det[$i]['Emp_ID'],'',array('id'=>'transferred_'.$get_det[$i]['Emp_ID'], 
																					'name' => 'transferred_'.$get_det[$i]['Emp_ID'],
																					'maxlength' => '14',
																					'style'=>'text-align:right;padding:0px !important;width:100%;',
																					'onkeypress' => 'return isNumberKey(event)',
																					'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',
																					'class'=>'totalclick  form-control transferred_'.$i)) }}
									</td>
						</tr>
						@endfor
					@else
						<tr>
							@php($colspan = 7)
								@if(count($salary_det) == 0 && count($salary_ded) == 0)
									@php($colspan = 7)
								@elseif(count($salary_det) != 0 && count($salary_ded) == 0)
									@php($colspan = 6 + count($salary_det))
								@elseif(count($salary_det) == 0 && count($salary_ded) != 0)
									@php($colspan = 6 + count($salary_ded))
								@elseif(count($salary_det) != 0 && count($salary_ded) != 0)
									@php($colspan = 5 + count($salary_det) + count($salary_ded))
								@endif
							<td class="text-center multiadd_td" colspan="<?php echo $colspan; ?>" style="color: red;width: 1300px;">{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endif
				</tbody>	
			</table>
			<!-- </div>
			</div> -->
			<fieldset style="background-color: #DDF1FA;">
			<div class="form-group">
			<div align="center" class="mt8">
				<button type="submit" class="btn btn-success add box100 multiplereg ml5">
						<i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
				</button>
				<a href="javascript:goindex('index','{{$request->mainmenu}}');" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
				</a>
			</div>
			</div>
			</fieldset>

				{{ Form::close() }}
			

	    {{ Form::open(array('name'=>'salaryplusmultieditcancel', 'id'=>'salaryplusmultieditcancel', 'url' => 'salarycalc/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
		{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
		{{ Form::hidden('date_hdn', '', array('id' => 'date_hdn')) }}
		{{ Form::hidden('count', count($get_det), array('id' => 'count')) }}
		{{ Form::hidden('get_prev_yr', $request->get_prev_yr , array('id' => 'get_prev_yr')) }}
		{{ Form::close() }}

		@if(isset($detedit))
			@for ($i=0; $i < count($detedit); $i++)
			    <script type="text/javascript">
		            calculateSum('{{ $i }}')
		        </script>
			@endfor
		@endif

	</article>
</div>
@endsection
