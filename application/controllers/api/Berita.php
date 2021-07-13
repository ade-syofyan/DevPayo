<?php

//'tes' => number_format(200 / 100, 2, ",", "."),

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Berita extends REST_Controller

{

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data berita
    function index_get() {
        $id = $this->get('id_berita');
        if ($id == '') {
            $allBerita = $this->db->get('berita')->result();
        } else {
            $this->db->where('id_berita', $id);
            $allBerita = $this->db->get('berita')->result();
            
        }
        $this->response($allBerita, 200);
    }

    //Menampilkan data news
    function news_get() {
        $id = $this->get('id_berita');
        if ($id == '') {
            $this->db->select('*');
            $this->db->from('berita');
            $this->db->join('kategori_news', 'kategori_news.id_kategori_news = berita.id_kategori');
            $this->db->where('berita.type',1);
            $news = $this->db->get()->result();
        } else {
            $this->db->select('*');
            $this->db->from('berita');
            $this->db->join('kategori_news', 'kategori_news.id_kategori_news = berita.id_kategori');
            $this->db->where('berita.type',1);
            $this->db->where('berita.id_berita', $id);
            $news = $this->db->get()->result();
        }

        $this->response($news, 200);
    }

}