<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Merchantapi_model extends CI_model
{

    public function check_banned($phone)
    {
        $stat =  $this->db->query("SELECT id_mitra FROM mitra WHERE status_mitra='3' AND telepon_mitra='$phone'");
        if ($stat->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist($email, $phone)
    {
        $cek = $this->db->query("SELECT id_mitra FROM mitra where email_mitra = '$email' AND telepon_mitra='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone($phone)
    {
        $cek = $this->db->query("SELECT id_mitra FROM mitra where telepon_mitra='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_exist_email($email)
    {
        $cek = $this->db->query("SELECT id_mitra FROM mitra where email_mitra='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_ktp($ktp)
    {
        $cek = $this->db->query("SELECT id_mitra FROM mitra where nomor_identitas_mitra='$ktp'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_merchant($condition)
    {
        $this->db->select('mitra.*, saldo.saldo, merchant.*');
        $this->db->from('mitra');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user');
        $this->db->join('merchant', 'mitra.id_merchant = merchant.id_merchant');
        $this->db->where($condition);
        $this->db->where('status_mitra', '1');
        return $this->db->get();
    }

    public function onmerchant($data, $where)
    {
        $this->db->where($where);
        $this->db->update('merchant', $data);
        return true;
    }

    public function edit_profile_token($data, $phone)
    {
        $this->db->where('telepon_merchant', $phone);
        $this->db->update('merchant', $data);
        return true;
    }

    public function edit_profile($data, $phone)
    {
        $this->db->where('telepon_mitra', $phone);
        $this->db->update('mitra', $data);
        return true;
    }

    public function edit_profile_mitra_merchant($data, $phone)
    {
        $datamitra = [
            'nama_mitra' => $data['nama'],
            'telepon_mitra' => $data['no_telepon'],
            'phone_mitra' => $data['phone'],
            'email_mitra' => $data['email'],
            'country_code_mitra' => $data['countrycode'],
            'alamat_mitra' => $data['alamat']
        ];

        $datamerchant = [
            'telepon_merchant' => $data['no_telepon'],
            'phone_merchant' => $data['phone'],
            'country_code_merchant' => $data['countrycode']
        ];

        $this->db->where('telepon_merchant', $phone);
        $this->db->update('merchant', $datamerchant);

        $this->db->where('telepon_mitra', $phone);
        $this->db->update('mitra', $datamitra);
        return true;
    }

    public function signup($data_signup, $data_merchant, $data_berkas)
    {
        $this->db->insert('merchant', $data_merchant);
        $inserid = $this->db->insert_id();
        $datasignup = array(
            'id_mitra' => $data_signup['id_mitra'],
            'nama_mitra' => $data_signup['nama_mitra'],
            'jenis_identitas_mitra' => $data_signup['jenis_identitas_mitra'],
            'nomor_identitas_mitra' => $data_signup['nomor_identitas_mitra'],
            'alamat_mitra' => $data_signup['alamat_mitra'],
            'email_mitra' => $data_signup['email_mitra'],
            'password' => $data_signup['password'],
            'telepon_mitra' => $data_signup['telepon_mitra'],
            'phone_mitra' => $data_signup['phone_mitra'],
            'country_code_mitra' => $data_signup['country_code_mitra'],
            'partner' => '0',
            'id_merchant' => $inserid,
            'status_mitra' => '0'
        );
        $signup = $this->db->insert('mitra', $datasignup);

        $databerkas = array(
            'id_driver' => $data_signup['id_mitra'],
            'foto_ktp' => $data_berkas['foto_ktp'],
            'foto_sim' => "",
            'id_sim' => ""
        );
        $insberkas = $this->db->insert('berkas_driver', $databerkas);

        $datasaldo = array(
            'id_user' => $data_signup['id_mitra'],
            'saldo' => 0
        );
        $insSaldo = $this->db->insert('saldo', $datasaldo);
        return $signup;
    }

    public function transaksi_home($idmerchant)
    {
        $this->db->select('transaksi_detail_merchant.*, history_transaksi.*, transaksi.id_pelanggan, pelanggan.fullnama, (SELECT SUM(ti.jumlah_item)
        FROM transaksi_item ti
        WHERE ti.id_transaksi = transaksi_detail_merchant.id_transaksi) quantity, pelanggan.fullnama');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('transaksi', 'transaksi_detail_merchant.id_transaksi = transaksi.id');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->where('transaksi_detail_merchant.id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status = 2');
        $this->db->order_by('transaksi.id DESC');
        return $this->db->get();
    }

    public function transaksi_history($idmerchant)
    {
        $this->db->select('transaksi_detail_merchant.*, history_transaksi.*, transaksi.id_pelanggan, pelanggan.fullnama, (SELECT SUM(ti.jumlah_item)
        FROM transaksi_item ti
        WHERE ti.id_transaksi = transaksi_detail_merchant.id_transaksi) quantity');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('transaksi', 'transaksi_detail_merchant.id_transaksi = transaksi.id');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->where('transaksi_detail_merchant.id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status != 2');
        $this->db->where('history_transaksi.status != 1');
        $this->db->where('history_transaksi.status != 0');
        $this->db->order_by('transaksi.id DESC');
        return $this->db->get();
    }

    public function total_history_daily($day, $idmerchant)
    {
        $this->db->select('SUM(transaksi_detail_merchant.total_biaya) daily');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('history_transaksi', 'transaksi_detail_merchant.id_transaksi = history_transaksi.id_transaksi');
        $this->db->where('date(transaksi_detail_merchant.created)', $day);
        $this->db->where('id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status', '4');
        return $this->db->get();
    }

    public function total_history_earning($idmerchant)
    {
        $this->db->select('SUM(transaksi_detail_merchant.total_biaya) earning');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('history_transaksi', 'transaksi_detail_merchant.id_transaksi = history_transaksi.id_transaksi');
        $this->db->where('id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status', '4');
        return $this->db->get();
    }

    public function total_history_month($month, $idmerchant)
    {
        $this->db->select('SUM(transaksi_detail_merchant.total_biaya) month');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('history_transaksi', 'transaksi_detail_merchant.id_transaksi = history_transaksi.id_transaksi');
        $this->db->where('MONTH(transaksi_detail_merchant.created)', $month);
        $this->db->where('id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status', '4');
        return $this->db->get();
    }

    public function total_history_yearly($year, $idmerchant)
    {
        $this->db->select('SUM(transaksi_detail_merchant.total_biaya) yearly');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('history_transaksi', 'transaksi_detail_merchant.id_transaksi = history_transaksi.id_transaksi');
        $this->db->where('YEAR(transaksi_detail_merchant.created)', $year);
        $this->db->where('id_merchant', $idmerchant);
        $this->db->where('history_transaksi.status', '4');
        return $this->db->get();
    }

    public function kategori_active($idmerchant)
    {
        $this->db->select('category_item.*, (SELECT COUNT(ti.id_item)
        FROM item ti
        WHERE ti.kategori_item = category_item.id_kategori_item) total_item');
        $this->db->from('category_item');
        $this->db->where('category_item.id_merchant', $idmerchant);
        $this->db->where('category_item.all_category != 1');
        $this->db->where('category_item.status_kategori = 1');
        return $this->db->get()->result();
    }
    public function kategori_nonactive($idmerchant)
    {
        $this->db->select('category_item.*, (SELECT COUNT(ti.id_item)
        FROM item ti
        WHERE ti.kategori_item = category_item.id_kategori_item) total_item');
        $this->db->from('category_item');
        $this->db->where('category_item.id_merchant', $idmerchant);
        $this->db->where('category_item.all_category != 1');
        $this->db->where('category_item.status_kategori = 0');
        return $this->db->get()->result();
    }

    public function itembycatactive($idmerchant, $idcat)
    {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('item.id_merchant', $idmerchant);
        $this->db->where('item.kategori_item', $idcat);
        $this->db->order_by('item.id_item DESC');
        return $this->db->get();
    }

    public function totalitemactive($idmerchant)
    {
        $this->db->select('COUNT(id_item) as active, (SELECT COUNT(ti.id_item)
        FROM item ti
        WHERE ti.id_merchant =' . $idmerchant . ' and ti.status_item = 0) as nonactive, (SELECT COUNT(ti.id_item)
        FROM item ti
        WHERE ti.id_merchant =' . $idmerchant . ' and ti.status_item = 1 and ti.status_promo = 1) as promo');
        $this->db->from('item');
        $this->db->where('item.id_merchant', $idmerchant);
        $this->db->where('item.status_item', '1');
        return $this->db->get();
    }

    public function actived_kategori($id, $status)
    {
        $data = array(
            'status_kategori' => $status
        );
        $this->db->where('id_kategori_item', $id);
        $this->db->update('category_item', $data);
        return true;
    }

    public function actived_item($id, $status)
    {
        $data = array(
            'status_item' => $status
        );
        $this->db->where('id_item', $id);
        $this->db->update('item', $data);
        return true;
    }

    public function addkategori($nama, $status, $id)
    {
        $data = array(
            'nama_kategori_item' => $nama,
            'status_kategori' => $status,
            'id_merchant' => $id,
            'all_category' => 0,
        );
        $this->db->insert('category_item', $data);
        return true;
    }

    public function editkategori($editdata, $id)
    {
        $this->db->where('id_kategori_item', $id);
        $this->db->update('category_item', $editdata);
        return true;
    }

    public function deletekategori($id)
    {
        $this->db->where('id_kategori_item', $id);
        $this->db->delete('category_item');

        $this->db->where('kategori_item', $id);
        $this->db->delete('item');
        return true;
    }

    public function additem($data)
    {
        $this->db->insert('item', $data);
        return true;
    }

    public function edititem($editdata, $id)
    {
        $this->db->where('id_item', $id);
        $this->db->update('item', $editdata);
        return true;
    }

    public function deleteitem($id)
    {
        $this->db->where('id_item', $id);
        $this->db->delete('item');
        return true;
    }

    public function check_exist_phone_edit($id, $phone)
    {
        $cek = $this->db->query("SELECT telepon_mitra FROM mitra where telepon_mitra='$phone' AND id_mitra!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email_edit($id, $email)
    {
        $cek = $this->db->query("SELECT id_mitra FROM mitra where email_mitra='$email' AND id_mitra!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function kategori_merchant_active()
    {
        $this->db->select('nama_kategori,id_kategori_merchant');
        $this->db->where('status_kategori != 0');
        return $this->db->get('category_merchant')->result_array();
    }

    public function kategori_merchant_active_data($idfitur)
    {
        $this->db->select('nama_kategori,id_kategori_merchant');
        $this->db->where('status_kategori != 0');
        $this->db->where('id_fitur', $idfitur);
        return $this->db->get('category_merchant')->result_array();
    }

    public function fitur_merchant_active()
    {
        $this->db->select('id_fitur,fitur');
        $this->db->from('fitur');
        $this->db->where('home = 4');
        $this->db->where('active', '1');
        $this->db->order_by('id_fitur ASC');
        return $this->db->get()->result_array();
    }
}
