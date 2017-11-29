<?php

use Elgg\Projects\Project;
use Elgg\Projects\Task;

elgg_register_event_handler('init', 'system', 'projects_init');

/**
 *
 */
function projects_init() {
	elgg_register_page_handler('task', 'task_page_handler');
	elgg_register_page_handler('project', 'project_page_handler');

	elgg_register_menu_item('site', [
		'name' => 'project',
		'text' => elgg_echo('projects:projects'),
		'href' => 'project/all',
	]);

	elgg_register_action('project/save', __DIR__ . '/actions/project/save.php');
	elgg_register_action('project/subscribe', __DIR__ . '/actions/project/subscribe.php');
	elgg_register_action('project/unsubscribe', __DIR__ . '/actions/project/unsubscribe.php');
	elgg_register_action('project/close', __DIR__ . '/actions/project/close.php');
	elgg_register_action('project/reopen', __DIR__ . '/actions/project/reopen.php');

	elgg_register_action('task/save', __DIR__ . '/actions/task/save.php');
	elgg_register_action('task/complete', __DIR__ . '/actions/task/complete.php');

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', '\Elgg\Projects\OwnerBlockMenu::register');
	elgg_register_plugin_hook_handler('permissions_check', 'object', '\Elgg\Projects\WritePermissionCheck::process');

	elgg_register_notification_event('object', Project::SUBTYPE, [
		'create',
	]);

	elgg_register_notification_event('object', Task::SUBTYPE, [
		'create',
		'assign',
		'close',
		'reopen',
	]);

	add_group_tool_option('projects', elgg_echo('projects:group:enable'));

	elgg_register_widget_type('task', elgg_echo('projects:tasks'), elgg_echo('task:widget:description'));

	// Registers the view project/calendar.php to be
	// called with the URL ajax/view/project/calendar.
	elgg_register_ajax_view('project/calendar');
}

/**
 *
 */
function project_page_handler($page) {
	$page_type = elgg_extract(0, $page, 'all');

	$link = null;
	if ($page_type != 'all') {
		$link = 'project/all';
	}
	elgg_push_breadcrumb(elgg_echo('projects:project:all'), $link);

	$identifier = elgg_extract(1, $page);

	$vars = ['page_type' => $page_type];

	switch ($page_type) {
		case 'owner':
			$vars['container'] = get_user_by_username($identifier);
			echo elgg_view_resource("project/list", $vars);
			break;
		case 'group':
			$vars['container'] = get_entity($identifier);
			echo elgg_view_resource("project/list", $vars);
			break;
		case 'view':
			$vars['tab'] = get_input('tab', 'details');
			$vars['guid'] = $identifier;
			echo elgg_view_resource("project/view", $vars);
			break;
		case 'edit':
		case 'add':
			$vars['guid'] = $identifier;
			echo elgg_view_resource("project/save", $vars);
			break;
		default:
			echo elgg_view_resource("project/list", $vars);
	}
}

/**
 *
 */
function task_page_handler($page) {
	$page_type = elgg_extract(0, $page, 'all');

	elgg_push_breadcrumb(elgg_echo('projects:project:all'), 'project/all');

	$identifier = elgg_extract(1, $page);

	$vars = ['page_type' => $page_type];

	switch ($page_type) {
		case 'view':
			$vars['guid'] = $identifier;
			echo elgg_view_resource("task/view", $vars);
			break;
		case 'edit':
		case 'add':
			$vars['guid'] = $identifier;
			echo elgg_view_resource("task/save", $vars);
			break;
		case 'owner':
		case 'assigned':
			$user = get_user_by_username($identifier);
			$vars['guid'] = $user->guid;
		default:
			echo elgg_view_resource("task/list", $vars);
			break;
	}

}
