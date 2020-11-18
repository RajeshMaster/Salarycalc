@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/contract.js') }}
<script type="text/javascript">
var datetime = '<?php echo date('Ymdhis'); ?>';
function exceldownload(contractid,mainmenu) {
	var reason = $('#txt_reason').val();
	$('#contractid').val(contractid);
	if (reason == "") {
		$("#doj_joinerr").show();
		$("#txt_reason").focus();
	} else if(reason != ""){
		$("#doj_joinerr").hide();
		if(confirm("Do You Want Download The Excel")) {
			$('#contractform').attr('action', 'salarycertifydownload'+'?mainmenu='+mainmenu+'&time='+datetime);
			$("#contractform").submit();
		}
	}
}
</script>
<style>
#circle {
	width: 105px;
	height: 105px;
	border:1px solid red;
	-moz-border-radius: 50px;
	-webkit-border-radius: 50px;
	border-radius: 50px;
}
.validationdiv {
	color: #9C0000;
	display: none;
}
</style>
<div class="CMN_display_block" id="main_contents" style="width: 100%;">
	<!-- article to select the main&sub menu -->
	<article id="visa" class="DEC_flex_wrapper " data-category="visa visa_sub_2">
   {{ Form::open(array('name'=>'contractform', 'id'=>'contractform', 'url' => 'Contract/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
	{{ csrf_field() }}
	{{ Form::hidden('contractsort',$request->contractsort , array('id' => 'contractsort')) }}
	{{ Form::hidden('sortOptn',$request->contractsort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('contractid', $request->contractid , array('id' => 'contractid')) }}
	{{ Form::hidden('contract_id', $request->contract_id , array('id' => 'contract_id')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	<input type="hidden" name="Total" id="Total" value="<?php echo $salarycertificate->Total; ?>">
	<input type="hidden" name="doj" id="doj" value="<?php echo $salarycertify->DOJ; ?>">
	{{ Form::hidden('empname', $request->empname , array('id' => 'empname')) }}
	<div class="row hline">
		<div class="col-sm-8">
			<img class="pull-left ml10 box40 mt10" src="{{ URL::asset('resources/assets/images/contract_no.png') }}">
			<h2 class="pull-left pl5 mt15">{{ trans('messages.lbl_salarycertify')}}</h2>
		</div>
	</div>
	<div class="box100per pr10 pl10 mt10">
		<div class="mt10">
			<a href="javascript:gotoBackview('viewlist','{{$request->mainmenu}}');"
				class="btn btn-info box80"><span class="fa fa-arrow-left"></span>
				{{ trans('messages.lbl_back') }}</a>
			<div class="mt10 pull-right pr10" title="Salary Certify History">
				<a href="javascript:fnsalarycertifyHistory('{{ $request->contract_id }}','{{$request->mainmenu}}');"><span class="fa fa-edit mr5"></span>
					{{ trans('messages.lbl_salarycertifyhistory')}}</a>
				<br/><br/>
				<a  href="javascript:exceldownload('{{ $request->contractid }}','{{ $request->mainmenu }}');">
					<span class="fa fa-download pr5"></span>
					{{ trans('messages.lbl_salarycertify')}}
				</a>
		  </div>
		</div>
		<br/><br/>
		<div>
			<table width="" class="tablewidth" align="center"  border="1" style="border-collapse: collapse;text-align: center;table-layout: fixed !important;">
				<tr class="tableborderall">
					<th class=" tableborderall" colspan="5" style="text-align: center;">
						<span title="Certificate Of Employment">
						{{ trans('messages.lbl_certificate_employment') }}</span>
					</th>
				</tr>
				<tr class="tableborderall">
					<th class=" tableborderall" colspan="5" style="text-align: center;">在    職   証   明   書</th>
				</tr>
				<tr　class="tableborderall" rowspan="2">
					<td class=" tableborderall" width="120" align="center">Name</td>
					<td class="tableborderall" width="220" colspan="4" style="text-align: left;padding-left: 5px;">
						@if($salarycertify->FirstName!="" && $salarycertify->LastName!="")
							{{ $salarycertify->FirstName }} {{ $salarycertify->LastName }}
						@endif
					</td>
				</tr>
				<tr>
					<td class=" tableborderall" align="center">Date Of Birth</td>
					<td class="tableborderall" width="150">
						{{ $salarycertify->DOB}}
					</td>
					<td class=" tableborderall" align="center">Gender</td>
					<td class="tableborderall" colspan="2" width="105" style="text-align: left;">
						@if($salarycertify->Gender==1)
							Male
							<span id="circle">男</span>･女
						@elseif($salarycertify->Gender==2)
							Female
							男･<span id ="circle">女</span>
						@endif  
					</td>
				</tr>
				<tr class="tableborderall">
					<th class=" tableborderall" colspan="5" style="text-align: center;">上記の者は、下記のとおり当社に在職していることを証明いたします。</th>
				</tr>
				<tr class="tableborderall">	
					<th class=" tableborderall" colspan="5" style="text-align: center;">記
					</th>
				</tr>
				<tr class="tableborderall">
					<td class=" tableborderall" style="padding-left:5px;">1．所属部署</td>
					<td class="tableborderall" colspan="5" style="text-align: left;">株式会社　MICROBIT　（マイクロビット）</td>
				</tr>
				<tr class="tableborderall">
					<td class=" tableborderall" style="padding-left:20px;">2．入社年月日</td>
					<td class="tableborderall" colspan="5" style="text-align: left;">
						{{ $salarycertify->DOJ }}	
					</td>
				</tr>
				<tr class="tableborderall">
					<td class=" tableborderall" style="padding-left:20px;">3．地位・給与</td>
					<td class="tableborderall tac">Employees</td>
					<td class=" tableborderall" align="center">Monthly Salary</td>
					<td class="tableborderall" colspan="2">{{ number_format(str_replace(',', '', $salarycertificate->Total)) }} 円</td>
				</tr>
				<tr class="tableborderall">
					<td class=" tableborderall" style="padding-left:20px;">4．職務の内容</td>
					<td class="tableborderall" colspan="5" style="text-align: left;">コンピュータソフト開発技術者 (Software Engineer)</td>
				</tr>
				<tr class="tableborderall">
					<td class=" tableborderall" align="center">Reason</td>
					<td class="" colspan="5" align="center"><input type="text" name="txt_reason" id="txt_reason" style="width:100%;height: 25px;" 
						value = "" /> 
					</td>
				</tr>
				<tr class="tableborderall">
					<td class="tableborderall" colspan="6" style="text-align:right;">
						{{ $today}}
					</td>
				</tr>
				<tr class="tableborderall">
					<td class="tableborderall"></td>
					<td class=" tableborderall" align="center">
						{{ trans('messages.lbl_address') }}</td>
					<td class="tableborderall" colspan="3" style="text-align: left;">大阪市淀川区西中島５丁目６-３－３０５号<br>Osaka, Yodogawa-ku, Nishinakajima 5-6-3-305</td>
				</tr>
				<tr class="tableborderall">
					<td class="tableborderall"></td>
					<td class=" tableborderall" align="center">{{ trans('messages.lbl_companyname') }}</td>
					<td class="tableborderall" colspan="2" style="text-align: left;">株式会社　MICROBIT　「カ）マイクロビット」<br>MICROBIT Company Limited</td>
					<td class="tableborderall"></td>
				</tr>
				<tr class="tableborderall">
					<td class="tableborderall"></td>
					<td class=" tableborderall" align="center">
						{{ trans('messages.lbl_ceo') }}</td>
					<td class="tableborderall" colspan="2" style="text-align: left;">マイクロビット　有限会社<br>Microbit Limited Company</td>
					<td class="tableborderall"><!-- <img src="signImg/sign.jpg" alt="印" height="50" /> --></td>
				</tr>
			</table>
		  	<strong id="doj_joinerr" class="validationdiv" style="float: right;margin-top: -207px;margin-right: 76px;">{{ "Please Enter a reason." }}</strong>
		</div><br/>
	</div>
	{{ Form::close() }}
</article>
</div>
@endsection