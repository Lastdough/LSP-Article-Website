<?php
function isAdminLoggedIn()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function generateArticleId($pdo, $adminId)
{
    $datePart = date('Ymd');
    // Query to get the count of articles for today by this admin
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM article_table WHERE admin_id = ? AND DATE(created_at) = CURDATE()");
    $stmt->execute([$adminId]);
    $todayCount = $stmt->fetchColumn() + 1; // Add 1 to get the next sequence number

    $articleId = $datePart . $adminId . str_pad($todayCount, 4, '0', STR_PAD_LEFT);
    return $articleId;
}