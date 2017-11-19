<?php

$entity = $vars['entity'];

$dates = [
	'date_start',
	'date_end',
	'date_completed',
];

$items = '';
foreach ($dates as $date_name) {
	if (empty($entity->$date_name)) {
		$date = '-';
	} else {
		$date = date(elgg_echo('projects:date:format'), $entity->$date_name);
	}

	$item = elgg_echo("projects:label:{$date_name}", [$date]);
	$items .= "<li>$item</li>";
}

echo "<p><ul>$items</ul></p>";
