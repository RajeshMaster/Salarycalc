$(document).ready(function() {
	var cc = 0;
	$('#basicsort').click(function () {
		cc++;
		if (cc == 2) {
			$(this).change();
			cc = 0;
		} 
	}).change (function () {
		sortingfun();
		cc = -1;
	}); 
});

function pageClick(pageval) {
	$('#page').val(pageval);
	$("#gensenIndex").submit();
}

function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#gensenIndex").submit();
}

function sortingfun() {
	pageload();
	$('#plimit').val('');
	$('#page').val('');
	var sortselect=$('#basicsort').val();
	$('#sortOptn').val(sortselect);
	var alreadySelectedOptn=$('#sortOptn').val(); 
	var alreadySelectedOptnOrder=$('#sortOrder').val();
	if (sortselect == alreadySelectedOptn) {
		if (alreadySelectedOptnOrder == "asc") {
			$('#sortOrder').val("desc"); 
		} else {
			$('#sortOrder').val("asc"); 
		}
	}
    $('#gensenIndex').submit();
}

function getData(selYear,time) {
	$('#selYear').val(selYear);
	var mainmenu = $('#mainmenu').val();
	$('#gensenIndex').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
	$("#gensenIndex").submit();
}

function staffview(id) { 
	var mainmenu = $('#mainmenu').val();
	$('#Emp_ID').val(id);
	$('#gensenIndex').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
	$("#gensenIndex").submit();
}

function goindexpage(yr) {
	var mainmenu = $('#mainmenu').val();
	$('#selYear').val(yr);
	$('#frmgensenstaffview').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmgensenstaffview").submit();
}

function fngodownloadgensen() {
	var confirmprocess_download = confirm("Do You Want To Download?");
	var mainmenu = $('#mainmenu').val();
	if(confirmprocess_download) {
		$('#frmgensenstaffview').attr('action','../Gensendtls/gensenDownload?mainmenu='+mainmenu+'&time='+datetime);
		$("#frmgensenstaffview").submit();
	}
}

function salarydeduction() {
	var mainmenu = $('#mainmenu').val();
	var year = $('#selYear').val();
	popupopenclose(1);
	$('#salarydeductionpopup').load('../Gensendtls/salarydeductionpopup?mainmenu='+mainmenu+'&year='+year);
	$("#salarydeductionpopup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#salarydeductionpopup').modal('show');
}


function deductionselectbypopupclick() {
	var length = $("#to option").length;
	if(length == 0) {
		alert("Please Select atleast One Deduction")
		return false;
	}
	var Emp_selection = "Do You Want To Add?";
	if(confirm(Emp_selection)) {
		$('#to option').prop('selected', true);
		$('#from option').prop('selected', true);
		document.deductionselectform.submit();
		return true;
	} else {
		return false;
	}
}
