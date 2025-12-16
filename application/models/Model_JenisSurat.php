<?php
class Model_JenisSurat extends CI_Model {

    function combojenis ($namafield)
	{
		$sql="select * from tbjenis_surat";
			$query=$this->db->query($sql);

			$data[""]="Pilih";
			$no=1;
			foreach ($query->result() as $row )
			{
				$data[$row->KodeJenis]=$no.") ".$row->NamaJenis;
				$no++;
			}
			echo form_dropdown($namafield,$data,"","class='form-control' id='".$namafield."'");
	}

	public function getFieldIsian($kodeJenis)
	{
		$this->db->where('KodeJenis', $kodeJenis);
		$query = $this->db->get('tbjenis_surat');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return json_decode($row->FieldIsian); // decode JSON
		}
		return [];
	}

	function combokaling($namafield)
{
    $sql = "SELECT * FROM tbkaling WHERE StatusAktivasi = 'Terverifikasi'";
    $query = $this->db->query($sql);

    echo "<select name='$namafield' id='$namafield' class='form-control select2'>";
    echo "<option value='null'>Pilih Kepala Lingkungan</option>";

    foreach ($query->result() as $row) {
        $label = "<strong>{$row->NamaLengkap}</strong><br><small>{$row->Jabatan}</small>";
        $label_plain = "{$row->NamaLengkap} ({$row->Jabatan})"; // fallback teks
        echo "<option value='{$row->KodeKaling}' data-html=\"" . htmlentities($label) . "\">{$label_plain}</option>";
    }

    echo "</select>";
}

}
?>