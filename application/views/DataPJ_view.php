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

                    <!-- DataTales Example -->
                    <!-- Pastikan div.card ini memiliki kelas border-left-purple dan shadow yang didefinisikan di admin_view.php -->
                    <div class="card shadow mb-4"> 
                        <div class="card-header py-3 rounded-top" style="background-color:#674188 ;"> <!-- Ditambahkan bg-primary dan rounded-top -->
                            <h6 class="m-0 font-weight-bold text-center text-white" style="font-size: 1.25rem;">Penanggung Jawab Terverifikasi Wilayah QW</h6> <!-- Ditambahkan text-white -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status Verifikasi</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIK</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Email</th>
                                            <th>Wilayah</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                if (empty($hasil)) {
                                    echo "<tr><td colspan='9'>Data tidak tersedia</td></tr>";
                                } else {
                                    $no = 1;
                                    foreach ($hasil as $data): 
                                     if (($data->StatusAktivasi ?? '') !== 'Terverifikasi') continue;
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($no); ?></td>
                                            <td> <span class="badge bg-success text-white">
                                                <?php echo htmlspecialchars($data->StatusAktivasi ?? '-'); ?>
                                            </span></td>
                                            <td><?php echo htmlspecialchars($data->NamaLengkap ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Username ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->JenisKelamin ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Email ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Wilayah ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($data->Alamat ?? '-'); ?></td>                                          
                                            <td width="150">
                                            <a href="<?php echo base_url('Penanggungjawab'); ?>" class="btn btn-sm btn-warning" >
                                                <i class="fa fa-plus-square" title="Tambah dan Edit Data"></i></a> <!-- Ditambahkan rounded-pill dan shadow-sm -->
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
                
                </body>
                <!-- /.container-fluid -->
