<?php

class Agent_model extends CI_model
{
    public function getDataAgent()
    {
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('admin.*');
        $this->db->join('wa_province', 'admin.province_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'admin.regency_id = wa_regency.id', 'left');
        $this->db->where('admin.level_id', 2);
        // return  $this->db->get_where('admin', ['admin.level_id' => 2])->result_array();
        return  $this->db->get('admin')->result_array();
    }

    public function getDataProv()
    {
        $this->db->select('wa_province.*');
        $this->db->order_by('name');

        return $this->db->get('wa_province')->result_array();
    }

    public function getDataReg($id)
    {
        $this->db->select('wa_regency.*');
        $this->db->where('province_id', $id);
        $this->db->order_by('name');

        return $this->db->get('wa_regency')->result_array();
    }

    public function tambahdata($data)
    {
        // var_dump($data);die;
        $this->db->insert('admin', $data);
        // die;
        // $this->db->insert('saldo', $data2);
    }
}
