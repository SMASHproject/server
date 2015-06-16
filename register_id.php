<?php

$data = $_REQUEST['data'];
$json_obj = json_decode($data,TRUE);

$table_num = $json_obj['table_num'];
$regid = $json_obj['regid'];

if (empty($table_num) || empty($regid)) {
	echo "please input table_num and regid";
}else{
	$dbc = mysql_connect("localhost","root","1234") or die("db connect fail");

	mysql_query("set name utf8;",$dbc);

	mysql_select_db("MIT",$dbc) or die("db select fail");

	$query1 = "SELECT table_num FROM `table` WHERE table_num = $table_num";

	$result = mysql_query($query1);

	if($row = mysql_fetch_assoc($result)) {
		//Table already registered
		$query_update = "UPDATE `table` set regid = '$regid' where  table_num = '$table_num'";

		$result = mysql_query($query_update);

		if ($result) {	
				echo 'accept';			
		}else{
				echo 'not accept';		
		}
	
	}else {
		//first registration
		$query_insert = "INSERT INTO `table`(`table_num`, `regid`) VALUES ($table_num,'$regid')";

		$result = mysql_query($query_insert);
	
		if ($result) {	
				echo 'accept';			
		}else{
				echo 'not accept';		
		}
	}

	

	mysql_close($dbc);
}

?>