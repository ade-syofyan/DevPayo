<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Place extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper("url");
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }



    // get data province
    function provinsi_get()
    {
        $this->db->select('*');
        $this->db->from('wa_province');
        $province = $this->db->get()->result();

        $this->response($province, 200);
    }

    // get data kabupaten kota berdasarkan id provinsi
    function regency_get()
    {
        $id = $this->get('province_id');
        if ($id == '') {
            $this->db->select('*');
            $this->db->from('wa_regency');
            $regency = $this->db->get()->result();
        } else {
            $this->db->select('*');
            $this->db->from('wa_regency');
            $this->db->where('wa_regency.province_id', $id);
            $regency = $this->db->get()->result();
        }
        $this->response($regency, 200);
    }
}
