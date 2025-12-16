<?php
	class Validasi extends CI_Model
	{
		function validasiakun()
		{
			$JenisAkun=$this->session->userdata('JenisAkun');
			if($JenisAkun=="")
			{
				echo "<script>alert('Maaf anda tidak dapat mengakses halaman ini')</script>";
				redirect('Halamanlog','refresh');	
			}	
		}
		
				// Validasi khusus Admin
		public function validasiadmin()
		{
			if ($this->session->userdata('JenisAkun') !== 'Admin') {
				redirect('Halamanlog');
			}
		}

		// Validasi khusus Kepala Lingkungan
		public function validasikaling()
		{
			if ($this->session->userdata('JenisAkun') !== 'KepalaLingkungan') {
				redirect('Halamanlog');
			}
		}

		// Validasi khusus Penanggung Jawab
		public function validasipj()
		{
			if ($this->session->userdata('JenisAkun') !== 'PenanggungJawab') {
				redirect('Halamanlog');
			}
		}

	}
?>