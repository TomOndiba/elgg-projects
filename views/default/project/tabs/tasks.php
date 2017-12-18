<?php

namespace Elgg\Projects;

$entity = elgg_extract('entity', $vars);

$author_guid = get_input('author_guid');
$assignee_guid = get_input('assignee_guid');
$status = get_input('status');

$vars['author_guid'] = $author_guid;
$vars['author_options'][0] = elgg_echo("projects:select:author");
foreach ($entity->getAuthors() as $author) {
	$vars['author_options'][$author->guid] = $author->getDisplayName();
}

$vars['assignee_guid'] = $assignee_guid;
$vars['assignee_options'][0] = elgg_echo("projects:select:assignee");
foreach ($entity->getAssignees() as $assignee) {
	$vars['assignee_options'][$assignee->guid] = $assignee->getDisplayName();
}

$vars['status'] = $status;
$vars['status_options'] = [
	0 => elgg_echo('projects:select:status'),
	'open' => elgg_echo('projects:task:open'),
	'closed' => elgg_echo('projects:task:closed'),
	'reopened' => elgg_echo('projects:task:reopened'),
];

$filter_form = elgg_view_form(
	'project/task_filter',
	['action' => current_page_url()],
	$vars
);

$options = [
	'type' => 'object',
	'subtype' => Task::SUBTYPE,
	'container_guid' => $entity->guid,
	'no_results' => elgg_echo('projects:tasks:none'),
];

if ($author_guid) {
	$options['owner_guid'] = $author_guid;
}
if ($assignee_guid) {
	$options['relationship'] = Task::ASSIGNED_TO;
	$options['relationship_guid'] = $author_guid;
}
if ($status) {
	$options['metadata_name_value_pairs'] = [
		[
			'name' => 'status',
			'value' => $status,
		],
	];
}

$tasks = elgg_list_entities_from_relationship($options);

echo $filter_form . $tasks;
