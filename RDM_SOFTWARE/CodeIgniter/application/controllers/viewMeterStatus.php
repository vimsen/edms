<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewMeter
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI



class viewMeterStatus extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('mac', '', TRUE);
    }

    function index() {

        $this->session_validation();


        $index = 0;
        $m_id = array();
        $macNames = array();
        $mac = array();
        $DayReceived = array();
        $MacCreate = "";



        $data["m_id"] = $m_id;
        $data["macNames"] = $macNames;
        $data["mac"] = $mac;
        $data["DayReceived"] = $DayReceived;
        $session_data = $this->session->userdata('logged_in');
        $member = $this->session->userdata('member');
        $data['member'] = $member;
        $data['username'] = $session_data['username'];

        $this->load->view('viewMeterStatus_view', $data);
    }

    function indexLoadStatus() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(2);

        $queryS = $this->mac->listAllMacsPlusLastPingStatus($this->session->userdata('id'));
        $index = 0;
        $m_id = array();
        $macNames = array();
        $mac = array();
        $DayReceived = array();
        $MacCreate = "";
        $return_value = "";


        foreach ($queryS->result() as $rowS) {
            $m_id[$index] = $rowS->m_id;
            $macNames[$index] = $rowS->macNames;
            $mac[$index] = $rowS->mac;
            //$DayReceived[$index] = $rowS->received;
            if (mb_strlen($rowS->received, 'UTF-8')) {

                $date1 = new DateTime($rowS->received);
                $date2 = new DateTime(date("Y-m-d H:i:s"));
                $interval = $date1->diff($date2);

                if ($interval->y) {
                    $DayReceived[$index] = " <strong style='color:green'>OFFLINE </strong> (Last transmition at:" . $rowS->received . ") Before: " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days " . $interval->i . " minutes.";
                } elseif ($interval->m) {
                    $DayReceived[$index] = "<strong style='color:green'>OFFLINE </strong> (Last transmition at:" . $rowS->received . ") Before:" . $interval->m . " months, " . $interval->d . " days " . $interval->i . " minutes. ";
                } elseif ($interval->d) {
                    $DayReceived[$index] = "<strong style='color:green'>OFFLINE </strong> (Last transmition at:" . $rowS->received . ") Before:" . $interval->d . " days " . $interval->i . " minutes.";
                } elseif ($interval->i > 15) {
                    $DayReceived[$index] = "<strong style='color:green'>OFFLINE </strong> (Last transmition at:" . $rowS->received . ") Before:" . $interval->i . " minutes.";
                } else {
                    $DayReceived[$index] = " ACTIVE Live Meter (" . $rowS->received . ") ";
                }
            } else {

                $DayReceived[$index] = "<strong style='color:green'>OFFLINE </strong> No data ( No records found today:" . date("Y-m-d") . "  )";
            }

            $index++;
        }

        $member = $this->session->userdata('member');

        $max = sizeof($m_id);

        if ($member == "Admin") {

            if ($max) {

                for ($i = 0; $i < $max; $i++) {

                 $return_value.= "<div id='block_$i' style='float:left;'><p style='float:left;margin-right:8px;cursor:pointer;'>$DayReceived[$i] / </p><p class='pMac' data-id='$m_id[$i]' data-mac='$mac[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $macNames[$i] . " / </p>   <img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                    
                }
            }
        } else {


            if ($max) {

                for ($i = 0; $i < $max; $i++) {

                    $return_value.= "<div id='block_$i' style='float:left;'><p style='float:left;margin-right:8px;cursor:pointer;'>$DayReceived[$i] N/ </p><p class='pMac' data-id='$m_id[$i]' data-mac='$mac[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $macNames[$i] . " / </p>  <img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                }
            }
        }




        echo json_encode(array('falseD' => "on", 'messageAlert' => $return_value));
    }

   

    function listMacMeter() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);
        $queryS = $this->mac->listMacsDevicesNames($this->session->userdata('id'), $this->input->post('dId'));

        $index = 0;

        $m_id = array();
        $macNames = array();
        $DeviceName = array();
        $Device_Rowid = array();
        foreach ($queryS->result() as $rowS) {

            $m_id[$index] = $rowS->macId;
            $macNames[$index] = $rowS->macNames;
            $DeviceName[$index] = $rowS->DeviceName;
            $Device_Rowid[$index] = $rowS->d_id;


            //
            $index++;
        }

        echo json_encode(array('Result' => "Meters", 'm_id' => $m_id, 'macNames' => $macNames, 'DeviceName' => $DeviceName, 'Devicedi' => $Device_Rowid));
        exit;
    }

    

    
   

    function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }

}
