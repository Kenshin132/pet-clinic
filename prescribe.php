<?php
require_once("dbConnection.php");

if (isset($_GET['id']) && isset($_GET['description'])) {
    $id = $_GET['id'];
    $description = urldecode($_GET['description']);
    $generatedId = $mysqli->query("SELECT drug_id FROM drugs WHERE id = $id")->fetch_assoc()['drug_id'];
    $defaultDosage = $mysqli->query("SELECT dosage FROM drugs WHERE id = $id")->fetch_assoc()['dosage'];
    $batchDate = $mysqli->query("SELECT batch_date FROM drugs WHERE id = $id")->fetch_assoc()['batch_date'];
    $expirationDate = $mysqli->query("SELECT expiration_date FROM drugs WHERE id = $id")->fetch_assoc()['expiration_date'];
} else {
    echo "Invalid request. Please provide a valid ID and description.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $patientName = strtoupper($_POST['patient_name']);
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $dosagePerDay = $_POST['dosage_per_day'];

    // Check if prescription dates are within the valid range
    if ($startDate < $batchDate || $endDate > $expirationDate || $startDate > $endDate) {
        echo "Invalid prescription dates. Please check the dates.";
        exit();
    }

    // Calculate prescription duration in days
    $prescriptionDuration = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24) + 1;

    // Calculate quantity and amount due using the default dosage
    $dosage = ($prescriptionDuration * $dosagePerDay) / $defaultDosage;
    $price = $mysqli->query("SELECT price FROM drugs WHERE id = $id")->fetch_assoc()['price'];
    $amountDue = $dosage * $price;

    // Redirect to the prescription display page with the details
    header("Location: prescription_display.php?" . http_build_query([
        'patientName' => $patientName,
        'generatedId' => $generatedId,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'dosagePerDay' => $dosagePerDay,
        'dosage' => $dosage,
        'amountDue' => $amountDue,
    ]));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescribe Drug</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Prescribe Drug</h1>
    <form action="prescribe.php?id=<?php echo $id; ?>&description=<?php echo urlencode($description); ?>" method="post">
        <label for="patient_name">Patient Name:</label>
        <input type="text" id="patient_name" name="patient_name" required><br>

        <label for="start_date">Prescription Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br>

        <label for="end_date">Prescription End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br>

        <!-- Retain the Dosage Per Day on the form for display -->
        <label for="dosage_per_day">Dosage Per Day:</label>
        <input type="text" id="dosage_per_day" name="dosage_per_day"><br>

        <input type="submit" value="Prescribe">
    </form>
</body>
</html>
