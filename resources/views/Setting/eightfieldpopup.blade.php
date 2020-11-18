<script type="text/javascript">

  $(document).ready(function() {

    $('#swaptable1').delegate('tr', 'click' , function(){

      if (event.target.type !== 'radio') {

        if (event.target.nodeName != "SPAN") {

          $(this).find('input[type=radio]').prop('checked', true).trigger("click");

        }

      }

    }

                            );

  }

                   );

  var datetime = '<?php echo date('Ymdhis'); ?>';
  
  function divHide(divId){
    if (divId == 'dataview') {
      $("#editcompanydetails").hide();
      $("#add_var").show();
      $("#update_var").hide();
    }else{
      $("#editcompanydetails").show();
      $("#add_var").hide();
      $("#update_var").hide();
    }
    $("#"+divId).hide();
  }

  function fneditcompanydetails() {
    
    var number;
    var name;
    var branch;
    var capital;
    var address;
    var tel;
    var ceo;
    var referencenumber;

    if ($('#loadafternumber').data('companynumberafterload') != "") {
      number = $('#loadafternumber').data('companynumberafterload');
    }else{
      number = $("#companydata").data("companynumber");
    }

    if ($('#loadaftername').data('companynameafterload') != "") {
      name = $('#loadaftername').data('companynameafterload');
    }else{
      name = $("#companydata").data("companyname");
    }

    if ($('#loadafterbranch').data('companybranchafterload') != "") {
      branch = $('#loadafterbranch').data('companybranchafterload');
    }else{
      branch = $("#companydata").data("companybranch");
    }

    if ($('#loadaftercapital').data('companycapitalafterload') != "") {
      capital = $('#loadaftercapital').data('companycapitalafterload');
    }else{
      capital = $("#companydata").data("companycapital");
    }

    if ($('#loadafteraddress').data('companyaddressafterload') != "") {
      address = $('#loadafteraddress').data('companyaddressafterload');
    }else{
      address = $("#companydata").data("companyaddress");
    }

    if ($('#loadaftertel').data('companytelafterload') != "") {
      tel = $('#loadaftertel').data('companytelafterload');
    }else{
      tel = $("#companydata").data("companytel");
    }

    if ($('#loadafterceo').data('companyceoafterload') != "") {
      ceo = $('#loadafterceo').data('companyceoafterload');
    }else{
      ceo = $("#companydata").data("companyceo");
    }

    if ($('#loadafterreferencenumber').data('companyreferencenumberafterload') != "") {
      referencenumber = $('#loadafterreferencenumber').data('companyreferencenumberafterload');
    }else{
      referencenumber = $("#companydata").data("companyreferencenumber");
    }

    $("#dataview").hide();

    $("#dataviewafterload").hide();

    $("#datainput").show();

    document.getElementById("editcompanydetails").disabled = true;

    $("#add_var").hide();

    $("#update_var").show();

    $('#companyNumber').val(number);

    $('#companyName').val(name);

    $('#companyBranch').val(branch);

    $('#capital').val(capital);

    $('#address').val(address);
    
    $('#TEL').val(tel);

    $('#CEO').val(ceo);

    $('#referencenumber').val(referencenumber);

    return false;
  }

</script>

<style>

  .scrollbar {

    overflow-y: 220px;

    padding: 5px;

    height: 100%;

    width:100%;

    max-width: 100%;

    margin-bottom: 0px;

  }

  .table_Scroll_limit_set{

    overflow-y: scroll;

    overflow-x: hidden;

    height: 214px;

    background-color: #FFFFFF;

  }

  .alertboxalign {

  margin-bottom: -50px !important;

  }

  .alert {

      display:inline-block !important;

      height:30px !important;

      padding:5px !important;

  }

  .modal {

      position: fixed;

      top: 49% !important;

      left: 50%;

      transform: translate(-50%, -50%);

   }

   form-control-plaintext{
      display:block;
      width:100%;
      padding-top:222px;
      padding-bottom:.375rem;
      margin-bottom:0;
      line-height:1.5;
      color:#212529;
      background-color:transparent;
      border:solid transparent;
    }

</style>

@if (count($query) == 0)

  <script>  divHide('dataview');  </script>

@endif @if(count($query) != 0)

  <script>  divHide('datainput');  </script>

@endif

{{ Form::open(array('name'=>'settingform','action' => 'SettingController@index','method'=>'POST',

'files'=>true,'class' => '','id' => 'settingform')) }}

{{ Form::hidden('countryflg', $request->countryflg, array('id' => 'countryflg')) }}

{{ Form::hidden('tableselect', $request->tableselect, array('id' => 'tableselect')) }}

{{ Form::hidden('hid_txtval', '', array('id' => 'hid_txtval')) }}

{{ Form::hidden('hid_txt2val', '', array('id' => 'hid_txt2val')) }}

{{ Form::hidden('hid_txt3val', '', array('id' => 'hid_txt3val')) }}

{{ Form::hidden('editid', '', array('id' => 'editid')) }}

{{ Form::hidden('type', '1', array('id' => 'type')) }}

{{ Form::hidden('process', '1', array('id' => 'process')) }}

{{ Form::hidden('connectto', $request->connectto, array('id' => 'connectto')) }}

{{ Form::hidden('tablename', $request->tablename , array('id' => 'tablename')) }}

{{ Form::hidden('flag', '', array('id' => 'flag')) }}

  <div class="modal-content">

    <div class="modal-header">

      <div class="box98per ml5">

        <div class="col-md-2 pull-right mt10">

          <a data-dismiss="modal" onclick="fnclosepopdig();" class="close fr">

            &#10006; </a>

        </div>

          <div class="box75per ml10  CMN_display_block ">

            <h2 class="fs30 mt5">{{ $headinglbl }}

              </span>

            </h2>

          </div> 

      </div>

    </div>

  <input type="hidden" name="nameval" id="nameval">

  <input type="hidden" name="bid" id="bid">

  <div class="box98per">

    <div align="center" class="alertboxalign" id="popupsessionreg" style="display: none;">

      <p class="alert alert-success">

        Inserted Successfully!

      </p>

    </div>

    <div align="center" class="alertboxalign" id="popupsessionupd" style="display: none;">

      <p class="alert alert-success">

        Updated Successfully!

      </p>

    </div>

    <button id="editcompanydetails" onclick="return fneditcompanydetails();" 

            class="btn btn-warning CMN_display_block box100 flr " 

            >

      <i class="fa fa-edit"></i>

      {{ trans('messages.lbl_edit') }}

    </button>

  </div>

  <div class="mt3 CMN_display_block box100per">
  </div>

  <div class="box96per ml15" id="datainput">

    <fieldset class="h50">

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company_number') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb5">

          {{ Form::text('companyNumber','',array('id' => 'companyNumber',

          'class'=>'box40per form-control ime_mode_disabled','maxlength' => 13

          )) }}

          <label id="empty_companyNumber" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_companyname') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('companyName','',array('id' => 'companyName',

          'class'=>'box40per form-control ime_mode_active','maxlength' => 40

          )) }}

          <label id="empty_companyName" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>  

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_company') }} {{ trans('messages.lbl_branch') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('companyBranch','',array('id' => 'companyBranch',

          'class'=>'box40per form-control ime_mode_active','maxlength' => 40

          )) }}

          <label id="empty_companyBranch" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_company_capital') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('capital','',array('id' => 'capital', 'name' => 'capital',

          'class'=>'box40per form-control ime_mode_active','maxlength' => 40

          )) }}

          <label id="empty_capital" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_address') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('address','',array('id' => 'address',

          'class'=>'box60per form-control ime_mode_active','maxlength' => 60

          )) }}

          <label id="empty_address" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_tel') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('TEL','',array('id' => 'TEL',

          'class'=>'box40per form-control ime_mode_active','maxlength' => 40

          )) }}

          <label id="empty_TEL" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_ceo') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('CEO','',array('id' => 'CEO',

          'class'=>'box60per form-control ime_mode_active','maxlength' => 60

          )) }}

          <label id="empty_CEO" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

      <div class="mt5 col-md-12 ml50">

        <div class="box25per mt5 pull-left text-right clr_blue fwb">

          {{ trans('messages.lbl_reference_number') }}

          <span style="color:red;">*

          </span>

        </div>

        <div class="ml15 pull-left box70per mb10">

          {{ Form::text('referencenumber','',array('id' => 'referencenumber',

          'class'=>'box40per form-control ime_mode_active','maxlength' => 8,

          'onkeypress' =>'return isNumberKey(event)',

          'onblur'=>'this.value=jQuery.trim(this.value);'

          )) }}

          <label id="empty_referencenumber" class="registernamecolor display_none">

           This Field is required.

          </label>

        </div>

      </div>

    </fieldset>

  </div>

  <!--  -->

  <div class="box96per ml15" id="dataview">

    <fieldset class="h50">
      @forelse($query as $count => $data)

      <!--  -->
      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company_number') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['1'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_companyname') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['2'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company') }} {{ trans('messages.lbl_branch') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['3'] }}

        </div>

      </div>  

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company_capital') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['4'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_address') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['5'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_tel') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['6'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_ceo') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['7'] }}

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_reference_number') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          {{ $data->$selectfields['8'] }}

        </div>

      </div>

      <input type="hidden" name="companydata" id="companydata" 
      data-companynumber="{{ $data->$selectfields['1'] }}" data-companyname="{{ $data->$selectfields['2'] }}" 
      data-companybranch="{{ $data->$selectfields['3'] }}" data-companycapital="{{ $data->$selectfields['4'] }}" 
      data-companyaddress="{{ $data->$selectfields['5'] }}" data-companytel="{{ $data->$selectfields['6'] }}" 
      data-companyceo="{{ $data->$selectfields['7'] }}" data-companyreferencenumber="{{ $data->$selectfields['8'] }}">
      @empty
      @endforelse
    </fieldset>

  </div>

  <div class="box96per ml15" id="dataviewafterload" style="display: none;">
    <fieldset class="h50">
      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company_number') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadafternumber" data-companynumberafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_companyname') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadaftername" data-companynameafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company') }} {{ trans('messages.lbl_branch') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadafterbranch" data-companybranchafterload=""></span>

        </div>

      </div>  

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_company_capital') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadaftercapital" data-companycapitalafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_address') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadafteraddress" data-companyaddressafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_tel') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadaftertel" data-companytelafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_ceo') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadafterceo" data-companyceoafterload=""></span>

        </div>

      </div>

      <div class="col-md-12 mt10 ml50">

        <div class="box25per pull-left text-right clr_blue fwb mt5">

          {{ trans('messages.lbl_reference_number') }}

        </div>

        <div class="ml15 pull-left box70per mt5" style="height: 30px;">

          <span id="loadafterreferencenumber" data-companyreferencenumberafterload=""></span>

        </div>

      </div>
    </fieldset>
  </div>
  <!--  -->

  <div class="modal-footer">

    <div class="bg-info pt15 pb15">

    <center>

      <div class="box100per text-center">

        <div class="CMN_display_block" id="add_var">

          <button  id="btnadd" type="button" 

                  onclick="return fnaddeditcompanydetails('company_details',0);" 

                  class="btn btn-success CMN_display_block box100" >

            <i class="fa fa-plus" id="plusicon">

            </i>

            {{ trans('messages.lbl_add') }}

          </button>

        </div>

        <div class="CMN_display_block" id="update_var"  style="display: none;">

          <button id="btnadd" type="button" 

                  onclick="return fnaddeditcompanydetails('company_details',1);" 

                  class="CMN_display_block box100 btn add btn-warning">

            <i class="fa fa-edit" id="plusicon">

            </i>

            {{ trans('messages.lbl_update') }}

          </button>

        </div>

        <button type="button" onclick="divpopupclose();" 

                  class="btn btn-danger CMN_display_block box110 button" >

            <i class="fa fa-remove" aria-hidden="true">

            </i> 

            {{ trans('messages.lbl_cancel') }}

          </button>

      </div>

    </center>

    </div>

  </div>

</div>