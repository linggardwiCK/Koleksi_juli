<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">

</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <?php
                echo mysqli_num_rows(mysqli_query($koneksi, "SELECT*FROM kategori"));
                ?>
                Total Kategori
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="?page=kategori">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <?php
                echo mysqli_num_rows(mysqli_query($koneksi, "SELECT*FROM buku"));
                ?>
                Total buku
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <?php
                echo mysqli_num_rows(mysqli_query($koneksi, "SELECT*FROM ulasan"));
                ?>
                Total ulasan
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="?page=ulasan">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <?php
                    echo mysqli_num_rows(mysqli_query($koneksi, "SELECT*FROM user"));
                    ?>
                    Total user
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td width="200">Nama</td>
                <td width="1">:</td>
                <td>
                    <?php echo $_SESSION['user']['name']; ?>
                </td>
            </tr>
            <tr>
                <td width="200">level user</td>
                <td width="1">:</td>
                <td>
                    <?php echo $_SESSION['user']['level']; ?>
                </td>
            </tr>
            <tr>
                <td width="" 200>TANGGAL LOGIN</td>
                <td width="1">:</td>
                <td>
                    <?php echo date('d-m-y'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>



<div class="row">
    <h2>DAFTAR BUKU</h2>
    <div class="row">
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * from buku LEFT JOIN kategori on buku.id_kategori = kategori.id_kategori");
        while ($data = mysqli_fetch_array($query)) {


            // code yang juli harus tambah di home.php dari sini
        
            $isInCollection = false;

            // Pastikan untuk melindungi variabel dari injeksi SQL dengan menggunakan fungsi mysqli_real_escape_string
            $user_id = mysqli_real_escape_string($koneksi, $_SESSION['user']['id_user']);
            $buku_id = mysqli_real_escape_string($koneksi, $data['id_buku']);

            // Query dengan parameterized statement untuk mencegah serangan SQL Injection
            $cekKoleksi = mysqli_prepare($koneksi, "SELECT * FROM koleksi WHERE id_user = ? AND id_buku = ?");
            mysqli_stmt_bind_param($cekKoleksi, "ii", $user_id, $buku_id);
            mysqli_stmt_execute($cekKoleksi);
            $result = mysqli_stmt_get_result($cekKoleksi);

            // Periksa apakah baris ditemukan
            if (mysqli_num_rows($result) > 0) {
                $isInCollection = true;
                $koleksiData = mysqli_fetch_assoc($result);
            }

            // Selalu bersihkan hasil dan tutup statement setelah digunakan
            mysqli_free_result($result);
            mysqli_stmt_close($cekKoleksi);

            // sampai sini lalu dibawah 
        






            ?>

            <div class="col-sm-3">
                <?php $no++; ?>

                <div class="card-p-2" style="min-width: 10rem;">

                    <img src="assets/buku/<?php echo $data['foto'] ?>" class="card-img-top" alt="..." width: 100%;>

                    <div class="card-body">
                        <p class="card-title h5 fw-lighter">
                            <?php echo $data['kategori']; ?>
                        </p>
                        <h3 class="card-title h3 text-capitalize">
                            <?php echo $data['judul']; ?>
                        </h3>
                        <p class="card-title p">penulis :
                            <?php echo $data['penulis']; ?>
                        </p>
                        <p class="card-title p">Penerbit :
                            <?php echo $data['penerbit']; ?>
                        </p>
                        <p class="card-title p">Tahun Terbit :
                            <?php echo $data['tahun_terbit']; ?>
                        </p>
                        <p class="card-title p">Deskripsi :

                            <button type="button" class="btn btn-primary" data-bs-toggle="lihat"
                                data-bs-target="#lihat<?php echo $no; ?>">
                                lihat
                            </button>
                        </p>




                        <!-- code yang harus kamu copey untuk home.php selanjutnya dari sini sampai -->
                        <?php if ($isInCollection) { ?>
                            <!-- Jika buku ada dalam koleksi, tampilkan tombol untuk menghapus dari koleksi -->
                            <a onclick="return confirm('Apakah anda yakin ingin menghapus buku ini dari daftar koleksi anda?');"
                                href="hapus_koleksi.php?id=<?php echo $koleksiData['koleksi_id']; ?>" class="btn btn-warning"><i
                                    class="fa-solid fa-bookmark"></i></a>

                        <?php } else { ?>
                            <!-- Jika buku tidak ada dalam koleksi, tampilkan tombol untuk menambahkan ke koleksi -->
                            <a onclick="return confirm('Apakah anda yakin ingin menambahkan buku ini kedalam daftar koleksi anda?');"
                                href="tambah_koleksi.php?id=<?php echo $data['id_buku']; ?>&user=<?php echo $_SESSION['user']['id_user']; ?>"
                                class="btn btn-warning"><i class="fa-regular fa-bookmark"></i></a>
                        <?php } ?>
                        <!-- sampai sini saja -->





                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal<?php echo $no; ?>">
                            Pinjam
                        </button>











                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modal<?php echo $no; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 card-title h3 text-capitalize" id="exampleModalLabel">
                                Pinjam Buku Ini?
                            </h1>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-light">
                            <div class="row">
                                <div class="col-5"><img src="assets/buku/<?php echo $data['foto'] ?>" class="card-img-top"
                                        alt="..." style="width:180px;height:300px;object-fit:cover;"></div>
                                <div class="col-7">
                                    <form action="" method="POST">
                                        <h5 class="h5 fw-bold text-uppercase">
                                            <?php echo $data['judul']; ?>
                                        </h5>
                                        <input type="hidden" name="id_buku" value="<?php echo $data['id_buku']; ?>">
                                        <label class="form-label fw-bold text-uppercase pt-4">Tanggal Pinjam</label>
                                        <input class="form-control" type="date" name="tanggal_pinjam" id=""
                                            min="<?php echo date('Y-m-d'); ?>" required>
                                        <label class="form-label fw-bold text-uppercase pt-4">Tanggal Kembali</label>
                                        <input class="form-control" type="date" name="tanggal_kembali" id=""
                                            min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <i class="bi bi-1-circle"></i>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="pinjam" class="btn btn-primary">Ajukan Pinjaman</button></form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- liat -->
            <div class="modal fade" id="lihat<?php echo $no; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 card-title h3 text-capitalize" id="exampleModalLabel">
                                Pinjam Buku Ini?
                            </h1>

                            <button type="button" class="btn-close" data-bs-dismiss="lihat" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-light">
                            <div class="row">
                                <div class="col-5"><img src="assets/buku/<?php echo $data['foto'] ?>" class="card-img-top"
                                        alt="..." style="width:180px;height:300px;object-fit:cover;"></div>
                                <div class="col-7">
                                    <form action="" method="POST">
                                        <h5 class="h5 fw-bold text-uppercase">
                                            <?php echo $data['judul']; ?>
                                        </h5>

                                </div>
                                <i class="bi bi-1-circle"></i>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="pinjam" class="btn btn-primary">Ajukan Pinjaman</button></form>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>