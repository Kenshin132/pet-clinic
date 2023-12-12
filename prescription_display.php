<?php
// Check if prescription details are provided in the URL
if (isset($_GET['patientName']) && isset($_GET['generatedId']) && isset($_GET['startDate']) && isset($_GET['endDate']) && isset($_GET['dosagePerDay']) && isset($_GET['dosage']) && isset($_GET['amountDue'])) {
    $patientName = $_GET['patientName'];
    $generatedId = $_GET['generatedId'];
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $dosagePerDay = $_GET['dosagePerDay'];
    $dosage = $_GET['dosage'];
    $amountDue = $_GET['amountDue'];
} else {
    // If not provided, redirect to an error page or handle accordingly
    echo "Invalid request. Please provide prescription details.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Display</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php"><h1>Prescription Details</h1></a>
    <p>Patient Name: <?php echo $patientName; ?></p>
    <p>Drug ID: <?php echo $generatedId; ?></p>
    <p>Prescription Start Date: <?php echo date('F j, Y', strtotime($startDate)); ?></p>
    <p>Prescription End Date: <?php echo date('F j, Y', strtotime($endDate)); ?></p>
    <p>Dosage Per Day: <?php echo $dosagePerDay; ?></p><br>
    <p>Quantity to buy: <?php echo $dosage; ?> units</p>
    <p>Amount due: Php <?php echo number_format($amountDue, 2); ?></p>
</body>
</html>
