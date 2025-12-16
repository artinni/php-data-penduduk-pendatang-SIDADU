<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <title>Laporan Pendatang</title>

</head>

<body>

    <div class="container-fluid mt-4">

        <div class="card shadow mb-4">
            <div class="card-header py-3 rounded-top" style="background-color: #674188">
                <h6 class="m-0 font-weight-bold text-center text-white" style="font-size: 1.25rem;">Pendatang Wilayah QW</h6>
 <div class="info-bulan-card text-white text-center">
                    <p class="mb-0">Bulan: <?= date('F Y', strtotime($bulan_terpilih . '-01')) ?></p>
                </div>            </div>
            <div class="card-body">
                <form method="get" action="<?= site_url('Pendatang/laporan_bulanan') ?>" class="form-inline mb-4">
                    <label for="bulan" class="mr-2">Pilih Bulan:</label>
                    <input type="month" id="bulan" name="bulan" required value="<?= isset($bulan_terpilih) ? $bulan_terpilih : date('Y-m') ?>" class="form-control mr-2">
                    <button type="submit" class="btn btn-primary mr-2">Tampilkan</button>
                    
                    <a href="<?= site_url('Pendatang/cetak_laporan_pdf?bulan=' . (isset($bulan_terpilih) ? $bulan_terpilih : date('Y-m'))) ?>" class="btn btn-success" target="_blank">Cetak PDF</a>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat Asal</th>
                                <th>Alamat Sekarang</th>
                                <th>Tgl Masuk</th>
                                <th>Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Pastikan $hasil adalah variabel yang berisi data yang sudah difilter dari controller
                            if (empty($hasil)) {
                                echo "<tr><td colspan='8' class='text-center'>Data tidak tersedia</td></tr>";
                            } else {
                                $no = 1;
                                foreach ($hasil as $data):
                                    // Filter StatusVerifikasi seharusnya sudah dilakukan di model/controller
                                    // Baris if (($data->StatusVerifikasi ?? '') !== 'Diterima') continue; mungkin tidak lagi diperlukan di sini
                                    // karena model sudah memfilter hanya yang 'Diterima'.
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($no); ?></td>
                                        <td><?php echo htmlspecialchars($data->NamaLengkap ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->NIK ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->JenisKelamin ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->AlamatAsal ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->AlamatSekarang ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->TglMasuk ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($data->Tujuan ?? '-'); ?></td>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });

            // Set the value of the month input based on the current filter
            // This ensures the input shows the selected month after filtering
            <?php if (isset($bulan_terpilih)): ?>
                $('#bulan').val('<?= $bulan_terpilih ?>');
            <?php endif; ?>
        });
    </script>
</body>
</html>