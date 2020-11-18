@extends('layouts.app')
@section('content')
    {!! Minify::stylesheet(array(
                        URL::asset('resources/assets/css/lib/bootstrap-datetimepicker.min.css'),
                        URL::asset('resources/assets/css/lib/bootstrap-datepicker3.min.css'))) !!}
    {!! Minify::javascript(array(URL::asset('resources/assets/js/lib/bootstrap-datetimepicker.js'),
                               URL::asset('resources/assets/js/lib/bootstrap-datepicker.min.js'),
                               URL::asset('resources/assets/js/travelexp.js'),
                               URL::asset('resources/assets/js/lib/lightbox.js'))) !!}
  <script type="text/javascript">
  $( document ).ready(function() {
      var datselval = $('input:radio[name=dateselection]:checked').val();
      document.getElementById('datselvalrad').value = datselval;
      if(datselval=='1') { 
        $('#date').show();
        $('#datelab').show();
        $('#multi_date').hide();
        $('#multi_datelab').hide();
      } else {
        $('#date').hide();
        $('#datelab').hide();
        $('#multi_date').show();
        $('#multi_datelab').show();
      }
      var val = $('input:radio[name=trip]:checked').val();
      document.getElementById('tripselvalrad').value = val;
      if(val=='3') { 
        $('input[id=dateselection2]').attr("disabled",true);
        $('#trdt').hide();
        $('#trdtft').show();
        $('#enddate').show();
        $('#spanid').show();
        $('#enddatel').show();
        $('#monthdiv').show();
      } else {
        $('input[id=dateselection2]').attr("disabled",false);
        $('#trdt').show();
        $('#trdtft').hide();
        $('#spanid').hide();
        $('#enddate').hide();
        $('#enddatel').hide();
        $('#monthdiv').hide();
      }
      if($('#mode_of_travel').val() == 5 ) {
        $('#others').show();
      } else {
        $('#others').hide();
      }
      $('#mode_of_travel').on('change', function() { 
        if($('#mode_of_travel').val() == 5 ) {
          $('#others').show();
        } else {
          $('#others').hide();
        }
      });
      $("#mode_of_travel option").each(function()
          {
          if ($(this).val() == 5) {
            $(this).css('font-weight','bold');
            $(this).css('color','brown');
          }
        });
      $("input[name=trip]:radio").change(function () {
        var val = $('input:radio[name=trip]:checked').val();
        document.getElementById('tripselvalrad').value = val;
          if(val=='3') { 
            $('input[id=dateselection2]').attr("disabled",true);
            $('#trdt').hide();
            $('#trdtft').show();
            $('#enddate').show();
            $('#spanid').show();
            $('#enddatel').show();
            $('#monthdiv').show();
          } else {
            $('input[id=dateselection2]').attr("disabled",false);
            $('#trdt').show();
            $('#trdtft').hide();
            $('#spanid').hide();
            $('#enddate').hide();
            $('#enddatel').hide();
            $('#monthdiv').hide();
          }
      });
      $("input[name=dateselection]:radio").change(function () {
        var datselval = $('input:radio[name=dateselection]:checked').val();
        document.getElementById('datselvalrad').value = datselval;
        if(datselval=='1') { 
          $('#date').show();
          $('#datelab').show();
          $('#multi_date').hide();
          $('#multi_datelab').hide();
          $('input[id=trip3]').attr("disabled",false);
        } else {
          $('input[id=trip3]').attr("disabled",true);
          $('#date').hide();
          $('#datelab').hide();
          $('#multi_date').show();
          $('#multi_datelab').show();
        }
      });
      setDatePicker("from_date");
      setDatePicker("end_date");
      $("#multi_date").datepicker({
          multidate : true,
          format: 'yyyy-mm-dd',
          multidateSeparator: ","
      });
    });
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>
  @if(isset($detedit))
    @if($request->useflg == 1)
      {{ Form::model($detedit, array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/edit?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST') ) }}
      {{ Form::hidden('cnfrmsg', '2' , array('id' => 'cnfrmsg')) }}
    @else 
      {{ Form::model($detedit, array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST') ) }}
      {{ Form::hidden('cnfrmsg', '1' , array('id' => 'cnfrmsg')) }}
    @endif
  @else
    {{ Form::open(array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
      {{ Form::hidden('cnfrmsg', '1' , array('id' => 'cnfrmsg')) }}
  @endif
      {{ csrf_field() }}
      {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
      {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
      {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
      {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
      {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
      {{ Form::hidden('travelid', $request->travelid , array('id' => 'travelid')) }}
      {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
      {{ Form::hidden('traexpid', $request->traexpid , array('id' => 'traexpid')) }}
      {{ Form::hidden('sortOptn', $request->travelsort , array('id' => 'sortOptn')) }}
      {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
      {{ Form::hidden('datselvalrad', $request->datselvalrad , array('id' => 'datselvalrad')) }}
      {{ Form::hidden('tripselvalrad', $request->tripselvalrad , array('id' => 'tripselvalrad')) }}
      {{ Form::hidden('expdate', $request->expdate , array('id' => 'expdate')) }}
      <div class="row hline">
        <div class="col-sm-8">
          <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/localtravel.png') }}">
          <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_localtravel') }}</h2>
          <h2 class="pull-left mt15">・</h2> 
          @if(isset($detedit))
            @if($request->useflg == 1)
              <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
            @else
              <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_copy') }}</h2>
            @endif
          @else
          <h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
          @endif
        </div>
      </div>
      @if(isset($request->travelid))
        {{ Form::hidden('localtravel', $request->travelid , array('id' => 'localtravel')) }}
      @endif
      <div class="box100per pr10 pl10 mt10">
        <fieldset>
          <div class="col-md-12">
                <label class="col-md-3 control-label clr_blue text-right">{{ trans('messages.lbl_empid') }}
                <span class="mr10"></span>
                </label>
                <div class="col-md-6  fwb" style="color:{{ getEmpIDColor( $fnGetEmpDetails[0]->Emp_ID ) }}">
                   {{ $fnGetEmpDetails[0]->Emp_ID }}
                </div>
            </div>
          <div class="col-md-12 mt8">
            <label class="col-md-3 control-label clr_blue text-right">{{ trans('messages.lbl_employeename') }}
                  <span class="fr ml10"></span>
            </label>
              <div class="col-md-6 fwb"  style="color:#9C0000">
                    {{ empnamelength($fnGetEmpDetails['0']->LastName, $fnGetEmpDetails['0']->FirstName, 200) }}
                </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8">
              <label for="trip" class="mt2 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_traveltrip') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                <label style="font-weight: normal;">
                    {{ Form::radio('trip', '2', false, array('name' => 'trip','class' => 'tripcls','id' => 'trip1')) }}
                    {{ trans('messages.lbl_roundtrip') }}
                </label>
                <label style="font-weight: normal;">
                    {{ Form::radio('trip', '1', false, array('name' => 'trip','class' => 'tripcls ml10','id' => 'trip2')) }}
                    {{ trans('messages.lbl_oneway') }}
                </label>
                <label style="font-weight: normal;">
                    {{ Form::radio('trip', '3', false, array('name' => 'trip','class' => 'tripcls ml10','id' => 'trip3')) }}
                    {{ trans('messages.lbl_monthlypass') }}
                </label>
                <div class="triperror CMN_display_inline"></div>
              </div>
            </div>
          </div>
          <div class="form-group" id="dateselid">
            <div class="col-md-12 mt8">
              <label for="dateselection" class="mt2 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_dateselection') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                <label style="font-weight: normal;">
                    {{ Form::radio('dateselection', '1', true, array('name' => 'dateselection','id' => 'dateselection1','class' => 'dateselcls')) }}
                    {{ trans('messages.lbl_singletra') }}
                </label>
                <label style="font-weight: normal;">
                    {{ Form::radio('dateselection', '2', false, array('name' => 'dateselection','class' => 'dateselcls ml10','id' => 'dateselection2')) }}
                    {{ trans('messages.lbl_multi') }}
                </label>
                <div class="dateselerror CMN_display_inline"></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8">
              <label id="trdt" for="date" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_traveldate') }}<span class="fr ml2"> * </span>
              </label>
              <label id="trdtft" style="display:none;" for="travel_from" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_traveldate').' ( '. trans('messages.lbl_from') .'~'. trans('messages.lbl_to').' )' }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9" >
                  <input type="text" name="multi_date" class="box35per multidatcls form-control" id="multi_date" style="display: none;">
                  <label id="multi_datelab" class="mt10 ml4 mr7 fa fa-calendar fa-lg" for="multi_date" aria-hidden="true"></label>
                  {{ Form::text('date',null,array('id'=>'date', 
                                                 'name' => 'date',
                                                 'maxlength' => '10',
                                                 'autocomplete' => 'off',
                                                 'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
                                                 'class'=>'box13per CMN_display_inline ime_mode_disable pull-left form-control from_date dateField',
                                                 )) }}
                  <label id="datelab" class="mt10 ml4 mr7 fa fa-calendar fa-lg" for="date" aria-hidden="true"></label>
                  <span id="spanid" class="mr10 mt5" style="display:none;"> ~ </span>
                  {{ Form::text('enddate',null,array('id'=>'enddate', 
                                                 'name' => 'enddate',
                                                 'maxlength' => '10',
                                                 'autocomplete' => 'off',
                                                 'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
                                                 'class'=>'box13per CMN_display_inline ime_mode_disable form-control end_date dateField',
                                                 'style'=>'display:none',
                                                 )) }}
                  <label class="mt10 ml4 fa fa-calendar fa-lg" id="enddatel" for="enddate" aria-hidden="true" style="display:none;"></label>
                <div class="dateFielderror CMN_display_inline"></div>
                <span id="datgreater" class="CMN_display_inline ml3 mt3 validationdiv"><strong>From　Date Should Be Less Than To Date.</strong></span>
              </div>
            </div>
          </div>
          <div class="form-group" id="monthdiv" style="display:none;">
            <div class="col-md-12 mt8">
              <label for="modeoftravel" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_month') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                {{ Form::select('month', $month_array, $request->month,
                                  ['class' => 'form-control input-sm widthauto', 'id' => 'month']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8">
              <label for="client" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_placepurpose') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                  {{ Form::text('client',null,array('id'=>'client', 'name' => 'client','class'=>'box39per form-control')) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8">
              <label for="modeoftravel" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_modeoftravel') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                {{ Form::select('mode_of_travel', [null=>''] + $travel_mode_array, null,
                                  ['class' => 'form-control mt3 mb3 input-sm widthauto', 'id' => 'mode_of_travel']) }}
                {{ Form::text('others',null,array('id'=>'others', 'name' => 'others','class'=>'box25per ml6 ime_mode_disable form-control','style'=>'display:none')) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8">
              <label for="travel_from" class="mt6 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_desitination').' ( '. trans('messages.lbl_from') .'~'. trans('messages.lbl_to').' )' }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9">
                {{ Form::text('travel_from',null,array('id'=>'travel_from',
                                                       'name' => 'travel_from',
                                                       'onkeypress'=>'return fnCheckJap(event)',
                                                       'class'=>'travelcls box17per ime_mode_active form-control')) 
                }}
                <span> ~ </span>
                {{ Form::text('travel_to',null,array('id'=>'travel_to', 
                                                     'name' => 'travel_to',
                                                     'onkeypress'=>'return fnCheckJap(event)',
                                                     'class'=>'travelcls box17per ime_mode_active mr8 form-control'))
                }}
                <a href="javascript:swap();"><span class="glyphicon glyphicon-transfer"></span></a>
                <div class="travelerror CMN_display_inline"></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 mt8 mb10">
              <label for="amount" class="mt5 col-md-3 text-right control-label clr_blue">
                  {{ trans('messages.lbl_amount') }}<span class="fr ml2"> * </span>
              </label>
              <div class="col-md-9 pull-left">
              @if(!empty($amountfield))
                {{ Form::text('amount',$amountfield,array('id'=>'amount',
                                             'name' => 'amount',
                                             'maxlength' => '6',
                                             'style' => 'text-align:right;',
                                             'class'=>'box16per ime_mode_disable form-control amount',
                                             'onkeypress'=>'return numberonly(event)',
                                             'onkeyup'=>'return fnMoneyFormatwithINR(this.id)')) }}
              @else
               {{ Form::text('amount',null,array('id'=>'amount',
                                             'name' => 'amount',
                                             'maxlength' => '6',
                                             'style' => 'text-align:right;',
                                             'class'=>'box16per ime_mode_disable form-control amount',
                                             'onkeypress'=>'return numberonly(event)',
                                             'onkeyup'=>'return fnMoneyFormatwithINR(this.id)')) }}
              @endif
               <div id="amountboxval" class="validationdiv mt5 pull-right CMN_display_inline" style="padding-right: 55%;">
                        <strong>{{ "The Amount Field is required." }}</strong>
                    </div>
              </div>
            </div>
          </div>
        </fieldset>
        <fieldset style="background-color: #DDF1FA;">
            <div class="form-group">
                <div align="center" class="mt5">
                    @if(isset($detedit))
                      @if($request->useflg == 1)
                        <button type="submit" class="add btn btn-warning box100 addeditprocess">
                        <i class="glyphicon glyphicon-edit"></i>{{ trans('messages.lbl_update') }} 
                        </button>
                      @else
                        <button type="submit" class="add btn btn-success box100 addeditprocess">
                        <i class="glyphicon glyphicon-plus"></i>{{ trans('messages.lbl_register') }} 
                        </button>
                      @endif
                    @else
                    <button type="submit" class="add btn btn-success box100 addeditprocess">
                        <i class="glyphicon glyphicon-plus"></i>{{ trans('messages.lbl_register') }} 
                    </button>
                    @endif
                    <a href="javascript:cancel();" class="btn btn-danger box100"><span class="glyphicon glyphicon-remove"></span>{{ trans('messages.lbl_cancel') }} </a>
                </div>
            </div>
        </fieldset>
      </div>
    {{ Form::close() }}
 @if(isset($detedit))
  @if($request->useflg == 2)
    <script type="text/javascript">
      $('input[id=dateselection1]').attr("checked",true);
      document.getElementById('date').value = "";
      document.getElementById('enddate').value = "";
    </script>
  @else
    <script type="text/javascript">
      $('#dateselid').hide();
    </script>
  @endif
@endif
@if($request->useflg == 3)
    <script type="text/javascript">
      $('input[id=dateselection1]').attr("checked",true);
      var date = '{{ $request->expdate }}';
      document.getElementById('date').value = date;
      document.getElementById('enddate').value = "";
    </script>
@endif
<script type="text/javascript">
//Script for Cancel Check//
var cancel_check = true;
$('input, select, textarea').bind("change keyup paste", function() {
    cancel_check = false;
});
</script>
@endsection