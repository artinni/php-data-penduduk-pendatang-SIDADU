
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lihat Akun Anda</title>
  <style>
    .form-section {
      background: #fff;
      padding: 20px;
      margin-top: 30px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-section h3 {
      text-align: center;
      color: #fff;
      margin-bottom: 20px;
      background-color: #674188;
      padding: 10px;
      border-radius: 5px;
    }
    table.form-table {
      width: 100%;
    }
    table.form-table td {
      padding: 10px;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container">
    <div class="form-section">
      <h3>Informasi Akun Anda</h3>
<form method="post" id="formJenisSurat" action="<?php echo base_url('JenisSurat/simpanJenisSurat'); ?>">
    <input type="hidden" name="KodeJenis" id="KodeJenis"/>

    <div class="row">
<div class="col-md-4 text-center">
    <div class="well well-sm" style="padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <span class="glyphicon glyphicon-user" style="font-size: 80px; color: #337ab7; margin-bottom: 15px;"></span>
        <h3 class="text-white" style="font-weight: bold; margin-top: 25px; color: #333; font-size: 22px;">
            <?php echo $this->session->userdata('NamaLengkap'); ?>
        </h3>
        <span class="label 
            <?= isset($level) && $level == 'admin' ? 'label-danger' : 
                (isset($level) && $level == 'penanggungjawab' ? 'label-success' : 
                (isset($level) && $level == 'kaling' ? 'label-info' : 'label-default')) ?>" 
            style="font-size: 14px; padding: 3px 6px; margin-top: 5px; display: inline-block;">
            <?= isset($level) ? ucfirst($level) : 'Tidak Diketahui'; ?>
        </span>
    </div>
</div>
                        
                        <!-- Profile Information -->
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="30%">
                                                <strong>
                                                    <span class="glyphicon glyphicon-user"></span> Nama Lengkap
                                                </strong>
                                            </td>
                                            <td><?php echo $this->session->userdata('NamaLengkap'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-tag"></span> NIK/Username
                                                </strong>
                                            </td>
                                            <td><?= isset($user['Username']) ? htmlspecialchars($user['Username']) : $this->session->userdata('Username'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-envelope"></span> Email
                                                </strong>
                                            </td>
                                            <td><?php echo $this->session->userdata('Email'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-envelope"></span> Nomor Telepon
                                                </strong>
                                            </td>
                                            <td>
                                            <?php echo $this->session->userdata('Telp'); ?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-certificate"></span> Jenis Akun
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="label label-<?= 
                                                    isset($level) && $level == 'admin' ? 'danger' :
                                                    (isset($level) && $level == 'penanggungjawab' ? 'success' :
                                                    (isset($level) && $level == 'kaling' ? 'info' : 'default'))
                                                ?>">
                                                    <?= isset($level) ? ucfirst($level) : 'Tidak Diketahui'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        <div class="text-center mt-4">
          <input type="button" value="Kembali" class="btn btn-warning" onclick="window.location.href='<?php echo base_url('Dashboard'); ?>'">
        </div>
      </form>
    </div>
  </div>
</body>
</html>