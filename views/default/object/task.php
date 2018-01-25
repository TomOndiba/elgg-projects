<?php

$full = elgg_extract('full_view', $vars, false);

$entity = elgg_extract('entity', $vars);

if ($full) {
	echo elgg_view('object/task/full_view', $vars);
} else {
	$params = array(
		'entity' => $entity,
		'title' => elgg_view('output/url', [
			'href' => $entity->getURL(),
			'text' => $entity->getDisplayName(),
		]),
		'subtitle' => elgg_echo('projects:deadline', [
			date(elgg_echo('projects:date:format'), $entity->date_end),
		]),
		'metadata' => elgg_view_menu('entity', [
			'entity' => $entity,
			'handler' => 'task',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		]),
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
