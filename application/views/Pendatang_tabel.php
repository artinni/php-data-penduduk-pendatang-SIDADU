<script>
    var BASE_URL = "<?php echo base_url(); ?>";
</script>

<style>
.thead-custom {
    background-color: #27548A; /* Contoh abu-abu gelap */
    color: white;
}

</style>


<div class="container mt-4">
    <div class="card">
        <div >
            <?php
                    $level = $this->session->userdata('level');
                    ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <div class="table-responsive">
            <table id="tablePendatang" class="table table-striped table-bordered text-center">
                    <thead class="thead-custom">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Masuk</th>
                            <th>Alasan Penolakan</th>
                            <th>
                                <select id="statusFilter" class="form-control form-control-sm" style="width: 150px; display: inline-block;">
                                <option value="">Semua Status </option>
                                <option value="Diproses" <?php echo ($this->input->get('status') == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                <option value="Diterima" <?php echo ($this->input->get('status') == 'Diterima') ? 'selected' : ''; ?>>Diterima</option>
                                <option value="Ditolak" <?php echo ($this->input->get('status') == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                            </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if (empty($hasil)) {
                            echo "<tr><td colspan='7'>Data tidak tersedia</td></tr>";
                        } else {
                            $no = 1;
                            foreach ($hasil as $data): ?>
                                <tr>
                            <td><?php echo htmlspecialchars($no); ?></td>
                            <td><?php echo htmlspecialchars($data->NIK ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($data->NamaLengkap ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($data->TglMasuk ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($data->AlasanPenolakan ?? '-'); ?></td>                                    
                            <td>
  <?php 
    $status = htmlspecialchars($data->StatusVerifikasi ?? '-'); 
    $btnClass = ($status === 'Diproses') ? 'btn-primary' : (($status === 'Diterima') ? 'btn-success' : 'btn-danger');
  ?>
  <span class="btn btn-sm <?php echo $btnClass; ?>" style="cursor: default;">
        <?php echo $status; ?>
    </span>
</td>
<td width="150">
    <button class="btn btn-sm btn-success" title="Detail" onclick="tampilDetail('<?php echo htmlspecialchars($data->KodePendatang ?? ''); ?>')" data-toggle="modal" data-target="#detailModal">
        <i class="fas fa-info-circle"></i>
    </button>

    <button class="btn btn-sm btn-warning" title="Edit" onclick="editpendatang('<?php echo htmlspecialchars($data->KodePendatang ?? '');?>')">
        <i class="fas fa-edit"></i>
    </button>

    <button class="btn btn-sm btn-danger" title="Hapus" 
    onclick="showHapusModal('<?php echo base_url('Pendatang/hapuspendatang/' . $data->KodePendatang); ?>')">
        <i class="fas fa-trash-alt" ></i>
    </button>
</td>
                                </tr>
                            <?php
                                $no++;
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
               <!-- Modal -->
                
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="detailModalLabel">Detail Data Pendatang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Foto Section -->
                <div class="text-center mb-4">
                    <h6 class="text-muted mb-3">FOTO PENDUDUK</h6>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <strong>Foto Selfie dengan KTP</strong>
                            <div class="mt-2">
                                <img id="fotoSelfie" src="" alt="Foto Selfie dengan KTP" style="max-width: 250px; max-height: 180px; border: 2px solid #ddd; border-radius: 5px; display: none;">
                                <div id="noFotoSelfie" style="width: 250px; height: 180px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; color: #999; margin: 0 auto;">Tidak ada foto</div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <strong>Foto KTP</strong>
                            <div class="mt-2">
                                <img id="fotoKTP" src="" alt="Foto KTP" style="max-width: 250px; max-height: 180px; border: 2px solid #ddd; border-radius: 5px; display: none;">
                                <div id="noFotoKTP" style="width: 250px; height: 180px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; color: #999; margin: 0 auto;">Tidak ada foto</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <h6 class="text-muted mb-3">DATA DIRI</h6>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="200"><strong>NIK</strong></td>
                            <td id="detailNIK">-</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td id="detailNama">-</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td id="detailNoTelp">-</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat Lahir</strong></td>
                            <td id="detailTempatLahir">-</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td id="detailTanggalLahir">-</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td id="detailJenisKelamin">-</td>
                        </tr>
                        <tr>
                            <td><strong>Golongan Darah</strong></td>
                            <td id="detailGolonganDarah">-</td>
                        </tr>
                        <tr>
                            <td><strong>Agama</strong></td>
                            <td id="detailAgama">-</td>
                        </tr>
                    </tbody>
                </table>

                <h6 class="text-muted mb-3 mt-4">ALAMAT ASAL</h6>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="200"><strong>Provinsi Asal</strong></td>
                            <td id="detailProvinsiAsal">-</td>
                        </tr>
                        <tr>
                            <td><strong>Kabupaten Asal</strong></td>
                            <td id="detailKabAsal">-</td>
                        </tr>
                        <tr>
                            <td><strong>Kecamatan Asal</strong></td>
                            <td id="detailKecAsal">-</td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan Asal</strong></td>
                            <td id="detailKelAsal">-</td>
                        </tr>
                        <tr>
                            <td><strong>RT</strong></td>
                            <td id="detailRT">-</td>
                        </tr>
                        <tr>
                            <td><strong>RW</strong></td>
                            <td id="detailRW">-</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat Asal</strong></td>
                            <td id="detailAlamatAsal">-</td>
                        </tr>
                    </tbody>
                </table>

                <h6 class="text-muted mb-3 mt-4">INFORMASI PENDATANG</h6>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="200"><strong>Alamat Tinggal Sekarang</strong></td>
                            <td id="detailAlamatSekarang">-</td>
                        </tr>
                        <tr>
                            <td><strong>Tujuan</strong></td>
                            <td id="detailTujuan">-</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Masuk</strong></td>
                            <td id="detailTglMasuk">-</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Keluar</strong></td>
                            <td id="detailTglKeluar">-</td>
                        </tr>
                        <tr>
                            <td><strong>Penanggung Jawab</strong></td>
                            <td id="detailKodePJ">-</td>
                        </tr>
                        <tr>
                            <td><strong>Wilayah yang dinaungi</strong></td>
                            <td id="detailWilayah">-</td>
                        </tr>
                        <tr>
                            <td><strong>Status Verifikasi</strong></td>
                            <td id="detailStatus">-</td>
                        </tr>
                        <tr>
                            <td><strong>Alasan Penolakan</strong></td>
                            <td id="detailAlasanPenolakan">-</td>
                        </tr>
                    </tbody>
                </table>

                <div class="alert alert-info mt-3">
                    <strong>Catatan:</strong><br>
                    Pilih "Verifikasi" untuk mengkonfirmasi Pendatang dengan data diatas yang menetap di wilayah anda
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="btnTolak" onclick="tolakAkun()">Tolak</button>
                <button class="btn btn-primary" id="btnVerifikasi" onclick="verifikasiAkun()">Verifikasi Akun</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
                <!-- end modal -->
</div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" >
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <a href="#" id="btnHapus" class="btn btn-danger btn-sm">Hapus</a>
      </div>
    </div>
  </div>
</div>


<script language="javascript">

function hapuspendatang(KodePendatang) {
 if (confirm("Apakah anda yakin menghapus data ini?")) {
       window.open("<?php echo base_url(); ?>Pendatang/hapuspendatang/" + KodePendatang, "_self");
            }
            }

function editpendatang(KodePendatang) {
    $.ajax({
         url: BASE_URL + "Pendatang/editpendatang/" + KodePendatang,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response) {
                // Isi input di form yang ADA di halaman ini
                $('#KodePendatang').val(response.KodePendatang);
                $('#NIK').val(response.NIK);
                $('#NamaLengkap').val(response.NamaLengkap);
                $('#NoTelp').val(response.NoTelp);
                $('#TempatLahir').val(response.TempatLahir);
                $('#TanggalLahir').val(response.TanggalLahir);
                $('#JenisKelamin').val(response.JenisKelamin);
                $('#GolonganDarah').val(response.GolonganDarah);
                $('#Agama').val(response.Agama);
                $('#ProvinsiAsal').val(response.ProvinsiAsal).trigger('change');
                // Setelah provinsi diisi, perlu delay sedikit sebelum set kabupaten
                setTimeout(function(){
                    $('#KabAsal').val(response.KabAsal).trigger('change');
                }, 500);
                setTimeout(function(){
                    $('#KecAsal').val(response.KecAsal).trigger('change');
                }, 1000);
                setTimeout(function(){
                    $('#KelAsal').val(response.KelAsal);
                }, 1500);
                $('#RT').val(response.RT);
                $('#RW').val(response.RW);
                $('#AlamatAsal').val(response.AlamatAsal);
                $('#AlamatSekarang').val(response.AlamatSekarang);
                $('#Tujuan').val(response.Tujuan);
                $('#TglMasuk').val(response.TglMasuk);
                $('#TglKeluar').val(response.TglKeluar);
                $('#KodePJ').val(response.KodePJ).trigger('change');
                $('#WilayahLabel').val(response.Wilayah);
                $('#latitude').val(response.Latitude);
                $('#longitude').val(response.Longitude);
                // NOTE: Untuk file Foto & KTP tidak bisa diisi dari JS — user harus upload ulang kalau mau ubah
            }
        },
        error: function() {
            alert('Gagal memuat data untuk diedit.');
        }
    });
}


var KodePendatang_aktif = null;
var detailModal = null;

// Initialize modal when document is ready
$(document).ready(function() {
    // Inisialisasi modal Bootstrap
    detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    // Atau jika menggunakan Bootstrap versi lama:
    // detailModal = $('#detailModal');
});

function tampilDetail(KodePendatang) {
    KodePendatang_aktif = KodePendatang;

    $.ajax({
        url: "<?php echo base_url('pendatang/detailpendatang/'); ?>" + KodePendatang,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (data) {
                populateModalData(data);
                $('#detailModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
            alert("Gagal mengambil data detail.");
        }
    });
}

// Fungsi untuk menampilkan foto dari database
function displayPhoto(photoPath, imgElementId, noPhotoElementId) {
    const imgElement = document.getElementById(imgElementId);
    const noPhotoElement = document.getElementById(noPhotoElementId);
    
    // Sembunyikan elemen gambar dan tampilkan placeholder terlebih dahulu
    imgElement.style.display = 'none';
    noPhotoElement.style.display = 'block';
    noPhotoElement.textContent = 'Tidak ada foto'; // Teks default

    if (photoPath && photoPath.trim() !== '' && photoPath !== 'null' && photoPath !== null) {
        // Gabungkan BASE_URL dengan path gambar
        // Pastikan tidak ada duplikasi garis miring
        const fullPath = BASE_URL + 'uploads/pendatang/' + photoPath;

        imgElement.src = fullPath;

        // Tampilkan gambar jika berhasil dimuat
        imgElement.onload = function() {
            imgElement.style.display = 'block';
            noPhotoElement.style.display = 'none';
        };

        // Tangani jika gambar gagal dimuat (misal: 404 Not Found)
        imgElement.onerror = function() {
            imgElement.style.display = 'none';
            noPhotoElement.style.display = 'block';
            noPhotoElement.textContent = 'Foto tidak dapat dimuat';
        };
    }
}
function getNamaWilayah(code, type, elementId) {
    // Pastikan kode atau ID wilayah tidak kosong atau null
    if (!code || code === '-' || code === 'null') {
        document.getElementById(elementId).innerText = '-';
        return;
    }

    // Tentukan URL API berdasarkan tipe wilayah
    let apiUrl = '';
    let paramName = '';
    if (type === 'provinsi') {
        apiUrl = `https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`;
    } else if (type === 'kabupaten') {
        apiUrl = `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${code}.json`;
    } else if (type === 'kecamatan') {
        apiUrl = `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${code}.json`;
    } else if (type === 'kelurahan') {
        apiUrl = `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${code}.json`;
    } else {
        document.getElementById(elementId).innerText = '-';
        return;
    }

    $.ajax({
        url: apiUrl,
        type: "GET",
        dataType: "json",
        success: function(response) {
            let namaWilayah = '-';
            if (response) {
                if (type === 'provinsi') {
                    // Untuk provinsi, kita perlu mencari ID yang cocok
                    const found = response.find(item => item.id == code);
                    namaWilayah = found ? found.name : '-';
                } else {
                    // Untuk kabupaten, kecamatan, kelurahan, respon langsung array data dengan nama
                    namaWilayah = response.name || '-';
                }
            }
            document.getElementById(elementId).innerText = namaWilayah;
        },
        error: function(xhr, status, error) {
            console.error(`Error fetching ${type} data for ID ${code}:`, error);
            document.getElementById(elementId).innerText = 'Gagal memuat';
        }
    });
}


function populateModalData(data) {
    console.log("Data yang diterima dari server:", data); // BARIS INI PENTING!
    console.log("Path Foto Selfie:", data.Foto);
    console.log("Path Foto KTP:", data.KTP);
    console.log("Status:", data.StatusVerifikasi); // debug
    console.log("Status length:", data.StatusVerifikasi.length); // debug panjang string
    console.log("Status charCodes:", data.StatusVerifikasi.split('').map(c => c.charCodeAt(0))); // debug karakter
    
    // Populate data fields
    document.getElementById("detailStatus").innerText = data.StatusVerifikasi;
    document.getElementById("detailKodePJ").innerText = data.NamaPJ; // untuk nampilin nama lengkap dari pj yang diinput sebelumnya  
    document.getElementById("detailNIK").innerText = data.NIK;
    document.getElementById("detailNama").innerText = data.NamaLengkap;
    document.getElementById("detailNoTelp").innerText = data.NoTelp;
    document.getElementById("detailTempatLahir").innerText = data.TempatLahir;
    document.getElementById("detailTanggalLahir").innerText = data.TanggalLahir;
    document.getElementById("detailJenisKelamin").innerText = data.JenisKelamin;
    document.getElementById("detailGolonganDarah").innerText = data.GolonganDarah;
    document.getElementById("detailAgama").innerText = data.Agama;
    
    // provinsi dll 
    getNamaWilayah(data.ProvinsiAsal, 'provinsi', 'detailProvinsiAsal');
    getNamaWilayah(data.KabAsal, 'kabupaten', 'detailKabAsal');
    getNamaWilayah(data.KecAsal, 'kecamatan', 'detailKecAsal');
    getNamaWilayah(data.KelAsal, 'kelurahan', 'detailKelAsal');

    document.getElementById("detailRT").innerText = data.RT;
    document.getElementById("detailRW").innerText = data.RW;
    document.getElementById("detailAlamatAsal").innerText = data.AlamatAsal;
    document.getElementById("detailAlamatSekarang").innerText = data.AlamatSekarang;
    document.getElementById("detailTujuan").innerText = data.Tujuan;
    document.getElementById("detailTglMasuk").innerText = data.TglMasuk;
    document.getElementById("detailTglKeluar").innerText = data.TglKeluar;
    document.getElementById("detailWilayah").innerText = data.Wilayah;
    
    displayPhoto(data.Foto, 'fotoSelfie', 'noFotoSelfie');
    displayPhoto(data.KTP, 'fotoKTP', 'noFotoKTP');
    
    // Handle additional fields if they exist
    if (document.getElementById("detailLatitude")) {
        document.getElementById("detailLatitude").innerText = data.Latitude;
    }
    if (document.getElementById("detailLongitude")) {
        document.getElementById("detailLongitude").innerText = data.Longitude;
    }
    if (document.getElementById("detailAlasanPenolakan")) {
        document.getElementById("detailAlasanPenolakan").innerText = data.AlasanPenolakan || '-';
    }

    const btnVerifikasi = document.getElementById("btnVerifikasi");
    const btnTolak = document.getElementById("btnTolak");

    // Debug: Cek apakah element ditemukan
    console.log("btnVerifikasi found:", btnVerifikasi !== null);
    console.log("btnTolak found:", btnTolak !== null);

    if (!btnVerifikasi) {
        console.error("Button verifikasi tidak ditemukan!");
        return;
    }

    // Reset dulu - hapus semua class styling
    btnVerifikasi.className = "btn";
    btnVerifikasi.style.display = "none";
    btnTolak.style.display = "none";
    
    // Trim whitespace dari status untuk memastikan perbandingan akurat
    const status = data.StatusVerifikasi.trim();
    console.log("Processed status:", status); // debug
    
    // Tampilkan button sesuai status
    if (status === "Diproses") {
        console.log("Showing buttons for Diproses status");
        btnVerifikasi.innerText = "Verifikasi Akun";
        btnVerifikasi.classList.add("btn-primary");
        btnVerifikasi.style.display = "inline-block";
        btnTolak.style.display = "inline-block";
    } else if (status === "Diterima") {
        console.log("Showing button for Diterima status");
        btnVerifikasi.innerText = "Batalkan Verifikasi";
        btnVerifikasi.classList.add("btn-danger");
        btnVerifikasi.style.display = "inline-block";
        btnTolak.style.display = "none";
    } else if (status === "Ditolak") {
        console.log("Showing button for Ditolak status");
        btnVerifikasi.innerText = "Ajukan Ulang";
        btnVerifikasi.classList.add("btn-warning");
        btnVerifikasi.style.display = "inline-block";
        btnTolak.style.display = "none";
    } else {
        console.log("Unknown status:", status);
    }
}

function verifikasiAkun() {
    // PERBAIKAN: Gunakan variabel yang konsisten
    if (!KodePendatang_aktif) {
        console.error("KodePendatang_aktif is null");
        return;
    }

    console.log("Verifying KodePendatang:", KodePendatang_aktif); // Debug log

    $.ajax({
        url: "<?php echo base_url('Pendatang/toggleVerifikasiAkun/'); ?>" + KodePendatang_aktif,
        type: "POST",
        dataType: "json", // Tambahkan dataType
        success: function(response) {
            console.log("Response:", response); // Debug log
            
            let msg = "";
            switch (response.status) {
                case "accept":
                    msg = "Akun berhasil diverifikasi!";
                    break;
                case "rejected":
                    msg = "Akun telah ditolak.";
                    break;
                case "processing":
                    msg = "Akun dikembalikan ke status Diproses.";
                    break;
                default:
                    msg = "Status akun diperbarui.";
            }

            alert(msg);
            
            // PERBAIKAN: Cek apakah detailModal sudah diinisialisasi
            if (detailModal) {
                if (typeof detailModal.hide === 'function') {
                    detailModal.hide(); // Bootstrap 5
                } else {
                    $('#detailModal').modal('hide'); // Bootstrap 4
                }
            } else {
                $('#detailModal').modal('hide');
            }
            
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText); // Debug log
            alert("Gagal memverifikasi akun. Error: " + error);
        }
    });
}

function tolakAkun() {
    // PERBAIKAN: Gunakan variabel yang konsisten
    if (!KodePendatang_aktif) {
        console.error("KodePendatang_aktif is null");
        return;
    }

    console.log("Rejecting KodePendatang:", KodePendatang_aktif); // Debug log

    $.ajax({
        url: "<?php echo base_url('Pendatang/updateStatusVerifikasi/'); ?>" + KodePendatang_aktif,
        type: "POST",
        data: { status: "Ditolak" },
        dataType: "json", // Tambahkan dataType
        success: function(response) {
            console.log("Response:", response); // Debug log
            
            let msg = "";
            switch (response.status) {
                case "Ditolak":
                    msg = "Akun berhasil ditolak.";
                    break;
                default:
                    msg = "Status berhasil diupdate.";
            }

            alert(msg);
            
            // PERBAIKAN: Cek apakah detailModal sudah diinisialisasi
            if (detailModal) {
                if (typeof detailModal.hide === 'function') {
                    detailModal.hide(); // Bootstrap 5
                } else {
                    $('#detailModal').modal('hide'); // Bootstrap 4
                }
            } else {
                $('#detailModal').modal('hide');
            }
            
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText); // Debug log
            alert("Gagal menolak akun. Error: " + error);
        }
    });
}

document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value;
    let url = new URL(window.location.href);
    url.searchParams.set('status', selectedStatus);
    url.hash = "tablePendatang"; // tambahkan #tabelPJ di URL
    window.location.href = url.toString();
});

</script>
               
            </div>
        </div>
    </div>
</div>


