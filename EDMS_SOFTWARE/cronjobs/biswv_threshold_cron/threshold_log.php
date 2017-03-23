<?php
/**
 * Description of threshold
 *
 * @author intelen
 */
class Threshold_log {
    
    private $thresholds_id;
    private $value;
    private $condition_value;
    private $value_from;
    private $value_to;
    private $date;
    
    public function toArray(){
        $result = array();
        foreach ($this as $key => $value)
        {
            $result[$key] = $value;
        }
        return $result;
    }
    
    public function getThresholds_id() {
        return $this->thresholds_id;
    }

    public function setThresholds_id($thresholds_id) {
        $this->thresholds_id = $thresholds_id;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setCondition($condition) {
        $this->condition_value = $condition;
    }

    public function setValueFrom($value) {
        $this->value_from = $value;
    }

    public function setValueTo($value) {
        $this->value_to = $value;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }


}

?>
