<?php

$full = elgg_extract('full_view', $vars, false);

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \Elgg\Projects\Project) {
	return;
}

if ($full) {
	echo elgg_view('object/elements/full', [
		'entity' => $entity,
		'summary' => '',
		'body' => $entity->description,
		'icon' => '',
	]);
} else {
	if ($entity->isClosed()) {
		$status_icon = elgg_view_icon('times-times-o', [
			'style' => 'color: red',
		]);
	} else {
		$status_icon = elgg_view_icon('times-circle-o', [
			'style' => 'color: green',
		]);
	}

	$task_count = elgg_format_element(
		'span',
		['style' => 'margin-left: 5px'],
		elgg_echo('project:tasks:count', [
			$entity->countClosed(),
			$entity->countTotal(),
		])
	);

	$params = array(
		'entity' => $entity,
		'title' => elgg_view('output/url', [
			'href' => $entity->getURL(),
			'text' => $entity->getDisplayName(),
		]),
		'metadata' => elgg_view_menu('entity', [
			'entity' => $entity,
			'handler' => 'project',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		]),
		'content' => $task_count,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
