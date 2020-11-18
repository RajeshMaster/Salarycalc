$(document).ready(function() {
	$("#checkall").change(function(){  //"select all" change 
	    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
	});

	//".checkbox" change 
	$('.checkbox').change(function(){ 
		//uncheck "select all", if one of the listed checkbox item is unchecked
	    if(false == $(this).prop("checked")){ //if this item is unchecked
	        $("#checkall").prop('checked', false); //change "select all" checked status to false
	    }
		//check "select all" if all checkbox items are checked
		if ($('.checkbox:checked').length == $('.checkbox').length ){
			$("#checkall").prop('checked', true);
		}
	});
	$('.addeditprocess').click(function () {
        $("#addeditsalarycalc").validate({
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
                month: {required: true},
                date: {required: true, date: true,minlength:10,correctformatdate: true},
            },
            submitHandler: function(form) { // for demo
                if($('#editcheck').val() == 0 || $('#editcheck').val() == 3) {
                    var month = $('#month').val();
                	var Emp_ID = $('#Emp_ID').val();
                	var selYear = $('#selYear').val();
                	$.ajax({
                    type: 'GET',
                    url: 'getdataExists',
                    data: {"Emp_ID": Emp_ID,"selYear": selYear,"month": month},
                    success: function(resp) {
                        if (resp > 0) { 
                            document.getElementById('errorSectiondisplay').innerHTML = "";
                            err_invalidcer = "Data Already Exists";
                            var error='<div align="center" style="padding: 0px;" id="inform">';
                                    error+='<table cellspacing="0" class="statusBg1" cellpadding="0" border="0">';
                                    error+='<tbody><tr><td style="padding: 4px 10px" align="center"><span class="innerBg" id="mc_msg_txt">'+err_invalidcer+'</span></td>';
                                    error+='<td width="20" valign="top" style="padding-top: 4px; _padding-top: 2px;"><span>';
                                    error+='<a href="javascript:displaymessage();" class="fa fa-times" style="color:white;"/>';
                                    error+='</span></td>';
                                    error+='</tr></tbody></table></div>';
                            document.getElementById('errorSectiondisplay').style.display = 'block';
                            document.getElementById('errorSectiondisplay').innerHTML = error;
                            return false;
                        } else {
                    		var confirmprocess = confirm("Do You Want To Register?");
                    		if(confirmprocess) {

                    			if ($('#editcheck').val() == 3) {
                    				pageload();
                    				form.submit();
                   					return true;
                    			} else {
	                    			if ($("#stop_next").val() == '1' || $("#stop_next_hdn").val() == '1') {
	                    				$.ajax({
						                    type: 'GET',
						                    url: 'dataReg',
						                    data: $('#addeditsalarycalc').serialize(),
						                    success: function(resp) {
						                    	$('#hdn_id').val(resp);
						                    	gotoviewpage();
						                    },
						                    error: function(data) {
						                        alert(data);
						                    }
						                });
	                    			} else {
		                    			$.ajax({
						                    type: 'GET',
						                    url: 'dataReg',
						                    data: $('#addeditsalarycalc').serialize(),
						                    success: function(resp) {
						                    	$('#hdn_id').val(resp);
						                    	popupopenclose(1);
												$("#salconfirmpopup").modal({
													backdrop: 'static',
													keyboard: false
												});
												$('#salconfirmpopup').modal('show');
						                        
						                    },
						                    error: function(data) {
						                        alert(data);
						                    }
						                });
					                }
				                }
			                } else {
			                    return false;
			                }
                        }
                    },
                    error: function(data) {
                        alert(data);
                        // $("#regbutton").attr("data-dismiss","modal");
                    }
                	});
                } else {
                    var confirmprocess = confirm("Do You Want To Update?");
                }
                if(confirmprocess) {
                   pageload();
                   return true;
                } else {
                    return false;
                }
            }
        });
        $.validator.messages.required = function (param, input) {
            var article = document.getElementById(input.id);
            return article.dataset.label + ' field is required';
        }
    });
    // Multiadd Process
    $('.multiplereg').click(function () {
        $("#frmmultireg").validate({
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
                txt_startdate: {required: true, date: true,minlength:10,correctformatdate: true},
            },
            submitHandler: function(form) { // for demo
                var confirmprocess = confirm("Do You Want To Register?");
	            if(confirmprocess) {
	               pageload();
	               return true;
	            } else {
	                return false;
	            }
            }
        });
        $.validator.messages.required = function (param, input) {
            var article = document.getElementById(input.id);
            return article.dataset.label + ' field is required';
        }
    });

});

function resetErrors() {
	$('form input, form select, form radio').removeClass('inputTxtError');
	$('label.error').remove();
} 

function displaymessage() {
    document.getElementById('errorSectiondisplay').style.display='none';
}

function gotoviewpage() {
	pageload();
	$('#hiddenform').attr('action','../salarycalcplus/view?mainmenu='+mainmenu+'&time='+datetime);
	$("#hiddenform").submit();
}

function getnextrecordclick() {
	pageload();
	$('#next_record').val('1');
	$('#hdn_id').val('');
	$('#Emp_ID').val('');
	$('#firstname').val('');
	$('#lastname').val('');
	$('#hiddenform').attr('action','../salarycalcplus/addedit?mainmenu='+mainmenu+'&time='+datetime);
	$("#hiddenform").submit();
}

function pageClick(pageval) {
	$('#page').val(pageval);
	$("#salarycalcindex").submit();
}

function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#salarycalcindex").submit();
}

function multi_reg_calc(){
	var mainmenu = $('#mainmenu').val();
	var salChecked = new Array();
	if($('.checkboxid:checkbox:checked').length > 0){
		$('.checkboxid:checkbox:checked').each(function() {
	      salChecked[salChecked.length] = this.value;            
	    });
		$('#hdn_salid_arr').val(salChecked);
		$('#salflg').val('1');
	}
	$('#multiflg_reg').val('1');
	$('#salarycalcindex').attr('action','../salarycalcplus/multieditprocess?mainmenu='+mainmenu+'&time='+datetime);
	$("#salarycalcindex").submit();
}

function monthchangecalc(month) {
	var mainmenu = $('#mainmenu').val();
	$('#frmmultireg #selMonth').val(month);
	$('#frmmultireg #no_flg').val('1');
	$('#frmmultireg').attr('action','../salarycalcplus/multieditprocess?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmmultireg").submit();
}

function emplimitchangecalc(limit) {
	var mainmenu = $('#mainmenu').val();
	$('#frmmultireg #emp_limit').val(limit);
	$('#frmmultireg').attr('action','../salarycalcplus/multieditprocess?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmmultireg").submit();
}

function salaryselectpopup_main() {
	var mainmenu = $('#mainmenu').val();
	var year = $('#selYear').val();
	var month = $('#selMonth').val();
	var get_prev_yr = $('#get_prev_yr').val();
	popupopenclose(1);
	$('#salarypopup').load('../salarycalcplus/salarypopup?mainmenu='+mainmenu+'&year='+year+'&month='+month+'&get_prev_yr='+get_prev_yr);
	$("#salarypopup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#salarypopup').modal('show');
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
	$('#salarycalcindex').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#salarycalcindex").submit();
	}
}

function fngotoadd(id,empid,editcheck,mainmenu,firstname,lastname) {
	pageload();
	$('#id').val(id);
	$('#firstname').val(firstname);
	$('#lastname').val(lastname);
	$('#Emp_ID').val(empid);
	if (editcheck == 0) {
		$('#editcheck').val(editcheck);
		$('#salarycalcindex').attr('action', 'addedit?mainmenu='+mainmenu+'&time='+datetime);
		$("#salarycalcindex").submit();	
	} else {
		$('#editcheck').val('1');
		$('#salarycalcindex').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
		$("#salarycalcindex").submit();
	}
}

function gotoindexsalarycalc(mainmenu) {
	pageload();
	$('#addeditsalarycalc').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#addeditsalarycalc").submit();
}

function fngotoedit(mainmenu) {
	pageload();
	$('#editcheck').val('1');
	$('#addeditsalarycalc').attr('action', 'edit?mainmenu='+mainmenu+'&time='+datetime);
	$("#addeditsalarycalc").submit();
}

function fngotocopy(mainmenu) {
	pageload();
	$('#editcheck').val('3');
	$('#addeditsalarycalc').attr('action', 'edit?mainmenu='+mainmenu+'&time='+datetime);
	$("#addeditsalarycalc").submit();
}

function undercos() {
	alert('Under Construction');
}

function gotoindex(viewflg,mainmenu) {
	if (cancel_check == false) {
		if (!confirm("Do You Want To Cancel the Page?")) {
			return false;
		}
	}
	pageload();
	if ($('#editcheck').val() == 1 || $('#editcheck').val() == 3) {
		$('#editcheck').val('2');
		$('#salaryplusaddeditcancel').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
		$("#salaryplusaddeditcancel").submit();
	} else {
		$('#salaryplusaddeditcancel').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#salaryplusaddeditcancel").submit();
	}
}
function getdate() {
	$('#date').val(saldate);
}

function getdate_multicheck() {
	$('#txt_startdate').val(saldate);
}

function fngotohistory(empid,mainmenu,firstname,lastname) {
	$('#hiddenplimit').val($('#plimit').val());
	$('#hiddenpage').val($('#page').val());
	$('#Emp_ID').val(empid);
	$('#firstname').val(firstname);
	$('#lastname').val(lastname);
	$('#salarycalcindex').attr('action', 'history?mainmenu='+mainmenu+'&time='+datetime);
	$("#salarycalcindex").submit();
}

function gotoindexback(mainmenu,limit,page) {
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	$('#page').val(page);
	$('#plimit').val(limit);
	$('#selYear').val(year);
	$('#selMonth').val(month);
	$('#salarycalchistory').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#salarycalchistory").submit();
}

function goindex(viewflg,mainmenu) {
	if (cancel_check == false) {
		if (!confirm("Do You Want To Cancel the Page?")) {
			return false;
		}
	}
	pageload();
	$('#salaryplusmultieditcancel').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
	$("#salaryplusmultieditcancel").submit();
}

function empselectbypopupclick() {
	var length = $("#to option").length;
	if(length==0) {
		alert("Please Select atleast One Employee")
		return false;
	}
	var Emp_selection = "Do You Want To Add?";
	if(confirm(Emp_selection)) {
		$('#to option').prop('selected', true);
		$('#from option').prop('selected', true);
		document.empselectform.submit();
		return true;
	} else {
		return false;
	}
}

function gototsalamount() {
	var totalamount = $('#totamt').data('totalamt');

	$.ajax({
        type: 'GET',
        url: 'getsalamount',
        data: $('#addeditsalarycalc').serialize(),
        success: function(resp) {
        	var diff_amt = parseInt(Number(resp.trim().replace(/[, ]+/g, ""))) - parseInt(Number(totalamount.trim().replace(/[, ]+/g, "")));
        	var diff_amnt = '<span style="font-weight: bold;">Dif amt : </span>&nbsp;<span style="color: red;">' + diff_amt.toLocaleString() + '</span>';
        	$("#difference_amount").html(diff_amnt);
        	$('#salamt').val(resp);
        },
        error: function(data) {
            alert(data);
        }
    });
	// $('#transferred').val($('#totamt').text());
}

function getTransferedAmount() {
	var totalamount = $('#totamt').data('totalamt');

	$.ajax({
        type: 'GET',
        url: 'getTransferedAmount',
        data: $('#addeditsalarycalc').serialize(),
        success: function(resp) {
        	var diff_amt = parseInt(Number(resp.trim().replace(/[, ]+/g, ""))) - parseInt(Number(totalamount.trim().replace(/[, ]+/g, "")));
        	var diff_amnt = '<span style="font-weight: bold;">'+lbl_amount_difference+'</span>&nbsp;<span style="color: red;">' + diff_amt.toLocaleString() + '</span>';
        	$("#difference_amount").html(diff_amnt);
        	$('#salamt').val(resp);
        },
        error: function(data) {
            $('#salamt').val('');
        }
    });
	// $('#transferred').val($('#totamt').text());
}

function gotoemployeewise() {
	pageload();
	$('#tblchg').val('0');
	$('#salarycalcindex').submit();
}

function gotomaster() {
	pageload();
	$('#tblchg').val('1');
	$('#salarycalcindex').submit();
}

function getlastmonthdetails() {
	var month = $('#month').val();
	var Emp_ID = $('#Emp_ID').val();
	var selYear = $('#selYear').val();
	$.ajax({
        type: 'GET',
        url: 'getlastmonthdet',
        data: {"Emp_ID": Emp_ID,"selYear": selYear,"month": month},
        success: function(resp) {
        	var obj = jQuery.parseJSON(resp);
        	var sum = 0;
        	$("#totamt").text('');
        	$.each( obj, function( index, value ){
        		$('#'+index).val(value);
        		if (index !== 'remarks') {
        			var remnum = Number(value.trim().replace(/[, ]+/g, ""));
			        //add only if the value is number
			        if (!isNaN(remnum) && value.length != 0) {
			            sum += parseFloat(remnum);
			            // $(this).css("background-color", "#FEFFB0");
			        }
        		}
        		
			});
			var isNeg = sum < 0;
		    var amount = isNeg ? sum : Math.abs(sum.toFixed(0));
			var tot = amount.toLocaleString();
			var tott = tot;
			$("#totamt").text(tott);
			$("#totamt").data('totalamt', tott);
        },
        error: function(data) {
            alert(data);
        }
    });
}

function fngodownloadempid(mainmenu) {
	var confirmprocess_download = confirm("Do You Want To Download?");
    if(confirmprocess_download) {
		$('#addeditsalarycalc').attr('action','../salarycalcplus/salarydownloadprocess?mainmenu='+mainmenu+'&time='+datetime);
		$("#addeditsalarycalc").submit();
	}
}

function transferdetailsdownload(mainmenu) {
	$('#hdn_empid_arr').val('');
	var cbChecked = new Array();
	var cbChecked_text_mailflg_0 = new Array();
	var cbChecked_text_mailflg_1 = new Array();
	if($('.checkbox:checkbox:checked').length > 0){
		$('.checkbox:checkbox:checked').each(function() {
			if ($(this).attr("data-mailflg") == 0) {
	      		cbChecked[cbChecked.length] = this.value;            
	      		cbChecked_text_mailflg_0[cbChecked_text_mailflg_0.length] = $(this).attr("data-name-empid").toUpperCase();            
			} else {
	      		cbChecked_text_mailflg_1[cbChecked_text_mailflg_1.length] = $(this).attr("data-name-empid").toUpperCase();            
			}
	    });
	    $('#hdn_empid_arr').val(cbChecked);
	    var confirmprocess_download = confirm("Do You Want To Download?");
	    if(confirmprocess_download) {
			$('#salarycalcindex').attr('action','../salarycalcplus/transferdetailsdownload?mainmenu='+mainmenu+'&time='+datetime);
			$("#salarycalcindex").submit();
		}
	} else {
		alert("Please Select Employee ID");return;
	}
}

// Start Madasamy 03/08/2020
function salaryplusdownload(mainmenu) {

	var variable = $("#selMonth").val();
	if(typeof(variable) != "undefined" && variable !== null) {
	    $("#payrollExcel").val(variable);
	    var form = '#salarycalcindex';
	} else{
		var form = '#salarycalchistoryTotal';
	}

	$('#hdn_empid_arr').val('');
	var cbChecked = new Array();
	var cbChecked_text_mailflg_0 = new Array();
	var cbChecked_text_mailflg_1 = new Array();
	if($('.checkbox:checkbox:checked').length > 0){
		$('.checkbox:checkbox:checked').each(function() {
			if ($(this).attr("data-mailflg") == 0) {
	      		cbChecked[cbChecked.length] = this.value;            
	      		cbChecked_text_mailflg_0[cbChecked_text_mailflg_0.length] = $(this).attr("data-name-empid").toUpperCase();            
			} else {
	      		cbChecked_text_mailflg_1[cbChecked_text_mailflg_1.length] = $(this).attr("data-name-empid").toUpperCase();            
			}
	    });
	    $('#hdn_empid_arr').val(cbChecked);
	    var confirmprocess_download = confirm("Do You Want To Download?");
	    if(confirmprocess_download) {
			$(form).attr('action','../salarycalcplus/salaryplusdownload?mainmenu='+mainmenu+'&time='+datetime);
			$(form).submit();
		}
	} else {
		alert("Please Select Employee ID");return;
	}
}

function salplusPayrollSingledownload(mainmenu,dataCount) {
	if (dataCount != "" && dataCount > 0) {
		var confirmprocess_download = confirm("Do You Want To Download?");
	    if(confirmprocess_download) {
			$('#salarycalchistorydwnld').attr('action','../salarycalcplus/salaryplusPayrollSingleDownload?mainmenu='+mainmenu+'&time='+datetime);
			$("#salarycalchistorydwnld").submit();
		}
	} else {
		alert('No data found...'); return false;
	}
}

function historyTotal(mainmenu){
	$('#salarycalcindex').attr('action','../salarycalcplus/historyTotal?mainmenu='+mainmenu+'&time='+datetime);
	$("#salarycalcindex").submit();
}
// End Madasamy 03/08/2020
