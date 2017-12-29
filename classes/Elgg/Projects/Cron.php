<?php

namespace Elgg\Projects;

class Cron {

	/**
	 * Send reminders to task assignees at specific intervals.
	 *
	 * -10 days, -1 week, -3 days, -1 day
	 *
	 * @param string $hook   'cron'
	 * @param string $period 'daily'
	 * @param string $return Empty string
	 * @param array  $params Hook parameters
	 */
	public function process($hook, $period, $return, $params) {
		$intervals = [10, 7, 3, 1];

		foreach ($intervals as $interval) {
			foreach (self::getTasksFromInterval($interval) as $task) {
				self::sendNotifications($task);
			}
		}
	}

	/**
	 * Get tasks where deadline is on the given day.
	 *
	 * @param int $days
	 * @return Task[]
	 */
	private static function getTasksFromInterval($days) {
		$day = 86400;

		return elgg_get_entities_from_metadata([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'metadata_name_value_pairs' => [
				[
					'name' => 'date_end',
					'value' => time() + ($days -1) * $day,
					'operand' => '>',
				],
				[
					'name' => 'date_end',
					'value' => time() + ($days) * $day,
					'operand' => '<',
				],

			]
		]);
	}

	/**
	 * Send notifications to assignees.
	 *
	 * @param Task $task
	 */
	private static function sendNotifications(Task $task) {
		$from = elgg_get_site_entity()->guid;

		foreach ($task->getAssignees() as $user) {
			$date_format = elgg_echo('projects:date:format', [], $user->language);

			$subject = elgg_echo('projects:reminder:title', [$task->title], $user->language);

			$message = elgg_echo('projects:reminder:body', [
				$task->title,
				date($date_format, $task->date_end),
				$task->getURL(),
			], $user->language);

			$params = [
				'action' => 'reminder',
				'object' => $task,
			];

			notify_user($user->guid, $from, $subject, $message, $params);
		}
	}

}
