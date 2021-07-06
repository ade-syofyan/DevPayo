<?php

class partnerjob_model extends CI_model
{
    public function getAllpartnerjob()
    {
        return  $this->db->get('driver_job')->result_array();
    }

    public function addpartnerjob($data)
    {
        $this->db->insert('driver_job', $data);
    }

    public function getpartnerjobbyid($id)
    {
        return $this->db->get_where('driver_job', ['id' => $id])->row_array();
    }

    public function editdatapartnerjob($data)
    {

        $this->db->set('icon', $data['icon']);
        $this->db->set('driver_job', $data['driver_job']);
        $this->db->set('status_job', $data['status_job']);

        $this->db->where('id', $data['id']);
        return $this->db->update('driver_job', $data);
    }

    public function deletepartnerjobbyId($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('driver_job');
    }
}