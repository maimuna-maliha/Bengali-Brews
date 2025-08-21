<?php
include 'includes/db_connect.php';
include 'includes/header.php';
?>

<main>
    <section class="hero">
        <h1>Welcome to Bengali Brews</h1>
        <div class="showcase-container">
            <div class="showcase-logo">
                <img src="assets/images/logo.png" alt="Bengali Brews">
            </div>
        </div>
        <p>Your Everyday Escape!</p>
    <section class="featured-menu">
        <h2>Latest Arrivals</h2>
        <div class="menu-container">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM menu_items ORDER BY item_id DESC LIMIT 8");
            while($menu_items = mysqli_fetch_assoc($result)):
            ?>
            <a class="menu-link">
                <div class="menu-card">
                    <img src="assets/images/<?php echo $menu_items['image']; ?>" alt="<?php echo $menu_items['item_name']; ?>">
                    <h3><?php echo $menu_items['item_name']; ?></h3>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </section>
    </section>
    <section class="showcase">
        <h2>Why Choose Us?</h2></br></br>
        <div class="showcase-container">
            <div class="showcase-item">
                <img src="assets/images/coffee.avif" alt="Coffee">
                <p>Sip your perfect cup, every time</p>
            </div>
            <div class="showcase-item">
                <img src="assets/images/cup.webp" alt="Cup">
                <p>Grab, sip, chill</p>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
