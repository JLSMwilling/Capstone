<?php
include_once "dbconnection-shoppingcars.php";

$id = empty($_GET["id"]) ? "" : $_GET["id"];

$do =  empty($_GET["do"]) ? "" : $_GET["do"];
$make = empty($_GET['make']) ? "" : $_GET['make'];
$model = empty($_GET['model']) ? "" : $_GET['model'];
$year = empty($_GET['year']) ? "" : $_GET['year'];
$color = empty($_GET['color']) ? "" : $_GET['color'];
$price = empty($_GET['price']) ? "" : $_GET['price'];
$image = empty($_GET['image']) ? "" : $_GET['image'];

if ($do == "add") {
    $insert = "INSERT INTO cart (inventory_id) VALUES (:id)";
    $add =  $db->prepare($insert);
    $add->bindParam(':id', $id, PDO::PARAM_INT);
    $add->execute();
} elseif ($do == "del") {
    $delete = "DELETE FROM cart WHERE inventory_id = :id";
    $del =  $db->prepare($delete);
    $del->bindParam(':id', $id, PDO::PARAM_INT);
    $del->execute();
}



$my_query = "SELECT * FROM inventory WHERE id=:id AND make=make AND model=model AND color=color AND year=year AND price=price AND image=image";
$stmt = $db->prepare($my_query);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$row = ($stmt->fetch(PDO::FETCH_ASSOC));
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
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <link rel="stylesheet" href="placingorder.css" type="text/css">
</head>

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
    <main id="main-flex">
        <div>
            <?php

            $description = $row['year'] . " " . $row['color'] . " " . $row['make'] . " " . $row['model'] . " " . " " . "Price " . "$" . $row['price'];
            ?>
            <div id="img-div" class="card div-hover car-img">
                <img class="img-fluid" src="capstoneimages/<?= $row['image'] ? $row['image'] : "Photo-Not-Available-Image.jpg" ?>" alt="<?= $description ?>">

                <h5 id="font" class="card-title"><?= $description ?></h5>

                <div id=top-nav>
                    <a class="place-order-btn" href="cart.php?id=<?= $id ?>&do=add"> Add to cart</a>

                    <a class="place-order-btn" href="placingorder.php?id=<?= $row["id"] ?>">Buy now</a>
                </div>
            </div>
        </div>
        <?php include_once "includecart.php";
        ?>

    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>