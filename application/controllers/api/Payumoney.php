<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Payumoney extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->model('Pelanggan_model');
        $this->load->model('Driver_model');
        $this->load->model('Merchantapi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Jasaku!", 200);
    }

    function payu_post()
    {
        $json = json_encode($_POST);
        $dec_data = json_decode($json);
        $statususer = $dec_data->udf4;
        if ($statususer == "pelanggan") {
            $conditionpelanggan = array(
                'id' => $dec_data->udf1,
                'password' => $dec_data->udf3
            );
            $cek_login = $this->Pelanggan_model->get_data_pelanggan($conditionpelanggan);
        } else if ($statususer == "driver") {
            $conditiondriver = array(
                'id' => $dec_data->udf1,
                'password' => $dec_data->udf3
            );
            $cek_login = $this->Driver_model->get_data_pelanggan($conditiondriver);
        } else if ($statususer == "merchant") {
            $conditionmerchant = array(
                'id_mitra' => $dec_data->udf1,
                'password' => $dec_data->udf3
                //'token' => $decoded_data->token
            );
            $cek_login = $this->Merchantapi_model->get_data_merchant($conditionmerchant);
        }
        if ($cek_login->num_rows() > 0) {
            if ($dec_data->status == 'success') {
                $amount = str_replace(".", "", $dec_data->amount);

                $datapayu = array(
                    'id_user' => $dec_data->udf1,
                    'rekening' => $dec_data->cardnum,
                    'bank' => $dec_data->udf2,
                    'nama_pemilik' => $dec_data->firstname,
                    'type' => $dec_data->productinfo,
                    'jumlah' => $amount,
                    'status' => 1
                );

                $this->Pelanggan_model->insertwallet($datapayu);
                foreach ($cek_login->result_array() as $gettoken) {
                    $datasaldo = [
                        'saldo' => ($gettoken['saldo'] + $amount)
                    ];
                    $this->Pelanggan_model->tambahsaldo($dec_data->udf1, $datasaldo);
                }
                echo '<script type="text/javascript">';
                echo 'PayU.onSuccess("Amount =" +' . $dec_data->amount . ')';
                echo "</script>";

                $this->response("", 200);
            } else {
                echo ("<br>");
                echo "\nInvalid transaction";

                $this->response("", 200);
            }
        }
    }
}
