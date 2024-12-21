<style>
    body {
        background-color: #f8f9fa; /* Warna latar belakang yang lebih terang */
    }

    .custom-border-bottom {
        border-bottom: 2px solid #007bff; /* Garis bawah yang lebih tebal */
    }

    .text-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff; /* Warna judul */
    }

    .card {
        border-radius: 10px; /* Sudut yang lebih halus */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
    }

    .member-info p {
        margin: 0;
        padding: 0;
        font-size: 0.9rem; /* Ukuran font yang lebih kecil */
    }

    .cart-item {
        background-color: #ffffff; /* Latar belakang item keranjang */
        border-radius: 5px; /* Sudut yang lebih halus */
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
    }

    .cart-item p {
        margin: 0;
        padding: 0;
        font-size: 0.9rem; /* Ukuran font yang lebih kecil */
    }

    .btn-success {
        background-color: #007bff; 
        border: none; /* Menghilangkan border */
        border-radius: 5px; /* Sudut yang lebih halus */
        padding: 10px 20px; /* Jarak antara teks dan border */
    }

    .btn-success:hover {
        background-color: #003bff; 
    }

    .form-group label {
        font-weight: bold; /* Label yang lebih tebal */
    }

    .total-summary {
        background-color: #e9ecef; /* Latar belakang ringkasan total */
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .total-summary div {
        font-size: 1rem; /* Ukuran font yang lebih besar */
    }
</style>

<div id="content" style="width: 100%;"> 
    <div class="container">
        <div class="row">
            <div class="container custom-border-bottom pb-3">
                <h2 class="text-title">Payment</h2>
            </div>
        </div>
        <div class="row mt-3">
            <div class="card mt-2 mb-5">
                <div class="container">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card m-5 p-3">
                                    <h6><strong>Customer Information</strong></h6>
                                    <div id="member-info" class="member-info">
                                        <p><strong>ID:</strong> <span id="member-id"></span></p>
                                        <p><strong>Name:</strong> <span id="member-name"></span></p>
                                    </div>
                                    <h6>Transaction Detail</h6>
                                    <div id="cart-items"></div>
                                    <div id="cart-summary" class="total-summary">
                                        <div><strong>Total Items:</strong> <span id="total-items" class="float-end">0</span></div>
                                        <div><strong>SubTotal:</strong> <span id="total-item-price" class="float-end">Rp 0</span></div>
                                        <div><strong>Total Tax (5%):</strong> <span id="total-tax" class="float-end">Rp 0</span></div>
                                        <div><strong>Discount (Product):</strong> <span id="total-discount" class="float-end">Rp 0</span></div>
                                        <div><strong>Member Discount (5%):</strong> <span id="total-member-discount" class="float-end">Rp 0</span></div>
                                        <div><strong>Total:</strong> <span id="total-with-tax" class="float-end">Rp 0</span></div>
                                        <div><strong>Pembayaran:</strong> <span id="pembayaran" class="float-end">Rp 0</span></div>
                                        <div><strong>Kembalian:</strong></strong> <span id="kembalian" class="float-end">Rp 0</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card m-5 p-3">
                                    <div class="form-group">
                                        <label for="amount">Input Bayar</label>
                                        <input type="number" class="amount form-control" id="amount" name="amount" placeholder="Masukkan jumlah bayar" min="0">
                                    </div><br>
                                    <button id="btn-pay" class="btn btn-sm btn-success fs-5">Transaksi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="paymentData"></div>
    </div>
</div>

<script>
    // Ambil data member dan data keranjang dari localStorage
    var memberData = JSON.parse(localStorage.getItem('memberData'));
    var cartData = JSON.parse(localStorage.getItem('cartData'));

    // Menampilkan informasi member jika ada
    if (memberData) {
        document.getElementById('member-id').textContent = memberData.id || "Not available";
        document.getElementById('member-name').textContent = memberData.name || "Not available";
    } else {
        document.getElementById('member-info').innerHTML = "<p>No member data available.</p>";
    }

    // Jika ada data keranjang, proses dan tampilkan
    if (cartData && cartData.length > 0) {
        var cartItemsContainer = document.getElementById('cart-items');
        let totalItems = 0; 
        let totalPriceBeforeDiscount = 0;
        let totalDiscount = 0;
        let totalPriceAfterDiscount = 0;
        let memberDiscount = 0;

        // Proses tiap item dalam keranjang
        cartData.forEach(function(item) {
            var discountPerItem = (item.price * item.discount / 100) * item.quantity;
            var priceAfterDiscount = item.price * item.quantity - discountPerItem;

            totalPriceBeforeDiscount += item.price * item.quantity;
            totalDiscount += discountPerItem;
            totalPriceAfterDiscount += priceAfterDiscount;

            // Buat elemen HTML untuk setiap item
            var itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item', 'p-2', 'mb-2', 'border-bottom');
            itemDiv.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div class="product-info">
                        <p><strong>${item.name}</strong></p>
                        <p>Rp ${formatRupiah(item.price)}</p>
                    </div>
                    <div class="product-total">
                        <p>X${item.quantity}</p>
                    </div>
                </div>
            `;
            cartItemsContainer.appendChild(itemDiv);

            totalItems += item.quantity;
        });

        // Hitung pajak dan diskon untuk member
        var totalTax = totalPriceBeforeDiscount * 0.05; // Pajak 5%
        if (memberData) {
            memberDiscount = totalPriceBeforeDiscount * 0.05; // Diskon 5% untuk member
        }

        const totalAfterMemberDiscount = totalPriceAfterDiscount - memberDiscount;
        const totalWithTax = totalAfterMemberDiscount + totalTax;

        // Tampilkan data total
        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('total-item-price').textContent = "Rp " + formatRupiah(totalPriceBeforeDiscount);
        document.getElementById('total-discount').textContent = "Rp " + formatRupiah(totalDiscount);
        document.getElementById('total-member-discount').textContent = "Rp " + formatRupiah(memberDiscount);
        document.getElementById('total-tax').textContent = "Rp " + formatRupiah(totalTax);
        document.getElementById('total-with-tax').textContent = "Rp " + formatRupiah(totalWithTax);

        // Kalkulasi pembayaran dan kembalian
        document.getElementById('amount').addEventListener('input', function() {
            var amount = parseFloat(this.value) || 0;
            var change = amount - totalWithTax; 
            document.getElementById('pembayaran').textContent = "Rp " + formatRupiah(amount);
            document.getElementById('kembalian').textContent = "Rp " + formatRupiah(change);
        });

    } else {
        // Tampilkan pesan jika keranjang kosong
        document.getElementById('cart-info').innerHTML = "<p>Your cart is empty.</p>";
    }

    // Tombol bayar
    $('#btn-pay').click(function() {
        const cartData = JSON.parse(localStorage.getItem('cartData'));  
        const memberData = JSON.parse(localStorage.getItem('memberData')); 

        const totalQuantity = $('#total-items').text();  
        const totalItemPrice = $('#total-item-price').text();  
        const totalTax = $('#total-tax').text();  
        const totalDiscount = $('#total-discount').text();  
        const totalMemberDiscount = $('#total-member-discount').text();  
        const totalWithTax = $('#total-with-tax').text();  
        const pembayaran = $('#pembayaran').text();  
        const kembalian = $('#kembalian').text();  

        const dataToSend = {
            totalQuantity: totalQuantity,
            totalPrice: parseFloat(totalItemPrice.replace('Rp ', '').replace('.', '').trim()),  
            totalTax: parseFloat(totalTax.replace('Rp ', '').replace('.', '').trim()),  
            totalDiscount: parseFloat(totalDiscount.replace('Rp ', '').replace('.', '').trim()),  
            totalMemberDiscount: parseFloat(totalMemberDiscount.replace('Rp ', '').replace('.', '').trim()),  
            totalWithTaxAndDiscount: parseFloat(totalWithTax.replace('Rp ', '').replace('.', '').trim()),  
            pembayaran: parseFloat(pembayaran.replace('Rp ', '').replace('.', '').trim()),  
            kembalian: parseFloat(kembalian.replace('Rp ', '').replace('.', '').trim()),  
            member: memberData,
            cartItems: cartData.map(item => ({
                id: item.id,
                name: item.name,
                kategori: item.kategori,
                price: item.price,
                quantity: item.quantity,
                discount: item.discount,
                image: item.image
            }))
        };

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: 'transaksiProses.php', 
            type: 'POST',                    
            data: dataToSend,                  
            success: function(response) {
                alert('Transaksi berhasil disimpan!');
                localStorage.removeItem('cartData');
                localStorage.removeItem('memberData'); 
                window.location.href = "index.php?page=pos";
            },
            error: function(xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
                alert('Gagal menyimpan transaksi. Silakan coba lagi.');
            }
        });
    });

    // Format angka ke format Rupiah
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }
</script>
