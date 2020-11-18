function settingpopupsinglefield(screen_name,tablename,location,tableselect,parametersub,popupname) {

    var req = "?screen_name="+screen_name+

                "&tablename="+tablename+

                "&location="+location;



    if (screen_name == "singletextpopup") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename+'&location='+location);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "onetextpopup") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/onetextpopup?screen_name='+screen_name+'&tablename='+tablename+'&location='+location);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "twotextpopup") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/twotextpopup?screen_name='+screen_name+'&tablename='+tablename+'&location='+location);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    }  else if (screen_name == "selectthreefieldDatasforbank") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/selectthreefieldDatas?screen_name='+screen_name+'&tablename='+tablename+'&tableselect='+tableselect+'&location='+location+'&parametersub='+parametersub);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "selectthreefieldDatas") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/selectthreefieldDatas?screen_name='+screen_name+'&tablename='+tablename+'&tableselect='+tableselect+'&location='+location+'&parametersub='+parametersub);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "projecttype") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "others") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "taxfree") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    }  else if (screen_name == "Allowance") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "deduction") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "bycompany") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/singletextpopup?screen_name='+screen_name+'&tablename='+tablename);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else if (screen_name == "eighttextpopup") {

        popupopenclose(1);

        $('#showpopup').load('../Setting/eighttextpopup?screen_name='+screen_name+'&tablename='+tablename+'&location='+location);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    } else {

        popupopenclose(1);

        $('#showpopup').load('../Setting/uploadpopup?screen_name='+screen_name);

        $("#showpopup").modal({

           backdrop: 'static',

            keyboard: false

        });

    $('#showpopup').modal('show');

    }

}

function fnrdocheck(textbox1,editid) {


    $('#hid_txtval').val(textbox1);

    $('#rdoid').val(editid);

    // EDIT BUTTON ENABLE

    document.getElementById("edit").disabled = false;

    $("#rdoedit"+editid).attr("checked", true);

    $("#edit").css("background-color","#FF8C00");

}



function fneditcheck() {

    var editid = $('#rdoid').val();

    $("#edit").addClass("CMN_cursor_default");

    $('#process').val(2);

    document.getElementById("edit").disabled = true;

    $("#add_var").hide();

    $("#update_var").show();

    var dataname = $('#dataname'+editid).text();

    var hid_txtval = $('#hid_txtval').val();

    $('#textbox1').val(dataname);

    return false;

}

function fnrdochecktwofield(textbox1,textbox2,editid) {

    $('#hid_txtval').val(textbox1);

    $('#hid_txt2val').val(textbox2);

    $('#rdoid').val(editid);

    // EDIT BUTTON ENABLE

    document.getElementById("edit").disabled = false;

    $("#rdoedit"+editid).attr("checked", true);

    $("#edit").css("background-color","#FF8C00");

}

function fneditcheckonefield() {

    var editid = $('#rdoid').val();

    $("#edit").addClass("CMN_cursor_default");

    $('#process').val(2);

    document.getElementById("edit").disabled = true;

    $("#add_var").hide();

    $("#update_var").show();

    var dataname1 = $('#dataname1'+editid).text();

    // var dataname2 = $('#dataname2'+editid).text();

    $('#textbox1').val(dataname1);

    // $('#textbox2').val(dataname2);

    return false;

}

function fneditchecktwofield() {

    var editid = $('#rdoid').val();

    $("#edit").addClass("CMN_cursor_default");

    $('#process').val(2);

    document.getElementById("edit").disabled = true;

    $("#add_var").hide();

    $("#update_var").show();

    var dataname1 = $('#dataname1'+editid).text();

    var dataname2 = $('#dataname2'+editid).text();

    $('#textbox1').val(dataname1);

    $('#textbox2').val(dataname2);

    return false;

}

function fnrdocheckthreefield(selectbox1,textbox1,textbox2,editid) {

    $('#hid_txt1val').val(selectbox1);

    $('#hid_txt2val').val(textbox1);

    $('#hid_txt3val').val(textbox2);

    $('#rdoid').val(editid);

    // EDIT BUTTON ENABLE

    document.getElementById("edit").disabled = false;

    $("#rdoedit"+editid).attr("checked", true);

    $("#edit").css("background-color","#FF8C00");

}



function fneditcheckthreefield() {

    var editid = $('#rdoid').val();

    $("#edit").addClass("CMN_cursor_default");

    $('#process').val(2);

    document.getElementById("edit").disabled = true;

    $("#add_var").hide();

    $("#update_var").show();

    var dataname1 = $('#dataname1'+editid).text();

    var dataname2 = $('#dataname2'+editid).text();

    var dataname3 = $('#dataname3'+editid).text();

    $('#textbox1').val($.trim(dataname1));

    $('#textbox2').val(dataname2);

    $('#textbox3').val(dataname3);

    return false;

}

function fnaddeditsinglefield(location,mainmenu,tablename,flag,messageflag) {

    mainmenu = "Setting";

        if($("#textbox1").val()==""){

        $("#empty_textbox1").show(); 

        $("#textbox1").focus();

        } else if($("#textbox1").val()!=""){

            $("#empty_textbox1").hide(); 

            var opr=$('#process').val();

            var messageflags = $('#flashmessage').val(messageflag)

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {   

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                $('#location').val(location);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'SingleFieldaddedit';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"textbox1": textbox1,"location": location,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {



                             if (data != "") {

                                var res = $.parseJSON(data);

                                var orderid=res.orderid;

                                var totalid=res.totalid;

                                var data=orderid;

                                  $('#textbox1').val('');

                                  if(opr==1) {

                                    var tempdata= parseInt(data)+1;

                                    var data='<tr class="h37" onclick="fnrdocheck(\''+textbox1+'\',\''+totalid+'\')"><td class="tac" title="Select"><input type = "radio" name="rdoedit" id="rdoedit'+data+'" class="h13 w13" onclick="fnrdocheck(\''+textbox1+'\',\''+data+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+data+'"></td><td class="text-center pt7" title="S.No">'+data+'</td><td class="pl7 pt7" id="dataname'+totalid+'">'+textbox1+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+totalid+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+totalid+'"></td></tr>';

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                     $("#popupsessionupd").css("display", "none");

                                   } else {

                                    $("#dataname"+editid).text(textbox1);

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");



                                   }

                                    var rowCount = $('#swaptable1 tr').length;

                                    if ($('#swaptable1 tr').hasClass('nodata')) {

                                        $('#swaptable1 tr:first').remove();

                                }



                             }

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}

function fnaddeditonefield(location,mainmenu,tablename,flag) {

    mainmenu = "Setting";

    var opr=$('#process').val();

        if($("#textbox1").val()==""){

        $("#empty_textbox1").show(); 

        $("#textbox1").focus();

        } else {

            $("#empty_textbox1").hide(); 

            // $("#empty_textbox2").hide(); 

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {   

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                var textbox2 =  $('#textbox2').val();

                // $('#textbox2').val(textbox2);

                $('#location').val(location);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'oneFieldaddedit';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"textbox1": textbox1,"location": location,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {

                           if (data != "") {
         
                            // 2020-06-08 Updated by Easa
                                var res = $.parseJSON(data);

                                var orderid = res;

                                var totalid = res;

                                var data = orderid;


                            // 2020-06-08 Updated by Easa End

                                // $('#swaptable1 tr:last').remove();

                                $('#textbox1').val('');

                                // $('#textbox2').val('');

                                if(opr==1) {
// alert(res.update_query);
                                    var tempdata= parseInt(data)+1;
// alert(JSON.stringify(res.update_query));
                                    var data='<tr class="h37"><td class="tac" title="Select"><input type = "radio" name="rdoedit" id="rdoedit'+totalid+'" class="h13 w13" onclick="fnrdocheckonefield(\''+textbox1+'\',\''+totalid+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+res+'"></td><td class="text-center pt7" title="S.No">'+res+'</td><td class="pl7 pt7" id="dataname1'+res+'">'+textbox1+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+data+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+totalid+'"></td></tr>';

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                    $("#popupsessionupd").css("display", "none");

                                    $("#popupsessionfail").css("display", "none");

                                    $("#swaptable1 tr:last").css('cursor', 'hand');

                                } else {

                                    $("#dataname1"+editid).text(textbox1);

                                    // $("#dataname2"+editid).text(textbox2);

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");

                                    $("#popupsessionfail").css("display", "none");

                                }
                                 

                                var rowCount = $('#swaptable1 tr').length;

                                if ($('#swaptable1 tr').hasClass('nodata')) {

                                    $('#swaptable1 tr:first').remove();

                                }

                            }else{
                                $("#popupsessionfail").css("display", "block");

                                $("#popupsessionupd").css("display", "none");

                                $("#popupsessionreg").css("display", "none");
                            }

                                

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}

function fnaddedittwofield(location,mainmenu,tablename,flag) {

    mainmenu = "Setting";

    var opr=$('#process').val();

        if($("#textbox1").val()==""){

        $("#empty_textbox1").show(); 

        $("#textbox1").focus();

        } /*else if($("#textbox2").val()==""){

        $("#empty_textbox2").show(); 

        $("#textbox2").focus();

        $("#empty_textbox1").hide(); 

        }*/ else {

            $("#empty_textbox1").hide(); 

            $("#empty_textbox2").hide(); 

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {   

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                var textbox2 =  $('#textbox2').val();

                $('#textbox2').val(textbox2);

                $('#location').val(location);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'twoFieldaddedit';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"textbox1": textbox1,"textbox2": textbox2,"location": location,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {

                           if (data != "") {
                            // 2020-06-08 Updated by Easa
                                var res = $.parseJSON(data);

                                var orderid=res.orderid;

                                var totalid=res.totalid;

                                var data=orderid;
                            // 2020-06-08 Updated by Easa End

                                // $('#swaptable1 tr:last').remove();

                                $('#textbox1').val('');

                                $('#textbox2').val('');

                                if(opr==1) {

                                    var tempdata= parseInt(data)+1;

                                    var data='<tr class="h37"><td class="tac" title="Select"><input type = "radio" name="rdoedit" id="rdoedit'+totalid+'" class="h13 w13" onclick="fnrdochecktwofield(\''+textbox1+'\',\''+textbox2+'\',\''+totalid+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+totalid+'"></td><td class="text-center pt7" title="S.No">'+data+'</td><td class="pl7 pt7" id="dataname1'+totalid+'">'+textbox1+'</td><td class="pl7 pt7" id="dataname2'+totalid+'">'+textbox2+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+data+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+totalid+'"></td></tr>';

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                    $("#popupsessionupd").css("display", "none");

                                    $("#swaptable1 tr:last").css('cursor', 'hand');

                                } else {

                                    $("#dataname1"+editid).text(textbox1);

                                    $("#dataname2"+editid).text(textbox2);

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");

                                }

                                var rowCount = $('#swaptable1 tr').length;

                                if ($('#swaptable1 tr').hasClass('nodata')) {

                                    $('#swaptable1 tr:first').remove();

                                }

                            }

                                

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}



function fnaddeditthreefieldforbank(location,mainmenu,tablename,flag) {

    mainmenu = "Setting";

    var opr=$('#process').val();

        if($("#selectbox1").val()==""){

            $("#empty_selectbox1").show();

            $("#empty_textbox1").hide(); 

            $("#empty_textbox2").hide(); 

            $("#selectbox1").focus();

        } else if($("#textbox1").val()==""){

            $("#empty_textbox1").show(); 

            $("#empty_selectbox1").hide();

            $("#empty_textbox2").hide();

            $("#textbox1").focus();

        } else if($("#textbox2").val()==""){

            $("#empty_textbox2").show(); 

            $("#empty_selectbox1").hide();

            $("#empty_textbox1").hide();

            $("#textbox2").focus();

        } else {

            $("#empty_selectbox1").hide();

            $("#empty_textbox1").hide(); 

            $("#empty_textbox2").hide();

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {

                var selectbox1 =  $('#selectbox1').val();

                $('#selectbox1').val(selectbox1);

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                var textbox2 =  $('#textbox2').val();

                $('#textbox2').val(textbox2);

                $('#location').val(location);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'threeFieldaddeditforbank';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"selectbox1": selectbox1,"textbox1": textbox1,"textbox2": textbox2,"location": location,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {

                            if (data != "") {

                                var res = $.parseJSON(data);

                                var orderid=res.orderid;

                                var totalid=res.totalid;

                                var data=orderid;

                                 $('#selectbox1').val('');

                                 $('#textbox1').val('');

                                 $('#textbox2').val('');

                                 if(opr==1) {

                                    var tempdata= parseInt(data)+1;

                                    var tempselecctvalue=$("#selectbox1 option[value="+selectbox1+"]").text();

                                    var data='<tr class="h37" onclick="fnrdocheckthreefield(\''+selectbox1+'\',\''+textbox1+'\',\''+textbox2+'\',\''+totalid+'\')"><td class="tac" title="Select"><input type = "radio"" name="rdoedit" id="rdoedit'+totalid+'" class="h13 w13" onclick="fnrdocheckthreefield(\''+tempselecctvalue+'\',\''+textbox1+'\',\''+textbox2+'\',\''+totalid+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+data+'"></td><td class="text-center pt7" title="S.No">'+data+'</td><td class="pl7 pt7" id="datanametd2'+totalid+'">'+tempselecctvalue+'<input type="hidden" name="hiddenselectvalue" id="dataname1'+totalid+'" value="'+selectbox1+'"></td><td class="pl7 pt7" id="dataname2'+totalid+'">'+textbox1+'</td><td class="pl7 pt7" id="dataname3'+totalid+'">'+textbox2+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+totalid+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+totalid+'"></td></tr>'; 

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                    $("#popupsessionupd").css("display", "none");

                                    $("#swaptable1 tr:last").css('cursor', 'hand');



                                } else {

                                var tempselecctvalue=$("#selectbox1 option[value="+selectbox1+"]").text();

                                   $("#datanametd2"+editid).html('');

                                   var tempdata=tempselecctvalue+'<input type="hidden" name="hiddenselectvalue" id="dataname1'+editid+'" value="'+selectbox1+'">'

                                   $("#datanametd2"+editid).html(tempdata);

                                    $("#dataname2"+editid).text(textbox1);

                                    $("#dataname3"+editid).text(textbox2); 

                                    $('#dataname1'+editid).val(selectbox1);

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");



                                }

                                    var rowCount = $('#swaptable1 tr').length;

                                    if ($('#swaptable1 tr').hasClass('nodata')) {

                                        $('#swaptable1 tr:first').remove();

                                }



                            }

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}

function fnaddeditthreefield(mainmenu,tablename,flag) {

    mainmenu = "Setting";

    var opr=$('#process').val();

        if($("#selectbox1").val()==""){

            $("#empty_selectbox1").show(); 

            $("#selectbox1").focus();

            $("#empty_textbox1").hide(); 

            $("#empty_textbox2").hide();

        } else if($("#textbox1").val()==""){

            $("#empty_textbox1").show(); 

            $("#textbox1").focus();

            $("#empty_selectbox1").hide();

            $("#empty_textbox2").hide();

        } else if($("#textbox2").val()==""){

            $("#empty_textbox2").show(); 

            $("#textbox2").focus();

            $("#empty_selectbox1").hide();

            $("#empty_textbox1").hide(); 

        } else {

            $("#empty_selectbox1").hide();

            $("#empty_textbox1").hide(); 

            $("#empty_textbox2").hide();

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {

                var selectbox1 =  $('#selectbox1').val();

                $('#selectbox1').val(selectbox1);

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                var textbox2 =  $('#textbox2').val();

                $('#textbox2').val(textbox2);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'threeFieldaddedit';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"selectbox1": selectbox1,"textbox1": textbox1,"textbox2": textbox2,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {

                            // alert(data);

                            if (data != "") {

                                 $('#selectbox1').val('');

                                 $('#textbox1').val('');

                                 $('#textbox2').val('');

                                 if(opr==1) {

                                 var tempdata= parseInt(data)+1;

                                    var tempselecctvalue=$("#selectbox1 option[value="+selectbox1+"]").text();

                                    var data='<tr class="h37" onclick="fnrdocheckthreefield(\''+selectbox1+'\',\''+textbox1+'\',\''+textbox2+'\',\''+data+'\')"><td class="tac" title="Select"><input type = "radio"" name="rdoedit" id="rdoedit'+data+'" class="h13 w13" onclick="fnrdocheckthreefield(\''+tempselecctvalue+'\',\''+textbox1+'\',\''+textbox2+'\',\''+data+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+data+'"></td><td class="text-center pt7" title="S.No">'+data+'</td><td class="pl7 pt7 box30per" id="datanametd2'+data+'">'+tempselecctvalue+'<input type="hidden" name="hiddenselectvalue" id="dataname1'+data+'" value="'+selectbox1+'"></td><td class="pl7 pt7" id="dataname2'+data+'">'+textbox1+'</td><td class="pl7 pt7" id="dataname3'+data+'">'+textbox2+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+data+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+data+'"></td></tr>'; 

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                    $("#popupsessionupd").css("display", "none");

                                    $("#swaptable1 tr:last").css('cursor', 'hand');



                                } else {

                                var tempselecctvalue=$("#selectbox1 option[value="+selectbox1+"]").text();

                                   // $("#datanametd2"+editid).append(tempselecctvalue);

                                   $("#datanametd2"+editid).html('');

                                   var tempdata=tempselecctvalue+'<input type="hidden" name="hiddenselectvalue" id="dataname1'+editid+'" value="'+selectbox1+'">'

                                   $("#datanametd2"+editid).html(tempdata);

                                    $("#dataname2"+editid).text(textbox1);

                                    $("#dataname3"+editid).text(textbox2); 

                                    $('#dataname1'+editid).val(selectbox1);

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");

                                }

                                    var rowCount = $('#swaptable1 tr').length;

                                    if ($('#swaptable1 tr').hasClass('nodata')) {

                                    $('#swaptable1 tr:first').remove();

                                }



                            }

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}

function fnaddeditthreetextfield(mainmenu,tablename,flag) {

    var opr=$('#process').val();

        if($("#textbox1").val()==""){

            $("#empty_textbox1").show(); 

            $("#textbox1").focus();

            $("#empty_textbox2").hide(); 

        } else if($("#textbox2").val()==""){

            $("#empty_textbox2").show(); 

            $("#textbox2").focus();

            $("#empty_textbox1").hide();

        } else {

            $("#empty_textbox1").hide();

            $("#empty_textbox2").hide(); 

            if ($('#process').val() == 1) {

                var err_cnfirm = confirm(err_confreg);

            } else {

                var err_cnfirm = confirm(err_confup);

            }

            if(err_cnfirm) {

                var textbox1 =  $('#textbox1').val();

                $('#textbox1').val(textbox1);

                var textbox2 =  $('#textbox2').val();

                $('#textbox2').val(textbox2);

                var textbox3 =  $('#textbox3').val();

                $('#textbox3').val(textbox3);

                $('#tablename').val(tablename);

                $('#flag').val(flag);

                var editid = $('#rdoid').val();

                var url = 'threeFieldaddedit';

                    $.ajax({

                    async: true,

                        type: 'GET',

                        url: url,

                        data: {"textbox1": textbox1,"textbox2": textbox2,"textbox3": textbox3,"mainmenu": mainmenu,"tablename": tablename,"id": editid,"flag": flag},

                        success: function(data) {

                            // alert(data);

                            if (data != "") {

                                var res = $.parseJSON(data);

                                var orderid=res.orderid;

                                var totalid=res.totalid;

                                var data=orderid;

                                 $('#textbox1').val('');

                                 $('#textbox2').val('');

                                 $('#textbox3').val('');

                                 if(opr==1) {

                                    var tempdata= parseInt(data)+1;

                                    var data='<tr class="h37" onclick="fnrdocheckthreefield(\''+textbox1+'\',\''+textbox2+'\',\''+textbox3+'\',\''+totalid+'\')"><td class="tac" title="Select"><input type = "radio"" name="rdoedit" id="rdoedit'+totalid+'" class="h13 w13" onclick="fnrdocheckthreefield(\''+textbox1+'\',\''+textbox2+'\',\''+textbox3+'\',\''+totalid+'\');"><input id="rdoid" name="rdoid" type="hidden" value="'+totalid+'"></td><td class="text-center pt7" title="S.No">'+data+'</td><td class="pl7 pt7 box30per" id="dataname1'+totalid+'">'+textbox1+'</td><td class="pl7 pt7" id="dataname2'+totalid+'">'+textbox2+'</td><td class="pl7 pt7" id="dataname3'+totalid+'">'+textbox3+'</td><td class="tac pt7" title="Use/Not Use"><a href="javascript:useNotuse(\''+totalid+'\',\''+tempdata+'\');" class="btn-link" style="color:blue;"><label class="btn-link" id="usenotuselabel'+tempdata+'" data-type="0" style="color: blue;">Use</label></a><input id="curtFlg'+tempdata+'" name="curtFlg'+tempdata+'" type="hidden" value="1"><input id="editid'+tempdata+'" name="editid'+tempdata+'" type="hidden" value="'+totalid+'"></td></tr>'; 

                                    $('#swaptable1 tr:last').after(data);

                                    $("#popupsessionreg").css("display", "block");

                                    $("#popupsessionupd").css("display", "none");

                                    $("#swaptable1 tr:last").css('cursor', 'hand');



                                } else {

                                    $('#dataname1'+editid).text(textbox1);

                                    $("#dataname2"+editid).text(textbox2);

                                    $("#dataname3"+editid).text(textbox3); 

                                    $("#add_var").show();

                                    $("#update_var").hide();

                                    $('#process').val(1);

                                    $("#popupsessionupd").css("display", "block");

                                    $("#popupsessionreg").css("display", "none");

                                }

                                    var rowCount = $('#swaptable1 tr').length;

                                    if ($('#swaptable1 tr').hasClass('nodata')) {

                                    $('#swaptable1 tr:first').remove();

                                }



                            }

                        },

                           error: function(data) {

                        }

                    });

            }

    }

}

function useNotuse(editid,i) {

    var tablename =  $('#tablename').val();

    var editid =  $('#editid'+i).val();

    var curtFlg =  $("#usenotuselabel"+i).attr('data-type');

    var url = 'useNotuse';

        $.ajax({

        async: true,

            type: 'GET',

            url: url,

            data: {"tablename": tablename,"editid": editid,"curtFlg": curtFlg },

            success: function(data) {

                 if(curtFlg==1) {

                     $("#usenotuselabel"+i).text('Use');

                     $("#usenotuselabel"+i).css('color','blue');

                     $("#usenotuselabel"+i).attr('data-type','0');

                     $("#usenotuseanchor"+i).css('text-decoration', 'none');

                 } else {

                     $("#usenotuselabel"+i).text('Not Use');

                     $("#usenotuselabel"+i).css('color','red');

                     $("#usenotuselabel"+i).attr('data-type','1');

                     $("#usenotuseanchor"+i).css('text-decoration', 'none');

                 }

            },

               error: function(data) {

            }

        });

}

function fnsettingpopup(heading) {

    var ifile = document.getElementById('xlfile').value;



    if (ifile == "") {

        alert("Please Select a File");

        document.getElementById('xlfile').focus();

        document.getElementById('xlfile').select();

        return false;

    } else if (ifile != "") {

        var arr1 = new Array;

        arr1 = ifile.split("\\");

        var len = arr1.length;

        var doc1 = arr1[len - 1];

        var filext = doc1.substring(doc1.lastIndexOf(".") + 1);

        // Checking Extension

        if (filext == "xls" || filext == "xlsx") {

        } else {

            alert("The Uploaded File Should Be a xls or xlsx Format");

            return false;

        }

    }

    var cmsg = "Do You Want Update File";

    if (confirm(cmsg)) {

        document.getElementById("upload").disabled = true;

        document.getElementById("cancel").disabled = true;

        document.forms["uploadpopup"].submit();



        return true;

    } else {

        return false;

    }

}

function fnclosepopdig() {

    $(this).removeData('bs.modal');

    $('#modal-container .modal-content').empty();

}

function divpopupclose() {

    var confirmmsg = cancel_msg;

    if (confirm(confirmmsg)) {

        $( "body div" ).removeClass( "modalOverlay" );

        $( '#showpopup' ).empty();

        $('#showpopup').modal('toggle');

    } else {

        return false;

    }

}

function fnselecttoggleclose() {

   $("#styleSelector").removeClass('open');

}

function fnaddeditcompanydetails(tablename, id = 0) {

    var companyNumber =  $('#companyNumber').val();
    
    var companyName =  $('#companyName').val();
    
    var companyBranch =  $('#companyBranch').val();
    
    var capital =  $('#capital').val();
    
    var address =  $('#address').val();
    
    var TEL =  $('#TEL').val();
    
    var CEO =  $('#CEO').val();

    var referencenumber =  $('#referencenumber').val();

    var allfieldstatus = 0;

    if(companyNumber ==""){

        $("#empty_companyNumber").show(); 

    } else {

        $("#empty_companyNumber").hide(); 

    }


    if(companyName ==""){

        $("#empty_companyName").show(); 

    } else {

        $("#empty_companyName").hide(); 

    }

    if(companyBranch ==""){

        $("#empty_companyBranch").show(); 

    } else {

        $("#empty_companyBranch").hide(); 

    }

    if(capital ==""){

        $("#empty_capital").show(); 

    } else {

        $("#empty_capital").hide(); 
        
    }

    if(address ==""){

        $("#empty_address").show(); 

    } else {

        $("#empty_address").hide(); 
        
    }

    if(TEL ==""){

        $("#empty_TEL").show(); 

    } else {

        $("#empty_TEL").hide(); 
        
    }

    if(CEO ==""){

        $("#empty_CEO").show(); 

    } else {

        $("#empty_CEO").hide(); 
        
    }

    if(referencenumber ==""){

        $("#empty_referencenumber").show(); 

    } else {

        $("#empty_referencenumber").hide(); 

    }

    if ((companyNumber != "") && (companyName != "") && (companyBranch != "") && 
        (capital != "") && (address != "") && (TEL != "") && (CEO != "") && (referencenumber != "")) {
        allfieldstatus = 1;
    }

    if (allfieldstatus == 1) {
        var cmsg = "Are You Confirm To Register";

        if (confirm(cmsg)) {
            var url = 'eighttextpopup';

            $.ajax({

            async: true,

                type: 'GET',

                url: url,

                data: {"id": id,"tablename": tablename,"companyNumber": companyNumber,"companyName": companyName
                ,"companyBranch": companyBranch,"capital": capital,"address": address,"TEL": TEL,"CEO": CEO,"referencenumber": referencenumber },

                success: function(data) {
                    if (id != 0) {
                        $("#popupsessionreg").css("display", "none");

                        $("#popupsessionupd").css("display", "block");
                    }else{
                        $("#popupsessionreg").css("display", "block");

                        $("#popupsessionupd").css("display", "none");
                    }
                    

                    $("#datainput").hide();

                    $("#add_var").hide();

                    $("#update_var").hide();

                    document.getElementById("editcompanydetails").disabled = false;

                    $("#editcompanydetails").show();

                    $("#loadafternumber").html(companyNumber);
                    $('#loadafternumber').data('companynumberafterload', companyNumber);

                    $("#loadaftername").html(companyName);
                    $('#loadaftername').data('companynameafterload', companyName);

                    $("#loadafterbranch").html(companyBranch);
                    $('#loadafterbranch').data('companybranchafterload', companyBranch);

                    $("#loadaftercapital").html(capital);
                    $('#loadaftercapital').data('companycapitalafterload', capital);

                    $("#loadafteraddress").html(address);
                    $('#loadafteraddress').data('companyaddressafterload', address);

                    $("#loadaftertel").html(TEL);
                    $('#loadaftertel').data('companytelafterload', TEL);

                    $("#loadafterceo").html(CEO);
                    $('#loadafterceo').data('companyceoafterload', CEO);

                    $("#loadafterreferencenumber").html(referencenumber);
                    $('#loadafterreferencenumber').data('companyreferencenumberafterload', referencenumber);

                    $("#dataviewafterload").show();

                },

                   error: function(data) {

                }

            });
        }
    }

}

// Sastha 05/08/2020
function fnrdocheckonefield(textbox1,editid) {
    $('#hid_txtval').val(textbox1);
    $('#rdoid').val(editid);
    // EDIT BUTTON ENABLE
    document.getElementById("edit").disabled = false;
    $("#rdoedit"+editid).attr("checked", true);
    $("#edit").css("background-color","#FF8C00");
}

