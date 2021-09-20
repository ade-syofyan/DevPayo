<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agent extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
        //     redirect(base_url() . "login");
        // }
        // $this->load->model('profile_model', 'profile');
        $this->load->model('agent_model', 'agenmodel');
        // $this->load->model('news_model', 'news');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // $data['news'] = $this->news->getallnews();
        $data['data'] = $this->agenmodel->getDataAgent();

        $this->load->view('includes/header');
        $this->load->view('agen/index', $data);
        $this->load->view('includes/footer');
    }

    public function tambah()
    {

        $data['prov'] = $this->agenmodel->getDataProv();


        $username = html_escape($this->input->post('user_name', TRUE));
        $password = html_escape($this->input->post('password', TRUE));
        $email    = html_escape($this->input->post('email', TRUE));
        $province = html_escape($this->input->post('province', TRUE));
        $regency  = html_escape($this->input->post('regency', TRUE));
        $this->form_validation->set_rules('user_name', 'NAME', 'trim|prep_for_form');
        $this->form_validation->set_rules('phone', 'PHONE', 'trim|prep_for_form|is_unique[admin.phone]');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|prep_for_form|is_unique[admin.email]');
        $this->form_validation->set_rules('password', 'PASSWORD', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            $config['upload_path']     = './images/agent/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {

                $foto = html_escape($this->upload->data('file_name'));
            } else {
                $foto = 'noimage.jpg';
            }
            $data             = [

                'user_name'                 => $username,
                'password'                  => sha1($password),
                'email'                     => $email,
                'countryCode'               => html_escape($this->input->post('countrycode', TRUE)),
                'phone'                     => html_escape($this->input->post('phone', TRUE)),
                'province_id'               => $province,
                'regency_id'                => $regency,
                // 'token'                     => 'T' . time(),
                'image'                      => $foto,
                'level_id'                  => 2
                // 'no_telepon'                => str_replace("+", "", $countrycode) . $phone,

            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('agent/index');
            } else {

                $this->agenmodel->tambahdata($data);
                $this->session->set_flashdata('tambah', 'Agent Has Been Added');
                redirect('agent/index');
            }
        } else {
            $this->load->view('includes/header');
            $this->load->view('agen/tambah', $data);
            $this->load->view('includes/footer');
            // }
        }
    }

    public function get_regency()
    {
        $id = $this->input->post('id');
        $data = $this->agenmodel->getDataReg($id);
        echo json_encode($data);
    }
}
