<?php
    class Penanggungjawab extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('validasi');
            $this->load->model('Model_pj');
        }

        function index () //untuk tampilan menambah PJ
        {
            $datalist['hasil']=$this->tampildata();
            $data['konten']=$this->load->view('Penanggungjawab_view','',TRUE);
            $data['table']=$this->load->view('Penanggungjawab_tabel', $datalist, TRUE);
            $this->load->view('admin_view', $data);
        }

        function datapj() 
        {
            $datalist['hasil'] = $this->tampildata();
            $table1 = $this->load->view('DataPJ_view', $datalist, TRUE);
            $table2 = $this->load->view('DataPJ2_view', $datalist, TRUE);
            $data['table'] = $table1 . $table2;
            $this->load->view('admin_view', $data);	
        }
        public function simpanpj()
        {
            $data = array(
                'Username' => $this->input->post('Username'),
                'NamaLengkap' => $this->input->post('NamaLengkap'),
                'JenisKelamin' => $this->input->post('JenisKelamin'),
                'Email' => $this->input->post('Email'),
                'Password'        => password_hash($this->input->post('Password'), PASSWORD_DEFAULT),
                'Wilayah'=>$this->input->post('Wilayah'),
                'Alamat' => $this->input->post('Alamat'),
                'Telp' => $this->input->post('Telp'),
                'StatusAktivasi'=>"Diproses",
                'JenisAkun'=>"Penanggungjawab"
            );

            $KodePJ = $this->input->post('KodePJ');

            if (!empty($KodePJ)) {
                // Update data
                $this->db->where('KodePJ', $KodePJ);
                $this->db->update('tbpj', $data);
                $this->session->set_flashdata('pesan', 'Data berhasil diperbarui');
            } else {
                // Insert data baru
                $this->db->insert('tbpj', $data);
                $this->session->set_flashdata('pesan', 'Data berhasil disimpan');
            }

            redirect('Penanggungjawab');
        }

        function tampildata()
        {
            $status = $this->input->get('status'); // ambil dari URL jika ada
            $this->db->from('tbpj');

            if (!empty($status)) {
                $this->db->where('StatusAktivasi', $status);
            }
            $this->db->order_by('KodePJ', 'DESC');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return [];
            }
        }

        
        function hapuspj($KodePJ)
        {
            $sql="delete from tbpj where KodePJ='".$KodePJ."'";
            $this->db->query($sql); //jalankan querry

            redirect('Penanggungjawab/index', 'refresh');
        }

        public function editpj($KodePJ)
		{
			$this->db->where('KodePJ', $KodePJ);
			$query = $this->db->get('tbpj');
			
			if ($query->num_rows() > 0) {
				$data = $query->row();
				$response = array(
					'KodePJ' => $data->KodePJ,
					'Username' => $data->Username,
					'NamaLengkap' => $data->NamaLengkap,
                    'JenisKelamin' => $data->JenisKelamin,
                    'Email' => $data->Email,
                    'Password' => $data->Password,
                    'Wilayah' => $data->Wilayah,
                    'Alamat' => $data->Alamat,
                    'Telp' => $data->Telp
				);
				echo json_encode($response);
			} else {
				echo json_encode(null);
			}
		}

        public function detailpj($KodePJ)
        {
            $data = $this->Model_pj->get_detailpj($KodePJ);
            echo json_encode($data);
        }

        public function getWilayahPJ() 
        {
            $KodePJ = $this->input->post('KodePJ');
            $this->load->model('Model_pj');
            $detail = $this->Model_pj->get_detailpj($KodePJ);
            if ($detail) {
                echo $detail->Wilayah; // pastikan nama kolomnya sama persis
            } else {
                echo "-";
            }
        }


       public function toggleAktivasiAkun($KodePJ) // pop up yang untuk aktivasi diproses dan tolak
        {
            $data = $this->Model_pj->get_detailpj($KodePJ);
            $currentStatus = $data->StatusAktivasi;

            switch ($currentStatus) {
                case 'Diproses':
                    $this->Model_pj->updateStatusAktivasi($KodePJ, 'Terverifikasi');
                    echo json_encode(['status' => 'verified']);
                    break;
                case 'Terverifikasi':
                    $this->Model_pj->updateStatusAktivasi($KodePJ, 'Ditolak');
                    echo json_encode(['status' => 'rejected']);
                    break;
                case 'Ditolak':
                default:
                    $this->Model_pj->updateStatusAktivasi($KodePJ, 'Diproses');
                    echo json_encode(['status' => 'processing']);
                    break;
            }
        }

        public function updateStatusAktivasi($KodePJ)
        {
            $newStatus = $this->input->post('status');
            if (!in_array($newStatus, ['Diproses', 'Terverifikasi', 'Ditolak'])) {
                echo json_encode(['status' => 'error', 'message' => 'Status tidak valid.']);
                return;
            }

            $this->Model_pj->updateStatusAktivasi($KodePJ, $newStatus);
            echo json_encode(['status' => $newStatus]);
        }

        public function verify_email($token)
        {
            // Cari PJ berdasarkan token
            $this->db->where('EmailToken', $token);
            $query = $this->db->get('tbpj');

            if ($query->num_rows() == 1) {
                // Jika token valid → update status aktivasi
                $this->db->where('EmailToken', $token);
                $this->db->update('tbpj', [
                    'StatusAktivasi' => 'Terverifikasi',
                    'EmailToken' => NULL
                ]);

                $data['status'] = 'sukses';
            } else {
                $data['status'] = 'gagal';
            }

            // Tampilkan hasil verifikasi
            $this->load->view('email_verify', $data);
        }
        


    }
?>