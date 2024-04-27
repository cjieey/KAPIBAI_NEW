<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent from the menu.php page    
    $customerName = $_POST['customerName'];
    $orderDetailsJson = $_POST['orderDetails'];
    $orderDetails = json_decode($orderDetailsJson, true); // Convert JSON string to associative array

    // Validate the data (you may add more validation as needed)

    // Connect to your database
    include 'dbconnect.php'; // Include database connection settings

    // Prepare and execute the SQL statement to insert order details into the database
    $insertSql = "INSERT INTO orders (customer_name, Pname, quantity, total_price, date, time) VALUES (?, ?, ?, ?, CURDATE(), CURTIME())";
    $stmt = mysqli_prepare($conn, $insertSql);

    if ($stmt) {
        foreach ($orderDetails as $order) {
            mysqli_stmt_bind_param($stmt, "ssdd", $customerName, $order['productName'], $order['quantity'], $order['totalPrice']);
            mysqli_stmt_execute($stmt);
        }
        // Close statement
        mysqli_stmt_close($stmt);
        echo "Order placed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn); // Display error if preparation fails
    }

    // Close connection
    mysqli_close($conn);
} else {
    // If the request method is not POST, send an error response
    http_response_code(405);
    echo "Error: Method not allowed.";
}
?>
