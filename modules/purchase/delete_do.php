<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_GET["id"]) && !empty($_GET["id"])){
	$id=slash($_GET["id"]);
	$rs=doquery("select * from purchase_items where purchase_id='".$id."'", $dblink);
	
	doquery("delete from purchase_items where purchase_id='".$id."'",$dblink);
	doquery("delete from purchase where id='".$id."'",$dblink);
	header("Location: purchase_manage.php");
	die;
}