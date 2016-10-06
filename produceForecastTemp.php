<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$con = mysqli_connect("localhost", "active", "d1@st1m0pl010ntE", "VimsentPlatform");
//service mysql restart
//http://94.70.143.113/~glimperop/vimsen/MQTT_Topic_Tree/index.html
//$con = mysqli_connect("localhost", "active", "root", "qazqaz");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
} else {


    echo "\n ===Connect to db \n";
}

function ClearTable($con) {

    $sql = "TRUNCATE TABLE VimsentPlatform.vimsentForecastTemp";
    $result = mysqli_query($con, $sql);
}

function Days($con, $days, $mac,$dateInsert) {

    $total_energy_consumption_forecast = array();
    $total_energy_consumption_date_forecast = array();
    $total_energy_consumptionResult_forecast = array();
    $production_forecast = array();
    $macID = "";
    $production_result_forecast = "";
    $sqlInsert = "";
    // $week_4ago = strtotime(date("Y-m-d", strtotime(date('Y-m-d') . " -4 week"));
    $week_4ago = strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " -4 week");
    $interval = 900;

    $OneDayAhead = $dateInsert;//date('Y-m-d', strtotime(date('Y-m-d') . "+1 days"));


    $sql_3 = "select topic_c,mac, FROM_UNIXTIME(received) as DateNum,unix_timestamp(curdate()),payload,received,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") * "
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,ROUND(COALESCE(avg(payload),0),2) as payAvg, date_format(DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *" . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s'),'%H:%i:%s') as timeActual FROM VimsentPlatform.mqtt_logs "
            . "where unix_timestamp(received)>$week_4ago and topic_c='total_energy_consumption_300' and weekday(received)=$days  and mac='$mac' group by date_format(time,'%H %i %s') order by timeActual";



    $sql_4 = "select count(payload) as countField,ROUND(sum(payload),2) as sumPayload,topic_c,mac, payload,received,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") * "
            . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time, date_format(DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *" . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s'),'%H:%i:%s') as timeActual FROM VimsentPlatform.mqtt_logs "
            . "where unix_timestamp(received)>$week_4ago and topic_c='PV1_production_power' and weekday(received)=$days  and mac='$mac' group by date_format(time,'%H %i %s') order by timeActual";


    //exit($sql_3);
    
    $query_3 = mysqli_query($con, $sql_3);

    while ($row_3 = mysqli_fetch_assoc($query_3)) {

        $total_energy_consumption_forecast[] = $row_3["payAvg"];
        $total_energy_consumption_date_forecast[] = $row_3["timeActual"];
    }


    $maxf = sizeof($total_energy_consumption_forecast);

    for ($ii = 0; $ii < $maxf; $ii++) {

        if (isset($total_energy_consumption_forecast[$ii + 1])) {

            if ($total_energy_consumption_forecast[$ii] > $total_energy_consumption_forecast[$ii + 1] and $total_energy_consumption_forecast[$ii + 1]) {

                $total_energy_consumptionResult_forecast[$ii] = array($OneDayAhead . "T" . $total_energy_consumption_date_forecast[$ii] . "+02:00" => str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii + 1], 2, ',', '')));
            } else {

                $total_energy_consumptionResult_forecast[$ii] = array($OneDayAhead . "T" . $total_energy_consumption_date_forecast[$ii] . "+02:00" => str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii + 1] - $total_energy_consumption_forecast[$ii], 2, ',', '')));
            }
        } elseif ($ii + 1 == $maxf) {

            if (isset($total_energy_consumption_forecast[$ii]) and isset($total_energy_consumption_forecast[$ii - 1])) {
                if ($total_energy_consumption_forecast[$ii] > $total_energy_consumption_forecast[$ii - 1]) {
                    $total_energy_consumptionResult_forecast[$ii] = array($OneDayAhead . "T" . $total_energy_consumption_date_forecast[$ii] . "+02:00" => str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 1], 2, ',', '')));
                } else {

                    $total_energy_consumptionResult_forecast[$ii] = array($OneDayAhead . "T" . $total_energy_consumption_date_forecast[$ii] => str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii] - $total_energy_consumption_forecast[$ii - 2], 2, ',', '')));
                }
            } else {

                $total_energy_consumptionResult_forecast[$ii] = array($OneDayAhead . "T" . $total_energy_consumption_date_forecast[$ii] . "+02:00" => str_replace(",", ".", number_format($total_energy_consumption_forecast[$ii], 2, ',', '')));
            }
        }
    }


    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////



    $query4 = mysqli_query($con, $sql_4);
    while ($row4 = mysqli_fetch_assoc($query4)) {

        $macID = $row4["mac"];
        $production_result_forecast = $row4["sumPayload"] / $row4["countField"];
        $production_result_forecastf = $production_result_forecast * $interval / 3600;
        $production_forecast[] = array($OneDayAhead . "T" . $row4["timeActual"] . "+02:00" => number_format($production_result_forecastf, 2, '.', ''));
    }



    if (sizeof($total_energy_consumptionResult_forecast)) {
        echo "\n--------------------total_energy_consumptionResult_forecast Loading----------------\n";
        // var_dump($total_energy_consumptionResult_forecast);
        //json_encode($total_energy_consumptionResult_forecast)
        echo "\n--------total_energy_consumptionResult_forecast Loading End------------";

        $sqlInsert = "INSERT INTO VimsentPlatform.vimsentForecastTemp (mac,vimJson,vimDay,forecast,dateInsertCall)
VALUES ('" . $mac . "', '" . serialize($total_energy_consumptionResult_forecast) . "', '" . $days . "','total_energy_consumptionResult_forecast','" . $dateInsert . "')";
        $resultInsert = mysqli_query($con, $sqlInsert);
    }


    if (sizeof($production_forecast)) {
        echo "\n--------------------production_forecast loading---------\n";
        //var_dump($production_forecast);
        //json_encode($production_forecast)

        $sqlInsert = "INSERT INTO VimsentPlatform.vimsentForecastTemp (mac,vimJson,vimDay,forecast,dateInsertCall)
VALUES ('" . $mac . "', '" . serialize($production_forecast) . "', '" . $days . "','production_forecast','" . $dateInsert . "')";
        $resultInsert = mysqli_query($con, $sqlInsert);

        echo "\n--------production_forecast Loading End------------";
    }





    $sqlInsert = "";

    unset($total_energy_consumptionResult_forecast);
    unset($production_forecast);




    // $query4 = mysqli_query($con, $sql_4);
}

echo "\n  -----------||------------  \n";

$dayWeekIndex["Mon"]=0;
$dayWeekIndex["Tue"]=1;
$dayWeekIndex["Wed"]=2;
$dayWeekIndex["Thu"]=3;
$dayWeekIndex["Fri"]=4;
$dayWeekIndex["Sat"]=5;
$dayWeekIndex["Sun"]=6;

$timestamp_limit = 0;
$dateLabel = "";
$timestamp_todays = strtotime(date('Y-m-d'));

$sql_canirun ="select dateInsertCall from vimsentForecastTemp order by dateInsertCall desc limit 1";

$result_canirun = mysqli_query($con, $sql_canirun);

if ($result_canirun) {
    
  while ($row_canirun = mysqli_fetch_assoc($result_canirun)) {
      
      
   // echo  $row_x["dateInsertCall"];
   // $row_x["dateInsertCall"];
      $timestamp_limit = strtotime($row_canirun["dateInsertCall"]);
    
     // echo $timestamp_limit;
      $dateLabel = $row_canirun["dateInsertCall"];
      
  }  
    
    
}

echo " \n --$timestamp_limit -- $timestamp_todays  \n ";

if($timestamp_limit< $timestamp_todays){


$sql_x = "select distinct mac recordMac from mqtt_logs";

$result_x = mysqli_query($con, $sql_x);

if ($result_x) {

    //ClearTable($con);

    while ($row_x = mysqli_fetch_assoc($result_x)) {

        echo $row_x["recordMac"] . "\n";
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+0 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+0 days"))." \n";   
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+1 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+1 days"))." \n";   
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+2 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+2 days"))." \n";       
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+3 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+3 days"))." \n";
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+4 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+4 days"))." \n";       
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+5 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+5 days"))." \n";     
        
        echo $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+6 days"))];
        echo " ".date('Y-m-d', strtotime(date('Y-m-d') . "+6 days"))." \n";       
        
        
        
        
        /*
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+0 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+0 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+1 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+1 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+2 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+2 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+3 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+3 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+4 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+4 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+5 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+5 days")));
        Days($con, $dayWeekIndex[date('D', strtotime(date('Y-m-d') . "+6 days"))], $row_x["recordMac"],date('Y-m-d', strtotime(date('Y-m-d') . "+6 days")));
       */ 
    }
}

}else{
    
    echo " \n ---   The process will run after $dateLabel   --- \n";
    
}

mysqli_close($con);
