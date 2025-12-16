<?php
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('validasi');
        $this->validasi->validasiakun();
        $this->load->model('Notifikasi_model');
        $this->load->library('session');
    }
    public function index()
    {
        $jenis = $this->session->userdata('JenisAkun');

        if ($jenis == 'Admin') {
            redirect('Dashboard/admin');
        } elseif ($jenis == 'Kaling') {
            redirect('Dashboard/kaling');
        } elseif ($jenis == 'Penanggungjawab') {
            redirect('Dashboard/pj');
        } else {
            redirect('Halamanlog');
        }

    }

    public function admin()
    {
        // Validasi hanya admin
    if ($this->session->userdata('JenisAkun') !== 'Admin') {
        redirect('Halamanlog');
    }

    // Hitung jumlah pendatang yang diverifikasi
    $data['jumlahTerverifikasi'] = $this->db
        ->where('StatusVerifikasi', 'Diterima')
        ->count_all_results('tbpendatang');
    $data['jumlahAktivasi'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbkaling');
    $data['jumlahTerverifikasipj'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbpj');

    // Load view dashboard dan kirim data
    $data['konten'] = $this->load->view('dashboard_view', $data, TRUE);
    $this->load->view('admin_view', $data);
    }

    public function kaling()
    {
        // Validasi hanya Kepala Lingkungan
        if ($this->session->userdata('JenisAkun') !== 'Kaling') {
            redirect('Halamanlog');
        }

    $data['jumlahTerverifikasi'] = $this->db
        ->where('StatusVerifikasi', 'Diterima')
        ->count_all_results('tbpendatang');
    $data['jumlahAktivasi'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbkaling');
    $data['jumlahTerverifikasipj'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbpj');

        $data['konten'] = $this->load->view('dashboard_view', $data, TRUE);
        $this->load->view('admin_view', $data);

    }

    public function pj()
    {
        // Validasi hanya Penanggung Jawab
        if ($this->session->userdata('JenisAkun') !== 'Penanggungjawab') {
            redirect('Halamanlog');
        }
    $data['jumlahTerverifikasi'] = $this->db
        ->where('StatusVerifikasi', 'Diterima')
        ->count_all_results('tbpendatang');
    $data['jumlahAktivasi'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbkaling');
    $data['jumlahTerverifikasipj'] = $this->db
        ->where('StatusAktivasi', 'Terverifikasi')
        ->count_all_results('tbpj');

        $data['konten'] = $this->load->view('dashboard_view', $data, TRUE);
        $this->load->view('admin_view', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Halamanlog/index', 'refresh');
    }


    public function getNotifikasi()
{

    // Ambil data notifikasi dari database
    $surat_count = $this->Notifikasi_model->getSuratCount(); // Contoh fungsi di model
    $pendatang_count = $this->Notifikasi_model->getPendatangCount();
    $pj_count = $this->Notifikasi_model->getPjCount();
    $kaling_count = $this->Notifikasi_model->getKalingCount();

    $data = array(
        'total' => $surat_count + $pendatang_count + $pj_count + $kaling_count,
        'surat' => $surat_count,
        'pendatang' => $pendatang_count,
        'pj' => $pj_count,
        'kaling' => $kaling_count,
    );

    // Set header agar browser tahu ini adalah JSON
    $this->output->set_content_type('application/json');

    // Kirim data sebagai JSON
    echo json_encode($data);
}



}
