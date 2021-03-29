function resetErrors() {
	$('form input, form select, form radio').removeClass('inputTxtError');
	$('label.error').remove();
} 

function displaymessage() {
	document.getElementById('errorSectiondisplay').style.display='none';
}

function pageClick(pageval) {
	$('#page').val(pageval);
	$("#SalaryDetails").submit();
}

function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#SalaryDetails").submit();
}

function getData(month, year, flg, prevcnt, nextcnt, account_period, lastyear, currentyear, account_val) {
	var yearmonth = year + "-" +  ("0" + month).substr(-2);
	var mainmenu = $('#mainmenu').val();
	if ((prevcnt == 0) && (flg == 0) && (parseInt(month) < account_period) && (year == lastyear)) {
		alert(err_no_previous_record);
	} else if ((nextcnt == 0) && (flg == 0) && (parseInt(month) > account_period) && (year == currentyear)) {
		alert(err_no_next_record);
	} else {
		if (flg == 1) {
			document.getElementById('previou_next_year').value = year + "-" +  ("0" + month).substr(-2);
		}
	document.getElementById('selMonth').value = month;
	document.getElementById('selYear').value = year;
	document.getElementById('prevcnt').value = prevcnt;
	document.getElementById('nextcnt').value = nextcnt;
	document.getElementById('account_val').value = account_val;
	$('#pageclick').val('');
	$('#page').val('');
	$('#plimit').val('');
	$("#searchmethod").val('');
	$('#get_prev_yr').val('1');
	$('#SalaryDetails').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#SalaryDetails").submit();
	}
}

function empNameclick(empId){ 
	pageload();
	$('#plimit').val(50);
	$('#page').val('');
	$('#empIdArr').val(empId);
	$("#searchmethod").val(3);
	$('#SalaryDetails').attr('action','index'+'?mainmenu='+mainmenu+'&time='+datetime); 
	$("#SalaryDetails").submit();
}



