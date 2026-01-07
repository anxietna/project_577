<?php
session_start();
include "db.php";

/* MATCH LOGIN SESSION */
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];
$message = '';
$error = '';

/* UPDATE USER INFO */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    /* Check username duplication (excluding current user) */
    $check = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username='$username' AND idUser != '$userID'"
    );

    if (mysqli_num_rows($check) > 0) {
        $error = "Username already exists!";
    } else {

        $update = "UPDATE user 
                   SET name='$name', email='$email', username='$username', password='$password'
                   WHERE idUser='$userID'";

        if (mysqli_query($conn, $update)) {
            $message = "Information updated successfully!";
            $_SESSION['username'] = $username; // update session username
        } else {
            $error = "Error updating information.";
        }
    }
}

/* FETCH LOGGED-IN USER DATA */
$qry = mysqli_query($conn, "SELECT * FROM user WHERE idUser='$userID'");
$row = mysqli_fetch_assoc($qry);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css">
    <link rel="stylesheet" href="navi.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="main.css">
</head>
<header>
    <div id="header">
        <h1>THE SMARTVID</h1>
    </div>
</header>
<body>
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
    <div class="container">
        <h2>Settings</h2>
        <?php if ($message): ?>
            <script>
                // Display alert message for successful update
                alert("<?php echo $message; ?>");
            </script>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="settingspage.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($row['password']); ?>" required>
            <button type="submit">Update</button>
            <button type="button" onclick="location.href='homepage.php';">Cancel</button>
        </form>
    </div>

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
