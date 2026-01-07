<?php
session_start();
include("db.php");

if (!isset($_SESSION['userID'])) {
    echo "You must log in first.";
    exit();
}

$userID = $_SESSION['userID'];

/* ---------- 1️⃣ CHECK USAGE ---------- */
$sql = "SELECT usage_count, max_usage 
        FROM subscription 
        WHERE userID='$userID' AND status='active' 
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$usageCount = $row['usage_count'] ?? 0;
$maxUsage   = $row['max_usage'] ?? 5;

if ($usageCount >= $maxUsage) {
    echo "You have reached your free limit. Please subscribe.";
    exit();
}

/* ---------- 2️⃣ READ REAL DATA FROM FORM ---------- */

$video_url     = mysqli_real_escape_string($conn, $_POST['video_url']);
$summary_text  = mysqli_real_escape_string($conn, $_POST['summary']);
$subject       = mysqli_real_escape_string($conn, $_POST['subject']);

/* Safety check */
if (empty($summary_text) || empty($subject) || empty($video_url)) {
    echo "Missing data — please try again.";
    exit();
}

/* ---------- 3️⃣ SAVE SUMMARY ---------- */

$sql_save = "INSERT INTO summaries (idUser, video_url, summary_text, subject, created_at)
             VALUES ('$userID', '$video_url', '$summary_text', '$subject', NOW())";

if (mysqli_query($conn, $sql_save)) {

    // update usage
    mysqli_query($conn, "
        UPDATE subscription 
        SET usage_count = usage_count + 1 
        WHERE userID='$userID'
    ");

    echo "Summary saved successfully!";
} 
else {
    echo "Failed to save summary.";
}
?>
