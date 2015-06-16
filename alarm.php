<?php

// $json_obj = json_decode($_REQUEST['data']);

// echo $_REQUEST['data'];

// $order_num = $json_obj -> { 'order_num'};
// $state = $json_obj -> {'state'};	
// $staff = $json_obj -> {'staff_name'};
#$goback = $json_obj -> {'goback'};

$order_num = $_REQUEST['order_num'];
$state = $_REQUEST['state'];
$staff = $_REQUEST['staff'];

if ( empty($state) || empty($staff) ) {
	echo "please input phone_num or pw";
	die();
	}

$dbc = mysql_connect('localhost','root','1234') or die('db connect fail');
mysql_select_db('MIT',$dbc) or die('db select fail');

if ($state ==  'yellow') {
	#send message to tablet accept

	$staff_query = "SELECT name FROM staff_name WHERE staff_id = '$staff' ";
	$name_query = mysql_query($staff_query);

	if ($row = mysql_fetch_assoc($name_query)) {
			$staff_name =$row['name'];
		}	

	$insert_staff = "UPDATE order_total SET staff_name = '$staff_name'  WHERE order_num = $order_num";
	mysql_query($insert_staff);
}
else if($state == 'green') {
	#send message that order is finished
	#1.get table_num
	$query_get_orderinfo = "SELECT tb.regid FROM order_total ot JOIN `table` tb ON ot.table_num = tb.table_num WHERE order_num = $order_num";
	$getinfo_result = mysql_query($query_get_orderinfo);

	$regid;
	if ($row = mysql_fetch_assoc($getinfo_result)) {
		# code...
		$regid = $row['regid'];
		
	}
		//send gcm

		$headers = array( 'Content-Type:application/json', 'Authorization:key=AIzaSyAbuhbDpRnafKSfveiCvcoij5oB7-_ZKuE');

		    $arr = array();
		    $arr['data'] = array();
		    $arr['data']['title'] = 'Order Finished';
		    $arr['data']['message'] = 'To yeonhong Kim';
		    $arr['registration_ids'] = array();
		    $arr['registration_ids'][0] = $regid;

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
		     $response = curl_exec($ch);
		     curl_close($ch);

		     // 푸시 전송 결과 반환.
		     $obj = json_decode($response);

		     // 푸시 전송시 성공 수량 반환.
		     $cnt = $obj->{"success"};

		     var_dump($obj);

		    if($cnt != 1) die('GCM fail');

		    echo "SUCCESS";

		     //Update state;

	} 
	else {
		die("NOT Allowed");
	}
	//delete finished order;

?>