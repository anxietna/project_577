<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Adjust this to your login page
    exit;
}

// Include your database connection file
include 'db.php';

// Check if the user has confirmed the deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm-delete'])) {
    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Perform deletion from the database
    $sql = "DELETE FROM user WHERE idUser = $userId"; 
    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        $alertMessage = "Your account has been successfully deleted.";
        session_destroy(); // Destroy the session after deletion
        // Redirect with JavaScript alert
        echo "<script>alert('$alertMessage'); window.location.href = 'MainPage.html';</script>";
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If the form is submitted without confirmation, redirect back (or show an error)
    header("Location: homepage.php"); // Redirect back to settings page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
    <style>
        body {
            background-color: black;
            color: yellow;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h2 {
            color: yellow;
        }
        form {
            margin-top: 20px;
        }
        input[type="submit"], a {
            background-color: yellow;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            font-weight: bold;
        }
        input[type="submit"]:hover, a:hover {
            background-color: #ffd700;
            color: black;
        }
    </style>
</head>
<body>
    <h2>Delete Your Account</h2>
    <form method="post">
        <p>Are you sure you want to delete your account?</p>
        <input type="submit" name="confirm-delete" value="Yes, I'm sure">
        <a href="main.php">No, go back</a>
    </form>
</body>
</html>


