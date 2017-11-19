<?php

namespace Elgg\Projects;

$title = elgg_echo('projects:project');

$guid = elgg_extract('guid', $vars);

$entity = get_entity($guid);

elgg_register_menu_item('title', [
	'name' => 'project_edit',
	'text' => elgg_echo('edit'),
	'href' => "project/edit/$guid",
	'link_class' => 'elgg-button elgg-button-action',
]);

elgg_register_menu_item('title', [
	'name' => 'task_add',
	'text' => elgg_echo('projects:task:add'),
	'href' => "task/add/$guid",
	'link_class' => 'elgg-button elgg-button-action',
]);

$entity_view = elgg_view_entity($entity, [
	'full_view' => true,
]);

$tasks = elgg_list_entities([
	'type' => 'object',
	'subtype' => Task::SUBTYPE,
	'container_guid' => $entity->guid,
	'no_results' => elgg_echo('projects:tasks:none'),
]);

$comments = elgg_view_comments($entity);

$body = elgg_view_layout('content', [
	'title' => $entity->title,
	'filter' => '',
	'content' => $entity_view . $tasks . $comments,
]);

echo elgg_view_page($title, $body);
