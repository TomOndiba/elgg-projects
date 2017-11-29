<?php

$title = elgg_echo('projects:projects');

$container = elgg_extract('container', $vars);

elgg_register_title_button();

$options = [
	'type' => 'object',
	'subtype' => 'project',
	'full_view' => false,
	'no_results' => elgg_echo('projects:project:none'),
];

if ($container instanceof ElggGroup) {
	$options['container_guid'] = $container->guid;
} else {
	$options['owner_guid'] = $container->guid;
}

$entities = elgg_list_entities($options);

$body = elgg_view_layout('content', [
	'title' => $title,
	'filter' => '',
	'content' => $entities,
]);

echo elgg_view_page($title, $body);
