<?php
session_start();
include('db.php');

// Must be logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}

// Decide which view admin wants
$view = $_GET['view'] ?? 'users';

// --------------------- USERS QUERY ---------------------
if ($view === 'users') {
    $userQuery = "
        SELECT u.idUser, u.name, u.email, u.username,
               s.subscription_type, s.usage_count, s.max_usage
        FROM user u
        LEFT JOIN subscription s ON u.idUser = s.userID
        ORDER BY u.idUser ASC
    ";
    $userResult = mysqli_query($conn, $userQuery);
}

// --------------------- FEEDBACK QUERY ---------------------
if ($view === 'feedback') {
    $feedbackQuery = "
        SELECT f.feedbackID, u.name AS userName, f.feedbackText, f.rating, f.created_at
        FROM feedback f
        LEFT JOIN user u ON f.userID = u.idUser
        ORDER BY f.feedbackID DESC
    ";
    $feedbackResult = mysqli_query($conn, $feedbackQuery);
}

// --------------------- SUBSCRIPTIONS QUERY ---------------------
if ($view === 'subscriptions') {
    $subQuery = "
        SELECT s.subscriptionID, u.name AS userName, s.subscription_type, s.usage_count, s.max_usage, s.start_date, s.status
        FROM subscription s
        LEFT JOIN user u ON s.userID = u.idUser
        ORDER BY s.subscriptionID ASC
    ";
    $subResult = mysqli_query($conn, $subQuery);
}

// --------------------- SUBSCRIPTION PLANS QUERY ---------------------
if ($view === 'subsplan') {
    $planQuery = "SELECT * FROM subsplan ORDER BY planID ASC";
    $planResult = mysqli_query($conn, $planQuery);
}

// --------------------- DELETE FEEDBACK ---------------------
if (isset($_GET['deleteFeedback'])) {
    $feedbackID = intval($_GET['deleteFeedback']);
    mysqli_query($conn, "DELETE FROM feedback WHERE feedbackID = $feedbackID");
    header("Location: admin_dashboard.php?view=feedback");
    exit();
}

// --------------------- DELETE PLAN ---------------------
if (isset($_GET['deletePlan'])) {
    $planID = intval($_GET['deletePlan']);
    mysqli_query($conn, "DELETE FROM subsplan WHERE planID = $planID");
    header("Location: admin_dashboard.php?view=subsplan");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - THE SMARTVID</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <p style="text-align:center;">Welcome, <strong><?php echo $_SESSION['admin']; ?></strong>!</p>
    <a href="logoutadmin.php" class="logout-btn">Logout</a>

    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
        <div class="dashboard-card" onclick="window.location='admin_dashboard.php?view=users'">View Users</div>
        <div class="dashboard-card" onclick="window.location='admin_dashboard.php?view=feedback'">View Feedback</div>
        <div class="dashboard-card" onclick="window.location='admin_dashboard.php?view=subscriptions'">View Subscriptions</div>
        <div class="dashboard-card" onclick="window.location='admin_dashboard.php?view=subsplan'">View Subscription Plans</div>
    </div>

    <!-- Users Table -->
    <?php if ($view === 'users'): ?>
        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Subscription</th>
                    <th>Usage</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($user = mysqli_fetch_assoc($userResult)) { 
                $currentPlan = $user['subscription_type'] ?? 'Free';
                $usageCount = $user['usage_count'] ?? 0;
                $maxUsage = isset($user['max_usage']) ? ($user['max_usage'] === NULL ? '∞' : $user['max_usage']) : 5;
            ?>
                <tr>
                    <td><?php echo $user['idUser']; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo $currentPlan; ?></td>
                    <td><?php echo $usageCount . ' / ' . $maxUsage; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Feedback Table -->
    <?php if ($view === 'feedback'): ?>
        <h2>User Feedback</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Feedback</th>
                    <th>Rating</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($feedbackResult)) { ?>
                <tr>
                    <td><?php echo $row['feedbackID']; ?></td>
                    <td><?php echo htmlspecialchars($row['userName']); ?></td>
                    <td><?php echo htmlspecialchars($row['feedbackText']); ?></td>
                    <td><?php echo str_repeat('⭐', $row['rating']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="admin_dashboard.php?view=feedback&deleteFeedback=<?php echo $row['feedbackID']; ?>" onclick="return confirm('Delete this feedback?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Subscriptions Table -->
    <?php if ($view === 'subscriptions'): ?>
        <h2>User Subscriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Type</th>
                    <th>Usage</th>
                    <th>Start Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($sub = mysqli_fetch_assoc($subResult)) { 
                $usageDisplay = $sub['max_usage'] === NULL ? '∞' : $sub['usage_count'] . ' / ' . $sub['max_usage'];
            ?>
                <tr>
                    <td><?php echo $sub['subscriptionID']; ?></td>
                    <td><?php echo htmlspecialchars($sub['userName']); ?></td>
                    <td><?php echo $sub['subscription_type']; ?></td>
                    <td><?php echo $usageDisplay; ?></td>
                    <td><?php echo $sub['start_date']; ?></td>
                    <td><?php echo $sub['status']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Subscription Plans Table -->
    <?php if ($view === 'subsplan'): ?>
        <!-- VIEW SUBSCRIPTION PLANS -->
<h2>Subscription Plans</h2>

<table>
    <thead>
        <tr>
            <th>Plan ID</th>
            <th>Plan Name</th>
            <th>Price (RM)</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $plans = mysqli_query($conn, "SELECT * FROM subsplan ORDER BY planID ASC");
        while ($p = mysqli_fetch_assoc($plans)) { 
        ?>
            <tr>
                <td><?php echo $p['planID']; ?></td>
                <td><?php echo htmlspecialchars($p['plan_name']); ?></td>
                <td><?php echo $p['price']; ?></td>
                <td><?php echo htmlspecialchars($p['description']); ?></td>

                <td>
                    <a href="edit_subsplan.php?id=<?php echo $p['planID']; ?>" class="edit-btn">Edit</a>
                    <a href="admin_dashboard.php?deletePlan=<?php echo $p['planID']; ?>" 
                       class="delete-btn"
                       onclick="return confirm('Delete this plan?');">
                       Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

    <?php endif; ?>

</div>
</body>
</html>
