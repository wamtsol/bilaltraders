<?php
include("include/db.php");
include("include/utility.php");
include("include/session.php");
include("include/paging.php");
define("APP_START", 1);
$filename = 'purchase_manage.php';
include("include/admin_type_access.php");
$tab_array=array("list", "status", "delete", "bulk_action", "get_unit_price","get_quantity", "report","addedit", "print", "single_print_item", "csv_report");
if(isset($_REQUEST["tab"]) && in_array($_REQUEST["tab"], $tab_array)){
	$tab=$_REQUEST["tab"];
}
else{
	$tab="list";
}
$q="";
$extra='';
$is_search=false;
if(isset($_GET["date_from"])){
	$date_from=slash($_GET["date_from"]);
	$_SESSION["purchase"]["list"]["date_from"]=$date_from;
}
if(isset($_SESSION["purchase"]["list"]["date_from"]))
	$date_from=$_SESSION["purchase"]["list"]["date_from"];
else
	$date_from="";
if($date_from != ""){
	$extra.=" and datetime_added>='".date_dbconvert($date_from)."'";
	$is_search=true;
}
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["purchase"]["list"]["date_to"]=$date_to;
}
if(isset($_SESSION["purchase"]["list"]["date_to"]))
	$date_to=$_SESSION["purchase"]["list"]["date_to"];
else
	$date_to="";
if($date_to != ""){
	$extra.=" and datetime_added<='".date_dbconvert($date_to)."'";
	$is_search=true;
}
if(isset($_GET["q"])){
	$q=slash($_GET["q"]);
	$_SESSION["purchase"]["list"]["q"]=$q;
}
if(isset($_SESSION["purchase"]["list"]["q"]))
	$q=$_SESSION["purchase"]["list"]["q"];
else
	$q="";
if(!empty($q)){
	$extra.=" and (supplier_name like '%".$q."%' or supplier_code like '%".$q."%')";
	$is_search=true;
}
if(isset($_GET["item_id"])){
	$item_id=slash($_GET["item_id"]);
	$_SESSION["purchase"]["list"]["item_id"]=$item_id;
}
if(isset($_SESSION["purchase"]["list"]["item_id"]))
	$item_id=$_SESSION["purchase"]["list"]["item_id"];
else
	$item_id="";
if($item_id!=""){
	$extra.=" and a.id in (select purchase_id from purchase_items where item_id = '".$item_id."')";
	$is_search=true;
}
$order_by = "datetime_added";
$order = "desc";
if( isset($_GET["order_by"]) ){
	$_SESSION["purchase"]["list"]["order_by"]=slash($_GET["order_by"]);
}
if( isset( $_SESSION["purchase"]["list"]["order_by"] ) ){
	$order_by = $_SESSION["purchase"]["list"]["order_by"];
}
if( isset($_GET["order"]) ){
	$_SESSION["purchase"]["list"]["order"]=slash($_GET["order"]);
}
if( isset( $_SESSION["purchase"]["list"]["order"] ) ){
	$order = $_SESSION["purchase"]["list"]["order"];
}
if(isset($_GET["supplier_id"])){
	$supplier_id=slash($_GET["supplier_id"]);
	$_SESSION["purchase"]["supplier_id"]=$supplier_id;
}
if(isset($_SESSION["purchase"]["supplier_id"]))
	$supplier_id=$_SESSION["purchase"]["supplier_id"];
else
	$supplier_id="";
if($supplier_id!=""){
	$extra.=" and supplier_id='".$supplier_id."'";
    $is_search=true;
}

$orderby = $order_by." ".$order;
$sql="select a.*, b.supplier_name, b.supplier_code, phone, address, sum(quantity_sold) as quantity_sold, total_items-sum(quantity_sold) as remaining_stock from purchase a left join supplier b on a.supplier_id = b.id left join purchase_items c on a.id = c.purchase_id where 1 $extra group by id order by $orderby";
switch($tab){
	case 'addedit':
		include("modules/purchase/addedit_do.php");
	break;
	case 'delete':
		include("modules/purchase/delete_do.php");
	break;
	case 'status':
		include("modules/purchase/status_do.php");
	break;
	case 'bulk_action':
		include("modules/purchase/bulkactions.php");
	break;
	case 'report':
		include("modules/purchase/report.php");
		die;
	break;
	case 'print':
		include("modules/purchase/print.php");
		die;
	break;
	case 'single_print_item':
		include("modules/purchase/single_print_item.php");
		die;
	break;
	case 'csv_report':
		include("modules/purchase/csv_report.php");
		die;
	break;
}
?>
<?php include("include/header.php");?>
  <div class="container-widget row">
    <div class="col-md-12">
      <?php
		switch($tab){
			case 'list':
				include("modules/purchase/list.php");
			break;
			case 'addedit':
				include("modules/purchase/addedit.php");
			break;
		}
      ?>
    </div>
  </div>
</div>
<?php include("include/footer.php");?>