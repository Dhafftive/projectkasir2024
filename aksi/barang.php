<?php
include "../koneksi.php";

if($_POST){
    // Perintah Tambah
    if($_POST['aksi']=='tambah'){
        $nama_produk=$_POST['nama_produk'];
        $stok=$_POST['stok'];
        $harga_beli=$_POST['harga_beli'];
        $harga_jual=$_POST['harga_jual'];
        $barcode=$_POST['barcode'];

        $sql="INSERT into produk (produk_id,nama_produk,stok,harga_beli,harga_jual,barcode) values(DEFAULT,'$nama_produk',$stok,$harga_beli,$harga_jual,$barcode)";
        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=barang');
    }
    // Perintah Ubah
    if($_POST['aksi']=='ubah'){
        $produk_id=$_POST['produk_id'];
        $nama_produk=$_POST['nama_produk'];
        $stok=$_POST['stok'];
        $harga_beli=$_POST['harga_beli'];
        $harga_jual=$_POST['harga_jual'];
        $barcode=$_POST['barcode'];

        $sql="UPDATE produk set nama_produk='$nama_produk',stok=$stok,harga_beli=$harga_beli,harga_jual=$harga_jual,barcode=$barcode where produk_id=$produk_id";

        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=barang');
    }

}

if($_GET){
    // Perintah Hapus Data
    if($_GET['aksi']=='hapus'){
        $id=$_GET['id'];
        $sql="DELETE from produk where produk_id=$id";
        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=barang');
    }
}
