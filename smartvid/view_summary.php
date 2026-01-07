<?php
session_start();

if (!isset($_SESSION['userID'])) {
    echo "You must be logged in to view your summaries.";
    exit;
}

$conn = new mysqli("localhost", "root", "", "smartviddb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idUser = $_SESSION['userID'];

$sql = "SELECT subject, video_url, summary_text, created_at 
        FROM summaries 
        WHERE idUser = '$idUser'
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Summaries</title>
<link rel="stylesheet" href="viewsummary.css">
<link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navi.css">
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
                    <a href="delete_account.php" id="delete-account">DELETE ACCOUNT</a>
                </div>
            </li>
        </ul>
    </nav>
</div>
<div class="container">
    <h1>My Saved Summaries</h1>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="card">
            <p class="date">Saved on: <?php echo $row['created_at']; ?></p>

            <h2><?php echo htmlspecialchars($row['subject']); ?></h2>

            <p>
                <strong>YouTube Link: </strong>
                <a href="<?php echo $row['video_url']; ?>" target="_blank">
                    <?php echo $row['video_url']; ?>
                </a>
            </p>

            <div class="summary-box">
                <?php echo nl2br(htmlspecialchars($row['summary_text'])); ?>
            </div>
        </div>

<?php
    }
} else {
    echo "<p class='empty'>You have not saved any summaries yet.</p>";
}

$conn->close();
?>

</div>
<script src="scripts.js"></script>
<script>
    document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        alert('Thank you for using The SMARTVID'); // Show the thank you message
        window.location.href = 'MainPage.html'; // Redirect to MainPage.html
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
