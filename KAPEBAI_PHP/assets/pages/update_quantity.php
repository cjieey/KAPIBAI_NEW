<?php
// Update product quantity in the database
$connection = mysqli_connect("localhost", "root", "", "kapebai_db");
if ($connection) {
    if (isset($_POST['productId']) && isset($_POST['quantity'])) {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];

        // Update the database
        $updateSql = "UPDATE products SET quantity = quantity - $quantity WHERE id = $productId";
        $result = mysqli_query($connection, $updateSql);
        if ($result) {
            echo "Quantity updated successfully.";
        } else {
            echo "Failed to update quantity.";
        }
    } else {
        echo "Invalid request.";
    }
    mysqli_close($connection);
} else {
    echo "Failed to connect to database.";
}
?>
