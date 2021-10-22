<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Driver_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }
    public function signup($data_signup, $data_kendaraan, $data_berkas)
    {
        $inskendaraan = $this->db->insert('kendaraan', $data_kendaraan);
        $inserid = $this->db->insert_id();
        $datasignup = array(
            'id' => $data_signup['id'],
            'nama_driver' => $data_signup['nama_driver'],
            'no_ktp' => $data_signup['no_ktp'],
            'tgl_lahir' => $data_signup['tgl_lahir'],
            'no_telepon' => $data_signup['no_telepon'],
            'phone' => $data_signup['phone'],
            'email' => $data_signup['email'],
            'countrycode' => $data_signup['countrycode'],
            'foto' => $data_signup['foto'],
            'password' => $data_signup['password'],
            'job' => $data_signup['job'],
            'gender' => $data_signup['gender'],
            'alamat_driver' => $data_signup['alamat_driver'],
            'reg_id' => '12345',
            'kendaraan' => $inserid,
            'status' => '0'
        );

        $signup = $this->db->insert('driver', $datasignup);

        $dataconfig = array(
            'id_driver' => $data_signup['id'],
            'latitude' => '0',
            'longitude' => '0',
            'status' => '5'
        );

        $insconfig = $this->db->insert('config_driver', $dataconfig);

        $databerkas = array(
            'id_driver' => $data_signup['id'],
            'foto_ktp' => $data_berkas['foto_ktp'],
            'foto_sim' => $data_berkas['foto_sim'],
            'id_sim' => $data_berkas['id_sim']
        );

        $insberkas = $this->db->insert('berkas_driver', $databerkas);

        $datasaldo = array(
            'id_user' => $data_signup['id'],
            'saldo' => 0
        );

        $insSaldo = $this->db->insert('saldo', $datasaldo);

        return $signup;
    }

    public function check_exist($email, $phone)
    {
        $cek = $this->db->query("SELECT id FROM driver where email='$email' AND no_telepon='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_ktp($ktp)
    {
        $cek = $this->db->query("SELECT id FROM driver where no_ktp='$ktp'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_sim($sim)
    {
        $cek = $this->db->query("SELECT id_berkas FROM berkas_driver where id_sim='$sim'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone($phone)
    {
        $cek = $this->db->query("SELECT id FROM driver where no_telepon='$phone'");

        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email($email)
    {
        $cek = $this->db->query("SELECT id FROM driver where email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($phone)
    {
        $stat =  $this->db->query("SELECT id FROM driver WHERE status='3' AND no_telepon='$phone'");
        if ($stat->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone_edit($id, $phone)
    {
        $cek = $this->db->query("SELECT no_telepon FROM driver where no_telepon='$phone' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email_edit($id, $email)
    {
        $cek = $this->db->query("SELECT id FROM driver where email='$email' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_pelanggan($condition)
    {
        $this->db->select('driver.*, saldo.saldo,kendaraan.*');
        $this->db->from('driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k');
        $this->db->where($condition);
        $this->db->where('status', '1');

        return $this->db->get();
    }

    public function get_job()
    {
        $this->db->select('*');
        $this->db->from('driver_job');
        $this->db->where('status_job', '1');

        return $this->db->get()->result();
    }

    public function get_status_driver($condition)
    {
        $this->db->select('*');
        $this->db->from('config_driver');
        $this->db->where($condition);

        return $this->db->get();
    }

    public function edit_profile($data, $phone)
    {
        $this->db->where('no_telepon', $phone);
        $this->db->update('driver', $data);

        return true;
    }

    public function edit_status_login($phone)
    {
        $phonenumber = array('no_telepon' => $phone);
        $datadriver = $this->get_data_driver($phonenumber);
        $datas = array('status' => '4');
        $this->db->where('id_driver', $datadriver->row('id'));
        $this->db->update('config_driver', $datas);

        return true;
    }

    public function logout($dataEdit, $id)
    {
        $this->db->where('id_driver', $id);
        $logout = $this->db->update('config_driver', $dataEdit);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_kendaraan($data, $id)
    {
        $this->db->where('id_k', $id);
        $this->db->update('kendaraan', $data);

        return true;
    }

    function my_location($data_l)
    {
        if ($data_l['bearing'] != '0.0') {
            $data = array(
                'latitude' => $data_l['latitude'],
                'longitude' => $data_l['longitude'],
                'bearing' => $data_l['bearing']
            );
        } else {
            $data = array(
                'latitude' => $data_l['latitude'],
                'longitude' => $data_l['longitude']
            );
        }

        $this->db->where('id_driver', $data_l['id_driver']);
        $upd = $this->db->update('config_driver', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_driver($condition)
    {
        $this->db->select('driver.*, saldo.saldo');
        $this->db->from('driver');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->where($condition);

        return $this->db->get();
    }

    function change_status_driver($idD, $stat_order)
    {
        $params = array(
            'status' => $stat_order
        );
        $this->db->where('id_driver', $idD);
        $upd = $this->db->update('config_driver', $params);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_data_driver_sync($id)
    {
        $this->db->select(""
            . "driver.*,"
            . "kendaraan.*,"
            . "driver.foto as foto,"
            . "saldo,"
            . "config_driver.status as status_config");
        $this->db->from('driver');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k');
        $this->db->where('driver.id', $id);

        $dataCon = $this->db->get();

        return array(
            'data_driver' => $dataCon,
            'status_order' => $this->check_status_order($id)
        );
    }

    function check_status_order($idDriver)

    {

        $this->db->select(''

            . 'transaksi.*,'

            . 'transaksi_detail_send.*,'

            . 'history_transaksi.*,'

            . 'pelanggan.fullnama,'

            . 'pelanggan.no_telepon as telepon,'

            . 'pelanggan.token as reg_id_pelanggan');

        $this->db->join('transaksi', 'transaksi.id = history_transaksi.id_transaksi');

        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');

        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');

        $this->db->where("(history_transaksi.status = '2' OR history_transaksi.status = '3')", NULL, FALSE);

        $this->db->where('history_transaksi.id_driver', $idDriver);

        $this->db->order_by('history_transaksi.nomor', 'DESC');

        $check = $this->db->get('history_transaksi', 1, 0);

        return $check;
    }



    function edit_config($data, $id)

    {

        $this->db->where('id_driver', $id);

        $edit = $this->db->update('config_driver', $data);

        if ($this->db->affected_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }



    public function accept_request($cond)

    {

        $this->db->where('id_driver', 'D0');

        $this->db->where('id_transaksi', $cond['id_transaksi']);

        $this->db->where("(status = '1')", NULL, FALSE);

        $this->db->from('history_transaksi');

        $cek_once = $this->db->get();

        if ($cek_once->num_rows() > 0) {

            $data = array(

                'status' => '2',

                'id_driver' => $cond['id_driver']

            );

            $this->db->where('id_driver', 'D0');

            $this->db->where('id_transaksi', $cond['id_transaksi']);

            $edit = $this->db->update('history_transaksi', $data);



            if ($this->db->affected_rows() > 0) {

                $this->db->where('id', $cond['id_transaksi']);

                $update_trans = $this->db->update('transaksi', array('id_driver' => $cond['id_driver']));



                $datD = array(

                    'status' => '2'

                );

                $this->db->where(array('id_driver' => $cond['id_driver']));

                $updDriver = $this->db->update('config_driver', $datD);

                return array(

                    'status' => true,

                    'data' => []

                );
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        } else {

            return array(

                'status' => false,

                'data' => 'canceled'

            );
        }
    }



    public function start_request($cond)

    {
        $this->db->where($cond);

        $this->db->where('status', '2');

        $this->db->from('history_transaksi');

        $cek_once = $this->db->get();

        if ($cek_once->num_rows() > 0) {

            $data = array(

                'status' => '3',

                'id_driver' => $cond['id_driver']

            );

            $this->db->where($cond);

            $edit = $this->db->update('history_transaksi', $data);

            if ($this->db->affected_rows() > 0) {

                $datD = array(

                    'status' => '3'

                );

                $this->db->where(array('id_driver' => $cond['id_driver']));

                $updDriver = $this->db->update('config_driver', $datD);

                return array(

                    'status' => true,

                    'data' => []

                );
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        } else {

            $datD = array(

                'status' => '1'

            );

            $this->db->where(array('id_driver' => $cond['id_driver']));



            $updDriver = $this->db->update('config_driver', $datD);

            return array(

                'status' => false,

                'data' => 'canceled'

            );
        }
    }



    public function finish_request($cond, $condtr)

    {

        $this->db->where($condtr);

        $this->db->update('transaksi', array('waktu_selesai' => date('Y-m-d H:i:s')));





        if ($this->db->affected_rows() > 0) {

            $last_trans = $this->get_data_last_transaksi($condtr);



            $get_mitra = $this->get_trans_merchant($last_trans->row('id_transaksi'));

            $datapelanggan = $this->get_data_pelangganid($last_trans->row('id_pelanggan'));

            $datadriver = $this->get_data_driverid($cond['id_driver']);



            $data_cut = array(

                'id_driver' => $cond['id_driver'],

                'harga' => $last_trans->row('harga'),

                'biaya_akhir' => $last_trans->row('biaya_akhir'),

                'kredit_promo' => $last_trans->row('kredit_promo'),

                'id_transaksi' => $last_trans->row('id_transaksi'),

                'fitur' => $last_trans->row('fitur'),

                'order_fitur' => $last_trans->row('order_fitur'),

                'nama_driver' => $datadriver->row('nama_driver'),

                'pakai_wallet' => $last_trans->row('pakai_wallet')

            );

            $dataC = array(

                'id_pelanggan' => $last_trans->row('id_pelanggan'),

                'harga' => $last_trans->row('harga'),

                'biaya_akhir' => $last_trans->row('biaya_akhir'),

                'kredit_promo' => $last_trans->row('kredit_promo'),

                'id_transaksi' => $last_trans->row('id_transaksi'),

                'pakai_wallet' => $last_trans->row('pakai_wallet'),

                'order_fitur' => $last_trans->row('order_fitur'),

                'nama_pelanggan' => $datapelanggan->row('fullnama'),

                'fitur' => $last_trans->row('fitur')

            );

            if ($last_trans->row('home') == 4) {



                $data_cut_mitra = array(

                    'id_mitra' => $get_mitra->row('id_mitra'),

                    'harga' => $get_mitra->row('total_biaya'),

                    'biaya_akhir' => $last_trans->row('biaya_akhir'),

                    'kredit_promo' => $last_trans->row('kredit_promo'),

                    'id_transaksi' => $last_trans->row('id_transaksi'),

                    'fitur' => $last_trans->row('fitur'),

                    'order_fitur' => $last_trans->row('order_fitur'),

                    'nama_mitra' => $get_mitra->row('nama_mitra'),

                    'pakai_wallet' => $last_trans->row('pakai_wallet')

                );

                $this->cut_mitra_saldo_by_order($data_cut_mitra);

                $this->delete_chat($get_mitra->row('id_merchant'), $last_trans->row('id_pelanggan'));

                $this->delete_chat($get_mitra->row('id_merchant'), $cond['id_driver']);
            };



            $cutUser = $this->cut_user_saldo_by_order($dataC);

            $cutting = $this->cut_driver_saldo_by_order($data_cut);





            if ($cutting['status']) {

                $this->delete_chat($cond['id_driver'], $last_trans->row('id_pelanggan'));

                $data = array(

                    'status' => '4'

                );

                $this->db->where($cond);

                $this->db->update('history_transaksi', $data);

                $datD = array(

                    'status' => '1'

                );

                $this->db->where(array('id_driver' => $cond['id_driver']));

                $this->db->update('config_driver', $datD);

                return array(

                    'status' => true,

                    'data' => $last_trans->result(),

                    'idp' => $last_trans->row('id_pelanggan'),

                );
            } else {

                return array(

                    'status' => false,

                    'data' => 'false in cutting'

                );
            }
        } else {

            return array(

                'status' => false,

                'data' => 'abc'

            );
        }
    }



    public function get_data_pelangganid($id)

    {

        $this->db->select('pelanggan.*, saldo.saldo');

        $this->db->from('pelanggan');

        $this->db->join('saldo', 'pelanggan.id = saldo.id_user');

        $this->db->where('id', $id);

        return $this->db->get();
    }



    public function get_data_driverid($id)

    {

        $this->db->select('driver.*, saldo.saldo');

        $this->db->from('driver');

        $this->db->join('saldo', 'driver.id = saldo.id_user');

        $this->db->where('id', $id);

        return $this->db->get();
    }



    function cut_user_saldo_by_order($dataC)

    {



        $this->db->where('id_user', $dataC['id_pelanggan']);

        $saldo = $this->db->get('saldo')->row('saldo');



        if ($dataC['pakai_wallet'] == 1) {

            $data_ins = array(

                'id_user' => $dataC['id_pelanggan'],

                'jumlah' => $dataC['biaya_akhir'],

                'bank' => $dataC['fitur'],

                'nama_pemilik' => $dataC['nama_pelanggan'],

                'rekening' => 'wallet',

                'type' => 'Order-'

            );

            $ins_trans = $this->db->insert('wallet', $data_ins);

            if ($ins_trans) {

                $this->db->where('id_user', $dataC['id_pelanggan']);

                $upd = $this->db->update('saldo', array('saldo' => ($saldo - $dataC['biaya_akhir'])));
            } else {

                return false;
            }
        }
    }



    function cut_driver_saldo_by_order($data)

    {

        $this->db->select('komisi');

        $this->db->where('id_fitur', $data['order_fitur']);

        $persen = $this->db->get('fitur')->row('komisi');



        $this->db->where('id_user', $data['id_driver']);

        $saldo = $this->db->get('saldo')->row('saldo');

        if ($data['pakai_wallet'] == 1) {

            $kred = $data['harga'];

            $potongan = $kred * ($persen / 100);

            $hasil = $kred - $potongan;



            $data_ins = array(

                'id_user' => $data['id_driver'],

                'jumlah' => $hasil,

                'bank' => $data['fitur'],

                'nama_pemilik' => $data['nama_driver'],

                'rekening' => 'wallet',

                'type' => 'Order+'

            );

            $ins_trans = $this->db->insert('wallet', $data_ins);

            if ($ins_trans) {

                $this->db->where('id_user', $data['id_driver']);

                $upd = $this->db->update('saldo', array('saldo' => ($saldo + $hasil)));

                if ($this->db->affected_rows() > 0) {

                    return array(

                        'status' => true,

                        'data' => array('saldo' => ($saldo + $hasil))

                    );
                } else {

                    return array(

                        'status' => false,

                        'data' => 'fail in update'

                    );
                }
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        } else {

            $hasil = $data['harga'] * ($persen / 100);

            $data_ins = array(

                'id_user' => $data['id_driver'],

                'jumlah' => $hasil,

                'bank' => $data['fitur'],

                'nama_pemilik' => $data['nama_driver'],

                'rekening' => 'wallet',

                'type' => 'Order-'

            );

            $ins_trans = $this->db->insert('wallet', $data_ins);

            if ($ins_trans) {

                $this->db->where('id_user', $data['id_driver']);

                $upd = $this->db->update('saldo', array('saldo' => ($saldo - $hasil)));

                if ($this->db->affected_rows() > 0) {

                    return array(

                        'status' => true,

                        'data' => []

                    );
                } else {

                    return array(

                        'status' => false,

                        'data' => 'fail in update'

                    );
                }
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        }
    }



    function cut_mitra_saldo_by_order($data)

    {

        $this->db->select('komisi');

        $this->db->where('id_fitur', $data['order_fitur']);

        $persen = $this->db->get('fitur')->row('komisi');



        $this->db->where('id_user', $data['id_mitra']);

        $saldo = $this->db->get('saldo')->row('saldo');

        if ($data['pakai_wallet'] == 1) {

            $kred = $data['harga'];

            $potongan = $kred * ($persen / 100);

            $hasil = $kred - $potongan;



            $data_ins = array(

                'id_user' => $data['id_mitra'],

                'jumlah' => $hasil,

                'bank' => $data['fitur'],

                'nama_pemilik' => $data['nama_mitra'],

                'rekening' => 'wallet',

                'type' => 'Order+'

            );

            $ins_trans = $this->db->insert('wallet', $data_ins);

            if ($ins_trans) {

                $this->db->where('id_user', $data['id_mitra']);

                $upd = $this->db->update('saldo', array('saldo' => ($saldo + $hasil)));

                if ($this->db->affected_rows() > 0) {

                    return array(

                        'status' => true,

                        'data' => array('saldo' => ($saldo + $hasil))

                    );
                } else {

                    return array(

                        'status' => false,

                        'data' => 'fail in update'

                    );
                }
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        } else {

            $hasil = $data['harga'] * ($persen / 100);

            $data_ins = array(

                'id_user' => $data['id_mitra'],

                'jumlah' => $hasil,

                'bank' => $data['fitur'],

                'nama_pemilik' => $data['nama_mitra'],

                'rekening' => 'wallet',

                'type' => 'Order-'

            );

            $ins_trans = $this->db->insert('wallet', $data_ins);

            if ($ins_trans) {

                $this->db->where('id_user', $data['id_mitra']);

                $upd = $this->db->update('saldo', array('saldo' => ($saldo - $hasil)));

                if ($this->db->affected_rows() > 0) {

                    return array(

                        'status' => true,

                        'data' => []

                    );
                } else {

                    return array(

                        'status' => false,

                        'data' => 'fail in update'

                    );
                }
            } else {

                return array(

                    'status' => false,

                    'data' => []

                );
            }
        }
    }



    function get_data_last_transaksi($cond)
    {
        $this->db->select('id as id_transaksi,'
            . '(waktu_selesai - waktu_order) as lama,'
            . 'waktu_selesai,'
            . 'harga,'
            . 'biaya_akhir,'
            . 'kredit_promo,'
            . 'order_fitur,'
            . 'id_pelanggan,'
            . 'fitur.home, fitur.fitur,'
            . 'pakai_wallet');

        $this->db->from('transaksi');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where($cond);
        $cek = $this->db->get();

        return $cek;
    }

    function all_transaksi($iduser)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('transaksi.id_driver', $iduser);
        $this->db->where('history_transaksi.status != 1');
        $this->db->where('history_transaksi.status != 2');
        $this->db->where('history_transaksi.status != 3');
        $this->db->where('history_transaksi.status != 0');
        $this->db->order_by('transaksi.id', 'DESC');

        $trans = $this->db->get();

        return $trans;
    }

    function delete_chat($otherid, $userid)
    {
        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json"
        );

        $data3 = array();
        $url3 = firebaseDb . '/chat/' . $otherid . '-' . $userid . '/.json';
        $ch3 = curl_init($url3);

        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch3, CURLOPT_POSTFIELDS, json_encode($data3));
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);

        $return3 = curl_exec($ch3);
        $json_data3 = json_decode($return3, true);
        $data2 = array();

        $url2 = firebaseDb . '/chat/' . $userid . '-' . $otherid . '/.json';
        $ch2 = curl_init($url2);

        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($data2));
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

        $return2 = curl_exec($ch2);
        $json_data2 = json_decode($return2, true);

        $data1 = array();
        $url1 = firebaseDb . '/Inbox/' . $userid . '/' . $otherid . '/.json';
        $ch1 = curl_init($url1);

        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($data1));
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

        $return1 = curl_exec($ch1);
        $json_data1 = json_decode($return1, true);
        $data = array();

        $url = firebaseDb . '/Inbox/' . $otherid . '/' . $userid . '/.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $return = curl_exec($ch);
        $json_data = json_decode($return, true);
    }

    public function getAlldriver()
    {
        $this->db->select('config_driver.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('driver.*');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('wa_province', 'driver.provinsi_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'driver.regency_id = wa_regency.id', 'left');

        return  $this->db->get('driver')->result_array();
    }

    // public function getAlldriverbyagent()
    // {
    //     $regency = $this->session->userdata('regency');
    //     $this->db->select('config_driver.status as status_job');
    //     $this->db->select('driver_job.driver_job');
    //     $this->db->select('wa_province.name as province_name');
    //     $this->db->select('wa_regency.name as regency_name');
    //     $this->db->select('driver.*');
    //     $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
    //     $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
    //     $this->db->join('wa_province', 'driver.provinsi_id = wa_province.id', 'left');
    //     $this->db->join('wa_regency', 'driver.regency_id = wa_regency.id', 'left');

    //     return  $this->db->get_where('driver', ['regenct_id' => $regency])->result_array();
    // }

    public function getDriverByAgent()
    {
        $regency = $this->session->userdata('regency');
        $this->db->select('config_driver.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('wa_province.name as province_name');
        $this->db->select('wa_regency.name as regency_name');
        $this->db->select('driver.*');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('wa_province', 'driver.provinsi_id = wa_province.id', 'left');
        $this->db->join('wa_regency', 'driver.regency_id = wa_regency.id', 'left');

        return  $this->db->get_where('driver', ['regency_id' => $regency])->result_array();
    }

    public function getdriverbyid($id)
    {
        $this->db->select('kendaraan.*');
        $this->db->select('saldo.saldo');
        $this->db->select('config_driver.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('berkas_driver.*');
        $this->db->select('driver.*');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k', 'left');
        $this->db->join('saldo', 'driver.id = saldo.id_user', 'left');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('berkas_driver', 'driver.id = berkas_driver.id_driver', 'left');

        return  $this->db->get_where('driver', ['driver.id' => $id])->row_array();
    }

    public function countorder($id)
    {
        $this->db->select('id_driver');
        $query = $this->db->get_where('transaksi', ['id_driver' => $id])->result_array();
        return count($query);
    }

    public function wallet($id)
    {
        $this->db->order_by('wallet.id', 'DESC');
        return $this->db->get_where('wallet', ['id_user' => $id])->result_array();
    }

    public function transaksi($id)
    {
        $this->db->select('status_transaksi.*');
        $this->db->select('history_transaksi.*');
        $this->db->select('fitur.*');
        $this->db->select('transaksi.*');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->order_by('transaksi.id', 'DESC');
        $this->db->where('history_transaksi.status != 1');

        return $this->db->get_where('transaksi', ['transaksi.id_driver' => $id])->result_array();
    }

    public function ubahdataid($data)
    {
        $this->db->set('nama_driver', $data['nama_driver']);
        $this->db->set('email', $data['email']);
        $this->db->set('countrycode', $data['countrycode']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('no_telepon', $data['no_telepon']);
        $this->db->set('tempat_lahir', $data['tempat_lahir']);
        $this->db->set('tgl_lahir', $data['tgl_lahir']);
        $this->db->set('alamat_driver', $data['alamat_driver']);
        $this->db->where('id', $data['id']);
        $this->db->update('driver', $data);
    }

    public function ubahdatakendaraan($data, $data2)
    {
        $this->db->set('jenis', $data['jenis']);
        $this->db->set('merek', $data['merek']);
        $this->db->set('tipe', $data['tipe']);
        $this->db->set('nomor_kendaraan', $data['nomor_kendaraan']);
        $this->db->set('warna', $data['warna']);
        $this->db->where('id_k', $data['id_k']);
        $this->db->update('kendaraan', $data);
        $this->db->set('job', $data2['job']);
        $this->db->where('id', $data2['id']);
        $this->db->update('driver', $data2);
    }

    public function ubahdatafoto($data)
    {
        $this->db->set('foto', $data['foto']);
        $this->db->where('id', $data['id']);
        $this->db->update('driver', $data);
    }

    public function ubahdatapassword($data)
    {
        $this->db->set('password', $data['password']);
        $this->db->where('id', $data['id']);
        $this->db->update('driver', $data);
    }

    public function blockdriverbyid($id)
    {
        $this->db->set('status', 3);
        $this->db->where('id', $id);
        $this->db->update('driver');
        $this->db->set('status', 5);
        $this->db->where('id_driver', $id);
        $this->db->update('config_driver');
    }

    public function unblockdriverbyid($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('driver');
    }

    public function ubahdatacard($data, $data2)
    {
        $this->db->set('foto_ktp', $data['foto_ktp']);
        $this->db->set('foto_sim', $data['foto_sim']);
        $this->db->set('id_sim', $data['id_sim']);
        $this->db->where('id_driver', $data['id']);
        $this->db->update('berkas_driver');
        $this->db->set('no_ktp', $data2['no_ktp']);
        $this->db->where('id', $data2['id']);
        $this->db->update('driver');
    }

    public function driverjob()
    {
        return $this->db->get('driver_job')->result_array();
    }

    public function hapusdriverbyid($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('driver');

        $this->db->where('id_driver', $id);
        $this->db->delete('config_driver');

        $this->db->where('id_driver', $id);
        $this->db->delete('transaksi');

        $this->db->where('id_user', $id);
        $this->db->delete('saldo');

        $this->db->where('id_driver', $id);
        $this->db->delete('history_transaksi');

        $this->db->where('id_driver', $id);
        $this->db->delete('berkas_driver');

        $this->db->where('userid', $id);
        $this->db->delete('forgot_password');

        $this->db->where('id_driver', $id);
        $this->db->delete('rating_driver');

        $this->db->where('id_user', $id);
        $this->db->delete('wallet');
    }

    public function tambahdatadriver($datadriver)
    {
        $this->db->insert('driver');
    }

    public function ubahstatusnewreg($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('driver');
    }

    public function get_trans_merchant($idtransaksi)
    {
        $this->db->select('mitra.*,transaksi_detail_merchant.id_merchant,transaksi_detail_merchant.total_biaya');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('mitra', 'transaksi_detail_merchant.id_merchant = mitra.id_merchant');
        $this->db->where('id_transaksi', $idtransaksi);

        return $this->db->get();
    }

    public function get_verify($data)
    {
        $this->db->select('*');

        $this->db->from('transaksi_detail_merchant');

        $this->db->where($data);

        return $this->db->get();
    }

    public function driver_cancel_request($cond)
    {
        $this->db->select(''
            . 'id_driver,'
            . 'status');
        $this->db->from('history_transaksi');
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $id = $this->db->get();

        $this->db->select('transaksi.*, fitur.home');
        $this->db->from('transaksi');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('id', $cond['id_transaksi']);
        $id2 = $this->db->get();

        if ($id->row('status') == 1 || $id->row('status') == 2) {
            $data = array(
                'status' => '5'
            );
            if ($id2->row('home') == 4) {
                $get_mitra = $this->get_trans_merchant($cond['id_transaksi']);
                $this->delete_chat($get_mitra->row('id_merchant'), $id2->row('id_pelanggan'));
                $this->delete_chat($get_mitra->row('id_merchant'), $id2->row('id_driver'));
            };

            if ($id2->row('home') == 3) {
                $get_mitra = $this->get_trans_merchant($cond['id_transaksi']);
                $this->delete_chat($get_mitra->row('id_merchant'), $id2->row('id_pelanggan'));
                $this->delete_chat($get_mitra->row('id_merchant'), $id2->row('id_driver'));
            };

            $this->db->where($cond);
            $edit = $this->db->update('history_transaksi', $data);
            $data = array(
                'status' => '1'
            );

            $this->db->where('id_driver', $id->row('id_driver'));
            $edit = $this->db->update('config_driver', $data);

            return array(
                'status' => true,
                'data' => [],
                'iddriver' => $id->row('id_driver'),
                'idpelanggan' => $id2->row('id_pelanggan')
            );
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }


    public function check_minimum_wallet_job($cond)
    {
        $this->db->select('fitur, wallet_minimum');
        $this->db->from('fitur');
        $this->db->where('driver_job', $cond['driver_job']);
        $this->db->order_by('wallet_minimum', 'DESC');
        $trans = $this->db->get();

        return $trans;
    }
}
