@extends('layouts.app')
@section('content')

@php use App\Http\Helpers; @endphp

{{ HTML::script('resources/assets/js/travelexp.js') }}

  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
    $('.btn_staffexpenses').addClass('active');
  </script>
  <style type="text/css">
    .bg_lightgrey {
    background-color:#D3D3D3 ! important;
    }
    .sort_asc {
    background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
    }
    .sort_desc {
      background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
    }
  </style>
<div class="CMN_display_block" id="main_contents">
  <!-- article to select the main&sub menu -->
  <article id="expenses" class="DEC_flex_wrapper " data-category="staffexpenses totexp_sub_1">
{{ Form::open(array('name'=>'travelexpform', 'id'=>'travelexpform', 'url' => 'Travelexp/history?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
      {{ csrf_field() }}
      {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
      {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
      {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
      {{ Form::hidden('indexplimit', $request->indexplimit , array('id' => 'indexplimit')) }}
      {{ Form::hidden('indexpage', $request->indexpage , array('id' => 'indexpage')) }}
      {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
      {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
      {{ Form::hidden('parentmonth', $request->parentmonth , array('id' => 'parentmonth')) }}
      {{ Form::hidden('parentyr', $request->parentyr , array('id' => 'parentyr')) }}
      {{ Form::hidden('travelid', $request->travelid , array('id' => 'travelid')) }}
      {{ Form::hidden('useflg', '' , array('id' => 'useflg')) }}
      {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
      {{ Form::hidden('traexpid', $request->traexpid , array('id' => 'traexpid')) }}
      {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
      {{ Form::hidden('histback', $request->histback , array('id' => 'histback')) }}
      {{ Form::hidden('histbackdup', $request->histbackdup , array('id' => 'histbackdup')) }}
      {{ Form::hidden('totexpind', $request->totexpind , array('id' => 'totexpind')) }}

      <input type="hidden" name="sortOptn" id="sortOptn" value="<?php echo $request->travelsort; ?>">

      <div class="row hline">
          <div class="col-sm-8">
                <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/localtravel.png') }}">
                <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_localtravel') }} History</h2>
          </div>
      </div>
      <div class="box100per pr10 pl10 mt10">
        @if($request->histback == 2)
          <a href="javascript:histbacktra();" class="btn btn-info box80 mb5"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
        @else
          <a href="javascript:backtoindex();" class="btn btn-info box80 mb5"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
        @endif
        @if($fnGetEmpDetails)
        <div class="mt5">
          <B>{{ trans('messages.lbl_empid').':' }}
          <span class="fwb mr40" style="color:{{ getEmpIDColor( $fnGetEmpDetails[0]->Emp_ID ) }}">
            {{ $fnGetEmpDetails[0]->Emp_ID }} 
          </span>
          {{ trans('messages.lbl_empName').':' }}
          <span class="fwb" style="color:#9C0000">
            {{ empnamelength($fnGetEmpDetails[0]->LastName, $fnGetEmpDetails[0]->FirstName, 30) }}
          </span></B>
        @endif
          <div class="form-group pull-right moveleft nodropdownsymbol" style="margin-top: -10px;">
                {{ Form::select('travelsort', $sortarray,
                          $request->travelsort,
                          array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
                         'id' => 'travelsort',
                         'name' => 'travelsort'))
                }}
          </div>
        </div>
        {{--*/ $style_tr = '' /*--}}
        <table class="tablealternate box100per" style="word-break: break-all;">
          <colgroup>
            <col width="6%">
            <col width="10%">
            <col width="15%">
            <col width="25%">
            <col width="20%">
            <col width="10%">
          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_date') }}</th>
              <th>{{ trans('messages.lbl_client') }}</th>
              <th>{{ trans('messages.lbl_modeoftravel') }}</th>
              <th>{{ trans('messages.lbl_from') .' ~ '. trans('messages.lbl_to') }}</th>
              <th>{{ trans('messages.lbl_total') }}</th>
            </tr>
          </thead>
          <tbody>
            {{--*/ $datetmp = '0' /*--}}
            @if(count($empdetails) > 0 )
            @for ($i = 0; $i < count($empdetails); $i++)
              @if($i == 0 )
              <tr class="bg_lightgrey" style="font-weight:bold;">
                  <td colspan="5" class="text-right">{{ trans('messages.lbl_grandtot') }} </td>
                  <td style="color:blue" class="text-right">{{ number_format($historygrandtotal[0]->grandtotal).' 円' }}</td>
              </tr>
              @endif
              @if($datetmp != $empdetails[$i]['date_month'])
                <tr class="bg_lightgrey" style="font-weight:bold;">
                    <td colspan="5" class="text-left">{{ $empdetails[$i]['date_month'] }}</td>
                    <td class="text-right">{{ number_format($empdetails[$i]['SUM']) }}</td>
                </tr>
              @endif
              @if(($i % 2) == 0 ) 
                {{--*/ $style_tr = 'background-color: #FFFFFF;' /*--}}
              @else
                {{--*/ $style_tr = 'background-color: #A7CEC9;' /*--}}
              @endif
            <tr style="{{ $style_tr }}" >
               <td class="text-center">
                {{ $i + $history->firstItem() }}
              </td>
              <td class="text-center">
                  {{ $empdetails[$i]['date_month'] }}
                  {{--*/ $datetmp = $empdetails[$i]['date_month'] /*--}}
              </td>
              <td class="text-left" title="{{ $empdetails[$i]['client'] }}">{{ singlefieldlength($empdetails[$i]['client'],36) }}</td>        
              <td class="text-left">
                @if($empdetails[$i]['mode_of_travel'] == 5)
                  {{ $empdetails[$i]['others'] }}
                @else
                  {{ Helpers::fnGetTravelMode($empdetails[$i]['mode_of_travel']) }}
                @endif
              </td>
              <td class="text-left">
                {{ $empdetails[$i]['travel_from'] .' ~ '. $empdetails[$i]['travel_to'] }}
              </td>
              <td class="text-right">{{ number_format($empdetails[$i]['totalval']) }}</td>
              <!-- <td class="text-center">
                <a title="{{ trans('messages.lbl_copy') }}" href="javascript:editcopy('{{ $empdetails[$i]['id'] }}','2');" style="text-decoration:none;" class="glyphicon glyphicon-copy"></a>
              </td> -->
            </tr>
            @endfor
            @else
            <tr>
              <td class="text-center fr" colspan="6">
                {{ trans('messages.lbl_nodatafound') }}
              </td>
            </tr>
            @endif
          </tbody>
          </table>
      </div>
      <div class="text-center">
        @if(!empty($history->total()))
           <span class="pull-left mt24 ml15">{{ $history->firstItem() }} ~ {{ $history->lastItem() }} / {{ $history->total() }}</span> 
        {{ $history->links() }}
        <div class="CMN_display_block flr">
          {{ $history->linkspagelimit() }}
        </div>
        @endif
      </div>
    {{ Form::close() }}
</article>
</div>
@endsection