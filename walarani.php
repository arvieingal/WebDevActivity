<?php
include_once("connections/connection.php");
$con = connection();

if (isset($_POST['edit_id'])) {
    $editId = $_POST['edit_id'];
    $newFirstname = $_POST['new_firstname'];
    $newLastname = $_POST['new_lastname'];
    $newAge = $_POST['new_age'];
    $newAddress = $_POST['new_address'];

     Make sure to use prepared statements to prevent SQL injection
    $sql = "UPDATE users SET firstname = ?, lastname = ?, age = ?, address = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssisi", $newFirstname, $newLastname, $newAge, $newAddress, $editId);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM users";
$show = $con->query($sql) or die($con->error);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show All Users</title>
    <style>
        /* Hide the edit form by default */
        .edit-form {
            display: none;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Age</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $show->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <!-- Add a class to the edit button for easier selection -->
                        <button class="edit-button">Edit</button>
                        <!-- Edit form (hidden by default) -->
                        <form class="edit-form" action="" method="POST">
                            <input required type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <input required type="text" name="new_firstname" placeholder="New Firstname" value="">
                            <input required type="text" name="new_lastname" placeholder="New Lastname" value="">
                            <input required type="text" name="new_age" placeholder="New Age" value="">
                            <input required type="text" name="new_address" placeholder="New Address" value="">
                            <button type="submit">Save</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        // Add JavaScript to toggle the edit form visibility and populate input fields
        const editButtons = document.querySelectorAll('.edit-button');
        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const editForm = button.nextElementSibling;
                if (editForm.style.display === 'none' || editForm.style.display === '') {
                    // Show the edit form
                    editForm.style.display = 'block';
                    // Populate input fields with current values
                    const row = button.parentNode.parentNode;
                    const cells = row.querySelectorAll('td');
                    const inputs = editForm.querySelectorAll('input[type="text"]');
                    for (let i = 0; i < cells.length; i++) {
                        inputs[i].value = cells[i].textContent;
                    }
                } else {
                    // Hide the edit form
                    editForm.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
