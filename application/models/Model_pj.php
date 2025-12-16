<?php
class Model_pj extends CI_Model {

    public function get_detailpj($KodePJ)
    {
        return $this->db->get_where('tbpj', ['KodePJ' => $KodePJ])->row();
    }

    public function updateStatusAktivasi($KodePJ, $status) 
    {
    $this->db->where('KodePJ', $KodePJ);
    return $this->db->update('tbpj', ['StatusAktivasi' => $status]);
    }

}
