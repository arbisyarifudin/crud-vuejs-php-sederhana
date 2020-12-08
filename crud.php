<?php

include 'function.php'; // panggl function 

// allow cors
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTION');
header('Content-Type: application/json');

// ambil data input/body dari axios 
$input = json_decode(file_get_contents("php://input"), TRUE);

// jika request methodnya GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // jika parameter aksi == tampil_produk, maka jalankan fungsi tampil produk
    if ($_GET['aksi'] == 'tampil_produk') {
        $data_produk = tampil('tb_produk');

        // kasihkan data json ke si axios / pemanggil
        echo json_encode($data_produk);
    }

    // dan seterusnya..
    if ($_GET['aksi'] == 'tampil_kategori') {
        # code
    }
}

// jika request methodnya POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // jika $_POST aksi == tambah_produk 
    if ($_POST['aksi'] == 'tambah_produk') {


        // masukan masing2 data post dr inputkan ke dalam array $data_tambah
        // data ini akan di masukan ke dalam database nanti
        $data_tambah = array(
            'nama' => $_POST['nama'],
            'harga' => $_POST['harga'],
            'berat' => $_POST['berat'],
            'deskripsi' => $_POST['deskripsi'],
        );

        // ambil gambar yang mau diupload
        $gambar = $_FILES['file'];

        // ambil nama file nya dan tambahkan time() untuk membuat nama file acak
        $nama_file = time() . $gambar['name'];

        // ambil lokasi sementara file berada
        $lokasi_temp = $gambar['tmp_name'];

        // pindahkan foto dari lokasi sementara ke folder gambar
        move_uploaded_file($lokasi_temp, "gambar/$nama_file");

        // masukan $nama_file ke dalam array $data_tambah 
        // agar ikut masuk saat proses insert ke table produk
        $data_tambah['gambar'] = $nama_file;

        // jalankan fungsi tambah produk berdasarkan id nya
        tambah('tb_produk', $data_tambah);

        // buat pesan respon
        $respon = [
            'sukses' => TRUE,
            'pesan' => 'Produk berhasil ditambah!',
            'tipe' => 'success',
        ];

        // kasihkan pesan json ke si axios / pemanggil di frontend
        echo json_encode($respon);
    }

    if ($_POST['aksi'] == 'tambah_kategori') {
        # code
    }

    // untuk ubah produk
    if ($_POST['aksi'] == 'ubah_produk') {

        // ambil $_POST id_produk
        $id_produk = $_POST['id_produk'];

        // siapkkan data yang mau di update
        // masukan masing2 data post dr inputkan ke dalam array $data_update
        // array ini akan di jadikan where clause di fungsi update nanti
        $data_update = array(
            'nama' => $_POST['nama'],
            'harga' => $_POST['harga'],
            'berat' => $_POST['berat'],
            'deskripsi' => $_POST['deskripsi'],
        );

        //cek apakah user mau update gambar produk
        // jika ada inputan file nya, maka upload/update gambar produk
        if (!empty($_FILES['file']['name'])) {

            // ambil gambar yang mau diupload
            $gambar = $_FILES['file'];

            // ambil nama file nya dan tambahkan time() untuk membuat nama file acak
            $nama_file = time() . $gambar['name'];

            // ambil lokasi sementara file berada
            $lokasi_temp = $gambar['tmp_name'];

            // pindahkan foto dari lokasi sementara ke folder gambar
            move_uploaded_file($lokasi_temp, "gambar/$nama_file");

            // masukan $nama_file ke dalam array $data_update 
            // agar ikut masuk saat proses update di fungsi update nanti
            $data_update['gambar'] = $nama_file;
        }

        // yang mana yang mau di update
        $kondisi_where = array('id' => $id_produk);

        // jalankan fungsi update berdasarkan kondisi where nya
        $hasil = update(
            'tb_produk',
            $data_update,
            $kondisi_where
        );

        if (!$hasil) {
            // buat pesan respon gagal
            $respon = [
                'sukses' => FALSE,
                'pesan' => 'Error! Produk gagal diperbarui.',
                'tipe' => 'warning',
            ];
        } else {
            // buat pesan respon
            $respon = [
                'sukses' => TRUE,
                'pesan' => 'Produk berhasil diperbarui!',
                'tipe' => 'success',
            ];
        }

        // kasihkan pesan json ke si axios / pemanggil
        echo json_encode($respon);
    }

    // untuk ubah kategori misal
    if ($_POST['aksi'] == 'ubah_kategori') {
        #
    }

    // jika $_POST aksi == hapus_produk 
    if ($_POST['aksi'] == 'hapus_produk') {

        // ambil $_POST id_produk
        $id_produk = $_POST['id_produk'];

        // yang mana yang mau di hapus
        $kondisi_where = array('id' => $id_produk);

        // jalankan fungsi hapus produk berdasarkan kondisi where nya
        $hasil = hapus('tb_produk', $kondisi_where);

        if (!$hasil) {
            // buat pesan respon gagal
            $respon = [
                'sukses' => FALSE,
                'pesan' => 'Error! Produk gagal dihapus',
                'tipe' => 'warning',
            ];
        } else {
            // buat pesan respon
            $respon = [
                'sukses' => TRUE,
                'pesan' => 'Produk berhasil dihapus!',
                'tipe' => 'success',
            ];
        }


        // kasihkan pesan json ke si axios / pemanggil
        echo json_encode($respon);
    }

    if ($_POST['aksi'] == 'hapus_kategori') {
        # code
    }

    // dan seterusnya..
}
