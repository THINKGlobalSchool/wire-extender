<?php
/**
 * wire form override
 *
 * @package WireExtender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright Think Global School 2009-2010
 * @link http://www.thinkglobalschool.com
 *
 */

elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('thewire:reply');
}

if ($post) {
	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
}

// Sort out group access
if (isset($vars['group']) && elgg_instanceof($vars['group'], 'group')) {
	$access_id = $vars['group']->group_acl;
	$container_guid = elgg_view('input/hidden', array(
		'name' => 'container_guid',
		'value' => $vars['group']->getGUID(),
	));
}

$access = "<label>" . elgg_echo("wire-extender:label:thewire:access") . "</label>";
$access .= elgg_view('input/access', array(
	'name' => 'access_id', 
	'value' => (int)get_default_access(),
	'style' => 'float: none;',
));


if (elgg_get_plugin_setting('limit_wire_chars', 'wire-extender') != 'no') {
	$characters_content = '<div id="thewire-characters-remaining"><span>140</span>&nbsp;' . elgg_echo('thewire:charleft') . '</div>';
	$textarea_id = 'thewire-textarea';
} else {
	$textarea_id = 'thewire-nolimit-textarea';
	$style = "style='height: 80px; padding: 8px;'";
}

?>
<textarea id="<?php echo $textarea_id; ?>" <?php echo $style; ?> name="body" class="mtm"></textarea>
<div class="mts">
<?php
echo $characters_content;

echo $container_guid;

echo "<div class='elgg-subtext'>" . elgg_echo("wire-extender:label:thewire:tips") . "</div>";

echo elgg_view('forms/thewire/extend');

echo $access;

echo elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
));
?>
</div>