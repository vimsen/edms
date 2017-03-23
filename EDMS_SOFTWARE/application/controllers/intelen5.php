<?php

include(APPPATH . 'libraries/REST_Controller.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of intelen
 *
 * @author John Papagiannis
 */
class intelen5 extends REST_Controller {

    //put your code here


    function getdataVGW_get() {


        $startDate = "";
        $endDate = "";
        $mac = "";
        $total = "";
        $Ptotal = "";
        $interval = "";
        $pointer = "";
        $testFlag = "";
        $consumptionFlag = "";

        $startDate = strip_tags(trim($this->input->get("startdate")));

        $endDate = strip_tags(trim($this->input->get("enddate")));

        $mac = strip_tags(trim($this->input->get("prosumers")));

        $total = strip_tags(trim($this->input->get("total")));

        $interval = strip_tags(trim($this->input->get("interval")));

        $pointer = strip_tags(trim($this->input->get("pointer")));

        $testFlag = strip_tags(trim($this->input->get("testFlag")));

        $consumptionFlag = strip_tags(trim($this->input->get("consumptionFlag")));

        $this->load->model('execute_model');

        $this->execute_model->alarm_exit($pointer, $startDate, $endDate, $mac, $interval);

        if ($total == 1) {

            $Ptotal = 1;
        }

        if ($testFlag == 1) {

            $testFlag = "on";
        } else {
            $testFlag = "";
        }


        if ($consumptionFlag == 1) {

            $consumptionFlag = "on";
        } else {

            $consumptionFlag = "";
        }


        if ($this->execute_model->apiCallUpate("getdataVGW_get", "start") > 130) {

            $macID = "";
            $production = array();
            $production_batteryPercentage = array();
            $total_energy_consumptionResult = array();
            $total_energy_consumptionResult_forecast = "";
            $production_forecast = "";

            $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast);
            exit(json_encode($main_data));
        }


        $pieces_timestamps = explode("T", $startDate);
        $pieces_timestampsEndDate = explode("T", $endDate);


        if (strtotime(date('Y-m-d')) == strtotime($pieces_timestamps[0])) {
           
            $this->execute_model->block_data_now($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $testFlag, $consumptionFlag);
        } elseif (strtotime($pieces_timestamps[0]) < strtotime(date('Y-m-d')) and strtotime($pieces_timestampsEndDate[0]) < strtotime(date('Y-m-d'))) {//$pieces_timestampsEndDate
         
            $this->execute_model->block_data_past($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $testFlag);
        } else {
          
            $this->execute_model->block_data_mainsource_join_past_present($startDate, $endDate, $mac, $Ptotal, $interval, $pointer, $interval, $consumptionFlag);
        }
    }

}
