<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home.php
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashboard.php"); // redirects to home.php
}
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
$error = false;
$f_name = $l_name = $email = $birth_date = $password = $picture =  $address = $city = $phone = $country = $reg_date ='';
$fnameError = $lnameError = $emailError = $bdateError = $passError = $picError =  $addressError = $cityError =  $phoneError = $countryError = $rdateError ='';
$status = "user";
if (isset($_POST['btn-signup'])) {

    // sanitise user input to prevent sql injection
    // trim - strips whitespace (or other characters) from the beginning and end of a string
    $f_name = trim($_POST['f_name']);


    // strip_tags -- strips HTML and PHP tags from a string
    $f_name = strip_tags($f_name);

    // htmlspecialchars converts special characters to HTML entities
    $f_name = htmlspecialchars($f_name);

    $l_name = trim($_POST['l_name']);
    $l_name = strip_tags($l_name);
    $l_name = htmlspecialchars($l_name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $birth_date = trim($_POST['birth_date']);
    $birth_date = strip_tags($birth_date);
    $birth_date = htmlspecialchars($birth_date);

    $reg_date = trim($_POST['reg_date']);
    $reg_date = strip_tags($reg_date);
    $reg_date = htmlspecialchars($reg_date);

    $password = trim($_POST['password']);
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $address = trim($_POST['address']);
    $address = strip_tags($address);
    $address = htmlspecialchars($address);

    $city = trim($_POST['city']);
    $city = strip_tags($city);
    $city = htmlspecialchars($city);

    $country = trim($_POST['country']);
    $country = strip_tags($country);
    $country = htmlspecialchars($country);

    $phone = trim($_POST['phone']);
    $phone = strip_tags($phone);
    $phone = htmlspecialchars($phone);

    
    $uploadError = '';
    $picture = file_upload($_FILES['picture']);



    // basic name validation
    if (empty($f_name) || empty($l_name)) {
        $error = true;
        $f_nameError = "Please enter your full name and surname";
    } else if (strlen($f_name) < 3 || strlen($l_name) < 3) {
        $error = true;
        $f_nameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $f_name) || !preg_match("/^[a-zA-Z]+$/", $l_name)) {
        $error = true;
        $f_nameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // checks if the date input was left empty
    if (empty($birth_date)) {
        $error = true;
        $bdateError = "Please enter your date of birth.";
    }
    if (empty($city)) {
        $error = true;
        $cityError = "Please enter your city.";
    }
    if (empty($country)) {
        $error = true;
        $countryError = "Please enter your country.";
    }
   
    if (empty($phone)) {
        $error = true;
        $phoneError = "Please enter your phone.";
    }

    if (empty($reg_date)) {
        $error = true;
        $rdateError = "Please enter the date of registration.";
    }
    // password validation
    if (empty($password)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($password) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }
    if (empty($address)) {
        $error = true;
        $addressError = "Please enter your address.";
    }

    // password hashing for security
    $password = hash('sha256', $password);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users (f_name, l_name, birth_date, address, city, country, phone, email, password, status, reg_date, picture)
                  VALUES('$f_name', '$l_name','$birth_date', '$address', '$city', '$country', $phone, '$email', '$password', '$status',  '$reg_date', '$picture->fileName')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration System</title>
    <?php require_once 'components/boot.php' ?>
    <link rel="stylesheet" href="2.css">
    <style type="text/css">
        
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
        .d-grid{
            margin-top: 1rem;
            margin-left: 3rem;
        }
        
    </style>
</head>

<body>
<body style="background-image: url(./)" class="text-center">
    <div class="hero">
     <h1 class="text-white">Welcome to Our Animal Adoption Page</h1>
    </div>
    <div class="  text-center ">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Please Sign Up</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>
    <div style="width:;" class="image-grid">
        <div class="d-grid">
            <h4>First Name</h4>   
            <input type="text" name="f_name" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $f_name ?>" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>
        </div>
        <div class="d-grid ">
            <h4>Last Name</h4>
            <input type="text" name="l_name" class="form-control" placeholder="Last Name" maxlength="50" value="<?php echo $l_name ?>" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>
            </div>
    </div> 
    <div class="image-grid"> 
        <div class="d-grid"> 
            <h4>Email</h4>           
            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>
        </div>    
        <div  class="d-grid">
            <h4>Password</h4>
            <input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $passError; ?> </span>
        </div>
    </div>
    <div class="image-grid">     
        <div  class=" d-grid">
            <h4 >Date of Birth</h4>
                <input  class='form-control' type="date" name="birth_date" value="<?php echo $birth_date ?>" />
                <span class="text-danger"> <?php echo $bdateError; ?> </span>
        </div>   
        <div class="d-grid">
            <h4>Photo</h4>
                <input class='form-control' type="file" name="picture">
                <span class="text-danger"> <?php echo $picError; ?> </span>
        </div>
    </div>        
    <div class="image-grid">
        <div class="d-grid"> 
              <h4>Adress</h4>
            <input type="text" name="address" class="form-control" placeholder="Address" maxlength="50" value="<?php echo $address ?>" />
            <span class="text-danger"> <?php echo $addressError; ?> </span>
        </div>    
        <div class="d-grid">    
            <h4>City</h4>
            <input type="text" name="city" class="form-control" placeholder="City" maxlength="50" value="<?php echo $city ?>" />
            <span class="text-danger"> <?php echo $cityError; ?> </span>
        </div>
    </div>
    <div class="image-grid">
        <div class="d-grid">
            <h4>Country</h4>
            <input type="text" name="country" class="form-control" placeholder="Country" maxlength="50" value="<?php echo $country ?>" />
            <span class="text-danger"> <?php echo $countryError; ?> </span>
        </div>    
        <div class="d-grid">
            <h4>Phone</h4>
            <input type="number" name="phone" class="form-control" placeholder="Phone" maxlength="10" value="<?php echo $phone ?>" />
            <span class="text-danger"> <?php echo $phoneError; ?> </span>
        </div>
    </div>
    <div class="image-grid">
        <div class="d-grid">
            <h4>Date of Registration</h4>
              <input class='form-control' type="date" name="reg_date" value="<?php echo $reg_date ?>" />
                <span class="text-danger"> <?php echo $rdateError; ?> </span>
        </div>
        
    </div>
            <hr />
            <button type="submit" href="index.php" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            <hr />
            <a href="index.php">Sign in Here...</a>
        </form>
    </div>
   

</body>
</html>