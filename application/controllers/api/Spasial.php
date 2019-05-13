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


    public function inputkos_post(){
        $targetDir = 'Photos';
        if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["userfile"]["name"];
        }
        $id = rand();
        $filePath = FCPATH . $targetDir . DIRECTORY_SEPARATOR . $id . '_' . $fileName;
        print_r($filePath);
        $insert_data = [
            'alamat'    =>    $this->input->post('alamat'),
            'wilayah' => $this->input->post('wilayah'),
            'jenis' => $this->input->post('jenis'),
            'karakteristik'    =>    $this->input->post('karakteristik'),
            'pemilik'    =>    $this->input->post('pemilik'),
            'penghunikos'    =>    $this->input->post('penghunikos'),
            'kapasitas'    =>    $this->input->post('kapasitas'),
            'luas'    =>    $this->input->post('luas'),
            'harga'    =>    $this->input->post('harga'),
            'jendela'    =>    $this->input->post('jendela'),
            'wc'    =>    $this->input->post('wc'),
            'ranjang'    =>    $this->input->post('ranjang'),
            'lemari'    =>    $this->input->post('lemari'),
            'meja'    =>    $this->input->post('meja'),
            'kursi'    =>    $this->input->post('kursi'),
            'ac'    =>    $this->input->post('ac'),
            'nocluster'    =>    $this->input->post('nocluster'),
        ];
       
        $result = $this->sp_model->inputkos($insert_data);
        $insert_data2 = [
            'no' => $result[0]["no"],
            'path' => $id. "_" .$fileName ,
            'long'=>   $this->input->post('longitude'),
            'lat'  =>    $this->input->post('latitude'),
        ];
        $result2 = $this->sp_model->inputspasial($insert_data2);

        $cleanupTargetDir = true;
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                 http_response_code(500);
				die('{"jsonrpc" : "2.0", "error" : {"code": 500, "message": "Failed to open temp directory."}, "id" : "id"}');
			}
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
        }
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            // print_r($chunks);
            http_response_code(500);
            die('{"jsonrpc" : "2.0", "error" : {"code":502, "message": "Failed to open output stream."}, "id" : "id"}');
        }
        if (!empty($_FILES)) {
            if ($_FILES["userfile"]["error"] || !is_uploaded_file($_FILES["userfile"]["tmp_name"])) {
                 http_response_code(500);
                die('{"jsonrpc" : "2.0", "error" : {"code": 503, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }
            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["userfile"]["tmp_name"], "rb")) {
                 http_response_code(500);
                die('{"jsonrpc" : "2.0", "error" : {"code": 501, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                 http_response_code(500);
                die('{"jsonrpc" : "2.0", "error" : {"code": 501, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        rename("{$filePath}.part", $filePath);

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

    public function nocluster_get($long, $lat){
        $output =  $this->sp_model->cekcluster($long, $lat);
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

}