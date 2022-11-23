<?php
if (!function_exists('format')) {
    function format($number)
    {
        $format = CURRENCY_SIGN.number_format($number,2);
        return $format;
    }
}
if (!function_exists('getUserById')) {
    function getUserById($id)
    {
        global $con;
        $name = '';
        $query  = mysqli_query($con, "SELECT * from users where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        if (isset($fetch['first_name'])) {
            $name .= $fetch['first_name'];
        }
        if (isset($fetch['last_name'])) {
            $name .= ' ' . $fetch['last_name'];
        }
        return $name;
    }
}
if (!function_exists('getCustomerAddress')) {
    function getCustomerAddress($id)
    {
        global $con;
        $name = '';
        $query  = mysqli_query($con, "SELECT * from customers where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        if (isset($fetch['address'])) {
            $name .= $fetch['address'];
        }
        if (isset($fetch['town'])) {
            $name .= ' ' . $fetch['town'];
        }
        if (isset($fetch['country'])) {
            $name .= ' ' . $fetch['country'];
        }
        if (isset($fetch['postal_code'])) {
            $name .= ' ' . $fetch['postal_code'];
        }
        return $name;
    }
}
if (!function_exists('getCustomerDateBirht')) {
    function getCustomerDateBirht($id)
    {
        global $con;
        $name = '';
        $query  = mysqli_query($con, "SELECT * from customers where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        if (isset($fetch['date_of_birth'])) {
            $name .= $fetch['date_of_birth'];
        }
        return $name;
    }
}
if (!function_exists('getUserBalance')) {
    function getUserBalance($id)
    {
        global $con;
        $query  = mysqli_query($con, "SELECT * from users where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        return isset($fetch['credit_balance']) ? $fetch['credit_balance'] : 0;
    }
}
if (!function_exists('getTests')) {
    function getTests($ids)
    {
        global $con;
        $return_names = '';
        $ids_array = explode(',', $ids);
        for ($i = 0; $i < count($ids_array); $i++) {
            $id = $ids_array[$i];
            $query  = mysqli_query($con, "SELECT * from tests where id=$id");
            $fetch = mysqli_fetch_assoc($query);
            $return_names .= $fetch['test_name'] . ",";
        }
        return rtrim($return_names, ',');
    }
}
if (!function_exists('getShippingType')) {
    function getShippingType($ids)
    {
        global $con;
        $return_names = '';
        if (!empty($ids)) {
            $ids_array = explode('_', $ids);
            $id = $ids_array[0];
            $string = isset($ids_array[1]) ? $ids_array[1] : '';
            $query  = mysqli_query($con, "SELECT * from shiping_types where id=$id");
            $fetch = mysqli_fetch_assoc($query);
            $return_names = isset($string) && !empty($string) ? $fetch['name'] . ' - ' . $string : $fetch['name'];
            return $return_names;
        }
    }
}
if (!function_exists('getOtherChargesList')) {
    function getOtherChargesList($ids)
    {
        global $con;
        $return_names = '';
        $ids_array = explode(',', $ids);
        if(!empty($ids)){
            $return_names .="<ul>";
            for ($i = 0; $i < count($ids_array); $i++) {
                $id = $ids_array[$i];
                $query  = mysqli_query($con, "SELECT * from other_charges where id=$id");
                $fetch = mysqli_fetch_assoc($query);
                // $return_names .= $fetch['name'] . ",";
                $return_names .="<li>".$fetch['name']. "</li>";
            }
            $return_names .="</ul>"; 
        }
        return rtrim($return_names, ',');
    }
}
if (!function_exists('getOtherCharges')) {
    function getOtherCharges($ids)
    {
        global $con;
        $return_names = '';
        $ids_array = explode(',', $ids);
        for ($i = 0; $i < count($ids_array); $i++) {
            $id = $ids_array[$i];
            $query  = mysqli_query($con, "SELECT * from other_charges where id=$id");
            $fetch = mysqli_fetch_assoc($query);
            $return_names .= $fetch['name'] . ",";
        }
        return rtrim($return_names, ',');
    }
}
if (!function_exists('shippingChargesTotal')) {
    function shippingChargesTotal()
    {
        global $con;
        $shiping_charges = 0;
        $id = isset($_SESSION['cart']['shipping_id']) ? $_SESSION['cart']['shipping_id'] : '';
        $query  = mysqli_query($con, "SELECT value from shiping_types where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        $shiping_charges = $fetch['value'];
        return $shiping_charges;
    }
}
if (!function_exists('otherChargesTotal')) {
    function otherChargesTotal()
    {
        global $con;
        $other_charges = 0;
        $ids = isset($_SESSION['cart']['other_ids']) ? $_SESSION['cart']['other_ids'] : '';
        if (!empty($ids)) {
            $ids_array = explode(',', $ids);
            for ($i = 0; $i < count($ids_array); $i++) {
                $id = $ids_array[$i];
                $query  = mysqli_query($con, "SELECT value from other_charges where id=$id");
                $fetch = mysqli_fetch_assoc($query);
                $other_charges += $fetch['value'];
            }
        }
        return $other_charges;
    }
}
if (!function_exists('cartGrandTotal')) {
    function cartGrandTotal()
    {
        global $con;
        $other_charges = 0;
        $ids = isset($_SESSION['cart']['other_ids']) ? $_SESSION['cart']['other_ids'] : '';
        if (!empty($ids)) {
            $ids_array = explode(',', $ids);
            for ($i = 0; $i < count($ids_array); $i++) {
                $id = $ids_array[$i];
                $query  = mysqli_query($con, "SELECT value from other_charges where id=$id");
                $fetch = mysqli_fetch_assoc($query);
                $other_charges += $fetch['value'];
            }
        }
        $shiping_charges = 0;
        $id = isset($_SESSION['cart']['shipping_id']) ? $_SESSION['cart']['shipping_id'] : '';
        $query  = mysqli_query($con, "SELECT value from shiping_types where id=$id");
        $fetch = mysqli_fetch_assoc($query);
        $shiping_charges = $fetch['value'];
        $cart_total = 0;
        $cart_ids = isset($_SESSION['cart']['test_ids']) ? $_SESSION['cart']['test_ids'] : '';
        if (!empty($cart_ids)) {
            for ($i = 0; $i < count($cart_ids); $i++) {
                $test_id = $cart_ids[$i];
                $query  = mysqli_query($con, "SELECT price from tests where id=$test_id");
                $fetch = mysqli_fetch_assoc($query);
                $cart_total += $fetch['price'];
            }
        }
        $discount_value = isset($_SESSION['cart']['coupon_value']) ? $_SESSION['cart']['coupon_value'] : 0;
        return $cart_total + $shiping_charges + $other_charges - $discount_value;
    }
}
if (!function_exists('UserBalance')) {
    function UserBalance()
    {
        global $con;
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $totalcr_q = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(credit_amount) as total_credit from credit_requests where user_id = " . $user_id));
        $totalUserCredit  = isset($totalcr_q['total_credit']) ? $totalcr_q['total_credit'] : 0;

        $total_paid_q = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total_val) as total_paid from orders where created_by = " . $user_id . " AND payment_status = 'Paid'"));
        $paidCredit  = isset($total_paid_q['total_paid']) ? $total_paid_q['total_paid'] : 0;
        $balance = $totalUserCredit - $paidCredit;
        return $balance;
    }
}