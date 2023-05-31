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
    <div class="flex flex-col gap-4">
        <?php
            include("components/user-card.php");
            include("components/recomended-user.php");
        ?>
    </div>
<?php } else { ?>
    <?php include("components/sign-up-card.php"); ?>
<?php } ?>