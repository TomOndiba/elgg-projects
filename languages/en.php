<?php

return [
	'projects:project:all' => 'All projects',
	'projects:task:add' => 'Add task',
	'projects:task:edit' => 'Edit task',
	'projects:date_start' => 'Starting time',
	'projects:date_end' => 'Ending time',
	'projects:access' => 'Read access',
	'projects:write_access' => 'Write access',
	'project:owner_block:group' => 'Group projects',
	'projects:project:none' => 'No projects',
	'projects:project' => 'Projects',
	'projects:project:action:closed' => 'Project closed',
	'projects:project:action:reopened' => 'Project reopened',
	'projects:project:not_found' => 'Project was not found',
	'project:add' => 'Add new project',
	'projects:task' => 'Task',
	'projects:tasks' => 'Tasks',
	'projects:tasks:none' => 'No tasks',
	'projects:task:assignees' => 'Assignees',
	'projects:group:enable' => 'Enable group projects',
	'projects:task:title:owner' => 'Tasks created by %s',
	'projects:task:title:assigned' => 'Tasks assigned to %s',
	'projects:task:mark_complete' => 'Mark complete',
	'projects:task:action:completed' => 'Task marked as completed',
	'projects:task:message:reopened' => 'The task was reopened',
	'projects:label:date_start' => 'Start date: %s',
	'projects:label:date_end' => 'End date: %s',
	'projects:label:date_closed' => 'Completion date: %s',
	'projects:date:format' => 'Y-m-d',
	'task:widget:description' => 'Display tasks assigned to you.',
	'projects:widget:task:numbertodisplay' => 'Amount of tasks',
	'reopen' => 'Reopen',

	'projects:project:subscribe' => 'Subscribe',
	'projects:project:unsubscribe' => 'Unsubscribe',
	'projects:project:subscribed' => 'You have been subscribed to project notifications',
	'projects:project:unsubscribed' => 'You have been unsubscribed from project notification',

	/**
	 * Translation keys generated automatically by the core
	 * notifications system.
	 *
	 * See:
	 *  - NotificationsService::getNotificationSubject()
	 *  - NotificationsService::getNotificationBody()
	 */

	 // Task was created.
	'notification:create:object:task:subject' => '%s created the task %s',
	'notification:create:object:task:body' => '
%1$s has created the task %3$s in the project %4$s

%6$s',
	// Task was closed.
	'notification:close:object:task:subject' => '%s closed the task %s',
	'notification:close:object:task:body' => '
%1$s has closed the task %3$s in the project %4$s

%6$s',
	// Task was reopened.
	'notification:reopen:object:task:subject' => '%s reopened the task %s',
	'notification:reopen:object:task:body' => '
%1$s has reopened the task %3$s in the project %4$s

%6$s',
	// Task was assigned.
	'notification:assign:object:task:subject' => '%s assigned the task %s to you',
	'notification:assign:object:task:body' => '
%s has assigned to you the task %s in the project %s

%s',
];
