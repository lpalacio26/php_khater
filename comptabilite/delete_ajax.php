<?php
include "db.php";

$id = $_POST['id'];
$sql = "DELETE FROM orders WHERE id ='".$id."'";
$stmt = $conn->prepare($sql);
$stmt->execute();

?>