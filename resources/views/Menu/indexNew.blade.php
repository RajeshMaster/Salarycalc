@extends('layouts.menulayout')
@section('content')
	@if (Session::get('setlanguageval') == 'en')
		{{ HTML::script('resources/assets/js/english.js') }}
	@elseif(empty(Session::get('setlanguageval')))
		{{ HTML::script('resources/assets/js/japanese.js') }}
	@else
		{{ HTML::script('resources/assets/js/japanese.js') }}
	@endif
	<script type="text/javascript">
		function changelanguage() {
			// var err_changelanguage = "言語を変更しますか？。";
			if ($('#langvalue').val() == "jp") {
				var err_lang = "Do You Want To Change The Language?.";
			} else {
				var err_lang = "言語を変更しますか？。";
			}
			// var confm = confirm("Do You Want To Change The Language?.");
			if (!confirm(err_lang)) {
				return false;
			}
			$.ajax({
				type:'GET',
				url:'changelanguage',
				data: {
					langvalue: $('#langvalue').val()
				},
				success:function(data){
					location.reload(true);
				},
				error: function (data) {
					// alert(data.status);
				}
			});
		}
	</script>
	<style type="text/css">
	.image_b {
		width: 150px;
		height: 40px;
		background-color: #0b93b3;
		background-repeat: no-repeat;
		color: #ffffff;
		padding-top: 10px;
		font-size: 15px;
		text-align: center;
	}
	.div_inline {
	    display: inline-block;
	}
	.alinkEng {
		background: url(../resources/assets/images/resultset_next.png) no-repeat left center;
		height: 16px;
		vertical-align: text-bottom;
		font-size: 12px;
		padding-left: 16px;
	}
	#for_stretch_align {
		display: table;
		margin: auto;
		width: 1185px !important;
	}
	</style>
	<script type="text/javascript">
		var datetime = '<?php echo date('Ymdhis'); ?>'; 
		$(function () {  
			$(document).keydown(function (e) {  
				return (e.which || e.keyCode) != 116;  
			});
		});
		function callPage(screenType) {
			$("#screenType").val(screenType);
			if (screenType == "Invoice") {
				$('#menuNewform').attr('action', '../../larainvoice/login');
				$("#menuNewform").submit();
			} else if(screenType == "Accounting") {
				$('#menuNewform').attr('action', '../../AccountingSys/login');
				$("#menuNewform").submit();
			} else {
				$('#menuNewform').attr('action', '../../Salarycalc/login');
				$("#menuNewform").submit();
			}
		}
	</script>
	{{ Form::open(array('name'=>'menuNewform', 'id'=>'menuNewform', 
						'url' => '','method' => 'POST')) }}
		{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
		{{ Form::hidden('screenType','', array('id' => 'screenType')) }}
		{{ Form::hidden('userid', Auth::user()->userid , array('id' => 'userid')) }}
		{{ Form::hidden('password',Session::get('password'), array('id' => 'password')) }}
		<div class="" id="for_stretch_align">
		<!-- article to select the main&sub menu -->
			<div class="col-xs-12">
				<div class="col-xs-5"></div>
				<div class="col-xs-2">
					{{ Form::button('Invoice',
							array('class'=>'btn btn-info btn-block pt15 pb15',
									'type'=>'submit',
									'onclick' => 'javascript:return callPage("Invoice")')) 
					}}
					{{ Form::button('Salary Calc',
							array('class'=>'btn btn-info btn-block pt15 pb15',
									'type'=>'submit',
									'onclick' => 'javascript:return callPage("Salarycalc")')) 
					}}
					<!-- {{ Form::button('Accounting',
							array('class'=>'btn btn-info btn-block pt15 pb15',
									'type'=>'submit',
									'onclick' => 'javascript:return callPage("Accounting")')) 
					}} -->
				</div>
				<div class="col-xs-5"></div>
			</div>
		</div>
	{{ Form::close() }}
@endsection