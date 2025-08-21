<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ["admin", "store manager"])) {
    header("Location: login.php");
    exit;
}
include 'includes/db_connect.php';

$item_id = (int)$_GET['item_id'];
$menu_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu_items WHERE item_id=$item_id"));

if(isset($_POST['update'])){
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = (float)$_POST['price'];

    // Image update
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $target = "assets/images/".basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        mysqli_query($conn, "UPDATE menu_items SET item_name='$item_name', price=$price, image='$image' WHERE item_id=$item_id");
    } else {
        mysqli_query($conn, "UPDATE menu_items SET item_name='$item_name',  price=$price WHERE item_id=$item_id");
    }
    header("Location: dashboard.php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>
<h1>Edit Item</h1>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="item_name" value="<?php echo $menu_items['item_name']; ?>" required>
    <input type="number" step="0.01" name="price" value="<?php echo $menu_items['price']; ?>" required>
    <input type="file" name="image">
    <button type="submit" name="update">Update Item</button>
</form>
<?php include 'includes/footer.php'; ?>
