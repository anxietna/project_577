<?php
session_start();
include('db.php');

// Must be logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$showPopup = false;
$error = "";
$feedbackText = "";

// Get logged-in user ID
$user_id = $_SESSION['userID'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedbackText = trim($_POST['feedbackText']);
    $rating = intval($_POST['rating'] ?? 0);

    if (!empty($feedbackText) && $rating >= 1 && $rating <= 5) {
        $feedbackText = mysqli_real_escape_string($conn, $feedbackText);

        // Insert feedback with userID foreign key
        $sql = "INSERT INTO feedback (userID, feedbackText, rating, created_at) 
                VALUES ($user_id, '$feedbackText', $rating, NOW())";

        if (mysqli_query($conn, $sql)) {
            $showPopup = true; // trigger popup
            $feedbackText = "";
        } else {
            $error = "Error saving feedback. Please try again. " . mysqli_error($con);
        }
    } else {
        $error = "Please enter your feedback and select a rating.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://kit.fontawesome.com/0dbb3f2ef0.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="footer.css">
<link rel="stylesheet" href="navi.css">
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="feedback.css">
<title>Website Feedback</title>
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
    <h2>Website Feedback</h2>
    <form method="POST">
        <textarea name="feedbackText" placeholder="Share your thoughts..." required><?php echo htmlspecialchars($feedbackText); ?></textarea>

        <div class="stars">
            <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
        </div>

        <button type="submit">Submit Feedback</button>
    </form>

    <?php if($error): ?>
        <p class="message error"><?php echo $error; ?></p>
    <?php endif; ?>
</div>

<div class="popup" id="thankyouPopup">
    <div class="popup-content">
        <h3>Thank You!</h3>
        <p>Your feedback has been submitted successfully.</p>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>
function closePopup() {
    document.getElementById('thankyouPopup').style.display = 'none';
}

<?php if($showPopup): ?>
    document.getElementById('thankyouPopup').style.display = 'flex';
<?php endif; ?>

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
