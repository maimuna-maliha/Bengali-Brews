<?php
session_start();

// Optional: allow only logged-in users
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

// Fetch orders with customer info
$sql = "SELECT o.order_id, c.name AS customer, o.total_amount, o.status, o.order_time 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        ORDER BY o.order_id DESC";
$result = $conn->query($sql);
?>

<h1>All Orders</h1>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;width:100%;">
    <tr style="background:#f2f2f2;">
        <th>Order ID</th>
        <th>Customer</th>
        <th>Order Time</th>
        <th>Status</th>
        <th>Total Amount (BDT)</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['order_id'] ?></td>
        <td><?= $row['customer'] ?></td>
        <td><?= $row['order_time'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['total_amount'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
