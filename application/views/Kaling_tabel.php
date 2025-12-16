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
                <table id="tableKaling" class="table table-striped table-bordered text-center">
                    <thead class="thead-custom">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
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
                                    <td><?php echo htmlspecialchars($data->Alamat ?? '-'); ?></td>
                                    
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
   <button class="btn btn-sm btn-info" title="Detail" onclick="tampilDetail('<?php echo htmlspecialchars($data->KodeKaling ?? ''); ?>')">
    <i class="fas fa-info-circle"></i>
</button>

    <button class="btn btn-sm btn-warning" title="Edit" onclick="editkaling('<?php echo htmlspecialchars($data->KodeKaling ?? '');?>')">
        <i class="fas fa-edit"></i>
    </button>

    <button class="btn btn-sm btn-danger" title="Hapus" 
    onclick="showHapusModal('<?php echo base_url('Kaling/hapuskaling/' . $data->KodeKaling); ?>')">
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
                                <h5 class="modal-title text-center" id="detailModalLabel">Detail Kaling</h5>
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
                                    <label>Provinsi</label>
                                    <div class="modal-value" id="detailProvinsi"></div>
                                </div>
                                 <div class="modal-field">
                                    <label>Kabupaten</label>
                                    <div class="modal-value" id="detailKabupaten"></div>
                                </div>
                                 <div class="modal-field">
                                    <label>Kecamatan</label>
                                    <div class="modal-value" id="detailKecamatan"></div>
                                </div>
                                <div class="modal-field">
                                    <label>Kelurahan</label>
                                    <div class="modal-value" id="detailKelurahan"></div>
                                </div>
                                 <div class="modal-field">
                                    <label>Status Aktivasi</label>
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
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
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
    // DEFINE BASE_URL HERE
    const BASE_URL = "<?php echo base_url(); ?>";

    function hapuskaling(KodeKaling) {
        if (confirm("Apakah anda yakin menghapus data ini?")) {
            alert("Data berhasil dihapus!");
            window.open(BASE_URL + "Kaling/hapuskaling/" + KodeKaling, "_self"); // Gunakan BASE_URL di sini juga
        }
    }

    function editkaling(KodeKaling) {
        $.ajax({
            url: BASE_URL + "Kaling/editkaling/" + KodeKaling, // Gunakan BASE_URL di sini
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response) {
                document.getElementById('KodeKaling').value = response.KodeKaling;
                document.getElementById('Username').value = response.Username;
                document.getElementById('NamaLengkap').value = response.NamaLengkap;
                document.getElementById('JenisKelamin').value = response.JenisKelamin;
                document.getElementById('Email').value = response.Email;
                document.getElementById('Password').value = response.Password;
                document.getElementById('Alamat').value = response.Alamat;
                document.getElementById('Provinsi').value = response.Provinsi;
                document.getElementById('Kabupaten').value = response.Kabupaten;
                document.getElementById('Kecamatan').value = response.Kecamatan;
                document.getElementById('Kelurahan').value = response.Kelurahan;
                document.getElementById('Jabatan').value = response.Jabatan;
                document.getElementById('Telp').value = response.Telp;
                }
            },
        });
    }

    var KodeKaling_aktif = null;
    var detailModal = null;

    $(document).ready(function() {
        detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    });

    function tampilDetail(KodeKaling) {
        KodeKaling_aktif = KodeKaling;

        $.ajax({
            url: BASE_URL + "Kaling/detailkaling/" + KodeKaling, // Gunakan BASE_URL di sini
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data) {
                    populateModalData(data);
                    detailModal.show();
                }
            }
        });
    }

    function populateModalData(data) {
        document.getElementById("detailNIK").innerText = data.Username;
        document.getElementById("detailNama").innerText = data.NamaLengkap;
        document.getElementById("detailAlamat").innerText = data.Alamat;
        document.getElementById("detailTelp").innerText = data.Telp;
        document.getElementById("detailEmail").innerText = data.Email;
        document.getElementById("detailStatus").innerText = data.StatusAktivasi;

        document.getElementById("detailProvinsi").innerText = data.NamaProvinsi;
        document.getElementById("detailKabupaten").innerText = data.NamaKabupaten;
        document.getElementById("detailKecamatan").innerText = data.NamaKecamatan;
        document.getElementById("detailKelurahan").innerText = data.NamaKelurahan;

        const btnAktivasi = document.getElementById("btnAktivasi");
        const btnTolak = document.getElementById("btnTolak");

        btnAktivasi.className = "btn"; // Reset class
        
        if (data.StatusAktivasi === "Diproses") {
            btnAktivasi.innerText = "Verifikasi Akun";
            btnAktivasi.classList.add("btn-primary");
            btnTolak.style.display = "inline-block";
            btnAktivasi.style.display = "inline-block";
        } else if (data.StatusAktivasi === "Terverifikasi") {
            btnAktivasi.innerText = "Batalkan Verifikasi";
            btnAktivasi.classList.add("btn-danger");
            btnTolak.style.display = "none";
            btnAktivasi.style.display = "inline-block";
        } else if (data.StatusAktivasi === "Ditolak") {
            btnAktivasi.innerText = "Ajukan Ulang";
            btnAktivasi.classList.add("btn-warning");
            btnTolak.style.display = "none";
            btnAktivasi.style.display = "inline-block";
        }
    }

    function aktivasiAkun() {
        if (!KodeKaling_aktif) return;

        $.ajax({
            url: BASE_URL + "Kaling/toggleAktivasiAkun/" + KodeKaling_aktif, // Gunakan BASE_URL di sini
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
        if (!KodeKaling_aktif) return;

        $.ajax({
            url: BASE_URL + "Kaling/tolakAkun/" + KodeKaling_aktif, // Gunakan BASE_URL di sini
            type: "POST",
            data: {
                status: "Ditolak"
            },
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
    url.hash = "tableKaling"; // tambahkan #tabelPJ di URL
    window.location.href = url.toString();
});
</script>