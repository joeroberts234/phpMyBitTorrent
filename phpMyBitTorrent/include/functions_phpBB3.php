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

define('IN_PHPBB', true);
if (eregi("phpBB.php",$_SERVER["PHP_SELF"]))define('IN_CRON', true);
define('IN_PORTAL',TRUE);
include ((!defined('FORUMSHARING')) ? "./include/forum_settings.php" : "../../include/forum_settings.php");

/*---------------------------------
HERE WE GET PHPbb3 USER ID
----------------------------------*/
function get_user_forum_name($username){
global $db, $forumpx, $db_prefix;

        $sql = ("SELECT * FROM ".$forumpx."_users WHERE username ='".$username."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['user_id']."";
return "".$fid."";
}

function get_user_forum_id($uid) {
global $db, $forumpx, $db_prefix;
        $sql =("SELECT * FROM ".$db_prefix."_users WHERE id = '".$uid."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr1 = $db->sql_fetchrow($res);
        $sql = ("SELECT * FROM ".$forumpx."_users WHERE username ='".$arr1['username']."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['user_id']."";
return "".$fid."";
}
function get_user_tracker_name($username){
global $db, $forumpx, $db_prefix;

        $sql = ("SELECT * FROM ".$db_prefix."_users WHERE username ='".$username."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['user_id']."";
return "".$fid."";
}

function get_user_tracker_id($uid) {
global $db, $forumpx, $db_prefix;
        $sql =("SELECT * FROM ".$forumpx."_users WHERE user_id = '".$uid."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr1 = $db->sql_fetchrow($res);
        $sql = ("SELECT * FROM ".$db_prefix."_users WHERE username ='".$arr1['username']."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['id']."";
return "".$fid."";
}
/*------------------------------------
END USER ID
--------------------------------------*/
function get_tracker_stats($poster_id)
{
			$tracker_user_cache[$poster_id] = array(
				'uploaded'		=> mksize('0'),
				'downloaded'	=> mksize('0'),
				'ratio'		    => "&infin;",
			);

global $db, $forumpx, $db_prefix;
        $sql = "SELECT  uploaded,  downloaded, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".get_user_tracker_id($poster_id)."';";
		//echo $sql;
        $res = $db->sql_query($sql);
        $tracker = $db->sql_fetchrow($res);
		$uploaded = $tracker['uploaded'];
		$downloaded =$tracker['downloaded'];
		$ratio = $tracker['ratio'];
        $db->sql_freeresult($res);
		//echo $uploaded."<br />";
		$ratio2 = pic("pic_ratio.gif");;
        if ($downloaded == 0)
                $ratio2 .= "&infin;";
        elseif ($ratio < 0.1)
                $ratio2 .= "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.2)
                $ratio2 .= "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.3)
                $ratio2 .= "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.4)
                $ratio2 .= "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.5)
                $ratio2 .= "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.6)
                $ratio2 .= "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.7)
                $ratio2 .= "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.8)
                $ratio2 .= "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.9)
                $ratio2 .= "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 1)
                $ratio2 .= "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
        else
                $ratio2 .= "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
			//$tracker_id_cache[] = $poster_id;
			$tracker_user_cache[$poster_id] = array(
				'uploaded'		=> mksize($uploaded),
				'downloaded'	=> mksize($downloaded),
				'ratio'		    => $ratio2,
			);
			//print_r($tracker_user_cache);
			return $tracker_user_cache[$poster_id];
}
/*------------------------------------
HERE IS WHERE WE BANN USER FROM FORUM
--------------------------------------*/

function forum_ban ($username, $reason_user)
{

global $db, $forumpx, $db_prefix;
        $sql = ("SELECT * FROM ".$forumpx."_users WHERE username ='".escape($username)."'LIMIT 1");
		$res = $db->sql_query($sql);
		$arr1 = $db->sql_fetchrow($res);
	 $db->sql_query("INSERT INTO ".$forumpx."_banlist ( ban_userid , ban_ip, ban_start , ban_reason , ban_give_reason )VALUES('".$arr['user_id']."', '".$arr['user_ip']."', " . time() . ", '".$reason_user."', '".$reason_user."')")or print(mysql_error());
               
}
function forum_unban ($uid)
{
global $db, $forumpx, $db_prefix;
		 $db->sql_query("DELETE FROM ".$forumpx."_banlist WHERE ban_userid ='".get_user_forum_name($uid)."'");
 }
/*------------------------------------
END USER USER BANN
--------------------------------------*/
/*------------------------------------
HERE IS WHERE WE EDIT USER INFO "PASSWORD, IM INFO
--------------------------------------*/

function forum_pass($uid, $newpasswd)
{
global $db, $forumpx, $db_prefix;
		 $db->sql_query("UPDATE ".$forumpx."_users SET user_password = '".md5($newpasswd)."' WHERE user_id  ='".get_user_forum_name($uid)."'");
}
function forum_im($uid, $aim, $icq, $msn, $yahoo, $jabber)
{
global $db, $forumpx, $db_prefix;
if ($aim == "NULL") {
                $forum_aim = "";
        
} else $forum_aim = $aim;
if ($icq == "NULL") {
                $forum_icq = "";
        
} else $forum_icq = $icq;
if ($msn == "NULL") {
                $forum_msn = "";
        
} else $forum_msn = $msn ;
if ($yahoo == "NULL") {
                $forum_yahoo = "";
        
} else $forum_yahoo = $yahoo ;
if ($jabber == "NULL") {
                $forum_jabber = "";
        
} else $forum_jabber = $jabber ;



		$db->sql_query("UPDATE ".$forumpx."_users SET user_jabber = '".$forum_jabber."', user_icq = '".$forum_icq."', user_aim = '".$forum_aim."',  user_msnm ='".$forum_msn."', user_yim = '".$forum_yahoo."' WHERE user_id  ='".get_user_forum_id($uid)."'");
}
function add_avatar_upload($uid, $newfname, $height, $width)
{
global $db, $forumpx, $db_prefix;
$avatar = './avatars/user/'.$newfname;
$db->sql_query("UPDATE ".$forumpx."_users SET `user_avatar` = '".$avatar."', `user_avatar_type` = '2', `user_avatar_width` = '".$width."', `user_avatar_height` = '".$height."' WHERE `".$forumpx."_users`.`user_id` =".get_user_forum_id($uid)." LIMIT 1 ;");

}
function add_avatar_galery($uid, $avgallery)
{
global $db, $forumpx, $db_prefix;
                                $imageinfo = getimagesize('./avatars/'.$avgallery);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
                                if ($width > 90 OR $height > 90)return;

$avatar = './avatars/'.$avgallery;
$db->sql_query("UPDATE ".$forumpx."_users SET `user_avatar` = '".$avatar."', `user_avatar_type` = '2', `user_avatar_width` = '".$width."', `user_avatar_height` = '".$height."' WHERE `".$forumpx."_users`.`user_id` =".get_user_forum_id($uid)." LIMIT 1 ;");

}

/*------------------------------------
END EDIT USER INFO
--------------------------------------*/
/*------------------------------------
HERE IS WHERE WE AUTO ADD NEW USERS
--------------------------------------*/

function forumadd($username){
global $db, $forumpx, $db_prefix, $forumbase, $phpEx, $config,$phpbb_root_path;
define('FORUM_ADD',TRUE);
define('phpBBBASE',$forumbase);
include_once($phpbb_root_path. '/common.'.$phpEx);
include_once($phpbb_root_path . '/includes/functions_user.' . $phpEx);
     //include('./'.$forumbase . '/includes/ucp/ucp_register.php');
global $config;

define('IN_PHPBB',TRUE);
define('IN_PORTAL',TRUE);

//$phpbb_root_path= './'.phpBBBASE.'/';
		$coppa			= (isset($_REQUEST['coppa'])) ? ((!empty($_REQUEST['coppa'])) ? 1 : 0) : false;

	$group_name = ($coppa) ? 'REGISTERED_COPPA' : 'REGISTERED';
        $sql = 'SELECT group_id
        FROM ' . GROUPS_TABLE . "
        WHERE group_name = '" . $db->sql_escape($group_name) . "'
            AND group_type = " . GROUP_SPECIAL;
$result = $db->sql_query($sql)or print(mysql_error());
$row = $db->sql_fetchrow($result);
$group_id = $row['group_id'];
$res = "SELECT id,username,password,email FROM ".$db_prefix."_users WHERE username ='".escape($username)."';";
$result = $db->sql_query($res)or print(mysql_error());
$user_actkey = md5(rand(0, 100) . time());
$user_actkey = substr($user_actkey, 0, rand(6, 10));
$timezone = '-6';
$language = 'en';
$user_type = USER_NORMAL;
$is_dst = date('I');
		$arr = $db->sql_fetchrow($result);
				$user_row = array(
					'username'				=> $arr['username'],
					'user_password'			=> $arr['password'],
					'user_email'			=> $arr['email'],
					'group_id'				=> (int) $group_id,
					'user_timezone'			=> (float) $timezone,
					'user_dst'				=> $is_dst,
					'user_lang'				=> $language,
					'user_type'				=> $user_type,
					'user_actkey'			=> $user_actkey,
					'user_regdate'			=> time(),
				);

				// Register user...
				 user_add($user_row);
}
/*------------------------------------
END AD NEW USER
--------------------------------------*/
function forum_delete($uid, $username)
{
global $db, $forumpx, $db_prefix, $forumbase, $phpEx, $config,$phpbb_root_path;
$delet_user_id = get_user_forum_id($uid);
define('FORUM_ADD',TRUE);
define('phpBBBASE',$forumbase);
define('IN_PHPBB',TRUE);
include('./'.$forumbase . '/common.'.$phpEx);
include_once('./'.$forumbase . '/includes/functions_user.' . $phpEx);
include_once('./'.$forumbase . '/includes/constants.' .$phpEx);
$user = get_user_forum_id($user->id);
global $config,  $cache, $user, $auth;
$cache		= new cache();
$mode = 'retain';
$post_username = $username;
//die('|'.$mode.'|'. $delet_user_id .'|'. $post_username);
user_delete($mode, $delet_user_id, $post_username);
return;
}

/*------------------------------------
HERE IS WHERE WE START NEW SSESSION(LOGIN)
--------------------------------------*/
function startsession()
{
session_create($user_id, $set_admin, $persist_login);
}
function forumlogin($username){
 global $db, $forumpx, $db_prefix, $logintime, $remember;
		// See If User is banned in Forum
		$sql = ("SELECT COUNT(*) FROM ".$forumpx."_banlist WHERE ban_userid ='".get_user_forum_name($username)."'");
		$res1 = $db->sql_query($sql);
		$arr12 = $db->sql_fetchrow($res1);
		$banned = $arr12[0];
		//end
if ($banned > "0"){	
return;
}
else{
        $db->sql_query("DELETE FROM ".$forumpx."_sessions WHERE session_user_id ='".get_user_forum_name($username)."';")or print(mysql_error());
        $db->sql_query("DELETE FROM ".$forumpx."_sessions_keys WHERE user_id ='".get_user_forum_name($username)."';")or print(mysql_error());
        $res = $db->sql_query("SELECT * FROM torrent_users WHERE username ='".$username."';")or print(mysql_error());
        if (!$res) break;
        $row = $db->sql_fetchrow($res);
        if (!$row) break;
		$remember = $row['remember'];
$admin = ($row['level']=="admin") ? 1 : 0;
        $sql = "SELECT config_value FROM ".$forumpx."_config WHERE config_name = 'rand_seed' ;";
$result = $db->sql_query($sql)or print(mysql_error());
$config = $db->sql_fetchrow($result)or print(mysql_error());

	$val = $config[0] . microtime();
	
	$val = md5($val);
	
	
	$key_id = substr($val, 4, 16);
                        $session_time = time() + (($logintime) ? 1600 * (int) $logintime : 31536000);
						$cookie_expire = time()+8640000;
						if ($remember=="no" ) $auto_login  = '0'; 
						else
						$auto_login  = '1';
                        $session_browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? (string) $_SERVER['HTTP_USER_AGENT'] : '';
                        $session_user_id = (get_user_forum_name($username));
                        $session_page  = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
                        $session_id = md5(substr($val, 4, 16));
        if (!array_key_exists("HTTP_X_FORWARDED_FOR",$_SERVER)) { # Proxy check. Thanks to an anonymous contributor
                $session_ip = $_SERVER["REMOTE_ADDR"];
        } else {
                $session_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
	                    $sql="INSERT INTO ".$forumpx."_sessions_keys (key_id, last_ip, last_login, user_id) VALUES ('".(string) md5($key_id)."', '".$session_ip."', '".(int) time()."', '".$session_user_id ."');";
						if ($remember=="yes") $db->sql_query($sql);
	 $db->sql_query("INSERT INTO ".$forumpx."_sessions (session_id, session_user_id, session_last_visit, session_start,  session_time, session_ip, session_browser, session_page, session_admin, session_autologin) VALUES ('".$session_id ."', '".$session_user_id ."', " . time() . ", " . time() . ", '".$session_time ."', '".$session_ip."', '".$session_browser."', '".$session_page."', '".$admin."', '".$auto_login."')")or print(mysql_error());
               
 			set_cookie('u', $session_user_id, $cookie_expire);
			if ($remember=="no")set_cookie('k', '.', $cookie_expire);
			else
			set_cookie('k', (string) md5($key_id), $cookie_expire);
			set_cookie('sid', $session_id, $cookie_expire);
			return;

			
}        
}

	function set_cookie($name, $cookiedata, $cookietime)
	{
	global $cookie_name, $cookie_domain, $cookie_path, $forumpx;
		$name_data = rawurlencode($cookie_name . '_' . $name) . '=' . rawurlencode($cookiedata);
		$expire = gmdate('D, d-M-Y H:i:s \\G\\M\\T', $cookietime);
		$domain = (!$cookie_domain || $cookie_domain == 'localhost' || $cookie_domain == '127.0.0.1') ? '' : '; domain=' . $cookie_domain;

		header('Set-Cookie: ' . $name_data . '; expires=' . $expire . '; path=' . $cookie_path . $domain . ((!$cookie_secure) ? '' : '; secure') . '; HttpOnly', false);
	return;
	}
function session_get(){
global $db, $forumpx, $db_prefix, $user;
$sql=("SELECT * FROM ".$forumpx."_sessions WHERE session_user_id = '".get_user_forum_id($user->id)."' LIMIT 1");
		$res = $db->sql_query($sql);
		$row = $db->sql_fetchrow($res);
$sid = $row["session_id"];
//$db->sql_freeresult($configquery);
return $sid;
}
	
function forumlogout(){
global $db, $forumpx, $user;
            $cookie_expire = time() +  86400 ;
		 $db->sql_query("DELETE FROM ".$forumpx."_sessions WHERE session_user_id ='".get_user_forum_id($user->id)."'");
		 $db->sql_query("DELETE FROM ".$forumpx."_sessions_keys WHERE user_id ='".get_user_forum_id($user->id)."'");

 			set_cookie('u', '', $cookie_expire);
			set_cookie('k', '', $cookie_expire);
			set_cookie('sid', '', $cookie_expire);

}
/*------------------------------------
END SESSIONS (LOGIN)
--------------------------------------*/
/*------------------------------------
convert html to BBcode
--------------------------------------*/
function html_bbcode_format ($replace, $bbcode_uid) { 
$replace = str_replace(';;','',$replace);
$replace = str_replace('&quot;','"',$replace);
$replace = str_replace('&lt;','<',$replace);
$replace = str_replace('&gt;','>',$replace);
$replace = str_replace('<br />','',$replace);
$replace = preg_replace('</div>', '', $replace);
$replace = preg_replace('<div align="(.*?)">', '', $replace);
$replace = preg_replace('<img src="(.*?)"(.*?) />', '[img:'.$bbcode_uid.']$1[/img:'.$bbcode_uid.']', $replace);
$replace = preg_replace('<img(.*?)src="(.*?)">', '[img:'.$bbcode_uid.']$2[/img:'.$bbcode_uid.']', $replace);
$replace = preg_replace('/\<font size=\"([1-7])\"\>((\s|.)+?)\<\/font>/i', '[size=\\1:'.$bbcode_uid.']\\2[/size:'.$bbcode_uid.']', $replace);
$replace = preg_replace('/\<font color=\"(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\"\>((\s|.)+?)\<\/font>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
$replace = preg_replace('/\<font color=\"([a-zA-Z]+)\]((\s|.)+?)\<\/font>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
$replace = preg_replace("/\<a href=\"((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\">((\s|.)+?)\<\/a\>/i","[url=\\1:'.$bbcode_uid.']\\3[/url:'.$bbcode_uid.']", $replace);
$replace = str_replace('<i>','[i:'.$bbcode_uid.']',$replace);
$replace = str_replace('</i>','[/i:'.$bbcode_uid.']',$replace);
$replace = str_replace('<b>','[b:'.$bbcode_uid.']',$replace);
$replace = str_replace('</b>','[/b:'.$bbcode_uid.']',$replace);
$replace = str_replace('<strong>','[b:'.$bbcode_uid.']',$replace);
$replace = str_replace('</strong>','[/b:'.$bbcode_uid.']',$replace);
$replace = str_replace('<u>','[u:'.$bbcode_uid.']',$replace);
$replace = str_replace('</u>','[/u:'.$bbcode_uid.']',$replace);
$replace = str_replace('<','',$replace);
$replace = str_replace('/>','',$replace);
$replace = str_replace('>','',$replace);
$replace = str_replace('&nbsp;',' ',$replace);
return $replace; 
}
/*---------------------------------------
end convert html to BBcode
-----------------------------------------*/
/*---------------------------------------
insert new topic
-----------------------------------------*/
function newtopic($name, $description, $poster)
{
global $db, $forumpx, $user, $auto_post;

$description = stripslashes($description);
		$bbcode_bitfield = "Sg==";


$bbcode_uid = substr(md5(time()), 0, 5);

        if (!array_key_exists("HTTP_X_FORWARDED_FOR",$_SERVER)) { # Proxy check. Thanks to an anonymous contributor
                $ip = $_SERVER["REMOTE_ADDR"];
        } else {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}		
if($poster == "0") $postername = 'ANONYMOUS';
else
$postername = $user->name;
if($poster == "0") $poster = "1";
else
$poster = get_user_forum_id($poster);
$replace = str_replace(";;"," ",$description);
$description = html_bbcode_format ($replace, $bbcode_uid);
$sql = ("SELECT `user_colour` FROM `".$forumpx."_users` WHERE `user_id` = " . $poster ." LIMIT 1");
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$color = $db->sql_fetchrow($res);
		$user_color = $color['user_colour'];

#update topics
$db->sql_query("INSERT INTO `".$forumpx."_topics` (`forum_id`, `topic_title`, `topic_poster` , `topic_time` , `topic_views`, `topic_first_poster_name`, `topic_first_poster_colour`, `topic_last_poster_name`, `topic_last_poster_colour`, `topic_last_post_subject`, `topic_last_post_time`, `topic_last_view_time`) 
VALUES ('" . $auto_post ."', '" . $name . "', '" . $poster . "', '" . time(). "', '1', '" . $postername . "','" . $user_color . "' , '" . $postername . "', '" . $user_color . "' , '" . $name . "', '" . time(). "', '" .time() . "' )");
$topicid = $db->sql_nextid();

#insert post
$db->sql_query("INSERT INTO `".$forumpx."_posts` (`topic_id`, `forum_id`, `poster_id` , `poster_ip`, `post_time`,  `post_username`, `post_subject` , `post_text` , `post_checksum`,  `post_postcount`, `bbcode_bitfield`, `bbcode_uid`) 
VALUES ('" . $topicid ."', '" . $auto_post . "', '" . $poster ."', '" . $ip . "', '" . time(). "', '" . $postername . "', '" . $name . "', '" . $description . "', '" . md5($description) ."', '1', '" . $bbcode_bitfield . "', '" . $bbcode_uid . "')");
$postid = $db->sql_nextid();



#update config
$db->sql_query("UPDATE `".$forumpx."_config` SET `config_value` = config_value  + ' 1' 
WHERE CONVERT( `".$forumpx."_config`.`config_name` USING utf8 ) = 'num_topics'  ;");

$db->sql_query("UPDATE `".$forumpx."_config` SET `config_value` = config_value  + ' 1' 
WHERE CONVERT( `".$forumpx."_config`.`config_name` USING utf8 ) = 'num_posts'  ;");

#update topic posts
$db->sql_query("INSERT INTO `".$forumpx."_topics_posted` ( `user_id` , `topic_id` , `topic_posted` )
VALUES (
'" . $poster . "', '" . $topicid ."', '1'
) ");

#update forum
$db->sql_query("UPDATE `".$forumpx."_forums` SET `forum_posts` = forum_posts + '1',
`forum_topics` = forum_topics + '1',
`forum_topics_real` = forum_topics_real + '1',
`forum_last_post_id` =  '" . $postid . "',
`forum_last_poster_id` = '" . $poster . "',
`forum_last_post_subject` = '" . $name . "',
`forum_last_post_time` = ". time() . ",
`forum_last_poster_name` = '" . $postername . "' WHERE `".$forumpx."_forums`.`forum_id` = " . $auto_post . " LIMIT 1 ;");

#if is a user update the user posts and last post time
if($poster >= "1")
{
$db->sql_query("UPDATE `".$forumpx."_users` SET `user_posts` = user_posts + '1', 
`user_lastpost_time` = " . time() ." 
WHERE `".$forumpx."_users`.`user_id` = " . $poster . "");
}
}
/*---------------------------------------
end insert new topic
-----------------------------------------*/

?>