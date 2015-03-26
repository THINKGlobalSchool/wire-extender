<?php
/**
 * Wire extender plugin settings
 *
 * @package WireExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 */

if (!isset($vars['entity']->post_from_activity_stream)) {
	$vars['entity']->post_from_activity_stream = 'no';
}

if (!isset($vars['entity']->show_wire_menu)) {
	$vars['entity']->show_wire_menu = 'yes';
}

echo '<div>';
echo elgg_echo('wire-extender:label:thewire:postfromactivitystream');
echo ' ';
echo elgg_view('input/dropdown', array(
		'name' => 'params[post_from_activity_stream]',
		'options_values' => array(
			'no' => elgg_echo('option:no'),
			'yes' => elgg_echo('option:yes')
			),
		'value' => $vars['entity']->post_from_activity_stream
));
echo '</div>';
	
echo '<div>';
echo elgg_echo('wire-extender:label:thewire:showinmenu');
echo ' ';
echo elgg_view('input/dropdown', array(
		'name' => 'params[show_wire_menu]',
		'options_values' => array(
			'no' => elgg_echo('option:no'),
			'yes' => elgg_echo('option:yes')
			),
		'value' => $vars['entity']->show_wire_menu
));
echo '</div>';
