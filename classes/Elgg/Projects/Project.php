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
		return "project/view/{$this->guid}";
	}

	/**
	 * Get completion percentage.
	 *
	 * @return int
	 */
	public function getCompetionPercentage() {
		$total_count = elgg_get_entities([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
			'count' => true,
		]);


		if ($total_count == 0) {
			return 0;
		}

		$finished_count = elgg_get_entities_from_metadata([
			'type' => 'object',
			'subtype' => Task::SUBTYPE,
			'container_guid' => $this->guid,
			'limit' => false,
			'count' => true,
			'metadata_name_value_pairs' => [
				[
					'name' => 'status',
					'value' => 'completed',
					'operator' => '!=',
				]
			]
		]);

		return round($finished_count / $total_count * 100);
	}
}
