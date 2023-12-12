<?php
require_once("dbConnection.php");

// Search
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($mysqli, $_POST['search_term']);
    $query = "SELECT * FROM drugs WHERE drug_description LIKE '%$searchTerm%' OR dosage LIKE '%$searchTerm%' OR batch_date LIKE '%$searchTerm%' OR expiration_date LIKE '%$searchTerm%' OR price LIKE '%$searchTerm%'";
} else {
    $query = "SELECT * FROM drugs";
}

$result = mysqli_query($mysqli, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Drug Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php"><h1>Prescription Drug Information</h1></a>
    <form method="POST">
        <input type="text" name="search_term" placeholder="Search...">
        <button type="submit" name="search">Search</button>
    </form>
    <a href="add.php"><button>Add Drug</button></a>

    <table>
        <thead>
            <tr>
                <th>Prescription Drug Information</th>
                <th>Generated ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($res = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$res['drug_description']." <br> ".$res['dosage']." <br> ".date('F j, Y', strtotime($res['batch_date']))." <br> ".date('F j, Y', strtotime($res['expiration_date']))." <br> ".$res['price']."</td>";
            echo "<td>".$res['drug_id']."</td>";
            
            echo "<td>
            <a href=\"prescribe.php?id=$res[id]&description=".urlencode($res['drug_description'])."\"'><button>Prescribe</button></a>
            <a href=\"edit.php?id=$res[id]\"><button>Edit</button></a>
            <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><button>Delete</button></a>
            </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <script>
        function showAddForm() {
            var addFormContainer = document.getElementById('addFormContainer');
            addFormContainer.style.display = 'block';
        }
    </script>
</body>
</html>
