<?php 
include_once "../conn.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$content = (array)json_decode(file_get_contents('php://input'), TRUE);

if (!function_exists("checkUniqueEmail")){
    function checkUniqueEmail($email)
    {
        global $con;
        $output=null;
        $result = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM clients WHERE email='".$email."'"));
        if (isset($result['email']))
        {
            $output = $result;
        }
        return $output;
    }
}

$email = isset($content['email']) ? $content['email'] :'';

$error_message = null;
$error = null;

if(empty($email)){
    $error = 1;
    $error_message = 'Email is required!';
}
if(isset($error) && $error=1){
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => $error_message));
    exit();
}
$email_exist =  checkUniqueEmail($email); 


if(isset($email_exist['email']) && !empty($email_exist['email'])){
    $user_id = $email_exist['id'];
    $random_number = rand(1000,9999);
    include_once("../includes/functions.php");
    $data['email'] =$email; 
    $date=date('Y-m-d H:i:s');
    $message['subject'] = 'Forget Password Email';
    $message['body'] = "<b>Hello " . $email_exist['first_name'] .' ' .$email_exist['last_name']. " </b>";
    $message['body'] .= '<p>Your otp is:</p>';
    $message['body'] .= '<p>'.$random_number.'</p>';
    $send = sendEmail($data, $message);
    $code = http_response_code(201);
    mysqli_query($con,"UPDATE clients set forget_otp='$random_number' where id=$user_id");
    echo json_encode(array("response" => 1, "code"=>$code, "message" => "OTP sent to your email!", "otp"=>$random_number));
    exit();
    
}else{
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Incorrect email!"));
    exit();
}

$code = http_response_code(200);
echo json_encode(array("response" => 0, "code"=>$code, "message" => "Error occured try again later!"));
exit();