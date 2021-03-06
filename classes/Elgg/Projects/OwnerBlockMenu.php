<?php

namespace Elgg\Projects;

use ElggMenuItem;
use ElggUser;

class OwnerBlockMenu {

	/**
	 * Add menu item to the ownerblock
	 */
	public static function register ($hook, $type, $return, $params) {
		$entity = $params['entity'];

		if ($entity instanceof ElggUser) {
			$url = "project/owner/{$entity->username}/open";
			$return[] = new ElggMenuItem('project', elgg_echo('project:owner_block'), $url);
		} else {
			if ($entity->projects_enable != "no") {
				$url = "project/group/{$entity->guid}/open";
				$return[] = new ElggMenuItem('project', elgg_echo('project:owner_block:group'), $url);
			}
		}

		return $return;
	}
}
