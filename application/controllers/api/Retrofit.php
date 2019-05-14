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

    public function inputkos_post(){
        // $targetDir = 'Photos';
        // if (isset($_REQUEST["name"])) {
		// 	$fileName = $_REQUEST["name"];
		// } elseif (!empty($_FILES)) {
		// 	$fileName = $_FILES["userfile"]["name"];
        // }
        // $id = rand();
        // $filePath = FCPATH . $targetDir . DIRECTORY_SEPARATOR . $id . '_' . $fileName;
        // print_r($filePath);
        $insert_data = [

            'alamat'    =>    $this->input->post('alamat'),
            // 'wilayah' => $this->input->post('wilayah'),
            'jenis' => $this->input->post('jenis'),
            'karakteristik'    =>    $this->input->post('karakteristik'),
            // 'pemilik'    =>    $this->input->post('pemilik'),
            // 'penghunikos'    =>    $this->input->post('penghunikos'),
            // 'kapasitas'    =>    $this->input->post('kapasitas'),
            // 'luas'    =>    $this->input->post('luas'),
            'harga'    =>    $this->input->post('harga'),
            // 'jendela'    =>    $this->input->post('jendela'),
            // 'wc'    =>    $this->input->post('wc'),
            // 'ranjang'    =>    $this->input->post('ranjang'),
            // 'lemari'    =>    $this->input->post('lemari'),
            // 'meja'    =>    $this->input->post('meja'),
            // 'kursi'    =>    $this->input->post('kursi'),
            // 'ac'    =>    $this->input->post('ac'),
            // 'nocluster'    =>    $this->input->post('nocluster'),
        ];
       
        $result = $this->sp_model->inputkos($insert_data);
        $insert_data2 = [
            'no' => $result[0]["no"],
            // 'path' => $id. "_" .$fileName ,
            'long'=>   $this->input->post('longitude'),
            'lat'  =>    $this->input->post('latitude'),
        ];
        $result2 = $this->sp_model->inputspasial($insert_data2);
        if(!empty($result2) && $result2 != FALSE){
            $this->response($result2, REST_Controller::HTTP_OK);
        }else{
            $message = [
                'status' => FALSE,
                'message' => "Not Found"
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }


    
}

// ashkasjak