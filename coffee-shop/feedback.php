<?php
include 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ["admin", "customer service lead"])) {
    header("Location: login.php");
    exit;
}
// Fetch feedback
$result = $conn->query("SELECT f.feedback_id, c.name AS customer, f.rating, f.comment, f.submitted_at
                        FROM feedback f
                        JOIN customers c ON f.customer_id = c.customer_id
                        ORDER BY f.submitted_at DESC");

?>
<?php include 'includes/header.php'; ?>

<h1>Feedback</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <tr style="background:#f2f2f2;">
        <th>ID</th>
        <th>Customer</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['feedback_id'] ?></td>
        <td><?= $row['customer'] ?></td>
        <td><?= $row['rating'] ?> ⭐</td>
        <td><?= $row['comment'] ?></td>
        <td><?= $row['submitted_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
