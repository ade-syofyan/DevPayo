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
        $this->load->helper('tanggal_rupiah_helper');
        $this->load->model('agent_model', 'agenmodel');
        $this->load->model('Users_model', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
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


        $nik      = html_escape($this->input->post('nik', TRUE));
        $username = html_escape($this->input->post('user_name', TRUE));
        $fullname = html_escape($this->input->post('fullname', TRUE));
        $password = html_escape($this->input->post('password', TRUE));
        $email    = html_escape($this->input->post('email', TRUE));
        $province = html_escape($this->input->post('province', TRUE));
        $regency  = html_escape($this->input->post('regency', TRUE));
        $district = html_escape($this->input->post('district', TRUE));
        $village  = html_escape($this->input->post('village', TRUE));
        $alamat   = html_escape($this->input->post('address', TRUE));
        $this->form_validation->set_rules('nik', 'NIK', 'trim|prep_for_form|is_unique[admin.nik]');
        $this->form_validation->set_rules('user_name', 'NAME', 'trim|prep_for_form');
        $this->form_validation->set_rules('phone', 'PHONE', 'trim|prep_for_form|is_unique[admin.phone]');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|prep_for_form|is_unique[admin.email]');
        $this->form_validation->set_rules('password', 'PASSWORD', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            $config['upload_path']     = './images/agent/';
            $config['allowed_types']   = 'gif|jpg|png|jpeg';
            $config['max_size']        = '10000';
            $config['file_name']       = 'name';
            $config['encrypt_name']    = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {

                $foto = html_escape($this->upload->data('file_name'));
            } else {
                $foto = 'noimage.jpg';
            }
            if ($this->upload->do_upload('ktp')) {

                $ktp = html_escape($this->upload->data('file_name'));
            } else {
                $ktp = 'noimage.jpg';
            }
            if ($this->upload->do_upload('selfie')) {

                $selfie = html_escape($this->upload->data('file_name'));
            } else {
                $selfie = 'noimage.jpg';
            }
            $data             = [

                'foto_ktp'                  => $ktp,
                'foto_selfie_ktp'           => $selfie,
                'nik'                       => $nik,
                'user_name'                 => $username,
                'nama_lengkap'              => $fullname,
                'password'                  => sha1($password),
                'email'                     => $email,
                'countryCode'               => html_escape($this->input->post('countrycode', TRUE)),
                'phone'                     => html_escape($this->input->post('phone', TRUE)),
                'province_id'               => $province,
                'regency_id'                => $regency,
                'district_id'               => $district,
                'village_id'                => $village,
                'alamat'                    => $alamat,
                'image'                     => $foto,
                'level_id'                  => 2,
                'status'                    => 'A'

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

    public function get_district()
    {
        $id = $this->input->post('id');
        $data = $this->agenmodel->getDataDis($id);
        echo json_encode($data);
    }

    public function get_village()
    {
        $id = $this->input->post('id');
        $data = $this->agenmodel->getDataVillage($id);
        echo json_encode($data);
    }

    public function detail($id)
    {
        $data = $this->user->getcurrency();
        $data['agent']  = $this->agenmodel->getagentbyid($id);
        $data['prov']   = $this->agenmodel->getDataProv();
        $data['komisi'] = $this->agenmodel->komisi($id);

        $this->load->view('includes/header');
        $this->load->view('agen/detail', $data);
        $this->load->view('includes/footer');
    }

    public function ubahinfo()
    {
        $username = html_escape($this->input->post('user_name', TRUE));
        $fullname = html_escape($this->input->post('nama_lengkap', TRUE));
        $email    = html_escape($this->input->post('email', TRUE));
        $province = html_escape($this->input->post('province', TRUE));
        $regency  = html_escape($this->input->post('regency', TRUE));
        $district = html_escape($this->input->post('district', TRUE));
        $village  = html_escape($this->input->post('village', TRUE));
        $alamat   = html_escape($this->input->post('alamat', TRUE));

        $this->form_validation->set_rules('nama_lengkap', 'nama_lengkap', 'trim|prep_for_form');
        $this->form_validation->set_rules('phone', 'PHONE', 'trim|prep_for_form');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            $data = [
                // 'foto_ktp'            => $ktp,
                // 'foto_selfie_ktp'     => $selfie,
                // 'nik'                 => $nik,
                'id'                  => html_escape($this->input->post('id', TRUE)),
                'user_name'           => $username,
                'nama_lengkap'        => $fullname,
                // 'password'            => sha1($password),
                'email'               => $email,
                'countryCode'         => html_escape($this->input->post('countrycode', TRUE)),
                'phone'               => html_escape($this->input->post('phone', TRUE)),
                'province_id'         => $province,
                'regency_id'          => $regency,
                'district_id'         => $district,
                'village_id'          => $village,
                'alamat'              => $alamat,
                // 'image'               => $foto,
            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('agent/detail/' . $this->input->post('id', TRUE));
            } else {
                $id = html_escape($this->input->post('id', TRUE));
                $this->agenmodel->ubahdatainfo($data);
                $this->session->set_flashdata('ubah', 'Agent Info Has Been Changed');
                redirect('agent/detail/' . $id);
            }
        } else {
            $data = $this->user->getcurrency();
            $data['agent']  = $this->agenmodel->getagentbyid($id);
            $data['prov']   = $this->agenmodel->getDataProv();
            $data['komisi'] = $this->agenmodel->komisi($id);

            $this->load->view('includes/header');
            $this->load->view('Agen/detail/' . $data);
            $this->load->view('includes/footer');
        }
    }

    public function ubahfoto()
    {

        $config['upload_path']     = './images/agent/';
        $config['allowed_types']   = 'gif|jpg|png|jpeg';
        $config['max_size']        = '10000';
        $config['file_name']       = 'name';
        $config['encrypt_name']    = true;
        $this->load->library('upload', $config);

        $id = $id = html_escape($this->input->post('id', TRUE));
        $data = $this->agenmodel->getagentbyid($id);
        // var_dump($data);die;

        if ($this->upload->do_upload('image')) {
            if ($data['image'] != 'noimage.jpg') {
                $gambar = $data['image'];
                unlink('images/agent/' . $gambar);
            }

            $foto = html_escape($this->upload->data('file_name'));

            $data = [
                'image' => $foto,
                'id'    => html_escape($this->input->post('id', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('agent/detail/' . $id);
            } else {
                $this->agenmodel->ubahdatafoto($data);
                $this->session->set_flashdata('ubah', 'Agent Image Has Been Change');
                redirect('agent/detail/' . $id);
            }
        } else {

            $data = $this->user->getcurrency();
            $data['agent']  = $this->agenmodel->getagentbyid($id);
            $data['prov']   = $this->agenmodel->getDataProv();
            $data['komisi'] = $this->agenmodel->komisi($id);

            $this->load->view('includes/header');
            $this->load->view('agen/detail', $data);
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

            $data = [
                'id'       => html_escape($this->input->post('id', TRUE)),
                'password' => $dataencrypt
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('agent/detail/' . $id);
            } else {

                $this->agenmodel->ubahdatapassword($data);
                $this->session->set_flashdata('ubah', 'Agent Password Has Been Changed');
                redirect('agent/detail/' . $id);
            }
        } else {
            $data = $this->user->getcurrency();
            $data['agent']  = $this->agenmodel->getagentbyid($id);
            $data['prov']   = $this->agenmodel->getDataProv();
            $data['komisi'] = $this->agenmodel->komisi($id);

            $this->load->view('includes/header');
            $this->load->view('agen/detail', $data);
            $this->load->view('includes/footer');
        }
    }


    public function hapus($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('agent/index');
        } else {
            $data = $this->agenmodel->getagentbyid($id);
            $foto = $data['image'];
            unlink('images/agent/' . $foto);
            $ktp = $data['foto_ktp'];
            unlink('images/agent/' . $ktp);
            $selfie = $data['foto_selfie_ktp'];
            unlink('images/agent/' . $selfie);

            $this->agenmodel->hapus($id);

            $this->session->set_flashdata('hapus', 'User Has Been Deleted');
            redirect('agent/index');
        }
    }

    public function transferkomisi()
    {
        $data['currency'] = $this->user->getcurrency();
        $data['data']     = $this->agenmodel->getDataAgent();


        if ($_POST != NULL) {
            // $saldo = html_escape($this->input->post('saldo', TRUE));
            // $remove = array(".", ",");
            // $add = array("", "");
            $data = [
                'id_user'   => $this->input->post('idagent'),
                // 'jumlah'    => str_replace($remove, $add, $saldo),
                'jumlah' => $this->input->post('jumlah')
            ];


            $this->agenmodel->updatesaldowallet($data);
            $this->session->set_flashdata('ubah', 'Top Up Has Been Added');
            redirect('agent/komisi');
        } else {
            $this->load->view('includes/header');
            $this->load->view('agen/transferkomisi', $data);
            $this->load->view('includes/footer');
        }
    }

    public function komisi()
    {

        $idarr = $this->agenmodel->getIdWallet();
        $id = $idarr['wallet_id'];
        $data['cek'] = $this->agenmodel->cekWallet($id);
        $data['komisi'] = $this->agenmodel->getKomisi($id);

        $name   = html_escape($this->input->post('nama', TRUE));
        $no_rekening  = html_escape($this->input->post('no_rekening', TRUE));
        $this->form_validation->set_rules('no_rekening', 'NO_REKENING', 'trim|prep_for_form|is_unique[wallet_agent.no_rekening]');
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_pemilik' => $name,
                'no_rekening'  => $no_rekening,
                'status'       => 'A'

            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('agent/komisi');
            } else {
                $this->db->insert('wallet_agent', $data);
                $id_wallet = $this->db->insert_id();
                $komisi = [
                    'id_wallet' => $id_wallet,
                    'jumlah'    => 0,
                    'status'    => 'U',
                    'waktu'     => date('Y-m-d H:i:s'),
                ];
                $this->agenmodel->insertKomisi($komisi, $id_wallet);

                $this->session->set_flashdata('tambah', 'Wallet Has Been Added');
                redirect('agent/komisi');
            }
        }

        $this->load->view('includes/header');
        $this->load->view('agen/wallet', $data);
        $this->load->view('includes/footer');
    }

    public function get_komisi($id)
    {
        $agent = $this->agenmodel->get_regency_agent($id);
        $reg_id = $agent['regency_id'];
        $data  = $this->agenmodel->getKomisiAgent($reg_id);

        echo json_encode($data);
    }

    public function list_komisi()
    {
        $data['data'] = $this->agenmodel->getListKomisi();

        $this->load->view('includes/header');
        $this->load->view('agen/list_komisi', $data, false);
        $this->load->view('includes/footer');
    }

    public function load_komisi()
    {
        $bulan = $_GET['bulan'];
        $fee = $this->agenmodel->getadminsetting();
        $komisi = $fee['komisi_agent'];
        if ($bulan == 0) {
            $data = $this->agenmodel->getListKomisi();
        } else {
            $data = $this->db->query('SELECT a.nama_lengkap, a.id, a.image, sum(t.biaya_akhir) as total FROM transaksi t LEFT JOIN driver d ON t.id_driver = d.id LEFT JOIN admin a ON d.regency_id = a.regency_id LEFT JOIN history_transaksi ht ON t.id = ht.id_transaksi LEFT JOIN fitur f ON t.order_fitur = f.id_fitur WHERE a.level_id = 2 AND ht.status != 1 AND f.id_fitur = 15 AND MONTH(t.waktu_selesai) = ' . $bulan . ' GROUP BY d.regency_id')->result_array();
        }

        foreach ($data as $no => $ag) : ?>
            <?php $fee = $ag['total'] * $komisi / 100 ?>
            <tr>
                <td><?= $no + 1 ?></td>
                <td>
                    <img src="<?= base_url('images/agent/') . $ag['image']; ?>">
                </td>
                <td><?= $ag['nama_lengkap'] ?></td>
                <td><?= formatRupiah($ag['total']) ?></td>
                <td><?= formatRupiah($fee) ?></td>
                <td>
                    <a href="#" type="button" class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#bayar<?= $ag['id'] ?>">Bayar
                    </a>
                </td>
            </tr>
            <div class="modal fade" id="bayar<?= $ag['id'] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLabel">Konfirmasi Pembayaran</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="module/user/aksi_edit.php" method="POST">
                                <div class="form-group">
                                    <label for="nilai">Ganti Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <option value="P">Paid</option>
                                        <option value="U">Unpaid</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-outline-success" type="submit" name="update">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
<?php

    }
}
