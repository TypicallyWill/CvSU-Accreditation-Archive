<?php
// user_info.php

// Include your database connection configuration file
require('./dbConfig.php');

// Check if the user ID is provided in the POST request
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Modify this query based on your database schema
    $query = "SELECT * FROM users WHERE id = $userId";

    $result = $mysqli->query($query);

    if ($result) {
        $user = $result->fetch_assoc();
        // Output user information in HTML format
        echo '<strong>User Information:</strong><br>';
        echo 'ID: ' . $user['id'] . '<br>';
        echo 'First Name: ' . $user['first_name'] . '<br>';
        echo 'Last Name: ' . $user['last_name'] . '<br>';
        echo 'Email: ' . $user['email'] . '<br>';
        // Add more fields as needed
    } else {
        // Handle query error
        echo 'Error fetching user information.';
    }
} else {
    // Handle missing user ID
    echo 'User ID not provided.';
}

// Close the database connection
$mysqli->close();
?>
