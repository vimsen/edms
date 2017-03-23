<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of process_model2
 *
 * @author hulk
 */
class process_model2 extends CI_Model{
    //put your code here
    
    function validate($data) {

        $returnData = array();

        $returnData["startDate"] = strip_tags(trim($data["startdate"]));

        $returnData["endDate"] = strip_tags(trim($data["enddate"]));

        $returnData["mac"] = strip_tags(trim($data["prosumers"]));

        if (isset($data["total"])) {
            $returnData["total"] = strip_tags(trim($data["total"]));
        } else {
            $returnData["total"] = 0;
        }


        $returnData["interval"] = strip_tags(trim($data["interval"]));

        $returnData["pointer"] = 2;

        if (mb_strlen($returnData["pointer"], 'UTF-8') > 5) {// 
            exit("Pointer Lenght too long");
        }


        if (mb_strlen($returnData["startDate"], 'UTF-8') > 30) {// 
            exit("Start Date Lenght too long");
        }


        if (mb_strlen($returnData["endDate"], 'UTF-8') > 30) {// 
            exit("End Date Lenght too long");
        }

        if (mb_strlen($returnData["mac"], 'UTF-8') > 90) {// 
            exit("Prosumers Lenght too long");
        }

        if (mb_strlen($returnData["interval"], 'UTF-8') > 30) {// 
            exit("Interval Lenght too long");
        }

        if (mb_strlen($returnData["interval"], 'UTF-8') > 1) {// 
            if (ctype_digit($returnData["interval"]) && (int) $returnData["interval"] > 0) {
                
            } else {

                exit("Interval is not a number");
            }
        }

        if ($returnData["total"] == 1) {

            $returnData["Ptotal"] = 1;
        }else{
            $returnData["Ptotal"] = "";
        }


        return $returnData;
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
    
    
       function block_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($interval == 60) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($group < 1) {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, 900, $pointer);
            } else {

                $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            }
        } else {

            $data = $this->retrieve_data_now($startDate, $endDate, $mac, $Ptotal);
        }
    }
    
      function block_data_past($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($interval == 60) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($group < 1) {


                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, 900, $pointer);
            } else {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            }
        } else {

            $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal);
        }
    }
    
     function block_data_mainsource_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval) {


        if ($interval) {

            $group = $interval / 900;

            if ($interval == 300) {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($interval == 60) {

                $data = $this->retrieve_dataHistory($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            } elseif ($group < 1) {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, 900, $pointer);
            } else {

                $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer);
            }
        } else {

            $data = $this->retrieve_data_join_past_present($startDate, $endDate, $mac, $Ptotal);
        }
    }
    
    
    function retrieve_data_now($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null) {
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
        $pointer = 2;

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

                $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));

                $sql_3 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql_4 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";
              
                $query1 = $this->db->query($sql1);

                foreach ($query1->result() as $row1) {

                    if ($row1->topic_c == "PV1_production_power") {

                        $macID = $row1->mac;
                        $production_result = $row1->sumPayload / $row1->countField;
                        $production_resultf = $production_result * $interval / 3600;

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


                if ($query_2->num_rows() > 1) {

                    foreach ($query_2->result() as $row_2) {

                        $macID = $row_2->mac;
                        $total_energy_consumption[] = $row_2->payload;
                        $total_energy_consumption_date[] = $row_2->time;
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

                    $total_energy_consumptionResult_forecast = unserialize($row_3->total_energy_consumptionResult); 
                }


                $query4 = $this->db->query($sql_4);

                foreach ($query4->result() as $row4) {

                    $production_forecast = unserialize($row4->production_forecast); 
                }
           

                $max = sizeof($total_energy_consumption);

                for ($i = 0; $i < $max; $i++) {
                    if (isset($total_energy_consumption[$i + 1])) {

                        if ($total_energy_consumption[$i] > $total_energy_consumption[$i + 1]) {

                            $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i + 1], 2, ',', '')));
                        } else {
                            $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i + 1] - $total_energy_consumption[$i], 2, ',', '')));
                        }

                        $flag = $total_energy_consumption[$i] - $total_energy_consumption[$i + 1];
                    } elseif ($i + 1 == $max) {

                        if (sizeof($total_energy_consumption) > 1) {
                            if ($total_energy_consumption[$i] > $total_energy_consumption[$i - 1]) {
                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i - 1], 2, ',', '')));
                            } else {

                                $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i - 1] - $total_energy_consumption[$i], 2, ',', '')));
                            }
                        } else {

                            $total_energy_consumptionResult[$i] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i], 2, ',', '')));
                        }
                    }
                }


               

                $this->apiCallUpate("getdataVGW_get", "end");

                $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
              
                exit(json_encode($main_data));
            }
             elseif ($pointer == 3) {

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
    
     function retrieve_dataHistory($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null) {

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
      
          $switch_date2 = 0;
          $pointer = 2;
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
                

            }elseif($interval == 3600){
                
                
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

                
                
            }elseif($interval == 86400){

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
                
                
                
            }elseif($interval == 300){
                
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

                
            }elseif($interval == 60){
                
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

                
            }
            
              $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));


                $sql5 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql6 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";

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
                         $macID = $row->mac;
                        $production_batteryPercentage[] = array(str_replace(" ", "T", $row->received) . '.000+02:00' => $row->payload);
                    }
                }
                
                
                    $query1 = $this->db->query($sql1);

                foreach ($query1->result() as $row1) {

                    if ($row1->topic_c == "PV1_production_power") {
                         $macID = $row1->mac;
                        $production[] = array(str_replace(" ", "T", $row1->received) . '.000+02:00' => $row1->payload);
                    }
                }
         

              $query3 = $this->db->query($sql3);
              if($query3->num_rows()>1){
                  
                   foreach ($query3->result() as $row3) {
                     $macID = $row3->mac;  
                     $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row3->received) . '.000+02:00' => $row3->payload);     
                                           
                   }  
                  
              }else{
                  
                $query4 = $this->db->query($sql4);  
                  
                 if($query4->num_rows()>1){
                     
                    foreach ($query4->result() as $row4) {
                                     $macID = $row4->mac;  
                     $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row4->received) . '.000+02:00' => $row4->payload);     
                                           
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
              
              

            $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage,'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
            $this->apiCallUpate("getdataVGW_get", "end");
            exit(json_encode($main_data));
        }
    }
    
      function retrieve_data_join_past_present($startdate, $enddate, $mac = null, $total, $interval = null, $pointer = null) {
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
        $pointer = 2;

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
                

            }elseif($interval == 3600){
                
                
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

         
            }elseif($interval == 86400){
                
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

    
            }elseif($interval == 300){
                
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

                
            }elseif($interval == 60){
                
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
               
            
              $forcastindex = 0;
                if ($switch_date2 == 6) {

                    $forcastindex = 0;
                } else {

                    $forcastindex = $switch_date2 + 1;
                }

                $tomorrowDay = date("Y-m-d", strtotime("+ 1 day"));


                $sql5 = "select vimJson as total_energy_consumptionResult from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='total_energy_consumptionResult' and dateInsertCall='$OneDayAhead'";

                $sql6 = "select vimJson as production_forecast from VimsentPlatform.vimsentForecastTemp where mac='$mac' and vimDay='$forcastindex' and forecast='production_forecast' and dateInsertCall='$OneDayAhead'";

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
                        $production_resultf = $production_result * $interval / 3600;
                        $production[] = array($row1_present->time . '.000+02:00' => number_format($production_resultf, 2, '.', ''));
                    }
                }
         

              $query3 = $this->db->query($sql3);
              if($query3->num_rows()>1){
                  
                   foreach ($query3->result() as $row3) {
                                    
                     $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row3->received) . '.000+02:00' => $row3->payload);     
                                           
                   }  
                  
              }else{
                  
                $query4 = $this->db->query($sql4);  
                  
                 if($query4->num_rows()>1){
                     
                    foreach ($query4->result() as $row4) {
                                    
                     $total_energy_consumptionResult[] = array(str_replace(" ", "T", $row4->received) . '.000+02:00' => $row4->payload);     
                                           
                   } 
                     
                 }
                  
              }
              
              
               $query_2_present = $this->db->query($sql_2_present);


                if ($query_2_present->num_rows() > 1) {

                    foreach ($query_2_present->result() as $row_2_present) {

                        $macID = $row_2_present->mac;
                        $total_energy_consumption[] = $row_2_present->payload;
                        $total_energy_consumption_date[] = $row_2_present->time;
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
                  if(sizeof($total_energy_consumptionResult)){ $addCounter=sizeof($total_energy_consumptionResult);}
                  
                  
                for ($i = 0; $i < $max; $i++) {
                    if (isset($total_energy_consumption[$i + 1])) {

                        if ($total_energy_consumption[$i] > $total_energy_consumption[$i + 1]) {

                            $total_energy_consumptionResult[$i+$addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i + 1], 2, ',', '')));
                        } else {
                            $total_energy_consumptionResult[$i+$addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i + 1] - $total_energy_consumption[$i], 2, ',', '')));
                        }


                        $flag = $total_energy_consumption[$i] - $total_energy_consumption[$i + 1];
                    } elseif ($i + 1 == $max) {

                        if (sizeof($total_energy_consumption) > 1) {
                            if ($total_energy_consumption[$i] > $total_energy_consumption[$i - 1]) {
                                $total_energy_consumptionResult[$i+$addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i] - $total_energy_consumption[$i - 1], 2, ',', '')));
                            } else {

                                $total_energy_consumptionResult[$i+$addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i - 1] - $total_energy_consumption[$i], 2, ',', '')));
                            }
                        } else {

                            $total_energy_consumptionResult[$i+$addCounter] = array($total_energy_consumption_date[$i] . '.000+02:00' => str_replace(",", ".", number_format($total_energy_consumption[$i], 2, ',', '')));
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
              
              

            $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage,'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast, 'Flexibility' => $flexibility, 'Reliability' => $reliability);
            $this->apiCallUpate("getdataVGW_get", "end");
            exit(json_encode($main_data));
            
            }
            elseif ($pointer == 3) {

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
    
}
