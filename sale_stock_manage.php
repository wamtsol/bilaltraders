<?php
include("include/db.php");
include("include/utility.php");
include("include/session.php");
include("include/paging.php");
define("APP_START", 1);
$filename = 'sale_stock_manage.php';
include("include/admin_type_access.php");
$tab_array=array("list", "print");
if(isset($_REQUEST["tab"]) && in_array($_REQUEST["tab"], $tab_array)){
	$tab=$_REQUEST["tab"];
}
else{
	$tab="list";
}
$q="";
$extra='';
$is_search=true;
if(isset($_GET["date_from"])){
	$date_from=slash($_GET["date_from"]);
	$_SESSION["reports"]["sales"]["date_from"]=$date_from;
}

if(isset($_SESSION["reports"]["sales"]["date_from"]))
	$date_from=$_SESSION["reports"]["sales"]["date_from"];
else
	$date_from='';

if($date_from != ""){
	$extra.=" and datetime_added>='".date('Y-m-d',strtotime(date_dbconvert($date_from)))." 00:00:00'";
}
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["reports"]["sales"]["date_to"]=$date_to;
}

if(isset($_SESSION["reports"]["sales"]["date_to"]))
	$date_to=$_SESSION["reports"]["sales"]["date_to"];
else
	$date_to='';

if($date_to != ""){
	$extra.=" and datetime_added<='".date('Y-m-d',strtotime(date_dbconvert($date_to)))." 23:59:59'";
}
if(isset($_GET["supplier_id"])){
	$supplier_id=slash($_GET["supplier_id"]);
	$_SESSION["sale_stock"]["list"]["supplier_id"]=$supplier_id;
}
if(isset($_SESSION["sale_stock"]["list"]["supplier_id"]))
	$supplier_id=$_SESSION["sale_stock"]["list"]["supplier_id"];
else
	$supplier_id="";
if(!empty($supplier_id)){
	$extra.=" and supplier_id = '".$supplier_id."'";
}
if(isset($_GET["stock_status"])){
	$stock_status=slash($_GET["stock_status"]);
	$_SESSION["sale_stock"]["list"]["stock_status"]=$stock_status;
}
if(isset($_SESSION["sale_stock"]["list"]["stock_status"]))
	$stock_status=$_SESSION["sale_stock"]["list"]["stock_status"];
else
	$stock_status="";
if( $stock_status == "1" ){
	$extra.=" having remaining_stock > 0";
}
if( $stock_status == "-1" ){
	$extra.=" having remaining_stock <= 0";
}
$order_by = "remaining_stock";
$order = "asc";
if( isset($_GET["order_by"]) ){
	$_SESSION["sale_stock"]["list"]["order_by"]=slash($_GET["order_by"]);
}
if( isset( $_SESSION["sale_stock"]["list"]["order_by"] ) ){
	$order_by = $_SESSION["sale_stock"]["list"]["order_by"];
}
if( isset($_GET["order"]) ){
	$_SESSION["sale_stock"]["list"]["order"]=slash($_GET["order"]);
}
if( isset( $_SESSION["sale_stock"]["list"]["order"] ) ){
	$order = $_SESSION["sale_stock"]["list"]["order"];
}
$orderby = $order_by." ".$order;
$sql="select c.id as item_id, c.quantity, supplier_name, concat( b.supplier_code, '-', c.item_number) as title, quantity_sold, total_items-quantity_sold as remaining_stock  from purchase a left join supplier b on a.supplier_id = b.id left join purchase_items c on a.id = c.purchase_id where 1 $extra order by $orderby";
switch($tab){
	case 'list':
		include("modules/sale_stock/list_do.php");
	break;
	case 'print':
		include("modules/sale_stock/print.php");
	break;
}
?>
<?php include("include/header.php");?>
  <div class="container-widget row">
    <div class="col-md-12">
      <?php
		switch($tab){
			case 'list':
				include("modules/sale_stock/list.php");
			break;
		}
      ?>
    </div>
  </div>
</div>
<?php include("include/footer.php");?>