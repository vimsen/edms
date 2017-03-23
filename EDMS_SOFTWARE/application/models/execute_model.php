<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of execute_model
 *
 * @author hulk
 */
class execute_model extends CI_Model {

    //put your code here
     
      function alarm_exit($pointer, $startDate, $endDate, $mac, $interval) {

        if (mb_strlen($pointer, 'UTF-8') > 5) {// 
            exit("Pointer Lenght too long");
        }


        if (mb_strlen($startDate, 'UTF-8') > 30) {// 
            exit("Start Date Lenght too long");
        }


        if (mb_strlen($endDate, 'UTF-8') > 30) {// 
            exit("End Date Lenght too long");
        }

        if (mb_strlen($mac, 'UTF-8') > 90) {// 
            exit("Prosumers Lenght too long");
        }

        if (mb_strlen($interval, 'UTF-8') > 30) {// 
            exit("Interval Lenght too long");
        }

        if (mb_strlen($interval, 'UTF-8') > 1) {// 
            if (ctype_digit($interval) && (int) $interval > 0) {
                
            } else {

                exit("Interval is not a number");
            }
        }
    }


    function block_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $testFlag = null, $consumptionFlag = null) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag, $consumptionFlag);
            } elseif ($interval == 60) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag, $consumptionFlag);
            } elseif ($group < 1) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, 900, $pointer, $testFlag, $consumptionFlag);
            } else {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag, $consumptionFlag);
            }
        } else {

            $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, "", "", "", $consumptionFlag);
        }
    }

    function block_data_past($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $testFlag = null) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag);
            } elseif ($interval == 60) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag);
            } elseif ($group < 1) {


                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, 900, $pointer, $testFlag);
            } else {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $testFlag);
            }
        } else {

            $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, "", "", $testFlag);
        }
    }

    function block_data_mainsource_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $consumptionFlag = null) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $consumptionFlag);
            } elseif ($interval == 60) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($group < 1) {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, 900, $pointer, $consumptionFlag);
            } else {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $consumptionFlag);
            }
        } else {

            $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, "", "", $consumptionFlag);
        }
    }

    function retrieve_data_join_past_present($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null, $consumptionFlag = null) {
        ini_set('memory_limit', '1000M');

        $startdate = str_replace(" ", "+", $startdate);
        $enddate = str_replace(" ", "+", $enddate);
        $pieces_timestamp = explode("T", $startdate);
        $pieces_timestampend = explode("T", $enddate);
        $week_4ago = strtotime(date("Y-m-d", strtotime($pieces_timestamp[0])) . " -4 week");
        $OneDayAhead = date('Y-m-d', strtotime($pieces_timestampend[0] . "+1 days"));
        $datetime = DateTime::createFromFormat('Ymd', str_replace("-", "", $pieces_timestamp[0]));
        $switch_date = 0;

        if ($datetime->format('D') == "Mon") {
            $switch_date = 0;
        } elseif ($datetime->format('D') == "Tue") {
            $switch_date = 1;
        } elseif ($datetime->format('D') == "Wed") {
            $switch_date = 2;
        } elseif ($datetime->format('D') == "Thu") {
            $switch_date = 3;
        } elseif ($datetime->format('D') == "Fri") {
            $switch_date = 4;
        } elseif ($datetime->format('D') == "Sat") {
            $switch_date = 5;
        } elseif ($datetime->format('D') == "Sun") {
            $switch_date = 6;
        }

        $switch_date2 = 0;
        $datetime2 = DateTime::createFromFormat('Ymd', str_replace("-", "", $pieces_timestampend[0]));

        if ($datetime2->format('D') == "Mon") {
            $switch_date2 = 0;
        } elseif ($datetime2->format('D') == "Tue") {
            $switch_date2 = 1;
        } elseif ($datetime2->format('D') == "Wed") {
            $switch_date2 = 2;
        } elseif ($datetime2->format('D') == "Thu") {
            $switch_date2 = 3;
        } elseif ($datetime2->format('D') == "Fri") {
            $switch_date2 = 4;
        } elseif ($datetime2->format('D') == "Sat") {
            $switch_date2 = 5;
        } elseif ($datetime2->format('D') == "Sun") {
            $switch_date2 = 6;
        }


        $MacAnd = "";
        $forcast = array();
        $main_data = array();
        $production = array();
        $production_forecast = array();
        $total_energy_consumptionResult_forecast = "";
        $total_energy_consumption_forecast = array();
        $total_energy_consumption_date_forecast = array();
        $production_batteryPercentage = array();
        $total_energy_consumption = array();
        $total_energy_consumptionResult = array();
        $total_energy_consumption_date = array();
        $production_result = 0;
        $production_resultf = 0;
        $production_resultFinal = 0;
        $macID = "";
        $production_forecast = "";
        $pos = strpos($mac, ",");


        if ($mac == "b827ebf9b703") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH4ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH5ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH7B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "21060028") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "Quadronuovo3ABC1458813213817.27") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "generaleluciesterne2ABC1458813156839.97") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "MD1251ABC1458813130520.72") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH10ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH1ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH8C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH4B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH2B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH6C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH12A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH8A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH9C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH9A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH6A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH4C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH3A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH3C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH2A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        }


        if ($mac and $pos === false) {

            $MacAnd = " and mac=" . $this->db->escape($mac) . "";

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


        if ($total == 1) {

            $sql = "SELECT mac,sum(payload),unix_timestamp(received) as timestampD,received,payload FROM VimsentPlatform.mqtt_logs"
                    . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                    . " GROUP BY date(received) order by unix_timestamp(received) desc";




            $query = $this->db->query($sql);

            foreach ($query->result() as $row) {

                $main_data[] = array('Mac' => $row->mac, 'Date' => strstr($row->received, ' ', true), 'Kwh' => $row->payload);
            }
        } elseif ($interval) {

            if ($pointer == 1) {

                $sql = "SELECT mac,COALESCE(sum(payload),0) as data,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . " $groupby topic_c order by time asc";






                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->data, 'Kwh_roundUp' => $row->roundUP, 'Topic' => $pieces[3]);
                }
            } elseif ($pointer == 2) {

                if ($interval == 900) {

                    $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_900 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' and interval_radios='900' "
                            . "  order by received ";


                    $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_900 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' and interval_radios='900' "
                            . "  order by received ";


                    $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_900 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_energy_consumption_300' and interval_radios='900' "
                            . "  order by received ";


                    $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_900 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_power' and interval_radios='900' "
                            . "  order by received ";

                    $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_900 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='meter1_power' and interval_radios='900' "
                            . "  order by received ";
                } elseif ($interval == 3600) {


                    $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_3600 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' and interval_radios='3600' "
                            . "  order by received ";


                    $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_3600 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' and interval_radios='3600' "
                            . "  order by received ";

                    $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_3600 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_energy_consumption_300' and interval_radios='3600' "
                            . "  order by received ";


                    $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_3600 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_power' and interval_radios='3600' "
                            . "  order by received ";


                    $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_3600 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='meter1_power' and interval_radios='3600' "
                            . "  order by received ";
                } elseif ($interval == 86400) {

                    $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_86400 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' and interval_radios='86400' "
                            . "  group by received order by received ";


                    $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_86400 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' and interval_radios='86400' "
                            . "  group by received order by received ";

                    $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_86400 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_energy_consumption_300' and interval_radios='86400' "
                            . "  group by received order by received ";


                    $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_86400 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_power' and interval_radios='86400' "
                            . "  group by received order by received ";


                    $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_86400 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='meter1_power' and interval_radios='86400' "
                            . "  group by received order by received ";
                } elseif ($interval == 300) {

                    $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_300 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' and interval_radios='300' "
                            . "  order by received ";


                    $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_300 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' and interval_radios='300' "
                            . "  order by received ";


                    $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_300 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_energy_consumption_300' and interval_radios='300' "
                            . "  order by received ";


                    $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_300 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_power' and interval_radios='300' "
                            . "  order by received ";

                    $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_300 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='meter1_power' and interval_radios='300' "
                            . "  order by received ";
                } elseif ($interval == 60) {

                    $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_60 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' and interval_radios='60' "
                            . "  order by received ";


                    $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_60 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' and interval_radios='60' "
                            . "  order by received ";


                    $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_60 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_energy_consumption_300' and interval_radios='60' "
                            . "  order by received ";


                    $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_60 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='total_power' and interval_radios='60' "
                            . "  order by received ";


                    $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received,mac,topic_c "
                            . "FROM VimsentPlatform.mqtt_logs_prediction_60 "
                            . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='meter1_power' and interval_radios='60' "
                            . "  order by received ";
                }

                $sql_present = "SELECT mac,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' "
                        . " $groupby time order by time ";



                $sql1_present = "SELECT count(mac) as countField,ROUND(sum(payload),2) as sumPayload,mac,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' "
                        . "  group by time order by time ";


                $sql_2_present = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='total_energy_consumption_300' GROUP BY time order by time ";

                $sql_2a_present = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='total_power' GROUP BY time order by time ";


                $sql_3a_present = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='meter1_power' GROUP BY time order by time ";



                $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));


                $sql5 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql6 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";




                $sql7 = "select * from VimsentPlatform.reliability_flexibility where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`date`) < " . strtotime($enddate) . "";


                $flexibility = [];
                $reliability = [];


                $query7 = $this->db->query($sql7);

                foreach ($query7->result() as $row7) {


                    if ($row7->flexibility) {
                        $flexibility[] = array(str_replace(" ", "T", $row7->date) . '.000+02:00' => substr($row7->flexibility, 0, 4));
                    }

                    if ($row7->reliability) {
                        $reliability[] = array(str_replace(" ", "T", $row7->date) . '.000+02:00' => substr($row7->reliability, 0, 4));
                    }
                }


                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    if ($row->topic_c == "PV1_production_battery_percentage") {

                        $production_batteryPercentage[] = array(str_replace(" ", "T", $row->received) . '.000+02:00' => $row->payload);
                    }
                }

                $query_present = $this->db->query($sql_present);

                foreach ($query_present->result() as $row_present) {



                    if ($row_present->topic_c == "PV1_production_battery_percentage") {

                        $ReturnValue = $row_present->payload * 10 / 100;
                        $ReturnValue = str_replace(",", ".", number_format($ReturnValue, 2, ',', ''));
                        $production_batteryPercentage[] = array($row_present->time . '.000+02:00' => $ReturnValue);
                    }
                }



                $query1 = $this->db->query($sql1);

                foreach ($query1->result() as $row1) {

                    if ($row1->topic_c == "PV1_production_power") {
                        $macID = $row1->mac;
                        $production[] = array(str_replace(" ", "T", $row1->received) . '.000+02:00' => $row1->payload);
                    }
                }



                $query1_present = $this->db->query($sql1_present);

                foreach ($query1_present->result() as $row1_present) {

                    if ($row1_present->topic_c == "PV1_production_power") {

                        $macID = $row1_present->mac;
                        $production_result = $row1_present->sumPayload / $row1_present->countField;
                        $production_resultf = $production_result * ($interval / 3600 / 1000);
                        $production[] = array($row1_present->time . '.000+02:00' => number_format($production_resultf, 2, '.', ''));
                    }
                }


                $query3 = $this->db->query($sql3);
                if ($query3->num_rows() > 1) {

                    foreach ($query3->result() as $row3) {

                        $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row3->received) . '.000+02:00' => $row3->payload);
                    }
                } else {

                    $query4 = $this->db->query($sql4);

                    if ($query4->num_rows() > 1) {

                        foreach ($query4->result() as $row4) {

                            $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row4->received) . '.000+02:00' => $row4->payload);
                        }
                    }
                }


                $query_2_present = $this->db->query($sql_2_present);
                $query_3_present = $this->db->query($sql_3a_present);


                if ($query_2_present->num_rows() > 1) {

                    foreach ($query_2_present->result() as $row_2_present) {

                        $macID = $row_2_present->mac;
                        $total_energy_consumption[] = $row_2_present->payload;
                        $total_energy_consumption_date[] = $row_2_present->time;
                    }
                } elseif ($query_3_present->num_rows() > 1) {


                    foreach ($query_3_present->result() as $row_3_present) {

                        $macID = $row_3_present->mac;
                        $total_energy_consumption[] = $row_3_present->payload;
                        $total_energy_consumption_date[] = $row_3_present->time;
                    }
                } else {

                    $query_2a_present = $this->db->query($sql_2a_present);
                    if ($query_2a_present->num_rows() > 1) {
                        foreach ($query_2a_present->result() as $row_2a_present) {
                            $macID = $row_2a_present->mac;
                            $total_energy_consumption[] = $row_2a_present->payload;
                            $total_energy_consumption_date[] = $row_2a_present->time;
                        }
                    }
                }


                $max = sizeof($total_energy_consumption);
                $addCounter = 0;
                if (sizeof($total_energy_consumptionResult)) {
                    $addCounter = sizeof($total_energy_consumptionResult);
                }


                for ($i = 0; $i < $max; $i++) {
                    // echo "<br>--$i--$max||--".$total_energy_consumption_date[$i]."---".$total_energy_consumption[$i] ." - ".$total_energy_consumption[$i+1];
                    if (isset($total_energy_consumption[$i + 1])) {

                        if ($total_energy_consumption[$i] > $total_energy_consumption[$i + 1]) {

                            if ($consumptionFlag == "on") {

                                $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i] - $total_energy_consumption[$i + 1]) / 1000, 2, ',', '')));
                            } else {


                                //str_replace(",",".",number_format($production_resultf, 2, ',', '')) 
                                $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i + 1], 2, ',', '')));
                            }
                        } else {


                            if ($consumptionFlag == "on") {

                                $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i + 1] - $total_energy_consumption[$i]) / 1000, 2, ',', '')));
                            } else {



                                $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i + 1] - $total_energy_consumption[$i], 2, ',', '')));
                            }
                        }


                        $flag = $total_energy_consumption[$i] - $total_energy_consumption[$i + 1];
                    } elseif ($i + 1 == $max) {

                        if (sizeof($total_energy_consumption) > 1) {
                            if ($total_energy_consumption[$i] > $total_energy_consumption[$i - 1]) {

                                if ($consumptionFlag == "on") {

                                    $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i] - $total_energy_consumption[$i - 1]) / 1000, 2, ',', '')));
                                } else {


                                    $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i - 1], 2, ',', '')));
                                }
                            } else {


                                if ($consumptionFlag == "on") {

                                    $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i - 1] - $total_energy_consumption[$i]) / 1000, 2, ',', '')));
                                } else {


                                    $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i - 1] - $total_energy_consumption[$i], 2, ',', '')));
                                }
                            }
                        } else {

                            $total_energy_consumptionResult[$i + $addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i], 2, ',', '')));
                        }
                    }
                }


                $query5 = $this->db->query($sql5);

                foreach ($query5->result() as $row5) {

                    $total_energy_consumptionResult_forecast = unserialize($row5->total_energy_consumptionResult); //str_replace('\\"', '', $row_3->total_energy_consumptionResult);
                }


                $query6 = $this->db->query($sql6);

                foreach ($query6->result() as $row6) {

                    $production_forecast = unserialize($row6->production_forecast); //str_replace('\\"', '', $row4->production_forecast);   
                }



                $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
                $this->apiCallUpate("getdataVGW_get", "end");
                exit(json_encode($main_data));
            } elseif ($pointer == 3) {

                $sql = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . "  order by time asc";


                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->payload, 'Topic' => $pieces[3]);
                }
            } else {


                $sql = "SELECT mac,COALESCE(sum(payload),0) as data,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . " $groupby topic_c order by time asc";



                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->data, 'Kwh_roundUp' => $row->roundUP, 'Topic' => $pieces[3]);
                }
            }
        } else {


            $sql = "SELECT mac,payload,unix_timestamp(received) as timestampD,received,payload,topic FROM VimsentPlatform.mqtt_logs"
                    . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                    . " order by unix_timestamp(received) desc";


            $query = $this->db->query($sql);

            foreach ($query->result() as $row) {

                $pieces = explode("/", $row->topic);

                $main_data[] = array('Mac' => $row->mac, 'Date' => $row->received, 'Kwh' => $row->payload, 'Topic' => $pieces[3]);
            }
        }
        echo json_encode($main_data);
    }

    function retrieve_dataHistory($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null, $testFlag = null) {


        $time_zoneSearch = explode(" ", $startdate);
        $time_zoneSearchEnd = explode(" ", $enddate);

        if (strpos($time_zoneSearch[0], '.') !== false) {

            $searchTimestampstartDate = getdate(strtotime(str_replace(" ", "+", $startdate)))[0];


            $searchTimestampstartDate_noEnc = substr($time_zoneSearch[0], 0, strpos($time_zoneSearch[0], "."));
        } else {
            $searchTimestampstartDate = getdate(strtotime(str_replace(" ", "+", $startdate)))[0];

            $searchTimestampstartDate_noEnc = $time_zoneSearch[0];
        }

        if (strpos($time_zoneSearch[0], '.') !== false) {
            $searchTimestampendDate = getdate(strtotime(str_replace(" ", "+", $enddate)))[0];

            $searchTimestampendDate_noEnc = substr($time_zoneSearchEnd[0], 0, strpos($time_zoneSearchEnd[0], "."));
        } else {
            $searchTimestampendDate = getdate(strtotime(str_replace(" ", "+", $enddate)))[0];

            $searchTimestampendDate_noEnc = $time_zoneSearchEnd[0];
        }



        if (array_key_exists(1, $time_zoneSearch)) {
            if (strlen($time_zoneSearch[1]) < 2) {
                $time_zoneSearch[1] = "00:00";
            }
        } else {
            $time_zoneSearch[1] = "00:00";
        }


        $startdate = str_replace(" ", "+", $startdate);

        $enddate = str_replace(" ", "+", $enddate);

        $pos = strpos($mac, ",");

        $production = array();

        $production_batteryPercentage = array();

        $total_energy_consumptionResult_forecast = array();

        $production_forecast = array();

        $total_energy_consumptionResult = array();

        $macID = "";

        $production_result = 0;

        $production_resultf = 0;

        $macLookFor = "";

        $switch_date2 = 0;
        $pieces_timestampend = explode("T", $enddate);

        $datetime2 = DateTime::createFromFormat('Ymd', str_replace("-", "", $pieces_timestampend[0]));
        $OneDayAhead = date('Y-m-d', strtotime($pieces_timestampend[0] . "+1 days"));

        if ($datetime2->format('D') == "Mon") {
            $switch_date2 = 0;
        } elseif ($datetime2->format('D') == "Tue") {
            $switch_date2 = 1;
        } elseif ($datetime2->format('D') == "Wed") {
            $switch_date2 = 2;
        } elseif ($datetime2->format('D') == "Thu") {
            $switch_date2 = 3;
        } elseif ($datetime2->format('D') == "Fri") {
            $switch_date2 = 4;
        } elseif ($datetime2->format('D') == "Sat") {
            $switch_date2 = 5;
        } elseif ($datetime2->format('D') == "Sun") {
            $switch_date2 = 6;
        }


        if ($mac and $pos === false) {

            $macLookFor = trim(strip_tags($mac));

            $MacAnd = " and mac=" . $this->db->escape($mac) . "";

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

        if ($pointer == 2) {

            $storage = [];

            $this->db->query("SET time_zone='+00:00';");
            date_default_timezone_set('UTC');


            if ($this->getHednoData($macLookFor) == 1) {


                $mqtt_logs_prediction_3600 = "mqtt_logs_prediction_3600_history";
                $mqtt_logs_prediction_86400 = "mqtt_logs_prediction_86400_history";
                $mqtt_logs_prediction_300 = "mqtt_logs_prediction_300_history";
                $mqtt_logs_prediction_60 = "mqtt_logs_prediction_60";

                if ($interval == 3600) {

                    $mqtt_logs_prediction_900 = "mqtt_logs_hedno2_hourly";
                    $mqtt_logs_prediction_3600 = "mqtt_logs_hedno2_hourly";
                    $sql7 = "select mac,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility_3600 where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } elseif ($interval == 86400) {

                    $mqtt_logs_prediction_900 = "mqtt_logs_hedno2_daily";
                    $mqtt_logs_prediction_86400 = "mqtt_logs_hedno2_daily";
                    $sql7 = "select mac,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility_86400 where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } else {


                    $mqtt_logs_prediction_900 = "mqtt_logs_hedno2";
                    $sql7 = "select mac,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                }


                $sql8 = "";

                if ($interval == 900) {


                    $pieces_startdate = explode("+", $startdate);
                    $time = date('H:i', strtotime($pieces_startdate[1] . '+1 hour'));
                    $startdatestorage = $pieces_startdate[0] . "+" . $time;

                    $pieces_enddate = explode("+", $enddate);
                    $time = date('H:i', strtotime($pieces_enddate[1] . '+1 hour'));
                    $enddatestorage = $pieces_enddate[0] . "+" . $time;

                    $sql8 = "select mac,storage,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.storage where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                    $query8 = $this->db->query($sql8);
                }

                if (mb_strlen($sql8, 'UTF-8') > 2) {




                    foreach ($query8->result() as $row8) {


                        if ($row8->storage) {
                            $production_batteryPercentage[] = array(str_replace(" ", "T", $row8->date) . '.000+' . $time_zoneSearch[1] . '' => $row8->storage);
                        }
                    }
                }


                $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("{$enddate} + 1 day"));
                if ($interval == 900) {

                    $sqlf = "select * from VimsentPlatform.forecastingQuarter where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } elseif ($interval == 3600) {

                    $sqlf = "select * from VimsentPlatform.forecastingHourly where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } elseif ($interval == 86400) {

                    $sqlf = "select * from VimsentPlatform.forecastingDaily where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } elseif ($interval == 900) {

                    $sqlf = "select * from VimsentPlatform.forecastingQuarter where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } else {

                    $sqlf = "";
                }


                $query_f = $this->db->query($sqlf);
                foreach ($query_f->result() as $row_f) {

                    $total_energy_consumptionResult_forecast[] = array(str_replace(" ", "T", $row_f->timestamp) . '.000+' . $time_zoneSearch[1] . '' => $row_f->consumption);

                    $production_forecast[] = array(str_replace(" ", "T", $row_f->timestamp) . '.000+' . $time_zoneSearch[1] . '' => $row_f->production);
                }



                $pieces_startdate = explode("+", $startdate);
                $time = date('H:i', strtotime($pieces_startdate[1] . '+1 hour'));
                $startdate = $pieces_startdate[0] . "+" . $time;


                $pieces_enddate = explode("+", $enddate);
                $time = date('H:i', strtotime($pieces_enddate[1] . '+1 hour'));
                $enddate = $pieces_enddate[0] . "+" . $time;
            } elseif ($this->getHednoData2($macLookFor) == 1) {

                $mqtt_logs_prediction_900 = "mqtt_logs_hedno"; //"mqtt_logs_hedno";
                $mqtt_logs_prediction_3600 = "mqtt_logs_prediction_3600_history";
                $mqtt_logs_prediction_86400 = "mqtt_logs_prediction_86400_history";
                $mqtt_logs_prediction_300 = "mqtt_logs_prediction_300_history";
                $mqtt_logs_prediction_60 = "mqtt_logs_prediction_60";




                if ($interval == 3600) {

                    $sql7 = "select mac,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility_3600 where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } elseif ($interval == 86400) {

                    $sql7 = "select mac,date,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility_86400 where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } elseif ($interval == 900) {

                    $sql7 = "select mac,date,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } else {

                    $sql7 = "";
                }

                $sql8 = "";
                if ($interval == 900) {

                    $pieces_startdate = explode("+", $startdate);
                    $time = date('H:i', strtotime($pieces_startdate[1] . '+1 hour'));
                    $startdatestorage = $pieces_startdate[0] . "+" . $time;


                    $pieces_enddate = explode("+", $enddate);
                    $time = date('H:i', strtotime($pieces_enddate[1] . '+1 hour'));
                    $enddatestorage = $pieces_enddate[0] . "+" . $time;


                    $sql8 = "select mac,storage,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.storage where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";

                    $query8 = $this->db->query($sql8);
                }

                if (mb_strlen($sql8, 'UTF-8') > 2) {
                    foreach ($query8->result() as $row8) {


                        if ($row8->storage) {
                            $production_batteryPercentage[] = array(str_replace(" ", "T", $row8->date) . '.000+' . $time_zoneSearch[1] . '' => $row8->storage);
                        }
                    }
                }

                $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }
                $tomorrowDay = date("Y-m-d", strtotime("{$enddate} + 1 day"));

                if ($interval == 900) {

                    $sqlf = "select * from VimsentPlatform.forecastingQuarter where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } elseif ($interval == 3600) {

                    $sqlf = "select * from VimsentPlatform.forecastingHourly where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } elseif ($interval == 86400) {

                    $sqlf = "select * from VimsentPlatform.forecastingDaily where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                } else {

                    $sqlf = "select * from VimsentPlatform.forecastingQuarter where mac='$mac' and date(timestamp)= '$tomorrowDay'";
                }


                $query_f = $this->db->query($sqlf);

                foreach ($query_f->result() as $row_f) {

                    $total_energy_consumptionResult_forecast[] = array(str_replace(" ", "T", $row_f->timestamp) . '.000+' . $time_zoneSearch[1] . '' => $row_f->consumption);

                    $production_forecast[] = array(str_replace(" ", "T", $row_f->timestamp) . '.000+' . $time_zoneSearch[1] . '' => $row_f->production);
                }


                $pieces_startdate = explode("+", $startdate);
                $time = date('H:i', strtotime($pieces_startdate[1] . '+1 hour'));
                $startdate = $pieces_startdate[0] . "+" . $time;


                $pieces_enddate = explode("+", $enddate);
                $time = date('H:i', strtotime($pieces_enddate[1] . '+1 hour'));
                $enddate = $pieces_enddate[0] . "+" . $time;
            } else {

                $mqtt_logs_prediction_900 = "mqtt_logs_prediction_900";
                $mqtt_logs_prediction_3600 = "mqtt_logs_prediction_3600";
                $mqtt_logs_prediction_86400 = "mqtt_logs_prediction_86400";
                $mqtt_logs_prediction_300 = "mqtt_logs_prediction_300";
                $mqtt_logs_prediction_60 = "mqtt_logs_prediction_60";


                if ($interval == 900) {

                    $sql7 = "select mac,date,flexibility,reliability,CONVERT_TZ( date, 'UTC', '+$time_zoneSearch[1]' ) as date from VimsentPlatform.reliability_flexibility where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`date`) < " . $searchTimestampendDate . "";
                } else {
                    $sql7 = "";
                }

                $forcastindex = 0;

                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));

                $sql5 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql6 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";

                $query5 = $this->db->query($sql5);

                foreach ($query5->result() as $row5) {

                    $total_energy_consumptionResult_forecast = unserialize($row5->total_energy_consumptionResult);
                }


                $query6 = $this->db->query($sql6);

                foreach ($query6->result() as $row6) {

                    $production_forecast = unserialize($row6->production_forecast);
                }
            }

//exit($mqtt_logs_prediction_900);
            if ($interval == 900) {


                $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_900 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_battery_percentage'  "
                        . "  order by received ";


                $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_900 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_power'  "
                        . "  order by received ";


                $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_900 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_energy_consumption_300'  "
                        . "  order by received ";


                $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_900 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_power'  "
                        . "  order by received ";

                $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /900) *900,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_900 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='meter1_power'  "
                        . "  order by received ";
            } elseif ($interval == 3600) {




                $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_3600 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_battery_percentage'  "
                        . "  order by received ";


                $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_3600 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_power'  "
                        . "  order by received ";

                $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_3600 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_energy_consumption_300'  "
                        . "  order by received ";


                $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_3600 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_power'  "
                        . "  order by received ";

                $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /3600) *3600,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_3600 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='meter1_power'  "
                        . "  order by received ";
            } elseif ($interval == 86400) {

                $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_86400 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_battery_percentage'  "
                        . "  group by received order by received ";

                $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_86400 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_power'  "
                        . "  group by received order by received ";

                $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_86400 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_energy_consumption_300'  "
                        . "  group by received order by received ";

                $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_86400 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_power'  "
                        . "  group by received order by received ";

                $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /86400) *86400,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_86400 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='meter1_power'  "
                        . "  group by received order by received ";
            } elseif ($interval == 300) {


                $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_300 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_battery_percentage'  "
                        . "  order by received ";


                $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_300 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_power'  "
                        . "  order by received ";


                $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_300 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_energy_consumption_300'  "
                        . "  order by received ";


                $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_300 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_power'  "
                        . "  order by received ";


                $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /300) *300,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_300 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='meter1_power'  "
                        . "  order by received ";
            } elseif ($interval == 60) {



                $sql = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_60 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_battery_percentage'  "
                        . "  order by received ";


                $sql1 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_60 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='PV1_production_power'  "
                        . "  order by received ";


                $sql3 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_60 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_energy_consumption_300'  "
                        . "  order by received ";


                $sql4 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_60 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='total_power'  "
                        . "  order by received ";


                $sql5 = "SELECT payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /60) *60,'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as received2,mac,topic_c,CONVERT_TZ( received, 'UTC', '+$time_zoneSearch[1]' ) as received "
                        . "FROM VimsentPlatform.$mqtt_logs_prediction_60 "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . $searchTimestampstartDate . " and UNIX_TIMESTAMP(`received`) < " . $searchTimestampendDate . " $MacAnd and topic_c='meter1_power'  "
                        . "  order by received ";
            }

            if (isset($testFlag)) {
                
            }

            $flexibility = [];
            $reliability = [];

            if (mb_strlen($sql7, 'UTF-8') > 2) {
                $query7 = $this->db->query($sql7);

                foreach ($query7->result() as $row7) {


                    if ($row7->flexibility) {
                        $flexibility[] = array(str_replace(" ", "T", $row7->date) . '.000+' . $time_zoneSearch[1] . '' => substr($row7->flexibility, 0, 4));
                    }

                    if ($row7->reliability) {
                        $reliability[] = array(str_replace(" ", "T", $row7->date) . '.000+' . $time_zoneSearch[1] . '' => substr($row7->reliability, 0, 4));
                    }
                }
            }



            $query = $this->db->query($sql);

            foreach ($query->result() as $row) {

                if ($row->topic_c == "PV1_production_battery_percentage") {
                    $macID = $row->mac;
                    $production_batteryPercentage[] = array(str_replace(" ", "T", $row->received) . '.000+' . $time_zoneSearch[1] . '' => $row->payload);
                }
            }


            $query1 = $this->db->query($sql1);

            foreach ($query1->result() as $row1) {

                if ($row1->topic_c == "PV1_production_power") {
                    $macID = $row1->mac;
                    $production[] = array(str_replace(" ", "T", $row1->received) . '.000+' . $time_zoneSearch[1] . '' => $row1->payload);
                }
            }


            $query3 = $this->db->query($sql3);

            $query5 = $this->db->query($sql5);


            if ($query3->num_rows() > 1) {

                foreach ($query3->result() as $row3) {
                    $macID = $row3->mac;
                    $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row3->received) . '.000+' . $time_zoneSearch[1] . '' => $row3->payload);
                }
            } elseif ($query5->num_rows() > 1) {


                foreach ($query5->result() as $row5) {
                    $macID = $row5->mac;
                    $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row5->received) . '.000+' . $time_zoneSearch[1] . '' => $row5->payload);
                }
            } else {

                $query4 = $this->db->query($sql4);

                if ($query4->num_rows() > 1) {

                    foreach ($query4->result() as $row4) {
                        $macID = $row4->mac;
                        $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row4->received) . '.000+' . $time_zoneSearch[1] . '' => $row4->payload);
                    }
                }
            }


            $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
            $this->apiCallUpate("getdataVGW_get", "end");
            exit(json_encode($main_data));
        }
    }

    function retrieve_data_now($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null, $testFlag = null, $consumptionFlag = null) {
        ini_set('memory_limit', '1000M');


        $startdate = str_replace(" ", "+", $startdate);
        $enddate = str_replace(" ", "+", $enddate);
        $pieces_timestamp = explode("T", $startdate);
        $pieces_timestampend = explode("T", $enddate);
        $week_4ago = strtotime(date("Y-m-d", strtotime($pieces_timestamp[0])) . " -4 week");
        $OneDayAhead = date('Y-m-d', strtotime($pieces_timestampend[0] . "+1 days"));
        $datetime = DateTime::createFromFormat('Ymd', str_replace("-", "", $pieces_timestamp[0]));
        $switch_date = 0;

        if ($datetime->format('D') == "Mon") {
            $switch_date = 0;
        } elseif ($datetime->format('D') == "Tue") {
            $switch_date = 1;
        } elseif ($datetime->format('D') == "Wed") {
            $switch_date = 2;
        } elseif ($datetime->format('D') == "Thu") {
            $switch_date = 3;
        } elseif ($datetime->format('D') == "Fri") {
            $switch_date = 4;
        } elseif ($datetime->format('D') == "Sat") {
            $switch_date = 5;
        } elseif ($datetime->format('D') == "Sun") {
            $switch_date = 6;
        }

        $switch_date2 = 0;
        $datetime2 = DateTime::createFromFormat('Ymd', str_replace("-", "", $pieces_timestampend[0]));

        if ($datetime2->format('D') == "Mon") {
            $switch_date2 = 0;
        } elseif ($datetime2->format('D') == "Tue") {
            $switch_date2 = 1;
        } elseif ($datetime2->format('D') == "Wed") {
            $switch_date2 = 2;
        } elseif ($datetime2->format('D') == "Thu") {
            $switch_date2 = 3;
        } elseif ($datetime2->format('D') == "Fri") {
            $switch_date2 = 4;
        } elseif ($datetime2->format('D') == "Sat") {
            $switch_date2 = 5;
        } elseif ($datetime2->format('D') == "Sun") {
            $switch_date2 = 6;
        }


        $MacAnd = "";
        $forcast = array();
        $main_data = array();
        $production = array();
        $production_forecast = array();
        $total_energy_consumptionResult_forecast = "";
        $total_energy_consumption_forecast = array();
        $total_energy_consumption_date_forecast = array();
        $production_batteryPercentage = array();
        $total_energy_consumption = array();
        $total_energy_consumptionResult = array();
        $total_energy_consumption_date = array();
        $production_result = 0;
        $production_resultf = 0;
        $production_resultFinal = 0;
        $macID = "";
        $production_forecast = "";
        $pos = strpos($mac, ",");
        $macFlagCon = "";



        if ($mac == "b827ebf9b703") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH4ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH5ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060241CH7B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "21060028") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "Quadronuovo3ABC1458813213817.27") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "generaleluciesterne2ABC1458813156839.97") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "MD1251ABC1458813130520.72") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH10ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH1ABC") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH8C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH4B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH2B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7B") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH6C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH12A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH8A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH7C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH9C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH9A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH6A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH4C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH3A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH3C") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        } elseif ($mac == "14060229CH2A") {
            $consumptionFlag = "on";
            $macFlagCon = "on";
        }



        if ($mac and $pos === false) {

            $MacAnd = " and mac=" . $this->db->escape($mac) . "";

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


        if ($total == 1) {

            $sql = "SELECT mac,sum(payload),unix_timestamp(received) as timestampD,received,payload FROM VimsentPlatform.mqtt_logs_insert"
                    . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                    . " GROUP BY date(received) order by unix_timestamp(received) desc";




            $query = $this->db->query($sql);

            foreach ($query->result() as $row) {

                $main_data[] = array('Mac' => $row->mac, 'Date' => strstr($row->received, ' ', true), 'Kwh' => $row->payload);
            }
        } elseif ($interval) {

            if ($pointer == 1) {

                $sql = "SELECT mac,COALESCE(sum(payload),0) as data,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . " $groupby topic_c order by time asc";


                $query = $this->db->query($sql);
                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->data, 'Kwh_roundUp' => $row->roundUP, 'Topic' => $pieces[3]);
                }
            } elseif ($pointer == 2) {

                $pieces = explode("+", $startdate);
                $pieces2 = explode("+", $enddate);



                $sql = "SELECT mac,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_battery_percentage' "
                        . " $groupby time order by time ";


                $sql1 = "SELECT count(mac) as countField,ROUND(sum(payload),2) as sumPayload,mac,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd and topic_c='PV1_production_power' "
                        . "  group by time order by time ";


                $sql_2 = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='total_energy_consumption_300' GROUP BY time order by time ";

                $sql_2a = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='total_power' GROUP BY time order by time ";

                $sql_2b_1 = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic,topic_c "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  UNIX_TIMESTAMP(`received`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`received`) < " . strtotime($enddate) . " $MacAnd "
                        . " and topic_c='meter1_power' GROUP BY time order by time ";


                $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));


                $sql_3 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql_4 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";



                $query1 = $this->db->query($sql1);

                foreach ($query1->result() as $row1) {

                    if ($row1->topic_c == "PV1_production_power") {

                        $macID = $row1->mac;
                        $production_result = $row1->sumPayload / $row1->countField;
                        $production_resultf = $production_result * ($interval / 3600 / 1000 );
                        $production[] = array($row1->time . '.000+02:00' => number_format($production_resultf, 2, '.', ''));
                    }
                }


                $sql7 = "select * from VimsentPlatform.reliability_flexibility where mac='$mac' and UNIX_TIMESTAMP(`date`) >= " . strtotime($startdate) . " and UNIX_TIMESTAMP(`date`) < " . strtotime($enddate) . "";


                $flexibility = [];
                $reliability = [];


                $query7 = $this->db->query($sql7);

                foreach ($query7->result() as $row7) {


                    if ($row7->flexibility) {
                        $flexibility[] = array(str_replace(" ", "T", $row7->date) . '.000+02:00' => substr($row7->flexibility, 0, 4));
                    }

                    if ($row7->reliability) {
                        $reliability[] = array(str_replace(" ", "T", $row7->date) . '.000+02:00' => substr($row7->reliability, 0, 4));
                    }
                }


                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {



                    if ($row->topic_c == "PV1_production_battery_percentage") {

                        $ReturnValue = $row->payload * 10 / 100;
                        $ReturnValue = str_replace(",", ".", number_format($ReturnValue, 2, ',', ''));
                        $production_batteryPercentage[] = array($row->time . '.000+02:00' => $ReturnValue);
                    }
                }


                $query_2 = $this->db->query($sql_2);
                $query_2b_1 = $this->db->query($sql_2b_1);

                if ($query_2->num_rows() > 1) {

                    foreach ($query_2->result() as $row_2) {

                        $macID = $row_2->mac;
                        $total_energy_consumption[] = $row_2->payload;
                        $total_energy_consumption_date[] = $row_2->time;
                    }
                } elseif ($query_2b_1->num_rows() > 1) {

                    foreach ($query_2b_1->result() as $row_2b_1) {

                        $macID = $row_2b_1->mac;
                        $total_energy_consumption[] = $row_2b_1->payload;
                        $total_energy_consumption_date[] = $row_2b_1->time;
                    }
                } else {

                    $query_2a = $this->db->query($sql_2a);
                    if ($query_2a->num_rows() > 1) {
                        foreach ($query_2a->result() as $row_2a) {
                            $macID = $row_2a->mac;
                            $total_energy_consumption[] = $row_2a->payload;
                            $total_energy_consumption_date[] = $row_2a->time;
                        }
                    }
                }


                $query_3 = $this->db->query($sql_3);

                foreach ($query_3->result() as $row_3) {

                    $total_energy_consumptionResult_forecast = unserialize($row_3->total_energy_consumptionResult); //str_replace('\\"', '', $row_3->total_energy_consumptionResult);
                }


                $query4 = $this->db->query($sql_4);

                foreach ($query4->result() as $row4) {

                    $production_forecast = unserialize($row4->production_forecast); //str_replace('\\"', '', $row4->production_forecast);   
                }


                $max = sizeof($total_energy_consumption);

                for ($i = 0; $i < $max; $i++) {
                    if (isset($total_energy_consumption[$i + 1])) {

                        if ($total_energy_consumption[$i] > $total_energy_consumption[$i + 1]) {

                            if ($consumptionFlag == "on") {

                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i] - $total_energy_consumption[$i + 1]) / 1000, 2, ',', '')));
                            } else {

                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i + 1], 2, ',', '')));
                            }
                        } else {


                            if ($consumptionFlag == "on") {

                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i + 1] - $total_energy_consumption[$i]) / 1000, 2, ',', '')));
                            } else {

                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i + 1] - $total_energy_consumption[$i], 2, ',', '')));
                            }
                        }


                        $flag = $total_energy_consumption[$i] - $total_energy_consumption[$i + 1];
                    } elseif ($i + 1 == $max) {

                        if (sizeof($total_energy_consumption) > 1) {
                            if ($total_energy_consumption[$i] > $total_energy_consumption[$i - 1]) {

                                if ($consumptionFlag == "on") {

                                    $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i] - $total_energy_consumption[$i - 1]) / 1000, 2, ',', '')));
                                } else {


                                    $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i - 1], 2, ',', '')));
                                }
                            } else {


                                if ($consumptionFlag == "on") {

                                    $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format(($total_energy_consumption[$i - 1] - $total_energy_consumption[$i]) / 1000, 2, ',', '')));
                                } else {



                                    $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i - 1] - $total_energy_consumption[$i], 2, ',', '')));
                                }
                            }
                        } else {




                            $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i], 2, ',', '')));
                        }
                    }
                }

                if ($testFlag == "on") {
                    
                }


                $this->apiCallUpate("getdataVGW_get", "end");

                $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
                exit(json_encode($main_data));
            } elseif ($pointer == 3) {

                $sql = "SELECT mac,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . "  order by time asc";

                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->payload, 'Topic' => $pieces[3]);
                }
            } else {


                $sql = "SELECT mac,COALESCE(sum(payload),0) as data,ROUND(COALESCE(sum(payload),0),2) as roundUP,unix_timestamp(received) as timestampD,received,payload,DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(unix_timestamp(received) /" . $interval . ") *"
                        . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time,topic "
                        . "FROM VimsentPlatform.mqtt_logs_insert "
                        . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                        . " $groupby topic_c order by time asc";


                $query = $this->db->query($sql);

                foreach ($query->result() as $row) {

                    $pieces = explode("/", $row->topic);
                    $main_data[] = array('Mac' => $row->mac, 'Date' => $row->time, 'Kwh' => $row->data, 'Kwh_roundUp' => $row->roundUP, 'Topic' => $pieces[3]);
                }
            }
        } else {


            $sql = "SELECT mac,payload,unix_timestamp(received) as timestampD,received,payload,topic FROM VimsentPlatform.mqtt_logs_insert"
                    . " where  unix_timestamp(received) >= " . strtotime($startdate) . " and unix_timestamp(received) < " . strtotime($enddate) . " $MacAnd "
                    . " order by unix_timestamp(received) desc";




            $query = $this->db->query($sql);

            foreach ($query->result() as $row) {

                $pieces = explode("/", $row->topic);

                $main_data[] = array('Mac' => $row->mac, 'Date' => $row->received, 'Kwh' => $row->payload, 'Topic' => $pieces[3]);
            }
        }
        echo json_encode($main_data);
    }

    function apiCallUpate($functionName, $status) {


        $sql = "SELECT ApiCall FROM VimsentPlatform.http_api_call where  FunctionName ='$functionName' ";

        $flag = 0;



        $query = $this->db->query($sql);

        foreach ($query->result() as $row) {

            if ($row->ApiCall) {
                $flag = $row->ApiCall;
            }
        }


        if ($status == "start") {
            if ($flag) {


                $flag = $flag + 1;

                $query = "UPDATE VimsentPlatform.http_api_call SET ApiCall = $flag where FunctionName='$functionName'";

                $this->db->query($query);

                return $flag;
            } else {


                $sqlInsert = "INSERT INTO VimsentPlatform.http_api_call (FunctionName,ApiCall,ApiDate)
VALUES ('" . $functionName . "', '" . 1 . "','" . date('Y-m-d h:i:s') . "')";

                $this->db->query($sqlInsert);

                return 1;
            }
        } else {


            if ($flag == 1) {


                $query = "DELETE FROM VimsentPlatform.http_api_call WHERE FunctionName='$functionName'";

                $this->db->query($query);
            } elseif ($flag) {

                $flag = $flag - 1;

                $query = "UPDATE VimsentPlatform.http_api_call SET ApiCall = $flag where FunctionName='$functionName'";

                $this->db->query($query);
            } else {

                $query = "DELETE FROM VimsentPlatform.http_api_call WHERE FunctionName='$functionName'";

                $this->db->query($query);
            }
        }
    }

    function getHednoData2($macLookFor) {

        $arrayALL[] = "10001";
        $arrayALL[] = "10002";
        $arrayALL[] = "10003";
        $arrayALL[] = "10004";
        $arrayALL[] = "10005";
        $arrayALL[] = "10006";
        $arrayALL[] = "10007";
        $arrayALL[] = "10008";
        $arrayALL[] = "10009";
        $arrayALL[] = "10010";
        $arrayALL[] = "10011";
        $arrayALL[] = "10012";
        $arrayALL[] = "10013";
        $arrayALL[] = "10014";
        $arrayALL[] = "10015";
        $arrayALL[] = "10016";
        $arrayALL[] = "10017";
        $arrayALL[] = "10018";
        $arrayALL[] = "10019";
        $arrayALL[] = "10020";
        $arrayALL[] = "10021";
        $arrayALL[] = "10022";
        $arrayALL[] = "10023";
        $arrayALL[] = "10024";
        $arrayALL[] = "10025";
        $arrayALL[] = "10026";
        $arrayALL[] = "10027";
        $arrayALL[] = "10028";
        $arrayALL[] = "10029";
        $arrayALL[] = "10030";
        $arrayALL[] = "10031";
        $arrayALL[] = "10032";
        $arrayALL[] = "10033";
        $arrayALL[] = "10034";
        $arrayALL[] = "10035";
        $arrayALL[] = "10036";
        $arrayALL[] = "10037";
        $arrayALL[] = "10038";
        $arrayALL[] = "10039";
        $arrayALL[] = "10040";
        $arrayALL[] = "10041";
        $arrayALL[] = "10042";
        $arrayALL[] = "10043";
        $arrayALL[] = "10044";
        $arrayALL[] = "10045";
        $arrayALL[] = "10046";
        $arrayALL[] = "10047";
        $arrayALL[] = "10048";
        $arrayALL[] = "10049";
        $arrayALL[] = "10050";
        $arrayALL[] = "11001";
        $arrayALL[] = "11002";
        $arrayALL[] = "11003";
        $arrayALL[] = "11004";
        $arrayALL[] = "11005";
        $arrayALL[] = "11006";
        $arrayALL[] = "11007";
        $arrayALL[] = "11008";
        $arrayALL[] = "11009";
        $arrayALL[] = "11010";
        $arrayALL[] = "11011";
        $arrayALL[] = "11012";
        $arrayALL[] = "11013";
        $arrayALL[] = "11014";
        $arrayALL[] = "11015";
        $arrayALL[] = "11016";
        $arrayALL[] = "11017";
        $arrayALL[] = "11018";
        $arrayALL[] = "11019";
        $arrayALL[] = "11020";
        $arrayALL[] = "11021";
        $arrayALL[] = "11022";
        $arrayALL[] = "11023";
        $arrayALL[] = "11024";
        $arrayALL[] = "11025";
        $arrayALL[] = "11026";
        $arrayALL[] = "11027";
        $arrayALL[] = "11028";
        $arrayALL[] = "11029";
        $arrayALL[] = "11030";
        $arrayALL[] = "11031";
        $arrayALL[] = "11032";
        $arrayALL[] = "11033";
        $arrayALL[] = "11034";
        $arrayALL[] = "11035";
        $arrayALL[] = "11036";
        $arrayALL[] = "11037";
        $arrayALL[] = "11038";
        $arrayALL[] = "11039";
        $arrayALL[] = "11040";
        $arrayALL[] = "11041";
        $arrayALL[] = "11042";
        $arrayALL[] = "11043";
        $arrayALL[] = "11044";
        $arrayALL[] = "11045";
        $arrayALL[] = "11046";
        $arrayALL[] = "11047";
        $arrayALL[] = "11048";
        $arrayALL[] = "11049";
        $arrayALL[] = "11050";
        $arrayALL[] = "3001 ";
        $arrayALL[] = "3002 ";
        $arrayALL[] = "3003 ";
        $arrayALL[] = "3004 ";
        $arrayALL[] = "3005 ";
        $arrayALL[] = "3006 ";
        $arrayALL[] = "3007 ";
        $arrayALL[] = "3008 ";
        $arrayALL[] = "3009 ";
        $arrayALL[] = "3010 ";
        $arrayALL[] = "3011 ";
        $arrayALL[] = "3012 ";
        $arrayALL[] = "3013 ";
        $arrayALL[] = "3014 ";
        $arrayALL[] = "3015 ";
        $arrayALL[] = "3016 ";
        $arrayALL[] = "3017 ";
        $arrayALL[] = "3018 ";
        $arrayALL[] = "3019 ";
        $arrayALL[] = "3020 ";
        $arrayALL[] = "3021 ";
        $arrayALL[] = "3022 ";
        $arrayALL[] = "3023 ";
        $arrayALL[] = "3024 ";
        $arrayALL[] = "3025 ";
        $arrayALL[] = "3026 ";
        $arrayALL[] = "3027 ";
        $arrayALL[] = "3028 ";
        $arrayALL[] = "3029 ";
        $arrayALL[] = "3030 ";
        $arrayALL[] = "3031 ";
        $arrayALL[] = "3032 ";
        $arrayALL[] = "3033 ";
        $arrayALL[] = "3034 ";
        $arrayALL[] = "3035 ";
        $arrayALL[] = "3036 ";
        $arrayALL[] = "3037 ";
        $arrayALL[] = "3038 ";
        $arrayALL[] = "3039 ";
        $arrayALL[] = "3040 ";
        $arrayALL[] = "4001 ";
        $arrayALL[] = "4002 ";
        $arrayALL[] = "4003 ";
        $arrayALL[] = "4004 ";
        $arrayALL[] = "4005 ";
        $arrayALL[] = "4006 ";
        $arrayALL[] = "4007 ";
        $arrayALL[] = "4008 ";
        $arrayALL[] = "4009 ";
        $arrayALL[] = "4010 ";
        $arrayALL[] = "4011 ";
        $arrayALL[] = "4012 ";
        $arrayALL[] = "4013 ";
        $arrayALL[] = "4014 ";
        $arrayALL[] = "4015 ";
        $arrayALL[] = "4016 ";
        $arrayALL[] = "4017 ";
        $arrayALL[] = "4018 ";
        $arrayALL[] = "4019 ";
        $arrayALL[] = "4020 ";
        $arrayALL[] = "4021 ";
        $arrayALL[] = "4022 ";
        $arrayALL[] = "4023 ";
        $arrayALL[] = "4024 ";
        $arrayALL[] = "4025 ";
        $arrayALL[] = "4026 ";
        $arrayALL[] = "4027 ";
        $arrayALL[] = "4028 ";
        $arrayALL[] = "4029 ";
        $arrayALL[] = "4030 ";
        $arrayALL[] = "4031 ";
        $arrayALL[] = "4032 ";
        $arrayALL[] = "4033 ";
        $arrayALL[] = "4034 ";
        $arrayALL[] = "4035 ";
        $arrayALL[] = "4036 ";
        $arrayALL[] = "4037 ";
        $arrayALL[] = "4038 ";
        $arrayALL[] = "4039 ";
        $arrayALL[] = "4040 ";
        $arrayALL[] = "4041 ";
        $arrayALL[] = "4042 ";
        $arrayALL[] = "4043 ";
        $arrayALL[] = "4044 ";
        $arrayALL[] = "4045 ";
        $arrayALL[] = "4046 ";
        $arrayALL[] = "4047 ";
        $arrayALL[] = "4048 ";
        $arrayALL[] = "4049 ";
        $arrayALL[] = "4050 ";
        $arrayALL[] = "5001 ";
        $arrayALL[] = "5002 ";
        $arrayALL[] = "5003 ";
        $arrayALL[] = "5004 ";
        $arrayALL[] = "5005 ";
        $arrayALL[] = "5006 ";
        $arrayALL[] = "5007 ";
        $arrayALL[] = "5008 ";
        $arrayALL[] = "5009 ";
        $arrayALL[] = "5010 ";
        $arrayALL[] = "5011 ";
        $arrayALL[] = "5012 ";
        $arrayALL[] = "5013 ";
        $arrayALL[] = "5014 ";
        $arrayALL[] = "5015 ";
        $arrayALL[] = "5016 ";
        $arrayALL[] = "5017 ";
        $arrayALL[] = "5018 ";
        $arrayALL[] = "5019 ";
        $arrayALL[] = "5020 ";
        $arrayALL[] = "5021 ";
        $arrayALL[] = "5022 ";
        $arrayALL[] = "5023 ";
        $arrayALL[] = "5024 ";
        $arrayALL[] = "5025 ";
        $arrayALL[] = "5026 ";
        $arrayALL[] = "5027 ";
        $arrayALL[] = "5028 ";
        $arrayALL[] = "5029 ";
        $arrayALL[] = "5030 ";
        $arrayALL[] = "5031 ";
        $arrayALL[] = "5032 ";
        $arrayALL[] = "5033 ";
        $arrayALL[] = "5034 ";
        $arrayALL[] = "5035 ";
        $arrayALL[] = "5036 ";
        $arrayALL[] = "5037 ";
        $arrayALL[] = "5038 ";
        $arrayALL[] = "5039 ";
        $arrayALL[] = "5040 ";
        $arrayALL[] = "5041 ";
        $arrayALL[] = "5042 ";
        $arrayALL[] = "5043 ";
        $arrayALL[] = "5044 ";
        $arrayALL[] = "5045 ";
        $arrayALL[] = "5046 ";
        $arrayALL[] = "5047 ";
        $arrayALL[] = "5048 ";
        $arrayALL[] = "5049 ";
        $arrayALL[] = "5050 ";
        $arrayALL[] = "6001 ";
        $arrayALL[] = "6002 ";
        $arrayALL[] = "6003 ";
        $arrayALL[] = "6004 ";
        $arrayALL[] = "6005 ";
        $arrayALL[] = "6006 ";
        $arrayALL[] = "6007 ";
        $arrayALL[] = "6008 ";
        $arrayALL[] = "6009 ";
        $arrayALL[] = "6010 ";
        $arrayALL[] = "6011 ";
        $arrayALL[] = "6012 ";
        $arrayALL[] = "6013 ";
        $arrayALL[] = "6014 ";
        $arrayALL[] = "6015 ";
        $arrayALL[] = "6016 ";
        $arrayALL[] = "6017 ";
        $arrayALL[] = "6018 ";
        $arrayALL[] = "6019 ";
        $arrayALL[] = "6020 ";
        $arrayALL[] = "6021 ";
        $arrayALL[] = "6022 ";
        $arrayALL[] = "6023 ";
        $arrayALL[] = "6024 ";
        $arrayALL[] = "6025 ";
        $arrayALL[] = "6026 ";
        $arrayALL[] = "6027 ";
        $arrayALL[] = "6028 ";
        $arrayALL[] = "6029 ";
        $arrayALL[] = "6030 ";
        $arrayALL[] = "6031 ";
        $arrayALL[] = "6032 ";
        $arrayALL[] = "6033 ";
        $arrayALL[] = "6034 ";
        $arrayALL[] = "6035 ";
        $arrayALL[] = "6036 ";
        $arrayALL[] = "6037 ";
        $arrayALL[] = "6038 ";
        $arrayALL[] = "6039 ";
        $arrayALL[] = "6040 ";
        $arrayALL[] = "6041 ";
        $arrayALL[] = "6042 ";
        $arrayALL[] = "6043 ";
        $arrayALL[] = "6044 ";
        $arrayALL[] = "6045 ";
        $arrayALL[] = "6046 ";
        $arrayALL[] = "6047 ";
        $arrayALL[] = "6048 ";
        $arrayALL[] = "6049 ";
        $arrayALL[] = "6050 ";
        $arrayALL[] = "7001 ";
        $arrayALL[] = "7002 ";
        $arrayALL[] = "7003 ";
        $arrayALL[] = "7004 ";
        $arrayALL[] = "7005 ";
        $arrayALL[] = "7006 ";
        $arrayALL[] = "7007 ";
        $arrayALL[] = "7008 ";
        $arrayALL[] = "7009 ";
        $arrayALL[] = "7010 ";
        $arrayALL[] = "7011 ";
        $arrayALL[] = "7012 ";
        $arrayALL[] = "7013 ";
        $arrayALL[] = "7014 ";
        $arrayALL[] = "7015 ";
        $arrayALL[] = "7016 ";
        $arrayALL[] = "7017 ";
        $arrayALL[] = "7018 ";
        $arrayALL[] = "7019 ";
        $arrayALL[] = "7020 ";
        $arrayALL[] = "7021 ";
        $arrayALL[] = "7022 ";
        $arrayALL[] = "7023 ";
        $arrayALL[] = "7024 ";
        $arrayALL[] = "7025 ";
        $arrayALL[] = "7026 ";
        $arrayALL[] = "7027 ";
        $arrayALL[] = "7028 ";
        $arrayALL[] = "7029 ";
        $arrayALL[] = "7030 ";
        $arrayALL[] = "7031 ";
        $arrayALL[] = "7032 ";
        $arrayALL[] = "7033 ";
        $arrayALL[] = "7034 ";
        $arrayALL[] = "7035 ";
        $arrayALL[] = "7036 ";
        $arrayALL[] = "7037 ";
        $arrayALL[] = "7038 ";
        $arrayALL[] = "7039 ";
        $arrayALL[] = "7040 ";
        $arrayALL[] = "7041 ";
        $arrayALL[] = "7042 ";
        $arrayALL[] = "7043 ";
        $arrayALL[] = "7044 ";
        $arrayALL[] = "7045 ";
        $arrayALL[] = "7046 ";
        $arrayALL[] = "7047 ";
        $arrayALL[] = "7048 ";
        $arrayALL[] = "7049 ";
        $arrayALL[] = "7050 ";
        $arrayALL[] = "8001 ";
        $arrayALL[] = "8002 ";
        $arrayALL[] = "8003 ";
        $arrayALL[] = "8004 ";
        $arrayALL[] = "8005 ";
        $arrayALL[] = "8006 ";
        $arrayALL[] = "8007 ";
        $arrayALL[] = "8008 ";
        $arrayALL[] = "8009 ";
        $arrayALL[] = "8010 ";
        $arrayALL[] = "8011 ";
        $arrayALL[] = "8012 ";
        $arrayALL[] = "8013 ";
        $arrayALL[] = "8014 ";
        $arrayALL[] = "8015 ";
        $arrayALL[] = "8016 ";
        $arrayALL[] = "8017 ";
        $arrayALL[] = "8018 ";
        $arrayALL[] = "8019 ";
        $arrayALL[] = "8020 ";
        $arrayALL[] = "8021 ";
        $arrayALL[] = "8022 ";
        $arrayALL[] = "8023 ";
        $arrayALL[] = "8024 ";
        $arrayALL[] = "8025 ";
        $arrayALL[] = "8026 ";
        $arrayALL[] = "8027 ";
        $arrayALL[] = "8028 ";
        $arrayALL[] = "8029 ";
        $arrayALL[] = "8030 ";
        $arrayALL[] = "8031 ";
        $arrayALL[] = "8032 ";
        $arrayALL[] = "8033 ";
        $arrayALL[] = "8034 ";
        $arrayALL[] = "8035 ";
        $arrayALL[] = "8036 ";
        $arrayALL[] = "8037 ";
        $arrayALL[] = "8038 ";
        $arrayALL[] = "8039 ";
        $arrayALL[] = "8040 ";
        $arrayALL[] = "8041 ";
        $arrayALL[] = "8042 ";
        $arrayALL[] = "8043 ";
        $arrayALL[] = "8044 ";
        $arrayALL[] = "8045 ";
        $arrayALL[] = "8046 ";
        $arrayALL[] = "8047 ";
        $arrayALL[] = "8048 ";
        $arrayALL[] = "8049 ";
        $arrayALL[] = "8050 ";
        $arrayALL[] = "9001 ";
        $arrayALL[] = "9002 ";
        $arrayALL[] = "9003 ";
        $arrayALL[] = "9004 ";
        $arrayALL[] = "9005 ";
        $arrayALL[] = "9006 ";
        $arrayALL[] = "9007 ";
        $arrayALL[] = "9008 ";
        $arrayALL[] = "9009 ";
        $arrayALL[] = "9010 ";
        $arrayALL[] = "9011 ";
        $arrayALL[] = "9012 ";
        $arrayALL[] = "9013 ";
        $arrayALL[] = "9014 ";
        $arrayALL[] = "9015 ";
        $arrayALL[] = "9016 ";
        $arrayALL[] = "9017 ";
        $arrayALL[] = "9018 ";
        $arrayALL[] = "9019 ";
        $arrayALL[] = "9020 ";
        $arrayALL[] = "9021 ";
        $arrayALL[] = "9022 ";
        $arrayALL[] = "9023 ";
        $arrayALL[] = "9024 ";
        $arrayALL[] = "9025 ";
        $arrayALL[] = "9026 ";
        $arrayALL[] = "9027 ";
        $arrayALL[] = "9028 ";
        $arrayALL[] = "9029 ";
        $arrayALL[] = "9030 ";
        $arrayALL[] = "9031 ";
        $arrayALL[] = "9032 ";
        $arrayALL[] = "9033 ";
        $arrayALL[] = "9034 ";
        $arrayALL[] = "9035 ";
        $arrayALL[] = "9036 ";
        $arrayALL[] = "9037 ";
        $arrayALL[] = "9038 ";
        $arrayALL[] = "9039 ";
        $arrayALL[] = "9040 ";
        $arrayALL[] = "9041 ";
        $arrayALL[] = "9042 ";
        $arrayALL[] = "9043 ";
        $arrayALL[] = "9044 ";
        $arrayALL[] = "9045 ";
        $arrayALL[] = "9046 ";
        $arrayALL[] = "HP_0001";
        $arrayALL[] = "HP_0002";
        $arrayALL[] = "HP_0003";
        $arrayALL[] = "HP_0004";
        $arrayALL[] = "HP_0005";
        $arrayALL[] = "HP_0006";
        $arrayALL[] = "HP_0007";
        $arrayALL[] = "HP_0008";
        $arrayALL[] = "HP_0009";
        $arrayALL[] = "HP_0010";
        $arrayALL[] = "HP_0011";
        $arrayALL[] = "HP_0012";
        $arrayALL[] = "HP_0013";
        $arrayALL[] = "HP_0014";
        $arrayALL[] = "HP_0015";
        $arrayALL[] = "HP_0016";
        $arrayALL[] = "HP_0017";
        $arrayALL[] = "HP_0018";
        $arrayALL[] = "HP_0019";
        $arrayALL[] = "HP_0020";
        $arrayALL[] = "HP_0021";
        $arrayALL[] = "HP_0022";
        $arrayALL[] = "HP_0023";
        $arrayALL[] = "HP_0024";
        $arrayALL[] = "HP_0025";
        $arrayALL[] = "HP_0026";
        $arrayALL[] = "HP_0027";
        $arrayALL[] = "HP_0028";
        $arrayALL[] = "HP_0029";
        $arrayALL[] = "HP_0030";
        $arrayALL[] = "HP_0031";
        $arrayALL[] = "HP_0032";
        $arrayALL[] = "HP_0033";
        $arrayALL[] = "HP_0034";
        $arrayALL[] = "HP_0035";
        $arrayALL[] = "HP_0036";
        $arrayALL[] = "HP_0037";
        $arrayALL[] = "HP_0038";
        $arrayALL[] = "HP_0039";
        $arrayALL[] = "HP_0040";
        $arrayALL[] = "HP_0041";
        $arrayALL[] = "HP_0042";
        $arrayALL[] = "HP_0043";
        $arrayALL[] = "HP_0044";
        $arrayALL[] = "HP_0045";
        $arrayALL[] = "HP_0046";
        $arrayALL[] = "HP_0047";
        $arrayALL[] = "HP_0048";
        $arrayALL[] = "HP_0049";
        $arrayALL[] = "HP_0050";
        $arrayALL[] = "HP_0051";
        $arrayALL[] = "HP_0052";
        $arrayALL[] = "HP_0053";
        $arrayALL[] = "HP_0054";
        $arrayALL[] = "HP_0055";
        $arrayALL[] = "HP_0056";
        $arrayALL[] = "HP_0057";
        $arrayALL[] = "HP_0058";
        $arrayALL[] = "HP_0059";
        $arrayALL[] = "HP_0060";
        $arrayALL[] = "HP_0061";
        $arrayALL[] = "HP_0062";
        $arrayALL[] = "HP_0063";
        $arrayALL[] = "HP_0064";
        $arrayALL[] = "HP_0065";
        $arrayALL[] = "HP_0066";
        $arrayALL[] = "HP_0067";
        $arrayALL[] = "HP_0068";
        $arrayALL[] = "HP_0069";
        $arrayALL[] = "HP_0070";
        $arrayALL[] = "HP_0071";
        $arrayALL[] = "HP_0072";
        $arrayALL[] = "HP_0073";
        $arrayALL[] = "HP_0074";
        $arrayALL[] = "HP_0075";
        $arrayALL[] = "HP_0076";
        $arrayALL[] = "HP_0077";
        $arrayALL[] = "HP_0078";
        $arrayALL[] = "HP_0079";
        $arrayALL[] = "HP_0080";
        $arrayALL[] = "HP_0081";
        $arrayALL[] = "HP_0082";
        $arrayALL[] = "HP_0083";
        $arrayALL[] = "HP_0084";
        $arrayALL[] = "HP_0085";
        $arrayALL[] = "HP_0086";
        $arrayALL[] = "HP_0087";
        $arrayALL[] = "HP_0088";
        $arrayALL[] = "HP_0089";
        $arrayALL[] = "HP_0090";
        $arrayALL[] = "HP_0091";
        $arrayALL[] = "HP_0092";
        $arrayALL[] = "HP_0093";
        $arrayALL[] = "HP_0094";
        $arrayALL[] = "HP_0095";
        $arrayALL[] = "HP_0096";
        $arrayALL[] = "HP_0097";
        $arrayALL[] = "HP_0098";
        $arrayALL[] = "HP_0099";
        $arrayALL[] = "HP_0100";
        $arrayALL[] = "HP_0101";
        $arrayALL[] = "HP_0102";
        $arrayALL[] = "HP_0103";
        $arrayALL[] = "HP_0104";
        $arrayALL[] = "HP_0105";
        $arrayALL[] = "HP_0106";
        $arrayALL[] = "HP_0107";
        $arrayALL[] = "HP_0108";
        $arrayALL[] = "HP_0109";
        $arrayALL[] = "HP_0110";
        $arrayALL[] = "HP_0111";
        $arrayALL[] = "HP_0112";
        $arrayALL[] = "HP_0113";
        $arrayALL[] = "HP_0114";
        $arrayALL[] = "HP_0115";
        $arrayALL[] = "HP_0116";
        $arrayALL[] = "HP_0117";
        $arrayALL[] = "HP_0118";
        $arrayALL[] = "HP_0119";
        $arrayALL[] = "HP_0120";
        $arrayALL[] = "HP_0121";
        $arrayALL[] = "HP_0122";
        $arrayALL[] = "HP_0123";
        $arrayALL[] = "HP_0124";
        $arrayALL[] = "HP_0125";
        $arrayALL[] = "HP_0126";
        $arrayALL[] = "HP_0127";
        $arrayALL[] = "HP_0128";
        $arrayALL[] = "HP_0129";
        $arrayALL[] = "HP_0130";
        $arrayALL[] = "HP_0131";
        $arrayALL[] = "HP_0132";
        $arrayALL[] = "HP_0133";
        $arrayALL[] = "HP_0134";
        $arrayALL[] = "HP_0135";
        $arrayALL[] = "HP_0136";
        $arrayALL[] = "HP_0137";
        $arrayALL[] = "HP_0138";
        $arrayALL[] = "HP_0139";
        $arrayALL[] = "HP_0140";
        $arrayALL[] = "HP_0141";
        $arrayALL[] = "HP_0142";
        $arrayALL[] = "HP_0143";
        $arrayALL[] = "HP_0144";
        $arrayALL[] = "HP_0145";
        $arrayALL[] = "HP_0146";
        $arrayALL[] = "HP_0147";
        $arrayALL[] = "HP_0148";
        $arrayALL[] = "HP_0149";
        $arrayALL[] = "HP_0150";
        $arrayALL[] = "HP_0151";
        $arrayALL[] = "HP_0152";
        $arrayALL[] = "HP_0153";
        $arrayALL[] = "HP_0154";
        $arrayALL[] = "HP_0155";
        $arrayALL[] = "HP_0156";
        $arrayALL[] = "HP_0157";
        $arrayALL[] = "HP_0158";
        $arrayALL[] = "HP_0159";
        $arrayALL[] = "HP_0160";

        if (in_array($macLookFor, $arrayALL)) {

            return 1;
        } else {

            return 2;
        }
    }

    function getHednoData3($macLookFor) {

        $hednoma[] = "3001";
        $hednoma[] = "3002";
        $hednoma[] = "3003";
        $hednoma[] = "3004";
        $hednoma[] = "3005";
        $hednoma[] = "3006";
        $hednoma[] = "3007";
        $hednoma[] = "3008";
        $hednoma[] = "3009";
        $hednoma[] = "3010";
        $hednoma[] = "3011";
        $hednoma[] = "3012";
        $hednoma[] = "3013";
        $hednoma[] = "3014";
        $hednoma[] = "3015";
        $hednoma[] = "3016";
        $hednoma[] = "3017";
        $hednoma[] = "3018";
        $hednoma[] = "3019";
        $hednoma[] = "3020";
        $hednoma[] = "3021";
        $hednoma[] = "3022";
        $hednoma[] = "3023";
        $hednoma[] = "3024";
        $hednoma[] = "3025";
        $hednoma[] = "3026";
        $hednoma[] = "3027";
        $hednoma[] = "3028";
        $hednoma[] = "3029";
        $hednoma[] = "3030";
        $hednoma[] = "3031";
        $hednoma[] = "3032";
        $hednoma[] = "3033";
        $hednoma[] = "3034";
        $hednoma[] = "3035";
        $hednoma[] = "3036";
        $hednoma[] = "3037";
        $hednoma[] = "3038";
        $hednoma[] = "3039";
        $hednoma[] = "3040";
        $hednoma[] = "4001";
        $hednoma[] = "4002";
        $hednoma[] = "4003";
        $hednoma[] = "4004";
        $hednoma[] = "4005";
        $hednoma[] = "4006";
        $hednoma[] = "4007";
        $hednoma[] = "4008";
        $hednoma[] = "4009";
        $hednoma[] = "4010";
        $hednoma[] = "4011";
        $hednoma[] = "4012";
        $hednoma[] = "4013";
        $hednoma[] = "4014";
        $hednoma[] = "4015";
        $hednoma[] = "4016";
        $hednoma[] = "4017";
        $hednoma[] = "4018";
        $hednoma[] = "4019";
        $hednoma[] = "4020";
        $hednoma[] = "4021";
        $hednoma[] = "4022";
        $hednoma[] = "4023";
        $hednoma[] = "4024";
        $hednoma[] = "4025";
        $hednoma[] = "4026";
        $hednoma[] = "4027";
        $hednoma[] = "4028";
        $hednoma[] = "4029";
        $hednoma[] = "4030";
        $hednoma[] = "4031";
        $hednoma[] = "4032";
        $hednoma[] = "4033";
        $hednoma[] = "4034";
        $hednoma[] = "4035";
        $hednoma[] = "4036";
        $hednoma[] = "4037";
        $hednoma[] = "4038";
        $hednoma[] = "4039";
        $hednoma[] = "4040";
        $hednoma[] = "4041";
        $hednoma[] = "4042";
        $hednoma[] = "4043";
        $hednoma[] = "4044";
        $hednoma[] = "4045";
        $hednoma[] = "4046";
        $hednoma[] = "4047";
        $hednoma[] = "4048";
        $hednoma[] = "4049";
        $hednoma[] = "4050";
        $hednoma[] = "5001";
        $hednoma[] = "5002";
        $hednoma[] = "5003";
        $hednoma[] = "5004";
        $hednoma[] = "5005";
        $hednoma[] = "5006";
        $hednoma[] = "5007";
        $hednoma[] = "5008";
        $hednoma[] = "5009";
        $hednoma[] = "5010";
        $hednoma[] = "5011";
        $hednoma[] = "5012";
        $hednoma[] = "5013";
        $hednoma[] = "5014";
        $hednoma[] = "5015";
        $hednoma[] = "5016";
        $hednoma[] = "5017";
        $hednoma[] = "5018";
        $hednoma[] = "5019";
        $hednoma[] = "5020";
        $hednoma[] = "5021";
        $hednoma[] = "5022";
        $hednoma[] = "5023";
        $hednoma[] = "5024";
        $hednoma[] = "5025";
        $hednoma[] = "5026";
        $hednoma[] = "5027";
        $hednoma[] = "5028";
        $hednoma[] = "5029";
        $hednoma[] = "5030";
        $hednoma[] = "5031";
        $hednoma[] = "5032";
        $hednoma[] = "5033";
        $hednoma[] = "5034";
        $hednoma[] = "5035";
        $hednoma[] = "5036";
        $hednoma[] = "5037";
        $hednoma[] = "5038";
        $hednoma[] = "5039";
        $hednoma[] = "5040";
        $hednoma[] = "5041";
        $hednoma[] = "5042";
        $hednoma[] = "5043";
        $hednoma[] = "5044";
        $hednoma[] = "5045";
        $hednoma[] = "5046";
        $hednoma[] = "5047";
        $hednoma[] = "5048";
        $hednoma[] = "5049";
        $hednoma[] = "5050";
        $hednoma[] = "6001";
        $hednoma[] = "6002";
        $hednoma[] = "6003";
        $hednoma[] = "6004";
        $hednoma[] = "6005";
        $hednoma[] = "6006";
        $hednoma[] = "6007";
        $hednoma[] = "6008";
        $hednoma[] = "6009";
        $hednoma[] = "6010";
        $hednoma[] = "6011";
        $hednoma[] = "6012";
        $hednoma[] = "6013";
        $hednoma[] = "6014";
        $hednoma[] = "6015";
        $hednoma[] = "6016";
        $hednoma[] = "6017";
        $hednoma[] = "6018";
        $hednoma[] = "6019";
        $hednoma[] = "6020";
        $hednoma[] = "6021";
        $hednoma[] = "6022";
        $hednoma[] = "6023";
        $hednoma[] = "6024";
        $hednoma[] = "6025";
        $hednoma[] = "6026";
        $hednoma[] = "6027";
        $hednoma[] = "6028";
        $hednoma[] = "6029";
        $hednoma[] = "6030";
        $hednoma[] = "6031";
        $hednoma[] = "6032";
        $hednoma[] = "6033";
        $hednoma[] = "6034";
        $hednoma[] = "6035";
        $hednoma[] = "6036";
        $hednoma[] = "6037";
        $hednoma[] = "6038";
        $hednoma[] = "6039";
        $hednoma[] = "6040";
        $hednoma[] = "6041";
        $hednoma[] = "6042";
        $hednoma[] = "6043";
        $hednoma[] = "6044";
        $hednoma[] = "6045";
        $hednoma[] = "6046";
        $hednoma[] = "6047";
        $hednoma[] = "6048";
        $hednoma[] = "6049";
        $hednoma[] = "6050";
        $hednoma[] = "7001";
        $hednoma[] = "7002";
        $hednoma[] = "7003";
        $hednoma[] = "7004";
        $hednoma[] = "7005";
        $hednoma[] = "7006";
        $hednoma[] = "7007";
        $hednoma[] = "7008";
        $hednoma[] = "7009";
        $hednoma[] = "7010";
        $hednoma[] = "7011";
        $hednoma[] = "7012";
        $hednoma[] = "7013";
        $hednoma[] = "7014";
        $hednoma[] = "7015";
        $hednoma[] = "7016";
        $hednoma[] = "7017";
        $hednoma[] = "7018";
        $hednoma[] = "7019";
        $hednoma[] = "7020";
        $hednoma[] = "7021";
        $hednoma[] = "7022";
        $hednoma[] = "7023";
        $hednoma[] = "7024";
        $hednoma[] = "7025";
        $hednoma[] = "7026";
        $hednoma[] = "7027";
        $hednoma[] = "7028";
        $hednoma[] = "7029";
        $hednoma[] = "7030";
        $hednoma[] = "7031";
        $hednoma[] = "7032";
        $hednoma[] = "7033";
        $hednoma[] = "7034";
        $hednoma[] = "7035";
        $hednoma[] = "7036";
        $hednoma[] = "7037";
        $hednoma[] = "7038";
        $hednoma[] = "7039";
        $hednoma[] = "7040";
        $hednoma[] = "7041";
        $hednoma[] = "7042";
        $hednoma[] = "7043";
        $hednoma[] = "7044";
        $hednoma[] = "7045";
        $hednoma[] = "7046";
        $hednoma[] = "7047";
        $hednoma[] = "7048";
        $hednoma[] = "7049";
        $hednoma[] = "7050";
        $hednoma[] = "8001";
        $hednoma[] = "8002";
        $hednoma[] = "8003";
        $hednoma[] = "8004";
        $hednoma[] = "8005";
        $hednoma[] = "8006";
        $hednoma[] = "8007";
        $hednoma[] = "8008";
        $hednoma[] = "8009";
        $hednoma[] = "8010";
        $hednoma[] = "8011";
        $hednoma[] = "8012";
        $hednoma[] = "8013";
        $hednoma[] = "8014";
        $hednoma[] = "8015";
        $hednoma[] = "8016";
        $hednoma[] = "8017";
        $hednoma[] = "8018";
        $hednoma[] = "8019";
        $hednoma[] = "8020";
        $hednoma[] = "8021";
        $hednoma[] = "8022";
        $hednoma[] = "8023";
        $hednoma[] = "8024";
        $hednoma[] = "8025";
        $hednoma[] = "8026";
        $hednoma[] = "8027";
        $hednoma[] = "8028";
        $hednoma[] = "8029";
        $hednoma[] = "8030";
        $hednoma[] = "8031";
        $hednoma[] = "8032";
        $hednoma[] = "8033";
        $hednoma[] = "8034";
        $hednoma[] = "8035";
        $hednoma[] = "8036";
        $hednoma[] = "8037";
        $hednoma[] = "8038";
        $hednoma[] = "8039";
        $hednoma[] = "8040";
        $hednoma[] = "8041";
        $hednoma[] = "8042";
        $hednoma[] = "8043";
        $hednoma[] = "8044";
        $hednoma[] = "8045";
        $hednoma[] = "8046";
        $hednoma[] = "8047";
        $hednoma[] = "8048";
        $hednoma[] = "8049";
        $hednoma[] = "8050";
        $hednoma[] = "9001";
        $hednoma[] = "9002";
        $hednoma[] = "9003";
        $hednoma[] = "9004";
        $hednoma[] = "9005";
        $hednoma[] = "9006";
        $hednoma[] = "9007";
        $hednoma[] = "9008";
        $hednoma[] = "9009";
        $hednoma[] = "9010";
        $hednoma[] = "9011";
        $hednoma[] = "9012";
        $hednoma[] = "9013";
        $hednoma[] = "9014";
        $hednoma[] = "9015";
        $hednoma[] = "9016";
        $hednoma[] = "9017";
        $hednoma[] = "9018";
        $hednoma[] = "9019";
        $hednoma[] = "9020";
        $hednoma[] = "9021";
        $hednoma[] = "9022";
        $hednoma[] = "9023";
        $hednoma[] = "9024";
        $hednoma[] = "9025";
        $hednoma[] = "9026";
        $hednoma[] = "9027";
        $hednoma[] = "9028";
        $hednoma[] = "9029";
        $hednoma[] = "9030";
        $hednoma[] = "9031";
        $hednoma[] = "9032";
        $hednoma[] = "9033";
        $hednoma[] = "9034";
        $hednoma[] = "9035";
        $hednoma[] = "9036";
        $hednoma[] = "9037";
        $hednoma[] = "9038";
        $hednoma[] = "9039";
        $hednoma[] = "9040";
        $hednoma[] = "9041";
        $hednoma[] = "9042";
        $hednoma[] = "9043";
        $hednoma[] = "9044";
        $hednoma[] = "9045";
        $hednoma[] = "9046";
        $hednoma[] = "9047";
        $hednoma[] = "9048";
        $hednoma[] = "9049";
        $hednoma[] = "9050";
        $hednoma[] = "10001";
        $hednoma[] = "10002";
        $hednoma[] = "10003";
        $hednoma[] = "10004";
        $hednoma[] = "10005";
        $hednoma[] = "10006";
        $hednoma[] = "10007";
        $hednoma[] = "10008";
        $hednoma[] = "10009";
        $hednoma[] = "10010";
        $hednoma[] = "10011";
        $hednoma[] = "10012";
        $hednoma[] = "10013";
        $hednoma[] = "10014";
        $hednoma[] = "10015";
        $hednoma[] = "10016";
        $hednoma[] = "10017";
        $hednoma[] = "10018";
        $hednoma[] = "10019";
        $hednoma[] = "10020";
        $hednoma[] = "10021";
        $hednoma[] = "10022";
        $hednoma[] = "10023";
        $hednoma[] = "10024";
        $hednoma[] = "10025";
        $hednoma[] = "10026";
        $hednoma[] = "10027";
        $hednoma[] = "10028";
        $hednoma[] = "10029";
        $hednoma[] = "10030";
        $hednoma[] = "10031";
        $hednoma[] = "10032";
        $hednoma[] = "10033";
        $hednoma[] = "10034";
        $hednoma[] = "10035";
        $hednoma[] = "10036";
        $hednoma[] = "10037";
        $hednoma[] = "10038";
        $hednoma[] = "10039";
        $hednoma[] = "10040";
        $hednoma[] = "10041";
        $hednoma[] = "10042";
        $hednoma[] = "10043";
        $hednoma[] = "10044";
        $hednoma[] = "10045";
        $hednoma[] = "10046";
        $hednoma[] = "10047";
        $hednoma[] = "10048";
        $hednoma[] = "10049";
        $hednoma[] = "10050";
        $hednoma[] = "11001";
        $hednoma[] = "11002";
        $hednoma[] = "11003";
        $hednoma[] = "11004";
        $hednoma[] = "11005";
        $hednoma[] = "11006";
        $hednoma[] = "11007";
        $hednoma[] = "11008";
        $hednoma[] = "11009";
        $hednoma[] = "11010";
        $hednoma[] = "11011";
        $hednoma[] = "11012";
        $hednoma[] = "11013";
        $hednoma[] = "11014";
        $hednoma[] = "11015";
        $hednoma[] = "11016";
        $hednoma[] = "11017";
        $hednoma[] = "11018";
        $hednoma[] = "11019";
        $hednoma[] = "11020";
        $hednoma[] = "11021";
        $hednoma[] = "11022";
        $hednoma[] = "11023";
        $hednoma[] = "11024";
        $hednoma[] = "11025";
        $hednoma[] = "11026";
        $hednoma[] = "11027";
        $hednoma[] = "11028";
        $hednoma[] = "11029";
        $hednoma[] = "11030";
        $hednoma[] = "11031";
        $hednoma[] = "11032";
        $hednoma[] = "11033";
        $hednoma[] = "11034";
        $hednoma[] = "11035";
        $hednoma[] = "11036";
        $hednoma[] = "11037";
        $hednoma[] = "11038";
        $hednoma[] = "11039";
        $hednoma[] = "11040";
        $hednoma[] = "11041";
        $hednoma[] = "11042";
        $hednoma[] = "11043";
        $hednoma[] = "11044";
        $hednoma[] = "11045";
        $hednoma[] = "11046";
        $hednoma[] = "11047";
        $hednoma[] = "11048";
        $hednoma[] = "11049";
        $hednoma[] = "11050";
        $hednoma[] = "HP_0001";
        $hednoma[] = "HP_0002";
        $hednoma[] = "HP_0003";
        $hednoma[] = "HP_0004";
        $hednoma[] = "HP_0005";
        $hednoma[] = "HP_0006";
        $hednoma[] = "HP_0007";
        $hednoma[] = "HP_0008";
        $hednoma[] = "HP_0009";
        $hednoma[] = "HP_0010";
        $hednoma[] = "HP_0011";
        $hednoma[] = "HP_0012";
        $hednoma[] = "HP_0013";
        $hednoma[] = "HP_0014";
        $hednoma[] = "HP_0015";
        $hednoma[] = "HP_0016";
        $hednoma[] = "HP_0017";
        $hednoma[] = "HP_0018";
        $hednoma[] = "HP_0019";
        $hednoma[] = "HP_0020";
        $hednoma[] = "HP_0021";
        $hednoma[] = "HP_0022";
        $hednoma[] = "HP_0023";
        $hednoma[] = "HP_0024";
        $hednoma[] = "HP_0025";
        $hednoma[] = "HP_0026";
        $hednoma[] = "HP_0027";
        $hednoma[] = "HP_0028";
        $hednoma[] = "HP_0029";
        $hednoma[] = "HP_0030";
        $hednoma[] = "HP_0031";
        $hednoma[] = "HP_0032";
        $hednoma[] = "HP_0033";
        $hednoma[] = "HP_0034";
        $hednoma[] = "HP_0035";
        $hednoma[] = "HP_0036";
        $hednoma[] = "HP_0037";
        $hednoma[] = "HP_0038";
        $hednoma[] = "HP_0039";
        $hednoma[] = "HP_0040";
        $hednoma[] = "HP_0041";
        $hednoma[] = "HP_0042";
        $hednoma[] = "HP_0043";
        $hednoma[] = "HP_0044";
        $hednoma[] = "HP_0045";
        $hednoma[] = "HP_0046";
        $hednoma[] = "HP_0047";
        $hednoma[] = "HP_0048";
        $hednoma[] = "HP_0049";
        $hednoma[] = "HP_0050";
        $hednoma[] = "HP_0051";
        $hednoma[] = "HP_0052";
        $hednoma[] = "HP_0053";
        $hednoma[] = "HP_0054";
        $hednoma[] = "HP_0055";
        $hednoma[] = "HP_0056";
        $hednoma[] = "HP_0057";
        $hednoma[] = "HP_0058";
        $hednoma[] = "HP_0059";
        $hednoma[] = "HP_0060";
        $hednoma[] = "HP_0061";
        $hednoma[] = "HP_0062";
        $hednoma[] = "HP_0063";
        $hednoma[] = "HP_0064";
        $hednoma[] = "HP_0065";
        $hednoma[] = "HP_0066";
        $hednoma[] = "HP_0067";
        $hednoma[] = "HP_0068";
        $hednoma[] = "HP_0069";
        $hednoma[] = "HP_0070";
        $hednoma[] = "HP_0071";
        $hednoma[] = "HP_0072";
        $hednoma[] = "HP_0073";
        $hednoma[] = "HP_0074";
        $hednoma[] = "HP_0075";
        $hednoma[] = "HP_0076";
        $hednoma[] = "HP_0077";
        $hednoma[] = "HP_0078";
        $hednoma[] = "HP_0079";
        $hednoma[] = "HP_0080";
        $hednoma[] = "HP_0081";
        $hednoma[] = "HP_0082";
        $hednoma[] = "HP_0083";
        $hednoma[] = "HP_0084";
        $hednoma[] = "HP_0085";
        $hednoma[] = "HP_0086";
        $hednoma[] = "HP_0087";
        $hednoma[] = "HP_0088";
        $hednoma[] = "HP_0089";
        $hednoma[] = "HP_0090";
        $hednoma[] = "HP_0091";
        $hednoma[] = "HP_0092";
        $hednoma[] = "HP_0093";
        $hednoma[] = "HP_0094";
        $hednoma[] = "HP_0095";
        $hednoma[] = "HP_0096";
        $hednoma[] = "HP_0097";
        $hednoma[] = "HP_0098";
        $hednoma[] = "HP_0099";
        $hednoma[] = "HP_0100";
        $hednoma[] = "HP_0101";
        $hednoma[] = "HP_0102";
        $hednoma[] = "HP_0103";
        $hednoma[] = "HP_0104";
        $hednoma[] = "HP_0105";
        $hednoma[] = "HP_0106";
        $hednoma[] = "HP_0107";
        $hednoma[] = "HP_0108";
        $hednoma[] = "HP_0109";
        $hednoma[] = "HP_0110";
        $hednoma[] = "HP_0111";
        $hednoma[] = "HP_0112";
        $hednoma[] = "HP_0113";
        $hednoma[] = "HP_0114";
        $hednoma[] = "HP_0115";
        $hednoma[] = "HP_0116";
        $hednoma[] = "HP_0117";
        $hednoma[] = "HP_0118";
        $hednoma[] = "HP_0119";
        $hednoma[] = "HP_0120";
        $hednoma[] = "HP_0121";
        $hednoma[] = "HP_0122";
        $hednoma[] = "HP_0123";
        $hednoma[] = "HP_0124";
        $hednoma[] = "HP_0125";
        $hednoma[] = "HP_0126";
        $hednoma[] = "HP_0127";
        $hednoma[] = "HP_0128";
        $hednoma[] = "HP_0129";
        $hednoma[] = "HP_0130";
        $hednoma[] = "HP_0131";
        $hednoma[] = "HP_0132";
        $hednoma[] = "HP_0133";
        $hednoma[] = "HP_0134";
        $hednoma[] = "HP_0135";
        $hednoma[] = "HP_0136";
        $hednoma[] = "HP_0137";
        $hednoma[] = "HP_0138";
        $hednoma[] = "HP_0139";
        $hednoma[] = "HP_0140";
        $hednoma[] = "HP_0141";
        $hednoma[] = "HP_0142";
        $hednoma[] = "HP_0143";
        $hednoma[] = "HP_0144";
        $hednoma[] = "HP_0145";
        $hednoma[] = "HP_0146";
        $hednoma[] = "HP_0147";
        $hednoma[] = "HP_0148";
        $hednoma[] = "HP_0149";
        $hednoma[] = "HP_0150";
        $hednoma[] = "HP_0151";
        $hednoma[] = "HP_0152";
        $hednoma[] = "HP_0153";
        $hednoma[] = "HP_0154";
        $hednoma[] = "HP_0155";
        $hednoma[] = "HP_0156";
        $hednoma[] = "HP_0157";
        $hednoma[] = "HP_0158";
        $hednoma[] = "HP_0159";
        $hednoma[] = "HP_0160";


        if (in_array($macLookFor, $hednoma)) {

            return 1;
        } else {

            return 2;
        }
    }

    function getHednoData($macLookFor) {

        $arrayALL[] = "10001";
        $arrayALL[] = "10002";
        $arrayALL[] = "10003";
        $arrayALL[] = "10004";
        $arrayALL[] = "10005";
        $arrayALL[] = "10006";
        $arrayALL[] = "10007";
        $arrayALL[] = "10008";
        $arrayALL[] = "10009";
        $arrayALL[] = "10010";
        $arrayALL[] = "10011";
        $arrayALL[] = "10012";
        $arrayALL[] = "10013";
        $arrayALL[] = "10014";
        $arrayALL[] = "10015";
        $arrayALL[] = "10016";
        $arrayALL[] = "10017";
        $arrayALL[] = "10018";
        $arrayALL[] = "10019";
        $arrayALL[] = "10020";
        $arrayALL[] = "10021";
        $arrayALL[] = "10022";
        $arrayALL[] = "10023";
        $arrayALL[] = "10024";
        $arrayALL[] = "10025";
        $arrayALL[] = "10026";
        $arrayALL[] = "10027";
        $arrayALL[] = "10028";
        $arrayALL[] = "10029";
        $arrayALL[] = "10030";
        $arrayALL[] = "10031";
        $arrayALL[] = "10032";
        $arrayALL[] = "10033";
        $arrayALL[] = "10034";
        $arrayALL[] = "10035";
        $arrayALL[] = "10036";
        $arrayALL[] = "10037";
        $arrayALL[] = "10038";
        $arrayALL[] = "10039";
        $arrayALL[] = "10040";
        $arrayALL[] = "10041";
        $arrayALL[] = "10042";
        $arrayALL[] = "10043";
        $arrayALL[] = "10044";
        $arrayALL[] = "10045";
        $arrayALL[] = "10046";
        $arrayALL[] = "10047";
        $arrayALL[] = "10048";
        $arrayALL[] = "10049";
        $arrayALL[] = "10050";
        $arrayALL[] = "11001";
        $arrayALL[] = "11002";
        $arrayALL[] = "11003";
        $arrayALL[] = "11004";
        $arrayALL[] = "11005";
        $arrayALL[] = "11006";
        $arrayALL[] = "11007";
        $arrayALL[] = "11008";
        $arrayALL[] = "11009";
        $arrayALL[] = "11010";
        $arrayALL[] = "11011";
        $arrayALL[] = "11012";
        $arrayALL[] = "11013";
        $arrayALL[] = "11014";
        $arrayALL[] = "11015";
        $arrayALL[] = "11016";
        $arrayALL[] = "11017";
        $arrayALL[] = "11018";
        $arrayALL[] = "11019";
        $arrayALL[] = "11020";
        $arrayALL[] = "11021";
        $arrayALL[] = "11022";
        $arrayALL[] = "11023";
        $arrayALL[] = "11024";
        $arrayALL[] = "11025";
        $arrayALL[] = "11026";
        $arrayALL[] = "11027";
        $arrayALL[] = "11028";
        $arrayALL[] = "11029";
        $arrayALL[] = "11030";
        $arrayALL[] = "11031";
        $arrayALL[] = "11032";
        $arrayALL[] = "11033";
        $arrayALL[] = "11034";
        $arrayALL[] = "11035";
        $arrayALL[] = "11036";
        $arrayALL[] = "11037";
        $arrayALL[] = "11038";
        $arrayALL[] = "11039";
        $arrayALL[] = "11040";
        $arrayALL[] = "11041";
        $arrayALL[] = "11042";
        $arrayALL[] = "11043";
        $arrayALL[] = "11044";
        $arrayALL[] = "11045";
        $arrayALL[] = "11046";
        $arrayALL[] = "11047";
        $arrayALL[] = "11048";
        $arrayALL[] = "11049";
        $arrayALL[] = "11050";
        $arrayALL[] = "3001";
        $arrayALL[] = "3002";
        $arrayALL[] = "3003";
        $arrayALL[] = "3004";
        $arrayALL[] = "3005";
        $arrayALL[] = "3006";
        $arrayALL[] = "3007";
        $arrayALL[] = "3008";
        $arrayALL[] = "3009";
        $arrayALL[] = "3010";
        $arrayALL[] = "3011";
        $arrayALL[] = "3012";
        $arrayALL[] = "3013";
        $arrayALL[] = "3014";
        $arrayALL[] = "3015";
        $arrayALL[] = "3016";
        $arrayALL[] = "3017";
        $arrayALL[] = "3018";
        $arrayALL[] = "3019";
        $arrayALL[] = "3020";
        $arrayALL[] = "3021";
        $arrayALL[] = "3022";
        $arrayALL[] = "3023";
        $arrayALL[] = "3024";
        $arrayALL[] = "3025";
        $arrayALL[] = "3026";
        $arrayALL[] = "3027";
        $arrayALL[] = "3028";
        $arrayALL[] = "3029";
        $arrayALL[] = "3030";
        $arrayALL[] = "3031";
        $arrayALL[] = "3032";
        $arrayALL[] = "3033";
        $arrayALL[] = "3034";
        $arrayALL[] = "3035";
        $arrayALL[] = "3036";
        $arrayALL[] = "3037";
        $arrayALL[] = "3038";
        $arrayALL[] = "3039";
        $arrayALL[] = "3040";
        $arrayALL[] = "4001";
        $arrayALL[] = "4002";
        $arrayALL[] = "4003";
        $arrayALL[] = "4004";
        $arrayALL[] = "4005";
        $arrayALL[] = "4006";
        $arrayALL[] = "4007";
        $arrayALL[] = "4008";
        $arrayALL[] = "4009";
        $arrayALL[] = "4010";
        $arrayALL[] = "4011";
        $arrayALL[] = "4012";
        $arrayALL[] = "4013";
        $arrayALL[] = "4014";
        $arrayALL[] = "4015";
        $arrayALL[] = "4016";
        $arrayALL[] = "4017";
        $arrayALL[] = "4018";
        $arrayALL[] = "4019";
        $arrayALL[] = "4020";
        $arrayALL[] = "4021";
        $arrayALL[] = "4022";
        $arrayALL[] = "4023";
        $arrayALL[] = "4024";
        $arrayALL[] = "4025";
        $arrayALL[] = "4026";
        $arrayALL[] = "4027";
        $arrayALL[] = "4028";
        $arrayALL[] = "4029";
        $arrayALL[] = "4030";
        $arrayALL[] = "4031";
        $arrayALL[] = "4032";
        $arrayALL[] = "4033";
        $arrayALL[] = "4034";
        $arrayALL[] = "4035";
        $arrayALL[] = "4036";
        $arrayALL[] = "4037";
        $arrayALL[] = "4038";
        $arrayALL[] = "4039";
        $arrayALL[] = "4040";
        $arrayALL[] = "4041";
        $arrayALL[] = "4042";
        $arrayALL[] = "4043";
        $arrayALL[] = "4044";
        $arrayALL[] = "4045";
        $arrayALL[] = "4046";
        $arrayALL[] = "4047";
        $arrayALL[] = "4048";
        $arrayALL[] = "4049";
        $arrayALL[] = "4050";
        $arrayALL[] = "5001";
        $arrayALL[] = "5002";
        $arrayALL[] = "5003";
        $arrayALL[] = "5004";
        $arrayALL[] = "5005";
        $arrayALL[] = "5006";
        $arrayALL[] = "5007";
        $arrayALL[] = "5008";
        $arrayALL[] = "5009";
        $arrayALL[] = "5010";
        $arrayALL[] = "5011";
        $arrayALL[] = "5012";
        $arrayALL[] = "5013";
        $arrayALL[] = "5014";
        $arrayALL[] = "5015";
        $arrayALL[] = "5016";
        $arrayALL[] = "5017";
        $arrayALL[] = "5018";
        $arrayALL[] = "5019";
        $arrayALL[] = "5020";
        $arrayALL[] = "5021";
        $arrayALL[] = "5022";
        $arrayALL[] = "5023";
        $arrayALL[] = "5024";
        $arrayALL[] = "5025";
        $arrayALL[] = "5026";
        $arrayALL[] = "5027";
        $arrayALL[] = "5028";
        $arrayALL[] = "5029";
        $arrayALL[] = "5030";
        $arrayALL[] = "5031";
        $arrayALL[] = "5032";
        $arrayALL[] = "5033";
        $arrayALL[] = "5034";
        $arrayALL[] = "5035";
        $arrayALL[] = "5036";
        $arrayALL[] = "5037";
        $arrayALL[] = "5038";
        $arrayALL[] = "5039";
        $arrayALL[] = "5040";
        $arrayALL[] = "5041";
        $arrayALL[] = "5042";
        $arrayALL[] = "5043";
        $arrayALL[] = "5044";
        $arrayALL[] = "5045";
        $arrayALL[] = "5046";
        $arrayALL[] = "5047";
        $arrayALL[] = "5048";
        $arrayALL[] = "5049";
        $arrayALL[] = "5050";
        $arrayALL[] = "6001";
        $arrayALL[] = "6002";
        $arrayALL[] = "6003";
        $arrayALL[] = "6004";
        $arrayALL[] = "6005";
        $arrayALL[] = "6006";
        $arrayALL[] = "6007";
        $arrayALL[] = "6008";
        $arrayALL[] = "6009";
        $arrayALL[] = "6010";
        $arrayALL[] = "6011";
        $arrayALL[] = "6012";
        $arrayALL[] = "6013";
        $arrayALL[] = "6014";
        $arrayALL[] = "6015";
        $arrayALL[] = "6016";
        $arrayALL[] = "6017";
        $arrayALL[] = "6018";
        $arrayALL[] = "6019";
        $arrayALL[] = "6020";
        $arrayALL[] = "6021";
        $arrayALL[] = "6022";
        $arrayALL[] = "6023";
        $arrayALL[] = "6024";
        $arrayALL[] = "6025";
        $arrayALL[] = "6026";
        $arrayALL[] = "6027";
        $arrayALL[] = "6028";
        $arrayALL[] = "6029";
        $arrayALL[] = "6030";
        $arrayALL[] = "6031";
        $arrayALL[] = "6032";
        $arrayALL[] = "6033";
        $arrayALL[] = "6034";
        $arrayALL[] = "6035";
        $arrayALL[] = "6036";
        $arrayALL[] = "6037";
        $arrayALL[] = "6038";
        $arrayALL[] = "6039";
        $arrayALL[] = "6040";
        $arrayALL[] = "6041";
        $arrayALL[] = "6042";
        $arrayALL[] = "6043";
        $arrayALL[] = "6044";
        $arrayALL[] = "6045";
        $arrayALL[] = "6046";
        $arrayALL[] = "6047";
        $arrayALL[] = "6048";
        $arrayALL[] = "6049";
        $arrayALL[] = "6050";
        $arrayALL[] = "7001";
        $arrayALL[] = "7002";
        $arrayALL[] = "7003";
        $arrayALL[] = "7004";
        $arrayALL[] = "7005";
        $arrayALL[] = "7006";
        $arrayALL[] = "7007";
        $arrayALL[] = "7008";
        $arrayALL[] = "7009";
        $arrayALL[] = "7010";
        $arrayALL[] = "7011";
        $arrayALL[] = "7012";
        $arrayALL[] = "7013";
        $arrayALL[] = "7014";
        $arrayALL[] = "7015";
        $arrayALL[] = "7016";
        $arrayALL[] = "7017";
        $arrayALL[] = "7018";
        $arrayALL[] = "7019";
        $arrayALL[] = "7020";
        $arrayALL[] = "7021";
        $arrayALL[] = "7022";
        $arrayALL[] = "7023";
        $arrayALL[] = "7024";
        $arrayALL[] = "7025";
        $arrayALL[] = "7026";
        $arrayALL[] = "7027";
        $arrayALL[] = "7028";
        $arrayALL[] = "7029";
        $arrayALL[] = "7030";
        $arrayALL[] = "7031";
        $arrayALL[] = "7032";
        $arrayALL[] = "7033";
        $arrayALL[] = "7034";
        $arrayALL[] = "7035";
        $arrayALL[] = "7036";
        $arrayALL[] = "7037";
        $arrayALL[] = "7038";
        $arrayALL[] = "7039";
        $arrayALL[] = "7040";
        $arrayALL[] = "7041";
        $arrayALL[] = "7042";
        $arrayALL[] = "7043";
        $arrayALL[] = "7044";
        $arrayALL[] = "7045";
        $arrayALL[] = "7046";
        $arrayALL[] = "7047";
        $arrayALL[] = "7048";
        $arrayALL[] = "7049";
        $arrayALL[] = "7050";
        $arrayALL[] = "8001";
        $arrayALL[] = "8002";
        $arrayALL[] = "8003";
        $arrayALL[] = "8004";
        $arrayALL[] = "8005";
        $arrayALL[] = "8006";
        $arrayALL[] = "8007";
        $arrayALL[] = "8008";
        $arrayALL[] = "8009";
        $arrayALL[] = "8010";
        $arrayALL[] = "8011";
        $arrayALL[] = "8012";
        $arrayALL[] = "8013";
        $arrayALL[] = "8014";
        $arrayALL[] = "8015";
        $arrayALL[] = "8016";
        $arrayALL[] = "8017";
        $arrayALL[] = "8018";
        $arrayALL[] = "8019";
        $arrayALL[] = "8020";
        $arrayALL[] = "8021";
        $arrayALL[] = "8022";
        $arrayALL[] = "8023";
        $arrayALL[] = "8024";
        $arrayALL[] = "8025";
        $arrayALL[] = "8026";
        $arrayALL[] = "8027";
        $arrayALL[] = "8028";
        $arrayALL[] = "8029";
        $arrayALL[] = "8030";
        $arrayALL[] = "8031";
        $arrayALL[] = "8032";
        $arrayALL[] = "8033";
        $arrayALL[] = "8034";
        $arrayALL[] = "8035";
        $arrayALL[] = "8036";
        $arrayALL[] = "8037";
        $arrayALL[] = "8038";
        $arrayALL[] = "8039";
        $arrayALL[] = "8040";
        $arrayALL[] = "8041";
        $arrayALL[] = "8042";
        $arrayALL[] = "8043";
        $arrayALL[] = "8044";
        $arrayALL[] = "8045";
        $arrayALL[] = "8046";
        $arrayALL[] = "8047";
        $arrayALL[] = "8048";
        $arrayALL[] = "8049";
        $arrayALL[] = "8050";
        $arrayALL[] = "9001";
        $arrayALL[] = "9002";
        $arrayALL[] = "9003";
        $arrayALL[] = "9004";
        $arrayALL[] = "9005";
        $arrayALL[] = "9006";
        $arrayALL[] = "9007";
        $arrayALL[] = "9008";
        $arrayALL[] = "9009";
        $arrayALL[] = "9010";
        $arrayALL[] = "9011";
        $arrayALL[] = "9012";
        $arrayALL[] = "9013";
        $arrayALL[] = "9014";
        $arrayALL[] = "9015";
        $arrayALL[] = "9016";
        $arrayALL[] = "9017";
        $arrayALL[] = "9018";
        $arrayALL[] = "9019";
        $arrayALL[] = "9020";
        $arrayALL[] = "9021";
        $arrayALL[] = "9022";
        $arrayALL[] = "9023";
        $arrayALL[] = "9024";
        $arrayALL[] = "9025";
        $arrayALL[] = "9026";
        $arrayALL[] = "9027";
        $arrayALL[] = "9028";
        $arrayALL[] = "9029";
        $arrayALL[] = "9030";
        $arrayALL[] = "9031";
        $arrayALL[] = "9032";
        $arrayALL[] = "9033";
        $arrayALL[] = "9034";
        $arrayALL[] = "9035";
        $arrayALL[] = "9036";
        $arrayALL[] = "9037";
        $arrayALL[] = "9038";
        $arrayALL[] = "9039";
        $arrayALL[] = "9040";
        $arrayALL[] = "9041";
        $arrayALL[] = "9042";
        $arrayALL[] = "9043";
        $arrayALL[] = "9044";
        $arrayALL[] = "9045";
        $arrayALL[] = "9046";
        $arrayALL[] = "HP_0001";
        $arrayALL[] = "HP_0002";
        $arrayALL[] = "HP_0003";
        $arrayALL[] = "HP_0004";
        $arrayALL[] = "HP_0005";
        $arrayALL[] = "HP_0006";
        $arrayALL[] = "HP_0007";
        $arrayALL[] = "HP_0008";
        $arrayALL[] = "HP_0009";
        $arrayALL[] = "HP_0010";
        $arrayALL[] = "HP_0011";
        $arrayALL[] = "HP_0012";
        $arrayALL[] = "HP_0013";
        $arrayALL[] = "HP_0014";
        $arrayALL[] = "HP_0015";
        $arrayALL[] = "HP_0016";
        $arrayALL[] = "HP_0017";
        $arrayALL[] = "HP_0018";
        $arrayALL[] = "HP_0019";
        $arrayALL[] = "HP_0020";
        $arrayALL[] = "HP_0021";
        $arrayALL[] = "HP_0022";
        $arrayALL[] = "HP_0023";
        $arrayALL[] = "HP_0024";
        $arrayALL[] = "HP_0025";
        $arrayALL[] = "HP_0026";
        $arrayALL[] = "HP_0027";
        $arrayALL[] = "HP_0028";
        $arrayALL[] = "HP_0029";
        $arrayALL[] = "HP_0030";
        $arrayALL[] = "HP_0031";
        $arrayALL[] = "HP_0032";
        $arrayALL[] = "HP_0033";
        $arrayALL[] = "HP_0034";
        $arrayALL[] = "HP_0035";
        $arrayALL[] = "HP_0036";
        $arrayALL[] = "HP_0037";
        $arrayALL[] = "HP_0038";
        $arrayALL[] = "HP_0039";
        $arrayALL[] = "HP_0040";
        $arrayALL[] = "HP_0041";
        $arrayALL[] = "HP_0042";
        $arrayALL[] = "HP_0043";
        $arrayALL[] = "HP_0044";
        $arrayALL[] = "HP_0045";
        $arrayALL[] = "HP_0046";
        $arrayALL[] = "HP_0047";
        $arrayALL[] = "HP_0048";
        $arrayALL[] = "HP_0049";
        $arrayALL[] = "HP_0050";
        $arrayALL[] = "HP_0051";
        $arrayALL[] = "HP_0052";
        $arrayALL[] = "HP_0053";
        $arrayALL[] = "HP_0054";
        $arrayALL[] = "HP_0055";
        $arrayALL[] = "HP_0056";
        $arrayALL[] = "HP_0057";
        $arrayALL[] = "HP_0058";
        $arrayALL[] = "HP_0059";
        $arrayALL[] = "HP_0060";
        $arrayALL[] = "HP_0061";
        $arrayALL[] = "HP_0062";
        $arrayALL[] = "HP_0063";
        $arrayALL[] = "HP_0064";
        $arrayALL[] = "HP_0065";
        $arrayALL[] = "HP_0066";
        $arrayALL[] = "HP_0067";
        $arrayALL[] = "HP_0068";
        $arrayALL[] = "HP_0069";
        $arrayALL[] = "HP_0070";
        $arrayALL[] = "HP_0071";
        $arrayALL[] = "HP_0072";
        $arrayALL[] = "HP_0073";
        $arrayALL[] = "HP_0074";
        $arrayALL[] = "HP_0075";
        $arrayALL[] = "HP_0076";
        $arrayALL[] = "HP_0077";
        $arrayALL[] = "HP_0078";
        $arrayALL[] = "HP_0079";
        $arrayALL[] = "HP_0080";
        $arrayALL[] = "HP_0081";
        $arrayALL[] = "HP_0082";
        $arrayALL[] = "HP_0083";
        $arrayALL[] = "HP_0084";
        $arrayALL[] = "HP_0085";
        $arrayALL[] = "HP_0086";
        $arrayALL[] = "HP_0087";
        $arrayALL[] = "HP_0088";
        $arrayALL[] = "HP_0089";
        $arrayALL[] = "HP_0090";
        $arrayALL[] = "HP_0091";
        $arrayALL[] = "HP_0092";
        $arrayALL[] = "HP_0093";
        $arrayALL[] = "HP_0094";
        $arrayALL[] = "HP_0095";
        $arrayALL[] = "HP_0096";
        $arrayALL[] = "HP_0097";
        $arrayALL[] = "HP_0098";
        $arrayALL[] = "HP_0099";
        $arrayALL[] = "HP_0100";
        $arrayALL[] = "HP_0101";
        $arrayALL[] = "HP_0102";
        $arrayALL[] = "HP_0103";
        $arrayALL[] = "HP_0104";
        $arrayALL[] = "HP_0105";
        $arrayALL[] = "HP_0106";
        $arrayALL[] = "HP_0107";
        $arrayALL[] = "HP_0108";
        $arrayALL[] = "HP_0109";
        $arrayALL[] = "HP_0110";
        $arrayALL[] = "HP_0111";
        $arrayALL[] = "HP_0112";
        $arrayALL[] = "HP_0113";
        $arrayALL[] = "HP_0114";
        $arrayALL[] = "HP_0115";
        $arrayALL[] = "HP_0116";
        $arrayALL[] = "HP_0117";
        $arrayALL[] = "HP_0118";
        $arrayALL[] = "HP_0119";
        $arrayALL[] = "HP_0120";
        $arrayALL[] = "HP_0121";
        $arrayALL[] = "HP_0122";
        $arrayALL[] = "HP_0123";
        $arrayALL[] = "HP_0124";
        $arrayALL[] = "HP_0125";
        $arrayALL[] = "HP_0126";
        $arrayALL[] = "HP_0127";
        $arrayALL[] = "HP_0128";
        $arrayALL[] = "HP_0129";
        $arrayALL[] = "HP_0130";
        $arrayALL[] = "HP_0131";
        $arrayALL[] = "HP_0132";
        $arrayALL[] = "HP_0133";
        $arrayALL[] = "HP_0134";
        $arrayALL[] = "HP_0135";
        $arrayALL[] = "HP_0136";
        $arrayALL[] = "HP_0137";
        $arrayALL[] = "HP_0138";
        $arrayALL[] = "HP_0139";
        $arrayALL[] = "HP_0140";
        $arrayALL[] = "HP_0141";
        $arrayALL[] = "HP_0142";
        $arrayALL[] = "HP_0143";
        $arrayALL[] = "HP_0144";
        $arrayALL[] = "HP_0145";
        $arrayALL[] = "HP_0146";
        $arrayALL[] = "HP_0147";
        $arrayALL[] = "HP_0148";
        $arrayALL[] = "HP_0149";
        $arrayALL[] = "HP_0150";
        $arrayALL[] = "HP_0151";
        $arrayALL[] = "HP_0152";
        $arrayALL[] = "HP_0153";
        $arrayALL[] = "HP_0154";
        $arrayALL[] = "HP_0155";
        $arrayALL[] = "HP_0156";
        $arrayALL[] = "HP_0157";
        $arrayALL[] = "HP_0158";
        $arrayALL[] = "HP_0159";
        $arrayALL[] = "HP_0160";

        if (in_array($macLookFor, $arrayALL)) {

            return 1;
        } else {

            return 2;
        }
    }

}
