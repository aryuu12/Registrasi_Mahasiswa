<?php
if (!isset($_POST["submit"])) {
    header("Location: registration.php");
    die();
} else {
    $title = "Data Registrasi Mahasiswa";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= $title ?></title>
<style>
body { font-family: Arial, sans-serif; background-color: #f0f0f0; }
.container { width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
fieldset { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; }
legend { font-weight: bold; }
img { max-width: 150px; border-radius: 5px; }
a { text-decoration: none; color: #007bff; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
<h2><?= $title ?></h2>

<fieldset>
<legend>Biodata</legend>
<p><b>Nama:</b> <?= $student_name ?></p>
<p><b>NIM:</b> <?= $student_number ?></p>
<p><b>Alamat:</b> <?= $student_address ?></p>
<p><b>Tanggal Lahir:</b> <?= "$student_birth_date-$student_birth_month-$student_birth_year" ?></p>
<p><b>Jenis Kelamin:</b> <?= ($student_gender == "man") ? "Pria" : "Wanita" ?></p>
<p><b>Foto:</b><br><img src="folder_upload/<?= $_FILES["student_photo"]["name"] ?>"></p>
<p><b>Website:</b> <a href="<?= $student_website ?>" target="_blank"><?= $student_website ?></a></p>
</fieldset>

<fieldset>
<legend>Info Akun</legend>
<p><b>Email:</b> <?= $student_email ?></p>
<p><b>Username:</b> <?= $student_username ?></p>
</fieldset>

<a href="registration.php">← Kembali ke Form Registrasi</a>
</div>
</body>
</html>
