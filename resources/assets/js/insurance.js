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

// function resetErrors() {

//     $('form input, form select').removeClass('inputTxtError');

//     $('label.error').remove();

// } 

function pageClick(pageval) {

	$('#page').val(pageval);

	$("#insuranceIndex").submit();

}

function pageLimitClick(pagelimitval) {

	$('#page').val('');

	$('#plimit').val(pagelimitval);

	$("#insuranceIndex").submit();

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
    $('#insuranceIndex').submit();
}

function getData(selYear,time) {
    $('#selYear').val(selYear);
    var mainmenu = $('#mainmenu').val();
    $('#insuranceIndex').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
    $("#insuranceIndex").submit();
}