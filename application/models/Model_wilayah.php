<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_wilayah extends CI_Model {

    public function getNamaProvinsi($id)
    {
        $query = $this->db->get_where('provinsi', ['id' => $id])->row();
        return $query ? $query->nama : '-';
    }

    public function getNamaKabupaten($id)
    {
        $query = $this->db->get_where('kabupaten', ['id' => $id])->row();
        return $query ? $query->nama : '-';
    }

    public function getNamaKecamatan($id)
    {
        $query = $this->db->get_where('kecamatan', ['id' => $id])->row();
        return $query ? $query->nama : '-';
    }

    public function getNamaKelurahan($id)
    {
        $query = $this->db->get_where('kelurahan', ['id' => $id])->row();
        return $query ? $query->nama : '-';
    }
}

