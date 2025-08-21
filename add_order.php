<?php
session_start();

if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "cashier", "barista", "chef"])) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

// Add order
if (isset($_POST['add_order'])) {
    $items = $_POST['items']; // array of item_id
    $quantities = $_POST['quantities']; // array of qty
    $customizations = $_POST['customizations']; // array of text

    // calculate total
    $total_amount = 0;
    foreach ($items as $index => $item_id) {
        $qty = (int)$quantities[$index];
        if ($qty > 0) {
            $price_result = $conn->query("SELECT price FROM menu_items WHERE item_id = $item_id");
            $price = $price_result->fetch_assoc()['price'];
            $total_amount += ($price * $qty);
        }
    }

    // insert order (customer_id will be assigned later)
    $stmt = $conn->prepare("INSERT INTO orders (total_amount, status) VALUES (?, 'Pending')");
    $stmt->bind_param("d", $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // insert items
    foreach ($items as $index => $item_id) {
        $qty = (int)$quantities[$index];
        $custom = $customizations[$index];
        if ($qty > 0) {
            $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, customizations) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiis", $order_id, $item_id, $qty, $custom);
            $stmt2->execute();
        }
    }

    // redirect to payment page
    header("Location: add_payment.php?order_id=$order_id");
    exit;
}

// Fetch menu items
$menu_items = $conn->query("SELECT item_id, item_name, price FROM menu_items ORDER BY item_name ASC");
?>

<h1>Add New Order</h1>

<form method="POST">
    <h3>Ordered Items:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Item</th>
            <th>Price (BDT)</th>
            <th>Quantity</th>
            <th>Customizations</th>
        </tr>
        <?php while ($row = $menu_items->fetch_assoc()): ?>
        <tr>
            <td>
                <?= $row['item_name'] ?>
                <input type="hidden" name="items[]" value="<?= $row['item_id'] ?>">
            </td>
            <td><?= $row['price'] ?></td>
            <td><input type="number" name="quantities[]" min="0" value="0" style="width:60px;"></td>
            <td><input type="text" name="customizations[]" placeholder="(e.g., no sugar, extra hot)"></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>

    <button type="submit" name="add_order">Add Order</button>
</form>

<?php include 'includes/footer.php'; ?>
