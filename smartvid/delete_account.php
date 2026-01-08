<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm-delete'])) {

    $userId = $_SESSION['userID'];

    // Start transaction (safe delete)
    mysqli_begin_transaction($conn);

    try {
        // 1. Delete summaries
        mysqli_query($conn, "DELETE FROM summaries WHERE idUser = $userId");

        // 2. Delete subscriptions
        mysqli_query($conn, "DELETE FROM subscription WHERE userID = $userId");

        // 3. Delete payments (if exists)
        mysqli_query($conn, "DELETE FROM payment WHERE idUser = $userId");

        // 4. Delete feedback (if exists)
        mysqli_query($conn, "DELETE FROM feedback WHERE userID = $userId");

        // 5. Finally delete user
        mysqli_query($conn, "DELETE FROM user WHERE idUser = $userId");

        mysqli_commit($conn);

        session_destroy();
        echo "<script>
            alert('Your account has been successfully deleted.');
            window.location.href='MainPage.html';
        </script>";
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error deleting account.";
    }
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



