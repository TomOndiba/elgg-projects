<?php

namespace Elgg\Projects;

$guid = $vars[1];

$entity = get_entity($guid);
$container = $entity->getContainerEntity();

elgg_push_breadcrumb($container->getDisplayName(), $container->getURL());

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
} else {
	$form_vars['container_guid'] = $guid;

	$title = elgg_echo("projects:task:add");
}

$form = elgg_view_form('task/save', $form_vars, $form_vars);

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => '',
	'content' => $form,
]);

echo elgg_view_page($title, $body);
