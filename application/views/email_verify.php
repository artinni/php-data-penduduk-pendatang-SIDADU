<!-- application/views/email_verify.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>Verifikasi Email</h4>
                </div>
                <div class="card-body text-center">
                    <?php if (isset($status) && $status == 'sukses'): ?>
                        <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                        <h5>Email kamu berhasil diverifikasi!</h5>
                        <p>Silakan login untuk melanjutkan.</p>
                        <a href="<?= base_url('Halamanlog') ?>" class="btn btn-success" onclick="goBack()">Login</a>
                    <?php else: ?>
                        <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                        <h5>Link verifikasi tidak valid atau sudah digunakan.</h5>
                        <p>Silakan minta link baru atau hubungi admin.</p>
                        <a href="<?= base_url('Halamanlog') ?>" class="btn btn-danger">Kembali ke Login</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- FontAwesome dan Bootstrap JS -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function goBack() {
    if (window.history.length > 1) {
        window.history.back(); // kembali ke halaman sebelumnya
    } else {
        window.location.href = "<?= base_url('Halamanlog') ?>"; // fallback
    }
}

//     function closeAndReload() {
//     if (window.opener) {
//         window.opener.location.reload(); // reload halaman asal
//         window.close(); // tutup tab verifikasi
//     } else {
//         window.location.href = "<?= base_url('Halamanlog') ?>";
//     }
// }
</script>

</body>
</html>
