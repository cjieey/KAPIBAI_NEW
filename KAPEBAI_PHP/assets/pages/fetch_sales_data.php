<?php
// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "kapebai_db");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the date parameter is set
if (isset($_GET['date'])) {
    // Sanitize the input to prevent SQL injection
    $date = mysqli_real_escape_string($connection, $_GET['date']);

    // Query to fetch sales data based on the selected date
    $sql = "SELECT time, total_price FROM orders WHERE date = '$date'";
    $result = mysqli_query($connection, $sql);

    // Fetch data as associative array
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Close connection
    mysqli_close($connection);

    // Output data as JSON
    echo json_encode($data);
} else {
    // If date parameter is not set, return an error message
    echo json_encode(['error' => 'Date parameter is missing']);
}
?>
