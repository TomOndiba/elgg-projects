<?php

namespace Elgg\Projects;

$guid = $vars['guid'];

$entity = get_entity($guid);

$form_vars = [];
if ($entity instanceof Project) {
	foreach (Project::getProperties() as $name => $type) {
		$form_vars[$name] = $entity->$name;
	}

	$form_vars['container_guid'] = $entity->container_guid;
} else {
	$form_vars['container_guid'] = $guid;
}

$form = elgg_view_form('project/save', $form_vars, $form_vars);

$title = elgg_echo('projects:project');

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => '',
	'content' => $form,
]);

echo elgg_view_page($title, $body);
