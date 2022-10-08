<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["items_add"])){
	extract($_POST);
	$err="";
	if(empty($title))
		$err="Fields with (*) are Mandatory.<br />";
	if($err==""){
		$sql="INSERT INTO items (item_category_id, title, unit_id, alert_quantity, unit_price, sale_price, quantity, sortorder) VALUES ('".slash($item_category_id)."','".slash($title)."','".slash($unit_id)."','".slash($alert_quantity)."','".slash($unit_price)."','".slash($sale_price)."','".slash($quantity)."','".slash($sortorder)."')";
		doquery($sql,$dblink);
		$id = inserted_id();
		unset($_SESSION["items_manage"]["add"]);
		header('Location: items_manage.php?tab=list&msg='.url_encode("Successfully Added"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["items_manage"]["add"][$key]=$value;
		header('Location: items_manage.php?tab=add&err='.url_encode($err));
		die;
	}
}