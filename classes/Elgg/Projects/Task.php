<?php

namespace Elgg\Projects;

use ElggObject;

class Task extends ElggObject {
	const SUBTYPE = 'task';

	const ASSIGNED_TO = 'assigned_to';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * Make sure new tasks have the 'open' status by default.
	 */
	public function save() {
		if (empty($this->guid)) {
			$this->status = 'open';
		}
		parent::save();
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
			'tags' => 'tags',
		];
	}

	/**
	 *
	 */
	public function getURL() {
		return elgg_normalize_url("task/view/{$this->guid}");
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
				$this->removeRelationship($user->guid, self::ASSIGNED_TO);
			}
		}

		// If no users are selected, the value of the tokeninput field
		// will be an aray: [0 => ''].
		if (empty($user_guids[0])) {
			return;
		}

		$logged_in_guid = elgg_get_logged_in_user_guid();

		$from = elgg_get_logged_in_user_entity();
		foreach ($user_guids as $user_guid) {
			$this->addRelationship($user_guid, self::ASSIGNED_TO);

			if ($user_guid == $logged_in_guid) {
				// Do not notify if assigning to self.
				continue;
			}

			$user = get_user($user_guid);

			$subject = elgg_echo(
				'notification:assign:object:task:subject',
				[
					$from->getDisplayName(),
					$this->getDisplayName(),
				],
				$user->language
			);

			$message = elgg_echo(
				'notification:assign:object:task:body',
				[
					$from->getDisplayName(),
					$this->getDisplayName(),
					$this->getContainerEntity()->getDisplayName(),
					$this->getURL()
				],
				$user->language
			);

			notify_user($user_guid, $from->guid, $subject, $message, [
				'object' => $this,
				'action' => 'assign',
			]);
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
	 * Mark this task as closed.
	 *
	 * Will change the status of the task and save the completion date.
	 */
	public function markClosed() {
		$this->status = 'closed';
		$this->date_closed = time();

		elgg_trigger_event('close', 'object', $this);
	}

	/**
	 * Is this task closed?
	 *
	 * @return boolean
	 */
	public function isClosed() {
		return $this->status == 'closed';
	}

	/**
	 * Remove completion date and set status to 'open'.
	 */
	public function reopen() {
	    $this->date_closed = null;
		$this->status = 'open';

		elgg_trigger_event('reopen', 'object', $this);
	}

	/**
	 * Can user mark this task as closed?
	 *
	 * @param ElggUser $user
	 */
	public function canClose(\ElggUser $user) {
		// Task cannot be closed if it already is closed.
		if ($this->isClosed()) {
			return false;
		}

		// All people who can edit the task can also close it.
		if ($this->canEdit()) {
			return true;
		}

		// All assignees are allowed to close their own tasks.
		foreach ($this->getAssignees() as $assignee) {
			if ($assignee->guid == $user->guid) {
				return true;
			}
		}

		return false;

	}

}
