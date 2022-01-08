<?php
include '../Config/Database.php';
// include '../models/Users.php';

include '../Formater/Format.php';

$fm=new Format();

$db=new Database();
$conn=$db->connect();
 // $users = new Users($db);

if(isset($_POST['submit'])){
	$email=$_POST['email'];
	$pass=$_POST['password'];
  $type=$_POST['types'];
  if(empty($email)||empty($pass)||empty($type)){
    header("Location: loginform.php?error=emptyinputfield");

  }else{
    $email=$fm->validation($email);
    $pass=$fm->validation($pass);
    $type=$fm->validation($type);


    $query = "INSERT INTO users(email, password, types) VALUES (:email,:pass,:types)";
          // Prepare statement
    $stmt = $conn->prepare($query);
      // Bind Param
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);

    $stmt->bindParam(':types', $type);


    if($type=='consumer'){
      if($stmt->execute()){
        $userid=$conn->lastInsertId();
        $metername="meter".$userid;
        $sql1="INSERT INTO meters( user_id, meter_name) VALUES (:uid,:mname)";
        $stmt=$conn->prepare($sql1);
        $stmt->bindParam(':uid',$userid);
        $stmt->bindParam(':mname',$metername);
        $stmt->execute();
        header("Location: ../addusers.php?success=addUserSuccessfully");
      };
    }else{
     if($stmt->execute()){
      header("Location: ../addusers.php?success=addUserSuccessfully");
    };

  }

      // Execute query


}
}else{
	header("Location: login.php?error=plzlogin");


}



?>