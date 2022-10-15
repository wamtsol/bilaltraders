<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_GET["id"]) && !empty($_GET["id"])){
	$sale=dofetch(doquery("select * from sales where id='".slash($_GET["id"])."'", $dblink));
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice</title>
<style>
.clearfix:after {
	content: "";
	display: table;
	clear: both;
}
#main {
width:71mm;
border:0;
}
a {
	color: #5D6975;
	text-decoration: underline;
}
body {
	position: relative;
	margin: 0;
	color: #000;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	padding: 0px
}
p{margin:0 0 5px 0}
#logo img {
    width: 100%;
	margin-bottom: 0.7em;
}
table {
	width: 100%;
	border-collapse: collapse;
	border-spacing: 0;
	margin-bottom: 10px;
}
table tr:nth-child(2n-1) td {
	background: #F5F5F5;
}
table th, table td {
	text-align: left;
}
table th {
    border: 1px solid #fff;
    color: #fff;
    font-weight: bold;
    line-height: 0.9em;
    padding: 10px 0;
    text-align: center;
	background-color:#000;
    white-space: nowrap;
}
table td {
	text-align: right;
	padding-top: 8px;
	padding-right: 2px;
	padding-bottom: 8px;
	padding-left: 2px;
	font-size:11px;
}
table tr{ font-size:10px}

table td.unit, table td.qty, table td.total {
	font-size: 1.2em;
}
table td.grand {
	border-top: 1px solid #5D6975;
}

#signcompny {
    border-top: thin solid #000;
    margin: 5px 0 0;
    padding-top: 5px;
    text-align: center;
}
footer {
	color: #5D6975;
	width: 100%;
	height: 30px;
	position: absolute;
	bottom: 0;
	border-top: 1px solid #C1CED9;
	padding: 8px 0;
	text-align: center;
}
.comnme {
	font-size: 22px;
	font-weight: bold;
}
.contentbox{display:block}

#logo {
    border-radius: 3px;
    display: block;
    font-size: 26px;
    font-weight: bold;
    margin: 10px auto 0;
    padding: 6px 15px;
	text-align: center;
}
#receipt {
    border: 1px solid;
    border-radius: 3px;
    display: block;
    font-size: 18px;
    font-weight: bold;
    line-height: 13px;
    margin: 10px auto 16px;
    padding: 5px;
    text-align: center;
    width: 82px;
}
#order {
    border: 1px solid #000000;
    border-radius: 5px;
    color: #000000;
    display: block;
    font-size: 18px;
    font-weight: bold;
    line-height: 16px;
    margin: 16px auto 20px;
    padding: 5px;
    text-align: center;
    width: 150px;
}
#logo span {
    line-height: 20px;
}
.address{
	text-align:center;
	display:block;
	font-size:11px;
}
</style>
		<script>
		function print_page(){
			printer = '<?php echo get_config( 'thermal_printer_title' );?>';
			printers = jsPrintSetup.getPrintersList().split(",");
			if( printers.indexOf( printer ) !== -1 ) {
				jsPrintSetup.setPrinter( printer );
				jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
				// set top margins in millimeters
				jsPrintSetup.setOption('marginTop', 0);
				jsPrintSetup.setOption('marginBottom', 0);
				jsPrintSetup.setOption('marginLeft', 0);
				jsPrintSetup.setOption('marginRight', 0);
				// set page header
				jsPrintSetup.setOption('headerStrLeft', '');
				jsPrintSetup.setOption('headerStrCenter', '');
				jsPrintSetup.setOption('headerStrRight', '');
				// set empty page footer
				jsPrintSetup.setOption('footerStrLeft', '');
				jsPrintSetup.setOption('footerStrCenter', '');
				jsPrintSetup.setOption('footerStrRight', '');
				jsPrintSetup.setOption('printBGColors', 1);
				// Suppress print dialog
				jsPrintSetup.setSilentPrint(true);
				// Do Print
				jsPrintSetup.printWindow(window);
				// Restore print dialog
				//jsPrintSetup.setSilentPrint(false);
			}
			else {
				alert( printer + " is not installed." );
			}
			
		}
        </script>
</head>
<body onload="print_page();">
<div id="main">
    <div id="logo">
    	<?php $reciept_logo=get_config("reciept_logo"); if(empty($reciept_logo)) echo $site_title; else { ?><img src="<?php echo $file_upload_root;?>config/<?php echo $reciept_logo?>" /><?php }?>
    </div>
    <span class="address"><?php echo nl2br(get_config("address_phone"))?></span>
    <div id="receipt" style="width: 150px">RECEIPT #<strong><?php echo $sale["id"]; ?></div>
    <?php
    $order_id = dofetch(doquery("select count(1) from sales where datetime_added >='".date("Y-m-d", strtotime($sale["datetime_added"]))." 00:00:00"."' and datetime_added<='".$sale["datetime_added"]."'", $dblink));
	$order_id = $order_id[ "count(1)" ] + 1;
	?>
    <div class="contentbox">
        <p>Date/Time: <strong style="float:right"><?php echo datetime_convert($sale["datetime_added"]); ?></strong></p>
		<p>Customer: <strong style="float:right"><?php echo get_field($sale["customer_id"], "customer", "business_name"); ?></strong></p>
		
        <table cellpadding="0" cellspacing="0" align="center" width="800" border="0" class="items">
            <tr>
                <th width="5%">S#</th>
                <th width="65%">Item</th>
                <th width="10%">Qty</th>
                <th width="10%">Rate</th>
                <th width="10%">Amount</th>
            </tr>
            <?php
            $items=doquery("select * from sales_items where sales_id='".$sale["id"]."' order by id", $dblink);
            if(numrows($items)>0){
                $sn=1;
                while($item=dofetch($items)){
					$item_name = get_field($item[ "item_id" ], "items", "title");
					
                    ?>
                    <tr>
                    	<td style="text-align:center"><?php echo $sn++?></td>
                        <td style="text-align:left;"><?php echo $item_name;?></td>
                        <td style="text-align:center; font-size:9px;"><?php echo $item["quantity"]?></td>
                        <td style="text-align:right; font-size:9px;"><?php echo curr_format($item["sale_price"])?></td>
                        <td style="text-align:right; font-size:9px;"><?php echo curr_format($item["total"])?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <hr style="border:0; border-top:1px solid #999">
        <p><strong>TOTAL</strong><strong style="float:right">Rs. <?php echo curr_format($sale["total_price"])?></strong></p>
        <p><strong>Shipping Charges</strong><strong style="float:right">Rs. <?php echo curr_format($sale["shipping_charges"])?></strong></p>
		<p><strong>Discount</strong><strong style="float:right">Rs. <?php echo curr_format($sale["discount"])?></strong></p>
        <p style="border-bottom: 1px solid #ccc;padding-bottom: 5px;"><strong>TOTAL</strong><strong style="float:right">Rs. <?php echo curr_format($sale["net_price"])?></strong></p>
		<p><strong>Note:</strong> <strong style="float:right"><?php echo unslash($sale["notes"]); ?></strong></p>
    </div>
    <div id="signcompny"><p>No Return No Exchange</p> Software developed by wamtSol http://wamtsol.com/ - 0346 3891 662</div> 
</div>
</body>
</html>
<?php
die;
}