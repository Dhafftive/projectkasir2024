<?php
include "../koneksi.php";

if ($_POST) {
    // Perintah Tambah
    if ($_POST['aksi'] == 'tambah') {
        $produk_id = $_POST['produk_id'];
        $harga_beli = $_POST['harga_beli'];
        $jumlah = $_POST['jumlah'];
        $user_id = 4;

        // Cek Apakah Barang Sudah Ada?
        $sql_cek = "SELECT * from pembelian_keranjang where produk_id=$produk_id";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $ketemu = mysqli_num_rows($query_cek);

        if ($ketemu >= 1) {
            $sql = "UPDATE pembelian_keranjang set harga_beli=$harga_beli,jumlah=$jumlah where produk_id=$produk_id";
        } else {
            $sql = "INSERT into pembelian_keranjang(id_beli_keranjang,produk_id,harga_beli,jumlah,user_id) values(DEFAULT,$produk_id,$harga_beli,$jumlah,$user_id)";
        }

        //echo $sql;
        mysqli_query($koneksi, $sql);

        header('location:../index.php?hal=beli-tambah');
    }

    if ($_POST['aksi'] == 'tambah-by-barcode') {
        $jumlah = $_POST['jumlah'];
        $barcode = $_POST['barcode'];
        $harga_beli = $_POST['harga_beli'];

        $sql_cari = "SELECT * from produk where barcode='$barcode'";
        $query_cari = mysqli_query($koneksi, $sql_cari);
        $ketemu_barcode = mysqli_num_rows($query_cari);

        if ($ketemu_barcode >= 1) {
            $ambil_id = mysqli_fetch_array($query_cari);
            $produk_id = $ambil_id['produk_id'];
            $user_id = 4;

            // Cek Apakah Barang Sudah Ada?
            $sql_cek = "select * from pembelian_keranjang where produk_id=$produk_id";
            $query_cek = mysqli_query($koneksi, $sql_cek);
            $ketemu = mysqli_num_rows($query_cek);

            if ($ketemu >= 1) {
                $sql = "UPDATE pembelian_keranjang set harga_beli=$harga_beli,jumlah=$jumlah where produk_id=$produk_id";
            } else {
                $sql = "INSERT into pembelian_keranjang(id_beli_keranjang,produk_id,harga_beli,jumlah,user_id) values(DEFAULT,$produk_id,$harga_beli,$jumlah,$user_id)";
            }

            //echo $sql;
            mysqli_query($koneksi, $sql);
        } else {
            echo "Barcode Tidak Ketemu";
        }

        header('location:../index.php?hal=beli-tambah');
    }
}

if ($_GET) {
    // Perintah Hapus Data
    if ($_GET['aksi'] == 'hapus') {
        $id = $_GET['id'];
        $sql = "DELETE from pembelian_keranjang where id_beli_keranjang=$id";
        mysqli_query($koneksi, $sql);

        header('location:../index.php?hal=beli-tambah');
    }
}
