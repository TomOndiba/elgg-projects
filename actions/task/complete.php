<?php

namespace Elgg\Projects;

$guid = get_input('guid');

$task = get_entity($guid);

if (!$task instanceof Task) {
	elgg_error_response(elgg_echo('projects:task:not_found'));
	exit;

	//forward(get_input('forward', REFERER));
}

if (!$task->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$task->markCompleted();

return elgg_ok_response('', elgg_echo('projects:task:action:completed'), $task->getURL());
