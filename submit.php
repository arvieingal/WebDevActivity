<?php

include_once("connections/connection.php");
$con = connection();

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$age = $_POST['age'];
$address = $_POST['address'];

$sql = "insert into users(firstname,lastname,age,address) values ('".$firstname."','".$lastname."',".$age.",'".$address."')";
$con->query($sql) or die ($con->error);

echo header("Location: index.html");


?>