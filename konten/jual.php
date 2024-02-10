<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penjualan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item active">Penjualan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <!-- Tombol Tambah -->
        <a href="index.php?hal=jual-tambah"><button type="button" class="btn btn-primary mb-2">
                Tambah
            </button></a>

        <div class="card">
            <div class="card-header">
                <h5>Data Penjualan</h5>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm">
                    <thead>
                        <th>ID</th>
                        <th>TANGGAL</th>
                        <th>WAKTU</th>
                        <th>NAMA PELANGGAN</th>
                        <th>TOTAL ITEM</th>
                        <th>TOTAL BELANJA</th>
                        <th>AKSI</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT penjualan.*,pelanggan.nama,(SELECT SUM(jumlah) FROM penjualan_detail WHERE penjualan_id=penjualan.penjualan_id) AS total_item,(SELECT SUM(jumlah*harga_jual) FROM penjualan_detail WHERE penjualan_id=penjualan.penjualan_id) AS total_belanja FROM penjualan,pelanggan WHERE penjualan.id_pelanggan=pelanggan.id_pelanggan";
                        $query = mysqli_query($koneksi, $sql);
                        while ($kolom = mysqli_fetch_array($query)) {


                        ?>
                            <tr>
                                <td><?= $kolom['penjualan_id']; ?></td>
                                <td><?= $kolom['tanggal']; ?></td>
                                <td><?= $kolom['waktu']; ?></td>
                                <td><?= $kolom['nama']; ?></td>
                                <td><?= number_format($kolom['total_item']); ?></td>
                                <td><?= number_format($kolom['total_belanja']); ?></td>
                                <td align="center">
                                    <a href="index.php?hal=jual-detail&penjualan_id=<?= $kolom['penjualan_id']; ?>"><i class="fas fa-search"></i></a> | 
                                    <a href="aksi/jual.php?aksi=hapus&penjualan_id=<?= $kolom['penjualan_id']; ?>" onclick="return confirm('Apakah Anda Yakin Akan Dihapus??')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>