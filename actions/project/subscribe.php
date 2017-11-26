<?php
/**
 * Subscribe to project notifications.
 */

$guid = get_input('guid');

$user = elgg_get_logged_in_user_entity();

$methods = $user->getNotificationSettings();

foreach ($methods as $method => $enabled) {
	if ($enabled) {
		elgg_add_subscription($user->guid, $method, $guid);
	}
}

$project = get_entity($guid);

return elgg_ok_response('', elgg_echo('projects:project:subscribed'), $project->getURL());
