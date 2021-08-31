<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Driver extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();



        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('driver_model', 'driver');
        $this->load->model('appsettings_model', 'app');
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['driver'] = $this->driver->getalldriver();


        $this->load->view('includes/header');
        $this->load->view('drivers/index', $data);
        $this->load->view('includes/footer');
    }

    public function tracking_driver()
    {
        $this->load->view('includes/header');
        $this->load->view('drivers/tracking_driver');
    }

    public function detail($id)
    {
        $data['driver'] = $this->driver->getdriverbyid($id);
        $data['currency'] = $this->app->getappbyid();
        $data['countorder'] = $this->driver->countorder($id);
        $data['transaksi'] = $this->driver->transaksi($id);
        $data['wallet'] = $this->driver->wallet($id);
        $data['driverjob'] = $this->driver->driverjob();

        $this->load->view('includes/header');
        $this->load->view('drivers/detail', $data);
        $this->load->view('includes/footer');
    }

    public function ubahid()
    {

        $this->form_validation->set_rules('nama_driver', 'nama_driver', 'trim|prep_for_form');

        $this->form_validation->set_rules('email', 'email', 'trim|prep_for_form');
        $this->form_validation->set_rules('tempat_lahir', 'tempat_lahir', 'trim|prep_for_form');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'trim|prep_for_form');
        $this->form_validation->set_rules('gender', 'gender', 'trim|prep_for_form');
        $this->form_validation->set_rules('alamat_driver', 'alamat_driver', 'trim|prep_for_form');


        if ($this->form_validation->run() == TRUE) {

            $phone = html_escape($this->input->post('phone', TRUE));
            $countrycode = html_escape($this->input->post('countrycode', TRUE));

            $data             = [
                'id'                    => html_escape($this->input->post('id', TRUE)),
                'nama_driver'           => html_escape($this->input->post('nama_driver', TRUE)),
                'email'                 => html_escape($this->input->post('email', TRUE)),
                'countrycode'           => html_escape($this->input->post('countrycode', TRUE)),
                'phone'                 => html_escape($this->input->post('phone', TRUE)),
                'no_telepon'            => str_replace("+", "", $countrycode) . $phone,
                'tempat_lahir'          => html_escape($this->input->post('tempat_lahir', TRUE)),
                'tgl_lahir'             => html_escape($this->input->post('tgl_lahir', TRUE)),
                'gender'                => html_escape($this->input->post('gender', TRUE)),
                'alamat_driver'         => html_escape($this->input->post('alamat_driver', TRUE))
            ];


            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/detail/' . $this->input->post('id', TRUE));
            } else {
                $id = html_escape($this->input->post('id', TRUE));
                $this->driver->ubahdataid($data);
                $this->session->set_flashdata('ubah', 'Driver ID Has Been Changed');
                redirect('driver/detail/' . $id);
            }
        } else {

            $data['driver'] = $this->driver->getdriverbyid($id);
            $data['currency'] = $this->app->getappbyid();
            $data['countorder'] = $this->driver->countorder($id);

            $this->load->view('includes/header');
            $this->load->view('drivers/detail', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahkendaraan()
    {

        $this->form_validation->set_rules('jenis', 'jenis', 'trim|prep_for_form');
        $this->form_validation->set_rules('merek', 'merek', 'trim|prep_for_form');
        $this->form_validation->set_rules('tipe', 'tipe', 'trim|prep_for_form');
        $this->form_validation->set_rules('nomor_kendaraan', 'nomor_kendaraan', 'trim|prep_for_form');
        $this->form_validation->set_rules('warna', 'warna', 'trim|prep_for_form');


        if ($this->form_validation->run() == TRUE) {
            $data             = [

                'id_k'                      => html_escape($this->input->post('id_k', TRUE)),
                'jenis'                     => html_escape($this->input->post('jenis', TRUE)),
                'merek'                     => html_escape($this->input->post('merek', TRUE)),
                'tipe'                      => html_escape($this->input->post('tipe', TRUE)),
                'nomor_kendaraan'           => html_escape($this->input->post('nomor_kendaraan', TRUE)),
                'warna'                     => html_escape($this->input->post('warna', TRUE))
            ];

            $data2             = [

                'id'                        => html_escape($this->input->post('id', TRUE)),
                'job'                       => html_escape($this->input->post('jenis', TRUE)),

            ];


            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/detail/' . $this->input->post('id', TRUE));
            } else {
                $id = html_escape($this->input->post('id', TRUE));
                $this->driver->ubahdatakendaraan($data, $data2);
                $this->session->set_flashdata('ubah', 'Driver Vechile Has Been Changed');
                redirect('driver/detail/' . $id);
            }
        } else {

            $data['driver'] = $this->driver->getdriverbyid($id);
            $data['currency'] = $this->app->getappbyid();
            $data['countorder'] = $this->driver->countorder($id);

            $this->load->view('includes/header');
            $this->load->view('drivers/detail', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahfoto()
    {

        @$_FILES['foto']['name'];

        if ($_FILES != NULL) {

            $config['upload_path']     = './images/fotodriver/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->upload->initialize($config);
            $this->upload->do_upload('foto');

            $id = $id = html_escape($this->input->post('id', TRUE));
            $data = $this->driver->getdriverbyid($id);


            if ($this->upload->do_upload('foto')) {
                if ($data['foto'] != 'noimage.jpg') {
                    $gambar = $data['foto'];
                    unlink('images/fotodriver/' . $gambar);
                }

                $foto = html_escape($this->upload->data('file_name'));
            } else {
                $foto = $data['foto'];
            }

            $data = [
                'foto'           => $foto,
                'id'               => html_escape($this->input->post('id', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/detail/' . $id);
            } else {
                $this->driver->ubahdatafoto($data);
                $this->session->set_flashdata('ubah', 'Driver Picture Has Been Changed');
                redirect('driver/detail/' . $id);
            }
        } else {

            $data['driver'] = $this->driver->getdriverbyid($id);
            $data['currency'] = $this->app->getappbyid();
            $data['countorder'] = $this->driver->countorder($id);

            $this->load->view('includes/header');
            $this->load->view('drivers/detail', $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahpassword()
    {


        $this->form_validation->set_rules('password', 'password', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('id');
            $data = $this->input->post('password');
            $dataencrypt = sha1($data);

            $data             = [
                'id'            => html_escape($this->input->post('id', TRUE)),
                'password'      => $dataencrypt
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/detail/' . $id);
            } else {

                $this->driver->ubahdatapassword($data);
                $this->session->set_flashdata('ubah', 'Driver Password Has Been Changed');
                redirect('driver/detail/' . $id);
            }
        } else {
            $data['driver'] = $this->driver->getdriverbyid($id);
            $data['currency'] = $this->app->getappbyid();
            $data['countorder'] = $this->driver->countorder($id);

            $this->load->view('includes/header');
            $this->load->view('drivers/detail', $data);
            $this->load->view('includes/footer');
        }
    }

    public function block($id)
    {
        $this->driver->blockdriverbyid($id);
        redirect('driver');
    }

    public function unblock($id)
    {
        $this->driver->unblockdriverbyid($id);
        redirect('driver');
    }

    public function ubahcard()
    {

        $this->form_validation->set_rules('no_ktp', 'no_ktp', 'trim|prep_for_form');
        $this->form_validation->set_rules('id_sim', 'id_sim', 'trim|prep_for_form');

        $id = html_escape($this->input->post('id', TRUE));
        $data = $this->driver->getdriverbyid($id);

        if ($this->form_validation->run() == TRUE) {





            if (@$_FILES['foto_ktp']['name']) {

                $config['upload_path']     = './images/fotoberkas/ktp';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '10000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_ktp')) {
                    if ($data['foto_ktp'] != 'noimage.jpg') {
                        $gambar = $data['foto_ktp'];
                        unlink('images/fotoberkas/ktp/' . $gambar);
                    }

                    $foto_ktp = html_escape($this->upload->data('file_name'));
                } else {
                    $foto_ktp = $data['foto_ktp'];
                }
            }
            if (@$_FILES['foto_sim']['name']) {

                $config['upload_path']     = './images/fotoberkas/sim';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '10000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_sim')) {
                    if ($data['foto_sim'] != 'noimage.jpg') {
                        $gambar = $data['foto_sim'];
                        unlink('images/fotoberkas/sim/' . $gambar);
                    }

                    $foto_sim = html_escape($this->upload->data('file_name'));
                } else {
                    $foto_sim = $data['foto_sim'];
                }
            }

            $data = [
                'foto_ktp'           => $foto_ktp,
                'foto_sim'           => $foto_sim,
                'id_sim'           => html_escape($this->input->post('id_sim', TRUE)),
                'id'               => html_escape($this->input->post('id', TRUE))
            ];

            $data2 = [
                'no_ktp'           => html_escape($this->input->post('no_ktp', TRUE)),
                'id'               => html_escape($this->input->post('id', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/detail/' . $id);
            } else {
                $this->driver->ubahdatacard($data, $data2);
                $this->session->set_flashdata('ubah', 'Driver Licence Has Been Changed');
                redirect('driver/detail/' . $id);
            }
        } else {
            $data['driver'] = $this->driver->getdriverbyid($id);
            $data['currency'] = $this->app->getappbyid();
            $data['countorder'] = $this->driver->countorder($id);

            $this->load->view('includes/header');
            $this->load->view('drivers/detail', $data);
            $this->load->view('includes/footer');
        }
    }

    public function hapus($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('driver/index');
        } else {
            $data = $this->driver->getdriverbyid($id);
            $gambar = $data['foto'];
            $gambarsim = $data['foto_sim'];
            $gambarktp = $data['foto_ktp'];
            unlink('images/fotodriver/' . $gambar);
            unlink('images/fotoberkas/ktp/' . $gambarktp);
            unlink('images/fotoberkas/sim/' . $gambarsim);
            $this->session->set_flashdata('hapus', 'Driver Has Been Deleted');
            $this->driver->hapusdriverbyid($id);

            redirect('driver');
        }
    }

    public function tambah()
    {

        $phone = html_escape($this->input->post('phone', TRUE));
        $email = html_escape($this->input->post('email', TRUE));

        // $check_exist = $this->Pelanggan_model->check_exist($email, $phone);
        // $check_exist_phone = $this->Pelanggan_model->check_exist_phone($phone);
        // $check_exist_email = $this->Pelanggan_model->check_exist_email($email);
        // if ($check_exist) {

        //     $this->session->set_flashdata('invalid', 'phone or email has been used');
        //     redirect('users/tambah');
        // } else if ($check_exist_phone) {

        //     $this->session->set_flashdata('invalid', 'phone has been used');
        //     redirect('users/tambah');
        // } else if ($check_exist_email) {

        //     $this->session->set_flashdata('invalid', 'email has been used');
        //     redirect('users/tambah');
        // } else {

        $this->form_validation->set_rules('nama_driver', 'nama_driver', 'trim|prep_for_form');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|prep_for_form|is_unique[driver.phone]');
        $this->form_validation->set_rules('email', 'Email', 'trim|prep_for_form|is_unique[driver.email]');
        $this->form_validation->set_rules('password', 'password', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            if (@$_FILES['foto']['name']) {

                $config['upload_path']     = './images/fotodriver/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '10000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {

                    $foto = html_escape($this->upload->data('file_name'));
                } else {
                    $foto = 'noimage.jpg';
                }
            }

            if ($this->form_validation->run() == TRUE) {
                if (@$_FILES['foto_sim']['name']) {

                    $config['upload_path']     = './images/fotoberkas/sim';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']         = '10000';
                    $config['file_name']     = 'name';
                    $config['encrypt_name']     = true;
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('foto_sim')) {

                        $fotosim = html_escape($this->upload->data('file_name'));
                    } else {
                        $fotosim = 'noimage.jpg';
                    }
                }
            }

            if ($this->form_validation->run() == TRUE) {
                if (@$_FILES['foto_ktp']['name']) {

                    $config['upload_path']     = './images/fotoberkas/ktp';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']         = '10000';
                    $config['file_name']     = 'name';
                    $config['encrypt_name']     = true;
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('foto_ktp')) {

                        $fotoktp = html_escape($this->upload->data('file_name'));
                    } else {
                        $fotoktp = 'noimage.jpg';
                    }
                }
            }


            $countrycode = html_escape($this->input->post('countrycode', TRUE));
            $id = 'D' . time();


            $datasignup             = [

                'id'                        => $id,
                'phone'                     => html_escape($this->input->post('phone', TRUE)),
                'countrycode'               => html_escape($this->input->post('countrycode', TRUE)),
                'tgl_lahir'                 => html_escape($this->input->post('tgl_lahir', TRUE)),
                'reg_id'                    => 'R' . time(),
                'foto'                      => $foto,
                'password'                   => sha1(time()),
                'nama_driver'               => html_escape($this->input->post('nama_driver', TRUE)),
                'no_telepon'                => str_replace("+", "", $countrycode) . $phone,
                'email'                     => html_escape($this->input->post('email', TRUE)),
                'gender'                    => html_escape($this->input->post('gender', TRUE)),
                'alamat_driver'             => html_escape($this->input->post('alamat_driver', TRUE)),
                'job'                       => html_escape($this->input->post('job', TRUE)),
                'no_ktp'                    => html_escape($this->input->post('no_ktp', TRUE))

            ];



            $datakendaraan             = [

                'merek'                     => html_escape($this->input->post('merek', TRUE)),
                'tipe'                      => html_escape($this->input->post('tipe', TRUE)),
                'warna'                     => html_escape($this->input->post('warna', TRUE)),
                'nomor_kendaraan'           => html_escape($this->input->post('nomor_kendaraan', TRUE))

            ];

            $databerkas             = [

                'id_driver'                 => $id,
                'foto_sim'                  => $fotosim,
                'foto_ktp'                  => $fotoktp,
                'id_sim'                    => html_escape($this->input->post('id_sim', TRUE))

            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('driver/tambah');
            } else {

                $this->driver->signup($datasignup, $datakendaraan, $databerkas);
                $this->session->set_flashdata('tambah', 'Driver Has Been Added');
                redirect('newregistration/index');
            }
        } else {
            $data['driverjob'] = $this->driver->driverjob();
            $this->load->view('includes/header');
            $this->load->view('drivers/tambahdriver', $data);
            $this->load->view('includes/footer');
        }
        // }

    }
}
