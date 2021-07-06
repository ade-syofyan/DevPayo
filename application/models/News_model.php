<?php

class News_model extends CI_model
{
    public function getAllnews()
    {
        // $this->db->select('config_driver.status as status_job');
        // $this->db->select('driver_job.driver_job');
        // $this->db->select('driver.*');
        // $this->db->join('config_driver', 'driver.id = config_driver.id_driver', 'left');
        $this->db->join('kategori_news', 'berita.id_kategori = kategori_news.id_kategori_news', 'left');
        return  $this->db->get('berita')->result_array();
    }

    public function getallkategorinews()
    {
        return  $this->db->get('kategori_news')->result_array();
    }

    public function tambahdataberita($data)
    {
        return $this->db->insert('berita', $data);
    }

    public function getnewsbyid($id)
    {
        return $this->db->get_where('berita', ['id_berita' => $id])->row_array();
    }

    public function hapuskategoribyId($id)
    {
        $this->db->where('id_kategori_news', $id);
        $this->db->delete('kategori_news');
    }
    public function hapusberitabyId($id)
    {
        $this->db->where('id_berita', $id);
        $this->db->delete('berita');
    }

    public function ubahdataberita($data)
    {

        $this->db->set('foto_berita', $data['foto_berita']);
        $this->db->set('title', $data['title']);
        $this->db->set('content', $data['content']);
        $this->db->set('id_kategori', $data['id_kategori']);
        $this->db->set('status_berita', $data['status_berita']);

        $this->db->where('id_berita', $data['id_berita']);
        $this->db->update('berita', $data);
    }

    public function tambahdatakategori($data)
    {
        $this->db->set('kategori', $data['kategori']);
        $this->db->insert('kategori_news', $data);
    }
}
