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
@font-face {
    font-family: 'NafeesRegular';
    src: url('fonts/NafeesRegular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}
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
#right_title {
	font-size: 18px;
	font-style: italic;
	font-weight: bolder;
	float: right;
	margin-right: 5px;
	text-decoration: underline;
}
#center_title {
	font-size: 22px;
	font-style: normal;
	font-weight: bold;
	float: right;
	padding-top: 45px;
	text-transform: uppercase
}
#inv_status {
	margin-bottom: 30px;
	font-size: 14px;
}
#inv_status_alrt {
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	border: thin solid #666;
	float: right;
	margin-right: 5px;
	position: relative;
	padding-top: 5px;
	padding-right: 30px;
	padding-bottom: 5px;
	padding-left: 30px;
}
#project {
	float: left;
	font-size: 14px;
}
#project div {
	margin-bottom: 5px;
}
#customer {
	float: right;
	text-align: center;
	line-height: 1em;
}
#jbnum {
	width: 200px;
	padding: 5px;
	line-height: 1em;
	margin-bottom: 5px;
	background-color: #444;
	color: #fff;
}
#customer span {
	color: #000000;
	text-align: left;
	width: 52px;
	margin-right: 10px;
	display: inline-block;
	font-size: 13px;
}
#company {
	float: right;
	text-align: right;
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
.data-table td{border:1px solid #afafaf;}
.data-table td strong{text-align:right;display:block}
#th_center {
	text-align: center;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #666666;
}
#cinfo_table {
	height: auto;
	width: 49%;
	float: left;
}
#cinfo_table_cntr {
	height: auto;
	width: 260px;
	margin-left: 266px;
}
#cinfo_table_rgt {
	height: auto;
	width: 49%;
	float: right;
}
#inchk_table {
	float: left;
	width: 393px;
}
#inchk_table td {
	border: thin solid #CCCCCC;
	padding-top: 1px;
	padding-bottom: 1px;
	line-height: 1.5em;
}
#othrd_table {
	float: right;
	width: 393px;
}
#othrd_table td {
	border: thin solid #CCC;
	padding-top: 1px;
	padding-bottom: 1px;
	line-height: 1.5em;
}
.tableamount {
	text-align: right;
}
#acc {
	border: thin solid #000;
	padding-right: 15px;
	display: block;
	line-height: 20px;
}
#rbr {
	border-right-width: thin;
	border-right-style: solid;
	border-right-color: #000;
	background-color: #ccc;
	width: 100px;
	white-space: nowrap;
	float: left;
	padding-left: 10px;
}
#acc span {
	margin-left: 15px;
}
table .service, table .desc {
	text-align: left;
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
table td.service, table td.desc {
	vertical-align: top;
}
table td.unit, table td.qty, table td.total {
	font-size: 1.2em;
}
table td.grand {
	border-top: 1px solid #5D6975;
}
#notices {
	margin-top: 20px;
	float: left;
	clear: both;
	width: 100%;
}

#signcompny {
    border-top: thin solid #000;
    margin: 12px 0 0;
    padding-top: 5px;
    text-align: center;
}
#signcus {
	text-align: center;
	border-top-width: thin;
	border-top-style: solid;
	border-top-color: #000;
	margin-right: 5px;
	margin-top: 100px;
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
					$item1 = dofetch( doquery( "SELECT a.*, c.supplier_code, c.supplier_name, d.title as size_title, e.title as color_title, f.title as category_title FROM `purchase_items` a left join purchase b on a.purchase_id = b.id left join supplier c on b.supplier_id = c.id left join size d on a.size = d.id left join color e on a.color = e.id left join item_category f on a.item_category_id = f.id where a.id = '".$item[ "purchase_item_id" ]."'", $dblink ) );
					$item_name = (!empty($item1[ "supplier_code" ])?unslash($item1[ "supplier_code" ])."-":'').unslash($item1[ "item_number" ]);
					if( !empty( $item1[ "size" ] ) || !empty( $item1[ "color" ] ) ) {
						$attributes = array();
						if( !empty( $item1[ "size" ] ) ) {
							$attributes[] = 'Size: '.unslash( $item1[ "size_title" ] );
						}
						if( !empty( $item1[ "color" ] ) ) {
							$attributes[] = 'Color: '.unslash( $item1[ "color_title" ] );
						}
						if( !empty( $item1[ "item_category_id" ] ) ) {
							$attributes[] = '<br> '.unslash( $item1[ "category_title" ] );
						}
						$item_name .= ' ('.implode( ", ", $attributes ).")";
					}
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
        <p><strong>Discount</strong><strong style="float:right">Rs. <?php echo curr_format($sale["discount"])?></strong></p>
        <p><strong>TOTAL</strong><strong style="float:right">Rs. <?php echo curr_format($sale["net_price"])?></strong></p>
    </div>
    <div id="signcompny"><p>No Return No Exchange</p> Software developed by wamtSol http://wamtsol.com/ - 0346 3891 662</div> 
</div>
</body>
</html>
<?php
die;
}