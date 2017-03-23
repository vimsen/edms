<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailMeter
 *
 * @author hulk
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class detailMeter extends CI_Controller {

   public $path = "";
    
    //put your code here
    function __construct() {
        parent::__construct();
        $this->session_validation();
        $this->load->model('mac', '', TRUE);
    }

    function index() {

        $id = 0;
        $index = 0;
        $data = array();
        $DeviceName = array();

        $payload2 = array();
        $received2 = array();
        $topic_c2 = array();

        $macName = "";

        $index2 = 0;

        $id = (int) strip_tags(trim($this->input->get('id')));

        $queryS = $this->mac->selectDeviceNames($id);

        foreach ($queryS->result() as $rowS) {

            $DeviceName[$index] = $rowS->DeviceName;
            $macName = $rowS->mac;
            $index++;
        }


        $queryS2 = $this->mac->selectLastMeterMeassure($macName);

        foreach ($queryS2->result() as $rowS2) {

            $payload2[$index2] = (float) $rowS2->payload;

            $received2[$index2] = $rowS2->received;
            $topic_c2[$index2] = $rowS2->topic_c;
            $index2++;
        }


        $data["MacName"] = $macName;

        $data["payload2"] = $payload2;
        $data["received2"] = $received2;
        $data["topic_c2"] = $topic_c2;
        $data["DeviceName"] = $DeviceName;
        $data["m_id"] = $id;
        $session_data = $this->session->userdata('logged_in');
        $member = $this->session->userdata('member');
        $data['member'] = $member;
        $data['username'] = $session_data['username'];
        if (sizeof($payload2) < 1) {
            $data['linesDraw'] = array(0, 0, 0, 0, 0);
        } else {
            $data['linesDraw'] = $payload2;
        }


        $this->load->view('detailMeter_view', $data);
    }

    function makeConnecionRemotehost($url) {

        $connection = ssh2_connect($url, '22');

        return $connection;
    }

    function executeCommandRemotehost($connection, $user, $pass, $command_SSH) {

        if (ssh2_auth_password($connection, $user, $pass)) {


            $stream = ssh2_exec($connection, $command_SSH);
            stream_set_blocking($stream, true);

            $data2 = "";
            $data = "";
            $count = 0;

            while (list ($field1) = fscanf($stream, "%s")) {

                $data .= '["' . ++$count . '",' . '"' . $field1 . '"],';
            }
            $b[] = $data;

            echo str_replace('],"]', ']]', str_replace('["[', '[[', str_replace('\\', '', json_encode(array('jsonrpc' => 2.0, 'result' => $b, 'id' => 7, 'error' => null)))));
        } else {
            echo json_encode(array('jsonrpc' => 2.0, 'result' => [["75", "Authentication Failed...", "34", "3", $connection_SSH_pieces[0], $connection_SSH_pieces[1], $connection_SSH_pieces[2], $connection_SSH_pieces[3]]], 'id' => 7, 'error' => null));
        }
    }

    function connectshell() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
      

        $command_SSH = "";

        $connection_SSH = "";


        $connection = "";

        $connection_SSH = $this->input->post('com_name1');

        //str_replace

        if (mb_strlen($this->input->post('com_name'), 'UTF-8') > 1 and mb_strlen($this->input->post('com_name'), 'UTF-8') < 30) {

            $command_SSH = strip_tags(trim($this->input->post('com_name')));
        }



        if (mb_strlen($this->input->post('com_name1'), 'UTF-8') > 1 and mb_strlen($this->input->post('com_name1'), 'UTF-8') < 80) {

            $connection_SSH = str_replace(" ", "@", strip_tags(trim($this->input->post('com_name1'))));

            $connection_SSH_pieces = explode("@", $connection_SSH);

            //$connection_SSH = strip_tags(trim($this->input->post('com_name1')));
        } else {

            exit(json_encode(array('jsonrpc' => 2.0, 'result' => [["75", "Authentication Failed...", "30", "3"]], 'id' => 7, 'error' => null)));
        }


      
       
             if($command_SSH=="ls"){
            $connection = $this->makeConnecionRemotehost($connection_SSH_pieces[2]);
         
            $this->executeCommandRemotehost($connection, $connection_SSH_pieces[1], $connection_SSH_pieces[3], $command_SSH); 
            }elseif($command_SSH=="ping"){
            
                $connection = $this->makeConnecionRemotehost($connection_SSH_pieces[2]);   
                
            }
      
        
      

    }

    function loadTopic() {


        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        $index2 = 0;
        $payload2 = array();

        $queryS2 = $this->mac->selectLastMeterMeassure(strip_tags(trim($this->input->post('macname'))), strip_tags(trim($this->input->post('topiName'))));

        foreach ($queryS2->result() as $rowS2) {

            $payload2[$index2] = (float) $rowS2->payload;

            $index2++;
        }

        if (sizeof($payload2) < 1) {
            echo json_encode(array('Result' => array(0, 0, 0, 0, 0, 0, 0)));
        } else {
            echo json_encode(array('Result' => $payload2));
        }

        exit;
    }

    function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }

}
