<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine base path based on folder
$current_folder = basename(dirname($_SERVER['PHP_SELF']));
if ($current_folder == 'auth' || $current_folder == 'user' || $current_folder == 'admin') {
    $base_path = '../';
} else {
    $base_path = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengali Brews</title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>
<body>
<header>
    <div class="logo"><a href="<?php echo $base_path; ?>home.php">Bengali Brews</a></div>
    <nav>
        <ul>
            <?php if(isset($_SESSION['username'])): ?>
                <?php $role = $_SESSION['role'] ?? ''; ?>
                <?php if($role === "admin"): ?>
                    <li><a href="<?php echo $base_path; ?>admin_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_menu.php">MENU</a></li>
                    <li><a href="<?php echo $base_path; ?>employees.php">EMPLOYEES</a></li>
                    <li><a href="<?php echo $base_path; ?>customers.php">CUSTOMERS</a></li>
                    <li><a href="<?php echo $base_path; ?>orders.php">ORDERS</a></li>
                    <li><a href="<?php echo $base_path; ?>payments.php">PAYMENTS</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_reservations.php">RESERVATIONS</a></li>
                    <li><a href="<?php echo $base_path; ?>feedback.php">FEEDBACK</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_shifts.php">SHIFTS</a></li>
                <?php endif; ?>                
                <?php if($role === "cashier"): ?>
                    <li><a href="<?php echo $base_path; ?>cashier_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>customers.php">CUSTOMERS</a></li>
                    <li><a href="<?php echo $base_path; ?>add_order.php">ADD ORDER</a></li>                    
                    <li><a href="<?php echo $base_path; ?>payments.php">PAYMENTS</a></li>
                <?php endif; ?>                
                <?php if($role === "barista" || $role === "chef"): ?>
                    <li><a href="<?php echo $base_path; ?>chef_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>orders.php">ORDERS</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_orders.php">UPDATE ORDER</a></li>
                <?php endif; ?>                
                <?php if($role === "receptionist"): ?>
                    <li><a href="<?php echo $base_path; ?>receptionist_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>add_customer.php">ADD CUSTOMER</a></li>
                    <li><a href="<?php echo $base_path; ?>customers.php">CUSTOMERS</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_reservations.php">RESERVATIONS</a></li>
                <?php endif; ?>                
                <?php if($role === "shift supervisor"): ?>
                    <li><a href="<?php echo $base_path; ?>shift_supervisor_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>orders.php">ORDERS</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_shifts.php">SHIFTS</a></li>
                <?php endif; ?>      
                <?php if($role === "customer service lead"): ?>
                    <li><a href="<?php echo $base_path; ?>customer_service_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>customers.php">CUSTOMERS</a></li>
                    <li><a href="<?php echo $base_path; ?>add_feedback.php">ADD FEEDBACK</a></li>
                    <li><a href="<?php echo $base_path; ?>feedback.php">FEEDBACK</a></li>
                <?php endif; ?>                           
                <?php if($role === "store manager"): ?>
                    <li><a href="<?php echo $base_path; ?>store_manager_dashboard.php">DASHBOARD</a></li>
                    <li><a href="<?php echo $base_path; ?>manage_menu.php">MENU</a></li>
                    <li><a href="<?php echo $base_path; ?>customers.php">CUSTOMERS</a></li>
                    <li><a href="<?php echo $base_path; ?>employees.php">EMPLOYEES</a></li>               
                    <li><a href="<?php echo $base_path; ?>orders.php">ORDERS</a></li>
                    <li><a href="<?php echo $base_path; ?>payments.php">PAYMENTS</a></li>
                <?php endif; ?>                        
                <li><a href="<?php echo $base_path; ?>logout.php">LOGOUT</a></li>
            <?php else: ?>
                <!-- Guest menu -->
                <li><a href="<?php echo $base_path; ?>menu.php">MENU</a></li>
                <li><a href="<?php echo $base_path; ?>about.php">ABOUT</a></li>
                <li><a href="<?php echo $base_path; ?>contact.php">HELP & SUPPORT</a></li>
                <li><a href="<?php echo $base_path; ?>login.php">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>


