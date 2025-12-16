<?php
class JenisSurat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('validasi');
        $this->load->model('Model_JenisSurat');
        $this->validasi->validasiakun();
    }

    function index ()
    {
        $datalist['hasil']=$this->tampildata();
        $data['konten']=$this->load->view('JenisSurat_view','',TRUE);
        $data['table']=$this->load->view('JenisSurat_tabel', $datalist, TRUE);
        $this->load->view('admin_view', $data);
    }

    function datajenis()
    {
        $datalist['hasil']=$this->tampildata();
		$data['table']=$this->load->view('JenisSurat_view', $datalist,TRUE);
		$this->load->view('admin_view',$data);
    }

    public function simpanJenisSurat()
    {
        $fieldIsian = $this->input->post('FieldIsian');
        $data = array(
             'NamaJenis' => $this->input->post('NamaJenis'),
             'Deskripsi' => $this->input->post('Deskripsi'),
             'DibuatOleh' => $this->session->userdata('Username'),
             'FieldIsian' => json_encode($fieldIsian) // simpan sebagai JSON
            );

            $KodeJenis = $this->input->post('KodeJenis');

            if (!empty($KodeJenis)) {
                // Update data
                $this->db->where('KodeJenis', $KodeJenis);
                $this->db->update('tbjenis_surat', $data);
                $this->session->set_flashdata('pesan', 'Data berhasil diperbarui');
            } else {
                // Insert data baru
                $this->db->insert('tbjenis_surat', $data);
                $this->session->set_flashdata('pesan', 'Data berhasil disimpan');
            }

            redirect('JenisSurat');
    }

    function tampildata()
    {
         $sql = "SELECT * FROM tbjenis_surat ORDER BY KodeJenis DESC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result(); // Kembalikan semua data
        } else {
            return []; // Kembalikan array kosong jika tidak ada data
        }
    }
    

    function hapusjenis($KodeJenis)
        {
            $sql="delete from tbjenis_surat where KodeJenis='".$KodeJenis."'";
            $this->db->query($sql); //jalankan querry

            redirect('JenisSurat/index', 'refresh');
        }

    public function editjenis($KodeJenis)
	{
		$this->db->where('KodeJenis', $KodeJenis);
		$query = $this->db->get('tbjenis_surat');
		
		if ($query->num_rows() > 0) {
			$data = $query->row();
			$response = array(
				'KodeJenis' => $data->KodeJenis,
				'NamaJenis' => $data->NamaJenis,
                'Deskripsi' => $data->Deskripsi,
			);
			echo json_encode($response);
		} else {
			echo json_encode(null);
		}
		}
}
?>