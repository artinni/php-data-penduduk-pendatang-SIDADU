<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .border-bottom-purple2 {
            border-bottom: 7px solid #674188; /* ungu */
        }

        .border-bottom-green {
            border-bottom: 5px solid #347433; /* hijau */
        }
        .border-bottom-navy2 {
            border-bottom: 5px solid #27548A;
        }
        .border-bottom-maroon {
            border-bottom: 5px solid #56021F;
        }
        .border-bottom-orange {
            border-bottom: 5px solid #B22222;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-5">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color:#674188">
            <h5 class="h4 text-white text-center font-weight-bold">
                Halaman Utama SIDADU - Hallo, 
                <?= $this->session->userdata('NamaLengkap'); ?>
            </h5>
        </div>
        <div class="card-body">
            <p>Mewujudkan pendataan pendatang yang tertib, akurat, dan transparan.
                Gunakan fitur dashboard untuk melihat statistik, verifikasi data, dan kelola laporan pendatang.
            </p>
        </div>
    </div>

    <!-- Konten dua kolom -->
    <div class="row">
        <!-- Kartu Kiri -->
        <div class="col-lg-4">
            <!-- Kartu 1 -->
            <div class="card border-bottom-purple2 shadow mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold text-uppercase mb-1 text-purple">Pendatang Terverifikasi</div>
                            <div class="h5 font-weight-bold"><?= $jumlahTerverifikasi ?? 0; ?></div>
                        </div>
                        <i class="fa-solid fa-person-circle-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 2 -->
            <div class="card border-bottom-navy2 shadow mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold text-uppercase mb-1 text-navy">Kaling Terverifikasi</div>
                            <div class="h5 font-weight-bold"><?= $jumlahAktivasi ?? 0; ?></div>
                        </div>
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 3 -->
            <div class="card border-bottom-green shadow mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold text-uppercase mb-1 text-success">Penanggung Jawab Terverifikasi</div>
                            <div class="h5 font-weight-bold"><?= $jumlahTerverifikasipj ?? 0; ?></div>
                        </div>
                        <i class="fas fa-house-circle-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 4 -->
            <div class="card border-bottom-green shadow mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold text-uppercase mb-1 text-success">Surat yang Dikeluarkan</div>
                            <div class="h5 font-weight-bold"><?= $jumlahSurat ?? 0; ?></div>
                        </div>
                        <i class="fas fa-file-circle-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ilustrasi di Kanan -->
        <div class="col-lg-8">
            <div class="card shadow mb-4 mt-2" style="min-height: 100%;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #674188;">Illustrations</h6>
                </div>
                <div class="card-body text-center">
                    <img src="<?= base_url('assets/img/undraw_complete-design_pzh6.svg'); ?>" class="img-fluid mb-3" style="width: 25rem;" alt="...">
                    <p class="mt-2">Membantu Anda mendata dan memverifikasi penduduk pendatang dengan mudah dan efisien!</p>
                    <a target="_blank" rel="nofollow" href="<?= base_url('Pendatang/index') ?>">Tambahkan penduduk pendatang &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
    </body>
</html>