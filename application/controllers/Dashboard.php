<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
       
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->load->model('users_model', 'user');
        $this->load->model('driver_model', 'driver');
        $this->load->model('notification_model', 'notif');
        // $this->load->library('form_validation');
    }

    public function index()
    {
        $data['jan1'] = $this->dashboard->getTotalTransaksiBulanan(1, date('Y'), 1);
        $data['feb1'] = $this->dashboard->getTotalTransaksiBulanan(2, date('Y'), 1);
        $data['mar1'] = $this->dashboard->getTotalTransaksiBulanan(3, date('Y'), 1);
        $data['apr1'] = $this->dashboard->getTotalTransaksiBulanan(4, date('Y'), 1);
        $data['mei1'] = $this->dashboard->getTotalTransaksiBulanan(5, date('Y'), 1);
        $data['jun1'] = $this->dashboard->getTotalTransaksiBulanan(6, date('Y'), 1);
        $data['jul1'] = $this->dashboard->getTotalTransaksiBulanan(7, date('Y'), 1);
        $data['aug1'] = $this->dashboard->getTotalTransaksiBulanan(8, date('Y'), 1);
        $data['sep1'] = $this->dashboard->getTotalTransaksiBulanan(9, date('Y'), 1);
        $data['okt1'] = $this->dashboard->getTotalTransaksiBulanan(10, date('Y'), 1);
        $data['nov1'] = $this->dashboard->getTotalTransaksiBulanan(11, date('Y'), 1);
        $data['des1'] = $this->dashboard->getTotalTransaksiBulanan(12, date('Y'), 1);

        $data['jan2'] = $this->dashboard->getTotalTransaksiBulanan(1, date('Y'), 2);
        $data['feb2'] = $this->dashboard->getTotalTransaksiBulanan(2, date('Y'), 2);
        $data['mar2'] = $this->dashboard->getTotalTransaksiBulanan(3, date('Y'), 2);
        $data['apr2'] = $this->dashboard->getTotalTransaksiBulanan(4, date('Y'), 2);
        $data['mei2'] = $this->dashboard->getTotalTransaksiBulanan(5, date('Y'), 2);
        $data['jun2'] = $this->dashboard->getTotalTransaksiBulanan(6, date('Y'), 2);
        $data['jul2'] = $this->dashboard->getTotalTransaksiBulanan(7, date('Y'), 2);
        $data['aug2'] = $this->dashboard->getTotalTransaksiBulanan(8, date('Y'), 2);
        $data['sep2'] = $this->dashboard->getTotalTransaksiBulanan(9, date('Y'), 2);
        $data['okt2'] = $this->dashboard->getTotalTransaksiBulanan(10, date('Y'), 2);
        $data['nov2'] = $this->dashboard->getTotalTransaksiBulanan(11, date('Y'), 2);
        $data['des2'] = $this->dashboard->getTotalTransaksiBulanan(12, date('Y'), 2);

        $data['jan3'] = $this->dashboard->getTotalTransaksiBulanan(1, date('Y'), 3);
        $data['feb3'] = $this->dashboard->getTotalTransaksiBulanan(2, date('Y'), 3);
        $data['mar3'] = $this->dashboard->getTotalTransaksiBulanan(3, date('Y'), 3);
        $data['apr3'] = $this->dashboard->getTotalTransaksiBulanan(4, date('Y'), 3);
        $data['mei3'] = $this->dashboard->getTotalTransaksiBulanan(5, date('Y'), 3);
        $data['jun3'] = $this->dashboard->getTotalTransaksiBulanan(6, date('Y'), 3);
        $data['jul3'] = $this->dashboard->getTotalTransaksiBulanan(7, date('Y'), 3);
        $data['aug3'] = $this->dashboard->getTotalTransaksiBulanan(8, date('Y'), 3);
        $data['sep3'] = $this->dashboard->getTotalTransaksiBulanan(9, date('Y'), 3);
        $data['okt3'] = $this->dashboard->getTotalTransaksiBulanan(10, date('Y'), 3);
        $data['nov3'] = $this->dashboard->getTotalTransaksiBulanan(11, date('Y'), 3);
        $data['des3'] = $this->dashboard->getTotalTransaksiBulanan(12, date('Y'), 3);

        $data['jan4'] = $this->dashboard->getTotalTransaksiBulanan(1, date('Y'), 4);
        $data['feb4'] = $this->dashboard->getTotalTransaksiBulanan(2, date('Y'), 4);
        $data['mar4'] = $this->dashboard->getTotalTransaksiBulanan(3, date('Y'), 4);
        $data['apr4'] = $this->dashboard->getTotalTransaksiBulanan(4, date('Y'), 4);
        $data['mei4'] = $this->dashboard->getTotalTransaksiBulanan(5, date('Y'), 4);
        $data['jun4'] = $this->dashboard->getTotalTransaksiBulanan(6, date('Y'), 4);
        $data['jul4'] = $this->dashboard->getTotalTransaksiBulanan(7, date('Y'), 4);
        $data['aug4'] = $this->dashboard->getTotalTransaksiBulanan(8, date('Y'), 4);
        $data['sep4'] = $this->dashboard->getTotalTransaksiBulanan(9, date('Y'), 4);
        $data['okt4'] = $this->dashboard->getTotalTransaksiBulanan(10, date('Y'), 4);
        $data['nov4'] = $this->dashboard->getTotalTransaksiBulanan(11, date('Y'), 4);
        $data['des4'] = $this->dashboard->getTotalTransaksiBulanan(12, date('Y'), 4);


        $data['harian'] = $this->dashboard->getbydate();

        




        $data['currency'] = $this->app->getappbyid();
        $data['transaksi'] = $this->dashboard->getAlltransaksi();
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();
        $data['user'] = $this->user->getallusers();
        $data['driver'] = $this->driver->getalldriver();
        $data['mitra'] = $this->dashboard->countmitra();
        $data['hitungdriver'] = $this->dashboard->countdriver();



        $this->load->view('includes/header');
        $this->load->view('dashboard/index', $data);
    }

    

    public function detail($id)
    {
        
        $data['transaksi'] = $this->dashboard->gettransaksiById($id);
        $data['currency'] = $this->app->getappbyid();
        $data['transitem'] = $this->dashboard->getitem($id);

        $this->load->view('includes/header');
        $this->load->view('dashboard/detailtransaction', $data);
        $this->load->view('includes/footer');
    }

    public function cancletransaction($id)
    {
        $dataget = $this->dashboard->gettransaksiById($id);

        $id_driver      = $dataget['id_driver'];
        $id_transaksi   = $dataget['id'];
        $token_user     = $dataget['token'];
        $token_driver     = $dataget['reg_id'];
        $this->notif->notif_cancel_user($id_driver, $id_transaksi, $token_user);
        $this->notif->notif_cancel_driver($id_transaksi, $token_driver);
        $this->dashboard->ubahstatustransaksibyid($id);
        $this->dashboard->ubahstatusdriverbyid($id_driver);
        $this->session->set_flashdata('cancel', 'Transaction Has Been Cancel');
        redirect('dashboard/index');
    }

    public function delete($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('transaction/index');
        } else {
            $this->dashboard->deletetransaksi($id);
            $this->session->set_flashdata('hapus', 'Transaction Has Been Delete ');
            redirect('transaction/index');
        }
    }
}
