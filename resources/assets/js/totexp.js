
$(document).ready(function() {
    var cc = 0;
    $('#expsort').click(function () {
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

function getData(selMonth, selYear,time) {
    $('#page').val('');
    $('#plimit').val('');
    $('#selMonth').val(selMonth);
    $('#selYear').val(selYear);
    $('#parentmonth').val(selMonth);
    $('#parentyr').val(selYear);
    var mainmenu = $('#mainmenu').val();
    $('#totalexpform').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
    $("#totalexpform").submit();
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

function gotoexpense(id) {
    pageload();
    $('#empid').val(id);
    $('#page').val('');
    $('#plimit').val('');
    $('#mainmenu').val('expenses_exp');
    $('#totalexpform').attr('action', '../Expenses/view?mainmenu=expenses_exp&time='+datetime);
    $("#totalexpform").submit();
}


function gototravel(id) {
    pageload();
    $('#traexpid').val(id);
    $('#page').val('');
    $('#plimit').val('');
    $('#mainmenu').val('expenses_travel');
    $('#totalexpform').attr('action', '../Travelexp/view?mainmenu=expenses_travel&time='+datetime);
    $("#totalexpform").submit();
}

function sortingfun() {
    pageload();
    $('#plimit').val('');
    $('#page').val('');
    var sortselect=$('#expsort').val();
    var alreadySelectedOptn=$('#sortOptn').val(); 
    var alreadySelectedOptnOrder=$('#sortOrder').val();
    if (sortselect == alreadySelectedOptn) {
        if (alreadySelectedOptnOrder == "asc") {
            $('#sortOrder').val("desc"); 
        } else {
            $('#sortOrder').val("asc"); 
        }
    }
    $('#totalexpform').submit();
}
function pageClick(pageval) {
    $('#page').val(pageval);
    /*$('#totcount').val('0');*/
    $("#totalexpform").submit();
}
function pageLimitClick(pagelimitval) {
    $('#page').val('');
    /*$('#totcount').val('0');*/
    $('#plimit').val(pagelimitval);
    $("#totalexpform").submit();
}
function histback() {
    window.history.back();
}

function paiddatepopup(id,table,paiddate,empid) {
    var pass_date = $('#pass_date').val();
    var mainmenu =  $('#mainmenu').val();
    var selMonth = document.getElementById("selMonth").value;
    var selYear = document.getElementById("selYear").value;
    $('#regpopup').load('../Totalexp/regpopup?selMonth='+selMonth+'&selYear='+selYear+'&empid='+empid+'&pass_date='+pass_date+'&table='+table+'&id='+id+'&paiddate='+paiddate+'&mainmenu='+mainmenu);
    $("#regpopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#regpopup').modal('show');
}
function paiddatepopupcf(no,empid) {
    var pass_date = $('#pass_date').val();
    if ($('#loccf'+no).val() != undefined ) {
        var locid = $('#loccf'+no).val();
    } else {
        var locid = "";
    }
    if ($('#expcf'+no).val() != undefined ) {
        var exid = $('#expcf'+no).val();
    } else {
        var exid = "";
    }
    var table = "tbl_localtravel";
    var paiddate = "";
    var id = "000000";
    var selMonth = document.getElementById("selMonth").value;
    var selYear = document.getElementById("selYear").value;
    $('#regpopup').load('../Totalexp/regcfpopup?selMonth='+selMonth+'&selYear='+selYear+'&empid='+empid+'&pass_date='+pass_date+'&table='+table+'&id='+id+'&locid='+locid+'&exid='+exid+'&paiddate='+paiddate);
    $("#regpopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#regpopup').modal('show');
}
function confirmamount(flag) {
    if(flag == 1) {
        alert(travel_confirm_amount_msg);
    } else {
        alert(expenses_confirm_amount_msg);
    }
}
function revert(no) {
    if ($('#revertloc'+no).val() != undefined ) {
        var revertloc = $('#revertloc'+no).val();
        $('#revertcondloc').val(revertloc);
    } else {
        var revertloc = "";
    }
    if ($('#revertexp'+no).val() != undefined ) {
        var revertexp = $('#revertexp'+no).val();
        $('#revertcondexp').val(revertexp);
    } else {
        var revertexp = "";
    }
    var selMonth = document.getElementById("selMonth").value;
    var selYear = document.getElementById("selYear").value;
    var datepass = document.getElementById("pass_date").value;
    var empiddb = document.getElementById("empiddb"+no).value;
    $('#regpopup').load('../Totalexp/revert?selMonth='+selMonth+'&selYear='+selYear+'&revertloc='+revertloc+'&revertexp='+revertexp+'&date='+datepass+'&empiddb='+empiddb);
    $("#regpopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#regpopup').modal('show');
}

