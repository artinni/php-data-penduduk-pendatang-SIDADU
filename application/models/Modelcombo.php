<?php
	class Modelcombo extends CI_Model
	{
		function combopj($namafield)
{
    // Tambahkan kondisi WHERE pada query SQL
    $sql = "SELECT * FROM tbpj WHERE StatusAktivasi = 'Terverifikasi'";
    $query = $this->db->query($sql);

    $data["null"] = "Pilih Penanggung Jawab";
    $no = 1;
    foreach ($query->result() as $row) {
        $data[$row->KodePJ] = $no . ") " . $row->NamaLengkap;
        $no++;
    }

    echo form_dropdown($namafield, $data, "", "class='form-control' id='" . $namafield . "'");
	}
	
			public function get_NamaLengkap($KodePJ) {
			$sql = "SELECT NamaLengkap FROM tbpj WHERE KodePJ = ?";
			$query = $this->db->query($sql, array($KodePJ));
			if ($query->num_rows() > 0) {
				return $query->row()->NamaLengkap;
			}
			return null;
		}


	}
?>