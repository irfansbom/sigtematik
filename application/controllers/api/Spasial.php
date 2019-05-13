<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Spasial extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model('Spasial_Model','sp_model');
	}

	public function showdata_get(){
        $output =  $this->sp_model->getspasial();
		if (!empty($output) && $output != FALSE) {
            $this->response($output, REST_Controller::HTTP_OK);
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

                for($i=0;$i<sizeof($output);$i++){
                    $coordinat[$i] = $output[$i]['geom'];
                    $properties[$i]= [
                        'namawilaya'=> $output[$i]['namawilaya'],
                        'nocluster'=> $output[$i]['nocluster'],
                        'hargaAvg'=> $output[$i]['hargaAVG']
                    ];

                    $realcoor[$i]=(explode("\"",$coordinat[$i],7));
                    $type[$i]=$realcoor[$i][3];
                    $realcoor2[$i]=(explode(":",$realcoor[$i][6]));
                     $fullcoordinat[$i]=$realcoor2[$i][1];
                     $fullcoordinat2[$i]= substr($fullcoordinat[$i], 4, strlen($fullcoordinat[$i])-9 );
                     $fullcoordinat3[$i]= explode("],[", $fullcoordinat2[$i]);
                        for($k=0;$k<sizeof($fullcoordinat3[$i]);$k++){
                            $fullcoordinat4[0][$k][0] = $fullcoordinat3[$i][$k];
                            $fullcoordinat5[$i][$k]= explode(",", $fullcoordinat3[$i][$k]);
                            $fullcoordinat5[$i][$k][0] = (double) $fullcoordinat5[$i][$k][0];
                            $fullcoordinat5[$i][$k][1] = (double) $fullcoordinat5[$i][$k][1];
                            $fullcoordinat5[$i][$k][3] = 0.0;
                        } 
                }
                for($j=0; $j<sizeof($output);$j++){
                    $massage[$j]=[
                        'type'=>'Feature',
                        'geometry'=> [
                            'type'=> $type[$j], 
                            'coordinates'=> array(array($fullcoordinat5[$j])),
                        ],
                        'properties'=>$properties[$j]
                    ];
                }
            $fullmassage=[
                'type'=>"FeatureCollection", 
                'features'=>$massage
                
            ];
                $this->response($fullmassage, REST_Controller::HTTP_OK);
        } else {
                   $message = [
                        'status' => FALSE,
                        'message' => "Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
    }

    public function datadikit_get(){
        $output =  $this->sp_model->getgeomdikit();
        if (!empty($output) && $output != FALSE) {
        $massage=[
            'message' => $output
        ];
            $this->response($massage, REST_Controller::HTTP_OK);
        } else {
                   $message = [
                        'status' => FALSE,
                        'message' => "Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
    }

    public function dataspasial_get(){
            $output =  $this->sp_model->getspasial();
            if (!empty($output) && $output != FALSE) {
                for($i=0;$i<sizeof($output);$i++){
                    $coordinat[$i] = $output[$i]['geom'];
                    $properties[$i]= [
                        'namawilaya'=> $output[$i]['namawilaya'],
                        'nocluster'=> $output[$i]['id'],
                    ];
                }
                for($j=0; $j<sizeof($output);$j++){
                    $massage[$j]=[
                        'type'=>'Feature',
                        'geometry'=> $coordinat[$j], 
                        'properties'=>$properties[$j]
                    ];
                }
            
                $fullmassage=[
                    'type'=>"FeatureCollection", 
                    'features'=>$massage
                
                ];
                $this->response($fullmassage, REST_Controller::HTTP_OK);
            } else {
                       $message = [
                            'status' => FALSE,
                            'message' => "Not Found"
                        ];
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    }
    }

    public function datatag_get(){
        $output =  $this->sp_model->gettagkosan();
		if (!empty($output) && $output != FALSE) {
           
            for($i=0;$i<sizeof($output);$i++){
                $coordinat[$i] = [ (double) $output[$i]['long'], (double) $output[$i]['lat'] ];
                $properties[$i]= [
                    'jenis'=> $output[$i]['jenis'],
                    'alamat'=> $output[$i]['alamat'],
                    'karakteristik'=> $output[$i]['karakteristik'],
                    'pemilik'=> $output[$i]['pemilik'],
                    'penghunikos'=> $output[$i]['penghunikos'],
                    'kapasitas'=> $output[$i]['kapasitas'],
                    'luas'=> $output[$i]['luas'],
                    'harga'=> $output[$i]['harga'],
                    'jendela'=> $output[$i]['jendela'],
                    'wc'=> $output[$i]['wc'],
                    'ranjang'=> $output[$i]['ranjang'],
                    'lemari'=> $output[$i]['lemari'],
                    'meja'=> $output[$i]['meja'],
                    'kursi'=> $output[$i]['kursi'],
                    'ac'=> $output[$i]['ac'],
                    'path'=> $output[$i]['path'],
                ];
            }


            for($j=0; $j<sizeof($output);$j++){
                $massage[$j]=[
                    'type'=>'Feature',
                    'geometry'=> [
                        'type'=> "Point", 
                        'coordinates'=>$coordinat[$j],
                    ],
                    'properties'=>$properties[$j]
                ];
            }

        $fullmassage=[
            'type'=>"FeatureCollection", 
            'features'=>$massage
        ];
            $this->response($fullmassage, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => "Not Found"
            ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }


}