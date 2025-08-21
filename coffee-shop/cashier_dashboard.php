<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "cashier") {
    header("Location: login.php");
    exit;
}
$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
$totalPayments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM payments"))['total'];
$res = mysqli_query($conn, "SELECT SUM(amount) AS sales FROM payments");
$row = mysqli_fetch_assoc($res);
$totalSales = $row['sales'] ? $row['sales'] : 0;

?>
<?php include 'includes/header.php'; ?>
<div class="dashboard">
    <h1>Cashier Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You can manage orders and payments.</p>
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
            <h3>Total Payments</h3>
            <p><?= $totalPayments; ?></p>
        </div>        
        <div class="card">
            <h3>Total Sales</h3>
            <p>BDT <?= number_format($totalSales, 2); ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
