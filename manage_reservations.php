<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "receptionist"])) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

$message = "";

// Add reservation
if (isset($_POST['add_reservation'])) {
    $customer_id = $_POST['customer_id'];
    $table_number = $_POST['table_number'];
    $reservation_date = $_POST['reservation_date'];
    $time_slot = $_POST['time_slot'];

    // Check if customer exists
    $check = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $check->bind_param("i", $customer_id);
    $check->execute();
    $result_check = $check->get_result();

    if ($result_check->num_rows > 0) {
        // Customer exists, insert reservation
        $stmt = $conn->prepare("INSERT INTO reservations (customer_id, table_number, reservation_date, time_slot) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $customer_id, $table_number, $reservation_date, $time_slot);
        if ($stmt->execute()) {
            $message = "<span style='color:green;'>Reservation added successfully!</span>";
        } else {
            $message = "<span style='color:red;'>Error adding reservation.</span>";
        }
    } else {
        // Customer does not exist
        $message = "<span style='color:red;'>No customer found with ID {$customer_id}. Please add a new customer first.</span>";
    }
}

// Fetch reservations
$reservations = $conn->query("SELECT r.reservation_id, c.name as customer, r.table_number, r.reservation_date, r.time_slot
                              FROM reservations r
                              JOIN customers c ON r.customer_id = c.customer_id
                              ORDER BY r.reservation_date DESC");
?>

<h1>Manage Reservations</h1>

<?php if($message) echo "<p>$message</p>"; ?>

<form method="POST">
    <input type="number" name="customer_id" placeholder="Customer ID" required>
    <input type="number" name="table_number" placeholder="Table Number" required>
    <input type="date" name="reservation_date" required>
    <input type="time" name="time_slot" required>
    <button type="submit" name="add_reservation">Add Reservation</button>
</form>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Table</th>
    <th>Date</th>
    <th>Time</th>
</tr>
<?php while ($row = $reservations->fetch_assoc()): ?>
<tr>
    <td><?= $row['reservation_id'] ?></td>
    <td><?= $row['customer'] ?></td>
    <td><?= $row['table_number'] ?></td>
    <td><?= $row['reservation_date'] ?></td>
    <td><?= $row['time_slot'] ?></td>
</tr>
<?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
