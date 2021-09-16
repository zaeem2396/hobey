<div class=" min_footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p class=" copyright">© 2021 <!-- devices.shemaroo.com --></p>
            </div>
            <div class="col-md-8 text-right">
                
            </div>
        </div>
    </div>
</div>
<!-- Google Map API --> 
<!-- script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script--> 
<!-- jQuery --> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/jquery-1.11.1.min.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/jquery-ui.min.js"></script> <!-- Bootstrap --> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/bootstrap.min.js"></script> 
<!-- Page Plugins --> 
<!--<script type="text/javascript" src="js/raphael.js"></script> 
<script type="text/javascript" src="js/morris.js"></script> 
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="js/datatables.js"></script> 
<script type="text/javascript" src="js/jquery-jvectormap.min.js"></script> 
<script type="text/javascript" src="js/jquery-jvectormap-us-lcc-en.js"></script> 
<script type="text/javascript" src="js/clndr.js"></script> 
<script type="text/javascript" src="js/moment.js"></script> -->
<!-- Flot Plugins --> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/jquery.flot.min.js"></script> 
<!-- Theme Javascript --> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/spin.min.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/underscore-min.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/main.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/ajax.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="<?php echo $base_url_views;?>js/custom.js"></script> 
<script type="text/javascript">

jQuery(document).ready(function () {
	  
	/* $("#startdate").append('<i class="fa fa-calendar" aria-hidden="true"></i>'); */
     // Remove the checked state from "All" if any checkbox is unchecked
	$('#checkAll').on('ifUnchecked', function (event) {
		$('.minimal-red').iCheck('uncheck');
	});

	// Make "All" checked if all checkboxes are checked
	$('#checkAll').on('ifChecked', function (event) {
		if ($('#checkAll').filter(':checked').length == $('#checkAll').length) {
			$('.minimal-red').iCheck('check');
		}
	});
	
	"use strict";
	 // Init Theme Core 	  
     Core.init();
     // Enable Ajax Loading 	  
     Ajax.init();
	 // Dashboard Widgets Slidedown
     $('.dashboard-widget-tray .btn:first-child').on('click', function() {
		$('#widget-dropdown').slideToggle('fast'); 
	 });
	 	 
	 var runFlotChart = function () {	 
		 
        // Add a series of colors to be used in the charts and pie graphs
        var Colors = [blueColor, purpleColor, orangeColor, greenColor, redColor, tealColor, yellowColor];

		if ($(".chart-toggle").length) {
			
			var datasets = {
				"Facebook": {
					label: "Facebook",
					data: [[1, 40], [2, 8000], [3, 3400], [4, 6000], [5, 9100], [6, 43500], [7, 16000], [8, 2000], [9, 800], [10, 600]]
				},        
				"Twitter": {
					label: "Twitter",
					data: [[1, 40], [2, 100], [3, 200], [4, 1000], [5, 11100], [6, 1500], [7, 2400], [8, 5000], [9, 12000], [10, 24000]]
				},        
				"Pinterest": {
					label: "Pinterest",
					data: [[1, 40], [2, 7000], [3, 1700], [4, 15000], [5, 14400], [6, 9500], [7, 5600], [8, 700], [9, 800], [10, 400]]
				},           
				"Instagram": {
					label: "Instagram",
					data: [[1, 16000], [2, 7000], [3, 200], [4, 3300], [5, 8000], [6, 500], [7, 600], [8, 3700], [9, 5800], [10, 2300]]
				},        
			};
	
			// hard-code color indices to prevent them from shifting as
			// countries are turned on/off
			var i = 0;
			$.each(datasets, function(key, val) {
				val.color = i;
				++i;
			});
	
			// insert checkboxes 
			var choiceContainer = $("#choices");
			$.each(datasets, function(key, val) {				
				choiceContainer.append("<div class='cBox mt15 " + key.toLowerCase() +"-bg'><input type='checkbox' name='" + key + "' checked='checked' id='" + key + "'/> <label for='" + key + "'>" + val.label + "</label></div>");
			});
			
			choiceContainer.find("input").click(function() {
				plotAccordingToChoices();
			});
			
		    var plotAccordingToChoices = function() {
				var data = [];
				choiceContainer.find("input:checked").each(function () {
					var key = $(this).attr("name");
					if (key && datasets[key]) {
						data.push(datasets[key]);
					}
				});
	
				if (data.length > 0) {
					$.plot(".chart-toggle", data, {
						grid: {
							show: true,
							aboveData: true,
							color: "#3f3f3f",
							labelMargin: 5,
							axisMargin: 0,
							borderWidth: 0,
							borderColor: null,
							minBorderMargin: 5,
							clickable: true,
							hoverable: true,
							autoHighlight: true,
							mouseActiveRadius: 20
						},
						series: {
							lines: {
								show: true,
								fill: 0.5,
								lineWidth: 2,
								steps: false
							},
							points: {
								show: false
							}
						},
						yaxis: {
							min: 0
						},
						xaxis: {
							ticks: 11,
							tickDecimals: 0
						},
						colors: Colors,
						shadowSize: 1,
						tooltip: true,
						//activate tooltip
						tooltipOpts: {
							content: "%s : %y.0",
							shifts: {
								x: -30,
								y: -50
							}
						}
					});
				}
			}
			plotAccordingToChoices();
	    } 
	 };		 
		 
	 // Jvector Map Plugin
     var runJvectorMap = function () {
        var mapData = [900, 700, 350, 500];
           // Init Jvector Map
       /* $('#map1').vectorMap({
           map: 'us_lcc_en',
           //regionsSelectable: true,
           backgroundColor: '#FFF',
           series: {
              markers: [{
                 attribute: 'r',
                 scale: [3, 7],
                 values: mapData
              }]
           },
           regionStyle: {
              initial: {
                 fill: '#E5E5E5'
              },
              hover: {
                 "fill-opacity": 0.3
              }
           },
           markers: [{
              latLng: [37.78, -122.41],
              name: 'San Francisco,CA'
           }, {
              latLng: [36.73, -103.98],
              name: 'Texas,TX'
           }, {
              latLng: [38.62, -90.19],
              name: 'St. Louis,MO'
           }, {
              latLng: [40.67, -73.94],
              name: 'New York City,NY'
           }],
           markerStyle: {
              initial: {
                 fill: '#a288d5',
                 stroke: '#b49ae0',
                 "fill-opacity": 1,
                 "stroke-width": 10,
                 "stroke-opacity": 0.3,
                 r: 3
              },
              hover: {
                 stroke: 'black',
                 "stroke-width": 2
              },
              selected: {
                 fill: 'blue'
              },
              selectedHover: {}
           },
        });
		*/
		
		// Manual code to alter the Vector map plugin to 
		// allow for individual coloring of countries
        var states = ['US-CA', 'US-TX', 'US-MO', 'US-NY'];
        var colors = ['#e2ceeb', '#f1dccb', '#d7f0f0', '#b6e2a0'];
        var colors2 = ['#c384dd', '#efac75', '#95e5e7', '#7ec35d'];
        $.each(states, function (i, e) {
           $("[data-code=" + e + "]").css({
              fill: colors[i]
           });
        });
        $('.jvector-simple').find('.jvectormap-marker').each(function (i, e) {
           $(e).css({
              fill: colors2[i],
              stroke: colors2[i]
           });
        });
     }
	 
	 // Clndr Plugin
    /* var runClndr = function () {
        // Init Clndr Widget (small calendar)
        $('#clndr').clndr({
           daysOfTheWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
        });
     }
	 */
	 // Datatables Plugin
     /*var runDatatables = function () {
	    $('#datatable, #datatable_2').dataTable({
			"bSort": true,
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": false,
			"bInfo": false,
			"bAutoWidth": false,
			"aoColumnDefs": [{
			   'bSortable': false,
			   'aTargets': [-1]
			}]
	    });
     }
	 */
	 // Morris Charts Plugin
     var runMorrisCharts = function () {
        // Use Morris.Area instead of Morris.Line
      /*  Morris.Area({
           element: 'graph',
           data: [{
              y: '2006',
              a: 0,
              b: 0,
              c: 0
           }, {
              y: '2007',
              a: 25,
              b: 35,
              c: 25
           }, {
              y: '2008',
              a: 30,
              b: 30,
              c: 29
           }, {
              y: '2009',
              a: 35,
              b: 40,
              c: 35
           }, {
              y: '2010',
              a: 40,
              b: 50,
              c: 65
           }, {
              y: '2011',
              a: 180,
              b: 350,
              c: 240
           }, {
              y: '2012',
              a: 40,
              b: 50,
              c: 75
           }, {
              y: '2013',
              a: 40,
              b: 50,
              c: 25
           }, {
              y: '2014',
              a: 30,
              b: 40,
              c: 15
           }, {
              y: '2015',
              a: 25,
              b: 35,
              c: 5
           }, {
              y: '2016',
              a: 0,
              b: 0,
              c: 0
           }],
           xkey: 'y',
           ykeys: ['a', 'b', 'c'],
           labels: ['Series A', 'Series B', 'Series C'],
           lineColors: [orangeColor, purpleColor, tealColor],
        });
		*/
     }
	 
	 // Init Jquery Sortable
	//$(".sortable").sortable();
    //$(".sortable").disableSelection();

	 // Init All Dashboard required Widgets
     runJvectorMap();
     //runClndr();
     //runDatatables();
     //runMorrisCharts();

	//////////////////////////////////////
	// Responsive Dashboard Chart Helpers
	 	 
	// Update chart size anytime the window is resized or when our primary 
	// content container undergoes an animation(indicating a size change).
	$(window).resize(_.debounce(function(){
		if  ($('#graph').length){
			$('#graph').empty();
			runMorrisCharts()
		}
		if  ($('.chart-toggle').length){
		$('.chart-toggle').empty();
		$('#choices').empty();
		runFlotChart();
		}
	}, 200));

	// When a panel tab is clicked check to see if the new tab contains a chart.
	// If it does we need to recreate it as the container size changes on tab show
	$('.panel-tabs li').on('click', function() {
		var Graph1 = $($(this).find('a').attr('href')).find('.chart-toggle');	
		var Graph2 = $($(this).find('a').attr('href')).find('#graph');	
		if ($(Graph1).length) {
			$(Graph1).empty();
			$('#choices').empty();
			var timeout = setTimeout(function() {
				runFlotChart();	
			},100);
		}
		else if ($(Graph2).length) {
			$(Graph2).empty();
			$('#choices').empty();
			var timeout = setTimeout(function() {
				runMorrisCharts()	
			},100);
		}
	});	
	
	$('body').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
		$('#graph').empty();
		runMorrisCharts();	
 	});
 	
	$('.sd .fa-calendar').click(function() {
		$("#startdate").focus();
	});
	
	$('.ed .fa-calendar').click(function() {
		$("#enddate").focus();
	});
	
	

  });
</script>
