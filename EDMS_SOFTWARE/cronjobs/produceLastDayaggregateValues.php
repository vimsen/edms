<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$con = mysqli_connect("localhost", "", "", "");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
} else {

    echo "\n ===Connect to db \n";
}

function storeCron($name, $startdate, $enddate, $con) {

    $query = "select cronName,cronStart,cronEnd from cronJobs.iniCron where date(cronStart)='" . substr($startdate, 0, strpos($startdate, ' ')) . "' and cronName='$name'";

    $result = mysqli_query($con, $query);

    $returnCronName = "";
    $returnCronStart = "";
    $returnCronronEnd = "";

    while ($row = mysqli_fetch_assoc($result)) {

        $returnCronName = $row["cronName"];
        $returnCronronEnd = $row["cronEnd"];
    }

    if ($returnCronName) {

        if (mb_strlen($returnCronronEnd, 'UTF-8') < 1) {
            $sqlUpdate = " update cronJobs.iniCron set cronEnd='$enddate' where date(cronStart)='" . substr($startdate, 0, strpos($startdate, ' ')) . "' and cronName='$name'";

            $result = mysqli_query($con, $sqlUpdate);
        }

        return "on";
    } else {

        $sqlInsert = "INSERT INTO cronJobs.iniCron (cronName,cronStart,cronEnd)
VALUES ( '" . $name . "','" . $startdate . "','')";

        mysqli_query($con, $sqlInsert);

        return "off";
    }
}

function retrieve_data($con, $startdate, $enddate, $mac = null, $interval = null) {

    $startdate = str_replace(" ", "+", $startdate);

    $enddate = str_replace(" ", "+", $enddate);

    $groupby = "";

    $macFlagCon = "";

    if ($mac == "b827ebf9b703") {
        $macFlagCon = "on";
    } elseif ($mac == "14060241CH4ABC") {
        $macFlagCon = "on";
    } elseif ($mac == "14060241CH5ABC") {
        $macFlagCon = "on";
    } elseif ($mac == "14060241CH7B") {
        $macFlagCon = "on";
    } elseif ($mac == "21060028") {
        $macFlagCon = "on";
    } elseif ($mac == "Quadronuovo3ABC1458813213817.27") {
        $macFlagCon = "on";
    } elseif ($mac == "generaleluciesterne2ABC1458813156839.97") {
        $macFlagCon = "on";
    } elseif ($mac == "MD1251ABC1458813130520.72") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH10ABC") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH1ABC") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH8C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH4B") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH2B") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH7B") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH6C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH12A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH7A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH8A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH7C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH9C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH9A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH6A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH4C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH3A") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH3C") {
        $macFlagCon = "on";
    } elseif ($mac == "14060229CH2A") {
        $macFlagCon = "on";
    }



    $production_forecast = array();
    $total_energy_consumptionResult_forecast = "";
    $total_energy_consumption_forecast = array();
    $total_energy_consumption_date_forecast = array();
    $production_batteryPercentage = array();
    $total_energy_consumption = array();
    $total_energy_consumptionResult = array();
    $total_energy_consumption_date = array();

    $pos = strpos($mac, ",");

    if ($mac and $pos === false) {

        $MacAnd = " and mac='" . $mac . "'";

        $groupby = " GROUP BY  ";
    } elseif ($mac and $pos) {

        $pieces_mac = explode(",", $mac);

        $max_pieces = sizeof($pieces_mac);

        $string_mac = "";

        $groupby = "";

        for ($i = 0; $i < $max_pieces; $i++) {

            if ($pieces_mac[$i]) {

                $pieces_mac[$i] = trim($this->db->escape($pieces_mac[$i]));

                $string_mac .="$pieces_mac[$i],";
            }
        }

        $groupby = rtrim($groupby, ",");

        $string_mac = rtrim($string_mac, ",");

        $groupby = " GROUP BY mac, ";

        $MacAnd = " and mac in ( $string_mac )";
    }



    $sql = "SELECT mac,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
            . "FROM VimsentPlatform.mqtt_logs "
            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' "
            . " $groupby time order by time ";


    $sql1 = "SELECT count(mac) as countField,ROUND(sum(payload),2) as sumPayload,mac,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
            . "FROM VimsentPlatform.mqtt_logs "
            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' "
            . " group by time order by time ";


    $sql_2 = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
            . "FROM VimsentPlatform.mqtt_logs "
            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
            . " and topic_c='total_energy_consumption_300' GROUP BY time order by time ";

    $sql_2a = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
            . "FROM VimsentPlatform.mqtt_logs "
            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
            . " and topic_c='total_power' GROUP BY time order by time ";

    $query1 = mysqli_query($con, $sql1);




    while ($row4 = mysqli_fetch_assoc($query1)) {

        $macID = $row4["mac"];
        $production_result_forecast = $row4["sumPayload"] / $row4["countField"];
        $production_result_forecastf = $production_result_forecast * ($interval / 3600 / 1000 );


        if ($interval == 300) {
            $tableSearch = "mqtt_logs_prediction_300";
        } elseif ($interval == 3600) {
            $tableSearch = "mqtt_logs_prediction_3600";
        } elseif ($interval == 60) {
            $tableSearch = "mqtt_logs_prediction_60";
        } elseif ($interval == 86400) {
            $tableSearch = "mqtt_logs_prediction_86400";
        } elseif ($interval == 900) {
            $tableSearch = "mqtt_logs_prediction_900";
        }


        $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . number_format($production_result_forecastf, 2, '.', '') . "','" . str_replace("T", " ", $row4["time"]) . "','" . $mac . "','PV1_production_power','" . $interval . "')"; //$OneDayAhead $interval
        $resultInsert = mysqli_query($con, $sqlInsert);
    }


    $query = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($query)) {


        if ($row["topic_c"] == "PV1_production_battery_percentage") {

            $ReturnValue = $row["payload"] * 10 / 100;
            $ReturnValue = str_replace(",", ".", number_format($ReturnValue, 2, ',', ''));


            if ($interval == 300) {
                $tableSearch = "mqtt_logs_prediction_300";
            } elseif ($interval == 3600) {
                $tableSearch = "mqtt_logs_prediction_3600";
            } elseif ($interval == 60) {
                $tableSearch = "mqtt_logs_prediction_60";
            } elseif ($interval == 86400) {
                $tableSearch = "mqtt_logs_prediction_86400";
            } elseif ($interval == 900) {
                $tableSearch = "mqtt_logs_prediction_900";
            }


            $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . $ReturnValue . "','" . str_replace("T", " ", $row["time"]) . "','" . $mac . "','PV1_production_battery_percentage','" . $interval . "')";
            mysqli_query($con, $sqlInsert);
        }
    }



    $query_3 = mysqli_query($con, $sql_2);



    if ($query_3->num_rows > 1) {

        while ($row_3 = mysqli_fetch_assoc($query_3)) {

            $total_energy_consumption_forecast[] = $row_3["payload"];
            $total_energy_consumption_date_forecast[] = $row_3["time"];
        }
    } else {

        $query_3a = mysqli_query($con, $sql_2a);
        if ($query_3a->num_rows > 1) {
            while ($row_3a = mysqli_fetch_assoc($query_3a)) {

                $total_energy_consumption_forecast[] = $row_3a["payload"];
                $total_energy_consumption_date_forecast[] = $row_3a["time"];
            }
        }
    }


    $maxf = sizeof($total_energy_consumption_forecast);

    for ($ii = 0; $ii < $maxf; $ii++) {

        if (isset($total_energy_consumption_forecast[$ii + 1])) {

            if ($total_energy_consumption_forecast[$ii] > $total_energy_consumption_forecast[$ii + 1] and $total_energy_consumption_forecast[$ii + 1]) {


                if ($interval == 300) {
                    $tableSearch = "mqtt_logs_prediction_300";
                } elseif ($interval == 3600) {
                    $tableSearch = "mqtt_logs_prediction_3600";
                } elseif ($interval == 60) {
                    $tableSearch = "mqtt_logs_prediction_60";
                } elseif ($interval == 86400) {
                    $tableSearch = "mqtt_logs_prediction_86400";
                } elseif ($interval == 900) {
                    $tableSearch = "mqtt_logs_prediction_900";
                }


                if ($macFlagCon) {

                    $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format(($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii + 1]) / 1000, 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                } else {

                    $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii + 1], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                }

                mysqli_query($con, $sqlInsert);
            } else {


                if ($interval == 300) {
                    $tableSearch = "mqtt_logs_prediction_300";
                } elseif ($interval == 3600) {
                    $tableSearch = "mqtt_logs_prediction_3600";
                } elseif ($interval == 60) {
                    $tableSearch = "mqtt_logs_prediction_60";
                } elseif ($interval == 86400) {
                    $tableSearch = "mqtt_logs_prediction_86400";
                } elseif ($interval == 900) {
                    $tableSearch = "mqtt_logs_prediction_900";
                }


                if ($macFlagCon) {


                    $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format(($total_energy_consumption_forecast[$ii + 1] - $total_energy_consumption_forecast[$ii]) / 1000, 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                } else {


                    $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii + 1] - $total_energy_consumption_forecast[$ii], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                }
                mysqli_query($con, $sqlInsert);
            }
        } elseif ($ii + 1 == $maxf) {

            if (isset($total_energy_consumption_forecast[$ii]) and isset($total_energy_consumption_forecast[$ii - 1])) {
                if ($total_energy_consumption_forecast[$ii] > $total_energy_consumption_forecast[$ii - 1]) {


                    if ($interval == 300) {
                        $tableSearch = "mqtt_logs_prediction_300";
                    } elseif ($interval == 3600) {
                        $tableSearch = "mqtt_logs_prediction_3600";
                    } elseif ($interval == 60) {
                        $tableSearch = "mqtt_logs_prediction_60";
                    } elseif ($interval == 86400) {
                        $tableSearch = "mqtt_logs_prediction_86400";
                    } elseif ($interval == 900) {
                        $tableSearch = "mqtt_logs_prediction_900";
                    }



                    if ($macFlagCon) {

                        $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format(($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 1]) / 1000, 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                    } else {

                        $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 1], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                    }


                    mysqli_query($con, $sqlInsert);
                } else {


                    if ($total_energy_consumption_forecast[$ii] > $total_energy_consumption_forecast[$ii - 2]) {

                        if ($interval == 300) {
                            $tableSearch = "mqtt_logs_prediction_300";
                        } elseif ($interval == 3600) {
                            $tableSearch = "mqtt_logs_prediction_3600";
                        } elseif ($interval == 60) {
                            $tableSearch = "mqtt_logs_prediction_60";
                        } elseif ($interval == 86400) {
                            $tableSearch = "mqtt_logs_prediction_86400";
                        } elseif ($interval == 900) {
                            $tableSearch = "mqtt_logs_prediction_900";
                        }



                        if ($macFlagCon) {


                            $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format(($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 2]) / 1000, 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                        } else {

                            $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 2], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                        }




                        mysqli_query($con, $sqlInsert);
                    } else {


                        if ($interval == 300) {
                            $tableSearch = "mqtt_logs_prediction_300";
                        } elseif ($interval == 3600) {
                            $tableSearch = "mqtt_logs_prediction_3600";
                        } elseif ($interval == 60) {
                            $tableSearch = "mqtt_logs_prediction_60";
                        } elseif ($interval == 86400) {
                            $tableSearch = "mqtt_logs_prediction_86400";
                        } elseif ($interval == 900) {
                            $tableSearch = "mqtt_logs_prediction_900";
                        }

                        if ($macFlagCon) {

                            $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format(($total_energy_consumption_forecast[$ii - 2] - $total_energy_consumption_forecast[$ii]) / 1000, 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                        } else {

                            $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii - 2] - $total_energy_consumption_forecast[$ii], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                        }

                        mysqli_query($con, $sqlInsert);
                    }
                }
            } else {


                if ($interval == 300) {
                    $tableSearch = "mqtt_logs_prediction_300";
                } elseif ($interval == 3600) {
                    $tableSearch = "mqtt_logs_prediction_3600";
                } elseif ($interval == 60) {
                    $tableSearch = "mqtt_logs_prediction_60";
                } elseif ($interval == 86400) {
                    $tableSearch = "mqtt_logs_prediction_86400";
                } elseif ($interval == 900) {
                    $tableSearch = "mqtt_logs_prediction_900";
                }

                $sqlInsert = "INSERT INTO VimsentPlatform.$tableSearch (payload,received,mac,topic_c,interval_radios)
VALUES ( '" . str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii], 2, ',', '')) . "','" . str_replace("T", " ", $total_energy_consumption_date_forecast[$ii]) . "','" . $mac . "','total_energy_consumption_300','" . $interval . "')";
                mysqli_query($con, $sqlInsert);
            }
        }
    }

    unset($production_batteryPercentage);
    unset($total_energy_consumption_forecast);
    unset($total_energy_consumption_date);
    unset($total_energy_consumption_forecast);
    unset($total_energy_consumption_date_forecast);
    unset($production_forecast);
}

if (storeCron("produceLastDayaggregateValues", date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $con) == "on") {

    exit("\n script has allready run for date:" . date('Y-m-d') . "!!!! \n");
}



$sql_x = "select distinct mac recordMac from mqtt_logs";


$result_x = mysqli_query($con, $sql_x);

if ($result_x) {

    while ($row_x = mysqli_fetch_assoc($result_x)) {



        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day')); //'2016-09-07'; // $date = '2016-01-10';//$date = '2016-05-10'; // $date = '2016-01-11';
        $date_limit = date('Y-m-d'); //'2016-09-08'; //$date_limit = '2016-05-11';// $date_limit = '2016-05-12';



        $timestamp_limit = strtotime($date_limit);

        while (strtotime($date) <= strtotime(date('Y-m-d'))) {


            if (strtotime($date) < $timestamp_limit) {


                retrieve_data($con, $date . "T00:00:00.000+02:00", date("Y-m-d", strtotime("+1 day", strtotime($date))) . "T00:00:00.000+02:00", $row_x["recordMac"], 900);
                retrieve_data($con, $date . "T00:00:00.000+02:00", date("Y-m-d", strtotime("+1 day", strtotime($date))) . "T00:00:00.000+02:00", $row_x["recordMac"], 3600);
                retrieve_data($con, $date . "T00:00:00.000+02:00", date("Y-m-d", strtotime("+1 day", strtotime($date))) . "T00:00:00.000+02:00", $row_x["recordMac"], 86400);
                retrieve_data($con, $date . "T00:00:00.000+02:00", date("Y-m-d", strtotime("+1 day", strtotime($date))) . "T00:00:00.000+02:00", $row_x["recordMac"], 300);
                retrieve_data($con, $date . "T00:00:00.000+02:00", date("Y-m-d", strtotime("+1 day", strtotime($date))) . "T00:00:00.000+02:00", $row_x["recordMac"], 60);
            }



         
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
        }
    }
}

storeCron("produceLastDayaggregateValues", date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $con);
