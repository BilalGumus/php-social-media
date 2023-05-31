<?php
$user_id = null;
$category_id = $_GET["category_id"] ?? 0;
$post_title = $post_image = $post_category_id = "";
$post_title_err = $post_image_err = $post_category_id_err = $share_post_error = $share_success = "";

include("components/category-list.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['share_post'])) {
        if (is_uploaded_file($_FILES['post_image']['tmp_name'])) {
            date_default_timezone_set('Europe/Istanbul');
            $file_extension = strtolower(pathinfo($_FILES["post_image"]["name"], PATHINFO_EXTENSION));
            $uploaded_file_name = $user_id . "_" . date("Y-m-d_H-i-s") . "_" . rand() . '.' . $file_extension;
            $source_path = $_FILES["post_image"]["tmp_name"];
            $target_path = '../assets/images/post/' . $uploaded_file_name;

            if (move_uploaded_file($source_path, $target_path)) {
                if ($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg') {
                    $post_image = $uploaded_file_name;
                } else {
                    $post_image_err = "Lütfen geçerli bir dosya uzantısı giriniz.";
                }
            } else {
                $post_image_err = "Resminizi kaydederken bir sorunla karşılaştık.";
            }
        }

        if (empty(trim($_POST["post_title"]))) {
            $post_title_err = "Lütfen post başlığını doldurunuz.";
        } elseif (strlen(trim($_POST["post_title"])) > 280) {
            $post_title_err = "Post mesajınız en fazla 280 karakter olmalıdır.";
        } else {
            $post_title = trim($_POST["post_title"]);
        }

        if (empty(trim($_POST["post_category_id"]))) {
            $post_category_id_err = "Lütfen geçerli bir kategori seçiniz.";
        } else {
            $post_category_id = trim($_POST["post_category_id"]);
        }

        if (empty($post_title_err) && empty($post_image_err) && empty($post_category_id_err)) {
            $query = "INSERT INTO post (post_title, post_image, user_id, post_category_id) values(?,?,?,?)";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ssii", $post_title, $post_image, $user_id, $post_category_id);
                if ($stmt->execute()) {
                    $share_success = "Postunuz başarıyla paylaşıldı.";
                } else {
                    $share_post_error = "Üzgünüz şu anda postunuz paylaşılamadı.";
                }
            } else {
                $share_post_error = "Üzgünüz şu anda postunuz paylaşılamadı.";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_like'])) {
        $isLikedQuery = "SELECT * FROM post_review WHERE post_review_user_id = ? AND post_review_post_id = ?;";
        $stmt = $link->prepare($isLikedQuery);
        $stmt->bind_param("ii", $user_id, $_POST['post_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $post_review_data = $result->fetch_assoc();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO post_review (post_review_user_id, post_review_post_id, post_review_type) VALUES (?,?,1)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
            $isLiked = true;
            $isDisliked = false;
        } else if ($post_review_data["post_review_type"] == 1) {
            $query = "DELETE FROM post_review WHERE post_review_user_id=? AND post_review_post_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
            $isLiked = false;
            $isDisliked = false;
        } else {
            $query = "UPDATE post_review SET post_review_type=1 WHERE post_review_user_id=? AND post_review_post_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
            $isLiked = true;
            $isDisliked = false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_dislike'])) {
        $isLikedQuery = "SELECT * FROM post_review WHERE post_review_user_id = ? AND post_review_post_id = ?;";
        $stmt = $link->prepare($isLikedQuery);
        $stmt->bind_param("ii", $user_id, $_POST['post_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $post_review_data = $result->fetch_assoc();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO post_review (post_review_user_id, post_review_post_id, post_review_type) VALUES (?,?,-1)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
        } else if ($post_review_data["post_review_type"] == -1) {
            $query = "DELETE FROM post_review WHERE post_review_user_id=? AND post_review_post_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
        } else {
            $query = "UPDATE post_review SET post_review_type=-1 WHERE post_review_user_id=? AND post_review_post_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_id']);
            $stmt->execute();
        }
    }

    include("components/share-post.php");
} else {
    include("components/share-post-preview.php");
}

if ($category_id == 0) {
    $postQuery = "SELECT * FROM post INNER JOIN category ON category.category_id = post.post_category_id INNER JOIN users ON users.id = post.user_id ORDER BY post_id DESC;";
    $stmt = $link->prepare($postQuery);
    $stmt->execute();
    $filteredPostData = $stmt->get_result();
} else {
    $filteredPostQuery = "SELECT * FROM post INNER JOIN category ON category.category_id = post.post_category_id INNER JOIN users ON users.id = post.user_id WHERE post.post_category_id = ? ORDER BY post.post_id DESC;";
    $stmt = $link->prepare($filteredPostQuery);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $filteredPostData = $stmt->get_result();
}

if ($filteredPostData->num_rows > 0) {
    while ($row = $filteredPostData->fetch_assoc()) {
        include("components/post-card.php");
    }
} else { ?>
    <div class="pt-16 text-sm text-center">Hmm. Burası şimdilik boş görünüyor.</div>
<?php }
?>