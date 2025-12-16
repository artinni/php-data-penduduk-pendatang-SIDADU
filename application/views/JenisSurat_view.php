<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function simpanJenisSurat() {
    var NamaJenis = $('#NamaJenis').val();
    if (NamaJenis == "") {
        alert("Nama Jenis Surat masih kosong...");
        $('#NamaJenis').focus();
        return false;
    }
    $('#formJenisSurat').submit();
}
</script>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Jenis Surat</title>
  <style>
    .form-section {
      background: #fff;
      padding: 20px;
      margin-top: 30px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-section h3 {
      text-align: center;
      color: #fff;
      margin-bottom: 20px;
      background-color: #674188;
      padding: 10px;
      border-radius: 5px;
    }
    table.form-table {
      width: 100%;
    }
    table.form-table td {
      padding: 10px;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container">
    <div class="form-section">
      <h3>Form Jenis Surat</h3>
      <?php
      $pesan = $this->session->flashdata('pesan');
      if ($pesan != "") {
        echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>' . $pesan . '
              </div>';
      }
      ?>
<form method="post" id="formJenisSurat" action="<?php echo base_url('JenisSurat/simpanJenisSurat'); ?>">
    <input type="hidden" name="KodeJenis" id="KodeJenis"/>

    <table class="form-table">
      <tr>
        <td><label for="NamaJenis">Nama Jenis Surat</label></td>
        <td><input type="text" name="NamaJenis" id="NamaJenis" class="form-control"></td>
      </tr>
      <tr>
        <td><label>Deskripsi</label></td>
        <td><textarea type="text" name="Deskripsi" id="Deskripsi" class="form-control" rows="4"></textarea></td>
      </tr>
      <tr>
        <td>
          <label>Pilih data pendatang yang akan ditampilkan di surat:</label><br>
        </td>
        <td>
          <div class="row">
            <?php
            $fields = [
                'NamaLengkap' => 'Nama Lengkap',
                'NoTelp' => 'No. Telepon', 
                'TempatLahir' => 'Tempat Lahir',
                'TanggalLahir' => 'Tanggal Lahir',
                'JenisKelamin' => 'Jenis Kelamin',
                'GolonganDarah' => 'Golongan Darah',
                'Agama' => 'Agama',
                'ProvinsiAsal' => 'Provinsi Asal',
                'KabAsal' => 'Kabupaten Asal',
                'KecAsal' => 'Kecamatan Asal',
                'KelAsal' => 'Kelurahan Asal',
                'RT' => 'RT',
                'RW' => 'RW',
                'AlamatAsal' => 'Alamat Asal',
                'AlamatSekarang' => 'Alamat Sekarang',
                'Tujuan' => 'Tujuan',
                'TglMasuk' => 'Tanggal Masuk',
                'TglKeluar' => 'Tanggal Keluar',
                'Wilayah' => 'Wilayah'
            ];
            
            foreach ($fields as $value => $label) {
                echo '<div class="col-md-4 col-sm-6 mb-2">';
                echo '<div class="form-check">';
                echo "<input class='form-check-input' type='checkbox' name='FieldIsian[]' value='$value' id='field_$value'>";
                echo "<label class='form-check-label' for='field_$value'>$label</label>";
                echo '</div>';
                echo '</div>';
            }
            ?>
          </div>
        </td>
      </tr>
    </table>
        <div class="text-center mt-4">
          <input type="button" value="Simpan" class="btn btn-primary" onclick="simpanJenisSurat();">
          <input type="reset" value="Reset" class="btn btn-warning">
        </div>
      </form>
    </div>
  </div>
</body>
</html>
