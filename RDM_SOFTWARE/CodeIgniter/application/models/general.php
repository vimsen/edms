<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of general
 *
 * @author john
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class general extends CI_Model{
    //put your code here
    
    
      public function __construct() {
        parent::__construct();
    }

    function saveUser($UserNasme, $Pass,$Timestamp, $User) {
        $sql = "INSERT INTO Users_v(username, password,timestamp,type)VALUES (" . $this->db->escape($UserNasme) . ",'" . md5($Pass) . "' , " . $this->db->escape($Timestamp) . ", " . $this->db->escape($User) . ")";

        if ($this->db->query($sql) === TRUE) {
            return 1;
        } else {
            return 2;
        }
    }
    
    function RemoveUserD($rowId) {


        $sql_2 = "DELETE FROM Users_v where id_v= " . $this->db->escape($rowId) . "";

        $result = $this->db->query($sql_2);
    }
    
    
     function listAllUsers() {
        
      // $ids =  (int) $id;
        
        $sql = "select id_v,username,type,timestamp from Users_v";

        $result = $this->db->query($sql);
        return $result;
    }
    
    
}
