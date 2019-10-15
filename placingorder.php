<?php
include_once "dbconnection-shoppingcars.php";

$id = empty($_GET["id"]) ? "" : $_GET["id"];
$make = empty($_GET['make']) ? "" : $_GET['make'];
$model = empty($_GET['model']) ? "" : $_GET['model'];
$year = empty($_GET['year']) ? "" : $_GET['year'];
$color = empty($_GET['color']) ? "" : $_GET['color'];
$price = empty($_GET['price']) ? "" : $_GET['price'];

$my_order_query = "SELECT * FROM inventory WHERE id=:id";
$stmt = $db->prepare($my_order_query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = ($stmt->fetch(PDO::FETCH_ASSOC));
$description = $row['color'] . " " . $row['make'] . " " . $row['model'] . " " . $row['year'];

$grandTotal = 245 +  $row['price'];

$cart_query = "SELECT  inventory. * 
FROM cart 
JOIN inventory
ON cart.inventory_id=inventory.id ";

$stmt_cart = $db->query($cart_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Placing Order</title>
    <link rel="stylesheet" type="text/css" href="placingorder.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<body>
    <header>
        <div class="welcomebanner">
            <img src="capstoneimages/logo.png" alt="logo">
            <div class="nav-container">
                <nav id="top-nav">
                    <a href="index.html">Home</a>
                    <a href="shoppingcars.php">Shop your dream car</a>
                    <a href="cart.php#link-cart">cart<i class="fas fa-shopping-cart"></i></a>
                </nav>
            </div>
        </div>

    </header>
    <main id="flex">
        <article class="article">
            <h1 id="form-title">Place your order</h1>
            <form action="" method="get" id="form">
                <input class="input" type="text" name="fname" placeholder="First Name" require>
                <input class="input" type="text" name="lname" placeholder="Last Name" require>
                <input class="input" type="text" name="str-adrs" placeholder="Street Address" require>
                <input class="input" type="text" name="state" placeholder="State" maxlength="2" require>
                <input class="input" type="number" name="zip" placeholder="Zip Code" require>
                <input class="input" type="number" name="card-number" placeholder="Card number">
                <input class="input" type="number" name="exp-date" placeholder="Experation Date">
                <input class="input" type="number" name="cvc" placeholder="CVC" maxn="3" require>

        </article>

        <article class="article container">
            <h1 id="form-title">Shipping options</h1>
            <select name="Shipping options" class="input" id="shippingOption">
                <option value="5">nxt-day via(Helecopter)</option>
                <option value="4">standard 2-3 days via(Boat)</option>
                <option value="6">week via(Truck)</option>
            </select>
            <h3> <?= $description ?></h3>

            <ul>
                <li>car's price:<?= $row['price'] ?> <span id="carsPrice"></span></li>
                <li>Grand total: $<?= $grandTotal ?> <span id="grand-total"></span></li>
            </ul>
            <input class="greetings-btn mx-auto" type="submit" name="Order">

        </article>
    </main>
</body>

</html>