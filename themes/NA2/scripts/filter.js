jQuery(document).ready(function($) {
$("#group").select2();
	$('tr.online').hide();
	$('tr.virtual-en').hide();
	$('ul.bl_sort a').click(function() {
		$(this).css('outline','none');
		$('ul.bl_sort .current').removeClass('current');
		$(this).parent().addClass('current');
		
		var filterVal = $(this).attr('href');
		filterVal = filterVal.replace('#','');
				
		if(filterVal == 'all') {
			$('table.meetings-table tbody tr.hidden ').fadeIn('slow').removeClass('hidden');
		} else {
			$('.infoRow').hide();
			$('table.meetings-table tbody tr.single_meeting').each(function() {
				if(!$(this).hasClass(filterVal)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
		
		return false;
	});
	
	$('select').change(function() {
		var filterVal = $(this).val();
		filterVal = filterVal.replace('#','');

		//$('table.meetings-table tbody tr').removeClass('hidden');

		if (filterVal == 'all') {
			$('table.meetings-table tbody tr.hidden').fadeIn('slow').removeClass('hidden');
			$('thead').show();
			$('tr.online').hide();
			$('tr.virtual-en').hide();
		} else {
			$('.infoRow').hide(); 
			$('table.meetings-table tbody tr.single_meeting ').each(function() {
				if(!$(this).hasClass(filterVal)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
	});						   
function filterMeetingsByDay(day) {
    const allMeetings = document.querySelectorAll('.single_meeting');
    const allInfoRows = document.querySelectorAll('.infoRow');
    
    if (day === 'all') {
      allMeetings.forEach(meeting => meeting.style.display = '');
      allInfoRows.forEach(infoRow => infoRow.style.display = '');
    } else {
      allMeetings.forEach(meeting => {
        if (meeting.classList.contains(day)) {
          meeting.style.display = '';
        } else {
          meeting.style.display = 'none';
        }
      });
      allInfoRows.forEach(infoRow => {
        const meetingId = infoRow.id.replace('detail', '');
        const relatedMeeting = document.getElementById(meetingId);
        if (relatedMeeting && relatedMeeting.style.display === '') {
          infoRow.style.display = '';
        } else {
          infoRow.style.display = 'none';
        }
      });
    }
  }

    function hideEmptyTables() {
        // Get all tables or the specific tables you want to check
        let tables = document.querySelectorAll('.day-table'); // Adjust the selector to match your table's class or ID

        tables.forEach(function(table) {
            // Get all rows in the current table
            let rows = table.querySelectorAll('tr');

            // Assume we start by hiding the table
            let isTableEmpty = true; // Flag to check if the table is empty

            rows.forEach(function(row, index) {
                // If the row has visible content, set the flag to false
                if (row.offsetParent !== null) { // Check if the row is visible
                    isTableEmpty = false; // Found a visible row
                }

                // If the current row is a header row (contains <th>)
                if (row.querySelector('th')) {
                    // If the table is empty, hide the header row
                    if (isTableEmpty) {
                        row.style.display = 'none'; // Hide the header row
                    } else {
                        row.style.display = ''; // Show the header row
                    }
                }
            });

            // Hide the entire table if there are no visible rows
            if (isTableEmpty) {
                table.style.display = 'none'; // Hide the empty table
            } else {
                table.style.display = ''; // Show the table if it has visible content
            }
        });
    }

	});