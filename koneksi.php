<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'demo_vue';

$koneksi = mysqli_connect($host, $user, $password, $database);

// karena konsep yang saya buat bukan OOP -
// jadi saya buat $koneksi sebagai variabel global -
// agar bisa ditanggap oleh semua fungsi crud nanti.
$GLOBALS['koneksi'] = $koneksi;
