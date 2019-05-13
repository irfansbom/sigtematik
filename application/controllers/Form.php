<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Form extends REST_Controller {

function __construct(){
    parent::__construct();
}

public function index_get()
{		
    $this->load->view('inputkosan.html');
}
}