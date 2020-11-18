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

    $('#banksort').click(function () {
        cc++;
        if (cc == 2) {
            $(this).change();
            cc = 0;
        }         
    }).change (function () {
       sortingfun();
        cc = -1;
    });

    $('#addresssort').click(function () {
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

	var mainmenu = $('#mainmenu').val();
	$('#page').val(pageval);

	if(mainmenu == 'sal_bank'){
		$("#salbankindex").submit();
	} else if(mainmenu == 'family'){
		$("#familyIndex").submit();
	} else {
		$("#addressIndex").submit();
	}


}

function pageLimitClick(pagelimitval) {

	var mainmenu = $('#mainmenu').val();
	$('#page').val('');
	$('#plimit').val(pagelimitval);

	if(mainmenu == 'sal_bank'){
		$("#salbankindex").submit();
	} else if(mainmenu == 'family'){
		$("#familyIndex").submit();
	} else {
		$("#addressIndex").submit();
	}

}

function sortingfun() {
    pageload();
    var mainmenu = $('#mainmenu').val();
    $('#plimit').val('');
    $('#page').val('');

    if(mainmenu == 'sal_bank'){
        var sortselect=$('#banksort').val();
    } else if(mainmenu == 'family'){
        var sortselect=$('#familysort').val();
    } else {
        var sortselect=$('#addresssort').val();
    }

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

    if(mainmenu == 'sal_bank'){
        $("#salbankindex").submit();
    } else if(mainmenu == 'family'){
        $("#familyIndex").submit();
    } else {
        $("#addressIndex").submit();
    }
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
		$('#familyIndex').attr('action', 'familyIndex?mainmenu='+mainmenu+'&time='+datetime);
		$("#familyIndex").submit();
	}
}

function clearsearch() {
    $('#plimit').val(50);
    $('#page').val('');
    $('#singlesearch').val('');
    $('#searchmethod').val('');
    $("#familyIndex").submit();
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