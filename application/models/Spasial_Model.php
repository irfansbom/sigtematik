<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Spasial_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getspasial(){
        $data = $this->db->query('SELECT id, namawilaya, ST_AsGeoJSON(geom):: json  as geom FROM stis_kosan');
        //  print_r($data);
       return $data->result_array();
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

    public function getgeom(){
        $data = $this->db->query('SELECT k.noCluster, ST_AsGeoJSON(c.geom)::json as geom, c.namawilaya ,SUM(k.harga/t.jumlah) as "hargaAVG" FROM kos k JOIN stis_kosan c ON (c.gid = k.noCluster)INNER JOIN (SELECT noCluster, COUNT(*) as jumlah FROM kos GROUP BY noCluster) t ON (k.noCluster=t.noCluster) GROUP BY k.noCluster,c.geom,c.namawilaya');
        if($data->num_rows()){
                return $data->result_array();
            }else{
                return null;
            }
    }

    public function getgeomdikit(){
        $data = $this->db->query('SELECT k.noCluster, c.namawilaya ,SUM(k.harga/t.jumlah) as "hargaAVG" FROM kos k JOIN stis_kosan c ON (c.gid = k.noCluster)INNER JOIN (SELECT noCluster, COUNT(*) as jumlah FROM kos GROUP BY noCluster) t ON (k.noCluster=t.noCluster) GROUP BY k.noCluster,c.namawilaya');
        if($data->num_rows()){
                return $data->result_array();
            }else{
                return null;
            }
    }

    public function gettagkosan(){
        $data = $this->db->select('*')->from('kos')->join('geotagkosan', 'geotagkosan.no = kos.no')->get();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return null;
        }
    }

    public function inputkos(array $data){
        $this->db->insert('kos', $data);
        $c = $this->db->select('no')->order_by('no','DESC')->limit('1')->get('kos');
        return $c->result_array();
    }

    public function inputspasial(array $data){
        $this->db->insert('geotagkosan', $data);
        if ($this->db->affected_rows()> 0 ) {
            return array('message' => 'sukses');
        }
    }


}
?>