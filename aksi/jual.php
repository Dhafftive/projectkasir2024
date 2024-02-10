<?php
session_start();
include "../koneksi.php";

if($_POST){
    if($_POST['aksi']=='tambah'){
        $id_pelanggan=$_POST['id_pelanggan'];
        $tanggal=$_POST['tanggal'];
        $waktu=$_POST['waktu'];

        // Simpan Ke Tabel Jual
        $sql_jual="INSERT INTO penjualan (penjualan_id,id_pelanggan,tanggal,waktu) VALUES (DEFAULT,$id_pelanggan,'$tanggal','$waktu')";
        //echo $sql_jual;
        mysqli_query($koneksi,$sql_jual);

        // Simpan Ke Jual Detail
        $sql_cari_penjualan_id="SELECT penjualan_id FROM penjualan WHERE tanggal='$tanggal' AND waktu='$waktu' ORDER BY penjualan_id DESC";
        // echo $sql_cari_penjualan_id;
        $query_cari_penjualan_id=mysqli_query($koneksi,$sql_cari_penjualan_id);
        $data_penjualan_id=mysqli_fetch_array($query_cari_penjualan_id);
        $penjualan_id=$data_penjualan_id['penjualan_id'];

        // echo $penjualan_id;
        $sql_keranjang="SELECT * FROM penjualan_keranjang";
        $query_keranjang=mysqli_query($koneksi,$sql_keranjang);
        while($data_keranjang=mysqli_fetch_array($query_keranjang)){
            $produk_id=$data_keranjang['produk_id'];
            $harga_beli=$data_keranjang['harga_beli'];
            $harga_jual=$data_keranjang['harga_jual'];
            $jumlah=$data_keranjang['jumlah'];

            $sql_penjualan_detail="INSERT INTO penjualan_detail(id_jual_detail,penjualan_id,produk_id,harga_beli,harga_jual,jumlah) VALUES(DEFAULT,$penjualan_id,$produk_id,$harga_beli,$harga_jual,$jumlah)";
            //echo $sql_penjualan_detail."<br>";
            mysqli_query($koneksi,$sql_penjualan_detail);

            // Perintah Update Stok
            $sql_update_barang="UPDATE produk SET stok=stok-$jumlah WHERE produk_id=$produk_id";
             //echo $sql_update_barang."<br>";
            mysqli_query($koneksi,$sql_update_barang);

            
        }

        // Kosongkan Keranjang
        $sql_hapus_keranjang="DELETE FROM penjualan_keranjang";
        mysqli_query($koneksi,$sql_hapus_keranjang);

        header("location:../index.php?hal=jual");

    }
}

if($_GET){
    if($_GET['aksi']=='hapus'){
        $penjualan_id=$_GET['penjualan_id'];
        // Perintah Kurangi Stok Barang
        $sql="SELECT * FROM penjualan_detail WHERE penjualan_id=$penjualan_id";
        $query=mysqli_query($koneksi,$sql);
        while($data=mysqli_fetch_array($query)){
            $produk_id=$data['produk_id'];
            $jumlah=$data['jumlah'];

            $sql_update_stok="UPDATE produk SET stok=stok+$jumlah WHERE produk_id=$produk_id";
            // echo $sql_update_stok."<br>";
            mysqli_query($koneksi,$sql_update_stok);
        }

        // Perintah Hapus Tabel jual
        $sql_hapus_jual="DELETE FROM penjualan WHERE penjualan_id=$penjualan_id";
        mysqli_query($koneksi,$sql_hapus_jual);

        // Perintah Hapus Tabel penjualan_detail
        $sql_hapus_penjualan_detail="DELETE FROM penjualan_detail WHERE penjualan_id=$penjualan_id";
        mysqli_query($koneksi,$sql_hapus_penjualan_detail);

        header("location:../index.php?hal=jual");
    }
}