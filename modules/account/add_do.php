<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["account_add"])){
	extract($_POST);
	$err="";
	if(empty($title))
		$err="Fields with (*) are Mandatory.<br />";
	if($err==""){
		$sql="INSERT INTO account (title, type, description) VALUES ('".slash($title)."', '".slash($account_type)."', '".slash($description)."')";
		doquery($sql,$dblink);
		unset($_SESSION["account_manage"]["add"]);
		header('Location: account_manage.php?tab=list&msg='.url_encode("Sucessfully Added"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["account_manage"]["add"][$key]=$value;
		header('Location: account_manage.php?tab=add&err='.url_encode($err));
		die;
	}
}