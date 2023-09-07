<?php

include_once("connections/connection.php");
$con = connection();

$sql = "SELECT * FROM users";
$show = $con->query($sql) or die ($con->error);
$row = $show->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show All Users</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>FIrstname</th>
                <th>Lastname</th>
                <th>Age</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php do{ ?>
            <tr>
                <td><?php echo $row['firstname'];?></td>
                <td><?php echo $row['lastname'];?></td>
                <td><?php echo $row['age'];?></td>
                <td><?php echo $row['address'];?></td>
            </tr>
            <?php }while ($row = $show->fetch_assoc()); ?>
        </tbody>
    </table>
    <a href="index.html">Go back to menu</a>
</body>
</html>