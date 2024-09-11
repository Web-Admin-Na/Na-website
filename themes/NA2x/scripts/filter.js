jQuery(document).ready(function($) {
	$('ul.bl_sort a').click(function() {
		$(this).css('outline','none');
		$('ul.bl_sort .current').removeClass('current');
		$(this).parent().addClass('current');
		
		var filterVal = $(this).attr('href');
		filterVal = filterVal.replace('#','');
				
		if(filterVal == 'all') {
			$('table.meetings-table tbody tr.hidden').fadeIn('slow').removeClass('hidden');
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
});