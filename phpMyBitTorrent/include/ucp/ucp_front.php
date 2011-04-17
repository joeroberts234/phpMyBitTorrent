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
* @version $Id: ucp_front.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
$sql_profile = "SELECT U.* , count(F.id)AS forumposts, F.added as fadded FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid where U.id ='".$uid."' GROUP BY U.id LIMIT 1;";
$res_profile = $db->sql_query($sql_profile)OR btsqlerror($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
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
while($row = $db->sql_fetchrow($res))
$t_post_in[] = $row['id'];

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
$template->assign_vars(array(
        'CP_UID'				=> $uid,
		'CP_UREGDATE'           => formatTimeStamp($userrow["regdate"]),
        'CP_ULASTSEEN'          => formatTimeStamp($userrow["lastlogin"]),
		'CP_POST_COUNT'         => $userrow["forumposts"],
		'POSTS_DAY'             => sprintf('%.2f posts per day', $posts_per_day),
		'POSTS_PCT'             => sprintf('%.2f%% of all posts', $percentage),
		'ACTIVE_FORUM'			=> (isset($active_f_name['name'])) ? $active_f_name['name'] : '',
		'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 0) ? sprintf('%d Post', 0) :($active_f_count == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in_f['posts']),
		'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
		'ACTIVE_TOPIC'			=> (isset($active_t_name['subject'])) ? $active_t_name['subject'] : '',
		'ACTIVE_TOPIC_POSTS'	=> (isset($most_in['posts'])) ? ($most_in['posts'] == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in['posts']) : '',
		'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
		'U_ACTIVE_FORUM'		=> (isset($active_t_name['forumid'])) ? './forums.php?action=viewforum&forumid='.$active_t_name['forumid'] : '',
		'U_ACTIVE_TOPIC'		=> (isset($most_in['id'])) ? './forums.php?action=viewtopic&topicid='.$most_in['id'] : '',
		));
?>