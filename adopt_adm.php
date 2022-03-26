<?php
session_start();
require_once './components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$sql = "SELECT users.user_id, users.f_name, users.l_name, users.email,  users.address, users.birth_date, users.city, users.phone,animals.anim_id, animals.kind, animals.name, animals.breed, animals.age, animals.location, animals.size, animals.sex, adoptions.adpt_id, adoptions.date  FROM users 
JOIN adoptions ON adoptions.fk_user_id = users.user_id 
JOIN animals on animals.anim_id = adoptions.fk_anim_id
WHERE animals.status = 'Adopted'";
$result = mysqli_query($connect, $sql);

$tbody = '';

if(mysqli_num_rows($result)  > 0) {     
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    
 $tbody .= "<tr>
            <td>" . $row['adpt_id'] . "</td>
            <td>" . $row['f_name'] . "</td>
            <td>" . $row['l_name'] . " </td>
            <td>" . $row['email'] . " </td>
            <td>" . $row['address'] . "</td>
            <td>" . $row['city'] . "</td>
            <td>" . $row['birth_date'] . "</td>
            <td>" . $row['phone'] . "</td>
            <td>" . $row['anim_id'] . "</td>
            <td>" . $row['kind'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['breed'] . " </td>
            <td>" . $row['age'] . " </td>
            <td>" . $row['location'] . "</td>
            <td>" . $row['size'] . "</td>
            <td>" . $row['sex'] . "</td>
            <td>" . $row['date'] . "</td>
            <td><a href='adopting/delete.php?id=" . $row['adpt_id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";
    }
    
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-Dashboard</title>
    <?php require_once './components/boot.php' ?>
       <link rel="stylesheet" type="text/css" href="2.css">
    <style type="text/css">
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .userImage {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body style="background-image: url(./aaaas.jpeg)" >
   
        
            <div style="height: 10rem;"  class="text-center">
                <img class="userImage" src="./pictures/admavatar.png" alt="Adm avatar">
                <p class="">Administrator</p>
                
                <a class="btn btn-warning" href="dashboard.php">Back</a>
               
            </div>
            <div   class="text-center ">
                <p class='h2'>Adoptions</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Adoption ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Date of Birth</th>
                            <th>Phone</th>
                            <th>Animal  ID</th>
                            <th>Kind</th>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <th>Location</th>
                            <th>Size</th>
                            <th>Location</th>
                            <th>Adoption Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
       
    
</body>
</html>