<?php
session_start();
include 'includes/db_connect.php';
include 'includes/header.php';

// Handle feedback submission
if (isset($_POST['submit_feedback'])) {
    $customer_id = (int)$_POST['customer_id'];
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    // Check if customer exists
    $check = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $check->bind_param("i", $customer_id);
    $check->execute();
    $cust = $check->get_result()->fetch_assoc();

    if (!$cust) {
        echo "<p style='color:red;'>No customer found with ID $customer_id. Please enter a valid Customer ID.</p>";
    } else {
        // Insert feedback
        $stmt = $conn->prepare("INSERT INTO feedback (customer_id, rating, comment, submitted_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $customer_id, $rating, $comment);
        $stmt->execute();

        echo "<p style='color:green;'>Thank you for your feedback!</p>";
    }
}
?>

<h1>Customer Feedback</h1>

<form method="POST">
    <label>Customer ID:</label>
    <input type="number" name="customer_id" required><br><br>

    <label>Rating:</label>
    <select name="rating" required>
        <option value="">-- Select Rating --</option>
        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
        <option value="4">⭐⭐⭐⭐ Good</option>
        <option value="3">⭐⭐⭐ Average</option>
        <option value="2">⭐⭐ Poor</option>
        <option value="1">⭐ Very Bad</option>
    </select><br><br>

    <label>Comments:</label><br>
    <textarea name="comment" rows="4" cols="40" placeholder="Write your feedback here..."></textarea><br><br>

    <button type="submit" name="submit_feedback">Submit Feedback</button>
</form>

<?php include 'includes/footer.php'; ?>
