function resetErrors() {
	$('form input, form select, form radio').removeClass('inputTxtError');
	$('label.error').remove();
} 

function displaymessage() {
	document.getElementById('errorSectiondisplay').style.display='none';
}

function pageClick(pageval) {
	$('#page').val(pageval);
	$("#SalarycalcAndSalaryplus").submit();
}

function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#SalarycalcAndSalaryplus").submit();
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
	$('#get_prev_yr').val('1');
	$('#SalarycalcAndSalaryplus').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#SalarycalcAndSalaryplus").submit();
	}
}

// function employeeCheck(val,empId,id) {
// 	if ($("#empIdCheck"+val).prop('checked') == true) {
// 		$('#salId'+val).val(id);
// 		$('#salempId'+val).val(empId);
// 	} else {
// 		$('#salId'+val).val('');
// 		$('#salempId'+val).val('');
// 	}
// }

function addeditemployee(totalval) {
	if (totalval != "") {
		var confirmprocess = confirm("Do You Want To Update?");
		if(confirmprocess) {
			$('#totVal').val(totalval);
			$('#SalarycalcAndSalaryplus').attr('action', 'addeditemp?mainmenu='+mainmenu+'&time='+datetime);
			$("#SalarycalcAndSalaryplus").submit();
		} else {
			return false;
		}
	} else {
		return false;
	}
	
}
