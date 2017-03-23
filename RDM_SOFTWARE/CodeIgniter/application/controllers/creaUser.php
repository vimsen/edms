<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creaUser
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class creaUser extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('general', '', TRUE);
    }

    //

    function index() {

        $this->session_validation();

        $session_data = $this->session->userdata('logged_in');
        $member = $this->session->userdata('member');


        $queryS = $this->general->listAllUsers();
        $index = 0;
        $m_id = array();
        $username = array();
        $type = array();
        $timestamp = array();

        foreach ($queryS->result() as $rowS) {
// m_id,macNames,mac
            $m_id[$index] = $rowS->id_v;
            $username[$index] = $rowS->username;
            $type[$index] = $rowS->type;
            $timestamp[$index] = $rowS->timestamp;

            $index++;
        }

        $data["mid"] = $m_id;
        $data["usernames"] = $username;
        $data["type"] = $type;
        $data["timestamp"] = $timestamp;
        $data['username'] = $session_data['username'];
        $data['member'] = $member;
        $this->load->view('creaUser_view', $data);
    }

    function delUserD() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        $flag = $this->general->RemoveUserD(strip_tags(trim($this->input->post('DDId'))));

        echo json_encode(array('Result' => 1));
        exit;
    }

    function saveMacUser() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        if (mb_strlen($this->input->post('uname'), 'UTF-8') > 40) {
            exit(json_encode(array('Result' => 4)));
        } elseif (mb_strlen($this->input->post('uname'), 'UTF-8') < 1) {
            exit(json_encode(array('Result' => 4)));
        }

        if (mb_strlen($this->input->post('Upass'), 'UTF-8') > 40) {
            exit(json_encode(array('Result' => 3)));
        } elseif (mb_strlen($this->input->post('Upass'), 'UTF-8') < 1) {
            exit(json_encode(array('Result' => 3)));
        }


        if ($this->input->post('UserType') == "User" || $this->input->post('UserType') == "Admin") {
            
        } else {
            exit(json_encode(array('Result' => 5)));
        }



        $UserNasme = strip_tags(trim($this->input->post('uname')));

        $Pass = strip_tags(trim($this->input->post('Upass')));

        $User = strip_tags(trim($this->input->post('UserType')));

        $switch = $this->general->saveUser($UserNasme, $Pass, date("Y-m-d h:i:sa"), $User);

        echo json_encode(array('Result' => $switch));
        exit;
    }

    function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }

}
