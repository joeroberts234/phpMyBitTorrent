<?php
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'PRIMARY_GROUP'		=> 'Primary group',
	'REMOVE_SELECTED'		=> 'Remove selected',
	'USER_GROUP_CHANGE'			=> 'From “%1$s” group to “%2$s”',
	'USER_GROUP_DEMOTE'			=> 'Demote leadership',
	'USER_GROUP_DEMOTE_CONFIRM'	=> 'Are you sure you want to demote as group leader from the selected group?',
	'USER_GROUP_DEMOTED'		=> 'Successfully demoted your leadership.',
));

?>