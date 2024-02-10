<?php
session_start();
include "../koneksi.php";

if ($_POST) {
    // Perintah Tambah
    if ($_POST['aksi'] == 'tambah') {
        $produk_id = $_POST['produk_id'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $jumlah = $_POST['jumlah'];
        $user_id = $_SESSION['user_id'];

        // Cek Apakah Barang Sudah Ada?
        $sql_cek = "SELECT * from penjualan_keranjang where produk_id=$produk_id";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $ketemu = mysqli_num_rows($query_cek);

        if ($ketemu >= 1) {
            $sql = "UPDATE penjualan_keranjang set harga_beli=$harga_beli,harga_jual=$harga_jual,jumlah=$jumlah where produk_id=$produk_id";
        } else {
            $sql = "INSERT into penjualan_keranjang(id_jual_keranjang,produk_id,harga_beli,harga_jual,jumlah,user_id) values(DEFAULT,$produk_id,$harga_beli,$harga_jual,$jumlah,$user_id)";
        }

        //echo $sql;
        mysqli_query($koneksi, $sql);
        header('location:../index.php?hal=jual-tambah');
    }

    if ($_POST['aksi'] == 'tambah-by-barcode') {
        $jumlah = $_POST['jumlah'];
        $barcode = $_POST['barcode'];        

        $sql_cari = "SELECT * from produk where barcode='$barcode'";
        $query_cari = mysqli_query($koneksi, $sql_cari);
        $ketemu_barcode = mysqli_num_rows($query_cari);

        if ($ketemu_barcode >= 1) {
            $ambil_id = mysqli_fetch_array($query_cari);
            $id_produk = $ambil_id['produk_id'];
            $harga_beli = $ambil_id['harga_beli'];
            $harga_jual = $ambil_id['harga_jual'];
            $user_id = $_SESSION['user_id'];

            // Cek Apakah produk Sudah Ada?
            $sql_cek = "SELECT * from penjualan_keranjang where produk_id=$id_produk";
            $query_cek = mysqli_query($koneksi, $sql_cek);
            $ketemu = mysqli_num_rows($query_cek);

            if ($ketemu >= 1) {
                $sql = "UPDATE penjualan_keranjang set jumlah=jumlah+$jumlah where produk_id=$id_produk";
            } else {
                $sql = "INSERT into penjualan_keranjang(id_jual_keranjang,produk_id,harga_beli,harga_jual,jumlah,user_id) values(DEFAULT,$id_produk,$harga_beli,$harga_jual,$jumlah,$user_id)";
            }

            //echo $sql;
            mysqli_query($koneksi, $sql);
        } else {
            echo "Barcode Tidak Ketemu";
        }

        header('location:../index.php?hal=jual-tambah');
    }
}

if ($_GET) {
    // Perintah Hapus Data
    if ($_GET['aksi'] == 'hapus') {
        $id = $_GET['id'];
        $sql = "DELETE from penjualan_keranjang where id_jual_keranjang=$id";
        mysqli_query($koneksi, $sql);

        header('location:../index.php?hal=jual-tambah');
    }
}
