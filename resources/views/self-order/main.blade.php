<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Self Order System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #666cff;
            --primary-light: #7c81ff;
            --primary-dark: #5a5fe1;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --success: #28a745;
            --danger: #dc3545;
            --border-radius: 8px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: var(--white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .progress-bar {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 120px;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 60px;
            width: 120px;
            height: 2px;
            background-color: #ddd;
            z-index: 1;
        }

        .step.active:not(:last-child)::after {
            background-color: var(--primary-color);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            z-index: 2;
        }

        .step.active .step-circle {
            background-color: var(--primary-color);
        }

        .step-label {
            margin-top: 8px;
            font-size: 0.9rem;
            text-align: center;
        }

        .step-content {
            display: none;
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 25px;
            margin-bottom: 30px;
        }

        .step-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .menu-categories {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .category-btn {
            padding: 10px 20px;
            background-color: var(--light-bg);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .category-btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .menu-item {
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
        }

        .menu-item:hover {
            transform: translateY(-5px);
        }

        .menu-item-image {
            height: 160px;
            background-color: #eee;
            background-size: cover;
            background-position: center;
        }

        .menu-item-content {
            padding: 15px;
        }

        .menu-item-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .menu-item-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
        }

        .menu-item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-item-price {
            font-weight: 700;
            color: var(--primary-color);
        }

        .add-to-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart:hover {
            background-color: var(--primary-dark);
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
            border-radius: var(--border-radius);
            background-color: #eee;
            background-size: cover;
            background-position: center;
            margin-right: 15px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: var(--primary-color);
            font-weight: 600;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity {
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }

        .remove-item {
            color: var(--danger);
            cursor: pointer;
            margin-left: 10px;
        }

        .cart-summary {
            background-color: var(--light-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-total {
            font-weight: 700;
            font-size: 1.2rem;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .payment-method {
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: var(--primary-color);
        }

        .payment-method.active {
            border-color: var(--primary-color);
            background-color: rgba(102, 108, 255, 0.05);
        }

        .payment-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .success-container {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--success);
        }

        .order-number {
            background-color: var(--light-bg);
            padding: 15px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            font-weight: 600;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .empty-cart i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ddd;
        }

        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .step:not(:last-child)::after {
                width: 80px;
                left: 50px;
            }

            .step {
                width: 100px;
            }
        }

        @media (max-width: 576px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            .step:not(:last-child)::after {
                width: 60px;
                left: 40px;
            }

            .step {
                width: 80px;
            }

            .step-label {
                font-size: 0.8rem;
            }
        }


        /* Tambahkan di bagian CSS yang sudah ada */

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    z-index: 1000;
    color: white;
    font-weight: 500;
    max-width: 300px;
    animation: slideIn 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
}

.notification.success {
    background-color: var(--success);
}

.notification.error {
    background-color: var(--danger);
}

.notification.warning {
    background-color: var(--warning);
    color: #333;
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 30px;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow);
}

/* Improved form styling */
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(102, 108, 255, 0.1);
    outline: none;
}

/* Payment method hover effects */
.payment-method {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.payment-method:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.payment-method.active {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(102, 108, 255, 0.05) 0%, rgba(102, 108, 255, 0.1) 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 108, 255, 0.2);
}
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="{{ asset('images/logo/miegacoan.png') }}" alt="Mie Gacoan Logo" style="height:60px; width: auto; display:block; margin:0 auto;">

                </div>
                <div class="cart-icon" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="progress-bar">
            <div class="step active" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Pilih Menu</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Keranjang</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle">3</div>
                <div class="step-label">Pembayaran</div>
            </div>
            <div class="step" data-step="4">
                <div class="step-circle">4</div>
                <div class="step-label">Selesai</div>
            </div>
        </div>

        <!-- Step 1: Menu Selection -->
        <div class="step-content active" id="step1">
            <h2>Pilih Menu Makanan</h2>
            <div class="menu-categories">
                <button class="category-btn active" data-category="all">Semua</button>
                @foreach ($type as $v)
                    <button class="category-btn" data-category="{{ $v->type_desc }}">{{ $v->type_desc }}</button>
                @endforeach

            </div>
            <div class="menu-grid" id="menuGrid">
                <!-- Menu items will be populated by JavaScript -->
            </div>
            <div class="navigation-buttons">
                <div></div> <!-- Empty div for spacing -->
                <button class="btn btn-primary" id="nextToCart">Lanjut ke Keranjang</button>
            </div>
        </div>

        <!-- Step 2: Cart -->
        <div class="step-content" id="step2">
            <h2>Keranjang Belanja</h2>
            <div class="cart-items" id="cartItems">
                <!-- Cart items will be populated by JavaScript -->
            </div>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span id="tax">Rp 0</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span id="total">Rp 0</span>
                </div>
            </div>
            <div class="navigation-buttons">
                <button class="btn" id="backToMenu">Kembali ke Menu</button>
                <button class="btn btn-primary" id="nextToPayment">Lanjut ke Pembayaran</button>
            </div>
        </div>

        <!-- Step 3: Payment -->
        <div class="step-content" id="step3">
            <h2>Metode Pembayaran</h2>
            <div class="payment-methods">
                <div class="payment-method" data-method="cash">
                    <div class="payment-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="payment-name">Tunai</div>
                </div>
                <div class="payment-method" data-method="card">
                    <div class="payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="payment-name">Kartu Kredit/Debit</div>
                </div>
                <div class="payment-method" data-method="qris">
                    <div class="payment-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="payment-name">QRIS</div>
                </div>
                <div class="payment-method" data-method="ewallet">
                    <div class="payment-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="payment-name">E-Wallet</div>
                </div>
            </div>

            <div id="paymentDetails">
                <!-- Payment details will be shown based on selected method -->
            </div>

            <div class="navigation-buttons">
                <button class="btn" id="backToCart">Kembali ke Keranjang</button>
                <button class="btn btn-primary" id="processPayment">Proses Pembayaran</button>
            </div>
        </div>

        <!-- Step 4: Success -->
        <div class="step-content" id="step4">
            <div class="success-container">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="success-title">Pembayaran Berhasil!</h2>
                <p>Terima kasih telah memesan di Restoran Nusantara.</p>
                <p>Pesanan Anda sedang diproses dan akan segera disiapkan.</p>

                <div class="order-number">
                    Nomor Pesanan: <span id="orderNumber">RST-2023-00125</span>
                </div>

                <p>Estimasi waktu penyajian: <strong>15-20 menit</strong></p>

                <button class="btn btn-primary" id="newOrder">Pesan Lagi</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Sample menu data

            const menuItems = {!! json_encode($finish_goods) !!};


            let cart = [];
            let currentStep = 1;
            let selectedPaymentMethod = null;

            // Initialize the menu
            function initializeMenu() {
                const menuGrid = $('#menuGrid');
                menuGrid.empty();

                menuItems.forEach(item => {
                    const menuItem = `
                        <div class="menu-item" data-category="${item.category}">
                            <div class="menu-item-image" style="background-image: url('${item.image}')"></div>
                            <div class="menu-item-content">
                                <div class="menu-item-title">${item.name}</div>
                                <div class="menu-item-description">${item.description}</div>
                                <div class="menu-item-footer">
                                    <div class="menu-item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                                    <button class="add-to-cart" data-id="${item.id}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    menuGrid.append(menuItem);
                });

                // Add event listeners to category buttons
                $('.category-btn').on('click', function() {
                    $('.category-btn').removeClass('active');
                    $(this).addClass('active');

                    const category = $(this).data('category');
                    filterMenu(category);
                });

                // Add event listeners to add to cart buttons
                $('.add-to-cart').on('click', function() {
                    const itemId = parseInt($(this).data('id'));
                    addToCart(itemId);
                });
            }

            // Filter menu by category
            function filterMenu(category) {
                if (category === 'all') {
                    $('.menu-item').show();
                } else {
                    $('.menu-item').hide();
                    $(`.menu-item[data-category="${category}"]`).show();
                }
            }

            // Add item to cart
            function addToCart(itemId) {
                const item = menuItems.find(i => i.id === itemId);
                const existingItem = cart.find(i => i.id === itemId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: item.id,
                        name: item.name,
                        price: item.price,
                        image: item.image,
                        quantity: 1
                    });
                }

                updateCartUI();

                // Show notification
                showNotification(`${item.name} ditambahkan ke keranjang`);
            }

            // Update cart UI
            function updateCartUI() {
                const cartItems = $('#cartItems');
                const cartCount = $('.cart-count');
                const subtotalElement = $('#subtotal');
                const taxElement = $('#tax');
                const totalElement = $('#total');

                // Update cart count
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCount.text(totalItems);

                // Update cart items
                cartItems.empty();

                if (cart.length === 0) {
                    cartItems.html(`
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Keranjang Anda kosong</p>
                        </div>
                    `);
                } else {
                    cart.forEach(item => {
                        const cartItem = `
                            <div class="cart-item">
                                <div class="cart-item-image" style="background-image: url('${item.image}')"></div>
                                <div class="cart-item-details">
                                    <div class="cart-item-title">${item.name}</div>
                                    <div class="cart-item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                                </div>
                                <div class="cart-item-controls">
                                    <button class="quantity-btn decrease" data-id="${item.id}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity">${item.quantity}</span>
                                    <button class="quantity-btn increase" data-id="${item.id}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <div class="remove-item" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                        cartItems.append(cartItem);
                    });

                    // Add event listeners to cart controls
                    $('.increase').on('click', function() {
                        const itemId = parseInt($(this).data('id'));
                        const item = cart.find(i => i.id === itemId);
                        item.quantity += 1;
                        updateCartUI();
                    });

                    $('.decrease').on('click', function() {
                        const itemId = parseInt($(this).data('id'));
                        const item = cart.find(i => i.id === itemId);
                        if (item.quantity > 1) {
                            item.quantity -= 1;
                        } else {
                            cart = cart.filter(i => i.id !== itemId);
                        }
                        updateCartUI();
                    });

                    $('.remove-item').on('click', function() {
                        const itemId = parseInt($(this).data('id'));
                        cart = cart.filter(i => i.id !== itemId);
                        updateCartUI();
                    });
                }

                // Update summary
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const tax = subtotal * 0.1;
                const total = subtotal + tax;

                subtotalElement.text(`Rp ${subtotal.toLocaleString('id-ID')}`);
                taxElement.text(`Rp ${tax.toLocaleString('id-ID')}`);
                totalElement.text(`Rp ${total.toLocaleString('id-ID')}`);
            }

            // Show notification
            // function showNotification(message) {
            //     const notification = $(`
            //         <div class="notification" style="position: fixed; top: 20px; right: 20px; background: var(--success); color: white; padding: 15px 20px; border-radius: var(--border-radius); box-shadow: var(--shadow); z-index: 1000;">
            //             ${message}
            //         </div>
            //     `);

            //     $('body').append(notification);

            //     setTimeout(() => {
            //         notification.fadeOut(300, function() {
            //             $(this).remove();
            //         });
            //     }, 3000);
            // }

            // Show notification dengan styling yang lebih baik
function showNotification(message, type = 'success') {
    const icon = type === 'success' ? 'fa-check-circle' :
                 type === 'error' ? 'fa-exclamation-circle' :
                 'fa-exclamation-triangle';

    const notification = $(`
        <div class="notification ${type}">
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        </div>
    `);

    $('body').append(notification);

    setTimeout(() => {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 4000);
}




            ///////////////

            // Navigate to step
            function goToStep(step) {
                // Update progress bar
                $('.step').removeClass('active');
                $(`.step[data-step="${step}"]`).addClass('active');

                // Update step content
                $('.step-content').removeClass('active');
                $(`#step${step}`).addClass('active');

                currentStep = step;

                // Special handling for step 3 (payment)
                if (step === 3) {
                    initializePaymentMethods();
                }
            }

            // Initialize payment methods
            function initializePaymentMethods() {
                $('.payment-method').on('click', function() {
                    $('.payment-method').removeClass('active');
                    $(this).addClass('active');

                    selectedPaymentMethod = $(this).data('method');
                    showPaymentDetails(selectedPaymentMethod);
                });
            }

            // Show payment details based on selected method
            // function showPaymentDetails(method) {
            //     const paymentDetails = $('#paymentDetails');
            //     paymentDetails.empty();

            //     let detailsHTML = '';

            //     switch(method) {
            //         case 'cash':
            //             detailsHTML = `
            //                 <div class="form-group">
            //                     <label class="form-label">Jumlah Uang Tunai</label>
            //                     <input type="number" class="form-control" id="cashAmount" placeholder="Masukkan jumlah uang">
            //                 </div>
            //                 <div id="cashChange" style="margin-top: 10px; font-weight: 600;"></div>
            //             `;
            //             break;
            //         case 'card':
            //             detailsHTML = `
            //                 <div class="form-group">
            //                     <label class="form-label">Nomor Kartu</label>
            //                     <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
            //                 </div>
            //                 <div class="form-group">
            //                     <label class="form-label">Nama di Kartu</label>
            //                     <input type="text" class="form-control" placeholder="Nama Lengkap">
            //                 </div>
            //                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            //                     <div class="form-group">
            //                         <label class="form-label">Masa Berlaku</label>
            //                         <input type="text" class="form-control" placeholder="MM/YY">
            //                     </div>
            //                     <div class="form-group">
            //                         <label class="form-label">CVV</label>
            //                         <input type="text" class="form-control" placeholder="123">
            //                     </div>
            //                 </div>
            //             `;
            //             break;
            //         case 'qris':
            //             detailsHTML = `
            //                 <div style="text-align: center; padding: 20px;">
            //                     <div style="width: 200px; height: 200px; background: #eee; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
            //                         <i class="fas fa-qrcode" style="font-size: 4rem; color: #666;"></i>
            //                     </div>
            //                     <p style="margin-top: 15px;">Scan QR code di atas untuk melakukan pembayaran</p>
            //                 </div>
            //             `;
            //             break;
            //         case 'ewallet':
            //             detailsHTML = `
            //                 <div class="form-group">
            //                     <label class="form-label">Pilih E-Wallet</label>
            //                     <select class="form-control">
            //                         <option value="">Pilih E-Wallet</option>
            //                         <option value="gopay">GoPay</option>
            //                         <option value="ovo">OVO</option>
            //                         <option value="dana">DANA</option>
            //                         <option value="linkaja">LinkAja</option>
            //                     </select>
            //                 </div>
            //                 <div class="form-group">
            //                     <label class="form-label">Nomor Telepon</label>
            //                     <input type="text" class="form-control" placeholder="08xxxxxxxxxx">
            //                 </div>
            //             `;
            //             break;
            //     }

            //     paymentDetails.html(detailsHTML);

            //     // Add event listener for cash amount input
            //     if (method === 'cash') {
            //         $('#cashAmount').on('input', function() {
            //             const cashAmount = parseFloat($(this).val()) || 0;
            //             const total = getTotalAmount();
            //             const change = cashAmount - total;

            //             if (change >= 0) {
            //                 $('#cashChange').text(`Kembalian: Rp ${change.toLocaleString('id-ID')}`);
            //                 $('#cashChange').css('color', 'var(--success)');
            //             } else {
            //                 $('#cashChange').text(`Uang kurang: Rp ${Math.abs(change).toLocaleString('id-ID')}`);
            //                 $('#cashChange').css('color', 'var(--danger)');
            //             }
            //         });
            //     }
            // }
///////////////////////////////////////////
                function showPaymentDetails(method) {
    const paymentDetails = $('#paymentDetails');
    paymentDetails.empty();

    // Add customer information form dengan styling yang lebih baik
    let detailsHTML = `
        <div class="customer-info-section" style="background: var(--light-bg); padding: 20px; border-radius: var(--border-radius); margin-bottom: 25px;">
            <h4 style="color: var(--primary-color); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user"></i>
                Informasi Customer
            </h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600;">Nama Customer *</label>
                    <input type="text" class="form-control" id="customerName" placeholder="Masukkan nama customer" style="border: 2px solid #e9ecef; transition: all 0.3s;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600;">Nomor Meja *</label>
                    <input type="text" class="form-control" id="tableNumber" placeholder="Contoh: A01, B12" style="border: 2px solid #e9ecef; transition: all 0.3s;">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Nomor Telepon</label>
                <input type="text" class="form-control" id="customerPhone" placeholder="08xxxxxxxxxx (opsional)" style="border: 2px solid #e9ecef; transition: all 0.3s;">
            </div>
        </div>

        <div class="payment-details-section">
            <h4 style="color: var(--primary-color); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-credit-card"></i>
                Detail Pembayaran - ${$('.payment-method.active .payment-name').text()}
            </h4>
    `;

    switch(method) {
        case 'cash':
            detailsHTML += `
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600;">Jumlah Uang Tunai *</label>
                    <input type="number" class="form-control" id="cashAmount"
                           placeholder="Masukkan jumlah uang"
                           style="border: 2px solid #e9ecef; transition: all 0.3s;"
                           min="${getTotalAmount()}">
                    <small class="text-muted" style="font-size: 0.85rem; margin-top: 5px; display: block;">
                        Total yang harus dibayar: <strong>Rp ${getTotalAmount().toLocaleString('id-ID')}</strong>
                    </small>
                </div>
                <div id="cashChange" style="margin-top: 15px; padding: 12px; border-radius: var(--border-radius); font-weight: 600; text-align: center; display: none;"></div>
            `;
            break;
        case 'card':
            detailsHTML += `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 600;">Nomor Kartu *</label>
                        <input type="text" class="form-control" id="cardNumber"
                               placeholder="1234 5678 9012 3456"
                               style="border: 2px solid #e9ecef; transition: all 0.3s;"
                               maxlength="19">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 600;">Nama di Kartu *</label>
                        <input type="text" class="form-control" id="cardName"
                               placeholder="Nama Lengkap"
                               style="border: 2px solid #e9ecef; transition: all 0.3s;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 600;">Masa Berlaku *</label>
                        <input type="text" class="form-control" id="cardExpiry"
                               placeholder="MM/YY"
                               style="border: 2px solid #e9ecef; transition: all 0.3s;"
                               maxlength="5">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 600;">CVV *</label>
                        <input type="text" class="form-control" id="cardCvv"
                               placeholder="123"
                               style="border: 2px solid #e9ecef; transition: all 0.3s;"
                               maxlength="3">
                    </div>
                </div>
            `;
            break;
        case 'qris':
            detailsHTML += `
                <div style="text-align: center; padding: 30px 20px; background: var(--light-bg); border-radius: var(--border-radius);">
                    <div style="width: 220px; height: 220px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 12px; position: relative;">
                        <i class="fas fa-qrcode" style="font-size: 5rem; color: white;"></i>
                        <div style="position: absolute; bottom: 10px; left: 0; right: 0; text-align: center;">
                            <div style="background: white; padding: 5px 10px; border-radius: 20px; display: inline-block;">
                                <small style="color: var(--primary-color); font-weight: 600;">MIE GACOAN</small>
                            </div>
                        </div>
                    </div>
                    <p style="margin-top: 20px; font-size: 1rem; color: #666;">
                        Scan QR code di atas menggunakan aplikasi e-wallet atau mobile banking Anda
                    </p>
                    <div style="background: var(--primary-light); color: white; padding: 10px; border-radius: var(--border-radius); margin-top: 15px;">
                        <small>Total: <strong>Rp ${getTotalAmount().toLocaleString('id-ID')}</strong></small>
                    </div>
                </div>
            `;
            break;
        case 'ewallet':
            detailsHTML += `
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600;">Pilih E-Wallet *</label>
                    <select class="form-control" id="ewalletProvider" style="border: 2px solid #e9ecef; transition: all 0.3s; padding: 12px 15px;">
                        <option value="">Pilih E-Wallet</option>
                        <option value="gopay">GoPay</option>
                        <option value="ovo">OVO</option>
                        <option value="dana">DANA</option>
                        <option value="linkaja">LinkAja</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600;">Nomor Telepon *</label>
                    <input type="text" class="form-control" id="ewalletPhone"
                           placeholder="08xxxxxxxxxx"
                           style="border: 2px solid #e9ecef; transition: all 0.3s;">
                </div>
                <div style="background: var(--light-bg); padding: 15px; border-radius: var(--border-radius); margin-top: 15px;">
                    <small class="text-muted">
                        <i class="fas fa-info-circle" style="color: var(--primary-color);"></i>
                        Pastikan nomor telepon terdaftar di e-wallet yang dipilih
                    </small>
                </div>
            `;
            break;
    }

    detailsHTML += `</div>`;
    paymentDetails.html(detailsHTML);

    // Add focus effects untuk input fields
    $('.form-control').on('focus', function() {
        $(this).css('border-color', 'var(--primary-color)');
        $(this).css('box-shadow', '0 0 0 2px rgba(102, 108, 255, 0.1)');
    }).on('blur', function() {
        $(this).css('border-color', '#e9ecef');
        $(this).css('box-shadow', 'none');
    });

    // Format card number
    if (method === 'card') {
        $('#cardNumber').on('input', function() {
            let value = $(this).val().replace(/\s/g, '').replace(/(\d{4})/g, '$1 ').trim();
            $(this).val(value.substring(0, 19));
        });

        $('#cardExpiry').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            $(this).val(value.substring(0, 5));
        });

        $('#cardCvv').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, '').substring(0, 3));
        });
    }

    // Add event listener for cash amount input
    if (method === 'cash') {
        $('#cashAmount').on('input', function() {
            const cashAmount = parseFloat($(this).val()) || 0;
            const total = getTotalAmount();
            const change = cashAmount - total;
            const $changeElement = $('#cashChange');

            if (cashAmount > 0) {
                $changeElement.show();
                if (change >= 0) {
                    $changeElement.html(`
                        <div style="background: var(--success); color: white; padding: 12px; border-radius: var(--border-radius);">
                            <i class="fas fa-check-circle"></i>
                            Kembalian: <strong>Rp ${change.toLocaleString('id-ID')}</strong>
                        </div>
                    `);
                } else {
                    $changeElement.html(`
                        <div style="background: var(--danger); color: white; padding: 12px; border-radius: var(--border-radius);">
                            <i class="fas fa-exclamation-circle"></i>
                            Uang kurang: <strong>Rp ${Math.abs(change).toLocaleString('id-ID')}</strong>
                        </div>
                    `);
                }
            } else {
                $changeElement.hide();
            }
        });
    }
}



            //////////////////////////////////////
            // Get subtotal amount
            function getSubtotalAmount() {
                return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            }

            // Get tax amount
            function getTaxAmount() {
                return getSubtotalAmount() * 0.1;
            }

            // Get total amount
            function getTotalAmount() {
                return getSubtotalAmount() + getTaxAmount();
            }

            // Get total amount
            function getTotalAmount() {
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const tax = subtotal * 0.1;
                return subtotal + tax;
            }

            // Generate random order number
            function generateOrderNumber() {
                const prefix = 'RST';
                const year = new Date().getFullYear();
                const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                return `${prefix}-${year}-${randomNum}`;
            }

            // Initialize event listeners
            function initializeEventListeners() {
                // Navigation buttons
                $('#nextToCart').on('click', function() {
                    if (cart.length === 0) {
                        showNotification('Keranjang masih kosong. Silakan tambahkan item terlebih dahulu.');
                        return;
                    }
                    goToStep(2);
                });

                $('#backToMenu').on('click', function() {
                    goToStep(1);
                });

                $('#nextToPayment').on('click', function() {
                    goToStep(3);
                });

                $('#backToCart').on('click', function() {
                    goToStep(2);
                });



                // $('#processPayment').on('click', function() {
                //     if (!selectedPaymentMethod) {
                //         showNotification('Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
                //         return;
                //     }

                //     // Validate payment details based on method
                //     let paymentData = {};
                //     let isValid = true;

                //     if (selectedPaymentMethod === 'cash') {
                //         const cashAmount = parseFloat($('#cashAmount').val()) || 0;
                //         const total = getTotalAmount();

                //         if (cashAmount < total) {
                //             showNotification('Jumlah uang tunai kurang dari total pembayaran.', 'error');
                //             isValid = false;
                //             return;
                //         }

                //         paymentData = {
                //             cash_amount: cashAmount,
                //             change: cashAmount - total
                //         };
                //     } else if (selectedPaymentMethod === 'card') {
                //         const cardNumber = $('#cardNumber').val();
                //         const cardName = $('#cardName').val();
                //         const cardExpiry = $('#cardExpiry').val();
                //         const cardCvv = $('#cardCvv').val();

                //         if (!cardNumber || !cardName || !cardExpiry || !cardCvv) {
                //             showNotification('Silakan lengkapi data kartu kredit/debit.', 'error');
                //             isValid = false;
                //             return;
                //         }

                //         paymentData = {
                //             card_number: cardNumber.replace(/\s/g, '').substring(-4),
                //             card_name: cardName,
                //             card_expiry: cardExpiry,
                //             // Note: CVV tidak disimpan di database untuk keamanan
                //         };
                //     } else if (selectedPaymentMethod === 'qris') {
                //         paymentData = {
                //             qris_data: 'QRIS_PAYMENT_' + Date.now()
                //         };
                //     } else if (selectedPaymentMethod === 'ewallet') {
                //         const provider = $('#ewalletProvider').val();
                //         const phone = $('#ewalletPhone').val();

                //         if (!provider || !phone) {
                //             showNotification('Silakan lengkapi data e-wallet.', 'error');
                //             isValid = false;
                //             return;
                //         }

                //         paymentData = {
                //             provider: provider,
                //             phone: phone
                //         };
                //     }

                //     if (!isValid) return;

                //     // Show loading
                //     const $button = $(this);
                //     const originalText = $button.html();
                //     $button.html('<div class="spinner" style="width: 20px; height: 20px; margin: 0 auto;"></div>');
                //     $button.prop('disabled', true);

                //     // Prepare order data for backend
                //     const orderData = {
                //         items: cart.map(item => ({
                //             product_id: item.id,
                //             product_name: item.name,
                //             quantity: item.quantity,
                //             price: item.price,
                //             subtotal: item.price * item.quantity
                //         })),
                //         subtotal: getSubtotalAmount(),
                //         tax: getTaxAmount(),
                //         total: getTotalAmount(),
                //         payment_method: selectedPaymentMethod,
                //         payment_details: paymentData,
                //         order_number: generateOrderNumber(),
                //         customer_name: $('#customerName').val() || 'Customer Self-Order',
                //         customer_phone: $('#customerPhone').val() || '',
                //         table_number: $('#tableNumber').val() || '01'
                //     };

                //     // Send order to Laravel backend
                //     $.ajax({
                //         url: '/self-order',
                //         method: 'POST',
                //         contentType: 'application/json',
                //         data: JSON.stringify(orderData),
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         },
                //         success: function(response) {
                //             if (response.success) {
                //                 // Update order number in UI
                //                 $('#orderNumber').text(response.order_number);

                //                 // Move to success step
                //                 setTimeout(() => {
                //                     goToStep(4);
                //                     $button.html(originalText);
                //                     $button.prop('disabled', false);
                //                 }, 1000);

                //                 showNotification('Pembayaran berhasil! Pesanan sedang diproses.', 'success');
                //             } else {
                //                 throw new Error(response.message || 'Terjadi kesalahan');
                //             }
                //         },
                //         error: function(xhr, status, error) {
                //             console.error('Error submitting order:', error);

                //             let errorMessage = 'Gagal memproses pesanan. Silakan coba lagi.';
                //             if (xhr.responseJSON && xhr.responseJSON.message) {
                //                 errorMessage = xhr.responseJSON.message;
                //             }

                //             showNotification(errorMessage, 'error');
                //             $button.html(originalText);
                //             $button.prop('disabled', false);
                //         }
                //     });
                // });
$('#processPayment').on('click', function() {
    if (!selectedPaymentMethod) {
        showNotification('Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
        return;
    }

    // Validate customer information
    const customerName = $('#customerName').val()?.trim();
    const tableNumber = $('#tableNumber').val()?.trim();

    if (!customerName) {
        showNotification('Silakan masukkan nama customer.', 'error');
        return;
    }

    if (!tableNumber) {
        showNotification('Silakan masukkan nomor meja.', 'error');
        return;
    }

    // Validate payment details based on method
    let paymentData = {};
    let isValid = true;

    if (selectedPaymentMethod === 'cash') {
        const cashAmount = parseFloat($('#cashAmount').val()) || 0;
        const total = getTotalAmount();

        if (cashAmount < total) {
            showNotification('Jumlah uang tunai kurang dari total pembayaran.', 'error');
            isValid = false;
            return;
        }

        paymentData = {
            cash_amount: cashAmount,
            change: cashAmount - total
        };
    } else if (selectedPaymentMethod === 'card') {
        const cardNumber = $('#cardNumber').val();
        const cardName = $('#cardName').val();
        const cardExpiry = $('#cardExpiry').val();
        const cardCvv = $('#cardCvv').val();

        if (!cardNumber || !cardName || !cardExpiry || !cardCvv) {
            showNotification('Silakan lengkapi data kartu kredit/debit.', 'error');
            isValid = false;
            return;
        }

        paymentData = {
            card_number: cardNumber.replace(/\s/g, '').slice(-4), // Ambil 4 digit terakhir
            card_name: cardName,
            card_expiry: cardExpiry,
        };
    } else if (selectedPaymentMethod === 'qris') {
        paymentData = {
            qris_data: 'QRIS_PAYMENT_' + Date.now()
        };
    } else if (selectedPaymentMethod === 'ewallet') {
        const provider = $('#ewalletProvider').val();
        const phone = $('#ewalletPhone').val();

        if (!provider || !phone) {
            showNotification('Silakan lengkapi data e-wallet.', 'error');
            isValid = false;
            return;
        }

        paymentData = {
            provider: provider,
            phone: phone
        };
    }

    if (!isValid) return;

    // Show loading
    const $button = $(this);
    const originalText = $button.html();
    $button.html('<div class="spinner" style="width: 20px; height: 20px; margin: 0 auto;"></div>');
    $button.prop('disabled', true);

    // Prepare order data for backend - SESUAI DENGAN STRUCTURE BACKEND LARAVEL
    const orderData = {
        items: cart.map(item => ({
            product_id: item.id,
            product_name: item.name,
            quantity: item.quantity,
            price: item.price
        })),
        subtotal: getSubtotalAmount(),
        tax: getTaxAmount(),
        total: getTotalAmount(),
        payment_method: selectedPaymentMethod,
        payment_details: paymentData,
        customer_name: customerName,
        customer_phone: $('#customerPhone').val()?.trim() || '',
        table_number: tableNumber,
        trans_date: new Date().toISOString().split('T')[0] // Format YYYY-MM-DD
    };

    console.log('Sending order data:', orderData); // Untuk debugging

    // Send order to Laravel backend
    $.ajax({
        url: '/self-order', // Pastikan route ini sesuai
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(orderData),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Response from server:', response); // Untuk debugging

            // SESUAIKAN DENGAN RESPONSE BACKEND LARAVEL
            if (response.response_code === 200) {
                // Update order number in UI - ambil dari trans_no
                const orderNumber = response.data?.trans_no || generateOrderNumber();
                $('#orderNumber').text(orderNumber);

                // Move to success step
                setTimeout(() => {
                    goToStep(4);
                    $button.html(originalText);
                    $button.prop('disabled', false);
                }, 1000);

                showNotification(response.message || 'Pembayaran berhasil! Pesanan sedang diproses.', 'success');
            } else {
                throw new Error(response.message || 'Terjadi kesalahan pada server');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error submitting order:', error);
            console.log('XHR response:', xhr.responseJSON); // Untuk debugging

            let errorMessage = 'Gagal memproses pesanan. Silakan coba lagi.';

            if (xhr.responseJSON) {
                // Handle Laravel validation errors
                if (xhr.responseJSON.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0];
                    errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                } else if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
            }

            showNotification(errorMessage, 'error');
            $button.html(originalText);
            $button.prop('disabled', false);
        }
    });
});

                ///////////////////////////////////

                $('#newOrder').on('click', function() {
                    // Reset cart and go back to step 1
                    cart = [];
                    updateCartUI();
                    goToStep(1);
                });

                // Cart icon click
                $('#cartIcon').on('click', function() {
                    goToStep(2);
                });
            }

            // Initialize the application
            function init() {
                initializeMenu();
                updateCartUI();
                initializeEventListeners();
            }

            // Start the application
            init();
        });
    </script>
</body>
</html>
