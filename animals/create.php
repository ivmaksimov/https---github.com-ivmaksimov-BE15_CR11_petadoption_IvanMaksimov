<?php
session_start();
require_once '../components/db_connect.php';

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../components/boot.php' ?>
       <link rel="stylesheet" type="text/css" href="2.css">
    <title>Add Animal</title>
    <style>
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>
<body style="background-image: url(./aaaas.jpeg)" class="text-center">
    <div class="hero">
     <h1 class="text-white">Animal Adoption </h1>
    </div>
    <fieldset>
        <legend class='h2'>Add Animal</legend>
        <form action="actions/a_create.php" method="post" enctype="multipart/form-data">
            <table class='table'>
                <tr>
                    <th>Kind</th>
                    <td><input class='form-control' type="text" name="kind" placeholder="Kind" /></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name="breed" placeholder="Breed"   /></td>
                </tr>
                <tr>
                    <th>Sex</th>
                    <td><input class='form-control' type="text" name="sex" placeholder="Sex"   /></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name"  placeholder="Name"/></td>
                </tr>
                
                <tr>
                    <th>Size</th>
                    <td><input class='form-control' type="text" name="size" placeholder="Size" /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name="age" placeholder="Age"  /></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name="location" placeholder="Location" /></td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td><input class='form-control' type="text" name="descript" placeholder="Description" /></td>
                </tr>
                
                <tr>
                    <th>Picture</th>
                    <td><input class='form-control' type="file" name="picture" /></td>
                </tr>
                
                <tr>
                    <th>Status</th>
                    <td><input class='form-control' type="text" name="status" placeholder="Status" /></td>
                </tr>
                <tr>
                    <td><button class='btn btn-success' type="submit">Insert Product</button></td>
                    <td><a href="index.php"><button class='btn btn-warning' type="button">Home</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>