<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Select_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getDataProv()
    {
        return $this->db->get('wa_province')->result_array();
    }

    public function getDataRegency($idprov)
    {
        return $this->db->get_where('wa_regency', ['province_id' => $idprov])->result();
    }

    public function getDataKecamatan($idreg)
    {
        return $this->db->get_where('wa_district', ['regency_id' => $idreg])->result();
    }
    public function getDataKelurahan($idkelurahan)
    {
        return $this->db->get_where('wa_village', ['district_id' => $idkelurahan])->result();
    }
}
