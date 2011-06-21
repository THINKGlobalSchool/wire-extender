<?php
/**
 * Wire Extender start.php
 *
 * @package WireExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright Think Global School 2009-2010
 * @link http://www.thinkglobalschool.com
 * 
 * Provides the following features/functionality
 * - Enable/Disable the wire character limit
 * - Post to wire from activity steam 
 * - Group wire posts
 *
 * The following views have been added/overidden
 * - forms/thewire/add
 * - actions/thewire/add
 * - groups/profile/activity_module
 */

// Register init event 
elgg_register_event_handler('init', 'system', 'wire_extender_init');


/**
 * Init
 */
function wire_extender_init() {
	
	elgg_register_library('elgg:wire-extender', elgg_get_plugins_path() . 'wire-extender/lib/wire-extender.php');
	elgg_load_library('elgg:wire-extender');
	
	// Post from activity stream	
	if (elgg_get_plugin_setting('post_from_activity_stream', 'wire-extender') == 'yes' && elgg_is_logged_in()) {
		// Extend core river filter
		elgg_extend_view('core/river/filter', 'wire-extender/wire_form', -100);
	}
	
	// Show wire on the menu
	if (elgg_get_plugin_setting('show_wire_menu', 'wire-extender') == 'no') {
		// Register hook to remove the wire from the site menu
		elgg_register_plugin_hook_handler('register', 'menu:site', 'wire_extender_site_menu_setup');
	}
	
	/* ACTIONS */	
	$action_base = elgg_get_plugins_path() . 'wire-extender/actions/thewire';
	elgg_register_action("thewire/add", "$action_base/add.php");
}

/**
 * Remove the wire from the site menu
 */
function wire_extender_site_menu_setup($hook, $type, $return, $params) {
	foreach($return as $idx => $item) {
		if ($item->getName() == 'thewire') {
			unset($return[$idx]);
		}
	}
	
	return $return;
}
