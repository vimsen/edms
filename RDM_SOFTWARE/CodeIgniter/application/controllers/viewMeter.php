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

session_start(); 

class viewMeter extends CI_Controller {

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

        $this->load->view('viewMeter_view', $data);
    }

    function indexLoadData() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(2);

        $queryS = $this->mac->listAllMacsPlusLastPing($this->session->userdata('id'));
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
            if (mb_strlen($rowS->received, 'UTF-8')) {

                $date1 = new DateTime($rowS->received);
                $date2 = new DateTime(date("Y-m-d H:i:s"));
                $interval = $date1->diff($date2);

                if ($interval->y) {
                    $DayReceived[$index] = "(Last transmition at:" . $rowS->received . ") Before: " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days " . $interval->i . " minutes.";
                } elseif ($interval->m) {
                    $DayReceived[$index] = "(Last transmition at:" . $rowS->received . ") Before:" . $interval->m . " months, " . $interval->d . " days " . $interval->i . " minutes. ";
                } elseif ($interval->d) {
                    $DayReceived[$index] = "(Last transmition at:" . $rowS->received . ") Before:" . $interval->d . " days " . $interval->i . " minutes.";
                } elseif ($interval->i > 15) {
                    $DayReceived[$index] = "(Last transmition at:" . $rowS->received . ") Before:" . $interval->i . " minutes.";
                } else {
                    $DayReceived[$index] = "Live Meter (" . $rowS->received . ") ";
                }
            } else {

                $DayReceived[$index] = " No data ( No records found today:" . date("Y-m-d") . "  )";
            }

            $index++;
        }

        $member = $this->session->userdata('member');

        $max = sizeof($m_id);

        if ($member == "Admin") {

            if ($max) {

                for ($i = 0; $i < $max; $i++) {

                 $return_value.= "<div id='block_$i' style='float:left;'><p style='float:left;margin-right:8px;cursor:pointer;'>$DayReceived[$i] / </p><p class='pMac' data-id='$m_id[$i]' data-mac='$mac[$i]' style='float:left;margin-right:8px;cursor:pointer;'>" . $macNames[$i] . " / </p>  <p class='device_mac' data-id='$m_id[$i]' data-macnames='$macNames[$i]' style='float:left;margin-right:8px;cursor:pointer;'>Add Devices for this Gateway / </p> <p class='device_macre' data-id='$m_id[$i]' data-ii='$i' data-macnames='$macNames[$i]' style='float:left;margin-right:8px;cursor:pointer;color:#686868;font-weight: bold;'>Remove this Gateway / </p><p class='device_maDisplay' data-id='$m_id[$i]' data-macnames='$macNames[$i]' data-lid='$i' style='float:left;margin-right:8px;cursor:pointer;font-weight: bold;'>Display Devices for this Gateway</p>--<a href='detailMeter?id=$m_id[$i];' style='color:white;font-size:18px;'> Details</a><img src='" . base_url() . "public/img/ajax-loader_2.gif' id='spiadl_$i' style='display:none;float:right;'></div><div id='cle'></div>";
                    
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

    function saveMacMeter() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        if (mb_strlen($this->input->post('cId'), 'UTF-8') > 20) {
            exit(json_encode(array('Result' => 4)));
        } elseif (mb_strlen($this->input->post('cId'), 'UTF-8') < 1) {
            exit(json_encode(array('Result' => 4)));
        }

        $macid = (int) $this->input->post('cId');

        $Data_devices = rtrim($this->input->post('textSend'), "@");

        if (mb_strlen($Data_devices, 'UTF-8') < 1) {

            exit(array('Result' => 3));
        } elseif (mb_strlen($Data_devices, 'UTF-8') > 550) {

            exit(array('Result' => 31));
        }

        $pieces = explode("@", $Data_devices);

        $key_Memcache="RestartRun3";
        $Memcache_connection = new Memcache;
        $Memcache_connection->connect('localhost', 11211) or die("Could not connect");
         //
        $Return_Result = $Memcache_connection->get($key_Memcache);
        $Memcache_connection->set($key_Memcache, "restartScript");
        
        
        $switch = $this->mac->addMacDevice($pieces, $macid, $this->session->userdata('id'));

        echo json_encode(array('Result' => $switch));

        exit;
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
// macNames,DeviceName,macId
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

    function histMacMeter() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);
        $queryS = $this->mac->listMacshistoricalNames($this->input->post('tmname'), $this->input->post('tname'));

        $index = 0;
        $m_id = array();
        $payload = array();
        $received = array();

        foreach ($queryS->result() as $rowS) {
            $payload[$index] = $rowS->payload;
            $received[$index] = $rowS->received;

            $index++;
        }

        echo json_encode(array('Result' => "Meters", 'Value' => $payload, 'Time' => $received));
        exit;
    }

    function delMacMeter() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        $flag = $this->mac->RemoveMacDevice(strip_tags(trim($this->input->post('dId'))), $this->session->userdata('id'));
       
        $key_Memcache="RestartRun3";
        $Memcache_connection = new Memcache;
        $Memcache_connection->connect('localhost', 11211) or die("Could not connect");
        $Return_Result = $Memcache_connection->get($key_Memcache);
        $Memcache_connection->set($key_Memcache, "restartScript");
        
        echo json_encode(array('Result' => 1));
        exit;
    }

    function delMacMeterD() {

        $this->session_validation();

        if (!$this->input->is_AJAX_request())
            exit('none AJAX calls rejected!');
        sleep(1);

        $flag = $this->mac->RemoveMacDeviceD(strip_tags(trim($this->input->post('DDId'))));

        $key_Memcache="RestartRun3";
        $Memcache_connection = new Memcache;
        $Memcache_connection->connect('localhost', 11211) or die("Could not connect");
        $Return_Result = $Memcache_connection->get($key_Memcache);
        $Memcache_connection->set($key_Memcache, "restartScript");

        
        
        echo json_encode(array('Result' => 1));
        exit;
    }

    function session_validation() {

        $uid = (int) $this->session->userdata('id');

        if ($uid == 0 || mb_strlen($uid, 'UTF-8') < 1) {
            redirect('login', 'refresh');
        }
    }

}
