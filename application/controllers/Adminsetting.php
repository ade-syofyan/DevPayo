<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminsetting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Adminsetting_model', 'setting');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['komisi'] = $this->setting->getData();
        // var_dump($data);die;
        $this->load->view('includes/header');
        $this->load->view('agen/setting_komisi', $data);
        $this->load->view('includes/footer');
    }

    public function ubah()
    {
        $this->form_validation->set_rules('komisi', 'komisi', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('id');
            $komisi = html_escape($this->input->post('komisi'));
            $fee = explode("%", $komisi);
            $komisiagent = $fee[0];


            $data = [
                'id'           => html_escape($this->input->post('id', TRUE)),
                'komisi_agent' => $komisiagent,
                'updated_at'   => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7)
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('adminsetting');
            } else {
                $this->setting->ubahdata($data);
                $this->session->set_flashdata('ubah', 'Komisi Has Been Changed');
                redirect('adminsetting');
            }
        } else {
            $data['komisi'] = $this->setting->getData();

            $this->load->view('includes/header');
            $this->load->view('agen/setting_komisi', $data);
            $this->load->view('includes/footer');
        }
    }
}
