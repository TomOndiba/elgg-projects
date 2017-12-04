<?php

namespace Elgg\Projects;

$guid = elgg_extract('guid', $vars);
$tab = elgg_extract('tab', $vars);

elgg_entity_gatekeeper($guid, 'object', Project::SUBTYPE);
elgg_group_gatekeeper();

$title = elgg_echo('projects:project');

$entity = get_entity($guid);

$user = elgg_get_logged_in_user_entity();

if ($user) {
	if ($entity->canEdit()) {
		if ($entity->isClosed()) {
			elgg_register_menu_item('title', [
				'name' => 'project_reopen',
				'text' => elgg_echo('reopen'),
				'href' => "action/project/reopen?guid={$guid}",
				'link_class' => 'elgg-button elgg-button-action',
				'is_action' => true,
				'confirm' => true,
			]);
		} else {
			elgg_register_menu_item('title', [
				'name' => 'project_close',
				'text' => elgg_echo('close'),
				'href' => "action/project/close?guid={$guid}",
				'link_class' => 'elgg-button elgg-button-action',
				'is_action' => true,
				'confirm' => true,
			]);
		}

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

$tabs = elgg_view('project/tabs', [
	'tab' => $tab,
	'entity' => $entity,
]);

$vars['entity'] = $entity;

$content = elgg_view("project/tabs/$tab", $vars);

$body = elgg_view_layout('content', [
	'title' => $entity->title,
	'filter' => $tabs,
	'content' => $content,
]);

echo elgg_view_page($title, $body);
