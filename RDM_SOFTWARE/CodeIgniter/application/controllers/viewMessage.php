<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewMessage
 *
 * @author hulk
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class viewMessage extends CI_Controller {
    //put your code here
    
        function __construct() {
        parent::__construct();
        $this->load->model('mac', '', TRUE);
    }

    
        function index() {

        $this->session_validation();

        $queryS = $this->mac->listAllMessages($this->session->userdata('id'));
        $index = 0;

        $mId = array();
        $id_message = array();
        $main_Message = array();
        $userName = array();
        $timestamp = array();

        foreach ($queryS->result() as $rowS) {
            $mId[$index] = $rowS->mId;
            $id_message[$index] = $rowS->id_message;
            $main_Message[$index] = $rowS->main_Message;
            $userName[$index] = $rowS->userName;
            $timestamp[$index] = $rowS->timestamp;

            $index++;
        }

        $data["mId"] = $mId;
        $data["id_message"] = $id_message;
        $data["main_Message"] = $main_Message;
        $data["userName"] = $userName;
        $data["timestamp"] = $timestamp;
                
        $session_data = $this->session->userdata('logged_in');
        $member = $this->session->userdata('member');
        $data['member'] = $member;
        $data['username'] = $session_data['username'];

        $this->load->view('viewMessage_view', $data);
    }
    
        function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }
    
    
}
