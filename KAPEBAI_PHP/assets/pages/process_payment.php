<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customerName = $_POST['customerName'];
    $tendered = $_POST['tendered'];
    $type = $_POST['type'];

    // Calculate change
    $connection = mysqli_connect("localhost", "root", "", "kapebai_db");
    $query = "SELECT SUM(total_price) AS totalAmount FROM orders WHERE customer_name = '$customerName'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $totalAmount = $row['totalAmount'];
    $change = $tendered - $totalAmount;

    // Update payment status in the database
    $updateQuery = "UPDATE orders SET payment_status = 'Paid' WHERE customer_name = '$customerName'";
    mysqli_query($connection, $updateQuery);

    // Create receipt content
    $receiptContent = "
        Receipt\n\n
        Customer Name: $customerName\n
        Total Amount: ₱" . number_format($totalAmount, 2) . "\n
        Tendered: ₱" . number_format($tendered, 2) . "\n
        Change: ₱" . number_format($change, 2) . "\n
        Payment Type: $type\n
    ";

    // Save receipt to a text file
    $fileName = 'receipt_' . time() . '.txt'; // Unique filename
    $filePath = '../pages/receipts/' . $fileName; // Path to the receipts folder
    file_put_contents($filePath, $receiptContent);

    // Close connection
    mysqli_close($connection);

    // Redirect to the orders page
    header("Location: orders.php");
    exit();
} else {
    // If the form is not submitted, redirect to the orders page
    header("Location: orders.php");
    exit();
}
?>
