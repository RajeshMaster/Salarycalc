var data = {};
$(document).ready(function() {
    setDatePicker("dob");
    setDatePicker("from_date");
    setDatePicker("to_date");

    var cc = 0;
    $('#visasort').click(function () {
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
        //$("#visasort").removeAttr("style");
        if( $('#searchmethod').val() == 1 || $('#searchmethod').val() == 2){
            ccd++;
        }
        if (ccd % 2 == 0) {
            movediv = "+=220px"
        } else {
            movediv = "-=220px"
        }
        $('#visasort').animate({
            'marginRight' : movediv //moves down
        });
        ccd++;
        // if( $('#singlesearch').val() || $('#searchmethod').val() == 2 ){
        if( $('#searchmethod').val() == 1 || $('#searchmethod').val() == 2){
            ccd--;
        }  
    }); 

    $('.addeditprocess').click(function () {
        $("[name='familyVisaAddEdit']").validate({
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
                Emp_Relation: {required: true},
                subRelationType: {required: true},
                Nationality: {required: true},
                Address: {required: true},

                CardNo: {required: true},
                NoYears: {required: true},
                StDate: {required: true, date: true,correctformatdate: true,greaterThan: "#DOB"},
                Address: {required: true},

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

function goBack() {
    window.history.back()
}

function gotoEmpVisalist(Emp_ID) {

    $('#Emp_ID').val(Emp_ID);
    $('#visaid').val(Emp_ID);
    $('#familyView').attr('action', '../Visa/viewlist?mainmenu=visa&time='+datetime);
    $("#familyView").submit();
}

function gotoFamilyView(Emp_ID) {

    $('#Emp_ID').val(Emp_ID);
    $('#familyVisaView').attr('action', 'familyView?mainmenu=visa&time='+datetime);
    $("#familyVisaView").submit();
}

function gotosingleView(id,Emp_ID){

    $('#id').val(id);
    $('#Emp_ID').val(Emp_ID);
    $('#familyView').attr('action', 'singleView?mainmenu=familyvisa&time='+datetime);
    $("#familyView").submit();

}

// function addVisa() {

//     $('#visaform').attr('action', 'edit?mainmenu=familyvisa&time='+datetime);
//     $("#visaform").submit();

// }

function edit() {

    $('#editChk').val(1);
    $('#familyVisaView').attr('action', 'addEdit?mainmenu=familyvisa&time='+datetime);
    $("#familyVisaView").submit();

}

function register(Emp_ID){


    // if (backcheck == 1) {
    //     $('#familyView #plimit').val(50);
    //     $('#familyView #page').val('');
    //     $('#familyView #sortOptn').val('');
    //     $('#familyView #sortOrder').val('');
    //     $('#familyView #singlesearch').val('');
    //     $('#familyView #msearchempid').val('');
    //     $('#familyView #msearchempname').val('');
    //     $('#familyView #msearchstdate').val('');
    //     $('#familyView #msearcheddate').val('');
    //     $('#familyView #searchmethod').val('');
    //     $("#familyView #filterval").val(1);
    // }
    $('#editChk').val(0);
    $('#Emp_ID').val(Emp_ID);
    $('#visaid').val(Emp_ID);
    $('#familyView').attr('action', 'addEdit?mainmenu=familyvisa&time='+datetime);
    $("#familyView").submit();

    // $('#familyView').attr('action', 'addedit?mainmenu=familyvisa&time='+datetime);
    // $("#familyView").submit();

}

function cancel(viewflg) {

    var mainmenu = $("#mainmenu").val();
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();
            if (viewflg == "singleView") {
                window.history.back();
            }
            $('#familyVisaAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
            $("#familyVisaAddEdit").submit();
        }
    } else {
        if (viewflg == "singleView") {
            window.history.back();
        }
        $('#familyVisaAddEdit').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#familyVisaAddEdit").submit();
    }
}

function setEnddate () {
    var timestamp = Date.parse($("#StDate").val());
    var myLength = $("#StDate").val().length;
    if (isNaN(timestamp) == true || myLength !=10) { 
        // document.getElementById('StDate').value = "";
        document.getElementById('EdDated').value = "";
        document.getElementById('EdDate').value = "";
    } 
    if (document.getElementById('StDate').value != "" && document.getElementById('NoYears').value != "" && isNaN(timestamp) == false && myLength ==10) {
        var ContractTerm = document.getElementById('NoYears').value;
        var dateMin = document.getElementById('StDate').value;
        dateMin = new Date(dateMin);
        var rMax = new Date(dateMin.getFullYear() + parseInt(ContractTerm), dateMin.getMonth(),dateMin.getDate());
        var setEddate = (rMax.getFullYear()+1)+"-"+("0"+(rMax.getMonth()+1)).slice(-2)+"-"+("0"+rMax.getDate()).slice(-2);
        document.getElementById('EdDated').value = setEddate;
        document.getElementById('EdDate').value = setEddate;
    }
}

function setNation() {

    if ($("#Nationality").val() == 3) {
        $("#nationDiv").show();
    } else if($("#Nationality").val() != 3){
        $("#nationDiv").hide();
        $("#NationalityOthers").val("");
    }

}

function familyVisa(Emp_ID) {

    $('#Emp_ID').val(Emp_ID);
    $('#visaform').attr('action', '../FamilyVisa/familyView?mainmenu=familyvisa&time='+datetime);
    $("#visaform").submit();
    
}

function setSubRelation(){

    var Emp_ID = $('#visaid').val();
    var relationType = $('#Emp_Relation').val();

    $('#FirstName').val("");
    $('#LastName').val("");
    $('#Kana_FirstName').val("");
    $('#Kana_LastName').val("");
    $('#DOB').val("");

    if(relationType == 5 || relationType == 6 || relationType == 8 || relationType == 9 ){
        
        $('#subRelationType').find('option').not(':first').remove();
        $.ajax({
            type:"GET",
            dataType: "JSON",
            url: 'getSubRelation',
            data: {
                relationType: relationType,
                Emp_ID: Emp_ID
            },
            success: function(data) { // What to do if we succeed
                
                // alert(JSON.stringify(data));
                // $('#subRelationType').empty();
                // $.each(data, function(key, value){
                //     $('#subRelationType').append('<option value="'+key+'">' + value + '</option>');
                // });

                for (i = 0; i < data.length; i++){    
                    $('#subRelationType').append( '<option value="'+data[i]["subRelationType"]+'">'+data[i]["stringVal"]+'</option>' );
                }
            },
            error: function(data) {
                alert('there was a problem checking the fields');
            }  
        });

        $('#subRelationDiv').show();
    } else {
        $('#subRelationDiv').hide();
        setBasicDetails();
    }
}

function setBasicDetails(){

    var Emp_ID = $('#visaid').val();
    var relationType = $('#Emp_Relation').val();

    if(relationType == 5 || relationType == 6 || relationType == 8 || relationType == 9 ){
        var subRelationType = $('#subRelationType').val();
    } else {
        var subRelationType = 0;
    }

        $.ajax({
            type:"GET",
            dataType: "JSON",
            url: 'getBasicDetails',
            data: {
                relationType: relationType,
                subRelationType: subRelationType,
                Emp_ID: Emp_ID
            },
            success: function(data) { // What to do if we succeed

                $('#FirstName').val(data[0]['FirstName']);
                $('#LastName').val(data[0]['LastName']);
                $('#Kana_FirstName').val(data[0]['Kana_FirstName']);
                $('#Kana_LastName').val(data[0]['Kana_LastName']);
                $('#DOB').val(data[0]['DOB']);
                
            },
            error: function(data) {
                alert('there was a problem checking the fields');
            }  
        });

}