<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin","cashier","receptionist","store manager","customer service lead"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';

// Fetch all customers
$result = mysqli_query($conn, "SELECT name, phone, email, loyalty_points FROM customers ORDER BY name ASC");

include 'includes/header.php';
?>
<?php if (isset($_GET['msg'])): ?>
    <p style="color:green; font-weight:bold;">
        <?= htmlspecialchars($_GET['msg']); ?>
    </p>
<?php endif; ?>

<h1>Customers</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Loyality Point</th>
    </tr>
<?php
while($row = mysqli_fetch_assoc($result)){
?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['loyalty_points']); ?></td>
    </tr>
<?php } ?>
</table>

<?php include 'includes/footer.php'; ?>
