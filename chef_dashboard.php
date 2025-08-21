<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== "barista" && $_SESSION['role'] !== "chef")) {
    header("Location: login.php");
    exit;
}
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$totalCompleted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders where status='Completed'"))['total'];

?>

<?php include 'includes/header.php'; ?>

<div class="dashboard">
    <h1>Chef Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You can manage order preparation.</p>
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Items</h3>
            <p><?= $totalItems; ?></p>
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <p><?= $totalOrders; ?></p>
        </div>
        <div class="card">
            <h3>Total Completed Orders</h3>
            <p><?= $totalCompleted; ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

