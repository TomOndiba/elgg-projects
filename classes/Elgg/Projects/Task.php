<?php

namespace Elgg\Projects;

use ElggObject;

class Task extends ElggObject {
	const SUBTYPE = 'task';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 *
	 */
	public static function getProperties(){
		return [
			'guid' => 'hidden',
			'container_guid' => 'hidden',
			'title' => 'text',
			'description' => 'longtext',
			'category' => 'text',
			'access_id' => 'access',
			'write_access_id' => 'access',
			'date_start' => 'date',
			'date_end' => 'date',
			'date_completed' => 'date',
			'tags' => 'tags',
		];
	}

	/**
	 *
	 */
	public function getURL() {
		return "task/view/{$this->guid}";
	}

	/**
	 * Set assignees for this task.
	 *
	 * Users missing from the input array will be unassigned.
	 *
	 * @param array $user_guids
	 */
	public function setAssignees($user_guids) {
		$existing = $this->getAssignees();

		foreach ($existing as $user) {
			if (!in_array($user->guid, $user_guids)) {
				$this->removeRelationship($user->guid, 'assigned_to');
			}
		}

		foreach ($user_guids as $user_guid) {
			$this->addRelationship($user_guid, 'assigned_to');
		}
	}

	/**
	 * Get all users assigned to this task.
	 *
	 * @return ElggUser[]
	 */
	public function getAssignees() {
		return $this->getEntitiesFromRelationship([
			'relationship' => 'assigned_to',
		]);
	}

	/**
	 * Mark this task as completed.
	 *
	 * Will change the status of the task and save the completion date.
	 */
	public function markCompleted() {
		$this->status = 'completed';
		$this->date_completed = time();
	}

	/**
	 * Is this task completed?
	 *
	 * @return boolean
	 */
	public function isCompleted() {
		return $this->status == 'completed';
	}

}
