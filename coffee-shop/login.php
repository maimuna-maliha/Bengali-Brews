<?php
session_start();
include 'includes/db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Employee login
    $sql = "SELECT employee_id, username, password, role FROM employees WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = strtolower($row['role']);

            // Redirect based on role
            switch ($_SESSION['role']) {
                 case "admin":
                    header("Location: admin_dashboard.php");
                    break;
                case "cashier":
                    header("Location: cashier_dashboard.php");
                    break;
                case "barista":
                    header("Location: chef_dashboard.php");
                    break;
                case "chef":
                    header("Location: chef_dashboard.php");
                    break;
                case "store manager":
                    header("Location: store_manager_dashboard.php");
                    break;
                case "shift supervisor":
                    header("Location: shift_supervisor_dashboard.php");
                    break;
                case "receptionist":
                    header("Location: receptionist_dashboard.php");
                    break;
                case "customer service lead":
                    header("Location: customer_service_dashboard.php");
                    break;
                default:
                    $error = "Role not assigned a dashboard.";
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h1>LOGIN</h1>
<h4>(Only for Employees)<h4>
<form method="post">
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
