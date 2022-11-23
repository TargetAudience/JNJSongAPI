<?php
include_once("conn.php");
session_start();
if (isset($_POST['signup'])) {
	$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
	$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
	$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
	$area_of_business = isset($_POST['area_of_business']) ? $_POST['area_of_business'] : '';
	$number_of_clients = isset($_POST['number_of_clients']) ? $_POST['number_of_clients'] : '';
	$test_per_month = isset($_POST['test_per_month']) ? $_POST['test_per_month'] : '';
	$comments_box = isset($_POST['comments_box']) ? $_POST['comments_box'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$con_pass = isset($_POST['con_pass']) ? $_POST['con_pass'] : '';

	if ($password != $con_pass) {
		echo json_encode(array("response" => 0, "message" => "Password not Matched!!"));
		exit;
	}
	$uniqe_email_error = false;
	$email_check = mysqli_fetch_assoc(mysqli_query($con, "SELECT email from users Where email = '$email'"));
	$uniqe_email_error = isset($email_check['email']) ? true : false;
	if ($uniqe_email_error) {
		echo json_encode(array("response" => 0, "message" => "Email Already Exists!!"));
		exit;
	}
	$password = md5($con_pass);
	$created_at = date('Y-m-d H:i:s');
	$query = mysqli_query($con, "INSERT INTO users(first_name ,last_name, email,phone, password, pass_string, status, is_verified, created_at,comments_box,test_per_month,number_of_clients,area_of_business,company_name) VALUES('" . $first_name . "','" . $last_name . "','" . $email . "','" . $phone . "','" . $password . "','" . $con_pass . "','0','1','" . $created_at . "','" . $comments_box . "','" . $test_per_month . "','" . $number_of_clients . "','" . $area_of_business . "','" . $company_name . "')");
	$insert_id = mysqli_insert_id($con);
	if ($insert_id > 0) {
		echo json_encode(array("response" => 1, "message" => "Signup Successfully! Login to continuee!!!"));
		exit;
	} else {
		echo json_encode(array("response" => 0, "message" => "Error Occured Try Again Later!!"));
		exit;
	}
}
if (isset($_POST['login'])) {
	$email = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? md5($_POST['password']) : '';
	$query = mysqli_query($con, "SELECT * from users where user_name = '$email' AND password = '$password'");
	$rows = mysqli_num_rows($query);
	$fetch = mysqli_fetch_assoc($query);
	if ($rows > 0) {
		if ($fetch['status'] == 0) {
			echo json_encode(array("response" => 0, "message" => "Account not activated please contact administrator"));
			exit;
		} else {
			$_SESSION['user_id'] = $fetch['id'];
			$_SESSION['email'] = $fetch['user_name'];
			echo json_encode(array("response" => 1, "message" => "Login Successfully!!! Redirecting....."));
			exit;
		}
	} else {
		echo json_encode(array("response" => 0, "message" => "Wrong Email or Password!!!"));
		exit;
	}
}
//
/*
first_name
last_name

user_name
email
mobile
password

status
created_at
*/
if (isset($_POST['del_multi_test']) && $_POST['del_multi_test'] == 1) {
	$ids = isset($_POST['ids']) ? rtrim($_POST['ids'], ',') : '';

	$ex_ids = explode(',', $ids);
	foreach ($ex_ids as $key => $id) {
		mysqli_query($con, "DELETE FROM tests where id= $id");
		# code...
	}
	if (count($ex_ids) > 0 && !empty($ex_ids[0])) {
		$_SESSION['suc_msg'] = "Tests deleted successfully!!!";
	} else {
		$_SESSION['err_msg'] = "Please select tests to delete!!";
	}
	echo json_encode(array("res" => 1));
}
if (isset($_POST['update_proceede']) && $_POST['update_proceede'] == 1) {
	$customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
	$test_ids = isset($_POST['test_ids']) ? rtrim($_POST['test_ids'], ',') : '';
	$client_id = isset($_POST['client_id']) ? $_POST['client_id'] : '';
	$client_name = isset($_POST['client_name']) ? $_POST['client_name'] : '';
	$total_val = isset($_POST['total_val']) ? $_POST['total_val'] : '';
	$test_ids_array = explode(',', $test_ids);
	$checkbox_tick = isset($_POST['checkbox_tick']) ? $_POST['checkbox_tick'] : '';
	$_SESSION['cart']['customer_id'] = $customer_id;
	$_SESSION['cart']['client_id'] = $client_id;
	$_SESSION['cart']['client_name'] = $client_name;
	echo json_encode(array("res" => 1));
}
if (isset($_POST['check_box_cart']) && $_POST['check_box_cart'] == 1) {
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$action = isset($_POST['action']) ? rtrim($_POST['action'], ',') : '';
	$session_cart_ids = isset($_SESSION['cart']['test_ids']) ? $_SESSION['cart']['test_ids'] : array();
	if ($action == 'add') {
		array_push($session_cart_ids, $id);
	} else {
		foreach ($session_cart_ids as $key => $id_single) {
			if ($id == $id_single) {
				unset($session_cart_ids[$key]);
			}
		}
	}
	$total_value = 0;

	foreach ($session_cart_ids as $key => $id_single) {
		$price_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT price from tests where id= $id_single"));
		// print_r($price_res);
		$total_value += $price_res['price'];
		// echo $total_value;
	}

	// die;
	$_SESSION['cart']['test_ids'] = $session_cart_ids;
	$_SESSION['cart']['total_val'] = $total_value;
	$selected_count = isset($_SESSION['cart']['test_ids']) ?  count($_SESSION['cart']['test_ids']) : 0 ;
	$html = '<h2>Session IDs</h2>';
	$test_id_array = $_SESSION['cart']['test_ids'];
	$test_names = '';
	$sr = 1;
	for ($i = 0; $i < 80; $i++) {
		$test_id = $test_id_array[$i];
		$testData = mysqli_fetch_assoc(mysqli_query($con, "SELECT * from tests where id='$test_id'"));
		
		if (isset($testData['test_name'])) {
			$test_names .= '<span style="display:block">'.$sr++.'-' . $testData['test_name'] . '</span>';  
		}
	}
	echo json_encode(array("res" => 1,"test_ids"=>$session_cart_ids,"total_val"=>$total_value,"html"=>$test_names,"count"=>$selected_count));
}
if (isset($_POST['other_charges']) && $_POST['other_charges'] == 1) {
	$other_ids = isset($_POST['other_ids']) ? rtrim($_POST['other_ids'], ',') : '';
	$total = isset($_POST['total']) ? $_POST['total'] : '';
	$_SESSION['cart']['other_ids'] = $other_ids;
	$cart_ids = $_SESSION['cart']['test_ids'];
	foreach ($cart_ids as $key => $cart_id) {
		$sql = "SELECT * from tests where id = $cart_id";
		$query = mysqli_query($con, $sql);
		$test = mysqli_fetch_assoc($query);
		$total_test_val += $test['price'];
	}
	$html = '';
	$html.='<table class="table table-bordered table-stripped"><thead><tr><td>Subtotal</td><td>'.format($total_test_val).'</td></tr></thead><tbody>';
	if (isset($_SESSION['cart']['discount_code']) && !empty($_SESSION['cart']['discount_code'])){
		$html .='<tr><td>Discount Coupon: '.$_SESSION['cart']['discount_code'].'</td><td>'.format($_SESSION['cart']['coupon_value']).'<input type="hidden" id="copun_value" value="'.$_SESSION['cart']['coupon_value'].'"></td></tr><tr><td>Total After Discount</td><td>'.format($total_test_val - $_SESSION['cart']['coupon_value']).'<input type="hidden" id="grand_total"value="'.$total_test_val - $_SESSION['cart']['coupon_value'].'"></td></tr>';
	}
	if (isset($_SESSION['cart']['shipping_id']) && !empty($_SESSION['cart']['shipping_id'])){
		$html .='<tr><td>Shipping charges</td><td>'.format(shippingChargesTotal()).'</td></tr>';
	}
	if (isset($_SESSION['cart']['other_ids']) && !empty($_SESSION['cart']['other_ids'])){
		$html.='<tr><td>Other charges</td><td>'.format(otherChargesTotal()).'</tr>';
	}
	$html.='<tr><td>Grand Total</td><td>'.format(cartGrandTotal()).'</td></tr></tbody></table>';                                    
	// $_SESSION['cart']['total_val'] = $total;
	echo json_encode(array("res" => 1,'html'=>$html));
}
if (isset($_POST['shipping_charges']) && $_POST['shipping_charges'] == 1) {
	$shipping_id = isset($_POST['shipping_id']) ? rtrim($_POST['shipping_id'], ',') : '';
	$total = isset($_POST['total']) ? $_POST['total'] : '';
	$_SESSION['cart']['shipping_id'] = $shipping_id;
	// $_SESSION['cart']['total_val'] = $total;
	$cart_ids = $_SESSION['cart']['test_ids'];
	foreach ($cart_ids as $key => $cart_id) {
		$sql = "SELECT * from tests where id = $cart_id";
		$query = mysqli_query($con, $sql);
		$test = mysqli_fetch_assoc($query);
		$total_test_val += $test['price'];
	}
	$html = '';
	$html.='<table class="table table-bordered table-stripped"><thead><tr><td>Subtotal</td><td>'.format($total_test_val).'</td></tr></thead><tbody>';
	if (isset($_SESSION['cart']['discount_code']) && !empty($_SESSION['cart']['discount_code'])){
		$html .='<tr><td>Discount Coupon: '.$_SESSION['cart']['discount_code'].'</td><td>'.format($_SESSION['cart']['coupon_value']).'<input type="hidden" id="copun_value" value="'.$_SESSION['cart']['coupon_value'].'"></td></tr><tr><td>Total After Discount</td><td>'.format($total_test_val - $_SESSION['cart']['coupon_value']).'<input type="hidden" id="grand_total"value="'.$total_test_val - $_SESSION['cart']['coupon_value'].'"></td></tr>';
	}
	if (isset($_SESSION['cart']['shipping_id']) && !empty($_SESSION['cart']['shipping_id'])){
		$html .='<tr><td>Shipping charges</td><td>'.format(shippingChargesTotal()).'</td></tr>';
	}
	if (isset($_SESSION['cart']['other_ids']) && !empty($_SESSION['cart']['other_ids'])){
		$html.='<tr><td>Other charges</td><td>'.format(otherChargesTotal()).'</tr>';
	}
	$html.='<tr><td>Grand Total</td><td>'.format(cartGrandTotal()).'</td></tr></tbody></table>';                                    
	// $_SESSION['cart']['total_val'] = $total;
	echo json_encode(array("res" => 1,'html'=>$html));
}
if (isset($_POST['check_coupon']) && $_POST['check_coupon'] == 1) {
	$discount_code = isset($_POST['discount_code']) ? $_POST['discount_code'] : '';
	$query = mysqli_query($con, "SELECT * from coupons where coupon_id = '$discount_code'");
	$rows = mysqli_num_rows($query);
	$fetch = mysqli_fetch_assoc($query);

	if ($rows > 0) {
		$today = date('Y-m-d');
		$expiry_date = $fetch['expiry_date'];
		$value = $fetch['value'];
		$type = $fetch['type'];
		$max_users = $fetch['max_users'];
		$used = $fetch['used'];
		if ($today > $expiry_date) {
			echo "Coupon Expired";
			exit;
		}
		if ($max_users <= $used) {
			echo "Coupon Limit Reached";
			exit;
		}
		$c_val = isset($_SESSION['cart']['total_val']) ? $_SESSION['cart']['total_val'] : 0;
		$coupon_value = 0;
		if ($type == 2) {
			$coupon_value = $value;
		} else {
			$coupon_value = $c_val * $value / 100;
		}
		if ($c_val > 0) {
			$_SESSION['cart']['coupon_value'] = $coupon_value;
			$_SESSION['cart']['discount_code'] = $discount_code;
		}
		echo 1;
		exit;
	} else {
		echo "Wrong Coupon Code";
		exit;
	}
}