<?php
/*
*------------------------------phpMyBitTorrent V 2.0.5-------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*key 1: 45CHOUWY915767c86f593bbbcc9adfb6ecbc69d6
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
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$startpagetime = microtime();
require_once("common.php");
$template = & new Template();
function get_topic_title($id){
global $db, $db_prefix;
			        $sql = "SELECT `subject` FROM `".$db_prefix."_forum_topics` WHERE `id`='".$id."' LIMIT 1;";
					$arr = $db->sql_query($sql);
					while ($res = $db->sql_fetchrow($arr)) {
					return $res['subject'];
					}

}
function processinput($name,&$input) {
        global $sqlfields, $sqlvalues;
        if (!get_magic_quotes_gpc()) $input = addslashes($input);
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != "NULL") ? "'".$input."'" : "NULL";
}

function processload($name,&$input) {
        global $sqlfields, $sqlvalues;
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != 0) ? "".$input."" : 0;
}
if(!$user->user){
header("Location: ".$siteurl."/login.php");
die();
 }
$admin_mode = false;
if (isset($id)) {
		if($user->id != $id AND (!checkaccess('edit_user'))){
              set_site_var('- '._btuserprofile.' - '._bterror);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>_btaccdenied,
                                        'S_ERROR_MESS'            => _btuser_edit,
                                ));
             echo $template->fetch('error.html');
             @include_once("include/cleanup.php");
             ob_end_flush();
             die();
}
        else {
                $uid = intval($id);
                $admin_mode = true;
        }
} else $uid = $user->id;
                                $template->assign_vars(array(
                                        'S_MOD_MODE'            => $admin_mode,
                                        'PMBT_LINK_BACK'            => ($admin_mode)? $siteurl.'/template_test.php?'.'id=' . $uid . '&amp;' : $siteurl.'/template_test.php?',
                                ));
if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}

$sql_profile = "SELECT U.* , count(F.id)AS forumposts FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid where U.id ='".$uid."' LIMIT 1;";
$res_profile = $db->sql_query($sql_profile)OR btsqlerror($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
if ($admin_mode) $uname = $userrow["username"];
else $uname = $user->name;

$mode											= request_var('mode', '');
$icq			                                = request_var('icq', '');
$aim											= request_var('aim', '');
$msn											= request_var('msn', '');
$yahoo											= request_var('yahoo', '');
$jabber											= request_var('jabber', '');
$skype											= request_var('skype', '');
$country										= request_var('country', '');
$bday_day										= request_var('bday_day', '');
$bday_month										= request_var('bday_month', '');
$bday_year										= request_var('bday_year', '');
$signature										= request_var('signature', '');
$avupload										= request_var('avupload', '');
$uploadurl										= request_var('uploadurl', '');
$remotelink										= request_var('remotelink', '');
$width											= request_var('width', '');
$height											= request_var('height', '');
$avgallery										= request_var('avgallery', '');
$name											= request_var('name', '');
$new_password									= request_var('newpasswd', '');
$password_confirm								= request_var('newpasswdconf', '');
$cur_password									= request_var('cur_password', '');
$accept_mail									= request_var('accept_mail', '');
$accept_pm_notivy								= request_var('accept_pm_notivy', '');
$pm_notify										= request_var('pm_notify', '');
$allowpm										= request_var('allowpm', '');
$hideonline										= request_var('Show_online', '');
$notifypm										= request_var('notifypm', '');
$popuppm										= request_var('popuppm', '');
$user_torrent_per_page							= request_var('user_torrent_per_page', '');
$customlang										= request_var('customlang', '');
$customtheme									= request_var('customtheme', '');
$offset											= request_var('offset', '');
$sendto											= request_var('sendto', '');
$usernames										= request_var('usernames', '');
$passkey_reset                                  = request_var('passkey_reset', '');
$new_email                                      = request_var('new_email', '');
$email_confirm									= request_var('email_confirm', '');
$take_edit                                      = request_var('take_edit', '');
$new_foe                                        = request_var('new_foe', '');
$remove_foe                                     = request_var('remove_foe', array(0));
$new_freind                                     = request_var('new_freind', '');
$remove_friend                                  = request_var('remove_friend', array(0));
if($take_edit){
        $errors = Array();
        $sqlfields = Array();
        $sqlvalues = Array();
                switch($mode) {
				               case "subscribed":{
							                     break;
							                     }
				               case "bookmarks":{
						                        include 'include/ucp/edit_bookmarks.php';
							                    break;
							                    }
				               case "drafts":{
							                  break;
							                  }
				               case "attachments":{
							                      break;
							                      }
				               case "profile_info":{
							                       include 'include/ucp/edit_profile_info.php';
							                       break;
							                       }
				               case "signature":{
							                     include 'include/ucp/edit_signature.php';
							                     break;
							                     }
				               case "avatar":{
							                 include 'include/ucp/edit_avatar.php';
							                 break;
							                 }
				               case "admin_reg_details":{
							                            break;
							                            }
				               case "reg_details":{
							                 include 'include/ucp/edit_reg_details.php';
							                      break;
							                      }
				               case "personal":{
							                   include 'include/ucp/edit_personal.php';
							                   break;
							                   }
				               case "friends":{
							                  include 'include/ucp/edit_friends.php';
							                  break;
							                  }
				               case "foes":{
							               include 'include/ucp/edit_foes.php';
							               break;
							               }
							}
              }
$sql_profile = "SELECT U.* , count(F.id)AS forumposts, COUNT(DISTINCT B.topic_id)AS book FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid LEFT JOIN ".$db_prefix."_bookmarks B ON U.id = B.user_id  where U.id ='".$uid."' LIMIT 1;";
$res_profile = $db->sql_query($sql_profile)OR btsqlerror($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
if ($admin_mode) $uname = $userrow["username"];
else $uname = $user->name;

$off_set = '<option value=0>----</option>';
$sql = ("SELECT id,name from ".$db_prefix."_time_offset ORDER BY name");
$tz_r = $db->sql_query($sql);
while ($tz_a = $db->sql_fetchrow($tz_r))
  $off_set .= "<option value='" . $tz_a['id'] . "'" . ($userrow["tzoffset"] == $tz_a['id'] ? " selected" : "") . ">" . $tz_a['name'] . "</option>\n";

$countries = "<option value=0>----</option>\n";
$sql = ("SELECT id,name from ".$db_prefix."_countries ORDER BY name");
$ct_r = $db->sql_query($sql);
while ($ct_a = $db->sql_fetchrow($ct_r))
  $countries .= "<option value=$ct_a[id]" . ($userrow["country"] == $ct_a['id'] ? " selected" : "") . ">$ct_a[name]</option>\n";
set_site_var(_btuserprofile.' - '.$userrow["username"]);
if($userrow["book"]){
$sql="SELECT topic_id AS book_id FROM `".$db_prefix."_bookmarks` WHERE user_id = '" . $uid . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
while ($bookmarks = $db->sql_fetchrow($res)){
$sql2="SELECT forumid AS forumid FROM `".$db_prefix."_forum_topics` WHERE  id = '" . $bookmarks['book_id'] . "' LIMIT 1;";
$res2 = $db->sql_query($sql2) OR btsqlerror($sql2);
$post_forumid = $db->sql_fetchrow($res2);
$sql3 = 'SELECT name AS name FROM `'.$db_prefix.'_forum_forums` WHERE id = ' . $post_forumid['forumid'] . ' LIMIT 1'; 
$res3 = $db->sql_query($sql3) OR btsqlerror($sql3);
$book_forum = $db->sql_fetchrow($res3);
$sql4 = 'SELECT * FROM `'.$db_prefix.'_forum_posts` WHERE topicid = ' . $bookmarks['book_id'] . ' ORDER BY added DESC LIMIT 1'; 
$res4 = $db->sql_query($sql4) OR btsqlerror($sql4);
$book_post_info = $db->sql_fetchrow($res4);
$template->assign_block_vars('books_title',array(
'BOOKS_LAST_POSTER_COLOR' =>getusercolor(getlevel_name($book_post_info['userid'])),
'BOOKS_LAST_NAME' =>username_is($book_post_info['userid']),
'BOOKS_LAST_POSTER' =>$book_post_info['userid'],
'BOOKS_LAST_POST_DATE' =>$book_post_info['added'],
'BOOKS_FORUM_TITTLE' =>$book_forum['name'],
'BOOKS_FORUM_ID' => $post_forumid['forumid'],
'BOOKS_TITTLE' => get_topic_title($bookmarks['book_id']),
'BOOKS_ID' => $bookmarks['book_id'],
));
$books_title[] = get_topic_title($bookmarks['book_id']);
$books_id[] = $bookmarks['book_id'];
}
}
$post_count = 0;
$active_f_name = $most_in = $active_t_name = $most_in_f = array();
if($userrow["forumposts"]){
$sql="SELECT count(id)as num FROM `".$db_prefix."_forum_posts`;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$post_count = $db->sql_fetchrow($res);
$sql = " SELECT count(`torrent_forum_posts`.`topicid`)as posts, `torrent_forum_posts`.`topicid` as id FROM `torrent_forum_posts` WHERE `torrent_forum_posts`.`userid` = " . $userrow["id"] . " GROUP BY `torrent_forum_posts`.`topicid` ORDER BY posts  DESC LIMIT 1;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in = $db->sql_fetchrow($res);
$sql = "SELECT `subject`, `forumid` FROM `torrent_forum_topics` WHERE `id` = " . $most_in['id'] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_t_name = $db->sql_fetchrow($res);
$sql = "SELECT `name`, `id` FROM `torrent_forum_forums` WHERE `id` = " . $active_t_name['forumid'] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_f_name = $db->sql_fetchrow($res);
$t_post_in = array();
$sql = "SELECT `id` FROM `torrent_forum_topics` WHERE `forumid` = " . $active_f_name['id'] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
while($row = $db->sql_fetchrow($res)){
$t_post_in[] = $row['id'];
}
$sql = " SELECT count(`torrent_forum_posts`.`id`)as posts FROM `torrent_forum_posts` WHERE `torrent_forum_posts`.`topicid` IN ('".implode("', '",$t_post_in)."') AND `torrent_forum_posts`.`userid` = " . $userrow["id"] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in_f = $db->sql_fetchrow($res);
}
		$memberdays = max(1, round((time() - sql_timestamp_to_unix_timestamp($userrow["regdate"])) / 86400));
		$posts_per_day = $userrow["forumposts"] / $memberdays;
		$percentage = ($post_count['num']) ? min(100, ($userrow["forumposts"] / $post_count['num']) * 100) : 0;
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 600;
$dt = date("Y-m-d H:i:s", $dt1);
$active_f_count = ($userrow["forumposts"]) ? $userrow["forumposts"] : '0';
$l_active_pct = ($user->user && $userrow["id"] == $user->id) ? '%.2f%% of your posts' : '%.2f%% of user’s posts';
$active_t_pct = ($userrow["forumposts"]) ? ($most_in['posts'] / $userrow["forumposts"]) * 100 : 0;
$active_f_pct = ($userrow["forumposts"]) ? ($most_in_f['posts'] / $userrow["forumposts"]) * 100 : 0;
$now = getdate(time() - date('Z'));
$user_friends = '';
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$userrow["id"]."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                for ($i = 1; list($uid, $username, $user_name, $can_do, $laslogin, $show_online) = $db->sql_fetchrow($res); $i++) {
                        $user_friends .= "<option value=\"" . $uid ."\">" . $user_name . "</option>";
		$which = (time() - 300 < sql_timestamp_to_unix_timestamp($laslogin) && ($show_online == 'true' || $user->admin)) ? 'online' : 'offline';

		$template->assign_block_vars("friends_{$which}", array(
			'USER_ID'		=> $uid,
			'USER_COLOUR'	=> getusercolor($can_do),
			'USERNAME'		=> $username,
			'USERNAME_FULL'	=> $user_name)
		);
                }
        }
        $db->sql_freeresult($res);
$user_foe = '';
$sql = "SELECT B.slave, IF (U.name IS NULL, U.username, U.name) as username FROM ".$db_prefix."_private_messages_blacklist B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$userrow["id"]."' ORDER BY username;";
$res = $db->sql_query($sql) or btsqlerror($sql);
while (list ($id, $name) = $db->sql_fetchrow($res)) {
$user_foe .= "<option value=\"" . $id ."\">" . $name . "</option>";
}
$db->sql_freeresult($res);
$galery = '';
$galery .= "<option value=\"none\">"._btchooseavatar."</option>";
$galery .= "<option value=\"blank.gif\">"._btnone."</option>";
$dhandle = opendir("./".$avgal."/");
while ($file = readdir($dhandle)) {
        if (is_dir("./".$avgal."/".$file) OR $file == "blank.gif" OR !eregi("\.(gif|jpg|png)$",$file)) continue;
        $galery .= "<option value=\"".$file."\">".$file."</option>";
}
closedir($dhandle);
        $languages = Array();
        $langdir = "language";
        $langhandle = opendir($langdir);
        while ($langfile = readdir($langhandle)) {
                if (eregi("\.php$",$langfile) AND strtolower($langfile) != "mailtexts.php" AND strtolower($langfile) != "help.php")
                        $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
        }
        closedir($langhandle);
        unset($langdir,$langfile);
		$langset = '';
foreach ($languages as $key=>$val) {
        $langset .= "<option ";
        if ($userrow["language"] == $key) $langset .= "selected";
        $langset .= " value=\"".$key."\">".$val."</option>\n";
}
unset($languages);
        $themes = Array();
        $thememaindir = "themes";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
		$themeset = '';
foreach ($themes as $key=>$val) {
        $themeset .= "<option ";
        if ($userrow["theme"] == $key) $themeset .= "selected";
        $themeset .= " value=\"".$key."\">".$val."</option>\n";
}
unset($themes);

        $adminlevel = "<select name=\"level\">";
        $adminlevel .= "<option ".(($userrow["level"] == "user") ? "selected " :'' )."value=\"user\">"._btclassuser."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "premium") ? "selected " :'' )."value=\"premium\">"._btclasspremium."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "moderator") ? "selected " :'' )."value=\"moderator\">"._btclassmoderator."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "admin") ? "selected " :'' )."value=\"admin\">"._btclassadmin."</option>";
        $adminlevel .= "</select>";

        if(isset($userrow["birthday"]) OR !$userrow["birthday"]=='')$bday = explode("-", $userrow["birthday"]);
		else
		$bday = array('0','0','0');
		$now = getdate(time() - date('Z'));
switch($mode) {
			   case "front":{
       				         include 'include/ucp/ucp_front.php';
						     break;
						     }
			   case "drafts":{
       				         include 'include/ucp/drafts.php';
						     break;
						     }
				default:{
				        include 'include/ucp/ucp_front.php';
						break;
					}
			  }
$template->assign_vars(array(
        'S_FORCE_PASSKEY'       => $force_passkey,
        'CP_UNAME'              => $userrow["username"],
        'CP_USNAME'             => $userrow["name"],
        'CP_MOD_COMENTS'        => $userrow["modcomment"],
		'CP_FRIENDS'            => $user_friends,
 		'CP_PASSKEY'            => $userrow["passkey"],
 		'CP_TORPERPAGE'         => $userrow["torrent_per_page"],
 		'CP_FOES'               => $user_foe,
		'CP_PM_NOTIVY'          => ($userrow["pm_notify"] == 'true') ? true : false,
		'CP_PM_POPUP'           => ($userrow["pm_popup"] == 'true') ? true : false,
		'CP_ALLOW_MASS_MAIL'    => ($userrow["mass_mail"] == 'yes') ? true : false,
        'CP_UID'                => $userrow["id"],
        'CP_SHOW_ONLINE'        => $userrow["Show_online"],
		'U_BITH_D'              =>  $bday[0],
		'U_BITH_M'              =>  $bday[1],
		'U_BITH_Y'              =>  $bday[2],
		'U_SEEDBOX_IP'          => long2ip($userrow["seedbox"]),
		'U_IS_WARNED'           => ($userrow["warned"]) ? true : false,
		'U_WARNED_TELL'         => ($userrow["warned"]) ? gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])) : '',
		'U_ACTIVATED_ACC'       => ($userrow["active"] == "1") ? true : false,
		'U_SITE_HELPER'         => ($userrow['helper'] == 'true') ? true : false,
		'U_SITE_HELP_WITH'      => $userrow["help_able"],
        'CP_TRUEUPLOADED'       => $userrow["uploaded"],
        'CP_TRUEDOWNLOADED'     => $userrow["downloaded"],
        'CP_INVITES'            => $userrow["invites"],
        'CP_SEED_POINTS'        => $userrow["seedbonus"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
        'CP_UAVATAR'            => gen_avatar($userrow["id"]),
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UWARNED'            => ($userrow["warned"]) ? true : false,
        'CP_UWARNEDTELL'        => gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])),
        'CP_UNICK'              => (!empty($userrow["name"]))? $userrow["name"]: false,
     //   'CP_ULEVEL'             => $ulevel,
        'CP_UCAN_DO'            => $userrow["can_do"],
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
		'S_GROUP_OPTIONS'	    => selectaccess($al= false),
		'S_SHOW_ACTIVITY'		=> true,
		'SIGNATURE'             => $userrow["signature"],
		'LOCATION'		        => $countries,
		'TX_OFF_SET'            => $off_set,
		'U_ALLOW_EMAIL'	        => ($userrow["accept_mail"] == "yes") ? true : false,
		'U_ICQ'				    => (!empty($userrow["icq"])) ? $userrow["icq"] : '',
		'U_AIM'				    => (!empty($userrow["aim"])) ? $userrow["aim"] : '',
		'U_YIM'				    => (!empty($userrow["yahoo"])) ? $userrow["yahoo"] : '',
		'U_MSN'				    => (!empty($userrow["msn"])) ? $userrow["msn"] : '',
		'U_JABBER'			    => (!empty($userrow["jabber"])) ?$userrow["jabber"] : '',
		'U_SKYPE'			    => (!empty($userrow["skype"])) ? $userrow["skype"] : '',
		'U_LANGUAGES'           => $langset,
		'U_THEMES'              => $themeset,
		'ALLOW_AVATAR_UPLOAD'   => $avuploadon,
		'ALLOW_AVATAR_LINK'     => $avremoteon,
		'ALLOW_AVATAR_GALORY'   => $avgalon,
		'ALLOW_AVATAR'          => $avon,
		'AVATAR_MAXHT'          => $avmaxht,
		'AVATAR_MAXWT'          => $avmaxwt,
		'AVATAR_MAXSZ'          => mksize($avmaxwt),
		'AVATAR_MAXSZ_SEL'      => $galery,
        'ACTION'                => (isset($action)) ? $action : '',
		'ALLOW_EMAIL_CHANGE'    => $emaileditecf,
        'MODE'                  => $mode,
		'A_GROUP'               => selectaccess($userrow["can_do"]),
		'A_LEVEL'               => $adminlevel,
		'U_BOOK'                => $userrow["book"],
		));
$template->assign_var('S_IN_UCP', true);

$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
echo $template->fetch('ucp_edit_profile.html');
if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
$ip = getip();
        $sql = "UPDATE ".$db_prefix."_users SET lastip = '".sprintf("%u",ip2long($ip))."', lasthost = '".gethostbyaddr($ip)."', lastpage = '".addslashes(str_replace("/", '',$_SERVER['REQUEST_URI']))."', lastlogin = NOW() WHERE id = '".$user->id."';";
        $db->sql_query($sql);
}
include_once("include/cleanup.php");
ob_end_flush();
die();
?>