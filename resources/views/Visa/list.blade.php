@extends('layouts.app')

@section('content')

{{ HTML::style('resources/assets/css/lib/bootstrap-datetimepicker.min.css') }}

{{ HTML::script('resources/assets/js/lib/bootstrap-datetimepicker.js') }}
{{ HTML::script('resources/assets/js/visa.js') }}
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
    $(document).ready(function() {
      var singlesearch = document.getElementById("singlesearch");
      singlesearch.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
         event.preventDefault();
         $('#advsearch').click();
        }
      });
      var msearchempid = document.getElementById('msearchempid');
      msearchempid.addEventListener('keyup', function(event) {
        if (event.keyCode === 13) {
         event.preventDefault();
         $('#addeditsearch').click();
        }
      });
      var msearchempname = document.getElementById('msearchempname');
      msearchempname.addEventListener('keyup', function(event) {
        if (event.keyCode === 13) {
         event.preventDefault();
         $('#addeditsearch').click();
        }
      });
      var msearchstdate = document.getElementById('msearchstdate');
      msearchstdate.addEventListener('keyup', function(event) {
        if (event.keyCode === 13) {
         event.preventDefault();
         $('#addeditsearch').click();
        }
      });
      var msearcheddate = document.getElementById('msearcheddate');
      msearcheddate.addEventListener('keyup', function(event) {
        if (event.keyCode === 13) {
         event.preventDefault();
         $('#addeditsearch').click();
        }
      });
    });  

    function mulclick(divid){
      if($('#'+divid).css('display') == 'block'){
        document.getElementById(divid).style.display = 'none';
        document.getElementById(divid).style.height= "240px";
      }else {
        document.getElementById(divid).style.display = 'block';
      }
    }

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
  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_1">
  <!-- 'action' => 'VisaController@index',  -->
  
    {{ Form::open(array('name'=>'visaform', 'value'=>'visaform', 'id'=>'visaform', 'url' => 'Visa/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
    {{ csrf_field() }}
    {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
    {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('visaid', '' , array('id' => 'visaid')) }}
    {{ Form::hidden('id', '' , array('id' => 'id')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('searchval',1, array('id' => 'searchval')) }}
    <!--  {{ Form::hidden('urlpass','index?time='.date('YmdHis'),array('id' => 'urlpass')) }} -->
    <div class="row hline">
        <div class="col-sm-8">
              <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/visarenew.png') }}">
              <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_visa_details') }}</h2>
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

        <!-- Session msg -->
          <!-- <a href="{{ url('Visa/addedit') }}" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> Register
          </a> -->
        <div class="box100per">
          {{ Form::button(
                    trans('messages.lbl_all'),
                    array('class'=>'pageload btn btn-link '.$disabledall,
                          'style'=>'padding-left:2px;',
                          'type'=>'button',
                          'onclick'=>'javascript:return filter(4)'))  
          }}
            <span>|</span>
          {{ Form::button(
                   trans('messages.lbl_existing'),
                   array('class'=>'pageload btn btn-link '. $disabledex,
                         'type'=>'button',
                         'onclick' => 'javascript:return filter(1)')) 
         }}
          <span>|</span>
          @if ($request->mainmenu != "contract_visa")
            {{ Form::button(
                     trans('messages.lbl_sathisys'),
                     array('class'=>'pageload btn btn-link '. $disabledss,
                           'type'=>'button',
                           'onclick' => 'javascript:return filter(2)')) 
            }}
          <span>|</span>
          @endif
          {{ Form::button(
                   trans('messages.lbl_completed'),
                   array('class'=>'pageload btn btn-link '. $disabledcm,
                         'type'=>'button',
                         'onclick' => 'javascript:return filter(3)')) 
          }}
          <div class="form-group mb10 pt20 pull-right moveleft nodropdownsymbol" id="moveleft">
              <!-- <a href="javascript:importpopupenable('{{ $request->mainmenu }}');" style="color:blue;" class="mr10 mt2 pb15 box30">
                <img class="box22 mr7 mb5" src="{{ URL::asset('resources/assets/images/copy.png') }}">{{ trans('messages.lbl_import_expenses') }}
              </a> -->
             {{ Form::select('visasort', $sortarray,
                              $request->visasort,
                              array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
                             'style' => $sortMargin,
                             'id' => 'visasort',
                             'name' => 'visasort'))
              }}
          </div>
          @if($emps[0] != "" || $emps[0] != array())
          <div class="mb5">
          <a class="fa fa-download" aria-hidden="true"  href="javascript:visadetailsdownload('downloadexcel');">
                  </a>
                  <a class="" href="javascript:visadetailsdownload('downloadexcel');">
                       Visa Details Download
                  </a> 
          </div>
          @endif
        </div>
        <table class="tablealternate CMN_tblfixed">
          <colgroup>
            <!-- <col width="3%">
            <col width="6%">
            <col width="14%">
            <col width="8%">
            <col width="4%">
            <col width="7%">
            <col width="7%">
            <col width="12%">
            <col width="13%">
            <col width="4%">
            <col width="5%"> -->
            <col width="4%">
            <col width="11%">
            <col>
            <col width="15%">
            <col width="14%">
            <col width="14%">
            <col width="11%">
          </colgroup>
          <thead class="CMN_tbltheadcolor">
            <tr>
              <th>{{ trans('messages.lbl_sno') }}</th>
              <th>{{ trans('messages.lbl_empid') }}</th>
              <th>{{ trans('messages.lbl_empName') }}</th>
              <th>{{ trans('messages.lbl_visacardno') }}</th>
              <th>{{ trans('messages.lbl_NoofYears') }}</th>
              <!-- <th>{{ trans('messages.lbl_start_date') }}</th> -->
              <th>{{ trans('messages.lbl_enddate') }}</th>
              <!-- <th>{{ trans('messages.lbl_status') }}</th> -->
              <!-- <th>{{ trans('messages.lbl_position') }}</th> -->
              <!-- <th>{{ trans('messages.lbl_img') }}</th> -->
              <th>{{ trans('messages.lbl_validity') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($emps as $key=>$user)
              <tr>
                  <td class="text-center">
                    {{ ($emps->currentpage()-1) * $emps->perpage() + $key + 1 }}
                  </td>
                  <td class="text-center">
                      @if ($user->Validity >= "1")
                        <a style="color:{{ getEmpIDColor( $user->user_id ) }};" href="javascript:gotoView('{{ $user->user_id }}',{{ $user->id }},'{{ $request->mainmenu }}',1);">
                      @elseif ($user->Validity < "1")
                        <a style="color:{{ getEmpIDColor( $user->user_id ) }};" href="javascript:gotoView('{{ $user->user_id }}','1','{{ $request->mainmenu }}',2);">
                      @endif
                        {{ $user->user_id }}
                      </a>
                  </td>
                  <td>{{ empnamelength($user->LastName, $user->FirstName, 30) }}</td>
                  <td>{{ $user->CardNo }}</td>
                  <td class="text-center">{{ $user->NoYears }}</td>
                  <!-- <td class="text-center">{{ $user->StDate }}</td> -->
                  <td class="text-center">{{ $user->EdDate }}</td>
                  <!-- <td>{{ $user->VisaNM }}</td> -->
                  <!-- <td title="{{ $user->VisaPosNM }}">{{ singlefieldlength($user->VisaPosNM,17) }}</td> -->
                  @if($user->days_diff === 0)
                    <td class="text-center" style="font-weight: bold;color: blue; ">
                        1
                    </td>
                  @else
                    <td class="text-center"
                       @if ($user->days_diff == '')
                          @if ($user->Validity  < 90)
                             style="color:red;font-weight:bold;"
                          @endif>
                             @if ($user->Validity  < 0)
                                -
                             @else
                                {{ $user->Validity }}
                             @endif
                       @else
                          @if ($user->Validity  < 90)
                             style="color:blue;font-weight:bold;"
                          @endif>
                              @if ($user->Validity  < 0)
                                {{ $user->days_diff+1 }}
                             @else
                                {{ $user->days_diff+1 }}
                             @endif
                       @endif
                    </td>
                  @endif
              </tr>
            @empty
                <tr>
                  <td class="text-center fr" colspan="7">
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

    <div @if ($request->singlesearch != "" || $request->searchmethod == 2) 
            class="open CMN_fixed mt120" 
         @else 
            class="CMN_fixed mt120" 
         @endif 
            id="styleSelector">
        <div class="selector-toggle" id="movesorting">
          <a href="javascript:void(0)" onclick="closepopover();"></a>
        </div>
        <ul>
            <li>
               <p class="selector-title">{{ trans('messages.lbl_visa_search') }}</p>
            </li>
            <li class="theme-option">
               <div class="box100per mt5 ml5">
                  {!! Form::text('singlesearch', trim($request->singlesearch),
                    array('','class'=>'form-control ml2 box60per','style'=>'height:30px;','id'=>'singlesearch')) !!}
                  {{ Form::button('<i class="fa fa-search" aria-hidden="true"></i> ', 
                          array('class'=>'ml2 search box15per btn btn-info btn-sm', 
                                'type'=>'button',
                                'name' => 'advsearch',
                                'id' => 'advsearch',
                                'onclick'=> 'singlesearchclick();',
                                'style'=>'border: none;' 
                                )) }}
                  <a href="javascript:clearsearch()" title="Clear Search" class="pull-left">
                    <img class="box30" src="{{ URL::asset('resources/assets/images/clearsearch.png') }}">
                  </a>
               </div>
            </li>
        </ul>

        <div class="mt5 ml12 pull-left mb5">
            <a onclick="mulclick('demo');" class="" style="font-family: arial, verdana;cursor: pointer;">{{ trans('messages.lbl_multi_search') }}</a>
        </div>
        
        <div>
            <ul id="demo" @if ($request->searchmethod == 2) class="collapse in ml5 pull-left" @else class="collapse ml5 pull-left"  @endif>
              <li class="theme-option" style="display: block!important;">
                <span class="mt2">{{ trans('messages.lbl_empid') }}</span>
                <div class="mt5 box95per">
                  {!! Form::text('msearchempid', trim($request->msearchempid),
                       array('',
                       'id' => 'msearchempid',
                       'class'=>'form-control')) !!}
                </div>

                <div class="mt5">
                    <span class="pt3">{{ trans('messages.lbl_empName') }}</span>
                    <div class="mt5 box95per">
                        {!! Form::text('msearchempname', trim($request->msearchempname),
                                  array('',
                                  'id' => 'msearchempname',
                                  'class'=>'form-control')) !!}
                    </div>
                </div>

                <!-- DATE TIME PICKER -->
                <div class="mt5"> 
                    <span class="">{{ trans('messages.lbl_enddate') }}</span>
                    <div class="box100per mt5">
                    {{ Form::hidden('dateFielderror','', array('id' => 'dateFielderror')) }}
                      {!! Form::text('msearchstdate', $request->msearchstdate,
                                    array('',
                                        'id'=>'msearchstdate','data-placement'=>'left', 
                                        'style="font-size:12px;padding-left:7px;"',
                                        'class'=>'form-control box40per pull-left from_date dateField'
                                        )) !!}
                      <label class="ml1 mt8 fa fa-calendar fa-lg pull-left" for="msearchstdate" aria-hidden="true"></label>
                       {!! Form::text('msearcheddate', $request->msearcheddate,
                                     array('',
                                     'style="font-size:12px;padding-left:7px;"','data-placement'=>'left',
                                     'class'=>'form-control box40per pull-left to_date dateField',
                                     'id'=>'msearcheddate')) !!}
                      <label class="ml1 mt8 fa fa-calendar fa-lg" for="msearcheddate" aria-hidden="true"></label>
                    </div>
                </div>
                <!-- END DATE TIME PICKER -->
                <div class="mt5 mb6">
                      {{ Form::button(
                         '<i class="fa fa-search" aria-hidden="true"></i> '.trans('messages.lbl_search'),
                         array('id' => 'addeditsearch','name' => 'addeditsearch','class'=>'mt10 btn btn-info btn-sm addeditprocess',
                               'type'=>'submit')) 
                     }}
                </div>
              </li>
            </ul>
        </div> 



    </article>
  </div>
    {{ Form::close() }}

    <div id="importpopup" class="modal fade">
        <div id="login-overlay">
            <div class="modal-content">
                <!-- Popup will be loaded here -->
           </div>
        </div>
    </div>

    {{ Form::open(array('name'=>'exceldownloadform', 'value'=>'exceldownloadform', 'id'=>'exceldownloadform', 'url' => 'Visa/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
      {{ csrf_field() }}
        {{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::close() }}

@endsection