    {!! Minify::stylesheet(array(URL::asset('resources/assets/css/lib/bootstrap-datetimepicker.min.css'))) !!}
    {!! Minify::javascript(array(URL::asset('resources/assets/js/lib/bootstrap-datetimepicker.js'))) !!}
<script type="text/javascript">
  var datetime = '<?php echo date('Ymdhis'); ?>';
  var currentdate = '<?php echo date('d'); ?>';
  $( document ).ready(function() {
    setDatePicker("paid_date");
  });
  var easadate = $('#paid_date').val();
  if (easadate == '0000-00-00') {
      $('#paid_date').val('');
  }
  function cancelrevert(){
    if (confirm(cancel_msg)) {
           $('#regpopup').modal('toggle');
    } 
  }
  function formsubmit(currentdate) {
    var d = new Date();
    var current_date = d.getDate();
    if (Date.parse(new Date()) < Date.parse($("#paid_date").val())) { 
      alert("Paid Date should not be Greater than Today's Date");
      return false;
    }
    if($("#paid_date").val() == "") {
      $('#pdval').show();
    } else {
      $('#pdval').hide();
    }
    if($("#paid_date").val() != "") {
      if (confirm("Do you want to confirm the date ?")) { 
      $("#localtravelpopup").submit();
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
    {{ Form::model($paiddate, array('name'=>'localtravelpopup', 'id'=>'localtravelpopup', 'method' => 'POST','class'=>'form-horizontal','url' => 'Travelexp/addeditpd?time='.date('YmdHis') ) ) }}
      {{ Form::hidden('mainmenu', 'expenses_travel' , array('id' => 'mainmenu')) }}
      {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
      {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
      {{ Form::hidden('travelid', $request->travelid , array('id' => 'travelid')) }}
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
                {{ Form::text('paid_date',null,array('id'=>'paid_date', 
                                       'name' => 'paid_date',
                                       'class'=>'box32per pull-left form-control paid_date')) }}
                <label class="mt10 ml4 fa fa-calendar fa-lg" for="paid_date" aria-hidden="true"></label>
                <div id="pdval" class="pull-right mt6 mr25 validationdiv">
                      <strong>{{ "Paid Date field is required." }}</strong>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer popF_color">
            <center>
              @if($request->paiddate == "")
                <button type="button" onclick="formsubmit(currentdate);" class="btn btn-success CMN_display_block box100"><i class="glyphicon glyphicon-plus"></i>Paid</button>
              @else
                <button type="button" onclick="formsubmit();" class="btn btn-warning CMN_display_block box100"><i class="glyphicon glyphicon-edit"></i>{{ trans('messages.lbl_update') }}</button>
              @endif
              <button type="button" onclick="cancelrevert();" class="btn btn-danger CMN_display_block box100"><i class="glyphicon glyphicon-remove"></i>{{ trans('messages.lbl_cancel') }}</button>
            </center>
        </div>
    </div>
    </div>    
{{ Form::close() }}