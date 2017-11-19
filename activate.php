<?php

$subtypes = [
	'project' => 'Elgg\Projects\Project',
	'task' => 'Elgg\Projects\Task',
];

foreach ($subtypes as $name => $class) {
	add_subtype('object', $name, $class);
}
