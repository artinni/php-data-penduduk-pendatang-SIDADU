
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIDADU-ADMIN</title>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
<style>
.border-left-purple {
  border-left: 5px solid #674188; /* ungu */
}

.border-left-green {
  border-left: 5px solid #347433; /* hijau */
}

.border-left-maroon {
  border-left: 5px solid #56021F; 
}

.border-left-navy {
  border-left: 5px solid #27548A;
}

.border-left-orange {
  border-left: 5px solid #B22222;
}

.custom-card {
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 4px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  height: 100%;
}

.admin-logo {
  width: 50px;
  height: 50px;
  object-fit: cover;         /* Isi tetap proporsional */
  border-radius: 50%;        /* Bentuk lingkaran */
  background-color: white;   /* Latar belakang putih */
  padding: 5px;              /* Jeda antara gambar dan background putih */
  box-shadow: 0 0 5px rgba(0,0,0,0.1); /* Opsional: bayangan halus */
}

.sidebar-brand-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
</head>

<body id="page-top">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
          <ul class="navbar-nav sidebar sidebar-dark accordion sidebar-fixed left" style="background-color: #674188" id="accordionSidebar">
        <!-- <ul class="navbar-nav sidebar sidebar-dark accordion position-fixed" style="background-color: #674188" id="accordionSidebar"> -->

    <!-- Sidebar - Brand -->
<!-- Sidebar - Brand -->
<a href="<?= base_url('Dashboard'); ?>" 
   class="sidebar-brand d-flex align-items-center px-3" 
   style="min-height: 120px; padding: 20px 0;">

    <!-- Logo Bulat -->
    <div class="sidebar-brand-icon mr-3">
        <img src="<?= base_url('img/SIDADU LOGO.png') ?>" 
             class="admin-logo" 
             alt="Logo">
    </div>

    <!-- Teks di Samping Logo -->
    <div class="sidebar-brand-text">
        <h4 class="text-white mb-1" style="font-weight: bold; letter-spacing: 1px;">
            SIDADU </br>QW
        </h4>
        <small class="text-light d-block" style="font-size: 0.75rem;">
            Anda Login Sebagai:
        </small>
        <span class="badge badge-light px-3 py-1" style="font-weight: 600;">
    <?php
        $JenisAkun = $this->session->userdata('JenisAkun');
        switch ($JenisAkun) {
            case 'Admin':
                echo "<span style='font-size: 0.8rem;'>ADMIN</span>"; // Ukuran default
                break;
            case 'Penanggungjawab':
                echo "<span style='font-size: 0.65rem;'>PENANGGUNG </br>JAWAB</span>"; // Ukuran default
                break;
            case 'Kaling':
                echo "<span style='font-size: 0.65rem;'>KEPALA </br> LINGKUNGAN</span>"; // Ukuran lebih kecil
                break;
        }
    ?>
</span>
    </div>

</a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('Dashboard'); ?>">
            <i class="fa fa-desktop" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Master Data Section -->
    <div class="sidebar-heading">
        Master Data
    </div>

   <?php if ($JenisAkun == "Penanggungjawab"): ?>
    <!-- Tambahkan Data Pendatang (Penanggungjawab Only) -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Pendatang/index'); ?>">
            <i class="fas fa-users"></i>
            <span>Tambahkan Pendatang</span>
        </a>
    </li>
  <?php endif; ?>  
<!-- Data Pendatang (Available for All) -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Pendatang/datapendatang'); ?>">
            <i class="fas fa-users"></i>
            <span>Data Pendatang</span>
        </a>
    </li>

    <?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
    <!-- Data Penanggung Jawab (Admin Kaling) -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Penanggungjawab/datapj'); ?>">
            <i class="fas fa-address-book"></i>
            <span>Data Penanggung Jawab</span>
        </a>
    </li>  
    <!-- Data Kepala Lingkungan (Admin only) -->
     
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Kaling/datakaling'); ?>">
            <i class="fas fa-user-shield"></i>
            <span>Data Kepala Lingkungan</span>
        </a>
    </li>
    <?php endif; ?>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Dokumen Section -->
    <div class="sidebar-heading">
        Dokumen
    </div>
    <?php
                    $JenisAkun = $this->session->userdata('JenisAkun');
                    if ($JenisAkun=="Admin" || $JenisAkun == "Kaling" || $JenisAkun == "Penanggungjawab");
{

    ?>
<?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
<!-- membuat jenis surat untuk kaling/admin -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('JenisSurat/index'); ?>">
            <i class="fas fa-file-signature"></i>
            <span>Keluarkan Surat</span>
        </a>
    </li>
 <?php endif;?>
    <!-- Pengajuan Surat, bakal isi notif untuk pengajuan yang masuk ke kaling/admin  --> 
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Surat/Index'); ?>">
            <i class="fas fa-file-arrow-up"></i>
            <span>Pengajuan Surat</span>
        </a>
    </li>

    <!-- Laporan  -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Pendatang/laporan_bulanan'); ?>">
            <i class="fas fa-file-text"></i>
            <span>Laporan Administrasi</span>
        </a>
    </li>
<?php
}
?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    
    <!-- Sidebar Toggle (Topbar) untuk mobile -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

     <!-- Topbar Search -->
   <form class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 navbar-search" style="width: 300px;">
    <div class="input-group">
        <input type="text" class="form-control shadow bg-gray-200 border-0 small"
               placeholder="Cari fitur..." aria-label="Search" aria-describedby="basic-addon2"
               id="searchInput"> <div class="input-group-append">
            <button class="btn" type="button" style="background-color: #674188; color: white;">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>

    <!-- Marquee di tengah topbar -->
    <div class="d-none d-lg-flex align-items-center mx-3" style="flex: 1;">
    <marquee behavior="scroll" direction="left" style="width: 100%; height: 100%;">
        <span class="font-weight-bold" style="color: #674188; font-size: 18px;">SELAMAT DATANG DI SIDADU (SISTEM INFORMASI PENDATAAN PENDUDUK PENDATANG)</span>
    </marquee>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Nav Item - Alerts -->
         
<!-- Icon dropdown (lonceng) -->
<li class="nav-item dropdown no-arrow mx-1 d-flex align-items-center show">    <i class="fas fa-cog fa-spin fa-lg text-gray-700 mr-2"></i>

    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <span class="badge badge-danger badge-counter" id="notifCount">0</span>
    </a>

    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown" id="notifDropdown">
        <h6 class="dropdown-header" style="background-color: #674188;">Alerts Center</h6>
        <div id="notifContent">
            <!-- Notifikasi dinamis akan di-inject JavaScript di sini -->
        </div>
    </div>
</li> 
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 large">
            <?php echo $this->session->userdata('NamaLengkap'); ?>
        </span>
        <div> 
            <i class="fa fa-user" aria-hidden="true"></i>
        </div>
    </a>

    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        
        <!-- Lihat Akun - Link ke halaman User/index -->
        <a class="dropdown-item" href="<?php echo base_url('User/index'); ?>">
            <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i>
            Lihat Akun
        </a>

        <!-- Logout - Tetap gunakan modal -->
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</li>

    </ul>

</nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
    <div class="row">
        <?php
        $JenisAkun = $this->session->userdata('JenisAkun');
        if ($JenisAkun == "Admin" || $JenisAkun == "Kaling") { // Perbaiki logika if, hilangkan ; setelah kondisi
        ?>
            <?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
                <div class="col-xl-3 col-md-6 mb-10 searchable-card"> <div class="card custom-card border-left-purple h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-10" style="font-size:large">
                                        <a href="<?= base_url('Pendatang') ?>" style="color: #674188">TAMBAHKAN PENDATANG</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-person-circle-plus fa-3x" style="color: #674188;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($JenisAkun == "Admin"): ?>
                <div class="col-xl-3 col-md-6 mb-10 searchable-card"> <div class="card custom-card border-left-navy h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size:large">
                                        <a href="<?= base_url('Kaling/index') ?>" style="color: #27548A" >TAMBAHKAN KEPALA LINGKUNGAN</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tag fa-3x" style="color:#27548A"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>

            <?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
                <div class="col-xl-3 col-md-6 mb-10 searchable-card"> <div class="card custom-border border-left-green shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size:large">
                                        <a href="<?= base_url('Penanggungjawab')?>"style="color: #347433">TAMBAHKAN PENANGGUNG JAWAB</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-house-user fa-3x " style="color:#347433"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
                <div class="col-xl-3 col-md-6 mb-10 searchable-card"> <div class="card border-left-orange shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size:large" >
                                        <a href="<?= base_url('Surat/datasurat') ?>" style="color: #B22222">SURAT MASUK</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-arrow-down fa-3x " style="color:#B22222"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php
        } // Tutup if ($JenisAkun=="Admin" || $JenisAkun == "Kaling");
        ?>
    </div>
</div>
                        <!-- Pending Requests Card Example -->
                        
                        <?php
						if(empty($konten))
						{
							echo "";	
						}
						else
						{
							echo $konten;	
						}
						?>
                        
                        <?php
						if(empty($table))
						{
							echo "";	
						}
						else
						{
							echo $table;	
						}
						?>    
                    </div>

                    <!-- Content Row -->
                        </div>
                    </div>

                    <!-- Content Row -->
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Pendataan Penduduk Artini 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
        <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin meninggalkan halaman ini?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" buntuk meninggalkan halaman ini!</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="<?php echo base_url('Dashboard/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script>
  console.log("jQuery Version:", $.fn.jquery);
</script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<!-- <?php if ($this->uri->segment(1) == 'Dashboard'): ?>
    <script src="<?= base_url('assets/js/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('assets/js//demo/chart-pie-demo.js') ?>"></script>
<?php endif; ?> -->
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
        console.log("jQuery Version:", $.fn.jquery); // Pastikan ini menampilkan versi jQuery
    </script>

<script>
     $(document).on('keydown', function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                // $('#formlogin').submit(); // Ini untuk halaman login, tidak perlu di sini
            }
        });

        // --- JavaScript untuk Fungsi Pencarian Fitur di Sidebar ---
       $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            console.log("Mencari:", searchTerm);

            // --- Logika Pencarian Fitur di Sidebar ---
            $('#accordionSidebar .nav-item').each(function() {
                var navItem = $(this);
                var navItemText = navItem.find('span').text().toLowerCase();
                // console.log("Item menu sidebar:", navItemText); // Debugging

                if (navItemText.includes(searchTerm)) {
                    navItem.show();
                } else {
                    navItem.hide();
                }
            });

            // --- Logika Pencarian Kartu Informasi di Konten Utama ---
            $('.searchable-card').each(function() { // Gunakan kelas baru yang kita tambahkan
                var cardItem = $(this);
                // Ambil teks dari elemen <a> atau <div> yang berisi teks utama di dalam kartu
                // Anda mungkin perlu menyesuaikan selektor ini (.find('a') atau .find('.text-xs'))
                var cardText = cardItem.find('a').text().toLowerCase(); // Asumsi teks ada di dalam <a>
                // console.log("Item kartu:", cardText); // Debugging

                if (cardText.includes(searchTerm)) {
                    cardItem.show();
                } else {
                    cardItem.hide();
                }
            });
        });
    });

        // --- Akhir JavaScript Pencarian Fitur ---

function showHapusModal(url) {
    console.log("URL yang dikirim: " + url); // untuk cek apakah URL terbentuk
    $('#btnHapus').attr('href', url);
    $('#hapusModal').modal('show');
}

$(document).ready( function () {
    $('#dataTable').DataTable();
} );


$(document).ready(function() {
    function loadNotifikasi() {
        $.ajax({
            url: '<?= base_url('Dashboard/getNotifikasi') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("RESPON NOTIF:", data); // log respon

                // Tampilkan jumlah notifikasi
                if (data.total > 0) {
                    $('#notifCount').text(data.total).show();
                } else {
                    $('#notifCount').hide();
                }

                let list = '';
<?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
                // Notifikasi umum: surat
                if (data.surat > 0) {
                    list += `<a class="dropdown-item d-flex align-items-center" href="<?= base_url('Surat/datasurat') ?>">
                        <div class="mr-3"><div class="icon-circle bg-primary"><i class="fas fa-file-alt text-white"></i></div></div>
                        <div><div class="small text-gray-500">Hari ini</div>${data.surat} surat butuh verifikasi.</div>
                    </a>`;
                }
                <?php endif; ?>

                // Notifikasi khusus PJ (pendatang)
             if (data.pendatang > 0) {
                    list += `<a class="dropdown-item d-flex align-items-center" href="<?= base_url('Pendatang/index') ?>">
                        <div class="mr-3"><div class="icon-circle bg-success"><i class="fa-solid fa-people-group text-white"></i></div></div>
                        <div><div class="small text-gray-500">Hari ini</div>${data.pendatang} pendatang dalam proses.</div>
                    </a>`;
                }

                // Notifikasi PJ menunggu konfirmasi
                <?php if ($JenisAkun == "Admin" || $JenisAkun == "Kaling"): ?>
                if (data.pj > 0) {
                    list += `<a class="dropdown-item d-flex align-items-center" href="<?= base_url('Penanggungjawab/index') ?>">
                        <div class="mr-3"><div class="icon-circle bg-warning"><i class="fas fa-user-check text-white"></i></div></div>
                        <div><div class="small text-gray-500">Hari ini</div>${data.pj} PJ menunggu konfirmasi.</div>
                    </a>`;
                }
                <?php endif; ?>
<?php if ($JenisAkun == "Admin" ): ?>
                // Notifikasi Kaling
                if (data.kaling > 0) {
                    list += `<a class="dropdown-item d-flex align-items-center" href="<?= base_url('Kaling/index') ?>">
                        <div class="mr-3"><div class="icon-circle bg-info"><i class="fa-solid fa-person-chalkboard text-white"></i></div></div>
                        <div><div class="small text-gray-500">Hari ini</div>${data.kaling} Kaling menunggu konfirmasi.</div>
                    </a>`;
                }
<?php endif; ?>
                // Jika tidak ada notifikasi
                if (list === '') {
                    list = `<span class="dropdown-item text-muted text-center">Tidak ada notifikasi</span>`;
                }

                // Update isi dropdown
                $('#notifContent').html(list);
            }
        });
    }

    loadNotifikasi(); // pertama kali
    setInterval(loadNotifikasi, 30000); // per 30 detik
});


</script>

</body>

</html>