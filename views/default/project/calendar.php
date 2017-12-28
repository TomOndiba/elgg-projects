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
	// Skip tasks that are missing the dates.
	if (empty($task->date_start) && empty($task->time_end)) {
		continue;
	}

	$result[] = [
		'title' => $task->title,
		'start' => gmdate('c', $task->date_start),
		// Hack to make the task span across both dates in the calendar.
		'end' => gmdate('c', $task->date_end + 86400),
		'allDay' => true,
		'url' => $task->getURL(),
	];
}

header('Content-type: application/json');

echo json_encode($result);
