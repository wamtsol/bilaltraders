<?php
include("include/db.php");
include("include/utility.php");
include("include/session.php");
include("include/paging.php");
define("APP_START", 1);
$filename = 'sales_manage.php';
include("include/admin_type_access.php");
$tab_array=array("balance_sheet", "sales","income", "income_print", "general_journal", "general_journal_print", "balance_sheet_print", "profit_by", "profit_by_print");
if(isset($_REQUEST["tab"]) && in_array($_REQUEST["tab"], $tab_array)){
	$tab=$_REQUEST["tab"];
}
else{
	$tab="daily";
}

switch($tab){
	case 'general_journal':
		include("modules/reports/general_journal_do.php");
	break;
	case 'general_journal_print':
		include("modules/reports/general_journal_print.php");
	break;
	case 'income_print':
		include("modules/reports/income_print.php");
	break;
	case 'balance_sheet_print':
		include("modules/reports/balance_sheet_print.php");
	break;
	case 'profit_by':
		include("modules/reports/profit_by_do.php");
	break;
	case 'profit_by_print':
		include("modules/reports/profit_by_print.php");
	break;
}
?>
<?php include("include/header.php");?>
  <div class="container-widget row">
    <div class="col-md-12">
      <?php
		switch($tab){
			case 'balance_sheet':
				include("modules/reports/balance_sheet.php");
			break;
			case 'sales':
				include("modules/reports/sales.php");
			break;
			case 'income':
				include("modules/reports/income.php");
			break;
			case 'general_journal':
				include("modules/reports/general_journal.php");
			break;
			case 'profit_by':
				include("modules/reports/profit_by.php");
			break;
		}
      ?>
    </div>
  </div>
</div>
<?php include("include/footer.php");?>