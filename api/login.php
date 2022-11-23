<?php 
include_once "../conn.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$data_post = (array)json_decode(file_get_contents("php://input"));
$email = mysqli_real_escape_string($con, $data_post['email']);
$email = strtolower($email);
$password = mysqli_real_escape_string($con, $data_post['password']);
$sqll ="SELECT id, first_name,last_name,email,user_name , status from clients where LOWER(email)='$email' AND password = '" . md5($password) . "' ";

$query = mysqli_query($con, $sqll);
$count = mysqli_num_rows($query);
if(mysqli_error($con)){
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Error occured try again later!".mysqli_error($con)));
    exit;
}
if ($count > 0) {
    $fetch = mysqli_fetch_assoc($query);
    $status = isset($fetch['status']) ? $fetch['status'] : '';
    if(isset($status) && $status==9){
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Your registration is not confirmed please confirm your registration with otp from your email!"));
        exit();
    }
    if(isset($status) && $status==0){
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Your account is blocked pleas contact adminstration to activate your account!"));
        exit();
    }
    if(isset($status) && $status==1){
        $id = $fetch['id'];
        $email = $fetch['email'];
        // mysqli_query($con,"UPDATE tbl_member set is_online=1 where id = $id");
        $code = http_response_code(201);
        echo json_encode(array("response" =>1, "code"=> $code, 'data' => $fetch));
        exit();
    }
    
} else {
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Wrong email or password!"));
    exit();
}

?>