<?php
/**
 * Unsubscribe from project notifications.
 */

$guid = get_input('guid');

$user = elgg_get_logged_in_user_entity();

$methods = elgg_get_notification_methods();

foreach ($methods as $method) {
	elgg_remove_subscription($user->guid, $method, $guid);
}

$project = get_entity($guid);

return elgg_ok_response('', elgg_echo('projects:project:unsubscribed'), $project->getURL());
