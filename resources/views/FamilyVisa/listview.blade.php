@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/familyvisa.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}


  
  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>

  <div class="CMN_display_block" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">


  <!-- 'action' => 'VisaController@index',  -->
  {{ Form::open(array('name'=>'familyView', 'id'=>'familyView', 'url' => 'FamilyVisa/familyView?time='.date('YmdHis'),'method' => 'POST')) }}
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

    {{ Form::hidden('Emp_ID', $request->Emp_ID , array('id' => 'Emp_ID')) }}
    {{ Form::hidden('editChk', $request->editChk , array('id' => 'editChk')) }}
    <div class="">
      <div class="row hline">
          <div class="col-sm-8">
                <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
                <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_myfamilyDetails') }}</h2>
          </div>
      </div>
      
      <div class="box100per pr10 pl10 mt10">
        <div class="mt10">
          <a href="javascript:gotoEmpVisalist('{{ $empdetails->Emp_ID }}');" class="btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>

          <a href="javascript:register('{{ $empdetails->Emp_ID }}');" class="btn btn-success box100"><span class="fa fa-plus"></span> {{ trans('messages.lbl_register') }}</a>

          <!-- Session msg -->
          @if(Session::has('message'))
            <div align="center" class="alertboxalign">
              <p class="alert {{ Session::get('alert', Session::get('type') ) }}">
                {{ Session::get('message') }}
              </p>
            </div>
          @endif
        <!-- Session msg -->

        </div>



        <div class="fwb mt10 mb10">
          {{ trans('messages.lbl_empid').':' }}
          <span class="mr40" style="color:{{ getEmpIDColor( $empdetails->Emp_ID ) }}">
            {{ $empdetails->Emp_ID }} 
          </span>
            {{ trans('messages.lbl_empName').':' }}
          <span style="color:#9C0000">
            {{ empnamelength($empdetails->LastName, $empdetails->FirstName, 200) }}
          </span>
        </div>

        @php
            $relationArr = array('1'=> trans('messages.lbl_father'),
                   '2'=> trans('messages.lbl_mother'),
                   '3'=> trans('messages.lbl_grandFather'),
                   '4'=> trans('messages.lbl_grandMother'),
                   '5'=> trans('messages.lbl_sister'),
                   '6'=> trans('messages.lbl_brother'),
                   '7'=> trans('messages.lbl_wife'),
                   '8'=> trans('messages.lbl_son'),
                   '9'=> trans('messages.lbl_daughter'));
        @endphp

        <table class="tablealternate CMN_tblfixed mt5">
                  <colgroup>
                    <col width="4%">
                    <col width="12%">
                    <col>
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
                    <col width="8%">
                    <col width="15%">
                    <col width="8%">
                  </colgroup>
                  <thead class="CMN_tbltheadcolor">
                    <tr>
                      <th>{{ trans('messages.lbl_sno') }}</th>
                      <th>{{ trans('messages.lbl_visacardno') }}</th>
                      <th>{{ trans('messages.lbl_name') }}</th>
                      <th>{{ trans('messages.lbl_relationship') }}</th>
                      <th>{{ trans('messages.lbl_Start_date') }}</th>
                      <th>{{ trans('messages.lbl_enddate') }}</th>
                      <th>{{ trans('messages.lbl_noofyears') }}</th>
                      <th>{{ trans('messages.lbl_status') }}</th>
                      <th title="{{ trans('messages.lbl_registerdate_title') }}" >{{ trans('messages.lbl_registerdate') }}</th>
                    </tr>
                  </thead>
                   <tbody>
              @forelse($visaDetails as $key=>$value)
           
                <tr>
                    <td class="text-center">
                      {{ $key + 1 }}
                    </td>
                    <td class="text-center">
                      <a href="javascript:gotosingleView('{{ $value->id }}','{{ $value->Emp_ID }}');">
                        {{ $value->CardNo }}
                      </a>
                    </td>
                    <td title="{{ $value->FirstName.' '.$value->LastName }}">
                      {{ singlefieldlength($value->FirstName.' '.$value->LastName,20) }}
                    </td>

                    <td class="text-center">
                       <!--  @if($value->Emp_Relation == 1)
                          {{ trans('messages.lbl_wife') }}
                        @elseif($value->Emp_Relation == 2)
                          {{ trans('messages.lbl_son') }}
                        @elseif($value->Emp_Relation == 3)
                          {{ trans('messages.lbl_daughter') }}
                        @endif -->

                        {{ $relationArr[$value->Emp_Relation] }}

                    </td>

                    <td class="text-center">{{ $value->StDate }}</td>
                    <td class="text-center">{{ $value->EdDate }}</td>
                    <td class="text-center">{{ $value->NoYears }}</td>
                    
                    <td>{{ $value->VisaStatus }}</td>
                    
                    <td class="text-center">
                      @if ($value->CreatedDateTime != "0000-00-00 00:00:00" && $value->CreatedDateTime != "")
                        {{ substr($value->CreatedDateTime,0,11) }}
                      @endif
                    </td>
                </tr>
            @empty
                <tr>
                  <td class="text-center fr" colspan="9">
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