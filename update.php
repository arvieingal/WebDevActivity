<?php
// Include the PHP file that contains the database connection code.
include_once("connections/connection.php");

// Establish a database connection using the connection() function.
$con = connection();

// Define an SQL query to select all records from the "users" table.
$sql = "SELECT * FROM users";

// Execute the SQL query and store the result in the $show variable.
$show = $con->query($sql) or die ($con->error);

// Create an empty array to store the data retrieved from the database.
$data = array();

// Loop through the query result and fetch each row as an associative array, then add it to the $data array.
while ($row = $show->fetch_assoc()) {
    $data[] = $row;
}

// Check if the HTTP request method is POST and the 'edit' button is clicked.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    // Get the selected user's ID from the POST data.
    $selectedId = $_POST['selected_id'];

    // Define an SQL query to select a user by their ID.
    $select_sql = "SELECT * FROM users WHERE id = '$selectedId'";

    // Execute the SQL query to retrieve the selected user's data.
    $result = $con->query($select_sql);

    // Check if a user with the specified ID exists.
    if ($result->num_rows == 1) {
        // Fetch the selected user's data as an associative array.
        $selectedRow = $result->fetch_assoc();
    } else {
        // Display an error message if the user is not found.
        echo "Record not found.";
    }
}

// Check if the HTTP request method is POST and the 'update' button is clicked.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Get the selected user's ID and updated information from the POST data.
    $selectedId = $_POST['selected_id'];
    $newFirstname = $_POST['firstname'];
    $newLastname = $_POST['lastname'];
    $newAge = $_POST['age'];
    $newAddress = $_POST['address'];

    // Define an SQL query to update the user's information in the database.
    $update_sql = "UPDATE users SET firstname = '$newFirstname', lastname = '$newLastname', age = '$newAge', address = '$newAddress' WHERE id = '$selectedId'";

    // Execute the SQL query to update the user's information.
    if ($con->query($update_sql)) {
        // Redirect to the 'update.php' page upon successful update.
        header("Location: update.php");
        exit();
    } else {
        // Display an error message if the update fails.
        echo "Error updating record: " . $con->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the document's character encoding and other metadata. -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set the page title. -->
    <title>Edit Records</title>
</head>
<body>
    <!-- Create a heading for the page. -->
    <h2>Edit Records</h2>

    <!-- Create a form for selecting a user to edit. -->
    <form method="post" action="">
        <label for="selected_id">Select User:</label>
        <select name="selected_id" id="selected_id">
            <!-- Populate the dropdown with user IDs and first names from the $data array. -->
            <?php foreach ($data as $row): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['lastname']; ?></option>
            <?php endforeach; ?>
        </select>
        <!-- Create a button to trigger the 'edit' action. -->
        <button type="submit" name="edit">Edit</button>
    </form>

    <!-- Display an edit form if a user is selected. -->
    <?php if (isset($selectedRow)): ?>
        <form method="post" action="">
            <!-- Hidden input to store the selected user's ID. -->
            <input required type="hidden" name="selected_id" value="<?php echo $selectedRow['id']; ?>">
            First Name: 
            <input required type="text" name="firstname" value="<?php echo $selectedRow['firstname']; ?>"><br>
            Last Name: 
            <input required type="text" name="lastname" value="<?php echo $selectedRow['lastname']; ?>"><br>
            Age: 
            <input required type="text" name="age" value="<?php echo $selectedRow['age']; ?>"><br>
            Address: 
            <input required type="text" name="address" value="<?php echo $selectedRow['address']; ?>"><br>
            <!-- Create a button to trigger the 'update' action. -->
            <button type="submit" name="update">Update</button>
        </form>
    <?php endif; ?>

    <!-- Create an HTML table to display user data. -->
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the $data array and display user information in table rows. -->
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Create a link to go back to the menu page. -->
    <a href="index.html">Go back to menu</a>
</body>
</html>