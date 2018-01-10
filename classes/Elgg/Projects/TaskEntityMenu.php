<?php

namespace Elgg\Projects;

use ElggMenuItem;
use ElggUser;

class TaskEntityMenu {

	/**
	 * Add menu item to the ownerblock
	 */
	public static function register ($hook, $type, $return, $params) {
		$entity = $params['entity'];

		if ($entity instanceof Task) {
			$return[] = ElggMenuItem::factory([
				'name' => 'status',
				'text' => elgg_echo("projects:status:{$entity->status}"),
				'class' => "projects-status-{$entity->status}",
			]);
		}

		return $return;
	}
}
