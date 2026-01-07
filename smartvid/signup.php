<!DOCTYPE html>
<html>
<head>
    <title>Sign Up | SmartVid</title>
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

    <!-- SIGN UP FORM -->
    <form method="POST" action="signup_process.php">

        <div class="inputBox">
            <input class="input" type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="inputBox">
            <input class="input" type="email" name="email" placeholder="Email" required>
        </div>

        <div class="inputBox">
            <input class="input" type="text" name="username" placeholder="Username" required>
        </div>

        <div class="inputBox">
            <input class="input" type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" class="submit">Register</button>

        <!-- SWITCH -->
        <div class="user">
            Already have an account?
            <a href="login.php"><span>Login</span></a>
        </div>

    </form>

</div>

</body>
</html>
