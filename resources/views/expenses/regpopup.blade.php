    {!! Minify::stylesheet(array(URL::asset('resources/assets/css/lib/bootstrap-datetimepicker.min.css'))) !!}
    {!! Minify::javascript(array(URL::asset('resources/assets/js/lib/bootstrap-datetimepicker.js'))) !!}
<script type="text/javascript">
  var datetime = '<?php echo date('Ymdhis'); ?>';
  $( document ).ready(function() {
    setDatePicker("Paid_Date");
  });
  function cancelrevert(){
    if (confirm(cancel_msg)) {
           $('#regpopup').modal('toggle');
    } 
  }
  function formsubmit(flg) {
    var d = new Date();
    var current_date = d.getDate();
    if (Date.parse(new Date()) < Date.parse($("#Paid_Date").val())) { 
      alert("Paid Date should not be Greater than Today's Date");
      return false;
    }
    if($("#Paid_Date").val() == "") {
      $('#pdvals').hide();
      $('#pdval').show();
      return false;
    } else if(!checkdate($("#Paid_Date").val())) {
      $('#pdval').hide();
      $('#pdvals').show();
      return false;
    } else {
      $('#pdvals').hide();
      $('#pdval').hide();
    }
    if($("#Paid_Date").val() != "") {
      if(flg == "1") {
          if(confirm(err_confreg)) {
              $("#expensespopup").submit();
          } else {
              return false;
          }
      } else {
          if(confirm(err_confup)) {
              $("#expensespopup").submit();
          } else {
              return false;
          }
      }
    }
  }
</script>
<style type="text/css">
  .popupsize {
    margin:auto 32%;
    width:550px;
    height:60%;
  }
  .popF_color {
        background-color: #ccf2ff;
        margin-left: 0px;
        width: 100%;
        border-radius: 0px;
  }
</style>
    {{ Form::model($paiddate, array('name'=>'expensespopup', 'id'=>'expensespopup', 'method' => 'POST','class'=>'form-horizontal','url' => 'Expenses/addeditpd?time='.date('YmdHis') ) ) }}
      {{ Form::hidden('mainmenu', 'expenses_exp' , array('id' => 'mainmenu')) }}
      {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
      {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
      {{ Form::hidden('expid', $request->expid , array('id' => 'expid')) }}
      {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
      {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
      {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
      {{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
    <div class="popupstyle popupsize">
    <div class="modal-content">
        <div class="modal-header popH_color" style="height: 60px;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#10006;</button>
            <h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_paiddate') }}</B></h3>
        </div>
        <div class="form-group" style="min-height: 60px;">
          <div class="col-md-12 mt15">
            <div class="col-md-4 text-right">
                <label class="clr_blue mt8">{{ trans('messages.lbl_paiddate') }}<span class="fr ml2"> * </span></label>
            </div>
            <div class="col-md-8 form-group">
                {{ Form::text('Paid_Date',null,array('id'=>'Paid_Date', 
                                       'name' => 'Paid_Date',
                                       'maxlength' => '10',
                                       'class'=>'box32per pull-left form-control Paid_Date')) }}
                <label class="mt10 ml4 fa fa-calendar fa-lg" for="Paid_Date" aria-hidden="true"></label>
                <div id="pdval" class="pull-right mt6 mr25 validationdiv">
                      <strong>{{ "Paid Date field is required." }}</strong>
                </div>
                <div id="pdvals" class="pull-right mt6 validationdiv">
                      <strong>{{ "Paid Date field is not a valid date." }}</strong>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer popF_color">
            <center>
              @if($request->paiddate == "")
                <button type="button" onclick="formsubmit('1');" class="btn btn-success CMN_display_block box100"><i class="glyphicon glyphicon-plus"></i>Paid</button>
              @else
                <button type="button" onclick="formsubmit('2');" class="btn btn-warning CMN_display_block box100"><i class="glyphicon glyphicon-edit"></i>{{ trans('messages.lbl_update') }}</button>
              @endif
              <button type="button" onclick="cancelrevert();" class="btn btn-danger CMN_display_block box100"><i class="glyphicon glyphicon-remove"></i>{{ trans('messages.lbl_cancel') }}</button>
            </center>
        </div>
    </div>
    </div>    
{{ Form::close() }}