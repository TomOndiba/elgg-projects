<?php

$fields = [
	[
		'name' => 'guid',
		'#type' => 'hidden',
	],
	[
		'name' => 'container_guid',
		'#type' => 'hidden',
	],
	[
		'name' => 'title',
		'#type' => 'text',
		'#label' => elgg_echo('title'),
	],
	[
		'name' => 'description',
		'#type' => 'longtext',
		'#label' => elgg_echo('description'),
	],
	[
		'name' => 'access_id',
		'#type' => 'access',
		'#label' => elgg_echo('projects:access'),
	],
	[
		'name' => 'write_access_id',
		'#type' => 'access',
		'#label' => elgg_echo('projects:write_access'),
	],
	[
		'name' => 'date_start',
		'#type' => 'date',
		'#label' => elgg_echo('projects:date_start'),
	],
	[
		'name' => 'date_end',
		'#type' => 'date',
		'#label' => elgg_echo('projects:date_end'),
	],
	[
		'name' => 'tags',
		'#type' => 'tags',
		'#label' => elgg_echo('tags'),
	],
	[
		'name' => 'save',
		'#type' => 'submit',
		'#text' => elgg_echo('save'),
		'text' => elgg_echo('save'),
	],
];

foreach ($fields as $properties) {
	$name = $properties['name'];

	if (elgg_language_key_exists("projects:$name:help")) {
		$properties['#help'] = elgg_echo("projects:$name:help");
	}

	$properties['value'] = elgg_extract($name, $vars);

	echo elgg_view_field($properties);
}
