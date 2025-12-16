<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Memuat database library secara otomatis untuk model ini
        $this->load->database();
        
    }

    // Fungsi untuk menghitung surat yang perlu diverifikasi
    public function getSuratCount() {
        // Contoh: hitung surat dengan status 'pending' atau 'menunggu_verifikasi'
        // Sesuaikan nama tabel ('surat') dan kolom ('status_surat') serta nilai statusnya
        $this->db->where('status', 'Permohonan');
        $query = $this->db->get('tbsurat'); // Ganti 'surat' dengan nama tabel surat Anda
        return $query->num_rows();
    }

    // Fungsi untuk menghitung pendatang yang dalam proses (misal, belum selesai registrasi)
    public function getPendatangCount() {
        // Contoh: hitung pendatang dengan status 'proses'
        // Sesuaikan nama tabel ('pendatang') dan kolom ('status_pendatang') serta nilai statusnya
        $this->db->where('StatusVerifikasi', 'Diproses');
        $query = $this->db->get('tbpendatang'); // Ganti 'pendatang' dengan nama tabel pendatang Anda
        return $query->num_rows();
    }

    // Fungsi untuk menghitung Penanggung Jawab yang menunggu konfirmasi/verifikasi
    public function getPjCount() {
        // Contoh: hitung PJ yang statusnya 'pending_konfirmasi'
        // Sesuaikan nama tabel ('penanggung_jawab') dan kolom ('status_pj') serta nilai statusnya
        $this->db->where('StatusAktivasi', 'Diproses');
        $query = $this->db->get('tbpj'); // Ganti 'penanggung_jawab' dengan nama tabel PJ Anda
        return $query->num_rows();
    }

    // Fungsi untuk menghitung Kepala Lingkungan yang menunggu konfirmasi/verifikasi
    public function getKalingCount() {
        // Contoh: hitung Kaling yang statusnya 'pending_konfirmasi'
        // Sesuaikan nama tabel ('kepala_lingkungan') dan kolom ('status_kaling') serta nilai statusnya
        $this->db->where('StatusAktivasi', 'Diproses');
        $query = $this->db->get('tbkaling'); // Ganti 'kepala_lingkungan' dengan nama tabel Kaling Anda
        return $query->num_rows();
    }
}