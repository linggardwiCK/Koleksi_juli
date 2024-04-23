<div class="container mt-5">
    <div class="container">
        <div class="row">
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <h1 class="mt-4 text-center">Koleksi Buku</h1>
                </div>

                <div class="mt-3">
                    <div class="container">
                        <div class="row ">
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * from koleksi LEFT JOIN buku on koleksi.id_buku = buku.id_buku LEFT JOIN user on koleksi.id_user = user.id_user LEFT JOIN kategori on buku.id_kategori = kategori.id_kategori WHERE koleksi.id_user=" . $_SESSION['user']['id_user']);
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <div class="col-sm-3">
                                    <div class="container card-p-2" style="min-width: 18rem;">
                                        <p class="card-title h5  text-capitalize scroll-text row justify-content-center" style="">
                                            <?php echo $data['kategori']; ?>
                                        </p>
                                        <img src="assets/buku/<?php echo $data['foto'] ?>" class="card-img-top" style="width: 100%; object-fit: cover; aspect-ratio: 3 / 4; border: 1px solid #666666; " alt="..." width: 100%;>
                                        <div class="card-body">
                                            <h3 class="card-title h3 text-capitalize scroll-text">
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
                                            <a class="btn btn-warning" href="hapus_koleksi.php?id=<?php echo $data['koleksi_id']; ?>&&user=<?php echo $_SESSION['user']['id_user']; ?>"><i class="fa-solid fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>