<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('<?= base_url('img/BG1.jpg') ?>');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: white;
      padding: 2rem;
      border-radius: 1.25rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .login-logo {
      display: block;
      margin: 0 auto 1rem auto;
      max-width: 120px;
    }

    .form-control {
      border-radius: 0.75rem;
    }

    .btn-login {
      background-color: #6366f1;
      border: none;
      color: white;
      width: 100%;
      border-radius: 0.75rem;
    }

    .btn-login:hover {
      background-color: #4f46e5;
    }

    .text-link {
      color: #6366f1;
      text-decoration: none;
    }

    .text-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  
<div class="login-container">
  <div class="login-card">
    <img src="<?= base_url('img/SIDADU LOGO.png') ?>" class="login-logo" alt="Logo">

    <h5 class="text-center mb-2">Selamat Datang</h5>
    <p class="text-center text-muted mb-4">Silakan login untuk melanjutkan</p>

    <?php if ($this->session->flashdata('pesan')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('Halamanlog/proseslogin') ?>" id="formlogin">
      <div class="mb-3">
        <label for="JenisAkun" class="form-label">Jenis Akun</label>
        <select id="JenisAkun" name="JenisAkun" class="form-select" required>
          <option value="">Pilih Level</option>
          <option value="Admin">Admin</option>
          <option value="Kaling">Kepala Lingkungan</option>
          <option value="Penanggungjawab">Penanggungjawab</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="Username" class="form-label">Username</label>
        <input type="text" name="Username" id="Username" class="form-control" placeholder="Masukkan NIK anda" required>
      </div>

      <div class="mb-4">
        <label for="Password" class="form-label">Password</label>
        <input type="password" name="Password" id="Password" class="form-control" placeholder="Masukkan Password" required>
      </div>

      <button type="submit" class="btn btn-login mb-3">Login</button>

      <div class="text-center">
        Belum punya akun? <a href="<?= base_url('Chalaman/registrasi') ?>" class="text-link">Daftar</a>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  $(document).on('keydown', function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      $('#formlogin').submit();
    }
  });
</script>

</body>
</html>