<?php
session_start();
include('db.php'); // Make sure $conn is defined

// Must be logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

// Check selected plan
if (!isset($_GET['plan'])) {
    echo "<script>alert('No plan selected.'); window.location='subscription.php';</script>";
    exit();
}

$planKey = $_GET['plan'];

// Define plans
$plans = [
    "daily"   => "Daily",
    "monthly" => "Monthly",
    "yearly"  => "Yearly"
];

if (!isset($plans[$planKey])) {
    echo "<script>alert('Invalid plan.'); window.location='subscription.php';</script>";
    exit();
}

$planName = $plans[$planKey];

// Fetch planID and price from subsplan table
$planQuery = mysqli_query($conn, "SELECT planID, price FROM subsplan WHERE plan_name='$planName' LIMIT 1");
if (mysqli_num_rows($planQuery) === 0) {
    echo "<script>alert('Plan not found in database.'); window.location='subscription.php';</script>";
    exit();
}
$planRow = mysqli_fetch_assoc($planQuery);
$planID = $planRow['planID'];
$price  = $planRow['price'];

// Determine end date based on plan
$startDate = date('Y-m-d H:i:s');
switch (strtolower($planKey)) {
    case 'daily':
        $endDate = date('Y-m-d H:i:s', strtotime('+1 day'));
        break;
    case 'monthly':
        $endDate = date('Y-m-d H:i:s', strtotime('+30 days'));
        break;
    case 'yearly':
        $endDate = date('Y-m-d H:i:s', strtotime('+365 days'));
        break;
    default:
        $endDate = date('Y-m-d H:i:s', strtotime('+30 days')); // fallback
}

// Handle payment
if (isset($_POST['confirmPayment'])) {
    $cardName    = mysqli_real_escape_string($conn, $_POST['cardName']);
    $cardNumber  = mysqli_real_escape_string($conn, $_POST['cardNumber']);
    $expiryDate  = mysqli_real_escape_string($conn, $_POST['expiryDate']);
    $cvv         = mysqli_real_escape_string($conn, $_POST['cvv']);

    // Insert payment into database
    $insertPayment = "
        INSERT INTO payment (idUser, planID, cardName, cardNumber, expDate, cvv, price)
        VALUES ('$userID', '$planID', '$cardName', '$cardNumber', '$expiryDate', '$cvv', '$price')
    ";

    if (!mysqli_query($conn, $insertPayment)) {
        die("Payment error: " . mysqli_error($conn));
    }

    // Update or insert subscription
    $subQuery = "SELECT * FROM subscription WHERE userID='$userID' LIMIT 1";
    $subRes = mysqli_query($conn, $subQuery);

    if (mysqli_num_rows($subRes) > 0) {
        // Update existing subscription
        $updateSub = "
            UPDATE subscription
            SET subscription_type='$planName',
                start_date='$startDate',
                end_date='$endDate',
                usage_count=0,
                max_usage=999999,
                status='active'
            WHERE userID='$userID'
        ";
        $msg = "Subscription updated to $planName!";
    } else {
        // Insert new subscription
        $updateSub = "
            INSERT INTO subscription (userID, subscription_type, start_date, end_date, usage_count, max_usage, status)
            VALUES ('$userID', '$planName', '$startDate', '$endDate', 0, 999999, 'active')
        ";
        $msg = "Subscription $planName activated!";
    }

    mysqli_query($conn, $updateSub);

    echo "<script>alert('$msg'); window.location='subscription.php';</script>";
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment - THE SMARTVID</title>
<style>
body { font-family: Arial; background: #f7f7f7; }
.payment-container { width: 450px; margin: 60px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
h2 { text-align: center; }
label { font-weight: bold; }
input { width: 100%; padding: 10px; margin-top: 6px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc; }
.pay-btn { background: #ff69b4; color: white; padding: 12px; width: 100%; border: none; border-radius: 25px; cursor: pointer; font-size: 16px; margin-top: 10px; }
.pay-btn:hover { background: #ff4f9a; }
.price-box { text-align: center; background: #ffe3f1; padding: 15px; margin-bottom: 25px; border-radius: 10px; font-size: 18px; font-weight: bold; }
a.back { display: block; text-align: center; margin-top: 10px; color: #555; text-decoration: none; }
</style>
</head>
<body>

<div class="payment-container">
    <h2>Payment for <?php echo $planName; ?> Plan</h2>
    <div class="price-box">Total: RM <?php echo $price; ?></div>

    <form method="POST">
        <label>Cardholder Name</label>
        <input type="text" name="cardName" required>

        <label>Card Number</label>
        <input type="text" maxlength="16" name="cardNumber" required>

        <label>Expiry Date</label>
        <input type="month" name="expiryDate" required>

        <label>CVV</label>
        <input type="password" maxlength="3" name="cvv" required>

        <button type="submit" class="pay-btn" name="confirmPayment">Pay RM <?php echo $price; ?></button>
    </form>

    <a href="subscription.php" class="back">← Back to Plans</a>
</div>

</body>
</html>
