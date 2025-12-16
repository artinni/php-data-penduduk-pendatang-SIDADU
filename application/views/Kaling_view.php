<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script>
function simpankaling() {
    var Username = $('#Username').val();
    if (Username == "") {
        alert("Username masih kosong...");
        $('#Username').focus();
        return false;
    }
    $('#formkaling').submit();
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kaling</title>
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
            <h3>Form Data Kepala Lingkungan </h3>
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
            <form method="post" id="formkaling" action="<?php echo base_url('Kaling/simpankaling'); ?>">
                <input type="hidden" name="KodeKaling" id="KodeKaling"/>

                <table class="form-table">
                    <tr>
                        <td><label for="Username">Username (NIK KTP)</label></td>
                        <td><input type="text" name="Username" id="Username" class="form-control"></td>
                        <td><label for="Jabatan">Jabatan</label></td>
                        <td><input type="text" name="Jabatan" id="Jabatan" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Lengkap (Isi Sesuai KTP)</label></td>
                        <td><input type="text" name="NamaLengkap" id="NamaLengkap" class="form-control"></td>
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
                        <td><label>Email</label></td>
                        <td><input type="email" name="Email" id="Email" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td><input type="text" name="Alamat" id="Alamat" class="form-control"></td>
                        <td><label>Password</label></td>
                        <td><input type="password" name="Password" id="Password" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label for="">Provinsi</label></td>
                        <td>
                            <select name="Provinsi" id="Provinsi" class="form-control">
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </td>
                        <td><label for="">Kecamatan</label></td>
                        <td>
                            <select name="Kecamatan" id="Kecamatan" class="form-control">
                                <option value=""></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Kabupaten</label></td>
                        <td>
                            <select name="Kabupaten" id="Kabupaten" class="form-control">
                                <option value=""></option>
                            </select>
                        </td>    
                    <td><label for="">Kelurahan</label></td>
                        <td>
                            <select name="Kelurahan" id="Kelurahan" class="form-control">
                                <option value=""></option>
                            </select>
                        </td>
                        
                        
                    </tr>
                    
                </table>

                <div class="text-center mt-4">
                    <input type="button" value="Simpan" class="btn btn-primary" onclick="simpankaling();">
                    <input type="reset" value="Reset" class="btn btn-warning">
                </div>
            </form>
        </div>
    </div>
        <!-- Load Leaflet CSS dan JS Untuk PETA -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    
    function getNamaWilayah(id, tipe, elementId) {
    let url = "";

    switch(tipe) {
        case 'provinsi':
            url = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
            break;
        case 'kabupaten':
            url = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/" + id.substring(0, 2) + ".json";
            break;
        case 'kecamatan':
            url = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/" + id.substring(0, 4) + ".json";
            break;
        case 'kelurahan':
            url = "https://www.emsifa.com/api-wilayah-indonesia/api/villages/" + id.substring(0, 7) + ".json";
            break;
    }

    $.getJSON(url, function(data) {
        const result = data.find(item => item.id == id);
        document.getElementById(elementId).innerText = result ? result.name : '-';
    });
    }
$(document).ready(function() {
    $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json", function(data) {
    $.each(data, function(index, value) {
        $('#Provinsi').append('<option value="'+value.id+'">'+value.name+'</option>');
    });
    });
    // Load Kabupaten/Kota
    $('#Provinsi').change(function() {
        var ProvinsiID = $(this).val();
        $('#Kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
        $('#Kecamatan').html('<option value="">Pilih Kecamatan</option>');
        $('#Kelurahan').html('<option value="">Pilih Kelurahan/Desa</option>');
        if(ProvinsiID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/"+ProvinsiID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#Kabupaten').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    // Load Kecamatan
    $('#Kabupaten').change(function() {
        var KabupatenID = $(this).val();
        $('#Kecamatan').html('<option value="">Pilih Kecamatan</option>');
        $('#Kelurahan').html('<option value="">Pilih Kelurahan/Desa</option>');
        if(KabupatenID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/districts/"+KabupatenID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#Kecamatan').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    // Load Kelurahan/Desa
    $('#Kecamatan').change(function() {
        var KecamatanID = $(this).val();
        $('#Kelurahan').html('<option value="">Pilih Kelurahan/Desa</option>');
        if(KecamatanID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/villages/"+KecamatanID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#Kelurahan').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });
});

</script>
</body>
</html>



