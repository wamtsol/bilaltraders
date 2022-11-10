<?php
if(!defined("APP_START")) die("No Direct Access");
/*----------------------------------------------------------------------------------*/
if(isset($_GET["id"]) && $_GET["id"]!=""){
	$rs=doquery("select * from supplier where id='".slash($_GET["id"])."'",$dblink);
	if(numrows($rs)>0){
		$supplier=dofetch($rs);		
	}
}

$q="";
$extra='';
$is_search=false;
if(isset($_GET["start_date"])){
	$start_date=slash($_GET["start_date"]);
	$_SESSION["supplier_manage"]["report"][ "start_date" ]=$start_date;
}
if(isset($_SESSION["supplier_manage"]["report"][ "start_date" ]))
	$start_date=$_SESSION["supplier_manage"]["report"][ "start_date" ];
else
	$start_date=date("01/m/Y");
if(!empty($start_date)){
	$extra.=" and date>='".date('Y-m-d',strtotime(date_dbconvert($start_date)))." 00:00:00'";
	$is_search=true;
}
if(isset($_GET["end_date"])){
	$end_date=slash($_GET["end_date"]);
	$_SESSION["supplier_manage"]["report"][ "end_date" ]=$end_date;
}
if(isset($_SESSION["supplier_manage"]["report"][ "end_date" ]))
	$end_date=$_SESSION["supplier_manage"]["report"][ "end_date" ];
else
	$end_date=date("d/m/Y");
if(!empty($end_date)){
	$extra.=" and date<'".date('Y-m-d',strtotime(date_dbconvert($end_date)))." 23:59:59'";
	$is_search=true;
}
$order_by = "date";
$order = "asc";
if( isset($_GET["order_by"]) ){
	$_SESSION["supplier_manage"]["report"]["order_by"]=slash($_GET["order_by"]);
}
if( isset( $_SESSION["supplier_manage"]["report"]["order_by"] ) ){
	$order_by = $_SESSION["supplier_manage"]["report"]["order_by"];
}
if( isset($_GET["order"]) ){
	$_SESSION["supplier_manage"]["report"]["order"]=slash($_GET["order"]);
}
if( isset( $_SESSION["supplier_manage"]["report"]["order"] ) ){
	$order = $_SESSION["supplier_manage"]["report"]["order"];
}
$orderby = $order_by." ".$order;
$main_sql = array();
$main_sql[] = "select datetime_added as date, concat( 'Purchase ', if(net_price>0, 'from', 'to'),' Purchase # ', a.id, '<a href=\"purchase_manage.php?tab=addedit&id=', a.id,'\" target=\"_blank\" class=\"view-link\"> View bill</a>' ) as details, 0 as debit, net_price as credit from purchase a left join supplier b on a.supplier_id=b.id where a.status=1".(!empty($supplier["id"])?" and supplier_id='".$supplier["id"]."'":"");
$main_sql[] = "select datetime_added as date, concat( details) as details, amount as debit, 0 as credit from supplier_payment a left join supplier b on a.supplier_id=b.id where a.status=1".(!empty($supplier["id"])?" and supplier_id='".$supplier["id"]."'":"");
$main_sql="(".implode( ' union ', $main_sql ).") as total_records";
$sql = "select * from ".$main_sql." where 1 $extra order by $orderby";
$balance = dofetch( doquery( "select sum(debit)-sum(credit) as balance from ".$main_sql." where date < '".date('Y-m-d',strtotime(date_dbconvert($start_date)))." 00:00:00'", $dblink ) );
if( $order == 'desc' ) {
	$balance = get_supplier_balance( $supplier["id"], date_dbconvert($end_date)." 23:59:59" );
}
else{
	$balance = get_supplier_balance( $supplier["id"], date_dbconvert($start_date) );
}
