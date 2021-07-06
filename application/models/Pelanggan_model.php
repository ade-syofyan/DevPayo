<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function count_user()
    {
        $this->db->select('count(id) as count');
        $this->db->from('pelanggan');
        return $this->db->get();
    }

    public function check_phone_number($number)
    {
        $cek = $this->db->query("SELECT id FROM pelanggan where phone='$number'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist($email, $phone)
    {
        $cek = $this->db->query("SELECT id FROM pelanggan where email = '$email' AND no_telepon='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone($phone)
    {
        $cek = $this->db->query("SELECT id FROM pelanggan where no_telepon='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone_edit($id, $phone)
    {
        $cek = $this->db->query("SELECT no_telepon FROM pelanggan where no_telepon='$phone' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email($email)
    {
        $cek = $this->db->query("SELECT id FROM pelanggan where email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email_edit($id, $email)
    {
        $cek = $this->db->query("SELECT id FROM pelanggan where email='$email' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($phone)
    {
        $stat =  $this->db->query("SELECT id FROM pelanggan WHERE status='3' AND no_telepon='$phone'");
        if ($stat->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function get_data_pelanggan($condition)
    {
        $this->db->select('pelanggan.*, saldo.saldo');
        $this->db->from('pelanggan');
        $this->db->join('saldo', 'pelanggan.id = saldo.id_user');
        $this->db->where($condition);
        return $this->db->get();
    }

    public function signup($data_signup)
    {
        $signup = $this->db->insert('pelanggan', $data_signup);
        $dataIns = array(
            'id_user' => $data_signup['id'],
            'saldo' => 0
        );
        $insSaldo = $this->db->insert('saldo', $dataIns);
        return $signup;
    }

    public function edit_profile($data, $email)
    {

        $this->db->where('no_telepon', $email);
        $this->db->update('pelanggan', $data);
        return true;
    }

    public function check_password($condition)
    {
        $this->db->select('id');
        $this->db->from('pelanggan');
        $this->db->where($condition);
        $cek = $this->db->get();
        if ($cek->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function emailsend($subject, $emailuser, $content, $host, $port, $username, $password, $from, $appname, $secure)
    {
        require APPPATH . '/libraries/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = $secure;
        $mail->Host = $host; //host masing2 provider email
        $mail->SMTPDebug = 0;
        $mail->Port = $port;
        $mail->SMTPAuth = true;
        $mail->Username = $username; //user email
        $mail->Password = $password; //password email 
        $mail->SetFrom($from, $appname); //set email pengirim
        $mail->Subject = $subject; //subyek email
        $mail->AddAddress($emailuser, "User");  //tujuan email
        $mail->MsgHTML($content); //pesan dapat berupa html
        $mail->Send();
        return true;
    }

    public function get_settings()
    {
        $this->db->select('*');
        $this->db->from('app_settings');
        $this->db->where('id', '1');
        return $this->db->get()->result_array();
    }

    public function dataforgot($forgotpass)
    {
        $forgot = $this->db->insert('forgot_password', $forgotpass);
        return $forgot;
    }

    public function sliderhome()
    {
        $this->db->select('*');
        $this->db->from('promosi');
        $this->db->join('fitur', 'promosi.fitur_promosi = fitur.id_fitur', 'left');
        $this->db->where('is_show', '1');
        $this->db->where('tanggal_berakhir>', date("Y-m-d"));
        return $this->db->get()->result_array();
    }

    public function fiturhome()
    {
        $this->db->select('*');
        $this->db->from('fitur');
        $this->db->where('active', '1');
        $this->db->order_by('id_fitur ASC');
        $this->db->limit('7');
        return $this->db->get()->result_array();
    }

    public function fiturhomeall()
    {
        $this->db->select('*');
        $this->db->from('fitur');
        $this->db->where('active', '1');
        $this->db->order_by('id_fitur ASC');
        return $this->db->get()->result_array();
    }

    public function beritahome()
    {
        $this->db->select('*');
        $this->db->from('berita');
        $this->db->join('kategori_news', 'berita.id_kategori = kategori_news.id_kategori_news', 'left');
        $this->db->order_by('id_berita DESC');
        $this->db->limit('4');
        $this->db->where('status_berita', 1);
        return $this->db->get()->result_array();
    }

    public function allberita()
    {
        $this->db->select('*');
        $this->db->from('berita');
        $this->db->join('kategori_news', 'berita.id_kategori = kategori_news.id_kategori_news', 'left');
        $this->db->order_by('id_berita DESC');
        $this->db->where('status_berita', 1);
        return $this->db->get()->result_array();
    }

    public function beritadetail($id)
    {
        $this->db->select('*');
        $this->db->from('berita');
        $this->db->join('kategori_news', 'berita.id_kategori = kategori_news.id_kategori_news', 'left');
        $this->db->where('id_berita', $id);
        $this->db->order_by('id_berita DESC');
        return $this->db->get();
    }

    public function ratinghome()
    {
        $this->db->select('rating_driver.*, pelanggan.*');
        $this->db->from('rating_driver');
        $this->db->where('rating_driver.rating != 0');
        $this->db->where('rating_driver.rating != 1');
        $this->db->where('rating_driver.rating != 2');
        $this->db->where('rating_driver.rating != 3');
        $this->db->join('pelanggan', 'rating_driver.id_pelanggan = pelanggan.id', 'left');
        $this->db->order_by('rating_driver.nomor DESC');
        $this->db->limit('3');
        return $this->db->get()->result_array();
    }

    public function saldouser($id)
    {
        $this->db->select('saldo');
        $this->db->from('saldo');
        $this->db->where('id_user', $id);
        $saldo = $this->db->get();
        return $saldo;
    }

    public function payusettings()
    {
        $this->db->select('*');
        $this->db->from('payusettings');
        $this->db->where('id', 1);
        $saldo = $this->db->get();
        return $saldo;
    }

    public function getwallet($id)
    {
        $this->db->select('*');
        $this->db->from('wallet');
        $this->db->where('id_user', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function tambahsaldo($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('saldo', $data);
        return true;
    }


    public function insertwallet($data_withdraw)
    {
        $verify = $this->db->insert('wallet', $data_withdraw);
        return true;
    }

    public function get_driver_ride($lat, $lng, $fitur)
    {
        $url_foto = base_url() . 'images/fotodriver/';

        $result = $this->db->query("
            SELECT f.jarak_minimum, f.wallet_minimum, d.id as id, d.nama_driver, ld.latitude, ld.longitude, ld.bearing, ld.update_at,
            k.merek, k.nomor_kendaraan, k.warna, k.tipe, s.saldo,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
            . " * cos(radians(ld.longitude) - radians($lng))"
            . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj, kendaraan k, saldo s,fitur f
            WHERE ld.id_driver = d.id 
                AND f.id_fitur = $fitur
                AND ld.status = '1'
                AND dj.id = d.job
                AND d.job = f.driver_job
                AND d.status = '1'
                AND k.id_k = d.kendaraan
                AND s.id_user = d.id
                AND s.saldo > f.wallet_minimum
            HAVING distance <= f.jarak_minimum
            ORDER BY distance ASC");
        return $result;
    }

    public function get_driver_car($lat, $lng, $fitur)
    {
        $range = 10;
        $url_foto = base_url() . 'images/fotodriver/';

        $result = $this->db->query("
            SELECT f.jarak_minimum, f.wallet_minimum, d.id as id, d.nama_driver, ld.latitude, ld.longitude, ld.bearing, ld.update_at,
            k.merek, k.nomor_kendaraan, k.warna, k.tipe, s.saldo,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
            . " * cos(radians(ld.longitude) - radians($lng))"
            . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj, kendaraan k, saldo s,fitur f
            WHERE ld.id_driver = d.id 
                AND f.id_fitur = $fitur
                AND ld.status = '1'
                AND dj.id = d.job
                AND d.job = '2'
                AND d.status = '1'
                AND k.id_k = d.kendaraan
                AND s.id_user = d.id
                AND s.saldo > 500
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $result;
    }

    function get_biaya()
    {
        $tempBiaya = array();
        $this->db->select('fitur.*,voucher.nilai, driver_job.icon as icon_driver');
        $this->db->from('fitur');
        $this->db->join('voucher', 'fitur.id_fitur = voucher.untuk_fitur', 'left');
        $this->db->join('driver_job', 'fitur.driver_job = driver_job.id', 'left');
        $biaya = $this->db->get()->result_array();
        foreach ($biaya as $row) {
            $tempBiaya[] = array(
                'id_fitur' => $row['id_fitur'],
                'fitur' => $row['fitur'],
                'biaya' => $row['biaya'],
                'icon' => $row['icon'],
                'home' => $row['home'],
                'maks_distance' => $row['maks_distance'],
                'icon_driver' => $row['icon_driver'],
                'biaya_minimum' => $row['biaya_minimum'],
                'keterangan_biaya' => $row['keterangan_biaya'],
                'keterangan' => $row['keterangan'],
                'diskon' => $row['nilai'] . "%",
                'biaya_akhir' => $row['nilai'] / 100
            );
        }

        return $tempBiaya;
    }


    public function insert_transaksi($data_req)
    {

        $ha = 0;
        $kreditamuont = explode(".", $data_req['kredit_promo']);
        $ha  = $data_req['harga'] - $kreditamuont[0];
        if ($ha <= 0) {
            $ha = 0;
        }
        $data_req['kredit_promo'] = $kreditamuont[0];
        $data_req['biaya_akhir'] = $ha;

        $this->db->insert('transaksi', $data_req);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => '1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            return array(
                'status' => true,
                'data' => $get_data->result()
            );
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }

    public function insert_transaksi_send($data_req, $dataDetail)
    {

        $ha = 0;
        $kreditamuont = explode(".", $data_req['kredit_promo']);
        $ha  = $data_req['harga'] - $kreditamuont[0];
        if ($ha <= 0) {
            $ha = 0;
        }
        $data_req['kredit_promo'] = $kreditamuont[0];
        $data_req['biaya_akhir'] = $ha;

        $ins_trans = $this->db->insert('transaksi', $data_req);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => '1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $dataDetail['id_transaksi'] = $reqid;
            $this->db->insert('transaksi_detail_send', $dataDetail);
            $get_data_msend = $this->get_data_transaksi_send($data_req);
            return array(
                'status' => true,
                'data' => $get_data_msend
            );
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }

    function get_data_transaksi_send($data_cond)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
        $this->db->where($data_cond);
        $cek = $this->db->get();
        return $cek;
    }

    function get_data_transaksi($cond)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
        $this->db->where($cond);
        $cek = $this->db->get();
        return $cek;
    }

    function get_data_transaksi_merchant($cond)
    {
        $this->db->select('transaksi.*,transaksi_detail_merchant.id_trans_merchant, merchant.token_merchant');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
        $this->db->join('merchant', 'transaksi_detail_merchant.id_merchant = merchant.id_merchant', 'left');
        $this->db->where($cond);
        $cek = $this->db->get();
        return $cek;
    }

    function check_status($dataTrans)
    {
        $this->db->select(''
            . 'status_transaksi.id as status,'
            . 'status_transaksi.status_transaksi as keterangan');
        $this->db->from('history_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where($dataTrans);
        $cek = $this->db->get();

        $stat = TRUE;
        if ($cek->row('status') == 1) {
            $this->delete_transaksi($dataTrans['id_transaksi']);
            $stat = FALSE;
        }
        $dataCheck = array(
            'message' => 'check status',
            'status' => $stat,
            'data' => $cek->result(),
            'list_driver' => $this->get_data_driver_histroy($dataTrans['id_transaksi'])->result()
        );

        return $dataCheck;
    }

    function check_banned_user($email)
    {
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('email', $email);
        $this->db->where("(status = '2' OR status = '3')", NULL, FALSE);
        //        $this->db->where('status', '3');
        $cek = $this->db->get();
        if ($cek->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function listbank()
    {
        $this->db->select('*');
        $this->db->from('list_bank');
        $this->db->where('status_bank', "1");
        return $this->db->get();
    }

    function get_data_driver_histroy($id_transaksi)
    {
        $url_foto = base_url() . 'images/fotodriver/';

        $this->db->select(''
            . 'driver.id,'
            . 'nama_driver,'
            . 'no_telepon,'
            . 'cd.latitude,'
            . 'cd.longitude,'
            . 'cd.update_at,'
            . "CONCAT('$url_foto', driver.foto, '') as foto,"
            . 'reg_id,'
            . '"0" as distance,'
            . 'k.id_k as id_kendaraan,'
            . 'k.merek,'
            . 'k.tipe,'
            . 'k.jenis,'
            . 'k.nomor_kendaraan,'
            . 'k.warna');
        $this->db->from('driver');
        $this->db->join('history_transaksi', 'driver.id = history_transaksi.id_driver');
        $this->db->join('config_driver cd', 'driver.id = cd.id_driver');
        $this->db->join('kendaraan k', 'driver.kendaraan = k.id_k');
        $this->db->where('history_transaksi.id_transaksi', $id_transaksi);
        $getD = $this->db->get();
        return $getD;
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

    public function get_trans_merchant($idtransaksi)
    {
        $this->db->select('mitra.*,transaksi_detail_merchant.id_merchant,transaksi_detail_merchant.total_biaya');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('mitra', 'transaksi_detail_merchant.id_merchant = mitra.id_merchant');
        $this->db->where('id_transaksi', $idtransaksi);
        return $this->db->get();
    }

    public function user_cancel_request($cond)
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

    public function user_expired_request($cond)
    {

        $this->db->select(''
            . 'id_driver, '
            . 'status');
        $this->db->from('history_transaksi');
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $id = $this->db->get();

        if ($id->row('status') == 1 || $id->row('status') == 2) {
            $data = array(
                'status' => '0'
            );
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
                'idpelanggan' => $id->row('id_pelanggan')
            );
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }

    function detail_transaksi($idtrans)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('id', $idtrans);
        $loc = $this->db->get();
        return $loc;
    }

    function detail_driver($iddriver)
    {
        $this->db->select('*');
        $this->db->from('driver');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k', 'left');
        $this->db->where('id', $iddriver);
        $loc = $this->db->get();
        return $loc;
    }

    function get_driver_location($idDriver)
    {
        $this->db->select(''
            . 'id_driver,'
            . 'latitude,'
            . 'longitude');
        $this->db->from('config_driver');
        $this->db->where('id_driver', $idDriver);
        $loc = $this->db->get();
        return $loc;
    }

    function get_driver_location_admin()
    {
        $this->db->select(''
            . 'config_driver.id_driver,'
            . 'config_driver.latitude,'
            . 'config_driver.longitude,'
            . 'config_driver.status,'
            . 'driver.nama_driver');
        $this->db->from('config_driver');
        $this->db->join('driver', 'config_driver.id_driver = driver.id', 'left');
        $this->db->where('driver.status != 0');
        $this->db->where('driver.status != 3');
        $loc = $this->db->get();
        return $loc;
    }

    function rate_driver($data)
    {
        $ins_rate = $this->db->insert('rating_driver', $data);
        if ($this->db->affected_rows() == 1) {
            $get_rating = $this->count_rate_driver($data['id_driver']);

            $this->db->where('id', $data['id_transaksi']);
            $upd_trans = $this->db->update('transaksi', array('rate' => $data['rating']));

            $this->db->where('id', $data['id_driver']);
            $upd_driver = $this->db->update('driver', array('rating' => $get_rating));
            return true;
        } else {
            return false;
        }
    }

    function count_rate_driver($id)
    {
        $this->db->select('rating');
        $this->db->from('rating_driver');
        $this->db->where('id_driver', $id);
        $cek = $this->db->get();
        $rate = 0;
        $hasil = 0;
        if ($cek->num_rows() > 0) {
            foreach ($cek->result() as $row) {
                $rate += $row->rating;
            }
            $hasil = $rate / $cek->num_rows();
        }
        return $hasil;
    }

    function diskon_wallet()
    {
        $this->db->select('*');
        $this->db->from('voucher');
        $this->db->where("voucher LIKE 'DISKON%'");
        $this->db->order_by('id', 'asc');
        $disk = $this->db->get();

        $arrDisk = array();

        foreach ($disk->result() as $row) {
            $diskmpay = array(
                'fitur' => $row->untuk_fitur,
                'diskon' => $row->nilai . "%",
                'biaya_akhir' => (100 - $row->nilai) / 100
            );
            array_push($arrDisk, $diskmpay);
        }
        return $disk;
    }

    function promo_code()
    {
        $this->db->select('*');
        $this->db->from('kodepromo');
        $this->db->where("status", 1);
        $this->db->where('expired >', date("Y-m-d"));
        $this->db->order_by('id_promo', 'DESC');
        return $this->db->get();
    }

    function promo_code_use($code, $fitur)
    {
        $this->db->select('*');
        $this->db->from('kodepromo');
        $this->db->where('kode_promo', $code);
        $this->db->where("fitur", $fitur);
        $this->db->where("status", 1);
        $this->db->where('expired >', date("Y-m-d"));
        $diskon = $this->db->get();

        if ($diskon->num_rows() > 0) {
            $out = [
                'nominal' => $diskon->row('nominal_promo'),
                'type' => $diskon->row('type_promo')
            ];
            return $out;
        } else {
            return false;
        }
    }

    function transaksi($idtran)
    {
        $this->db->select('*');
        $this->db->from('transaksi');

        $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->join('merchant', 'transaksi_detail_merchant.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
        $this->db->where('transaksi.id', $idtran);

        $trans = $this->db->get();
        return $trans;
    }

    function all_transaksi($iduser)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('transaksi.id_pelanggan', $iduser);
        $this->db->where('history_transaksi.status != 1');
        $this->db->where('history_transaksi.status != 0');
        $this->db->order_by('transaksi.id', 'DESC');
        $trans = $this->db->get();
        return $trans;
    }

    public function getAlltransaksipickup()
    {
        $this->db->select('transaksi.*,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.icon,' . 'fitur.fitur');
        $this->db->from('transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('history_transaksi.status = 2');
        $this->db->order_by('transaksi.id', 'DESC');
        $this->db->limit('10');
        return $this->db->get();
    }

    public function getAlltransaksidestination()
    {
        $this->db->select('transaksi.*,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.icon,' . 'fitur.fitur');
        $this->db->from('transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('history_transaksi.status = 3');
        $this->db->order_by('transaksi.id', 'DESC');
        $this->db->limit('10');
        return $this->db->get();
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    function template1($subject, $text1, $text2, $web, $appname, $linkbtn, $linkgoogle, $address)
    {
        $msg = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="width=device-width" name="viewport">
<!--[if !mso]><!-->
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<!--<![endif]-->
<style type="text/css">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id="media-query" type="text/css">
		@media (max-width: 610px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;">

<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;" valign="top" width="100%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td style="word-break: break-word; vertical-align: top;" valign="top">


<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:590px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="590" style="background-color:transparent;width:590px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;">
<div style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
<p style="font-size: 26px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 31px; margin: 0;"><span style="font-size: 26px;"><strong>' . $subject . '</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:590px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="590" style="background-color:transparent;width:590px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px;" valign="top">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 5px solid #6DC0FF; width: 50%;" valign="top" width="50%">
<tbody>
<tr style="vertical-align: top;" valign="top">
<td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">


<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">

<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">


<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;">

<div style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: justify; mso-line-height-alt: 17px; margin: 0;">' . $text1 . '</p>
</div><div style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">

</div>
<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:590px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="590" style="background-color:transparent;width:590px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
<div align="center" class="button-container" style="padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="" style="height:31.5pt; width:192pt; v-text-anchor:middle;" arcsize="10%" stroke="false" fillcolor="#6dc0ff"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px"><![endif]-->
<a href="' . $linkbtn . '" rel="noopener" style="color: #ffffff" target="_blank"><div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#6dc0ff;border-radius:4px;-webkit-border-radius:4px;-moz-border-radius:4px;width:auto; width:auto;;border-top:1px solid #6dc0ff;border-right:1px solid #6dc0ff;border-bottom:1px solid #6dc0ff;border-left:1px solid #6dc0ff;padding-top:5px;padding-bottom:5px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;"><span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><strong> Reset Password </strong></span></span></div></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
</div>


</div>

</div>
</div>


</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:590px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="590" style="background-color:transparent;width:590px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">
<!--[if (!mso)&(!IE)]><!-->
<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
<!--<![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>

<div style="background-color:transparent;">
<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">


<div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;">
<div style="width:100% !important;">

<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">


<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;">
<div style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;">' . $text2 . ' .</p>
</div>
</div>


</div>

</div>
</div>


</div>
</div>
</div>
<div style="background-color:transparent;">
<div class="block-grid two-up" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">


<div class="col num6" style="max-width: 320px; min-width: 295px; display: table-cell; vertical-align: top; width: 295px;">
<div style="width:100% !important;">

<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">


<div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;">
<div style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
<p style="line-height: 1.2; word-break: break-word; mso-line-height-alt: NaNpx; margin: 0;">' . $address . '</p>
</div>
</div>





</div>

</div>
</div>


<div class="col num6" style="max-width: 320px; min-width: 295px; display: table-cell; vertical-align: top; width: 295px;">
<div style="width:100% !important;">

<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

<div align="center" class="img-container center fixedwidth" style="padding-right: 10px;padding-left: 10px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 10px;padding-left: 10px;" align="center"><![endif]--><a href="' . $linkgoogle . '"><img align="center" alt="Image" border="0" class="center fixedwidth" src="http://Maswend.com/fileenvato/googleplay.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 206px; display: block;" title="Image" width="206" data-iml="5150976.220000001"></a><a>
<!--[if mso]></td></tr></table><![endif]-->
</a></div></div><a>
<!--<![endif]-->
</a></div><a>
</a></div><a>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</a></div><a>
</a></div><a>
</a></div><a>
</a><div style="background-color:transparent;"><a>
</a><div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 590px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;"><a>
</a><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><a>
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:590px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="590" style="background-color:transparent;width:590px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
</a><div class="col num12" style="min-width: 320px; max-width: 590px; display: table-cell; vertical-align: top; width: 590px;"><a>
</a><div style="width:100% !important;"><a>
<!--[if (!mso)&(!IE)]><!-->
</a><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><a>
<!--<![endif]-->
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
</a><div style="color:#999999;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;"><a>
</a><div style="font-size: 14px; line-height: 1.2; color: #999999; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;"><a>
</a><p style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;"><a>Copyright Â© 2020 </a><a href="' . $web . '" rel="noopener" style="text-decoration: underline; color: #6dc0ff;" target="_blank">' . $appname . '</a>. All Rights Reserved</p>
</div><a>
</a></div><a>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</a></div><a>
<!--<![endif]-->
</a></div><a>
</a></div><a>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</a></div><a>
</a></div><a>
</a></div><a>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</a></td>
</tr>
</tbody>
</table>



</body></html>';
        return $msg;
    }

    public function kategorymerchant()
    {
        $this->db->select('category_merchant.*');
        $this->db->where('category_merchant.status_kategori = 1');
        $this->db->where('fitur.active = 1');
        $this->db->or_where('category_merchant.id_fitur = 0');

        $this->db->join('fitur', 'category_merchant.id_fitur = fitur.id_fitur', 'left');
        return $this->db->get('category_merchant');
    }

    public function merchantnearby($long, $lat)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant, saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND status_item = 1  ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");

        $this->db->from('merchant');
        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');
        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur');
        $this->db->join('mitra', 'merchant.id_merchant = mitra.id_merchant');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user');

        $this->db->limit('4');
        $query =  $this->db->get();

        $data = [];


        foreach ($query->result_array() as $q) {

            if ($q['status_promo'] == NULL) {
                $status = 0;
            } else {
                $status = $q['status_promo'];
            }
            $data[] = [
                'id_merchant'               => $q['id_merchant'],
                'nama_merchant'             => $q['nama_merchant'],
                'alamat_merchant'           => $q['alamat_merchant'],
                'latitude_merchant'         => $q['latitude_merchant'],
                'longitude_merchant'        => $q['longitude_merchant'],
                'jam_buka'                  => $q['jam_buka'],
                'jam_tutup'                 => $q['jam_tutup'],
                'deskripsi_merchant'        => $q['deskripsi_merchant'],
                'category_merchant'         => $q['category_merchant'],
                'foto_merchant'             => $q['foto_merchant'],
                'telepon_merchant'          => $q['telepon_merchant'],
                'status_merchant'           => $q['status_merchant'],
                'open_merchant'             => $q['open_merchant'],
                'saldo'                     => $q['saldo'],
                'distance'                  => $q['distance'],
                'status_promo'              => $status
            ];
        }

        return $data;
    }

    public function merchantpromo($long, $lat)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant,saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item WHERE merchant.id_merchant = item.id_merchant AND item.status_promo = 1 AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");

        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');


        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur');
        $this->db->join('mitra', 'merchant.id_merchant = mitra.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');

        $this->db->limit('4');
        return $this->db->get('merchant');
    }

    public function merchantbykategori($kategori, $long, $lat)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant,saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");
        $this->db->select('category_merchant.nama_kategori');


        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');
        if ($kategori != '1') {
            $this->db->where("merchant.category_merchant = $kategori");
        }

        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');

        $this->db->limit('4');
        return $this->db->get('merchant');
    }

    public function merchantbykategoripromo($kategori, $long, $lat)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant,saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND item.status_promo = 1 AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");
        $this->db->select('category_merchant.nama_kategori');


        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');
        if ($kategori != '1') {
            $this->db->where("merchant.category_merchant = $kategori");
        }

        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');

        $this->db->limit('4');
        return $this->db->get('merchant');
    }

    public function allmerchantnearby($long, $lat, $fitur)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant,saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");
        $this->db->select('category_merchant.nama_kategori');


        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where("merchant.id_fitur = $fitur");
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');

        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');


        return $this->db->get('merchant');
    }

    public function allmerchantnearbybykategori($long, $lat, $fitur, $kategori)
    {
        $this->db->select("merchant.id_merchant , merchant.nama_merchant , merchant.alamat_merchant , merchant.latitude_merchant , merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , merchant.category_merchant , merchant.foto_merchant , merchant.telepon_merchant , merchant.status_merchant , merchant.open_merchant,saldo.saldo,
            (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * sin( radians(merchant.latitude_merchant)))) AS distance
            ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");
        $this->db->select('category_merchant.nama_kategori');


        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where("merchant.id_fitur = $fitur");

        $this->db->where('saldo.saldo >= fitur.wallet_minimum');
        if ($kategori != '1') {
            $this->db->where("merchant.category_merchant = $kategori");
        }

        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');
        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');


        return $this->db->get('merchant');
    }


    public function kategorymerchantbyfitur($fitur)
    {

        $this->db->where("id_fitur = $fitur OR id_fitur = 0");
        $this->db->where('status_kategori = 1');
        return $this->db->get('category_merchant');
    }

    public function searchmerchantnearby($like, $long, $lat, $fitur)
    {
        $this->db->select("merchant.id_merchant ,
         merchant.nama_merchant , 
         merchant.alamat_merchant , 
         merchant.latitude_merchant , 
         merchant.longitude_merchant , 
         merchant.jam_buka , merchant.jam_tutup ,
        merchant.deskripsi_merchant , merchant.category_merchant , 
        merchant.foto_merchant , merchant.telepon_merchant , 
        merchant.status_merchant , merchant.open_merchant,
        saldo.saldo,
        fitur.fitur,
        category_merchant.nama_kategori,
        merchant.id_fitur,
        (6371 * acos(cos(radians($lat)) * cos(radians(merchant.latitude_merchant)) * 
        cos(radians(merchant.longitude_merchant) - radians( $long)) + sin(radians($lat)) * 
        sin( radians(merchant.latitude_merchant)))) AS distance
        ,(SELECT item.status_promo FROM item where merchant.id_merchant = item.id_merchant AND status_item = 1 ORDER BY status_promo DESC LIMIT 1) AS status_promo, fitur.jarak_minimum, fitur.wallet_minimum");

        $this->db->from('merchant');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');

        $this->db->where("
        saldo.saldo >= fitur.wallet_minimum AND merchant.id_fitur = $fitur
        ");
        $this->db->where('mitra.status_mitra = 1');
        $this->db->where('merchant.status_merchant = 1');

        $this->db->group_start();
        $this->db->like('merchant.nama_merchant', $like);
        $this->db->or_like('merchant.alamat_merchant', $like);


        $this->db->group_end();

        $this->db->having("status_promo is not null");
        $this->db->having("distance <= fitur.jarak_minimum");
        $this->db->order_by('distance ASC');

        $query =  $this->db->get();

        $data = [];


        foreach ($query->result_array() as $q) {

            if ($q['status_promo'] == NULL) {
                $status = 0;
            } else {
                $status = $q['status_promo'];
            }
            $data[] = [
                'id_merchant'               => $q['id_merchant'],
                'nama_merchant'             => $q['nama_merchant'],
                'alamat_merchant'           => $q['alamat_merchant'],
                'latitude_merchant'         => $q['latitude_merchant'],
                'longitude_merchant'        => $q['longitude_merchant'],
                'jam_buka'                  => $q['jam_buka'],
                'jam_tutup'                 => $q['jam_tutup'],
                'deskripsi_merchant'        => $q['deskripsi_merchant'],
                'category_merchant'         => $q['category_merchant'],
                'foto_merchant'             => $q['foto_merchant'],
                'telepon_merchant'          => $q['telepon_merchant'],
                'status_merchant'           => $q['status_merchant'],
                'open_merchant'             => $q['open_merchant'],
                'saldo'                     => $q['saldo'],
                'distance'                  => $q['distance'],
                'status_promo'              => $status
            ];
        }

        return $data;
    }

    public function merchantbyid($idmerchant, $long, $lat)
    {

        $this->db->select("
            merchant.id_merchant , 
            merchant.id_fitur ,
            merchant.nama_merchant , 
            merchant.alamat_merchant , merchant.latitude_merchant , 
            merchant.longitude_merchant , merchant.jam_buka , merchant.jam_tutup ,
            merchant.deskripsi_merchant , 
            merchant.category_merchant , 
            merchant.foto_merchant , 
            merchant.telepon_merchant , 
            merchant.status_merchant , 
            merchant.open_merchant,
            (6371 * acos(cos(radians($lat)) * 
            cos(radians(merchant.latitude_merchant)) * 
            cos(radians(merchant.longitude_merchant) - 
            radians( $long)) + 
            sin(radians($lat)) * 
            sin( radians(merchant.latitude_merchant)))) AS distance
        ");
        $this->db->select('
            item.status_promo,
            item.nama_item,
            item.harga_item,
            item.harga_promo,
            item.kategori_item,
            item.deskripsi_item');


        $this->db->select('mitra.partner');
        $this->db->select('category_merchant.nama_kategori');
        $this->db->select('fitur.fitur, fitur.jarak_minimum, fitur.wallet_minimum');
        $this->db->select('saldo.saldo');
        $this->db->where("merchant.id_merchant = $idmerchant");
        $this->db->where('merchant.status_merchant = 1');
        $this->db->where('saldo.saldo >= fitur.wallet_minimum');

        $this->db->join('fitur', 'merchant.id_fitur = fitur.id_fitur', 'left');
        $this->db->join('mitra', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->join('saldo', 'mitra.id_mitra = saldo.id_user', 'left');
        $this->db->join('category_merchant', 'merchant.category_merchant = category_merchant.id_kategori_merchant', 'left');
        $this->db->join('item', 'merchant.id_merchant = item.id_merchant', 'left');

        $this->db->order_by('merchant.id_merchant');

        return $this->db->get('merchant');
    }

    public function itemstatus($idmerchant)
    {
        $this->db->select('item.status_promo');
        $this->db->where("item.status_item = 1");
        $this->db->where("item.status_promo = 1");
        $this->db->where("item.id_merchant = $idmerchant");
        return $this->db->get('item');
    }

    public function itembyid($idmerchant)
    {
        $this->db->select('item.*');
        $this->db->select('
            category_item.nama_kategori_item,
            category_item.foto_kategori_item');

        $this->db->where("item.status_item = 1");
        $this->db->where("item.id_merchant = $idmerchant");

        $this->db->join('category_item', 'item.kategori_item = category_item.id_kategori_item', 'left');
        $this->db->where("category_item.status_kategori = 1");

        return $this->db->get('item');
    }

    public function kategoriitem($idmerchant)
    {

        $this->db->select("nama_kategori_item,id_kategori_item");
        $this->db->where("status_kategori = 1");
        $this->db->where("id_merchant = $idmerchant");
        $this->db->or_where('all_category = 1');
        return $this->db->get('category_item');
    }


    public function itembykategori($idmerchant, $itemk)
    {
        $this->db->select("item.*");
        $this->db->select('
            category_item.nama_kategori_item,
            category_item.foto_kategori_item');

        $this->db->where("item.status_item = 1");
        $this->db->where("item.id_merchant = $idmerchant");

        if ($itemk != '1') {
            $this->db->where("id_kategori_item = $itemk");
        }
        $this->db->join('category_item', 'item.kategori_item = category_item.id_kategori_item', 'left');
        $this->db->where("category_item.status_kategori = 1");
        return $this->db->get('item');
    }

    public function insert_data_transaksi_merchant($data_transaksi, $dataDetail, $total_belanja)
    {

        $biaya_akhir = ($data_transaksi['harga'] + $total_belanja['total_belanja']) - $data_transaksi['kredit_promo'];

        $transaksi = [
            'id_pelanggan'      => $data_transaksi['id_pelanggan'],
            'order_fitur'       => $data_transaksi['order_fitur'],
            'start_latitude'    => $data_transaksi['start_latitude'],
            'start_longitude'   => $data_transaksi['start_longitude'],
            'end_latitude'      => $data_transaksi['end_latitude'],
            'end_longitude'     => $data_transaksi['end_longitude'],
            'jarak'             => $data_transaksi['jarak'],
            'harga'             => $data_transaksi['harga'],
            'waktu_order'       => $data_transaksi['waktu_order'],
            'estimasi_time'     => $data_transaksi['estimasi_time'],
            'alamat_asal'       => $data_transaksi['alamat_asal'],
            'alamat_tujuan'     => $data_transaksi['alamat_tujuan'],
            'kredit_promo'      => $data_transaksi['kredit_promo'],
            'pakai_wallet'      => $data_transaksi['pakai_wallet'],
            'biaya_akhir'      => $biaya_akhir,
        ];

        $this->db->insert('transaksi', $transaksi);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {

            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => '1'
            );
            $this->db->insert('history_transaksi', $data_hist);

            $dataDetail['id_transaksi'] = $reqid;
            $this->db->insert('transaksi_detail_merchant', $dataDetail);

            $get_data = $this->get_data_transaksi_merchant($data_transaksi);
            return array(
                'status'        => true,
                'id_transaksi'  => $reqid,
                'data' => $get_data->result(),

            );
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }

    public function diskon_by_fitur($fitur)
    {
        $this->db->select('nilai');
        $this->db->from('voucher');
        $this->db->where("untuk_fitur = $fitur");
        $this->db->order_by('id', 'asc');
        return $this->db->get();
    }

    public function insert_data_item($item)
    {
        foreach ($item as $it) {
            $this->db->insert('transaksi_item', $it);
        }


        if ($this->db->affected_rows() == 1) {
            return array(
                'status'        => true,

            );
        } else {
            return array(
                'status' => false
            );
        }
    }

    public function detail_item($id)
    {
        $this->db->select('transaksi_item.jumlah_item,item.nama_item, transaksi_item.catatan_item, transaksi_item.total_harga');
        $this->db->from('transaksi_item');
        $this->db->join('item', 'transaksi_item.id_item = item.id_item');
        $this->db->where('id_transaksi', $id);
        return $this->db->get();
    }

    public function delete_transaksi($id)
    {
        $data = [
            'status' => '0'
        ];

        $this->db->where('id_transaksi', $id);
        $this->db->update('history_transaksi', $data);
        return true;
    }
}
