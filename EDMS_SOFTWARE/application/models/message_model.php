<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message_model
 *
 * @author hulk
 */
class message_model extends CI_Model {

    //put your code here

    function retrieve_messages() {

        $sql = "";
        
        $query = "";
        
        $emailName = []; //email
        
        $timestampTopic = []; //email
        
        $changeUPdate = [];
        
        $payload = [];

        $db = $this->load->database('default', TRUE);

        $sql = " select * from topicMessageRealTime where status='on' order by changeUPdate desc limit 200";

        $query = $db->query($sql);

        if ($query->num_rows()) {

            foreach ($query->result() as $row) {

                $emailName[] = $row->topicName;
                $timestampTopic[] = $row->timestampTopic;
                $changeUPdate[] = $row->changeUPdate;
                $payload[] = $row->payload;
            }
        }


        $main_data[] = array('Email' => $emailName, 'Timestamp' => $timestampTopic,'Message'=>$payload, 'EmailTimeSend' => $changeUPdate);

        exit(json_encode($main_data));
    }

}
