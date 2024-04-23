<?php
include 'koneksi.php';
$id=$_GET['id'];
$query=mysqli_query($koneksi, "DELETE FROM koleksi where koleksi_id='$id'");
?>
<script>alert('berhasil');
location.href = "index.php";</script>