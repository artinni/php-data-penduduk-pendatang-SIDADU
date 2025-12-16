<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('validasi');
        $this->validasi->validasiakun();
        $this->load->library('session');
    }

    // ============================
    // HALAMAN DASHBOARD UTAMA
    // ============================
    public function index()
    {
        $jenis_akun = $this->session->userdata('JenisAkun'); // Ambil JenisAkun dari session
        $user = null; // Inisialisasi variabel user

        // Ambil data user sesuai JenisAkun
        if ($jenis_akun == 'admin') {
            $user = $this->db->get_where('tblogin', [
                'KodeLogin' => $this->session->userdata('KodeLogin')
            ])->row_array();
            // Data JenisAkun sudah ada di tblogin
        } elseif ($jenis_akun == 'penanggungjawab') {
            $user = $this->db->get_where('tbpj', [
                'Username' => $this->session->userdata('Username')
            ])->row_array();
            // Penting: Jika kolom Nama Lengkap di DB tbpj pakai spasi, maka:
            // $user['NamaLengkap'] = $user['Nama Lengkap']; // Buat alias agar view pakai NamaLengkap
        } elseif ($jenis_akun == 'kaling') {
            $user = $this->db->get_where('tbkaling', [
                'Username' => $this->session->userdata('Username')
            ])->row_array();
            // Penting: Jika kolom Nama Lengkap di DB tbkaling pakai spasi, maka:
            // $user['NamaLengkap'] = $user['Nama Lengkap']; // Buat alias agar view pakai NamaLengkap
        }

        // Kirim data ke view. Variabel $level di view akan menggunakan $jenis_akun
        $viewData = [
            'user' => $user,
            'level' => $jenis_akun // Mengirim JenisAkun sebagai 'level' ke view
        ];

        $data['konten'] = $this->load->view('Akun_view', $viewData, TRUE);
        $this->load->view('admin_view', $data);
    }

    // ============================
    // HALAMAN PROFIL
    // ============================
    public function profil()
    {
        $jenis_akun = $this->session->userdata('JenisAkun'); // Ambil JenisAkun dari session
        $user = null; // Inisialisasi variabel user

        if ($jenis_akun == 'admin') {
            $user = $this->db->get_where('tblogin', [
                'KodeLogin' => $this->session->userdata('KodeLogin')
            ])->row_array();
        } elseif ($jenis_akun == 'penanggungjawab') {
            $user = $this->db->get_where('tbpj', [
                'Username' => $this->session->userdata('Username')
            ])->row_array();
            // if ($user) { $user['NamaLengkap'] = $user['Nama Lengkap']; } // Buat alias jika perlu
        } elseif ($jenis_akun == 'kaling') {
            $user = $this->db->get_where('tbkaling', [
                'Username' => $this->session->userdata('Username')
            ])->row_array();
            // if ($user) { $user['NamaLengkap'] = $user['Nama Lengkap']; } // Buat alias jika perlu
        }

        $data = [
            'user' => $user,
            'level' => $jenis_akun // Mengirim JenisAkun sebagai 'level' ke view
        ];

        $this->load->view('Akun_view', $data);
    }

    // ============================
    // UPDATE PROFIL ADMIN
    // ============================
    public function updateAdmin()
    {
        if ($this->session->userdata('JenisAkun') !== 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk aksi ini.');
            redirect('User/profil');
        }

        $data_update = [
            'NamaLengkap' => $this->input->post('NamaLengkap', TRUE),
            // Username dan JenisAkun tidak diupdate dari form ini
        ];
        $kode_login = $this->input->post('KodeLogin', TRUE);

        $this->db->where('KodeLogin', $kode_login);
        $this->db->update('tblogin', $data_update);

        $this->session->set_flashdata('success', 'Profil admin berhasil diperbarui.');
        redirect('User/profil');
    }

    // ============================
    // UPDATE PROFIL PENANGGUNGJAWAB
    // ============================
    public function updatePenanggungjawab()
    {
        if ($this->session->userdata('JenisAkun') !== 'penanggungjawab') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk aksi ini.');
            redirect('User/profil');
        }

        $data_update = [
            'Nama Lengkap' => $this->input->post('NamaLengkap', TRUE), // Menggunakan Nama Lengkap (dengan spasi)
            'Email' => $this->input->post('Email', TRUE),
        ];
        $kode_pj = $this->input->post('KodePJ', TRUE); // Mengambil KodePJ dari hidden field

        $this->db->where('KodePJ', $kode_pj); // Mengupdate berdasarkan KodePJ
        $this->db->update('tbpj', $data_update);

        $this->session->set_flashdata('success', 'Profil penanggung jawab berhasil diperbarui.');
        redirect('User/profil');
    }

    // ============================
    // UPDATE PROFIL KALING
    // ============================
    public function updateKaling()
    {
        if ($this->session->userdata('JenisAkun') !== 'kaling') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk aksi ini.');
            redirect('User/profil');
        }

        $data_update = [
            'NamaLengkap' => $this->input->post('NamaLengkap', TRUE),
            // Username, JenisAkun, dan Jabatan (jika ada) tidak diupdate dari form ini
        ];
        $kode_kaling = $this->input->post('KodeKaling', TRUE); // Mengambil KodeKaling dari hidden field

        $this->db->where('KodeKaling', $kode_kaling); // Mengupdate berdasarkan KodeKaling
        $this->db->update('tbkaling', $data_update);

        $this->session->set_flashdata('success', 'Profil kaling berhasil diperbarui.');
        redirect('User/profil');
    }
}