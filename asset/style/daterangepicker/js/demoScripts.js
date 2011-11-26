/*DEMO Scripts for running the date range picker within the article page*/
		enhancedDomReady(function(){
			$('.toggleRPpos').click(function(){
				if($('div.rangePicker').css('float') == 'left') { 
					$('div.rangePicker').css('float', 'right');
					$('.toggleRPpos').html('Align date picker to the left');
				}
				else { 
					$('div.rangePicker').css('float', 'left'); 
					$('.toggleRPpos').html('Align date picker to the right');
				}
				return false;
			});
			
			
			// create date picker by replacing out the inputs
		$('.rangePicker').html('<a href="#" class="range_prev"><span>Previous</span></a><a href="#" class="rangeDisplay"><span>Pick a Date</span></a><a href="#" class="range_next"><span>Next</span></a>').dateRangePicker({menuSet: 'futureRange'});
			
			
		});
