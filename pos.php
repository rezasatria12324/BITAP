<div id="content">
            
            <div class="container">
                <div class="row">
                    <div class="container custom-border-bottom pb-3">
                        <h2 class="text-title">POS</h2>
                    </div>
                </div>

                <div class="row mt-2 p-2 custom-border-bottom">
                    <div class="col-md-4 d-flex align-items-center">
                        <span style="font-weight: bolder; font-size: 20px; margin-right: 10px;">Items</span>
                        <div class="custom-select-wrapper">
                            <div class="custom-icon-left">
                                <i class="fas fa-filter"></i> <!-- Ikon kiri -->
                            </div>
                            <select name="kategori" id="kategori" class="custom-select form-control">
                                <option value="">Kategori</option>
                                <option value="kategori1">Kategori 1</option>
                                <option value="kategori2">Kategori 2</option>
                                <option value="kategori3">Kategori 3</option>
                            </select>
                            <div class="custom-icon-right">
                                <i class="fas fa-caret-down"></i> <!-- Ikon kanan -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="custom-input-wrapper">
                            <div class="custom-icon-left">
                                <i class="fas fa-search"></i> <!-- Ikon kiri (pencarian) -->
                            </div>
                            <input type="text" class="form-control custom-input" name="cari" placeholder="Cari...">
                        </div>
                    </div>

                </div>

                <div class="row mt-5">
                <?php
                    include "config.php";
                    // Fetch data from the database
                    $result = $conn->query("SELECT * FROM items");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // var_dump($row);
                    ?>
                            <div id="product" class="card col-md-3"  data-diskon="<?= $row['discount']?>" data-kategori="<?= $row['category']?>" data-id="<?= $row['product_id']?>" data-name="<?= $row['name_item']?>" data-price="<?= $row['price']?>" data-image="<?= $row['image_path']?>" style="width: 18rem;margin-right:2px;">
                                <center>
                                    <img style="max-width:200px;" src="<?= $row['image_path']?>" class="card-img-top" alt="...">
                                </center>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $row['name_item']?></h4>
                                    <span class="card-kategori text-secondary"><?= $row['category']?></span><br>
                                    <span class="text-primary">Rp.<?= number_format($row['price'],0,',','.')?></span><br>
                                    <center>
                                        <button  class="btn btn-primary add-to-cart" style="padding-left: 30px;padding-right:30px;">Add</button>
                                    </center>
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
            
        </div>

        <div class="row" style="background-color: white;width:20%;">
            <div class="container">

                <div class="row p-3" style="border-bottom: 1px solid grey;">
                    <h4>Order Details</h4>
                </div>

                <div class="row pt-2">
                    <span><b>Order Details</b></span>
                </div>

                <div class="row mb-5">
                    <span><b>Items</b>  <span id="total-items" class="badge bg-primary"></span></span>

                    <div id="detail-cart">

                    </div>
                </div>

                <div class="row">
                    <div class="container">
                        <div class="card p-3">
                            <div class="row">
                                <table style="width: 100%;font-size:12px;">
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>:Rp</td>
                                        <td id="total-price" style="text-align: right;">0</td>
                                    </tr>
                                    <tr>
                                        <td>Tax 5%</td>
                                        <td>:Rp</td>
                                        <td id="total-tax" style="text-align: right;">0</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>:Rp</td>
                                        <td id="total-discount" style="text-align: right;">0</td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount</td>
                                        <td>:Rp</td>
                                        <td id="total-with-tax-discount" style="text-align: right;">0</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary mt-2" id="checkout" style="width: 100%;">Continue</button>
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
                <h5 class="modal-title" id="memberModalLabel">Have Member ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="memberForm" class="d-flex justify-content-between w-100">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="memberSearch" class="form-label">ID Member</label>
                                <input type="text" class="form-control" id="memberSearch" name="memberSearch">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <div class="mb-3">
                                <label for="memberSearch" class="form-label">&nbsp;</label>
                                <button class="btn btn-sm btn-success">TAP MEMBER CARD</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="searchResults"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="Skip">Skip</button>
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