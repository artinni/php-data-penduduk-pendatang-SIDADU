<!-- untuk registrasi -->
<?php
class Chalaman extends CI_Controller
{

    public function registrasi()
    {
        $this->load->view('registrasi');
    }

    public function daftar()
{
    $username = $this->input->post('Username');
    $email    = $this->input->post('Email');

    // ✅ Cek username ganda di tbpj & tbkaling
    $this->db->where('Username', $username);
    $query1 = $this->db->get('tbpj');
    $this->db->where('Username', $username);
    $query2 = $this->db->get('tbkaling');

    if ($query1->num_rows() > 0 || $query2->num_rows() > 0) {
        $this->session->set_flashdata('pesan', 'Username sudah digunakan. Silakan gunakan yang lain.');
        redirect('Chalaman/registrasi');
        return;
    }

    // ✅ Cek email ganda
    $this->db->where('Email', $email);
    $queryEmail1 = $this->db->get('tbpj');
    $this->db->where('Email', $email);
    $queryEmail2 = $this->db->get('tbkaling');

    if ($queryEmail1->num_rows() > 0 || $queryEmail2->num_rows() > 0) {
        $this->session->set_flashdata('pesan', 'Email sudah digunakan. Silakan gunakan email lain.');
        redirect('Chalaman/registrasi');
        return;
    }

    // ✅ Tentukan jenis akun
    $jenisAkun = $this->input->post('JenisAkun');
    $jenis = ($jenisAkun == 'KepalaLingkungan') ? 'Kaling' :
             (($jenisAkun == 'PenanggungJawab') ? 'Penanggungjawab' : '');

    $token = bin2hex(random_bytes(6)); // 🔁 Gunakan token untuk semua

    $data = [
        'Username'       => $username,
        'Password'       => password_hash($this->input->post('Password'), PASSWORD_DEFAULT),
        'NamaLengkap'    => $this->input->post('NamaLengkap'),
        'Alamat'         => $this->input->post('Alamat'),
        'Telp'           => $this->input->post('Telp'),
        'Email'          => $email,
        'StatusAktivasi' => 'Diproses',
        'JenisAkun'      => $jenis,
        'JenisKelamin'   => $this->input->post('JenisKelamin'),
        'EmailToken'     => $token
    ];

    $this->load->library('email');
    $this->email->from('cutemeowmeow111@gmail.com', 'SIDADU');
    $this->email->to($email);

    if ($jenis == 'Penanggungjawab') {
        $this->db->insert('tbpj', $data);

        // Email verifikasi PJ
        $this->email->subject('Verifikasi Akun SIDADU Anda');
        $this->email->message('Klik link berikut untuk verifikasi akun Anda: <a href="' . base_url('Penanggungjawab/verify_email/' . $token) . '" target="_self">Verifikasi Sekarang</a>');
    } else {
        $this->db->insert('tbkaling', $data);

        // Email verifikasi Kaling (link beda)
        $this->email->subject('Verifikasi Akun Kepala Lingkungan SIDADU');
        $this->email->message('Halo ' . $data['NamaLengkap'] . ',<br><br>
        Akun Anda sebagai Kepala Lingkungan telah berhasil didaftarkan.<br>
        Silakan klik link berikut untuk verifikasi akun Anda: <a href="' . base_url('Kaling/verify_email/' . $token) . '" target="_self">Verifikasi Sekarang</a>');
    }

    if (!$this->email->send()) {
        echo $this->email->print_debugger();
        exit;
    }

    $this->session->set_flashdata('pesan', 'Akun berhasil dibuat. Login dapat dilakukan jika akun telah diverifikasi.');
    redirect('Halamanlog/index');
}

public function cek_username()
{
    $username = $this->input->post('Username');
    $cek_pj = $this->db->get_where('tbpj', ['Username' => $username])->num_rows();
    $cek_kaling = $this->db->get_where('tbkaling', ['Username' => $username])->num_rows();
    $exists = ($cek_pj > 0 || $cek_kaling > 0);
    echo json_encode(['exists' => $exists]);
}

}
?>
