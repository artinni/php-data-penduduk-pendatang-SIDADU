<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendatang PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        /* Styling untuk Kop Surat */
        .kopsurat {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000; /* Garis bawah untuk kop surat */
            padding-bottom: 10px;
        }
        .kopsurat table {
            width: 100%;
            border-collapse: collapse;
        }
        .kopsurat td {
            vertical-align: middle;
            padding: 0; /* Hapus padding default sel tabel */
            border: none; /* Hapus border default sel tabel */
        }
        .kopsurat img {
            width: 100px; /* Ukuran logo yang lebih kecil */
            height: auto;
            display: block; /* Agar gambar tidak memiliki ruang ekstra di bawahnya */
            margin: 0 auto; /* Tengah gambar */
        }
        .kopsurat .tengah {
            text-align: center;
        }
        .kopsurat h2 {
            margin: 0;
            font-size: 20px; /* Ukuran font judul yang lebih kecil */
            line-height: 1.2; /* Mengurangi spasi antar baris */
        }
        .kopsurat p {
            margin: 5px 0 0 0;
            font-size: 10px; /* Ukuran font alamat yang lebih kecil */
        }

        /* Styling untuk Judul Laporan dan Periode */
        .laporan-title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .laporan-title h1 {
            font-size: 18px; /* Ukuran font judul laporan */
            margin-bottom: 5px;
        }
        .laporan-title p {
            font-size: 12px; /* Ukuran font periode */
            margin: 0;
        }

        /* Styling untuk Tabel Data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px; /* Sesuaikan jarak dari judul laporan */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px; /* Ukuran font lebih kecil untuk PDF */
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            font-size: 12px; /* Ukuran font untuk total pendatang */
        }
    </style>
</head>
<body>
    <div class="kopsurat">
    <table>
        <tr>
            <td style="width: 100px;">
                <?php if (!empty($logo_src)): ?>
                    <img src="<?= $logo_src ?>" alt="Logo Desa">
                <?php else: ?>
                    <span>[Logo Not Found]</span>
                <?php endif; ?>
            </td>
            <td class="tengah">
                <h2>PEMERINTAH KABUPATEN KOTAWARINGIN</h2>
                <h2>KECAMATAN MENTAWA BARU</h2>
                <h2>DESA WANAASRI</h2>
                <p><b>Alamat:</b> Jalan Suka Indah Baru</p>
            </td>
        </tr>
    </table>
</div>

    <div class="laporan-title">
        <h1>Laporan Data Pendatang</h1>
        <p>Periode Bulan: <?= date('F Y', strtotime($bulan . '-01')) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Alamat Asal</th>
                <th>Alamat Sekarang</th>
                <th>Tanggal Masuk</th>
                <th>Tujuan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($hasil)) {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data pendatang untuk bulan ini.</td></tr>";
            } else {
                $no = 1;
                foreach ($hasil as $data):
            ?>
                    <tr>
                        <td><?php echo $no; ?></td>
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

    <div class="total-section">
        Jumlah Total Pendatang: <?= $total_pendatang ?? 0 ?>orang
    </div>
</body>
</html>