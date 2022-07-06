<?php

class Adminsetting_model extends CI_model
{
    public function getData()
    {
        $this->db->select('*');
        $this->db->from('admin_setting');
        $this->db->where('id', 1);
        return $this->db->get()->row_array();
        // return $this->db->get_where('admin_setting', ['admin_setting.id' => 1])->result_array();
    }

    public function ubahdata($data)
    {
        $this->db->set('komisi_agent', $data['komisi_agent']);
        $this->db->where('id', $data['id']);
        $this->db->update('admin_setting', $data);
    }

}
