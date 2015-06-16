<?php

$payment = $_REQUEST['payment'];
$order_num = $_REQUEST['order_num'];

if (empty($payment) || empty($order_num)) {
	echo "please input pay and  order_num";
}else{
	$dbc = mysql_connect("localhost","root","1234") or die("db connect fail");

	mysql_query("set name utf8;",$dbc);

	mysql_select_db("MIT",$dbc) or die("db select fail");

	$query = "UPDATE order_total set pay= '$payment' where  order_num = '$order_num'";

	$result = mysql_query($query);
	
	if ($result) {	
			echo 'accept';			
	}else{
			echo 'not accept';		
	}

	mysql_close($dbc);
}
	
?>