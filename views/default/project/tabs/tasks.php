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
];

if ($author_guid) {
	$options['owner_guid'] = $author_guid;
}

if ($assignee_guid) {
	$options['relationship'] = Task::ASSIGNED_TO;
	$options['relationship_guid'] = $assignee_guid;
	$options['inverse_relationship'] = true;
}

$tasks = elgg_get_entities_from_relationship($options);

// It's not possible to query simultaneously both by metadata and
// by relationships, so this hack filters the metadata afterwards.
if ($status) {
	foreach ($tasks as $key => $task) {
		if ($task->status != $status) {
			unset($tasks[$key]);
		}
	}
}

if (empty($tasks)) {
	$tasks = elgg_echo('projects:tasks:none');
} else {
	$tasks = elgg_view_entity_list($tasks, [
		'full_view' => false,
	]);
}

echo $filter_form . $tasks;
