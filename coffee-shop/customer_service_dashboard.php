<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "customer service lead") {
    header("Location: login.php");
    exit;
}
$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
$totalFeedback = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM feedback"))['total'];
$avgRating = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg FROM feedback"))['avg'];

?>
<?php include 'includes/header.php'; ?>
<div class="dashboard">
    <h1>Customer Service Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You can manage feedback and complaints.</p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Customers</h3>
            <p><?= $totalCustomers; ?></p>
        </div>
        <div class="card">
            <h3>Total Items</h3>
            <p><?= $totalItems; ?></p>
        </div>
        <div class="card">
            <h3>Total Feedback</h3>
            <p><?= $totalFeedback; ?></p>
        </div>
        <div class="card">
            <h3>Average Rating</h3>
            <p><?= number_format($avgRating, 2); ?></p>

        </div>        
</div>
<?php include 'includes/footer.php'; ?>
