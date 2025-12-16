<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registrasi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: linear-gradient(to right, #dbeafe, #e0e7ff);
      font-family: 'Poppins', sans-serif;
    }

    .register-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .register-card {
      background: white;
      padding: 2rem;
      border-radius: 1.25rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .form-control, .form-select {
      border-radius: 0.75rem;
    }

    .btn-register {
      background-color: #6366f1;
      border: none;
      border-radius: 0.75rem;
      width: 100%;
    }

    .btn-register:hover {
      background-color: #4f46e5;
    }

    .text-link {
      color: #6366f1;
    }

  </style>
</head>

<body>
<div class="register-container">
  <div class="register-card">
    <h4 class="text-center mb-4">Buat Akun Baru</h4>

    <?php if ($this->session->flashdata('pesan')): ?>
  <script>
    Swal.fire({
      icon: '<?= strpos($this->session->flashdata("pesan"), "sudah") !== false ? "error" : "success" ?>',
      title: '<?= strpos($this->session->flashdata("pesan"), "sudah") !== false ? "Gagal!" : "Berhasil!" ?>',
      text: '<?= $this->session->flashdata("pesan"); ?>'
    });
  </script>
<?php endif; ?>

    <form method="post" id="formdaftar" action="<?= base_url('Chalaman/daftar') ?>" enctype="multipart/form-data">
      <input type="hidden" name="KodeDaftar" id="KodeDaftar" />

      <div class="mb-3">
        <label for="JenisAkun" class="form-label">Jenis Akun</label>
        <select id="JenisAkun" name="JenisAkun" class="form-select" required>
          <option value="">Pilih Level</option>
          <option value="KepalaLingkungan">Kepala Lingkungan</option>
          <option value="PenanggungJawab">Penanggungjawab</option>
        </select>
      </div>

      <div class="mb-3">
        <input type="text" class="form-control" id="Username" name="Username" placeholder="Username (NIK KTP anda)"  onblur="cekUsername()"required>
        <small id="usernameHelp" class="text-danger"></small>
      </div>

      <div class="mb-3">
        <input type="text" class="form-control" id="NamaLengkap" name="NamaLengkap" placeholder="Nama Lengkap" required>
      </div>

      <div class="mb-3">
        <input type="email" class="form-control" id="Email" name="Email" placeholder="Alamat Email" required>
      </div>

      <div class="mb-3">
        <input type="text" class="form-control" id="Telp" name="Telp" placeholder="Nomor Telepon" required>
      </div>

      <div class="mb-3">
        <input type="Password" class="form-control" id="Password" name="Password" placeholder="Password" required>
      </div>
      <div class="mb-3">
  <input type="text" class="form-control" id="Alamat" name="Alamat" placeholder="Alamat Lengkap" required>
</div>

<div class="mb-3">
  <label for="JenisKelamin" class="form-label">Jenis Kelamin</label>
  <select class="form-select" name="JenisKelamin" id="JenisKelamin" required>
    <option value="">Pilih Jenis Kelamin</option>
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
  </select>
</div>

      <div class="d-grid gap-2">
        <button type="button" class="btn btn-register" onclick="simpandaftar()">Simpan</button>
        <button type="reset" class="btn btn-secondary">Hapus</button>
      </div>

      <div class="text-center mt-3">Sudah punya akun? 
        <a href="<?= base_url() ?>" class="text-link">Login!</a>
      </div>
      
    </form>
  </div>
</div>

<!-- SweetAlert Submit -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  function simpandaftar() {
    // Ambil semua field yang diperlukan
    const jenisAkun = document.getElementById('JenisAkun').value.trim();
    const username = document.getElementById('Username').value.trim();
    const namaLengkap = document.getElementById('NamaLengkap').value.trim();
    const email = document.getElementById('Email').value.trim();
    const telp = document.getElementById('Telp').value.trim();
    const password = document.getElementById('Password').value.trim();
    const alamat = document.getElementById('Alamat') ? document.getElementById('Alamat').value.trim() : '';
    const jenisKelamin = document.getElementById('JenisKelamin') ? document.getElementById('JenisKelamin').value.trim() : '';

    // Cek jika ada field yang kosong
    if (!jenisAkun || !username || !namaLengkap || !email || !telp || !password || !alamat || !jenisKelamin) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Semua field wajib diisi!'
      });
      return; // hentikan eksekusi
    }

    // Jika semua valid, tampilkan konfirmasi
    Swal.fire({
      title: 'Yakin ingin menyimpan data?',
      text: 'Pastikan semua data sudah benar.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#6366f1',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, simpan!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('formdaftar').submit();
      }
    });
  }
</script>
</body>
</html>
