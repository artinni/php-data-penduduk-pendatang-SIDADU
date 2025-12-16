<!-- Tampilan Surat Masuk -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Blok <style> dihapus dari sini -->
</head>

<body>
    
<!-- Begin Page Content -->
                <div class="container-fluid mt-4 mb-3">
                    <div class="card shadow mb-4"> 
                        <div class="card-header py-3 rounded-top" style="background-color:#674188 ;"> <!-- Ditambahkan bg-primary dan rounded-top -->
                            <h6 class="m-0 font-weight-bold text-center text-white" style="font-size: 1.25rem;">Daftar Surat Masuk</h6> <!-- Ditambahkan text-white -->
                        </div>
                         <?php if ($flash = $this->session->flashdata('pesan')) : ?>
                        <div class="alert alert-<?= $flash['type']; ?> alert-dismissible mt-3">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= $flash['message']; ?>
                        </div>
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Jenis Surat</th>
                                            <th>Nama Pengusul</th>
                                            <th>Acc</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                if (empty($hasil)) {
                                    echo "<tr><td colspan='7'>Data tidak tersedia</td></tr>";
                                } else {
                                    $no = 1;
                                    foreach ($hasil as $data):
                                        if (($data->status ?? '') !== 'Permohonan') continue; 
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($no); ?></td>
                                            <td> <span class="badge bg-info text-white">
                                                <?php echo htmlspecialchars($data->status ?? '-'); ?>
                                            </span></td>
                                            <td><?php echo htmlspecialchars($data->NamaJenis ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Dibuat_Oleh ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->AccSuratOleh ?? '-'); ?></td>
                                            <td width="150">
                                            <button 
                                            class="btn btn-sm btnSetujuSurat" 
                                            data-toggle="modal" 
                                            data-target="#setujuModal" 
                                            data-kodesurat="<?= $data->KodeSurat ?>" 
                                            title="Setujui">
                                            <i class="fa-solid fa-circle-check fa-2x" style="color: #1cc88a;"></i>
                                        </button>
                                            <button 
                                            class="btn btn-sm btnTolakSurat" 
                                            data-toggle="modal" 
                                            data-target="#modalTolakSurat"
                                            data-kodesurat="<?= $data->KodeSurat ?>"
                                            title="Tolak">
                                            <i class="fa-solid fa-circle-xmark fa-2x" style="color: #e74a3b;"></i>
                                        </button>
                                            <a href="<?= base_url('Surat/suratPengajuan/' . $data->KodeSurat) ?>" class="btn btn-sm">
                                                <i class="fa fa-search fa-2x" style="color: #4e73df;" title="Lihat"></i>
                                            </a>
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
                    </div> <!-- Tutup div card -->

                </div>
<div class="modal fade" id="modalTolakSurat" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('Surat/tolakSurat') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Catatan Penolakan</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="KodeSurat" id="inputKodeSurat">
          <div class="form-group">
            <label for="catatan">Alasan Penolakan</label>
            <textarea class="form-control" name="catatan_penolakan" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Tolak</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- modal konfirm setujui surat -->
<div class="modal fade" id="setujuModal" tabindex="-1" role="dialog" aria-labelledby="setujuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="setujuModalLabel">Konfirmasi Persetujuan</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menyetujui permohonan surat ini? QR code akan dibuat secara otomatis.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <a href="#" id="btnSetuju" class="btn btn-success btn-sm">Setujui</a>
      </div>
    </div>
  </div>
</div>
                
                </body>
                <!-- /.container-fluid -->
<script>
$(document).on('click', '.btnTolakSurat', function() {
    var kodeSurat = $(this).data('kodesurat');
    $('#inputKodeSurat').val(kodeSurat);
});

$(document).on('click', '.btnTolakSurat', function() {
    var kodeSurat = $(this).data('kodesurat');
    $('#inputKodeSurat').val(kodeSurat);
});

// Script modal Setujui
$(document).on('click', '.btnSetujuSurat', function() {
    var kodeSurat = $(this).data('kodesurat');
    var link = "<?= base_url('Surat/setujuiSurat/') ?>" + kodeSurat;
    $('#btnSetuju').attr('href', link);
});
</script>

