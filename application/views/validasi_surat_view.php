<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Surat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .validation-card {
            max-width: 600px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .validation-card .card-header {
            background-color: #674188; /* Warna kepala kartu */
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .validation-card .card-body {
            padding: 30px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .detail-item strong {
            display: inline-block;
            width: 150px; /* Lebar tetap untuk label */
        }
    </style>
</head>
<body>
    <div class="validation-card card">
        <div class="card-header">
            Status Validasi Surat
        </div>
        <div class="card-body">
            <div class="alert <?= $alert_class ?? 'alert-info' ?>" role="alert">
                <?= $message ?? 'Memuat status...' ?>
            </div>

            <?php if ($surat): ?>
                <h5 class="mt-4 mb-3">Detail Surat:</h5>
                <div class="detail-item">
                    <strong>Nomor Surat:</strong> <?= htmlspecialchars($surat->Nomor_Surat ?? '-') ?>
                </div>
                <div class="detail-item">
                    <strong>Jenis Surat:</strong> <?= htmlspecialchars($surat->NamaJenis ?? '-') ?>
                </div>
                <div class="detail-item">
                    <strong>Pengusul:</strong> <?= htmlspecialchars($surat->NamaPengusul ?? '-') ?>
                </div>
                <div class="detail-item">
                    <strong>Tanggal Surat:</strong> <?= htmlspecialchars(date('d F Y', strtotime($surat->Tanggal_Surat ?? date('Y-m-d')))) ?>
                </div>
                <div class="detail-item">
                    <strong>Disetujui Oleh:</strong> <?= htmlspecialchars($surat->AccSuratOleh ?? 'Belum Disetujui') ?>
                </div>
                <div class="detail-item">
                    <strong>Jabatan:</strong> <?= htmlspecialchars($surat->JabatanKaling ?? 'Belum Disetujui') ?>
                </div>
                <div class="detail-item">
                    <strong>Status:</strong> <?= htmlspecialchars($surat->status ?? '-') ?>
                </div>
                <?php if (!empty($surat->catatan_penolakan) && $surat->status == 'Tolak'): ?>
                    <div class="detail-item">
                        <strong>Catatan Penolakan:</strong> <?= htmlspecialchars($surat->catatan_penolakan) ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>Tidak ada detail surat yang dapat ditampilkan.</p>
            <?php endif; ?>
            <div class="mt-4 text-center">
                <a href="<?= base_url() ?>" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>