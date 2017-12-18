<?php

echo elgg_view_field([
    'name' => 'author_guid',
    '#type' => 'select',
    'options_values' => $vars['author_options'],
    'value' => $vars['author_guid'],
]);

echo elgg_view_field([
    'name' => 'assignee_guid',
    '#type' => 'select',
    'options_values' => $vars['assignee_options'],
    'value' => $vars['assignee_guid'],
]);

echo elgg_view_field([
    'name' => 'status',
    '#type' => 'select',
    'options_values' => $vars['status_options'],
    'value' => $vars['status'],
]);

echo elgg_view_field([
    'name' => 'save',
    '#type' => 'submit',
    '#text' => elgg_echo('save'),
    'text' => elgg_echo('save'),
]);
