<?php
include 'config.php';

// Proses tambah produk baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $name_item = $_POST['name_item'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image_path = '';

    // Upload gambar
    if (!empty($_FILES["image"]["name"])) {
        $image_path = 'images/' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    $sql = "INSERT INTO items (product_id, name_item, brand, category, stock, price, discount, image_path) 
            VALUES ('$product_id', '$name_item', '$brand', '$category', '$stock', '$price', '$discount', '$image_path')";

    if ($conn->query($sql)) {
        echo "<script>alert('Product added successfully');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}


// Proses update produk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $name_item = $_POST['name_item'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image_path = $_POST['current_image'];

    if (!empty($_FILES["image"]["name"])) {
        $image_path = 'images/' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    $sql = "UPDATE items SET 
                name_item = '$name_item', 
                brand = '$brand', 
                category = '$category', 
                stock = '$stock', 
                price = '$price', 
                discount = '$discount', 
                image_path = '$image_path' 
            WHERE product_id = '$product_id'";

    $conn->query($sql);
}

?>

<div id="content">
    <!-- Main Content -->
    <main class="ms-sm-auto px-md-4">
        <div class="row mb-3">
            <div class="card py-3 text-center">
                <h3 class="fw-bold mb-0" style="color: #0d6efd;">Product Management</h3>
            </div>
        </div>

        <!-- Form Add Product -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Product</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="productId" class="form-label">ID</label>
                            <input type="text" class="form-control" id="productId" name="product_id" required>
                        </div>
                        <div class="col-md-3">
                            <label for="productName" class="form-label">Name Item</label>
                            <input type="text" class="form-control" id="productName" name="name_item" required>
                        </div>
                        <div class="col-md-2">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" required>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option selected disabled>Select categories</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Motherboard">Motherboard</option>
                                <option value="Processor">Processor</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="col-md-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="col-md-2">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount" required>
                        </div>
                        <div class="col-md-3">
                            <label for="imageUpload" class="form-label">Image</label>
                            <input type="file" class="form-control" id="imageUpload" name="image" required>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product List -->
        <div class="card mb-2">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Product List</h5>
            </div>
            <div class="table-responsive p-3">
                <table id="productTable" class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name Item</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM items");
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['product_id']; ?></td>
                                <td><?= htmlspecialchars($row['name_item']); ?></td>
                                <td><?= htmlspecialchars($row['brand']); ?></td>
                                <td><?= htmlspecialchars($row['category']); ?></td>
                                <td><?= $row['stock']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td><?= $row['discount']; ?></td>
                                <td><img src="<?= $row['image_path']; ?>" alt="Product" width="50"></td>
                                <td>
                                    <button class="btn btn-warning btn-sm editProductBtn" 
                                            data-id="<?= $row['product_id']; ?>" 
                                            data-name="<?= htmlspecialchars($row['name_item']); ?>" 
                                            data-brand="<?= htmlspecialchars($row['brand']); ?>" 
                                            data-category="<?= htmlspecialchars($row['category']); ?>" 
                                            data-stock="<?= $row['stock']; ?>" 
                                            data-price="<?= $row['price']; ?>" 
                                            data-discount="<?= $row['discount']; ?>" 
                                            data-image="<?= $row['image_path']; ?>">
                                        Edit
                                    </button>
                                    <a href="delete.php?delete_id=<?= $row['product_id']; ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                    </a>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="editProductId">
                    <input type="hidden" name="current_image" id="editProductCurrentImage">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Name Item</label>
                        <input type="text" name="name_item" id="editProductName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBrand" class="form-label">Brand</label>
                        <input type="text" name="brand" id="editBrand" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select name="category" id="editCategory" class="form-select" required>
                            <option value="Laptop">Laptop</option>
                            <option value="Motherboard">Motherboard</option>
                            <option value="Processor">Processor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="editStock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" name="price" id="editPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDiscount" class="form-label">Discount</label>
                        <input type="number" name="discount" id="editDiscount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image</label>
                        <input type="file" name="image" id="editImage" class="form-control">
                        <small class="text-muted">Leave blank if you do not wish to change the image</small>
                    </div>
                    <div class="mb-3">
                        <img id="editPreviewImage" src="" alt="Current Image" width="100" class="d-block">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "paginate": {
                    "previous": "&laquo;",
                    "next": "&raquo;"
                },
                "search": "Search:",
                "lengthMenu": "Display _MENU_ members per page"
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editProductBtns = document.querySelectorAll('.editProductBtn');

        editProductBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const productId = btn.getAttribute('data-id');
                const nameItem = btn.getAttribute('data-name');
                const brand = btn.getAttribute('data-brand');
                const category = btn.getAttribute('data-category');
                const stock = btn.getAttribute('data-stock');
                const price = btn.getAttribute('data-price');
                const discount = btn.getAttribute('data-discount');
                const image = btn.getAttribute('data-image');

                document.getElementById('editProductId').value = productId;
                document.getElementById('editProductName').value = nameItem;
                document.getElementById('editBrand').value = brand;
                document.getElementById('editCategory').value = category;
                document.getElementById('editStock').value = stock;
                document.getElementById('editPrice').value = price;
                document.getElementById('editDiscount').value = discount;
                document.getElementById('editProductCurrentImage').value = image;
                document.getElementById('editPreviewImage').src = image;

                const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
                modal.show();
            });
        });
    });
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
