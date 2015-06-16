<?php
	$dbc = mysql_connect('localhost','root','1234') or die("db connect fail");

	mysql_select_db("MIT",$dbc) or die("db select fail");

	
	$find_notorder_query = "SELECT order_num ,table_num FROM order_total WHERE state ='not'";
	$not_order = mysql_query($find_notorder_query);

	if ($row = mysql_fetch_assoc($not_order)) {

		$table_num = array('table_num'=>$row['table_num']);

		$not_order = $row['order_num'];

		$collect_detail = "SELECT content,amount,price FROM order_detail NATURAL JOIN  menu WHERE order_num = '$not_order' ";
		$detail_info = mysql_query($collect_detail);

		$list_arr = array();
		while ($row1 = mysql_fetch_assoc($detail_info)) {
			$orderlist = array('content'=>$row1['content'],'amount'=>$row1['amount'],'price'=>$row1['price']);
			array_push($list_arr,$orderlist);				
		}

		$orderlist_arr=array("order_num"=>$not_order,'table_num'=>$row['table_num'],"orderlist"=>$list_arr);

		echo json_encode($orderlist_arr,JSON_UNESCAPED_UNICODE);
		unset($orderlist_arr);

		$update_query = "UPDATE order_total SET state = 'finish' WHERE order_num = '$not_order'";
		mysql_query($update_query);
	} else{
		echo "";
		

		die ();
	}
mysql_close($dbc);
	
?>
