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
                <div class="container-fluid mt-4">
                    <div class="card shadow mb-4"> 
                        <div class="card-header py-3 rounded-top" style="background-color:#674188 ;"> <!-- Ditambahkan bg-primary dan rounded-top -->
                            <h6 class="m-0 font-weight-bold text-center text-white" style="font-size: 1.25rem;">Daftar Pengajuan Surat</h6> <!-- Ditambahkan text-white -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Jenis Surat</th>
                                            <th>Nama Pengusul</th>
                                            <th>Acc Surat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                if (empty($hasil)) {
                                    echo "<tr><td colspan='8'>Data tidak tersedia</td></tr>";
                                } else {
                                    $no = 1;
                                    foreach ($hasil as $data): 
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($no); ?></td>
                                            <td>
                                            <?php
                                                $badgeColor = 'secondary';
                                                if ($data->status === 'Permohonan') $badgeColor = 'info';
                                                elseif ($data->status === 'Siap') $badgeColor = 'success';
                                                elseif ($data->status === 'Ditolak') $badgeColor = 'Danger';
                                                elseif ($data->status === 'Draft') $badgeColor = 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $badgeColor ?> text-white">
                                                <?= htmlspecialchars($data->status ?? '-') ?>
                                            </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($data->NamaJenis ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Dibuat_Oleh ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->AccSuratOleh ?? '-'); ?></td>
                                            <td width="150">
                                            <button class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="showHapusModal('<?php echo base_url('Surat/hapussurat/' . $data->KodeSurat); ?>')">
                                            <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <a href="<?= base_url('Surat/suratPengajuan/' . $data->KodeSurat) ?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-search" title="Lihat"></i>
                                            </a>
                                            <?php if ($data->status === 'Siap'): ?>
                                            <a href="<?= base_url('Surat/cetakSurat/' . $data->KodeSurat) ?>" 
                                            class="btn btn-sm btn-success" title="Cetak" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <?php endif; ?>
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

</body> <!-- /.container-fluid -->
<script>

</script>

