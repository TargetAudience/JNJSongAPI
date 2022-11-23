<?php 
include_once "../conn.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$data_post = (array)json_decode(file_get_contents("php://input"));
$id = isset($data_post['id'])?$data_post['id']:'';
$sort_no = isset($data_post['sort_no'])?$data_post['sort_no']:'';
if(empty($sort_no) || empty($id)){
    echo json_encode(array("response" => 0, "code"=>200, "message" => "Please fill required fields!"));
    exit;
}
$sqll ="UPDATE videos set sort_no=$sort_no Where id=$id";
$query = mysqli_query($con, $sqll);
$sqli_error='';
if(mysqli_error($con)){
    $sqli_error=mysqli_error($con); 
}
if(mysqli_affected_rows($con) > 0){
    echo json_encode(array("response" => 1, "code"=>201, "message" => "Sort No Updated!"));
    exit;
}else{
    echo json_encode(array("response" => 0, "code"=>200, "message" => "No record updated!".$sqli_error));
    exit;
}