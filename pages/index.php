<?php
include("../scripts/format_date.php");
require_once "../scripts/db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["loggedin"])) {
    header("location: sign-in.php");
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
            <?php include("../components/left-bar/index.php"); ?>
        </div>
        <div class="col-span-6">
            <?php include("../components/content/index.php"); ?>
        </div>
        <div class="col-span-3">
            <?php include("../components/right-bar/index.php"); ?>
        </div>
    </div>
</body>

</html>