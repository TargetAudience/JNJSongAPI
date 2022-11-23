<?php 
include_once "../conn.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$content = (array)json_decode(file_get_contents("php://input"));
$email = isset($content['email']) ? $content['email'] :'';
$password = isset($content['password']) ? md5($content['password']) :'';
$pass_string = isset($content['password']) ? $content['password'] :'';
if(empty($email) || empty($password)){
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Email and password are required!"));
    exit();
}
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
    $password = md5($pass_string);
    mysqli_query($con,"UPDATE clients set password = '$password', pass_string='$pass_string',status=1 where id =$user_id");
    if(mysqli_error($con)){
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Error occured try again later!".mysqli_error($con)));
        exit;
    }
    $code = http_response_code(201);
    echo json_encode(array("response" => 1, "code"=>$code, "message" => "Password changed successfully!"));
    exit();
}
$code = http_response_code(200);
echo json_encode(array("response" => 0, "code"=>$code, "message" => "Error occured try again later!"));
exit();
?>