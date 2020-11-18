    
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/visa.js') }}


<script type="text/javascript">
  $( document ).ready(function() {
      $('#apval').hide();
      $('#adval').hide();
      $('#rpval').hide();
      $('#advals').hide();
      $('#rdcdvals').hide();
      $('#rdval').hide();
      $('#adcdval').hide();
      $('#rdcdval').hide();
      var val = $('input:radio[name=visapurpose]:checked').val();
      if($("#editpage").val() == "editpage" && val == "2") {
        $('input[name=visapurpose]').attr("disabled",true);
      }
      if(val=='1') { 
        $('#return').hide();
        $('#apply').show();
      } else {
        $('#apply').hide();
        $('#return').show();
      }
    $("input[name=visapurpose]:radio").change(function () {
      if($('#visapurpose1').is(':checked')) { 
        $('#return').hide();
        $('#apply').show();
      } else {
        $('#apply').hide();
        $('#return').show();
      }
    });
  });
  function formsubmit() {
    var curdate = '<?php echo date("Y-m-d"); ?>';
    var val = $('input:radio[name=visapurpose]:checked').val();
    if(val=='1') {

      if($("#applydate").val() == "") {
        $('#advals').hide();
        $('#adval').show();
      } else if(!checkdate($('#applydate').val())) {
        $('#adval').hide();
        $('#advals').show();
      } else if($("#applydate").val() > curdate) {
        $('#advals').hide();
        $('#adval').hide();
        $('#adcdval').show();
      } else {
        $('#adcdval').hide();
        $('#adval').hide();
        $('#advals').hide();
      }

      if($("#appliedplace").val() == "") {
        $('#apval').show();
      } else {
        $('#apval').hide();
      }
      if($("#applydate").val() != "" && $("#appliedplace").val() != "" && $("#applydate").val() <= curdate) {
        if (confirm("Do you want to Apply Visa Date ? ")) {
          $("#visapopup").submit();
        }
      }
    } else {
      if($("#returneddate").val() == "") {
        $('#rdcdvals').hide();
        $('#rdval').show();
      } else if(!checkdate($('#returneddate').val())) {
        $('#rdval').hide();
        $('#rdcdvals').show();
      } else if($("#returneddate").val() > curdate) {
        $('#rdcdvals').hide();
        $('#rdcdval').show();
      } else {
        $('#rdcdvals').hide();
        $('#rdcdval').hide();
        $('#rdval').hide();
      }
      if($("#returnedplace").val() == "") {
        $('#rpval').show();
      } else {
        $('#rpval').hide();
      }
      if($("#returneddate").val() != "" && $("#returnedplace").val() != "" && $("#returneddate").val() <= curdate) {
        if (confirm("Do you want to Apply Visa Date ? ")) {
        $("#visapopup").submit();
        }
      }
    }
  }
  function divpopupclose() {
    if (cancel_check == true) {
        $( "body div" ).removeClass( "modalOverlay" );
        $( '#applydatepopup' ).empty();
        $('#applydatepopup').modal('toggle');
    } else {
        if (confirm(cancel_msg)) {
            cancel_check = true;
            $( "body div" ).removeClass( "modalOverlay" );
            $( '#applydatepopup' ).empty();
            $('#applydatepopup').modal('toggle');
        } else {
            return false;
        }
    }
  }

  function checkdate(doj){
    var validformat=/^\d{4}\-\d{2}\-\d{2}$/; 
    var returnval=false;
    if(!validformat.test(doj)){
    return false;
    }
    return true;
  }


</script>
<style type="text/css">
  .modal {
      width:720px;
      position: fixed;
      top: 25%;
      left: 25%;
   }

</style>
    @if(isset($applydateval))
        {{ Form::model($applydateval, array('name'=>'visapopup', 'id'=>'visapopup', 'method' => 'POST','class'=>'form-horizontal','url' => 'Visa/addeditpopup?time='.date('YmdHis') ) ) }}
            {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
    @else
        {{ Form::open(array('name'=>'visapopup', 'id'=>'visapopup', 
                            'class' => 'form-horizontal',
                            'url' => 'Visa/addeditpopup?time='.date('YmdHis'), 
                            'method' => 'POST')) }}
            {{ Form::hidden('editpage','addpage', array('id' => 'editpage')) }}
    @endif

      {{ Form::hidden('visaid', $request->visaid , array('id' => 'visaid')) }}
      {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
      {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    
    <div class="modal-content">
        
        <div class="modal-header popH_color" style="height: 60px;">
            <button type="button" onclick="divpopupclose();" class="close" style="color: red !important;" aria-hidden="true">&#10006;</button>
            <h3 class="modal-title custom_align"><B>Visa Date</B></h3>
        </div>
        
        <div>
        
          <div class="form-group" style="min-height: 130px;">
              <div class="col-md-12 mt15" style="margin-bottom:-6px;">
                  <div class="col-md-4 text-right">
                      <label class="clr_blue mt2">{{ trans('messages.lbl_visapurpose') }}<span class="fr ml2"> * </span></label>
                  </div>
                  <div class="col-md-8 form-group">
                      <label style="font-weight: normal;">
                          {{ Form::radio('visapurpose', '1', true, array('name' => 'visapurpose','class' => 'mt0','id' => 'visapurpose1')) }}
                          {{ trans('messages.lbl_applied') }}
                      </label>
                      <label style="font-weight: normal;">
                          {{ Form::radio('visapurpose', '2', false, array('name' => 'visapurpose','class' => 'ml10 mt0','id' => 'visapurpose2')) }}
                          {{ trans('messages.lbl_returned') }}
                      </label>
                  </div>
              </div>

              <div id="apply">
                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <label class="clr_blue mt8">{{ trans('messages.lbl_applieddate') }}<span class="fr ml2"> * </span></label>
                        </div>
                        <div class="col-md-8 form-group">
                              {{ Form::text('applydate', null,array('id'=>'applydate', 
                                            'name' => 'applydate',
                                            'maxlength' => '10',
                                            'class'=>'box24per pull-left form-control from_date')) }}
                              <label class="mt10 ml4 fa fa-calendar fa-lg" for="applydate" aria-hidden="true"></label>
                            <div id="adval" class="pull-right mt6 mr108" style="color: #9C0000;">
                                <strong>{{ "The Applied Date field is required." }}</strong>
                            </div>
                            <div id="advals" class="pull-right mt6 mr112" style="color: #9C0000;display: none;">
                                <strong>{{ "Start date is not a Valid Date." }}</strong>
                            </div>
                            <div id="adcdval" class="pull-right mt6 mr112" style="color: #9C0000;">
                                <strong>{{ "Must Be Less Than Current Date." }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4 text-right">
                            <label class="clr_blue mt4">{{ trans('messages.lbl_appliedplace') }}<span class="fr ml2"> * </span></label>
                        </div>
                        <div class="col-md-8 form-group">
                              {{ Form::select('appliedplace', [null=>'Please Select'] + $visaplace, null,
                                          ['class' => 'form-control input-sm widthauto', 'id' => 'appliedplace']) }}
                            <div id="apval" class="pull-right mt6 mr102" style="color: #9C0000;">
                                <strong>{{ "The Applied Place field is required." }}</strong>
                            </div>
                        </div> 
                    </div>
              </div>

            <div id="return">
                <div class="col-md-12">
                    <div class="col-md-4 text-right">
                        <label class="clr_blue mt8">{{ trans('messages.lbl_returneddate') }}<span class="fr ml2"> * </span></label>
                    </div>
                    <div class="col-md-8 form-group">
                          {{ Form::text('returneddate',null,array('id'=>'returneddate', 
                                        'maxlength' => '10',
                                        'name' => 'returneddate',
                                        'class'=>'box23per pull-left form-control from_date')) }}
                          <label class="mt10 ml4 fa fa-calendar fa-lg" for="returneddate" aria-hidden="true"></label>
                        <div id="rdval" class="pull-right mt6 mr97" style="color: #9C0000;">
                            <strong>{{ "The Returned Date field is required." }}</strong>
                        </div>
                        <div id="rdcdvals" class="pull-right mt6 mr112" style="color: #9C0000;display: none;">
                            <strong>{{ "Start date is not a Valid Date." }}</strong>
                        </div>
                        <div id="rdcdval" class="pull-right mt6 mr112" style="color: #9C0000;">
                            <strong>{{ "Must Be Less Than Current Date." }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-4 text-right">
                        <label class="clr_blue mt4">{{ trans('messages.lbl_returnedplace') }}<span class="fr ml2"> * </span></label>
                    </div>
                    <div class="col-md-8 form-group">
                          {{ Form::select('returnedplace',
                                      [null=>'Please Select',1=>'To India',2=>'To Japan'], null,
                                      ['class' => 'form-control input-sm widthauto', 'id' => 'returnedplace']) }} 
                        <div id="rpval" class="pull-right mt6 mr92" style="color: #9C0000;">
                            <strong>{{ "The Returned Place field is required." }}</strong>
                        </div>
                    </div> 
                </div>
            </div>
          </div>

            <div class="modal-footer popF_color">
                <center>
                  @if(!isset($applydateval))
                    <button type="button" onclick="formsubmit();" id="add" class="btn btn-success CMN_display_block box100"><i class="fa fa-plus"></i>{{ trans('messages.lbl_register') }}</button>
                  @else
                    <button type="button" onclick="formsubmit();" id="edit" class="btn btn-warning CMN_display_block box100"><i class="fa fa-edit"></i>{{ trans('messages.lbl_update') }}</button>
                  @endif
                  <button type="button" onclick="divpopupclose();" class="btn btn-danger CMN_display_block box100 button" >{{ trans('messages.lbl_cancel') }}</button>
                </center>
            </div>

        </div>
    </div>
{{ Form::close() }}