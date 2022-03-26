<?php
session_start();
require_once 'components/db_connect.php';


if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}


$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
$sql = "SELECT *  FROM animals Where age > 8 ";
$result = mysqli_query($connect ,$sql);
$tbody=''; 
if(mysqli_num_rows($result)  > 0) {     
    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){         
       $tbody .= "<a href='./moreinfo.php?id=" .$rows['anim_id']."'><img class='img11' src='./pictures/". $rows['picture']." '></a>";

    }}
    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Pets</title>
    <?php require_once 'components/boot.php' ?>
    <link rel="stylesheet" type="text/css" href="2.css">
    <style>
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
            margin-top:50px;
            margin-left:50px;
        }
    </style>

   
</head>

<body style="background-image: url(./aaaas.jpeg)">
    <div class="container">
       <div class="hero text-center d-flex ">
   
        <div class="image" >
            <img class="userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['f_name']; ?>">
            <p class="text-white">User-<?php echo $row['f_name']; ?></p>
        </div>
         <div class="name">
           <h1 class="text-white">Animal Adoption </h1> 
           <h3 class="text-danger">Senior Pets</h3>
           
        </div>
        </div> 
        
    </div>
    <div style="height: 5rem;" class=" text-center  ">
       <a class="btn btn-primary" href="home.php">Home</a> 
       
        
</div>
        
<div class="image-grid" >
  <?= $tbody;?>
</div>

	
   
 
       

    
</body>
</html>