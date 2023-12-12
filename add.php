<?php
require_once("dbConnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $description = $_POST['description'];
    $dosage = $_POST['dosage'];
    $batch_date = $_POST['batch_date'];
    $expiration_date = $_POST['expiration_date'];
    $price = $_POST['price'];

    // Generate drug ID
    $words = explode(" ", $description);
    $word1 = strtoupper(substr($words[0], 0, 1));
    $word2 = isset($words[1]) ? strtoupper(substr($words[1], 0, 1)) : '*';
    $word3 = (count($words) > 2) ? strtoupper(substr($words[2], 0, 1)) : '*';
    $random_number = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $drug_id = $word1 . $word2 . $word3 . "-" . date("mdY", strtotime($batch_date)) . "-" . date("mdY", strtotime($expiration_date)) . "-" . $random_number;

    // Insert data into the database
    $sql = "INSERT INTO drugs (drug_id, drug_description, dosage, batch_date, expiration_date, price) 
            VALUES ('$drug_id', '$description', $dosage, '$batch_date', '$expiration_date', $price)";

    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect to the index page after successful submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Drug</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add Drug</h1>
    <form action="add.php" method="post">
        <label for="description">Drug Description:</label>
        <input type="text" id="description" name="description" required><br>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required><br>

        <label for="batch_date">Batch Date:</label>
        <input type="date" id="batch_date" name="batch_date" required><br>

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
