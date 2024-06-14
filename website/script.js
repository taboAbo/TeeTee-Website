

// Event listener for DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function () {

    // Login form submission
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission behavior
        var email = document.getElementById('login-email').value; // Get email input value
        var password = document.getElementById('login-password').value; // Get password input value

        // Retrieve user credentials from local storage
        var storedUsers = JSON.parse(localStorage.getItem('users')) || [];

        // Check if the user exists and the password matches
        var user = storedUsers.find(user => user.email === email && user.password === password);

        // Redirect to home page upon successful login or show alert for invalid credentials
        if (user) {
            window.location.href = 'home.html';
        } else {
            alert('Invalid login credentials');
        }
    });

    // Switch to sign-up form
    document.getElementById('signUpBtn').addEventListener('click', function () {
        document.getElementById('login-container').style.display = 'none';
        document.getElementById('signup-container').style.display = 'block';
    });

    // Switch back to login form
    document.getElementById('backToLoginBtn').addEventListener('click', function () {
        document.getElementById('signup-container').style.display = 'none';
        document.getElementById('login-container').style.display = 'block';
    });

    // Forgot password functionality
    document.getElementById('forgot-password').addEventListener('click', function () {
        alert('Password recovery instructions will be sent to your email.');
    });

    // Sign-up form submission
    document.getElementById('signupForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission behavior
        var email = document.getElementById('signup-email').value; // Get email input value
        var password = document.getElementById('signup-password').value; // Get password input value
        var confirmPassword = document.getElementById('signup-confirm-password').value; // Get confirm password input value

        // Check if passwords match
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        // Check if the password is strong
        if (!isPasswordStrong(password)) {
            alert('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
            return;
        }

        // Retrieve existing users from local storage
        var storedUsers = JSON.parse(localStorage.getItem('users')) || [];

        // Check if the user already exists
        var userExists = storedUsers.some(user => user.email === email);

        // Alert if the user already exists, otherwise add the new user to the list and redirect to home page
        if (userExists) {
            alert('User already exists. Please log in.');
            return;
        } else {
            storedUsers.push({ email: email, password: password });
            localStorage.setItem('users', JSON.stringify(storedUsers));
            alert('Registration successful! Redirecting to sign up page...');
            window.location.href = 'index.html';
        }
    });

    // Event listener for password input to check password strength
    document.getElementById('signup-password').addEventListener('input', function () {
        var password = this.value;
        var passwordStrengthSpan = document.getElementById('password-strength');
        if (isPasswordStrong(password)) {
            passwordStrengthSpan.textContent = 'Password strength: Strong';
            passwordStrengthSpan.style.color = 'green';
        } else {
            passwordStrengthSpan.textContent = 'Password strength: Weak';
            passwordStrengthSpan.style.color = 'red';
        }
    });

});

// JavaScript for handling shopping cart functionality
let cart = [];

function addToCart(itemName, price) {
    const existingItemIndex = cart.findIndex(item => item.name === itemName);
    if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity += 1;
    } else {
        cart.push({ name: itemName, price: price, quantity: 1 });
    }
    updateCartUI();
    alert("Added to cart: " + itemName);
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
}

function removeFromCart(itemName) {
    const itemIndex = cart.findIndex(item => item.name === itemName);
    if (itemIndex !== -1) {
        cart.splice(itemIndex, 1);
    }
    updateCartUI();
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
}

function increaseQuantity(itemName) {
    const itemIndex = cart.findIndex(item => item.name === itemName);
    if (itemIndex !== -1) {
        cart[itemIndex].quantity += 1;
    }
    updateCartUI();
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
}

function decreaseQuantity(itemName) {
    const itemIndex = cart.findIndex(item => item.name === itemName);
    if (itemIndex !== -1 && cart[itemIndex].quantity > 1) {
        cart[itemIndex].quantity -= 1;
    }
    updateCartUI();
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
}

function updateCartUI() {
    const cartItemsContainer = document.querySelector('.cart-items');
    cartItemsContainer.innerHTML = ''; // Clear previous content

    let totalPrice = 0;

    cart.forEach(item => {
        totalPrice += item.price * item.quantity;
        cartItemsContainer.innerHTML += `
            <div>
                <span>${item.name} - R ${item.price} x ${item.quantity}</span>
                <button onclick="increaseQuantity('${item.name}')">+</button>
                <button onclick="decreaseQuantity('${item.name}')">-</button>
                <button onclick="removeFromCart('${item.name}')">Remove</button>
            </div>
        `;
    });

    cartItemsContainer.innerHTML += `
        <hr>
        <div>Total: R ${totalPrice}</div>

<button onclick="checkout()">Checkout</button>
    `;

    const cartDisplay = document.querySelector('.cart-items');
    cartDisplay.style.display = cart.length ? 'block' : 'none';
}

function checkout() {
    window.location.href = 'checkout.html';
}

// Load cart from local storage
document.addEventListener('DOMContentLoaded', function() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
    updateCartUI();
});

// This function runs when the page is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Get the cart items from local storage, or an empty array if there are no items
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const orderSummaryContainer = document.querySelector('.order-summary');

    let totalPrice = 0;

    // Loop through the cart items to calculate the total price and display each item
    cart.forEach(item => {
        totalPrice += item.price * item.quantity;
        orderSummaryContainer.innerHTML += `
            <div>
                <span>${item.name} - R ${item.price} x ${item.quantity}</span>
            </div>
        `;
    });

    // Display the total price
    orderSummaryContainer.innerHTML += `
        <hr>
        <div>Total: R ${totalPrice}</div>
    `;

    // Add an event listener for the delivery form submission
    document.getElementById('deliveryForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the values from the form inputs
        const name = document.getElementById('name').value;
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const postcode = document.getElementById('postcode').value;
        const cardNumber = document.getElementById('cardNumber').value;
        const expiryDate = document.getElementById('expiryDate').value;
        const cvv = document.getElementById('cvv').value;

        // Check if all required fields are filled
        if (name && address && city && postcode && cardNumber && expiryDate && cvv) {
            // Show a thank you message
            alert('Thank you for your purchase, ' + name + '!');

            // Create the content for the order report
            let reportContent = `Order Report\n\n`;
            reportContent += `Name: ${name}\n`;
            reportContent += `Address: ${address}\n`;
            reportContent += `City: ${city}\n`;
            reportContent += `Postcode: ${postcode}\n\n`;
            reportContent += `Order Summary:\n`;
            cart.forEach(item => {
                reportContent += `${item.name}: R ${item.price} x ${item.quantity}\n`;
            });
            reportContent += `\nTotal Amount Paid: R ${totalPrice}\n`;

            // Display the report content on the page
            document.getElementById('reportContent').innerText = reportContent;
            document.getElementById('reportSection').style.display = 'block';

            // Create a downloadable file from the report content
            const blob = new Blob([reportContent], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.getElementById('downloadLink');
            downloadLink.href = url;
            downloadLink.style.display = 'block';

            // Show a message to download the report and wait for redirection
            alert('Please download your order report down below. You will be redirected to the home page in 5 minutes.');

            // Clear the cart and redirect to the home page after a 5-minute delay
            setTimeout(() => {
                localStorage.removeItem('cart');
                window.location.href = 'home.html';
            }, 300000); // 300,000 milliseconds = 5 minutes
        } else {
            // Show an alert if any fields are missing
            alert('Please fill in all the fields.');
        }
    });
})

// Function to check if the password is strong
function isPasswordStrong(password) {
    // Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character
    const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{"':;?/>.<,])(?=.*[a-zA-Z]).{8,}$/;
    return regex.test(password);
}
