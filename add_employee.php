<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "store manager"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add'])) {
    $name           = trim($_POST['name']);
    $role           = trim($_POST['role']);
    $gender         = trim($_POST['gender']);
    $age            = (int)$_POST['age'];
    $contact_number = trim($_POST['contact_number']); 
    $email          = trim($_POST['email']);
    $salary         = (float)$_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO employees 
        (name, role, gender, age, contact_number, email, salary, joining_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("sssissd", 
        $name, $role, $gender, $age, $contact_number, $email, $salary
    );

    if ($stmt->execute()) {
        header("Location: employees.php?msg=Employee+added+successfully");
        exit;
    } else {
        header("Location: employees.php?msg=Error+adding+employee");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>
<h1>New Employee Details</h1>
<form method="post">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="role" placeholder="Role" required>
    <input type="text" name="gender" placeholder="Gender" required>
    <input type="number" step="1" name="age" placeholder="Age" required>
    <input type="text" name="contact_number" placeholder="Contact Number" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="number" step="0.01" name="salary" placeholder="Salary" required>
    <button type="submit" name="add">Add</button>
</form>
<?php include 'includes/footer.php'; ?>
