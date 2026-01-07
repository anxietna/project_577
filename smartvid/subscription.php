<?php
session_start();
include("db.php");

/* MATCH LOGIN SESSION */
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

/* FETCH USER + SUBSCRIPTION */
$sql = "
    SELECT 
        u.username,
        s.subscription_type,
        s.usage_count,
        s.max_usage
    FROM user u
    LEFT JOIN subscription s ON s.userID = u.idUser
    WHERE u.idUser = '$userID'
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$username   = $row['username'] ?? '';
$currentPlan = $row['subscription_type'] ?? 'free';
$usageCount = $row['usage_count'] ?? 0;
$maxUsage   = $row['max_usage'] ?? 5;

/* AUTO CREATE FREE SUBSCRIPTION IF NONE EXISTS */
if (!$row['subscription_type']) {

    $start = date('Y-m-d');
    $end   = date('Y-m-d', strtotime('+30 days'));

    $insertSql = "
        INSERT INTO subscription 
        (userID, subscription_type, start_date, end_date, usage_count, max_usage, status)
        VALUES
        ('$userID','free','$start','$end',0,5,'active')
    ";

    mysqli_query($conn, $insertSql);

    $currentPlan = 'free';
    $usageCount = 0;
    $maxUsage = 5;
}

/* FETCH ALL SUBSCRIPTION PLANS */
$planQuery  = "SELECT * FROM subsplan";
$planResult = mysqli_query($conn, $planQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Subscription</title>
    <link rel="stylesheet" href="settings.css">
    <link rel="stylesheet" href="navi.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="subscription.css">
</head>
<body>

<header>
    <div id="header">
        <h1>THE SMARTVID</h1>
    </div>
</header>

<div class="navigationBar">
    <nav>
        <ul>
            <li><a href="main.php">HOME</a></li>
            <li><a href="view_summary.php">MY SUMMARIES</a></li>
            <li><a href="subscription.php">SUBSCRIPTION</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li class="profile-dropdown">
                <a href="#"><i class="fa-regular fa-user"></i></a>
                <div class="dropdown-content">
                    <a href="settingspage.php">SETTINGS</a>
                    <a href="#" id="logout">LOG OUT</a>
                </div>
            </li>
        </ul>
    </nav>
</div>

<h2>Choose Your Subscription Plan</h2>

<div class="current-plan">
    <p>Hello <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
    <p>Your current plan: <strong><?php echo $currentPlan; ?></strong></p>
    <p>Usage: <strong><?php echo $usageCount; ?></strong> / <?php echo $maxUsage === 99999 ? '∞' : $maxUsage; ?></p>

    <?php if ($currentPlan == 'Free' && $usageCount >= $maxUsage): ?>
        <p style="color: red; font-weight: bold; margin-top: 10px;">
            You have reached your free summarization limit (<?php echo $maxUsage; ?>).  
            Please subscribe to continue enjoying all features.
        </p>
    <?php endif; ?>
</div>

<div class="plan-container">
    <?php while ($plan = mysqli_fetch_assoc($planResult)) : ?>
        <div class="plan-card">
            <div class="plan-title"><?php echo htmlspecialchars($plan['plan_name']); ?></div>
            <div class="price">RM <?php echo $plan['price'] === 99999 ? '∞' : $plan['price']; ?></div>
            <div class="description"><?php echo htmlspecialchars($plan['description']); ?></div>
            <form action="payment.php" method="GET">
                <input type="hidden" name="plan" value="<?php echo strtolower($plan['plan_name']); ?>">
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

<script>
document.getElementById('logout').addEventListener('click', function(event) {
    event.preventDefault();
    alert('Thank you for using The SMARTVID');
    window.location.href = 'MainPage.html';
});
</script>

<div id="footer-placeholder"></div>
<script>
fetch('footer.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('footer-placeholder').innerHTML = data;
    });
</script>

</body>
</html>
