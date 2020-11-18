@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/visa.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}


  
  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>

  <div class="CMN_display_block" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">


  <!-- 'action' => 'VisaController@index',  -->
  {{ Form::open(array('name'=>'visaform', 'id'=>'visaform', 'url' => 'Visa/index?time='.date('YmdHis'),'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
    {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    {{ Form::hidden('visasort',$request->visasort , array('id' => 'visasort')) }}
    {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('visaid', $request->visaid , array('id' => 'visaid')) }}
    {{ Form::hidden('id', '' , array('id' => 'id')) }}
    {{ Form::hidden('empname', '' , array('id' => 'empname')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('singlesearch', $request->singlesearch , array('id' => 'singlesearch')) }}
    {{ Form::hidden('msearchempid', $request->msearchempid , array('id' => 'msearchempid')) }}
    {{ Form::hidden('msearchempname', $request->msearchempname , array('id' => 'msearchempname')) }}
    {{ Form::hidden('msearchstdate', $request->msearchstdate , array('id' => 'msearchstdate')) }}
    {{ Form::hidden('msearcheddate', $request->msearcheddate , array('id' => 'msearcheddate')) }}
    <div class="">
   <div class="row hline">
        <div class="col-sm-8">
              <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
              <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_visa_details') }}</h2>
        </div>
    </div>
    <div class="box100per pr10 pl10 mt10">
        <div class="mt10">
          <a href="javascript:gotoBack('index', '{{ $request->byindex }}');" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>

          <a href="javascript:familyVisa('{{ $request->visaid }}');" class="pull-right mt15 fwb">
                {{ trans('messages.lbl_myfamilyDetails') }}
          </a>

        </div>
        @foreach($empdet as $key=>$userdet)
        <div class="fwb mt5">
          {{ trans('messages.lbl_empid').':' }}
          <span class="mr40" style="color:{{ getEmpIDColor( $userdet->Emp_ID ) }}">
            {{ $userdet->Emp_ID }} 
          </span>
            {{ trans('messages.lbl_empName').':' }}
          <span style="color:#9C0000">
            {{ empnamelength($userdet->LastName, $userdet->FirstName, 200) }}
          </span>
        @endforeach
        </div>
        <table class="tablealternate CMN_tblfixed mt5">
              <colgroup>
                <col width="4%">
                <col width="10%">
                <!-- <col width="9%">
                <col width="9%"> -->
                <col width="8%">
                <col width="8%">
                <col width="6%">
                <col width="12%">
                <col width="12%">
                <!-- <col width="11%"> -->
                <col width="10%">
              </colgroup>
              <thead class="CMN_tbltheadcolor">
                <tr>
                  <th>{{ trans('messages.lbl_sno') }}</th>
                  <th>{{ trans('messages.lbl_visacardno') }}</th>
                  <!-- <th>{{ trans('messages.lbl_applieddate') }}</th>
                  <th title="{{ trans('messages.lbl_visareceived_title') }}">{{ trans('messages.lbl_visareceived_abr') }}</th> -->
                  <th>{{ trans('messages.lbl_Start_date') }}</th>
                  <th>{{ trans('messages.lbl_enddate') }}</th>
                  <th>{{ trans('messages.lbl_noofyears') }}</th>
                  <th>{{ trans('messages.lbl_status') }}</th>
                  <th>{{ trans('messages.lbl_position') }}</th>
                  <!-- <th>{{ trans('messages.lbl_image') }}</th> -->
                  <th title="{{ trans('messages.lbl_registerdate_title') }}" >{{ trans('messages.lbl_registerdate') }}</th>
                </tr>
              </thead>
               <tbody>
          @forelse($visadetails as $key=>$user)
          <?php
            $total_count = count($visadetails)-1;
            $next_element = "";
            $diff_in_days = "";
            if ($total_count != $key) {
              $next_element = $visadetails[$key+1]->applydate;
            }
            if ($next_element != "" && $next_element != "0000-00-00" && $next_element != null ) {
              $to = \Carbon\Carbon::createFromFormat('Y-m-d', $next_element);
              $from = \Carbon\Carbon::createFromFormat('Y-m-d', $user->StDate);
              // Days Difference
              $diff_in_days = $to->diffInDays($from);
            } else {
              $next_element = "";
            }
          ?>
            <tr>
                <td class="text-center">
                  {{ $key + 1 }}
                </td>
                <td>
                  <a href="javascript:gotosingleView('{{ $user->id }}','{{ $user->user_id }}', '{{ $request->byindex }}');">
                    {{ $user->CardNo }}
                  </a>
                </td>
               <!--  <td class="text-center">{{ $next_element }}</td>
                <td class="text-center">{{ $diff_in_days }}</td> -->
                <td class="text-center">{{ $user->StDate }}</td>
                <td class="text-center">{{ $user->EdDate }}</td>
                <td class="text-center">{{ $user->NoYears }}</td>
                <td>{{ $user->VisaNM }}</td>
                <td title="{{ $user->VisaPosNM }}">{{ singlefieldlength($user->VisaPosNM,17) }}</td>
                <!-- <td class="text-center">
                  @if ($user->Image1 != "")
                    <div class="CMN_div_inblock">
                      <a style="text-decoration:none" href="{{ URL::asset('../../Com.sathisys/ss/img/alien/'.$user->Image1) }}" data-lightbox="visa-img{{ $user->id }}">
                        <img class="pull-left box18" src="{{ URL::asset('resources/assets/images/img_colour.png') }}">
                      </a>
                    </div>
                  @endif
                  @if ($user->Image2 != "")
                    <div class="CMN_div_inblock">
                      <a style="text-decoration:none" href="{{ URL::asset('../../Com.sathisys/ss/img/alien/'.$user->Image2) }}" data-lightbox="visa-img{{ $user->id }}">
                        <img class="pull-left box18" src="{{ URL::asset('resources/assets/images/img_colour.png') }}">
                      </a>
                    </div>
                  @endif
                  @if ($user->Image3 != "")
                    <div class="CMN_div_inblock">
                      <a style="text-decoration:none" href="{{ URL::asset('../../Com.sathisys/ss/img/alien/'.$user->Image3) }}" data-lightbox="visa-img{{ $user->id }}">
                        <img class="pull-left box18" src="{{ URL::asset('resources/assets/images/img_colour.png') }}">
                      </a>
                    </div>
                  @endif
                  @if ($user->Image4 != "")
                    <div class="CMN_div_inblock">
                      <a style="text-decoration:none" href="{{ URL::asset('../../Com.sathisys/ss/img/alien/'.$user->Image4) }}" data-lightbox="visa-img{{ $user->id }}">
                        <img class="pull-left box18" src="{{ URL::asset('resources/assets/images/img_colour.png') }}">
                      </a>
                    </div>
                  @endif
                  @if ($user->Image5 != "")
                    <div class="CMN_div_inblock">
                      <a style="text-decoration:none" href="{{ URL::asset('../../Com.sathisys/ss/img/alien/'.$user->Image5) }}" data-lightbox="visa-img{{ $user->id }}">
                        <img class="pull-left box18" src="{{ URL::asset('resources/assets/images/img_colour.png') }}">
                      </a>
                    </div>
                  @endif

                </td> -->
                <td class="text-center">
                  @if ($user->Ins_DT != "0000-00-00" && $user->Ins_DT != "")
                    {{ $user->Ins_DT }}
                  @endif
                </td>
            </tr>
        @empty
            <tr>
              <td class="text-center fr" colspan="8">
                {{ trans('messages.lbl_nodatafound') }}
              </td>
            </tr>
        @endforelse
        </tbody>
        </table>
      </div>
      </div>
    {{ Form::close() }}

</article>
</div>

    @if($request->byindex=="2")
    {{ Form::open(array('name'=>'backtoview', 'id'=>'backtoview', 'url' => 'Employees/view?time='.date('YmdHis'),'method' => 'POST')) }}
    @else
    {{ Form::open(array('name'=>'backtoindex', 'id'=>'backtoindex', 'url' => 'Employees/index?time='.date('YmdHis'),'method' => 'POST')) }}
    @endif
      {{ csrf_field() }}
      {{ Form::hidden('mainmenu', 'employees_emp' , array('id' => 'mainmenu')) }}
      {{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
      {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
      {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
      {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
      {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
      {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
      {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
      {{ Form::hidden('register', $request->register , array('id' => 'register')) }}
      {{ Form::hidden('employeesort', $request->employeesort , array('id' => 'employeesort')) }}
      {{ Form::hidden('singlesearch', $request->singlesearch , array('id' => 'singlesearch')) }}
      {{ Form::hidden('msearchempid', $request->msearchempid , array('id' => 'msearchempid')) }}
      {{ Form::hidden('msearchempname', $request->msearchempname , array('id' => 'msearchempname')) }}
      {{ Form::hidden('msearchstdate', $request->msearchstdate , array('id' => 'msearchstdate')) }}
      {{ Form::hidden('msearcheddate', $request->msearcheddate , array('id' => 'msearcheddate')) }}
      {{ Form::hidden('defaultmainmenu', $request->defaultmainmenu , array('id' => 'defaultmainmenu')) }}
    {{ Form::close() }}
@endsection