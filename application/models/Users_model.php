<?php
class Users_model extends CI_model
{
    public function getAllusers()
    {
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('pelanggan.*');
        $this->db->join('wa_province', 'pelanggan.provinsi_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'pelanggan.regency_id = wa_regency.id', 'left');
        $this->db->where('pelanggan.status = 1');
        return $this->db->get('pelanggan')->result_array();
    }

    public function getusersbyid($id)
    {
        // $this->db->select('kendaraan.*');
        $this->db->select('saldo.saldo');
        // $this->db->select('fitur.*');
        // $this->db->select('driver_job.driver_job');
        $this->db->select('pelanggan.*');
        // $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k', 'left');
        $this->db->join('saldo', 'pelanggan.id = saldo.id_user', 'left');
        // $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        // $this->db->join('fitur', 'pelanggan.order_fitur = fitur.id_fitur', 'left');
        return  $this->db->get_where('pelanggan', ['pelanggan.id' => $id])->row_array();
    }

    public function getcurrency()
    {
        $this->db->select('app_currency as duit');
        $this->db->where('id', '1');
        return $this->db->get('app_settings')->row_array();
    }

    public function wallet($id)
    {
        $this->db->order_by('wallet.id', 'DESC');
        return $this->db->get_where('wallet', ['id_user' => $id])->result_array();
    }

    public function countorder($id)
    {

        $this->db->select('status_transaksi.*');
        $this->db->select('history_transaksi.*');
        $this->db->select('fitur.*');
        $this->db->select('transaksi.*');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('history_transaksi.status != 1');
        $this->db->order_by('transaksi.id', 'DESC');
        $query =    $this->db->get_where('transaksi', ['id_pelanggan' => $id])->result_array();
        return $query;
    }

    public function blockusersbyid($id)
    {
        $this->db->set('status', '0');
        $this->db->where('id', $id);
        $this->db->Update('pelanggan');
    }

    public function unblockusersbyid($id)
    {
        $this->db->set('status', '1');
        $this->db->where('id', $id);
        $this->db->Update('pelanggan');
    }

    public function ubahdataid($data)
    {
        $this->db->set('fullnama', $data['fullnama']);
        $this->db->set('no_telepon', $data['no_telepon']);
        $this->db->set('email', $data['email']);
        $this->db->set('countrycode', $data['countrycode']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('tgl_lahir', $data['tgl_lahir']);


        $this->db->where('id', $data['id']);
        $this->db->update('pelanggan', $data);
    }

    public function ubahdatafoto($data)
    {
        $this->db->set('fotopelanggan', $data['fotopelanggan']);

        $this->db->where('id', $data['id']);
        $this->db->update('pelanggan', $data);
    }

    public function ubahdatapassword($data)
    {
        $this->db->set('password', $data['password']);

        $this->db->where('id', $data['id']);
        $this->db->update('pelanggan', $data);
    }

    public function blockuserbyid($id)
    {
        $this->db->set('status', 0);
        $this->db->where('id', $id);
        $this->db->update('pelanggan');
    }

    public function unblockuserbyid($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('pelanggan');
    }

    public function tambahdatausers($data)
    {
        $this->db->insert('pelanggan', $data);
        $data2 = [
            'id_user' => $data['id'],
            'saldo'   => 0,
        ];
        $this->db->insert('saldo', $data2);
    }

    public function hapusdatauserbyid($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pelanggan');

        $this->db->where('id_pelanggan', $id);
        $this->db->delete('transaksi');

        $this->db->where('id_user', $id);
        $this->db->delete('saldo');

        $this->db->where('userid', $id);
        $this->db->delete('forgot_password');

        $this->db->where('id_pelanggan', $id);
        $this->db->delete('rating_driver');

        $this->db->where('id_user', $id);
        $this->db->delete('wallet');
    }
}
