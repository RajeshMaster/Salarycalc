$(document).ready(function() {
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
});


function pageClick(pageval) {

	$('#page').val(pageval);
    $("#newVisaIndex").submit();


}

function pageLimitClick(pagelimitval) {

	$('#page').val('');
	$('#plimit').val(pagelimitval);
    $("#newVisaIndex").submit();

}

function sortingfun() {
    pageload();
    $('#plimit').val(50);
    $('#page').val('');
    var sortselect=$('#visasort').val();
    $('#sortOptn').val(sortselect);
    var alreadySelectedOptn=$('#sortOptn').val();
    var alreadySelectedOptnOrder=$('#sortOrder').val();

    if (sortselect == alreadySelectedOptn) {
        if (alreadySelectedOptnOrder == "asc") {
            $('#sortOrder').val('desc');
        } else {
            $('#sortOrder').val('asc');
        }
    }
    $("#newVisaIndex").submit();
 }

function confirmdownload() {
    if (confirm("Do You Wanto To Download ?")) {
        return true;
    } else {
        return false;
    }
}

function existChk(val) {

    pageload();
    $('#plimit').val('');
    $('#page').val('');
    $("#existChk").val(val);
    $("#visaIndex").submit();
}

function goBack() {
  window.history.back();
}

function gotoView(Emp_ID) {

    $("#Emp_ID").val(Emp_ID);
    $("#newVisaIndex").attr('action', 'view?mainmenu=newvisa&time='+datetime);
    $("#newVisaIndex").submit();
}


