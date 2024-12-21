
<?php
include "config.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>
<div id="content">
            

    <div class="container">
        <div class="row mt-4">
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card py-3 text-center">
                    <h3 class="fw-bold mb-0" style="color: #0d6efd;">Point of Sale (POS)</h3>
                </div>
                
                <div class="row mt-4">
                    <!-- Filter Kategori dan Pencarian -->
                    <div class="col-md-4">
                        <label for="kategori" class="form-label fw-bold">Items</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </span>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <?php
                                include "config.php";
                                // Mengambil daftar kategori unik dari database
                                $kategoriQuery = $conn->query("SELECT DISTINCT category FROM items");
                                while ($row = $kategoriQuery->fetch_assoc()) {
                                    echo "<option value='" . $row['category'] . "'>" . ucfirst($row['category']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="search" class="form-label fw-bold">Search</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="search" placeholder="Cari...">
                        </div>
                    </div>
                </div>

                <!-- Produk yang akan difilter -->
                <div class="row mt-5" id="products-container">
                    <?php
                    // Mengambil semua produk dari database
                    $result = $conn->query("SELECT * FROM items");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                        <div id="product" 
                            class="card col-sm-6 col-md-4 col-lg-3 mb-2 product" 
                            data-diskon="<?= $row['discount']?>" 
                            data-kategori="<?= $row['category']?>" 
                            data-id="<?= $row['product_id']?>" 
                            data-name="<?= $row['name_item']?>" 
                            data-price="<?= $row['price']?>" 
                            data-image="<?= $row['image_path']?>" 
                            style="width: 12rem; margin: 5px; padding: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                            <img src="<?= $row['image_path']?>" 
                                class="card-img-top img-fluid rounded-top" 
                                alt="<?= $row['name_item']?>" 
                                style="margin-top: 5px; height: 160px; object-fit: cover;">
                            <div class="card-body" style="padding: 10px;">
                                <h6 class="card-title" style="font-size: 0.9rem;"><?= $row['name_item']?></h6>
                                <p class="card-text text-muted mb-1" style="font-size: 0.8rem;"><?= $row['category']?></p>
                                <p class="text-primary fw-bold" style="font-size: 0.9rem;">Rp.<?= number_format($row['price'], 0, ',', '.')?></p>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-sm add-to-cart">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>No data available</td></tr>";
                    }
                    ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="right-sidebar bg-white shadow-sm py-4 p-2" style="position: sticky; top: 20px; height: 650px; overflow-y: auto; border-radius:10px; scrollbar-width:none;">
                    <!-- Heading Section -->
                    <h4 class="text-center border-bottom pb-3">Order Details</h4>
                    
                    <!-- Items Section -->
                    <div class="py-2">
                        <p class="fw-bold d-flex justify-content-between">
                            Items 
                            <span id="total-items" class="badge bg-primary">0</span>
                        </p>
                        <div id="detail-cart" class="border rounded p-2" style="min-height: 100px;">
                            <!-- Cart details will be dynamically added here -->
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="card p-3 mt-4">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end" id="total-price">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Tax (5%)</td>
                                    <td class="text-end" id="total-tax">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-end" id="total-discount">Rp 0</td>
                                </tr>
                                <tr class="fw-bold border-top">
                                    <td>Total</td>
                                    <td class="text-end" id="total-with-tax-discount">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100 mt-3" id="checkout">Continue</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

        <!-- Modal untuk memilih atau mengisi member -->
        <!-- Modal untuk memilih member -->
        <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="memberModalLabel">Member Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="memberForm">
                            <div class="mb-3">
                                <label for="memberSearch" class="form-label">ID Member</label>
                                <input type="text" class="form-control" id="memberSearch" name="memberSearch">
                            </div>
                            <button type="button" class="btn btn-success w-100">Tap Member Card</button>
                        </form>
                        <div id="searchResults" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="Skip">Next</button>
                    </div>
                </div>
            </div>
        </div>



<script>
$(document).ready(function () {
    // Kosongkan data cartData dan memberData dari localStorage di awal
    localStorage.removeItem('cartData');
    localStorage.removeItem('memberData');


    // Menambahkan produk ke keranjang saat tombol "Add to Cart" diklik
    $('.add-to-cart').click(function () {
        const $product = $(this).closest('.card');  // Mengambil elemen card yang terdekat
        const product = {
            id: $product.data('id'),
            name: $product.data('name'),
            kategori: $product.data('kategori'),
            price: $product.data('price'),
            image: $product.data('image'),
            discount: parseFloat($product.data('diskon')).toFixed(0),
        };
        addToCart(product);  // Menambahkan produk ke keranjang
    });

    let cart = [];  // Keranjang

    // Fungsi untuk menambahkan produk ke dalam keranjang
    function addToCart(product) {
        const existingProduct = cart.find(item => item.id === product.id);
        if (existingProduct) {
            existingProduct.quantity += 1;  // Jika produk sudah ada, update quantity
        } else {
            cart.push({ ...product, quantity: 1 });  // Jika produk baru, tambahkan ke keranjang
        }
        renderCart();  // Update tampilan keranjang
    }

    // Fungsi untuk mengupdate tampilan keranjang
    function renderCart() {
        const $cartTable = $('#detail-cart');
        $cartTable.empty();  // Mengosongkan keranjang sebelum mengisi ulang
        let totalPrice = 0;  // Variabel untuk menghitung total harga
        let totalDiscount = 0;  // Variabel untuk menghitung total diskon
        let totalTax = 0;  // Variabel untuk menghitung pajak total
        let totalQuantity = 0;  // Jumlah item total

        // Menampilkan setiap item dalam keranjang
        cart.forEach(item => {
            const totalItemPrice = item.price * item.quantity;  // Harga total per item
            const taxPerItem = item.price * 0.05;  // Pajak per item (5% dari harga produk)
            const discountPerItem = item.price * item.discount / 100;  // Diskon per item (misalnya 10%)
            
            const totalItemPriceWithDiscount = totalItemPrice - (discountPerItem * item.quantity);  // Harga setelah diskon
            const totalItemPriceWithTax = totalItemPriceWithDiscount + (taxPerItem * item.quantity);  // Harga setelah pajak

            totalPrice += totalItemPrice;  // Menambahkan harga item ke total harga
            totalDiscount += discountPerItem * item.quantity;  // Menambahkan diskon per item ke total diskon
            totalTax += taxPerItem * item.quantity;  // Menambahkan pajak per item ke total pajak
            totalQuantity += item.quantity;  // Menambahkan jumlah produk ke total quantity

            const row = `
            <div class="cart-product card mt-2 p-3 shadow-sm rounded-3" data-id="${item.id}">
                <div class="d-flex flex-row align-items-center position-relative">
                    <!-- Gambar Produk -->
                    <img src="${item.image}" alt="${item.name}" class="product-image img-fluid rounded-3" style="width: 30px; height: 30px; object-fit: cover;">
                    
                    <!-- Detail Produk -->
                    <div class="product-details ms-3 d-flex flex-column">
                        <p class="product-name mb-1" style="font-size:14px;font-weight:bolder;">${item.name}</p>
                        <p class="product-price mb-0" style="font-size:12px;">${item.kategori}</p>
                    </div>
                    
                    <!-- Tombol Hapus di pojok kanan atas -->
                    <button class="remove-item btn btn-danger btn-sm position-absolute top-0 end-0 p-1" style="font-size: 10px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <!-- Tombol Kuantitas dan Total Price di sebelah kanan -->
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <!-- Tombol Kuantitas -->
                    <div class="quantity-buttons d-flex align-items-center gap-2">
                        <button class="update-quantity btn btn-outline-secondary btn-sm" data-action="decrease" style="font-size: 10px;">-</button>
                        <span class="quantity" style="font-size: 12px;">${item.quantity}</span>
                        <button class="update-quantity btn btn-outline-primary btn-sm" data-action="increase" style="font-size: 10px;">+</button>
                    </div>

                    <!-- Total Price per item -->
                    <p class="total-item-price text-muted mb-0" style="font-size:12px;">Rp ${totalItemPrice}</p>
                </div>
            </div>
            `;
            $cartTable.append(row);
        });

        // Menghitung total keseluruhan
        const totalWithTaxAndDiscount = totalPrice - totalDiscount + totalTax;  // Total setelah diskon dan pajak

        // Menampilkan total harga keseluruhan, pajak, diskon, dan total setelah pajak dan diskon
        $('#total-items').text(`${totalQuantity}`); // Menampilkan jumlah item
        $('#total-price').text(` ${formatRupiah(totalPrice)}`);
        $('#total-tax').text(`${formatRupiah(totalTax)}`);
        $('#total-discount').text(`${formatRupiah(totalDiscount)}`);
        $('#total-with-tax-discount').text(`${formatRupiah(totalWithTaxAndDiscount)}`);
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }

    // Fungsi untuk mengupdate jumlah produk (tambah/kurang)
    $(document).on('click', '.update-quantity', function () {
        const $row = $(this).closest('.cart-product');
        const productId = $row.data('id');
        const action = $(this).data('action');
        const product = cart.find(item => item.id === productId);
        
        if (action === 'increase') {
            product.quantity += 1;  // Menambah kuantitas
        } else if (action === 'decrease' && product.quantity > 1) {
            product.quantity -= 1;  // Mengurangi kuantitas jika lebih dari 1
        }
        renderCart();  // Update tampilan keranjang setelah mengubah quantity
    });

    // Fungsi untuk menghapus item dari keranjang
    $(document).on('click', '.remove-item', function () {
        const productId = $(this).closest('.cart-product').data('id');
        cart = cart.filter(item => item.id !== productId);  // Menghapus produk dari keranjang
        renderCart();  // Update tampilan keranjang setelah menghapus item
    });

    // Fungsi untuk memunculkan modal sebelum checkout
    $('#checkout').click(function () {

        // Cek apakah ada produk di keranjang
        if (cart.length === 0) {
            alert('Keranjang kosong! Silakan tambahkan produk terlebih dahulu.');
            return;  // Jika kosong, hentikan proses checkout
        }
        // Menampilkan modal untuk memilih atau mengisi data member
        $('#memberModal').modal('show');
    });

    // Pencarian member
    $('#memberSearch').on('input', function() {
        var searchQuery = $(this).val();
    
        if (searchQuery.length > 0) {
            $.ajax({
                url: 'get_members.php',
                type: 'GET',
                data: { q: searchQuery },
                success: function(response) {
                    var data = JSON.parse(response);
                    var html = '';
                    if (data.members && data.members.length > 0) {
                        html = '';
                        data.members.forEach(function(member) {
                            html += "<div class='search-item'>";
                            html += "<strong>ID Member:</strong> " + member.id + "<br>";
                            html += "<strong>Nama Member:</strong> " + member.text + "<br>";
                            html += "</div><hr>";
                            var memberData = {
                                id: member.id,
                                name: member.text,
                                email: member.email
                            };
                            localStorage.setItem('memberData', JSON.stringify(memberData));
                        });
                    } else {
                        html = "Tidak ada Member.";
                    }
                    $('#searchResults').html(html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#searchResults').empty();
        }
    });

    // Proses ketika tombol "Skip" diklik
    $('#Skip').click(function () {
        var cartData = cart; // Ambil data cart
        var memberData = JSON.parse(localStorage.getItem('memberData')); // Ambil data member dari localStorage

        // Simpan data cart dan member ke localStorage
        localStorage.setItem('cartData', JSON.stringify(cartData));
        localStorage.setItem('memberData', JSON.stringify(memberData));

        // Redirect ke halaman pembayaran
        window.location.href = 'index.php?page=pembayaran';
    });
});

</script>

<!-- Script untuk filter dan search -->
<script>
    // Ambil elemen filter dan search
    const kategoriSelect = document.getElementById('kategori');
    const searchInput = document.getElementById('search');
    const productsContainer = document.getElementById('products-container');
    
    // Fungsi untuk memfilter produk berdasarkan kategori dan search
    function filterProducts() {
        const kategoriValue = kategoriSelect.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        // Ambil semua produk
        const products = productsContainer.querySelectorAll('.product');

        products.forEach(product => {
            const productName = product.getAttribute('data-name').toLowerCase();
            const productCategory = product.getAttribute('data-kategori').toLowerCase();

            // Cek apakah produk sesuai dengan kategori dan search
            if (
                (kategoriValue === '' || productCategory.includes(kategoriValue)) &&
                (searchValue === '' || productName.includes(searchValue))
            ) {
                product.style.display = 'block';  // Tampilkan produk
            } else {
                product.style.display = 'none';  // Sembunyikan produk
            }
        });
    }

    // Event listener untuk kategori dan search
    kategoriSelect.addEventListener('change', filterProducts);
    searchInput.addEventListener('input', filterProducts);
</script>