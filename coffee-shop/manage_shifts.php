<?php
session_start();
if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "shift supervisor"])) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php';
include 'includes/header.php';

// Add shift
if (isset($_POST['add_shift'])) {
    $employee_id = $_POST['employee_id'];
    $shift_date = $_POST['shift_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO shifts (employee_id, shift_date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $employee_id, $shift_date, $start_time, $end_time);
    $stmt->execute();
}

// Fetch assigned shifts
$result = $conn->query("SELECT s.shift_id, e.name AS employee, e.role, s.shift_date, s.start_time, s.end_time
                        FROM shifts s 
                        JOIN employees e ON s.employee_id = e.employee_id
                        ORDER BY s.shift_date DESC");
?>
<h1>Manage Shifts</h1>

<form method="POST">
    <input type="number" name="employee_id" placeholder="Employee ID" required>
    <input type="date" name="shift_date" required>
    <input type="time" name="start_time" required>
    <input type="time" name="end_time" required>
    <button type="submit" name="add_shift">Assign Shift</button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <tr style="background:#f2f2f2;">
        <th>ID</th>
        <th>Employee</th>
        <th>Role</th>
        <th>Date</th>
        <th>Start</th>
        <th>End</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['shift_id'] ?></td>
        <td><?= $row['employee'] ?></td>
        <td><?= $row['role'] ?></td>
        <td><?= $row['shift_date'] ?></td>
        <td><?= $row['start_time'] ?></td>
        <td><?= $row['end_time'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
