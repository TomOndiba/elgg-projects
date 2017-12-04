<?php

namespace Elgg\Projects;

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', Task::SUBTYPE);
elgg_group_gatekeeper();

$title = elgg_echo('projects:task');

$entity = get_entity($guid);
$container = $entity->getContainerEntity();

elgg_push_breadcrumb($container->getDisplayName(), $container->getURL());

$user = elgg_get_logged_in_user_entity();

if ($user && $entity->canClose($user)) {
	elgg_register_menu_item('title', [
		'name' => 'task_compete',
		'text' => elgg_echo('projects:task:mark_complete'),
		'href' => "action/task/complete?guid={$guid}",
		'confirm' => true,
		'is_action' => true,
		'link_class' => 'elgg-button elgg-button-action',
	]);
}

$entity_view = elgg_view_entity($entity, [
	'full_view' => true,
]);

$dates = elgg_view('object/project/dates', ['entity' => $entity]);

$comments = elgg_view_comments($entity);

$body = elgg_view_layout('content', [
	'title' => $entity->title,
	'filter' => '',
	'summary' => $summary,
	'content' => $entity_view . $dates . $comments,
]);

echo elgg_view_page($title, $body);
