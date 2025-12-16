<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 use Dompdf\Dompdf;
class Surat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require_once APPPATH . 'libraries/dompdf/vendor/autoload.php';
        $this->load->model('validasi');
        $this->load->model('Model_JenisSurat');
        $this->validasi->validasiakun();
    }
    function index ()
    {
        $datalist['hasil']=$this->tampildata();
        $data['konten']=$this->load->view('Surat_view','',TRUE);
        $data['table']=$this->load->view('Surat_tabel', $datalist, TRUE);
        $this->load->view('admin_view', $data);
    }
function pengajuan()
{
    $datalist['hasil'] = $this->tampildata();
    $data['JenisAkun'] = $this->session->userdata('JenisAkun');
    $data['surat'] = $datalist['hasil'][0]; // hanya ambil 1 jika memang cuma 1 yang dipreview

    $data['konten'] = $this->load->view('SuratPengajuan_view', $data, TRUE);
    $this->load->view('admin_view', $data);
}
   //nampilin draft suratnya

function datasurat()
    {
        $datalist['hasil']=$this->tampildata();
		$data['table']=$this->load->view('DataSurat_view', $datalist,TRUE);
		$this->load->view('admin_view',$data);
    }

    public function get_data_pendatang($nik) {
    $query = $this->db->get_where('tbpendatang', ['NIK' => $nik])->row_array();
    echo json_encode($query ?? []);
    }

    public function simpanSurat() 
    {

    $KodeKaling = $this->input->post('KodeKaling');
    $KodeJenis = $this->input->post('KodeJenis');
    if ($KodePJ === "null") {
        $this->session->set_flashdata('pesan', 'Penanggung Jawab belum dipilih!');
        redirect('Pendatang/index', 'refresh');
        return;
    }
    $NIK = $this->input->post('NIK');
    $Catatan = $this->input->post('Catatan');
    $Tanggal_Surat = date('Y-m-d');
    $Waktu_Dibuat = date('Y-m-d H:i:s');

    // Cek apakah NIK valid dan ambil data pendatang
    $pendatang = $this->db->get_where('tbpendatang', ['NIK' => $NIK, 'StatusVerifikasi' => 'Diterima'])->row();
    if (!$pendatang) {
        $this->session->set_flashdata('pesan', 'NIK tidak ditemukan atau belum diverifikasi.');
        redirect('Surat/index');
        return;
    }

    $KodePendatang = $pendatang->KodePendatang;

    // Ambil field tambahan dinamis
    $fields = $this->input->post();
    unset($fields['KodeJenis'], $fields['NIK'], $fields['Catatan'], $fields['KodeKaling'], $fields['StatusSurat']);


    // Encode field tambahan
    $fieldTambahan = json_encode($fields);

$jenisSurat = $this->db->get_where('tbjenis_surat', ['KodeJenis' => $KodeJenis])->row();
$kodeJenisSurat = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $jenisSurat->NamaJenis), 0, 3)); // Ambil 3 huruf, huruf saja

$bulan = date('m');
$tahun = date('Y');

// Cek nomor terakhir yang sama jenis dan bulan
$this->db->select('Nomor_Surat');
$this->db->from('tbsurat');
$this->db->like('Nomor_Surat', '/' . $kodeJenisSurat . '/' . $bulan . '/' . $tahun);
$this->db->order_by('Nomor_Surat', 'DESC');
$this->db->limit(1);
$last = $this->db->get()->row();

if ($last) {
    preg_match('/^(\d{3})/', $last->Nomor_Surat, $matches);
    $next_number = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
} else {
    $next_number = 1;
}

// Format nomor surat
$nomorSuratFormatted = str_pad($next_number, 3, '0', STR_PAD_LEFT) . "/$kodeJenisSurat/$bulan/$tahun";
    // Simpan ke database
   $data = [
    'KodeJenis' => $KodeJenis,
    'KodeKaling'=>$KodeKaling,
    'KodePendatang' => $KodePendatang,
    'Nomor_Surat' => $nomorSuratFormatted,
    'Tanggal_Surat' => $Tanggal_Surat,
    'Waktu_Dibuat' => $Waktu_Dibuat,
    'Dibuat_Oleh' => $this->session->userdata('NamaLengkap'),
    'FieldTambahan' => $fieldTambahan,
    'Catatan' => $Catatan
    ];

    $this->db->insert('tbsurat', $data);
    $KodeSurat = $this->db->insert_id();

// Cek apakah status langsung "Siap"
$status = $this->input->post('StatusSurat');
if ($status == 'Siap') {
    // Ambil data Kaling yang akan tanda tangan
    $kaling = $this->db->get_where('tbkaling', ['KodeKaling' => $KodeKaling])->row();

    if ($kaling) {
        // ✅ Load library QR
        $this->load->library('ciqrcode');

        // Siapkan data QR (misal berisi nama, jabatan, wilayah, waktu)
        $qr_data = "Nama: {$kaling->NamaLengkap}\n"
                 . "Jabatan: {$kaling->Jabatan}\n"
                 . "Alamat: {$kaling->Alamat}\n"
                 . "Telp: {$kaling->Telp}";

        $qr_name = 'ttd_surat_' . $KodeSurat . '.png';
        $params['data'] = $qr_data;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . 'uploads/qrcode/' . $qr_name;
        $this->ciqrcode->generate($params);

        // Update QR code di tbsurat
        $this->db->where('KodeSurat', $KodeSurat);
        $this->db->update('tbsurat', ['TandaTanganQR' => $qr_name]);
    }
} 
    $this->session->set_flashdata('pesan', 'Surat berhasil diajukan.');
    redirect('Surat/index');
}

   public function tampildata()
{
    $JenisAkun = $this->session->userdata('JenisAkun');
    $KodeKaling = $this->session->userdata('KodeKaling');

    $whereKaling = "";
    if ($JenisAkun == 'Kaling') {
        // Tambahkan filter WHERE jika yang login adalah Kaling
        $whereKaling = "WHERE s.KodeKaling = " . $this->db->escape($KodeKaling);
    }

    $sql = "SELECT 
                s.*, 
                js.NamaJenis, 
                js.DibuatOleh AS DibuatOlehJenis,
                p.NamaLengkap AS NamaPengusul,
                k.NamaLengkap AS AccSuratOleh
            FROM tbsurat s
            JOIN tbjenis_surat js ON s.KodeJenis = js.KodeJenis
            JOIN tbpendatang p ON s.KodePendatang = p.KodePendatang
            LEFT JOIN tbkaling k ON s.KodeKaling = k.KodeKaling
            $whereKaling
            ORDER BY s.Waktu_Dibuat DESC";

    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result() : [];
}


public function suratPengajuan($KodeSurat)
{
    // 1. Ambil data surat dari database
    $this->db->select('s.*, s.catatan_penolakan, js.NamaJenis, js.DibuatOleh AS DibuatOlehJenis, 
    p.NamaLengkap, p.NIK, k.NamaLengkap AS AccSuratOleh, 
    k.Jabatan AS JabatanKaling');
    $this->db->from('tbsurat s');
    $this->db->join('tbjenis_surat js', 's.KodeJenis = js.KodeJenis');
    $this->db->join('tbpendatang p', 's.KodePendatang = p.KodePendatang');
    $this->db->join('tbkaling k', 's.KodeKaling = k.KodeKaling', 'left');
    $this->db->where('s.KodeSurat', $KodeSurat);
    $surat = $this->db->get()->row();

    if (!$surat) {
        show_404(); // Jika surat tidak ditemukan
    }
    
    // Cek apakah file PDF sudah ada dan terdaftar di database
    $pdf_filename = 'surat_' . $surat->KodeSurat . '.pdf';
    $pdf_path = FCPATH . 'uploads/surat/' . $pdf_filename; 
    
    // Pastikan folder uploads/surat/ ada
    $upload_path = FCPATH . 'uploads/surat/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, TRUE);
    }
    
    if (empty($surat->File_Lampiran) || !file_exists($pdf_path)) {
        $dompdf = new Dompdf();
        $fieldTambahan = json_decode($surat->FieldTambahan, true);
        
        $data_surat_pdf = [
            'surat' => $surat,
            'field_tambahan' => $fieldTambahan
        ];

        $html = $this->load->view('surat_template', $data_surat_pdf, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($pdf_path, $dompdf->output());

        $this->db->where('KodeSurat', $surat->KodeSurat);
        $this->db->update('tbsurat', ['File_Lampiran' => $pdf_filename]);
        
        $surat->File_Lampiran = $pdf_filename;
    }

    // Siapkan data untuk view utama (halaman admin)
    $data['surat'] = $surat; // <-- Pastikan ini ada
    $data['konten'] = $this->load->view('SuratPengajuan_view', $data, TRUE);
    
    // Tampilkan view admin_view yang berisi SuratPengajuan_view di dalamnya
    $this->load->view('admin_view', $data);
}

    public function get_field_isian($kodeJenis)
    {
        $data = $this->Model_JenisSurat->getFieldIsian($kodeJenis);
        echo json_encode($data); // return array field isian
    }

    function hapussurat($KodeSurat)
        {
            $sql="delete from tbsurat where KodeSurat='".$KodeSurat."'";
            $this->db->query($sql); //jalankan querry

            redirect('Surat/index', 'refresh');
        }

// Di Surat.php, dalam fungsi setujuiSurat($KodeSurat)

public function setujuiSurat($KodeSurat)
{
    // Ubah status jadi Siap
    $this->db->where('KodeSurat', $KodeSurat);
    $this->db->update('tbsurat', ['status' => 'Siap']);

    // Ambil data surat setelah update
    $surat = $this->db->get_where('tbsurat', ['KodeSurat' => $KodeSurat])->row();

    // Generate QR Code
    $this->load->library('ciqrcode');

    // --- MODIFIKASI: QR_DATA MENGARAH KE FUNGSI VALIDASI ---
    $qr_data = base_url('Surat/validasi_surat/' . $KodeSurat);
    // --- AKHIR MODIFIKASI ---

    $qr_path = FCPATH . 'uploads/qrcode/';
    $qr_filename = $KodeSurat . '.png';
    $qr_file = $qr_path . $qr_filename;

    if (!is_dir($qr_path)) {
        mkdir($qr_path, 0777, true);
    }

    $params['data'] = $qr_data;
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = $qr_file;

    $this->ciqrcode->generate($params);

    // Simpan nama file QR ke kolom `TandaTangan` (sudah benar)
    $this->db->where('KodeSurat', $KodeSurat);
    $this->db->update('tbsurat', ['TandaTangan' => $qr_filename]);

    $this->session->set_flashdata('pesan', [
        'message' => 'Surat berhasil disetujui dan QR code disimpan.',
        'type' => 'success'
    ]);

    redirect('Surat/datasurat');
}

// untuk status permohonan
public function permohonanSurat($KodeSurat) {
    $this->db->where('KodeSurat', $KodeSurat);
    $this->db->update('tbsurat', ['status' => 'Permohonan']);
    $this->session->set_flashdata('pesan', 'Surat pengajuan dalam permohonan');
    redirect('Surat/index');
}

public function tolakSurat() {
    $KodeSurat = $this->input->post('KodeSurat');
    $catatan = $this->input->post('catatan_penolakan');

    $this->db->where('KodeSurat', $KodeSurat);
    $this->db->update('tbsurat', [
        'status' => 'Tolak',
        'catatan_penolakan' => $catatan
    ]);

    $this->session->set_flashdata('pesan', [
        'message' => 'Surat berhasil ditolak dengan catatan.',
        'type' => 'danger'
    ]);

    redirect('Surat/datasurat');
}

public function cetakSurat($KodeSurat)
{
    $this->db->select('s.*, js.NamaJenis, 
        js.DibuatOleh AS DibuatOlehJenis, 
        p.NamaLengkap AS NamaPengusul, 
        k.NamaLengkap AS AccSuratOleh,
        k.Jabatan AS JabatanKaling, 
        k.Kelurahan AS KodeKelurahanKaling');
    $this->db->from('tbsurat s');
    $this->db->join('tbjenis_surat js', 's.KodeJenis = js.KodeJenis');
    $this->db->join('tbpendatang p', 's.KodePendatang = p.KodePendatang');
    $this->db->join('tbkaling k', 's.KodeKaling = k.KodeKaling', 'left');
    $this->db->where('s.KodeSurat', $KodeSurat);
    $surat = $this->db->get()->row();

    // Validasi terlebih dahulu sebelum akses properti
    if (!$surat || $surat->status !== 'Siap') {
        show_error('Surat tidak ditemukan atau belum disetujui', 404);
        return;
    }

    // Ambil nama kelurahan berdasarkan kode
    $nama_kelurahan_kaling = $this->ambilNamaWilayah('kelurahan', $surat->KodeKelurahanKaling);

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);

    $fieldTambahan = json_decode($surat->FieldTambahan, true);

    $data_surat_pdf = [
        'surat' => $surat,
        'field_tambahan' => $fieldTambahan,
        'nama_kelurahan_kaling' => $nama_kelurahan_kaling
    ];

    $html = $this->load->view('surat_template', $data_surat_pdf, TRUE);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("Surat_" . $surat->KodeSurat . ".pdf", array("Attachment" => false));
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

// Di Surat.php, tambahkan di bagian bawah setelah fungsi cetakSurat atau di mana saja yang sesuai

public function validasi_surat($KodeSurat)
{
    // Ambil data surat berdasarkan KodeSurat
    $this->db->select('s.*, js.NamaJenis, p.NamaLengkap AS NamaPengusul, k.NamaLengkap AS AccSuratOleh,
    k.Jabatan AS JabatanKaling');
    $this->db->from('tbsurat s');
    $this->db->join('tbjenis_surat js', 's.KodeJenis = js.KodeJenis', 'left');
    $this->db->join('tbpendatang p', 's.KodePendatang = p.KodePendatang', 'left');
    $this->db->join('tbkaling k', 's.KodeKaling = k.KodeKaling', 'left'); // Bergabung dengan tabel Kaling
    $this->db->where('s.KodeSurat', $KodeSurat);
    $surat = $this->db->get()->row();

    $data = []; // Inisialisasi array data
    if ($surat) {
        // Jika surat ditemukan
        $data['surat'] = $surat;
        $data['valid'] = ($surat->status == 'Siap'); // Surat sah jika statusnya 'Siap'
        $data['message'] = '';

        if ($data['valid']) {
            $data['message'] = 'Surat ini SAH dan telah disetujui.';
            $data['alert_class'] = 'alert-success';
        } else if ($surat->status == 'Tolak') {
            $data['message'] = 'Surat ini DITOLAK. Catatan: ' . ($surat->catatan_penolakan ?? 'Tidak ada catatan.');
            $data['alert_class'] = 'alert-danger';
        } else if ($surat->status == 'Permohonan') {
            $data['message'] = 'Surat ini masih dalam status PERMOHONAN (belum disetujui).';
            $data['alert_class'] = 'alert-warning';
        } else {
             $data['message'] = 'Status surat TIDAK DIKETAHUI.';
            $data['alert_class'] = 'alert-secondary';
        }

    } else {
        // Jika surat tidak ditemukan
        $data['surat'] = null;
        $data['valid'] = false;
        $data['message'] = 'Surat dengan kode tersebut **TIDAK DITEMUKAN** atau tidak valid.';
        $data['alert_class'] = 'alert-danger';
    }

    // Load view untuk menampilkan hasil validasi
    // Tidak perlu admin_view karena ini adalah halaman publik untuk validasi
    
    $this->load->view('validasi_surat_view', $data);
}

}
?>