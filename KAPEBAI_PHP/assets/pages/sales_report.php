<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css"> <!-- Assuming you have a home.css file for styling -->

    <title>Sales Report</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Adjust as needed */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        th:first-child, td:first-child {
            border-left: none;
        }

        th:last-child, td:last-child {
            border-right: none;
        }

        .date-selector {
            margin-top: 100px;
        }

        button {
            font-weight: bold;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Date selector styles */
        .date-selector h1{
            text-align: center;
        }
        .date-selector label {
            font-weight: bold;
            margin-right: 10px;
        }

        .date-selector input[type="date"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        .date-selector input[type="date"]:focus {
            border-color: #4CAF50;
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

<script src="../js/main.js"></script>

<div class="date-selector">
    <h1>SALES REPORT</h1>
    <form method="get" action="">
        <label for="sales_date">Select Date:</label>
        <input type="date" id="sales_date" name="sales_date">
        <button type="submit">Show Sales</button>
    </form>
</div>

<?php
// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "kapebai_db");

// Check connection
if ($connection === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Check if a date is selected
if (isset($_GET['sales_date'])) {
    $selectedDate = $_GET['sales_date'];

    // Retrieve sales data for the selected date
    $query = "SELECT * FROM orders WHERE date = '$selectedDate' AND payment_status = 'Paid'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Initialize variables for total sales and total quantity sold
        $totalSales = 0;
        $totalQuantity = 0;

        // Display sales data in a table
        ?>
        <h2>Sales on <?php echo $selectedDate; ?></h2>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Time</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                // Update total sales and total quantity sold
                $totalSales += $row['total_price'];
                $totalQuantity += $row['quantity'];

                ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['Pname']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2"><strong>Total Quantity Sold:</strong></td>
                <td><strong><?php echo $totalQuantity; ?></strong></td>
                <td colspan="2"><strong>Total Sales: ₱<?php echo $totalSales; ?></strong></td>
            </tr>
        </table>

        <!-- Option to Print Sales Report as Text -->
        <form id="printForm" method="post" action="print_sales_report.php">
        <input type="hidden" name="selected_date" value="<?php echo $selectedDate; ?>">
        <input type="hidden" name="total_quantity" value="<?php echo $totalQuantity; ?>">
        <input type="hidden" name="total_sales" value="<?php echo $totalSales; ?>">
        <br>
        <button type="submit">Print Sales Report</button>
        <br>
        <br>
    </form>
        <?php
    } else {
        echo "<p>No sales found on $selectedDate.</p>";
    }
}

// Close connection
mysqli_close($connection);
?>
</body>
</html>
