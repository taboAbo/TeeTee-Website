<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Necklaces Admin - Tee Tee Jewellery</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product {
            width: 300px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
        .price {
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h1>All Products - Admin Panel</h1>
    <nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</header>

<!-- Products Section for Admin -->
<section class="product-category">
    <h2>All Products</h2>
    <div class="product-grid" id="product-grid">
        <!-- Products will be dynamically added here -->
    </div>
</section>

<!-- Admin Price Update Form -->
<div id="admin-panel">
    <h2>Price Update</h2>
    <div id="price-update-form"></div>
</div>

<footer>
    <div class="footer-links">
        <a href="terms.html">Terms of Service</a>
        <a href="privacy.html">Privacy Policy</a>
    </div>
    <p>&copy; 2024 Tee Tee Jewellery. All rights reserved.</p>
</footer>

<script>
    const products = [
        //mens necklace
        { id: 1, category: 'men', name: 'Silver Africa Necklace', price: 250, image: 'Tee tee website/africasilvermennecklace.jpg' },
        { id: 2, category: 'men', name: 'Gold Africa Necklace', price: 350, image: 'Tee tee website/goldafricanecklacemen.jpg' },
        { id: 3, category: 'men', name: 'Gold Hand Necklace', price: 350, image: 'Tee tee website/goldhandmennecklace.jpg' },
        { id: 4, category: 'men', name: 'Silver Cross Necklace', price: 300, image: 'Tee tee website/silvercross mennecklace.jpg' },
        { id: 5, category: 'men', name: 'Gold Cross Necklace', price: 300, image: 'Tee tee website/goldcrossmennecklace.jpg' },
        // Women's necklaces
        { id: 6, category: 'women', name: 'Gold Africa Necklace', price: 250, image: 'Tee tee website/africanecklacegoldwomen.jpg' },
        { id: 7, category: 'women', name: 'Rose Gold Flower Necklace', price: 150, image: 'Tee tee website/flower gold necklace women.jpg' },
        { id: 8, category: 'women', name: 'Silver Flower Necklace', price: 200, image: 'Tee tee website/flowersilver necklace women.jpg' },
        { id: 9, category: 'women', name: 'Gold Moon Necklace', price: 200, image: 'Tee tee website/goldmoon women necklace.jpg' },
        { id: 10, category: 'women', name: 'Gold Circle Necklace', price: 250, image: 'Tee tee website/goldcircle women necklace.jpg' },
        { id: 11, category: 'women', name: 'Gold Flower Necklace', price: 200, image: 'Tee tee website/goldFlowernecklace.jpg' },
        { id: 12, category: 'women', name: 'Silver Heart Necklace', price: 150, image: 'Tee tee website/heart women necklace.jpg' },
        { id: 13, category: 'women', name: 'Infinity Necklace', price: 250, image: 'Tee tee website/infinitysilverwomen.jpg' },
        { id: 14, category: 'women', name: 'Silver Moon Necklace', price: 250, image: 'Tee tee website/moonsilverwomennecklace.jpg' },
        { id: 15, category: 'women', name: 'Silver Cross Necklace', price: 150, image: 'Tee tee website/silvernecklacewomendiamons.jpg' },
    ];

    function showProductUpdateForms() {
        const priceUpdateForm = document.getElementById('price-update-form');
        products.forEach(product => {
            const div = document.createElement('div');
            div.classList.add('product');
            div.innerHTML = `
                <h3>${product.name}</h3>
                <img src="${product.image}" alt="${product.name}">
                <p class="price" id="price-${product.id}">Price: R ${product.price}</p>
                <label for="new-price-${product.id}">New Price:</label>
                <input type="number" id="new-price-${product.id}">
                <button onclick="updatePrice(${product.id})">Update Price</button>
            `;
            priceUpdateForm.appendChild(div);
        });
    }

    function updatePrice(productId) {
        const newPriceInput = document.getElementById(`new-price-${productId}`);
        const newPrice = newPriceInput.value;

        if (newPrice && !isNaN(newPrice)) { // Check if newPrice is not empty and is a valid number
            const parsedNewPrice = parseInt(newPrice); // Convert newPrice to integer

            products.forEach(product => {
                if (product.id === productId) {
                    product.price = parsedNewPrice; // Update price in the products array

                    // Update displayed price on the page
                    const priceElement = document.querySelector(`#price-${productId}`);
                    priceElement.textContent = `Price: R ${parsedNewPrice}`;
                }
            });

            newPriceInput.value = ''; // Clear the input field
        } else {
            alert('Please enter a valid new price.');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const productGrid = document.getElementById('product-grid');
        products.forEach(product => {
            const div = document.createElement('div');
            div.classList.add('product');
            div.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p class="price">Price: R ${product.price}</p>
            `;
            productGrid.appendChild(div);
        });

        showProductUpdateForms();
    });
</script>

</body>
</html>
