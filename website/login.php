<?php
$servername = "localhost";
$username = "root"; //database username
$password = ""; //database password
$dbname = "tee"; //database name
$port = 3307; //database port

// Create connection
$conID = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conID->connect_error) {
    die("Connection failed: " . $conID->connect_error);
}

// Check that form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $username = $_POST['username']; 

    // Prepare and execute SQL query to insert data
    $stmt = $conID->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, 'username')");
    $stmt->bind_param("ss", $email, $password);
    if ($stmt->execute()) {
        // Prepare and execute SQL query to check user credentials
        $stmt = $conID->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check that user exists
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $name = $data['username'];
            echo json_encode(['success' => true, 'message' => "$name - Logged in successfully."]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Email or Password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error storing data: ' . $conID->error]);
    }

    $stmt->close();
    $conID->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
