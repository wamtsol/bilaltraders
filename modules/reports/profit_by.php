<?php
if(!defined("APP_START")) die("No Direct Access");
?>
<div class="page-header">
	<h1 class="title">Reports</h1>
  	<ol class="breadcrumb">
    	<li class="active">Profit By Products</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a> 
            <a class="btn print-btn" href="report_manage.php?tab=profit_by_print"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
            	<input type="hidden" name="tab" value="profit_by" />
                <div class="col-sm-2">
                    <input type="text" title="Enter Date From" name="date_from" id="date_from" placeholder="From" class="form-control date-picker"  value="<?php echo $date_from?>">
                </div>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date To" name="date_to" id="date_to" placeholder="To" class="form-control date-picker"  value="<?php echo $date_to?>">
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
                <th>Product</th>
                <th class="text-right" width="20%">Gross Profit</th>
            </tr>
    	</thead>
    	<tbody>
			<?php 
            $rs=doquery($sql, $dblink);
            if(numrows($rs)>0){
                $sn=1;
				while($r=dofetch($rs)){             
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        <td><?php echo unslash($r["title"]); ?></td>
                        <td class="text-right"></td>
                    </tr>
                    <?php 
                    $sn++;
                }
            }
            else{	
                ?>
                <tr>
                    <td colspan="6"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
