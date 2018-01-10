<?php

namespace Elgg\Projects;

use ElggObject;

class Project extends ElggObject {
	const SUBTYPE = 'project';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * Make sure new projects have the 'open' status by default.
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
		return "project/view/{$this->guid}";
	}

	/**
	 * Mark this project as closed.
	 *
	 * Will change the status of the project and save the completion date.
	 */
	public function markClosed() {
		$this->status = 'closed';
		$this->date_closed = time();

		elgg_trigger_event('close', 'object', $this);
	}

	/**
	 * Is this project closed?
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
	 * Get total amount of tasks.
	 *
	 * @return int
	 */
	public function countTotal() {
		return elgg_get_entities([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
			'count' => true,
		]);
	}

	/**
	 * Get total amount of closed tasks.
	 *
	 * @return int
	 */
	public function countClosed() {
		return elgg_get_entities_from_metadata([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
			'count' => true,
			'metadata_name_value_pairs' => [
				[
					'name' => 'status',
					'value' => 'closed',
					'operator' => '!=',
				]
			]
		]);
	}

	/**
	 * Get completion percentage.
	 *
	 * @return int
	 */
	public function getCompletionPercentage() {
		$total_count = $this->countTotal();

		if ($total_count == 0) {
			return 0;
		}

		$finished_count = $this->countClosed();

		return round($finished_count / $total_count * 100);
	}


	/**
	 * Return all task authors in the project.
	 *
	 * @return ElggUser[] $authors All the task authors in the project.
	 */
	public function getAuthors() {
		$tasks = elgg_get_entities([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
		]);

		$authors = [];
		foreach ($tasks as $task) {
			$authors[$task->getOwnerGUID()] = $task->getOwnerEntity();
		}

		return $authors;
	}

	/**
	 * Return all task assignees in the project.
	 *
	 * @return ElggUser[] $assignees All the task assignees in the project.
	 */
	public function getAssignees() {
		$tasks = elgg_get_entities([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
		]);

		$assignees = [];
		foreach ($tasks as $task) {
			$task_assignees = $task->getAssignees();

			foreach ($task_assignees as $assignee) {
				$assignees[$task->getOwnerGUID()] = $task->getOwnerEntity();
			}
		}

		return $assignees;
	}

}
