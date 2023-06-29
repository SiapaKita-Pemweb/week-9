<?php
include 'connection.php';

$nim = $_GET['nim'];

$query="DELETE from student where nim='$nim'";
$result = mysqli_query($connection, $query);

if($result) {
    $message = "Data mahasiswa dengan NIM = \"<b>$nim</b>\" telah berhasil di dihapus ✅";
    $message = urlencode($message);
    header("Location: student_view.php?message={$message}");
}
else {
    die ("Query gagal dijalankan: ".mysqli_errno($connection). " - ".mysqli_error($connection));
}

?>