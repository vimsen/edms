<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of head
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start();

class head extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('mac', '', TRUE);
    }

    function index() {


        $queryS = $this->mac->listAllMacsDevices($this->session->userdata('id'));

        $index = 0;

        $m_id = array();
        $macNames = array();
        $DeviceName = array();

        foreach ($queryS->result() as $rowS) {

            $macNames[$index] = $rowS->macNames;
            $DeviceName[$index] = $rowS->DeviceName;
            $index++;
        }


        $data["macNames"] = $macNames;
        $data["DeviceName"] = $DeviceName;
        
        $this->load->view('head_view', $data);
    }

    function saveMacMeter() {
        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');

        $payload = "";

        $macPath = "";

        $payload = $this->input->post('payload');

        $macPath = $this->input->post('macPath');

        $result = $this->mac->addMacMeter($payload, $macPath, $this->session->userdata('id'));

        echo json_encode(array('Result' => $result));
    }

}
