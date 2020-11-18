@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
{{ HTML::style('resources/assets/css/lib/sweetalert.css') }}

{{ HTML::script('resources/assets/js/EsiMyNo.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/sweetalert.js') }}
{{ HTML::script('resources/assets/js/lib/validation.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}

    <script type="text/javascript">
        var datetime = '<?php echo date('Ymdhis'); ?>';

        $(document).ready(function() {
            setDatePicker("dob");
        });
    </script>
    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left box40 mt10" src="{{ URL::asset('resources/assets/images/insurance.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_esi_mynoDetails') }}</h2>
            <h2 class="pull-left mt15">・</h2> 
            @if(isset($detedit))
            <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
            @else
            <h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
            @endif
      </div>
    </div>

    <div class="" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_5">

    @if(isset($detedit))
    {{ Form::model($detedit, array('name'=>'esiMyNoAddEdit','id'=>'esiMyNoAddEdit','files'=>true, 'method' => 'POST','class'=>'form-horizontal','url' => 'EsiMyNo/addeditprocess?time='.date('YmdHis') ) ) }}
        {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
        {{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
    @else
    {{ Form::open(array('name'=>'esiMyNoAddEdit', 'id'=>'esiMyNoAddEdit', 
                        'class' => 'form-horizontal',
                        'files'=>true,
                        'url' => 'EsiMyNo/addeditprocess?time='.date('YmdHis'), 
                        'method' => 'POST')) }}
        {{ Form::hidden('confirm','1', array('id' => 'confirm')) }}
    @endif
        {{ csrf_field() }}
        {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
        {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
        @if(Session::has('error'))
        <div class="alert-box success" style="text-align: center;color: red;">
          {{ Session::get('error') }}
        </div>
        @endif
        <div class="mb50">
            <fieldset>
            <div class="form-group mt20">
                <label for="Emp_ID" class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_empid') }}</label>
                <div class="col-md-6">
                    <label for="Emp_ID" class="control-label fwb" style="color:{{ getEmpIDColor( $request->Emp_ID) }}">
                        {{ $request->Emp_ID }}
                        {{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="emp_name" class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_empName') }}</label>
                <div class="col-md-6">
                    <label for="emp_name" class="control-label fwb" style="color:#9C0000;">
                        {{ strtoupper($empdetails->FirstName.' '.$empdetails->LastName) }}
                        {{ Form::hidden('Emp_Name', $empdetails->FirstName.' '.$empdetails->LastName , array('id' => 'Emp_Name')) }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="myNo" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_myno') }}
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('myNo',null,array('id'=>'myNo',
                                                    'name' => 'myNo',
                                                    'class'=>'box40per form-control',
                                                    'data-label' => trans('messages.lbl_myno'),
                                                    'maxlength' => 14)) }}
                </div>
            </div>

            <div class="form-group">
                <label for="esiRegDate" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_esi_regdate') }}
                </label>
                <div class="col-md-6">
                    {{ Form::text('esiRegDate',null,array('id'=>'esiRegDate', 
                                                 'name' => 'esiRegDate',
                                                 'maxlength' => '10',
                                                 'onkeypress'=>'return numberonly(event)',
                                                 'autocomplete' => 'off',
                                                 'data-label' => trans('messages.lbl_dob'),
                                                 'class'=>'box19per pull-left form-control dob dateFieldDOB')) }}
                    <label class="mt10 ml4 fa fa-calendar fa-lg" for="esiRegDate" aria-hidden="true"></label>
                    <div class="dateFielderrorDOB CMN_display_inline"></div>
                </div>
            </div>

            <div class="form-group mb35">
                <label for="esiNo" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_esi_no') }}
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('esiNo',null,array('id'=>'esiNo',
                                                     'name' => 'esiNo',
                                                     'class'=>'box40per form-control',
                                                     'data-label' => trans('messages.lbl_esi_no'),
                                                     'maxlength' => 14)) }}
                </div>
            </div>
           
            </fieldset>
            <fieldset style="background-color: #DDF1FA;">
                <div class="form-group">
                    <div align="center" class="mt7">
                        @if(isset($detedit))
                            <button type="submit" class="edit btn btn-warning box100 addeditprocess">
                                <i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
                            </button>
                        @else
                            <button type="submit" class="add btn btn-success box100 addeditprocess">
                                <i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register') }} 
                            </button>
                        @endif
                            <a href="javascript:cancel('index');" class="btn btn-danger box110 ml10">
                                <span class="fa fa-remove"></span>&nbsp;{{ trans('messages.lbl_cancel') }} 
                            </a>
                    </div>
                </div>
            </fieldset>
        </div>
    {{ Form::close() }}
</article>
</div>
    
    <script type="text/javascript">
        var cancel_check = true;
        $('input, select, textarea').bind("change keyup paste", function() {
            cancel_check = false;
        });
    </script>


@endsection