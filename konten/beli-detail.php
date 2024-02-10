<?php
$pembelian_id = $_GET['pembelian_id'];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Pempembelianan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item"><a href="index.php?hal=pembelian">Pempembelianan</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">


        <div class="card">
            <div class="card-header">
                <h5>Data Pempembelianan</h5>
            </div>
            <div class="card-body">
                <?php
                    $sql_pembelian="SELECT pembelian.*,suplier.nama FROM pembelian,suplier WHERE pembelian.suplier_id=suplier.suplier_id AND pembelian.pembelian_id=$pembelian_id";
                    $query_pembelian=mysqli_query($koneksi,$sql_pembelian);
                    $kolom_pembelian=mysqli_fetch_array($query_pembelian);

                ?>
                <div class="row">
                    <div class="col-md-3"># Transaksi</div>
                    <div class="col-md-3">: <?= $kolom_pembelian['pembelian_id']; ?></div>
                    <div class="col-md-3">Tanggal</div>
                    <div class="col-md-3">: <?= $kolom_pembelian['tanggal']; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">suplier</div>
                    <div class="col-md-3">: <?= $kolom_pembelian['nama']; ?></div>
                    <div class="col-md-3">Jam</div>
                    <div class="col-md-3">: <?= $kolom_pembelian['waktu']; ?></div>
                </div>

                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <th>NO</th>
                        <th>NAMA BARANG</th>
                        <th>HARGA pembelian</th>
                        <th>JUMLAH</th>
                        <th>SUBTOTAL</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $total = 0;
                        $sql = "SELECT pembelian_detail.*,produk.nama_produk FROM pembelian_detail,produk WHERE pembelian_detail.produk_id=produk.produk_id AND pembelian_detail.pembelian_id=$pembelian_id";
                        $query = mysqli_query($koneksi, $sql);
                        while ($kolom = mysqli_fetch_array($query)) {
                            $no++;
                            $total = $total + ($kolom['jumlah'] * $kolom['harga_pembelian']);

                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $kolom['nama_produk']; ?></td>
                                <td><?= number_format($kolom['harga_pembelian']); ?></td>
                                <td><?= number_format($kolom['jumlah']); ?></td>
                                <td align="right"><?= number_format($kolom['harga_pembelian'] * $kolom['jumlah']); ?></td>

                            </tr>

                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4"><b>GRANDTOTAL</b></td>
                            <td align="right"><?= number_format($total); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div><!-- /.container-fluid -->
</section>