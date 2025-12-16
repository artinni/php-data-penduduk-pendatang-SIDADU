<?php if (!empty($TandaTangan)): ?>
    <div class="text-center">
        <p>QR Code:</p>
        <img src="<?= base_url('uploads/qrcode/' . $TandaTangan) ?>" width="150">
    </div>
<?php endif; ?>