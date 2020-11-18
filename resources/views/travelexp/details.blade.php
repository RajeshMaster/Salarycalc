@extends('layouts.app')

@section('content')

@php use App\Http\Helpers; @endphp
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/travelexp.js') }}

  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
    $('.btn_staffexpenses').addClass('active');
  </script>
  <style type="text/css">
    .bg_lightgrey {
    background-color:#D3D3D3    ! important;
    }
  </style>
  <div class="CMN_display_block" id="main_contents">
  <!-- article to select the main&sub menu -->
  <article id="expenses" class="DEC_flex_wrapper " data-category="staffexpenses totexp_sub_1">
    {{ Form::open(array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
        {{ csrf_field() }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
        {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
        {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
        {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
        {{ Form::hidden('parentmonth', $request->parentmonth , array('id' => 'parentmonth')) }}
        {{ Form::hidden('parentyr', $request->parentyr , array('id' => 'parentyr')) }}
        {{ Form::hidden('travelid', '' , array('id' => 'travelid')) }}
        {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
        {{ Form::hidden('traexpid', $request->traexpid , array('id' => 'traexpid')) }}
        {{ Form::hidden('useflg', '' , array('id' => 'useflg')) }}
        {{ Form::hidden('subcnfm', '' , array('id' => 'subcnfm')) }}
        {{ Form::hidden('histback', $request->histback  , array('id' => 'histback')) }}
        {{ Form::hidden('histbackdup', $request->histback , array('id' => 'histbackdup')) }}
        {{ Form::hidden('totexpind', $request->totexpind , array('id' => 'totexpind')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        <input type="hidden" id="empid" name="empid" value="<?php echo ($request->traexpid != '') ? $request->traexpid: $request->empid; ?>">

        <div class="row hline">
            <div class="col-sm-8">
                  <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/localtravel.png') }}">
                  <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_localtravel') }}</h2>
            </div>
        </div>
        <!-- Session msg -->
@if(Session::has('message'))
  <div align="center" class="mt10 alertboxalign">
    <p class="alert {{ Session::get('alert', Session::get('type') ) }}">
      {{ Session::get('message') }}
    </p>
    @php Session::forget('message') @endphp
  </div>
@endif
<!-- Session msg -->
        <div class="box100per pr10 pl10 mt10">
          <div class="mb10 mt10">
             @if($request->histback == 1)
              <a href="javascript:gobackexpense();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
             @elseif($request->flagval == 1)
              <a href="javascript:backtoemployees();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
            @else
              <a href="javascript:back();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
            @endif
            <!-- <a href="javascript:addedit();" class="btn btn-success box100 mr2"><span class="glyphicon glyphicon-plus"></span>{{ trans('messages.lbl_register') }}</a> -->
            @if($preval == "0") 
              {{--*/ $previmg = "/previousdisab.png" /*--}}
              {{--*/ $disableprev = "disabled" /*--}}
              {{--*/ $cursorprev = "cursor:default;vertical-align:middle;" /*--}}
            @else
              {{--*/ $previmg = "/previousenab.png" /*--}}
              {{--*/ $disableprev = "" /*--}}
              {{--*/ $cursorprev = "cursor:pointer;" /*--}}
            @endif
            @if($nextval == "0")
              {{--*/ $nextimg = "/nextdisab.png" /*--}}
              {{--*/ $disablenext = "disabled" /*--}}
              {{--*/ $cursornext = "cursor:default;vertical-align:middle;" /*--}}
            @else
              {{--*/ $nextimg = "/nextenab.png" /*--}}
              {{--*/ $disablenext = "" /*--}}
              {{--*/ $cursornext = "cursor:pointer;" /*--}}
            @endif
            <span class="pull-right mt8">
              <img src="{{ URL::asset('resources/assets/images'.$previmg) }}" width='20' height='20'
                @if ($prevcount != "0")  
                  onclick = "return fndateprev('{{ $preval }}');" class="pageload vam"
                @endif
                  {{ $disableprev }} style="{{ $cursorprev }}" >
                  <B>
                    {{ substr($request->pass_date, 0, 4).' 年 '.ltrim(substr($request->pass_date, 5, 2), "0").'月' }}
                  </B>
              <img src="{{ URL::asset('resources/assets/images'.$nextimg) }}" width='20' height='20'
              @if ($nextcount != "0")
                  onclick = "return fndatenext('{{ $nextval }}');" class="pageload vam"
                @endif
                {{ $disablenext }} style="{{ $cursornext }}" >
            </span>
            @if(count($exelcount) > 0 )
              <a class="pull-right mt10 pr10" onclick="return confirmdownload();" href="{{ url('Travelexp/Download?pass_date='.$request->pass_date.'&traexpid='.$employees[0]->Emp_ID ) }}">
                    {{ trans('messages.lbl_exceldownload') }}
              </a>
              <a class="fa fa-arrow-down td_n pull-right pr5 mt12" href="{{ url('Travelexp/Download?pass_date='.$request->pass_date.'&traexpid='.$employees[0]->Emp_ID ) }}"></a>
            @endif
            <a class="pull-right mt10 pr15" href="javascript:gotohistory();">
                  <i class="fa fa-history" aria-hidden="true"></i> {{ trans('messages.lbl_history') }}
            </a>
            <a class="pull-right mt10 pr15" href="javascript:gotoexpense();">
                  <i class="fa fa-exchange" aria-hidden="true"></i> {{ trans('messages.lbl_go_to_expenses') }}
            </a>
          </div>
          <table class="table table-striped table-bordered CMN_tblfixed">
            <colgroup>
              <col width="15%">
              <col width="35%">
              <col width="15%">
              <col width="35%">
            </colgroup>
            <tbody>
              <tr>
                <td class="fwb CMN_tbltheadcolor text-center" colspan="4">
                  {{ trans('messages.lbl_localtravelexpense') }}
                </td>
              </tr>
              <tr>
                <td class="fwb CMN_tbltheadcolor text-center">{{ trans('messages.lbl_period') }}</td>
                <td colspan="3" style="background-color: white;">
                  {{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}
                </td>
              </tr>
              <tr>
                <td class="fwb CMN_tbltheadcolor text-center" title="Submission Date">{{ trans('messages.lbl_dateofsubmission') }}</td>
                <td style="background-color: white;">
                @if(count($employees) > 0)
                  @if($employees[0]->dofsubmission)
                    {{ Helpers::fnYMChangeWareki(preg_replace('/-/', '', $employees[0]->dofsubmission)) }}
                  @else
                    <span style="color:red;">Did Not Submitted</span>
                  @endif
                @else
                  <span style="color:red;">{{ trans('messages.lbl_nodatafound') }}</span>
                @endif
                </td>
                <td class="fwb CMN_tbltheadcolor text-center">{{ trans('messages.lbl_designation') }}</td>
                <td style="background-color: white;">

                  @if((isset($fnGetEmpDetails[0]->DesignationNM)) && ($fnGetEmpDetails[0]->DesignationNM != ''))
                    {{ $fnGetEmpDetails[0]->DesignationNM }}
                  @endif
                  </td>
              </tr>
              <tr>
                <td class="fwb CMN_tbltheadcolor text-center">{{ trans('messages.lbl_employeno') }}</td>
                <td style="background-color: white;">{{ $fnGetEmpDetails[0]->Emp_ID }}</td>
                <td class="fwb CMN_tbltheadcolor text-center">{{ trans('messages.lbl_empName') }}</td>
                <td style="background-color: white;">
                  {{ empnamelength($fnGetEmpDetails[0]->LastName, $fnGetEmpDetails[0]->FirstName, 30) }}{{ ' ( '.$fnGetEmpDetails[0]->KanaLastName.' )' }}
                </td>
              </tr>
            </tbody>
          </table>
          <table class="tablealternate box100per" style="word-break: break-all;">
          <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="16%">
            <col width="12%">
            <col>
            <col width="7%">
            <col width="2%">
            <col width="2%">
            <col width="10%">
            <col width="7%">
            <col width="8%">
          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_date') }}</th>
              <th>{{ trans('messages.lbl_client') }}</th>
              <th>{{ trans('messages.lbl_modeoftravel') }}</th>
              <th>{{ trans('messages.lbl_from') .' ~ '. trans('messages.lbl_to') }}</th>
              <th colspan="3">{{ trans('messages.lbl_amount') }}</th>
              <th>{{ trans('messages.lbl_total') }}</th>
              <th>{{ trans('messages.lbl_month') }}</th>
              <th title="Registered Date">{{ trans('messages.lbl_registerdate') }}</th>
            </tr>
          </thead>
          <tbody>
            {{--*/ $grandtotalval = '0' /*--}}
            {{--*/ $i = '0' /*--}}
            {{--*/ $tempdate = false /*--}}
            {{--*/ $dos = "" /*--}}
            @forelse($employees as $key=>$user)
              @if($tempdate == false && $user->dofsubmission != "" && $user->dofsubmission != "0000-00-00")
                  {{--*/ $dos = $user->dofsubmission /*--}}
                  {{--*/ $tempdate = true /*--}}
              @endif
            {{--*/ $mode_val = '1' /*--}}
              @if ($user->trip != 3) 
                {{--*/ $mode_val = $user->trip /*--}}
              @endif
            <tr>
              <td class="text-center" style="vertical-align: middle;"> 
                {{ $i + 1 }}
              </td>
              <td class="text-center" style="vertical-align: middle;">
                {{ intval(substr($user->date, 5, 2)).'月'.substr($user->date, 8, 2).'日' }}
                @if ($user->trip == 3) 
                  </BR>{{ '~' }}</BR>
                  {{ intval(substr($user->enddate, 5, 2)).'月'.substr($user->enddate, 8, 2).'日' }}
                @endif
              </td>
              <td class="text-left" style="vertical-align: middle;" @if(strlen($user->client) > 17))
              title="{{ singlefieldlength($user->client,100) }}" @endif>
              {{ singlefieldlength($user->client,17) }}</td>
              <td class="text-left" style="vertical-align: middle;">
                @if($user->mode_of_travel == 5)
                  {{ $user->others }}
                @else
                  {{ Helpers::fnGetTravelMode($user->mode_of_travel) }}
                @endif
              </td>
              <td class="text-left" style="vertical-align: middle;">{{ $user->travel_from .' ~ '. $user->travel_to }}</td>
              <td class="text-right" style="vertical-align: middle;">{{ number_format($user->amount) }}</td>
              <td class="text-center" style="vertical-align: middle;">{{ 'X' }}</td>
              <td class="text-center" style="vertical-align: middle;">{{ $mode_val }}</td>
              <td class="text-right" style="vertical-align: middle;">
                {{ number_format($user->amount * $mode_val).' 円' }}
                @if($user->use_flg == "0")
                  {{--*/ $grandtotalval += $user->amount * $mode_val /*--}}
                @endif
              </td>
              <td class="text-center" style="vertical-align: middle;">
                @if ($user->trip == 3) 
                  {{ intval(substr($user->month, 5, 2)).'月' }}
                @endif
              </td>
              <td class="text-center" style="vertical-align: middle;">{{ ltrim(substr($user->created_time, 0, 10),"0") }}</td>
              <!-- <td class="text-center" style="vertical-align: middle;">
                @if($employees[0]->confirmFlg == 1 || $employees[0]->paid_date )
                @else
                <a title="{{ trans('messages.lbl_edit') }}" href="javascript:editcopy('{{ $user->id }}','1');" style="text-decoration:none;" class="glyphicon glyphicon-edit mr5"></a>
                @endif
                <a title="{{ trans('messages.lbl_copy') }}" href="javascript:editcopy('{{ $user->id }}','2');" style="text-decoration:none;" class="glyphicon glyphicon-copy"></a>
              </td> -->
              <!-- <td class="text-center" style="vertical-align: middle;">
                @if ($user->use_flg == 1)
                  <a style="color:red;" onclick="return confirmusage();" href="javascript:usenotuse('{{ $user->id }}','1');">Not Use</a>
                @else
                  <a style="color:blue;" onclick="return confirmusage();" href="javascript:usenotuse('{{ $user->id }}','2');">Use</a>
                @endif
              </td> -->
            </tr>
            {{--*/ $i++ /*--}}
            @if($i == count($employees) )
              <tr class="bg_lightgrey" style="font-weight:bold;">
                <td colspan="8" class="text-right">{{ trans('messages.lbl_grandtot') }}</td>
                <td class="text-right"><span style="color: blue;">{{ number_format($grandtotalval).' 円' }}</span></td>
                <td style="background-color: white;border-color: white;"></td>
              </tr>
            @endif
            @empty
            <tr>
              <td class="text-center fr" colspan="11">
                {{ trans('messages.lbl_nodatafound') }}
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
        @if($fnGetEmpDetails && $employees)
          <div class="mb15 text-center">
           <!--  @if(empty($dos))
              <button type="button" onclick="submitconfirm('1');" class="btn btn-success CMN_display_block box100"></i>{{ trans('messages.lbl_submit') }}</button>
            @else
              @if($employees[0]->confirmFlg == 1 || $employees[0]->paid_date )
                <span style="color:green;" class="fwb">Confirmed Successfully</span>
              @else
                <button type="button" onclick="submitconfirm('2');" class="btn btn-info active CMN_display_block box100"></i>{{ trans('messages.lbl_Confirm') }}</button>
              @endif
            @endif -->
          </div>
          <div class="fwb mb10">
            @if(!$employees[0]->dofsubmission)
              <span class="cmn_red">Note : </span>After the final submit, The Employee <span class="cmn_red">( <i>{{ empnamelength($fnGetEmpDetails[0]->LastName, $fnGetEmpDetails[0]->FirstName, 30) }}</i> )</span> cannot able to do Register and Edit Operation to the period<span class="cmn_red"> ( <i>{{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}</i> )</span>.
            @else
              <span class="cmn_red">Note : </span>The Employee <span class="cmn_red">( <i>{{ empnamelength($fnGetEmpDetails[0]->LastName, $fnGetEmpDetails[0]->FirstName, 30) }}</i> )</span> has already submitted to the period<span class="cmn_red"> ( <i>{{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}</i> )</span>.
            @endif
          </div>
        @endif
      </div>
    {{ Form::close() }}
</article>
</div>
@endsection

