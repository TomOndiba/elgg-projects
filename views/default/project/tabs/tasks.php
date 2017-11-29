<?php

namespace Elgg\Projects;

$entity = elgg_extract('entity', $vars);

$tasks = elgg_list_entities([
	'type' => 'object',
	'subtype' => Task::SUBTYPE,
	'container_guid' => $entity->guid,
	'no_results' => elgg_echo('projects:tasks:none'),
]);

echo $tasks;
