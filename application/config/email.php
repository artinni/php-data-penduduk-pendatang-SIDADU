<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com'; // Perbaikan di sini: Hapus 'ssl://', hanya nama host
$config['smtp_port']   = 465; // Untuk SSL, port standar adalah 465. Jika menggunakan TLS, portnya 587.
$config['smtp_user']   = 'cutemeowmeow111@gmail.com'; // Ganti dengan email kamu
$config['smtp_pass']   = 'ekvjxvklzcntawxz'; // Gunakan App Password Gmail
$config['smtp_crypto'] = 'ssl'; // Tetap gunakan ini untuk enkripsi SSL
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['crlf']        = "\r\n"; 