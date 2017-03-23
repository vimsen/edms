<?php

include(APPPATH . 'libraries/REST_Controller.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author hulk
 */
class message extends REST_Controller {

    //put your code here

    function printMessages_get() {

        $this->load->model('message_model');

        $this->message_model->retrieve_messages();
    }

}
