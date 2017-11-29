<?php

namespace Elgg\Projects;

$title = elgg_echo('projects:project');

$guid = elgg_extract('guid', $vars);

$entity = get_entity($guid);

$user = elgg_get_logged_in_user_entity();

if ($user) {
	if ($entity->canEdit()) {
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
	}

	$subscriptions = new Notification\Subscriptions();

	if ($subscriptions->isSubscribed($user, $entity)) {
		elgg_register_menu_item('title', [
			'name' => 'unsubscribe',
			'text' => elgg_echo('projects:project:unsubscribe'),
			'href' => "action/project/unsubscribe?guid={$guid}",
			'link_class' => 'elgg-button elgg-button-action',
			'is_action' => true,
		]);
	} else {
		elgg_register_menu_item('title', [
			'name' => 'subscribe',
			'text' => elgg_echo('projects:project:subscribe'),
			'href' => "action/project/subscribe?guid={$guid}",
			'link_class' => 'elgg-button elgg-button-action',
			'is_action' => true,
		]);
	}
}

$entity_view = elgg_view_entity($entity, [
	'full_view' => true,
]);

$dates = elgg_view('object/project/dates', ['entity' => $entity]);

$percentage = $entity->getCompletionPercentage();
$completion = <<<HTML
	<div class="elgg-progressbar mvl" style="border: 1px solid grey">
		<span style="background: green; display: block; width: {$percentage}%">{$percentage}%</span>
	</div>
HTML;

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
	'content' => $entity_view . $dates . $completion . $tasks . $comments,
]);

echo elgg_view_page($title, $body);
