<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \Elgg\Projects\Task) {
	return;
}

$metadata = '';
if (!elgg_in_context('widgets')) {
	// only show entity menu outside of widgets
	$metadata = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => 'task',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$body = elgg_view('output/longtext', [
		'value' => $entity->description
]);

$params = array(
	'entity' => $entity,
	'title' => false,
	'metadata' => $metadata,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$body .= $entity->date_start;

$assignees = $entity->getEntitiesFromRelationship(['relationship' => 'assigned_to']);

$body .= elgg_view_entity_list($assignees);

echo elgg_view('object/elements/full', [
	'entity' => $entity,
	'summary' => $summary,
	'body' => $body,
	'icon' => '',
]);
