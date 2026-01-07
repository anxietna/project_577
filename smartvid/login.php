<!DOCTYPE html>
<html>
<head>
    <title>Login | SmartVid</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- LOGO -->
    <div class="top">
        <div class="image">
            <img src="logo.png" alt="logo.png">
        </div>
        <span>THE SMARTVID</span>
    </div>

    <!-- LOGIN FORM -->
    <form method="POST" action="login_process.php">

        <div class="inputBox">
            <input class="input" type="text" name="username" placeholder="Username" required>
        </div>

        <div class="inputBox">
            <input class="input" type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" class="submit">Login</button>

        <!-- SWITCH -->
        <div class="user">
            Don’t have an account?
            <a href="signup.php"><span>Sign Up</span></a>
        </div>

    </form>

</div>

</body>
</html>
