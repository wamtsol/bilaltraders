<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["customer_add"])){
	extract($_POST);
	$err="";
	if(empty($customer_name))
		$err="Fields with (*) are Mandatory.<br />";
	if($err==""){
		$sql="INSERT INTO customer (business_name, customer_name, city, state, country, address, phone, balance) VALUES ('".slash($business_name)."','".slash($customer_name)."','".slash($city)."','".slash($state)."','".slash($country)."','".slash($address)."','".slash($phone)."','".slash($balance)."')";
		doquery($sql,$dblink);
		unset($_SESSION["customer_manage"]["add"]);
		header('Location: customer_manage.php?tab=list&msg='.url_encode("Successfully Added"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["customer_manage"]["add"][$key]=$value;
		header('Location: customer_manage.php?tab=add&err='.url_encode($err));
		die;
	}
}