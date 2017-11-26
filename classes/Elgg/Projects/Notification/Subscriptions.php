<?php

namespace Elgg\Projects\Notification;

class Subscriptions {

	/**
	 * Is user subscribed to receive notifications from the entity?
	 *
	 * @return boolean
	 */
	public function isSubscribed(\ElggUser $user, \ElggEntity $entity) {
		$subscribed = false;

		if (\elgg_is_active_plugin('notifications')) {
			$methods = \elgg_get_notification_methods();

			foreach ($methods as $method) {
				$relationship = \check_entity_relationship(
					$user->guid,
					"notify{$method}",
					$entity->guid
				);

				if ($relationship) {
					$subscribed = true;
					break;
				}
			}
		}

		return $subscribed;
	}

}