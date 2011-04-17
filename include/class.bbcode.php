<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_personal.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function add_form_key($form_name)
{
	global $config, $template, $user;

	$now = time();
	$token_sid = '';
	$token = sha1($now . '5522211445' . $form_name . $token_sid);

	$s_fields = build_hidden_fields(array(
		'creation_time' => $now,
		'form_token'	=> $token,
	));

	$template->assign_vars(array(
		'S_FORM_TOKEN'	=> $s_fields,
	));
}
function get_preg_expression($mode)
{
	switch ($mode)
	{
		case 'email':
			return '(?:[a-z0-9\'\.\-_\+\|]++|&amp;)+@[a-z0-9\-]+\.(?:[a-z0-9\-]+\.)*[a-z]+';
		break;

		case 'bbcode_htm':
			return array(
				'#<!\-\- e \-\-><a href="mailto:(.*?)">.*?</a><!\-\- e \-\->#',
				'#<!\-\- l \-\-><a (?:class="[\w-]+" )?href="(.*?)(?:(&amp;|\?)sid=[0-9a-f]{32})?">.*?</a><!\-\- l \-\->#',
				'#<!\-\- ([mw]) \-\-><a (?:class="[\w-]+" )?href="(.*?)">.*?</a><!\-\- \1 \-\->#',
				'#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#',
				'#<!\-\- .*? \-\->#s',
				'#<.*?>#s',
			);
		break;

		// Whoa these look impressive!
		// The code to generate the following two regular expressions which match valid IPv4/IPv6 addresses
		// can be found in the develop directory
		case 'ipv4':
			return '#^(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$#';
		break;

		case 'ipv6':
			return '#^(?:(?:(?:[\dA-F]{1,4}:){6}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:::(?:[\dA-F]{1,4}:){5}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:):(?:[\dA-F]{1,4}:){4}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,2}:(?:[\dA-F]{1,4}:){3}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,3}:(?:[\dA-F]{1,4}:){2}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,4}:(?:[\dA-F]{1,4}:)(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,5}:(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,6}:[\dA-F]{1,4})|(?:(?:[\dA-F]{1,4}:){1,7}:))$#i';
		break;

		case 'url':
		case 'url_inline':
			$inline = ($mode == 'url') ? ')' : '';
			$scheme = ($mode == 'url') ? '[a-z\d+\-.]' : '[a-z\d+]'; // avoid automatic parsing of "word" in "last word.http://..."
			// generated with regex generation file in the develop folder
			return "[a-z]$scheme*:/{2}(?:(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+|[0-9.]+|\[[a-z0-9.]+:[a-z0-9.]+:[a-z0-9.:]+\])(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;

		case 'www_url':
		case 'www_url_inline':
			$inline = ($mode == 'www_url') ? ')' : '';
			return "www\.(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;

		case 'relative_url':
		case 'relative_url_inline':
			$inline = ($mode == 'relative_url') ? ')' : '';
			return "(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;
	}

	return '';
}

class acp_bbcodes
{
	var $u_action = 'admin.php?op=bbcode';

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		//$user->add_lang('acp/posting');

		// Set up general vars
		$action	= request_var('action', '');
		$bbcode_id = request_var('bbcode', 0);

		$this->tpl_name = 'acp_bbcodes';
		$this->page_title = 'ACP_BBCODES';
		$form_key = 'acp_bbcodes';

		add_form_key($form_key);

		// Set up mode-specific vars
		switch ($action)
		{
			case 'add':
				$bbcode_match = $bbcode_tpl = $bbcode_helpline = '';
				$display_on_posting = 0;
			break;

			case 'edit':
				$sql = 'SELECT bbcode_match, bbcode_tpl, display_on_posting, bbcode_helpline
					FROM ' . BBCODES_TABLE . '
					WHERE bbcode_id = ' . $bbcode_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($user->lang['BBCODE_NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$bbcode_match = $row['bbcode_match'];
				$bbcode_tpl = htmlspecialchars($row['bbcode_tpl']);
				$display_on_posting = $row['display_on_posting'];
				$bbcode_helpline = $row['bbcode_helpline'];
			break;

			case 'modify':
				$sql = 'SELECT bbcode_id, bbcode_tag
					FROM ' . BBCODES_TABLE . '
					WHERE bbcode_id = ' . $bbcode_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($user->lang['BBCODE_NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

			// No break here

			case 'create':
				$display_on_posting = request_var('display_on_posting', 0);

				$bbcode_match = request_var('bbcode_match', '');
				$bbcode_tpl = htmlspecialchars_decode(request_var('bbcode_tpl', '', true));
				$bbcode_helpline = request_var('bbcode_helpline', '', true);
			break;
		}

		// Do major work
		switch ($action)
		{
			case 'edit':
			case 'add':

				$template->assign_vars(array(
					'S_EDIT_BBCODE'		=> true,
					'U_BACK'			=> $this->u_action,
					'U_ACTION'			=> $this->u_action . '&amp;action=' . (($action == 'add') ? 'create' : 'modify') . (($bbcode_id) ? "&amp;bbcode=$bbcode_id" : ''),

					'L_BBCODE_USAGE_EXPLAIN'=> sprintf($user->lang['BBCODE_USAGE_EXPLAIN'], '<a href="#down">', '</a>'),
					'BBCODE_MATCH'			=> $bbcode_match,
					'BBCODE_TPL'			=> $bbcode_tpl,
					'BBCODE_HELPLINE'		=> $bbcode_helpline,
					'DISPLAY_ON_POSTING'	=> $display_on_posting)
				);
				$L_token = array(
		'TEXT'			=> 'Any text, including foreign characters, numbers, etc… You should not use this token in HTML tags. Instead try to use IDENTIFIER or SIMPLETEXT.',
		'SIMPLETEXT'	=> 'Characters from the latin alphabet (A-Z), numbers, spaces, commas, dots, minus, plus, hyphen and underscore',
		'IDENTIFIER'	=> 'Characters from the latin alphabet (A-Z), numbers, hyphen and underscore',
		'NUMBER'		=> 'Any series of digits',
		'EMAIL'			=> 'A valid e-mail address',
		'URL'			=> 'A valid URL using any protocol (http, ftp, etc… cannot be used for javascript exploits). If none is given, &quot;http://&quot; is prefixed to the string.',
		'LOCAL_URL'		=> 'A local URL. The URL must be relative to the topic page and cannot contain a server name or protocol.',
		'COLOR'			=> 'A HTML colour, can be either in the numeric form <samp>#FF1234</samp> or a <a href="http://www.w3.org/TR/CSS21/syndata.html#value-def-color">CSS colour keyword</a> such as <samp>fuchsia</samp> or <samp>InactiveBorder</samp>'
	);

				foreach ($L_token as $token => $token_explain)
				{
					$template->assign_block_vars('token', array(
						'TOKEN'		=> '{' . $token . '}',
						'EXPLAIN'	=> $token_explain)
					);
				}

				return;

			break;

			case 'modify':
			case 'create':

				$data = $this->build_regexp($bbcode_match, $bbcode_tpl);

				// Make sure the user didn't pick a "bad" name for the BBCode tag.
				$hard_coded = array('code', 'quote', 'quote=', 'attachment', 'attachment=', 'b', 'i', 'url', 'url=', 'img', 'size', 'size=', 'color', 'color=', 'u', 'list', 'list=', 'email', 'email=', 'flash', 'flash=');

				if (($action == 'modify' && strtolower($data['bbcode_tag']) !== strtolower($row['bbcode_tag'])) || ($action == 'create'))
				{
					$sql = 'SELECT 1 as test
						FROM ' . BBCODES_TABLE . "
						WHERE LOWER(bbcode_tag) = '" . $db->sql_escape(strtolower($data['bbcode_tag'])) . "'";
					$result = $db->sql_query($sql);
					$info = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// Grab the end, interrogate the last closing tag
					if ($info['test'] === '1' || in_array(strtolower($data['bbcode_tag']), $hard_coded) || (preg_match('#\[/([^[]*)]$#', $bbcode_match, $regs) && in_array(strtolower($regs[1]), $hard_coded)))
					{
						trigger_error($user->lang['BBCODE_INVALID_TAG_NAME'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
				}

				if (substr($data['bbcode_tag'], -1) === '=')
				{
					$test = substr($data['bbcode_tag'], 0, -1);
				}
				else
				{
					$test = $data['bbcode_tag'];
				}

				if (!preg_match('%\\[' . $test . '[^]]*].*?\\[/' . $test . ']%s', $bbcode_match))
				{
					trigger_error($user->lang['BBCODE_OPEN_ENDED_TAG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (strlen($data['bbcode_tag']) > 16)
				{
					trigger_error($user->lang['BBCODE_TAG_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (strlen($bbcode_match) > 4000)
				{
					trigger_error($user->lang['BBCODE_TAG_DEF_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				
				
				if (strlen($bbcode_helpline) > 255)
				{
					trigger_error($user->lang['BBCODE_HELPLINE_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql_ary = array(
					'bbcode_tag'				=> $data['bbcode_tag'],
					'bbcode_match'				=> $bbcode_match,
					'bbcode_tpl'				=> $bbcode_tpl,
					'display_on_posting'		=> $display_on_posting,
					'bbcode_helpline'			=> $bbcode_helpline,
					'first_pass_match'			=> $data['first_pass_match'],
					'first_pass_replace'		=> $data['first_pass_replace'],
					'second_pass_match'			=> $data['second_pass_match'],
					'second_pass_replace'		=> $data['second_pass_replace']
				);

				if ($action == 'create')
				{
					$sql = 'SELECT MAX(bbcode_id) as max_bbcode_id
						FROM ' . BBCODES_TABLE;
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($row)
					{
						$bbcode_id = $row['max_bbcode_id'] + 1;

						// Make sure it is greater than the core bbcode ids...
						if ($bbcode_id <= NUM_CORE_BBCODES)
						{
							$bbcode_id = NUM_CORE_BBCODES + 1;
						}
					}
					else
					{
						$bbcode_id = NUM_CORE_BBCODES + 1;
					}

					if ($bbcode_id > 1511)
					{
						trigger_error($user->lang['TOO_MANY_BBCODES'] . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql_ary['bbcode_id'] = (int) $bbcode_id;
					$db->sql_query('INSERT INTO ' . BBCODES_TABLE . $db->sql_build_array('INSERT', $sql_ary));
					//$cache->destroy('sql', BBCODES_TABLE);

					$lang = 'BBCODE_ADDED';
					//$log_action = 'LOG_BBCODE_ADD';
				}
				else
				{
					$sql = 'UPDATE ' . BBCODES_TABLE . '
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE bbcode_id = ' . $bbcode_id;
					$db->sql_query($sql);
					$cache->destroy('sql', BBCODES_TABLE);

					$lang = 'BBCODE_EDITED';
					$log_action = 'LOG_BBCODE_EDIT';
				}

				//add_log('admin', $log_action, $data['bbcode_tag']);

				//trigger_error($user->lang[$lang] . adm_back_link($this->u_action));

			break;

			case 'delete':

				$sql = 'SELECT bbcode_tag
					FROM ' . BBCODES_TABLE . "
					WHERE bbcode_id = $bbcode_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row)
				{
					if (confirm_box(true))
					{
						$db->sql_query('DELETE FROM ' . BBCODES_TABLE . " WHERE bbcode_id = $bbcode_id");
						$cache->destroy('sql', BBCODES_TABLE);
						add_log('admin', 'LOG_BBCODE_DELETE', $row['bbcode_tag']);
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'bbcode'	=> $bbcode_id,
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action))
						);
					}
				}

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action . '&amp;action=add#bbcode')
		);

		$sql = 'SELECT *
			FROM ' . BBCODES_TABLE . '
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('bbcodes', array(
				'BBCODE_TAG'		=> $row['bbcode_tag'],
				'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;bbcode=' . $row['bbcode_id'] ."#bbcode",
				'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;bbcode=' . $row['bbcode_id'] ."#bbcode")
			);
		}
		$db->sql_freeresult($result);
	}

	/*
	* Build regular expression for custom bbcode
	*/
	function build_regexp(&$bbcode_match, &$bbcode_tpl)
	{
		$bbcode_match = trim($bbcode_match);
		$bbcode_tpl = trim($bbcode_tpl);

		$fp_match = preg_quote($bbcode_match, '!');
		$fp_replace = preg_replace('#^\[(.*?)\]#', '[$1]', $bbcode_match);
		$fp_replace = preg_replace('#\[/(.*?)\]$#', '[/$1]', $fp_replace);

		$sp_match = preg_quote($bbcode_match, '!');
		$sp_match = preg_replace('#^\\\\\[(.*?)\\\\\]#', '\[$1\]', $sp_match);
		$sp_match = preg_replace('#\\\\\[/(.*?)\\\\\]$#', '\[/$1\]', $sp_match);
		$sp_replace = $bbcode_tpl;

		// @todo Make sure to change this too if something changed in message parsing
		$tokens = array(
			'URL'	 => array(
				'!(?:(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('url')) . ')|(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('www_url')) . '))!ie'	=>	"\$this->bbcode_specialchars(('\$1') ? '\$1' : 'http://\$2')"
			),
			'LOCAL_URL'	 => array(
				'!(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('relative_url')) . ')!e'	=>	"\$this->bbcode_specialchars('$1')"
			),
			'EMAIL' => array(
				'!(' . get_preg_expression('email') . ')!ie'	=>	"\$this->bbcode_specialchars('$1')"
			),
			'TEXT' => array(
				'!(.*?)!es'	 =>	"str_replace(array(\"\\r\\n\", '\\\"', '\\'', '(', ')'), array(\"\\n\", '\"', '&#39;', '&#40;', '&#41;'), trim('\$1'))"
			),
			'SIMPLETEXT' => array(
				'!([a-zA-Z0-9-+.,_ ]+)!'	 =>	"$1"
			),
			'IDENTIFIER' => array(
				'!([a-zA-Z0-9-_]+)!'	 =>	"$1"
			),
			'COLOR' => array(
				'!([a-z]+|#[0-9abcdef]+)!i'	=>	'$1'
			),
			'NUMBER' => array(
				'!([0-9]+)!'	=>	'$1'
			)
		);

		$sp_tokens = array(
			'URL'	 => '(?i)((?:' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('url')) . ')|(?:' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('www_url')) . '))(?-i)',
			'LOCAL_URL'	 => '(?i)(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('relative_url')) . ')(?-i)',
			'EMAIL' => '(' . get_preg_expression('email') . ')',
			'TEXT' => '(.*?)',
			'SIMPLETEXT' => '([a-zA-Z0-9-+.,_ ]+)',
			'IDENTIFIER' => '([a-zA-Z0-9-_]+)',
			'COLOR' => '([a-zA-Z]+|#[0-9abcdefABCDEF]+)',
			'NUMBER' => '([0-9]+)',
		);

		$pad = 0;
		$modifiers = 'i';

		if (preg_match_all('/\{(' . implode('|', array_keys($tokens)) . ')[0-9]*\}/i', $bbcode_match, $m))
		{
			foreach ($m[0] as $n => $token)
			{
				$token_type = $m[1][$n];

				reset($tokens[strtoupper($token_type)]);
				list($match, $replace) = each($tokens[strtoupper($token_type)]);

				// Pad backreference numbers from tokens
				if (preg_match_all('/(?<!\\\\)\$([0-9]+)/', $replace, $repad))
				{
					$repad = $pad + sizeof(array_unique($repad[0]));
					$replace = preg_replace('/(?<!\\\\)\$([0-9]+)/e', "'\$' . (\$1 + \$pad) . ''", $replace);
					$pad = $repad;
				}

				// Obtain pattern modifiers to use and alter the regex accordingly
				$regex = preg_replace('/!(.*)!([a-z]*)/', '$1', $match);
				$regex_modifiers = preg_replace('/!(.*)!([a-z]*)/', '$2', $match);

				for ($i = 0, $size = strlen($regex_modifiers); $i < $size; ++$i)
				{
					if (strpos($modifiers, $regex_modifiers[$i]) === false)
					{
						$modifiers .= $regex_modifiers[$i];

						if ($regex_modifiers[$i] == 'e')
						{
							$fp_replace = "'" . str_replace("'", "\\'", $fp_replace) . "'";
						}
					}

					if ($regex_modifiers[$i] == 'e')
					{
						$replace = "'.$replace.'";
					}
				}

				$fp_match = str_replace(preg_quote($token, '!'), $regex, $fp_match);
				$fp_replace = str_replace($token, $replace, $fp_replace);

				$sp_match = str_replace(preg_quote($token, '!'), $sp_tokens[$token_type], $sp_match);
				$sp_replace = str_replace($token, '$' . ($n + 1) . '', $sp_replace);
			}

			$fp_match = '!' . $fp_match . '!' . $modifiers;
			$sp_match = '!' . $sp_match . '!s';

			if (strpos($fp_match, 'e') !== false)
			{
				$fp_replace = str_replace("'.'", '', $fp_replace);
				$fp_replace = str_replace(".''.", '.', $fp_replace);
			}
		}
		else
		{
			// No replacement is present, no need for a second-pass pattern replacement
			// A simple str_replace will suffice
			$fp_match = '!' . $fp_match . '!' . $modifiers;
			$sp_match = $fp_replace;
			$sp_replace = '';
		}

		// Lowercase tags
		$bbcode_tag = preg_replace('/.*?\[([a-z0-9_-]+=?).*/i', '$1', $bbcode_match);
		$bbcode_search = preg_replace('/.*?\[([a-z0-9_-]+)=?.*/i', '$1', $bbcode_match);

		if (!preg_match('/^[a-zA-Z0-9_-]+=?$/', $bbcode_tag))
		{
			global $user;
			trigger_error($user->lang['BBCODE_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		$fp_match = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $fp_match);
		$fp_replace = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $fp_replace);
		$sp_match = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $sp_match);
		$sp_replace = preg_replace('#\[/?' . $bbcode_search . '#ie', "strtolower('\$0')", $sp_replace);

		return array(
			'bbcode_tag'				=> $bbcode_tag,
			'first_pass_match'			=> $fp_match,
			'first_pass_replace'		=> $fp_replace,
			'second_pass_match'			=> $sp_match,
			'second_pass_replace'		=> $sp_replace
		);
	}
}
?>