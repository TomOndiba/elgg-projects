<?php

namespace Elgg\Projects;

$guid = get_input('guid');

$project = get_entity($guid);

if (!$project instanceof Project) {
	elgg_error_response(elgg_echo('projects:project:not_found'));
	exit;
}

if (!$project->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$project->markClosed();

return elgg_ok_response('', elgg_echo('projects:project:action:closed'), $project->getURL());
