<?php

session_start();

if(!isset($_SESSION['user_name']) && ($_SESSION['user_name']) !== true)
{
	header('location: login.php');
	exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tee Tee Jewels - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Welcome to Tee Tee Jewellery</h1>
    <h2>Hello <strong> <?php echo $_SESSION["user_name"]; ?></strong>, welcome !.</h2>

    <section class="intro">
        <p>Explore our timeless, elegant, stylish jewellery collection crafted for both men and women.</p>
    </section>
    <!-- Navigation Menu -->
    <nav>
        <ul>
            <!-- Dropdown for Shop Now -->
            <li class="dropdown">
                <a href="#">Shop Now</a>
                <div class="dropdown-content">
                    <a href="NecklaceMen.html">Necklace for Men</a>
                    <a href="NecklaceWomen.html">Necklace for Women</a>
                </div>
            </li>
            <!-- About Us Link -->
            <li>
                <a href="about us.html">About Us</a>
            </li>
            <!-- Contact Us Link -->
            <li>
                <a href="ContactUs.html">Contact Us</a>
            </li>
            <!-- Dropdown for Special Offers -->
            <li class="dropdown">
                <a href="#" onclick="alert('Special offers aren\'t available yet'); return false;">Special Offers</a>
            </li>
            <li>
                <a href="login.php">Log in</a>
            </li>

        </ul>
    </nav>

    <!-- Search Form -->
    <form class="search-form" action="search.html" method="get">
        <input type="text" name="query" placeholder="Search for products...">
        <button type="submit">Search</button>
    </form>
    <!-- Log Out Button -->
    <button class="logout-btn" onclick="logout()">Log Out</button>
</header>

<!-- Featured Products Section -->
<section class="featured-products">
    <h2>Featured Products</h2>
    <div class="product-grid">
        <!-- Showing one of the products on the home page -->
        <div class="product">
            <!-- Product Image with specific width and height -->
            <img src="Tee tee website/moonsilverwomennecklace.jpg" alt="Women Necklace" style="width: 250px; height: 250px; object-fit: cover; border-radius: 10px;">
            <h3>Product Name</h3>
            <p>Triple Gold Lock Necklace</p>
        </div>
    </div>
</section>

<div class="product-grid">

    <div class="product">

        <img src="Tee tee website/goldafricanecklacemen.jpg" alt="Men Necklace"  style="width: 250px; height: 250px; object-fit: cover; border-radius: 10px;">
        <h3>Product Name</h3>
        <p>Triple Gold Lock Necklace</p>
    </div>
</div>




<footer>
    <p>&copy; 2024 Tee Tee Jewellery. All rights reserved.</p>
</footer>

<script>
    function logout() {
        window.location.href = 'login.php';
    }
</script>

</body>
</html>
