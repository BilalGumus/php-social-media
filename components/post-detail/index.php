<?php
$user_id = null;
$post_comment_title = $post_comment_image = "";
$post_comment_title_err = $post_comment_image_err = $share_comment_error = $share_comment_success = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['share_post_comment'])) {
        if (is_uploaded_file($_FILES['post_comment_image']['tmp_name'])) {
            date_default_timezone_set('Europe/Istanbul');
            $file_extension = strtolower(pathinfo($_FILES["post_comment_image"]["name"], PATHINFO_EXTENSION));
            $uploaded_file_name = $user_id . "_" . date("Y-m-d_H-i-s") . "_" . rand() . '.' . $file_extension;
            $source_path = $_FILES["post_comment_image"]["tmp_name"];
            $target_path = '../assets/images/comments/' . $uploaded_file_name;

            if (move_uploaded_file($source_path, $target_path)) {
                if ($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg') {
                    $post_comment_image = $uploaded_file_name;
                } else {
                    $post_comment_image_err = "Lütfen geçerli bir dosya uzantısı giriniz.";
                }
            } else {
                $post_comment_image_err = "Resminizi kaydederken bir sorunla karşılaştık.";
            }
        }

        if (empty(trim($_POST["post_comment_title"]))) {
            $post_comment_title_err = "Lütfen yorum alanını doldurunuz.";
        } elseif (strlen(trim($_POST["post_comment_title"])) > 280) {
            $post_comment_title_err = "Yorumunuz en fazla 280 karakter olmalıdır.";
        } else {
            $post_comment_title = trim($_POST["post_comment_title"]);
        }

        if (empty($post_comment_title_err) && empty($post_comment_image_err)) {
            $query = "INSERT INTO post_comment (post_comment_title, post_comment_image, post_comment_user_id, post_comment_post_id) values(?,?,?,?)";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ssii", $post_comment_title, $post_comment_image, $user_id, $_POST['post_id']);
                if ($stmt->execute()) {
                    $$share_comment_success = "Postunuz başarıyla paylaşıldı.";
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_comment_like'])) {
        $isLikedQuery = "SELECT * FROM post_comment_review WHERE post_comment_review_user_id = ? AND post_comment_review_post_comment_id = ?;";
        $stmt = $link->prepare($isLikedQuery);
        $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $post_comment_review_data = $result->fetch_assoc();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO post_comment_review (post_comment_review_user_id, post_comment_review_post_comment_id, post_comment_review_type) VALUES (?,?,1)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
            $isLiked = true;
            $isDisliked = false;
        } else if ($post_comment_review_data["post_comment_review_type"] == 1) {
            $query = "DELETE FROM post_comment_review WHERE post_comment_review_user_id=? AND post_comment_review_post_comment_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
            $isLiked = false;
            $isDisliked = false;
        } else {
            $query = "UPDATE post_comment_review SET post_comment_review_type=1 WHERE post_comment_review_user_id=? AND post_comment_review_post_comment_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
            $isLiked = true;
            $isDisliked = false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_comment_dislike'])) {
        $isLikedQuery = "SELECT * FROM post_comment_review WHERE post_comment_review_user_id = ? AND post_comment_review_post_comment_id = ?;";
        $stmt = $link->prepare($isLikedQuery);
        $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $post_comment_review_data = $result->fetch_assoc();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO post_comment_review (post_comment_review_user_id, post_comment_review_post_comment_id, post_comment_review_type) VALUES (?,?,-1)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
        } else if ($post_comment_review_data["post_comment_review_type"] == -1) {
            $query = "DELETE FROM post_comment_review WHERE post_comment_review_user_id=? AND post_comment_review_post_comment_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
        } else {
            $query = "UPDATE post_comment_review SET post_comment_review_type=-1 WHERE post_comment_review_user_id=? AND post_comment_review_post_comment_id=?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ii", $user_id, $_POST['post_comment_id']);
            $stmt->execute();
        }
    }
}

$post_id = $_GET["post_id"];

$postQuery = "SELECT * FROM post INNER JOIN category ON category.category_id = post.post_category_id INNER JOIN users ON users.id = post.user_id WHERE post.post_id = ?;";
$stmt = $link->prepare($postQuery);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (empty($row) || empty($post_id)) { ?>
    <div class="pt-16 text-sm text-center">Üzgünüz aradığınız post bulunamadı.</div>
    <?php } else {
    include($_SERVER['DOCUMENT_ROOT'] . "/selcuk-sozluk/components/content/components/post-card.php");

    $postQuery = "SELECT * FROM post_comment INNER JOIN users ON users.id = post_comment.post_comment_user_id WHERE post_comment_post_id = ? ORDER BY post_comment_id ASC";
    $stmt = $link->prepare($postQuery);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $commentData = $stmt->get_result();

    if ($commentData->num_rows > 0) {
        while ($comment_row = $commentData->fetch_assoc()) { ?>
            <div class="border-t my-6"></div>
        <?php
            include("components/comment-card.php");
        }
    } else { ?>
        <div class="py-16 text-sm text-center">Burada herhangi bir yorum görünmüyor. İlk yorumu sen yap.</div>
<?php }

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $user_id = $_SESSION["id"];

        include("components/share-comment.php");
    } else {
        include("components/share-comment-preview.php");
    }
} ?>