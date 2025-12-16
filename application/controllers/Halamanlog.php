<?php
class Halamanlog extends CI_Controller
{
    public function index()
    {
        $this->load->view('index'); // Halaman login
    }

    public function proseslogin()
{
    $username = $this->input->post('Username');
    $password = $this->input->post('Password');
    $jenisAkun = $this->input->post('JenisAkun');

    // Cek berdasarkan jenis akun
    if ($jenisAkun == 'Penanggungjawab') {
        $query = $this->db->get_where('tbpj', ['Username' => $username]);
    } elseif ($jenisAkun == 'Kaling') {
        $query = $this->db->get_where('tbkaling', ['Username' => $username]);
    } elseif ($jenisAkun == 'Admin') {
        $query = $this->db->get_where('tblogin', ['Username' => $username]);
    } else {
        $this->session->set_flashdata('pesan', 'Jenis akun tidak valid.');
        redirect('Halamanlog');
        return;
    }

    if ($query->num_rows() == 0) {
        $this->session->set_flashdata('pesan', 'Akun tidak ditemukan.');
        redirect('Halamanlog');
        return;
    }

    $data = $query->row();

    // Tambahan: Kirim notifikasi email khusus untuk Kaling yang login sukses
    if ($jenisAkun == 'Kaling') {
        $this->load->library('email');
        $this->email->from('cutemeowmeow111@gmail.com', 'SIDADU');
        $this->email->to($data->Email);
        $this->email->subject('Login Berhasil di SIDADU');
        $this->email->message('Halo ' . $data->NamaLengkap . ',<br><br>Login ke akun Kepala Lingkungan Anda di SIDADU berhasil.<br>Jika ini bukan Anda, segera hubungi admin.');
        $this->email->send(); // Abaikan hasil agar tidak mengganggu alur login
    }

    // Verifikasi khusus PJ
    if ($jenisAkun == 'Penanggungjawab' && $data->StatusAktivasi != 'Terverifikasi') {
        $this->session->set_flashdata('pesan', 'Akun belum diverifikasi melalui email.');
        redirect('Halamanlog');
        return;
    }

    // Cek password
    if ($jenisAkun == 'Admin') {
        $passwordValid = ($data->Password === $password);
    } else {
        $passwordValid = password_verify($password, $data->Password);
    }

    if (! $passwordValid) {
        $this->session->set_flashdata('pesan', 'Password salah.');
        redirect('Halamanlog');
        return;
    }

    // Login sukses: buat session
    $session_data = [
        'Username'     => $data->Username,
        'NamaLengkap'  => $data->NamaLengkap,
        'JenisKelamin' => $data->JenisKelamin ?? '',
        'Email'        => $data->Email,
        'Telp'         => $data->Telp ?? '',
        'JenisAkun'    => $jenisAkun
    ];
    if (isset($data->KodeLogin)) {
        $session_data['KodeLogin'] = $data->KodeLogin;
    } elseif (isset($data->KodeKaling)) {
        $session_data['KodeKaling'] = $data->KodeKaling;
    } elseif (isset($data->KodePJ)) {
        $session_data['KodePJ'] = $data->KodePJ;
    }

 $this->session->set_userdata($session_data);

    // Redirect sesuai level
    if ($jenisAkun == 'Admin') {
        redirect('Dashboard/admin');
    } elseif ($jenisAkun == 'Kaling') {
        redirect('Dashboard/kaling');
    } elseif ($jenisAkun == 'Penanggungjawab') {
        redirect('Dashboard/pj');
    }
}

}