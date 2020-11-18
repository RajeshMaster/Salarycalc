var data = {};
$(document).ready(function() {
	var cc = 0;
	$('#contractsort').click(function () {
		cc++;
		if (cc == 2) {
			$(this).change();
			cc = 0;
		}
	}).change (function () {
		sortingfun();
		cc = -1;
	}); 
	// MOVE SORTING
	var ccd = 0;
	$('#movesorting').click(function () {
		if( $('#searchmethod').val() == 1 || $('#searchmethod').val() == 2){
			ccd++;
		}
		if (ccd % 2 == 0) {
			movediv = "+=220px"
		} else {
			movediv = "-=220px"
		}
		$('#contractsort').animate({
			'marginRight' : movediv //moves down
		});
		ccd++;
		if( $('#searchmethod').val() == 1 || $('#searchmethod').val() == 2){
			ccd--;
		}  
	}); 
	$(".Salary").each(function() {
		$(this).keyup(function(){
			calculateSum();
		});
	});
	$('.addeditprocess').click(function () {
		$("[name='contractform']").validate({
			showErrors: function(errorMap, errorList) {
				// Clean up any tooltips for valid elements
				$.each(this.validElements(), function (index, element) {
					var $element = $(element);
					$element.data("title", "") // Clear the title - there is no error associated anymore
					.removeClass("error")
					.tooltip("destroy");
				});
				// Create new tooltips for invalid elements
				$.each(errorList, function (index, error) {
					var $element = $(error.element);
					$element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
					.data("title", error.message)
					.addClass("error")
					.tooltip(); // Create a new tooltip based on the error messsage we just set in the title
				});
			},
			rules: {
				StartDate: {required: true, date: true},
				numyear: {required: true, money: "#numyear"},
				Salary: {required: true, money: "#Salary"},
				Travel_Expense: {required: true, money: "#Travel_Expense"},
				Accommodation: {required: true, money: "#Accommodation"},
				Contract_date: {required: true, date: true, lessThanJoindate: "#StartDate"},
			},
			submitHandler: function(form) { // for demo
				if($("#confirm").val() == '1') {
					if(confirm(err_confreg)) {
						pageload();
						$(".add").attr("disabled", false);
						form.submit();
					} else {
						$(":submit").attr("disabled", false);
					}
				} else {
					if(confirm(err_confup)) {
						pageload();
						$(".edit").attr("disabled", false);
						form.submit();
					} else {
						$(":submit").attr("disabled", false);
					}
				}
			}
		});
		$.validator.messages.required = function (param, input) {
			var article = document.getElementById(input.id);
			return article.dataset.label + err_fieldreq;
		}
	});
});
function resetErrors() {
	$('form input, form select, form radio').removeClass('inputTxtError');
	$('label.error').remove();
}
function sortingfun() {
	pageload();
	$('#plimit').val(50);
	$('#page').val('');
	var sortselect=$('#contractsort').val();
	var alreadySelectedOptn=$('#sortOptn').val();
	var alreadySelectedOptnOrder=$('#sortOrder').val();
	if (sortselect == alreadySelectedOptn) {
		if (alreadySelectedOptnOrder == "asc") {
			$('#sortOrder').val('desc');
		} else {
			$('#sortOrder').val('asc');
		}
	} else {
		if (alreadySelectedOptnOrder == "asc") {
			$('#sortOrder').val('desc');
		} else {
			$('#sortOrder').val('asc');
		}
	}
	$("#contractform").submit();
 }
function checkenable(numyear) { 
	if($("#check").is(":checked")) {
		$("#numyear").removeAttr("disabled");
	} else { 
		$("#numyear").val('');
		$("#numyear").attr("disabled" , "disabled");
	}
}
function filter(filterval) {
	pageload();
	$('#page').val('');
	$('#plimit').val('');
	$('#contractsort').val('');
	$('#sortOptn').val('');
	$('#sortOrder').val('');
	$("#filterval").val(filterval);
	$("#contractform").submit();
}
function pageClick(pageval) {
	$('#page').val(pageval);
	$("#contractform").submit();
}
function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#contractform").submit();
}
function gotoBack(viewlist,mainmenu) {
	pageload();
	$('#contractform').attr('action', 'viewlist'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoBack1(index,backcheck) {
	pageload();
	if (backcheck == 1) {
		$('#backtoindex #mainmenu').val($('#backtoindex #defaultmainmenu').val());
		var mainmenu=$('#backtoindex #mainmenu').val();
		$('#backtoindex').attr('action', '../Employees/index?mainmenu='+mainmenu+'&time='+datetime);
		$("#backtoindex").submit();
	} else if (backcheck == 2) {
		$('#backtoview #mainmenu').val($('#backtoview #defaultmainmenu').val());
		var mainmenu=$('#backtoview #mainmenu').val();
		$('#backtoview').attr('action', '../Employees/view?mainmenu='+mainmenu+'&time='+datetime);
		$("#backtoview").submit();
	} else {
		var mainmenu=$('#contractform #mainmenu').val();
		$('#contractform').attr('action', 'index'+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#contractform").submit();
	}
}
function gotoBack2(salarycertify,mainmenu) {
	$('#contractform').attr('action', 'index'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoBack2(salarycertify,mainmenu) {
	if (backcheck == 1) {
		$('#backtoindex #mainmenu').val($('#backtoindex #defaultmainmenu').val());
		var mainmenu=$('#backtoindex #mainmenu').val();
		$('#backtoindex').attr('action', '../Employees/index?mainmenu='+mainmenu+'&time='+datetime);
		$("#backtoindex").submit();
	} else {
		var mainmenu=$('#contractform #mainmenu').val();
		$('#contractform').attr('action', 'index'+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#contractform").submit();
	}
}
function gotoBack2(salarycertify,mainmenu) {
	pageload();
	$('#contractform').attr('action', 'salarycertify'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoBackview(viewlist,mainmenu) {
	pageload();
	$('#contractform').attr('action', 'viewlist'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function goCancel(viewlist,mainmenu) {
	pageload();
	$('#contractform').attr('action', 'viewlist'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function setEnddate () {
	var year = document.getElementById('numyear').value;
	if(year == "" || year == "0"){
		year = "1";
	}
	var timestamp = Date.parse($("#StartDate").val());
	var myLength = $("#StartDate").val().length;
	if (isNaN(timestamp) == true || myLength !=10) { 
		document.getElementById('StartDate').value = "";
		document.getElementById('EndDate').value = "";
		document.getElementById('CoEndDate').value = "";
	}
	if (document.getElementById('StartDate').value != "" && isNaN(timestamp) == false && myLength ==10) {
		var ContractTerm = year;
		var dateMin = document.getElementById('StartDate').value;
		dateMin = new Date(dateMin);
		var rMax = new Date(dateMin.getFullYear() + parseInt(ContractTerm), dateMin.getMonth(),dateMin.getDate() - 1);
		var setEddate = (rMax.getFullYear())+"-"+("0"+(rMax.getMonth()+1)).slice(-2)+"-"+("0"+rMax.getDate()).slice(-2);
		document.getElementById('EndDate').value = setEddate;
		document.getElementById('CoEndDate').value = setEddate;
	}
}
function list(contractid,mainmenu) {
	pageload();
	$('#contractid').val(contractid);
	$('#contractform').attr('action', 'viewlist'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoView1(contractid,backcheck) {
	pageload();
	if (backcheck == 1) {
		$('#contractform #page').val('');
		$('#contractform #plimit').val('');
		$('#contractform #contractsort').val('');
		$('#contractform #sortOptn').val('');
		$('#contractform #sortOrder').val('');
		$("#contractform #filterval").val(1);
	}
	var mainmenu=$('#contractform #mainmenu').val();
	$('#contractform #contract_id').val(contractid);
	$('#contractform').attr('action', 'singleview'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoRegister(contractid,backcheck) {
	pageload();
	if (backcheck == 1) {
		$('#contractform #page').val('');
		$('#contractform #plimit').val('');
		$('#contractform #contractsort').val('');
		$('#contractform #sortOptn').val('');
		$('#contractform #sortOrder').val('');
		$("#contractform #filterval").val(1);
	}
	var mainmenu=$('#contractform #mainmenu').val();
	$('#contractform #contract_id').val(contractid);
	$('#contractform').attr('action', 'addedit'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function gotoRegisters(contractid,mainmenu) {
	$('#contractid').val(contractid);
	$('#contractform').attr('action', 'addeditprocess'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function calculateSum() {
	var total = 0;
	$(".Salary").each(function() {
		var getVal = this.value.replace(/,/g, "");
		if(getVal != "") {
			total += parseFloat(getVal);
		}
	});
	var totalWithcomma = inrFormat(total, "jp");
	$("#sum").html(totalWithcomma);
	$("#oldtotal").html("");
	$("#Total").val(total);
}
function fncontractedit(contractid,mainmenu) {
	pageload();
	$('#contract_id').val(contractid);
	$('#contractform').attr('action', 'edit'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();
}
function fnsalarycertify(contractid,backcheck) {
	pageload();
	if (backcheck == 1) {
		$('#contractform #page').val('');
		$('#contractform #plimit').val('');
		$('#contractform #contractsort').val('');
		$('#contractform #sortOptn').val('');
		$('#contractform #sortOrder').val('');
	}
	var mainmenu=$('#contractform #mainmenu').val();
	$('#contractform #contract_id').val(contractid);
	$('#contractform').attr('action', 'salarycertify'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();  
}
function fnsalarycertifyHistory(contractid,mainmenu) {
	pageload();
	$('#contract_id').val(contractid);
	$('#contractform').attr('action', 'salarycertifyhistory'+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#contractform").submit();  
}
function fnhistory(id, contract_id, reason) {
	$('#salCertification_id').val(id);
	$('#contract_id').val(contract_id);
	$('#reason').val(reason);
	if($('#reason').val(reason) != ""){
		if(confirm("Do You Want Download The Excel")) {
			$('#contractform').attr('action', 'salarycertifydownload');
			$("#contractform").submit();
		}
	}
}
function fncontractdownload(mainmenu) {
	if(confirm("Do You Want Download The Excel")) {
		$('#contractform').attr('action', 'empcontractdownload'+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#contractform").submit();
	}
}
function download(file,path) {
	var confirm_download = "Do You Want To Download?";
	if(confirm(confirm_download)) {
		window.location.href="../app/Http/Common/downloadfile.php?file="+file+"&path="+path+"/";
	}
}
function cancel(viewflg,mainmenu) {
	if (cancel_check == false) {
		if (confirm(cancel_msg)) {
			pageload();
			$('#contractformcancel').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
			$("#contractformcancel").submit();
		}
	} else {
		pageload();
		$('#contractformcancel').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#contractformcancel").submit();
	}
}
function clearsearch() {
	$('#plimit').val(50);
	$('#page').val('');
	$('#contractsort').val('');
	$('#sortOptn').val('');
	$('#sortOrder').val('asc');
	$('#singlesearch').val('');
	$('#msearchempid').val('');
	$('#msearchempname').val('');
	$('#searchmethod').val('');
	$("#contractform").submit();
}
function singlesearchclick() {
	var mainmenu = 'contract';
	var singlesearchtxt = $("#singlesearch").val();
	$('#msearchempid').val('');
	$('#msearchempname').val('');
	if (singlesearchtxt == "") {
		alert("Please Enter The Contract Search.");
		$("#singlesearch").focus(); 
		return false;
	} else {
		$('#plimit').val(50);
		$('#page').val('');
		if ($('#singlesearch').val()) {
			$("#searchmethod").val(1);
		} else {
			$("#searchmethod").val('');
		}
		$('#contractsort').val('');
		$('#contractform').submit();
	}
}
function multiplesearch() {
	var mainmenu = 'contract';
	var msearchempid = $("#msearchempid").val();
	var msearchempid = document.getElementById('msearchempid').value;
	var msearchempname = $("#msearchempname").val();
	var msearchempname = document.getElementById('msearchempname').value;
	$('#singlesearch').val('');
	if (msearchempid == "" && msearchempname == "") {
		alert("contract search is missing.");
		$("#msearchempid").focus(); 
		return false;
	} else {
		$('#plimit').val(50);
		$('#page').val('');
		$('#contractsort').val('');
		$("#searchmethod").val(2);
		$("#contractform").submit();
	}
}
function checkSubmitsingle(e) {
	if(e && e.keyCode == 13) {
		singlesearchclick();
	}
}
function checkSubmitmulti(e) {
	if(e && e.keyCode == 13) {
		multiplesearch();
	}
}

