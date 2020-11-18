@extends('layouts.app')
@section('content')
    {!! Minify::stylesheet(array(URL::asset('resources/assets/css/lib/bootstrap-datetimepicker.min.css'),
                                URL::asset('resources/assets/css/lib/lightbox.css') )) !!}
  {!! Minify::javascript(array(URL::asset('resources/assets/js/lib/bootstrap-datetimepicker.js'),
                                URL::asset('resources/assets/js/expenses.js'),
                                URL::asset('resources/assets/js/lib/lightbox.js'),
                                URL::asset('resources/assets/js/settings.js') )) !!}
    <script type="text/javascript">
        var datetime = '<?php echo date('Ymdhis'); ?>';      
        $( document ).ready(function() {
	        setDatePicker("Date");
	        $("#main_sub option").each(function()
    			{
		      if ($(this).val() == 1) {
		        $(this).css('font-weight','bold');
		        $(this).css('color','brown');
		      }
		    });
		    $("#su_sub option").each(function()
    			{
		      if ($(this).val() == 1) {
		        $(this).css('font-weight','bold');
		        $(this).css('color','brown');
		      }
		    });
        });
    </script>
     <style type="text/css">
        .altertxtbx {height:28.5px ! important;padding-bottom: 0px !important;padding-top: 0px !important;}
    </style>
    <div class="row hline">
      <div class="col-sm-8">
            <img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/expenses.png') }}">
            <h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_expenses') }}</h2>
            <h2 class="pull-left mt15">・</h2> 
            @if(isset($detedit))
             @if($request->useflg == 1)
              <h2 class="pull-left mt15" style="color:red;">{{ trans('messages.lbl_edit') }}</h2>
             @else
              <h2 class="pull-left mt15" style="color:blue;">{{ trans('messages.lbl_copy') }}</h2>
             @endif
	        @else
	          <h2 class="pull-left mt15" style="color:green;">{{ trans('messages.lbl_register') }}</h2>
	        @endif
      </div>
    </div>
    <div>
    @if(isset($detedit))
	    @if($request->useflg == 1)
	    	{{ Form::model($detedit, array('name'=>'indexform','id'=>'indexform', 
	    				'class'=>'form-horizontal',
	    				'url' => 'Expenses/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
	    				'files'=>true,
	    				'method' => 'POST')) }}
	        {{ Form::hidden('confirm','2', array('id' => 'confirm')) }}
	        {{ Form::hidden('edmain_sub', $detedit->main_sub , array('id' => 'edmain_sub')) }}
		    {{ Form::hidden('edsu_sub', $detedit->su_sub , array('id' => 'edsu_sub')) }}
		    {{ Form::hidden('edMonth', $detedit->Month , array('id' => 'edMonth')) }}

	    @else
	    	{{ Form::model($detedit, array('name'=>'indexform','id'=>'indexform',
	    				'class'=>'form-horizontal',
	    				'url' => 'Expenses/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
	    				'files'=>true,
	    				'method' => 'POST')) }}
	        {{ Form::hidden('confirm','1', array('id' => 'confirm')) }}
    	@endif
  	@else
    	{{ Form::open(array('name'=>'indexform', 'id'=>'indexform', 
                        'class' => 'form-horizontal',
                        'url' => 'Expenses/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                        'files'=>true,
                        'method' => 'POST')) }}
		{{ Form::hidden('confirm','1', array('id' => 'confirm')) }}

    @endif
        {{ csrf_field() }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	    {{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
	    {{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
	    {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
	    {{ Form::hidden('expdate', '' , array('id' => 'expdate')) }}
	    {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
	    {{ Form::hidden('expid', $request->expid , array('id' => 'expid')) }}
	    {{ Form::hidden('process', $request->process , array('id' => 'process')) }}
	    {{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
	    {{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	    {{ Form::hidden('view_plimit', $request->view_plimit , array('id' => 'view_plimit')) }}
    	{{ Form::hidden('view_page', $request->view_page , array('id' => 'view_page')) }}
	    {{ Form::hidden('index_plimit', $request->index_plimit , array('id' => 'index_plimit')) }}
	    {{ Form::hidden('index_page', $request->index_page , array('id' => 'index_page')) }}
	    {{ Form::hidden('pass_date', $request->pass_date , array('id' => 'pass_date')) }}
	    {{ Form::hidden('subcnfm', $request->subcnfm , array('id' => 'subcnfm')) }}
    	{{ Form::hidden('useflg', $request->useflg , array('id' => 'useflg')) }}
    	{{ Form::hidden('histback', $request->histback  , array('id' => 'histback')) }}
    	{{ Form::hidden('histbackdup', $request->histbackdup , array('id' => 'histbackdup')) }}
    	{{ Form::hidden('totexpind', $request->totexpind , array('id' => 'totexpind')) }}
	    @if(Session::has('error'))
        <div class="alert-box success" style="text-align: center;color: red;">
          {{ Session::get('error') }}
        </div>
        @endif
        <fieldset>
        	<div class="col-md-12">
                <label class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_empid') }}
                <span class="mr10"></span>
                </label>
                <div class="col-md-6">
                    <label class="control-label fwb" style="color:{{ getEmpIDColor( $request->empid ) }}">
                        {{ $request->empid }}
                    </label>
                </div>
            </div>
	        <div class="col-md-12">
        		<label class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_employeename') }}
	                <span class="fr ml10"></span>
        		</label>
	            <div class="col-md-6">
                    <label class="control-label fwb"  style="color:#9C0000">
                        {{ empnamelength($employees['0']->LastName, $employees['0']->FirstName, 200) }}
                    </label>
                </div>
	        </div>
		    <div class="col-md-12 mt5">
        		<label class="col-md-3 control-label clr_blue">{{ trans('messages.lbl_date') }}
	                <span class="fr ml2"> * </span>
        		</label>
	            <div class="col-md-6">
	            	{{ Form::text('Date',null,array('id'=>'Date','name' => 'Date','class'=>'box19per pull-left form-control Date','maxlength' => '10','onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57','onchange'=>'javascript:checkmonth();','autocomplete' => 'off' )) }}
		            <label class="mt10 ml2 fa fa-calendar fa-lg" for="Date" aria-hidden="true"></label>
            		<div class="Dateerror CMN_display_inline"></div>
	            </div>
	        </div>
	        <div class="col-md-12 mt5">
	            <label for="mainsubject" class="col-md-3 control-label clr_blue">
	                {{ trans('messages.lbl_mainsubject') }}
	                	<span class="fr ml2"> * </span>
	            </label>
	            <div class="col-md-8">
		            {{Form::select('main_sub',[null=>''] + $mainsub, null,
	                                 array('id' => 'main_sub','class' => 'main widthauto input-sm form-control',
	                                        'style' => 'background-color: white;width:auto;', 
	                                        'onchange'=>'javascript:getsubdet();getothers();'))}}
	            </div>
	        </div>
	        <div class="col-md-12 mt5">
	            <label class="col-md-3 control-label clr_blue">
	                {{ trans('messages.lbl_subsubject') }}<span class="fr ml2"> * </span>
	            </label>
	            <div class="col-md-8">
	                {{Form::select('su_sub',[null=>''] + $su_sub, null,
                                 array('id' => 'su_sub',
                                        'class' => 'sub widthauto input-sm form-control',
                                        'onchange'=>'javascript:checkmonth();'))}}
                    <span class="" style="">
	                {{ Form::text('Others',null,
                                   array('name' => 'Others','id' => 'Others',
                                   'style' => 'visibility:hidden;',
                                            'class'=>'other input-sm box30per form-control')) }}
                </span>
	            </div>
	        </div>
	        <div class="col-md-12 mt5">
	        	@if($request->useflg=="1")
	        	<?php $monthSplit =array();
	        		$monthArray =array();
	        	$monthSplit = explode(",", $detedit->Month);
							for ($k=0;$k<count($monthSplit);$k++) {
								if ($monthSplit[$k] == 99) {
									$monthSplit[$k] = 13;
								}
								$monthArray[$monthSplit[$k]] = $monthSplit[$k];
							} ?>
				@endif
	            <label for="months" class="col-md-3 control-label clr_blue">
	                {{ trans('messages.lbl_months') }}<span class="fr ml2"> * </span>
	            </label>
	            <div class="col-md-8">
	                @for($i=1;$i<=13;$i++)
	                	@if(isset($monthArray[$i]))
							@if ($i==$monthArray[$i] && $request->useflg != "2") 
	              				{{--*/ $checkedStr = "1"; /*--}}
							@else
	              				{{--*/ $checkedStr = ""; /*--}}
							@endif
						@else
	              			{{--*/ $checkedStr = ""; /*--}}
						@endif	
	                	@if(isset($arrayNotEditOthers[$i]))
							@if ($i==$arrayNotEditOthers[$i])
	              				{{--*/ $disabled = "1"; /*--}}
							@else
	              				{{--*/ $disabled = ""; /*--}}
	              			@endif
						@else
    	          			{{--*/ $disabled = ""; /*--}}
						@endif	
              			{{--*/ $id = "month".$i; /*--}}
                        <input type="checkbox"  
                        	@if ($checkedStr=="1") checked="checked" @endif
                        	@if ($disabled=="1") disabled="disabled" @endif
                        	onchange="return nillCheck(this.value);" name="month[]" id="month<?php echo $i?>" style="vertical-align:middle;" value="<?php if ($i!=13) echo $i; else echo 99;?>">
                        <label for="{{$id}}" style="vertical-align: middle;font-weight: normal;margin-top: 10px;">
                        	@if($i != 13)
                        		{{ $i."月" }}
                        	@else
                        	  {{ "NILL" }}
                        	@endif
			            </label>
	                @endfor
	                <div id="checkboxval" class="validationdiv mt10 CMN_display_inline pull-right">
                       <label>{{ "The Months Field is required." }}</label>
                    </div>
	            </div>

	        </div>
	        <div class="col-md-12 mt5">
	            <label for="Amount" class="col-md-3 control-label clr_blue">
	                {{ trans('messages.lbl_amount') }}<span class="fr ml2"> * </span>
	            </label>
	            <div class="col-md-6 CMN_display_inline pull-left">
	            {{ Form::text('Amount',null,array('id'=>'Amount',
                                             'name' => 'Amount',
                                             'maxlength' => '6',
                                             'style' => 'text-align:right;',
                                             'class'=>'box16per ime_mode_disable form-control',
                                             'onkeypress'=>'return numberonly(event)',
                                             'onkeyup'=>'return fnMoneyFormatwithINR(this.id)')) }}
            		 <div id="amountboxval" class="validationdiv mt5 pull-right CMN_display_inline" style="padding-right: 50%;">
                        <strong>{{ "The Amount Field is required." }}</strong>
                    </div>
	             </div>
	            
	        </div>
	        
	        <div class="col-md-12 mt5">
	            <label class="col-md-3 control-label clr_blue pr30">
	                {{ trans('messages.lbl_bill') }} 
	            </label>
	            <div class="col-md-6 CMN_display_inline pull-left">
                	<div class="CMN_div_inblock mt5">
	                	{{ Form::file('Bill_Image', array('id'=>'Bill_Image','accept' => '.jpeg,.jpg,.png,.gif','name' => 'Bill_Image','class' => 'box350 name','style' => 'height:23px;' )) }}

	                	@if ($request->useflg == "1")
	    					{{ Form::hidden('Image', $detedit->Bill_Image , array('id' => 'Image')) }}
	    				@endif
	                </div>
                	<div class="CMN_div_inblock">
                	@if ($request->useflg == "1")
                		@if(isset($detedit)) @if( $detedit->Bill_Image ) 
                		<a id="Imagedisp" class="td_n" href="{{ URL::asset('../../Com.sathisys/ss/emp/img/upload/Expences/'.$detedit->Bill_Image) }}" data-lightbox="expenses-img">
                            <img width="10" height="20" name="Image" id="Image" class="ml5 box20" src="{{ URL::asset('../../Com.sathisys/ss/emp/img/upload/Expences/'.$detedit->Bill_Image) }}">
                   	 	</a>
                   	 	@endif @endif
                   	@endif
            			<label class="ml10 fwb mt5">Example :</span><span> (Jpeg, Png, Gif)</label>
            			<label id="{{ 'imagediv' }}" class="mt3 validationdiv"></label>
                   	</div>
                </div>
	        </div>


	        <div class="col-md-12 mt5">
	            <label for="remarks" class="col-md-3 control-label clr_blue pr30">
	                {{ trans('messages.lbl_remarks') }}
	            </label>
	            <div class="col-md-8">
	                {{ Form::textarea('Remark',null, array('id'=>'Remark','name' => 'Remark','class' => 'form-control ime_mode_disable name box40per','style' => 'height:70px;')) }}
	            </div>
	        </div>
        </fieldset>
        <fieldset style="background-color: #DDF1FA;">
        	@if($request->process=="1")
          		{{--*/ $page = "view" /*--}}
          	@else
          		{{--*/ $page = "history" /*--}}
          	@endif
            <div class="col-md-12">
                <div align="center" class="mt5">

                	@if(isset($detedit))
                      @if($request->useflg == 1)
                        <button type="submit" class="add btn btn-warning box100 addeditprocess">
                        <i class="glyphicon glyphicon-edit"></i>{{ trans('messages.lbl_update') }} 
                        </button>
                      @else
                        <button type="submit" class="add btn btn-success box100 addeditprocess">
                        <i class="glyphicon glyphicon-plus"></i>{{ trans('messages.lbl_register') }} 
                        </button>
                      @endif
                    @else
                    <button type="submit" class="add btn btn-success box100 addeditprocess">
                        <i class="glyphicon glyphicon-plus"></i>{{ trans('messages.lbl_register') }} 
                    </button>
                    @endif
                    <a href="javascript:cancel('{{ $page }}','{{ $request->mainmenu }}');" class="btn btn-danger box110"><span class="glyphicon glyphicon-remove"></span> {{ trans('messages.lbl_cancel') }} </a>
                </div>
            </div>
        </fieldset>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#su_sub option").each(function()
                {
                    if ($(this).val() == "3") {
                    $(this).css('font-weight','bold');
                    $(this).css('color','brown');
                }
        });
    </script>
    </div>
    @if(isset($detedit))
    	@if($request->useflg == "2")
		    <script type="text/javascript">
		      document.getElementById('Date').value = "";
		    </script>
	  	@endif
        <script type="text/javascript">
            getsubdet('{{ $detedit->su_sub }}')
            getothers()
        </script>
    @endif
    {{ Form::close() }}
  <!-- Common Settings Popup For All Process -->
  @include('settings.commonsettingspopup');
  <script type="text/javascript">
//Script for Cancel Check//
var cancel_check = true;
$('input, select, textarea').bind("change keyup paste", function() {
    cancel_check = false;
});
</script>
@endsection