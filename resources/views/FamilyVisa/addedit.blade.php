@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
{{ HTML::style('resources/assets/css/lib/sweetalert.css') }}

{{ HTML::script('resources/assets/js/familyvisa.js') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/sweetalert.js') }}
{{ HTML::script('resources/assets/js/lib/validation.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}

    <script type="text/javascript">
        var datetime = '<?php echo date('Ymdhis'); ?>';

        function getBrowseEnable(id,flg) {
            document.getElementById("imgval"+id).innerHTML = '';
            $('#imgvalemp'+id).hide();
            if (flg == 2) {
                document.getElementById("cambtn"+id).disabled = true;
                document.getElementById("file"+id).disabled = false;
                // document.getElementById("webcamdet"+id).src = "";
                document.getElementById("webcampath"+id).value = "";
            } else {
                document.getElementById("file"+id).disabled = true;
                $('#cambtn'+id).attr('disabled', false);
                document.getElementById("file"+id).value = "";
            }
        }


    </script>
    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
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

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">

    @if(isset($detedit[0]))
    {{ Form::model($detedit[0], array('name'=>'familyVisaAddEdit','files'=>true, 'method' => 'POST','class'=>'form-horizontal','url' => 'FamilyVisa/addeditprocess?time='.date('YmdHis') ) ) }}
        {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
        {{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
    @else
    {{ Form::open(array('name'=>'familyVisaAddEdit', 'id'=>'familyVisaAddEdit', 
                        'class' => 'form-horizontal',
                        'files'=>true,
                        'url' => 'FamilyVisa/addeditprocess?time='.date('YmdHis'), 
                        'method' => 'POST')) }}
        {{ Form::hidden('confirm','1', array('id' => 'confirm')) }}
    @endif
        {{ csrf_field() }}
        {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('visasort',$request->visasort , array('id' => 'visasort')) }}
        {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
        {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('visaid', $request->visaid , array('id' => 'visaid')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('radiono', '' , array('id' => 'radiono')) }}
        {{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
        {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
        {{ Form::hidden('singlesearch', $request->singlesearch , array('id' => 'singlesearch')) }}
        {{ Form::hidden('msearchempid', $request->msearchempid , array('id' => 'msearchempid')) }}
        {{ Form::hidden('msearchempname', $request->msearchempname , array('id' => 'msearchempname')) }}
        {{ Form::hidden('msearchstdate', $request->msearchstdate , array('id' => 'msearchstdate')) }}
        {{ Form::hidden('msearcheddate', $request->msearcheddate , array('id' => 'msearcheddate')) }}
        @if(Session::has('error'))
        <div class="alert-box success" style="text-align: center;color: red;">
          {{ Session::get('error') }}
        </div>
        @endif
        <div>
        <fieldset>
        <div class="form-group">
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
                    {{ strtoupper($empdet->FirstName.' '.$empdet->LastName) }}
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="Gender" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_relationship') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-1">
                {{ Form::select('Emp_Relation', [null=>''] + $Emp_Relation,null,
                                ['class' => 'form-control input-sm widthauto',
                                'id' => 'Emp_Relation',
                                'data-label' => trans("messages.lbl_relationship"),
                                'onchange' => 'javascript:setSubRelation();']) }}
            </div>
            <div class="col-md-1 ml20" id="subRelationDiv">
                {{ Form::select('subRelationType', [null=>''],null,
                                ['class' => 'form-control input-sm widthauto',
                                'id' => 'subRelationType',
                                'data-label' => trans("messages.lbl_relation"),
                                'onchange' => 'javascript:setBasicDetails();']) }}
            </div>
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
            <label for="Gender" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_nationality') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-1">
                {{ Form::select('Nationality', [null=>''] + $Nationality,null,
                                ['class' => 'form-control input-sm widthauto',
                                'id' => 'Nationality',
                                'data-label' => trans("messages.lbl_nationality"),
                                'onchange' => 'javascript:setNation();']) }}
            </div>

            <div class="col-md-3 ml5" id="nationDiv" style="display: inline-block;">
                <label style="font-weight: normal;">
                    {{ Form::text('NationalityOthers',null,array('id'=>'NationalityOthers', 'name' => 'NationalityOthers',
                                        'placeholder' => trans('messages.lbl_Others'),
                                        'class'=>'box70per form-control',
                                        'data-label' => trans('messages.lbl_nationality'),
                                        'maxlength' => 25)) }}
                </label>
                
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

        <div class="form-group">
            <label for="CardNo" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_visacardno') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-6" style="display: inline-block;">
                {{ Form::text('CardNo',null,array('id'=>'CardNo', 'name' => 'CardNo','class'=>'box28per form-control',
                                        'data-label' => trans('messages.lbl_visacardno'),
                                        'maxlength' => 12)) }}
            </div>
        </div>
        <div class="form-group">
            <label for="NoYears" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_noofyears') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-6">
                @if(isset($detedit[0])) 
                    {{ Form::select('NoYears', array('' => '')+ range(1,10), ($detedit[0]->NoYears-1), 
                                            ['class' => 'form-control input-sm widthauto', 'id' => 'NoYears','data-label' => trans('messages.lbl_noofyears'), 
                                            'onchange' => 'javascript:setEnddate();'] ) }}
                @else 
                    {{ Form::select('NoYears', array('' => '')+ range(1,10), '', 
                                             ['class' => 'form-control input-sm widthauto', 'id' => 'NoYears','data-label' => trans('messages.lbl_noofyears'), 
                                            'onchange' => 'javascript:setEnddate();'] ) }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="StDate" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_Start_date') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-6">
                {{ Form::text('StDate',null,array('id'=>'StDate', 
                                             'name' => 'StDate',
                                             'maxlength' => '10',
                                             'onkeypress'=>'return numberonly(event)',
                                             'autocomplete' => 'off',
                                             'data-label' => trans('messages.lbl_Start_date'),
                                             'class'=>'box19per pull-left form-control from_date dateField',
                                             'onchange' => 'javascript:setEnddate();')) }}
                <label class="mt10 ml4 fa fa-calendar fa-lg" for="StDate" aria-hidden="true"></label>
                <div class="dateFielderror CMN_display_inline"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="EdDate" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_enddate') }}
                <span class="fr ml10"></span>
            </label>
            <div class="col-md-6">
                @if(isset($detedit[0]))
                {{ Form::text('EdDated',$detedit[0]->EdDate,array('id'=>'EdDated', 
                                             'name' => 'EdDated',
                                             'class'=>'box19per pull-left form-control','disabled'=>'disabled')) }}
                @else
                {{ Form::text('EdDated',null,array('id'=>'EdDated', 
                                             'name' => 'EdDated',
                                             'class'=>'box19per pull-left form-control','disabled'=>'disabled')) }}
                @endif
                {{ Form::hidden('EdDate', null, array('id' => 'EdDate')) }}
                <label class="mt10 ml2" for="EdDate" aria-hidden="true"></label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="Address" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_address') }}<span class="fr ml2"> * </span>
            </label>
            <div class="col-md-9">

            @if(isset($address[0]->full_address))
                {{ Form::hidden('Address', $address[0]->Address , array('id' => 'Address')) }}
                <label class="col-md-6 mt7">
                    {{ $address[0]->full_address }}
                </label>
            @else
                {{ Form::hidden('Address', '' , array('id' => 'Address')) }}
                <label class="col-md-6 mt7">
                    NILL
                </label>
            @endif

            </div>
        </div>

        <div class="form-group">
            <label for="CardNo" class="col-md-3 control-label clr_blue">
                {{ trans('messages.lbl_visastatus') }}
            </label>
            <div class="col-md-6" style="display: inline-block;">
                {{ Form::text('VisaStatus',null,array('id'=>'VisaStatus', 'name' => 'VisaStatus','class'=>'box70per form-control',
                                        'data-label' => trans('messages.lbl_visastatus'),
                                        'maxlength' => 25)) }}
            </div>
        </div>
       
        </fieldset>
        <fieldset style="background-color: #DDF1FA;">
            <div class="form-group">
                <div align="center" class="mt5">
                    @if(isset($detedit[0]))
                        <button type="submit" class="edit btn btn-warning box100 addeditprocess">
                            <i class="fa fa-edit"></i>{{ trans('messages.lbl_update') }}
                        </button>
                        <a href="javascript:cancel('singleView');" class="btn btn-danger box110"><span class="fa fa-remove"></span>{{ trans('messages.lbl_cancel') }} </a>
                    @else
                        <button type="submit" class="add btn btn-success box100 addeditprocess">
                            <i class="fa fa-plus"></i>{{ trans('messages.lbl_register') }} 
                        </button>
                        <a href="javascript:cancel('familyView');" class="btn btn-danger box110"><span class="fa fa-remove"></span>{{ trans('messages.lbl_cancel') }} </a>
                    @endif
                </div>
            </div>
        </fieldset>
        </div>
    {{ Form::close() }}
</article>
</div>

@if((isset($detedit[0])) && ($detedit[0]->Nationality == 3))
    <script type="text/javascript">
      $('#nationDiv').show();  
    </script>
@elseif((isset($detedit[0])) && ($detedit[0]->Nationality != 3))
    <script type="text/javascript">
      $("#nationDiv").hide();
    </script>
@else
    <script type="text/javascript">
      $("#nationDiv").hide();
    </script>
@endif


<script type="text/javascript">
  $("#subRelationDiv").hide();
</script>

    
<script type="text/javascript">
    var cancel_check = true;
    $('input, select, textarea').bind("change keyup paste", function() {
        cancel_check = false;
    });
</script>


@endsection