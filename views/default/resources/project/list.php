<?php

$title = elgg_echo('projects:projects');

$container = elgg_extract('container', $vars);
$page_type = elgg_extract('page_type', $vars);
$tab = elgg_extract('tab', $vars);

elgg_register_title_button();

$options = [
	'type' => 'object',
	'subtype' => 'project',
	'full_view' => false,
	'no_results' => elgg_echo('projects:project:none'),
];

$options['container_guid'] = $container->guid;

if ($tab != 'all') {
	$options['metadata_name_value_pairs'] = [
		[
			'name' => 'status',
			'value' => $tab,
		],
	];
}

function projects_get_tab_url($container, $page_type, $status) {
	if ($page_type == 'all') {
		return "/project/all/$status";
	}

	if ($container instanceof ElggUser) {
		return "/project/owner/{$container->username}/$status";
	}

	if ($container instanceof ElggGroup) {
		return "/project/group/{$container->guid}/$status";
	}
}

$entities = elgg_list_entities_from_metadata($options);

$tabs = elgg_view('navigation/tabs', [
	'tabs' => [
		[
			'text' => elgg_echo('projects:status:open'),
			'href' => projects_get_tab_url($container, $page_type, 'open'),
			'selected' => $tab == 'open'
		],
		[
			'text' => elgg_echo('projects:status:closed'),
			'href' => projects_get_tab_url($container, $page_type, 'closed'),
			'selected' => $tab == 'closed'
		],
		[
			'text' => elgg_echo('all'),
			'href' => projects_get_tab_url($container, $page_type, 'all'),
			'selected' => $tab == 'all'
		],
	],
]);

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => $tabs,
	'content' => $entities,
]);

echo elgg_view_page($title, $body);
