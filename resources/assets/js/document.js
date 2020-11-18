
	// Start Madasamy - 28/07/20
	var data = {};
	$(document).ready(function() {

	    $('.addeditprocess').click(function () {

	    	var file_name = $("#file_name").val();
	 		var file_name_temp = $("#file_name_temp").val();
	 		var prevDocChk = $("#prevDocChk").val();

	        $("#documentAddEdit").validate({
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
	                file_name: {
	                	checkotherField: "#file_name_temp", 
	                }
	            },
	            submitHandler: function(form) { // for demo

	                if($('#editpage').val() != "editpage") {                    
	                    var confirmprocess = confirm("Do You Want To Register?");
	                } else if($('#editpage').val() == "editpage") {
	                    var confirmprocess = confirm("Do You Want To Update?");
	                }
	                 if(confirmprocess) {
	                    pageload();
	                    form.submit();
	                    return true;
	                } else {
	                    return false;
	                }
	            }
	        });

	        $.validator.messages.required = function (param, input) {
	            var article = document.getElementById(input.id);
	            return article.dataset.label + err_fieldreq;
	        }
	        $.validator.messages.extension = function (param, input) {
	            return err_extension;
	        }
	    });

		// Previous Doc checkbox
	    $('#prevDoc').change(function(){ 

	    	$('#file_name').tooltip('destroy');
	    	$("#file_name").removeClass('error');
	    	$("#file_name").val("");
	        if ($(this).prop("checked") == true){
	        	$("#prevDocChk").val(1);
		        var docId = $('#document_name').val();
		        $.ajax({
		            type: 'GET',
		            url: 'getPrevDocName',
		            data: { "docId": docId },
		            success: function(resp) {

		            	if (resp == "empty") {
		            		alert('Previous document not found...');
		            		$('#prevDoc').prop("checked",false);
		            		$("#prevDocName").text("");
		            		$("#file_name_temp").val("");
		            		$("#file_type").val("");
		            	} else {
		            		var obj = JSON.parse(resp);
		            		$("#prevDocName").text(obj.file_name);
		            		$("#file_name_temp").val(obj.file_name);
		            		$("#file_type").val(obj.file_type);

		            	} 
		            },
		            error: function(data) {
		                alert(data);
		            }
		        });
		    } else {
		    	$("#prevDocChk").val("");
		    	$("#prevDocName").text("");
	    		$("#file_name_temp").val("");
	    		$("#file_name").val("");
	    		$("#file_type").val("");
		    }
    	});

	});

	function resetErrors() {
	    $('form input, form select, form radio').removeClass('inputTxtError');
	    $('label.error').remove();
	}

	function pageClick(pageval) {

	    var mainmenu = $('#mainmenu').val();
	    $('#page').val(pageval);
	    $("#frmdocumentindex").submit();
	}

	function pageLimitClick(pagelimitval) {
		var mainmenu = $('#mainmenu').val();
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#frmdocumentindex").submit();
	}

	function addedit(type,id) {
		var mainmenu = $('#mainmenu').val();
		$('#editflg').val(type);
		$('#docId').val(id);
		$('#frmdocumentindex').attr('action', 'addedit?mainmenu='+mainmenu+'&time='+datetime);
		$("#frmdocumentindex").submit();
	}

	function getData(selYear,time) {
	  $('#selYear').val(selYear);
	  var mainmenu = $('#mainmenu').val();
	  $('#frmdocumentindex').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
	  $("#frmdocumentindex").submit();
	}

	function fileDownload(id) {
		var mainmenu = $('#mainmenu').val();
		var confirm_create = " Do you Want to Download the File";
		if(confirm(confirm_create)) {
		  
		  $('#frmdwnld #id').val(id);
		  $('#frmdwnld').attr('action', 'fileDownloadProcess?mainmenu='+mainmenu+'&time='+datetime);
		  $("#frmdwnld").submit();
		  
		}
	}

	function cancel(){
		var mainmenu = $('#mainmenu').val();
		if (cancel_check == false) {
		    if (confirm(cancel_msg)) {
		        $('#documentAddEditCancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		        $("#documentAddEditCancel").submit();
		    }
		} else {
		    $('#documentAddEditCancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		    $("#documentAddEditCancel").submit();
		}
	}

	function validate(file) {
	    var ext = file.split(".");
	    ext = ext[ext.length-1].toLowerCase();      
	    var arrayExtensions = ["pdf" , "xlsx", "xls"];

	    if (arrayExtensions.lastIndexOf(ext) == -1) {
	        alert("Wrong extension type.");
	        $("#file_name").val("");
	    }

	    $("#file_name_temp").val("");
	    $("#file_type").val("");
	    $('#prevDoc').prop("checked",false);
		$("#prevDocName").text("");
	}

	// End Madasamy - 28/07/20