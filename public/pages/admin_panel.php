<?php
include '../includes/functions.php';

session_start();

if (!isset($_SESSION['user']) || !isAdmin()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $name = $_POST['category_name'];
        addCategory($name);
    } elseif (isset($_POST['edit_category'])) {
        $id = $_POST['category_id'];
        $name = $_POST['category_name'];
        editCategory($id, $name);
    } elseif (isset($_POST['delete_category'])) {
        $id = $_POST['category_id'];
        deleteCategory($id);
    } elseif (isset($_POST['add_product'])) {
        $category_id = $_POST['category_id'];
        $name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = file_get_contents($_FILES['image']['tmp_name']);
        addProduct($category_id, $name, $description, $price, $image);
    } elseif (isset($_POST['edit_product'])) {
        $id = $_POST['product_id'];
        $category_id = $_POST['category_id'];
        $name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = file_get_contents($_FILES['image']['tmp_name']);
        editProduct($id, $category_id, $name, $description, $price, $image);
    } elseif (isset($_POST['delete_product'])) {
        $id = $_POST['product_id'];
        deleteProduct($id);
    }
}

$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <p>Welcome, <?php echo $_SESSION['user']['username']; ?>!</p>
        <a href="logout.php">Logout</a>
        <a href="shop.php">Go to Shop</a>
    </header>
    <main>
        <h2>Manage Categories</h2>
        <form method="POST" action="admin_panel.php" enctype="multipart/form-data">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>
        <?php while ($category = $categories->fetch_assoc()): ?>
            <form method="POST" action="admin_panel.php" enctype="multipart/form-data">
                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                <input type="text" name="category_name" value="<?php echo $category['name']; ?>" required>
                <button type="submit" name="edit_category">Edit Category</button>
                <button type="submit" name="delete_category">Delete Category</button>
            </form>
        <?php endwhile; ?>

        <h2>Manage Products</h2>
        <form method="POST" action="admin_panel.php" enctype="multipart/form-data">
            <select name="category_id" required>
                <?php $categories = getCategories(); ?>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="number" name="price" placeholder="Price" required>
            <input type="file" name="image">
            <button type="submit" name="add_product">Add Product</button>
        </form>
        <?php $categories = getCategories(); ?>
        <?php while ($category = $categories->fetch_assoc()): ?>
            <?php $products = getProductsByCategory($category['id']); ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <form method="POST" action="admin_panel.php" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="category_id" value="<?php echo $product['category_id']; ?>">
                    <input type="text" name="product_name" value="<?php echo $product['name']; ?>" required>
                    <textarea name="description"><?php echo $product['description']; ?></textarea>
                    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
                    <input type="file" name="image">
                    <button type="submit" name="edit_product">Edit Product</button>
                    <button type="submit" name="delete_product">Delete Product</button>
                </form>
            <?php endwhile; ?>
        <?php endwhile; ?>
    </main>
</body>
</html>
