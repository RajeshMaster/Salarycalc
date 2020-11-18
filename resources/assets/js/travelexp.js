var data = {};
$(document).ready(function() {
    var cc = 0;
    $('#travelsort').click(function () {
        cc++;
        if (cc == 2) {
            $(this).change();
            cc = 0;
        }         
    }).change (function () {
       sortingfun();
        cc = -1;
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
                // alert(resp);
            // alert(JSON.stringify(resp));
              if (resp === true) {
                    var conf =true;
                    var startdate = $('#date').val();
                    var enddate = $('#enddate').val();
                    var tripval = $('input:radio[name=trip]:checked').val();
                    if(tripval == 3) {
                        if( (new Date(startdate).getTime() > new Date(enddate).getTime())) {
                            $('#datgreater').show();
                            conf = false;
                        } else {
                            $('#datgreater').hide();
                            conf = true;
                        }
                    }
                    var amt =  $('#amount').val();            
                            if (amt == 0) {
                                $('#amountboxval').show();
                                conf = false; 
                            }
                    if(conf == true) {
                        if($("#cnfrmsg").val() == '1') {
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
                    if ($('input[name="' + i + '"]').hasClass('dateField') || $('input[name="' + i + '"]').hasClass('multidatcls')) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.dateFielderror').append(msg)
                    } else if ($('input[name="' + i + '"]').hasClass('tripcls') ) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.triperror').append(msg)
                    } else if ($('input[name="' + i + '"]').hasClass('travelcls') ) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.travelerror').append(msg)
                    } else if ($('input[name="' + i + '"]').hasClass('amountclass') ) {
                        $('input[name="' + i + '"]').addClass('inputTxtError');
                        $('.amounterror').append(msg)
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
}); 
function resetErrors() {
    $('form input, form select, form radio').removeClass('inputTxtError');
    $('label.error').remove();
}
function pageClick(pageval) {
    $('#page').val(pageval);
    $("#travelexpform").submit();
}
function pageLimitClick(pagelimitval) {
    $('#page').val('');
    $('#plimit').val(pagelimitval);
    $("#travelexpform").submit();
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
    $('#travelexpform').attr('action', 'index?mainmenu='+mainmenu+'&time='+time);
    $("#travelexpform").submit();
}
function paiddatepopup(id,paiddate,empid) {
    var selMonth = document.getElementById("selMonth").value;
    var selYear = document.getElementById("selYear").value;
    var pass_date = $('#pass_date').val();
    $('#travelid').val(id);
    $('#regpopup').load('../Travelexp/regpopup?selMonth='+selMonth+'&selYear='+selYear+'&empid='+empid+'&pass_date='+pass_date+'&travelid='+id+'&paiddate='+paiddate);
    $("#regpopup").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#regpopup').modal('show');
}
function traexpview(traexpid) {
    pageload();
    $('#traexpid').val(traexpid);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function traexphist(traexpid) {
    pageload();
    $('#traexpid').val(traexpid);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'history?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function back() {
    pageload();
    var mainmenu = $('#mainmenu').val();
    var totexpind = $('#totexpind').val();
    var histback = $('#histback').val();
    if(totexpind == 1 && histback != 1) {
        $('#mainmenu').val('expenses_total');
        $('#travelexpform').attr('action', '../totalexp/index?mainmenu=expenses_total&time='+datetime);
    } else {
        $('#travelexpform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    }
    $("#travelexpform").submit();
}
function backdetails() {
    pageload();
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function backtoindex() {
    pageload();
    document.getElementById("plimit").value = $('#indexplimit').val();
    document.getElementById("page").value = $('#indexpage').val();
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function usenotuse(id,flg) {
    pageload();
    $('#travelid').val(id);
    $('#useflg').val(flg);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();   
}
function editcopy(id,flg) {
    pageload();
    $('#travelid').val(id);
    $('#useflg').val(flg);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'Detedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();   
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
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    if (flg == 1) {
        if (confirm(err_submit)) {
            pageload();
            $("#travelexpform").submit();   
        } else {
            return false;
        }
    } else {
        if (confirm(err_confirm)) {
            pageload();
            $("#travelexpform").submit();   
        } else {
            return false;
        }
    }
}
function confirmdownload() {
    if (confirm("Do You Wanto To Download ?")) {
        return true;
    } else {
        return false;
    }
}
function confirmusage() {
    if (confirm("Do You Wanto To Change the Flag ?")) {
        return true;
    } else {
        return false;
    }
}
function fndateprev(pass_date) {
    $('#pass_date').val(pass_date);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function fndatenext(pass_date) {
    $('#pass_date').val(pass_date);
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function sortingfun() {
    pageload();
    $('#plimit').val(50);
    $('#page').val('');
    var sortselect=$('#travelsort').val();
    var alreadySelectedOptn=$('#sortOptn').val();
    var alreadySelectedOptnOrder=$('#sortOrder').val();
    if (sortselect == alreadySelectedOptn) {
        if (alreadySelectedOptnOrder == "asc") {
            $('#sortOrder').val('desc');
        } else {
            $('#sortOrder').val('asc');
        }
    }
    $("#travelexpform").submit();
}
function addedit() {
    pageload();
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'addedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function swap() {
    var travel_from = $('#travel_from').val();
    var travel_to = $('#travel_to').val();
    document.getElementById("travel_to").value = travel_from;
    document.getElementById("travel_from").value = travel_to;
}
function gotohistory() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('2');
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'history?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function gotoexpense() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('1');
    $('#mainmenu').val('expenses_exp');
    $('#travelexpform').attr('action', '../Expenses/view?mainmenu=expenses_exp&time='+datetime);
    $("#travelexpform").submit();
}
function backtoemployees() {
    pageload();
    $('#mainmenu').val('employees_emp');
    $('#travelexpform').attr('action', '../Employees/view?mainmenu=employees_emp&time='+datetime);
    $("#travelexpform").submit();
    // window.history.back();
}
function gobackexpense() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    $('#histback').val('');
    $('#mainmenu').val('expenses_exp');
    $('#travelexpform').attr('action', '../Expenses/view?mainmenu=expenses_exp&time='+datetime);
    $("#travelexpform").submit();
}
function histbacktra() {
    pageload();
    $('#page').val('');
    $('#plimit').val('');
    var histbackdup = $('#histbackdup').val();
    var histback = $('#histback').val();
    if(histbackdup == 1 && histback == 2) {
        $('#histback').val('1');
    }
    var mainmenu = $('#mainmenu').val();
    $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
    $("#travelexpform").submit();
}
function cancel() {
    var mainmenu = $('#mainmenu').val();
    if (cancel_check == false) {
        if (confirm(cancel_msg)) {
            pageload();
            window.history.back();
        }
    } else {
        pageload();
        $('#travelexpform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
        $("#travelexpform").submit();
        // window.history.back();
    }
}
function fnMoneyFormatwithINR(name) {
    var value = document.getElementById(name).value;
    value = value.replace(/[ ]*,[ ]*|[ ]+/g, '');
    fnMoneyFormatWithoutleadingzero(name, value, 'en')
}
function fnCheckJap(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if((charCode > 64 && charCode <91) || (charCode > 96 && charCode <123) || (charCode > 47 && charCode < 58) || (charCode < 48 || charCode > 57)) {
        
         //if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    }
}
function confirmamount() {
    alert(travel_confirm_amount_msg);
}