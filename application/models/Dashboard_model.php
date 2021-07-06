<?php


class Dashboard_model extends CI_model
{
  public function getAlltransaksi()
  {
    $this->db->select('transaksi.*,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('history_transaksi.status != 1');
    $this->db->where('history_transaksi.status != 0');
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }

  
  function getTotalTransaksiBulanan($bulan, $tahun, $typefitur)
  {
    //        lihat tranasksi tanpa limit 15
    $query = $this->db->query("
                SELECT COUNT(transaksi.id) as jumlah
                FROM transaksi
                left join fitur on transaksi.order_fitur = fitur.id_fitur
                left join history_transaksi on transaksi.id = history_transaksi.id_transaksi
                
                WHERE MONTH(waktu_selesai) = $bulan
                AND YEAR(waktu_selesai) = $tahun
                AND fitur.home = $typefitur
                AND history_transaksi.status = 4
            ");
    return $query->result_array();
  }

  public function getbydate()
  {
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    $this->db->select('fitur.fitur');
    $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE DAY(tr.waktu_selesai) = $day
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as hari
                ");
                $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE MONTH(tr.waktu_selesai) = $month
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as bulan
                ");
                $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE YEAR(tr.waktu_selesai) = $year
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as tahun
                ");
    $this->db->from('fitur');
    return $this->db->get()->result_array();

  }

  function getTotalTransaksiharian($hari, $fitur)
  {
    //        lihat tranasksi tanpa limit 15
    $query = $this->db->query("
                SELECT COUNT(transaksi.id) as jumlah
                FROM transaksi
                left join history_transaksi on transaksi.id = history_transaksi.id_transaksi
                
                WHERE DAY(waktu_selesai) = $hari
                AND history_transaksi.status = 4
            ");
    return $query->result_array();
  }

  public function getallsaldo()
  {
    $this->db->select('SUM(biaya_akhir)as total');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->where('history_transaksi.status != 1');
    return $this->db->get('transaksi')->row_array();
  }

  public function getAllfitur()
  {
    return $this->db->get('fitur')->result_array();
  }

  public function gettransaksibyid($id)
  {
    $this->db->select('merchant.*');
    $this->db->select('transaksi_detail_merchant.total_biaya as total_belanja');
    $this->db->select('transaksi_detail_send.*');
    $this->db->select('history_transaksi.*');
    $this->db->select('status_transaksi.*');
    $this->db->select('voucher.*');
    $this->db->select('fitur.*');
    $this->db->select('rating_driver.*');
    $this->db->select('pelanggan.fullnama,pelanggan.email as email_pelanggan,pelanggan.no_telepon as telepon_pelanggan,pelanggan.fotopelanggan,pelanggan.token');
    $this->db->select('driver.nama_driver,driver.foto,driver.email,driver.no_telepon,driver.reg_id');
    $this->db->select('transaksi.*');

    $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
    $this->db->join('merchant', 'transaksi_detail_merchant.id_merchant = merchant.id_merchant', 'left');
    $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('voucher', 'transaksi.order_fitur = voucher.untuk_fitur', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->join('rating_driver', 'transaksi.id = rating_driver.id_transaksi', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->where('history_transaksi.status != 1');
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get_where('transaksi', ['transaksi.id' => $id])->row_array();
  }

  public function getitem($id)
  {
    $this->db->where("transaksi_item.id_transaksi = $id");
    $this->db->join('item', 'transaksi_item.id_item = item.id_item', 'left');
    return $this->db->get('transaksi_item')->result_array();
  }

  public function ubahstatustransaksibyid($id)
  {
    $this->db->set('status', 5);
    $this->db->where('id_transaksi', $id);
    $this->db->update('history_transaksi');
  }

  public function ubahstatusdriverbyid($id_driver)
  {
    $this->db->set('status', 4);
    $this->db->where('id_driver', $id_driver);
    $this->db->update('config_driver');
  }

  public function deletetransaksi($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('transaksi');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('history_transaksi');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('rating_driver');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('transaksi_detail_send');
  }

  public function countdriver()
  {
    $this->db->where('status != 0');
    return $this->db->get('driver')->result_array();
  }

  public function countmitra()
  {
    $this->db->where('status_mitra != 0');
    return $this->db->get('mitra')->result_array();
  }
}
