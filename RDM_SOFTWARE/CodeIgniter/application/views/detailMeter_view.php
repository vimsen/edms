
<?php $this->view('part1'); ?>
<div class="row-fluid">

    <div class="span8 widget blue" onTablet="span7" onDesktop="span8">

        <div id="stats-chart2"  style="min-height:282px" >
            <link rel="stylesheet" href="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.css">
            <link rel="stylesheet" href="<?= base_url() ?>public/js/jquery.jqplot/jquery.jqplot.css">

            <div id="imgChart1"></div>
            <h1>Gateway: <?php echo"<p id='pMacn'  data-mac='$MacName'>$MacName</p>"; ?></h1>
            <div id="wrapperb">

                <?php
                echo "<h2>  - Last 10 Minutes resutls of each Topic</h2>";
                ?>
                <br>
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
                <br>
                <select id="DeviceNameListName" style="display:block;color:black;">

                    <?php
                    $max = sizeof($DeviceName);

                    for ($i = 0; $i < $max; $i++) {

                        echo "<option>$DeviceName[$i]</option>";
                    }
                    ?>

                </select>

                <br>
                <div id="chartdiv" ></div>
                <br>
                <?php
                $max2 = sizeof($payload2);
                if ($max2) {
                    echo "<h2> Last 30 measurements. Mac $MacName</h2><br><br>";
                    ?>

                    <?php
                    for ($ii = 0; $ii < $max2; $ii++) {

                        echo "<div>" . $payload2[$ii] . "--" . $topic_c2[$ii] . "--" . $received2[$ii] . "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div id="term_demo"></div>
    </div>


</div>

<?php $this->view('part2'); ?>


<script src="<?= base_url() ?>public/js/jquery.js"></script>

<script src="<?= base_url() ?>public/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jquery.jqplot.min.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jqplot.logAxisRenderer.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jqplot.barRenderer.min.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jqplot.highlighter.min.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jqplot.cursor.min.js"></script>

<script src="<?= base_url() ?>public/js/jquery.jqplot/jqplot.pointLabels.min.js"></script>

<script src="<?= base_url() ?>public/js/export-jqplot-to-png.js"></script>



<script src="<?= base_url() ?>public/js/jquery.mousewheel-min.js"></script>
<script src="<?= base_url() ?>public/js/jquery.terminal.min.js"></script>


<link href="<?= base_url() ?>public/css/jquery.terminal.css" rel="stylesheet"/>

<script type="text/javascript">

    $(document).ready(function () {

      



        var plot1 = $.jqplot('chartdiv', [<?php echo json_encode($linesDraw) ?>], {
            // Give the plot a title.
            title: 'Plot With Options',
            animate: true,
            // You can specify options for all axes on the plot at once with
            // the axesDefaults object.  Here, we're using a canvas renderer
            // to draw the axis label which allows rotated text.
            axesDefaults: {
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            },
            // Likewise, seriesDefaults specifies default options for all
            // series in a plot.  Options specified in seriesDefaults or
            // axesDefaults can be overridden by individual series or
            // axes options.
            // Here we turn on smoothing for the line.
            seriesDefaults: {
                rendererOptions: {
                    smooth: true
                }
            },
            // An axes object holds options for all axes.
            // Allowable axes are xaxis, x2axis, yaxis, y2axis, y3axis, ...
            // Up to 9 y axes are supported.
            axes: {
                // options for each axis are specified in seperate option objects.
                xaxis: {
                    label: "X Axis",
                    // Turn off "padding".  This will allow data point to lie on the
                    // edges of the grid.  Default padding is 1.2 and will keep all
                    // points inside the bounds of the grid.
                    pad: 0,
                    tickOptions: {
                        showGridline: false
                    }
                },
                yaxis: {
                    label: "Y Axis"
                }
            }
        });



        $('#DeviceNameListName').on('change', function () {


            $.ajax({
                type: "POST",
                url: "<? echo site_url('detailMeter/loadTopic');?>",
                dataType: 'json',
                cache: false,
                data: {
                    topiName: $.trim(this.value),
                    macname: $.trim($("#pMacn").attr("data-mac"))

                },
                beforeSend: function () {

                    $("#spiaj").css("display", "block");

                },
                complete: function () {
                    $("#spiaj").css("display", "none");

                },
                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

                   
                    plot1.destroy();
                    var plot2 = $.jqplot('chartdiv', [msg.Result], {
                        // Give the plot a title.
                        title: 'Plot With Options',
                        animate: true,
                        // You can specify options for all axes on the plot at once with
                        // the axesDefaults object.  Here, we're using a canvas renderer
                        // to draw the axis label which allows rotated text.
                        axesDefaults: {
                            labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                        },
                        // Likewise, seriesDefaults specifies default options for all
                        // series in a plot.  Options specified in seriesDefaults or
                        // axesDefaults can be overridden by individual series or
                        // axes options.
                        // Here we turn on smoothing for the line.
                        seriesDefaults: {
                            rendererOptions: {
                                smooth: true
                            }
                        },
                        // An axes object holds options for all axes.
                        // Allowable axes are xaxis, x2axis, yaxis, y2axis, y3axis, ...
                        // Up to 9 y axes are supported.
                        axes: {
                            // options for each axis are specified in seperate option objects.
                            xaxis: {
                                label: "X Axis",
                                // Turn off "padding".  This will allow data point to lie on the
                                // edges of the grid.  Default padding is 1.2 and will keep all
                                // points inside the bounds of the grid.
                                pad: 0,
                                tickOptions: {
                                    showGridline: false
                                }
                            },
                            yaxis: {
                                label: "Y Axis"
                            }
                        }
                    });                    ////////////////////////////////    
                    ////////////////////////////////    

                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                    $("#message_print_2").css("display", "block").delay(5000).fadeOut('slow');

                }
            });

        });




        var imgData = $('#chartdiv').jqplotToImageStr({});
        var imgElem = $('<img/>').attr('src', imgData);
//alert(imgElem);
        $('#imgChart1').append(imgElem);

        var command1 = "";
        $('#term_demo').terminal(function (command, term) {

            if (command.startsWith("ssh")) {
                //startsWith("He")   
                //if (command == 'ssh') {
                //ssh jedi_john@barney.intelen.com   
                command1 = command;
                var history = term.history();
                history.disable();
                term.push(function (command) {

                    $.ajax({
                        type: "POST",
                        url: "<? echo site_url('detailMeter/connectshell');?>",
                        dataType: 'json',
                        cache: false,
                        data: {
                            com_name: $.trim(command),
                            com_name1: $.trim(command1)

                        },
                        beforeSend: function () {

                          

                        },
                        complete: function () {
                         

                        },
                        success: function (data) {

                            term.resume();
                            if (data.error && data.error.message) {
                                term.error(data.error.message);
                            } else {
                                if (typeof data.result == 'boolean') {
                                    term.echo(data.result ? 'success' : 'fail');
                                } else {
                                    var len = data.result.length;
                                    for (var i = 0; i < len; ++i) {
                                        term.echo(data.result[i].join(' | '));
                                    }
                                }
                            }


                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {



                        }
                    });

                   


                }, {
                    prompt: 'type your command '
                });
            }
        });

       

    });



</script>