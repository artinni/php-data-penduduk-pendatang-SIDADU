<?php
	class Pendatang extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Modelcombo');
            $this->load->model('Model_pendatang');
			$this->load->model('validasi');
            $this->load->library('session');
            $this->load->library('pdf');
            $this->validasi->validasiakun();
		}
		
		function index() 
		{
			$datalist['hasil']=$this->tampildata();
			$data['konten']=$this->load->view('pendatang_view','',TRUE);
			$data['table']=$this->load->view('pendatang_tabel', $datalist,TRUE);
			$this->load->view('admin_view',$data);	
		}

		function datapendatang() 
		{
			$datalist['hasil']=$this->tampildata();
			$table1=$this->load->view('Datapendatang_view', $datalist,TRUE);
            $table2=$this->load->view('Datapendatang2_view', $datalist,TRUE);
            $data['table'] = $table1 . $table2;
			$this->load->view('admin_view',$data);	
		}

public function simpanpendatang()
{
    $KodePendatang = $this->input->post('KodePendatang');
    $KodePJ = $this->input->post('KodePJ');

    if ($KodePJ === "null") {
        $this->session->set_flashdata('pesan', 'Penanggung Jawab belum dipilih!');
        redirect('Pendatang/index', 'refresh');
        return;
    }

    // Ambil data form
    $NIK = $this->input->post('NIK');
    $NamaLengkap = $this->input->post('NamaLengkap');
    $NoTelp = $this->input->post('NoTelp');
    $TempatLahir = $this->input->post('TempatLahir');
    $TanggalLahir = $this->input->post('TanggalLahir');
    $JenisKelamin = $this->input->post('JenisKelamin');
    $GolonganDarah = $this->input->post('GolonganDarah');
    $Agama = $this->input->post('Agama');
    $ProvinsiAsal = $this->input->post('ProvinsiAsal');
    $KabAsal = $this->input->post('KabAsal');
    $KecAsal = $this->input->post('KecAsal');
    $KelAsal = $this->input->post('KelAsal');
    $RT = $this->input->post('RT');
    $RW = $this->input->post('RW');
    $AlamatAsal = $this->input->post('AlamatAsal');
    $AlamatSekarang = $this->input->post('AlamatSekarang');
    $Tujuan = $this->input->post('Tujuan');
    $TglMasuk = $this->input->post('TglMasuk');
    $TglKeluar = $this->input->post('TglKeluar');
    $Wilayah = $this->input->post('Wilayah');
    $Latitude = $this->input->post('Latitude');
    $Longitude = $this->input->post('Longitude');
    $AlasanPenolakan = $this->input->post('AlasanPenolakan');

    // Konfigurasi Upload
    $config['upload_path'] = './uploads/pendatang/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048;

    $this->load->library('upload');

     // Upload Foto jika ada
    $Foto = "";
    if (!empty($_FILES['Foto']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('Foto')) {
            $Foto = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('pesan', 'Upload Foto gagal: ' . $this->upload->display_errors());
            redirect('Pendatang/index', 'refresh');
            return;
        }
    }

    // Upload KTP jika ada
    $KTP = "";
    if (!empty($_FILES['KTP']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('KTP')) {
            $KTP = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('pesan', 'Upload KTP gagal: ' . $this->upload->display_errors());
            redirect('Pendatang/index', 'refresh');
            return;
        }
    }

    // Siapkan array data
    $data = array(
        'KodePJ' => $KodePJ,
        'NIK' => $NIK,
        'NamaLengkap' => $NamaLengkap,
        'NoTelp' => $NoTelp,
        'TempatLahir' => $TempatLahir,
        'TanggalLahir' => $TanggalLahir,
        'JenisKelamin' => $JenisKelamin,
        'GolonganDarah' => $GolonganDarah,
        'Agama' => $Agama,
        'ProvinsiAsal' => $ProvinsiAsal,
        'KabAsal' => $KabAsal,
        'KecAsal' => $KecAsal,
        'KelAsal' => $KelAsal,
        'RT' => $RT,
        'RW' => $RW,
        'AlamatAsal' => $AlamatAsal,
        'AlamatSekarang' => $AlamatSekarang,
        'Tujuan' => $Tujuan,
        'TglMasuk' => $TglMasuk,
        'TglKeluar' => $TglKeluar,
        'Wilayah' => $Wilayah,
        'Latitude' => $Latitude,
        'Longitude' => $Longitude,
        'AlasanPenolakan' =>$AlasanPenolakan,
        'StatusVerifikasi' => "Diproses"
    );

    // Hanya update foto jika ada upload baru
    if (!empty($Foto)) {
        $data['Foto'] = $Foto;
    }
    // Hanya update KTP jika ada upload baru
    if (!empty($KTP)) {
        $data['KTP'] = $KTP;
    }

    // INSERT atau UPDATE
    if (!empty($KodePendatang)) {
        // UPDATE
        $this->db->where('KodePendatang', $KodePendatang);
        $this->db->update('tbpendatang', $data);
        $this->session->set_flashdata('pesan', 'Data berhasil diperbarui...');
    } else {
        // INSERT baru
        $this->db->insert('tbpendatang', $data);
        $this->session->set_flashdata('pesan', 'Data berhasil disimpan...');
    }

    redirect('Pendatang/index', 'refresh');
}

		public function tampildata() 
        {
        $status = $this->input->get('status');

        $this->db->select('tbpendatang.*, tbpj.NamaLengkap AS NamaPJ');
        $this->db->from('tbpendatang');
        $this->db->join('tbpj', 'tbpendatang.KodePJ = tbpj.KodePJ', 'left');

        if (!empty($status)) {
            $this->db->where('tbpendatang.StatusVerifikasi', $status);
        }

        $this->db->order_by('tbpendatang.KodePendatang', 'DESC');
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result() : [];
    }

        function hapuspendatang($KodePendatang)
        {
            $sql="delete from tbpendatang where KodePendatang='".$KodePendatang."'";
            $this->db->query($sql); //jalankan querry

            redirect('Pendatang/index', 'refresh');
        }

         public function editpendatang($KodePendatang)
		{
			 log_message('debug', 'Memuat data pendatang untuk: ' . $KodePendatang);
            $this->db->where('KodePendatang', $KodePendatang);
			$query = $this->db->get('tbpendatang');
			
			if ($query->num_rows() > 0) {
				$data = $query->row();
				$response = array(
					'KodePendatang' => $data->KodePendatang,
                    'KodePJ' => $data->KodePJ,
                    'NIK' => $data->NIK,
                    'NamaLengkap' => $data->NamaLengkap,
                    'NoTelp' => $data->NoTelp,
                    'TempatLahir' => $data->TempatLahir,
                    'TanggalLahir' => $data->TanggalLahir,
                    'JenisKelamin' => $data->JenisKelamin,
                    'GolonganDarah' => $data->GolonganDarah,
                    'Agama' => $data->Agama,
                    'ProvinsiAsal' => $data->ProvinsiAsal,
                    'KabAsal' => $data->KabAsal,
                    'KecAsal' => $data->KecAsal,
                    'KelAsal' => $data->KelAsal,
                    'RT' => $data->RT,
                    'RW' => $data->RW,
                    'AlamatAsal' => $data->AlamatAsal,
                    'AlamatSekarang' => $data->AlamatSekarang,
                    'Tujuan' => $data->Tujuan,
                    'TglMasuk' => $data->TglMasuk,
                    'TglKeluar' => $data->TglKeluar,
                    'Wilayah' => $data->Wilayah,
                    'Foto' => $data->Foto,
                    'KTP' => $data->KTP,
                    'Latitude' => $data->Latitude,
                    'Longitude' => $data->Longitude,
                    'AlasanPenolakan' => $data->AlasanPenolakan,
				);
				echo json_encode($response);
			} else {
				echo json_encode(null);
			}
		}

        public function detailpendatang($KodePendatang)
        {
            $data = $this->Model_pendatang->get_detailpendatang($KodePendatang);
            echo json_encode($data);
        }

        public function toggleVerifikasiAkun($KodePendatang) // pop up yang untuk aktivasi diproses dan tolak
        {
            $data = $this->Model_pendatang->get_detailpendatang($KodePendatang);
            $currentStatus = $data->StatusVerifikasi;

            switch ($currentStatus) {
                case 'Diproses':
                    $this->Model_pendatang->updateStatusVerifikasi($KodePendatang, 'Diterima');
                    echo json_encode(['status' => 'accept']);
                    break;
                case 'Diterima':
                    $this->Model_pendatang->updateStatusVerifikasi($KodePendatang, 'Ditolak');
                    echo json_encode(['status' => 'rejected']);
                    break;
                case 'Ditolak':
                default:
                    $this->Model_pendatang->updateStatusVerifikasi($KodePendatang, 'Diproses');
                    echo json_encode(['status' => 'processing']);
                    break;
            }
        }

        public function updateStatusVerifikasi($KodePendatang)
        {
            $newStatus = $this->input->post('status');
            if (!in_array($newStatus, ['Diproses', 'Diterima', 'Ditolak'])) {
                echo json_encode(['status' => 'error', 'message' => 'Status tidak valid.']);
                return;
            }
            $this->Model_pendatang->updateStatusVerifikasi($KodePendatang, $newStatus);
            echo json_encode(['status' => $newStatus]);
        }

        public function get_by_nik($nik)
        {
            $this->load->model('Model_Pendatang');
            $data = $this->Model_Pendatang->getByNik($nik);
            echo json_encode($data);
        }
        
    private function ambilNamaWilayah($jenis, $kode)
{
    $url = "";

    if ($jenis == "provinsi") {
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
    } elseif ($jenis == "kabupaten") {
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/" . substr($kode, 0, 2) . ".json";
    } elseif ($jenis == "kecamatan") {
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/" . substr($kode, 0, 4) . ".json";
    } elseif ($jenis == "kelurahan") {
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/villages/" . substr($kode, 0, 7) . ".json";
    }

    $json = @file_get_contents($url);
    if (!$json) return '-';

    $data = json_decode($json);
    foreach ($data as $item) {
        if ($item->id == $kode) {
            return $item->name;
        }
    }

    return '-';
}

 public function laporan_bulanan()
{
    $bulan = $this->input->get('bulan'); // format: YYYY-MM, e.g., 2025-06
    $KodePJ = $this->session->userdata('KodePJ'); // Ambil KodePJ dari session

    // Jika bulan tidak diset, gunakan bulan saat ini sebagai default
    if (empty($bulan)) {
        $bulan = date('Y-m');
    }

    // Ambil data laporan bulanan dari model
    $data['hasil'] = $this->Model_pendatang->getDataLaporanBulanan($bulan, $KodePJ);
    $data['bulan_terpilih'] = $bulan; // Kirim bulan yang terpilih ke view

    // Load view laporan.
    // Jika ada hasil, tampilkan tabel. Jika tidak, tampilkan pesan peringatan.
    // Tidak perlu lagi 'redirect' di sini, karena kita akan langsung menampilkan view.
    $data['table'] = $this->load->view('Laporan_pendatang_view', $data, TRUE);

    // Load tampilan admin_view dengan konten laporan
    $this->load->view('admin_view', $data);
}

    // Di Pendatang.php, dalam fungsi cetak_laporan_pdf()

public function cetak_laporan_pdf()
{
    $kodePJ = $this->session->userdata('KodePJ');
    $bulanFilter = $this->input->get('bulan');

    if (empty($bulanFilter)) {
        $bulanFilter = date('Y-m');
    }

    // Ambil data dari model
    $data['hasil'] = $this->Model_pendatang->getDataLaporanBulanan($bulanFilter, $kodePJ);
    $data['bulan'] = $bulanFilter;

    // Tambahkan jumlah total pendatang
    $data['total_pendatang'] = count($data['hasil']);

    // --- Tambahkan ini untuk path gambar ---
    // FCPATH adalah konstanta CodeIgniter yang mengarah ke root folder aplikasi Anda
$logo_path = FCPATH . 'img/DESA.png'; // Make sure this path is correct
    if (file_exists($logo_path) && is_readable($logo_path)) {
        $type = pathinfo($logo_path, PATHINFO_EXTENSION);
        $data_uri = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logo_path));
        $data['logo_src'] = $data_uri;
    } else {
        // Fallback or log an error if image not found/readable
        $data['logo_src'] = ''; // Or a placeholder image data URI
        log_message('error', 'Dompdf: Could not load logo for Base64 encoding from: ' . $logo_path);
    }
    // --- End Base64 encoding ---

    // Render view to HTML
    $html = $this->load->view('laporan_pdf_view', $data, TRUE);
    // Load ke PDF
    $this->pdf->loadHtml($html);
    $this->pdf->setPaper('A4', 'portrait');
    $this->pdf->render();
    $this->pdf->stream("laporan_pendatang_" . $bulanFilter . ".pdf", array("Attachment" => 0));
}
}	
?>