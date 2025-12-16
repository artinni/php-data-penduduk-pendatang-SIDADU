<?php
class Laporan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('validasi');
        $this->validasi->validasiakun();

        // Load database jika belum
        $this->load->database();
    }

    public function index()
    {
        // Ambil data penduduk
        $data['penduduk'] = $this->db->get('tbpendatang')->result();

        // Ambil surat yang sudah disetujui/siap
        $this->db->where('status', 'Siap');
        $data['surat'] = $this->db->get('tbsurat')->result();

        // Tampilkan keduanya di satu halaman
        $data['konten'] = $this->load->view('Laporan_view', $data, TRUE);
        $this->load->view('admin_view', $data);
    }

    public function surat_disetujui()
    {
        $this->db->where('status', 'Siap');
        $data['surat'] = $this->db->get('tbsurat')->result();
        $data['konten'] = $this->load->view('laporan/surat_disetujui', $data, TRUE);
        $this->load->view('admin_view', $data);
    }
}
