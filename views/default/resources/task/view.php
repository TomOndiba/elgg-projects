<?php

$title = elgg_echo('projects:task');

$guid = $vars[1];

$entity = get_entity($guid);
$container = $entity->getContainerEntity();

elgg_push_breadcrumb($container->getDisplayName(), $container->getURL());

$body = elgg_view_layout('content', [
	'title' => $entity->title,
	'filter' => '',
	'summary' => $summary,
	'content' => elgg_view_entity($entity, [
		'full_view' => true,
	]),
]);

echo elgg_view_page($title, $body);
