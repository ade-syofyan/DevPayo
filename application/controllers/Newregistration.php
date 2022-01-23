<?php
defined('BASEPATH') or exit('No direct script access allowed');

class newregistration extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();


        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('driver_model', 'driver');
        $this->load->model('Pelanggan_model');
        $this->load->model('email_model');
        $this->load->model('appsettings_model', 'app');
    }

    public function index()
    {
        $regency = $this->session->userdata('regency');
        if ($regency == 0) {
            $data['driver'] = $this->driver->getAlldriver();
        } else {
            $data['driver'] = $this->driver->getAlldriverbyagent();
        }

        // echo $data['driver'];



        $this->load->view('includes/header');
        $this->load->view('newregistration/index', $data);
        $this->load->view('includes/footer');
    }

    public function confirm($id)
    {
        $this->driver->ubahstatusnewreg($id);

        $item = $this->app->getappbyid();

        $token = sha1(rand(0, 999999) . time());

        $dataforgot = array(
            'userid' => $id,
            'token' => $token,
            'idKey' => '2'
        );
        $this->Pelanggan_model->dataforgot($dataforgot);

        $linkbtn = base_url() . 'resetpass/rest/' . $token . '/2';
        $judul_email = $item['email_subject_confirm'] . '[ticket-' . rand(0, 999999) . ']';
        $template = $this->Pelanggan_model->template1($item['email_subject_confirm'], $item['email_text3'], $item['email_text4'], $item['app_website'], $item['app_name'], $linkbtn, $item['app_linkgoogle'], $item['app_address']);
        $email = $this->driver->getdriverbyid($id);
        $emailuser = $email['email'];
        $host = $item['smtp_host'];
        $port = $item['smtp_port'];
        $username = $item['smtp_username'];
        $password = $item['smtp_password'];
        $from = $item['smtp_from'];
        $appname = $item['app_name'];
        $secure = $item['smtp_secure'];

        $this->email_model->emailsend($judul_email, $emailuser, $template, $host, $port, $username, $password, $from, $appname, $secure);
        $this->session->set_flashdata('ubah', 'Driver Has Been Confirm');
        redirect('driver');
    }
}
