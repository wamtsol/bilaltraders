<?php
if(!defined("APP_START")) die("No Direct Access");
$extra='';
$is_search=true;
if(isset($_GET["datetime_added"])){
	$datetime_added=slash($_GET["datetime_added"]);
	$_SESSION["reports"]["daily"]["datetime_added"]=$datetime_added;
}
if(isset($_SESSION["reports"]["daily"]["datetime_added"]))
	$datetime_added=$_SESSION["reports"]["daily"]["datetime_added"];
else
	$datetime_added=date("d/m/Y");

if($datetime_added != ""){
	$extra.=" and datetime_added BETWEEN '".date('Y-m-d',strtotime(date_dbconvert($datetime_added)))." 00:00:00' AND '".date('Y-m-d',strtotime(date_dbconvert($datetime_added)))." 23:59:59'";
}

$order_by = "datetime_added";
$order = "asc";
$orderby = $order_by." ".$order;
?>
<div class="page-header">
	<h1 class="title">Reports</h1>
  	<ol class="breadcrumb">
    	<li class="active">Sales report</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a> 
            <a class="btn print-btn" href="sales_manage.php?tab=report"><i class="fa fa-print" aria-hidden="true"></i></a>  
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
                <span class="col-sm-1 text-to">Date</span>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date From" name="datetime_added" id="datetime_added" placeholder="" class="form-control date-picker"  value="<?php echo $datetime_added?>" >
                </div>
                
                
                <div class="col-sm-3 text-left">
                    <input type="button" class="btn btn-danger btn-l reset_search" value="Reset" alt="Reset Record" title="Reset Record" />
                    <input type="submit" class="btn btn-default btn-l" value="Search" alt="Search Record" title="Search Record" />
                </div>
          	</form>
        </div>
  	</li>
</ul>
<div class="panel-body table-responsive">
	<table class="table table-hover list">
    	<thead>
            <tr>
                <th width="5%" class="text-center">S.no</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th class="text-right">Total Items</th>
                <th class="text-right" >Price</th>
                <th class="text-right" >Discount</th>
                <th class="text-right">Net Price</th>
            </tr>
            <tr class="head">
                <th colspan="3" class="text-right">Total</th>
                <?php
					$sql="select sum(total_items), sum(total_price), sum(discount), sum(net_price) from sales where 1 $extra order by $orderby";
					$total=dofetch(doquery($sql, $dblink));
				?>
                <th class="text-right"><?php echo $total[ "sum(total_items)" ]?></th>
                <th class="text-right">Rs. <?php echo curr_format($total[ "sum(total_price)" ])?></th>
                <th class="text-right" >Rs. <?php echo curr_format($total[ "sum(discount)" ])?></th>
                <th class="text-right" >Rs. <?php echo curr_format($total[ "sum(net_price)" ])?></th>
            </tr>
    	</thead>
    	<tbody>
			<?php 
            $sql="select * from sales where 1 $extra order by $orderby";
            $rs=show_page($rows, $pageNum, $sql);
            if(numrows($rs)>0){
                $sn=1;
                while($r=dofetch($rs)){             
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        
                        <td><?php echo datetime_convert($r["datetime_added"]); ?></td>
                        <td><?php if($r["customer_id"]==0) echo "Cash"; else echo get_field($r["customer_id"], "customer","customer_name");?></td>
                        <td class="text-right"><?php echo unslash($r["total_items"]); ?></td>
                        <td class="text-right">Rs. <?php echo curr_format(unslash($r["total_price"])); ?></td>
                        <td class="text-right">Rs. <?php echo curr_format(unslash($r["discount"])); ?></td>
                        <td class="text-right">Rs. <?php echo curr_format(unslash($r["net_price"])); ?></td>
                    </tr>
                    <?php 
                    $sn++;
                }
                ?>
                <tr>
                    <td colspan="5" class="actions">
                        <select name="bulk_action" id="bulk_action" title="Choose Action">
                            <option value="null">Bulk Action</option>
                            <option value="delete">Delete</option>
                            <option value="statuson">Set Status On</option>
                            <option value="statusof">Set Status Off</option>
                        </select>
                        <input type="button" name="apply" value="Apply" id="apply_bulk_action" class="btn btn-light" title="Apply Action"  />
                    </td>
                    <td colspan="3" class="paging" title="Paging" align="right"><?php echo pages_list($rows, "sales", $sql, $pageNum)?></td>
                </tr>
                <?php	
            }
            else{	
                ?>
                <tr>
                    <td colspan="8"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
