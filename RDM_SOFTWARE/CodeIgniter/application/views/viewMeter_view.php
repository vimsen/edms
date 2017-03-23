
<?php $this->view('part1'); ?>
<div class="row-fluid">

    <div class="span8 widget blue" onTablet="span7" onDesktop="span8">

        <div id="stats-chart2"  style="min-height:282px" >
            <link rel="stylesheet" href="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.css">


            <br>

            <style>

                .input-field input[type=text]:focus {
                    border-bottom: 1px solid red;
                    box-shadow: 0 1px 0 0 red;
                }
                
                   .input-field input[type=text] {
                    border-bottom: 1px solid green;
                    box-shadow: 0 1px 0 0 green;
                }


            </style>



            <h1>View Gateways</h1>
            <div id="wrapperb">

                <div class="preloader-wrapper active" id="spiaj2" style="display:none;">
                    <div class="spinner-layer spinner-red-only">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                            <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>

                <div id="webConten">


                </div>  

                <?php
                $max = sizeof($m_id);
                $meterStatus = "";
                if ($member == "Admin") {


                    if ($max) {

                        for ($i = 0; $i < $max; $i++) {

                                                     echo "<div id='block_$i' style='float:left;'><p style='float:left;margin-right:8px;cursor:pointer;'>$DayReceived[$i] / </p><p class='pMac' data-id='$m_id[$i]' data-mac='$mac[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $macNames[$i] . " / </p>  <p class='device_mac' data-id='$m_id[$i]' data-macnames='$macNames[$i]' style='float:left;margin-right:8px;cursor:pointer;'>Add Devices for this Gateway / </p> <p class='device_macre' data-id='$m_id[$i]' data-ii='$i' data-macnames='$macNames[$i]' style='float:left;margin-right:8px;cursor:pointer;color:#686868;font-weight: bold;'>Remove this Gateway / </p><p class='device_maDisplay' data-id='$m_id[$i]' data-macnames='$macNames[$i]' data-lid='$i' style='float:left;margin-right:8px;cursor:pointer;font-weight: bold;'>Display Devices for this Gateway</p>--<a href='detailMeter?id=$m_id[$i];' style='color:white;font-size:18px;'> Details</a><img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                        }
                    }
                } else {

                    if ($max) {

                        for ($i = 0; $i < $max; $i++) {

                           

                            echo "<div id='block_$i' style='float:left;'><p style='float:left;margin-right:8px;cursor:pointer;'>$DayReceived[$i] N/ </p><p class='pMac' data-id='$m_id[$i]' data-mac='$mac[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $macNames[$i] . " / </p>  <img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                        }
                    }
                }
                ?>

            </div>

            <div id="messages"></div>

            <div id="dialog" title="">
                <table>
                    <td> <p>
                            This is the default dialog which is useful for displaying information.
                            The dialog window can be moved, resized and closed with the 'x' icon.
                        </p>
                    </td></tr><tr>

                        <td><h3 id="dataMacName">yyyy</h1></td></tr><tr>

                        <td>



                            <div class="input-field col s12" >
                                <select id="device_m" style="display:block">
                                    <option >-</option>
                                    <option >1</option>
                                    <option >2</option>
                                    <option >3</option>
                                    <option >4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>

                                </select> </div> 

                        </td>
                    </tr><tr>
                        <td>    
                            <div id="elemetex">

                            </div>

                        </td>
                    </tr><tr>

                        <td>
                            <!--<img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiaj" style="display:none;"> -->

                            <div class="preloader-wrapper active" id="spiaj" style="display:none;">
                                <div class="spinner-layer spinner-red-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div><div class="gap-patch">
                                        <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>

                            <p id="saveDsto" style="display:none;">
                                <strong id="savenow" class="waves-effect waves-light btn-large" style="cursor:pointer;">Save</strong>

                            </p>

                            <p id="message_print_1" style="display:none;">Your Action Completed successfully</p>
                            <p id="message_print_2" style="display:none;">Please try again Later.</p>
                            <p id="message_print_3" style="display:none;">You Haven't typed any Devices for this Gateway.</p>
                            <p id="message_print_3CH" style="display:none;">You Haven't checked all the checkbox.</p>
                            <p id="message_print_31" style="display:none;">You Have typed too many character Devices for this Gateway.</p>
                        </td>



                </table>     
            </div> 


            <div id="dialog_3" title="">


                <div id="contentbox3"></div>

            </div>

            <div id="dialog4" title="">
                <table>
                    <td>Do you want to delete Mac Device? <strong><p id="titleIdmd"></p><strong></td>
                            </tr><tr>    
                            <td>
                                <img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiad" style="display:none;"> 
                                <p id="delete_macD" style="cursor:pointer;color:red;">Delete</p></td>       
                            <td><p id="no_macD" style="cursor:pointer;">No</p></td>
                            </table>

                            </div>

                        <div id="dialogNo" title="">

                            <table>
                                <td>Do you want to delete this record? <strong><p id="titleId"></p><strong></td>
                                        </tr><tr>  


                                        <td>
                                            <img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiad" style="display:none;"> 
                                           
                                            <p id="delete_mac"  class="waves-effect waves-light btn-large" style="cursor:pointer;background-color:red;">Delete</p>
                                        
                                        </td>       
                                        <td><p id="no_mac" style="cursor:pointer;" class="waves-effect waves-light btn-large">No</p></td>
                                        </table>

                                        </div>


                                    <input type=hidden id="dId" name="dId" value=""/>
                                    <input type=hidden id="cId" name="cId" value=""/>
                                    <input type=hidden id="RId" name="RId" value=""/>

                                    <input type=hidden id="DDId" name="DDId" value=""/>
                                    <input type=hidden id="DDNId" name="DDNId" value=""/>

                                    </div>

                                    </div>

                                    <!-- End .sparkStats -->

                                    </div>

                                    <?php $this->view('part2'); ?>


                                    <script src="<?= base_url() ?>public/js/jquery.js"></script>

                                    <script src="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>



                                    <script src="<?= base_url() ?>public/js/mqttws31.js"></script>

                                    <script src="<?= base_url() ?>public/js/hiveMQ_client_test.js"></script>



                                    <script>

                                        client.connect(options);

                                        $("body").on("click", "#savenow", function () {

                                            var textSend = "";

                                            var checkSend = "";

                                            $("#message_print_1").css("display", "none");

                                            $("#message_print_2").css("display", "none");
                                            $("#message_print_3").css("display", "none");
                                            $("#message_print_31").css("display", "none");


                                            $(".submeter1").each(function () {
                                                if ($(this).val()) {
                                                    textSend += $(this).val() + "@";
                                                } else {
                                                    textSend += "@";

                                                    $("#message_print_3").css("display", "block").delay(5000).fadeOut('slow');

                                                }
                                            });

                                            $(".submeter_energ").each(function () {
                                                if ($(this).is(':checked')) {

                                                    checkSend += $(this).val() + "@";

                                                } else {
                                                    checkSend += "@";

                                                    $("#message_print_3CH").css("display", "block").delay(5000).fadeOut('slow');

                                                }
                                            });

                                            if (textSend) {

                                                $.ajax({
                                                    type: "POST",
                                                    url: "<? echo site_url('viewMeter/saveMacMeter');?>",
                                                    dataType: 'json',
                                                    cache: false,
                                                    data: {
                                                        textSend: $.trim(textSend),
                                                        checkSend: $.trim(checkSend),
                                                        cId: $.trim($("#cId").val())

                                                    },
                                                    beforeSend: function () {

                                                        $("#spiaj").css("display", "block");

                                                    },
                                                    complete: function () {
                                                        $("#spiaj").css("display", "none");

                                                    },
                                                    success: function (msg) { //probably this request will return anything, it'll be put in var "data"


                                                        if (msg.Result == 1) {
                                                            $("#message_print_1").css("display", "block").delay(5000).fadeOut('slow');
                                                            ;

                                                            setTimeout(function () {
                                                                $("#dialog").dialog("close");
                                                            }, 2000);


                                                        } else if (msg.Result == 3) {
                                                            $("#message_print_3").css("display", "block").delay(5000).fadeOut('slow');
                                                        } else if (msg.Result == 31) {
                                                            $("#message_print_31").css("display", "block").delay(5000).fadeOut('slow');
                                                        } else {
                                                            $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');
                                                        }

                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown)
                                                    {

                                                        $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');

                                                    }
                                                });

                                            }


                                        });


                                        //pMac
                                        $("body").on("click", ".pMac", function () {

                                            client.subscribe("+/" + $(this).attr("data-mac") + "/#", {qos: 0});


                                          

                                        });


                                        $("body").on("click", ".device_mac", function () {

                                            $("#elemetex").text("");
                                            $("#saveDsto").css("display", "none");
                                            $("#device_m").val("-");
                                            $("#cId").val($(this).attr("data-id"));
                                            $("#dataMacName").text("");
                                            $("#dataMacName").text($(this).attr("data-macnames"));
                                            $("#dialog").dialog("open");
                                        });



                                        $("body").on("click", ".divice_data", function () {
                                            $("#titleIdmd").text($(this).attr("data-name"));


                                            $("#DDId").val($(this).attr("data-Did"));
                                            $("#DDNId").val($(this).attr("data-name"));
                                            $("#dialog4").dialog("open");


                                        });

                                        $("body").on("click", "#no_macD", function () {
                                            $("#titleIdmd").text("");
                                            $("#dialog4").dialog("close");

                                        });


                                        $("body").on("click", ".device_maDisplay", function () {


                                            var rowIm = $(this).attr("data-lid");
 
                                            $.ajax({
                                                type: "POST",
                                                url: "<? echo site_url('viewMeter/listMacMeter');?>",
                                                dataType: 'json',
                                                cache: false,
                                                data: {
                                                    dId: $.trim($(this).attr("data-id"))

                                                },
                                                beforeSend: function () {

                                                    $("#spiadl_" + rowIm).css("display", "block");

                                                },
                                                complete: function () {
                                                    $("#spiadl_" + rowIm).css("display", "none");

                                                },
                                                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

                                                    $("#dialog_3").dialog("open");
                                                    $("#contentbox3").html("");
                                                    document.getElementById("dialog_3").innerHTML = "<div id='contentbox3'></div>";
                                                    var ids = msg.m_id;

                                                    ids = ids.toString();

                                                    var id_array = new Array();

                                                    id_array = ids.split(',');

                                                    var DeviceNames = msg.DeviceName;

                                                    DeviceNames = DeviceNames.toString();

                                                    var DeviceName_array = new Array();
                                                    DeviceName_array = DeviceNames.split(',');

                                                    ///macNames

                                                    var macNames = msg.macNames;

                                                    macNames = macNames.toString();

                                                    var macNames_array = new Array();
                                                    macNames_array = macNames.split(',');

                                                    var Devicedi = msg.Devicedi;
                                                    Devicedi = Devicedi.toString();
                                                    var Devicedi_array = new Array();
                                                    Devicedi_array = Devicedi.split(',');
                                                    for (i = 0; i < DeviceName_array.length; i++) {

                                                        $("#dialog_3").append("<div id='Rowdev" + Devicedi_array[i] + "'><img src='<?= base_url() ?>public/img/TrashIcon.png' id='spiadG' class='divice_data' data-Did='" + Devicedi_array[i] + "'  data-name='" + DeviceName_array[i] + "' style='display:block;float:left;cursor:pointer;'><p class='history_data'  data-macname='" + macNames_array[i] + "' data-name='" + DeviceName_array[i] + "' data-Did='" + Devicedi_array[i] + "' >" + DeviceName_array[i] + " </p></div><br>");

                                                    }


                                                    if (msg.Result == 1) {
                                                        $("#message_print_1").css("display", "block").delay(5000).fadeOut('slow');


                                                    } else {

                                                        $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');


                                                    }

                                                },
                                                error: function (jqXHR, textStatus, errorThrown)
                                                {
                                                    $("#dialog_3").dialog("close");
                                                    $("#spiadl_" + rowIm).css("display", "none").delay(5000).fadeOut('slow');

                                                }
                                            });

                                        });



                                        $("body").on("click", ".history_data", function () {

                                            $("#contentbox3").html(" ");

                                            $.ajax({
                                                type: "POST",
                                                url: "<? echo site_url('viewMeter/histMacMeter');?>",
                                                dataType: 'json',
                                                cache: false,
                                                data: {
                                                    tname: $.trim($(this).attr("data-name")),
                                                    tmname: $.trim($(this).attr("data-macname"))

                                                },
                                                beforeSend: function () {

                                                    $("#spiad").css("display", "block");

                                                },
                                                complete: function () {
                                                    $("#spiad").css("display", "none");

                                                },
                                                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

                                                    var payload = msg.Value;

                                                    payload = payload.toString();

                                                    var payload_array = new Array();
                                                    payload_array = payload.split(',');


                                                    var received = msg.Time;

                                                    received = received.toString();

                                                    var received_array = new Array();
                                                    received_array = received.split(',');


                                                    for (i = 0; i < payload_array.length; i++) {


                                                        $("#contentbox3").append("<p  >" + payload_array[i] + "  ( " + received_array[i] + " ) </p><br>");
                                                    }

                                                },
                                                error: function (jqXHR, textStatus, errorThrown)
                                                {

                                                    $("#spiad").css("display", "none").delay(5000).fadeOut('slow');

                                                }
                                            });

                                        });

                                        $("body").on("click", ".device_macre", function () {

                                            $("#RId").val($(this).attr("data-ii"));
                                            $("#dId").val($(this).attr("data-id"));
                                            $("#titleId").text($(this).attr("data-macnames"));
                                            $("#dialogNo").dialog("open");
                                        });

                                        $("body").on("click", "#no_mac", function () {

                                            $("#dId").val("");
                                            $("#dialogNo").dialog("close");
                                        });


                                        $("body").on("click", "#delete_macD", function () {

                                            $.ajax({
                                                type: "POST",
                                                url: "<? echo site_url('viewMeter/delMacMeterD');?>",
                                                dataType: 'json',
                                                cache: false,
                                                data: {
                                                    DDId: $.trim($("#DDId").val())

                                                },
                                                beforeSend: function () {

                                                    $("#spiad").css("display", "block");

                                                },
                                                complete: function () {
                                                    $("#spiad").css("display", "none");

                                                },
                                                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

                                                    if (msg.Result == 1) {
                                                        $("#message_print_1").css("display", "block").delay(5000).fadeOut('slow');
                                                        $("#dialog4").dialog("close");

                                                        setTimeout(function () {
                                                            $("#Rowdev" + $("#DDId").val()).slideUp();
                                                        }, 2000);

                                                    } else {

                                                        $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');


                                                    }

                                                },
                                                error: function (jqXHR, textStatus, errorThrown)
                                                {

                                                    $("#spiad").css("display", "none").delay(5000).fadeOut('slow');

                                                }
                                            });

                                        });

                                        $("body").on("click", "#delete_mac", function () {

                                            $.ajax({
                                                type: "POST",
                                                url: "<? echo site_url('viewMeter/delMacMeter');?>",
                                                dataType: 'json',
                                                cache: false,
                                                data: {
                                                    dId: $.trim($("#dId").val())

                                                },
                                                beforeSend: function () {

                                                    $("#spiad").css("display", "block");

                                                },
                                                complete: function () {
                                                    $("#spiad").css("display", "none");

                                                },
                                                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

                                                    if (msg.Result == 1) {
                                                        $("#message_print_1").css("display", "block").delay(5000).fadeOut('slow');
                                                        $("#dialogNo").dialog("close");

                                                        $("#block_" + $("#RId").val()).slideUp();

                                                    } else {

                                                        $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');


                                                    }

                                                },
                                                error: function (jqXHR, textStatus, errorThrown)
                                                {

                                                    $("#spiad").css("display", "none").delay(5000).fadeOut('slow');

                                                }
                                            });


                                        });

                                        $("body").on("click", "#device_m", function () {

                                            var i = 0;

                                            var max = parseInt($("#device_m").val());

                                            $("#elemetex").text("");

                                            for (i; i < max; i++) {

                                                $("#elemetex").append("<div class='input-field col s6' ><input type='text' class='submeter1' name='subdname" + i + "'></div> <input type='checkbox' class='submeter_energ' name='vehicle' value='on'> energy data.<br>");

                                            }

                                            $("#saveDsto").css("display", "block");

                                        });

                                        $("#dialog").dialog({
                                            autoOpen: false,
                                            height: 570,
                                            width: 550,
                                            modal: true,
                                        });


                                        $("#dialogNo").dialog({
                                            autoOpen: false,
                                             height: 570,
                                            width: 550,
                                            modal: true,
                                        });

                                        $("#dialog_3").dialog({
                                            autoOpen: false,
                                            height: 570,
                                            width: 550,
                                            modal: true,
                                        });

                                        $("#dialog4").dialog({
                                            autoOpen: false,
                                            height: 570,
                                            width: 550,
                                            modal: true,
                                        });

                                        $(document).ready(function () {
                                            var GidRow;
                                            var GbuiID;
                                            $.ajax({
                                                type: "POST",
                                                url: "<? echo site_url('viewMeter/indexLoadData');?>",
                                                dataType: 'json',
                                                cache: false,
                                                data: {
                                                    GidRow: $.trim(GidRow),
                                                    GbuiID: $.trim(GbuiID)

                                                },
                                                beforeSend: function () {
                                                    $("#spiaj2").css("display", "block");
                                                },
                                                complete: function () {

                                                    $("#spiaj2").css("display", "none");
                                                },
                                                success: function (msg) { //probably this request will return anything, it'll be put in var "data"


                                                    if (msg.falseD == "on") {
                                                        $('#webConten').html(msg.messageAlert);


                                                    } else if (msg.allDayn == "timeb") {

                                                    } else {

                                                    }


                                                },
                                                error: function (jqXHR, textStatus, errorThrown)
                                                {


                                                }
                                            });

                                        });

                                    </script>

                                    <script src="<?= base_url() ?>public/css/materialize/js/materialize.min.js"></script>