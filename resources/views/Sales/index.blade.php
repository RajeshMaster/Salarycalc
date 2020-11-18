@extends('layouts.app')

@section('content')

  <script type="text/javascript">
    var datetime = '<?php echo date('Ymdhis'); ?>';

    function pageClick(pageval) {
      $('#page').val(pageval);
      $("#salesIndex").submit();
    }

    function pageLimitClick(pagelimitval) {
      $('#page').val('');
      $('#plimit').val(pagelimitval);
      $("#salesIndex").submit();
    }

    function addedit(mainmenu,page,id ='') {
        $('#addeditpopup').load(page+'?id='+id+'&mainmenu='+mainmenu+'&time='+datetime);
        $("#addeditpopup").modal({
                backdrop: 'static',
                keyboard: false
            });
        $('#addeditpopup').modal('show');
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
  </style>
<div class="CMN_display_block" id="main_contents">
  <!-- article to select the main&sub menu -->
  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_3">
  <!-- 'action' => 'VisaController@index',  -->
  
    {{ Form::open(array('name'=>'salesIndex', 'value'=>'salesIndex', 'id'=>'salesIndex', 'url' => 'Sales/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
    
    {{ csrf_field() }}
    
    {{ Form::hidden('sortOptn',$request->visasort , array('id' => 'sortOptn')) }}
    {{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
    {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
    {{ Form::hidden('id', '' , array('id' => 'id')) }}
    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}

    <div class="row hline">
        <div class="col-sm-8">
              <img class="pull-left ml5 box40 mt10" src="{{ URL::asset('resources/assets/images/salesdetails.png') }}">
              <h2 class="pull-left pl10 mt15">{{ trans('messages.lbl_salesdetails') }}</h2>
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

          <div class="col-xs-6 ml10 mt10 mb10 pm0 pull-left">

            <a onclick="javascript:addedit('sales','addeditpopup','');" class="btn btn-success box100">
              <span class="fa fa-plus"></span> {{ trans('messages.lbl_register') }}
            </a>

          </div>

        </div>

        <div class="mt10 minheight380">
            <table class="tablealternate CMN_tblfixed">
              <colgroup>
                <col width="6%">
                <col width="20%">
                <col width="20%">
                <col width="5%">
                <col>
              </colgroup>
              <thead class="CMN_tbltheadcolor">
                <tr>
                  <th>{{ trans('messages.lbl_sno') }}</th>
                  <th>{{ trans('messages.lbl_period') }}</th>
                  <th>{{ trans('messages.lbl_sale') }} {{ trans('messages.lbl_amount') }}</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse($salesDetails as $key=>$sales)
                  <tr>

                      <td class="text-center">
                        {{ ($salesDetails->currentpage()-1) * $salesDetails->perpage() + $key + 1 }}
                      </td>
                      <td class="text-center">
                          {{ $sales->period }}
                      </td>
                      <td class="tar">
                          ¥ {{ $sales->salesAmount }}
                      </td>

                      @if($key == 0)
                        <td class="text-center">
                            <a style="cursor: pointer; color: red; font-size: 20px;">
                              <i class="fa fa-edit" onclick="javascript:addedit('sales','addeditpopupEdit','{{ $sales->id }}');"></i>
                            </a>
                        </td>
                      @else
                        <td></td>
                      @endif

                  </tr>
                @empty
                    <tr>
                      <td class="text-center fr" colspan="4">
                        {{ trans('messages.lbl_nodatafound') }}
                      </td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>

    </div>

    <div class="text-center">
      @if(!empty($salesDetails->total()))
        <span class="pull-left mt24 ml15">{{ $salesDetails->firstItem() }} ~ {{ $salesDetails->lastItem() }} / {{ $salesDetails->total() }}</span>
          {{ $salesDetails->links() }}
        <span class="pull-right">{{ $salesDetails->linkspagelimit() }}</span>
      @endif 
    </div>

  </article>
</div>

    {{ Form::close() }}

    <div id="addeditpopup" class="modal fade">
        <div id="login-overlay">
            <div class="modal-content">
                <!-- Popup will be loaded here -->
            </div>
        </div>
    </div>

@endsection