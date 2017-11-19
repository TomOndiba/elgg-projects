<?php

namespace Elgg\Projects;

$guid = get_input('guid');

if ($guid) {
	$project = get_entity($guid);
} else {
	$project = new Task;
}

$fields = Task::getProperties();

foreach ($fields as $name => $type) {
	$value = get_input($name);

	if ($name == 'tags') {
		$value = string_to_tag_array($value);
	}

	$project->$name = $value;
}

$project->save();

return elgg_ok_response('', elgg_echo('saved'), $project->getURL());
