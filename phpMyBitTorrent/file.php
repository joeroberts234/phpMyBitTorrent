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
* @version $Id: file.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
define("ATTACHMENTS_TABLE","torrent_attachments");
require_once("include/config_lite.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
if ($use_rsa) $rsa = new RSA($rsa_modulo, $rsa_public, $rsa_private);
$user = @new User($_COOKIE["btuser"]);
if (!function_exists('htmlspecialchars_decode'))
{
	/**
	* A wrapper for htmlspecialchars_decode
	* @ignore
	*/
	function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
	{
		return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
	}
}
function header_filename($file)
{
	$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';

	// There be dragons here.
	// Not many follows the RFC...
	if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Safari') !== false || strpos($user_agent, 'Konqueror') !== false)
	{
		return "filename=" . rawurlencode($file);
	}

	// follow the RFC for extended filename for the rest
	return "filename*=UTF-8''" . rawurlencode($file);
}
$config = array(
'allow_attachments'					=> true,
'allow_pm_attach'					=> true,
'upload_path'						=> '/files',
'avatar_salt'						=> '',
'avatar_path'						=> 'avatars',
'secure_downloads'					=> false,
'secure_allow_empty_referer'		=> true,
'secure_allow_deny'					=> true,
'force_server_vars'					=> '',
'server_name'						=> '',
);
if (isset($_GET['avatar']))
{
	$browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : 'msie 6.0';
	$filename = $_GET['avatar'];
	$avatar_group = false;
	if ($filename[0] === 'g')
	{
		$avatar_group = true;
		$filename = substr($filename, 1);
	}
	if (strpos($filename, '.') == false)
	{
		header('HTTP/1.0 403 forbidden');
		$db->sql_close();
		exit;
	}
	
	$ext		= substr(strrchr($filename, '.'), 1);
	$stamp		= (int) substr(stristr($filename, '_'), 1);
	$filename	= (int) $filename;
	// let's see if we have to send the file at all
	$last_load 	=  isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) : false;
	if (strpos(strtolower($browser), 'msie 6.0') === false)
	{
		if ($last_load !== false && $last_load <= $stamp)
		{
			header('Not Modified', true, 304);
			// seems that we need those too ... browsers
			header('Pragma: public');
			header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
			exit();
		} 
		else
		{
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $stamp) . ' GMT');
		}
	}
	
	if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg')))
	{
		// no way such an avatar could exist. They are not following the rules, stop the show.
		header("HTTP/1.0 403 forbidden");
		$db->sql_close();
		exit;
	}
	if (!$filename)
	{
		// no way such an avatar could exist. They are not following the rules, stop the show.
		header("HTTP/1.0 403 forbidden");
		$db->sql_close();
		exit;
	}
	send_avatar_to_browser(($avatar_group ? 'g' : '') . $filename . '.' . $ext, $browser);

	$db->sql_close();
	exit;
}
$download_id = request_var('id', 0);
$mode = request_var('mode', '');
$thumbnail = request_var('t', false);
if (!$download_id)
{
	trigger_error('NO_ATTACHMENT_SELECTED');
}

if (!$config['allow_attachments'] && !$config['allow_pm_attach'])
{
	trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
}
$sql = 'SELECT attach_id, is_orphan, download_count, in_message, post_msg_id, extension, physical_filename, real_filename, mimetype
	FROM ' . ATTACHMENTS_TABLE . "
	WHERE attach_id = $download_id";
$result = $db->sql_query($sql . " LIMIT 1") OR btsqlerror($sql);
$attachment = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$attachment)
{
	trigger_error('ERROR_NO_ATTACHMENT');
}
if ((!$attachment['in_message'] && !$config['allow_attachments']) || ($attachment['in_message'] && !$config['allow_pm_attach']))
{
	trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
}

$row = array();
	$filename = $siteurl . $config['upload_path'] . '/' . $attachment['physical_filename'];
	$size = @filesize($filename);
	//die($filename);
	if (headers_sent() || !@file_exists($filename) || !@is_readable($filename))
	{
		// PHP track_errors setting On?
		if (!empty($php_errormsg))
		{
			trigger_error($user->lang['UNABLE_TO_DELIVER_FILE'] . '<br />' . sprintf($user->lang['TRACKED_PHP_ERROR'], $php_errormsg));
		}

		trigger_error('UNABLE_TO_DELIVER_FILE');
	}
	header('Pragma: public');
		header('Content-Disposition: ' . ((strpos($attachment['mimetype'], 'image') === 0) ? 'inline' : 'attachment') . '; ' . header_filename(htmlspecialchars_decode($attachment['real_filename'])));
	header('Content-Type: ' . $attachment['mimetype']);
	//header('Content-Disposition: attachment; ' . header_filename(htmlspecialchars_decode($attachment['real_filename'])));
			header('expires: -1');
	if ($size)
	{
		header("Content-Length: $size");
	}
	// Try to deliver in chunks
	@set_time_limit(0);

	$fp = @fopen($filename, 'rb');

	if ($fp !== false)
	{
		while (!feof($fp))
		{
			echo fread($fp, 8192);
		}
		fclose($fp);
	}
	else
	{
		@readfile($filename);
	}

	flush();
$db->sql_query("UPDATE `torrent_attachments` SET `download_count` = '".($attachment['download_count']+1)."' WHERE `torrent_attachments`.`attach_id` = '".$attachment['attach_id']."' LIMIT 1;");
	exit;


?>