<?php
include "../koneksi.php";

if($_POST){
    // Perintah Tambah
    if($_POST['aksi']=='tambah'){
        $nama=$_POST['nama'];
        $alamat=$_POST['alamat'];
        $no_hp=$_POST['no_hp'];
        $email=$_POST['email'];        

        $sql="INSERT into suplier (suplier_id,nama,alamat,no_hp,email) values(DEFAULT,'$nama','$alamat','$no_hp','$email')";
        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=pemasok');
    }
    // Perintah Ubah
    if($_POST['aksi']=='ubah'){
        $suplier_id=$_POST['suplier_id'];
        $nama=$_POST['nama'];
        $alamat=$_POST['alamat'];
        $no_hp=$_POST['no_hp'];
        $email=$_POST['email']; 

        $sql="UPDATE suplier set nama='$nama',alamat='$alamat',no_hp='$no_hp',email='$email' where suplier_id=$suplier_id";

        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=pemasok');
    }

}

if($_GET){
    // Perintah Hapus Data
    if($_GET['aksi']=='hapus'){
        $id=$_GET['id'];
        $sql="DELETE from suplier where suplier_id=$id";
        mysqli_query($koneksi,$sql);

        header('location:../index.php?hal=pemasok');
    }
}
