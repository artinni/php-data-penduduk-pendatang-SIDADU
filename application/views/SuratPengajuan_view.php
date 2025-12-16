<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color: #674188;">Draft Surat</div>
                <div class="card-body">
                    <embed src="<?= base_url('uploads/surat/' . $surat->File_Lampiran) ?>" type="application/pdf" width="100%" height="600px"/>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">Detail Pengajuan</div>
                <div class="card-body">
                    <form action="<?= base_url('Surat/ajukanSurat/' . $surat->KodeSurat) ?>" method="post">
                        <input type="hidden" name="KodeSurat" value="<?= $surat->KodeSurat ?>">
                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="Perihal" value="<?= $surat->NamaJenis ?? '' ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            <input type="text" name="Waktu_Dibuat" value="<?= $surat->Waktu_Dibuat ?? '' ?>" class="form-control" readonly>
                        </div>
                            <div class="form-group">
                                <label>Status</label><br>
                                <?php
                                $status = $surat->status ?? 'Draft';

                                switch ($status) {
                                    case 'Siap': $class = 'badge-success'; break;
                                    case 'Proses': $class = 'badge-primary'; break;
                                    case 'Tolak': $class = 'badge-danger'; break;
                                    case 'Menunggu': $class = 'badge-warning'; break;
                                    default: $class = 'badge-secondary'; break;
                                }
                                ?>
                                <span class="badge <?= $class ?>"><?= $status ?></span>
                            </div>
                        
                        <?php if ($surat->status == 'Tolak'): ?>
                        <div class="form-group">
                            <label>Catatan Penolakan</label>
                            <textarea name="Catatan" class="form-control"><?= $surat->catatan_penolakan ?? '' ?></textarea>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                        <label>Acc</label>
                        <?php if (!empty($surat->AccSuratOleh)) : ?>
                            <div class="border rounded p-2 bg-light">
                                <strong><?= $surat->AccSuratOleh ?></strong>
                                <hr class="my-2">
                                <small class="text-muted"><?= $surat->JabatanKaling ?? 'Jabatan tidak tersedia' ?></small>
                            </div>
                        <?php else : ?>
                            <input type="text" value="" class="form-control" readonly>
                        <?php endif; ?>
                    </div>
                      
                     <div class="form-group">
                        <label for="nomorSurat">Nomor Surat</label>
                        <div style="position: relative;">
                            <input type="text" id="nomorSurat" value="<?= $surat->Nomor_Surat ?? '' ?>" class="form-control" readonly style="padding-right: 30px;">
                            <i class="fas fa-copy" onclick="copyToClipboard('nomorSurat', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                            <span id="copiedTooltip" style="position: absolute; top: -30px; left: 50%; transform: translateX(-50%); background-color: #5cb85c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8em; opacity: 0; transition: opacity 0.3s ease-in-out; white-space: nowrap; pointer-events: none;">Tersalin!</span>
                        </div>
                    </div>
            <?php if ($surat->status == 'Siap' && !empty($surat->TandaTangan)) : ?>
            <div class="form-group mt-3">
                <label>QR Code:</label><br>
                <img src="<?= base_url('uploads/qrcode/' . $surat->TandaTangan) ?>" alt="QR Code" width="150"><br>
                <a href="<?= base_url('uploads/qrcode/' . $surat->TandaTangan) ?>" download class="btn btn-sm btn-primary mt-2">
                    <i class="fa fa-download"></i> Download QR Code
                </a>
            </div>
        <?php endif; ?>

                         <div class="mt-3  justify-content-between">
                            
                        <?php if ($surat->status === 'draft'): ?>
                        <a href="<?= base_url('Surat/permohonanSurat/' . $surat->KodeSurat) ?>" class="btn btn-success ">Ajukan</a>
                        <?php endif; ?>

                        <!-- <a href="<?= base_url('Surat/tolakSurat/' . $surat->KodeSurat) ?>" class="btn btn-danger ">Tolak</a> -->

                        <button type="button" class="btn btn-secondary" onclick="history.back();">Kembali</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function copyToClipboard(elementId, iconElement) {
    // Pilih elemen input
    const inputElement = document.getElementById(elementId);

    // Pilih teks di dalam input
    inputElement.select();
    inputElement.setSelectionRange(0, 99999); // Untuk perangkat seluler

    try {
        // Salin teks ke clipboard menggunakan Clipboard API
        navigator.clipboard.writeText(inputElement.value).then(() => {
            // Tampilkan tooltip "Tersalin!"
            const tooltip = document.getElementById('copiedTooltip');
            if (tooltip) {
                tooltip.style.opacity = '1'; // Tampilkan tooltip
                setTimeout(() => {
                    tooltip.style.opacity = '0'; // Sembunyikan tooltip setelah 1.5 detik
                }, 1500);
            }
        }).catch(err => {
            console.error('Gagal menyalin teks (Clipboard API): ', err);
            alert('Gagal menyalin teks ke clipboard. Silakan salin secara manual.');
        });
    } catch (err) {
        // Fallback untuk browser lama atau jika navigator.clipboard tidak didukung
        console.warn('Clipboard API tidak didukung, menggunakan document.execCommand().');
        document.execCommand("copy");

        // Tampilkan tooltip
        const tooltip = document.getElementById('copiedTooltip');
        if (tooltip) {
            tooltip.style.opacity = '1';
            setTimeout(() => {
                tooltip.style.opacity = '0';
            }, 1500);
        }
    }
}
</script>