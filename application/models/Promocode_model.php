<?php

class promocode_model extends CI_model
{
    public function getAllpromocode()
    {
        $this->db->join('fitur', 'kodepromo.fitur = fitur.id_fitur', 'left');
        return  $this->db->get('kodepromo')->result_array();
    }

    public function getpromocodebyid($id)
    {
        return $this->db->get_where('kodepromo', ['id_promo' => $id])->row_array();
    }

    public function hapuspromocodebyId($id)
    {
        $this->db->where('id_promo', $id);
        $this->db->delete('kodepromo');
    }

    public function addpromocode($data)
    {
        return $this->db->insert('kodepromo', $data);
    }

    public function cekpromo($code)
    {
        $this->db->select('*');
        $this->db->from('kodepromo');
        $this->db->where('kode_promo',$code);
        return $this->db->get(); 
    }

    public function getpromobyid($id)
    {
        $this->db->select('*');
        $this->db->from('kodepromo');
        $this->db->where('id_promo',$id);
        return $this->db->get(); 
    }

    public function editpromocode($data)
    {
        $this->db->where('id_promo', $data['id_promo']);
        return $this->db->update('kodepromo', $data);
    }

}