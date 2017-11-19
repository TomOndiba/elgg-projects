<?php

elgg_register_event_handler('init', 'system', 'projects_init');

/**
 *
 */
function projects_init() {
	elgg_register_page_handler('task', 'task_page_handler');
	elgg_register_page_handler('project', 'project_page_handler');

	elgg_register_action('project/save', __DIR__ . '/actions/project/save.php');
	elgg_register_action('task/save', __DIR__ . '/actions/task/save.php');
	elgg_register_action('task/complete', __DIR__ . '/actions/task/complete.php');

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', '\Elgg\Projects\OwnerBlockMenu::register');

	add_group_tool_option('projects', elgg_echo('projects:group:enable'));
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
	if (in_array($page[0], ['add', 'edit'])) {
		$page[0] = 'save';
	}

	elgg_push_breadcrumb(elgg_echo('projects:project:all'), 'project/all');

	echo elgg_view_resource("task/{$page[0]}", $page);
}
