<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Bank_model', 'bank');
    }

    public function requestdriver()
    {
        // $data['news'] = $this->news->getallnews();
        $data['active'] = $this->bank->actvieBank();
        $data['reject'] = $this->bank->rejectBank();

        $this->load->view('includes/header');
        $this->load->view('drivers/request_bank', $data);
        $this->load->view('includes/footer');
    }

    public function requestmitra()
    {
        // $data['news'] = $this->news->getallnews();
        $data['active'] = $this->bank->actvieMitra();
        $data['reject'] = $this->bank->rejectMitra();

        $this->load->view('includes/header');
        $this->load->view('mitra/request_bank', $data);
        $this->load->view('includes/footer');
    }
}
