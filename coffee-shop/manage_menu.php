<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "store manager"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';
include 'includes/header.php';

// Handle delete
if (isset($_GET['delete'])) {
    $item_id = intval($_GET['delete']);
    $conn->query("DELETE FROM menu_items WHERE item_id=$item_id");
}

$result = $conn->query("SELECT * FROM menu_items");
?>
<?php if (isset($_GET['msg'])): ?>
    <p style="color:green; font-weight:bold;">
        <?= htmlspecialchars($_GET['msg']); ?>
    </p>
<?php endif; ?>

<h1>Manage Menu</h1>
</br>
<a href="add_items.php" class="btn">Add New Item</a>
</br>
<table border="1" cellpadding="10">
<tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['item_id'] ?></td>
    <td><?= $row['item_name'] ?></td>
    <td><?= number_format($row['price'], 2) ?> BDT</td>
    <td>
        <a href="edit_item.php?item_id=<?php echo $row['item_id']; ?>">Edit</a> |
        <a href="?delete=<?= $row['item_id'] ?>">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'includes/footer.php'; ?>
