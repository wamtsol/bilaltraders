<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["unit_add"])){
	extract($_POST);
	$err="";
	if(empty($title))
		$err="Fields with (*) are Mandatory.<br />";
	if($err==""){
		$sql="INSERT INTO units (title, short_title) VALUES ('".slash($title)."', '".slash($short_title)."')";
		doquery($sql,$dblink);
		$id=inserted_id();
		unset($_SESSION["unit_manage"]["add"]);
		header('Location: unit_manage.php?tab=list&msg='.url_encode("Successfully Added"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["unit_manage"]["add"][$key]=$value;
		header('Location: unit_manage.php?tab=add&err='.url_encode($err));
		die;
	}
}