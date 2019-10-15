$('.tab-list').each(function(){                   // Find lists of tabs
  var $this = $(this);                            // Store this list
  var $tab = $this.find('li.active');             // Get the active list item
  var $link = $tab.find('a');                     // Get link from active tab
  var $panel = $($link.attr('href'));             // Get active panel

  $this.on('click', '.tab-control', function(e) { // When click on a tab
    e.preventDefault();                           // Prevent link behavior
    var $link = $(this),                          // Store the current link
        id = this.hash;                           // Get href of clicked tab 

    if (id && !$link.is('.active')) {             // If not currently active
      $panel.removeClass('active');               // Make panel inactive
      $tab.removeClass('active');                 // Make tab inactive

      $panel = $(id).addClass('active');          // Make new panel active
      $tab = $link.parent().addClass('active');   // Make new tab active 
    }
  });
});



var $noDates = new Array("2019-05-25","2019-05-26","2019-09-01","2019-09-07","2019-09-08",
	"2019-09-14","2019-09-15","2019-09-21","2019-09-22","2019-09-28","2019-09-29",
	"2019-10-05","2019-10-06","2019-10-12","2019-10-13","2019-10-19","2019-10-20",);
 
	function noshowDates(date) {
 
	var $return=true;
	var $returnclass ="available";	
 
	var $dateFormat = $.datepicker.formatDate('yy-mm-dd',date);
 
		// We will now check if the date belongs to disableddates array 
		for (var i = 0; i < $noDates.length; i++) {
 
		// Now check if the current date is in disabled dates array. 
			if ($noDates[i] == $dateFormat) {
				$return = false;
        $returnclass= "unavailable";
			}
		}
		return [$return,$returnclass];
	}// noshowDate 
	  
	  
    $(function() {
		$( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		beforeShowDay: noshowDates,
		firstDay: 1,
		minDate: new Date(2019,5-1,20), 
		maxDate: new Date(2019,10-1,21),
		changeMonth:true,
		changeYear:true,
		numberOfMonths:[1,3],
		showAnim: "slideDown",
		show: true
        });
    });
	
	$(document).ready(function(){
		$("#boat1").click(function(){
			document.getElementById("message").innerHTML = "Cruise Day Destination: Morar-Eigg-Muck choose Routes: Morar-Eigg-Muck / Morar-Eigg / Eigg-Muck";
			$("#message").show();
		});
		
		$("#boat2").click(function(){
			document.getElementById("message").innerHTML = "Cruise Day Destination: Morar-Eigg-Rum choose Routes: Morar-Eigg-Rum / Morar- Eigg / Eigg-Rum";
			$("#message").show();
		});
		
		$("#boat3").click(function(){
			document.getElementById("message").innerHTML = "Cruise Day Destination: Morar-Rum only one route Morar - Rum apply as is direct trip to Rum";
			$("#message").show();
		});
	});
	
	
	
 
	
	
	
