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

$first_name = isset($content['first_name']) ? $content['first_name'] :'';
$last_name = isset($content['last_name']) ? $content['last_name'] :'';
$full_name = $first_name.' '.$content['last_name'];
$email = isset($content['email']) ? $content['email'] :'';

$password = isset($content['password']) ? md5($content['password']) :'';
$pass_string = isset($content['password']) ? $content['password'] :'';
$user_type = 0;
$error_message = null;
$error = null;
if(empty($first_name)){
    $error = 1;
    $error_message = 'First Name is required!';
}
if(empty($last_name)){
    $error = 1;
    $error_message = 'Last Name is required!';
}
if(empty($email)){
    $error = 1;
    $error_message = 'Email is required!';
}
if(empty($password)){
    $error = 1;
    $error_message = 'Password is required!';
}
if(isset($error) && $error=1){
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => $error_message));
    exit();
}
$email_exist =  checkUniqueEmail($email); 
$random_number = rand(1000,9999);
include_once("../includes/functions.php");
$data['email'] =$email; 
$date=date('Y-m-d H:i:s');
$message['subject'] = 'Account Registration';
$message['body'] = "<b>Hello " . $full_name . " </b>";
$message['body'] .= '<p>Thank you for registering with Jermy and Jazzy</p>';
$message['body'] .= '<p>Your security verification number is:</p>';
$message['body'] .= '<p>'.$random_number.'</p>';
if(isset($email_exist['email']) && !empty($email_exist['email'])){
    if(isset($email_exist['status']) && $email_exist['status']==9){
        // $send = sendEmail($data, $message);
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Account already registered against this email!"));
        exit();
    }else{
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Email Already Exists!"));
        exit();
    }
}
if(isset($type) && $type=='customer'){
    $user_type = 1;
}
$email_exp = explode("@",$email);
$user_name = $email_exp[0];

$send = sendEmail($data, $message);
// echo $send;
// $path = BASE_URL . 'admin/customer_detail.php?customer_id=1';
// $message['body'] = '<p>New User Account has been created</p>';
// $message['body'] .= '<p>Click below link to view customer.</p>';
// $message['body'] .= "<a href='$path'>$path</a>";
// sendEmailToAdmin($data, $message);
$status = 9;
if($send==1){
    $insert_query = "INSERT INTO clients (first_name,last_name,email,user_name,password,pass_string,mobile,status,created_at) Values('$first_name','$last_name','$email','$user_name','$password','$pass_string','$mobile','$status','$date')";
    
    $isert_record = mysqli_query($con, $insert_query);
    $last_id = mysqli_insert_id($con);
    if ($last_id > 0) {
        $code = http_response_code(201);
        mysqli_query($con,"UPDATE clients set email_otp = '$random_number' where id = $last_id");
        echo json_encode(array("response" =>1, "user_id"=>$last_id,  "code"=> $code, 'id' => $last_id, "message"=>"Email Sent! Please verify your email!!!"));
        exit();
    } else {
        $code = http_response_code(200);
        echo json_encode(array("response" => 0, "code"=>$code, "message" => "Wrong email or password!"));
        exit();
    }
}else{
    $code = http_response_code(200);
    echo json_encode(array("response" => 0, "code"=>$code, "message" => "Invalid Email!"));
    exit();
}
