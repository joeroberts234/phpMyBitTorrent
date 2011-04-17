<?php
/*
*------------------------------phpMyBitTorrent V 2.0.5-------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*/
define("IN_PMBT",true);
define('BBCODES_TABLE','torrent_bbcodes');
include_once'include/class.template.php';
include_once'include/class.bbcode.php';
$template = & new Template();
	$lang = array();
$lang = array_merge($lang, array(
	'HTML_REPLACEMENT'				=> 'HTML replacement',
	'HTML_REPLACEMENT_EXAMPLE'		=> '&lt;span style="background-color: {COLOR};"&gt;{TEXT}&lt;/span&gt;<br /><br />&lt;span style="font-family: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;',
	'HTML_REPLACEMENT_EXPLAIN'		=> 'Here you define the default HTML replacement. Do not forget to put back tokens you used above!',
	'BBCODE_ADDED'				=> 'BBCode added successfully.',
	'BBCODE_EDITED'				=> 'BBCode edited successfully.',
	'BBCODE_NOT_EXIST'			=> 'The BBCode you selected does not exist.',
	'BBCODE_HELPLINE'			=> 'Help line',
	'BBCODE_HELPLINE_EXPLAIN'	=> 'This field contains the mouse over text of the BBCode.',
	'BBCODE_HELPLINE_TEXT'		=> 'Help line text',
	'BBCODE_HELPLINE_TOO_LONG'	=> 'The help line you entered is too long.',
	'DISPLAY_ON_POSTING'		=> 'Display on posting page',
	'TOKEN'					=> 'Token',
	'TOKENS'				=> 'Tokens',
	'TOKENS_EXPLAIN'		=> 'Tokens are placeholders for user input. The input will be validated only if it matches the corresponding definition. If needed, you can number them by adding a number as the last character between the braces, e.g. {TEXT1}, {TEXT2}.<br /><br />Within the HTML replacement you can also use any language string present in your language/ directory like this: {L_<em>&lt;STRINGNAME&gt;</em>} where <em>&lt;STRINGNAME&gt;</em> is the name of the translated string you want to add. For example, {L_WROTE} will be displayed as &quot;wrote&quot; or its translation according to user\'s locale.<br /><br /><strong>Please note that only tokens listed below are able to be used within custom BBCodes.</strong>',
	'TOKEN_DEFINITION'		=> 'What can it be?',
	'TOO_MANY_BBCODES'		=> 'You cannot create any more BBCodes. Please remove one or more BBCodes then try again.',
	'BBCODE_USAGE'				=> 'BBCode usage',
	'BBCODE_USAGE_EXAMPLE'		=> '[highlight={COLOR}]{TEXT}[/highlight]<br /><br />[font={SIMPLETEXT1}]{SIMPLETEXT2}[/font]',
	'BBCODE_USAGE_EXPLAIN'		=> 'Here you define how to use the BBCode. Replace any variable input by the corresponding token (%ssee below%s).',
	'ACP_BBCODES_EXPLAIN'		=> 'BBCode is a special implementation of HTML offering greater control over what and how something is displayed. From this page you can add, remove and edit custom BBCodes.',
	'BACK'					=> 'Back',
	'ACP_BBCODES'				=> 'BBCodes',
	'EXAMPLES'						=> 'Examples:',
	'SETTINGS'					=> 'Settings',
	'SUBMIT'					=> 'Submit',
	'RESET'						=> 'Reset',
	'BBCODE_TAG'				=> 'Tag',
	'ACTION'				=> 'Action',
	'ADD_BBCODE'				=> 'Add a new BBCode',
	'ACP_NO_ITEMS'				=> 'There are no items yet.',
));
foreach($lang as $key => $value)define($key,$value);
	$template->assign_vars(array(
		'ICON_EDIT'					=> '<img src="themes/' . $themne . '/pics/edit.gif" alt="Edit" title="Edit" border="0">',
		'ICON_DELETE'				=> '<img src="themes/' . $themne . '/pics/drop.gif" alt="Delete" title="Delete" border="0">',
	'ACP_BBCODES'				=> 'BBCodes',
));
$bbcode  = & new acp_bbcodes();
//set_site_var('Admin');
$bbcode->main('1','edit');
$bbcode->u_action = 'admin.php';
echo $template->fetch('acp_bbcodes.html');
?>