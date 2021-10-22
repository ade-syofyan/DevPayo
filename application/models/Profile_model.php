<?php

class Profile_model extends CI_model
{
    public function getadmin()
    {
        $this->db->where('id', '1');
        return  $this->db->get('admin')->row_array();
    }

    public function getagent()
    {
        $id = $this->session->userdata('id');
        $this->db->where('id', $id);
        $this->db->where('level_id', 2);
        return  $this->db->get('admin')->row_array();
    }

    public function ubahdataadmin($data)
    {
        $this->db->set('user_name', $data['user_name']);
        $this->db->set('email', $data['email']);
        $this->db->set('image', $data['image']);
        $this->db->set('password', $data['password']);

        $this->db->where('id', '1');
        $this->db->update('admin', $data);
    }
}
