<?php
require 'config/database.php';

if (isset($_POST['submit'])){
$email = filter_var($_POST['email'], FILTER_SANITIZE_NUMBER_INT);
$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//valemailate inputs

if($email == ''){
    $_SESSION['update'] = "Please enter an email address";
}elseif($name == ''){
    $_SESSION['update'] = "please enter a name";
} elseif($password == '') {
    $_SESSION['update'] = "please enter a password";
} elseif(strlen($password) < 8){
    $_SESSION['update'] = "Password should be 8+ characters";
    } else {
    $id = $_SESSION['user-id'];
    $statement = "SELECT * FROM users WHERE id = $id";
    $statement_result = mysqli_query($connection, $statement);
    $row = mysqli_num_rows($statement_result);
    if ($row > 0) {
        $query = "UPDATE users SET email='$email' name='$name', password='$password' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)){
            $_SESSION['update'] = "Unable to update the details. ";
        } else {
            $_SESSION['update-success'] = "Your details are successfully updated";
        }
  }
}
}
header('location: '. ROOT_URL .'account.php');
