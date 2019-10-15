<?php

include_once "dbconnection-shoppingcars.php";

$make_qry = "SELECT DISTINCT make FROM inventory";
$model_qry = "SELECT DISTINCT model FROM inventory";
$year_qry = "SELECT DISTINCT year FROM inventory";
$color_qry = "SELECT DISTINCT color FROM inventory";
$price_qry = "SELECT DISTINCT price FROM inventory";
$image_qry = "SELECT DISTINCT image FROM inventory";

$make = empty($_GET['make']) ? "" : $_GET['make'];
$model = empty($_GET['model']) ? "" : $_GET['model'];
$year = empty($_GET['year']) ? "" : $_GET['year'];
$color = empty($_GET['color']) ? "" : $_GET['color'];
$price = empty($_GET['price']) ? "" : $_GET['price'];
$image = empty($_GET['image']) ? "" : $_GET['image'];

$placeHolder = [];

$my_query = "SELECT * FROM inventory WHERE 1=1";

if ($make) {
    $my_query .= ' AND make=:make';
    $placeHolder[':make'] = $make;
}
if ($model) {
    $my_query .= ' AND model=:model';
    $placeHolder[':model'] = $model;
}
if ($year) {
    $my_query .= ' AND year=:year';
    $placeHolder[':year'] = $year;
}
if ($color) {
    $my_query .= ' AND color=:color';
    $placeHolder[':color'] = $color;
}
if ($price) {
    $my_query .= ' AND price=:price';
    $placeHolder[':price'] = $price;
}
// print_r($my_query);
// print_r($placeHolder);

$stmt = $db->prepare($my_query);
foreach ($placeHolder as $k => $v) {
    $stmt->bindParam($k, $v);
}
$stmt->execute($placeHolder);

$stmt_make = $db->query($make_qry);
$stmt_model = $db->query($model_qry);
$stmt_year = $db->query($year_qry);
$stmt_color = $db->query($color_qry);
$stmt_price = $db->query($price_qry);
$stmt_image = $db->query($image_qry);
// $stmt-> bindParam($placeHolder,PDO::FETCH_ASSOC);
// $row = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($my_query);
// $result = $db->query($my_query);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop your dream car</title>
    <link rel="stylesheet" type="text/css" href="shoppingcars.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
     integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Courgette&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg nav-bar">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse search-flex" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Home</a> </li>

                    <li class="nav-item active">
                        <a class="nav-link" href="shoppingcars.php">Shop your dream car <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item active">
                        <a class="nav-link" href="cart.php#link-cart">cart<i class="fas fa-shopping-cart"></i></a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input id="search-bar" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn  my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </nav>
    </header>
    <main>
        <form action="" method="get" id="grid">
            <div id="flex">
                <select class="filters" id="filters" name="make">
                    <option value="">make</option>
                    <?php

                    while ($row = $stmt_make->fetch(PDO::FETCH_ASSOC)) {

                        ?> <option><?= $row['make'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <select class="filters" id="filters" name="model">
                    <option value="">model</option>
                    <?php

                    while ($row = $stmt_model->fetch(PDO::FETCH_ASSOC)) {

                        ?> <option><?= $row['model'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <select class="filters" id="filters" name="year">
                    <option value="">year</option>
                    <?php

                    while ($row = $stmt_year->fetch(PDO::FETCH_ASSOC)) {

                        ?> <option><?= $row['year'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <select class="filters" id="filters" name="color">
                    <option value="">color</option>
                    <?php

                    while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC)) {

                        ?> <option><?= $row['color'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <button id="filter-btn" type="submit" name="btn">update</button>
            </div>

            <section id="results">
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $description = $row['make'] . " " . $row['model'] . " " . $row['year'];
                    ?>
                    <a href="cart.php?id=<?= $row["id"]?>">
                  
                        <div id="<?= $row['id'] ?>" class="card div-hover">
                            <img src="capstoneimages/<?= $row['image'] ? $row['image'] : "Photo-Not-Available-Image.jpg" ?>" class="card-img-top " alt="<?= $description ?>">
                            <div class="card-body">
                                <h5 id="font" class="card-title"><?= $description ?></h5>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
            </section>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>