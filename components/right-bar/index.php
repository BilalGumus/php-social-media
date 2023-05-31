<?php
include("components/trend-card.php");

$trendQuery = "SELECT COUNT(post_id), category.category_id, category.category_title FROM post INNER JOIN category ON post.post_category_id = category.category_id WHERE post_date >= NOW() - INTERVAL 1 day GROUP BY post_category_id ORDER BY COUNT(post_id) DESC LIMIT 3;";
$stmt = $link->prepare($trendQuery);
$stmt->execute();
$trendData = $stmt->get_result();

if ($trendData->num_rows == 3) {
    echo TrendCard($trendData, "Bügünün Trendleri");
    exit();
}

$trendQuery = "SELECT COUNT(post_id), category.category_id, category.category_title FROM post INNER JOIN category ON post.post_category_id = category.category_id WHERE post_date >= NOW() - INTERVAL 1 week GROUP BY post_category_id ORDER BY COUNT(post_id) DESC LIMIT 3;";
$stmt = $link->prepare($trendQuery);
$stmt->execute();
$trendData = $stmt->get_result();

if ($trendData->num_rows == 3) {
    echo TrendCard($trendData, "Haftanın Trendleri");
    exit();
}

$trendQuery = "SELECT COUNT(post_id), category.category_id, category.category_title FROM post INNER JOIN category ON post.post_category_id = category.category_id WHERE post_date >= NOW() - INTERVAL 1 month GROUP BY post_category_id ORDER BY COUNT(post_id) DESC LIMIT 3;";
$stmt = $link->prepare($trendQuery);
$stmt->execute();
$trendData = $stmt->get_result();

if ($trendData->num_rows == 3) {
    echo TrendCard($trendData, "Ayın Trendleri");
    exit();
}

$trendQuery = "SELECT COUNT(post_id), category.category_id, category.category_title FROM post INNER JOIN category ON post.post_category_id = category.category_id WHERE post_date >= NOW() - INTERVAL 1 year GROUP BY post_category_id ORDER BY COUNT(post_id) DESC LIMIT 3;";
$stmt = $link->prepare($trendQuery);
$stmt->execute();
$trendData = $stmt->get_result();

if ($trendData->num_rows == 3) {
    echo TrendCard($trendData, "Yılın Trendleri");
    exit();
}


$trendQuery = "SELECT COUNT(post_id), category.category_id, category.category_title FROM post INNER JOIN category ON post.post_category_id = category.category_id GROUP BY post_category_id ORDER BY COUNT(post_id) DESC LIMIT 3;";
$stmt = $link->prepare($trendQuery);
$stmt->execute();
$trendData = $stmt->get_result();

echo TrendCard($trendData, "Trendler Kategoriler");
?>