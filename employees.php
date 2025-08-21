<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "store manager"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';

// Fetch all employees
$result = mysqli_query($conn, "SELECT name, contact_number, email, role, gender, age, joining_date, salary FROM employees ORDER BY joining_date ASC");
include 'includes/header.php';
?>
<?php if (isset($_GET['msg'])): ?>
    <p style="color:green; font-weight:bold;">
        <?= htmlspecialchars($_GET['msg']); ?>
    </p>
<?php endif; ?>
<h1>Employees</h1>
</br><a href="add_employee.php" class="btn">Add New Employee</a></br>
<table>
    <tr>
        <th>Name</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Role</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Joining Date</th>
        <th>Salary</th>
    </tr>
<?php
while($row = mysqli_fetch_assoc($result)){
?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['role']); ?></td>
        <td><?php echo htmlspecialchars($row['gender']); ?></td>
        <td><?php echo htmlspecialchars($row['age']); ?></td>
        <td><?php echo htmlspecialchars($row['joining_date']); ?></td>
        <td><?php echo htmlspecialchars($row['salary']); ?></td>
    </tr>
<?php } ?>
</table>
<?php include 'includes/footer.php'; ?>
