<?php

namespace Elgg\Projects;

$guid = get_input('guid');

if ($guid) {
	$task = get_entity($guid);
} else {
	$task = new Task;
}

$fields = Task::getProperties();

foreach ($fields as $name => $type) {
	$value = get_input($name);

	if ($name == 'tags') {
		$value = string_to_tag_array($value);
	}

	$task->$name = $value;
}

if ($task->isCompleted()) {
	$task->reopen();

	system_message(elgg_echo('projects:task:message:reopened'));
}

$task->save();

$assignees = $task->setAssignees(get_input('assignees'));

return elgg_ok_response('', elgg_echo('projects:task:saved'), $task->getURL());
