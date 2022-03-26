<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../components/db_connect.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE anim_id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $kind = $data['kind'];
        $breed = $data['breed'];
        $sex = $data['sex'];
        $name = $data['name'];
        $size = $data['size'];
        $age = $data['age'];
        $location = $data['location'];
        $descript = $data['descript'];
        $status = $data['status'];
        $picture = $data['picture'];
        }
     else {
        header("location: error.php");
    }
    mysqli_close($connect);
} 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Animals</title>
    <?php require_once '../components/boot.php' ?>
       <link rel="stylesheet" type="text/css" href="2.css">
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body style="background-image: url(./aaaas.jpeg)" class="text-center">
    <div class="hero">
            
            <h1 class="text-white">Animals Adoption </h1>
        </div>
    <fieldset>
        <legend class='h2'>Edit request <img class='img-thumbnail rounded-circle' src='../pictures/<?php echo $picture ?>' alt="<?php echo $name ?>"></legend>
        <form action="actions/a_update.php" method="post" enctype="multipart/form-data">
            <table class="table">
                 <tr>
                    <th>Kind</th>
                    <td><input class='form-control' type="text" name="kind" value="<?php echo $kind ?>" /></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name="breed" value="<?php echo $breed ?>"   /></td>
                </tr>
                <tr>
                    <th>Sex</th>
                    <td><input class='form-control' type="text" name="sex" value="<?php echo $sex ?>"   /></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name"  value="<?php echo $name ?>"/></td>
                </tr>
                
                <tr>
                    <th>Size</th>
                    <td><input class='form-control' type="text" name="size" value="<?php echo $size ?>" /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name="age" value="<?php echo $age ?>"  /></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name="location" value="<?php echo $location ?>" /></td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td><input class='form-control' type="text" name="descript" value="<?php echo $descript ?>" /></td>
                </tr>
                
                <tr>
                    <th>Picture</th>
                    <td><input class='form-control' type="file" name="picture" value="<?php echo $picture ?>"   /></td>
                </tr>
                
                <tr>
                    <th>Status</th>
                    <td><input class='form-control' type="text" name="status" value="<?php echo $status ?>" /></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['anim_id'] ?>" />
                    <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>" />
                    <td><button class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>