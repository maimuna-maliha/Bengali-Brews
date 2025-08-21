<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "store manager", "receptionist"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "INSERT INTO customers (name, phone, email) VALUES ('$name', '$phone', '$email')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: customers.php?msg=Customer+added+successfully");
        exit;
    } else {
        header("Location: customers.php?msg=Error+adding+customer");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<h1>New Customer Details</h1>
<form method="post">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="phone" placeholder="Contact Number" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="add">Add</button>
</form>

<?php include 'includes/footer.php'; ?>
