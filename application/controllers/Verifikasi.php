<?php
class Verifikasi extends CI_Controller {

    public function kaling($id) {
        $data['kaling'] = $this->db->get_where('tbkaling', ['KodeKaling' => $id])->row();

        if (!$data['kaling']) {
            show_404();
        }

        $this->load->view('verifikasi_kaling', $data);
    }
}

?>