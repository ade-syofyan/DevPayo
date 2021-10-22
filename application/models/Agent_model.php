<?php

class Agent_model extends CI_model
{
    public function getDataAgent()
    {
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('wa_district.name as district_name');
        $this->db->select('wa_village.name as village_name');
        $this->db->select('admin.*');
        $this->db->join('wa_province', 'admin.province_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'admin.regency_id = wa_regency.id', 'left');
        $this->db->join('wa_district', 'admin.district_id = wa_district.id', 'left');
        $this->db->join('wa_village', 'admin.village_id = wa_village.id', 'left');
        $this->db->where('admin.level_id', 2);
        // return  $this->db->get_where('admin', ['admin.level_id' => 2])->result_array();
        return  $this->db->get('admin')->result_array();
    }

    public function getListKomisi()
    {
        $month = date('m');
        $query = $this->db->query('SELECT a.nama_lengkap, a.id, a.image, sum(t.biaya_akhir) as total FROM transaksi t LEFT JOIN driver d ON t.id_driver = d.id LEFT JOIN admin a ON d.regency_id = a.regency_id LEFT JOIN history_transaksi ht ON t.id = ht.id_transaksi LEFT JOIN fitur f ON t.order_fitur = f.id_fitur WHERE a.level_id = 2 AND ht.status != 1 AND f.id_fitur = 15 AND MONTH(t.waktu_selesai) = "' . $month . '" GROUP BY d.regency_id');

        return $query->result_array();
    }

    public function filterMonth($month)
    {
        $query = $this->db->query('SELECT a.nama_lengkap, a.id, a.image, sum(t.biaya_akhir) as total FROM transaksi t LEFT JOIN driver d ON t.id_driver = d.id LEFT JOIN admin a ON d.regency_id = a.regency_id LEFT JOIN history_transaksi ht ON t.id = ht.id_transaksi LEFT JOIN fitur f ON t.order_fitur = f.id_fitur WHERE a.level_id = 2 AND ht.status != 1 AND f.id_fitur = 15 AND MONTH(t.waktu_selesai) = "' . $month . '" GROUP BY d.regency_id');

        return $query->result_array();
    }

    public function komisi($id)
    {
        $this->db->select('admin.*');
        $this->db->join('wallet_agent', 'admin.wallet_id = wallet_agent.id_wa', 'right');
        $this->db->join('komisi', 'admin.wallet_id = komisi.id_wallet', 'right');
        return $this->db->get_where('admin', ['admin.id' => $id])->result_array();
    }

    public function get_regency_agent($id)
    {
        $query = $this->db->query('SELECT regency_id FROM `admin` WHERE id = "' . $id . '"');
        return $query->row_array();
    }

    public function getKomisiAgent($reg_id)
    {
        $query = $this->db->query('SELECT sum(biaya_akhir) as total FROM transaksi t LEFT JOIN driver d ON t.id_driver = d.id LEFT JOIN history_transaksi ht ON t.id = ht.id_transaksi LEFT JOIN fitur f ON t.order_fitur = f.id_fitur WHERE ht.status != 1 AND f.id_fitur = 15 AND d.regency_id = "' . $reg_id . '"');

        return $query->row();
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

    public function getDataDis($id)
    {
        $this->db->select('wa_district.*');
        $this->db->where('regency_id', $id);
        $this->db->order_by('name');

        return $this->db->get('wa_district')->result_array();
    }

    public function getDataVillage($id)
    {
        $this->db->select('wa_village.*');
        $this->db->where('district_id', $id);
        $this->db->order_by('name');

        return $this->db->get('wa_village')->result_array();
    }

    public function tambahdata($data)
    {
        $this->db->insert('admin', $data);
    }

    public function ubahdatainfo($data)
    {
        $this->db->set('user_name', $data['user_name']);
        $this->db->set('nama_lengkap', $data['nama_lengkap']);
        $this->db->set('email', $data['email']);
        $this->db->set('countrycode', $data['countrycode']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('province_id', $data['province']);
        $this->db->set('regency_id', $data['regency']);
        $this->db->set('district_id', $data['district']);
        $this->db->set('village_id', $data['village']);
        $this->db->set('alamat', $data['alamat']);
        $this->db->where('id', $data['id']);
        $this->db->update('admin', $data);
    }

    public function ubahdatafoto($data)
    {
        $this->db->set('image', $data['image']);

        $this->db->where('id', $data['id']);
        $this->db->update('admin', $data);
    }

    public function ubahdatapassword($data)
    {
        $this->db->set('password', $data['password']);
        $this->db->where('id', $data['id']);
        $this->db->update('admin', $data);
    }

    public function insertKomisi($komisi, $id_wallet)
    {

        $this->db->insert('komisi', $komisi);
        $id = $this->session->userdata('id');

        $this->db->set('wallet_id', $id_wallet);
        $this->db->where('id', $id);
        $this->db->update('admin');
    }

    public function getagentbyid($id)
    {
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('wa_district.name as district_name');
        $this->db->select('wa_village.name as village_name');
        $this->db->select('admin.*');
        $this->db->join('wa_province', 'admin.province_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'admin.regency_id = wa_regency.id', 'left');
        $this->db->join('wa_district', 'admin.district_id = wa_district.id', 'left');
        $this->db->join('wa_village', 'admin.village_id = wa_village.id', 'left');
        $this->db->where('admin.id', $id);
        return $this->db->get('admin')->row_array();
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admin');
    }

    public function getKomisi($id)
    {
        // $reg_id = $this->session->userdata('regency');
        // $this->db->query('SELECT sum(biaya_akhir) as total FROM transaksi t LEFT JOIN driver d ON t.id_driver = d.id LEFT JOIN history_transaksi ht ON t.id = ht.id_transaksi LEFT JOIN fitur f ON t.order_fitur = f.id_fitur WHERE ht.status != 1 AND f.id_fitur = 15 AND d.regency_id = "' . $reg_id . '"');
        $this->db->select('komisi.*');
        $this->db->where('id_wallet', $id);
        return $this->db->get('komisi')->result_array();
    }

    public function cekWallet($id)
    {
        $this->db->select('wallet_agent.*');
        $this->db->where('id_wa', $id);
        return $this->db->count_all_results('wallet_agent');
    }

    public function getIdWallet()
    {
        $id = $this->session->userdata('id');
        $this->db->select('wallet_id');
        return $this->db->get_where('admin', ['id' => $id])->row_array();
    }
}
