<?php
session_start();
require_once 'components/db_connect.php';
$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
if ($_GET['id']) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM animals WHERE anim_id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result); 
        $kind = $data['kind'];
        $breed = $data['breed'];
        $picture = $data['picture'];
        $sex = $data['sex'];
        $name = $data['name'];
        $size = $data['size'];
        $age = $data['age'];
        $location = $data['location'];
        $descript = $data['descript'];
        $status = $data['status'];  

} else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}};
mysqli_close($connect);

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>infos</title>
        <?php require_once 'components/boot.php'?>
        <link rel="stylesheet" type="text/css" href="2.css">
        <style type="text/css">
            .manageProduct {           
                margin: auto;
            }
            .img-thumbnail {
                width: 70px !important;
                height: 70px !important;
            }
            td {          
                text-align: center;
                vertical-align: middle;
            }
            tr {
                text-align: center;
            }
            .userImage {
            width: 200px;
            height: 200px;
        }
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
        .image{
            margin:1rem
        }
        .name{
            margin-top:80px;
            margin-left:50px;
        }
        </style>
        
        
   
 
  </head>

<body style="background-image: url(./aaaas.jpeg)"   class="    ">
    <div class="container">
        <div class="hero text-center d-flex">
            <div class="image" >
                <img class="userImage" src="./pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['f_name']; ?>">
                <p class="text-white"><?php echo $row['f_name']; ?></p>
            </div>
            <div class="name">
                <h1 class="text-white">Animal Adoption</h1>
                 <h3 class="text-danger">Details About this Pet</h3>
           </div>
        </div>
    </div>

    <div style="margin-top:1rem;" class="container">    
    <a  href=<?php echo './adopting/adopt.php?id=' .$id?>><button style="padding: 1rem; width: 300px;" class='btn btn-success btn-sm' type='button'>Adopt this Pet</button></a>
    <a  href=<?php echo './more_of.php?id=' .$kind?>><button style="padding: 1rem; width: 300px;" class='btn btn-primary btn-sm' type='button'>More of this kind</button></a>
    </div>

    <div class="d-flex name text-center">
        <div style="width:30%">
            <h1><span class="h3">Name:   </span><?php echo $name ?></h1>
            <h1><span class="h3">Kind:   </span><?php echo $kind ?></h1>
            <h1><span class="h3">Breed:   </span><?php echo $breed ?></h1>
            <h1><span class="h3"></span><?php echo $sex ?></h1>
            <h1><span class="h3">Age:   </span><?php echo $age ?></h1>
            <h1><?php echo $size ?> size</h1>
            <h1 class="h2"><?php echo $location ?></h1>
            <h1><?php echo $status ?></h1>
        </div>
        <div style="width:30%" >
            <h1><?php echo $name ?></h1>
            <br>
            <img style="margin-top:1rem;" class="img-tumbnail" src="<?php echo 'pictures/' .$picture ?>" alt="">
        </div>
         
        <div style="width:30%">
            <h1>Description:</h1>
            <br>
            <br>
            <h3><?php echo $descript ?></h3>
        </div>
    </div>   
</body>