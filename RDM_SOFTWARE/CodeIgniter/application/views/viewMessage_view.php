
<?php $this->view('part1'); ?>
<div class="row-fluid">

    <div class="span8 widget blue" onTablet="span7" onDesktop="span8">

        <div id="stats-chart2"  style="min-height:282px" >
            <link rel="stylesheet" href="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.css">

            <h1>View Gateways</h1>
            <div id="wrapperb">
                <?php
                $max = sizeof($mId);

                if ($member == "Admin") {


                    if ($max) {

                        for ($i = 0; $i < $max; $i++) {

                            echo "<div id='block_$i' style='float:left;'><p class='pMac' data-id='$mId[$i]' data-idMessage='$id_message[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $id_message[$i] . " / </p>   <p class='device_macre' data-id='$mId[$i]' data-idMessage='$id_message[$i]' data-macnames='' style='float:left;margin-right:8px;cursor:pointer;color:#686868;font-weight: bold;'>Remove this Message / </p><p class='View_Message' data-id='$mId[$i]' data-idMessage='$id_message[$i]' data-mainMessage='$main_Message[$i]' data-lid='$i' style='float:left;margin-right:8px;cursor:pointer;font-weight: bold;'>View Messages</p><img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                        }
                    }
                } else {
                    
                }
                ?>

            </div>

            <div id="messages"></div>

            <div id="dialog" style="display:none;" title="">
                <table>
                    <td>
                  <h1>View  Gateway Message:</h1></td></tr><tr>

            <td><label for="username">Gateway ID:</label></td></tr><tr>
            <td><input type="text" size="50" id="gatewayId" name="macname"/></td></tr><tr>
            
            <td><label for="username">Gateway Mac Message:</label></td></tr><tr>
            <td><textarea rows="4" cols="50" id="gateNewMessage" name="vgwMessage"></textarea></td></tr><tr>
            <td><img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiaj" style="display:none;"></td></tr><tr>
            <td><p id="message_print_1" style="display:none;">Your Record just saved successfully</p>
            <p id="message_print_2" style="display:none;">Please try again later</p>  
            <p id="message_print_3" style="display:none;">You haven't selected Gateway name.</p>  
            <p id="message_print_4" style="display:none;">Gateway Name field can't be longer than 50 chars.</p> 
            </td></tr><tr>
            <td><p id="Save_mac_4567216" style="cursor:pointer;font-size:17px;">Save</p>
</td></tr><tr>
                </table>     
            </div> 


            <div id="dialog_3" title="">
                <div id="contentbox3"></div>

            </div>
                        <div id="dialogNo" title="">

                            <table>
                                <td>Do you want to delete this message? <strong><p id="titleId"></p><strong></td>
                                        </tr><tr>    
                                        <td>
                                            <img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiad" style="display:none;"> 
                                            <p id="delete_mac" style="cursor:pointer;">Delete</p></td>       
                                        <td><p id="no_mac" style="cursor:pointer;">No</p></td>
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

                                   


                                        $(".View_Message").click(function () {

                                            $("#gatewayId").val($(this).attr("data-idMessage"));
                                            $("#gateNewMessage").val($(this).attr("data-mainMessage"));
                                            $("#dialog").dialog("open");

                                        });


                                        $(".device_macre").click(function () {

                                            $("#gatewayId").val($(this).attr("data-idMessage"));
                                           // $("#gateNewMessage").val($(this).attr("data-mainMessage"));
                                            $("#dialogNo").dialog("open");

                                        });
                                     

                                        $("#dialog").dialog({
                                            autoOpen: false,
                                            height: 500,
                                            width: 520,
                                            modal: true,
                                        });


                                        $("#dialogNo").dialog({
                                            autoOpen: false,
                                            height: 500,
                                            width: 520,
                                            modal: true,
                                        });

                                      

                                    </script>