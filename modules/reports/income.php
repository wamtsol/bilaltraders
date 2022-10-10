<?php
if(!defined("APP_START")) die("No Direct Access");
$extra='';
$is_search=true;
if(isset($_GET["date_from"])){
	$date_from=slash($_GET["date_from"]);
	$_SESSION["reports"]["income"]["date_from"]=$date_from;
}

if(isset($_SESSION["reports"]["income"]["date_from"]))
	$date_from=$_SESSION["reports"]["income"]["date_from"];
else
	$date_from=date('01/m/Y');

if($date_from != ""){
	$extra.=" and datetime_added>='".date('Y-m-d',strtotime(date_dbconvert($date_from)))." 00:00:00'";
}
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["reports"]["income"]["date_to"]=$date_to;
}

if(isset($_SESSION["reports"]["income"]["date_to"]))
	$date_to=$_SESSION["reports"]["income"]["date_to"];
else
	$date_to=date('d/m/Y');

if($date_to != ""){
	$extra.=" and datetime_added<='".date('Y-m-d',strtotime(date_dbconvert($date_to)))." 23:59:59'";
}
if( empty( $extra ) ) {
	$extra = ' and 1=0 ';
}
$order_by = "datetime_added";
$order = "desc";
$orderby = $order_by." ".$order;
?>
<div class="page-header">
	<h1 class="title">Reports</h1>
  	<ol class="breadcrumb">
    	<li class="active">Income report</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a> 
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
                <input type="hidden" name="tab" value="income" />
                <span class="col-sm-2 text-to">From</span>
                <div class="col-sm-3">
                    <input type="text" title="Enter Date From" name="date_from" id="date_from" placeholder="" class="form-control date-picker"  value="<?php echo $date_from?>" autocomplete="off">
                </div>
                <span class="col-sm-2 text-to">To</span>
                <div class="col-sm-3">
                    <input type="text" title="Enter Date To" name="date_to" id="date_to" placeholder="" class="form-control date-picker"  value="<?php echo $date_to?>" autocomplete="off">
                </div>
                
                <div class="col-sm-2 text-left">
                    <input type="button" class="btn btn-danger btn-l reset_search" value="Reset" alt="Reset Record" title="Reset Record" />
                    <input type="submit" class="btn btn-default btn-l" value="Search" alt="Search Record" title="Search Record" />
                </div>
          	</form>
        </div>
  	</li>
</ul>
<div class="panel-body table-responsive">
	<table class="table table-hover list">
    	<?php
		$sql="select sum(total_items), sum(total_price), sum(discount), sum(net_price) from sales where 1 $extra";
		$total_sale=dofetch(doquery($sql, $dblink));
		$sql="select sum(total_price)-sum(discount) as total from purchase where status = 1 $extra";
		$purchase_total=dofetch(doquery($sql, $dblink));
		if($purchase_total[ "total" ]==0){
			$sql="select sum(unit_price) as total from items where status = 1";
			$items_total=dofetch(doquery($sql, $dblink));
		}
		else{
			$items_total = 0;
		}
		?>
    	<tr>
            <th class="text-right">Total Items Sold</th>
            <th class="text-right"><?php echo $total_sale[ "sum(total_items)" ]?></th>
        </tr>
        <tr>
            <th class="text-right">Total Price</th>
            <th class="text-right">Rs. <?php echo curr_format($total_sale[ "sum(total_price)" ])?></th>
        </tr>
        <tr>
            <th class="text-right">Total Discount</th>
            <th class="text-right" >Rs. <?php echo curr_format($total_sale[ "sum(discount)" ])?></th>
        </tr>
        <tr class="head">
            <th class="text-right">Net Total</th>
            <th class="text-right" >Rs. <?php echo curr_format($total_sale[ "sum(net_price)" ])?></th>
        </tr>
        <tr>
            <th class="text-right">Total Purchase</th>
            <th class="text-right" >Rs. <?php echo $purchase_total[ "total" ]==0?curr_format($items_total[ "total" ]):curr_format($purchase_total[ "total" ])?></th>
        </tr>
        <?php
		$total = 0;
		$rs = doquery( "select title, sum(amount) as total, datetime_added from expense a left join expense_category b on a.expense_category_id = b.id where a.status=1 $extra group by a.expense_category_id", $dblink );
		if( numrows( $rs ) > 0 ) {
			while( $r = dofetch( $rs ) ) {
				if( $r[ "total" ] > 0 ){
					$total += $r[ "total" ];
					?>
					<tr>
						<td class="text-right"><?php echo unslash( $r[ "title" ] )?></td>
						<td class="text-right" >Rs. <?php echo curr_format($r[ "total" ])?></td>
					</tr>	
					<?php
				}
			}
		}
		?>
        <tr class="head">
            <th class="text-right">Total Expense</th>
            <th class="text-right" ><?php echo curr_format($total)?></th>
        </tr>
		<?php
		$payment_total = 0;
		$rs = doquery( "select customer_name, business_name, sum(amount) as total, datetime_added from customer_payment a left join customer b on a.customer_id = b.id where a.status=1 $extra group by a.customer_id", $dblink );
		if( numrows( $rs ) > 0 ) {
			while( $r = dofetch( $rs ) ) {
				if( $r[ "total" ] > 0 ){
					$payment_total += $r[ "total" ];
					?>
					<tr>
						<td class="text-right"><?php echo unslash( $r[ "business_name" ] )?></td>
						<td class="text-right" >Rs. <?php echo curr_format($r[ "total" ])?></td>
					</tr>	
					<?php
				}
			}
		}
		?>
        <tr class="head">
            <th class="text-right">Total Payment</th>
            <th class="text-right" ><?php echo curr_format($payment_total)?></th>
        </tr>
		<?php
		$supplier_payment_total = 0;
		$rs = doquery( "select supplier_name, sum(amount) as total, datetime_added from supplier_payment a left join supplier b on a.supplier_id = b.id where a.status=1 $extra group by a.supplier_id", $dblink );
		if( numrows( $rs ) > 0 ) {
			while( $r = dofetch( $rs ) ) {
				if( $r[ "total" ] > 0 ){
					$supplier_payment_total += $r[ "total" ];
					?>
					<tr>
						<td class="text-right"><?php echo unslash( $r[ "supplier_name" ] )?></td>
						<td class="text-right" >Rs. <?php echo curr_format($r[ "total" ])?></td>
					</tr>	
					<?php
				}
			}
		}
		?>
        <tr class="head">
            <th class="text-right">Total Payment Supplier</th>
            <th class="text-right" ><?php echo curr_format($supplier_payment_total)?></th>
        </tr>
		<tr class="head bg-success">
            <th class="text-right">Net Income</th>
            <th class="text-right" >Rs. <?php echo curr_format($total_sale[ "sum(net_price)" ]-$total-$items_total["total"])?></th>
        </tr>
  	</table>
</div>
