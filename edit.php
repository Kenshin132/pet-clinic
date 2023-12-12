<?php
require_once("dbConnection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the drug information for the selected ID
    $query = "SELECT * FROM drugs WHERE id = $id";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        $drug = mysqli_fetch_assoc($result);
    } else {
        echo "Error retrieving drug information: " . $mysqli->error;
        exit();
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $description = $_POST['description'];
    $dosage = $_POST['dosage'];
    $batch_date = $_POST['batch_date'];
    $expiration_date = $_POST['expiration_date'];
    $price = $_POST['price'];

    // Update data in the database
    $sql = "UPDATE drugs SET drug_description = '$description', dosage = $dosage, batch_date = '$batch_date', expiration_date = '$expiration_date', price = $price WHERE id = $id";

    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect to the index page after successful update
        exit();
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Drug</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Drug</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label for="description">Drug Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $drug['drug_description']; ?>" required><br>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" value="<?php echo $drug['dosage']; ?>" required><br>

        <label for="batch_date">Batch Date:</label>
        <input type="date" id="batch_date" name="batch_date" value="<?php echo $drug['batch_date']; ?>" required><br>

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" value="<?php echo $drug['expiration_date']; ?>" required><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $drug['price']; ?>" required><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
