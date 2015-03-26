<?php
/**
 * Action for adding a wire post, override
 * 
 */

// don't filter since we strip and filter escapes some characters
$body = get_input('body', '', false);

$access_id = get_input('access_id', ACCESS_LOGGED_IN);
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

$container_guid = get_input('container_guid', NULL);

$container = get_entity($container_guid);

if (elgg_instanceof($container, 'group') && !$container->canWriteToContainer(elgg_get_logged_in_user_guid())) {
	register_error(elgg_echo('wire-extender:error:nogrouppermission'));
	forward(REFERER);
}

// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}

$guid = tgswire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method, $container_guid);
if (!$guid) {
	register_error(elgg_echo("thewire:notsaved"));
	forward(REFERER);
}

// if reply, forward to thread display page
if ($parent_guid) {
	$parent = get_entity($parent_guid);
	forward("thewire/thread/$parent->wire_thread");
}

system_message(elgg_echo("thewire:posted"));
forward(REFERER);
