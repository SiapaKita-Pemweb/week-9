<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
    include("connection.php");

    if (isset($_POST["submit"])) {
        $error_message="";
        if (!preg_match("/^[0-9]{8}$/",$nim) ) {
            $error_message .= "- NIM harus berupa 8 digit angka <br>";
        }
        if (empty($name)) {
            $error_message .= "- Nama belum diisi <br>";
        }
        if (empty($birth_city)) {
            $error_message .= "- Tempat lahir belum diisi <br>";
        }
        if (empty($department)) {
            $error_message .= "- Jurusan belum diisi <br>";
        }
        $select_ftib=""; $select_fteic="";
        switch ($faculty) {
            case 'FTIB':
                $select_ftib = "selected";
            break;
            case 'FTEIC':
                $select_fteic = "selected";
            break;
        }
        if (!is_numeric($gpa) OR ($gpa <=0)) {
            $error_message .= "- IPK harus diisi dengan angka";
        }
    }
    else {
        $error_message = "";
        $nim = "";
        $name = "";
        $birth_city = "";
        $select_ftib = "selected";
        $select_fteic = "";
        $department = "";
        $gpa = "";
        $birth_date=1;
        $birth_month="1";
        $birth_year=1996;
    }
    $arr_month = [
        "1"=>"Januari",
        "2"=>"Februari",
        "3"=>"Maret",
        "4"=>"April",
        "5"=>"Mei",
        "6"=>"Juni",
        "7"=>"Juli",
        "8"=>"Agustus",
        "9"=>"September",
        "10"=>"Oktober",
        "11"=>"Nopember",
        "12"=>"Desember"
    ];
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Data Mahasiswa</title>
        <link href="assets/style.css" rel="stylesheet" >
    </head>
    <body>
        <div class="container">
            <div id="header">
                <h1 id="logo">Data Mahasiswa</h1>
            </div>
            <hr>
            <nav>
                <ul>
                    <li><a href="student_view.php">Tampil</a></li>
                    <li><a href="student_add.php">Tambah</a>
                    <li><a href="logout.php">Logout</a>
                </ul>
            </nav>
            <h2>Edit Data Mahasiswa</h2>
            <?php
                if ($error_message !== "") {
                    echo "<div class='error'>$error_message</div>";
                }
                include 'connection.php';
                $nim = $_GET['nim'];
                $data = mysqli_query($connection,"select * from student where nim='$nim'");
                while($d = mysqli_fetch_array($data)){
            ?>
                <form id="form_mahasiswa" action="update_process.php" method="post">
                    <fieldset>
                        <legend>Data Mahasiswa</legend>
                        <p>
                            <label for="nim">NIM : </label>
                            <input type="text" name="nim" id="nim" value="<?php echo $nim ?>" placeholder="Contoh: 12345678"> (8 digit angka)
                        </p>
                        <p>
                            <label for="name">Nama : </label>
                            <input type="text" name="name" id="name" value="<?php echo $name ?>">
                        </p>
                        <p>
                            <label for="birth_city">Tempat Lahir : </label>
                            <input type="text" name="birth_city" id="birth_city" value="<?php echo $birth_city ?>">
                        </p>
                        <p>
                            <label for="birth_date" >Tanggal Lahir : </label>
                            <select name="birth_date" id="birth_date">
                                <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        if ($i == $birth_date){
                                            echo "<option value=$i selected>";
                                        }
                                        else {
                                            echo "<option value=$i>";
                                        }
                                        echo str_pad($i, 2, "0", STR_PAD_LEFT);
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                            <select name="birth_month">
                                <?php
                                    foreach ($arr_month as $key => $value) {
                                        if ($key == $birth_month){
                                            echo "<option value=\"{$key}\" selected>{$value}</option>";
                                        }
                                        else {
                                            echo "<option value=\"{$key}\">{$value}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <select name="birth_year">
                                <?php
                                    for ($i = 1990; $i <= 2005; $i++) {
                                        if ($i == $birth_year){
                                            echo "<option value=$i selected>";
                                        }
                                        else {
                                            echo "<option value=$i>";
                                        }
                                        echo "$i </option>";
                                    }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label for="faculty" >Fakultas : </label>
                            <select name="faculty" id="faculty">
                                <option value="FTIB" <?php echo $select_ftib ?>>FTIB</option>
                                <option value="FTEIC" <?php echo $select_fteic ?>>FTEIC</option>
                            </select>
                        </p>
                        <p>
                            <label for="department">Jurusan : </label>
                            <input type="text" name="department" id="department" value="<?php echo $department ?>">
                        </p>
                        <p>
                            <label for="gpa">IPK : </label>
                            <input type="text" name="gpa" id="gpa" value="<?php echo $gpa ?>" placeholder="Contoh: 2.75"> (angka desimal dipisah dengan karakter titik ".")
                        </p>
                    </fieldset>
                    <br>
                    <p>
                        <input type="submit" name="submit" value="Ubah Data">
                    </p>
                </form>
            <?php 
	            }
	        ?>

        </div>
    </body>
</html>
<?php
    mysqli_close($connection);
?>