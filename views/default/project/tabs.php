<?php

$tab = elgg_extract('tab', $vars);
$project = elgg_extract('entity', $vars);

echo elgg_view('navigation/tabs', [
	'tabs' => [
		[
			'text' => elgg_echo('projects:details'),
			'href' => $project->getURL() . "?tab=details",
			'selected' => $tab == 'details',
		],
		[
			'text' => elgg_echo('projects:tasks'),
			'href' => $project->getURL() . "?tab=tasks",
			'selected' => $tab == 'tasks',
		],
		[
			'text' => elgg_echo('projects:calendar'),
			'href' => $project->getURL() . "?tab=calendar",
			'selected' => $tab == 'calendar',
		],
	],
]);
