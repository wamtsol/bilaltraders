<?php
include("include/db.php");
include("include/utility.php");
include("include/session.php");
include("include/paging.php");
define("APP_START", 1);
$filename = 'purchase_manage.php';
include("include/admin_type_access.php");
$tab_array=array("list", "status", "delete", "bulk_action", "get_unit_price","get_quantity", "report","addedit", "print", "single_print_item");
if(isset($_REQUEST["tab"]) && in_array($_REQUEST["tab"], $tab_array)){
	$tab=$_REQUEST["tab"];
}
else{
	$tab="list";
}

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