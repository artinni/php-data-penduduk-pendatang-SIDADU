<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Jenis Surat</title>
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
      <h3>Form Pengajuan Surat</h3>
      <div class="alert alert-warning d-flex align-items-center mt-3" role="alert">
        <i class="fas fa-exclamation-triangle fa-lg fa-3x" style="margin-right: 15px;"></i>
        <div>
          <strong>Pemberitahuan:</strong><br>
          1. Data pendatang akan otomatis terisi setelah Anda input NIK dari pendatang!</br>
          2. Surat yang disimpan tidak bisa di edit! </br>
          3. Sebelum mengajukan surat, harap lihat draft surat terlebih dahulu! </br>
          4. Jika terdapat kesalahan isi dalam surat, ajukan ulang dengan menghapus surat yang salah!
        </div>
      </div>
      <?php
      $pesan = $this->session->flashdata('pesan');
      if ($pesan != "") {
        echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>' . $pesan . '
              </div>';
      }
      ?>

      <form method="post" id="formSurat" action="<?php echo base_url('Surat/simpanSurat'); ?>">
        <!-- <input type="hidden" name="KodeJenis" id="KodeJenis"/> -->
        <table class="form-table">
          <tr>
            <td><label for="NamaJenis">Jenis Surat</label></td>
            <td> <div id="combo-container"> 
              <?php echo $this->Model_JenisSurat->combojenis('KodeJenis'); ?></div>
            </td>
          </tr>
          <tr>
            <td><label for="NamaJenis">Pilih ACC Surat</label></td>
            <td> <div id="combo-container"> 
              <?php echo $this->Model_JenisSurat->combokaling('KodeKaling'); ?></div>
            </td>
          </tr>
          <tr>
            <td><label>Catatan</label></td>
            <td><textarea type="text" name="Catatan" id="Catatan" placeholder="Isikan Catatan Surat Yang Diajukan" class="form-control" rows="4"></textarea></td>
          </tr>
          <tr>
          <td><label for="NIK">Username Pendatang (NIK)</label></td>
          <td>
          <div class="row">
            <div class="col-8">
              <input type="text" name="NIK" id="NIK" placeholder="Masukkan NIK" class="form-control">
            </div>
            <div class="col-4">
              <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
            </div>
          </div>
        </td>
        </tr>
          <tr>
          <td colspan="2">
            <div id="form-data-pendatang"></div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
           <div id="dynamicFields"></div>
          </td>
        </tr>
        </table>

        <div class="text-center mt-4">
          <input type="button" value="Simpan" class="btn btn-primary" onclick="simpanSurat();">
          <input type="reset" value="Reset" class="btn btn-warning">
        </div>
      </form>
    </div>
  </div>
<script>
function simpanSurat() {
    var KodeJenis = $('#KodeJenis').val();
    if (KodeJenis == "") {
        alert("Nama Jenis Surat masih kosong...");
        $('#KodeJenis').focus();
        return false;
    }
    $('#formSurat').submit();
}

</script>

<script>
$(document).ready(function () {
    // Event saat KodeJenis berubah
    $('#KodeJenis').change(function () {
    var kodeJenis = $(this).val();
    if (kodeJenis !== '') {
        $.ajax({
            url: '<?= base_url("Surat/get_field_isian/") ?>' + kodeJenis,
            type: 'GET',
            dataType: 'json',
            success: function (fields) {
                var html = '';
                fields.forEach(function (field) {
                    html += `
                        <div class="form-group">
                            <label>${field}</label>
                            <input type="text" name="${field}" id="${field}" class="form-control"/>
                        </div>
                    `;
                });
                $('#dynamicFields').html(html);
            }
        });
    }
});

    // Tombol cari pendatang
    $('#formSurat').on('click', '.btn-primary', function () {
        var nik = $('#NIK').val();
        var kodeJenis = $('#KodeJenis').val();

        if (nik === '') {
            alert('Silakan masukkan NIK terlebih dahulu.');
            return;
        }

        if (kodeJenis === '') {
            alert('Silakan pilih Jenis Surat terlebih dahulu.');
            return;
        }

        $.getJSON('<?= base_url("Surat/get_field_jenis_surat/") ?>' + kodeJenis, function (fieldList) {
            $.getJSON('<?= base_url("Surat/get_data_pendatang/") ?>' + nik, function (pendatangData) {
                var container = $('#form-data-pendatang');
                container.empty();
                fieldList = typeof fieldList === 'string' ? JSON.parse(fieldList) : fieldList;

                fieldList.forEach(function (field) {
                    var value = pendatangData[field] ?? '';
                    var label = field.replace(/([A-Z])/g, ' $1');
                    container.append(`
                        <div class="form-group">
                            <label>${label}</label>
                            <input type="text" name="${field}" value="${value}" class="form-control" readonly>
                        </div>
                    `);
                });
            });
        });
    });
});
$('#btnCari').click(function () {
    var nik = $('#NIK').val();
    if (nik === '') {
        alert('Masukkan NIK terlebih dahulu');
        return;
    }

    $.ajax({
        url: '<?= base_url("Surat/get_data_pendatang/") ?>' + nik,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                // isi otomatis field yang cocok
                for (var key in data) {
                    $('#' + key).val(data[key]).prop('readonly', true);
                }
            }
        },
        error: function () {
            alert('Terjadi kesalahan saat mengambil data.');
        }
    });
});

$(document).ready(function() {
    $('#KodeKaling').select({
        templateResult: function (data) {
            if (!data.id) return data.text;
            var $html = $(data.element).data('html');
            return $html ? $(data.element).data('html') : data.text;
        },
        templateSelection: function (data) {
            return data.text;
        },
        escapeMarkup: function (m) { return m; }
    });
});
</script>  
</body>
</html>
