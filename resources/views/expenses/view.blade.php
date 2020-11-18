@extends('layouts.app')
@section('content')
@php use App\Http\Helpers; @endphp

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::script('resources/assets/js/expenses.js') }}

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
  {{ Form::open(array('name'=>'indexform', 'id'=>'indexform', 'url' => 'Expenses/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
    {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
    {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
    {{ Form::hidden('id', '' , array('id' => 'id')) }}
    {{ Form::hidden('expid', '' , array('id' => 'expid')) }}
    {{ Form::hidden('process', '1' , array('id' => 'process')) }}
    {{ Form::hidden('empname', '' , array('id' => 'empname')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('view_plimit', $request->view_plimit , array('id' => 'view_plimit')) }}
    {{ Form::hidden('view_page', $request->view_page , array('id' => 'view_page')) }}
    {{ Form::hidden('index_plimit', $request->index_plimit , array('id' => 'index_plimit')) }}
    {{ Form::hidden('index_page', $request->index_page , array('id' => 'index_page')) }}
    {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
    {{ Form::hidden('subcnfm', '' , array('id' => 'subcnfm')) }}
    {{ Form::hidden('histback', $request->histback , array('id' => 'histback')) }}
    {{ Form::hidden('histbackdup', $request->histback , array('id' => 'histbackdup')) }}
    {{ Form::hidden('totexpind', $request->totexpind , array('id' => 'totexpind')) }}
    {{ Form::hidden('expdate', '' , array('id' => 'expdate')) }}
    {{ Form::hidden('eamount', '' , array('id' => 'eamount')) }}
    {{ Form::hidden('useflg', '' , array('id' => 'useflg')) }}
    {{ Form::hidden('workinghours', $request->totalWorkingHrs , array('id' => 'workinghours')) }}
    {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    <input type="hidden" id="traexpid" name="traexpid" value="<?php echo ($request->empid != '') ? $request->empid: $request->traexpid; ?>">

    <div class="row hline">
        <div class="col-sm-8">
              <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/expenses.png') }}">
              <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_expdetail') }}</h2>
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
        {{--*/ $curdate = date('Y-m-d') /*--}}
        <div class="mt10">
          @if($request->histback == 1)
            <a href="javascript:backtotravel();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
          @elseif($request->flagval == 1)
            <a href="javascript:backtoemployees();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
          @else
            <a href="javascript:gotoBack('index','{{ $request->mainmenu }}');" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
          @endif
          <!-- <a href="javascript:addedit('{{ 'addedit' }}');" class="btn btn-success box100"><span class="glyphicon glyphicon-plus"></span> {{ trans('messages.lbl_register') }}</a> -->
          @if ($request->totalWorkingHrs != "0:00")
            <div class="fwb pull-right pr5 mt10">
              @if (ltrim($request->selMonth,0) == 1) 
                {{--*/ $monthval = $supportArray[1]; /*--}}
              @elseif (ltrim($request->selMonth,0) == 2) 
                {{--*/ $monthval = $supportArray[2]; /*--}}
              @elseif (ltrim($request->selMonth,0) == 3)
                {{--*/ $monthval = $supportArray[3]; /*--}}
              @else
                {{--*/ $monthval = $supportArray[4]; /*--}}
              @endif
              <span>{{ ltrim($request->selMonth,0)}}<sup>{{$monthval}}</sup>{{" ".trans('messages.lbl_month') }}</span>
              <span style="color: brown;font-weight: bold;">
                {{ trans('messages.lbl_totalworkinghours') }}:
              </span>
              <span>
              {{--*/ $timeSplit = explode(":", $request->totalWorkingHrs); /*--}}
              @if ( ($timeSplit[0] > 199 && ($timeSplit[1] > 0 || $timeSplit[1] == 0)) && $request->totalWorkingHrs != "200:00") 
                <span style="color:red;font-weight: bold;" class="fwb">
                  {{ $request->totalWorkingHrs }}
                </span>
              @else
                <span class="fwb">

                  {{ $request->totalWorkingHrs }}
                </span>
              @endif   
              </span>
            </div>
          @endif
        </div>
        <div class="fwb mt10 mb5">
          {{ trans('messages.lbl_empid').':' }}
          <span class="mr40" style="color:{{ getEmpIDColor( $employees['0']->Emp_ID ) }}">
            {{ $employees['0']->Emp_ID }} 
          </span>
            {{ trans('messages.lbl_empName').':' }}
          <span class="mr40" style="color:#9C0000">
            {{ empnamelength($employees['0']->LastName, $employees['0']->FirstName, 200) }}
          </span>
          <label title="Submission Date">
            {{ trans('messages.lbl_dos').':' }}
          </label>
          <span style="font-weight: normal;"> 
          @if($exp_details['0'])
            @if($exp_details['0']->Dof_Submission)
                {{ Helpers::fnYMChangeWareki(preg_replace('/-/', '', $exp_details['0']->Dof_Submission)) }}
            @else
                <span style="color:red;">
                  {{ "Did not Submit" }}
                </span>
            @endif
          @else
              <span style="color:red;">
                {{ "Did not Submit" }}
              </span>
          @endif
          </span>
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
          <span class="pull-right mb5">
            <img src="{{ URL::asset('resources/assets/images'.$previmg) }}" width='17' height='17'
              @if ($prevcount != "0")  
                onclick = "return fndateprev('{{ $preval }}');" class="pageload vam"
              @endif
                {{ $disableprev }} style="{{ $cursorprev }}" >
                <B class="mt100" style="vertical-align: middle;">
                  {{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}
                </B>
            <img src="{{ URL::asset('resources/assets/images'.$nextimg) }}" width='17' height='17'
            @if ($nextcount != "0")
                onclick = "return fndatenext('{{ $nextval }}');" class="pageload vam"
              @endif
              {{ $disablenext }} style="{{ $cursornext }}" >
          </span>
          <a class="pull-right pr15" style="font-weight: normal;" href="javascript:gotohistory();">
                 <i class="fa fa-history" aria-hidden="true"></i> {{ trans('messages.lbl_history') }}
            </a>
            <a class="pull-right pr15" style="font-weight: normal;" href="javascript:gototravel();">
                  <i class="fa fa-exchange" aria-hidden="true"></i> {{ trans('messages.lbl_gototravel') }}
            </a>
        </div>
    <table class="tablealternate box100per" style="word-break: break-all;">
          <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="15%">
            <col width="15%">
            <col width="15%">
            <col width="10%">
            <col width="10%">
            <col width="25%">

          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_date') }}</th>
              <th>{{ trans('messages.lbl_mainsubject') }}</th>
              <th>{{ trans('messages.lbl_subsubject') }}</th>
              <th>{{ trans('messages.lbl_Others') }}</th>
              <th>{{ trans('messages.lbl_amount') }}</th>
              <th>{{ trans('messages.lbl_months') }}</th>
              <th>{{ trans('messages.lbl_remarks') }}</th>
              <!-- <th>{{ trans('messages.lbl_bill') }}</th>
              <th></th> -->
            </tr>
          </thead>
          <tbody>
            {{--*/ $grandtotalval = '0' /*--}}
            {{--*/ $i = '0' /*--}}
            {{--*/ $temp = "" /*--}}
            {{--*/ $img_flag = "" /*--}}
            {{--*/ $dos = "" /*--}}
            {{--*/ $tempdate = false /*--}}
            {{ $style_tr = ""}}
            {{ $style_td = ""}}
            {{--*/ $row = '0' /*--}}
            @forelse($exp_details as $key=>$user)
              @if($tempdate == false && $user->Dof_Submission != "" && $user->Dof_Submission != "0000-00-00")
                    {{--*/ $dos = $user->Dof_Submission /*--}}
                    {{--*/ $tempdate = true /*--}}
              @endif
              @if($temp != $user->Date)
                @if($row==1)
                  {{--*/ $style_tr = 'background-color: #A7CEC9;' /*--}}
                  {{--*/ $row = '0' /*--}}
                @else
                  {{--*/ $style_tr = 'background-color: #FFFFFF;' /*--}}
                  {{--*/ $row = '1' /*--}}
                @endif
                {{--*/ $style_td = 'border-bottom: none;' /*--}}
                {{--*/ $disp_date = $user->Date /*--}}
              @else
                {{--*/ $style_td = 'border-top: none;border-bottom: none;'/*--}}
                {{--*/ $disp_date = '' /*--}}
              @endif
              <tr style="{{$style_tr}}">
                <td class="text-center">
                  {{ ($exp_details->currentpage()-1) * $exp_details->perpage() + $key + 1 }}
                </td>
                <td style="{{$style_td}}" class="text-center">
                  {{ $disp_date }}
                </td>
                <td>
                @if($user->main_sub)
                  {{ $user->main_sub }}
                @else
                  Others
                @endif
                </td>
                <td>
                @if($user->su_sub)
                  {{ $user->su_sub }}
                @else
                  Others
                @endif
                </td>
                <td>
                  {{ $user->Subject }}
                </td>
                <td class="text-right">
                  {{ number_format($user->Amount) }}
                </td>
                <td class="text-center">
                  {{--*/ $explodeMn = explode("-", $user->Month);  /*--}}
                  @if($user->Month != "")
                      @if($user->Month == "99")
                          {{ "NILL" }}
                      @elseif($user->Month == "0")
                          {{ "" }}
                      @else 
                          {{ $user->Month."月" }}
                      @endif
                  @else
                      {{ "" }}
                  @endif
                </td>
                <td>
                    {!! nl2br(e($user->Remark)) !!}
                </td>
                <!-- <td class="text-center">
                  @if($user->Bill_Image != "")
                    {{--*/ $img_flag = 1 /*--}}
                    <a class="glyphicon glyphicon-save td_n" href="javascript:download('{{ $user->Bill_Image }}','../../../../Com.sathisys/ss/emp/img/upload/Expences/');">
                    </a>
                  @endif
                </td>
                <td>
                  <a title="{{ trans('messages.lbl_edit') }}" href="javascript:editcopy('{{ $user->id }}','1');" style="text-decoration:none;" class="glyphicon glyphicon-edit ml10"></a>
                  <a title="{{ trans('messages.lbl_copy') }}" href="javascript:editcopy('{{ $user->id }}','2');" style="text-decoration:none;" class="glyphicon glyphicon-copy ml10"></a>
                  <a title="{{ trans('messages.lbl_move') }}" href="javascript:move('{{ $user->id }}','3','{{ $user->Date }}','{{ $user->Amount }}');" style="text-decoration:none;" class="glyphicon glyphicon-chevron-left ml10"></a>
                </td> -->
            </tr>
            {{--*/ $temp = $user->Date /*--}}
            {{--*/ $i++ /*--}}
            @if($i == count($exp_details) )
              <tr class="bg_lightgrey" style="font-weight:bold;">
                <td colspan="5" class="text-right">{{ trans('messages.lbl_grandtot') }}</td>
                <td class="text-right"><span style="color: blue;">{{ number_format($exp_detailstot[0]->TotAmount) }}</span></td>
                <td colspan="4" style="background-color: white;border-color: white;"></td>
              </tr>
            @endif
            @empty
            <tr>
              <td class="text-center fr" colspan="8">
                {{ trans('messages.lbl_nodatafound') }}
              </td>
            </tr>
          @endforelse
          </tbody>
    </table>
    @if($exp_details[0])
      <div class="mb15 text-center">
        <!-- @if(empty($dos))
          <button type="button" onclick="submitconfirm('1');" class="btn btn-success CMN_display_block box100"></i>{{ trans('messages.lbl_submit') }}</button>
        @else
          @if($exp_details[0]->confirmFlg == 1 || $request->paid_date )
            <span style="color:green;" class="fwb">Confirmed Successfully</span>
          @else
            <button type="button" onclick="submitconfirm('2');" class="btn btn-info active CMN_display_block box100"></i>{{ trans('messages.lbl_Confirm') }}</button>
          @endif
        @endif -->
      </div>
      <!-- @if($img_flag)
        <fieldset>
          <legend align="left" class="ml15" style="width: auto !important; background-color: white; border:none !important;float: left; font-size: 15px; position: relative; margin-top: -20px;">
            <b>{{ trans('messages.lbl_bill') }}</b>
          </legend>
          @for ($i = 0; $i < count($exp_details); $i++)
            @if ($exp_details[$i]->Bill_Image != "" )
              @php 
                if ($exp_details[$i]->Subject != "") {
                  $exp_details[$i]->Subject = $exp_details[$i]->Subject;
                } else {
                  $exp_details[$i]->Subject = $exp_details[$i]->main_sub."->".$exp_details[$i]->su_sub;
                }
              @endphp
              <div class="CMN_div_inblock pull-left ml20">
                <a class="td_n" 
                  href="{{ URL::asset('../../../../Com.sathisys/ss/emp/img/upload/Expences/'.$exp_details[$i]->Bill_Image) }}"
                    data-lightbox="bill-img">
                  <img class="viewPic3by2 pull-left ml10 mt2" 
                    src="{{ URL::asset('../../../../Com.sathisys/ss/emp/img/upload/Expences/'.$exp_details[$i]->Bill_Image) }}">
                </a>
                <div class="mt135 ml5" align="center">
                  {{ $exp_details[$i]->Subject }}
                </div>
              </div>
            @endif
          @endfor
        </fieldset>
      @endif -->
      <div class="fwb mb10 ml15">
        @if(!$exp_details[0]->Dof_Submission)
          <span class="cmn_red">Note : </span>After the final submit, The Employee <span class="cmn_red">( <i>{{ empnamelength($employees[0]->LastName, $employees[0]->FirstName, 30) }}</i> )</span> cannot able to do Register and Edit Operation to the period<span class="cmn_red"> ( <i>{{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}</i> )</span>.
        @else
          <span class="cmn_red">Note : </span>The Employee <span class="cmn_red">( <i>{{ empnamelength($employees[0]->LastName, $employees[0]->FirstName, 30) }}</i> )</span> has already submitted to the period<span class="cmn_red"> ( <i>{{ substr($request->pass_date, 0, 4).' 年 '.substr($request->pass_date, 5, 2).'月' }}</i> )</span>.
        @endif
      </div>
  @endif
</div>
<div class="text-center">
  @if(!empty($exp_details->total()))
    <span class="pull-left mt24 ml15">{{ $exp_details->firstItem() }} ~ {{ $exp_details->lastItem() }} / {{ $exp_details->total() }}</span>
    {{ $exp_details->links() }}
        <div class="CMN_display_block flr">
            {{ $exp_details->linkspagelimit() }}
        </div>
  @endif 
</div>
</div>
{{ Form::close() }}
</article>
</div>
@endsection