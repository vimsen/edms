<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mac
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mac extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

     function selectDeviceNames($id) {
         
        $sql = "select distinct DeviceName,macId,mac from MacDevices inner join ImeterMac on ImeterMac.m_id = MacDevices.macId and  MacDevices.macId='" . $this->db->escape($id) . "'";
        $result = $this->db->query($sql);
        return $result;
         
     }
    
     
      function selectLastMeterMeassure($mac,$topic=null) {
         
         if($mac and $topic){
                  $sql = "select payload,received,topic_c from mqtt_logs_insert where mac=" . $this->db->escape($mac) . " and topic_c=" . $this->db->escape($topic) . " order by received desc limit 30"; 
   
         }else{
          $sql = "select payload,received,topic_c from mqtt_logs_insert where mac=" . $this->db->escape($mac) . " order by received desc limit 30"; 
    
         } 
          
         
        $result = $this->db->query($sql);
        return $result;
         
     }
     
    
    
      function addMessage($gatewayId, $gateNewMessage, $id, $message) {
        $sql = "INSERT INTO vgwMessages (id_message,main_Message,userName,timestamp)VALUES (" . $this->db->escape($gatewayId) . ", " . $this->db->escape($gateNewMessage) . ", " . $this->db->escape($id) . ", " . $this->db->escape($message) . ")";

        if ($this->db->query($sql) === TRUE) {
            return 1;
        } else {
            return 2;
        }
    }
    
    
    
    function addMac($macName, $mac, $id) {
        $sql = "INSERT INTO ImeterMac (macNames, mac,UserId)VALUES (" . $this->db->escape($macName) . ", " . $this->db->escape($mac) . ", " . $this->db->escape($id) . ")";

        if ($this->db->query($sql) === TRUE) {
            return 1;
        } else {
            return 2;
        }
    }

    function addMacMeter($payload, $macPath, $id) {
        $sql = "INSERT INTO Imeters (MacPath, Value,UserId)VALUES (" . $this->db->escape($macPath) . ", " . $this->db->escape($payload) . ", " . $this->db->escape($id) . ")";

        if ($this->db->query($sql) === TRUE) {
            return 1;
        } else {
            return 2;
        }
    }

    function RemoveMacDevice($rowId, $userId) {

        $sql = "DELETE FROM ImeterMac where m_id= " . $this->db->escape($rowId) . " and UserId= " . $this->db->escape($userId) . "";

        $result = $this->db->query($sql);



        $sql_2 = "DELETE FROM MacDevices where macId= " . $this->db->escape($rowId) . "";

        $result = $this->db->query($sql_2);
    }
    
    function RemoveMacDeviceD($rowId) {


        $sql_2 = "DELETE FROM MacDevices where d_id= " . $this->db->escape($rowId) . "";

        $result = $this->db->query($sql_2);
    }
    

    function addMacDevice($pieces, $cId,$UserID) {

        $Data_devices = "";

        $macid = 0;

        $data = "";

     

        $max = sizeof($pieces);

        for ($i = 0; $i < $max; $i++) {

            if ($pieces[$i]) {

                $data .= "(" . $this->db->escape(strip_tags(trim($pieces[$i]))) . "," . $this->db->escape($cId) . "," . $this->db->escape($UserID) . "),";
            }
        }
        $data = rtrim($data, ",");

        $sql = "INSERT INTO MacDevices (DeviceName,macId,UserID_D) VALUES " . $data . "";


        if ($this->db->query($sql) === TRUE) {
            return 1;
        } else {
            return 2;
        }
        return $sql;
    }

    
     function listAllMessages($id) {
        
         
         $sql = "select mId,id_message,main_Message,userName,timestamp from vgwMessages";
        $result = $this->db->query($sql);
        return $result;
    }
    
     function listAllMacsPlusLastPing($id) {
        
  
        $sql = "select * from (select * from mqtt_logs_insert where mac in (select mac COLLATE utf8_unicode_ci from ImeterMac ) order by received desc) as T right join ImeterMac on ImeterMac.mac COLLATE utf8_unicode_ci =T.mac group by ImeterMac.mac";
        $result = $this->db->query($sql);
        return $result;
    }
    
    
    function listAllMacsPlusLastPingStatus($id) {
        
  
        $sql = "select * from (select * from mqtt_logs_insert where mac in (select mac COLLATE utf8_unicode_ci from ImeterMac ) order by received desc) as T right join ImeterMac on ImeterMac.mac COLLATE utf8_unicode_ci =T.mac group by ImeterMac.mac";
        $result = $this->db->query($sql);
        return $result;
    }
    
    
    
    function listAllMacs($id) {
        
         $sql = "select m_id,macNames,mac from ImeterMac";
        $result = $this->db->query($sql);
        return $result;
    }
    
    
     function listAllMacsDevices($id) {
        
        $sql = "select macNames,DeviceName from ImeterMac inner join MacDevices on UserId=" . $this->db->escape($id) . " and macId=m_id";

        $result = $this->db->query($sql);
        return $result;
    }
    
    
     function listMacsDevicesNames($useId,$RowId) {
        
        $sql = "select macNames,DeviceName,macId,d_id from ImeterMac inner join MacDevices on macId=m_id and m_id=$RowId"; 
        $result = $this->db->query($sql);
        
        return $result;
    }
    
    
    
      function listMacshistoricalNames($macName,$topicName) {
           
        $sql = "select payload,received from mqtt_logs where mac=" . $this->db->escape($macName) . " and topic_c=" . $this->db->escape($topicName) . " order by received desc limit 300";

        $result = $this->db->query($sql);
        return $result;
    }
    
    
     function updateMessages($id,$title,$message) {
        
        $sql = "update vgwMessages set id_message='" . $this->db->escape($title) . "',main_Message='" . $this->db->escape($message) . "' where mid=" . $this->db->escape($id) . " ";

        $result = $this->db->query($sql);
        return $result;
    }

}
