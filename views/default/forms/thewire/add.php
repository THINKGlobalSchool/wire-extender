<?php
/**
 * wire form override
 *
 * @package WireExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright Think Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org
 *
 */

elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('reply');
}
$chars_left = elgg_echo('thewire:charleft');

$parent_input = '';
if ($post) {
	$parent_input = elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 2;
if ($char_limit == 0) {
	$num_lines = 3;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 3;
}

// Sort out group access
if (isset($vars['group']) && elgg_instanceof($vars['group'], 'group')) {
	$access_id = $vars['group']->group_acl;
	$container_guid = elgg_view('input/hidden', array(
		'name' => 'container_guid',
		'value' => $vars['group']->getGUID(),
	));
}

$post_input = elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => 'thewire-textarea',
	'rows' => $num_lines,
	'data-max-length' => $char_limit,
));

$access = "<label>" . elgg_echo("wire-extender:label:thewire:access") . "</label>";
$access .= elgg_view('input/access', array(
	'name' => 'access_id', 
	'value' => (int)get_default_access(),
	'style' => 'float: none;',
));

$tips = "<div class='elgg-subtext'>" . elgg_echo("wire-extender:label:thewire:tips") . "</div>";

$submit_button = elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
));

$extension = elgg_view('forms/thewire/extend');

echo <<<HTML
	$post_input
<div id="thewire-characters-remaining">
	$count_down
</div>
$tips
$extension
$access
<div class="elgg-foot mts">
	$container_guid
	$parent_input
	$submit_button
</div>
HTML;
