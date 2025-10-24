<?php
$title = "Form Registrasi Mahasiswa";

$arr_month = [
    "1" => "Januari",
    "2" => "Februari",
    "3" => "Maret",
    "4" => "April",
    "5" => "Mei",
    "6" => "Juni",
    "7" => "Juli",
    "8" => "Agustus",
    "9" => "September",
    "10" => "Oktober",
    "11" => "November",
    "12" => "Desember",
];

$error_message = "";

if (isset($_POST["submit"])) {
    $student_name = htmlentities(strip_tags(trim($_POST["student_name"])));
    $student_number = htmlentities(strip_tags(trim($_POST["student_number"])));
    $student_address = htmlentities(strip_tags(trim($_POST["student_address"])));
    $student_birth_date = htmlentities(strip_tags(trim($_POST["student_birth_date"])));
    $student_birth_month = htmlentities(strip_tags(trim($_POST["student_birth_month"])));
    $student_birth_year = htmlentities(strip_tags(trim($_POST["student_birth_year"])));
    $student_gender = htmlentities(strip_tags(trim($_POST["student_gender"])));
    $student_website = htmlentities(strip_tags(trim($_POST["student_website"])));
    $student_email = htmlentities(strip_tags(trim($_POST["student_email"])));
    $student_username = htmlentities(strip_tags(trim($_POST["student_username"])));
    $student_password = htmlentities(strip_tags(trim($_POST["student_password"])));
    $student_password_confirmation = htmlentities(strip_tags(trim($_POST["student_password_confirmation"])));

    // Validasi
    if (empty($student_name)) $error_message .= "- Nama Mahasiswa belum diisi <br>";
    if (empty($student_number)) $error_message .= "- NIM belum diisi <br>";
    if (empty($student_address)) $error_message .= "- Alamat belum diisi <br>";
    if (empty($student_website)) $error_message .= "- Website belum diisi <br>";

    // Upload foto
    $upload_error = $_FILES["student_photo"]["error"];
    if ($upload_error !== 0) {
        $arr_upload_error = [
            1 => '- Ukuran file foto melewati batas maksimal <br>',
            2 => '- Ukuran file foto melewati batas maksimal 1MB <br>',
            3 => '- File foto hanya ter-upload sebagian <br>',
            4 => '- Foto tidak ditemukan <br>',
            6 => '- Server Error (Upload Foto) <br>',
            7 => '- Server Error (Upload Foto) <br>',
            8 => '- Server Error (Upload Foto) <br>',
        ];
        $error_message .= $arr_upload_error[$upload_error];
    } else {
        $folder_name = "folder_upload";
        $file_name = $_FILES["student_photo"]["name"];
        $file_path = "$folder_name/$file_name";

        if (file_exists($file_path)) {
            $error_message .= "- File dengan nama sama sudah ada di server <br>";
        }

        $file_size = $_FILES["student_photo"]["size"];
        if ($file_size > 1048576) {
            $error_message .= "- Ukuran file melebihi 1MB <br>";
        }

        $check = getimagesize($_FILES["student_photo"]["tmp_name"]);
        if ($check === false) {
            $error_message .= "- Mohon upload file gambar (gif, png, atau jpg) <br>";
        }
    }

    if (empty($student_email)) $error_message .= "- Email belum diisi <br>";
    if (empty($student_username)) $error_message .= "- Username belum diisi <br>";
    if (empty($student_password)) $error_message .= "- Password belum diisi <br>";
    if (empty($student_password_confirmation)) $error_message .= "- Konfirmasi Password belum diisi <br>";

    if ($error_message === "") {
        $folder_name = "folder_upload";
        $tmp = $_FILES["student_photo"]["tmp_name"];
        $file_name = $_FILES["student_photo"]["name"];
        move_uploaded_file($tmp, "$folder_name/$file_name");
        include("registration_process.php");
        die();
    }
} else {
    $student_name = "";
    $student_number = "";
    $student_address = "";
    $student_birth_date = 1;
    $student_birth_month = "1";
    $student_birth_year = "1990";
    $checked_man = "checked";
    $checked_woman = "";
    $student_website = "";
    $student_email = "";
    $student_username = "";
    $student_password = "";
    $student_password_confirmation = "";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="registration_style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">FM</div>
        <div>
            <h1><?= $title ?></h1>
            <div class="small">Form pendaftaran mahasiswa baru — isi data dengan lengkap</div>
        </div>
    </div>
    <?php if ($error_message !== "") echo "<div style='padding:16px'><div class='error'>$error_message</div></div>"; ?>
    <div class="content">
        <form action="registration.php" method="post" enctype="multipart/form-data" novalidate>
            <fieldset>
                <legend>Biodata</legend>
                <div class="group">
                    <div class="field">
                        <label for="student_name">Nama Mahasiswa*</label>
                        <input id="student_name" type="text" name="student_name" value="<?= $student_name ?>">
                    </div>
                    <div class="field">
                        <label for="student_number">NIM*</label>
                        <input id="student_number" type="text" name="student_number" value="<?= $student_number ?>">
                    </div>
                </div>

                <div class="field">
                    <label for="student_address">Alamat*</label>
                    <textarea id="student_address" name="student_address"><?= $student_address ?></textarea>
                </div>

                <div class="field">
                    <label>Tanggal Lahir*</label>
                    <div class="date-row">
                        <select name="student_birth_date">
                            <?php for ($i = 1; $i <= 31; $i++) { $sel = ($i == $student_birth_date) ? "selected" : ""; echo "<option $sel>$i</option>"; } ?>
                        </select>
                        <select name="student_birth_month">
                            <?php foreach ($arr_month as $key => $value) { $sel = ($key == $student_birth_month) ? "selected" : ""; echo "<option value='$key' $sel>$value</option>"; } ?>
                        </select>
                        <select name="student_birth_year">
                            <?php for ($i = 1990; $i <= 2010; $i++) { $sel = ($i == $student_birth_year) ? "selected" : ""; echo "<option $sel>$i</option>"; } ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Jenis Kelamin*</label>
                    <div class="gender-row">
                        <label><input type="radio" name="student_gender" value="man" checked> Pria</label>
                        <label><input type="radio" name="student_gender" value="woman"> Wanita</label>
                    </div>
                </div>

                <div class="field">
                    <label for="student_photo">Upload Foto* (maks 1MB)</label>
                    <input id="student_photo" type="file" name="student_photo" accept="image/*">
                </div>

                <div class="field">
                    <label for="student_website">Website*</label>
                    <input id="student_website" type="url" name="student_website" value="<?= $student_website ?>">
                </div>
            </fieldset>

            <fieldset>
                <legend>Info Akun</legend>
                <div class="field">
                    <label for="student_email">Email*</label>
                    <input id="student_email" type="email" name="student_email" value="<?= $student_email ?>">
                </div>

                <div class="group">
                    <div class="field">
                        <label for="student_username">Username*</label>
                        <input id="student_username" type="text" name="student_username" value="<?= $student_username ?>">
                    </div>
                    <div class="field">
                        <label for="student_password">Password*</label>
                        <input id="student_password" type="password" name="student_password">
                    </div>
                </div>

                <div class="field">
                    <label for="student_password_confirmation">Konfirmasi Password*</label>
                    <input id="student_password_confirmation" type="password" name="student_password_confirmation">
                    <div id="password_feedback" class="password-match small"></div>
                </div>
            </fieldset>

            <div class="actions">
                <button type="reset" class="btn btn-ghost">Reset</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <aside class="side">
            <div class="photo-preview">
                <img id="preview_img" src="" alt="Preview Foto" style="display:none">
                <div class="hint">Preview foto akan muncul di sini setelah memilih file.</div>
                <div class="note">Pastikan ukuran & format sesuai (jpg, png, gif). Maks 1MB.</div>
            </div>
        </aside>
    </div>

    <script>
    // Image preview
    const inputPhoto = document.getElementById('student_photo');
    const previewImg = document.getElementById('preview_img');
    inputPhoto.addEventListener('change', function(e){
        const file = this.files && this.files[0];
        if (!file) { previewImg.style.display='none'; previewImg.src=''; return; }
        if (!file.type.startsWith('image/')) { alert('Mohon pilih file gambar.'); this.value=''; return; }
        const reader = new FileReader();
        reader.onload = function(ev){ previewImg.src = ev.target.result; previewImg.style.display='block'; }
        reader.readAsDataURL(file);
    });

    // Password match
    const pw = document.getElementById('student_password');
    const pwc = document.getElementById('student_password_confirmation');
    const feedback = document.getElementById('password_feedback');
    function checkPassword(){
        if (!pw.value && !pwc.value) { feedback.textContent=''; return; }
        if (pw.value === pwc.value) { feedback.textContent='Password cocok'; feedback.className='password-match match-yes small'; }
        else { feedback.textContent='Password tidak cocok'; feedback.className='password-match match-no small'; }
    }
    pw.addEventListener('input', checkPassword);
    pwc.addEventListener('input', checkPassword);
    </script>

</div>
</body>
</html>
