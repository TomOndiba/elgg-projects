<?php
/**
 * Provides task data as JSON for the calendar view via AJAX.
 */

$container_guid = get_input('container_guid');

$date_start = get_input('date_start');
$date_end = get_input('date_end');

if (!$date_start) {
	$date = new DateTime('first day of this month');
	$date_start = $date->format('U');
}

if (!$date_end) {
	$date = new DateTime('last day of this month');
	$date_end = $date->format('U');
}

$entities = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => Elgg\Projects\Task::SUBTYPE,
	'container_guid' => $container_guid,
	'limit' => false,
	'metadata_name_value_pairs' => [
		[
			'name' => 'date_start',
			'value' => $date_start,
			'operand' => '>=',
		],
		[
			'name' => 'date_end',
			'value' => $date_end,
			'operand' => '<=',
		],
	]
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
		'color' => $task->isClosed() ? 'green' : 'red',
	];
}

header('Content-type: application/json');

echo json_encode($result);
