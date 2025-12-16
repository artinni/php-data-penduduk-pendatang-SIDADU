<?php 
class Kaling extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('validasi');
        $this->load->model('Model_kaling');
        $this->load->model('Model_wilayah');
    }

    public function index()
    {
        $datalist['hasil'] = $this->tampildata();
        $data['konten'] = $this->load->view('Kaling_view', '', TRUE);
        $data['table'] = $this->load->view('Kaling_tabel', $datalist, TRUE);
        $this->load->view('admin_view', $data);
    }

    public function datakaling()
    {
        $datalist['hasil'] = $this->tampildata();
        $table1 = $this->load->view('DataKaling_view', $datalist, TRUE);
        $table2 = $this->load->view('DataKaling2_view', $datalist, TRUE);
        $data['table'] = $table1 . $table2;
        $this->load->view('admin_view', $data);
    }

    public function simpankaling()
    {
        $KodeKaling = $this->input->post('KodeKaling');

        $data = array(
            'Username' => $this->input->post('Username'),
            'NamaLengkap' => $this->input->post('NamaLengkap'),
            'Jabatan' => $this->input->post('Jabatan'),
            'JenisKelamin' => $this->input->post('JenisKelamin'),
            'Email' => $this->input->post('Email'),
            'Password' => password_hash($this->input->post('Password'), PASSWORD_DEFAULT),
            'Alamat' => $this->input->post('Alamat'),
            'Telp' => $this->input->post('Telp'),
            'Provinsi' => $this->input->post('Provinsi'),
            'Kabupaten' => $this->input->post('Kabupaten'),
            'Kecamatan' => $this->input->post('Kecamatan'),
            'Kelurahan' => $this->input->post('Kelurahan'),
            'StatusAktivasi' => "Diproses",
            'JenisAkun' => "Kaling"
        );

        if (!empty($KodeKaling)) {
            $this->db->where('KodeKaling', $KodeKaling);
            $this->db->update('tbkaling', $data);
            $this->session->set_flashdata('pesan', 'Data berhasil diperbarui');
        } else {
            $this->db->insert('tbkaling', $data);
            $this->session->set_flashdata('pesan', 'Data berhasil disimpan');
        }

        redirect('Kaling');
    }

    public function tampildata()
    {
        $status = $this->input->get('status');
        $this->db->from('tbkaling');

        if (!empty($status)) {
            $this->db->where('StatusAktivasi', $status);
        }

        $this->db->order_by('KodeKaling', 'DESC');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    public function hapuskaling($KodeKaling)
    {
        $this->db->where('KodeKaling', $KodeKaling);
        $this->db->delete('tbkaling');

        redirect('Kaling/index', 'refresh');
    }

    public function editkaling($KodeKaling)
    {
        $this->db->where('KodeKaling', $KodeKaling);
        $query = $this->db->get('tbkaling');

        if ($query->num_rows() > 0) {
            $data = $query->row();
            $response = array(
                'KodeKaling' => $data->KodeKaling,
                'Username' => $data->Username,
                'NamaLengkap' => $data->NamaLengkap,
                'JenisKelamin' => $data->JenisKelamin,
                'Email' => $data->Email,
                'Password' => $data->Password,
                'Alamat' => $data->Alamat,
                'Provinsi' => $data->Provinsi,
                'Kabupaten' => $data->Kabupaten,
                'Kecamatan' => $data->Kecamatan,
                'Kelurahan' => $data->Kelurahan,
                'Jabatan' => $data->Jabatan,
                'Telp' => $data->Telp
            );
            echo json_encode($response);
        } else {
            echo json_encode(null);
        }
    }

    public function detailkaling($KodeKaling)
    {
        $data = $this->db->get_where('tbkaling', ['KodeKaling' => $KodeKaling])->row();

        if ($data) {
            $response = [
                'Username' => $data->Username,
                'NamaLengkap' => $data->NamaLengkap,
                'Alamat' => $data->Alamat,
                'Telp' => $data->Telp,
                'Email' => $data->Email,
                'StatusAktivasi' => $data->StatusAktivasi,
                'NamaProvinsi' => $this->ambilNamaWilayah('provinsi', $data->Provinsi),
                'NamaKabupaten' => $this->ambilNamaWilayah('kabupaten', $data->Kabupaten),
                'NamaKecamatan' => $this->ambilNamaWilayah('kecamatan', $data->Kecamatan),
                'NamaKelurahan' => $this->ambilNamaWilayah('kelurahan', $data->Kelurahan),
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }

    public function toggleAktivasiAkun($KodeKaling)
{
    $data = $this->Model_kaling->get_detailkaling($KodeKaling);
    
    if ($data->StatusAktivasi == 'Diproses') {
        $newStatus = 'Terverifikasi';
    } elseif ($data->StatusAktivasi == 'Terverifikasi') {
        $newStatus = 'Ditolak';
    } else {
        $newStatus = 'Diproses';
    }

    $this->Model_kaling->updateStatusAktivasi($KodeKaling, $newStatus);
    echo json_encode(['status' => $newStatus]);
}

public function tolakAkun($KodeKaling)
{
    $this->load->model('Model_kaling');
    $updated = $this->Model_kaling->updateStatusAktivasi($KodeKaling, 'Ditolak');

    if ($updated) {
        echo json_encode(['status' => 'Ditolak']);
    } else {
        echo json_encode(['status' => 'Gagal']);
    }
}

public function verify_email($token)
{
    $user = $this->db->get_where('tbkaling', ['EmailToken' => $token])->row();

    if ($user) {
        $this->db->where('KodeKaling', $user->KodeKaling);
        $this->db->update('tbkaling', [
            'StatusAktivasi' => 'Terverifikasi',
            'EmailToken' => NULL
        ]);
        $data['status'] = 'sukses'; // ✅ Kirim status ke view
    } else {
        $data['status'] = 'gagal'; // ✅ Kirim status ke view
    }

    // ✅ Tampilkan hasil ke view
    $this->load->view('email_verify', $data);
}

    public function form()
    {
        $this->db->order_by('KodeKaling', 'desc');
        $data = [];
        $this->load->view('form_kaling', $data);
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
}
?>
