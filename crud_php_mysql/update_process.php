<?php 
include 'connection.php';

if (isset($_POST["submit"])) {
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $name = htmlentities(strip_tags(trim($_POST["name"])));
    $birth_city = htmlentities(strip_tags(trim($_POST["birth_city"])));
    $faculty = htmlentities(strip_tags(trim($_POST["faculty"])));
    $department = htmlentities(strip_tags(trim($_POST["department"])));
    $gpa = htmlentities(strip_tags(trim($_POST["gpa"])));
    $birth_date = htmlentities(strip_tags(trim($_POST["birth_date"])));
    $birth_month = htmlentities(strip_tags(trim($_POST["birth_month"])));
    $birth_year = htmlentities(strip_tags(trim($_POST["birth_year"])));
    $error_message="";
    if ($error_message === "") {
        $gpa = (float) $gpa;
        $birth_date_full = $birth_year."-".$birth_month."-".$birth_date;
    }
}

$result = mysqli_query($connection,"UPDATE student SET name='$name', birth_city='$birth_city', birth_date='$birth_date_full', faculty='$faculty', department='$department', gpa='$gpa' WHERE nim='$nim'");
if($result) {
    $message = "Data mahasiswa dengan NIM = \"<b>$nim</b>\" telah berhasil di diubah ✅";
    $message = urlencode($message);
    header("Location: student_view.php?message={$message}");
}
else {
    die ("Query gagal dijalankan: ".mysqli_errno($connection). " - ".mysqli_error($connection));
}
 
?>