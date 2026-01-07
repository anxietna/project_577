<?php
include('db.php');
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Query admin table
        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php"); // redirect after successful login
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Briem+Hand:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Admin Login - THE SMARTVID</title>
</head>

<body>
    <div class="container containerFront">
        <div class="top">
            <div class="image">
                <img src="logo.png" alt="logo.png">
            </div>
            <span>ADMIN PANEL</span>
        </div>

        <div class="form">
            <form action="loginadmin.php" method="POST">
                <div class="inputBox inputBoxFront">
                    <label><i class="fa-solid fa-user-shield"></i></label>
                    <input type="text" name="username" placeholder="Admin Username" class="input" required>
                </div>

                <div class="inputBox inputBoxFront">
                    <label><i class="fa-solid fa-lock"></i></label>
                    <input type="password" name="password" placeholder="Password" class="input" required>
                </div>

                <button type="submit" class="submit" id="loginButton">Log In</button>

                <?php if (!empty($error)): ?>
                    <p style="color:red; margin-top:10px;"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
