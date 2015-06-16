<?php

$json_obj = json_decode($_REQUEST['data']);

$phone_number = $json_obj -> {'phone_number'};
$password = $json_obj-> {'password'};

if (empty($phone_number) || empty($password)) {
	echo "please input phone_num or pw";
}else{
	$dbc = mysql_connect("localhost","root","1234") or die("db connect fail");

	mysql_query("set name utf8;",$dbc);

	mysql_select_db("MIT",$dbc) or die("db select fail");

	$query = "INSERT INTO customer (phone_number,password) VALUES ('$phone_number','$password')";

	$result = mysql_query($query);
	
	if ($result) {	
			$state = 'accept';			
	}else{
			$state = 'not accept';		
	}

	$return  = array('state' => $state );

	echo json_encode($return);

	mysql_close($dbc);
}

?>