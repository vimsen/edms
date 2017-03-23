<?php

define("MYSQL_DATE_FORMAT", "Y-m-d H:i:s");

/**
 * Description of threshold_rule
 *
 * @author intelen
 */
class Threshold_rule {

    
    public $id;
    public $user_id;
    public $resource_id;
    public $resource_type;
    public $resource_name;

    /**
     * ex. 'greater_than', 'less_than', etc
     * @var String
     */
    public $condition_value;

    /**
     * if true send email to $email_list
     * @var Boolean
     */
    public $send_mail;

    /**
     * comma separated emails for sending notifications (besides user email)
     * @var String
     */
    public $email_list;

    /**
     * @var String
     */
    public $user_email;
    public $user_name;

    /**
     * 
     * @var float
     */
    public $value_from;

    /**
     *
     * @var float
     */
    public $value_to;
    public $field;
    public $specific_dates;
    public $date_start;
    public $date_end;
    public $active;

    /**
     *
     * @var DateTime 
     */
    private $check_start_time;

    /**
     *
     * @var DateTime
     */
    private $check_end_time;

    /**
     * value to be checked against the rules
     * @var float
     */
    private $metering_value;
    private $energy_api_url;
    private $write_api_url;
    private $read_api_url;
    private $timezone;
    private $now;
    private $debug = false;

    public function __construct($params, $debug = false) {
        $this->debug = $debug;
        global $config;
        if ($this->debug) {
//            var_dump($params);
        }
       var_dump($params);
        echo "-------------params----------------------";
       
        $this->read_api_url = $config['read_api_base'] . 'index.php/api/';
        $this->write_api_url = $config['write_api_base'] . 'index.php/api/';
        $this->energy_api_url = $config['energy_api_base'] . 'index.php/api/';

        $this->id = $params['id'];
        $this->user_id = $params['user_id'];
        $this->resource_id = $params['resource_id'];
        $this->resource_type = $params['resource_type'];
        if ($this->resource_type == 'meter') {
            $url = $this->read_api_url . "meters/mac/$this->resource_id/user/$this->user_id";
            $meter = Curl_helper::curl_get($url, $this->debug);
            if (isset($meter['meters'])) {
                $meterData = (reset($meter['meters']));
                $this->resource_name = $params['resource_name'].' <span style="color:grey">@Division: '.$meterData['building_division_name'].' - Building: '.$meterData['building_name'].'</span>';
            } else {
                $this->resource_name = $params['resource_name'];
            }
        } else if ($this->resource_type == 'division') {
            $url = $this->read_api_url . "building_divisions/id/$this->resource_id/user/$this->user_id";
            $division = Curl_helper::curl_get($url, $this->debug);
            if (isset($division['building_divisions'])) {
                $divisionData = (reset($division['building_divisions']));
                $this->resource_name = $params['resource_name'].' <span style="color:grey">@Building: '.$divisionData['building_name'].'</span>';
            } else {
                $this->resource_name = $params['resource_name'];
            }
        } else {
            $this->resource_name = $params['resource_name'];
        }
        $this->condition_value = $params['condition_value'];
        $this->value_from = $params['value_from'];
        $this->value_to = $params['value_to'];
        $this->field = $params['field'];
        $this->specific_dates = $params['specific_dates'];
        $this->date_start = $params['date_start'];
        $this->date_end = $params['date_end'];
        $this->timezone = new DateTimeZone($params['timezone']);
        $this->now = new DateTime("now");
        if($this->field == 'kwh'){
            if($this->specific_dates == 1){
                $this->check_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $params['date_start']);
            }
            else {
                //start time is start of threshold
                $this->check_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $params['server_start_time']);
            }
        } else {
            $this->check_start_time = clone $this->now;
            $this->check_start_time->sub(new DateInterval("PT15M"));
        }
        $this->check_end_time = clone $this->now;
        $this->send_mail = $params['send_email'];
        $this->email_list = $params['email_list'];
        $this->user_email = $params['user_email'];
        $this->user_name = $params['user_name'];
    }

    public function getCheckParameters() {
      
        //echo "----------getCheckParameters------".$this->check_start_time->format(DATE_ISO8601)."---------------";
        
        $input_arr = array(
            'resource_type' => $this->resource_type,
            'resource_id' => $this->resource_id,
            'field' => $this->field,
            'date_start' => date('Y-m-d')."T00:00:00+00:00",//$this->check_start_time->format(DATE_ISO8601),
            'date_end' => $this->check_end_time->format(DATE_ISO8601),
            'user_id' => $this->user_id,
            'threshold_id' => $this->id
        );
        if($this->specific_dates == 0){
            
        }
        return $input_arr;
    }

    public function checkValue($value = null) {
        //if no value present dont perform any checks and return
        if (!isset($value)) {
            if ($this->debug) 
                echo "null value";
            return FALSE;
        }
        echo "====condition_value====".$this->condition_value."--------------";
         echo "\n"."====metering_value===|=".$value."|-----------value_from=====---|".$this->value_from."|=======";
        $this->metering_value = $value;
        switch ($this->condition_value) {
            case 'greater_than':
                if ($this->metering_value >= $this->value_from)
                    return $this->trigger();
                break;
            case 'less_than':
                if ($this->metering_value <= $this->value_from)
                    return $this->trigger();
                break;
            case 'not_between':
                if ($this->metering_value <= $this->value_from || $this->metering_value >= $this->value_to)
                    return $this->trigger();
                break;
            case 'between':
                if ($this->metering_value >= $this->value_from && $this->metering_value <= $this->value_to)
                    return $this->trigger();
                break;    
            default:
                break;
        }

        if ($this->debug) {
           // echo "total: $this->metering_value";
        }
        return FALSE;
    }

    /**
     * Returns true if the log is triggered and saved to db
     * @return FALSE or threshold_log id
     */
    public function trigger() {

        $threshold_log = new Threshold_log();
        $threshold_log->setThresholds_id($this->id);
        $threshold_log->setValue($this->metering_value);
        $threshold_log->setCondition($this->condition_value);
        $threshold_log->setValueFrom($this->value_from);
        $threshold_log->setValueTo($this->value_to);
        $converted_date = clone $this->now;
        /* @var $converted_date DateTime */
        $converted_date->setTimezone($this->timezone);
        $threshold_log->setDate($converted_date->format(MYSQL_DATE_FORMAT));
        echo "----------INSIDE TRIGGER-----------------".$this->field."----------";
        //if field is kwh check if it is already triggered
        if ($this->field === 'kwh') {
            //get threshold logs for this 
            $start_time = clone $this->check_start_time;
            $end_time = clone $this->check_end_time;
            $start_time->setTimezone($this->timezone);
            $end_time->setTimezone($this->timezone);
            
            $check_start_time=  $start_time->getTimestamp();
            $check_end_time = $end_time->getTimestamp();
            
            $timenow = date('Y-m-d H:i:s');
            $timestamp = strtotime($timenow. ' +2 hour');
            //i disable this in order to fix it.
            $check_end_time2 = $timestamp;// =  $check_end_time + 3600;//strtotime($check_end_time . ' +2 hour');
            $date = new DateTime();
            //$beginOfDay = strtotime("midnight", $date->getTimestamp());
            
            //$beginOfDay = strtotime(date('Y-m-d '.'00:00:00'). ' +2 hour');
            $beginOfDay = strtotime(date('Y-m-d')."T00:00:00+00:00");//strtotime(date('Y-m-d '.'00:00:00'));
            //$date = new DateTime();
           // $timestampDateStart = $date->getTimestamp();
            //$timestampDateStart = strtotime('+2 hours',date('Y-m-d'));
            //$dateStart = (new \DateTime())->format('Y-m-d');//date('Y-m-d');
            //$timestampDateStart = strtotime('+1 day',$dateStart);
           // $timestampDateStart = $timestampDateStart + (2*60 * 60);
            
            //$url = $this->read_api_url . "threshold_log_count/threshold/$this->id/start_time/$check_start_time/end_time/$check_end_time/format/json";
            //$url = $this->read_api_url . "threshold_log_count/threshold/$this->id/start_time/$check_start_time/end_time/$check_end_time2/format/json";
            echo "\n -------252---------xxxxx---";
            //$url = $this->read_api_url . "threshold_log_count/threshold/$this->id/start_time/$beginOfDay/end_time/$check_end_time2/format/json";
           $url = "http://localhost:8888/public/colgate/read-api/index.php/api/threshold_log_count/threshold/$this->id/start_time/$beginOfDay/end_time/$check_end_time2/format/json";
            
            $old_logs = Curl_helper::curl_get($url, $this->debug);
            var_dump($old_logs);
            if ($this->debug) {
//                echo "old logs:";
//                var_dump($old_logs);
            }
            if ((int)$old_logs['count'] > 0){
                return FALSE;
            }
        }
echo "-----------------------CONTINUE--------------------------------------".$this->id."----------------------------".$this->write_api_url."---DEBUG----".$this->debug."----count--".(int)$old_logs['count'];
        //send to write api in order for it to be saved
       
    //$result = Curl_helper::curl_put($this->write_api_url . "thresholds_log", $threshold_log->toArray(), array(), $this->debug);
        $result = Curl_helper::curl_put("http://localhost:8888/public/colgate/write-api/index.php/api/thresholds_log", $threshold_log->toArray(), array(), $this->debug);
        
        if(isset($result['id']) && (int)$result['id'] > 0)
            return $result['id'];
        if ($this->debug) {
            echo "triggered !! ";
        }
        return FALSE;
    }
    
    /**
     * 
     * @return array
     */
    public function notify(){
        return $this;
    }

    /**
     * 
     * @return float
     */
    public function getMeteringValue() {
        return $this->metering_value;
    }

    /**
     * 
     * @return DateTime object
     */
    public function getThresholdAlertTime() {
        return $this->now;
    }

}

?>
