@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
{{ HTML::style('resources/assets/css/lib/sweetalert.css') }}

{{ HTML::script('resources/assets/js/family.js') }}
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
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/family.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_myfamilyDetails') }}</h2>
            <h2 class="pull-left mt15">・</h2> 
            @if(isset($detedit[0]))
            <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
            @else
            <h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
            @endif
      </div>
    </div>

    <div class="" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="staff" class="DEC_flex_wrapper " data-category="staff staff_sub_4">

    @if(isset($detedit[0]))
    {{ Form::model($detedit[0], array('name'=>'familyAddEdit','files'=>true, 'method' => 'POST','class'=>'form-horizontal','url' => 'Family/addeditprocess?time='.date('YmdHis') ) ) }}
        {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
        {{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
        {{ Form::hidden('subRelationType', $detedit[0]->subRelationType, array('id' => 'subRelationType')) }}
    @else
    {{ Form::open(array('name'=>'familyAddEdit', 'id'=>'familyAddEdit', 
                        'class' => 'form-horizontal',
                        'files'=>true,
                        'url' => 'Family/addeditprocess?time='.date('YmdHis'), 
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
                <label for="Emp_ID" class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_empid') }}<span class="fr ml10"></span></label>
                <div class="col-md-6">
                    <label for="Emp_ID" class="control-label fwb" style="color:{{ getEmpIDColor( $request->Emp_ID) }}">
                        {{ $request->Emp_ID }}
                        {{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="emp_name" class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_empName') }}<span class="fr ml10"></span></label>
                <div class="col-md-6">
                    <label for="emp_name" class="control-label fwb" style="color:#9C0000;">
                        {{ strtoupper($empdetails->FirstName.' '.$empdetails->LastName) }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="MartialStatus" class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_maritalstatus') }}<span class="fr ml10"></span></label>
                <div class="col-md-6">
                    <label for="MartialStatus" class="control-label fwb">
                        @if($empdetails->MartialStatus == 1)
                            {{ trans('messages.lbl_single') }}
                        @elseif($empdetails->MartialStatus == 2)
                            {{ trans('messages.lbl_married') }}
                        @else NILL
                        @endif
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_relation') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-1">
                    {{ Form::select('relationType', [null=>''] + $relationArr,null,
                                    ['class' => 'form-control input-sm widthauto',
                                    'id' => 'relationType',
                                    'data-label' => trans("messages.lbl_relation")]) }}
                </div>

                <!-- <div class="col-md-1 ml50" id="subRelationDiv">
                    {{ Form::select('subRelationType', [null=>''] + $subRelationArr,null,
                                    ['class' => 'form-control input-sm widthauto',
                                    'id' => 'subRelationType',
                                    'data-label' => trans("messages.lbl_relation"),]) }}
                </div> -->
            </div>

            <div class="form-group">
                <label for="FirstName" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_firstName') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('FirstName',null,array('id'=>'FirstName', 'name' => 'FirstName','class'=>'box70per form-control',
                                            'data-label' => trans('messages.lbl_firstName'),
                                            'maxlength' => 50)) }}
                </div>
            </div>

            <div class="form-group">
                <label for="LastName" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_lastName') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('LastName',null,array('id'=>'LastName', 'name' => 'LastName','class'=>'box70per form-control',
                                            'data-label' => trans('messages.lbl_lastName'),
                                            'maxlength' => 50)) }}
                </div>
            </div>

            <div class="form-group">
                <label for="Kana_FirstName" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_kanaFirstName') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('Kana_FirstName',null,array('id'=>'Kana_FirstName', 'name' => 'Kana_FirstName','class'=>'box70per form-control',
                                            'data-label' => trans('messages.lbl_kanaFirstName'),
                                            'maxlength' => 50)) }}
                </div>
            </div>

            <div class="form-group">
                <label for="Kana_LastName" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_kanaLastName') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-6" style="display: inline-block;">
                    {{ Form::text('Kana_LastName',null,array('id'=>'Kana_LastName', 'name' => 'Kana_LastName','class'=>'box70per form-control',
                                            'data-label' => trans('messages.lbl_kanaLastName'),
                                            'maxlength' => 50)) }}
                </div>
            </div>

            <div class="form-group">
                <label for="DOB" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_dob') }}<span class="fr ml2"> * </span>
                </label>
                <div class="col-md-6">
                    {{ Form::text('DOB',null,array('id'=>'DOB', 
                                                 'name' => 'DOB',
                                                 'maxlength' => '10',
                                                 'onkeypress'=>'return numberonly(event)',
                                                 'autocomplete' => 'off',
                                                 'readonly' => 'true',
                                                 'data-label' => trans('messages.lbl_dob'),
                                                 'class'=>'box19per pull-left form-control dob dateFieldDOB')) }}
                    <label class="mt10 ml4 fa fa-calendar fa-lg" for="DOB" aria-hidden="true"></label>
                    <div class="dateFielderrorDOB CMN_display_inline"></div>
                </div>
            </div>

            <div class="form-group mb50">
                <label for="liveInJapan" class="col-md-3 control-label clr_blue">
                    {{ trans('messages.lbl_livein_japan') }}
                </label>
                <div class="col-md-6 mt7" style="display: inline-block;">

                    {{ Form::checkbox('liveInJapan', null, (isset($detedit[0]->liveInJapan)) ? $detedit[0]->liveInJapan : 0, ['id' => 'liveInJapan']) }}

                </div>
            </div>
           
            </fieldset>
            <fieldset style="background-color: #DDF1FA;">
                <div class="form-group">
                    <div align="center" class="mt5">
                        @if(isset($detedit[0]))
                            <button type="submit" class="edit btn btn-warning box100 addeditprocess">
                                <i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
                            </button>
                        @else
                            <button type="submit" class="add btn btn-success box100 addeditprocess">
                                <i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register') }} 
                            </button>
                        @endif
                            <a href="javascript:cancel('familyView');" class="btn btn-danger box110 ml10">
                                <span class="fa fa-remove"></span>&nbsp;{{ trans('messages.lbl_cancel') }} 
                            </a>
                    </div>
                </div>
            </fieldset>
        </div>
    {{ Form::close() }}
</article>
</div>

<!-- @if((isset($detedit[0])) && ($detedit[0]->subRelationType == 5 || $detedit[0]->subRelationType == 6 || $detedit[0]->subRelationType == 8 || $detedit[0]->subRelationType == 9))
    <script type="text/javascript">
      $('#subRelationDiv').show();  
    </script>

@else
    <script type="text/javascript">
      $("#subRelationDiv").hide();
    </script>
@endif -->
    
    <script type="text/javascript">
        var cancel_check = true;
        $('input, select, textarea').bind("change keyup paste", function() {
            cancel_check = false;
        });
    </script>


@endsection