<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "store manager"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';

if(isset($_POST['add'])){
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = (float)$_POST['price'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "assets/images/".basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    mysqli_query($conn, "INSERT INTO menu_items (item_name, price, image) VALUES ('$item_name',$price,'$image')");
    header("Location: manage_menu.php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<h1>New Item</h1>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="item_name" placeholder="Item Name" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <button type="submit" name="add">Add</button>
</form>
<?php include 'includes/footer.php'; ?>
