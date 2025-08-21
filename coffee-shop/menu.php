<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<h1>Our Menu</h1></br>
<div class="menu-container">
<?php
$sql = "SELECT item_id, item_name, image, price FROM menu_items ORDER BY item_name ASC";
$result = $conn->query($sql);
while($menu_items = mysqli_fetch_assoc($result)){
?>
    <div class="menu-card">
        <img src="assets/images/<?php echo $menu_items['image']; ?>" alt="<?php echo $menu_items['item_name']; ?>">
        <h3><?php echo $menu_items['item_name']; ?></h3>
        <p>Price: BDT <?php echo $menu_items['price']; ?></p>
    </div>
<?php } ?>
</div>

<?php include 'includes/footer.php'; ?>
