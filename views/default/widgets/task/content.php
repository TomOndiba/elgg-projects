<?php
/**
 * View for displaying widget content
 */

namespace Elgg\Projects;

$widget = elgg_extract('entity', $vars);

$content = elgg_list_entities_from_relationship([
	'type' => 'object',
	'subtype' => Task::SUBTYPE,
	'relationship' => Task::ASSIGNED_TO,
	'relationship_guid' => $widget->owner_guid,
	'inverse_relationship' => $widget->owner_guid,
	'limit' => $widget->num_display,
	'pagination' => false,
	'order_by_metadata' => [
		'name' => 'date_end',
		'direction' => 'ASC',
		'as' => 'text',
	],
]);

if (empty($content)) {
	echo elgg_echo('projects:tasks:none');
	return;
}

echo $content;

$more_link = elgg_view('output/url', [
	'href' => 'task/assigned/' . $widget->getOwnerEntity()->username,
	'text' => elgg_echo('more'),
	'is_trusted' => true,
]);
echo "<div class=\"elgg-widget-more\">$more_link</div>";
