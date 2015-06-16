<?php

$data = $_REQUEST['data'];
$json_obj = json_decode($data,TRUE);

$phone_number = $json_obj['phone_number'];
$password = $json_obj['password'];
$tablenum = $json_obj['table_number'];
$orderlist = $json_obj['orderlist'];

if (empty($phone_number) || empty($password) ||empty($tablenum) || empty($orderlist)) {
	echo "please input phone_num or pw";
}else{
	$dbc = mysql_connect("localhost","root","1234") or die("db connect fail");

	mysql_query("set name utf8;",$dbc);

	mysql_select_db("MIT",$dbc) or die("db select fail");

	$query = "SELECT phone_number FROM customer WHERE phone_number ='$phone_number' and password = '$password'";

	$result = mysql_query($query);

	if ($row = mysql_fetch_assoc($result)) {	
			
			#insert basic
			
			#find new order num -----------------------
			$insert_ordernum_query = "SELECT order_num FROM order_total ORDER BY order_num desc";

			$maxnum = mysql_query($insert_ordernum_query);

			if($row = mysql_fetch_assoc($maxnum)) {
			$new_ordernum = $row['order_num'] +1 ;
			}

			$insert_basic_query = "INSERT INTO order_total (order_num,phone_number,table_num) VALUES ('$new_ordernum','$phone_number','$tablenum') ";
			mysql_query($insert_basic_query) or die("11111");
			
			#--------------------- datail insert
			$total = '0';
			foreach ($orderlist as $value) {
				$name =$value['content'];
				#find menu price 
				$find_price = "SELECT price FROM menu WHERE content = '$name'";
				$find_result = mysql_query($find_price) or die("22222");

				if($row = mysql_fetch_assoc($find_result)){
					$price=$row['price'];
				}
				$amount = $value['amount'];

				$total += $amount * $price ;

				$insert_detail = "INSERT INTO order_detail(order_num,content,amount) VALUES ('$new_ordernum','$name','$amount')";
				$detail_result = mysql_query($insert_detail) or die("33333");

			}

			#--------------- here insert total 
			$insert_query = "UPDATE order_total set total = '$total' , state = 'not' WHERE order_num = '$new_ordernum' ";
			mysql_query($insert_query) or die("444444");

			#----------------------- state insert
			$state = "success";

	}else{
			$state = "fail";
	}

	$return = array('state' => $state);

	echo json_encode($return);

	mysql_close($dbc);
}

?>