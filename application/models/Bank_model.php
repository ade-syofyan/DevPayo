<?php

class Bank_model extends CI_model
{
    public function actvieBank()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, driver.nama_driver');
        $this->db->from('data_bank');
        $this->db->join('driver', 'data_bank.id_member = driver.id', 'left');
        $this->db->where('data_bank.type_member', 'D');
        $this->db->where('data_bank.status_aprrove', 1);
        return  $this->db->get()->result_array();
    }

    public function rejectBank()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, driver.nama_driver, data_bank.catatan_reject');
        $this->db->from('data_bank');
        $this->db->join('driver', 'data_bank.id_member = driver.id', 'left');
        $this->db->where('data_bank.type_member', 'D');
        $this->db->where('data_bank.status_aprrove', 2);
        return  $this->db->get()->result_array();
    }

    public function actvieMitra()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, mitra.nama_mitra');
        $this->db->from('data_bank');
        $this->db->join('mitra', 'data_bank.id_member = mitra.id_mitra', 'left');
        $this->db->where('data_bank.type_member', 'M');
        $this->db->where('data_bank.status_aprrove', 1);
        return  $this->db->get()->result_array();
    }

    public function rejectMitra()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, mitra.nama_mitra, data_bank.catatan_reject');
        $this->db->from('data_bank');
        $this->db->join('mitra', 'data_bank.id_member = mitra.id_mitra', 'left');
        $this->db->where('data_bank.type_member', 'M');
        $this->db->where('data_bank.status_aprrove', 2);
        return  $this->db->get()->result_array();
    }

    public function dashboardDriver()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, driver.nama_driver, data_bank.id_data_bank');
        $this->db->from('data_bank');
        $this->db->join('driver', 'data_bank.id_member = driver.id', 'left');
        $this->db->where('data_bank.type_member', 'D');
        $this->db->where('data_bank.status_aprrove', 0);
        $this->db->limit(20);
        return  $this->db->get()->result_array();
    }

    public function dashboardMitra()
    {
        $this->db->select('data_bank.nama_bank, data_bank.norek, data_bank.atas_nama, mitra.nama_mitra, data_bank.id_data_bank');
        $this->db->from('data_bank');
        $this->db->join('mitra', 'data_bank.id_member = mitra.id_mitra', 'left');
        $this->db->where('data_bank.type_member', 'M');
        $this->db->where('data_bank.status_aprrove', 0);
        $this->db->limit(20);
        return  $this->db->get()->result_array();
    }
}
