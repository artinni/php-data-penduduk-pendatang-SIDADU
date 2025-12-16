<?php
class Model_pendatang extends CI_Model {

    public function get_detailpendatang($KodePendatang)
    {
        $this->db->select('tbpendatang.*, tbpj.NamaLengkap AS NamaPJ');
        $this->db->from('tbpendatang');
        $this->db->join('tbpj', 'tbpendatang.KodePJ = tbpj.KodePJ', 'left');
        $this->db->where('tbpendatang.KodePendatang', $KodePendatang);
        $query = $this->db->get();

        return $query->row();
    }

    public function updateStatusVerifikasi($KodePendatang, $status) 
    {
    $this->db->where('KodePendatang', $KodePendatang);
    return $this->db->update('tbpendatang', ['StatusVerifikasi' => $status]);
    }

    public function get_data_pendatang($nik)
    {
        $this->db->where('NIK', $nik);
        $this->db->where('StatusVerifikasi', 'Diterima'); // jika diperlukan filter status
        $query = $this->db->get('tbpendatang');

        if ($query->num_rows() > 0) {
            echo json_encode($query->row_array());
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }

    // Perbaiki fungsi ini agar menerima KodePJ dan memfilter berdasarkan itu
   // di Model_pendatang.php
public function getDataLaporanBulanan($bulan, $KodePJ) 
{
    // Format bulan: YYYY-MM
    $this->db->select('*');
    $this->db->from('tbpendatang');
    $this->db->where('StatusVerifikasi', 'Diterima');
    $this->db->like('TglMasuk', $bulan, 'after'); // 'after' agar cocok dengan 'YYYY-MM%'
    
    // Tambahkan filter berdasarkan KodePJ jika KodePJ tidak kosong
    if (!empty($KodePJ)) {
        $this->db->where('KodePJ', $KodePJ);
    }

    $query = $this->db->get();
    
    // --- DEBUGGING DI MODEL ---
    log_message('debug', 'Query SQL untuk laporan bulanan: ' . $this->db->last_query());
    log_message('debug', 'Jumlah hasil dari model: ' . $query->num_rows());
    // --- END DEBUGGING DI MODEL ---

    return $query->result(); // Pastikan selalu mengembalikan array objek
}

    private function getWilayahName($kode, $jenis)
    {
        $base_url = "https://emsifa.github.io/api-wilayah-indonesia/api/";

        if ($jenis == "provinsi") {
            $url = $base_url . "provinces.json";
        } elseif ($jenis == "kabupaten") {
            $parent = substr($kode, 0, 2);
            $url = $base_url . "regencies/{$parent}.json";
        } elseif ($jenis == "kecamatan") {
            $parent = substr($kode, 0, 4);
            $url = $base_url . "districts/{$parent}.json";
        } elseif ($jenis == "kelurahan") {
            $parent = substr($kode, 0, 7);
            $url = $base_url . "villages/{$parent}.json";
        } else {
            return null;
        }

        $response = file_get_contents($url);
        if (!$response) return null;

        $data = json_decode($response, true);
        foreach ($data as $item) {
            if ($item['id'] == $kode) {
                return $item['name'];
            }
        }

        return null;
    }
}
?>