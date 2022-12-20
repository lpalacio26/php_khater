<?php



include "db.php";

// J'arrivais pas à voir mes erreurs sans les deux lignes qui suivent.

ini_set("display_errors", "1");

error_reporting(E_ALL);


$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $sql = "SELECT id, date, client, product, quantity, price FROM orders";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = "<tr>
    <th onclick='sortTable(0)'>Date</th>
    <th onclick='sortTable(1)'>Client</th>
    <th onclick='sortTable(2)'>Produit</th>
    <th onclick='sortTable(3)'>Quantité</th>
    <th onclick='sortTable(4)'>Prix Unitaire</th>
    <th onclick='sortTable(5)'>Total</th>
    </tr> ";

    $i = 0;

    while ($i < count($orders)) {

        $total = 0;
        $id = $orders[$i]["id"];
        $date = $orders[$i]["date"];
        $client = $orders[$i]["client"];
        $product = $orders[$i]["product"];
        $quantity = $orders[$i]["quantity"];
        $price = number_format((float) $orders[$i]["price"], 2, '.', '');
        $total = $quantity * $price;
        $total = number_format((float) $quantity * $price, 2, '.', '');
        $i = $i + 1;
        $html = $html . "
        

        <tr id= 'tr_$id'>
          <td>$date</td>
          <td>$client</td>
          <td>$product</td>
          <td>$quantity</td>
          <td>$price"."€</td>
          <td class='total-per-item'>$total"."€</td>
          <td><button class='btn' onclick='remove($id);'></button></td>
        </tr>";


    }

    echo $html;
}

if ($method == "POST") {
    $date = $_POST['date'];
    $client = $_POST['client'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];


    $sql = "INSERT INTO orders(date, client, product, quantity, price) 
        VALUES('$date', '$client', '$product', '$quantity', '$price')";



    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        $last_id = $conn->lastInsertId();
        echo $last_id;
    } else {
        echo 'Erreur';
    }
}

?>