<?php
include "db.php";

$name     = $_POST['name'];
$email    = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password']; // ✅ save exactly as user input

/* Check if username already exists */
$check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

if (mysqli_num_rows($check) > 0) {
    echo "<script>
        alert('Username already exists!');
        window.location='signup.php';
    </script>";
    exit();
}

/* Insert user */
$user_sql = "INSERT INTO user (name, email, username, password)
             VALUES ('$name','$email','$username','$password')";

if (mysqli_query($conn, $user_sql)) {

    $userID = mysqli_insert_id($conn);

    /* Auto insert FREE subscription */
    $start = date('Y-m-d');
    $end   = date('Y-m-d', strtotime('+30 days'));

    $sub_sql = "INSERT INTO subscription
        (userID, subscription_type, start_date, end_date, usage_count, max_usage, status)
        VALUES
        ('$userID','free','$start','$end',0,5,'active')";

    mysqli_query($conn, $sub_sql);

    echo "<script>
        alert('Registration successful! Free plan activated.');
        window.location='login.php';
    </script>";

} else {
    echo "<script>
        alert('Registration failed!');
        window.location='signup.php';
    </script>";
}
?>
