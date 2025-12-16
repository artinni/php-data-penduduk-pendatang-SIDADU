<style>
.thead-custom {
    background-color: #27548A;
    color: white;
}

.btn-tolak {
    background-color: #dc3545;
    color: white;
}

.btn-verifikasi {
    background-color: #28a745;
    color: white;
}

.btn-belum {
    background-color: #007bff;
    color: white;
}

.modal-field {
    margin-bottom: 15px;
}

.modal-field label {
    font-size: 14px;
    font-weight: 500;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.modal-value {
    font-size: 15px;
    color: #111;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
}
</style>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelPJ" class="table table-striped table-bordered text-center">
                    <thead class="thead-custom">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Wilayah</th>
                            <th>
                             <select id="statusFilter" class="form-control form-control-sm" style="width: 150px; display: inline-block;">
                                <option value="">Semua Status</option>
                                <option value="Diproses" <?php echo ($this->input->get('status') == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                <option value="Terverifikasi" <?php echo ($this->input->get('status') == 'Terverifikasi') ? 'selected' : ''; ?>>Terverifikasi</option>
                                <option value="Ditolak" <?php echo ($this->input->get('status') == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                            </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($hasil)) {
                            echo "<tr><td colspan='6'>Data tidak tersedia</td></tr>";
                        } else {
                            $no = 1;
                            foreach ($hasil as $data): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($no); ?></td>
                                    <td><?php echo htmlspecialchars($data->Username ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($data->NamaLengkap ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($data->Wilayah ?? '-'); ?></td>
                                    
                                    <td>
  <?php 
    $status = htmlspecialchars($data->StatusAktivasi ?? '-'); 
    $btnClass = ($status === 'Terverifikasi') ? 'btn-success' : (($status === 'Diproses') ? 'btn-primary' : 'btn-danger');
  ?>
    <span class="btn btn-sm <?php echo $btnClass; ?>" style="cursor: default;">
        <?php echo $status; ?>
    </span>
</td>
<td width="150">
    <button class="btn btn-sm btn-success" title="Detail" onclick="tampilDetail('<?php echo htmlspecialchars($data->KodePJ ?? ''); ?>')">
        <i class="fas fa-info-circle"></i>
    </button>

    <button class="btn btn-sm btn-warning" title="Edit" onclick="editpj('<?php echo htmlspecialchars($data->KodePJ ?? '');?>')">
        <i class="fas fa-edit"></i>
    </button>

    <button class="btn btn-sm btn-danger" title="Hapus" 
    onclick="showHapusModal('<?php echo base_url('Penanggungjawab/hapuspj/' . $data->KodePJ); ?>')">
        <i class="fas fa-trash-alt"></i>
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

                <!-- Bootstrap Modal -->
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="detailModalLabel">Detail Penanggungjawab</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-field">
                                    <label>NIK</label>
                                    <div class="modal-value" id="detailNIK"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Nama</label>
                                    <div class="modal-value" id="detailNama"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Alamat</label>
                                    <div class="modal-value" id="detailAlamat"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Nomor Telepon</label>
                                    <div class="modal-value" id="detailTelp"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Alamat Email</label>
                                    <div class="modal-value" id="detailEmail"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Wilayah Yang Dinaungi</label>
                                    <div class="modal-value" id="detailWilayah"></div>
                                </div>

                                <div class="modal-field">
                                    <label>Status Verifikasi</label>
                                    <div class="modal-value" id="detailStatus"></div>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <strong>Catatan:</strong><br>
                                    Aktivasi akun untuk memudahkan pengisian penanggung jawab 
                                    pendatang daerah anda
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnTolak" onclick="tolakAkun()">Tolak</button>
                                <button type="button" class="btn btn-primary" id="btnAktivasi" onclick="aktivasiAkun()">Aktivasi Akun</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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


<script>

function hapuspj(KodePJ) {
    if (confirm("Apakah anda yakin menghapus data ini?")) {
        // Simulasi penghapusan
        alert("Data berhasil dihapus!");
        // window.open("<?php echo base_url(); ?>Penanggungjawab/hapuspj/" + KodePJ, "_self");
    }
}

function editpj(KodePJ) {
       
    $.ajax({
        url: "<?php echo base_url('Penanggungjawab/editpj/'); ?>" + KodePJ,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if(response) {
                // Isi form dengan data yang diterima
                document.getElementById('KodePJ').value = response.KodePJ;
                document.getElementById('Username').value = response.Username;
                document.getElementById('JenisKelamin').value = response.JenisKelamin;
                document.getElementById('NamaLengkap').value = response.NamaLengkap;
                document.getElementById('Email').value = response.Email;
                document.getElementById('Password').value = response.Password;
                document.getElementById('Alamat').value = response.Alamat;
                document.getElementById('Wilayah').value = response.Wilayah;
                document.getElementById('Telp').value = response.Telp;
            }
        },
    });
    
}

var kodePJ_aktif = null;
var detailModal = null;

// Initialize modal when document is ready
$(document).ready(function() {
    detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
});

function tampilDetail(KodePJ) {
    kodePJ_aktif = KodePJ;
    
    $.ajax({
        url: "<?php echo base_url('Penanggungjawab/detailpj/'); ?>" + KodePJ,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (data) {
                console.log("Data received:", data); // DEBUG: Lihat data yang diterima
                console.log("StatusAktivasi:", data.StatusAktivasi); // DEBUG: Lihat status spesifik
                populateModalData(data);
                detailModal.show();
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Gagal memuat data.");
        }
    });
}

function populateModalData(data) {
    // Populate data fields
    document.getElementById("detailNIK").innerText = data.Username;
    document.getElementById("detailNama").innerText = data.NamaLengkap;
    document.getElementById("detailAlamat").innerText = data.Alamat;
    document.getElementById("detailWilayah").innerText = data.Wilayah;
    document.getElementById("detailTelp").innerText = data.Telp;
    document.getElementById("detailEmail").innerText = data.Email;
    document.getElementById("detailStatus").innerText = data.StatusAktivasi;

    const btnAktivasi = document.getElementById("btnAktivasi");
    const btnTolak = document.getElementById("btnTolak");
    
    // DEBUG: Cek apakah button elements ditemukan
    console.log("btnAktivasi element:", btnAktivasi);
    console.log("btnTolak element:", btnTolak);

    if (!btnAktivasi || !btnTolak) {
        console.error("Button elements not found!");
        return;
    }

    // Reset button classes dan visibility
    btnAktivasi.className = "btn";
    btnAktivasi.style.display = "none";
    btnTolak.style.display = "none";

    // Trim whitespace dan konversi ke lowercase untuk comparison yang lebih robust
    const status = data.StatusAktivasi.toString().trim();
    console.log("Status after trim:", status); // DEBUG
    
    // Kondisi berdasarkan status
    if (status === "Diproses") {
        console.log("Setting buttons for Diproses status"); // DEBUG
        btnAktivasi.innerText = "Verifikasi Akun";
        btnAktivasi.classList.add("btn-primary");
        btnAktivasi.style.display = "inline-block";
        btnTolak.style.display = "inline-block";
        
    } else if (status === "Terverifikasi") {
        console.log("Setting buttons for Terverifikasi status"); // DEBUG
        btnAktivasi.innerText = "Batalkan Verifikasi";
        btnAktivasi.classList.add("btn-danger");
        btnAktivasi.style.display = "inline-block";
        btnTolak.style.display = "none";
        
    } else if (status === "Ditolak") {
        console.log("Setting buttons for Ditolak status"); // DEBUG
        btnAktivasi.innerText = "Ajukan Ulang";
        btnAktivasi.classList.add("btn-warning");
        btnAktivasi.style.display = "inline-block";
        btnTolak.style.display = "none";
        
    } else {
        console.log("Unknown status:", status); // DEBUG
        // Default: hide both buttons for unknown status
        btnAktivasi.style.display = "none";
        btnTolak.style.display = "none";
    }
    
    // DEBUG: Final button states
    console.log("Final btnAktivasi display:", btnAktivasi.style.display);
    console.log("Final btnAktivasi text:", btnAktivasi.innerText);
    console.log("Final btnTolak display:", btnTolak.style.display);
}

function aktivasiAkun() {
    if (!kodePJ_aktif) return;

    $.ajax({
        url: "<?php echo base_url('Penanggungjawab/toggleAktivasiAkun/'); ?>" + kodePJ_aktif,
        type: "POST",
        success: function(response) {
            const result = JSON.parse(response);
            let msg = "";

            switch (result.status) {
                case "verified":
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
            detailModal.hide();
            location.reload();
        },
        error: function() {
            alert("Gagal mengubah status aktivasi akun.");
        }
    });
}

function tolakAkun() {
    if (!kodePJ_aktif) return;

    $.ajax({
        url: "<?php echo base_url('Penanggungjawab/updateStatusAktivasi/'); ?>" + kodePJ_aktif,
        type: "POST",
        data: { status: "Ditolak" },
        success: function(response) {
            const result = JSON.parse(response);
            let msg = "";

            switch (result.status) {
                case "Ditolak":
                    msg = "Akun berhasil ditolak.";
                    break;
                default:
                    msg = "Status akun diperbarui.";
            }

            alert(msg);
            detailModal.hide();
            location.reload();
        },
        error: function() {
            alert("Gagal menolak akun.");
        }
    });
}

document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value;
    let url = new URL(window.location.href);
    url.searchParams.set('status', selectedStatus);
    url.hash = "tabelPJ"; // tambahkan #tabelPJ di URL
    window.location.href = url.toString();
});
</script>
