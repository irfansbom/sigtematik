<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spasial_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getspasial(){
        $data = $this->db->get('stis_kosan');
        //  print_r($data);
       return $data;
    }

    public function getkosan(){
        $data = $this->db->get('kos');
            //var_dump($data);
        if($data->num_rows()){
            return $data;
        }else{
            return null;
        }
    }

    // public function getgeom(){
    //     $data = $this->db->query(''){
    //         if($data->num_rows()){
    //             return $data;
    //         }else{
    //             return null;
    //         }
    //     }
    // }

}
?>