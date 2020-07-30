<?php

include_once('Points.php');
include_once('Building.php');

$pointC = null;
$pointD = null;
$perimeter = 0;
$area = 0;
$price = 0;

if (!empty($_POST["pointA"]) && !empty($_POST["pointB"])) {
    if (!empty($_POST["pointA"]["lat"]) && !empty($_POST["pointA"]["lng"]) && !empty($_POST["pointB"]["lat"]) && !empty($_POST["pointB"]["lng"])) {
        $pointA = new Points($_POST["pointA"]["lat"], $_POST["pointA"]["lng"]);
        $pointB = new Points($_POST["pointB"]["lat"], $_POST["pointB"]["lng"]);
        if ($pointA->validateLatLong() && $pointB->validateLatLong()) {
            $pointC = new Points($pointA->x, $pointB->y);
            $pointD = new Points($pointB->x, $pointA->y);

            $building = new Building($pointA, $pointB, $pointC, $pointD);
            $perimeter = $building->calculatePerimeter();
            $area = $building->calculateArea();
            $price = $building->calculateBuildingPrice();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Coordinate</title>
</head>

<body>
    <div class="container">
        <div class="col-md-6 offset-md-3">
            <form action="index.php" method="post">
                <div class="form-group">
                    <label>Point A</label>
                    <div class="row">
                        <div class="col-md">
                            <label for="pointA">Latitude</label>
                            <input type="number" step="0.000001" class="form-control" id="pointA" name="pointA[lat]">
                        </div>
                        <div class="col-md">
                            <label for="pointA">Longitude</label>
                            <input type="number" step="0.000001" class="form-control" id="pointA" name="pointA[lng]">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Point B</label>
                    <div class="row">
                        <div class="col-md">
                            <label for="pointBLong">Latitude</label>
                            <input type="number" step="0.000001" class="form-control" id="pointBLong" name="pointB[lat]">
                        </div>
                        <div class="col-md">
                            <label for="pointBLat">Longitude</label>
                            <input type="number" step="0.000001" class="form-control" id="pointBLat" name="pointB[lng]">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Calculate</button>
            </form>
            <hr>
            <div class="form-group">
                <label>Point C: <?= $pointC ? $pointC->x . ", " . $pointC->y : "" ?> </label>
            </div>

            <div class="form-group">
                <label>Point D: <?= $pointD ? $pointD->x . ", " . $pointD->y : "" ?> </label>
            </div>

            <div class="form-group">
                <label>Perimeter: <?= number_format($perimeter, 2) ?> meter</label>
            </div>

            <div class="form-group">
                <label>Area: <?= number_format($area, 0) ?> squadre meter</label>
            </div>

            <div class="form-group">
                <label>Total cost: <?= number_format($price, 2) ?> EUR</label>
            </div>
        </div>
    </div>

</body>

</html>