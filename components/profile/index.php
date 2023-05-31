<?php
$user_id = null;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];
}

$user_profile_id = $_GET["user_id"];

$userQuery = "SELECT * FROM users WHERE id = ?";
$stmt = $link->prepare($userQuery);
$stmt->bind_param("i", $user_profile_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();


if (empty($userData) || empty($user_profile_id)) { ?>
    <div class="pt-16 text-sm text-center">Üzgünüz aradığınız kullanıcı bulunamadı.</div>
<?php } else {
    include("../components/profile/profile-card.php"); ?>
    <div class="border-b my-2"></div>
    <?php
    $userAllPostQuery = "SELECT * FROM post INNER JOIN category ON category.category_id = post.post_category_id INNER JOIN users ON users.id = post.user_id WHERE users.id = ? ORDER BY post.post_id DESC;";
    $stmt = $link->prepare($userAllPostQuery);
    $stmt->bind_param("i", $user_profile_id);
    $stmt->execute();
    $userAllPostData = $stmt->get_result();

    if ($userAllPostData->num_rows > 0) {
        while ($row = $userAllPostData->fetch_assoc()) {
    ?>
            <?php include("../components/content/components/post-card.php"); ?>
    <?php }
    } ?>
<?php } ?>