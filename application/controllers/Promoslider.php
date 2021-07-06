<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promoslider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        

        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('promoslider_model', 'promo');
        $this->load->model('service_model', 'fitur');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['promo'] = $this->promo->getallpromo();

        $this->load->view('includes/header');
        $this->load->view('promoslider/index', $data);
        $this->load->view('includes/footer');
    }

    public function tambah()

    {

        $this->form_validation->set_rules('tanggal_berakhir', 'tanggal_berakhir', 'trim|prep_for_form');
        $this->form_validation->set_rules('fitur_promosi', 'fitur_promosi', 'trim|prep_for_form');
        $this->form_validation->set_rules('link_promosi', 'link_promosi', 'trim|prep_for_form');
        $this->form_validation->set_rules('is_show', 'is_show', 'trim|prep_for_form');
        $this->form_validation->set_rules('type_promosi', 'type_promosi', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/promo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $gambar = html_escape($this->upload->data('file_name'));
            } else {
                $gambar = 'noimage.jpg';
            }
            $type = html_escape($this->input->post('type_promosi', TRUE));

            if ($type != 'link') {
                $fitur = html_escape($this->input->post('fitur_promosi', TRUE));
            } else {
                $fitur = 0;
            }

            $data             = [
                'foto'                          => $gambar,
                'tanggal_berakhir'              => html_escape($this->input->post('tanggal_berakhir', TRUE)),
                'fitur_promosi'                 => $fitur,
                'type_promosi'                  => html_escape($this->input->post('type_promosi', TRUE)),
                'is_show'                       => html_escape($this->input->post('is_show', TRUE)),
                'link_promosi'                  => html_escape($this->input->post('link_promosi', TRUE))
            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('promoslider/tambah');
            } else {
                $this->promo->tambahdatapromo($data);
                $this->session->set_flashdata('tambah', 'Promotion Slider Has Been Added');
                redirect('promoslider');
            }
        } else {
            $data['fitur'] = $this->fitur->getallservice();
            $this->load->view('includes/header');
            $this->load->view('promoslider/addslider', $data);
            $this->load->view('includes/footer');
        }
    }
    public function hapus($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('promoslider/index');
        } else {
            $data = $this->promo->getpromoById($id);

            if ($data['foto'] != 'noimage.jpg') {
                $gambar = $data['foto'];
                unlink('images/promo/' . $gambar);
            }

            $this->promo->hapuspromoById($id);
            $this->session->set_flashdata('hapus', 'Promotion Slider Has Been deleted');
            redirect('promoslider');
        }
    }

    public function ubah($id)
    {

        $this->form_validation->set_rules('tanggal_berakhir', 'tanggal_berakhir', 'trim|prep_for_form');
        $this->form_validation->set_rules('fitur_promosi', 'fitur_promosi', 'trim|prep_for_form');
        $this->form_validation->set_rules('link_promosi', 'link_promosi', 'trim|prep_for_form');
        $this->form_validation->set_rules('is_show', 'is_show', 'trim|prep_for_form');
        $this->form_validation->set_rules('type_promosi', 'type_promosi', 'trim|prep_for_form');

        $data = $this->promo->getpromoById($id);
        $data['fitur'] = $this->fitur->getallservice();
        $id = html_escape($this->input->post('id', TRUE));

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/promo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                if ($data['foto'] != 'noimage.jpg') {
                    $gambar = $data['foto'];
                    unlink('images/foto/' . $gambar);
                }
                $gambar = html_escape($this->upload->data('file_name'));
            } else {
                $gambar = $data['foto'];
            }

            $type = html_escape($this->input->post('type_promosi', TRUE));

            if ($type != 'link') {
                $fitur = html_escape($this->input->post('fitur_promosi', TRUE));
                $link = 'service';
            } else {
                $fitur = 0;
                $link = html_escape($this->input->post('link_promosi', TRUE));
            }

            $data             = [
                'id'                            => html_escape($this->input->post('id', TRUE)),
                'foto'                          => $gambar,
                'tanggal_berakhir'              => html_escape($this->input->post('tanggal_berakhir', TRUE)),
                'fitur_promosi'                 => $fitur,
                'type_promosi'                  => $type,
                'is_show'                       => html_escape($this->input->post('is_show', TRUE)),
                'link_promosi'                  => $link,
            ];
            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('promoslider/index');
            } else {
                $this->promo->ubahdatapromo($data);
                $this->session->set_flashdata('ubah', 'Promotion Slider Has Been Changed');
                redirect('promoslider');
            }
        } else {
            $this->load->view('includes/header');
            $this->load->view('promoslider/editslider' . $id, $data);
            $this->load->view('includes/footer');
        }
    }
}
