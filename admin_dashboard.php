<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit;
}
$totalEmployees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role NOT IN ('admin')"))['total'];
$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$totalItems = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM menu_items"))['total'];
$res = mysqli_query($conn, "SELECT SUM(amount) AS sales FROM payments");
$row = mysqli_fetch_assoc($res);
$totalSales = $row['sales'] ? $row['sales'] : 0;
$avgRating = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg FROM feedback"))['avg'];
$Chefs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='barista' or role='chef'"))['total'];
$Cashiers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='cashier'"))['total'];
$StoreManagers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='store manager'"))['total'];
$Receptionist = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='receptionist'"))['total'];
$ShiftSupervisor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='shift supervisor'"))['total'];
$CustomerServiceLead = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees WHERE role='customer service lead'"))['total'];
$Helpers = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM employees 
    WHERE role NOT IN ('admin', 'chef', 'barista', 'cashier', 'store manager', 'receptionist', 'shift supervisor', 'customer service lead' )
"))['total'];
?>
<?php include 'includes/header.php'; ?>
<div class="dashboard">
    <h1>Admin Dashboard</h1>
    <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>! You have full control.</p>

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
            <h3>Total Sales</h3>
            <p>BDT <?= number_format($totalSales, 2); ?></p>
        </div>
        <div class="card">
            <h3>Average Rating</h3>
            <p><?= number_format($avgRating, 2); ?></p>
        </div>  
        <div class="card">
            <h3>Total Employees</h3>
            <p><?= $totalEmployees; ?></p>
        </div>              
        <div class="card">
            <h3>Chef</h3>
            <p><?= $Chefs; ?></p>
        </div>        
        <div class="card">
            <h3>Cashier</h3>
            <p><?= $Cashiers; ?></p>
        </div> 
        <div class="card">
            <h3>Store Manager</h3>
            <p><?= $StoreManagers; ?></p>
        </div>         
         <div class="card">
            <h3>Receptionist</h3>
            <p><?= $Receptionist; ?></p>
        </div>
         <div class="card">
            <h3>Shift Supervisor</h3>
            <p><?= $ShiftSupervisor; ?></p>
        </div>    
         <div class="card">
            <h3>Customer Service</h3>
            <p><?= $CustomerServiceLead; ?></p>
        </div> 
         <div class="card">
            <h3>Helper</h3>
            <p><?= $Helpers; ?></p>    
        </div> 
    </div>
</div>
<?php include 'includes/footer.php'; ?>
