<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', 'root', 'unitedremote_wcc');


// DISLIKE A SHOP
if (isset($_GET['dislikeshop'])) {
    
    // First, we need to check we don't already have an entry for this shop
    $check_entry_query = "SELECT * FROM users_disliked_shops WHERE email_user='". $_SESSION['email'] ."' and id_shop=". $_GET['dislikeshop'] ." LIMIT 1";
    $result = mysqli_query($db, $check_entry_query);
    
    // If not, then add the shop to his disliked ones
    if (mysqli_num_rows($result) == 0) {
        $time_start = date('Y-m-d H:i:s', strtotime('0 hour'));
        $time_end = date('Y-m-d H:i:s', strtotime('2 hour'));
        
        $query = "INSERT INTO users_disliked_shops (email_user, id_shop, start_at, end_at)
		  VALUES('". $_SESSION['email'] ."', '" .$_GET['dislikeshop'] . "', '$time_start', '$time_end')";
        //echo $query;
        mysqli_query($db, $query) or die(mysqli_error($db));
    }
    
}


// USER DELETES A PREFERRED SHOP
if (isset($_GET['deleteshopfrompreferred'])) {
    
        $query = "DELETE FROM users_shops WHERE email_user='". $_SESSION['email'] ."' and id_shop=". $_GET['deleteshopfrompreferred'] ."";
        mysqli_query($db, $query);
}

// USER ADDS A NEW PREFERRED SHOP
if (isset($_GET['addshoptopreferred'])) {
    
    // First, we need to check if the user already has the shop in his preferred shops
    $check_entry_query = "SELECT * FROM users_shops WHERE email_user='". $_SESSION['email'] ."' and id_shop=". $_GET['addshoptopreferred'] ." LIMIT 1";
    $result = mysqli_query($db, $check_entry_query);
    //$entry = mysqli_fetch_array($result);
    
    // If not, then add the shop to his preferred ones
    if (mysqli_num_rows($result) == 0) {
        // Insert the shop into the preferred shops
        $query = "INSERT INTO users_shops (email_user, id_shop)
		  VALUES('". $_SESSION['email'] ."', '" .$_GET['addshoptopreferred'] . "')";
        mysqli_query($db, $query);
        
        // Move to the preferred shops
        //header("location: preferred_shops.php");
    }
    
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "- Email is required"); }
  if (empty($password_1)) { array_push($errors, "- Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "- The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $check_entry_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $check_entry_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
    // if email already exists
    if ($user['email'] === $email) {
      array_push($errors, "- Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (email, password) 
  			  VALUES('$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: nearby_shops.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['email'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: nearby_shops.php');
        }else {
            array_push($errors, "- Wrong username/password combination");
        }
    }
}

?>