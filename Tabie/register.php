<?php
session_start();
include('config.php');

// Function to check if the password is strong
function isPasswordStrong($password) {
    // Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character
    return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{"\':;?\/>.<,])(?=.*[a-zA-Z]).{8,}$/', $password);
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Added for confirmation

    // Validate password strength on server-side
    if (!isPasswordStrong($password)) {
        echo '<p class="error">Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>';
        exit;
    }

    // Validate if passwords match
    if ($password !== $confirm_password) {
        echo '<p class="error">Passwords do not match.</p>';
        exit; // Stop  if passwords do not match
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email is already registered
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo '<p class="error">The email address is already registered!</p>';
    } else {
        // Insert new user into the database
        $query = $connection->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password_hash, :email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();

        if ($result) {
            // Registration successful
            $_SESSION['registration_success'] = true;
            header('Location: login.php');
            exit();
        } else {
            echo '<p class="error">Your registration was not successful!</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var strongRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{"':;?\/>.<,])(?=.*[a-zA-Z]).{8,}$/;

            // Validate password strength
            if (!strongRegex.test(password)) {
                document.getElementById("password-strength").innerHTML = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                return false;
            } else {
                document.getElementById("password-strength").innerHTML = "";
            }

            // Validate password and confirm password match
            if (password !== confirmPassword) {
                document.getElementById("confirm-password-error").innerHTML = "Passwords do not match.";
                return false;
            } else {
                document.getElementById("confirm-password-error").innerHTML = "";
            }

            return true;
        }
    </script>
</head>
<body>
    <form method="post" action="" name="signup-form" onsubmit="return validatePassword()">
        <div class="form-element">
            <label>Username</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
        </div>

        <div class="form-element">
            <label>Email</label>
            <input type="email" name="email" required />
        </div>

        <div class="form-element">
            <label>Password</label>
            <input type="password" id="password" name="password" onkeyup="validatePassword()" required />
            <p id="password-strength" style="color: red;"></p>
        </div>

        <div class="form-element">
            <label>Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm_password" onkeyup="validatePassword()" required />
            <p id="confirm-password-error" style="color: red;"></p>
        </div>

        <button type="submit" name="register" value="register">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <p>Amin access <a href="admin.html">Admin log in here</a></p>
    </form>

    <script src="script.js"></script>
</body>
</html>
