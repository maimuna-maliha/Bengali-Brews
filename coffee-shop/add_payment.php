<?php
session_start();
if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "cashier"])) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

$order_id = (int)$_GET['order_id'];

// Fetch order
$order = $conn->query("SELECT * FROM orders WHERE order_id=$order_id")->fetch_assoc();
if (!$order) {
    echo "<p style='color:red;'>Order not found.</p>";
    include 'includes/footer.php';
    exit;
}

if (!isset($_POST['customer_done']) && !isset($_POST['make_payment'])) {
    ?>
    <h2>Assign Customer for Order #<?= $order_id ?></h2>
    <form method="POST">
        <label>Existing Customer ID:</label>
        <input type="number" name="customer_id"><br><br>

        <p><strong>OR Add New Customer:</strong></p>
        <input type="text" name="name" placeholder="Name"><br><br>
        <input type="text" name="phone" placeholder="Phone"><br><br>
        <input type="email" name="email" placeholder="Email"><br><br>

        <button type="submit" name="customer_done">Continue to Payment</button>
    </form>
    <?php
    include 'includes/footer.php';
    exit;
}

if (isset($_POST['customer_done'])) {
    $customer_id = (int)$_POST['customer_id'];

    if ($customer_id > 0) {
        // Check if customer exists
        $chk = $conn->prepare("SELECT * FROM customers WHERE customer_id=?");
        $chk->bind_param("i", $customer_id);
        $chk->execute();
        $customer = $chk->get_result()->fetch_assoc();
        if (!$customer) {
            echo "<p style='color:red;'>No customer with ID $customer_id</p>";
            include 'includes/footer.php';
            exit;
        }
    } else {
        // Add new customer
        $stmt = $conn->prepare("INSERT INTO customers (name, phone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['name'], $_POST['phone'], $_POST['email']);
        $stmt->execute();
        $customer_id = $stmt->insert_id;
    }

    // Link customer to order
    $conn->query("UPDATE orders SET customer_id=$customer_id WHERE order_id=$order_id");
}

if (!isset($_POST['make_payment'])) {
    // Get customer_id (now linked to order)
    $cust = $conn->query("SELECT customer_id FROM orders WHERE order_id=$order_id")->fetch_assoc();
    $customer_id = $cust['customer_id'];
    ?>
    <h2>Payment for Order #<?= $order_id ?></h2>
    <p>Total Amount: <?= $order['total_amount'] ?> BDT</p>
    <form method="POST">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <input type="hidden" name="amount" value="<?= $order['total_amount'] ?>">

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">-- Select Method --</option>
            <option value="Cash">Cash</option>
            <option value="Card">Card</option>
            <option value="Mobile Banking">Mobile Banking</option>
        </select><br><br>
        <button type="submit" name="make_payment">Confirm Payment</button>
    </form>
    <?php
    include 'includes/footer.php';
    exit;
}

if (isset($_POST['make_payment'])) {
    $order_id = (int)$_POST['order_id'];
    $amount   = (float)$_POST['amount'];
    $method   = $_POST['payment_method'];

    // Mark order as completed
    $update = $conn->prepare("UPDATE orders SET status='Completed' WHERE order_id=?");
    $update->bind_param("i", $order_id);
    $update->execute();

    // Record payment (no customer_id column here)
    $stmt = $conn->prepare("INSERT INTO payments (order_id, amount, method) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $order_id, $amount, $method);
    $stmt->execute();

echo "
<div class='card border-success mb-3' style='max-width: 30rem; margin:20px auto;'>
  <div class='card-header bg-success text-white'>Payment Successful</div>
  <div class='card-body text-success'>
    <h5 class='card-title'>Order #$order_id Completed</h5>
    <p class='card-text'>
      <p>Payment Method:</p> $method <br>
      <p>Amount:</p> $amount BDT
    </p>
  </div>
</div>";

}

include 'includes/footer.php';
?>
