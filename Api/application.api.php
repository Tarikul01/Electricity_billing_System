<?php
include '../Config/Database.php';
include '../Formater/Format.php';


// include '../models/Users.php';
$db=new Database();
$conn=$db->connect();
 // $users = new Users($db);
$fm=new Format();

if(isset($_POST['submit'])){


	$name=$_POST['name'];
	$address=$_POST['address'];
  $message=$_POST['message'];
  $phone=$_POST['phone'];
  if(empty($name)||empty($phone) ||empty($address)||empty($message)){
    header("Location:../Applicationform.php?error=emptyinputfield");
  }
  else{
    $name=$fm->validation($name);
    $address=$fm->validation($address);
    $phone=$fm->validation($phone);
    $message=$fm->validation($message);
    $query = "INSERT INTO application(name,phone,address,message) VALUES (:name,:phone,:address,:message)";
          // Prepare statement
      $stmt = $conn->prepare($query);
      // Bind Param
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':message', $message);
 



      // Execute query
      $stmt->execute();


    header("Location:../index.php?Success=ApplicationSendSuccefully");

    // Valid Login
    // echo $stmt->rowCount();

  }


}

 


 ?>