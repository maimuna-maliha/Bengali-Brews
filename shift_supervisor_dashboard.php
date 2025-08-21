<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "shift supervisor") {
    header("Location: login.php");
    exit;
}
$totalEmployees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees"))['total'];
$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$totalCompleted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders where status='Completed'"))['total'];
?>
<?php include 'includes/header.php'; ?>

<div class="dashboard">
    <h1>Shitf Supervisor Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You can manage staff shifts and monitor orders.</p>

    <div class="dashboard-cards">
       <div class="card">
            <h3>Total Employees</h3>
            <p><?= $totalEmployees; ?></p>
        </div>
        <div class="card">
            <h3>Total Customers</h3>
            <p><?= $totalCustomers; ?></p>
        </div>
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
