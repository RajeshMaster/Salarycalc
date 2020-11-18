@extends('layouts.app')
@section('content')

{{ HTML::script('resources/assets/js/salarycalcplus.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}

<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var dates = '<?php echo date('Y-m-d'); ?>';
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
		    	var totempcount1 = $('#count').val();
		    	for (var i = 0; i <= (totempcount1-1); i++) {
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
	  width: 1300px;
	  overflow: hidden;
	  border-collapse: collapse;
	}


	/*thead*/
	thead#multiadd_thead {
	  position: relative;
	  display: block; /*seperates the header from the body allowing it to be positioned*/
	  width: 1300px;
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
	  width: 1300px;
	  min-height: 60px;
	  max-height: 350px;
	  overflow: auto;
	}

	tbody td.multiadd_td, thead th.multiadd_th 	{
	  min-width: 210px;
	}

	thead th.w_1, tbody td.w_1 {
		min-width: 40px;
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
	<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_3">
		@if(isset($detedit))
		    {{ Form::model($detedit, ['name'=>'frmmultireg', 
									'id'=>'frmmultireg', 
									'url' => 'salarycalcplus/multiregister?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
									'files' => true,
									'method' => 'POST']) }}
		@else
			{{ Form::open(array('name'=>'frmmultireg',
								'id'=>'frmmultireg',
								'url'=>'salarycalcplus/multiregister?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
								'files'=>true,
								'method' => 'POST' )) }}
		@endif
		{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
		{{ Form::hidden('selMonth', $request->selMonth, array('id' => 'selMonth')) }}
		{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
		{{ Form::hidden('emp_limit', $request->emp_limit, array('id' => 'emp_limit')) }}
		{{ Form::hidden('salflg', $request->salflg, array('id' => 'salflg')) }}
		{{ Form::hidden('multiflg_reg', $request->multiflg_reg, array('id' => 'multiflg_reg')) }}
		{{ Form::hidden('no_flg', $request->no_flg, array('id' => 'no_flg')) }}
		{{ Form::hidden('date_hdn', '', array('id' => 'date_hdn')) }}
		{{ Form::hidden('count', count($get_det), array('id' => 'count')) }}
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
		            	{{ Form::hidden('month', $request->selMonth, array('id' => 'month')) }}
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
						<img title="Current Date" class="box15" src="{{ URL::asset('resources/assets/images/add_date.png') }}"></a>
				<div style="display: inline-block;float: right;">
					<label class="ml22">{{ trans('messages.lbl_employee_limit') }}</label>
					{{ Form::select('emplimit_arr', $emplimit_array, $request->emp_limit, array('id' => 'emplimit_arr', 'onchange' => 'emplimitchangecalc(this.value)')) }}
	      		</div>
      		</div>
		</div>
 				<table id="multiadd_table" class="tablealternate">
				<thead id="multiadd_thead" class="CMN_tbltheadcolor">
					<tr>
						<th rowspan="2" class="vam sticky multiadd_th"></th>
						@if(count($get_det)!="")
					   		@for ($i = 0; $i < count($get_det); $i++)
					   		<th class="vam multiadd_th">
					   			{{ $get_det[$i]['Emp_ID'] }}
					   		</th>
					   		@endfor
				   		@endif
					</tr>
					<tr>
						@if(count($get_det)!="")
					   		@for ($i = 0; $i < count($get_det); $i++)
					   		<th class="vam multiadd_th" title="<?php echo $get_det[$i]['LastName']; ?>">
					   			{{ empnamelength($get_det[$i]['LastName'], $get_det[$i]['FirstName'],12) }}
					   		</th>
					   		@endfor
				   		@endif
					</tr>
				</thead>
				<tbody id="multiadd_tbody">
					@if(count($get_det)!="")
					@if(count($salary_det)!="")
		 				@for ($i = 0; $i < count($salary_det); $i++)
							<tr>
			 					<td class="tac sticky multiadd_td">
			 						{{ $salary_det[$i]->Name }}
			 					</td>
			 					@if(count($get_det)!="")			
			   		 				@for ($k = 0; $k < count($get_det); $k++)
				   		 				<td class="text-right pr10 multiadd_td">
					   		 				{{ Form::text('salary_'.$get_det[$k]['Emp_ID'].'_'.$salary_det[$i]->Salarayid,null,array('id'=>'salary_'.$get_det[$k]['Emp_ID'].'_'.$salary_det[$i]->Salarayid, 'name' => 'salary_'.$get_det[$k]['Emp_ID'].'_'.$salary_det[$i]->Salarayid,'maxlength' => '14','style'=>'text-align:right;padding-right:4px;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormat(this.id,"jp")','data-id'=>$k,'class'=>'txt'.$k.' totalclick box99per form-control')) }} 
					   		 			</td>
			   		 				@endfor
			   		 			@endif
                			</tr>
		 				@endfor
	 				@endif
	 				@if(count($salary_ded)!="")
		 				@for ($j = 0; $j < count($salary_ded); $j++)
		 					<tr>
			 					<td class="tac sticky multiadd_td">
		 							{{ $salary_ded[$j]->Name }}
		 						</td>
		 						@if(count($get_det)!="")
			   		 				@for ($l = 0; $l < count($get_det); $l++)
				   		 				<td class="text-right pr10 multiadd_td">
					   		 				{{ Form::text('Deduction_'.$get_det[$l]['Emp_ID'].'_'.$salary_ded[$j]->Salarayid,null,array('id'=>'Deduction_'.$get_det[$l]['Emp_ID'].'_'.$salary_ded[$j]->Salarayid,'name' => 'Deduction_'.$get_det[$l]['Emp_ID'].'_'.$salary_ded[$j]->Salarayid,'maxlength' => '14','style'=>'text-align:right;padding-right:4px;color:red;','onkeypress' => 'return isNumberKey(event)','onkeyup'=>'return fnMoneyFormatNegative(this.id,"jp");negativeamt(this.id,this.value)','data-id'=>$l,'class'=>'txt'.$l.' totalclick box99per form-control')) }} 
					   		 			</td>
			   		 				@endfor
			   		 			@endif
                			</tr>
		 				@endfor
	 				@endif
	 				<tr>
	 					<td class="tac sticky multiadd_td">
 						</td>
						@if(count($get_det)!="")
		 					@for ($i = 0; $i < count($get_det); $i++)
		 						<td class="text-right pr10 multiadd_td">
		                    		<span id="totalspan<?php echo $i ?>" class="clr_blue1 totamt" style="font-size:10px;">
									</span>
									<span class="" style="font-size:10px;">円</span>
								</td>
							@endfor
	 					@endif
 					</tr>
 					<tr>
	 					<td class="tac sticky multiadd_td">
	 						{{ trans('messages.lbl_transferred') }}
	 						<br>
	 						{{ Form::checkbox('copyamountval', 1,'',['id' => 'copyamountval']) }}
 						</td>
 						@if(count($get_det)!="")
	   		 				@for ($l = 0; $l < count($get_det); $l++)
	   		 				<input type="hidden" id="Emp_ID<?php echo $l;?>" name="Emp_ID<?php echo $l;?>" value="<?php echo $get_det[$l]['Emp_ID'] ?>">
		   		 				<td class="text-right pr10 multiadd_td">
		   		 					{{ Form::text('transferred_'.$get_det[$l]['Emp_ID'],'',array('id'=>'transferred_'.$get_det[$l]['Emp_ID'], 
																						'name' => 'transferred_'.$get_det[$l]['Emp_ID'],
																						'maxlength' => '14',
																						'style'=>'text-align:right;padding:0px !important;width:100%;',
																						'onkeypress' => 'return isNumberKey(event)',
																						'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',
																						'class'=>'totalclick  form-control transferred_'.$l)) }}
		   		 				</td>
	   		 				@endfor
	   		 			@endif
 					</tr>
 					@else
 						<tr>
 							<td class="text-center multiadd_td" style="color: red;width: 1300px;">{{ trans('messages.lbl_nodatafound') }}</td>
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
