<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Address_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getProvince()
    {
        return  $this->db->get('wa_province')->result_array();
    }
    public function getRegency()
    {
        return  $this->db->get('wa_regency')->result_array();
    }
}
