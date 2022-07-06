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

    public function accdriver($id)
    {
        $this->db->set('status_aprrove', 1);
        $this->db->where('id_data_bank', $id);
        $this->db->update('data_bank');
    }

    public function accmitra($id)
    {
        $this->db->set('status_aprrove', 1);
        $this->db->where('id_data_bank', $id);
        $this->db->update('data_bank');
    }

    public function rejectbankdriver($data)
    {
        $this->db->set('catatan_reject', $data['catatan_reject']);
        $this->db->set('status_aprrove', 2);
        $this->db->where('id_data_bank', $data['id_data_bank']);
        $this->db->update('data_bank', $data);
    }

    public function rejectbankmitra($data)
    {
        $this->db->set('catatan_reject', $data['catatan_reject']);
        $this->db->set('status_aprrove', 2);
        $this->db->where('id_data_bank', $data['id_data_bank']);
        $this->db->update('data_bank', $data);
    }
}
