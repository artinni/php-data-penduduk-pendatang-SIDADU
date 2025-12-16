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
                <table class="table table-striped table-bordered text-center">
                    <thead class="thead-custom">
                        <tr>
                            <th>No</th>
                            <th>Nama Jenis Surat</th>
                            <th>Deskripsi</th>
                            <th>Dibuat Oleh</th>
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
                                    <td><?php echo htmlspecialchars($data->NamaJenis ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($data->Deskripsi ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($data->DibuatOleh ?? '-'); ?></td>

<td width="150">
    <button class="btn btn-sm btn-warning" title="Edit" onclick="editjenis('<?php echo htmlspecialchars($data->KodeJenis ?? '');?>')">
        <i class="fas fa-edit"></i>
    </button>
     <button class="btn btn-sm btn-danger" title="Hapus"
    onclick="showHapusModal('<?php echo base_url('JenisSurat/hapusjenis/' . $data->KodeJenis); ?>')"> <i class="fas fa-trash-alt"></i>
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

function hapusjenis(KodeJenis) {
    if (confirm("Apakah anda yakin menghapus data ini?")) {
        // Simulasi penghapusan
        alert("Data berhasil dihapus!");
        window.open("<?php echo base_url(); ?>JenisSurat/hapusjenis/" + KodeJenis, "_self");
    }
}

function editjenis(KodeJenis) {
       
    $.ajax({
        url: "<?php echo base_url('JenisSurat/editjenis/'); ?>" + KodeJenis,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if(response) {
                // Isi form dengan data yang diterima
                document.getElementById('KodeJenis').value = response.KodeJenis;
                document.getElementById('NamaJenis').value = response.NamaJenis;
                document.getElementById('Deskripsi').value = response.Deskripsi;
            }
        },
    });
    
}


function populateModalData(data) {
    document.getElementById("detailNIK").innerText = data.NamaJenis;
    document.getElementById("detailNama").innerText = data.Deskripsi;
    document.getElementById("detailDibuatOleh").innerText = data.DibuatOleh;
    document.getElementById("detailTelp").innerText = data.Telp;
    document.getElementById("detailEmail").innerText = data.Email;
    document.getElementById("detailStatus").innerText = data.StatusAktivasi;

    const btnAktivasi = document.getElementById("btnAktivasi");
    const btnTolak = document.getElementById("btnTolak");

    // Reset classes
    btnAktivasi.className = "btn";
    
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

    //   /* Original AJAX code:
    $.ajax({
        url: "<?php echo base_url('Kaling/toggleAktivasiAkun/'); ?>" + KodeKaling_aktif,
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

    //   Original AJAX code:
    $.ajax({
        url: "<?php echo base_url('Kaling/updateStatusAktivasi/'); ?>" + KodeKaling_aktif,
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

function showHapusModal(deleteUrl) {
    // Setel atribut href dari tombol "Hapus" di dalam modal
    document.getElementById('btnHapus').href = deleteUrl;
    // Tampilkan modal
    $('#hapusModal').modal('show'); // Membutuhkan jQuery untuk Bootstrap Modal
}
</script>