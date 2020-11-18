@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/NewVisa.js') }}
{{ HTML::script('resources/assets/js/multisearchvalidation.js') }}

{{ HTML::style('resources/assets/css/common.css') }}

{{ HTML::style('resources/assets/css/widthbox.css') }}

{{ HTML::script('resources/assets/css/bootstrap.min.css') }}


{{ HTML::script('resources/assets/js/switch.js') }}
{{ HTML::script('resources/assets/js/hoe.js') }}
{{ HTML::style('resources/assets/css/extra.css') }}
{{ HTML::style('resources/assets/css/hoe.css') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
  
  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';
  </script>

  <style type="text/css">
    .CMN_main_content{
      min-width:1024px;
      max-width: auto;
      float: left;
      display:inline-block;
    }
    .sort_asc {
      background-image:url({{ URL::asset('resources/assets/images/upArrow.png') }}) !important;
    }
    .sort_desc {
      background-image:url({{ URL::asset('resources/assets/images/downArrow.png') }}) !important;
    }
    .disabled{
      pointer-events: none;
      color:grey;
      opacity: 0.5;
      text-decoration: none;
    }
  </style>
<div class="CMN_display_block" id="main_contents">
  <!-- article to select the main&sub menu -->
  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_4">
  <!-- 'action' => 'VisaController@index',  -->
  
    {{ Form::open(array('name'=>'newVisaIndex', 'value'=>'newVisaIndex', 'id'=>'newVisaIndex', 'url' => 'NewVisa/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
    {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('Emp_ID', '' , array('id' => 'Emp_ID')) }}
    {{ Form::hidden('id', '' , array('id' => 'id')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('searchval',1, array('id' => 'searchval')) }}
    <!--  {{ Form::hidden('urlpass','index?time='.date('YmdHis'),array('id' => 'urlpass')) }} -->
    <div class="row hline">
        <div class="col-sm-8">
              <img class="pull-left ml5 mr5 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
              <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_new_visa') }}</h2>
        </div>
    </div>

    <div class="box100per pr10 pl10 mt5">

        <!-- Session msg -->

        @if(Session::has('success'))

          <div align="center" class="alertboxalign" role="alert">

            <p class="alert {{ Session::get('alert', Session::get('type') ) }}">

              {{ Session::get('success') }}

            </p>

          </div>

        @endif

        @php Session::forget('success'); @endphp
         
          <div class="form-group mb10 pt20 pull-right moveleft nodropdownsymbol" id="moveleft">

             {{ Form::select('visasort', $sortarray,
                              $request->visasort,
                              array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
                             'id' => 'visasort',
                             'name' => 'visasort'))
              }}
          </div>
          
        </div>
        <table class="tablealternate CMN_tblfixed">
          <colgroup>
            <col width="5%">
            <col width="12%">
            <col width="30%">
            <col>
          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_empid') }}</th>
              <th>{{ trans('messages.lbl_empName') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($emps as $key=>$user)
              <tr>
                  <td class="text-center">
                    {{ ($emps->currentpage()-1) * $emps->perpage() + $key + 1 }}
                  </td>
                  <td class="text-center">
                      <a style="color:{{ getEmpIDColor( $user->Emp_ID ) }};" href="javascript:gotoView('{{ $user->Emp_ID }}');">{{ $user->Emp_ID }}
                      </a>
                  </td>
                  <td>{{ empnamelength($user->LastName, $user->FirstName, 30) }}</td>
                  
                  
              </tr>
            @empty
                <tr>
                  <td class="text-center fr" colspan="3">
                    {{ trans('messages.lbl_nodatafound') }}
                  </td>
                </tr>
            @endforelse
          </tbody>
        </table>
    </div>

    <div class="text-center">
      @if(!empty($emps->total()))
        <span class="pull-left mt24 ml15">{{ $emps->firstItem() }} ~ {{ $emps->lastItem() }} / {{ $emps->total() }}</span>
          {{ $emps->links() }}
        <span class="pull-right">{{ $emps->linkspagelimit() }}</span>
      @endif 
    </div>

    </article>
  </div>
    {{ Form::close() }}




@endsection