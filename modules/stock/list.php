<?php
if(!defined("APP_START")) die("No Direct Access");

?>
<div class="page-header">
	<h1 class="title">Manage Stock</h1>
  	<ol class="breadcrumb">
    	<li class="active">Stock Details</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
            <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a>
            <a class="btn print-btn" href="stock_manage.php?tab=print"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
            	<span class="col-sm-2 text-to">From</span>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date From" name="date_from" id="date_from" placeholder="" class="form-control date-picker"  value="<?php echo $date_from?>" >
                </div>
                <span class="col-sm-2 text-to">To</span>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date To" name="date_to" id="date_to" placeholder="" class="form-control date-picker"  value="<?php echo $date_to?>" >
                </div>
            	<!-- <div class="col-sm-3">
                  <select name="supplier_id">
                  	<option value="">All Suppliers</option>
                    <?php
                    $rs = doquery( "select * from supplier where status = 1", $dblink );
					if( numrows( $rs ) > 0 ) {
						while( $r = dofetch( $rs ) ) {
							?>
							<option value="<?php echo $r[ "id" ]?>"<?php echo $supplier_id==$r[ "id" ]?" selected":""?>><?php echo unslash($r[ "supplier_name" ])?></option>
							<?php
						}
					}
					?>
                  </select>
                </div> -->
                <!-- <div class="col-sm-2">
                  <select name="stock_status">
                  	<option value="1"<?php echo $stock_status=="1"?" selected":""?>>Available Stock</option>
                    <option value="-1"<?php echo $stock_status=="-1"?" selected":""?>>Unavailable Stock</option>
                    <option value=""<?php echo $stock_status==""?" selected":""?>>All Stock</option>                    
                  </select>
                </div> -->
                <div class="col-sm-2 text-left">
                    <input type="button" class="btn btn-danger btn-l reset_search" value="Reset" alt="Reset Record" title="Reset Record" />
                    <input type="submit" class="btn btn-default btn-l" value="Search" alt="Search Record" title="Search Record" />
                </div>
          	</form>
        </div>
  	</li>
</ul>
<div class="panel-body table-responsive">
<form method="post">
	<table class="table table-hover list">
    	<thead>
            <tr>
                <th width="2%" class="text-center">S.no</th>
                <th class="text-center" width="5%">ID</th>
                <th width="15%">Supplier</th>
                <th width="15%"><a href="stock_manage.php?order_by=title&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Item
                        <?php
                            if( $order_by == "title" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="10%">Purchase Value</th>
                <th class="text-right" width="10%">Sale Value</th>
                <th class="text-right" width="10%">Opening Stock</th>
                <th class="text-right" width="10%">
                        Item Purchased
                        
 				</th>
                <th class="text-right" width="12%">Purchasing Price</th>
                <th class="text-right" width="8%"><a href="stock_manage.php?order_by=quantity_sold&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Item Sold
                        <?php
                            if( $order_by == "quantity_sold" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="8%">Selling Price</th>
                <th class="text-right" width="10%"><a href="stock_manage.php?order_by=remaining_stock&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Remaining Stock
                        <?php
                            if( $order_by == "remaining_stock" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="8%">Stock Price</th>
                <!-- <th class="text-right" width="10%">Stock Return</th> -->
            </tr>
    	</thead>
    	<tbody>
			<?php
            $rs=doquery($sql, $dblink);
            if(numrows($rs)>0){
                $sn=1;
                $sold = $total_sale = $remaining_stock = 0;
                while($r=dofetch($rs)){        
                    $sale = dofetch(doquery( "select sum(a.quantity) as sold_qty, sum(a.total) as total_sale from sales_items a left join sales b on a.sales_id = b.id where item_id='".$r[ "id" ]."' $extra order by $orderby", $dblink ));
                    $sold = $sale[ "sold_qty" ];
                    $total_sale = $sale[ "total_sale" ];
                    $purchase = dofetch(doquery( "select sum(a.quantity) as purchase_qty, sum(a.total) as total_purchase from purchase_items a left join purchase b on a.purchase_id = b.id where item_id='".$r[ "id" ]."' $extra order by $orderby", $dblink ));
                    $purchased = $purchase[ "purchase_qty" ];
                    $total_purchase= $purchase[ "total_purchase" ];
                    $remaining_stock = $r["quantity"]+$purchased-$sold;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        <td class="text-center"><?php echo $r["id"]?></td>
                        <td><?php // echo unslash( $r["supplier_name"] )?></td>
                        <td><?php echo unslash($r["title"]); ?></td>
                        <td class="text-right"><?php echo unslash($r["unit_price"]); ?></td>
                        <td class="text-right"><?php echo unslash($r["sale_price"]); ?></td>
                        <td class="text-right"><?php echo $r["quantity"]; ?></td>
                        <td class="text-right"><?php echo $purchased; ?></td>
                        <td class="text-right"><?php echo curr_format( $total_purchase )?></td>
                        <td class="text-right"><?php echo $sold; ?></td>
                        <td class="text-right"><?php echo curr_format($total_sale); ?></td>
                        <td class="text-right"><?php echo $remaining_stock; ?></td>
                        <td class="text-right">
                            <?php 
                            if($remaining_stock>0){
                                echo $remaining_stock*$r[ "unit_price" ];
                            }
                            else{
                                echo $remaining_stock;
                            }
                            ?>
                        </td>
                        <!-- <td class="text-right"></td> -->
                    </tr>
                    <?php 
                    $sn++;
                }
				?>
				<!-- <tr>
                    <td colspan="11"  class="no-record"><input type="submit" name="stock_save" value="Save Values" /></td>
                </tr> -->
				<?php
            }
            else{	
                ?>
                <tr>
                    <td colspan="12"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</form>
</div>
