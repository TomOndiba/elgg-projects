<?php
/**
 * Provides task data as JSON for the calendar view via AJAX.
 */

$container_guid = get_input('container_guid');

$entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => Elgg\Projects\Task::SUBTYPE,
	'container_guid' => $container_guid,
	'limit' => false,
]);

$result = [];
foreach ($entities as $task) {
	$result[] = [
		'title' => $task->title,
		'start' => gmdate('c', $task->date_start),
		'end' => gmdate('c', $task->date_end),
		'allDay' => true,
		'url' => $task->getURL(),
	];
}

header('Content-type: application/json');

echo json_encode($result);
