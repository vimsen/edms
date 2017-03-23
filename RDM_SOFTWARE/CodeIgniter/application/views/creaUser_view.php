
<?php $this->view('part1'); ?>
<link rel="stylesheet" href="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.css">

<style>
    .input-field input[type=text] {
        border-bottom: 1px solid #1B5E20;
        box-shadow: 0 1px 0 0 #1B5E20;
    }

    .input-field input[type=text]:focus {
        border-bottom: 1px solid red;
        box-shadow: 0 1px 0 0 red;
    }


    .input-field input[type=password] {
        border-bottom: 1px solid #1B5E20;
        box-shadow: 0 1px 0 0 #1B5E20;
    }

    .input-field input[type=password]:focus {
        border-bottom: 1px solid red;
        box-shadow: 0 1px 0 0 red;
    }    

</style>
<div class="row-fluid">

    <div class="span8 widget blue" onTablet="span7" onDesktop="span8">

        <div id="stats-chart2"  style="min-height:282px" >

            <h1 style="float:left;">Manage Users</h1>

            <h1 style="float:left;margin-left:15px;cursor:pointer;" id="add_users"> / Add User</h1>
            
            <div id='cle'></div>
            <?php
            $max = sizeof($mid);

            echo "<div id='wrapperb'>";
            if ($max) {

                for ($i = 0; $i < $max; $i++) {

                    echo "<div id='block_$i' style='float:left;'><p class='pMac' data-id='$mid[$i]' data-mac='$usernames[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $usernames[$i] . " / </p>  <p class='device_mac' style='float:left;margin-right:8px;cursor:pointer;'>$timestamp[$i] / </p> <p class='remove_muser' data-id='$mid[$i]' data-ii='$i' data-macnames='$usernames[$i]' style='float:left;margin-right:8px;cursor:pointer;color:#686868;font-weight: bold;'>Remove User / </p>"
                    . ""
                    . " <div class='preloader-wrapper active' id='spiadl_$i' style='display:none;float:right;'>
                <div class='spinner-layer spinner-red-only'>
                    <div class='circle-clipper left'>
                        <div class='circle'></div>
                    </div><div class='gap-patch'>
                        <div class='circle'></div>
                    </div><div class='circle-clipper right'>
                        <div class='circle'></div>
                    </div>
                </div>
            </div></div>"
                    . "<div id='cle'></div>";
                }
            }


            echo "</div>";
            ?>


            <div id="dialog" title="Basic dialog">

                <table>
                    <td>Add New User</td>
                </tr><tr> 

            

                <td>
                    <div class="input-field col s6" style="color:black;">
                        <input  id="Uname12" type="text" name="Uname12" maxlength="50" class="validate">
                        <label for="Uname12" style="color:black;font-size: 14px;">User Name:</label>
                    </div>
                </td></tr><tr>  


                <td>
                    <div class="input-field col s12" style="color:black;">
                        <input  id="Upass12" type="password" name="Upass12" maxlength="50" class="validate">
                        <label for="Upass12" style="color:black;font-size: 14px;">Password:</label>
                    </div>
                </td></tr><tr>        
              

                <td>Type:</td></tr><tr>

                <td>

                    <select name="UserType" id="UserType" style="display:block;">

                        <option >User</option>
                        <option >Admin</option>
                    </select>

                </td></tr><tr>  

                <td>


                    <div class="preloader-wrapper active" id="spiad" style="display:none;">
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


                    <strong><p id="save_user" style="cursor:pointer;">Save User</p></strong></td></tr><tr>


                <td> 
                    <p id="message_print_1" style="display:none;">Your Action Completed successfully</p>
                    <p id="message_print_2" style="display:none;">Please try again Later.</p>     

                </td>

        </table>

    </div>


</div>

</div>

<!-- End .sparkStats -->

</div>


<?php $this->view('part2'); ?>

<script src="<?= base_url() ?>public/js/jquery.js"></script>

<script src="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script src="<?= base_url() ?>public/css/materialize/js/materialize.min.js"></script>


<script>




    $("#dialog").dialog({
        autoOpen: false,
        height: 500,
        width: 520,
        modal: true,
    });


    $("#add_users").click(function () {

        $("#Uname12").val("");
        $("#Upass12").val("");
        $("#dialog").dialog("open");

    });


    $("#save_user").click(function () {





        $.ajax({
            type: "POST",
            url: "<? echo site_url('creaUser/saveMacUser');?>",
            dataType: 'json',
            cache: false,
            data: {
                uname: $.trim($("#Uname12").val()),
                Upass: $.trim($("#Upass12").val()),
                UserType: $.trim($("#UserType").val())

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
                    ;

                    setTimeout(function () {
                        $("#dialog").dialog("close");
                        location.reload();

                    }, 2000);

                } else {
                    $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {

                $("#spiad").css("display", "none");
                $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');

            }
        });
    });



    $("body").on("click", ".remove_muser", function () {

        var rowIm = $(this).attr("data-ii");

        $.ajax({
            type: "POST",
            url: "<? echo site_url('creaUser/delUserD');?>",
            dataType: 'json',
            cache: false,
            data: {
                DDId: $.trim($(this).attr("data-id"))

            },
            beforeSend: function () {

                $("#spiadl_" + rowIm).css("display", "block");

            },
            complete: function () {
                $("#spiadl_" + rowIm).css("display", "none");

            },
            success: function (msg) { //probably this request will return anything, it'll be put in var "data"


                if (msg.Result == 1) {
                    
                    $("#message_print_1").css("display", "block").delay(5000).fadeOut('slow');

                    $("#block_" + rowIm).slideUp();
                    
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

</script>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

