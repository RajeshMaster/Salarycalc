@extends('layouts.app')

@section('content')

{{ HTML::script('resources/assets/js/document.js') }}

    <script type="text/javascript">
        var datetime = '<?php echo date('Ymdhis'); ?>';
    </script>

    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/contractImg.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_document') }}</h2>
            <h2 class="pull-left mt15">・</h2> 
            @if(isset($detedit[0]))
            <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
            @else
            <h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
            @endif
      </div>
    </div>

    <div class="" id="main_contents">

  <!-- article to select the main&sub menu -->

  <article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_6">

    @if(isset($detedit[0]))
        {{ Form::model($detedit[0], array('name'=>'documentAddEdit',
                                         'id'=>'documentAddEdit',
                                         'files'=>true, 'method' => 'POST',
                                         'class'=>'form-horizontal',
                                         'url' => 'Document/addeditprocess?time='.date('YmdHis') ) ) }}
        {{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
        {{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
    @else
        {{ Form::open(array('name'=>'documentAddEdit', 'id'=>'documentAddEdit', 
                        'class' => 'form-horizontal',
                        'files'=>true,
                        'url' => 'Document/addeditprocess?time='.date('YmdHis'), 
                        'method' => 'POST')) }}
        {{ Form::hidden('confirm','1', array('id' => 'confirm')) }}
    @endif
        {{ csrf_field() }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
        {{ Form::hidden('document_name', $documentName[0]->id , array('id' => 'document_name')) }}
        {{ Form::hidden('prevDocChk', "" , array('id' => 'prevDocChk')) }}

        <div class="mt20">
            <fieldset>

                <div class="form-group mt25">
                    <label for="Gender" class="col-md-3 control-label clr_blue">
                        {{ trans('messages.lbl_document_name') }}<span class="fr ml2"> * </span>
                    </label>
                    <div class="col-md-3">
                        <label class="mt6"> {{ $documentName[0]->document_name }} </label>
                    </div>
                </div>

                <div class="form-group mt15">
                    <div class="col-xs-3 text-right clr_blue">
                        <label>{{ trans('messages.lbl_file_upload') }}<span class="fr ml2 red"> * </span></label>
                    </div>
                    <div class="col-md-3">
                        {{ Form::file('file_name',array('id'=>'file_name','name' => 'file_name',
                            'data-label' => trans('messages.lbl_file'),
                            'accept' => '.pdf, .xlsx , .xls ',
                            'height' =>'27px',
                            'class'=>'box100per',
                            'onchange' => 'javascript:validate(this.value);')) 
                        }}
                    </div>

                    @if(isset($detedit[0]->file_name))

                        @if($detedit[0]->file_type != "")
                            @if($detedit[0]->file_type == 3)
                              {{--*/ $src = '/pdf.png'; /*--}}
                            @else
                              {{--*/ $src = '/excel_a.png'; /*--}}
                            @endif

                        @endif
                        <div class="col-md-3">
                              <img class="box20 mr10" src="{{ URL::asset('resources/assets/images') }}{{ $src }}">
                              <label class="mt5">{{ $detedit[0]->file_name }}</label>
                        </div>
                    @endif

                </div>

                @if(!isset($detedit[0]))
                    <div class="form-group mt15">
                        <div class="col-xs-3 text-right clr_blue">

                        </div>

                        <div class="col-md-2">
                            {{ Form::checkbox('prevDoc', 1, 0, ['id' => 'prevDoc']) }}
                                    &nbsp;<label for="prevDoc"><span>Use Previous</span></label>
                        </div>

                        <div class="col-md-3">
                              <label class="mt3" style="color:#9C0000;" id="prevDocName"></label>
                        </div>    
                    </div>
                @endif

                <div class="form-group mt20 mb20">
                    <div class="col-xs-3 text-right clr_blue">
                        <label>{{ trans('messages.lbl_remark') }}</label>
                    </div>
                    <div class="col-md-9">
                        {{ Form::textarea('remarks',null, 
                                            array('name' => 'remarks','id' => 'remarks',
                                                  'class' => 'box40per form-control','size' => '30x4'))
                        }}
                    </div>
                </div>

                {{ Form::hidden('file_name_temp',
                                (isset($detedit[0]->file_name)) ?  $detedit[0]->file_name : '',
                                array('id'=>'file_name_temp',
                                        'name' => 'file_name_temp',
                                        'class'=>'box30per form-control')) }}

                {{ Form::hidden('file_type',
                                (isset($detedit[0]->file_type)) ?   $detedit[0]->file_type : '',
                                array('id'=>'file_type',
                                        'name' => 'file_type',
                                        'class'=>'box30per form-control')) }}

                {{ Form::hidden('document_name_atdb',
                                (isset($detedit[0]->document_name)) ?  $detedit[0]->document_name : '',
                                array('id'=>'document_name_atdb',
                                        'name' => 'document_name_atdb',
                                        'class'=>'box30per form-control')) }}
            
           
            </fieldset>

            <fieldset style="background-color: #DDF1FA;">
                <div class="form-group">
                    <div align="center" class="mt7">
                        @if(isset($detedit[0]))
                            <button type="submit" class="edit btn btn-warning box100 addeditprocess">
                                <i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
                            </button>
                        @else
                            <button type="submit" class="add btn btn-success box100 addeditprocess">
                                <i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register') }} 
                            </button>
                        @endif
                            <a href="javascript:cancel();" class="btn btn-danger box110 ml10">
                                <span class="fa fa-remove"></span>&nbsp;{{ trans('messages.lbl_cancel') }} 
                            </a>
                    </div>
                </div>
            </fieldset>

        </div>
    {{ Form::close() }}
</article>
</div>
    
<script type="text/javascript">
    var cancel_check = true;
    $('input, select, textarea').bind("change keyup paste", function() {
        cancel_check = false;
    });
</script>




@endsection