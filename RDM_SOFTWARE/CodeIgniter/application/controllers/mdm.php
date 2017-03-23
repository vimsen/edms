<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mdm
 *
 * @author john
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class mdm extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
    }

    function index() {

        $this->load->view('mdm_view');
    }

}
