<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ahead_model extends CI_Model {

    /**
     *
     * @var int iMeter Mac address 
     */
    public $prosumers = null;

    /**
     *
     * @var int the current time of the url 
     */
    public $date = NULL;

    /**
     *
     * @var datestring with ours per hours
     */
    public $datestring = 'd-m-Y H:i';

    /**
     *
     * @var datesting for time day
     */
    public $datestring_day = 'd-m-Y';

    /**
     *
     * @var datesting for time month 
     */
    public $datestring_month = 'm-Y';

    function initialize($init) {
        if (isset($init['prosumers'])) {
            $this->prosumers = $init['prosumers'];
        } else {
            throw new GeneralException("411", "not valid prosumers in url", "initialize");
        }
        if (isset($init['date'])) {
            $this->date = $init['date'];
        } else {
            throw new GeneralException("411", "not valid date in url", "initialize");
        }
    }

    function validate() {
        if ($this->prosumers == false) {
            throw new GeneralException("411", "not valid prosumers", "validation");
        }
        if ($this->date == false) {
            throw new GeneralException("411", "not valid date", "validation");
        }
    }

    function sendData() {

        $data = $this->_data($this->prosumers, $this->date);
        return $data;
    }

    private function _data($prosumer, $date) {
        $this->config->load('config', TRUE);
        $prosumers_array = $this->config->item('prosumers', 'config');
        $prosumer_data = explode(',', $prosumer);
        $mac = array();
        $prosumer_data_mac = array();
        $i = 0;
        foreach ($prosumer_data as $id) {
            foreach ($prosumers_array as $key => $value) {
                if ($key == $id) {
                    if (!in_array($value['mac'], $mac)) {
                        array_push($mac, $value['mac']);
                        $prosumer_data_mac[$id] = $value['mac'];
                    }
                }
            }
            $i++;
        }
        $all_mac = '(' . join($mac, ',') . ')';
//        if (count($mac) < 2) {
//            $sql = "SELECT mac,sum(kwh) as data, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(timestamp /" . $interval . ") *" . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time FROM `cc3_data` where mac = " . $all_mac . " and timestamp >= " . strtotime($startdate) . " and timestamp < " . strtotime($enddate) . "  GROUP BY time order by time asc";
//        } else {
//            $sql = "SELECT mac,sum(kwh) as data, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(ceiling(timestamp /" . $interval . ") *" . $interval . ",'%Y-%m-%dT%H:%i:%s' ), 'UTC', 'UTC'), '%Y-%m-%dT%H:%i:%s') as time FROM `cc3_data` where mac in " . $all_mac . " and timestamp >= " . strtotime($startdate) . " and timestamp < " . strtotime($enddate) . " GROUP BY time order by time asc";
//        }
//        $query = $this->db->query($sql);
//        $result = $query->result();
        $data = array();
        $points = array();
        $w = 0;
        foreach ($prosumer_data as $value) {
            //$procume_mac = array_search($result_value->mac, $prosumer_data_mac);  
            for ($i = 0; $i < 24; $i++) {
                $points[$i] = (object) array(
                            'time' => $i,
                            'production' => 0,
                            'consumption' => $this->_GetRandomValue(0,4)
                );
            }
            $data[$w] = (object) array(
                        'prosumer_id' => (int)$value,
                        'date' => $date,
                        'points' => $points
            );
            $w++;
        }
        return $data;
    }

    private function _GetRandomValue($min, $max) {
        $range = $max - $min;
        $num = $min + $range * mt_rand(0, 32767) / 32767;

        $num = round($num, 4);
        return ((float) $num);
    }

}
