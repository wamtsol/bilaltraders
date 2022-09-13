<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["stock_save"])){
	foreach( $_POST[ "item" ] as $item_id => $item ){
		doquery( "update purchase_items set quantity = '".$item[ "quantity" ]."', quantity_sold = '".$item[ "quantity_sold" ]."' where id = '".$item_id."'", $dblink );
	}
	header('Location: stock_manage.php?msg='.url_encode("Stock Updated."));
	die;
}