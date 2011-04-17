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
if (!defined('IN_PMBT'))die("You can't access this file directly");
include_once'include/class.template.php';
require_once("include/actions.php");
require_once("include/torrent_functions.php");
if(!$user->user){
header("Location: ".$siteurl."/login.php");
die();
 }
if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}
$id = intval(request_var('id', ''));
$username = $db->sql_escape(request_var('username', ''));
$p1 = request_var('p1', '');
$p2 = request_var('p2', '');
$p3 = request_var('p3', '');
$p4 = request_var('p4', '');
if (!isset($p1) OR !is_numeric($p1) OR $p1 < 1) $p1 = 1;
if (!isset($p2) OR !is_numeric($p2) OR $p2 < 1) $p2 = 1;
if (!isset($p3) OR !is_numeric($p3) OR $p3 < 1) $p3 = 1;
if (!isset($p4) OR !is_numeric($p4) OR $p4 < 1) $p4 = 1;
if (!$user->premium) $passwhere = " AND T.password IS NULL ";
else $passwhere = "";
if (isset($id) AND $id != 0 AND is_numeric($id)) {
        $sql_profile = "SELECT count(F.id)AS forumposts,U.id AS id, U.warn_kapta AS warn_kapta, U.warn_hossz AS warn_hossz, U.can_shout AS can_shout, U.username AS username, U.name AS name, U.tzoffset AS tzoffset, U.level AS level, U.regdate AS regdate, U.email AS email, U.avatar AS avatar, U.lastlogin AS lastlogin, U.lastip AS lastip, U.lasthost AS lasthost, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded as ratio, U.accept_mail AS accept_mail, U.active AS active, U.aim AS aim, U.icq AS icq, U.msn AS msn, U.yahoo AS yahoo, U.invited_by AS invited_by, U.invitees AS invitees, U.invites AS invites, U.invitedate AS invitedate, U.warned AS warned, U.country AS country, U.seedbonus AS seedbonus, U.hitruns AS hitruns, U.can_do AS can_do, U.helper AS helper, U.help_able AS help_able, U.client as client, U.signature as signature, U.birthday as birthday, U.ban as ban FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid where U.id = '".$id."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.id = '".$id."' ".$passwhere." ORDER BY T.added DESC;";
} elseif (isset($username) AND $username != "") {
        $sql_profile = "SELECT count(F.id)AS forumposts,U.id AS id, U.warn_kapta AS warn_kapta, U.warn_hossz AS warn_hossz ,U.can_shout AS can_shout, U.username AS username, U.name AS name, U.tzoffset AS tzoffset, U.level AS level, U.regdate AS regdate, U.email AS email, U.avatar AS avatar, U.lastlogin AS lastlogin, U.lastip AS lastip, U.lasthost AS lasthost, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded AS ratio, U.accept_mail AS accept_mail, U.active AS active, U.aim AS aim, U.icq AS icq, U.msn AS msn, U.yahoo AS yahoo, U.invited_by AS invited_by, U.invitees AS invitees, U.invites AS invites, U.invitedate AS invitedate, U.warned AS warned, U.country AS country, U.seedbonus AS seedbonus, U.hitruns AS hitruns, U.can_do AS can_do, U.helper AS helper, U.help_able AS help_able, U.client as client, U.signature as signature, U.birthday as birthday, U.ban as ban FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid where U.username = '".$username."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.username = '".$username."' ".$passwhere." ORDER BY T.added DESC;";
}else{
        $sql_profile = "SELECT count(F.id)AS forumposts,U.id AS id, U.warn_kapta AS warn_kapta, U.warn_hossz AS warn_hossz ,U.can_shout AS can_shout, U.username AS username, U.name AS name, U.tzoffset AS tzoffset, U.level AS level, U.regdate AS regdate, U.email AS email, U.avatar AS avatar, U.lastlogin AS lastlogin, U.lastip AS lastip, U.lasthost AS lasthost, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded AS ratio, U.accept_mail AS accept_mail, U.active AS active, U.aim AS aim, U.icq AS icq, U.msn AS msn, U.yahoo AS yahoo, U.invited_by AS invited_by, U.invitees AS invitees, U.invites AS invites, U.invitedate AS invitedate, U.warned AS warned, U.country AS country, U.seedbonus AS seedbonus, U.hitruns AS hitruns, U.can_do AS can_do, U.helper AS helper, U.help_able AS help_able, U.client as client, U.signature as signature, U.birthday as birthday, U.ban as ban FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid where U.id = '".$user->id."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.id = '".$user->id."' ".$passwhere." ORDER BY T.added DESC;";
}
$res = $db->sql_query($sql_profile) OR btsqlerror($sql_profile);
if ($db->sql_numrows($res) < 1) bterror(_btusernoexist,_btuserprofile);
$userrow = $db->sql_fetchrow($res);
// Country code
$sql = ("SELECT name,flagpic FROM ".$db_prefix."_countries WHERE id='".$userrow['country']."' LIMIT 1");
$res = $db->sql_query($sql) OR btsqlerror($sql);
if ($db->sql_numrows($res) == 1) 
{
  $arr = $db->sql_fetchrow($res);
  $country = $arr[name];
  $flag = $arr[flagpic];
}
if($user->admin AND isset($mode) AND $mode == 'switch_perm'){
setcookie("bttestperm",$userrow["can_do"],time() + 31536000,$cookiepath,$cookiedomain,0);
header("Location: ".$siteurl."/user.php?op=profile&id=".$userrow["id"]);
die();
}
if($user->admin AND isset($mode) AND $mode == 'return_perm'){
setcookie("bttestperm",'',time() - 31536000,$cookiepath,$cookiedomain,0);
header("Location: ".$siteurl."/user.php?op=profile&id=".$userrow["id"]);
die();
}
$template = & new Template();
set_site_var('Viewing profile Of: '.$userrow["username"]);
switch ($userrow["level"]) {
        case "banned": {
                $ulevel =  _btclassbanned;
                break;
        }
        case "user": {
                $ulevel =  _btclassuser;
                break;
        }
        case "moderator": {
                $ulevel =  _btclassmoderator;
                break;
        }
        case "premium": {
                $ulevel =  _btclasspremium;
                break;
        }
        case "admin": {
                $ulevel =  _btclassadmin;
                break;
        }
}
$sqlbook = "SELECT slave FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$user->id."' AND slave = '".$userrow["id"]."';";
$sqlblack = "SELECT slave FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$userrow["id"]."';";
$resbook = $db->sql_query($sqlbook) or btsqlerror($sqlbook);
$resblack = $db->sql_query($sqlblack) or btsqlerror($sqlblack);
$sqlublack = "SELECT slave FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$userrow["id"]."' AND slave = '".$user->id."';";
$resublack = $db->sql_query($sqlublack) or btsqlerror($sqlublack);
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
$sql = 'SELECT count( `tid` ) AS thanks
FROM `torrent_thanks`
WHERE `uid` =\''.$userrow["id"].'\';';
$res = $db->sql_query($sql) OR btsqlerror($sql);
$thanks = $db->sql_fetchrow($res);
$sql = 'SELECT count( `id` ) AS tcoments
FROM `torrent_comments`
WHERE `user` =\''.$userrow["id"].'\';';
$res = $db->sql_query($sql) OR btsqlerror($sql);
$tcoments = $db->sql_fetchrow($res);
//echo $most_in_f['posts'];
		$memberdays = max(1, round((time() - sql_timestamp_to_unix_timestamp($userrow["regdate"])) / 86400));
		$posts_per_day = $userrow["forumposts"] / $memberdays;
		$percentage = ($post_count['num']) ? min(100, ($userrow["forumposts"] / $post_count['num']) * 100) : 0;
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 600;
$dt = date("Y-m-d H:i:s", $dt1);
$online = ($userrow['lastlogin'] > $dt ?  'on' : 'off');
$signature = format_comment($userrow["signature"]);
parse_smiles($signature);
	if (($userrow['accept_mail'] == 'yes') || checkaccess('can_view_others_email'))
	{
		$email = pic("icon_mail.gif","mailto:".$userrow["email"]);
	}
	else
	{
		$email = '';
	}
$l_active_pct = ($user->user && $userrow["id"] == $user->id) ? '%.2f%% of your posts' : '%.2f%% of user\'s posts';
$active_t_pct = ($userrow["forumposts"]) ? ($most_in['posts'] / $userrow["forumposts"]) * 100 : 0;
$active_f_pct = ($userrow["forumposts"]) ? ($most_in_f['posts'] / $userrow["forumposts"]) * 100 : 0;
$now = getdate(time() - date('Z'));
$template->assign_vars(array(
        'CP_UNAME'              => $userrow["username"],
        'CP_UID'                => $userrow["id"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
        'CP_UAVATAR'            => gen_avatar($userrow["id"]),
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UWARNED'            => ($userrow["warned"]) ? true : false,
        'CP_UWARNEDTELL'        => gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])),
        'CP_UNICK'              => (!empty($userrow["name"]))? $userrow["name"]: false,
        'CP_ULEVEL'             => $ulevel,
		'UPERMSET'              => (isset($_COOKIE["bttestperm"])) ? 'return_perm' : 'switch_perm',
        'CP_UCAN_DO'            => $userrow["can_do"],
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
        'CP_UREGDATE'           => formatTimeStamp($userrow["regdate"]),
        'CP_ULASTSEEN'          => formatTimeStamp($userrow["lastlogin"]),
        'CP_ONLINE'             => $online,
		'CP_POST_COUNT'         => $userrow["forumposts"],
		'POSTS_DAY'             => sprintf('%.2f posts per day', $posts_per_day),
		'POSTS_PCT'             => sprintf('%.2f%% of all posts', $percentage),
		'ACTIVE_FORUM'			=> $active_f_name['name'],
		'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in_f['posts']),
		'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
		'ACTIVE_TOPIC'			=> $active_t_name['subject'],
		'ACTIVE_TOPIC_POSTS'	=> ($most_in['posts'] == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in['posts']),
		'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
		'U_ACTIVE_FORUM'		=> './forums.php?action=viewforum&forumid='.$active_t_name['forumid'],
		'U_ACTIVE_TOPIC'		=> './forums.php?action=viewtopic&topicid='.$most_in['id'],
		'S_GROUP_OPTIONS'	    => selectaccess($al= false),
		'S_SHOW_ACTIVITY'		=> true,
		'SIGNATURE'             => $signature,
		'U_ADD_FRIEND'		    => ($userrow["id"] != $user->id) ? ((!$db->sql_numrows($resbook)) ? "pm.php?op=bookmark&id=".$userrow["id"] : '') : '',
		'U_ADD_FOE'			    => (!$db->sql_numrows($resblack)) ? "pm.php?op=blacklist&id=".$userrow["id"] : '',
		'U_REMOVE_FRIEND'	    => ($db->sql_numrows($resbook)) ? "pm.php?op=removebookmark&id=".$userrow["id"] : '',
		'U_REMOVE_FOE'		    => ($db->sql_numrows($resblack)) ? "pm.php?op=removeblacklist&id=".$userrow["id"] : '',
		'LOCATION'		        => (!$userrow["country"] == 0) ? "<img src=\"images/flag/".$flag."\" alt=\"$country\">" : '',
		'U_EMAIL'		        => $email,
		'T_THANKS'		        => $thanks['thanks'],
		'T_COMMENTS'	        => $tcoments['tcoments'],
		'U_IP'                  =>  (checkaccess('see_ip'))? '<a href="javascript:popUp(\'whois.php?ip='.$userrow['lastip'].'\')">'.long2ip($userrow['lastip']).'</a>' : '',
		'U_IP_HOST'             =>  (checkaccess('see_ip'))? $userrow['lasthost'] : '',
		'U_PM'				    => (!$db->sql_numrows($resublack)) ? pic("pm_write.png","pm.php?op=send&to=".$userrow["id"],_btpmnewmsg) : '',
		'U_ICQ'				    => (!empty($userrow["icq"])) ? pic("button_icq.gif","http://www.icq.com/whitepages/wwp.php?to=".$userrow["icq"]) : '',
		'U_AIM'				    => (!empty($userrow["aim"])) ? pic("button_aim.gif","aim:goim?screenname=".$userrow["aim"]).$userrow["aim"] : '',
		'U_YIM'				    => (!empty($userrow["yahoo"])) ? pic("button_yahoo.gif","http://edit.yahoo.com/config/send_webmesg?.target=".$userrow["yahoo"]) : '',
		'U_MSN'				    => (!empty($userrow["msn"])) ? pic("button_msn.gif","http://members.msn.com/".$userrow["msn"]) : '',
		'U_JABBER'			    => (!empty($userrow["jabber"])) ? pic("button_jabber.gif",null,$userrow["jabber"]) : '',
		'U_SKYPE'			    => (!empty($userrow["skype"])) ? pic("button_yahoo.gif","http://edit.yahoo.com/config/send_webmesg?.target=".$userrow["yahoo"]) : '',
		'AGE'				    => ($age = (int) substr($userrow['birthday'], -4)) ? ($now['year'] - $age) : '',
		'RANK_IMG'              => '<img src="themes/' . $theme . '/pics/group/' . $userrow["can_do"] . '.png" title="' . $userrow["can_do"] . '" alt="' . $userrow["can_do"] . '">',
		'U_BAN_USER'            => (checkaccess('banusers'))? (($userrow["ban"] == '0') ? '<a href="modcp.php?op=addban&amp;username=' . $userrow["username"] . '">' . _btuserban .  '</a>' : '<a href="modcp.php?op=delban&amp;uid=' . $userrow["id"] . '">' . _btuserunban .  '</a>') :'',
		'U_BAN_SHOUTS'          => (checkaccess('bann_shouts'))? (($userrow["can_shout"] == 'true') ? '<a href="user.php?op=banchat&amp;id=' . $userrow["id"] . '">' . _btusershoutban . '</a>' : '<a href="user.php?op=unbanchat&amp;id=' . $userrow["id"] . '">' . _btusershoutunban . '</a>') : '',
		));
$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
if (!$user->moderator) $ownertype = "AND ownertype = 0";
else $ownertype = "";

$from = ($p1 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE banned = 'no' AND owner = '".$userrow["id"]."' ".$ownertype.";";
$totres = $db->sql_query($totsql);
list ($tot) = $db->sql_fetchrow($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT ".$db_prefix."_torrents.*, IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level, U.can_do as can_do FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id WHERE banned = 'no' AND owner = '".$userrow["id"]."' ".$ownertype." ORDER BY ".$db_prefix."_torrents.added DESC LIMIT ".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYU'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p1=', $p1, $pages, $cat = false, '', '', $extra = 'MYU');
                $template->assign_vars(array(
                        'S_TORRENTSMYU'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'myu');
}
$db->sql_freeresult($res);
unset($res, $row, $sql);
$from = ($p2 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(DISTINCT torrent) AS tot FROM ".$db_prefix."_peers WHERE uid = '".$userrow["id"]."' AND seeder = 'yes';";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->sql_fetchrow($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT P.uid, T.*, IF(T.numratings < '".$minvotes."', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level, U.can_do as can_do FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_torrents T ON P.torrent = T.id LEFT JOIN ".$db_prefix."_categories C ON category = C.id LEFT JOIN ".$db_prefix."_users U ON P.uid = U.id WHERE banned = 'no' AND P.uid = '".$userrow["id"]."' AND P.seeder = 'yes' ORDER BY T.added DESC LIMIT ".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYS'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p2=', $p2, $pages, $cat = false, '', '', $extra = 'MYS');
                $template->assign_vars(array(
                        'S_TORRENTSMYS'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'mys');
}
$db->sql_freeresult($res);
unset($res);
$from = ($p3 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(DISTINCT torrent) AS tot FROM ".$db_prefix."_peers WHERE uid = '".$userrow["id"]."' AND seeder = 'no';";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->sql_fetchrow($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT P.uid, T.*, IF(T.numratings < '".$minvotes."', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level, U.can_do as can_do FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_torrents T ON P.torrent = T.id LEFT JOIN ".$db_prefix."_categories C ON category = C.id LEFT JOIN ".$db_prefix."_users U ON P.uid = U.id WHERE banned = 'no' AND P.uid = '".$userrow["id"]."' AND P.seeder = 'no' ORDER BY T.added DESC LIMIT ".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYL'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p3=', $p3, $pages, $cat = false, '', '', $extra = 'MYL');
                $template->assign_vars(array(
                        'S_TORRENTSMYL'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'myl');
}
$db->sql_freeresult($res);
unset($res);
echo $template->fetch('ucp_profile.html');
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
@include_once("include/cleanup.php");
ob_end_flush();
die();
?>