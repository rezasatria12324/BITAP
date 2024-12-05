<?php
include 'config.php';

// Proses menambahkan produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name_item = $_POST['name_item'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image_path = 'images/' . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        $sql = "INSERT INTO items (name_item, brand, category, stock, price, discount, image_path)
                VALUES ('$name_item', '$brand', '$category', '$stock', '$price', '$discount', '$image_path')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2 class="mt-4">Product</h2>

    <!-- Form Add Product -->
    <form class="mb-4" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-2 mb-3">
                <label for="productId" class="form-label">ID</label>
                <input type="text" class="form-control" id="productId" name="product_id" placeholder="Enter ID" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="productName" class="form-label">Name item</label>
                <input type="text" class="form-control" id="productName" name="name_item" placeholder="Enter name item" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter brand" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="category" class="form-label">Categories</label>
                <select class="form-select" id="category" name="category" required>
                    <option selected>Select categories</option>
                    <option value="Motherboard">Motherboard</option>
                    <option value="Processor">Processor</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter discount" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="imageUpload" class="form-label">Image</label>
                <input type="file" class="form-control" id="imageUpload" name="image" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Add item</button>
            </div>
        </div>
    </form>

    <!-- Table to display products -->
    <div class="card">
        <div class="container">
        <h3>Items</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name items</th>
                    <th>Brand</th>
                    <th>Categories</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from the database
                $result = $conn->query("SELECT * FROM items");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['product_id']}</td>
                                <td>{$row['name_item']}</td>
                                <td>{$row['brand']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['stock']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['discount']}</td>
                                <td><img src='{$row['image_path']}' alt='Product' width='50'></td>
                                <td>
                                    <a href='edit.php?id={$row['product_id']}' class='btn btn-warning btn-sm'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                    <a href='delete.php?id={$row['product_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this item?\")'>
                                        <i class='fas fa-trash'></i> Delete
                                    </a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>
</main>
