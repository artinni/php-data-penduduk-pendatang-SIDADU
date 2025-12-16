<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function simpanpj() {
    var Username = $('#Username').val();
    if (Username == "") {
        alert("Username masih kosong...");
        $('#Username').focus();
        return false;
    }
    $('#formpj').submit();
}
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penanggung Jawab</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   

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
            <h3>Form Data Penanggung Jawab</h3>
            <?php
            $pesan = $this->session->flashdata('pesan');
            if ($pesan != "") {
                echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ' . $pesan . '
                    </div>';
            }
            ?>
            <form method="post" id="formpj" action="<?php echo base_url('Penanggungjawab/simpanpj'); ?>">
                <input type="hidden" name="KodePJ" id="KodePJ"/>

                <table class="form-table">
                    <tr>
                        <td><label for="Username">Username (NIK KTP)</label></td>
                        <td><input type="text" name="Username" id="Username" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Lengkap (Isi Sesuai KTP)</label></td>
                        <td><input type="text" name="NamaLengkap" id="NamaLengkap" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Kelamin</label></td>
                        <td>
                            <select name="JenisKelamin" id="JenisKelamin" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>No Handphone</label></td>
                        <td><input type="text" name="Telp" id="Telp" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="email" name="Email" id="Email" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td><input type="password" name="Password" id="Password" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td><input type="text" name="Alamat" id="Alamat" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Wilayah yang dinaungi</label></td>
                        <td><input type="text" name="Wilayah" id="Wilayah" class="form-control"></td>
                    </tr>
                </table>

                <div class="text-center mt-4">
                    <input type="button" value="Simpan" class="btn btn-primary" onclick="simpanpj();">
                    <input type="reset" value="Reset" class="btn btn-warning">
                </div>
            </form>
        </div>
    </div>

</body>
</html>



