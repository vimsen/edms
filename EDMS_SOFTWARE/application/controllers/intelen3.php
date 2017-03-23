<?php

include(APPPATH . 'libraries/REST_Controller.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//https://beta.intelen.com/vimsenapi/EDMS_DSS/index.php/intelen3/getdataVGW?prosumers=b827eb4c14af&startdate=2016-03-22T06:30:00.000+02:00&enddate=2016-03-22T07:15:00.000+02:00&interval=900&pointer=2
/**
 * Description of intelen
 *
 * @author intelen.vimsen jedi
 */
class intelen3 extends REST_Controller {

    function getdataVGW_get() {

        try {

            $ValidateValuesReturn = "";
            $pieces_timestamps = "";
            $pieces_timestampsEndDate = "";


            $get_data = $this->input->get(Null, TRUE);

            $this->load->model('process_model2');

            $ValidateValuesReturn = $this->process_model2->validate($get_data);


            if ($this->process_model2->apiCallUpate("getdataVGW_get", "start") > 10) {

                $macID = "";
                $production = array();
                $production_batteryPercentage = array();
                $total_energy_consumptionResult = array();
                $total_energy_consumptionResult_forecast = "";
                $production_forecast = "";

                $main_data[] = array('ProsumerId' => $macID, 'Production' => $production, 'Storage' => $production_batteryPercentage, 'Consumption' => $total_energy_consumptionResult, 'ForecastConsumption' => $total_energy_consumptionResult_forecast, 'ForecastProduction' => $production_forecast);
                exit(json_encode($main_data));
            }
        

            $pieces_timestamps = explode("T", $ValidateValuesReturn["startDate"]);
            $pieces_timestampsEndDate = explode("T", $ValidateValuesReturn["endDate"]);


            if (strtotime(date('Y-m-d')) == strtotime($pieces_timestamps[0])) {
              

                $this->process_model2->block_data_now($ValidateValuesReturn["startDate"], $ValidateValuesReturn["endDate"], $ValidateValuesReturn["mac"], $ValidateValuesReturn["Ptotal"], $ValidateValuesReturn["interval"], $ValidateValuesReturn["pointer"], $ValidateValuesReturn["interval"]);
            } elseif (strtotime($pieces_timestamps[0]) < strtotime(date('Y-m-d')) and strtotime($pieces_timestampsEndDate[0]) < strtotime(date('Y-m-d'))) {//$pieces_timestampsEndDate
              
                $this->process_model2->block_data_past($ValidateValuesReturn["startDate"], $ValidateValuesReturn["endDate"], $ValidateValuesReturn["mac"], $ValidateValuesReturn["Ptotal"], $ValidateValuesReturn["interval"], $ValidateValuesReturn["pointer"], $ValidateValuesReturn["interval"]);
            } else {
              

                $this->process_model2->block_data_mainsource_join_past_present($ValidateValuesReturn["startDate"], $ValidateValuesReturn["endDate"], $ValidateValuesReturn["mac"], $ValidateValuesReturn["Ptotal"], $ValidateValuesReturn["interval"], $ValidateValuesReturn["pointer"], $ValidateValuesReturn["interval"]);
            }

          
        } catch (Exception $ex) {

            return $e;
        }
    }

}
