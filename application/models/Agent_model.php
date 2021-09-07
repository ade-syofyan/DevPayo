<?php

class Agent_model extends CI_model
{
    public function getagen()
    {
        $this->db->where('id', '!=', '1');
        return  $this->db->get('admin')->result_array();
    }

    // public function ubahdataagen($data, $id)
    // {
    //     $this->db->set('user_name', $data['user_name']);
    //     $this->db->set('email', $data['email']);
    //     $this->db->set('image', $data['image']);
    //     $this->db->set('password', $data['password']);

    //     $this->db->where('id', $id);
    //     $this->db->update('admin', $data);
    // }
}
