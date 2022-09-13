<?php
if(!defined("APP_START")) die("No Direct Access");
$rs=doquery("select * from customer where id='".slash($_GET["id"])."'",$dblink);
if(numrows($rs)>0){
	$customer=dofetch($rs);
}
else {
	return;
}
?>
<div class="page-header">
	<h1 class="title"><?php echo $customer[ "customer_name" ]?></h1>
  	<ol class="breadcrumb">
    	<li class="active">Manage Customers</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a href="customer_manage.php?tab=list" class="btn btn-light editproject">Back to List</a> 
        </div>
  	</div>
</div>
<div class="panel-body table-responsive">
	<table class="table table-hover list">
    	<thead>
            <tr>
                <th width="5%" class="text-center">S.no</th>
                <th>Date</th>
                <th>Transaction</th>                
                <th class="text-right">Amount</th>
                <th class="text-right">Balance</th>
            </tr>
    	</thead>
    	<tbody>
			<?php 
            $sql="select sum(amount) as amount from (select concat( 'Sale #', id) as transaction, net_price as amount from sales where customer_id = '".$customer[ "id" ]."' union select concat( 'Payment #', id) as transaction, -amount from customer_payment where customer_id = '".$customer[ "id" ]."') as transactions";
			$balance=dofetch(doquery($sql,$dblink));
			$balance = $balance[ "amount" ];
			$sql="select concat( 'Sale #', id) as transaction, datetime_added, net_price as amount from sales where customer_id = '".$customer[ "id" ]."' union select 'Payment', datetime_added as datetime_added, -amount from customer_payment where customer_id = '".$customer[ "id" ]."' order by datetime_added desc";
            $rs=doquery($sql,$dblink);
            if(numrows($rs)>0){
                $sn=1;
                while($r=dofetch($rs)){
					?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        <td><?php echo datetime_convert($r["datetime_added"]); ?></td>
                        <td><?php echo unslash($r["transaction"]); ?></td>
                        <td class="text-right"><?php echo curr_format($r["amount"]); ?></td>
                        <td class="text-right"><?php echo curr_format($balance); ?></td>
                    </tr>
                    <?php 
                    $balance = $balance - $r["amount"];
					$sn++;
                }
            }
            else{	
                ?>
                <tr>
                    <td colspan="5"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
