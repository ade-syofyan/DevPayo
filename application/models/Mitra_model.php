<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mitra_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getAllmitra()
    {
        $this->db->select('category_merchant.nama_kategori');
        $this->db->select('fitur.fitur');
        $this->db->select('merchant.*');
        $this->db->select('mitra.*');
        $this->db->join('merchant', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');
        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        return  $this->db->get('mitra')->result_array();
    }

    public function getmitrabyid($id)
    {
        $this->db->select('berkas_driver.foto_ktp');
        $this->db->select('category_merchant.nama_kategori');
        $this->db->select('fitur.fitur');
        $this->db->select('saldo.saldo');
        $this->db->select('merchant.*');
        $this->db->select('mitra.*');
        $this->db->join('berkas_driver', 'mitra.id_mitra = berkas_driver.id_driver', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('merchant', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');
        return  $this->db->get_where('mitra', ['mitra.id_mitra' => $id])->row_array();
    }

    public function countorder($id)
    {
        $this->db->select('id_merchant');
        $query = $this->db->get_where('transaksi_detail_merchant', ['id_merchant' => $id])->result_array();
        return count($query);
    }

    public function wallet($id)
    {
        $this->db->order_by('wallet.id', 'DESC');
        return $this->db->get_where('wallet', ['id_user' => $id])->result_array();
    }


    public function blockmitrabyid($id)
    {
        $this->db->set('status_mitra', 3);
        $this->db->where('id_mitra', $id);
        $this->db->update('mitra');
    }

    public function unblockmitrabyid($id)
    {
        $this->db->set('status_mitra', 1);
        $this->db->where('id_mitra', $id);
        $this->db->update('mitra');
    }

    public function get_trans_merchant($idtransaksi)
    {
        $this->db->select('mitra.*,transaksi_detail_merchant.id_merchant,transaksi_detail_merchant.total_biaya');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('mitra', 'transaksi_detail_merchant.id_merchant = mitra.id_merchant');
        $this->db->where('id_transaksi', $idtransaksi);
        return $this->db->get();
    }

    public function getitembyid($id)
    {
        $this->db->from('item');
        $this->db->where('id_merchant', $id);
        return $this->db->get()->result_array();
    }

    public function getitemkbyid($id)
    {
        $this->db->from('category_item');
        $this->db->where('id_merchant', $id);
        return $this->db->get()->result_array();
    }

    public function getmerchantk()
    {
        $this->db->from('category_merchant');
        $this->db->where('id_fitur != 0');
        return $this->db->get()->result_array();
    }

    public function insertitem($data)
    {
        return $this->db->insert('item', $data);
    }

    public function updateitem($data, $id)
    {
        $this->db->set('kategori_item', $data['kategori_item']);
        $this->db->set('nama_item', $data['nama_item']);
        $this->db->set('harga_item', $data['harga_item']);
        $this->db->set('harga_promo', $data['harga_promo']);
        $this->db->set('id_merchant', $data['id_merchant']);
        $this->db->set('deskripsi_item', $data['deskripsi_item']);
        $this->db->set('status_item', $data['status_item']);
        $this->db->set('status_promo', $data['status_promo']);
        $this->db->set('foto_item', $data['foto_item']);
        $this->db->where('id_item', $id);
        $this->db->update('item');
    }

    public function hapusitembyid($id)
    {
        $this->db->where('id_item', $id);
        $this->db->delete('item');
    }

    public function getfotoitem($id)
    {

        $this->db->where('id_item', $id);
        return  $this->db->get('item')->row_array();
    }

    public function getmerchantdetail($id)
    {
        $this->db->where('id_merchant', $id);
        return  $this->db->get('merchant')->row_array();
    }

    public function getidmitra($id)
    {

        $this->db->where('id_merchant', $id);
        return  $this->db->get('mitra')->row_array();
    }
    public function get_fitur_merchant()
    {
        $this->db->select('*');
        $this->db->from('fitur');
        $this->db->where('active', '1');
        $this->db->where('home', '4');
        return $this->db->get()->result_array();
    }

    public function updatemerchant($data)
    {
        $idmerchant = $data['id_merchant'];
        $this->db->where('id_merchant', $idmerchant);
        $this->db->update('merchant', $data);
    }

    public function hapuskategoryitembyId($id)
    {
        $this->db->where('kategori_item', $id);
        $this->db->delete('item');
        $this->db->where('id_kategori_item', $id);
        $this->db->delete('category_item');
    }

    public function getidmitrabycategory($id)
    {
        $this->db->select('mitra.*');
        $this->db->join('mitra', 'category_item.id_merchant = mitra.id_merchant');
        $this->db->where('id_kategori_item', $id);
        return $this->db->get('category_item')->row_array();
    }

    public function tambahkategoryitembyid($data)
    {
        return $this->db->insert('category_item', $data);
    }

    public function ubahkategoryitembyid($data, $id)
    {
        $this->db->set('nama_kategori_item', $data['nama_kategori_item']);
        $this->db->where('id_kategori_item', $id);
        $this->db->update('category_item');
    }

    public function ubahmitrabyid($data, $idm)
    {

        $this->db->where('id_mitra', $idm);
        $this->db->update('mitra', $data);
    }

    public function ubahfilemitrabyid($data, $id)
    {
        $this->db->set('foto_ktp', $data['foto_ktp']);
        $this->db->where('id_driver', $id);
        $this->db->update('berkas_driver');


        $this->db->set('nomor_identitas_mitra', $data['nomor_identitas_mitra']);
        $this->db->set('jenis_identitas_mitra', $data['jenis_identitas_mitra']);

        $this->db->where('id_mitra', $id);
        $this->db->update('mitra');
    }

    public function ubahpassmitrabyid($data, $idm)
    {
        $this->db->set('password', $data['password']);
        $this->db->where('id_mitra', $idm);
        $this->db->update('mitra');
    }

    public function gettranshistory($id)
    {
        $this->db->select('pelanggan.fullnama');
        $this->db->select('transaksi_item.*');
        $this->db->select('transaksi.*');
        $this->db->select('transaksi_detail_merchant.*');

        $this->db->join('transaksi_item', 'transaksi_detail_merchant.id_transaksi = transaksi_item.id_transaksi', 'left');
        $this->db->join('transaksi', 'transaksi_detail_merchant.id_transaksi = transaksi.id', 'left');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->where('history_transaksi.status != 0');
        return  $this->db->get_where('transaksi_detail_merchant', "transaksi_detail_merchant.id_merchant = $id")->result_array();
    }


    public function hapusmitrabyid($id)
    {

        $this->db->where('id_user', $id);
        $this->db->delete('wallet');
        $this->db->where('id_user', $id);
        $this->db->delete('saldo');
        $this->db->where('id_mitra', $id);
        $this->db->delete('mitra');
    }

    public function ubahstatusmitra($id)
    {


        $mitra = $this->getmitrabyid($id);
        $idmerchant = $mitra['id_merchant'];

        $this->db->set('status_mitra', '1');
        $this->db->where('id_mitra', $id);
        $this->db->update('mitra');

        $this->db->set('status_merchant', '1');
        $this->db->where('id_merchant', $idmerchant);
        $this->db->update('merchant');
    }

    public function insertmerchant($data)
    {
        $this->db->insert('merchant', $data);
        return $this->db->insert_id();
    }

    public function tambahkanmitra($datamitra, $databerkas, $datasaldo)
    {
        $this->db->insert('mitra', $datamitra);
        $this->db->insert('berkas_driver', $databerkas);
        $this->db->insert('saldo', $datasaldo);
    }

    public function getitembyiditem($id)
    {
        $this->db->from('item');
        $this->db->where('id_item', $id);
        return $this->db->get()->row_array();
    }

    public function getberkasbyid($id)
    {
        $this->db->where('id_driver', $id);
        return $this->db->get('berkas_driver')->row_array();
    }
}
