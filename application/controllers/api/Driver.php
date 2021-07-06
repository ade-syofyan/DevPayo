<?php

//'tes' => number_format(200 / 100, 2, ",", "."),

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Driver extends REST_Controller

{



    public function __construct()

    {

        parent::__construct();

        

        $this->load->helper("url");

        $this->load->database();

        $this->load->model('Driver_model');

        $this->load->model('Pelanggan_model');

        date_default_timezone_set('Asia/Jakarta');

    }



    function index_get()

    {

        $this->response("Api for Jasaku!", 200);

    }



    function privacy_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $app_settings = $this->Pelanggan_model->get_settings();



        $message = array(

            'code' => '200',

            'message' => 'found',

            'data' => $app_settings

        );

        $this->response($message, 200);

    }



    function job_post()

    {



        $job = $this->Driver_model->get_job();



        $message = array(

            'code' => '200',

            'message' => 'found',

            'data' => $job

        );

        $this->response($message, 200);

    }



    function login_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $reg_id = array(

            'reg_id' => $decoded_data->token

        );



        $condition = array(

            'password' => sha1($decoded_data->password),

            'no_telepon' => $decoded_data->no_telepon,

            //'token' => $decoded_data->token

        );

        $check_banned = $this->Driver_model->check_banned($decoded_data->no_telepon);

        if ($check_banned) {

            $message = array(

                'message' => 'banned',

                'data' => []

            );

            $this->response($message, 200);

        } else {

            $cek_login = $this->Driver_model->get_data_pelanggan($condition);

            $message = array();



            if ($cek_login->num_rows() > 0) {

                $upd_regid = $this->Driver_model->edit_profile($reg_id, $decoded_data->no_telepon);

                $get_pelanggan = $this->Driver_model->get_data_pelanggan($condition);

                $this->Driver_model->edit_status_login($decoded_data->no_telepon);

                $message = array(

                    'code' => '200',

                    'message' => 'found',

                    'data' => $get_pelanggan->result()

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'code' => '404',

                    'message' => 'wrong phone or password',

                    'data' => []

                );

                $this->response($message, 200);

            }

        }

    }



    function update_location_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }

        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $data = array(

            'latitude' => $decoded_data->latitude,

            'longitude' => $decoded_data->longitude,

            'bearing' => $decoded_data->bearing,

            'id_driver' => $decoded_data->id_driver

        );

        $ins = $this->Driver_model->my_location($data);



        if ($ins) {

            $message = array(

                'message' => 'location updated',

                'data' => []

            );

            $this->response($message, 200);

        }

    }



    function home_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }

        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);

        $saldo = $this->Pelanggan_model->saldouser($dec_data->id);

        $app_settings = $this->Pelanggan_model->get_settings();

        $condition = array(

            'no_telepon' => $dec_data->no_telepon

        );

        $cek_login = $this->Driver_model->get_data_driver($condition);



        foreach ($app_settings as $item) {

            if ($cek_login->num_rows() > 0) {

                $message = array(

                    'code' => '200',

                    'message' => 'success',

                    'saldo' => $saldo->row('saldo'),

                    'currency' => $item['app_currency'],

                    'currency_text' => $item['app_currency_text'],

                    'app_aboutus' => $item['app_aboutus'],

                    'app_contact' => $item['app_contact'],

                    'app_website' => $item['app_website'],

                    'stripe_active' => $item['stripe_active'],

                    'paypal_key' => $item['paypal_key'],

                    'paypal_mode' => $item['paypal_mode'],

                    'paypal_active' => $item['paypal_active'],

                    'app_email' => $item['app_email']





                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'code' => '201',

                    'message' => 'failed',

                    'data' => []

                );

                $this->response($message, 201);

            }

        }

    }



    function logout_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $dataEdit = array(

            'status' => 5

        );



        $logout = $this->Driver_model->logout($dataEdit, $decoded_data->id);

        if ($logout) {

            $message = array(

                'message' => 'success',

                'data' => ''

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'message' => 'fail',

                'data' => ''

            );

            $this->response($message, 200);

        }

    }



    function syncronizing_account_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);

        $saldo = $this->Pelanggan_model->saldouser($dec_data->id);

        $app_settings = $this->Pelanggan_model->get_settings();

        $getDataDriver = $this->Driver_model->get_data_driver_sync($dec_data->id);

        $condition = array(

            'no_telepon' => $dec_data->no_telepon

        );

        $cek_login = $this->Driver_model->get_data_pelanggan($condition);

        foreach ($app_settings as $item) {

            if ($cek_login->num_rows() > 0) {

                $payu = $this->Pelanggan_model->payusettings()->result();

                if ($getDataDriver['status_order']->num_rows() > 0) {

                    $stat = 0;

                    if ($getDataDriver['status_order']->row('status') == 3) {

                        $stat = 3;

                    } else if ($getDataDriver['status_order']->row('status') == 2) {

                        $stat = 2;

                    } else {

                        $stat = 1;

                    }



                    $getTrans = $this->Driver_model->change_status_driver($dec_data->id, $stat);

                    $message = array(

                        'message' => 'success',

                        'driver_status' => $stat,

                        'data_driver' => $getDataDriver['data_driver']->result(),

                        'data_transaksi' => $getDataDriver['status_order']->result(),

                        'saldo' => $saldo->row('saldo'),

                        'currency' => $item['app_currency'],

                        'currency_text' => $item['app_currency_text'],

                        'app_aboutus' => $item['app_aboutus'],

                        'app_contact' => $item['app_contact'],

                        'app_website' => $item['app_website'],

                        'stripe_active' => $item['stripe_active'],

                        'paypal_key' => $item['paypal_key'],

                        'paypal_mode' => $item['paypal_mode'],

                        'paypal_active' => $item['paypal_active'],

                        'app_email' => $item['app_email'],

                        'payu' => $payu

                    );

                    $this->response($message, 200);

                } else {

                    $this->Driver_model->change_status_driver($dec_data->id, 1);

                    $message = array(

                        'message' => 'success',

                        'driver_status' => 1,

                        'data_driver' => $getDataDriver['data_driver']->result(),

                        'data_transaksi' => [],

                        'saldo' => $saldo->row('saldo'),

                        'currency' => $item['app_currency'],

                        'currency_text' => $item['app_currency_text'],

                        'app_aboutus' => $item['app_aboutus'],

                        'app_contact' => $item['app_contact'],

                        'app_website' => $item['app_website'],

                        'stripe_active' => $item['stripe_active'],

                        'paypal_key' => $item['paypal_key'],

                        'paypal_mode' => $item['paypal_mode'],

                        'paypal_active' => $item['paypal_active'],

                        'app_email' => $item['app_email'],

                        'payu' => $payu

                    );

                    $this->response($message, 200);

                }

            } else {

                $message = array(

                    'code' => '201',

                    'message' => 'failed',

                    'data' => []

                );

                $this->response($message, 201);

            }

        }

    }



    function turning_on_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }

        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $is_turn = $dec_data->is_turn;

        $dataEdit = array();

        if ($is_turn) {

            $dataEdit = array(

                'status' => 1

            );

            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);

            if ($upd_regid) {

                $message = array(

                    'message' => 'success',

                    'data' => '1'

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'message' => 'fail',

                    'data' => []

                );

                $this->response($message, 200);

            }

        } else {

            $dataEdit = array(

                'status' => 4

            );

            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);

            if ($upd_regid) {

                $message = array(

                    'message' => 'success',

                    'data' => '4'

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'message' => 'fail',

                    'data' => []

                );

                $this->response($message, 200);

            }

        }

    }



    function accept_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $data_req = array(

            'id_driver' => $dec_data->id,

            'id_transaksi' => $dec_data->id_transaksi

        );



        $condition = array(

            'id_driver' => $dec_data->id,

            'status' => '1'

        );



        $cek_login = $this->Driver_model->get_status_driver($condition);

        if ($cek_login->num_rows() > 0) {



            $acc_req = $this->Driver_model->accept_request($data_req);

            if ($acc_req['status']) {

                $message = array(

                    'message' => 'berhasil',

                    'data' => 'berhasil'

                );

                $this->response($message, 200);

            } else {

                if ($acc_req['data'] == 'canceled') {

                    $message = array(

                        'message' => 'canceled',

                        'data' => 'canceled'

                    );

                    $this->response($message, 200);

                } else {

                    $message = array(

                        'message' => 'unknown fail',

                        'data' => 'canceled'

                    );

                    $this->response($message, 200);

                }

            }

        } else {

            $message = array(

                'message' => 'unknown fail',

                'data' => 'canceled'

            );

            $this->response($message, 200);

        }

    }



    function start_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $data_req = array(

            'id_driver' => $dec_data->id,

            'id_transaksi' => $dec_data->id_transaksi

        );



        $acc_req = $this->Driver_model->start_request($data_req);

        if ($acc_req['status']) {

            $message = array(

                'message' => 'berhasil',

                'data' => 'success'

            );

            $this->response($message, 200);

        } else {

            if ($acc_req['data'] == 'canceled') {

                $message = array(

                    'message' => 'canceled',

                    'data' => 'canceled'

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'message' => 'unknown fail',

                    'data' => 'unknown fail'

                );

                $this->response($message, 200);

            }

        }

    }



    function finish_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $data_req = array(

            'id_driver' => $dec_data->id,

            'id_transaksi' => $dec_data->id_transaksi

        );



        $data_tr = array(

            'id_driver' => $dec_data->id,

            'id' => $dec_data->id_transaksi

        );



        $finish_transaksi = $this->Driver_model->finish_request($data_req, $data_tr);

        if ($finish_transaksi['status']) {

            $message = array(

                'message' => 'berhasil',

                'data' => 'finish',

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'message' => 'fail',

                'data' => $finish_transaksi['data']

            );

            $this->response($message, 200);

        }

    }



    function detail_transaksi_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);

        $gettrans = $this->Pelanggan_model->transaksi($dec_data->id);

        $getdriver = $this->Driver_model->get_data_pelangganid($dec_data->id_pelanggan);

        $getitem = $this->Pelanggan_model->detail_item($dec_data->id);



        $message = array(

            'status' => true,

            'data' => $gettrans->result(),

            'pelanggan' => $getdriver->result(),

            'item' => $getitem->result(),

        );

        $this->response($message, 200);

    }



    function verifycode_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);

        $condition = array(

            'no_telepon' => $dec_data->no_telepon

        );

        $dataverify = array(

            'struk' => $dec_data->verifycode,

            'id_transaksi' => $dec_data->id_transaksi

        );

        $dataver = $this->Driver_model->get_verify($dataverify);

        $cek_login = $this->Driver_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0 && $dataver->num_rows() > 0) {



            $message = array(

                'message' => 'success',

                'data' => '',

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'message' => 'fail',

                'data' => ''

            );

            $this->response($message, 200);

        }

    }



    function edit_profile_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $check_exist_phone = $this->Driver_model->check_exist_phone_edit($decoded_data->id, $decoded_data->no_telepon);

        $check_exist_email = $this->Driver_model->check_exist_email_edit($decoded_data->id, $decoded_data->email);

        if ($check_exist_phone) {

            $message = array(

                'code' => '201',

                'message' => 'phone already exist',

                'data' => []

            );

            $this->response($message, 201);

        } else if ($check_exist_email) {

            $message = array(

                'code' => '201',

                'message' => 'email already exist',

                'data' => []

            );

            $this->response($message, 201);

        } else {

            $condition = array(

                'no_telepon' => $decoded_data->no_telepon

            );

            $condition2 = array(

                'no_telepon' => $decoded_data->no_telepon_lama

            );



            if ($decoded_data->fotodriver == null && $decoded_data->fotodriver_lama == null) {

                $datauser = array(

                    'nama_driver' => $decoded_data->fullnama,

                    'no_telepon' => $decoded_data->no_telepon,

                    'phone' => $decoded_data->phone,

                    'email' => $decoded_data->email,

                    'countrycode' => $decoded_data->countrycode,

                    'tgl_lahir' => $decoded_data->tgl_lahir

                );

            } else {

                $image = $decoded_data->fotodriver;

                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";

                $path = "images/fotodriver/" . $namafoto;

                file_put_contents($path, base64_decode($image));



                $foto = $decoded_data->fotodriver_lama;

                $path = "./images/fotodriver/$foto";

                unlink("$path");





                $datauser = array(

                    'nama_driver' => $decoded_data->fullnama,

                    'no_telepon' => $decoded_data->no_telepon,

                    'phone' => $decoded_data->phone,

                    'email' => $decoded_data->email,

                    'countrycode' => $decoded_data->countrycode,

                    'foto' => $namafoto,

                    'tgl_lahir' => $decoded_data->tgl_lahir

                );

            }





            $cek_login = $this->Driver_model->get_data_pelanggan($condition2);

            if ($cek_login->num_rows() > 0) {

                $upd_user = $this->Driver_model->edit_profile($datauser, $decoded_data->no_telepon_lama);

                $getdata = $this->Driver_model->get_data_pelanggan($condition);

                $message = array(

                    'code' => '200',

                    'message' => 'success',

                    'data' => $getdata->result()

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'code' => '404',

                    'message' => 'error data',

                    'data' => []

                );

                $this->response($message, 200);

            }

        }

    }



    function edit_kendaraan_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);



        $condition = array(

            'id' => $decoded_data->id,

            'no_telepon' => $decoded_data->no_telepon

        );



        $datakendaraan = array(

            'merek' => $decoded_data->merek,

            'tipe' => $decoded_data->tipe,

            'nomor_kendaraan' => $decoded_data->no_kendaraan,

            'warna' => $decoded_data->warna

        );







        $cek_login = $this->Driver_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {

            $upd_user = $this->Driver_model->edit_kendaraan($datakendaraan, $decoded_data->id_kendaraan);

            $getdata = $this->Driver_model->get_data_pelanggan($condition);

            $message = array(

                'code' => '200',

                'message' => 'success',

                'data' => $getdata->result()

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'code' => '404',

                'message' => 'error data',

                'data' => []

            );

            $this->response($message, 200);

        }

    }



    function changepass_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $reg_id = array(

            'password' => sha1($decoded_data->new_password)

        );



        $condition = array(

            'password' => sha1($decoded_data->password),

            'no_telepon' => $decoded_data->no_telepon

        );

        $condition2 = array(

            'password' => sha1($decoded_data->new_password),

            'no_telepon' => $decoded_data->no_telepon

        );

        $cek_login = $this->Driver_model->get_data_pelanggan($condition);

        $message = array();



        if ($cek_login->num_rows() > 0) {

            $upd_regid = $this->Driver_model->edit_profile($reg_id, $decoded_data->no_telepon);

            $get_pelanggan = $this->Driver_model->get_data_pelanggan($condition2);



            $message = array(

                'code' => '200',

                'message' => 'found',

                'data' => $get_pelanggan->result()

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'code' => '404',

                'message' => 'wrong password',

                'data' => []

            );

            $this->response($message, 200);

        }

    }



    function history_progress_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }

        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);

        $getWallet = $this->Driver_model->all_transaksi($decoded_data->id);

        $message = array(

            'status' => true,

            'data' => $getWallet->result()

        );

        $this->response($message, 200);

    }



    function forgot_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $decoded_data = json_decode($data);



        $condition = array(

            'email' => $decoded_data->email,

            'status' => '1'

        );

        $cek_login = $this->Driver_model->get_data_pelanggan($condition);

        $app_settings = $this->Pelanggan_model->get_settings();

        $token = sha1(rand(0, 999999) . time());





        if ($cek_login->num_rows() > 0) {

            $cheker = array('msg' => $cek_login->result());

            foreach ($app_settings as $item) {

                foreach ($cheker['msg'] as $item2 => $val) {

                    $dataforgot = array(

                        'userid' => $val->id,

                        'token' => $token,

                        'idKey' => '2'

                    );

                }





                $forgot = $this->Pelanggan_model->dataforgot($dataforgot);



                $linkbtn = base_url() . 'resetpass/rest/' . $token . '/2';

                $template = $this->Pelanggan_model->template1($item['email_subject'], $item['email_text1'], $item['email_text2'], $item['app_website'], $item['app_name'], $linkbtn, $item['app_linkgoogle'], $item['app_address']);

                $sendmail = $this->Pelanggan_model->emailsend($item['email_subject'] . " [ticket-" . rand(0, 999999) . "]", $decoded_data->email, $template, $item['smtp_host'], $item['smtp_port'], $item['smtp_username'], $item['smtp_password'], $item['smtp_from'], $item['app_name'], $item['smtp_secure']);

            }

            if ($forgot && $sendmail) {

                $message = array(

                    'code' => '200',

                    'message' => 'found',

                    'data' => []

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'code' => '401',

                    'message' => 'email not registered',

                    'data' => []

                );

                $this->response($message, 200);

            }

        } else {

            $message = array(

                'code' => '404',

                'message' => 'email not registered',

                'data' => []

            );

            $this->response($message, 200);

        }

    }



    function register_driver_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $email = $dec_data->email;

        $phone = $dec_data->no_telepon;

        $check_exist = $this->Driver_model->check_exist($email, $phone);

        $check_exist_phone = $this->Driver_model->check_exist_phone($phone);

        $check_exist_email = $this->Driver_model->check_exist_email($email);

        $check_exist_sim = $this->Driver_model->check_sim($dec_data->id_sim);

        $check_exist_ktp = $this->Driver_model->check_ktp($dec_data->no_ktp);

        if ($check_exist) {

            $message = array(

                'code' => '201',

                'message' => 'email and phone number already exist',

                'data' => ''

            );

            $this->response($message, 201);

        } else if ($check_exist_phone) {

            $message = array(

                'code' => '201',

                'message' => 'phone already exist',

                'data' => ''

            );

            $this->response($message, 201);

        } else if ($check_exist_sim) {

            $message = array(

                'code' => '201',

                'message' => 'Driver license already exist',

                'data' => ''

            );

            $this->response($message, 201);

        } else if ($check_exist_ktp) {

            $message = array(

                'code' => '201',

                'message' => 'ID Card already exist',

                'data' => ''

            );

            $this->response($message, 201);

        } else if ($check_exist_email) {

            $message = array(

                'code' => '201',

                'message' => 'email already exist',

                'data' => ''

            );

            $this->response($message, 201);

        } else {

            $image = $dec_data->foto;

                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";

                $path = "images/fotodriver/" . $namafoto;

                file_put_contents($path, base64_decode($image));

                $data_signup = array(

                    'id' => 'D' . time(),

                    'nama_driver' => $dec_data->nama_driver,

                    'no_ktp' => $dec_data->no_ktp,

                    'tgl_lahir' => $dec_data->tgl_lahir,

                    'no_telepon' => $dec_data->no_telepon,

                    'phone' => $dec_data->phone,

                    'email' => $dec_data->email,

                    'foto' => $namafoto,

                    'password' => sha1(time()),

                    'job' => $dec_data->job,

                    'countrycode' => $dec_data->countrycode,

                    'gender' => $dec_data->gender,

                    'alamat_driver' => $dec_data->alamat_driver,

                    'reg_id' => 12345,

                    'status' => 0

                );



                $data_kendaraan = array(

                    'merek' => $dec_data->merek,

                    'tipe' => $dec_data->tipe,

                    'nomor_kendaraan' => $dec_data->nomor_kendaraan,

                    'warna' => $dec_data->warna

                );



                $imagektp = $dec_data->foto_ktp;

                $namafotoktp = time() . '-' . rand(0, 99999) . ".jpg";

                $pathktp = "images/fotoberkas/ktp/" . $namafotoktp;

                file_put_contents($pathktp, base64_decode($imagektp));



                $imagesim = $dec_data->foto_sim;

                $namafotosim = time() . '-' . rand(0, 99999) . ".jpg";

                $pathsim = "images/fotoberkas/sim/" . $namafotosim;

                file_put_contents($pathsim, base64_decode($imagesim));



                $data_berkas = array(

                    'foto_ktp' => $namafotoktp,

                    'foto_sim' => $namafotosim,

                    'id_sim' => $dec_data->id_sim

                );





                $signup = $this->Driver_model->signup($data_signup, $data_kendaraan, $data_berkas);

                if ($signup) {

                    $message = array(

                        'code' => '200',

                        'message' => 'success',

                        'data' => 'register has been succesed!'

                    );

                    $this->response($message, 200);

                } else {

                    $message = array(

                        'code' => '201',

                        'message' => 'failed',

                        'data' => ''

                    );

                    $this->response($message, 201);

                }

        }

    }



    public function withdraw_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $iduser = $dec_data->id;

        $bank = $dec_data->bank;

        $nama = $dec_data->nama;

        $amount = $dec_data->amount;

        $card = $dec_data->card;

        $email = $dec_data->email;

        $phone = $dec_data->no_telepon;



        $saldolama = $this->Pelanggan_model->saldouser($iduser);

        $datawithdraw = array(

            'id_user' => $iduser,

            'rekening' => $card,

            'bank' => $bank,

            'nama_pemilik' => $nama,

            'type' => $dec_data->type,

            'jumlah' => $amount,

            'status' => 0

        );

        $check_exist = $this->Driver_model->check_exist($email, $phone);



        if ($dec_data->type ==  "topup") {

            $withdrawdata = $this->Pelanggan_model->insertwallet($datawithdraw);



            $message = array(

                'code' => '200',

                'message' => 'success',

                'data' => []

            );

            $this->response($message, 200);

        } else {



            if ($saldolama->row('saldo') >= $amount && $check_exist) {

                $withdrawdata = $this->Pelanggan_model->insertwallet($datawithdraw);



                $message = array(

                    'code' => '200',

                    'message' => 'success',

                    'data' => []

                );

                $this->response($message, 200);

            } else {

                $message = array(

                    'code' => '201',

                    'message' => 'You have insufficient balance',

                    'data' => []

                );

                $this->response($message, 200);

            }

        }

    }



    public function topuppaypal_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $iduser = $dec_data->id;

        $bank = $dec_data->bank;

        $nama = $dec_data->nama;

        $amount = $dec_data->amount;

        $card = $dec_data->card;

        $email = $dec_data->email;

        $phone = $dec_data->no_telepon;



        $datatopup = array(

            'id_user' => $iduser,

            'rekening' => $card,

            'bank' => $bank,

            'nama_pemilik' => $nama,

            'type' => 'topup',

            'jumlah' => $amount,

            'status' => 1

        );

        $check_exist = $this->Driver_model->check_exist($email, $phone);



        if ($check_exist) {

            $this->Pelanggan_model->insertwallet($datatopup);

            $saldolama = $this->Pelanggan_model->saldouser($iduser);

            $saldobaru = $saldolama->row('saldo') + $amount;

            $saldo = array('saldo' => $saldobaru);

            $this->Pelanggan_model->tambahsaldo($iduser, $saldo);



            $message = array(

                'code' => '200',

                'message' => 'success',

                'data' => ''

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'code' => '201',

                'message' => 'You have insufficient balance',

                'data' => ''

            );

            $this->response($message, 200);

        }

    }

    function driver_cancel_post()

    {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }



        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $data_req = array(

            'id_transaksi' => $dec_data->id_transaksi

        );

        $cancel_req = $this->Driver_model->driver_cancel_request($data_req);

        if ($cancel_req['status']) {

            $this->Driver_model->delete_chat($cancel_req['iddriver'], $cancel_req['idpelanggan']);

            $message = array(

                'message' => 'canceled',

                'data' => []

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'message' => 'cancel fail',

                'data' => []

            );

            $this->response($message, 200);

        }

    }


    function minimum_wallet_job_post()

    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header("WWW-Authenticate: Basic realm=\"Private Area\"");

            header("HTTP/1.0 401 Unauthorized");

            return false;

        }

        $data = file_get_contents("php://input");

        $dec_data = json_decode($data);



        $driver_job = $dec_data->driver_job;

        $condition = array(

            'driver_job' => $driver_job

        );

        $getdata = $this->Driver_model->check_minimum_wallet_job($condition);

        if ($getdata->num_rows() > 0) {  

            $message = array(

                'code' => '200',

                'message' => 'success',

                'data' => $getdata->result()

            );

            $this->response($message, 200);

        } else {

            $message = array(

                'code' => '404',

                'message' => 'error data',

                'data' => []

            );

            $this->response($message, 200);

        }

        
    }
    

}

