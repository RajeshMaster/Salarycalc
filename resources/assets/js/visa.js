var data = {};
$(document).ready(function() {
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
    $('.addeditprocess').on('click', function() {
      $(":submit").attr("disabled", true);
      resetErrors();
      var url = 'formValidation';
      $.each($('form input, form select, form radio'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
              if (v.type == 'radio') {
                var val = $('input[name='+v.name+']:checked').val();
                if (val == undefined) {
                    data[v.name] = val;
                }
              }
          }
      }); //end each

      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          data: data,
          success: function(resp) {
              if (resp === true) {
                var conf =true;
                    
                    if(conf == true) {

                        if($("#confirm").val() == '1') {
                           
                            if(confirm(err_confreg)) {
                                $(".add").removeAttr("disabled");
                                $('form').submit();
                            } else {
                                $(":submit").attr("disabled", false);
                            }
                        } else {
                            if(confirm(err_confup)) {
                                $(".edit").removeAttr("disabled");
                                $('form').submit();
                            } else {
                                $(":submit").attr("disabled", false);
                            }
                        }
                    } else {
                        $(":submit").attr("disabled", false);
                    }
              } else {
                  $.each(resp, function(i, v) {
                    // alert(i + " => " + v); // view in console for error messages
                    var msg = '<label class="error pl5" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
                    if ($('input[name="' + i + '"]').hasClass('dateField')) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.dateFielderror').append(msg)
                    } else if ($('input[name="' + i + '"]').hasClass('file') && $('input[name="' + i + '"]').hasClass('webcam') ) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.fileraderror').append(msg)
                    } else {
                        $('input[name="' + i + '"], select[name="' + i + '"], radio[name="' + i + '"]').addClass('inputTxtError').after(msg);
                    }
                  });
                  $(":submit").attr("disabled", false);
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function(data) {
              // alert(data.status);
              alert('there was a problem checking the fields');
          }
      });
      return false;
    });
    /*var urlpass=$('#urlpass').val();
    urlhide(urlpass);*/
});
function resetErrors() {
    $('form input, form select, form radio').removeClass('inputTxtError');
    $('label.error').remove();
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
    $("#visaform").submit();
 }
function singlesearchclick() {
    pageload();
    $('#plimit').val(50);
    $('#page').val('');
    if ($('#singlesearch').val()) {
         $("#searchmethod").val(1);
    } else {
        $("#searchmethod").val('');
    }
	$('#visasort').val('');
	$('#msearchempid').val('');
	$('#msearchempname').val('');
	$('#msearchstdate').val('');
	$('#msearcheddate').val('');
    $('#visaform').submit();
}
function multisearch() {
    $('#plimit').val(50);
    $('#page').val('');
    pageload();
    $('#visasort').val('');
    $('#singlesearch').val('');
    $("#searchmethod").val(2);
    $('#visaform').submit();
}
function filter(filterval) {
    $('#plimit').val(50);
    $('#page').val('');
	$('#visasort').val('');
	// $('#sortOptn').val('');
	// $('#sortOrder').val('');
	$('#singlesearch').val('');
	$('#msearchempid').val('');
	$('#msearchempname').val('');
	$('#msearchstdate').val('');
	$('#msearcheddate').val('');
    $('#searchmethod').val('');
	$("#filterval").val(filterval);
    $("#visaform").submit();
	return true;
}
function download(file,path) {
    var confirm_download = "Do You Want To Download?";
    if(confirm(confirm_download)) {
        window.location.href="../app/Http/Common/downloadfile.php?file="+file+"&path="+path+"/";
    }
}
function goBack() {
    window.history.back()
}
function edit() {
    pageload();
    var mainmenu=document.getElementById('mainmenu').value;
    $('#visaform').attr('action', 'edit?mainmenu='+mainmenu+'&time='+datetime);
    $("#visaform").submit();
}
function gotoView(visaid,id,mainmenu,viewflg) {
    pageload();
    $('#visaid').val(visaid);
    $('#id').val(id);
    if (viewflg == 1) {
        $('#visaform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    } else {
        $('#visaform').attr('action', 'viewlist?mainmenu='+mainmenu+'&time='+datetime);
    }
    $("#visaform").submit();
}
/*function gotoBack(viewflg) {
    pageload();
    var mainmenu=document.getElementById('mainmenu').value;
    $('#visaform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
    $("#visaform").submit();
}*/
function gotoBack(viewflg, backcheck) {
    pageload();
    if (backcheck == 1) {
        window.history.back();
        // $('#backtoindex #mainmenu').val($('#backtoindex #defaultmainmenu').val());
        // var mainmenu=$('#backtoindex #mainmenu').val();
        // $('#backtoindex').attr('action', '../Employees/index?mainmenu='+mainmenu+'&time='+datetime);
        // $("#backtoindex").submit();
    }else if (backcheck == 2) {
        $('#backtoview #mainmenu').val($('#backtoview #defaultmainmenu').val());
        var mainmenu=$('#backtoview #mainmenu').val();
        $('#backtoview').attr('action', '../Employees/view?mainmenu='+mainmenu+'&time='+datetime);
        $("#backtoview").submit();
    } else {
        var mainmenu=$('#visaform #mainmenu').val();
        $('#visaform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function gotosingleView(id,empid, backcheck){
    pageload();
    if (backcheck == 1) {
        $('#visaform #plimit').val(50);
        $('#visaform #page').val('');
        $('#visaform #sortOptn').val('');
        $('#visaform #sortOrder').val('');
        $('#visaform #singlesearch').val('');
        $('#visaform #msearchempid').val('');
        $('#visaform #msearchempname').val('');
        $('#visaform #msearchstdate').val('');
        $('#visaform #msearcheddate').val('');
        $('#visaform #searchmethod').val('');
        $("#visaform #filterval").val(1);
    }
    var mainmenu=$('#visaform #mainmenu').val();
    $('#visaform #id').val(id);
    $('#visaform #visaid').val(empid);
    $('#visaform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#visaform").submit();
}
function register(empname,backcheck){
    pageload();
    if (backcheck == 1) {
        $('#visaform #plimit').val(50);
        $('#visaform #page').val('');
        $('#visaform #sortOptn').val('');
        $('#visaform #sortOrder').val('');
        $('#visaform #singlesearch').val('');
        $('#visaform #msearchempid').val('');
        $('#visaform #msearchempname').val('');
        $('#visaform #msearchstdate').val('');
        $('#visaform #msearcheddate').val('');
        $('#visaform #searchmethod').val('');
        $("#visaform #filterval").val(1);
    }
    $('#visaform #empname').val(empname);
    var mainmenu=$('#visaform #mainmenu').val();
    $('#visaform').attr('action', 'addedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#visaform").submit();
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
function popupenable(no){
    $('#radiono').val(no);
    $('#webcampopup').load('../Visa/webcampopup');
    $("#webcampopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#webcampopup').modal('show');
}
function pageClick(pageval) {
    $('#page').val(pageval);
    $("#visaform").submit();
}
function pageLimitClick(pagelimitval) {
    $('#page').val('');
    $('#plimit').val(pagelimitval);
    $("#visaform").submit();
}
function rotation(action,mainmenu,file,path,fcnt) {
    $('#file').val(file);
    $('#path').val(path);
    $('#filecnt').val(fcnt);
    $('#updateflg').val(1);
    var confirm_download = "Do You Want To Rotate the Image?";
    if (confirm(confirm_download)) {
        $('#visaform').attr('action', action+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function rotationback(action,mainmenu,file,path,fcnt) {
    $('#file').val(file);
    $('#path').val(path); 
    $('#filecnt').val(fcnt);
    $('#updateflg').val(2);
    var confirm_download = "Do You Want To Rotate the Image?";
    if (confirm(confirm_download)) {
        $('#visaform').attr('action', action+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function rotationthree(action,mainmenu,file,path,fcnt) {
    $('#file').val(file);
    $('#path').val(path);
    $('#filecnt').val(fcnt);
    $('#updateflg').val(2);
    var confirm_download = "Do You Want To Rotate the Image?";
    if (confirm(confirm_download)) {
        $('#visaform').attr('action', action+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function rotationfour(action,mainmenu,file,path,fcnt) {
    $('#file').val(file);
    $('#filecnt').val(fcnt);
    $('#path').val(path); 
    $('#updateflg').val(2);
    var confirm_download = "Do You Want To Rotate the Image?";
    if (confirm(confirm_download)) {
        $('#visaform').attr('action', action+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function rotationfive(action,mainmenu,file,path,fcnt) {
    $('#file').val(file);
    $('#path').val(path);
    $('#filecnt').val(fcnt);
    $('#updateflg').val(2);
    var confirm_download = "Do You Want To Rotate the Image?";
    if (confirm(confirm_download)) {
        $('#visaform').attr('action', action+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function clearsearch() {
    $('#plimit').val(50);
    $('#page').val('');
    $('#visasort').val('');
    // $('#sortOptn').val('');
    // $('#sortOrder').val('');
    $('#singlesearch').val('');
    $('#msearchempid').val('');
    $('#msearchempname').val('');
    $('#msearchstdate').val('');
    $('#msearcheddate').val('');
    $('#searchmethod').val('');
    $("#filterval").val(1);
    $("#visaform").submit();
}
function applydate(page,mainmenu,diff) {
    visaid = document.getElementById("visaid").value;
    id = document.getElementById("id").value;
    $('#applydatepopup').load('../Visa/'+page+'?visaid='+visaid+'&id='+id+'&diff='+diff+'&mainmenu='+mainmenu);
    $("#applydatepopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#applydatepopup').modal('show');
}
function histback() {
    window.history.back();
}
function onlyNum() {
    var $this = $('#CardNo'); 
    $this.val($this.val().replace(/[^a-zA-Z0-9 ]/g, ''));
}
function cancel(viewflg) {
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();
            if (viewflg == "view") {
                window.history.back();
            }
            var mainmenu=document.getElementById('mainmenu').value;
            $('#visaform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
            $("#visaform").submit();
        }
    } else {
        pageload();
        if (viewflg == "view") {
            window.history.back();
        }
        var mainmenu=document.getElementById('mainmenu').value;
        $('#visaform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#visaform").submit();
    }
}
function visadetailsdownload(action) {
    if (confirm("Do you want to download the File ?")) {
        $('#exceldownloadform').attr('action', 'downloadexcel?mainmenu='+"mainmenu"+'&time='+datetime);
        $("#exceldownloadform").submit();   
    }
}
function filevalidationNotRequired(file_id,div_id,flg) {
    alert(file_id);
    alert(div_id);
    alert(flg);
  var file = $("#"+file_id).val();
  if (file!="") {
    if(flg == "1") {  // IMG
      var exts = ['gif','jpeg','jpg','png'];
    } else {  // DOCS
      var exts = ['doc','docx','pdf','xls','xlsx'];
    }
    var get_ext = file.split('.');
    get_ext = get_ext.reverse();
    if ( $("#"+file_id).val() != "") {
        var size = parseFloat($("#"+file_id)[0].files[0].size / 1024);
    } else {
        var size = '0';
    }
    if ( !($.inArray ( get_ext[0].toLowerCase(), exts ) > -1) ){
      if(flg == "1") { 
        $('#'+div_id).show();
        document.getElementById(div_id).innerHTML = '<strong>'+err_imgext+'</strong>';
      } else {
        $('#'+div_id).show();
        document.getElementById(div_id).innerHTML = '<strong>'+err_Docext+'</strong>';
      }
        return false;
    } else if(size > "2097") {
        $('#'+div_id).show();
        document.getElementById(div_id).innerHTML = '<strong>'+err_filesize+'</strong>';
        return false;
    } else {
        $('#'+div_id).hide();
    }
  }
}
function fnGetmissingData(empid) {
    $('#empid').val(empid);
    $('#visaform').attr('action', '../Requireddata/getmissingdetail?time='+datetime);
    $("#visaform").submit();
}
function fngetsubsubject(sel) {
    if (sel == 99999) {
        $('#newaddress').css({"display": "block"});
    } else {
        $('#newaddress').css({"display": "none"});
    }
}
function fnunderconstruction() {
    alert("Under Construction");
}
function fnmaterialstatus(sel) {
    if (sel == 2) {
        $('#relationdetails').css({"display": "block"});
    } else {
        $('#relationdetails').css({"display": "none"});
    }
}
function fncanceluserdata() {
    window.history.back();
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

function confirmdownload() {
    if (confirm("Do You Wanto To Download ?")) {
        return true;
    } else {
        return false;
    }
}

function familyVisa(Emp_ID) {

    $('#Emp_ID').val(Emp_ID);
    $('#visaform').attr('action', '../FamilyVisa/familyView?mainmenu=familyvisa&time='+datetime);
    $("#visaform").submit();
    
}
