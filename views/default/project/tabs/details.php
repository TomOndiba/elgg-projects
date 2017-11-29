<?php

$entity = elgg_extract('entity', $vars);

$entity_view = elgg_view_entity($entity, [
	'full_view' => true,
]);

$dates = elgg_view('object/project/dates', ['entity' => $entity]);

$percentage = $entity->getCompletionPercentage();
$completion = <<<HTML
	<span class="float-alt">{$percentage}%</span>
	<div class="elgg-progressbar mbl" style="border: 1px solid grey">
		<span style="background: green; display: block; width: {$percentage}%; height: 20px;"></span>
	</div>
HTML;

$comments = elgg_view_comments($entity);

echo $entity_view . $dates . $completion . $comments;
