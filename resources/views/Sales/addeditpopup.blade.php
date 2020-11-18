    
{{ HTML::script('resources/assets/js/common.js') }}

<script type="text/javascript">

  $( document ).ready(function() {
      $('#periodval').hide();
      $('#salesval').hide();
    
  });

  function formsubmit(val) {

    if($("#period").val() == "" && $("#salesAmount").val() == "") {
      $('#periodval').show();
      $('#salesval').show();
      return false;
    }

    if($("#period").val() == "") {
        $('#periodval').show(); return false;
    }

    if($("#salesAmount").val() == "") {
        $('#salesval').show(); return false;
    }

    if(val == 0){
      var str = "Do you want to Register ?";
    } else {
      var str = "Do you want to Update ?"
    }

    if (confirm(str)) {
        $("#salespopup").submit();
    }
    
  }

  function divpopupclose() {
    if (cancel_check == true) {
        $( "body div" ).removeClass( "modalOverlay" );
        $( '#addeditpopup' ).empty();
        $('#addeditpopup').modal('toggle');
    } else {
        if (confirm(cancel_msg)) {
            cancel_check = true;
            $( "body div" ).removeClass( "modalOverlay" );
            $( '#addeditpopup' ).empty();
            $('#addeditpopup').modal('toggle');
        } else {
            return false;
        }
    }
  }


</script>
<style type="text/css">
  .modal {
      width:560px;
      position: fixed;
      top: 27%;
      left: 30%;
   }

</style>
    @if(isset($salesVal))
        {{ Form::model($salesVal, array('name'=>'salespopup',
                                      'id'=>'salespopup',
                                      'method' => 'POST',
                                      'class'=>'form-horizontal',
                                      'url' => 'Sales/addedit?time='.date('YmdHis') ) ) }}
            {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
    @else
        {{ Form::open(array('name'=>'salespopup', 'id'=>'salespopup', 
                            'class' => 'form-horizontal',
                            'url' => 'Sales/addedit?time='.date('YmdHis'), 
                            'method' => 'POST')) }}
            {{ Form::hidden('editpage','addpage', array('id' => 'editpage')) }}
    @endif

      {{ Form::hidden('salesId',$request->id, array('id' => 'salesId')) }}
      {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    
    <div class="modal-content">
        
        <div class="modal-header popH_color" style="height: 60px;">
            <button type="button" onclick="divpopupclose();" class="close" style="color: red !important;" aria-hidden="true">&#10006;</button>

            <span class="modal-title custom_align">
              <h3 class="pull-left pl5 mt10">{{ trans('messages.lbl_sale') }}</h3>
              <h3 class="pull-left mt10">・</h3> 
              @if(isset($salesVal))
                <h3 class="pull-left mt10" style="color:red;">{{ trans('messages.lbl_edit') }}</h3>
              @else
                <h3 class="pull-left mt10" style="color:green;">{{ trans('messages.lbl_register') }}</h3>
              @endif
            </span>
        </div>
        
        <div>
        
          <div class="form-group" style="min-height: 130px;">

              <div class="col-md-12 mt15" style="margin-bottom:-6px;">
                  <div class="col-md-3 text-right">
                      <label class="clr_blue mt2">{{ trans('messages.lbl_period') }}<span class="fr ml2"> * </span></label>
                  </div>
                  <div class="col-md-4 form-group">
                      {{ Form::text('period',null,array('id'=>'period', 'name' => 'period','class'=>'box100per form-control',
                                        'maxlength' => 12,'onkeypress' => 'return isNumberKey(event)')) }}
                  </div>
                  <div id="periodval" class="col-md-5 mt2" style="color: #9C0000;">
                      <strong>{{ "Period is required." }}</strong>
                  </div>
              </div>

              <div class="col-md-12 mt15">
                  <div class="col-md-3 text-right">
                      <label class="clr_blue mt8">{{ trans('messages.lbl_sale') }} {{ trans('messages.lbl_amount') }}<span class="fr ml2"> * </span></label>
                  </div>
                  <div class="col-md-4 form-group">
                        {{ Form::text('salesAmount',null,array('id'=>'salesAmount',
                                                                'name' => 'salesAmount',
                                                                'class'=>'box100per tar pr7 form-control')) }}
                  </div>
                  <div id="salesval" class="col-md-5 mt2" style="color: #9C0000;">
                      <strong>{{ "Sales Amount is required." }}</strong>
                  </div>
              </div>  

            
          </div>

            <div class="modal-footer popF_color">
                <center>
                  @if(!isset($salesVal))
                    <button type="button" onclick="formsubmit(0);" id="add" class="btn btn-success CMN_display_block box100"><i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register') }}</button>
                  @else
                    <button type="button" onclick="formsubmit(1);" id="edit" class="btn btn-warning CMN_display_block box100"><i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}</button>
                  @endif
                  <button type="button" onclick="divpopupclose();" class="btn btn-danger CMN_display_block box100 button" >{{ trans('messages.lbl_cancel') }}</button>
                </center>
            </div>

        </div>
    </div>
{{ Form::close() }}