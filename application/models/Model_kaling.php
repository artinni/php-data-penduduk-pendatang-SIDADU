<?php
class Model_kaling extends CI_Model {

    public function get_detailkaling($KodeKaling)
    {
        return $this->db->get_where('tbkaling', ['KodeKaling' => $KodeKaling])->row();
    }

    public function updateStatusAktivasi($KodeKaling, $status) 
    {
    $this->db->where('KodeKaling', $KodeKaling);
    return $this->db->update('tbkaling', ['StatusAktivasi' => $status]);
    }

     public function get_nama_provinsi($id) {
        return $this->db->get_where('wilayah_provinsi', ['id' => $id])->row('nama');
    }

    public function get_nama_kabupaten($id) {
        return $this->db->get_where('wilayah_kabupaten', ['id' => $id])->row('nama');
    }

    public function get_nama_kecamatan($id) {
        return $this->db->get_where('wilayah_kecamatan', ['id' => $id])->row('nama');
    }

    public function get_nama_kelurahan($id) {
        return $this->db->get_where('wilayah_kelurahan', ['id' => $id])->row('nama');
    }

}
