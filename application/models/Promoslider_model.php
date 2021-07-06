<?php

class promoslider_model extends CI_model
{
    public function getAllpromo()
    {
        // $this->db->select('config_driver.status as status_job');
        // $this->db->select('driver_job.driver_job');
        // $this->db->select('driver.*');
        // $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        $this->db->join('fitur', 'promosi.fitur_promosi = fitur.id_fitur', 'left');
        return  $this->db->get('promosi')->result_array();
    }

    public function getpromobyid($id)
    {
        return $this->db->get_where('promosi', ['id' => $id])->row_array();
    }

    public function tambahdatapromo($data)
    {
        return $this->db->insert('promosi', $data);
    }

    public function hapuspromobyId($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('promosi');
    }

    public function ubahdatapromo($data)
    {

        $this->db->set('foto', $data['foto']);
        $this->db->set('tanggal_berakhir', $data['tanggal_berakhir']);
        $this->db->set('fitur_promosi', $data['fitur_promosi']);
        $this->db->set('link_promosi', $data['link_promosi']);
        $this->db->set('type_promosi', $data['type_promosi']);
        $this->db->set('is_show', $data['is_show']);

        $this->db->where('id', $data['id']);
        return $this->db->update('promosi', $data);
    }
}
