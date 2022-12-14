<?php
include("include/db.php");
include("include/utility.php");
include("include/session.php");
include("include/paging.php");
define("APP_START", 1);
$filename = 'sales_manage.php';
include("include/admin_type_access.php");
$tab_array=array("list", "status", "delete", "bulk_action", "print","report","addedit");
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
	$_SESSION["sales_manage"]["date_from"]=$date_from;
}
if(isset($_SESSION["sales_manage"]["date_from"]))
	$date_from=$_SESSION["sales_manage"]["date_from"];
else
	$date_from="";
if($date_from != ""){
	$extra.=" and datetime_added>='".date("Y/m/d H:i:s", strtotime(date_dbconvert($date_from)))."'";
	$is_search=true;
}
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["sales_manage"]["date_to"]=$date_to;
}
if(isset($_SESSION["sales_manage"]["date_to"]))
	$date_to=$_SESSION["sales_manage"]["date_to"];
else
	$date_to="";
if($date_to != ""){
	$extra.=" and datetime_added<'".date("Y/m/d", strtotime(date_dbconvert($date_to))+3600*24)."'";
	$is_search=true;
}
if(isset($_GET["q"])){
	$q=slash($_GET["q"]);
	$_SESSION["sales_manage"]["q"]=$q;
}
if(isset($_SESSION["sales_manage"]["q"]))
	$q=$_SESSION["sales_manage"]["q"];
else
	$q="";
if(!empty($q)){
	$extra.=" and (customer_name like '%".$q."%' or id='".$q."')";
	$is_search=true;
}
if(isset($_GET["item_id"])){
	$item_id=slash($_GET["item_id"]);
	$_SESSION["sales_manage"]["item_id"]=$item_id;
}
if(isset($_SESSION["sales_manage"]["item_id"]))
	$item_id=$_SESSION["sales_manage"]["item_id"];
else
	$item_id="";
if($item_id!=""){
	$extra.=" and id in (select sales_id from sales_items where item_id = '".$item_id."')";
	$is_search=true;
}
if(isset($_GET["stock_type"])){
	$stock_type=slash($_GET["stock_type"]);
	$_SESSION["sales_manage"]["stock_type"]=$stock_type;
}
if(isset($_SESSION["sales_manage"]["stock_type"]))
	$stock_type=$_SESSION["sales_manage"]["stock_type"];
else
	$stock_type="";
if($stock_type!=""){
	$extra.=" and id in (select sales_id from sales_items where stock_type = '".$stock_type."')";
	$is_search=true;
}
$order_by = "datetime_added";
$order = "desc";
if( isset($_GET["order_by"]) ){
	$_SESSION["sales_manage"]["order_by"]=slash($_GET["order_by"]);
}
if( isset( $_SESSION["sales_manage"]["order_by"] ) ){
	$order_by = $_SESSION["sales_manage"]["order_by"];
}
if( isset($_GET["order"]) ){
	$_SESSION["sales_manage"]["order"]=slash($_GET["order"]);
}
if( isset( $_SESSION["sales_manage"]["order"] ) ){
	$order = $_SESSION["sales_manage"]["order"];
}
if(isset($_GET["customer_id"])){
	$customer_id=slash($_GET["customer_id"]);
	$_SESSION["sales_manage"]["customer_id"]=$customer_id;
}
if(isset($_SESSION["sales_manage"]["customer_id"]))
	$customer_id=$_SESSION["sales_manage"]["customer_id"];
else
	$customer_id="";
if($customer_id!=""){
	$extra.=" and customer_id='".$customer_id."'";
    $is_search=true;
}
$orderby = $order_by." ".$order;
$sql="select * from sales where 1 $extra order by $orderby";
switch($tab){
	case 'addedit':
		include("modules/sales/addedit_do.php");
	break;
	case 'delete':
		include("modules/sales/delete_do.php");
	break;
	case 'status':
		include("modules/sales/status_do.php");
	break;
	case 'bulk_action':
		include("modules/sales/bulkactions.php");
	break;
	case "print":
		include("modules/sales/print.php");
	break;
	case 'report':
		include("modules/sales/report.php");
		die;
	break;
}
?>
<?php include("include/header.php");?>
  <div class="container-widget row">
    <div class="col-md-12">
      <?php
		switch($tab){
			case 'addedit':
				include("modules/sales/addedit.php");
			break;
			case 'list':
				include("modules/sales/list.php");
			break;
		}
      ?>
    </div>
  </div>
</div>
<?php if( isset( $_GET[ "print" ]) ){
	?>
	<iframe style="display:none" src="sales_manage.php?tab=print&id=<?php echo $_GET[ "print" ]?>"></iframe>
	<?php
}?> 
<?php include("include/footer.php");?>