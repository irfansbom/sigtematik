<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Retrofit extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model('Spasial_Model','sp_model');
	}

	  

    public function datatag_get(){
        $output =  $this->sp_model->gettagkosan();
		if (!empty($output) && $output != FALSE) {
           
            for($i=0;$i<sizeof($output);$i++){
              $properties[$i]= [
                    'longi' => $output[$i]['long'],
                    'lati' => $output[$i]['lat'],
                    'jenis'=> $output[$i]['jenis'],
                    'alamat'=> $output[$i]['alamat'],
                    'karakteristik'=> $output[$i]['karakteristik'],
                    // 'pemilik'=> $output[$i]['pemilik'],
                    // 'penghunikos'=> $output[$i]['penghunikos'],
                    // 'kapasitas'=> $output[$i]['kapasitas'],
                    // 'luas'=> $output[$i]['luas'],
                    'harga'=> $output[$i]['harga'],
                    // 'jendela'=> $output[$i]['jendela'],
                    // 'wc'=> $output[$i]['wc'],
                    // 'ranjang'=> $output[$i]['ranjang'],
                    // 'lemari'=> $output[$i]['lemari'],
                    // 'meja'=> $output[$i]['meja'],
                    // 'kursi'=> $output[$i]['kursi'],
                    // 'ac'=> $output[$i]['ac'],
                    // 'path'=> $output[$i]['path'],
                ];
            }


          

        $fullmassage=[
            'geotagkosan'=>$properties
        ];
            $this->response($properties, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => "Not Found"
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }


    
}