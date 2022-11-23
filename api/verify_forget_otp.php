<?php 
include_once "../conn.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$data_post = (array)json_decode(file_get_contents("php://input"));
$email = mysqli_real_escape_string($con, $data_post['email']);
$otp = mysqli_real_escape_string($con, $data_post['otp']);
$email = strtolower($email);
$password = mysqli_real_escape_string($con, $data_post['password']);
$sqll ="SELECT * from clients where email='$email' ";
 
$query = mysqli_query($con, $sqll);
$count = mysqli_num_rows($query);
$result = mysqli_fetch_assoc($query);
$user_id = isset($result['id']) ? $result['id'] :'';
if($count == 0){
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Incorrect email!"));
    exit();
}else{
    if($result['forget_otp']==$otp){
        $code = http_response_code(201);
        echo json_encode(array("response" => 1, "code"=>$code, "message" => "OTP Matched!"));
        exit();
    }else{
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Wrong OTP Code!"));
        exit(); 
    }
}
$code = http_response_code(200);
echo json_encode(array("response" => 0, "code"=>$code, "message" => "Error occured try again later!"));
exit();
?>