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

    $('.addeditprocess').click(function () {
        $("#addeditbasiccalc").validate({
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
                basic_amount: {required: true,money: true},
                increment_amount: {required: true,money: true},
                year_month_from: {required: true, date: true,minlength:10,correctformatdate: true},
                totalmonth: {required: true},
                hra: {required: true,money: true},
            },
            submitHandler: function(form) {
                if($('#editcheck').val() == 0 || $('#editcheck').val() == 2) {                    
                    var confirmprocess = confirm("Do You Want To Register?");
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

    // Mail Need or not checkbox
    var mail_need = '0';
    $('#mailneed').change(function(){ 
        if(false == $(this).prop("checked")){ //if this item is unchecked
            var mail_need = '0';
        }
        if ($('#mailneed:checked').length == $('#mailneed').length ){
            var mail_need = '1';
        }
        var Emp_ID = $('#Emp_ID').val();
        $.ajax({
            type: 'GET',
            url: 'update_mail',
            data: {"Emp_ID": Emp_ID,"mail_need": mail_need},
            success: function(resp) {
                // alert(resp);
            },
            error: function(data) {
                alert(data);
            }
        });
    });
    
});
function resetErrors() {

    $('form input, form select').removeClass('inputTxtError');

    $('label.error').remove();

} 

function pageClick(pageval) {

    $('#page').val(pageval);

    $("#salbasicindex").submit();

}

function pageLimitClick(pagelimitval) {

    $('#page').val('');

    $('#plimit').val(pagelimitval);

    $("#salbasicindex").submit();

}

function gotoindexBasicCalc(mainmenu){
    $('#basicCalcView').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    $("#basicCalcView").submit();
}

function fngotoedit(mainmenu) {
    pageload();
    $('#editcheck').val('1');
    $('#basicCalcView').attr('action', 'edit?mainmenu='+mainmenu+'&time='+datetime);
    $("#basicCalcView").submit();
}

function basicCalcRegCancel(mainmenu,editFlg){
    if (cancel_check == false || editFlg == 2) {
        if (!confirm("Do You Want To Cancel the Page?")) {
            return false;
        }
    }
    if(editFlg == 1 || editFlg == 2){
        $('#addeditCancel').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
        $("#addeditCancel").submit();
    } else {
        $('#addeditCancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
        $("#addeditCancel").submit();
    }
}

function gotoaddedit(empid, editcheck,firstname, lastname) {
    pageload();

    $('#Emp_ID').val(empid);
    $('#firstname').val(firstname);
    $('#lastname').val(lastname);
    if (editcheck == 0) {
        $('#editcheck').val(editcheck);
        $('#salbasicindex').attr('action', 'addedit?mainmenu='+mainmenu+'&time='+datetime);
        $("#salbasicindex").submit();   
    } else {
        $('#editcheck').val('1');
        $('#salbasicindex').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
        $("#salbasicindex").submit();
    }
}

function fngotoAdd(mainmenu){
    $('#editcheck').val('2');
    $('#basicCalcView').attr('action', 'addBasic?mainmenu='+mainmenu+'&time='+datetime);
    $("#basicCalcView").submit();   
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
    $('#salbasicindex').submit();
}