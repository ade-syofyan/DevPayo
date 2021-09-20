<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('profile_model', 'profile');
        // $this->load->model('news_model', 'news');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // $data['news'] = $this->news->getallnews();
        $data = $this->profile->getadmin();

        $this->load->view('includes/header');
        $this->load->view('profile/index', $data);
        $this->load->view('includes/footer');
    }

    public function ubah()
    {

        $this->form_validation->set_rules('user_name', 'user_name', 'trim|prep_for_form');
        $this->form_validation->set_rules('email', 'email', 'trim|prep_for_form');

        $data = $this->profile->getadmin();

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/admin/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                if ($data['image'] != 'noimage.jpg') {
                    $image = $data['image'];
                    unlink('images/admin/' . $image);
                }

                $gambar = html_escape($this->upload->data('file_name'));
            } else {
                $gambar = $data['image'];
            }



            if ($this->input->post('password', TRUE) == NULL) {
                $pass = $data['password'];
            } else {
                $pass = html_escape(sha1($this->input->post('password', TRUE)));
            }
            $data             = [

                'image'                         => $gambar,
                'user_name'                     => html_escape($this->input->post('user_name', TRUE)),
                'email'                         => html_escape($this->input->post('email', TRUE)),
                'password'                      => $pass
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('profile/index');
            } else {
                $this->profile->ubahdataadmin($data);
                $this->session->set_userdata($data);
                $this->session->set_flashdata('diubah', 'Has Been Changed');
                redirect('profile');
            }
        } else {

            $this->load->view('includes/header');
            $this->load->view('login', $data);
            $this->load->view('includes/footer');
        }
    }
}
