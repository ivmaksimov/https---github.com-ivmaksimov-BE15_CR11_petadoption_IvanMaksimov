<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// select logged-in users details - procedural style
$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM animals WHERE kind = '$id'";
$result = mysqli_query($connect ,$sql);
$tbody=''; 
if(mysqli_num_rows($result)  > 0) {     
    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)){         
       $tbody .= "<tr><td><img class='img-thumbnail' src='./pictures/" . $rows['picture'] . "'</td>
            
            <td>" . $rows['kind'] . "</td>
            
            <td>" . $rows['name'] . "</td>
            
            
            
           
            <td>" . $rows['status'] . "</td>
            <td><a href='moreinfo.php?id=" . $rows['anim_id'] . "'><button class='btn btn-primary btn-sm' type='button'>More Info</button></a>
            
            </tr>";
    }}}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More from - <?php echo $id; ?></title>
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

<body style="background-image: url()" >
    <div class="container">
       <div class="hero text-center d-flex ">
   
        <div class="image" >
            <img class="userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['f_name']; ?>">
            <p class="text-white">Hi <?php echo $row['f_name']; ?></p>
        </div>
         <div class="name">
           <h1 class="text-white">Animal Adoption</h1> 
            <h3 class="text-danger">More from  -<?php echo $id ?>s </h3>
           
        </div>
       </div>

    <div >
    <div style="height: 5rem;" class=" text-center  ">
    <a class="btn btn-success" href="home.php">Home</a> 
    </div>
         <p class='h2'><?php echo $id ?>s</p>  
            <table class='table '>
                <thead class='table-success'>
                    <tr>
                        <th>Picture</th>
                        <th>Kind</th>
                        <th>Name</th>
                        <th>Picture</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody >
                    <?= $tbody;?>
                </tbody>
            </table>
  </div>
</body>
</html>