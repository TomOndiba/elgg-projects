<?php

namespace Elgg\Projects;

$guid = elgg_extract('guid', $vars);

$entity = get_entity($guid);

$form_vars = [];
if ($entity instanceof Task) {
	if (!$entity->canEdit()) {
		register_error(elgg_echo('actionunauthorized'));
		forward(REFERER);
	}

	foreach (Task::getProperties() as $name => $type) {
		$form_vars[$name] = $entity->$name;
	}

	$form_vars['container_guid'] = $entity->container_guid;
	$form_vars['assignees'] = array_map(function($assignee) {
		return $assignee->guid;
	}, $entity->getAssignees());

	$title = elgg_echo("projects:task:edit");

	$container = $entity->getContainerEntity();
} else {
	$container = $entity;

	$form_vars['container_guid'] = $guid;

	elgg_set_page_owner_guid($guid);

	$title = elgg_echo("projects:task:add");
}

elgg_set_page_owner_guid($container->getContainerGuid());

elgg_push_breadcrumb($container->getDisplayName(), $container->getURL());

$form = elgg_view_form('task/save', $form_vars, $form_vars);

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => '',
	'content' => $form,
]);

echo elgg_view_page($title, $body);
