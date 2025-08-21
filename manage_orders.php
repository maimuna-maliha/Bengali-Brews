<?php
session_start();
if (
    !isset($_SESSION['role']) || 
    !in_array(strtolower($_SESSION['role']), ["admin", "barista", "shift supervisor"]) && 
    strpos(strtolower($_SESSION['role']), "chef") === false
) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    echo "<p style='color:green;'> Order ID $order_id status updated to $status.</p>";
}

// Search order
$order = null;
if (isset($_POST['search_order'])) {
    $order_id = $_POST['search_order_id'];
    $sql = "SELECT o.order_id, c.name AS customer, o.status, o.order_time 
            FROM orders o 
            JOIN customers c ON o.customer_id = c.customer_id 
            WHERE o.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
}
?>

<h1>Search & Update Order Status</h1>

<!-- Search Form -->
<form method="POST" style="margin-bottom:20px;">
    <label>Enter Order ID:</label>
    <input type="number" name="search_order_id" required>
    <button type="submit" name="search_order">Search</button>
</form>

<?php if ($order): ?>
<div style="border:1px solid #ccc;padding:10px;margin:10px;">
    <p><b>Order #<?= $order['order_id'] ?></b> | Customer: <?= $order['customer'] ?> | <?= $order['order_time'] ?></p>
    <form method="POST">
        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
        <select name="status">
            <option <?= $order['status']=="Pending"?"selected":"" ?>>Pending</option>
            <option <?= $order['status']=="In Progress"?"selected":"" ?>>In Progress</option>
            <option <?= $order['status']=="Prepared"?"selected":"" ?>>Canceled</option>
            <option <?= $order['status']=="Delivered"?"selected":"" ?>>Completed</option>
        </select>
        <button type="submit" name="update_status">Update</button>
    </form>
</div>
<?php elseif (isset($_POST['search_order'])): ?>
    <p style="color:red;"> No order found with ID <?= htmlspecialchars($_POST['search_order_id']) ?></p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
