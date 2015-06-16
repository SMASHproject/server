<?php

$dbc = mysql_connect('localhost','root','1234') or die('db connect fail');

mysql_select_db('MIT',$dbc) or die('db select fail');

$staff_list = array('staff' => $list);

$query = "SELECT staff_name ,SUM(total) FROM order_total WHERE state = 'finish' Group BY staff_name";


 $staff_total = mysql_query($query);

$return_arr = array();

while ($row = mysql_fetch_assoc($staff_total)) {
	$list =  array("name"=>$row['staff_name'],"peformance"=>$row['SUM(total)']);
	array_push($return_arr,$list);
}

echo json_encode($return_arr);
 mysql_close($dbc);
?>