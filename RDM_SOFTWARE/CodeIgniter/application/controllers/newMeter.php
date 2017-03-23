<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newMeter
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class newMeter extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('mac', '', TRUE);
    }

    function index() {
        $session_data = $this->session->userdata('logged_in');
        $member = $this->session->userdata('member');
        $this->session_validation();
        $data['username'] = $session_data['username'];
        $data['member'] = $member;

        $this->load->view('newMeter_view', $data);
    }

    function saveMac() {

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(2);

        $this->session_validation();

        if (mb_strlen($this->input->post('macname'), 'UTF-8') < 1) {
            exit(json_encode(array('Result' => 3)));
        }

        if (mb_strlen($this->input->post('macname'), 'UTF-8') > 50) {
            exit(json_encode(array('Result' => 4)));
        }

        $result = 0;
        $MacName = "";
        $mac = "";

        $MacName = strip_tags(trim($this->input->post('macname')));
        $mactype = strip_tags(trim($this->input->post('macserial')));

       
        
        $result = $this->mac->addMac($MacName, $mactype, $this->session->userdata('id'));

        echo json_encode(array('Result' => $result));
    }

    function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }

}
