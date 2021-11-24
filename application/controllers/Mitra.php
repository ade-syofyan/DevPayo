<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mitra extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }

        $this->load->model('Pelanggan_model');
        $this->load->model('mitra_model', 'mitra');
        $this->load->model('appsettings_model', 'app');
        $this->load->model('email_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['mitra'] = $this->mitra->getallmitra();
        $data['mitrabyagent'] = $this->mitra->getallmitrabyagent();
        // var_dump($data['mitrabyagent']);die;

        $this->load->view('includes/header');
        $this->load->view('mitra/index', $data);
        $this->load->view('includes/footer');
    }

    public function detail($id)
    {
        $data['mitra'] = $this->mitra->getmitrabyid($id);
        $data['item'] = $this->mitra->getitembyid($data['mitra']['id_merchant']);
        $data['itemk'] = $this->mitra->getitemkbyid($data['mitra']['id_merchant']);
        $data['currency'] = $this->app->getappbyid();
        $data['countorder'] = $this->mitra->countorder($data['mitra']['id_merchant']);
        $data['wallet'] = $this->mitra->wallet($id);
        $data['jumlah'] = count($data['item']);
        $data['merchantk'] = $this->mitra->getmerchantk();
        $data['transaksi'] = $this->mitra->gettranshistory($data['mitra']['id_merchant']);
        $data['fitur'] = $this->mitra->get_fitur_merchant();

        $this->load->view('includes/header');
        $this->load->view('mitra/detail', $data);
        $this->load->view('includes/footer');
    }

    public function block($id)
    {
        $this->mitra->blockmitrabyid($id);
        redirect('mitra');
    }

    public function unblock($id)
    {
        $this->mitra->unblockmitrabyid($id);
        redirect('mitra');
    }

    public function tambahitem()
    {
        $this->form_validation->set_rules('nama_item', 'nama_item', 'trim|prep_for_form');
        $this->form_validation->set_rules('harga_item', 'harga_item', 'trim|prep_for_form');
        $this->form_validation->set_rules('deskripsi_item', 'deskripsi_item', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            if (@$_FILES['foto_item']['name']) {

                $config['upload_path']     = './images/itemmerchant';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '30000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_item')) {

                    $fotoitem = html_escape($this->upload->data('file_name'));
                } else {
                    $fotoitem = 'noimage.jpg';
                }

                if ($this->input->post('status_promo') == 1) {
                    $promo = html_escape($this->input->post('harga_promo', TRUE));
                } else {
                    $promo = '0';
                }
                $id = $this->input->post('id_mitra');
                $hargaitem = html_escape($this->input->post('harga_item', TRUE));
                $hargapromo = $promo;

                $remove = array(".", ",");
                $add = array("", "");
                $data = [
                    'kategori_item'     => html_escape($this->input->post('kategori_item', TRUE)),
                    'nama_item'         => html_escape($this->input->post('nama_item', TRUE)),
                    'harga_item'        => str_replace($remove, $add, $hargaitem),
                    'harga_promo'       => str_replace($remove, $add, $hargapromo),
                    'id_merchant'       => html_escape($this->input->post('id_merchant', TRUE)),
                    'deskripsi_item'    => html_escape($this->input->post('deskripsi_item', TRUE)),
                    'status_item'       => html_escape($this->input->post('status_item', TRUE)),
                    'status_promo'      => html_escape($this->input->post('status_promo', TRUE)),
                    'foto_item'         => $fotoitem
                ];
                if (demo == TRUE) {
                    $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                    redirect('mitra/detail/' . $id);
                } else {
                    $this->mitra->insertitem($data);
                    $this->session->set_flashdata('tambah', 'Item Has Been Added');
                    redirect('mitra/detail/' . $id);
                }
            }
        } else {
            $id = $this->input->post('id_mitra');
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $id);
            $this->load->view('includes/footer');
        }
    }

    public function ubahitem($id)
    {

        $idmerchant = $this->input->post('id_merchant');
        $mitra = $this->mitra->getidmitra($idmerchant);

        $idm = $mitra['id_mitra'];

        $this->form_validation->set_rules('nama_item', 'nama_item', 'trim|prep_for_form');
        $this->form_validation->set_rules('harga_item', 'harga_item', 'trim|prep_for_form');
        $this->form_validation->set_rules('deskripsi_item', 'deskripsi_item', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {



            if (@$_FILES['foto_item']['name']) {

                $config['upload_path']     = './images/itemmerchant';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '30000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                $foto = $this->mitra->getfotoitem($id);


                if ($this->upload->do_upload('foto_item')) {

                    $fotoitem = $this->upload->data('file_name');
                    $fotolama = $foto['foto_item'];
                    unlink('images/itemmerchant/' . $fotolama);
                } else {
                    $fotolama = $foto['foto_item'];
                    $fotoitem = $fotolama;
                }


                if ($this->input->post('status_promo') == 1) {
                    $promo = html_escape($this->input->post('harga_promo', TRUE));
                } else {
                    $promo = '0';
                }

                $hargaitem = html_escape($this->input->post('harga_item', TRUE));
                $hargapromo = $promo;

                $remove = array(".", ",");
                $add = array("", "");



                $data = [
                    'kategori_item'     => html_escape($this->input->post('kategori_item', TRUE)),
                    'nama_item'         => html_escape($this->input->post('nama_item', TRUE)),
                    'harga_item'        => str_replace($remove, $add, $hargaitem),
                    'harga_promo'       => str_replace($remove, $add, $hargapromo),
                    'id_merchant'       => html_escape($this->input->post('id_merchant', TRUE)),
                    'deskripsi_item'    => html_escape($this->input->post('deskripsi_item', TRUE)),
                    'status_item'       => html_escape($this->input->post('status_item', TRUE)),
                    'status_promo'      => html_escape($this->input->post('status_promo', TRUE)),
                    'foto_item'         => $fotoitem

                ];
                if (demo == TRUE) {
                    $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                    redirect('mitra/detail/' . $idm);
                } else {

                    $this->mitra->updateitem($data, $id);
                    $this->session->set_flashdata('ubah', 'Item Has Been Changed');
                    redirect('mitra/detail/' . $idm);
                }
            } else {

                $foto = $this->mitra->getfotoitem($id);
                $fotolama = $foto['foto_item'];

                if ($this->input->post('status_promo') == 1) {
                    $promo = html_escape($this->input->post('harga_promo', TRUE));
                } else {
                    $promo = '0';
                }

                $hargaitem = html_escape($this->input->post('harga_item', TRUE));
                $hargapromo = $promo;

                $remove = array(".", ",");
                $add = array("", "");
                $data = [
                    'kategori_item'     => html_escape($this->input->post('kategori_item', TRUE)),
                    'nama_item'         => html_escape($this->input->post('nama_item', TRUE)),
                    'harga_item'        => str_replace($remove, $add, $hargaitem),
                    'harga_promo'       => str_replace($remove, $add, $hargapromo),
                    'id_merchant'       => html_escape($this->input->post('id_merchant', TRUE)),
                    'deskripsi_item'    => html_escape($this->input->post('deskripsi_item', TRUE)),
                    'status_item'       => html_escape($this->input->post('status_item', TRUE)),
                    'status_promo'      => html_escape($this->input->post('status_promo', TRUE)),
                    'foto_item'         => $fotolama
                ];
                if (demo == TRUE) {
                    $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                    redirect('mitra/detail/' . $idm);
                } else {

                    $this->mitra->updateitem($data, $id);
                    $this->session->set_flashdata('ubah', 'Item Has Been Changed');
                    redirect('mitra/detail/' . $idm);
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $idm);
            $this->load->view('includes/footer');
        }
    }

    public function hapusitem($id)
    {
        $data = $this->mitra->getfotoitem($id);
        $idmerchant = $data['id_merchant'];
        $idmitra = $this->mitra->getidmitra($idmerchant);
        $idm = $idmitra['id_mitra'];
        $gambar = $data['foto_item'];
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('mitra/detail/' . $idm);
        } else {

            unlink('images/itemmerchant/' . $gambar);

            $this->mitra->hapusitembyid($id);
            $this->session->set_flashdata('hapus', 'Item Has Been Deleted');
            redirect('mitra/detail/' . $idm);
        }
    }

    public function ubahmerchant($id)
    {
        $this->form_validation->set_rules('nama_merchant', 'nama_merchant', 'trim|prep_for_form');
        $this->form_validation->set_rules('alamat_merchant', 'alamat_merchant', 'trim|prep_for_form');
        $datafitur['fitur'] = $this->mitra->get_fitur_merchant();
        if ($this->form_validation->run() == TRUE) {



            $merchant = $this->mitra->getmerchantdetail($this->input->post('id_merchant'));
            $fotomerchant = $merchant['foto_merchant'];
            if (@$_FILES['foto_merchant']['name']) {

                $config['upload_path']     = './images/merchant';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '30000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_merchant')) {

                    $fotobarumerchant = $this->upload->data('file_name');
                    unlink('images/itemmerchant/' . $fotomerchant);
                } else {
                    $fotobarumerchant = $fotomerchant;
                }

                $data = [
                    'id_merchant'               => html_escape($this->input->post('id_merchant', TRUE)),
                    'id_fitur'                  => html_escape($this->input->post('id_fitur', TRUE)),
                    'nama_merchant'             => html_escape($this->input->post('nama_merchant', TRUE)),
                    'category_merchant'         => html_escape($this->input->post('category_merchant', TRUE)),
                    'alamat_merchant'           => html_escape($this->input->post('alamat_merchant', TRUE)),
                    'latitude_merchant'         => html_escape($this->input->post('latitude_merchant', TRUE)),
                    'longitude_merchant'        => html_escape($this->input->post('longitude_merchant', TRUE)),
                    'jam_buka'                  => html_escape($this->input->post('jam_buka', TRUE)),
                    'jam_tutup'                 => html_escape($this->input->post('jam_tutup', TRUE)),
                    'foto_merchant'             => $fotobarumerchant
                ];


                if (demo == TRUE) {
                    $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                    redirect('mitra/detail/' . $id);
                } else {

                    $this->mitra->updatemerchant($data);
                    $this->session->set_flashdata('ubah', 'Merchant Has Been Changed');
                    redirect('mitra/detail/' . $id);
                }
            } else {

                $data = [
                    'id_merchant'               => html_escape($this->input->post('id_merchant', TRUE)),
                    'id_fitur'                  => html_escape($this->input->post('id_fitur', TRUE)),
                    'nama_merchant'             => html_escape($this->input->post('nama_merchant', TRUE)),
                    'category_merchant'         => html_escape($this->input->post('category_merchant', TRUE)),
                    'alamat_merchant'           => html_escape($this->input->post('alamat_merchant', TRUE)),
                    'latitude_merchant'         => html_escape($this->input->post('latitude_merchant', TRUE)),
                    'longitude_merchant'        => html_escape($this->input->post('longitude_merchant', TRUE)),
                    'jam_buka'                  => html_escape($this->input->post('jam_buka', TRUE)),
                    'jam_tutup'                 => html_escape($this->input->post('jam_tutup', TRUE)),
                    'foto_merchant'             => $fotomerchant
                ];


                if (demo == TRUE) {
                    $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                    redirect('mitra/detail/' . $id);
                } else {

                    $this->mitra->updatemerchant($data);

                    $this->session->set_flashdata('ubah', 'Merchant Has Been Changed');
                    redirect('mitra/detail/' . $id);
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $id, $datafitur);
            $this->load->view('includes/footer');
        }
    }

    public function hapuscategoryitem($id)
    {
        $mitra = $this->mitra->getidmitrabycategory($id);
        $idm = $mitra['id_mitra'];

        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('mitra/detail/' . $idm);
        } else {
            $this->mitra->hapuskategoryitembyid($id);
            $this->session->set_flashdata('hapus', 'Item Category Has Been Deleted');
            redirect('mitra/detail/' . $idm);
        }
    }

    public function tambahcategoryitem()
    {

        $this->form_validation->set_rules('nama_kategori_item', 'nama_kategori_item', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {

            $idm = $this->input->post('id_merchant');
            $data = [
                'nama_kategori_item'    => html_escape($this->input->post('nama_kategori_item', TRUE)),
                'id_merchant'           => html_escape($this->input->post('id_mitra', TRUE)),
                'all_category'          => '0'
            ];

            $this->mitra->tambahkategoryitembyid($data);
            $this->session->set_flashdata('tambah', 'Item Category Has Been Added');
            redirect('mitra/detail/' . $idm);
        } else {
            $idm = $this->input->post('id_merchant');
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $idm);
            $this->load->view('includes/footer');
        }
    }

    public function ubahcategoryitem()
    {
        $this->form_validation->set_rules('nama_kategori_item', 'nama_kategori_item', 'trim|prep_for_form');
        if ($this->form_validation->run() == TRUE) {

            $idm = $this->input->post('id_mitra');
            $id = $this->input->post('id_kategori_item');
            $data = [
                'nama_kategori_item'    => html_escape($this->input->post('nama_kategori_item', TRUE)),
            ];
            $this->mitra->ubahkategoryitembyid($data, $id);
            $this->session->set_flashdata('ubah', 'Item Category Has Been Updated');
            redirect('mitra/detail/' . $idm);
        } else {
            $idm = $this->input->post('id_mitra');
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $idm);
            $this->load->view('includes/footer');
        }
    }

    public function editmitradetail()
    {
        $this->form_validation->set_rules('nama_mitra', 'nama_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('alamat_mitra', 'alamat_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('email_mitra', 'email_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('countrycode', 'countrycode', 'trim|prep_for_form');
        $this->form_validation->set_rules('phone', 'phone', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            $idm = $this->input->post('id_mitra');
            $phone       = html_escape($this->input->post('phone_mitra', TRUE));
            $countrycode = html_escape($this->input->post('country_code_mitra', TRUE));
            $remove = array("+", "-");

            $data = [
                'nama_mitra'                => html_escape($this->input->post('nama_mitra', TRUE)),
                'alamat_mitra'              => html_escape($this->input->post('alamat_mitra', TRUE)),
                'email_mitra'               => html_escape($this->input->post('email_mitra', TRUE)),
                'partner'                   => $this->input->post('partner'),
                'phone_mitra'               => $phone,
                'country_code_mitra'        => $countrycode,
                'telepon_mitra'             => str_replace($remove, '', $countrycode) . $phone,
            ];
            $datamerchant = [
                'id_merchant'               => html_escape($this->input->post('id_merchant', TRUE)),
                'phone_merchant'               => $phone,
                'country_code_merchant'        => $countrycode,
                'telepon_merchant'             => str_replace($remove, '', $countrycode) . $phone,
            ];
            $this->mitra->ubahmitrabyid($data, $idm);
            $this->mitra->updatemerchant($datamerchant);
            $this->session->set_flashdata('ubah', 'Mitra Has Been Updated');
            redirect('mitra/detail/' . $idm);
        } else {
            $idm = $this->input->post('id_mitra');
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $idm);
            $this->load->view('includes/footer');
        }
    }

    public function editmitrafile()
    {
        $this->form_validation->set_rules('jenis_identitas_mitra', 'jenis_identitas_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('nomor_identitas_mitra', 'nomor_identitas_mitra', 'trim|prep_for_form');

        $id = $this->input->post('id_mitra');

        if ($this->form_validation->run() == TRUE) {

            $foto = $this->mitra->getmitrabyid($id);
            $fotoktp = $foto['foto_ktp'];

            if (@$_FILES['foto_ktp']['name']) {

                $config['upload_path']     = './images/fotoberkas/ktp';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '30000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_ktp')) {

                    $fotobaruktp = $this->upload->data('file_name');
                    unlink('images/fotoberkas/ktp/' . $fotoktp);
                } else {
                    $fotobaruktp = $fotoktp;
                }

                $data = [
                    'jenis_identitas_mitra'     => html_escape($this->input->post('jenis_identitas_mitra', TRUE)),
                    'nomor_identitas_mitra'     => html_escape($this->input->post('nomor_identitas_mitra', TRUE)),
                    'foto_ktp'                  => $fotobaruktp
                ];

                $this->mitra->ubahfilemitrabyid($data, $id);
                $this->session->set_flashdata('ubah', 'Mitra files Has Been Updated');
                redirect('mitra/detail/' . $id);
            } else {
                $data = [
                    'jenis_identitas_mitra'     => html_escape($this->input->post('jenis_identitas_mitra', TRUE)),
                    'nomor_identitas_mitra'     => html_escape($this->input->post('nomor_identitas_mitra', TRUE)),
                    'foto_ktp'                  => $fotoktp
                ];

                $this->mitra->ubahfilemitrabyid($data, $id);
                $this->session->set_flashdata('ubah', 'Mitra files Has Been Updated');
                redirect('mitra/detail/' . $id);
            }
        } else {
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $id);
            $this->load->view('includes/footer');
        }
    }

    public function editmitrapass()
    {
        $this->form_validation->set_rules('password', 'password', 'trim|prep_for_form');
        $idm = $this->input->post('id_mitra');
        if ($this->form_validation->run() == TRUE) {
            $pass = html_escape($this->input->post('password', TRUE));
            $data = [
                'password'                => sha1($pass),
            ];

            $this->mitra->ubahpassmitrabyid($data, $idm);
            $this->session->set_flashdata('ubah', 'Mitra password Has Been Updated');
            redirect('mitra/detail/' . $idm);
        } else {
            $this->session->set_flashdata('gagal', 'Error, Please Try Again');
            $this->load->view('includes/header');
            $this->load->view('mitra/detail/' . $idm);
            $this->load->view('includes/footer');
        }
    }

    public function hapus($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('mitra/detail/' . $id);
        } else {
            $berkas = $this->mitra->getberkasbyid($id);
            $fotoktp = $berkas['foto_ktp'];
            unlink('images/fotoberkas/ktp/' . $fotoktp);


            $this->mitra->hapusmitrabyid($id);
            $this->session->set_flashdata('hapus', 'Owner Merchant Has Been Deleted');
            redirect('mitra');
        }
    }

    public function newregmitra()
    {
        $data['mitra'] = $this->mitra->getallmitra();
        $data['merchantk'] = $this->mitra->getmerchantk();
        $data['fitur'] = $this->mitra->get_fitur_merchant();
        $this->load->view('includes/header');
        $this->load->view('mitra/newreg', $data);
        $this->load->view('includes/footer');
    }

    public function confirmmitra($id)
    {
        $this->mitra->ubahstatusmitra($id);

        $item = $this->app->getappbyid();

        $token = sha1(rand(0, 999999) . time());

        $dataforgot = array(
            'userid' => $id,
            'token' => $token,
            'idKey' => '3'
        );
        $this->Pelanggan_model->dataforgot($dataforgot);

        $linkbtn = base_url() . 'resetpass/rest/' . $token . '/3';
        $judul_email = $item['email_subject_confirm'] . '[ticket-' . rand(0, 999999) . ']';
        $template = $this->Pelanggan_model->template1($item['email_subject_confirm'], $item['email_text3'], $item['email_text4'], $item['app_website'], $item['app_name'], $linkbtn, $item['app_linkgoogle'], $item['app_address']);
        $email = $this->mitra->getmitrabyid($id);
        $emailuser = $email['email_mitra'];
        $host = $item['smtp_host'];
        $port = $item['smtp_port'];
        $username = $item['smtp_username'];
        $password = $item['smtp_password'];
        $from = $item['smtp_from'];
        $appname = $item['app_name'];
        $secure = $item['smtp_secure'];

        $this->email_model->emailsend($judul_email, $emailuser, $template, $host, $port, $username, $password, $from, $appname, $secure);
        $this->session->set_flashdata('ubah', 'Mitra Has Been Confirm');
        redirect('mitra');
    }

    public function tambahmitra()
    {


        $this->form_validation->set_rules('nama_mitra', 'nama_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('alamat_mitra', 'alamat_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('email_mitra', 'email_mitra', 'trim|prep_for_form|is_unique[mitra.email_mitra]');
        $this->form_validation->set_rules('phone_mitra', 'phone_mitra', 'trim|prep_for_form|is_unique[mitra.phone_mitra]');
        $this->form_validation->set_rules('country_code_mitra', 'country_code_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('jenis_identitas_mitra', 'jenis_identitas_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('nomor_identitas_mitra', 'nomor_identitas_mitra', 'trim|prep_for_form');
        $this->form_validation->set_rules('nama_merchant', 'nama_merchant', 'trim|prep_for_form');
        $this->form_validation->set_rules('id_fitur', 'id_fitur', 'trim|prep_for_form');
        $this->form_validation->set_rules('category_merchant', 'category_merchant', 'trim|prep_for_form');
        $this->form_validation->set_rules('alamat_merchant', 'alamat_merchant', 'trim|prep_for_form');
        $this->form_validation->set_rules('jam_buka', 'jam_buka', 'trim|prep_for_form');
        $this->form_validation->set_rules('jam_tutup', 'jam_tutup', 'trim|prep_for_form');

        if ($this->input->post('category_merchant') == NUll) {
            $this->session->set_flashdata('gagal', 'Please Add Category Merchant First');
            redirect('mitra/newregmitra');
        }

        if ($this->form_validation->run() == TRUE) {

            if (@$_FILES['foto_merchant']['name']) {

                $config['upload_path']     = './images/merchant';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']         = '30000';
                $config['file_name']     = 'name';
                $config['encrypt_name']     = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto_merchant')) {

                    $fotomerchant = html_escape($this->upload->data('file_name'));
                }


                if ($this->form_validation->run() == TRUE) {
                    if (@$_FILES['katepe']['name']) {

                        $config['upload_path']     = './images/fotoberkas/ktp';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size']         = '30000';
                        $config['file_name']     = 'name';
                        $config['encrypt_name']     = true;
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('katepe')) {
                            $fotoktp = html_escape($this->upload->data('file_name'));
                        }
                    }
                }
            }

            $countrycode = html_escape($this->input->post('country_code_mitra', TRUE));
            $phone = html_escape($this->input->post('phone_mitra', TRUE));
            $id = 'M' . time();

            $datamerchant = [
                'id_fitur'                              => html_escape($this->input->post('id_fitur', TRUE)),
                'nama_merchant'                         => html_escape($this->input->post('nama_merchant', TRUE)),
                'alamat_merchant'                       => html_escape($this->input->post('alamat_merchant', TRUE)),
                'latitude_merchant'                     => html_escape($this->input->post('latitude_merchant', TRUE)),
                'longitude_merchant'                    => html_escape($this->input->post('longitude_merchant', TRUE)),
                'jam_buka'                              => html_escape($this->input->post('jam_buka', TRUE)),
                'jam_tutup'                             => html_escape($this->input->post('jam_tutup', TRUE)),
                'category_merchant'                     => html_escape($this->input->post('category_merchant', TRUE)),
                'foto_merchant'                         => $fotomerchant,
                'telepon_merchant'                      => str_replace("+", "", $countrycode) . $phone,
                'country_code_merchant'                 => $countrycode,
                'phone_merchant'                        => $phone,
                'status_merchant'                       => '0',
                'token_merchant'                        => sha1(time())
            ];

            $idmerchant = $this->mitra->insertmerchant($datamerchant);

            $datamitra = [
                'id_mitra'                          => $id,
                'nama_mitra'                        => html_escape($this->input->post('nama_mitra', TRUE)),
                'jenis_identitas_mitra'             => html_escape($this->input->post('jenis_identitas_mitra', TRUE)),
                'nomor_identitas_mitra'             => html_escape($this->input->post('nomor_identitas_mitra', TRUE)),
                'alamat_mitra'                      => html_escape($this->input->post('alamat_mitra', TRUE)),
                'email_mitra'                       => html_escape($this->input->post('email_mitra', TRUE)),
                'password'                          => sha1(time()),
                'telepon_mitra'                     => str_replace("+", "", $countrycode) . $phone,
                'country_code_mitra'                => $countrycode,
                'phone_mitra'                       => $phone,
                'id_merchant'                       => $idmerchant,
                'partner'                           => '0',
                'status_mitra'                      => '0'
            ];

            $databerkas = [
                'id_driver'                          => $id,
                'foto_ktp'                          => $fotoktp,
            ];

            $datasaldo = [
                'id_user' => $id,
                'saldo' => 0
            ];

            $this->mitra->tambahkanmitra($datamitra, $databerkas, $datasaldo);
            $this->session->set_flashdata('tambah', 'Merchant Has Been Added');
            redirect('mitra/newregmitra');
        } else {

            $data['mitra'] = $this->mitra->getallmitra();
            $data['merchantk'] = $this->mitra->getmerchantk();

            $this->load->view('includes/header');
            $this->load->view('mitra/newreg', $data);
            $this->load->view('includes/footer');
        }
    }

    public function edititem($id)
    {
        $data['item'] = $this->mitra->getitembyiditem($id);
        $data['itemk'] = $this->mitra->getitemkbyid($data['item']['id_merchant']);
        $data['currency'] = $this->app->getappbyid();


        $this->load->view('includes/header');
        $this->load->view('mitra/edititem', $data);
        $this->load->view('includes/footer');
    }
}
