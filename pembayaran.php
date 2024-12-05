<style>
    .cart-item p {
        margin: 0;
        padding: 0;
    }

    .member-info p {
        margin: 0;
        padding: 0;
    }
</style>

<div id="content" style="width: 100%;"> 
    <div class="container">
        <div class="row">
            <div class="container custom-border-bottom pb-3">
                <h2 class="text-title">Payment</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="card mt-2 mb-5">
                <div class="container">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card m-5 p-2">
                                    <h6><strong>Customer Information</strong></h6>
                                    <div id="member-info" class="member-info">
                                        <p><strong>ID:</strong> <span id="member-id"></span></p>
                                        <p><strong>Name:</strong> <span id="member-name"></span></p>
                                    </div>
                                    <h6>Transaction Detail</h6>
                                    <div id="cart-items"></div>
                                    <div id="cart-summary" class="mt-3">
                                        <div><strong>Total Items:</strong> <span id="total-items" class="float-end">0</span></div>
                                        <div><strong>SubTotal:</strong> <span id="total-item-price" class="float-end">Rp 0</span></div>
                                        <div><strong>Total Tax (5%):</strong> <span id="total-tax" class="float-end">Rp 0</span></div>
                                        <div><strong>Discount (Product):</strong> <span id="total-discount" class="float-end">Rp 0</span></div>
                                        <div><strong>Member Discount (5%):</strong> <span id="total-member-discount" class="float-end">Rp 0</span></div>
                                        <div><strong>Total:</strong> <span id="total-with-tax" class="float-end">Rp 0</span></div>
                                        <div><strong>Pembayaran:</strong> <span id="pembayaran" class="float-end">Rp 0</span></div>
                                        <div><strong>Kembalian:</strong> <span id="kembalian" class="float-end">Rp 0</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card m-5 p-2">
                                    <div class="form-group">
                                        <label for="amount">Input Bayar</label>
                                        <input type="number" class="amount form-control" id="amount" name="amount" placeholder="Masukkan jumlah bayar" min="0">
                                    </div><br>
                                    <button id="btn-pay" class="btn btn-sm btn-success">Transaksi</button>
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
    var memberData = JSON.parse(localStorage.getItem('memberData'));
    var cartData = JSON.parse(localStorage.getItem('cartData'));

    if (memberData) {
        document.getElementById('member-id').textContent = memberData.id || "Not available";
        document.getElementById('member-name').textContent = memberData.name || "Not available";
    } else {
        document.getElementById('member-info').innerHTML = "<p>No member data available.</p>";
    }

    if (cartData && cartData.length > 0) {
        var cartItemsContainer = document.getElementById('cart-items');
        let totalItems = 0; 
        let totalPriceBeforeDiscount = 0;
        let totalDiscount = 0;
        let totalPriceAfterDiscount = 0;
        let memberDiscount = 0;

        cartData.forEach(function(item) {
            var discountPerItem = (item.price * item.discount / 100) * item.quantity;
            var priceAfterDiscount = item.price * item.quantity - discountPerItem;

            totalPriceBeforeDiscount += item.price * item.quantity;
            totalDiscount += discountPerItem;
            totalPriceAfterDiscount += priceAfterDiscount;

            var itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item');
            itemDiv.classList.add('p-2');
            itemDiv.classList.add('mb-2');
            itemDiv.classList.add('border-bottom');
            
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

        var totalTax = totalPriceBeforeDiscount * 0.05; 

        if (memberData) {
            memberDiscount = totalPriceBeforeDiscount * 0.05;
        }

        const totalAfterMemberDiscount = totalPriceAfterDiscount - memberDiscount;
        const totalWithTax = totalAfterMemberDiscount + totalTax;

        // Update the UI
        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('total-item-price').textContent = "Rp " + formatRupiah(totalPriceBeforeDiscount);
        document.getElementById('total-discount').textContent = "Rp " + formatRupiah(totalDiscount);
        document.getElementById('total-member-discount').textContent = "Rp " + formatRupiah(memberDiscount);
        document.getElementById('total-tax').textContent = "Rp " + formatRupiah(totalTax);
        document.getElementById('total-with-tax').textContent = "Rp " + formatRupiah(totalWithTax);

        document.getElementById('amount').addEventListener('input', function() {
            var amount = this.value || 0;
            var change = amount - totalWithTax; 
            document.getElementById('pembayaran').textContent = "Rp " + formatRupiah(amount);
            document.getElementById('kembalian').textContent = change < 0 ? "Rp " + formatRupiah(change) : "Rp " + formatRupiah(change);
        });

    } else {
        document.getElementById('cart-info').innerHTML = "<p>Your cart is empty.</p>";
    }

    
    $('#btn-pay').click(function() {
        const cartData = JSON.parse(localStorage.getItem('cartData'));  // Mendapatkan data keranjang belanja
        const memberData = JSON.parse(localStorage.getItem('memberData')); // Mendapatkan data member
    

        // Mengambil data dari elemen-elemen HTML
        const totalQuantity = $('#total-items').text();  // Jumlah item
        const totalItemPrice = $('#total-item-price').text();  // Subtotal
        const totalTax = $('#total-tax').text();  // Pajak
        const totalDiscount = $('#total-discount').text();  // Diskon produk
        const totalMemberDiscount = $('#total-member-discount').text();  // Diskon member
        const totalWithTax = $('#total-with-tax').text();  // Total dengan pajak
        const pembayaran = $('#pembayaran').text();  // Pembayaran
        const kembalian = $('#kembalian').text();  // Kembalian

        // Menyusun data yang akan dikirim melalui AJAX
        const dataToSend = {
            // Data transaksi
            totalQuantity: totalQuantity,
            totalPrice: parseFloat(totalItemPrice.replace('Rp ', '').replace('.', '').trim()),  // Menghapus format 'Rp' dan titik untuk parsing
            totalTax: parseFloat(totalTax.replace('Rp ', '').replace('.', '').trim()),  // Parsing menjadi angka
            totalDiscount: parseFloat(totalDiscount.replace('Rp ', '').replace('.', '').trim()),  // Parsing diskon produk
            totalMemberDiscount: parseFloat(totalMemberDiscount.replace('Rp ', '').replace('.', '').trim()),  // Parsing diskon member
            totalWithTaxAndDiscount: parseFloat(totalWithTax.replace('Rp ', '').replace('.', '').trim()),  // Total setelah pajak dan diskon
            pembayaran: parseFloat(pembayaran.replace('Rp ', '').replace('.', '').trim()),  // Pembayaran
            kembalian: parseFloat(kembalian.replace('Rp ', '').replace('.', '').trim()),  // Kembalian

            // Data member (jika ada)
            member: memberData,

            // Data keranjang belanja (cartData)
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

        // Mengubah data menjadi format URL encoded
        const formData = $.param(dataToSend);

        // AJAX request untuk mengirim data ke server
        $.ajax({
            url: 'transaksiProses.php', // Ganti dengan URL endpoint server kamu
            type: 'POST',                    // Menggunakan metode POST
            data: formData,                  // Data yang dikirim (dalam format x-www-form-urlencoded)
            success: function(response) {
                alert('Transaksi berhasil disimpan!');
                localStorage.removeItem('cartData');
                localStorage.removeItem('memberData'); // Jika ingin menghapus data member juga
                window.location.href = "index.php?page=pos";
            },
            error: function(xhr, status, error) {
                // Menampilkan pesan error jika terjadi kegagalan
                console.error('Terjadi kesalahan:', error);
                alert('Gagal menyimpan transaksi. Silakan coba lagi.');
            }
        });
    });


    
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }
</script>
