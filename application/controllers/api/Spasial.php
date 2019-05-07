<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Spasial extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model('Spasial_Model','sp_model');
	}

    public function index_get()
	{		
		$this->load->view('index.html');
	}



	public function showdata_get(){
        $output =  $this->sp_model->getspasial();
		if (!empty($output) && $output != FALSE) {
            $this->response($output->result_array(), REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => "Not Found"
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function datalengkap_get(){
        $output =  $this->sp_model->getgeom();
		if (!empty($output) && $output != FALSE) {
            $this->response($output->result_array(), REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => "Not Found"
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

}