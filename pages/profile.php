<?php
include("../scripts/format_date.php");
require_once "../scripts/db_connect.php";
session_start();

if (!isset($_GET["user_id"])) {
    header("location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["loggedin"])) {
    header("location: sign-in.php");
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow_user']) && $_GET["user_id"] != $_SESSION["id"]) {
        $isFollowingQuery = "SELECT * FROM user_follow WHERE sender_id = ? AND receiver_id = ?;";
        $stmt = $link->prepare($isFollowingQuery);
        $stmt->bind_param("ii", $_SESSION["id"], $_GET["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $query = "INSERT INTO user_follow (sender_id, receiver_id) values(?,?);";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ii", $_SESSION["id"], $_GET["user_id"]);
                $stmt->execute();
            }
        } else {
            $query = "DELETE FROM user_follow WHERE sender_id = ? AND receiver_id = ?;";
            $stmt = $link->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ii", $_SESSION["id"], $_GET["user_id"]);
                $stmt->execute();
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
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selçuk Sözlük</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <?php include("../components/header.php");  ?>
    <div class="p-2 container mx-auto grid grid-cols-12 gap-4">
        <div class="col-span-3">
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                $user_id = $_SESSION["id"];

                $userQuery = "SELECT * FROM users WHERE id = ?";
                $stmt = $link->prepare($userQuery);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $userData = $result->fetch_assoc();
            ?>
                <?php include("../components/left-bar/components/recomended-user.php"); ?>
            <?php } else { ?>
                <?php include("../components/left-bar/components/sign-up-card.php"); ?>
            <?php } ?>
        </div>
        <div class="col-span-6">
            <?php include("../components/profile/index.php"); ?>
        </div>
        <div class="col-span-3">
            <?php include("../components/right-bar/index.php"); ?>
        </div>
    </div>
</body>

</html>