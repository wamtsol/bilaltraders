<div id="footer" class="bottom_round_corners">
	<div id="footer_content">
    	<address>&copy; <?php echo date("Y");?> - <?php echo $site_title; ?> Admin Panel</address>
    </div>
</div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
<link href="js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/moment/moment.min.js"></script>
<script type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
<link href="js/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="js/jQuery-Scanner-Detection-master/jquery.scannerdetection.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$('.date-picker').daterangepicker({ singleDatePicker: true, format: 'DD/MM/YYYY'});
	$('.fancybox_iframe').fancybox({
		type: 'iframe',
		afterClose: function(){ window.location.reload(); }
	});
	$('.fancybox-btn a').fancybox({type: 'inline'});
	if(window.location != window.parent.location){
		$("body").addClass("popup-content");
	}
	$('.date-timepicker').datetimepicker({
		"format": 'DD/MM/YYYY hh:mm A'
	});
	$(".angular-datetimepicker").on("dp.change", function(){
		dp = $(this);
		angular.element($("#"+dp.data( 'controllerid' ))).scope().updateDate();
	});
	$( ".tabs" ).tabs();
	$("select.item_select").chosen({width: "100%"});
	
});
</script>
<?php include("include/upload_center.php");?>
<script> 
$(document).ready(function(){
	$("#supplier_id").change(function(){
		$supplier = $(this).find("option:selected");
		if( $supplier.val() != "" ){
			$("#supplier_name").val($supplier.data("supplier_name"));
			$("#phone").val($supplier.data("phone"));
			$("#address").val($supplier.data("address"));
		}
	}).change();
	$("#customer_id").change(function(){
		$customer = $(this).find("option:selected");
		if( $customer.val() != "" ){
			$("#customer_name").val($customer.data("customer_name"));
			$("#phone").val($customer.data("phone"));
			$("#address").val($customer.data("address"));
		}
	}).change();
});
</script>
<script>
$(document).scannerDetection({
	timeBeforeScanTest: 200, // wait for the next character for upto 200ms
	avgTimeByChar: 100, // it's not a barcode if a character takes longer than 100ms
	onComplete: function(barcode, qty){
		var barcode = parseInt(barcode);
		if( barcode > 0 ){
			angular.element($("#salesController")).scope().addItem( barcode, qty );
		}
    }
});
</script>
<script>
$(document).ready(function() {    
	$(".sorting").hover(function(){
	  $icon=$(this).find(".sort-icon i");
	  $icon.removeClass("fa-angle-"+$icon.data("hover_out")).addClass("fa-angle-"+$icon.data("hover_in"))
	},function(){
	  $icon=$(this).find(".sort-icon i");
	  $icon.addClass("fa-angle-"+$icon.data("hover_out")).removeClass("fa-angle-"+$icon.data("hover_in"))
	});
	$(".reset_search").click(function(){
		$form = $(this).parents("form");
		$form.find('input[type=text], select, textarea').val('');
		$form.submit();
	});
	$(".barcode_print_button").click(function(e){
		e.preventDefault();
		$a = $(this);
		$copies = prompt("Number of Copies (Multiple of 2)", "1");
		if($copies > 0)
		{
			$("<iframe>")
			.hide()
			.attr("src", $a.attr("href")+"&copies="+$copies)
			.appendTo("body"); 
		}
	});
}); 
</script>  
<script type="text/javascript" src="js/angular.min.js"></script>
<script type="text/javascript" src="js/angular-animate.js"></script>
<script src="js/angular-moment.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/ui-bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/angularjs-datetime-picker.css" />
<script type="text/javascript" src="js/datetimepicker.js"></script>
<script type="text/javascript" src="js/mask.js"></script>
<script type="text/javascript" src="js/angular-chosen.js"></script>
<script type="text/javascript" src="js/purchase.angular.js"></script>
<script type="text/javascript" src="js/sales.angular.js"></script>

<!-- EXTERNAL SCRIPTS FOR CALLMENICK.COM, PLEASE DO NOT INCLUDE -->

</body>
</html>