<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $selectedDate = $_POST['selected_date'];
    $totalQuantity = $_POST['total_quantity'];
    $totalSales = $_POST['total_sales'];

    // Create the content for the sales report
    $salesReportContent = "Sales Report for $selectedDate\n\n";
    $salesReportContent .= "Total Quantity Sold: $totalQuantity\n";
    $salesReportContent .= "Total Sales: $totalSales\n";

    // Define the filename for the sales report
    $fileName = '../sales_report/sales_report_' . $selectedDate . '.txt';

    // Save the sales report as a text file
    if (!file_exists('../sales_report')) {
        mkdir('../sales_report', 0777, true);
    }
    
    if (file_put_contents($fileName, $salesReportContent)) {
        // Prompt the user to download the sales report
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=$fileName");
        echo "Successfully save the sales report.";
        echo $salesReportContent;
        exit();
    } else {
        // If the file couldn't be saved, display an error message
        echo "Failed to save the sales report.";
    }
} else {
    // If the form is not submitted, redirect to the sales report page
    header("Location: sales_report.php");
    exit();
}
?>
