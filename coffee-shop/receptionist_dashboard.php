<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "receptionist") {
    header("Location: login.php");
    exit;
}
$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$totalReservations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservations"))['total'];
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
?>
<?php include 'includes/header.php'; ?>
<div class="dashboard">
    <h1>Receptionist Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You can manage customer reservations.</p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Customers</h3>
            <p><?= $totalCustomers; ?></p>
        </div>
        <div class="card">
            <h3>Total Reservations</h3>
            <p><?= $totalReservations; ?></p>
        </div>        
        <div class="card">
            <h3>Total Items</h3>
            <p><?= $totalItems; ?></p>
        </div>
        <div class="card">
            <h3>Total Tables</h3>
            <p>25</p>
        </div>        
    </div>
</div>
<?php include 'includes/footer.php'; ?>
