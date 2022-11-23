<?php
include("conn.php");
session_start();
if(isset($_POST['save'])){
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $hash_pass = md5($password);
    $date = date('Y-m-d H:i:s');

    if(isset($_POST['edit_id']) && $_POST['edit_id'] > 0){
        $id = $_POST['edit_id'];
        mysqli_query($con,"UPDATE clients set first_name = '$first_name',last_name = '$last_name',user_name = '$user_name',email = '$email',mobile = '$mobile',password = '$hash_pass',pass_string = '$password',status = '$status',created_at = '$date' where id = $id");
        $_SESSION['s_msg']="User Updated Successfully!!";
    }else{
        mysqli_query($con,"INSERT INTO clients (first_name,last_name,email,user_name,password,pass_string,mobile,status,created_at) Values('$first_name','$last_name','$email','$user_name','$hash_pass','$password','$mobile','$status','$date')");
        $_SESSION['s_msg']="User Added Successfully!!";
    }
   
    header("Location:users.php");
}

?>