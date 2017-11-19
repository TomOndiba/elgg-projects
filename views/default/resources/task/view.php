<?php

$title = elgg_echo('projects:task');

$guid = $vars[1];

$entity = get_entity($guid);
$container = $entity->getContainerEntity();

elgg_push_breadcrumb($container->getDisplayName(), $container->getURL());

if (!$entity->isCompleted()) {
	elgg_register_menu_item('title', [
		'name' => 'task_compete',
		'text' => elgg_echo('projects:task:mark_complete'),
		'href' => "action/task/complete?guid={$guid}",
		'is_action' => true,
		'link_class' => 'elgg-button elgg-button-action',
	]);
}

$entity_view = elgg_view_entity($entity, [
	'full_view' => true,
]);

$comments = elgg_view_comments($entity);

$body = elgg_view_layout('content', [
	'title' => $entity->title,
	'filter' => '',
	'summary' => $summary,
	'content' => $entity_view . $comments,
]);

echo elgg_view_page($title, $body);
