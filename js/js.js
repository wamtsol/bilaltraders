function getToday(){
	var mydate=new Date();
	var year=mydate.getYear();
	if (year < 1000)
	year+=1900;
	var day=mydate.getDay();
	var month=mydate.getMonth();
	var daym=mydate.getDate();
	if (daym<10)
	daym="0"+daym;
	var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	return(montharray[month]+" "+daym+", "+year);
}
function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes ;

  // Update the time display
  document.getElementById("clock").innerHTML = "asdasdasd";
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
$(window).load(function(){
	$("#right_content").css("min-height", $("#left_content").css("height"));
	$(".file-select-option").change(function(){
		$target_container=jQuery("#"+$(this).attr('data-selected-file-display'));
		console.log($target_container);
		$src=jQuery(this).find('option:selected').attr('data-img-src');
		if($target_container.length && $src)
			$target_container.html('<img src="'+$src+'" />');
	});
	$(".file-select-option").change();
	$(".file-select-button").click(function(){
		$target_container=jQuery("#"+$(this).attr('data-selected-file-display'));
		$target_input=jQuery("#"+$(this).attr('data-input-field-id'));
		$target_input.unbind('change').change(function(){
			$target_container.html(jQuery(this).val());
		});
		$target_input.click();
	});
});
$(document).ready(function(){
	$(".file-select-option").change(function(){
		$target_container=jQuery("#"+$(this).attr('data-selected-file-display'));
		console.log($target_container);
		$src=jQuery(this).find('option:selected').attr('data-img-src');
		if($target_container.length && $src)
			$target_container.html('<img src="'+$src+'" />');
	});
	$(".file-select-option").change();
	$(".file-select-button").click(function(){
		$target_container=jQuery("#"+$(this).attr('data-selected-file-display'));
		$target_input=jQuery("#"+$(this).attr('data-input-field-id'));
		$target_input.unbind('change').change(function(){
			$target_container.html(jQuery(this).val());
		});
		$target_input.click();
	});
	if($(".select_multiple").length>0) $(".select_multiple").chosen();
	
	$("#select_all").change(function(){
		var chckedstatus=this.checked;
		$(".list :checkbox").each(function(){
			this.checked=chckedstatus;
		});
	});
	$("#apply_bulk_action").click(function(){
			$slectedvalue=$('#bulk_action option:selected').val();
			if($slectedvalue != "null"){
				$IDs='';
				$(".list :checkbox").each(function(){
					if(this.checked)
						if(this.value!=0)
							$IDs+=this.value+',';
				});
				$IDs=$IDs.substring(0,$IDs.length-1);
				var pagename= window.location.pathname;
				pagename=pagename.substring(pagename.lastIndexOf("/") + 1);
				window.location.href=pagename+'?tab=bulk_action&action='+$slectedvalue+'&Ids='+$IDs+'&pid='+getUrlVars()["pid"]+'&ppid='+getUrlVars()["ppid"];
			}
	});
	if($("#seo_url")){
		$("#seo_url").keyup(function(){
			$new=$(this).attr('value').toLowerCase();							  
			$(this).attr('value',$new.replace(" ", "-"));
		});
	}
	$(".dropdown.link").click(function(){
		$(".dropdown-menu").toggle();
	});
	$("#topstats.btn").click(function(){
		$(".topstats.search_filter").slideToggle();
	});
	$(".sidebar-open-button").click(function(){
		$(".sidebar").toggle();
		$(".sidebar").toggleClass("active");
		if($(window).width()>768){
			if($(".sidebar").hasClass('active')){
				$(".content").css("margin-left","250px");
			}
			else{
				$(".content").css("margin-left","0");
			}
		}
		/*$(".sidebar").css("width","250px");
		$(".content").css("margin-left","250px");*/
		
		/*$(".sidebar").toggle()
		if($(window).width()>768){
			if($(".sidebar").hasClass('closed')){
				$(".sidebar").addClass('closed')
				$(".content").css("margin-left","250px");
			}
			else{
				$(".sidebar").removeClass('closed')
				$(".content").css("margin-left","0px");
			}
		}*/
	});
	$('.nav > li > a').click(function(){
		if ($(this).attr('class') != 'active'){
		  	$('.nav li ul').slideUp();
		  	$(this).next().slideToggle();
		  	$('.nav li a').removeClass('active');
		  	$(this).addClass('active');
		}
		else{
			$(this).next().slideToggle();
		  	$(this).removeClass('active');
		}
	});
});