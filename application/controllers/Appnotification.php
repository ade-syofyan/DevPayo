<?php
defined('BASEPATH') or exit('No direct script access allowed');

class appnotification extends CI_Controller
{

    public function  __construct()
    {
        parent::__construct();



        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('notification_model', 'notif');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $this->load->view('includes/header');
        $this->load->view('appnotification/index');
        $this->load->view('includes/footer');
    }

    public function send()
    {


        $topic = $this->input->post('topic');
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $this->notif->send_notif($title, $message, $topic);
        $this->session->set_flashdata('send', 'Notification Has Been Send');
        redirect('appnotification/index');
    }
}
