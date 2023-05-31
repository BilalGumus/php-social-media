<?php
require_once "./db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);

    if (isset($logout)) {
        $_SESSION = array();
        session_destroy();

        header("location: ../index.php");
        exit;
    }

    if (isset($post_dislike)) {
        $query = "INSERT INTO post_review (post_review_user_id, post_review_post_id, post_review_type) VALUES (?,?,-1)";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssii", $post_title, $post_image, $user_id, $post_category_id);
            if ($stmt->execute()) {
                header("location: ../pages/sign-up.php");
            }
        }
        exit;
    }
}
