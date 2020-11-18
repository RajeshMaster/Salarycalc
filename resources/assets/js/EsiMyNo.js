var data = {};
$(document).ready(function() {

    var cc = 0;
    $('#esiMyNoSort').click(function () {
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
    $('#sidedesignselector').click(function () {
        if( $('#searchmethod').val() == 1){
            ccd++;
        }
        if (ccd % 2 == 0) {
            movediv = "+=220px"
        } else {
            movediv = "-=220px"
        }
        $('#importLink').animate({
            'marginRight' : movediv //moves down
        });
        ccd++;
        if( $('#searchmethod').val() == 1){
            ccd--;
        }  
    });  

    $('.addeditprocess').click(function () {
        $("#esiMyNoAddEdit").validate({
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

});

function resetErrors() {
    $('form input, form select, form radio').removeClass('inputTxtError');
    $('label.error').remove();
}

function pageClick(pageval) {
    $('#page').val(pageval);
    $("#esiMyNoIndex").submit();
}

function pageLimitClick(pagelimitval) {
    $('#page').val('');
    $('#plimit').val(pagelimitval);
    $("#esiMyNoIndex").submit();
}

function usinglesearch() {
    var mainmenu='family';
    var singlesearchtxt = $("#singlesearch").val();
    if (singlesearchtxt == "") {
        alert("Please Enter Search Value.");
        $("#singlesearch").focus(); 
        return false;
    } else {
        $('#plimit').val('');
        $('#page').val('');
        $('#searchmethod').val('1');
        $('#esiMyNoIndex').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
        $("#esiMyNoIndex").submit();
    }
}

function clearsearch() {
    $('#plimit').val(50);
    $('#page').val('');
    $('#singlesearch').val('');
    $('#searchmethod').val('');
    $("#esiMyNoIndex").submit();
}

function cancel(viewflg) {
    var mainmenu = $('#mainmenu').val();
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();
            $('#esiMyNoAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
            $("#esiMyNoAddEdit").submit();
        }
    } else {
        $('#esiMyNoAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#esiMyNoAddEdit").submit();
    }
}

function sortingfun() {
    pageload();
    $('#plimit').val('');
    $('#page').val('');
    
    var sortselect=$('#esiMyNoSort').val();

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
    
    $("#esiMyNoIndex").submit();

}

function addEdit(val,Emp_ID){

    $('#Emp_ID').val(Emp_ID);
    $('#editFlg').val(val);
    var mainmenu = $('#mainmenu').val();
    $('#esiMyNoIndex').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
    $("#esiMyNoIndex").submit();

}

function setMyNo(){
    var number = $('#myNo').val();
    if (number.length == 4) {
        $('#myNo').val($('#myNo').val() + ' ');
    }
    else if (number.length == 9) {
        $('#myNo').val($('#myNo').val() + ' ');
    }
}

function setEsiNo(){
    var number = $('#esiNo').val();
    if (number.length == 5) {
        $('#esiNo').val($('#esiNo').val() + '-');
    }
    else if (number.length == 12) {
        $('#esiNo').val($('#esiNo').val() + '-');
    }
}
