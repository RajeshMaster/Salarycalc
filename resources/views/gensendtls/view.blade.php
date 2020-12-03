@extends('layouts.app')
@section('content')
{{ HTML::script('resources/assets/js/gensendtls.js') }}
{{ HTML::script('resources/assets/js/lib/lightbox.js') }}
{{ HTML::style('resources/assets/css/lib/lightbox.css') }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
</script>
<style type="text/css">
	.alertboxalign {
		margin-bottom: -50px !important;
	}
	.alert {
		display:inline-block !important;
		height:30px !important;
		padding:5px !important;
	}

</style>
<div class="CMN_display_block" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="expenses" class="DEC_flex_wrapper " data-category="expenses expenses_sub_6">
	{{ Form::open(array('name'=>'frmgensenstaffview',
						'id'=>'frmgensenstaffview',
						'url' => 'Gensendtls/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files'=>true,
						'method' => 'POST')) }}
	{{ Form::hidden('selYear', $request->selYear, array('id' => 'selYear')) }}
	{{ Form::hidden('mainmenu', '', array('id' => 'mainmenu')) }}
	
	<!-- Start Heading -->
	<div class="row hline pm0">
		<div class="col-xs-12">
			<img class="pull-left box35 mt10" src="{{ URL::asset('resources/assets/images/employee.png') }}">
			<h2 class="pull-left pl5 mt10 CMN_mw150">{{ trans('messages.lbl_staff') }}<span>・</span><span class="colbl">{{ trans('messages.lbl_view') }}</span></h2>
		</div>
	</div>
	<div class="pb10"></div>
	<!-- End Heading -->
	
	<div class="pl5 pr5">
		<div class="pull-left ml5">
			<a href="javascript:goindexpage('{{ $request->selYear }}');" class="pageload btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
		</div>
	</div>
	
	<div class="col-xs-12 mt10 pl5">
		<div class="col-xs-6 mt10">
		<fieldset>
			<div class="CMN_display_block">
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_employeeid') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->Emp_ID != "") ? $staffdetail[0]->Emp_ID : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_dateofjoining') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->DOJ != "") ? $staffdetail[0]->DOJ : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_staffusersurname') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->FirstName != "") ? $staffdetail[0]->FirstName : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_staffusername') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->LastName != "") ? $staffdetail[0]->LastName : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_gender') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->Gender == "1") ? trans('messages.lbl_male') : trans('messages.lbl_female')}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_dob') }}</label>
					</div>
					<div>
					{{ ($staffdetail[0]->DOB != "") ? $staffdetail[0]->DOB : 'Nill'}}
					<span class="box100per fwb">({{ birthday(($staffdetail[0]->DOB != "") ? $staffdetail[0]->DOB : 'Nill') }})</span>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_mobileno') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->Mobile1 != "") ? $staffdetail[0]->Mobile1 : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_mailid') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->Emailpersonal != "") ? $staffdetail[0]->Emailpersonal : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_streetaddress') }}</label>
					</div>
					<div class="col-xs-9 box60per pm0">
						@if(!empty($staffdetail[0]->Address1))
							{{ $staffdetail[0]->full_address }}
						@else
							NILL
						@endif
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_resigneddate') }}</label>
					</div>
					<div>
						{{ ($staffdetail[0]->resigndate != "") ? $staffdetail[0]->resigndate : 'Nill'}}
					</div>
				</div>
				
			</div>
		</fieldset>
		</div>
		<div class="col-xs-6 mt10">
		<fieldset>
			<div class="CMN_display_block mb90">
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_company_number') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->companyNumber != "") ? $companyDetails[0]->companyNumber : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_companyname') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->companyName != "") ? $companyDetails[0]->companyName : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_branch_name') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->companyBranch != "") ? $companyDetails[0]->companyBranch : 'Nill'}}
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_company_capital') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->capital != "") ? $companyDetails[0]->capital : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_address') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->address != "") ? $companyDetails[0]->address : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_tel') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->TEL != "") ? $companyDetails[0]->TEL : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_ceo') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->CEO != "") ? $companyDetails[0]->CEO : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-12">
					<div class="col-xs-3 text-right clr_blue box40per">
						<label>{{ trans('messages.lbl_reference_number') }}</label>
					</div>
					<div>
						{{ ($companyDetails[0]->referencenumber != "") ? $companyDetails[0]->referencenumber : 'Nill'}}
					</div>
				</div>
			</div>
		</fieldset>
		</div>
	</div>
	<div class="col-xs-12 mt10 pr10">
	<fieldset>
		<center>
			<div class="box98per tablealternate mt12">
				<table border="1px solid black" width="100%" cellpadding="0" cellspacing="0">
					<tr width="100%" 
						style="text-align: center;background-color:#AADDE6;">
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_relation') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_name') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_kananame') }}</th>
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_dob') }}</th>
					<th class="text-center" width="5%" height="25px">
						{{ trans('messages.lbl_alive') }}</th>
					<th class="text-center" width="10%" height="25px">
						{{ trans('messages.lbl_workanualincome') }}</th>
					</tr>
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
							{{ trans('messages.lbl_father') }}</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->FatherName }}">
							{{ singlefieldlength($staffdetail[0]->FatherName,25) }}
						</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->FatherkanaName }}">
							{{ singlefieldlength($staffdetail[0]->FatherkanaName,25) }}
						</td>
						<td width="6%" height="25px" align="center">
							@if($staffdetail[0]->FatherDOB!="" && $staffdetail[0]->FatherDOB!="0000-00-00")
								{{ $staffdetail[0]->FatherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->FatherDOB) }})</span>
							@else
								{{ "" }}
							@endif
						</td>
						<td width="3%" height="25px" class="text-center">
							{{ Form::checkbox('father', '1',$staffdetail[0]->Father, array('id'=>'father','class' => '','disabled'=>'disabled')) }}
						</td>
						@if($staffdetail[0]->FatherWorkIncome !=0)
							<td width="4%" height="25px" class="text-right pr10">
								{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }}
								<span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->FatherWorkIncome) }}</span>
							</td>
						@else
							<td width="4%" height="25px" class="text-center">
								{{ "---" }}
							</td>
						@endif
			  		</tr>
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
							{{ trans('messages.lbl_mother') }}</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->MotherName }}">
							{{ singlefieldlength($staffdetail[0]->MotherName,25) }}
						</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->MotherkanaName }}">
							{{ singlefieldlength($staffdetail[0]->MotherkanaName,25) }}
						</td>
						<td width="6%" height="25px" align="center">
							@if($staffdetail[0]->MotherDOB!="" && $staffdetail[0]->MotherDOB!="0000-00-00")
								{{ $staffdetail[0]->MotherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->MotherDOB) }})</span>
							@else
								{{ "" }}
							@endif
						</td>
						<td width="3%" height="25px" class="text-center">
							{{ Form::checkbox('Mother', '1',$staffdetail[0]->Mother, array('id'=>'Mother','class' => '','disabled'=>'disabled')) }}
						</td>
						@if($staffdetail[0]->MotherWorkIncome !=0)
							<td width="4%" height="25px" class="text-right pr10">
								{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }}
								<span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->MotherWorkIncome) }}</span>
							</td>
						@else
							<td width="4%" height="25px" class="text-center">
								{{ "---" }}
							</td>
						@endif
			 		</tr>
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
							{{ trans('messages.lbl_grandFather') }}</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->GrandFatherName }}">
							{{ singlefieldlength($staffdetail[0]->GrandFatherName,25) }}
						</td>
						<td class="pl5" width="15%" height="25px">
							{{ $staffdetail[0]->GrandFatherkanaName }}
						</td>
						<td width="6%" height="25px" align="center">
							@if($staffdetail[0]->GrandFatherDOB!="" && $staffdetail[0]->GrandFatherDOB!="0000-00-00")
								{{ $staffdetail[0]->GrandFatherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->GrandFatherDOB) }})</span>
							@else
								{{ "" }}
							@endif
						</td>
						<td width="3%" height="25px" class="text-center">
							{{ Form::checkbox('GrandFather', '1',$staffdetail[0]->GrandFather, array('id'=>'GrandFather','class' => '','disabled'=>'disabled')) }}
						</td>
						<td width="4%" height="25px" class="text-center">
							{{ "---" }}
						</td>
					</tr>
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
							{{ trans('messages.lbl_grandMother') }}</td>
						<td class="pl5" width="15%" height="25px" 
							title="{{ $staffdetail[0]->GrandMotherName }}"> 
							{{ singlefieldlength($staffdetail[0]->GrandMotherName,25) }}
						</td>
						<td class="pl5" width="15%" height="25px">
							{{ $staffdetail[0]->GrandMotherkanaName }}
						</td>
						<td width="6%" height="25px" align="center">
							@if($staffdetail[0]->GrandMotherDOB!="" && $staffdetail[0]->GrandMotherDOB!="0000-00-00")
								{{ $staffdetail[0]->GrandMotherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->GrandMotherDOB) }})</span>
							@else
								{{ "" }}
							@endif
						</td>
						<td width="3%" height="25px" class="text-center">
							{{ Form::checkbox('GrandMother', '1',$staffdetail[0]->GrandMother, array('id'=>'GrandMother','class' => '','disabled'=>'disabled')) }}
						</td>
						<td width="4%" height="25px" class="text-center">
							{{ "---" }}
						</td>
					</tr>
				</table>
			</div>
		</center>
		<div class="col-md-12 mt5" style="padding-right: 50px;">
			<div class="col-md-3 text-right clr_blue">
				<label>{{ trans('messages.lbl_elderBrother') }}</label>
			</div>
			<div class="box100per">
				@if($staffdetail[0]->ElderBrother!=0)
				  <span class="fblue">{{ $staffdetail[0]->ElderBrother }}</span>
				@else
				  <span class="fr">{{ "No" }}</span>
				@endif
			</div>
		</div>
		<div class="col-md-12 mt5" style="padding-right: 50px;">
			<div class="col-md-3 text-right clr_blue">
				<label>{{ trans('messages.lbl_youngerBrother') }}</label>
			</div>
			<div class="box100per">
				@if($staffdetail[0]->YoungerBrother!=0)
				  <span class="fblue">{{ $staffdetail[0]->YoungerBrother }}</span>
				@else
				  <span class="fr">{{ "No" }}</span>
				@endif
			</div>
		</div>
		<div class="col-md-12 mt5" style="padding-right: 50px;">
			<div class="col-md-3 text-right clr_blue">
				<label>{{ trans('messages.lbl_elderSister') }}</label>
			</div>
			<div class="box100per">
				<span>
					@if($staffdetail[0]->ElderSister!=0)
						<span class="fblue">{{ $staffdetail[0]->ElderSister }}</span>
					@else
						<span class="fr">{{ "No" }}</span>
					@endif
				</span>
			</div>
		</div>
		<div class="col-md-12 mt5" style="padding-right: 50px;">
			<div class="col-md-3 text-right clr_blue">
				<label>{{ trans('messages.lbl_youngerSister') }}</label>
			</div>
			<div class="box100per">
				<span>
					@if($staffdetail[0]->YoungerSister!=0)
						<span class="fblue">{{ $staffdetail[0]->YoungerSister }}</span>
					@else
						<span class="fr">{{ "No" }}</span>
					@endif
				</span>
			</div>
		</div>
		@if($staffdetail[0]->ElderBrother!="0")
		<div style="margin-top: 20px;">
		<center>
			<div class="box98per tablealternate mt12">
			<table border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr width="100%" style="text-align: center;background-color:#AADDE6;">
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_relation') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_name') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_kananame') }}</th>
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_dob') }}</th>
					<th class="text-center" width="5%" height="25px">
						{{ trans('messages.lbl_alive') }}</th>
					<th class="text-center" width="10%" height="25px">
						{{ trans('messages.lbl_workanualincome') }}</th>
				</tr>
				@for($idx=1;$idx<=$staffdetail[0]->ElderBrother;$idx++)
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
						{{ trans('messages.lbl_elderBrother').$idx }}</td>
						@php $ElderBrotherName='ElderBrother'.$idx.'Name'; @endphp
						<td class="pl5" width="15%" height="25px" 
							title="{{ singlefieldtitle($staffdetail[0]->$ElderBrotherName,30) }}">
							@if(mb_strlen($staffdetail[0]->$ElderBrotherName)>35) 
								{{ mb_substr($staffdetail[0]->$ElderBrotherName,0,35)."..." }}
							@else 
								{{ $staffdetail[0]->$ElderBrotherName }}
							@endif
						</td>
						@php $ElderBrotherkanaName='ElderBrother'.$idx.'kanaName'; 
						@endphp
						<td class="pl5" width="15%" height="25px"
							title="{{ singlefieldtitle($staffdetail[0]->$ElderBrotherkanaName,30) }}">
							@if(mb_strlen($staffdetail[0]->$ElderBrotherkanaName)>30) 
								{{ mb_substr($staffdetail[0]->$ElderBrotherkanaName,0,30)."..." }}
							@else 
								{{ $staffdetail[0]->$ElderBrotherkanaName }}
							@endif
						</td>
						<td width="6%" height="25px" align="center">
							@php $ElderBrotherDOB='ElderBrother'.$idx.'DOB'; @endphp
							@if($staffdetail[0]->$ElderBrotherDOB!="" && $staffdetail[0]->$ElderBrotherDOB!="0000-00-00")
								{{ $staffdetail[0]->$ElderBrotherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->$ElderBrotherDOB) }})
							@else
								{{ "" }}
							@endif
						</td>
						<td width="4%" height="25px" class="text-center">
							@php $ElderBrother='ElderBrother'.$idx; @endphp
							{{ Form::checkbox('father', '1',$staffdetail[0]->$ElderBrother, array('id'=>'father','class' => '','disabled'=>'disabled')) }}
						</td>
						@php $ElderBrotherWorkIncome='ElderBrother'.$idx.'WorkIncome'; @endphp
						@if($staffdetail[0]->$ElderBrotherWorkIncome !=0)
							<td width="4%" height="25px" class="text-right pr10">
								{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }} <span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->$ElderBrotherWorkIncome) }}</span>
							</td>
						@else
							<td width="4%" height="25px" class="text-center">
								{{ "---" }}
							</td>
						@endif
					</tr>
				@endfor
			</table>
			</div>
		</center>
		</div>
		@endif
		@if($staffdetail[0]->YoungerBrother!="0")
		<center>
			<div class="box98per tablealternate mt12">
			<table border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr width="100%" style="text-align: center;background-color:#AADDE6;">
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_relation') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_name') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_kananame') }}</th>
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_dob') }}</th>
					<th class="text-center" width="5%" height="25px">
						{{ trans('messages.lbl_alive') }}</th>
					<th class="text-center" width="10%" height="25px">
						{{ trans('messages.lbl_workanualincome') }}</th>
				</tr>
				@for($idx=1;$idx<=$staffdetail[0]->YoungerBrother;$idx++)
					<tr width="100%">
						<td class="pl5" width="6%" height="25px">
							{{ trans('messages.lbl_youngerBrother').$idx }}</td>
							@php $YoungerBrotherName='YoungerBrother'.$idx.'Name'; @endphp
						<td class="pl5" width="15%" height="25px" 
							title="{{ singlefieldtitle($staffdetail[0]->$YoungerBrotherName,30) }}">
							@if(mb_strlen($staffdetail[0]->$YoungerBrotherName)>35) 
								{{ mb_substr($staffdetail[0]->$YoungerBrotherName,0,35)."..." }}
							@else 
								{{ $staffdetail[0]->$YoungerBrotherName }}
							@endif
						</td>
			  			@php $YoungerBrotherKanaName='YoungerBrother'.$idx.'KanaName'; @endphp
						<td class="pl5" width="15%" height="25px" 
							title="{{ singlefieldtitle($staffdetail[0]->$YoungerBrotherKanaName,30) }}">
							@if(mb_strlen($staffdetail[0]->$YoungerBrotherKanaName)>30) 
								{{ mb_substr($staffdetail[0]->$YoungerBrotherKanaName,0,30)."..." }}
							@else 
								{{ $staffdetail[0]->$YoungerBrotherKanaName }}
							@endif
						</td>
						<td width="6%" height="25px" align="center">
							@php $YoungerBrotherDOB='YoungerBrother'.$idx.'DOB'; @endphp
							@if($staffdetail[0]->$YoungerBrotherDOB!="" && $staffdetail[0]->$YoungerBrotherDOB!="0000-00-00")
								{{ $staffdetail[0]->$YoungerBrotherDOB }} <span class="fwb">({{ birthday($staffdetail[0]->$YoungerBrotherDOB) }})
							@else
								{{ "" }}
							@endif
						</td>
						<td width="4%" height="25px" class="text-center">
							@php $YoungerBrother='YoungerBrother'.$idx; @endphp
							{{ Form::checkbox('YoungerBrother', '1',$staffdetail[0]->$YoungerBrother, array('id'=>'YoungerBrother','class' => '','disabled'=>'disabled')) }}
						</td>
						@php
						$YoungerBrotherWorkIncome='YoungerBrother'.$idx.'WorkIncome';
						@endphp
						@if($staffdetail[0]->$YoungerBrotherWorkIncome !=0)
							<td width="4%" height="25px" class="text-right pr10">
								{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }}
								<span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->$YoungerBrotherWorkIncome) }}</span>
							</td>
						@else
							<td width="4%" height="25px" class="text-center">
								{{ "---" }}
							</td>
						@endif
					</tr>
				@endfor
			</table>
			</div>
		</center>
		@endif
		@if($staffdetail[0]->ElderSister!="0")
		<center>
			<div class="box98per tablealternate mt12">
			<table border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr width="100%" style="text-align: center;background-color:#AADDE6;">
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_relation') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_name') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_kananame') }}</th>
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_dob') }}</th>
					<th class="text-center" width="5%" height="25px">
						{{ trans('messages.lbl_alive') }}</th>
					<th class="text-center" width="10%" height="25px">
						{{ trans('messages.lbl_workanualincome') }}</th>
				</tr>
				@for($idx=1;$idx<=$staffdetail[0]->ElderSister;$idx++)
				<tr width="100%">
					<td class="pl5" width="6%" height="25px">
						{{ trans('messages.lbl_elderSister').$idx }}</td>
					@php $ElderSisterName='ElderSister'.$idx.'Name'; @endphp
					<td class="pl5" width="15%" height="25px" 
						title="{{ singlefieldtitle($staffdetail[0]->$ElderSisterName,30) }}">
						@if(mb_strlen($staffdetail[0]->$ElderSisterName)>35) 
							{{ mb_substr($staffdetail[0]->$ElderSisterName,0,35)."..." }}
						@else 
							{{ $staffdetail[0]->$ElderSisterName }}
						@endif
					</td>
					@php $ElderSisterkanaName='ElderSister'.$idx.'kanaName'; @endphp
					<td class="pl5" width="15%" height="25px" 
						title="{{ singlefieldtitle($staffdetail[0]->$ElderSisterkanaName,30) }}">
						@if(mb_strlen($staffdetail[0]->$ElderSisterkanaName)>30) 
							{{ mb_substr($staffdetail[0]->$ElderSisterkanaName,0,30)."..." }}
						@else 
							{{ $staffdetail[0]->$ElderSisterkanaName }}
					 	@endif
					</td>
					<td width="6%" height="25px" align="center">
						@php $ElderSisterDOB='ElderSister'.$idx.'DOB'; @endphp
						@if($staffdetail[0]->$ElderSisterDOB!="" && $staffdetail[0]->$ElderSisterDOB!="0000-00-00")
							{{ $staffdetail[0]->$ElderSisterDOB }} <span class="fwb">({{ birthday($staffdetail[0]->$ElderSisterDOB) }})
						@else
							{{ "" }}
						@endif
					</td>
					<td width="4%" height="25px" class="text-center">
						@php $ElderSister='ElderSister'.$idx; @endphp
					  	{{ Form::checkbox('ElderSister', '1',$staffdetail[0]->$ElderSister, array('id'=>'ElderSister','class' => '','disabled'=>'disabled')) }}
					</td>
					@php $ElderSisterWorkIncome='ElderSister'.$idx.'WorkIncome'; @endphp
					@if($staffdetail[0]->$ElderSisterWorkIncome !=0)
						<td width="4%" height="25px" class="text-right pr10">
							{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }}
							<span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->$ElderSisterWorkIncome) }}</span>
						</td>
					@else
						<td width="4%" height="25px" class="text-center">
						{{ "---" }}
						</td>
					@endif
				</tr>
				@endfor
			</table>
			</div>
		</center>
		@endif
		@if($staffdetail[0]->YoungerSister!="0")
		<center>
			<div class="box98per tablealternate mt12">
			<table border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr width="100%" style="text-align: center;background-color:#AADDE6;">
					<th class="text-center" width="6%" height="25px">
						{{ trans('messages.lbl_relation') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_name') }}</th>
					<th class="text-center" width="15%" height="25px">
						{{ trans('messages.lbl_kananame') }}</th>
					<th class="text-center" width="6%" class="text-center"height="25px">
						{{ trans('messages.lbl_dob') }}</th>
					<th class="text-center" width="5%" height="25px">
						{{ trans('messages.lbl_alive') }}</th>
					<th class="text-center" width="10%" height="25px">
						{{ trans('messages.lbl_workanualincome') }}</th>
				</tr>
				@for($idx=1;$idx<=$staffdetail[0]->YoungerSister;$idx++)
				<tr width="100%">
					<td class="pl5" width="6%" height="25px">
						{{ trans('messages.lbl_youngerSister').$idx }}</td>
					@php $YoungerSisterName='YoungerSister'.$idx.'Name'; @endphp
					<td class="pl5" width="15%" height="25px" 
						title="{{ singlefieldtitle($staffdetail[0]->$YoungerSisterName,30) }}">
						@if(mb_strlen($staffdetail[0]->$YoungerSisterName)>35) 
							{{ mb_substr($staffdetail[0]->$YoungerSisterName,0,35)."..." }}
						@else 
							{{ $staffdetail[0]->$YoungerSisterName }}
						@endif
					</td>
					@php $YoungerSisterKanaName='YoungerSister'.$idx.'KanaName'; @endphp
					<td class="pl5" width="15%" height="25px" 
						title="{{ singlefieldtitle($staffdetail[0]->$YoungerSisterKanaName,30) }}">
						@if(mb_strlen($staffdetail[0]->$YoungerSisterKanaName)>30) 
							{{ mb_substr($staffdetail[0]->$YoungerSisterKanaName,0,30)."..." }}
						@else 
							{{ $staffdetail[0]->$YoungerSisterKanaName }}
						@endif
					</td>
					<td width="6%" height="25px" align="center">
						@php $YoungerSisterDOB='YoungerSister'.$idx.'DOB'; @endphp
						@if($staffdetail[0]->$YoungerSisterDOB!="" && $staffdetail[0]->$YoungerSisterDOB!="0000-00-00")
							{{ $staffdetail[0]->$YoungerSisterDOB }} <span class="fwb">({{ birthday($staffdetail[0]->$YoungerSisterDOB) }})
						@else
							{{ "" }}
						@endif
					</td>
					<td width="4%" height="25px" class="text-center">
						@php $YoungerSister='YoungerSister'.$idx; @endphp
						{{ Form::checkbox('YoungerSister', '1',$staffdetail[0]->$YoungerSister, array('id'=>'YoungerSister','class' => '','disabled'=>'disabled')) }}
					</td>
					@php $YoungerSisterWorkIncome='YoungerSister'.$idx.'WorkIncome'; 
					@endphp
					@if($staffdetail[0]->$YoungerSisterWorkIncome !=0)
						<td width="4%" height="25px" class="text-right pr10">
							{{ Form::checkbox('name', '1', 'true', array('disabled'=>'disabled')) }}
							<span class="fwb">{{ "Rs. ".moneyFormatIND($staffdetail[0]->$YoungerSisterWorkIncome) }}</span>
						</td>
					@else
						<td width="4%" height="25px" class="text-center">
							{{ "---" }}
						</td>
					@endif
				</tr>
				@endfor
			</table>
			</div>
		</center>
		@endif
		<div class="mb12"></div>
	</fieldset>
	</div>
	{{ Form::close() }}
	<div id="resign" class="modal fade">
		<div id="login-overlay">
			<div class="modal-content">
				<!-- Popup will be loaded here -->
			</div>
		</div>
	</div>
</article>
</div>
<div class="CMN_display_block pb10"></div>
@endsection