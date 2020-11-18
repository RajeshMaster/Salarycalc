var data = {};
$(document).ready(function() {

    var cc = 0;
    $('#familysort').click(function () {
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
        $("[name='familyAddEdit']").validate({
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
                FirstName: {required: true},
                LastName: {required: true},
                Kana_FirstName: {required: true},
                Kana_LastName: {required: true},
                DOB: {required: true, date: true,correctformatdate: true,DOB : "#DOB"},
                relationType: {required: true},
                subRelationType: {required: true},
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

function gotoIndex() {

    $('#myfamilyView').attr('action', 'index?mainmenu=family&time='+datetime);
    $("#myfamilyView").submit();
}

function pageClick(pageval) {
    $('#page').val(pageval);
    $("#index").submit();
}

function pageLimitClick(pagelimitval) {
    $('#page').val('');
    $('#plimit').val(pagelimitval);
    $("#index").submit();
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
        $('#index').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
        $("#index").submit();
    }
}

function clearsearch() {
    $('#plimit').val(50);
    $('#page').val('');
    $('#singlesearch').val('');
    $('#searchmethod').val('');
    $("#index").submit();
}

function cancel(viewflg) {
    var mainmenu = $('#mainmenu').val();
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();

            if (viewflg == "familyView") {
                window.history.back();
            }
            $('#familyAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
            $("#familyAddEdit").submit();
        }
    } else {
        if (viewflg == "familyView") {
            window.history.back();
        }
        $('#familyAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#familyAddEdit").submit();
    }
}

function sortingfun() {
    pageload();
    $('#plimit').val('');
    $('#page').val('');
    
    var sortselect=$('#familysort').val();

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
    
    $("#index").submit();

}

function gotoFamilyView(mainmenu,Emp_ID){

    $('#Emp_ID').val(Emp_ID);
    $('#mainmenu').val(mainmenu);
    $('#index').attr('action', 'familyView?mainmenu='+mainmenu+'&time='+datetime);
    $("#index").submit();

}

function addFamilyMember(Emp_ID){

    $('#Emp_ID').val(Emp_ID);
    $('#editChk').val(0);
    var mainmenu = $('#mainmenu').val();
    $('#myfamilyView').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
    $("#myfamilyView").submit();

}

function editMember(id) {

    $('#editChk').val(1);
    $('#id').val(id);
    var mainmenu = $('#mainmenu').val();
    $('#myfamilyView').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
    $("#myfamilyView").submit();

}

function setSubRelation(){

    var relationType = $('#relationType').val();
    if(relationType == 5 || relationType == 6 || relationType == 8 || relationType == 9 ){
        
        $('#subRelationType').find('option').not(':first').remove();
        $.ajax({
            type:"GET",
            dataType: "JSON",
            url: 'getSubRelation',
            data: {
                relationType: relationType,
            },
            success: function(data) { // What to do if we succeed

                // $('#subRelationType').empty();
                $.each(data, function(key, value){
                    $('#subRelationType').append('<option value="'+key+'">' + value + '</option>');
                });
                
            },
            error: function(data) {
                alert('there was a problem checking the fields');
            }  
        });

        // var Name = "<?php echo trans('messages.lbl_sister'); ?>";

        // $('#subRelationType').append('<option value="1">' + Name + '</option>');

        $('#subRelationDiv').show();
    } else {
        $('#subRelationDiv').hide();
    }
}

//open Popup
function importpopupenable(mainmenu) {
     popupopenclose(1);
    $('#importpopup').load('importpopup?mainmenu='+mainmenu+'&time='+datetime);
    $("#importpopup").modal({
           backdrop: 'static',
            keyboard: false
        });
    $('#importpopup').modal('show');
}