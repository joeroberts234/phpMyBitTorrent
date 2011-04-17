<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
*------              ©2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, Dec 20, 2009 1:05 AM   ------------------------*
*/
/**
* gen_avatar
*
*
* Used to get the users avatar
*/
if (!function_exists("gen_avatar")){ 
function gen_avatar($id, $hight = false, $width = false){
        global $db, $db_prefix, $user, $theme, $avon, $avstore, $siteurl, $avgal;	
		if(!$avon)return;
		// Colect Info on the user
			$sql = "SELECT COUNT(id) AS count, `name`, `username`, `avatar`, `avatar_type`, `avatar_ht`, `avatar_wt` FROM ".$db_prefix."_users WHERE `id` = '".$id."' LIMIT 1;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			$noavatar = false;
			if ($row['count'] == 0)
			{
			// Check to find the Default Avatar
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
                                if($row['avatar_type'] == 0)
								{
									$imageinfo = @getimagesize("/".$row["avatar"]);
                                	$truewidth = (isset($imageinfo[0]) ? $imageinfo[0] : 0);
                                	$trueheight = (isset($imageinfo[1]) ? $imageinfo[1] : 0);
								}
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
}
if (!function_exists("getuser")){ 
function getuser($name){
        global $db, $db_prefix;
            $sql = "SELECT 
			`id` 
			FROM ".$db_prefix."_users 
			WHERE username ='".$db->sql_escape($name)."' 
			OR name = '".$db->sql_escape($name)."' 
			OR clean_username = '".$db->sql_escape(strtolower($name))."'";
			$res = $db->sql_query($sql);
            if ($db->sql_numrows($res) == 0) return "0";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['id'];
			}
}
}
if (!function_exists("username_is")){ 
function username_is($id)
{
        global $db, $db_prefix;
			$sql = "SELECT COUNT(id) AS count, `username` FROM ".$db_prefix."_users WHERE `id` = '".$id."';";
			$res = $db->sql_query($sql);
			$row = $db->sql_fetchrow($res);
            if ($row['count'] == 0) return "Guest";
			else{
		    return $row['username'];
			}

}
}
if (!function_exists("getlevel")){ 
function getlevel($userid){
        global $db, $db_prefix;
			$sql = "SELECT `can_do` FROM ".$db_prefix."_users WHERE `id` = '".$userid."';";
			$res = $db->sql_query($sql);
            if ($db->sql_numrows($res) == 0) return "guest";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['can_do'];
			}
}
}
if (!function_exists("getusercolor")){ 
function getusercolor($level){
        global $db, $db_prefix;
			$sql = "SELECT color FROM ".$db_prefix."_levels WHERE `level` = '".$level."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
		return $row['color'];
}
}
if (!function_exists("get_user_timezone")){ 
function get_user_timezone($id) {
        global $db, $db_prefix, $user;
  if ($user->user){
	   $sql = "SELECT * FROM ".$db_prefix."_users WHERE id='" . $id . "' LIMIT 1";
       $query = $db->sql_query($sql);
       if ($db->sql_numrows($query) != "0") {
			$kasutaja = $db->sql_fetchrow($query);
			$timezone = $kasutaja["tzoffset"]+60;
			return $timezone;
		} else {
         return "377";
		} //Default timezone
	}
}
}
if (!function_exists("processinput")){ 
function processinput($name,&$input) {
        global $sqlfields, $sqlvalues;
        if (!get_magic_quotes_gpc()) $input = addslashes($input);
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != "NULL") ? "'".$input."'" : "NULL";
}
}
if (!function_exists("processload")){ 
function processload($name,$input) {
        global $sqlfields, $sqlvalues;
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != 0) ? "".$input."" : 0;
}
}
if (!function_exists("tz_select")){ 
	function tz_select($default = '', $userrow = '', $truncate = false)
	{
	        global $db, $db_prefix;
		$sql = ("SELECT id,name from ".$db_prefix."_time_offset ORDER BY name");
		$tz_r = $db->sql_query($sql);
		while ($tz_a = $db->sql_fetchrow($tz_r))
		  $default .= "<option value=" . $tz_a['id'] . "" . ($userrow["tzoffset"] == $tz_a['id'] ? " selected" : "") . ">" . $tz_a['name'] . "</option>\n";
		
	return $default;
	}
}
if (!function_exists("cnt_select")){ 
	function cnt_select($countries = '', $userrow = array("country" =>0,))
	{
	        global $db, $db_prefix;
		$sql = ("SELECT id,name from ".$db_prefix."_countries ORDER BY name");
		$ct_r = $db->sql_query($sql);
		while ($ct_a = $db->sql_fetchrow($ct_r))
		  $countries .= "<option value=" . $ct_a['id'] . "" . ($userrow["country"] == $ct_a['id'] ? " selected" : "") . ">" . $ct_a['name'] . "</option>\n";
	return $countries;
	}
}
if (!function_exists("confirm_box")){ 
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
}
?>