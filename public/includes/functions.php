<?php
include 'db.php';

function registerUser($username, $password) {
    global $conn;
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'client')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    return $stmt->execute();
}

function loginUser($username, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

function addCategory($name) {
    global $conn;
    $sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    return $stmt->execute();
}

function editCategory($id, $name) {
    global $conn;
    $sql = "UPDATE categories SET name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    return $stmt->execute();
}

function deleteCategory($id) {
    global $conn;
    $sql = "DELETE FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function addProduct($category_id, $name, $description, $price, $image) {
    global $conn;
    $sql = "INSERT INTO products (category_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $null = NULL;
    $stmt->bind_param("isdss", $category_id, $name, $description, $price, $image);
    $stmt->send_long_data(4, $image);
    return $stmt->execute();
}

function editProduct($id, $category_id, $name, $description, $price, $image) {
    global $conn;
    $sql = "UPDATE products SET category_id=?, name=?, description=?, price=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $null = NULL;
    $stmt->bind_param("isdssi", $category_id, $name, $description, $price, $null, $image);
    $stmt->send_long_data(4, $image);
    return $stmt->execute();
}

function deleteProduct($id) {
    global $conn;
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getCategories() {
    global $conn;
    $sql = "SELECT * FROM categories";
    return $conn->query($sql);
}

function getProductsByCategory($category_id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE category_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getCategoryById($id) {
    global $conn;
    $sql = "SELECT * FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getProductById($id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin';
}
?>
