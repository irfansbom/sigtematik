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

    // public function datalengkap_get(){
    //     $output =  $this->sp_model->getgeom();
	// 	if (!empty($output) && $output != FALSE) {
    //         print_r($output);
    //         for($i=0; $i<sizeof($output); $i++){
    //             $message1 = [
    //                 'type'=>"FeatureCollection",
    //                 'geometry'=>[

    //                 ]

    //             ];
    //         }
            
    //         $message= [
    //             'type'=>"FeatureCollection",
    //             'features'=> [$message1
    //             ]
    //             ];


    //         $this->response($message, REST_Controller::HTTP_OK);
    //     } else {
    //         $message = [
    //             'status' => FALSE,
    //             'message' => "Not Found"
    //         ];
    //         $this->response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }
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
                //    var_dump($realcoor[$i]);
                    $type[$i]=$realcoor[$i][3];

                    $realcoor2[$i]=(explode(":",$realcoor[$i][6]));
                    // $fullcoordinat[$i]=$realcoor[$i][6];
                    // print_r($realcoor2);
                     $fullcoordinat[$i]=$realcoor2[$i][1];
                }
                for($j=0; $j<sizeof($output);$j++){
                    $massage[$j]=[
                        'type'=>'Feature',
                        'geometry'=> [
                            'type'=> $type[$j], 
                            'coordinates'=> $fullcoordinat[$j], 
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
}