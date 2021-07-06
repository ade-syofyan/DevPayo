<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('news_model', 'news');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['news'] = $this->news->getallnews();
        $data['kategori'] = $this->news->getallkategorinews();

        $this->load->view('includes/header');
        $this->load->view('news/index', $data);
        $this->load->view('includes/footer');
    }

    public function hapuscategory($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('news/index');
        } else {
            $this->news->hapuskategoribyid($id);
            $this->session->set_flashdata('hapus', 'Category News Has Been Deleted');
            redirect('news');
        }
    }

    public function tambah()
    {

        $this->form_validation->set_rules('title', 'title', 'trim|prep_for_form');
        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|prep_for_form');


        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/berita/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_berita')) {
                $gambar = html_escape($this->upload->data('file_name'));
            } else {
                $gambar = 'noimage.jpg';
            }

            $data             = [
                'foto_berita'                => $gambar,
                'title'                      => html_escape($this->input->post('title', TRUE)),
                'content'                    => $this->input->post('content', TRUE),
                'id_kategori'                => html_escape($this->input->post('id_kategori', TRUE)),
                'status_berita'              => html_escape($this->input->post('status_berita', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('news/tambah');
            } else {

                $this->news->tambahdataberita($data);
                $this->session->set_flashdata('tambah', 'Category News Has Been Added');
                redirect('news');
            }
        } else {
            $data['news'] = $this->news->getallkategorinews();
            $this->load->view('includes/header');
            $this->load->view('news/addnews', $data);
            $this->load->view('includes/footer');
        }
    }

    public function hapus($id)
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('news/index');
        } else {
            $data = $this->news->getnewsById($id);
            if ($data['foto_berita'] != 'noimage.jpg') {
                $gambar = $data['foto_berita'];
                unlink('images/berita/' . $gambar);
            }
            $this->news->hapusberitaById($id);
            $this->session->set_flashdata('hapus', 'News Has Been Deleted');
            redirect('news');
        }
    }

    public function ubah($id)
    {

        $this->form_validation->set_rules('title', 'title', 'trim|prep_for_form');
        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|prep_for_form');


        $data['news'] = $this->news->getnewsById($id);
        $id  = html_escape($this->input->post('id_berita', TRUE));


        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']     = './images/berita/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']         = '10000';
            $config['file_name']     = 'name';
            $config['encrypt_name']     = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_berita')) {
                if ($data['news']['foto_berita'] != 'noimage.jpg') {
                    $gambar = $data['news']['foto_berita'];
                    unlink('images/berita/' . $gambar);
                }

                $gambar = html_escape($this->upload->data('file_name'));
            } else {
                $gambar = $data['news']['foto_berita'];
            }
            $data             = [
                'id_berita'                     => html_escape($this->input->post('id_berita', TRUE)),
                'foto_berita'                   => $gambar,
                'title'                         => html_escape($this->input->post('title', TRUE)),
                'content'                       => $this->input->post('content'),
                'id_kategori'                   => html_escape($this->input->post('id_kategori', TRUE)),
                'status_berita'                 => html_escape($this->input->post('status_berita', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('news/index');
            } else {

                $this->news->ubahdataberita($data);
                $this->session->set_flashdata('ubah', 'News Has Been Changed');
                redirect('news');
            }
        } else {
            $data['knews'] = $this->news->getallkategorinews();


            $this->load->view('includes/header');
            $this->load->view('news/editnews', $data);
            $this->load->view('includes/footer');
        }
    }

    public function tambahcategory()
    {

        $this->form_validation->set_rules('kategori', 'kategori', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {

            $data             = [
                'kategori'                => html_escape($this->input->post('kategori', TRUE))
            ];

            if (demo == TRUE) {
                $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
                redirect('news/index');
            } else {
                $this->news->tambahdatakategori($data);
                $this->session->set_flashdata('tambah', 'Has Been added');
                redirect('news');
            }
        } else {
            $this->load->view('includes/header');
            $this->load->view('news/addcategory');
            $this->load->view('includes/footer');
        }
    }
}
