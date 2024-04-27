<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="../css/orders.css">

    <title>Kape Bai History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body id="body-pd">
<header class="header" id="header">
    <div class="header__toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>

    <div class="header__img">
        <img src="../img/coffee.jpg" alt="">
    </div>
</header>

<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav__logo">
                <i class='bx bx-coffee-togo'></i>
                <span class="nav__logo-name">KAPE BAI</span>
            </a>

            <div class="nav__list">
                <a href="../pages/home.php" class="nav__link ">
                    <i class='bx bx-grid-alt nav__icon' ></i>
                    <span class="nav__name">Dashboard</span>
                </a>

                <a href="../pages/manage_product.php" class="nav__link ">
                    <i class='bx bx-package nav__icon' ></i>
                    <span class="nav__name">Manage Product</span>
                </a>

                <a href="../pages/menu.php" class="nav__link ">
                    <i class='bx bx-food-menu nav__icon'></i>
                    <span class="nav__name">Menu</span>
                </a>

                <a href="../pages/orders.php" class="nav__link active">
                    <i class='bx bxs-receipt nav__icon'></i>
                    <span class="nav__name">Orders</span>
                </a>
            </div>
        </div>

        <a href="../pages/index.php" class="nav__link">
            <i class='bx bx-log-out nav__icon' ></i>
            <span class="nav__name">Log Out</span>
        </a>
    </nav>
</div>

<!--===== MAIN JS =====-->
<script src="../js/main.js"></script>

<?php
// Connect to database
$connection = mysqli_connect("localhost", "root", "", "kapebai_db");

// Check connection
if ($connection === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Retrieve unique customer names from orders table
$query = "SELECT DISTINCT customer_name FROM orders WHERE payment_status <> 'Paid'";
$result = mysqli_query($connection, $query);

// Display orders grouped by customer name
while ($row = mysqli_fetch_assoc($result)) {
    $customerName = $row['customer_name'];
    ?>
    <h2><?php echo $customerName; ?></h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
        </tr>
        <?php
        // Retrieve orders for the current customer that are not paid
        $query = "SELECT * FROM orders WHERE customer_name = '$customerName' AND payment_status <> 'Paid'";
        $ordersResult = mysqli_query($connection, $query);

        // Display order details
        $totalAmount = 0;
        while ($order = mysqli_fetch_assoc($ordersResult)) {
            $totalAmount += $order['total_price'];
            ?>
            <tr>
                <td><?php echo $order['Pname']; ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo $order['date']; ?></td>
                <td><?php echo $order['time']; ?></td>
                <td><!-- Action buttons can be added here if needed --></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2"><strong>Total:</strong></td>
            <td><strong><?php echo $totalAmount; ?></strong></td>
            <td colspan="3"></td>
        </tr>
    </table>
    <!-- Form for Tendered, Change, and Type -->
    <form method="post" action="process_payment.php">
        <input type="hidden" name="customerName" value="<?php echo $customerName; ?>">
        <label for="tendered_<?php echo $customerName; ?>">Tendered:</label>
        <input type="number" id="tendered_<?php echo $customerName; ?>" name="tendered" step="0.01" required><br>
        <label for="type_<?php echo $customerName; ?>">Type:</label>
        <select id="type_<?php echo $customerName; ?>" name="type" required>
            <option value="Cash">Cash</option>
            <option value="Gcash">Gcash</option>
            <option value="Paypal">Paypal</option>
        </select><br>
        <button type="submit">Make Receipt</button>
    </form>
    <?php
}

// Close connection
mysqli_close($connection);
?>
    
</body>
</html>
