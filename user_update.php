<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}

$backBtn = '';

if (isset($_SESSION["user"])) {
  $backBtn = "home.php";
}

if (isset($_SESSION["adm"])) {
 header("Location: index.php");
}


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE user_id = {$id}";
  $result = mysqli_query($connect, $sql);
  if (mysqli_num_rows($result) == 1) {
      $data = mysqli_fetch_assoc($result);
      $f_name = $data['f_name'];
      $l_name = $data['l_name'];
      $email = $data['email'];
      $birth_date = $data['birth_date'];
      $picture = $data['picture'];
      $address = $data['address'];
      $city = $data['city'];
      $country = $data['country'];
      $phone = $data['phone'];
      $password = $data['password'];
      $reg_date = $data['reg_date'];
     }
}

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
   
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
  
  $uploadError = '';
  $pictureArray = file_upload($_FILES['picture']); 
  $picture = $pictureArray->fileName;
  if ($pictureArray->error === 0) {
      ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
      $sql = "UPDATE users SET f_name = '$f_name', l_name = '$l_name',  birth_date = '$birth_date', address = '$address',  city = '$city', country = '$country', phone = $phone, email = '$email', password = '$password', picture = '$pictureArray->fileName' WHERE user_id = {$id}";
  } else {
      $sql = "UPDATE users SET f_name = '$f_name', l_name = '$l_name',  birth_date = '$birth_date', address = '$address',  city = '$city', country = '$country', phone = $phone, email = '$email', password = '$password' WHERE user_id = {$id}";
  }
  if (mysqli_query($connect, $sql) === true) {
      $class = "alert alert-success";
      $message = "The record was successfully updated";
      $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
     
  } else {
      $class = "alert alert-danger";
      $message = "Error while updating record : <br>" . $connect->error;
      $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
     
  }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <?php require_once 'components/boot.php' ?>
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
  </style>
</head>

<body>
  <div class="container">
      <div class="<?php echo $class; ?>" role="alert">
          <p><?php echo ($message) ?? ''; ?></p>
          <p><?php echo ($uploadError) ?? ''; ?></p>
      </div>

      <h2>Update</h2>
      <img class='img-thumbnail rounded-circle' src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $f_name ?>">
      <form method="post" enctype="multipart/form-data">
          <table class="table">
              <tr>
                  <th>First Name</th>
                  <td><input class="form-control" type="text" name="f_name" placeholder="First Name" value="<?php echo $f_name ?>" /></td>
              </tr>
              <tr>
                  <th>Last Name</th>
                  <td><input class="form-control" type="text" name="l_name" placeholder="Last Name" value="<?php echo $l_name ?>" /></td>
              </tr>
              <tr>
                  <th>Email</th>
                  <td><input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" /></td>
              </tr>
              <tr>
                  <th>Date of birth</th>
                  <td><input class="form-control" type="date" name="birth_date" placeholder="Date of birth" value="<?php echo $birth_date ?>" /></td>
              </tr>
              <tr>
                  <th>Address</th>
                  <td><input class="form-control" type="text" name="address" placeholder="Address" value="<?php echo $address ?>" /></td>
              </tr>
              <tr>
                  <th>City</th>
                  <td><input class="form-control" type="text" name="city" placeholder="City" value="<?php echo $city ?>" /></td>
              </tr>
              <tr>
                  <th>Country</th>
                  <td><input class="form-control" type="text" name="country" placeholder="Coyntry" value="<?php echo $country ?>" /></td>
              </tr>
              <tr>
                  <th>Phone</th>
                  <td><input class="form-control" type="number" name="phone" placeholder="Phone" value="<?php echo $phone ?>" /></td>
              </tr>
               <tr>
                  <th>Password</th>
                  <td><input class="form-control" type="password" name="password" placeholder="Password" value="<?php echo $password ?>" /></td>
              </tr>
              <tr>
                  <th>Picture</th>
                  <td><input class="form-control" type="file" name="picture" /></td>
              </tr>
              <tr>
                  <input type="hidden" name="id" value="<?php echo $data['user_id'] ?>" />
                  <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                  <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                  <td><a href="<?php echo $backBtn ?>"><button class="btn btn-warning" type="button">Back</button></a></td>
              </tr>
          </table>
      </form>
  </div>
</body>
</html>