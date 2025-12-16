<!DOCTYPE html>
<html>
<head>
    <title>Surat Pengajuan <?= $surat->NamaJenis ?></title>
    <style>
     body {
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        margin: 40px;
        line-height: 1.5;
    }

    .kopsurat {
        width: 100%;
        max-width: 750px;
        margin: 0 auto 20px;
    }

    .kopsurat table {
        width: 100%;
        border-bottom: 5px solid #000;
        padding-bottom: 10px;
    }

    .kopsurat img {
        width: 100px;
        height: auto;
    }

    .kopsurat .tengah {
        text-align: center;
        line-height: 1.2;
        padding-left: 20px; /* Tambahkan jarak dari gambar */
    }

    .kopsurat .tengah h2,
    .kopsurat .tengah h3,
    .kopsurat .tengah p {
        margin: 0;
        padding: 0;
    }

        .nomor-surat {
            text-align: center; /* Tengah untuk bagian nomor surat */
            margin: 30px 0 20px; /* Atas 30px, bawah 20px */
            font-weight: bold; /* Tebal */
        }

        .nomor-surat small {
            font-size: 11pt; /* Ukuran sedikit lebih kecil */
            font-weight: normal; /* Normal (tidak bold) */
        }

        .content {
            text-align: justify; /* Teks rata kanan kiri */
        }

        .content p {
            margin: 10px 0; /* Jarak atas bawah antar paragraf */
            text-indent: 30px; /* Paragraf masuk 30px di awal */
        }

        .data-pemohon table {
            margin-left: 30px; /* Geser tabel ke kanan */
            border-collapse: collapse; /* Gabungkan batas sel */
        }

        .data-pemohon td {
            padding: 3px 0; /* Spasi atas bawah antar baris data */
            vertical-align: top; /* Teks rata atas */
        }

        .data-pemohon td:first-child {
            width: 180px; /* Lebar kolom kiri (label) */
        }

        .ttd {
            margin-top: 60px; /* Jarak atas sebelum tanda tangan */
            text-align: right; /* Rata kanan */
        }

        .ttd .tanggal {
            margin-bottom: 60px; /* Jarak sebelum nama */
        }

        .ttd .nama-ttd {
            text-decoration: underline; /* Garis bawah untuk nama */
            font-weight: bold; /* Tebal */
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kopsurat">
    <table>
        <tr>
            <td style="width: 100px;"><img src="<?= base_url('img/DESA.png') ?>" alt="Logo Desa"></td>
            <td class="tengah">
                <h2>PEMERINTAH KABUPATEN KOTAWARINGIN</h2>
                <h2>KECAMATAN MENTAWA BARU</h2>
                <h2>DESA WANAASRI</h2>
                <p><b>Alamat:</b> Jalan Suka Indah Baru</p>
            </td>
        </tr>
    </table>
</div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        SURAT PENGANTAR PINDAH DATANG PENDUDUK WNI<br>
        <small>(ANTAR KABUPATEN / KOTA ATAU PROVINSI)</small><br>
        <small>NOMOR: <?= $surat->Nomor_Surat ?> / <?= date('m') ?> / <?= date('Y') ?></small>
    </div>

    <!-- ISI SURAT -->
<div class="content">
    <p>Yang bertanda tangan di bawah ini, menerangkan dengan sesungguhnya bahwa penduduk WNI dengan data sebagai berikut:</p>

    <div class="data-pemohon">
        <table>

            <!-- Tambahan field dinamis -->
            <?php foreach ($field_tambahan as $key => $value): ?>
            <?php if ($key != 'KodeKaling'): ?>
                <tr>
                    <td><?= ucwords(str_replace('_', ' ', $key)) ?></td>
                    <td>: <?= $value ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </table>
    </div>

    <p>Adapun permohonan pindah penduduk WNI yang bersangkutan karena alasan mata pencaharian.</p>
    <p>Demikian surat pengantar pindah ini dibuat agar dapat digunakan sebagaimana mestinya.</p>
</div>

<!-- TANDA TANGAN -->
<div class="ttd">
    <p class="tanggal">
     <?= $nama_kelurahan_kaling ?>, <?= date('d F Y', strtotime($surat->Tanggal_Surat)) ?>
</p>
    <p><?= $surat->JabatanKaling ?? 'Jabatan tidak tersedia' ?></p>
    <p class="nama-ttd"><?= $surat->AccSuratOleh ?></p>
</div>

</body>
</html>
