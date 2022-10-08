<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["items_edit"])){
	extract($_POST);
	$err="";
	if(empty($title))
		$err="Fields with (*) are Mandatory.<br />";
	if($err==""){
		$sql="Update items set `item_category_id`='".slash($item_category_id)."', `title`='".slash($title)."', `unit_id`='".slash($unit_id )."', `alert_quantity`='".slash($alert_quantity )."',  `unit_price`='".slash($unit_price)."', `sale_price`='".slash($sale_price)."', `quantity`='".slash($quantity)."',`sortorder`='".slash($sortorder)."' where id='".$id."'";
		doquery($sql,$dblink);
		unset($_SESSION["items_manage"]["edit"]);
		header('Location: items_manage.php?tab=list&msg='.url_encode("Successfully Updated"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["items_manage"]["edit"][$key]=$value;
		header("Location: items_manage.php?tab=edit&err=".url_encode($err)."&id=$id");
		die;
	}
}
/*----------------------------------------------------------------------------------*/
if(isset($_GET["id"]) && $_GET["id"]!=""){
	$rs=doquery("select * from items where id='".slash($_GET["id"])."'",$dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		foreach($r as $key=>$value)
			$$key=htmlspecialchars(unslash($value));
		if(isset($_SESSION["items_manage"]["edit"]))
			extract($_SESSION["items_manage"]["edit"]);
	}
	else{
		header("Location: items_manage.php?tab=list");
		die;
	}
}
else{
	header("Location: items_manage.php?tab=list");
	die;
}