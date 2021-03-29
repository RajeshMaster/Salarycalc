{{ HTML::script('resources/assets/js/salarycalcplus.js') }}

<style>

.modal {
	position: absolute;
	top: 50% !important;
	left: 50%;
	transform: translate(-50%, -50%);
}

</style>

<div class="modal-content">
	<div class="modal-header" style="padding: 3px !important;">
		<div class="col-md-2 pull-right mt15">
			<button type="button" data-dismiss="modal" class="close" 
				style="color: red !important;" aria-hidden="true">&#10006;</button>
		</div>
		<div class="col-md-8" style="padding-left: 2%;padding-top: 2%">
			<h2 style="font-size:30px;" class="modal-title custom_align">
				{{ trans('messages.lbl_cempsel') }}</h2>
		</div>
	</div>

	{{ Form::open(array('name'=>'employeeselectform', 'id'=>'employeeselectform', 
			'url' => 'salarycalcplus/contractempselproces?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
			'method' => 'POST')) }}

	 {{ Form::hidden('mainmenu', $request->mainmenu ,array('id' => 'mainmenu')) }}

	<input type="hidden" name="year" id="year" value="<?php echo $request->year ?>">
	<input type="hidden" name="month" id="month" value="<?php echo $request->month ?>">
	
	<div id="errorSectiondisplay" align="center" class="box100per"></div>

	<div class="modal-body" style="padding: 10px !important;">
		<div class="form-group col-md-12" style="min-height: 300px;">
			<div class="col-md-12 mt20">
				<div class="col-md-3 fwb"> 
					<label>{{ trans('messages.lbl_yearmonth') }}
						<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-md-9">
					{{ Form::text('selectedyear',$request->year,
							array('id'=>'selectedyear', 
									'name' => 'selectedyear',
									'maxlength' => '4',
									'data-label' => trans('messages.lbl_year'),
									'onkeypress' => 'return isNumberKey(event)',
									'class'=>'selectedyear box15per form-control')) }} 
					<span class="fr ml5 mr5 red"> - </span>
					{{ Form::text('selectedmonth',$request->month,
							array('id'=>'selectedmonth', 
									'name' => 'selectedmonth',
									'maxlength' => '2',
									'data-label' => trans('messages.lbl_month'),
									'onkeypress' => 'return isNumberKey(event)',
									'class'=>'selectedmonth box12per form-control')) }} 
				</div>
			</div>
			<div class="col-md-12 mt20 mb20">
				<div class = "col-md-3 fwb"> 
					<label>{{ trans('messages.lbl_Selected') }}
						<span class="fr ml2"> * </span></label>
				</div>
				<div class="col-md-9">
					<select multiple size="15" id="selectedEmp" name="selected[]" 
						style="height: 275px;width: 80%;">
							@foreach($employeeSelect as $key => $employeesselected)
								@php 
									$resignYear = substr($employeesselected->resigndate, 0,4);
									$resignMnth = substr($employeesselected->resigndate, 5,2);
								@endphp
								@if($employeesselected->resign_id == 0 || $resignYear > $request->year || ($resignYear == $request->year && $resignMnth >= $request->month))
								<option value="{{ $employeesselected->Emp_ID }}">
									{{ $employeesselected->LastName }}
								</option>
								@endif
							@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="modal-footerbg-info mb10 mr10 ml10" 
			style="padding: 6px !important;border-radius: 5px !important;">
			<center>
				<button id = "add"
					class="btn btn-success CMN_display_block box100 contractempselpopup">
					<i class="fa fa-plus" aria-hidden="true"></i> 
					{{ trans('messages.lbl_add') }}
				</button>
				<button data-dismiss="modal" 
					class="btn btn-danger CMN_display_block box100">
					<i class="fa fa-times" aria-hidden="true"></i>
					{{ trans('messages.lbl_cancel') }}
				</button>
			</center>
		</div>
	</div>
</div>

{{ Form::close() }}