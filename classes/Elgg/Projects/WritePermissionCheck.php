<?php

namespace Elgg\Projects;

use ElggUser;

class WritePermissionCheck {

	/**
	 * Extend permissions checking to extend can-edit for write users.
	 *
	 * @param string $hook
	 * @param string $entity_type
	 * @param bool   $returnvalue
	 * @param array  $params
	 *
	 * @return bool
	 */
	public function process($hook, $entity_type, $returnvalue, $params) {
		/* @var ElggObject $entity */
		$entity = $params['entity'];

		if (!$entity instanceof Project && !$entity instanceof Task) {
			return null;
		}

		$write_permission = (int) $entity->write_access_id;
		$user = $params['user'];

		switch ($write_permission) {
			case ACCESS_PRIVATE:
				if ($user->guid != $entity->getOwnerGuid()) {
					return false;
				}

				return null;
				break;
			case ACCESS_FRIENDS:
				$owner = $entity->getOwnerEntity();
				if (($owner instanceof ElggUser) && $owner->isFriendsWith($user->guid)) {
					return true;
				}
				break;
			default:
				$list = get_access_array($user->guid);
				if (in_array($write_permission, $list)) {
					// user in the access collection
					return true;
				}
				break;
		}
	}

}
