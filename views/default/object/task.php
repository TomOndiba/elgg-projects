<?php

$full = elgg_extract('full_view', $vars, false);

$entity = elgg_extract('entity', $vars);

if ($full) {
	echo elgg_view('object/task/full_view', $vars);
} else {
	$subtitle = '';
	if (elgg_in_context('widgets')) {
		// Tasks from all the different projects are displayed in the
		// same widget, so we also need to display, which projects each
		// task belongs to.
		$subtitle .= $entity->getContainerEntity()->getDisplayName() . "<br />";
	}

	$subtitle .= elgg_echo('projects:deadline', [
		date(elgg_echo('projects:date:format'), $entity->date_end),
	]);

	$params = array(
		'entity' => $entity,
		'title' => elgg_view('output/url', [
			'href' => $entity->getURL(),
			'text' => $entity->getDisplayName(),
		]),
		'subtitle' => $subtitle,
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
