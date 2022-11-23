<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
ini_set('memory_limit', '-1');
// $con = mysqli_connect('localhost', 'root', '', 'video_admin');
$servername = "localhost";
$username = "glonnwas_vac_master";
$password = "4gcxI8H_fXOT";
$database = "glonnwas_api_testing";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);
if ($con->connect_errno) {
  echo "Failed to connect to MySQL: " . $con->connect_error;
  exit();
}
include_once("custom_functions.php");
$created_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$fetchUser = array();
$pay_on_credit = false;


define("CURRENCY_SIGN", "£");
define("CURRENCY", "GB");
define("BASE_URL", "https://gloneweb.com/videoApp/");
date_default_timezone_set("Asia/Karachi");

// define("SECRET_KEY", "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");
// define("PUBLISH_KEY", "pk_live_51IG3cNJAdLfZdFr6Rp5krFQwTZKzD3IFy2HwctpMFdbHLUqlD0azmvQm8HexJjLJ3D4wDiFShX56jsKbq6huSOtl00Fvzwb5TX");
define("SECRET_KEY", "sk_test_51IG3cNJAdLfZdFr6JEamduNF0mCX3TEJLCluriuzCQXOjY2thxyEnSO1b9n47qpqAOY1ZhYiR5dzda127qAUpFAk000U64Js7j");
define("PUBLISH_KEY", "pk_test_51IG3cNJAdLfZdFr6WbUo1H26tJfV9Hjo9Fh8QYfwCasaoR1qoVH4dNU0YX7Lo2jjS1uCdZ1PpirQlEyumsKed99n00njVKEQhY");