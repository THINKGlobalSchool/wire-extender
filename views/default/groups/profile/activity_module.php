<?php
/**
 * groups activity module override
 * - Displays the add wire post form in the group activity module
 *
 * @package WireExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright Think Global School 2009-2010
 * @link http://www.thinkglobalschool.com
 *
 */

if ($vars['entity']->activity_enable == 'no') {
	return true;
}

$group = $vars['entity'];
if (!$group) {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "groups/activity/$group->guid",
	'text' => elgg_echo('link:view:all'),
));


// Add wire form
if (elgg_get_plugin_setting('post_from_activity_stream', 'wire-extender') == 'yes' && elgg_is_logged_in() && $vars['entity']->isMember(elgg_get_logged_in_user_guid())) {
	$wire_form = elgg_view('wire-extender/wire_form', array('group' => $vars['entity']));
}

elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$content = elgg_list_river(array(
	'limit' => 4,
	'pagination' => false,
	'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
	'wheres' => array("(e1.container_guid = $group->guid)"),
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('groups:activity:none') . '</p>';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('groups:activity'),
	'content' => $wire_form . $content,
	'all_link' => $all_link,
));
