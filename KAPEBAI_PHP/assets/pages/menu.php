<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="../css/menu.css">

        <title>Kape Bai Users</title>
    </head>
    <body id="body-pd">
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>

            <div class="header__cart">
                <i class='bx bx-cart-alt cart-toggle-button'></i>
            </div>
            
            <div class="header__img">
                <img src="../img/coffee.jpg" alt="">
            </div>
        </header>

        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a href="#" class="nav__logo">
                        <i class='bx bx-coffee-togo'></i>
                        <span class="nav__logo-name">KAPE BAI</span>
                    </a>

                    <div class="nav__list">
                        <a href="../pages/home.php" class="nav__link ">
                            <i class='bx bx-grid-alt nav__icon' ></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="../pages/manage_product.php" class="nav__link ">
                            <i class='bx bx-package nav__icon' ></i>
                            <span class="nav__name">Manage Product</span>
                        </a>
                        
                        <a href="../pages/menu.php" class="nav__link active">
                            <i class='bx bx-food-menu nav__icon'></i>
                            <span class="nav__name">Menu</span>
                        </a>

                        <a href="../pages/orders.php" class="nav__link">
                            <i class='bx bxs-receipt nav__icon'></i>
                            <span class="nav__name">Orders</span>
                        </a>
                    </div>
                </div>

                <a href="../pages/index.php" class="nav__link">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>

        <!--===== MAIN JS =====-->
        <script src="../js/main.js"></script>
    </head>
<body>
    <div class="menu-category">
        <div class="box-container" id="hot-coffee-button">
            <a class="menu-link">
                <img src="../img/1.png" alt="">
                <button class="category-button" data-category="HOT COFFEE">HOT COFFEE</button>
            </a>
        </div>
        <div class="box-container" id="iced-coffee-button">
            <a class="menu-link">
                <img src="../img/2.png" alt="">
                <button class="category-button" data-category="ICED COFFEE">ICED COFFEE</button>
            </a>
        </div>
        <div class="box-container" id="pastries-button">
            <a class="menu-link">
                <img src="../img/3.png" alt="">
                <button class="category-button" data-category="PASTRIES">PASTRIES</button>
            </a>
        </div>
    </div>
    
<div class="product-container">
    <h1 id="menu-title"></h1>
    <div class="grid-product">
    <?php
    // Retrieve products from the database
    $connection = mysqli_connect("localhost", "root", "", "kapebai_db");
    if($connection) {
        // Check if a specific category is selected
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

        $selectSql = "SELECT * FROM products";
        
        // If a category is selected, filter by that category
        if (!empty($categoryFilter)) {
            $selectSql .= " WHERE category = '$categoryFilter'";
        }

        $result = mysqli_query($connection, $selectSql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="product" data-id="<?php echo $row['id']; ?>" data-quantity="<?php echo $row['quantity']; ?>" data-price="<?php echo $row['price']; ?>" data-category="<?php echo $row['category']; ?>">
                    <div class="product-box">
                        <div class="img-box">
                            <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                        </div>
                        <div class="box-content">
                            <h3><?php echo $row['product_name']; ?></h3>
                            <p>₱<?php echo $row['price']; ?></p>
                            <p>Quantity: <?php echo $row['quantity']; ?></p>
                        </div>   
                    </div>
                    
                    <label for="quantity_<?php echo $row['id']; ?>">Quantity:</label>
                    <input type="number" id="quantity_<?php echo $row['id']; ?>" name="quantity" min="1" max="<?php echo $row['quantity']; ?>" value="1"><br>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        mysqli_close($connection);
    } else {
        echo "<p>Failed to connect to database.</p>";
    }
    ?>
    </div>
    
</div>

<!-- Cart Section -->

<div class="cart-container">
    <h2>Cart</h2>
    <div class="cart-items">
        <!-- Cart items will be added dynamically via JavaScript -->
    </div>
    <label for="customer_name">Customer Full Name</label><br>
    <input type="text" id="customer_name" placeholder="Customer">
    <p>Total Amount: ₱<span id="total-amount">0.00</span></p>
    <button class="place-order-button">Place Order</button>
</div>

<script>
    // JavaScript for toggling cart visibility
    const cartToggleButton = document.querySelector('.cart-toggle-button');
    const cartContainer = document.querySelector('.cart-container');

    cartToggleButton.addEventListener('click', () => {
        cartContainer.classList.toggle('show-cart');
    });

    // Function to update menu title
    function updateMenuTitle(category) {
        menuTitle.textContent = `${category.toUpperCase()} MENU`; // Update menu title
    }

    // Default title
    const menuTitle = document.getElementById('menu-title'); // Define menuTitle here
    updateMenuTitle("All");

    // Filter products by category
    const categoryButtons = document.querySelectorAll('.category-button');
    categoryButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default behavior (page refresh)

            const category = button.dataset.category;
            updateMenuTitle(category); // Update menu title when category button is clicked

            // Remove "menu-active" class from all box-container elements
            document.querySelectorAll('.box-container').forEach(container => {
                container.classList.remove('menu-active');
            });

            // Add "menu-active" class to the parent box-container of the clicked button
            button.closest('.box-container').classList.add('menu-active');

            // Hide all products
            const products = document.querySelectorAll('.product');
            products.forEach(product => {
                product.style.display = "none";
            });

            // Show products of the selected category
            const selectedProducts = document.querySelectorAll(`.product[data-category="${category}"]`);
            selectedProducts.forEach(product => {
                product.style.display = "block";
            });
        });
    });

    // JavaScript for adding products to cart and placing order
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartItemsContainer = document.querySelector('.cart-items');
    const placeOrderButton = document.querySelector('.place-order-button');
    const totalAmountSpan = document.getElementById('total-amount');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const product = button.closest('.product');
            const productId = product.dataset.id;
            const productName = product.querySelector('.box-content h3').textContent;
            const productPrice = parseFloat(product.dataset.price);
            const productQuantityInput = product.querySelector('input[type="number"]');
            const productQuantity = parseFloat(productQuantityInput.value);
            const productImage = product.querySelector('.img-box img').src;

            const existingCartItem = cartItemsContainer.querySelector(`.cart-item[data-id="${productId}"]`);
            if (existingCartItem) {
                const existingQuantity = parseFloat(existingCartItem.querySelector('.item-quantity').textContent.split(':')[1].trim());
                const newQuantity = existingQuantity + productQuantity;
                if (newQuantity <= parseFloat(product.dataset.quantity)) {
                    existingCartItem.querySelector('.item-quantity').textContent = `Quantity: ${newQuantity}`;
                    // Update quantity in the database
                    updateProductQuantity(productId, newQuantity);
                } else {
                    alert(`The product ${productName} only has ${product.dataset.quantity} available.`);
                }
            } else {
                if (productQuantity <= parseFloat(product.dataset.quantity)) {
                    const cartItem = document.createElement('div');
                    cartItem.classList.add('cart-item');
                    cartItem.dataset.id = productId;
                    cartItem.innerHTML = `
                    <img src="${productImage}" alt="${productName}">
                    <div class="item-info">
                        <div>
                            <span class="item-name">${productName}</span>
                            <br>
                            <span class="item-price">₱${productPrice.toFixed(2)}</span>
                        </div>
                        <div>
                            <span class="item-quantity">Quantity: ${productQuantity}</span>
                            <button class="remove-from-cart">Remove</button>
                        </div>
                    </div>
                    `;
                    cartItemsContainer.appendChild(cartItem);
                    // Update quantity in the database
                    updateProductQuantity(productId, productQuantity);
                } else {
                    alert(`The product ${productName} only has ${product.dataset.quantity} available.`);
                }
            }
            updateTotalAmount();
        });
    });

    // Function to handle placing order
    function placeOrder() {
        const customerName = document.getElementById('customer_name').value;
        const cartItems = document.querySelectorAll('.cart-item');
        const orderDetails = [];

        cartItems.forEach(item => {
            const productName = item.querySelector('.item-name').textContent;
            const quantity = parseFloat(item.querySelector('.item-quantity').textContent.split(':')[1].trim());
            const productPrice = parseFloat(item.querySelector('.item-price').textContent.split('₱')[1].trim());
            const totalPrice = productPrice * quantity; // Calculate total price
            orderDetails.push({
                productName: productName,
                quantity: quantity,
                totalPrice: totalPrice
            });
        });

        // Sending order details to the backend for processing and saving to the database
        const formData = new FormData();
        formData.append('customerName', customerName);
        formData.append('orderDetails', JSON.stringify(orderDetails)); // Convert to JSON string

        fetch('place_order.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log('Order placed successfully:', data);
            // Optionally, you can clear the cart and display a success message
        })
        .catch((error) => {
            console.error('Error placing order:', error);
        });
    }


    // Event listener for place order button
    placeOrderButton.addEventListener('click', () => {
        placeOrder();
    });

    // Remove product from cart
    cartItemsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-from-cart')) {
            e.target.closest('.cart-item').remove();
            updateTotalAmount();
        }
    });

    // Function to update total amount in the cart
    function updateTotalAmount() {
        const cartItems = document.querySelectorAll('.cart-item');
        let totalAmount = 0;
        cartItems.forEach(item => {
            const productQuantity = parseFloat(item.querySelector('.item-quantity').textContent.split(':')[1].trim());
            const productPrice = parseFloat(item.querySelector('.item-price').textContent.split('₱')[1].trim());
            totalAmount += productQuantity * productPrice;
        });
        totalAmountSpan.textContent = totalAmount.toFixed(2);
    }

    // Function to update product quantity in the database
    function updateProductQuantity(productId, quantity) {
        const formData = new FormData();
        formData.append('productId', productId);
        formData.append('quantity', quantity);

        fetch('update_quantity.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log('Quantity updated successfully:', data);
        })
        .catch((error) => {
            console.error('Error updating quantity:', error);
        });
    }
</script>
    </body>
</html>
