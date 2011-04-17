<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

// This file contains Bit Torrent main functions. MUST be included before every
// other file at the beginning of any script
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (!function_exists("sha1")) require_once("include/sha1lib.php");

define('STRIP', (get_magic_quotes_gpc()) ? true : false);
function set_var(&$result, $var, $type, $multibyte = false)
{
	settype($var, $type);
	$result = $var;

	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $result), ENT_COMPAT, 'UTF-8'));

		if (!empty($result))
		{
			// Make sure multibyte characters are wellformed
			if ($multibyte)
			{
				if (!preg_match('/^./u', $result))
				{
					$result = '';
				}
			}
			else
			{
				// no multibyte, allow only ASCII (0-127)
				$result = preg_replace('/[\x80-\xFF]/', '?', $result);
			}
		}

		$result = (STRIP) ? stripslashes($result) : $result;
	}
}
function request_var($var_name, $default, $multibyte = false, $cookie = false)
{
	if (!$cookie && isset($_COOKIE[$var_name]))
	{
		if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
		{
			return (is_array($default)) ? array() : $default;
		}
		$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
	}

	if (!isset($_REQUEST[$var_name]) || (is_array($_REQUEST[$var_name]) && !is_array($default)) || (is_array($default) && !is_array($_REQUEST[$var_name])))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $_REQUEST[$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
		if ($type == 'array')
		{
			reset($default);
			$default = current($default);
			list($sub_key_type, $sub_type) = each($default);
			$sub_type = gettype($sub_type);
			$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
			$sub_key_type = gettype($sub_key_type);
		}
	}

	if (is_array($var))
	{
		$_var = $var;
		$var = array();

		foreach ($_var as $k => $v)
		{
			set_var($k, $k, $key_type);
			if ($type == 'array' && is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					if (is_array($_v))
					{
						$_v = null;
					}
					set_var($_k, $_k, $sub_key_type);
					set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
				}
			}
			else
			{
				if ($type == 'array' || is_array($v))
				{
					$v = null;
				}
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}

	return $var;
}
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = false, $tpl_prefix = '')
{
	global $template, $user;

	// Make sure $per_page is a valid value
	$per_page = ($per_page <= 0) ? 1 : $per_page;

	$seperator = '<span class="page-sep">, </span>';
	$total_pages = ceil($num_items / $per_page);

	if ($total_pages == 1 || !$num_items)
	{
		return false;
	}

	$on_page = floor($start_item / $per_page) + 1;
	$url_delim = (strpos($base_url, '?') === false) ? '?' : '&amp;';

	$page_string = ($on_page == 1) ? '<strong>1</strong>' : '<a href="' . $base_url . '">1</a>';

	if ($total_pages > 5)
	{
		$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
		$end_cnt = max(min($total_pages, $on_page + 4), 6);

		$page_string .= ($start_cnt > 1) ? ' ... ' : $seperator;

		for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}page=" . $i . '">' . $i . '</a>';
			if ($i < $end_cnt - 1)
			{
				$page_string .= $seperator;
			}
		}

		$page_string .= ($end_cnt < $total_pages) ? ' ... ' : $seperator;
	}
	else
	{
		$page_string .= $seperator;

		for ($i = 2; $i < $total_pages; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}page=" . $i . '">' . $i . '</a>';
			if ($i < $total_pages)
			{
				$page_string .= $seperator;
			}
		}
	}

	$page_string .= ($on_page == $total_pages) ? '<strong>' . $total_pages . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . $total_pages . '">' . $total_pages . '</a>';

	if ($add_prevnext_text)
	{
		if ($on_page != 1)
		{
			$page_string = '<a href="' . $base_url . "{$url_delim}page=" . (($on_page - 2) * $per_page) . '">'._btsnatch_prev.'</a>&nbsp;&nbsp;' . $page_string;
		}

		if ($on_page != $total_pages)
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . $base_url . "{$url_delim}page=" . ($on_page * $per_page) . '">'._btsnatch_next.'</a>';
		}
	}

	$template->assign_vars(array(
		$tpl_prefix . 'BASE_URL'		=> $base_url,
		'A_' . $tpl_prefix . 'BASE_URL'	=> addslashes($base_url),
		$tpl_prefix . 'PER_PAGE'		=> $per_page,

		$tpl_prefix . 'PREVIOUS_PAGE'	=> ($on_page == 1) ? '' : $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page),
		$tpl_prefix . 'NEXT_PAGE'		=> ($on_page == $total_pages) ? '' : $base_url . "{$url_delim}start=" . ($on_page * $per_page),
		$tpl_prefix . 'TOTAL_PAGES'		=> $total_pages,
	));

	return $page_string;
}
function on_page($num_items, $per_page, $start)
{
	global $template;

	// Make sure $per_page is a valid value
	$per_page = ($per_page <= 0) ? 1 : $per_page;

	$on_page = floor($start / $per_page) + 1;

	$template->assign_vars(array(
		'ON_PAGE'		=> $on_page)
	);

	return sprintf(PAGE_OF, $on_page, max(ceil($num_items / $per_page), 1));
}
function format_date2($gmepoch, $format = false, $forcedate = false)
	{
		global $midnight,$u_datetime;

		$lang_dates = $u_datetime;
		$format = (!$format) ? 'D M d, Y g:i a' : $format;

		// Short representation of month in format
		if ((strpos($format, '\M') === false && strpos($format, 'M') !== false) || (strpos($format, '\r') === false && strpos($format, 'r') !== false))
		{
			$lang_dates['May'] = $lang_dates['May_short'];
		}

		unset($lang_dates['May_short']);

		if (!$midnight)
		{
			list($d, $m, $y) = explode(' ', gmdate('j n Y', time() + 0 + 3600));
			$midnight = gmmktime(0, 0, 0, $m, $d, $y) - 7200;
		}

		if (strpos($format, '|') === false || ($gmepoch < $midnight - 86400 && !$forcedate) || ($gmepoch > $midnight + 172800 && !$forcedate))
		{
			return strtr(@gmdate(str_replace('|', '', $format), $gmepoch +7200), $lang_dates);
		}

		if ($gmepoch > $midnight + 86400 && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['TOMORROW'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}
		else if ($gmepoch > $midnight && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['TODAY'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}
		else if ($gmepoch > $midnight - 86400 && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['YESTERDAY'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}

		return strtr(@gmdate(str_replace('|', '', $format), $gmepoch +7200), $lang_dates);
	}
function confirm_box($check, $title = '', $hidden = '', $html_body = 'confirm_body.html', $u_action = '')
{
	global $user, $template, $db;

	if (isset($_POST['cancel']))
	{
		return false;
	}

	$confirm = false;
	if (isset($_POST['confirm']))
	{
		// language frontier
		if ($_POST['confirm'] === 'YES')
		{
			$confirm = true;
		}
	}

	if ($check && $confirm)
	{
		$user_id = request_var('user_id', 0);
		$session_id = request_var('sess', '');
		$confirm_key = request_var('confirm_key', '');

		if ($user_id != $user->id ||  !$confirm_key )
		{
			return false;
		}

		return true;
	}
	else if ($check)
	{
		return false;
	}

	$s_hidden_fields = build_hidden_fields(array(
		'user_id'	=> $user->id,
		'sess'		=> $user->session_id,
		'sid'		=> $user->session_id)
	);

	// generate activation key
	$confirm_key = RandomAlpha(10);


	// If activation key already exist, we better do not re-use the key (something very strange is going on...)
	if (request_var('confirm_key', ''))
	{
		// This should not occur, therefore we cancel the operation to safe the user
		return false;
	}

	$u_action .= ((strpos($u_action, '?') === false) ? '?' : '&amp;') . 'confirm_key=' . $confirm_key;
	$template->assign_vars(array(
		'MESSAGE_TITLE'		=> (defined('_'.$title)) ? constant('_'.$title) : 'CONFIRM',
		'MESSAGE_TEXT'		=> (defined('_'.$title.'_CONFIRM')) ? constant('_'.$title.'_CONFIRM') : '_CONFIRM',

		'YES_VALUE'			=> 'YES',
		'S_CONFIRM_ACTION'	=> $u_action,
		'S_HIDDEN_FIELDS'	=> $hidden . $s_hidden_fields)
	);
			  echo $template->fetch('confirm_body.html');
			  die;
}
function build_hidden_fields($field_ary, $specialchar = false, $stripslashes = false)
{
	$s_hidden_fields = '';

	foreach ($field_ary as $name => $vars)
	{
		$name = ($stripslashes) ? stripslashes($name) : $name;
		$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

		$s_hidden_fields .= _build_hidden_fields($name, $vars, $specialchar, $stripslashes);
	}

	return $s_hidden_fields;
}
function _build_hidden_fields($key, $value, $specialchar, $stripslashes)
{
	$hidden_fields = '';

	if (!is_array($value))
	{
		$value = ($stripslashes) ? stripslashes($value) : $value;
		$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;

		$hidden_fields .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
	}
	else
	{
		foreach ($value as $_key => $_value)
		{
			$_key = ($stripslashes) ? stripslashes($_key) : $_key;
			$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

			$hidden_fields .= _build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
		}
	}

	return $hidden_fields;
}
function get_u_ratio($upload, $download)
{
        if ($upload == 0 AND $download == 0) return "---";
        elseif ($download == 0) return "&infin;";
        else {
                $ratio = $upload/$download;

                if ($ratio < 0.1) $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.2) $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.3) $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.4) $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.5) $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.6) $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.7) $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.8) $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.9) $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 1)   $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
                else $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
        }
		return $ratio;
}
function bt_pm_out($sender, $recipient, $subject, $text){
        global $db, $db_prefix;
		$subject = $db->sql_escape((STRIP) ? stripslashes($subject) : $subject);
		$text = $db->sql_escape((STRIP) ? stripslashes($text) : $text);
                $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$sender."','".$recipient."','".$subject."', '".$text."', NOW());");
}
function bt_shout($user, $text, $id_to = 0){
        global $db, $db_prefix;
		if(!isset($user, $text)){
		}
                $db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted, id_to) VALUES ('".$user."', '".$text."', NOW(), '".$id_to."');");
}
/*---------------------------------
ERROR HANDLING FUNCTIONS
----------------------------------*/
function logerror($message, $error = _btgenerror) {
        global $db, $db_prefix, $user;
                $ip = getip();
       $sql = "INSERT INTO ".$db_prefix."_log (action, results, ip, host, userid) VALUES ('".addslashes($error)."', '".addslashes($message)."', '".sprintf("%u",ip2long($ip))."',  '".gethostbyaddr($ip)."', '".$user->id."');";
        $db->sql_query($sql);
        return;
}
function getlevel_name($userid){
        global $db, $db_prefix;
			$sql = "SELECT `can_do` FROM ".$db_prefix."_users WHERE `id` = '".$userid."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "guest";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['can_do'];
			}
}
function getlevel($can_do){
        global $db, $db_prefix;
			$sql = "SELECT name FROM ".$db_prefix."_levels WHERE `level` = '".$can_do."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "guest";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['name'];
			}
}
function getMetaTitle($content){
	if($user->id == 1)echo "||".$content."||";

if(!@file ("$content"))return $content;
$fcontents = implode ('', file ("$content"));
$fcontents = stristr($fcontents, '<title>');
$rest = substr($fcontents, 7);
$extra = stristr($fcontents, '</title>');
$titlelen = strlen($rest) - strlen($extra);
$gettitle = trim(substr($rest, 0, $titlelen));
if($gettitle == "")return $content;
return $gettitle;
}
function getusercolor($level){
        global $db, $db_prefix;
			$sql = "SELECT color FROM ".$db_prefix."_levels WHERE `level` = '".$level."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$con = $db->sql_numrows($res);
			if($con == 0)return $level;
			$row = $db->sql_fetchrow($res);
		return $row['color'];
}
function selectaccess($al= false){
        global $db, $db_prefix, $user;
			$sql = "SELECT level as level, name as name FROM ".$db_prefix."_levels;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$level = "<select name=\"group\">";
while ($tracker = $db->sql_fetchrow($res)) {
if($user->group =="owner" AND $tracker['level'] == "owner")continue;
$level .= "<option ";
if(isset($al) && $al == $tracker['level'])$level .= "selected=\"selected\"";
$level .= "value=\"".$tracker['level']."\">".$tracker['name']."</option>";
}
			$level .= "</select>";
        $db->sql_freeresult($res);
		return $level;
}
  function hitrun($hnrid = 0)
  {
        global $db, $db_prefix;
		if($hnrid == 0) return false;
			$sql = "SELECT `level`, dongift, can_do FROM ".$db_prefix."_users WHERE `id` = '".$hnrid."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			if($row['level']=='admin')return false;
			if($row['dongift']==2)return false;
			$sql2 = "SELECT `hit_run` FROM ".$db_prefix."_levels WHERE `level` = '".$row['can_do']."'";
			$res2 = $db->sql_query($sql2) or btsqlerror($sql2);
			$row2 = $db->sql_fetchrow($res2);
			if($row2['hit_run'] == 'true')return false;
			else return true;
  }
function checkaccess($access){
        global $db, $db_prefix, $user,$_COOKIE;
			$sql = "SELECT ".$access." FROM ".$db_prefix."_levels WHERE `level` = '".$user->group."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			if($user->level != "guest")
			{
        $userdata = cookie_decode($_COOKIE["btuser"]);
        if ($userdata[0] != $user->id) return false;
        if (addslashes($userdata[1]) != $user->name) return false;
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n) return false;
		}
		//echo $row[$access];
			if($row[$access] == "true")return true;
			else
			return false;
}
function sqlerr($sql = ''){
return  btsqlerror($sql);
}
function validip($ip)
{
	if (!empty($ip) && $ip == long2ip(ip2long($ip)))
	{
		// reserved IANA IPv4 addresses
		// http://www.iana.org/assignments/ipv4-address-space
		$reserved_ips = array (
				array('0.0.0.0','2.255.255.255'),
				array('10.0.0.0','10.255.255.255'),
				array('127.0.0.0','127.255.255.255'),
				array('169.254.0.0','169.254.255.255'),
				array('172.16.0.0','172.31.255.255'),
				array('192.0.2.0','192.0.2.255'),
				array('192.168.0.0','192.168.255.255'),
				array('255.255.255.0','255.255.255.255')
		);

		foreach ($reserved_ips as $r)
		{
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
		return true;
	}
	else return false;
}

// Patched function to detect REAL IP address if it's valid
function getip() {
   if (isset($_SERVER)) {
     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     } else {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   } else {
     if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
       $ip = getenv('HTTP_X_FORWARDED_FOR');
     } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
       $ip = getenv('HTTP_CLIENT_IP');
     } else {
       $ip = getenv('REMOTE_ADDR');
     }
   }

   return $ip;
 }

function get_user_timezone($id) {
        global $db, $db_prefix, $user;
  if ($user->user){
	   $sql = "SELECT * FROM ".$db_prefix."_users WHERE id=$id LIMIT 1";
       $query = mysql_query($sql);
       if (mysql_num_rows($query) != "0") {
			$kasutaja = mysql_fetch_array($query);
			$timezone = $kasutaja["tzoffset"]+60;
			return "$timezone";
		} else {
         return "377";
		} //Default timezone
	}
}
function datum($datum=true) {
$sign = "+"; // Whichever direction from GMT to your timezone. + or -
$h = "1"; // offset for time (hours)
$dst = true; // true - use dst ; false - don't

if ($dst==true) {
    $daylight_saving = date('I');
    if ($daylight_saving){
        if ($sign == "-"){ $h=$h-1;  }
        else { $h=$h+1; }
    }
}
$hm = $h * 60;
$ms = $hm * 60;
if ($sign == "-"){ $timestamp = time()-($ms); }
else { $timestamp = time()+($ms); }
$gmdate = gmdate("m.d.Y. g:i A", $timestamp);
if($datum==true) {
return $gmdate;
}
else {
return $timestamp;
}

}
function removedinactive($uid){
                        global $db, $db_prefix, $forumshare,$phpEx, $config, $forumbase,$phpbb_root_path,$forumpx;
						$username = username_is($uid);
                        if (empty($username)) return;
                        $sql = "SELECT avatar FROM ".$db_prefix."_users WHERE id = '".$uid."';";
                        $res = $db->sql_query($sql)or btsqlerror($sql);
                        list ($avatar) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($sql);
                        if (eregi("^user/",$avatar)) @unlink($avatar);
						if($forumshare AND get_user_forum_name($username)>=2)forum_delete($uid, $username);                        
                        $sql = Array();
                        $sql[] = "DELETE FROM ".$db_prefix."_tickets WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE userid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_shouts WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_online_users WHERE id = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_torrents SET owner = '0', ownertype = '2' WHERE owner = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_peers SET uid = '0' WHERE uid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages WHERE recipient = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_users WHERE id = '".$uid."';";

                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($sql);
                        }
						//return;
} 
function mkglobal($vars) {
    if (!is_array($vars))
        $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v]))
            $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v]))
            $GLOBALS[$v] = unesc($_POST[$v]);
        else
            return 0;
    }
    return 1;
}

function btsqlerror($sql) { //Returns SQL Error
        global $db, $db_prefix, $theme;
        $err = Array();
        $err = $db->sql_error();
		echo $theme;
        //OpenErrTable("SQL Error");
        $msg = "<p>\n";
        $msg .= _btsqlerror1.htmlspecialchars($sql) ;
        $msg .=("<br />");
        $msg .= _btsqlerror2.$err["code"];
        $msg .=("<br />");
        $msg .= _btsqlerror3.htmlspecialchars($err["message"]);
        $msg .= "</p>";
		echo $msg;
       // logerror($msg, "Data base sql error");
      //  CloseErrTable();
        CloseTable2();
        CloseTable();
        //logerror($err["message"],$sql);
        $db->sql_query("",END_TRANSACTION);
        @include("footer.php");
        die();
}

function get_elapsed_time($ts)
{
  $mins = floor((strtotime(gmdate("Y-m-d H:i:s", time())) - $ts) / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  $t = "";
  if ($weeks)
    return "$weeks week" . ($weeks > 1 ? "s" : "");
  if ($days)
    return "$days day" . ($days > 1 ? "s" : "");
  if ($hours)
    return "$hours hour" . ($hours > 1 ? "s" : "");
  if ($mins)
    return "$mins min" . ($mins > 1 ? "s" : "");
  return "< 1 min";
}
function bterror($error, $title = _btgenerror, $fatal = true) {
        global $db, $db_prefix;
        OpenErrTable($title);
        if (is_array($error)) {
                echo "<p>"._btalertmsg."</p>\n";
                echo "<ul>\n";
                foreach ($error as $msg) {
                        echo "<li><p>".$msg."</p></li>\n";
                }
                echo "</ul>\n";
        }else {
                 echo "<p class=\"errortext\">".$error."</p>";
        }
        CloseErrTable();
        if (is_array($error)) $error = implode("<br />",$error);
        //if (!eregi("admin.php",$_SERVER["PHP_SELF"])) logerror($error);
        if (!$fatal) return;
        CloseTable2();
        CloseTable();
        @include("footer.php");
        die();
}
function loginrequired($level, $guickclose = false) {
        global $user, $gfx_check, $autoscrape;
	    $returnto = $_SERVER["REQUEST_URI"];
		$returnto = str_replace('sid', 'oldsd', $returnto);
		$returnto = str_replace('&', '@', $returnto);
        $loginbox = "<br><br><form method=\"POST\" action=\"user.php?returnto=".$returnto."\"><input type=\"hidden\" name=\"op\" value=\"login\" />\n
        <p align=\"center\">"._btusername."<br><input type=\"text\" name=\"username\" size=\"20\" />\n<br>"._btpassword."<br><input type=\"password\" name=\"password\" size=\"20\" />\n<br>Remember Me<br><input type=\"checkbox\" name=\"remember\" value=\"yes\" /></p>\n";
        if ($gfx_check) {
                $rnd_code = strtoupper(RandomAlpha(5));
                $loginbox .= "<p align=\"center\">"._btsecuritycode."<br><img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                $loginbox .= "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\">\n\n";
        }
        $loginbox .= "<p><input type=\"submit\" value=\""._btlogin."\" /></p></form>";
        $loginbox .= "<a href=\"user.php?op=lostpassword\">"._btlostpassword."</a></p>\n\n";
		OpenTable(_btlogin);
        OpenErrTable('login');
        switch ($level) {
                case "user": {
                        echo "<p>"._btdenuser."</p>";
                        echo $loginbox;
                        break;
                }
                case "premium": {
                        echo "<p>"._btdenpremium."</p>";
                        if (!$user->user){
				echo "<p>"._btdenpremium."</p>";
				echo $loginbox;
                        }else echo "<p>"._btdenpremium2."</p>";
                        break;
                }
                case "admin": {
                        echo _btdenadmin;
                        if (!$user->user){ 
				echo "<p>"._btdenadmin."</p>";
				echo $loginbox;
                        }else echo _btdenadmin2;
                        break;
                }
                default: {
                        echo("Fatal Error!");
                        break;
                }
        }
        CloseErrTable();
        CloseTable();
		if (defined('BT_SHARE')){
		echo "</div></td></tr></table>";
        }
        CloseTable();
		if ($guickclose)die();
		include("footer.php");
}
function autoclean() {
    global $db, $db_prefix, $autoclean_interval, $announce_interval;
    $now = time();
    $docleanup = 0;

    $cln = "SELECT value_u FROM ".$db_prefix."_avps WHERE arg = 'lastcleantime'";
	$res = $db->sql_query($cln);
    $row = $db->sql_fetchrow($res);
    if (!$row) {
        $db->sql_query("INSERT INTO ".$db_prefix."_avps (arg, value_u) VALUES ('lastcleantime',$now)");
        return;
    }
    $ts = $row['value_u'];
    if ($ts + $autoclean_interval > $now) return;
    $db->sql_query("UPDATE ".$db_prefix."_avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");

    bonouse();
}

function bonouse(){
    global $db, $db_prefix, $announce_interval;
                       $bon = "SELECT active, seeding, by_torrent FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon)or btsqlerror($bon);
                        $bon_config = $db->sql_fetchrow($bonset);
						$active = $bon_config['active'];
						$seeding_point = $bon_config['seeding'];
						$by_torrent = $bon_config['by_torrent'];
					if($by_torrent == '1')$point_per = true;
						else
						$point_per = false;
						//echo $active;
if($active=='true')
{
if($point_per)
{
   $res = $db->sql_query("SELECT DISTINCT uid FROM ".$db_prefix."_peers WHERE seeder = 'yes'");
   $res2 = $db->sql_query("SELECT COUNT(uid) FROM ".$db_prefix."_peers WHERE seeder = 'yes' GROUP BY id");
   list ($count) = $db->sql_fetchrow($res2);
        $db->sql_freeresult($res2);
   if ($count > 0)
   {
       while ($arr = $db->sql_fetchrow($res))
       {
       $work = $db->sql_query("select count(uid) as count from ".$db_prefix."_peers WHERE seeder ='yes' AND uid = ".$arr['uid']." GROUP BY id");
       $row_count = $db->sql_fetchrow($work);
	   $seedbonus = $seeding_point*$row_count['count'];
       $db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$seedbonus."' WHERE id = ".$arr['uid']." AND active = '1' AND warned = '0'") or sqlerr(__FILE__, __LINE__);
       }
   }
}else{
   $res = $db->sql_query("SELECT DISTINCT uid FROM ".$db_prefix."_peers WHERE seeder = 'yes'");
   $res2 = $db->sql_query("SELECT COUNT(uid) FROM ".$db_prefix."_peers WHERE seeder = 'yes' GROUP BY id ");
   list ($count) = (int) $db->sql_fetchrow($res2);
        $db->sql_freeresult($res2);
   if ($count > 0)
   {
       while ($arr = $db->sql_fetchrow($res))
       {

       $db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$seeding_point."' WHERE id = ".$arr['uid']." AND active = '1' AND warned = '0'");
       }
   }
   }
}
                        $db->sql_freeresult($bonset);
}
/*---------------------------------
SECURITY FUNCTIONS
---------------------------------*/
function cookie_decode($cookie) {
        global $use_rsa, $rsa;
        if ($use_rsa) $cookie = $rsa->decrypt($cookie);
        else $cookie = base64_decode($cookie);
        $cookie = stripslashes($cookie);
        $cookie = addslashes($cookie);
        $cookie = explode("::", $cookie);
        if (count($cookie) != 4) return Array("","","","");
        return $cookie;
}

function cookie_encode(&$cookie) {
        global $use_rsa, $rsa;
        $cookie = implode("::",$cookie);
        if ($use_rsa) $cookie = $rsa->encrypt($cookie);
        else $cookie = base64_encode($cookie);
        return $cookie;
}

function is_banned($user, &$reason) {
        //Both checking against username and IP
        global $db, $db_prefix, $_SERVER;
        $ip = sprintf("%u",ip2long(getip()));

        $sqlip = "SELECT reason as reason FROM ".$db_prefix."_bans WHERE  ipstart <= '".$ip."' AND ipend >= '".$ip."'  LIMIT 1;";
        $resip = $db->sql_query($sqlip) or btsqlerror($sqlip);
        $sql = "SELECT banreason as reason FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND ban = 1 UNION SELECT reason FROM ".$db_prefix."_bans WHERE ipstart <= '".$ip."' AND ipend >= '".$ip."'  LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($resip) >= 1) {
                list ($reason) = $db->sql_fetchrow($resip);
                return true;
		}
        if ($db->sql_numrows($res) < 1) {
                $reason = "";
                return false;
        } else {
                list ($reason) = $db->sql_fetchrow($res);
                return true;
        }
}

function is_user($user) {//Deprecated
        //trigger_error("Function is_user() is deprecated",E_USER_WARNING);
        global $user;
        return $user->user;
}

function is_btadmin($user) {//Deprecated
        //trigger_error("Function is_btadmin() is deprecated",E_USER_WARNING);
        global $user;
        return $user->admin;
}

function is_premium($user) {//Deprecated
        //trigger_error("Function is_premium() is deprecated",E_USER_WARNING);
        global $user;
        return $user->premium;
}

function is_moderator($user) {//Deprecated
        //trigger_error("Function is_moderator() is deprecated",E_USER_WARNING);
        global $user;
        return $user->moderator;
}

function can_download($user, &$torrent) {
        if ($user->premium) return true;
        global $db, $db_prefix, $download_level, $torrent_global_privacy;
        if ($download_level == "all" OR $torrent["tracker"] != "") return true;
        if ($download_level == "premium" AND !$user->premium) return false;
        if ($download_level == "user" AND !$user->user) return false;
        if ($download_level == "user" AND !$torrent_global_privacy) return true;
        if ($download_level == "user" AND $torrent_global_privacy) {
                if ($torrent["ownertype"] == 2 OR $torrent["private"] != "true") return true;
                $ratioqry = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
                $ratiores = $db->sql_query($ratioqry);
                list ($uploaded, $downloaded) = $db->sql_fetchrow($ratiores);
                $db->sql_freeresult($ratiores);
                //if ($downloaded == 0) return true;
                if ($torrent["min_ratio"] > "0.00" AND ($downloaded > 0) AND $uploaded/$downloaded >= $torrent["min_ratio"]) return true;

                $sql = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."';";
                $privacylist = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($privacylist) == 1) {
                        $privacy = $db->sql_fetchrow($privacylist);
                        if ($privacy["status"] == "whitelist") return true;
                        else return false;
                }
                $sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE slave = '".$user->id."' AND torrent = '".$torrent["id"]."';";
                $authqry = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($authqry) == 0) return false;
                $authrow = $db->sql_fetchrow($authqry);
                if ($authrow["status"] == "granted") return true;
                else return false;
        }
        return false;
}
function userlogin($username, &$cookiedata) {
//include_once('include/forum_settings.php');
global $db, $db_prefix, $cookiedomain, $cookiepath, $logintime;
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE clean_username ='".escape(strtolower($username))."';");
if (!$res) return;
$row = $db->sql_fetchrow($res);
if (!$row) return;
$remember = 'yes';
$session_time = time() + (($logintime) ? 3200 * (int) $logintime : 31536000);
$cookiedata = Array($row["id"],addslashes($row["username"]),$row["password"],$row["act_key"]);
cookie_encode($cookiedata);
if ($remember=="no"){
setcookie("btuser",$cookiedata,$session_time,$cookiepath,$cookiedomain,0);
if ($row["theme"] != "" AND is_dir("themes/".$row["theme"]) AND $row["theme"] != "CVS") setcookie("bttheme",$row["theme"],$session_time,$cookiepath,$cookiedomain,0);
else setcookie("bttheme","",$session_time,$cookiepath,$cookiedomain,0);
if ($row["language"] != "" AND is_readable("language/".$row["language"].".php")) setcookie("btlanguage",$row["language"],$session_time,$cookiepath,$cookiedomain,0);
else setcookie("btlanguage","",$session_time,$cookiepath,$cookiedomain,0);
return;
}else{
        setcookie("btuser",$cookiedata,time()+8640000,$cookiepath,$cookiedomain,0);
        if ($row["theme"] != "" AND is_dir("themes/".$row["theme"]) AND $row["theme"] != "CVS") setcookie("bttheme",$row["theme"],time()+8640000,$cookiepath,$cookiedomain,0);
        else setcookie("bttheme","",time()+8640000,$cookiepath,$cookiedomain,0);
        if ($row["language"] != "" AND is_readable("language/".$row["language"].".php")) setcookie("btlanguage",$row["language"],time()+8640000,$cookiepath,$cookiedomain,0);
        else setcookie("btlanguage","",time()+8640000,$cookiepath,$cookiedomain,0);
        return;
}
} 
function getuserid($user) { //Deprecated
        //trigger_error("Function getuserid() is deprecated",E_USER_WARNING);
        global $user;
        return $user->id;
}

function getusername($user) { //Gets the user name from cookie
        //trigger_error("Function getusername() is deprecated",E_USER_WARNING);
        global $user;
        return $user->name;
}
function is_url($url) {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9_]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}
function is_filename($name) { //Is the file name valid?
        return preg_match('/^[^\\\\:\/<>|*"?]*$/si', $name);
}
function escape($x) { //Like mysql_escape_string()
        return addslashes($x);
}
function unescape($x) {
        return stripslashes($x);
}
function sqlwildcardesc($x) { //Replaces wildcards
        return str_replace(array("%","_"), array("\\%","\\_"), str_replace("'", "\'", $x));
}

function RandomNum($num) {
        $set = "0123456789";
        $resp = "";
        for ($i=1; $i<=$num; $i++) {
                $char = rand(0,strlen($set));
                $resp.=$set[$char];
        }
        return $resp;
}
function RandomAlpha($num) {
        $set = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvxyz0123456789";
        $resp = "";
        for ($i=1; $i<=$num; $i++) {
                $char = rand(0,strlen($set)-1);
                $resp.=$set[$char];
        }
        return $resp;
}
function spellmail($email) {
        $search = Array("@",".");
        $replace = Array(_at,_dot);
        return "<i>".str_replace($search,$replace,$email)."</i>";
}

function sql_timestamp_to_unix_timestamp($s)
{
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}
define('INT_SECOND', 1);
define('INT_MINUTE', 60);
define('INT_HOUR', 3600);
define('INT_DAY', 86400);
define('INT_WEEK', 604800);

function get_formatted_timediff($then, $now = false)
{
    $now      = (!$now) ? time() : $now;
    $timediff = ($now - $then);
    $weeks    = (int) intval($timediff / INT_WEEK);
    $timediff = (int) intval($timediff - (INT_WEEK * $weeks));
    $days     = (int) intval($timediff / INT_DAY);
    $timediff = (int) intval($timediff - (INT_DAY * $days));
    $hours    = (int) intval($timediff / INT_HOUR);
    $timediff = (int) intval($timediff - (INT_HOUR * $hours));
    $mins     = (int) intval($timediff / INT_MINUTE);
    $timediff = (int) intval($timediff - (INT_MINUTE * $mins));
    $sec      = (int) intval($timediff / INT_SECOND);
    $timediff = (int) intval($timediff - ($sec * INT_SECOND));

    $str = '';
    if ( $weeks )
    {
        $str .= intval($weeks);
        $str .= ($weeks > 1) ? 'w\'s' : 'w';
    }

    if ( $days )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($days);
        $str .= ($days > 1) ? 'd\'s' : 'd';
    }

    if ( $hours )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($hours);
        $str .= ($hours > 1) ? 'h\'s' : 'h';
    }

    if ( $mins )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($mins);
        $str .= ($mins > 1) ? 'm\'s' : 'm';
    }

    if ( $sec )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($sec);
        $str .= ($sec > 1) ? 's\'s' : 's';
    }
   
    if ( !$weeks && !$days && !$hours && !$mins && !$sec )
    {
        $str .= '0seconds ';
    }
    else
    {
        $str .= '';
    }
   
    return $str;
}

/*---------------------------------
TEXT & GRAPHICS FUNCTIONS
----------------------------------*/

/*
GETURL FUNCTION
RETURNS URL IN NORMAL STYLE

PARAMETERS:
 FILE = THE FILE TO LOAD IN MAIN DIRECTORY
 ARGS = [KEY]=>[VAL] ARRAY OF ADDITIONAL GET PARAMETERS

EXAMPLE:
GETURL("INDEX",ARRAY("OP"=>"LOAD","ACTION"=>"DOIT"));

RETURNS
INDEX.PHP?OP=LOAD&ACTION=DOIT
*/
function geturl($file, $args = Array()) {
        $s = $file.".php";
        if (count($args) > 0) $s .="?";
        $i = 0;
        foreach ($args as $key=>$val) {
                if ($i != 0) $s .= "&";
                $s .= $key."=".$val;
                $i++;
        }
        return htmlspecialchars($s); //Required by W3C specifications
}
function unesc($x) { //Useful for escaping strings
        if (get_magic_quotes_gpc())
                return stripslashes($x);
        return $x;
}
function mksize($s) { //Byte, Kilobyte, Megabyte, Gigabyte size
        $x = 4;
        $a = array("","K","M","G","T");
        for (;;) {
                $v = pow(1024, $x);
                if (!$x OR $s >= $v) {
                        $ss = sprintf("%.2f", ($s / $v));
                        $xx = $ss . " " . $a[$x] . "B";
                        break;
                }
                $x--;
        }
        return $xx;
}
function formatTimestamp($time) {//Formats date & time
    setlocale(LC_TIME, _LOCALE);
    ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
    $datetime = strftime(_DATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
    $datetime = ucfirst($datetime);
    return($datetime);
}
function mkprettytime($s) {//Formats date&time?
        if ($s < 0)
                $s = 0;
        $t = array();
        foreach (array("60:sec","60:min","24:hour","0:day") as $x) {
                $y = explode(":", $x);
                if ($y[0] > 1) {
                        $v = $s % $y[0];
                        $s = floor($s / $y[0]);
                }
                else
                        $v = $s;
                $t[$y[1]] = $v;
        }

        if ($t["day"])
                return $t["day"]._btdays.", ".$t["hour"]._bthours. $t["min"]._btmins.$t["sec"]._btsecs;
        if ($t["hour"])
                return $t["hour"]._bthours. $t["min"]._btmins. $t["sec"]._btsecs;
        if ($t["min"])
                return $t["min"]._btmins. $t["sec"]._btsecs;
        return $t["sec"]. _btsecs;
}

function urlparse($m) { //Makes URLs clickable
        $t = $m[0];
        if (preg_match(',^\w+://,', $t))
                return "<a href=\"".$t."\">".$t."</a>";
        return "<a href=\"http://".$t."\">".$t."</a>";
}
function parsedescr($d) { //Parses Torrent description
        $pd = str_replace(array("\n", "\r"), array("<br />\n", ""), htmlspecialchars($d));
       $pd = preg_replace_callback("`(http|ftp)+(s)?:(//)((\w|\.|\-|_)+)(/)?(\S+)?`i", "urlparse", $pd);
        return $pd;
}
function searchfield($s) {
        $s= preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
		return str_replace(" ", " +", $s);
}
function parse_html(&$text) {
        $allowed_tags = Array(
		"<br />",
        "<p>",
        "<i>",
        "<u>",
        "<br>",
        "<img>",
        "<a>",
        "<ul>",
        "<ol>",
        "<tr>",
        "<td>",
        "<thead>",
        "<tbody>",
        "<hr>",
        "<div>",
        "<span>",
        "<strong>",
        "<strike>",
        "<pre>",
        "<address>",
        "<font>",
        "<h1>",
        "<h2>",
        "<h3>",
        "<h4>",
        "<h5>",
        "<h6>",
        "<h7>"
        );
       // $text = strip_tags($text,implode(",",$allowed_tags));
}
function parse_smiles(&$text) { //Parses text against smiles
        global $db, $db_prefix;
        $sql = "SELECT * FROM ".$db_prefix."_smiles;";
        $smile_res = $db->sql_query($sql);
        $search = Array();
        $replace = Array();
        while ($smile = $db->sql_fetchrow($smile_res)) {
                $search[] = $smile["code"];
                $replace[] = "<img src=\"smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\">";
        }
        $text = str_replace($search,$replace,$text);
        $db->sql_freeresult($smile_res);
}
function hex_esc($matches) {
        return sprintf("%02x", ord($matches[0]));
}
function catlist() { //Category List
        global $db, $db_prefix;
        $ret = array();
        if(! $res = $db->sql_query("SELECT id, name, image FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC") )
                bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");
        while ($row = $db->sql_fetchrow($res))
                $ret[] = $row;
        return $ret;
}
function pic($name, $url = "", $alt = "", $h = false, $w = false) {//Gets a picture from theme directory
        global $theme;
		$hi ="";
		$wi ="";
		if($h)$hi ="hidth=\"".$h."\"";
		if($w)$wi ="width=\"".$w."\"";
        if ($alt == "" AND $alt != null AND defined("_btalt_".$name)) $alt = constant("_btalt_".$name);

        $ret = "<img src=\"themes/".$theme."/pics/".$name."\" border=\"0\" alt=\"".$alt."\" title=\"".$alt."\" ".$hi." ".$wi." />";
        if ($url != "") {
                return "<a href=\"".$url."\">".$ret."</a>";
        }
        return $ret;
}
function ratingpic($num) {//Gets the correct star rating picture
        $r = round($num * 2) / 2;
        if ($r < 1 OR $r > 5) return;
        return pic($r."-rating.png");
}
function no_parse_message($text_noparse) {
	$text_noparse = str_replace('[', '**-NoParseTagBegin-**', $text_noparse);
	$text_noparse = str_replace(']', '**-NoParseTagEnd-**', $text_noparse);
	$text_noparse = str_replace(':', '**-NoParseTagsmileis-**', $text_noparse);
	$text_noparse = str_replace('http', '**-NoParseurls-**', $text_noparse);
	$text_noparse = str_replace('HTTP', '**-NoParseurls-**', $text_noparse);
	return $text_noparse;
}
function format_comment($text, $strip_html = false, $strip_slash = false)
{
	global $smilies, $privatesmilies, $user, $db, $db_prefix;

	$s = $text;

	if ($strip_html)
		$s = htmlspecialchars($s);

	if ($strip_slash)
		$s = stripslashes($s);
	$s = preg_replace('#\[noparse\](.*)\[/noparse\]#sUe', 'no_parse_message(\'$1\')', $s);
	$s = preg_replace('#\[np\](.*)\[/np\]#sUe', 'no_parse_message(\'$1\')', $s);

$s = str_replace("]\n", "]", $s);
$match = array(
"/\[list\]\s*((\s|.)+?)\s*\[\/list\]/i",
"/\[list=(.*?)\]\s*((\s|.)+?)\s*\[\/list=(.*?)\]/i",
"/\[\*\]/i",
"/\[br\]/",
"/\[hr\]/",
"/\[b\]((\s|.)+?)\[\/b\]/",
"/\[i\]((\s|.)+?)\[\/i\]/",
"/\[u\]((\s|.)+?)\[\/u\]/",
"/\[img\](.*?)\[\/img\]/is",
"/\[img=((http|https):\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\]/i",
"/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
"/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
"/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
"/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
"/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
"/\[center\]((\s|.)+?)\[\/center\]/i",
"/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
"/\[video=[^\s'\"<>]*video.google.com.*docid=(-?[0-9]+).*\]/ims",
'#\[code\](.*?)\[\/code\]#se',
'#\[code=php\](.*?)\[\/code\]#se',
'#\[php\](.*?)\[\/php\]#se',
"/\[skype\]((\s|.)+?)\[\/skype\]\s*/i",
"/\[website\](.*?)\[\/website\]\s*/i",
"/\[spoiler\]\s*((\s|.)+?)\s*\[\/spoiler\]\s*/i",
"/\[aim=(.*?)\](.*?)\[\/aim\]\s*/i",
"/\[attachment=(.*?)\](.*?)\[\/attachment\]\s*/i",
);
$replace = array(
"<span><ul>\\1</ul></span>",
"<span><ol TYPE=\\1>\\2</ol></span>",
"<li>",
"<br>",
"<hr>",
"<b>\\1</b>",
"<i>\\1</i>",
"<u>\\1</u>",
"<a href=\"\\1\" rel=\"lightbox[roadtrip]\" title=\"Image resized click to view full\" ><img border=0 src=\"\\1\" onload=\"SetSize(this, 500);\"></a>",
"<a href=\"\\1\" rel=\"lightbox[roadtrip]\" title=\"Image resized click to view full\" ><img border=0 src=\"\\1\" onload=\"SetSize(this, 500);\"></a>",
"<font color=\\1>\\2</font>",
"<font color=\\1>\\2</font>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\3</a>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\1</a>",
"<font size=\\1>\\2</font>",
"<center>\\1</center>",
"<font face=\"\\1\">\\2</font>",
"<embed style=\"width:500px; height:410px;\" id=\"VideoPlayback\" align=\"middle\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=\\1\" allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" wmode=\"window\" salign=\"TL\"  FlashVars=\"playerMode=embedded\"> </embed>",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.stripslashes('$1').'<td></tr></table><br /></dl>'",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"<script type=\"text/javascript\" src=\"http://download.skype.com/share/skypebuttons/js/skypeCheck.js\"></script><a href=\"skype:spockst?call\"><img src=\"http://mystatus.skype.com/smallclassic/\\1\" style=\"border: none;\" width=\"114\" height=\"20\" alt=\"My status\" /></a>",
"<iframe src=\"\\1\" name=\"frame1\" scrolling=\"auto\" frameborder=\"0\" align=\"middle\" height = \"500px\" width = \"600px\"></iframe>",
"<div style=\"padding: 3px; background-color: #FFFFFF; border: 1px solid #d8d8d8; font-size: 1em;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;\"><span onClick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') {  this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>Spoiler: </b><a href=\'#\' onClick=\'return false;\'>hide</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>Spoiler: </b><a href=\'#\' onClick=\'return false;\'>show</a>'; }\" /><b>Spoiler: </b><a href=\"#\" onClick=\"return false;\">show</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\">\\1</div></div></div>",
"<img src=http://www.funnyweb.dk:8080/aim/\\1 alt=\\2>",
"<img src=./file.php?id=\\1 alt=\\2>",
);
$s = preg_replace($match, $replace, $s);
	// URLs
$sql = "SELECT *
FROM `" . $db_prefix . "_bbcodes`";
$res = $db->sql_query($sql);
$m = array();
$r = array();
        while ($row = $db->sql_fetchrow($res)) {
		$m[] = str_replace(array('[/','!\\','!i','!s','+)\\'),array('[\/','/\\','/','\s*/i','+?)\\'),$row['second_pass_match']);
		$r[] = $row['second_pass_replace'];
		}
$s = preg_replace($m, $r, $s);
	$s = format_urls($s);


	// Maintain spacing
	$s = str_replace("  ", " &nbsp;", $s);
	//Quotes
$s = format_quotes($s);
	// Linebreaks
	$s = nl2br($s);
	$s = str_replace('**-NoParseTagBegin-**', '[', $s);
	$s = str_replace('**-NoParseTagEnd-**', ']', $s);
	$s = str_replace('**-NoParseTagsmileis-**', ':', $s);
	$s = str_replace('**-NoParseurls-**', 'http', $s);

	return $s;
}
function format_urls($s)
{
global $user;

$s= preg_replace(
    "/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/i",
    "\\1<a href=redirect.php?url=\\2>\\2</a>", $s);
   preg_match_all("/((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/",$s, $result);
	$s=@str_replace(">".$result[0][1]."<",">".$result[0][1]."<",$s);
	return $s;
}
function format_quotes($s)
{
   preg_match_all('/\\[quote.*?\\]/', $s, $result, PREG_PATTERN_ORDER);
    $openquotecount = count($openquote = $result[0]);
   preg_match_all('/\\[\/quote\\]/', $s, $result, PREG_PATTERN_ORDER);
    $closequotecount = count($closequote = $result[0]);

   if ($openquotecount != $closequotecount) return $s; // quote mismatch. Return raw string...

   // Get position of opening quotes
    $openval = array();
   $pos = -1;

   foreach($openquote as $val)
 $openval[] = $pos = strpos($s,$val,$pos+1);

   // Get position of closing quotes
   $closeval = array();
   $pos = -1;

   foreach($closequote as $val)
       $closeval[] = $pos = strpos($s,$val,$pos+1);


   for ($i=0; $i < count($openval); $i++)
 if ($openval[$i] > $closeval[$i]) return $s; // Cannot close before opening. Return raw string...


    $s = str_replace("[quote]","<p class=sub><b>Quote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>",$s);
   $s = preg_replace("/\\[quote=(.+?)\\]/", "<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>", $s);
   $s = str_replace("[/quote]","</td></tr></table><br>",$s);
   return $s;
}
function username_is($id)
{
        global $db, $db_prefix;
			$sql = "SELECT COUNT(id) AS count, `name`, `username` FROM ".$db_prefix."_users WHERE `id` = '".$id."' GROUP BY id;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
            if ($row['count'] == 0) return "guest";
			else{
		    return (!$row['name'] == '' ? $row['name'] : $row['username']);
			}

}
function getuser($name){
        global $db, $db_prefix;
            $sql = "SELECT `id` FROM ".$db_prefix."_users WHERE username ='".escape($name)."' OR name = '".escape($name)."' OR clean_username = '".escape(strtolower($name))."'";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "0";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['id'];
			}
}
function gen_avatar($id){
        global $db, $db_prefix, $user, $theme, $avon, $avstore, $siteurl,$avgal;	
		if(!$avon)return;
			$sql = "SELECT COUNT(id) AS count, `name`, `username`, `avatar`, `avatar_type`, `avatar_ht`, `avatar_wt` FROM ".$db_prefix."_users WHERE `id` = '".$id."' GROUP BY `id`;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			$noavatar = false;
			if ($row['count'] == 0)
			{
			
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}else{
			if ($row["avatar"] == "blank.gif"){
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}
                                if($row['avatar_type'] == 0)$imageinfo = @getimagesize("/".$row["avatar"]);
                                $truewidth = (isset($imageinfo[0]) ? $imageinfo[0] : 0);
                                $trueheight = (isset($imageinfo[1]) ? $imageinfo[1] : 0);
								//if($row['avatar_type'] == 0) return $trueheight;
			$hight = " height=\"".$trueheight>"\"";
			$width = " width=\"".$truewidth."\"";
			if($row['avatar_ht'] != "0")$hight = " height=\"".$row['avatar_ht']."px\"";
			if($row['avatar_wt'] != "0")$width = " width=\"".$row['avatar_wt']."px\"";
			if($row['avatar_type'] == 0)return "<img".$hight.$width."  src=\"$siteurl/avatars/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 1)return "<img".$hight.$width." src=\"$siteurl/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 2)return "<img".$hight.$width." src=\"".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 3)return "<img".$hight.$width." src=\"./".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			}
			return $noavatar;
}
if (!function_exists('stripos'))
{
	function stripos($haystack, $needle)
	{
		if (preg_match('#' . preg_quote($needle, '#') . '#i', $haystack, $m))
		{
			return strpos($haystack, $m[0]);
		}

		return false;
	}
}
function genrelist2() {
        global $db, $db_prefix;
 $row = $db->sql_query("SELECT id, name, image, parent_id, tabletype FROM torrent_categories ORDER BY parent_id, sort_index, id ASC");

 while ($mysqlcats = $db->sql_fetchrow($row))
 $allcats[] = $mysqlcats;

 $allcats2 = $allcats;
 
 $i = 0;
 
 foreach ($allcats as $cat)
 {

 if ($cat[parent_id] == -1) 
 {

 $cats[] = $cat;
 $j = 0;
 foreach ($allcats2 as $subcat)
 {

 if ($cat[id] == $subcat[parent_id]) {

 //Subcategories
 $cats[$i]['subcategory'][] = $subcat;

 //Subcategories add parenttabletype
 $cats[$i]['subcategory'][$j]['parenttabletype'] = $cat['tabletype'];

 //Subcategories add idtabletype
 $cats[$i]['subcategory'][$j]['idtabletype'] = $subcat['id'].$subcat['tabletype'];

 //Subcategories description
 $cats[$i]['subcategory'][$j]['description'] = $cat['name']."->".$subcat['name'];

 //All link array for cats
 $cats[$i]['categories'] .= "cats$cat[tabletype][]=$subcat[id]&amp;";

 $j++;
 }
 }
 
 //All link for cats
 $cats[$i]['categories'] = substr($cats[$i]['categories'],0,-5);
 $i++;

 }

 }

 return $cats;

}

function categories_table($cats, $wherecatina, $linkpage = '', $display = 'block')
{
global $theme;

 $html = "";

 $html .= "<div id=\"cats\" style=\"display: {$display};\">";
 $html .= "<table>";
 $html .= "<tbody align=\"left\"><tr>";

 $i = 0;

 $ncats = count($cats);
 $catsperrow = $ncats;

 $width = 100/$ncats;

 if(count($ncats) > 0);
 foreach( $cats as $cat )
 {
if (file_exists("themes/".$theme."/pics/cat_pics/".$cat['image']))$img = "themes/".$theme."/pics/cat_pics/" . $cat['image'] ;
else
$img = "cat_pics/" . $cat['image'] ;
 $html .= ($i && $i % $catsperrow == 0) ? "</tr><tr>" : "";
 $html .= "<td class=\"nopad\" style=\"padding-bottom: 2px;padding-left: 7px;\"><img src=\"" . $img  . "\" title=\"" . htmlspecialchars($cat['name']) . "\" alt=\"" . htmlspecialchars($cat['name']) . "\" width=\"30px\" border=\"0\">&nbsp;&nbsp;<input id=\"checkAll{$cat[tabletype]}\" type=\"checkbox\" onclick=\"checkAllFields(1,{$cat['tabletype']});\" type=\"checkbox\" " . ($cat['checked'] ? "checked " : "") . "><a href=\"javascript: ShowHideMainSubCats({$cat['tabletype']},{$ncats})\"><img border=\"0\" src=\"themes/".$theme."/pics/plus.gif\" id=\"pic{$cat['tabletype']}\" alt=\"Show/Hide\">&nbsp;" . htmlspecialchars($cat['name']) . "</a>&nbsp;".(($linkpage != '') ? "<a class=\"catlink\" href=\"{$linkpage}?{$cat['categories']}\">(All)</a>" : "")."</td>\n";
 $i++;
 }



 $nrows = ceil($ncats/$catsperrow);
 $lastrowcols = $ncats % $catsperrow;

 if ($lastrowcols != 0)
 {
 if ($catsperrow - $lastrowcols != 1)
 $html .= "<td rowspan=\"" . ($catsperrow - $lastrowcols) . "\">&nbsp;</td>";
 else
 $html .= "<td>&nbsp;</td>";
 }

 $html .= "</tr><tbody>";
 $html .= "</table>";
 $html .= "</div>";

 if(count($cats) > 0);
 foreach( $cats as $cat )
 {
 $subcats = $cat[subcategory];

 if (count($subcats) > 0)
 {
 $html .= subcategories_table($cat, $wherecatina, $linkpage, $ncats);
 }

 }

 return $html;
}


function subcategories_table($cats, $wherecatina, $linkpage = '', $ncats)
{
global $theme;
 $html = "";
 $html .= "<div id=\"tabletype".$cats['tabletype']."\" style=\"display: none;\">";
 $html .= "<table>";
 $html .= "<tbody align=\"left\"><tr>";
 $width = 100/$ncats;
 $subcats = $cats['subcategory'];
 $catsperrow = $ncats;
 $i = 0;
 if (count($subcats) >0)
 foreach ($subcats as $cat)
 {
if (file_exists("themes/".$theme."/pics/cat_pics/".$cat['image']))$img = "themes/".$theme."/pics/cat_pics/" . $cat['image'] ;
else
 $img = "cat_pics/" . $cat['image'] ;
 $html .= ($i && $i % $catsperrow == 0) ? "</tr><tr>" : "";
 $html .= "<td class=\"subcatlink\" style=\"padding-bottom: 2px;padding-left: 7px; width: ".$width."%;\">"
           ."<img src=\"" . $img  . "\" title=\"" . htmlspecialchars($cat['name']) . "\" alt=\"" . htmlspecialchars($cat['name']) . "\" width=\"30px\" border=\"0\">"
		   ."&nbsp;&nbsp;<input type=\"checkbox\" onclick=\"checkAllFields(2,".$cats['tabletype'].");\" name=\"cats".$cats['tabletype']."[]\" value=\"".$cat['id']."\" type=\"checkbox\" " . (in_array($cat['id'],$wherecatina) ? "checked " : "") . ">"
		   .(($linkpage != '') ? "<a href=\"".$linkpage."?cats".$cats['tabletype']."[]=".$cat['id']."\">" . htmlspecialchars($cat['name']) . "</a>" : htmlspecialchars($cat['name']))."</td>\n";
 $i++;
 }
 $nsubcats = count($subcats);
 $nrows = ceil($nsubcats/$catsperrow);
 $lastrowcols = $nsubcats % $catsperrow;
 if ($lastrowcols != 0)
 {
 if ($catsperrow - $lastrowcols != 1)
 $html .= "<td rowspan=\"" . ($catsperrow - $lastrowcols) . "\">&nbsp;</td>";
 else
 $html .= "<td>&nbsp;</td>";
 }
 $html .= "</tr>";
 $html .= "</tbody>";
 $html .= "</table>";
 $html .= "</div>";
 return $html;
}
function set_site_var($page_title = '')
{
    global $db, $db_prefix, $announce_message, $donatein, $donateasked, $nodonate, $donations, $phpEx, $most_users_online_when, $most_users_online, $welcome_message, $version, $pivate_mode, $addprivate, $theme, $template, $user, $sitename, $siteurl, $torrent_per_page;
     if($user->user)
	 {
       //---Get User Peer Info --//
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'yes' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) $tseeding = "<p>".implode($torrents,"<br>")."</p>";
        else $tseeding = pic("upload.gif",null,_btyoureseeding);
        $tseedingcnt = $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
        #Number of downloading Torrents
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'no' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) $tleeching = "<p>".implode($torrents,"<br>")."</p>";
        else $tleeching = pic("download.gif",null,_btyoureleeching);
        $tleechingcnt = $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
		//---End User Peer Info --//
	}
$welcome_message = format_comment($welcome_message);
parse_smiles($welcome_message);
$announce_message = format_comment($announce_message);
parse_smiles($announce_message);
//---Donation Info --//
if($nodonate == "US")$type = "$";
else
$type = "&pound;";
$perc = round(100 * $donatein/$donateasked);
$width = round(1.5 * $perc);
  if ($perc<= 1) {$pic = "".$nodonate.".gif"; $width = "100";}
  elseif ($perc<= 40) $pic = "loadbarred.gif";
   elseif ($perc<= 70) $pic = "loadbaryellow.gif";
    else $pic = "loadbargreen.gif";
$donateimage = "<img height=15 width=$width src=\"images/$pic\" alt='$donatein)%'>";
	$template->assign_vars(array(
	    'SITE_NEWS'        => ($welcome_message != "") ? $welcome_message : '',
		'SITE_URL'		   => $siteurl,
		'PRIVATE_MODE'     => $pivate_mode,
		'PAGE_TITLE'       => $page_title,
		'SITENAME'         => $sitename,
		'S_ANNOUCEMENTS'   => $announce_message,
		'DONATION_IN'      => $type.$donatein,
		'DONATION_ASKED'   => $type.$donateasked,
		'DONATION_IMAGE'   => $donateimage,
		'DONATION_PERC'    => $perc,
		'S_MOST_USERS_ON'  => $most_users_online,
		'S_MOST_USERS_WN'  => $most_users_online_when,
		'U_USER'           => $user->user,
		'U_PREMIUM'        => $user->premium,
		'U_MODERATOR'      => $user->moderator,
		'U_ADMIN'          => $user->admin,
		'S_USER_ID'        => $user->id,
		'S_IN_MCP'        => false,
		'S_IN_UCP'        => false,
		'U_USER_USERNAME'  => $user->name,
		'U_USER_NICK'	   => ($user->nick) ? $user->nick : false,
		'U_USER_LEVEL'     => $user->level,
		'U_USER_GROUP'     => $user->group,
		'U_USER_LANG'      => $user->ulanguage,
		'U_USER_CAN_SHOUT' => ($user->can_shout == 'true') ? true : false,
		'U_USER_LAST_SEEN' => $user->lastlogin,
		'U_USER_FORUM_BAN' => $user->forumbanned,
		'U_SEED_BONUS'     => ($user->user) ? $user->seedbonus : '',
		'U_UPLOADED'       => ($user->user) ? mksize($user->uploaded) : '0',
		'U_DOWNLOADED'     => ($user->user) ? mksize($user->downloaded) : '0',
		'U_RATIO'          => ($user->user) ? get_u_ratio($user->uploaded, $user->downloaded) : '--',
		'U_TSEEDING'       => ($user->user) ? (($tseedingcnt >0) ? addslashes($tseeding) : false) : false,
		'U_TSEEDING_CNT'   => ($user->user) ? $tseedingcnt : false,
		'U_TLEECHING'      => ($user->user) ? (($tleechingcnt > 0) ? addslashes($tleeching) : false) : false,
		'U_TLEECHINGCNT'   => ($user->user) ? $tleechingcnt : false,
		'U_AVATAR'         => gen_avatar($user->id),
		'U_INVITES'        => ($user->user) ? $user->invites : '0',
	));
}
function pmbt_include_templ($file, $block)
{
    global $db, $db_prefix, $phpEx,  $pmbt_cache, $welcome_message, $version, $pivate_mode, $addprivate, $theme, $template, $user, $sitename, $siteurl, $torrent_per_page;
include_once($file);
if(isset($array))
{
foreach($array as $val){
if(is_array($val))$template->assign_block_vars($block,$val);
}
}
}
?>