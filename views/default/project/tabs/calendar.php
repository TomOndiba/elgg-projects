<?php

$entity = elgg_extract('entity', $vars);

elgg_require_js('project/calendar');

elgg_load_css('fullcalendar');

$open_string = elgg_echo('projects:status:open');
$closed_string = elgg_echo('projects:status:closed');

echo <<<HTML
	<p>
		<span class="projects-status-legend open"></span>$open_string
		<span class="projects-status-legend closed"></span>$closed_string
	</p>
	<div id="project-calendar" data-project_guid="{$entity->guid}"></div>
HTML;
