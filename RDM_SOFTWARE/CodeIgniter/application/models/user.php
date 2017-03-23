<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class User extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    
   
    
    function login($username, $password) {
        $sql = "
       select id_v,username,password,type  from Users_v where username=" . $this->db->escape($username) . " and password='" . md5($password) . "' limit 1";

        $query = $this->db->query($sql);
       

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    
    function Retrieve_allImeters() {
        
       $sql = "";
       $query = $this->db->query($sql);
     
        
    }
    
    

}
