<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "cashier", "store manager"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';
include 'includes/header.php';

$result = $conn->query("SELECT * FROM payments ORDER BY payment_id DESC");
?>
<h1>Payment Details</h1>

<table border="1" cellpadding="10">
<tr><th>Payment ID</th><th>Order ID</th><th>Amount</th><th>Method</th><th>Time</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['payment_id'] ?></td>
    <td><?= $row['order_id'] ?></td>
    <td><?= number_format($row['amount'], 2) ?> BDT </td>
    <td><?= $row['method'] ?></td>
    <td><?= $row['payment_time'] ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'includes/footer.php'; ?>
