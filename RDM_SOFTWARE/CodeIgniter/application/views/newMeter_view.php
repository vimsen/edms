<?php $this->view('part1'); ?>
<div class="row-fluid">

    <div class="span8 widget blue" onTablet="span7" onDesktop="span8">

        <div id="stats-chart2"  style="min-height:282px" >


            <a href="home">Menu</a>
            <a href="viewMeter">View Meters</a>
            <h1>Add New Gateway:</h1>

            <div class="input-field col s6" style="color:white;">
                <input  id="macname" type="text" name="macname" maxlength="50" class="validate">
                <label for="macname" style="color:white;font-size: 14px;">Gateway Name:</label>
            </div>

           
            <br/>

            <div class="input-field col s6" style="color:white;">
                <input id="macserial" type="text" name="macserial" maxlength="50" class="validate">
                <label for="macserial" style="color:white;font-size: 14px;">Gateway Mac Address:</label>
            </div>



            <br/>
            <br/>
           <!-- <img src="<?= base_url() ?>public/img/ajax-loader.gif" id="spiaj" style="display:none;"> -->
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





            <p id="message_print_1" style="display:none;">Your Record just saved successfully</p>
            <p id="message_print_2" style="display:none;">Please try again later</p>  
            <p id="message_print_3" style="display:none;">You haven't selected Gateway name.</p>  
            <p id="message_print_4" style="display:none;">Gateway Name field can't be longer than 50 chars.</p> 
            <p id="Save_mac_45674564" class="waves-effect waves-light btn-large" style="cursor:pointer;font-size:17px;" >Save</p>
        </div>

    </div>


</div>

<?php $this->view('part2'); ?>

<script src="<?= base_url() ?>public/js/jquery.js"></script>
<script src="<?= base_url() ?>public/js/request.js"></script>
<script src="<?= base_url() ?>public/css/materialize/js/materialize.min.js"></script>

<script>

    $("#Save_mac_45674564").click(function () {

        $("#message_print_1").css("display", "none");
        $("#message_print_2").css("display", "none");
        $("#message_print_3").css("display", "none");
        $("#message_print_4").css("display", "none");
        $.ajax({
            type: "POST",
            url: "<? echo site_url('newMeter/saveMac');?>",
            dataType: 'json',
            cache: false,
            data: {
                macname: $.trim($("#macname").val()),
                macserial: $.trim($("#macserial").val())

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
                    $("#macname").val("");
                    $("#macserial").val("");
                } else if (msg.Result == 3) {

                    $("#message_print_3").css("display", "block").delay(5000).fadeOut('slow');

                } else if (msg.Result == 4) {

                    $("#message_print_4").css("display", "block").delay(5000).fadeOut('slow');

                } else {

                    $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');

                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {

                $("#message_print_2").css("display", "none").delay(5000).fadeOut('slow');

            }
        });

    });


</script>
