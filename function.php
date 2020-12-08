<?php

include 'koneksi.php'; // panggil koneksi

function tampil(string $nama_table)
{

    $sql = "SELECT * FROM $nama_table";

    $hasil = mysqli_query($GLOBALS['koneksi'], $sql);

    $semua_data = array();

    while ($data = mysqli_fetch_assoc($hasil)) {
        $semua_data[] = $data;
    }
    return $semua_data;
}

function hapus(string $nama_table, array $yang_mana)
{



    $sql = "DELETE FROM $nama_table WHERE ";

    foreach ($yang_mana as $key => $value) {
        // kalau kondisi where lebih dari 1
        if (count($yang_mana) > 1) {
            $sql .= "$key = '$value' AND ";
        } else {
            // kalau kondisi where hanya 1
            $sql .= "$key = '$value'";
        }
    }

    $sql = rtrim($sql, " AND ");


    $hasil = mysqli_query($GLOBALS['koneksi'], $sql);

    return $hasil;
}

function tambah(string $nama_table, array $data)
{
    $kolom = '';
    $isi = '';

    foreach ($data as $key => $value) {
        $kolom .= $key . ",";
        $isi   .= "'$value',";
    }
    $kolom = rtrim($kolom, ",");
    $isi = rtrim($isi, ",");

    $sql = "INSERT INTO $nama_table ($kolom) VALUES ($isi) ";

    $hasil = mysqli_query($GLOBALS['koneksi'], $sql);

    return $hasil;
}

function update(string $nama_table, array $data_set, array $yang_mana)
{

    $sql = "UPDATE $nama_table SET ";

    foreach ($data_set as $key => $value) {
        $sql .= "$key = '$value', ";
    }

    $sql = rtrim($sql, ", ");

    $sql .= " WHERE ";

    foreach ($yang_mana as $key => $value) {
        if (count($yang_mana) > 1) {
            //  kalau kondisi where lebih dari 1
            $sql .= "$key = '$value' AND ";
        } else {
            //  kalau kondisi where hanya 1
            $sql .= "$key = '$value'";
        }
    }

    $sql = rtrim($sql, " AND ");

    $hasil = mysqli_query($GLOBALS['koneksi'], $sql);

    return $hasil;
}
