<?php

namespace Elgg\Projects;

$page_type = elgg_extract('page_type', $vars);
$guid = elgg_extract('guid', $vars);

$user = get_user($guid);

$options = [
	'type' => 'object',
	'subtype' => Task::SUBTYPE,
	'full_view' => false,
	'no_results' => elgg_echo('projects:tasks:none'),
];

switch ($page_type) {
	case 'owner':
		$options['owner_guid'] = $guid;
		$entities = elgg_list_entities($options);
		$title = elgg_echo('projects:task:title:owner', [$user->name]);
		break;
	case 'assigned':
		$options['relationship'] = Task::ASSIGNED_TO;
		$options['relationship_guid'] = $guid;
		$options['inverse_relationship'] = true;
		$entities = elgg_list_entities_from_relationship($options);
		$title = elgg_echo('projects:task:title:assigned', [$user->name]);
		break;
	default:
		$entities = elgg_list_entities($options);
}

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => '',
	'content' => $entities,
]);

echo elgg_view_page($title, $body);
