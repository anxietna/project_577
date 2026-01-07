<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php?view=subsplan");
    exit();
}

$planID = intval($_GET['id']);

// Fetch plan details
$result = mysqli_query($conn, "SELECT * FROM subsplan WHERE planID = $planID");
$plan = mysqli_fetch_assoc($result);

if (!$plan) {
    header("Location: admin_dashboard.php?view=subsplan");
    exit();
}

// Handle form submission
if (isset($_POST['updatePlan'])) {
    $planName = mysqli_real_escape_string($conn, $_POST['plan_name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "UPDATE subsplan SET plan_name='$planName', price=$price, description='$description' WHERE planID=$planID");
    header("Location: admin_dashboard.php?view=subsplan");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Subscription Plan</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="dashboard-container">
    <h2>Edit Subscription Plan</h2>
    <form method="POST">
        <label>Plan Name</label>
        <input type="text" name="plan_name" value="<?php echo htmlspecialchars($plan['plan_name']); ?>" required>

        <label>Price (RM)</label>
        <input type="number" name="price" value="<?php echo $plan['price']; ?>" step="0.01" required>

        <label>Description</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($plan['description']); ?></textarea>

        <button type="submit" name="updatePlan" class="edit-btn">Update Plan</button>
    </form>
    <a href="admin_dashboard.php?view=subsplan" class="back-btn">← Back</a>
</div>
</body>
</html>

