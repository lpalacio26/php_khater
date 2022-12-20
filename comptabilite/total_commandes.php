<?php

include "db.php";


ini_set("display_errors", "1");

error_reporting(E_ALL);


$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $sql = "SELECT quantity, price FROM orders";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = "";
    $i = 0;
    $total_all = 0;

    while ($i < count($orders)) {

        $quantity = $orders[$i]["quantity"];
        $price = $orders[$i]["price"];
        $total_all = $total_all + $price * $quantity;
        $i = $i + 1;

    }

    $html = $html . "
    <p>Total: <span id='total-euros'>$total_all</span>"."€</p>
    <p>Nombre de commandes: <span id='total-orders'>$i</span></p>";

    echo $html;

}

?>