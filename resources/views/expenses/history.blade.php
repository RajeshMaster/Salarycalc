@extends('layouts.app')
@section('content')

@php use App\Http\Helpers; @endphp
{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/expenses.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}

  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
    $('.btn_staffexpenses').addClass('active');
  </script>
  <style type="text/css">
    .bg_lightgrey {
      background-color:#D3D3D3    ! important;
    }
    .sort_asc {
      background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
    }
    .sort_desc {
      background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
    }
  </style>                    
<!-- Session msg -->
  @if(Session::has('message'))
    <div align="center" class="mt10 alertboxalign">
      <p class="alert {{ Session::get('alert', Session::get('type') ) }}">
        {{ Session::get('message') }}
      </p>
    </div>
  @endif
  <div class="CMN_display_block" id="main_contents">
    <!-- article to select the main&sub menu -->
  <article id="expenses" class="DEC_flex_wrapper " data-category="staffexpenses totexp_sub_1">
      <!-- Session msg -->
      {{ Form::open(array('name'=>'indexform', 'id'=>'indexform', 'url' => 'Expenses/history?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 'method' => 'POST')) }}
          {{ csrf_field() }}
          {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
          {{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
          {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
          {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
          {{ Form::hidden('id', '' , array('id' => 'id')) }}
          {{ Form::hidden('process', '2' , array('id' => 'process')) }}
          {{ Form::hidden('empname', '' , array('id' => 'empname')) }}
          {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
          {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
          {{ Form::hidden('view_plimit', $request->view_plimit , array('id' => 'view_plimit')) }}
          {{ Form::hidden('view_page', $request->view_page , array('id' => 'view_page')) }}
          {{ Form::hidden('index_plimit', $request->index_plimit , array('id' => 'index_plimit')) }}
          {{ Form::hidden('index_page', $request->index_page , array('id' => 'index_page')) }}
          {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
          {{ Form::hidden('sortOrder',$request->sortOrder , array('id' => 'sortOrder')) }}
          {{ Form::hidden('histback', $request->histback  , array('id' => 'histback')) }}
          {{ Form::hidden('histbackdup', $request->histbackdup , array('id' => 'histbackdup')) }}
          {{ Form::hidden('totexpind', $request->totexpind , array('id' => 'totexpind')) }}    
          <input type="hidden" name="sortOptn" id="sortOptn" value="<?php echo $request->expsort; ?>">

          <div class="row hline">
              <div class="col-sm-8">
                    <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/expenses.png') }}">
                    <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_exphistory') }}</h2>
              </div>
          </div>
          <div class="box100per pr10 pl10 mt10">
              {{--*/ $curdate = date('Y-m-d') /*--}}
              <div class="mt10">
              @if($request->histback == 2)
                <a href="javascript:histbackexp();" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
              @else
                <a href="javascript:gotoBack('index','{{ $request->mainmenu }}');" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
              @endif
              </div>
              <div class="fwb mt10 mb10">
                {{ trans('messages.lbl_empid').':' }}
                <span class="mr40" style="color:{{ getEmpIDColor( $employees['0']->Emp_ID ) }}">
                  {{ $employees['0']->Emp_ID }} 
                </span>
                  {{ trans('messages.lbl_empName').':' }}
                <span class="mr40" style="color:#9C0000">
                  {{ empnamelength($employees['0']->LastName, $employees['0']->FirstName, 200) }}
                </span>
                 <div class="form-group pull-right moveleft nodropdownsymbol" id="moveleft" style="margin-top: -10px;">
                   {{ Form::select('expsort', $sortarray,
                                    $request->expsort,
                                    array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
                                    'id' => 'expsort',
                                    'name' => 'expsort'))
                    }}
                </div>
              </div>
          <table class="tablealternate box100per" style="word-break: break-all;">
                <colgroup>
                  <col width="8%">
                  <col width="10%">
                  <col width="30%">
                  <col width="10%">
                  <col width="10%">
                  <col width="10%">
                </colgroup>
                <thead class="CMN_tbltheadcolor">
                  <tr>
                    <th>{{ trans('messages.lbl_sno') }}</th>
                    <th>{{ trans('messages.lbl_date') }}</th>
                    <th>{{ trans('messages.lbl_subject') }}</th>
                    <th>{{ trans('messages.lbl_amount') }}</th>
                    <th>{{ trans('messages.lbl_remarks') }}</th>
                    <th>{{ trans('messages.lbl_months') }}</th>
                  </tr>
                </thead>
                <tbody>
                  {{--*/ $datetmp = '0' /*--}}
                  {{--*/ $k = '0' /*--}}
                  @if(count($empdetails) > 0 )
                  @for ($i = 0; $i < count($empdetails); $i++)
                    @if($i == 0 )
                      <tr class="bg_lightgrey">
                        <td colspan="3" style="color: black;" class="fwb text-right">{{ trans('messages.lbl_grandtot') }} </td>
                        <td style="color:blue" class="fwb text-right">{{ number_format($grantTotal[0]->SUM).' 円' }}</td>
                        <td colspan="2"></td>
                      </tr> 
                    @endif
                    @if($datetmp != substr($empdetails[$i]['Date'], 0, 7) )
                      <tr class="bg_lightgrey">
                          <td colspan="3" style="color: black;" class="fwb text-left">{{ $empdetails[$i]['date_month'] }}</td>
                          <td style="color: black;" class="fwb text-right">{{ number_format($empdetails[$i]['SUM']) }}</td>
                          <td colspan="2"></td>
                      </tr>
                    @endif
                    @if($datetmp != substr($empdetails[$i]['Date'], 0, 7) ) 
                        @if($k == 0) 
                            {{--*/ $style_tr = 'background-color: #FFFFFF;' /*--}}
                            {{--*/ $k=1 /*--}}
                        @else
                            {{--*/ $style_tr = 'background-color: #A7CEC9;' /*--}}
                            {{--*/ $k=0 /*--}}
                        @endif
                        {{--*/ $style_td = 'border-bottom: none;' /*--}}
                        {{--*/ $disp_date = substr($empdetails[$i]['Date'], 0, 7) /*--}}
                    @else
                        {{--*/ $style_td = 'border-top: none;border-bottom: none;'/*--}}
                        {{--*/ $disp_date = "" /*--}}
                    @endif
                    <tr style="{{ $style_tr }}" >
                       <td class="text-center">
                        {{ $i + $exp_details->firstItem() }}
                      </td>
                      <td class="text-center" style="{{$style_td}}">
                          {{ $disp_date }}
                          {{--*/ $datetmp = substr($empdetails[$i]['Date'], 0, 7) /*--}}
                      </td>
                      <td class="text-left">{{ $empdetails[$i]['Subject'] }}</td>
                      <td class="text-right">{{ number_format($empdetails[$i]['Amount']) }}</td>
                      <td class="text-left">{!! nl2br(e($empdetails[$i]['Remark'])) !!}</td>
                      <td class="text-center">
                        @if($empdetails[$i]['Month'] != "")
                            @if($empdetails[$i]['Month'] == "99")
                                {{ "NILL" }}
                            @elseif($empdetails[$i]['Month'] == "0")
                                {{ "" }}
                            @else 
                                {{ $empdetails[$i]['Month']."月" }}
                            @endif
                        @else
                            {{ "" }}
                        @endif
                      </td> 
      <!--                 <td class="text-center">
                        @if($empdetails[$i]['Bill_Image'] != "")
                          <a class="glyphicon glyphicon-save td_n" href="javascript:download('{{ $empdetails[$i]['Bill_Image'] }}','../../../../Com.sathisys/ss/emp/img/upload/Expences/');">
                          </a>
                        @endif
                      </td>
                      <td>
                        <a title="{{ trans('messages.lbl_copy') }}" href="javascript:editcopy('{{ $empdetails[$i]['id'] }}','2');" style="text-decoration:none;" class="glyphicon glyphicon-copy ml10"></a>
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
        @if(!empty($exp_details->total()))
          <span class="pull-left mt24 ml15">{{ $exp_details->firstItem() }} ~ {{ $exp_details->lastItem() }} / {{ $exp_details->total() }}</span>
            {{ $exp_details->links() }}
            <div class="CMN_display_block flr">
              {{ $exp_details->linkspagelimit() }}
            </div>
         @endif 
      </div>
      {{ Form::close() }}
  </article>
</div>
@endsection