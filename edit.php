<?php
include 'config.php';

// Ambil ID produk dari URL
$product_id = $_GET['id'];

// Ambil data produk dari database
$sql = "SELECT * FROM items WHERE product_id = '$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found";
    exit;
}

// Proses pembaruan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_item = $_POST['name_item'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    // Cek apakah file gambar baru diupload
    if ($_FILES['image']['name']) {
        $image_path = 'images/' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            $image_query = ", image_path='$image_path'";
        } else {
            echo "Error uploading file.";
        }
    } else {
        $image_query = "";
    }

    // Update data produk ke database
    $sql_update = "UPDATE items SET name_item='$name_item', brand='$brand', category='$category', stock='$stock', price='$price', discount='$discount' $image_query WHERE product_id='$product_id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Product updated successfully";
        header("Location: product.php"); // Kembali ke halaman utama
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name_item" class="form-label">Name item</label>
                <input type="text" class="form-control" id="name_item" name="name_item" value="<?php echo $row['name_item']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $row['brand']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="Motherboard" <?php echo ($row['category'] == 'Motherboard') ? 'selected' : ''; ?>>Motherboard</option>
                    <option value="Processor" <?php echo ($row['category'] == 'Processor') ? 'selected' : ''; ?>>Processor</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $row['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" class="form-control" id="discount" name="discount" value="<?php echo $row['discount']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if ($row['image_path']): ?>
                    <img src="<?php echo $row['image_path']; ?>" alt="Product Image" width="100">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
