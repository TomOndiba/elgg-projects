<?php

$entity = elgg_extract('entity', $vars);

elgg_require_js('project/calendar');

elgg_load_css('fullcalendar');

echo <<<HTML
	<div id="project-calendar" data-project_guid="{$entity->guid}"></div>
HTML;

