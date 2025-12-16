<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendatang</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <!-- HAPUS jQuery dari sini - gunakan yang sudah ada di admin_view -->
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
            vertical-align: top;
        }
        textarea.form-control {
            resize: vertical;
        }
        .upload-section {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .upload-box {
            text-align: center;
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 250px;
            position: relative;
        }
        .upload-box img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .upload-placeholder {
            width: 120px;
            height: 120px;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #ccc;
        }
        .btn-upload {
            background-color: #674188;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .btn-upload:hover {
            background-color: #553366;
        }
        .file-name {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        .file-uploaded {
            color: #28a745 !important;
            font-weight: bold;
        }
        .button-group {
            display: flex;
            gap: 5px;
            justify-content: center;
            flex-wrap: wrap;
        }


        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .upload-section {
                flex-direction: column;
            }
            
            .upload-box {
                min-width: auto;
            }
        }
    </style>
</head>
<body class="bg-light">

<script>
function simpanpendatang() {
    // Ambil nilai dari semua field yang ingin divalidasi
    var NIK = $('#NIK').val();
    var NamaLengkap = $('input[name="NamaLengkap"]').val();
    var NoTelp = $('input[name="NoTelp"]').val();
    var TempatLahir = $('input[name="TempatLahir"]').val();
    var TanggalLahir = $('input[name="TanggalLahir"]').val();
    var JenisKelamin = $('select[name="JenisKelamin"]').val(); // Jika ini select/dropdown
    var GolonganDarah = $('select[name="GolonganDarah"]').val(); // Jika ini select/dropdown
    var Agama = $('select[name="Agama"]').val(); // Jika ini select/dropdown
    var ProvinsiAsal = $('select[name="ProvinsiAsal"]').val(); // Jika ini select/dropdown
    var KabAsal = $('select[name="KabAsal"]').val(); // Jika ini select/dropdown
    var KecAsal = $('select[name="KecAsal"]').val(); // Jika ini select/dropdown
    var KelAsal = $('select[name="KelAsal"]').val(); // Jika ini select/dropdown
    var RT = $('input[name="RT"]').val();
    var RW = $('input[name="RW"]').val();
    var AlamatAsal = $('textarea[name="AlamatAsal"]').val(); // Jika ini textarea
    var AlamatSekarang = $('textarea[name="AlamatSekarang"]').val(); // Jika ini textarea
    var Tujuan = $('textarea[name="Tujuan"]').val(); // Jika ini textarea
    var TglMasuk = $('input[name="TglMasuk"]').val();
    var TglKeluar = $('input[name="TglKeluar"]').val();
    var Wilayah = $('select[name="Wilayah"]').val(); // Jika ini select/dropdown
    var Latitude = $('input[name="Latitude"]').val(); // Asumsi input tersembunyi dari peta
    var Longitude = $('input[name="Longitude"]').val(); // Asumsi input tersembunyi dari peta
    
    // Khusus untuk input type="file"
    const Foto = document.getElementById('Foto').files[0]; // Akan undefined jika tidak ada file
    const KTP = document.getElementById('KTP').files[0];   // Akan undefined jika tidak ada file

    // Array untuk menyimpan field yang akan divalidasi
    // Format: [nilai_field, "Pesan error", "selector_untuk_fokus"]
    var fieldsToValidate = [
        [NIK, "NIK masih kosong...", '#NIK'],
        [NamaLengkap, "Nama lengkap masih kosong...", 'input[name="NamaLengkap"]'],
        [NoTelp, "Nomor Telepon masih kosong...", 'input[name="NoTelp"]'],
        [TempatLahir, "Tempat Lahir masih kosong...", 'input[name="TempatLahir"]'],
        [TanggalLahir, "Tanggal Lahir masih kosong...", 'input[name="TanggalLahir"]'],
        [JenisKelamin, "Jenis Kelamin belum dipilih...", 'select[name="JenisKelamin"]'],
        [GolonganDarah, "Golongan Darah belum dipilih...", 'select[name="GolonganDarah"]'],
        [Agama, "Agama belum dipilih...", 'select[name="Agama"]'],
        [ProvinsiAsal, "Provinsi Asal masih kosong...", 'select[name="ProvinsiAsal"]'],
        [KabAsal, "Kabupaten/Kota Asal masih kosong...", 'select[name="KabAsal"]'],
        [KecAsal, "Kecamatan Asal masih kosong...", 'select[name="KecAsal"]'],
        [KelAsal, "Kelurahan/Desa Asal masih kosong...", 'select[name="KelAsal"]'],
        [RT, "RT Asal masih kosong...", 'input[name="RT"]'],
        [RW, "RW Asal masih kosong...", 'input[name="RW"]'],
        [AlamatAsal, "Alamat Asal masih kosong...", 'textarea[name="AlamatAsal"]'],
        [AlamatSekarang, "Alamat Sekarang masih kosong...", 'textarea[name="AlamatSekarang"]'],
        [Tujuan, "Tujuan masih kosong...", 'textarea[name="Tujuan"]'],
        [TglMasuk, "Tanggal Masuk masih kosong...", 'input[name="TglMasuk"]'],
        [TglKeluar, "Tanggal Keluar masih kosong...", 'input[name="TglKeluar"]'],
        // [Wilayah, "Wilayah Lingkungan belum dipilih...", 'select[name="Wilayah"]'],
        // [Latitude, "Koordinat Latitude masih kosong (pilih di peta)...", 'input[name="Latitude"]'], // Asumsi latitude/longitude diisi dari peta
        // [Longitude, "Koordinat Longitude masih kosong (pilih di peta)...", 'input[name="Longitude"]'],
        // Validasi untuk file input
        [Foto, "Foto selfie KTP belum diunggah!", '#Foto'],
        [KTP, "Scan KTP belum diunggah!", '#KTP']
    ];

    // Lakukan loop untuk validasi semua field
    for (var i = 0; i < fieldsToValidate.length; i++) {
        var field = fieldsToValidate[i][0];
        var errorMessage = fieldsToValidate[i][1];
        var focusSelector = fieldsToValidate[i][2];

        // Khusus untuk input file, cek jika undefined (tidak ada file dipilih)
        if (focusSelector === '#Foto' || focusSelector === '#KTP') {
            if (typeof field === 'undefined') {
                alert(errorMessage);
                $(focusSelector).focus();
                return false;
            }
        } else {
            if (
                field === null ||
                typeof field === 'undefined' ||
                (typeof field === 'string' && field.trim() === "")
            ) {
                alert(errorMessage);
                $(focusSelector).focus();
                return false;
            }
        }

    // Jika semua validasi lolos, submit form
    $('#formpendatang').submit();
}
}
</script>

<div class="container">
    <div class="form-section">
        <h3>Form Data Pendatang</h3>
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
        <form method="post" id="formpendatang" action="<?= base_url('Pendatang/simpanpendatang'); ?>" enctype="multipart/form-data">
        <input type="hidden" name="KodePendatang" id="KodePendatang"/>

        <!-- upload ktp  -->
        <div class="upload-section">
            <div class="upload-box">
                <div class="upload-placeholder" id="foto-placeholder">👤</div>
                
                <input 
                    type="file" 
                    id="Foto" 
                    name="Foto" 
                    accept="image/*" 
                    style="display: none;" 
                    onchange="handleFileUpload('Foto', 'foto-file-name', 'foto-placeholder')">
                
                <button type="button" class="btn-upload" onclick="document.getElementById('Foto').click()">
                    Browse Foto
                </button>
                
                <div id="foto-file-name" class="file-name">No file selected.</div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-primary btn-sm" onclick="previewImage('foto')" data-toggle="modal" data-target="#fotoModal">
                        Preview Foto
                    </button>
                </div>
            </div>
            <!-- Upload KTP -->
            <div class="upload-box">
                <div class="upload-placeholder" id="ktp-placeholder">📄</div>
                
                <input 
                    type="file" 
                    id="KTP" 
                    name="KTP" 
                    accept="image/*" 
                    style="display: none;"
                    onchange="handleFileUpload('KTP', 'ktp-file-name', 'ktp-placeholder')">
                
                <button type="button" class="btn-upload" onclick="document.getElementById('KTP').click()">
                    Browse KTP
                </button>
                
                <div id="ktp-file-name" class="file-name">No file selected.</div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-primary btn-sm" onclick="previewImage('ktp')" data-toggle="modal" data-target="#ktpModal">
                        Preview KTP
                    </button>
                    <!-- <button type="button" class="btn btn-success btn-sm">
                        Scan & Isi Otomatis
                    </button> -->
                </div>
            </div>
        </div>

        <!-- Modal untuk Preview Foto -->
<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-centered" id="exampleModalLongTitle">Preview Selfie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="fotoModalBody" class="modalBody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        <!-- Modal untuk Preview KTP -->
<div class="modal fade" id="ktpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLongTitle">Preview KTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="ktpModalBody" class="modalBody">
        <div class="no-image">Belum ada KTP yang dipilih</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        <table class="form-table">
            <tr>
                <td><label>NIK (Isi Sesuai KTP)</label></td>
                <td><input type="text" name="NIK" id="NIK" class="form-control"></td>
                <td><label>ProvinsiAsal</label></td>
                <td>
                    <select id="ProvinsiAsal" name="ProvinsiAsal" class="form-control">
                        <option value="">Pilih ProvinsiAsal</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Nama Lengkap</label></td>
                <td><input type="text" name="NamaLengkap" id="NamaLengkap" class="form-control"></td>
                <td><label>KabAsal/Kota</label></td>
                <td>
                    <select id="KabAsal" name="KabAsal" class="form-control">
                        <option value="">Pilih KabAsal/Kota</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>No Handphone</label></td>
                <td><input type="text" name="NoTelp" id="NoTelp" class="form-control"></td>
                <td><label>KecAsal</label></td>
                <td>
                    <select id="KecAsal" name="KecAsal" class="form-control">
                        <option value="">Pilih KecAsal</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Tempat Lahir</label></td>
                <td><input type="text" name="TempatLahir" id="TempatLahir" class="form-control"></td>
                <td><label>KelAsal/Desa</label></td>
                <td>
                    <select id="KelAsal" name="KelAsal" class="form-control">
                        <option value="">Pilih KelAsal/Desa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Tanggal Lahir</label></td>
                <td><input type="date" name="TanggalLahir" id="TanggalLahir" class="form-control"></td>
                <td><label>RT</label></td>
                <td><input type="text" name="RT" id="RT" class="form-control"></td>
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
                <td><label>RW</label></td>
                <td><input type="text" name="RW" id="RW" class="form-control"></td>
            </tr>
            <tr>
                <td><label>Golongan Darah</label></td>
                <td>
                    <select name="GolonganDarah" id="GolonganDarah" class="form-control">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </td>
                <td><label>Tujuan</label></td>
                <td><textarea name="Tujuan" id="Tujuan" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td><label>Agama</label></td>
                <td>
                    <select name="Agama" id="Agama" class="form-control">
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </td>
                <td><label>Alamat Asal (Isi Sesuai KTP)</label></td>
                <td><textarea name="AlamatAsal" id="AlamatAsal" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td><label>Tanggal Masuk</label></td>
                <td><input type="date" name="TglMasuk" id="TglMasuk" class="form-control"></td>
                <td><label>Tanggal Keluar (opsional)</label></td>
                <td><input type="date" name="TglKeluar" id="TglKeluar" class="form-control"></td>
            </tr>
            <tr>
                <td><label>Penanggung Jawab</label></td>
                <td>
                    <?php echo $this->Modelcombo->combopj('KodePJ'); ?>
                </td>
                <td><label>Wilayah</label></td>
                <td>
                    <input type="text" id="WilayahLabel" name="Wilayah" class="form-control" readonly>
                </td>
            </tr>
        </table>
        
        <h4>Lokasi (Klik pada peta)</h4>
        <div id="mapid" style="height: 400px; width: 100%;" class="mb-3"></div>
        <label>Alamat Sekarang</label>
        <textarea name="AlamatSekarang" id="AlamatSekarang" class="form-control"></textarea>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <div class="text-center mt-4">
            <input type="button" value="Simpan" class="btn btn-primary" onclick="simpanpendatang();">
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
// Variabel global untuk map dan marker
let mapInstance = null;
let markerInstance = null;
// Tunggu hingga dokumen siap (gunakan jQuery yang sudah ada)
$(document).ready(function() {
    // Inisialisasi peta hanya sekali di sini
    if (!mapInstance && !L.DomUtil.get('mapid')._leaflet_id) {
        mapInstance = L.map('mapid').setView([-8.8007277, 115.1626822], 15);

        setTimeout(function () {
            mapInstance.invalidateSize();
        }, 100);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapInstance);


        // Event klik pada peta untuk menempatkan atau memindahkan marker
        mapInstance.on('click', function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Jika marker sudah ada, pindahkan. Jika belum, buat baru.
            if (markerInstance) {
                markerInstance.setLatLng(e.latlng);
            } else {
                markerInstance = L.marker(e.latlng).addTo(mapInstance);
            }

            // Update nilai latitude dan longitude di form
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            // Reverse geocoding untuk mendapatkan alamat dari koordinat
$.getJSON('<?= base_url("reverse_geocode.php") ?>', {
    lat: lat,
    lon: lng
}, function (data) {
    $('#AlamatSekarang').val(data.display_name);
});
        });
    } else {
        // Jika peta sudah diinisialisasi, tampilkan peringatan di konsol.
        // Ini membantu debug jika skrip dijalankan berkali-kali.
        console.warn("Peta sudah diinisialisasi. Melewatkan inisialisasi ulang.");
    }

     // Load ProvinsiAsal
    $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json", function(data) {
        $.each(data, function(index, value) {
            $('#ProvinsiAsal').append('<option value="'+value.id+'">'+value.name+'</option>');
        });
    });

    // Load KabAsal/Kota
    $('#ProvinsiAsal').change(function() {
        var ProvinsiAsalID = $(this).val();
        $('#KabAsal').html('<option value="">Pilih KabAsal/Kota</option>');
        $('#KecAsal').html('<option value="">Pilih KecAsal</option>');
        $('#KelAsal').html('<option value="">Pilih KelAsal/Desa</option>');
        if(ProvinsiAsalID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/"+ProvinsiAsalID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#KabAsal').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    // Load KecAsal
    $('#KabAsal').change(function() {
        var KabAsalID = $(this).val();
        $('#KecAsal').html('<option value="">Pilih KecAsal</option>');
        $('#KelAsal').html('<option value="">Pilih KelAsal/Desa</option>');
        if(KabAsalID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/districts/"+KabAsalID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#KecAsal').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    // Load KelAsal/Desa
    $('#KecAsal').change(function() {
        var KecAsalID = $(this).val();
        $('#KelAsal').html('<option value="">Pilih KelAsal/Desa</option>');
        if(KecAsalID) {
            $.getJSON("https://www.emsifa.com/api-wilayah-indonesia/api/villages/"+KecAsalID+".json", function(data) {
                $.each(data, function(index, value) {
                    $('#KelAsal').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        }
    });

    // Handle Penanggung Jawab change
    $('#KodePJ').change(function() {
        var kodepj = $(this).val();
        if (kodepj) {
            $.ajax({
                url: "<?php echo base_url('Penanggungjawab/getWilayahPJ'); ?>",
                type: "POST",
                data: {KodePJ: kodepj},
                success: function(data) {
                    $('#WilayahLabel').val(data);
                }
            });
        } else {
            $('#WilayahLabel').val('');
        }
    });
});


// Variabel untuk menyimpan file yang diupload
let uploadedFiles = {
    foto: null,
    ktp: null
};

// Fungsi untuk handle file upload
function handleFileUpload(inputId, fileNameId, placeholderId) {
    const input = document.getElementById(inputId);
    const fileNameDiv = document.getElementById(fileNameId);
    const placeholder = document.getElementById(placeholderId);
    const file = input.files[0];
    
    if (file) {
        // Update nama file
        fileNameDiv.textContent = file.name;
        fileNameDiv.classList.add('file-uploaded');
        
        // Simpan file untuk preview
        const fileType = inputId.toLowerCase();
        uploadedFiles[fileType] = file;
        
        // Update placeholder
        if (fileType === 'foto') {
            placeholder.textContent = '✓';
            placeholder.style.color = '#28a745';
        } else if (fileType === 'ktp') {
            placeholder.textContent = '✓';
            placeholder.style.color = '#28a745';
        }
    } else {
        // Reset jika tidak ada file
        fileNameDiv.textContent = 'No file selected.';
        fileNameDiv.classList.remove('file-uploaded');
        
        const fileType = inputId.toLowerCase();
        uploadedFiles[fileType] = null;
        
        // Reset placeholder
        if (fileType === 'foto') {
            placeholder.textContent = '👤';
            placeholder.style.color = '#ccc';
        } else if (fileType === 'ktp') {
            placeholder.textContent = '📄';
            placeholder.style.color = '#ccc';
        }
    }
}

// Fungsi untuk preview image
function previewImage(type) {
    const file = uploadedFiles[type];
    const modalId = type + 'Modal';
    const modalBodyId = type + 'ModalBody';
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const modalBody = document.getElementById(modalBodyId);
            modalBody.innerHTML = `<img src="${e.target.result}" alt="Preview ${type}" class="modal-image">`;
            openModal(modalId);
        };
        reader.readAsDataURL(file);
    } else {
        // Tampilkan modal dengan pesan tidak ada file
        const modalBody = document.getElementById(modalBodyId);
        const message = type === 'foto' ? 'Belum ada foto yang dipilih' : 'Belum ada KTP yang dipilih';
        modalBody.innerHTML = `<div class="no-image">${message}</div>`;
        openModal(modalId);
    }
}
</script>
</body>
</html>