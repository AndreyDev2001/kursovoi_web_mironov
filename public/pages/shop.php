<?php
include '../includes/functions.php';

session_start();

$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Welcome, <?php echo $_SESSION['user']['username']; ?>!</p>
            <a href="logout.php">Logout</a>
            <?php if (isAdmin()): ?>
                <a href="admin_panel.php">Admin Panel</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </header>
    <main>
        <?php while ($category = $categories->fetch_assoc()): ?>
            <section>
                <h2><?php echo $category['name']; ?></h2>
                <div class="product-list">
                    <?php $products = getProductsByCategory($category['id']); ?>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <div class="product-card">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['name']; ?>">
                            <div class="product-details">
                                <h3><?php echo $product['name']; ?></h3>
                                <p><?php echo $product['description']; ?></p>
                                <p class="price">Price: $<?php echo $product['price']; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        <?php endwhile; ?>
    </main>
</body>
</html>

