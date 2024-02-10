<?php
include "../koneksi.php";

if($_POST){
    if($_POST['aksi']=='tambah'){
        $suplier_id=$_POST['suplier_id'];
        $tanggal=$_POST['tanggal'];
        $waktu=$_POST['waktu'];

        // Simpan Ke Tabel pembelian
        $sql_pembelian="INSERT INTO pembelian(pembelian_id,suplier_id,tanggal,waktu) VALUES(DEFAULT,$suplier_id,'$tanggal','$waktu')";
        // echo $sql_pembelian;
        mysqli_query($koneksi,$sql_pembelian);

        // Simpan Ke pembelian Detail
        $sql_cari_pembelian_id="SELECT pembelian_id FROM pembelian WHERE tanggal='$tanggal' AND waktu='$waktu' ORDER BY pembelian_id DESC";
        // echo $sql_cari_pembelian_id;
        $query_cari_pembelian_id=mysqli_query($koneksi,$sql_cari_pembelian_id);
        $data_pembelian_id=mysqli_fetch_array($query_cari_pembelian_id);
        $pembelian_id=$data_pembelian_id['pembelian_id'];

        // echo $pembelian_id;
        $sql_keranjang="SELECT * FROM pembelian_keranjang";
        $query_keranjang=mysqli_query($koneksi,$sql_keranjang);
        while($data_keranjang=mysqli_fetch_array($query_keranjang)){
            $produk_id=$data_keranjang['produk_id'];
            $harga_beli=$data_keranjang['harga_beli'];
            $jumlah=$data_keranjang['jumlah'];

            $sql_pembelian_detail="INSERT INTO pembelian_detail(beli_id_detail,pembelian_id,produk_id,harga_beli,jumlah) VALUES(DEFAULT,$pembelian_id,$produk_id,$harga_beli,$jumlah)";
            //echo $sql_pembelian_detail."<br>";
            mysqli_query($koneksi,$sql_pembelian_detail);

            // Perintah Update Stok dan Harga pembelian
            $sql_update_barang="UPDATE produk SET stok=stok+$jumlah, harga_beli=$harga_beli WHERE id_produk=$produk_id";
            // echo $sql_update_barang;
            mysqli_query($koneksi,$sql_update_barang);

            
        }

        // Kosongkan Keranjang
        $sql_hapus_keranjang="DELETE FROM pembelian_keranjang";
        mysqli_query($koneksi,$sql_hapus_keranjang);

        header("location:../index.php?hal=beli");

    }
}

if($_GET){
    if($_GET['aksi']=='hapus'){
        $pembelian_id=$_GET['pembelian_id'];
        // Perintah Kurangi Stok Barang
        $sql="SELECT * FROM pembelian_detail WHERE pembelian_id=$pembelian_id";
        $query=mysqli_query($koneksi,$sql);
        while($data=mysqli_fetch_array($query)){
            $produk_id=$data['produk_id'];
            $jumlah=$data['jumlah'];

            $sql_update_stok="UPDATE produk SET stok=stok-$jumlah WHERE produk_id=$produk_id";
            // echo $sql_update_stok."<br>";
            mysqli_query($koneksi,$sql_update_stok);
        }

        // Perintah Hapus Tabel pembelian
        $sql_hapus_pembelian="DELETE FROM pembelian WHERE pembelian_id=$pembelian_id";
        mysqli_query($koneksi,$sql_hapus_pembelian);

        // Perintah Hapus Tabel pembelian_detail
        $sql_hapus_pembelian_detail="DELETE FROM pembelian_detail WHERE pembelian_id=$pembelian_id";
        mysqli_query($koneksi,$sql_hapus_pembelian_detail);

        header("location:../index.php?hal=beli");
    }
}