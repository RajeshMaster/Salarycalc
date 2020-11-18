@extends('layouts.app')
@section('content')
@php use App\Http\Helpers; @endphp


{{ HTML::script('resources/assets/js/travelexp.js') }}
  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>
  <style type="text/css">
    .bg_lightgrey {
    background-color:#D3D3D3    ! important;
    }
  </style>
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
  {{ Form::open(array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
        {{ csrf_field() }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
        {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
        {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
        {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
        {{ Form::hidden('parentmonth', $request->parentmonth , array('id' => 'parentmonth')) }}
        {{ Form::hidden('parentyr', $request->parentyr , array('id' => 'parentyr')) }}
        {{ Form::hidden('travelid', $request->travelid , array('id' => 'travelid')) }}
        {{ Form::hidden('pass_date', $pass_date , array('id' => 'pass_date')) }}
        {{ Form::hidden('traexpid', '' , array('id' => 'traexpid')) }}
        <div class="row hline">
            <div class="col-sm-8">
                  <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/localtravel.png') }}">
                  <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_localtravel') }}</h2>
            </div>
        </div>
        <div class="box100per pr10 pl10 mt10">
          <div class="mt30 mb15">
            {{ Helpers::displayYear_Month($prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime) }}
          </div>
        <table class="table table-striped table-bordered CMN_tblfixed">
          <colgroup>
            <col width="4%">
            <col width="8%">
            <col>
            <col width="29%">
            <col width="15%">
            <col width="10%">
          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_date') }}</th>
              <th>{{ trans('messages.lbl_employeename') }}</th>
              <th>{{ trans('messages.lbl_company') }}</th>
              <th>{{ trans('messages.lbl_total') }}</th>
              <th>{{ trans('messages.lbl_paiddate') }}</th>
            </tr>
          </thead>
          <tbody>
            {{--*/ $grandtotalval = '0' /*--}}
            {{--*/ $i = '0' /*--}}
            @forelse($employees as $key=>$user)
            <tr>
              <td class="text-center">
                {{ ($employees->currentpage()-1) * $employees->perpage() + $key + 1 }}
              </td>
              <td class="text-center">
                <a style="color:blue" href="javascript:traexpview('{{ $user->Emp_ID }}');">
                  {{ substr($user->created_time, 0, 10) }}
                </a>
              </td>
              <td>
                <a style="color:blue" href="javascript:traexphist('{{ $user->Emp_ID }}');">
                  {{ empnamelength($user->LastName, $user->FirstName, 43) }}
                </a>
              </td>
              <td>{{ singlefieldlength($user->client,40) }}</td>
              <td class="text-right">
                {{ number_format($user->grandtotal) }}
                {{--*/ $grandtotalval += $user->grandtotal /*--}}
              </td>
              <td class="text-center">
                  @if (empty($user->paid_date) || ($user->paid_date == "0000-00-00")) 
                    @if($user->confirmFlg == 1 && !empty($user->dofsubmission))
                      <a href="javascript:paiddatepopup('{{ $user->id }}','{{ $user->paid_date }}','{{ $user->Emp_ID }}');" style ="color:blue;font-weight:bold;text-decoration:none;">Confirmed</a>
                    @elseif (!empty($user->dofsubmission) && ($user->dofsubmission != "0000-00-00")) 
                       <a href="javascript:confirmamount();" style ="color:green;font-weight:bold;text-decoration:none;">
                        {{ trans('messages.lbl_submited') }}
                      </a>
                    @else
                      <a style ="color:grey;font-weight:bold;text-decoration:none;cursor:default;">
                        {{ trans('messages.lbl_submit') }}
                      </a>
                    @endif
                  @else
                    <a href="javascript:paiddatepopup('{{ $user->id }}','{{ $user->paid_date }}','{{ $user->Emp_ID }}');" style ="color:blue;text-decoration:none;">
                      {{ $user->paid_date }}
                    </a>
                  @endif
              </td>
            </tr>
            {{--*/ $i++ /*--}}
            @if($i == count($employees) )
              <tr class="bg_lightgrey" style="font-weight:bold;">
                <td colspan="4" class="text-right">{{ trans('messages.lbl_tot') }}</td>
                <td class="text-right">{{ number_format($travelamout[0]->grandtotals) }}</td>
                <td style="background-color: white;border-color: white;"></td>
              </tr>
            @endif
            @empty
            <tr>
              <td class="text-center fr" colspan="6">
                {{ trans('messages.lbl_nodatafound') }}
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="text-center">
        @if(!empty($employees->total()))
           <span class="pull-left mt24 ml15">{{ $employees->firstItem() }} ~ {{ $employees->lastItem() }} / {{ $employees->total() }}</span>
        {{ $employees->links() }}
        {{ $employees->linkspagelimit() }}
        @endif 
      </div>
    {{ Form::close() }}
    <div id="regpopup" class="modal fade">
      <div id="login-overlay">
          <div class="modal-content">
              <!-- Popup will be loaded here -->
          </div>
      </div>
    </div>
@endsection