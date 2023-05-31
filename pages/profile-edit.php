<?php
include("../scripts/format_date.php");
require_once "../scripts/db_connect.php";
session_start();

$user_id = null;
$will_banner_picture_change  = false;
$new_password = $confirm_new_password = "";
$username_err = $first_name_err = $last_name_err = $email_err = $new_password_err = $confirm_new_password_err = $update_profile_success = $update_profile_err = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];

    $userQuery = "SELECT * FROM users WHERE id = ?";
    $stmt = $link->prepare($userQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $temp_user_data = $result->fetch_assoc();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (is_uploaded_file($_FILES['banner_picture']['tmp_name'])) {
            date_default_timezone_set('Europe/Istanbul');
            $file_extension = strtolower(pathinfo($_FILES["banner_picture"]["name"], PATHINFO_EXTENSION));
            $uploaded_file_name = $user_id . "_" . date("Y-m-d_H-i-s") . "_" . rand() . '.' . $file_extension;
            $source_path = $_FILES["banner_picture"]["tmp_name"];
            $target_path = '../assets/images/user/banner/' . $uploaded_file_name;

            if (move_uploaded_file($source_path, $target_path)) {
                if ($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg') {
                    $banner_picture = $uploaded_file_name;
                } else {
                    $banner_picture_err = "Lütfen geçerli bir dosya uzantısı giriniz.";
                }
            } else {
                $banner_picture_err = "Resminizi kaydederken bir sorunla karşılaştık.";
            }
        } else {
            $banner_picture = $temp_user_data["banner_picture"];
        }

        if (is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
            date_default_timezone_set('Europe/Istanbul');
            $file_extension = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
            $uploaded_file_name = $user_id . "_" . date("Y-m-d_H-i-s") . "_" . rand() . '.' . $file_extension;
            $source_path = $_FILES["profile_picture"]["tmp_name"];
            $target_path = '../assets/images/user/profile/' . $uploaded_file_name;

            if (move_uploaded_file($source_path, $target_path)) {
                if ($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg') {
                    $profile_picture = $uploaded_file_name;
                } else {
                    $profile_picture_err = "Lütfen geçerli bir dosya uzantısı giriniz.";
                }
            } else {
                $profile_picture_err = "Resminizi kaydederken bir sorunla karşılaştık.";
            }
        } else {
            $profile_picture = $temp_user_data["profile_picture"];
        }

        if (empty(trim($_POST["username"]))) {
            $username_err = "Lütfen kullanıcı adınızı giriniz.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
            $username_err = "Kullanıcı adı sadece harf, rakam ve _ içerebilir.";
        } else {
            $param_username = trim($_POST["username"]);
            $query = "SELECT id FROM users WHERE username = ? AND id != ?;";
            $stmt = $link->prepare($query);
            $stmt->bind_param("si", $param_username, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $temp = $result->fetch_assoc();

            if ($result->num_rows >= 1) {
                $username_err = "Bu kullanıcı adı zaten alınmış.";
            } else {
                $username = trim($_POST["username"]);
            }
        }

        if (empty(trim($_POST["first_name"]))) {
            $first_name_err = "Lütfen adınızı giriniz.";
        } else {
            $first_name = trim($_POST["first_name"]);
        }

        if (empty(trim($_POST["last_name"]))) {
            $last_name_err = "Lütfen soy adınızı giriniz.";
        } else {
            $last_name = trim($_POST["last_name"]);
        }

        if (empty(trim($_POST["email"]))) {
            $email_err = "Lütfen e-posta adresinizi giriniz.";
        } elseif (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', trim($_POST["email"]))) {
            $email_err = "Lütfen geçerli bir e-posta adresi giriniz.";
        } else {
            $param_email = trim($_POST["email"]);
            $query = "SELECT id FROM users WHERE email = ? AND id != ?;";
            $stmt = $link->prepare($query);
            $stmt->bind_param("si", $param_email, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $temp = $result->fetch_assoc();

            if ($result->num_rows >= 1) {
                $email_err = "Bu e-posta adresi adı zaten alınmış.";
            } else {
                $email = trim($_POST["email"]);
            }
        }

        if (!empty(trim($_POST["new_password"])) || !empty(trim($_POST["confirm_new_password"]))) {
            $will_new_password_change = true;

            if (empty(trim($_POST["new_password"]))) {
                $new_password_err = "Lütfen şifrenizi giriniz.";
            } elseif (strlen(trim($_POST["new_password"])) < 6) {
                $new_password_err = "Şifreniz en az 6 karakter olmalıdır.";
            } else {
                $new_password = trim($_POST["new_password"]);
            }

            if (empty(trim($_POST["confirm_new_password"]))) {
                $confirm_new_password_err = "Lütfen şifrenizi doğrulayınız.";
            } else {
                $confirm_new_password = trim($_POST["confirm_new_password"]);
                if (empty($password_err) && ($new_password != $confirm_new_password)) {
                    $confirm_new_password_err = "Şifreler birbiriyle uyuşmuyor.";
                }
            }
        } else {
            $will_new_password_change = false;
        }

        if (empty($new_password_err) && empty($profile_picture_err) && empty($banner_picture_err) && empty($confirm_new_password_err) && empty($username_err) && empty($first_name_err) && empty($last_name_err) && empty($email_err)) {
            if ($will_new_password_change) {
                $query = "UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, password = ?, profile_picture = ?, banner_picture = ? WHERE id=?";
                $stmt = $link->prepare($query);
                if ($stmt) {
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt->bind_param("sssssssi", $username, $first_name, $last_name, $email, $param_password, $profile_picture, $banner_picture, $user_id);
                    if ($stmt->execute()) {
                        $update_profile_success = "Profiliniz başarıyla güncellendi.";
                    } else {
                        $update_profile_error = "Üzgünüz şu anda postunuz paylaşılamadı.";
                    }
                } else {
                    $update_profile_error = "Üzgünüz şu anda postunuz paylaşılamadı.";
                }
            } else {
                $query = "UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, profile_picture = ?, banner_picture = ? WHERE id=?";
                $stmt = $link->prepare($query);
                if ($stmt) {
                    $stmt->bind_param("ssssssi", $username, $first_name, $last_name, $email, $profile_picture, $banner_picture, $user_id);
                    if ($stmt->execute()) {
                        $update_profile_success = "Profiliniz başarıyla güncellendi.";
                    } else {
                        $update_profile_error = "Üzgünüz profiliniz şu anda güncellenemiyor. Lütfen daha sonra tekrar deneyin.";
                    }
                } else {
                    $update_profile_error = "Üzgünüz profiliniz şu anda güncellenemiyor. Lütfen daha sonra tekrar deneyin.";
                }
            }
        }
    }
} else {
    header("location: sign-up.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilini Düzenle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
</head>

<body>
    <?php include("../components/header.php");  ?>
    <?php include("../components/profile/profile-edit-card.php"); ?>
</body>

</html>