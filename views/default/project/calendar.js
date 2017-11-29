/**
 * Displays project tasks in a calendar.
 */
define(['jquery', 'elgg', 'fullcalendar'], function($, elgg) {

	var init = function() {
		var project_guid = $('#project-calendar').data('project_guid');

		$('#project-calendar').fullCalendar({
			events: elgg.normalize_url('ajax/view/project/calendar?container_guid=' + project_guid),
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'today'
			},
			allDayDefault: true,
			timeFormat: 'H:mm',
			lang: elgg.get_language(),
			buttonText: {
				today: elgg.echo('projects:calendar:today'),
			}
		});
	};

	elgg.register_hook_handler('init', 'system', init);
});
