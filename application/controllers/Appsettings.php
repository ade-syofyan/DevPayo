<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appsettings extends CI_Controller
{
    public function  __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->library('form_validation');
        $this->load->model('appsettings_model', 'app');
    }

    public function index()
    {
        $data['appsettings'] = $this->app->getappbyid();
        $data['payusettings'] = $this->app->getpayubyid();
        $data['transfer'] = $this->app->gettransfer();

        $this->load->view('includes/header');
        $this->load->view('appsettings/index', $data);
        $this->load->view('includes/footer');
    }

    public function ubahbank($id)
    {
        $this->form_validation->set_rules('nama_bank', 'nama_bank', 'trim|prep_for_form');
        $this->form_validation->set_rules('rekening_bank', 'rekening_bank', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/bank/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = time();
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            $dataget = $this->app->getbankid($id);

            if ($this->upload->do_upload('image_bank')) {
                if ($dataget['image_bank'] != 'noimage.jpg') {
                    $gambar = $dataget['image_bank'];
                    unlink('./images/bank/' . $gambar);
                }

                $gambar = $dataget['image_bank'];
                unlink('./images/bank/' . $gambar);
                $app_logo = html_escape($this->upload->data('file_name'));
            } else {
                $app_logo = $dataget['image_bank'];
            }

            $data = [
                'nama_bank' => html_escape($this->input->post('nama_bank', TRUE)),
                'rekening_bank' => html_escape($this->input->post('rekening_bank', TRUE)),
                'status_bank' => html_escape($this->input->post('status_bank', TRUE)),
                'image_bank' => $app_logo
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdatarekening($data, $id);
                $this->session->set_flashdata('ubah', 'APP Has Been Change');
                redirect('appsettings');
            }
        }
    }

    public function hapusbank($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('appsettings/index');
        } else {
            $dataget = $this->app->getbankid($id);
            $gambar = $dataget['image_bank'];
            unlink('./images/bank/' . $gambar);
            $this->app->hapusrekening($id);
            $this->session->set_flashdata('ubah', 'APP Has Been deleted');
            redirect('appsettings');
        }
    }

    public function adddatabank()
    {
        $this->form_validation->set_rules('nama_bank', 'nama_bank', 'trim|prep_for_form');
        $this->form_validation->set_rules('rekening_bank', 'rekening_bank', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/bank/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = time();
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image_bank')) {
                $app_logo = html_escape($this->upload->data('file_name'));
            }
            $data = [
                'nama_bank' => html_escape($this->input->post('nama_bank', TRUE)),
                'rekening_bank' => html_escape($this->input->post('rekening_bank', TRUE)),
                'status_bank' => html_escape($this->input->post('status_bank', TRUE)),
                'image_bank' => $app_logo
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->adddatarekening($data);
                $this->session->set_flashdata('ubah', 'APP Has Been add');
                redirect('appsettings');
            }
        }
    }

    public function ubahapp()
    {
        $this->form_validation->set_rules('app_email', 'app_email', 'trim|prep_for_form');
        $this->form_validation->set_rules('app_website', 'app_website', 'trim|prep_for_form');
        $this->form_validation->set_rules('app_linkgoogle', 'app_linkgoogle', 'trim|prep_for_form');
        $this->form_validation->set_rules('app_currency', 'app_currency', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './asset/images/icon/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);
            $data = $this->app->getappbyid();

            if ($this->upload->do_upload('app_logo')) {
                if ($data['app_logo'] != 'noimage.jpg') {
                    $gambar = $data['app_logo'];
                    unlink('asset/images/icon/' . $gambar);
                }

                $app_logo = html_escape($this->upload->data('file_name'));
            } else {
                $app_logo = $data['app_logo'];
            }

            $data = [
                'app_logo'           => $app_logo,
                'app_email'          => html_escape($this->input->post('app_email', TRUE)),
                'app_website'        => html_escape($this->input->post('app_website', TRUE)),
                'app_privacy_policy' => $this->input->post('app_privacy_policy', TRUE),
                'app_book_guide'     => $this->input->post('app_book_guide', TRUE),
                'app_aboutus'        => $this->input->post('app_aboutus', TRUE),
                'app_address'        => $this->input->post('app_address'),
                'app_linkgoogle'     => html_escape($this->input->post('app_linkgoogle', TRUE)),
                'app_name'           => html_escape($this->input->post('app_name', TRUE)),
                'app_currency'       => html_escape($this->input->post('app_currency', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdataappsettings($data);
                $this->session->set_flashdata('ubah', 'APP Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['appsettings'] = $this->app->getappbyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahemail()
    {
        $this->form_validation->set_rules('email_subject', 'email_subject', 'trim|prep_for_form');
        $this->form_validation->set_rules('email_subject_confirm', 'email_subject', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'email_subject'         => html_escape($this->input->post('email_subject', TRUE)),
                'email_subject_confirm' => html_escape($this->input->post('email_subject_confirm', TRUE)),
                'email_text1'           => $this->input->post('email_text1'),
                'email_text2'           => $this->input->post('email_text2'),
                'email_text3'           => $this->input->post('email_text3'),
                'email_text4'           => $this->input->post('email_text4')
            ];


            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdataemail($data);
                $this->session->set_flashdata('ubah', 'Email Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['appsettings'] = $this->app->getappbyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahsmtp()
    {
        $this->form_validation->set_rules('smtp_host', 'smtp_host', 'trim|prep_for_form');
        $this->form_validation->set_rules('smtp_port', 'smtp_port', 'trim|prep_for_form');
        $this->form_validation->set_rules('smtp_username', 'smtp_username', 'trim|prep_for_form');
        $this->form_validation->set_rules('smtp_password', 'smtp_password', 'trim|prep_for_form');
        $this->form_validation->set_rules('smtp_form', 'smtp_form', 'trim|prep_for_form');
        $this->form_validation->set_rules('smtp_secure', 'smtp_secure', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'smtp_host'     => html_escape($this->input->post('smtp_host', TRUE)),
                'smtp_port'     => html_escape($this->input->post('smtp_port', TRUE)),
                'smtp_username' => html_escape($this->input->post('smtp_username', TRUE)),
                'smtp_password' => html_escape($this->input->post('smtp_password', TRUE)),
                'smtp_from'     => html_escape($this->input->post('smtp_from', TRUE)),
                'smtp_secure'   => html_escape($this->input->post('smtp_secure', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdatasmtp($data);
                $this->session->set_flashdata('ubah', 'SMTP Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['appsettings'] = $this->app->getappbyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahstripe()

    {
        $this->form_validation->set_rules('stripe_secret_key', 'stripe_secret_key', 'trim|prep_for_form');
        $this->form_validation->set_rules('stripe_published_key', 'stripe_published_key', 'trim|prep_for_form');
        $this->form_validation->set_rules('stripe_status', 'stripe_status', 'trim|prep_for_form');
        $this->form_validation->set_rules('stripe_active', 'stripe_active', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $data             = [
                'stripe_secret_key'                    => html_escape($this->input->post('stripe_secret_key', TRUE)),
                'stripe_published_key'                => html_escape($this->input->post('stripe_published_key', TRUE)),
                'stripe_status'                        => html_escape($this->input->post('stripe_status', TRUE)),
                'stripe_active'                        => html_escape($this->input->post('stripe_active', TRUE))
            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdatastripe($data);
                $this->session->set_flashdata('ubah', 'Stripe Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['appsettings'] = $this->app->getappbyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahpaypal()
    {
        $this->form_validation->set_rules('paypal_key', 'paypal_key', 'trim|prep_for_form');
        $this->form_validation->set_rules('app_currency_text', 'app_currency_text', 'trim|prep_for_form');
        $this->form_validation->set_rules('paypal_mode', 'paypal_mode', 'trim|prep_for_form');
        $this->form_validation->set_rules('paypal_active', 'paypal_active', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $data             = [
                'paypal_key'                    => html_escape($this->input->post('paypal_key', TRUE)),
                'app_currency_text'                => html_escape($this->input->post('app_currency_text', TRUE)),
                'paypal_mode'                        => html_escape($this->input->post('paypal_mode', TRUE)),
                'paypal_active'                        => html_escape($this->input->post('paypal_active', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdatapaypal($data);
                $this->session->set_flashdata('ubah', 'Paypal Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['appsettings'] = $this->app->getappbyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }

    public function addbank()
    {
        $this->load->view('includes/header');
        $this->load->view('appsettings/addbank');
        $this->load->view('includes/footer');
    }

    public function editbank($id)
    {
        $data['transfer'] = $this->app->getbankid($id);
        $this->load->view('includes/header');
        $this->load->view('appsettings/editbank', $data);
        $this->load->view('includes/footer');
    }


    public function ubahpayumoney()
    {
        $this->form_validation->set_rules('payu_key', 'payu_key', 'trim|prep_for_form');
        $this->form_validation->set_rules('payu_id', 'payu_id', 'trim|prep_for_form');
        $this->form_validation->set_rules('payu_salt', 'payu_salt', 'trim|prep_for_form');
        $this->form_validation->set_rules('payu_debug', 'payu_debug', 'trim|prep_for_form');
        $this->form_validation->set_rules('active', 'active', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $data             = [
                'payu_key'                    => html_escape($this->input->post('payu_key', TRUE)),
                'payu_id'                => html_escape($this->input->post('payu_id', TRUE)),
                'payu_salt'                        => html_escape($this->input->post('payu_salt', TRUE)),
                'payu_debug'                        => html_escape($this->input->post('payu_debug', TRUE)),
                'active'                        => html_escape($this->input->post('active', TRUE))
            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('appsettings/index');
            } else {
                $this->app->ubahdatapayu($data);
                $this->session->set_flashdata('ubah', 'Pay U Money Has Been Change');
                redirect('appsettings');
            }
        } else {
            $data['payusettings'] = $this->app->getpayubyid();
            $this->load->view('includes/header');
            $this->load->view('appsettings/index', $data);
            $this->load->view('includes/footer');
        }
    }


    public function changeStatus()
    {
        $status = $_GET['app_maintenance'];
        $data = $this->db->query('UPDATE app_settings SET app_maintenance = ' . $status . ' WHERE id = 1');
        // $data = $this->app->changeAppStatus($status);
        echo json_encode($data);
    }
}
