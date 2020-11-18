var data = {};
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
        var ccd = 0;
        $('#sidedesignselector').click(function () {
            if( $('#workinghours').val() != "0:00"){
                ccd++;
            }
            if (ccd % 2 == 0) {
                movediv = "+=220px"
            } else {
                movediv = "-=220px"
            }
            ccd++;
            if( $('#workinghours').val() != "0:00"){
                ccd--;
            }  
        });
        $('.addeditprocess').on('click', function() {
          $(":submit").attr("disabled", true);
          resetErrors();
          var url = 'formValidation';
          $.each($('form input, form select, form radio,form textarea'), function(i, v) {
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
            // alert(JSON.stringify(resp));
                  if (resp === true) {
                        $(":submit").attr("disabled", false);
                        var conf =true;
                        if ($("#Bill_Image").val() !="") {
                            var filechk = filevalidationNR("Bill_Image","imagediv","1");
                            if(filechk == false) { conf = false; } 
                        }
                        var opts = document.getElementsByName('month[]');
                        var temp=false;
                        var chkValue = "";
                        for(i=0; i < opts.length; i++) {
                              if(opts[i].checked) { temp = true; chkValue = chkValue+opts[i].value+",";}
                        }
                        $('#checkboxval').hide();
                        if (!temp) {
                            $('#checkboxval').show();
                            conf = false; 
                        }
                        var amt =  $('#Amount').val();            
                            if (amt == 0) {
                                $('#amountboxval').show();
                                conf = false; 
                            }
                        if(conf == true) {
                            if($("#confirm").val() == '1') {
                                if(confirm(err_confreg)) {
                                    $(".add").removeAttr("disabled");
                                    $('form').submit();
                                } else{
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
                        }
                  } else {
                      $.each(resp, function(i, v) {
                        // alert(i + " => " + v); // view in console for error messages
                        var msg = '<label class="error pl5" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
                        if ($('input[name="' + i + '"]').hasClass('Date')) {
                            $('input[name="' + i + '"]').addClass('inputTxtError');
                            $('.Dateerror').append(msg)
                        } else {
                            $('input[name="' + i + '"], select[name="' + i + '"], radio[name="' + i + '"]').addClass('inputTxtError').after(msg);
                        }
                      });
                      $(":submit").attr("disabled", false);
                      // var keys = Object.keys(resp);
                      // $('input[name="'+keys[0]+'"]').focus();
                  }
                  return false;
              },
              error: function(data) {
                  alert(data.status);
                  alert('there was a problem checking the fields');
              }
          });
          return false;
        });
});
function resetErrors() {
    $('form input, form select, form radio, form textarea').removeClass('inputTxtError');
    $('label.error').remove();
}
function pageClick(pageval) {
    $('#page').val(pageval);
    $("#indexform").submit();
}
function pageLimitClick(pagelimitval) {
    $('#page').val('');
    $('#plimit').val(pagelimitval);
    $("#indexform").submit();
}
function histback() {
    window.history.back();
}
function getData(selMonth, selYear,time) {
    $('#page').val('');
    $('#plimit').val('');
    $('#selMonth').val(selMonth);
    $('#selYear').val(selYear);
    $('#parentmonth').val(selMonth);
    $('#parentyr').val(selYear);
    var mainmenu = $('#mainmenu').val();
    $('#indexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
    $("#indexform").submit();
}
function paiddatepopup(id,paiddate,empid) {
    var selMonth = document.getElementById("selMonth").value;
    var selYear = document.getElementById("selYear").value;
    var plimit = document.getElementById("plimit").value;
    var page = document.getElementById("page").value;
    $('#expid').val(id);
    var pass_date = $('#pass_date').val();
    $('#regpopup').load('../Expenses/regpopup?selMonth='+selMonth+'&pass_date='+pass_date+'&selYear='+selYear+'&empid='+empid+'&plimit='+plimit+
                        '&page='+page+'&expid='+id+'&paiddate='+paiddate);
    $("#regpopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#regpopup').modal('show');
}
function backtoemployees() {
    pageload();
    $('#mainmenu').val('employees_emp');
    $('#indexform').attr('action', '../Employees/view?mainmenu=employees_emp&time='+datetime);
    $("#indexform").submit();
    // window.history.back();
}
function gotoView(empid) {
    pageload();
    $('#empid').val(empid);
    document.getElementById('index_plimit').value = document.getElementById('plimit').value;
    document.getElementById('index_page').value = document.getElementById('page').value;
    document.getElementById('plimit').value = '';
    document.getElementById('page').value = '';
    $('#indexform').attr('action', 'view?mainmenu=expenses_exp&time='+datetime);
    $("#indexform").submit();
}
function gotoBack(viewflg,mainmenu) {
    pageload();
    if (viewflg!="view" && viewflg != "history") {
        document.getElementById('plimit').value = document.getElementById('index_plimit').value;
        document.getElementById('page').value = document.getElementById('index_page').value;
    }
    var totexpind = $('#totexpind').val();
    var histback = $('#histback').val();
    if(totexpind == 1 && histback != 1) {
        $('#mainmenu').val('expenses_total');
        $('#indexform').attr('action', '../totalexp/index?mainmenu=expenses_total&time='+datetime);
    } else {
        $('#indexform').attr('action', viewflg+'?mainmenu=expenses_exp&time='+datetime);
    }
    $("#indexform").submit();
}
function download(file,path) {
    var confirm_download = "Do You Want To Download?";
    if(confirm(confirm_download)) {
        window.location.href="../app/Http/Common/downloadfile.php?file="+file+"&path="+path+"/";
    }
}
function submitconfirm(flg) {
    var pass_date = $('#pass_date').val();
    var date = new Date();
    var current_date = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).substr(-2);
    if (pass_date == current_date && flg == 1) {
        alert("You cannot submit Current Period ( " + pass_date + " ).");
        return false;
    } 
    $('#subcnfm').val(flg);
    $('#indexform').attr('action', 'view?mainmenu=expenses_exp&time='+datetime);
    if (flg == 1) {
        if (confirm(err_submit)) {
            $("#indexform").submit();   
        } else {
            return false;
        }
    } else {
        if (confirm(err_confirm)) {
            $("#indexform").submit();   
        } else {
            return false;
        }
    }
}
function fndateprev(pass_date) {
    $('#pass_date').val(pass_date);
    $('#indexform').attr('action', 'view?mainmenu=expenses_exp&time='+datetime);
    $("#indexform").submit();
}
function fndatenext(pass_date) {
    $('#pass_date').val(pass_date);
    $('#indexform').attr('action', 'view?mainmenu=expenses_exp&time='+datetime);
    $("#indexform").submit();
}
function expensesDetails(screen,empid) {
    $('#empid').val(empid);
    document.getElementById('index_plimit').value = document.getElementById('plimit').value;
    document.getElementById('index_page').value = document.getElementById('page').value;
    document.getElementById('plimit').value = '';
    document.getElementById('page').value = '';
    $('#indexform').attr('action',  'history?mainmenu=expenses_exp&time='+datetime);
    $("#indexform").submit();
}
function sortingfun() {
    pageload();
    $('#plimit').val(50);
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
    $('#indexform').submit();
}
function addedit(screen) {
    pageload();
    $('#indexform').attr('action',  'addedit?mainmenu=expenses_exp&time='+datetime);
    $('#indexform').submit();
}
function editcopy(id,flg) {
    pageload();
    $('#id').val(id);
    $('#useflg').val(flg);
    $('#indexform').attr('action', 'Detedit?mainmenu=expenses_exp&time='+datetime);
    $("#indexform").submit();   
}
function move(id,flg,date1,Amount) {
    pageload();
    $('#travelid').val(id); 
    $('#useflg').val(flg);
    $('#expdate').val(date1);
    $('#eamount').val(Amount);
    $('#mainmenu').val('expenses_travel');
    $('#indexform').attr('action', '../Travelexp/addedit?mainmenu=expenses_travel&time='+datetime);
    $("#indexform").submit();   
}
function underprocess() {
    alert("Under Construction");
}
function getsubdet(value) {
    var mainid = $('#main_sub').val();
    var mainmenu = $('#mainmenu').val();
    $('#su_sub').find('option').not(':first').remove();
    $.ajax({
        type:"GET",
        dataType: "JSON",
        url: 'getsubsubject',
        data: {
            mainid: mainid,
            mainmenu : mainmenu
        },
        success: function(data) { // What to do if we succeed
            for (i = 0; i < data.length; i++)
            {    
                 $('#su_sub').append( '<option value="'+data[i]["id"]+'">'+data[i]["sub"]+'</option>' );
                 // $("#degree option:selected" ).text(value);
                 $('select[name="su_sub"]').val(value);
            }
            $("#su_sub option[value='1']").css('color', 'brown');
            $("#su_sub option[value='1']").css('font-weight', 'bold');
        },
       error: function(data) {
               // alert(data.status);
              alert('there was a problem checking the fields');
          }  
    })
}
function getothers() {
    var other =  $('#Others').val();
    var main_sub = document.getElementById('main_sub');
    var mainsubdata=main_sub.options[main_sub.selectedIndex].text;
    // $("#specificationOthers").attr("style", "visibility: visible")
    if ( mainsubdata.toLowerCase()=="others") {
        // $( "specificationOthers" ).removeClass(".defaulthide" );
        $("#Others").show();
        $("#Others").attr("style", "visibility: visible")
    }else{
        $("#Others").hide();
        // $("#degreeOthers").hide();
    }
}
function checkmonth() {
    var expDate = $('#Date').val();
    var main_sub = $('#main_sub').val();
    var su_sub = $('#su_sub').val();
    var empid = $('#empid').val();
    $.ajax({
        type:"GET",
        dataType: "JSON",
        url: 'checkmonth',
        data: {
            expDate: expDate,
            main_sub: main_sub,
            su_sub: su_sub,
            empid: empid
        },
        success: function(data) { // What to do if we succeed
            var splitMn = data;
            for (var j=1;j<=12;j++) {
                document.getElementById("month"+j).checked = false;
                document.getElementById("month"+j).disabled = false;
            }
            if (data != "") {
                for (var i=0;i<splitMn.length;i++) {
                    if (splitMn[i] != "") {
                        document.getElementById("month"+splitMn[i]).checked = false;
                        document.getElementById("month"+splitMn[i]).disabled = true;
                    }
                }
                if (document.getElementById('useflg').value=="1") {
                    if (document.getElementById('main_sub').value == document.getElementById('edmain_sub').value && 
                        document.getElementById('su_sub').value == document.getElementById('edsu_sub').value) {
                        var editMonthSplit = document.getElementById('edMonth').value.split(",");
                        for (var k=0;k<editMonthSplit.length;k++) {
                            if (editMonthSplit[k]!="") {
                                document.getElementById("month"+editMonthSplit[k]).checked = true;
                                document.getElementById("month"+editMonthSplit[k]).disabled = false;
                            }
                        }
                    }
                }
            }
        },
       error: function(data) {
              alert('there was a problem checking the fields');
          }  
    })
}
function nillCheck(id) {
    // alert(id);
    // var group = document.expensesfrm.month;
    if (id == 99) {
        for (var i=1; i<=12; i++) {
            document.getElementById("month"+i).checked = false;
        }
    } else {
        document.getElementById("month13").checked = false;
    }
}
function backtotravel() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('');
    $('#mainmenu').val('expenses_travel');
    $('#indexform').attr('action', '../Travelexp/view?mainmenu=expenses_travel&time='+datetime);
    $("#indexform").submit();
}
function gototravel() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('1');
    $('#mainmenu').val('expenses_travel');
    $('#indexform').attr('action', '../Travelexp/view?mainmenu=expenses_travel&time='+datetime);
    $("#indexform").submit();
}
function gotohistory() {
    // document.getElementById('view_plimit').value = document.getElementById('plimit').value;
    // document.getElementById('view_page').value = document.getElementById('page').value;
    pageload();
    document.getElementById('plimit').value = '';
    document.getElementById('page').value = '';
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('2');
    var mainmenu = $('#mainmenu').val();
    $('#indexform').attr('action', 'history?mainmenu='+mainmenu+'&time='+datetime);
    $("#indexform").submit();
}
function histbackexp() {
    pageload();
    document.getElementById('plimit').value = document.getElementById('view_plimit').value;
    document.getElementById('page').value = document.getElementById('view_page').value;
    var histbackdup = $('#histbackdup').val();
    var histback = $('#histback').val();
    if(histbackdup == 1 && histback == 2) {
        $('#histback').val('1');
    }
    var mainmenu = $('#mainmenu').val();
    $('#indexform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#indexform").submit();
}
function cancel(viewflg,mainmenu) {
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();
            $('#indexform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
            $("#indexform").submit();
        }
    } else {
        pageload();
        $('#indexform').attr('action', viewflg+'?mainmenu='+mainmenu+'&time='+datetime);
        $("#indexform").submit();
    }
}
function removezero() {
  var doc_val_check = $('#Amount').attr("value");
  if (doc_val_check = "0") {
        $('#Amount').val("");
    }
}
function placezero() {     
    if ($('#Amount').val() == "") {
            $('#Amount').val("0");
    }
}
function fnMoneyFormatwithINR(name) {
    var value = document.getElementById(name).value;
    value = value.replace(/[ ]*,[ ]*|[ ]+/g, '');
    fnMoneyFormatWithoutleadingzero(name, value, 'en')
}
function confirmamount() {
    alert(expenses_confirm_amount_msg);
}