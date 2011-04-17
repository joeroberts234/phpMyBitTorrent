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
* @version $Id: drafts.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*TOTAL_TOPICS
*/
        if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
	$hidden = build_hidden_fields(array(
	"op"		=> "editprofile",
	"take_edit"		=> "1",
	"action" 		=> 'overview',
	"mode"			=> 'subscribed'
	));
				$template->assign_vars(array(
				'topicrow' => false,
				'L_TITLE'     => 'Watched forums',
				'S_TORRENT_NOTIFY'		=> true,
				'S_FORUM_NOTIFY'		=> true,
				'S_TOPIC_NOTIFY'		=> true,
				'S_HIDDEN_FIELDS'		=> $hidden
));
	$sql = "SELECT `torrent`, `user`, `status`FROM `".$db_prefix."_comments_notify` WHERE `user` = '".$uid."' ;"; 
	$res = $db->sql_query($sql) or btsqlerror($sql);
	if ($db->sql_numrows($res) >= 1) {
				$template->assign_vars(array(
				'S_TORRENT_NOTIFY'		=> true,
				));
	while($dcont = $db->sql_fetchrow($res)){
				$torrent = '';
						$sql_t = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, 
						A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, 
						A.password, A.imdb, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, 
						A.numratings, A.name, 
						IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, 
						A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, 
						A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, 
						A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, 
						B.name AS cat_name, B.image AS cat_pic, IF(C.name IS NULL, C.username, C.name) as ownername, 
						A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$dcont['torrent']."' GROUP BY A.id LIMIT 1;";
						$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
						$torrent = $db->sql_fetchrow($res_t);
						$db->sql_freeresult($res_t);
								if (can_download($user,$torrent)) {
						        $can_access = true;
								} else {
						        $can_access = false;
								}
                        if (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$torrent["cat_pic"]))
                                $cat_pics = "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
                                elseif (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("cat_pics/".$torrent["cat_pic"]))
                                $cat_pics = "<img border=\"0\" src=\"cat_pics/" . $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
                        else
                                $cat_pics = $torrent["cat_name"];
				$template->assign_block_vars('torrentrow',array(
				'TORRENT_ID'     => $dcont['torrent'],
				'STATUS'		 => $dcont['status'],
				'CAT_IMG'		 => $cat_pics,
				'TORRENT_NAME'	 => $torrent['name'],
				'U_TORFORUM'	 => $siteurl.'/details.php?id='.$dcont['torrent'].'&hit',
				'DATE_ADDED'	 => format_date2(sql_timestamp_to_unix_timestamp($torrent['added'])),
				'LAST_SEEDER'    => ($torrent['tracker'] != "")? '' : format_date2(sql_timestamp_to_unix_timestamp($torrent['lastseed'])),
				'CAN_DOWNLOAD'	 => can_download($user, $torrent),
				'CAN_EDIT'	 	 => ($torrent["owner"] == $user->id AND checkaccess("edit_own_torrents"))? true : checkaccess("can_edit_others_torrents")? true : false,
				'CAN_DELETE'	 => ($torrent["owner"] == $user->id AND checkaccess("edit_own_torrents"))? true : checkaccess("can_edit_others_torrents")? true : false,
				'CAN_BAN'		 => checkaccess("bann_torrents"),
				'TRACKER'		 => ($torrent["tracker"]!= "")? $torrent["tracker"] : false
				));
	}
	}//else				$template->assign_block_vars('torrentrow',array());
				$sql = "SELECT *
				FROM `".$db_prefix."_bookmarks`
				WHERE `user_id` =".$uid.";";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	$posts = $db->sql_numrows($res);
	if ($posts > 0) {
	include_once('themes/'.$theme.'/forums/main.php');
	while($top = $db->sql_fetchrow($res)){
		$topic_id = $top['topic_id'];
				$template->assign_vars(array(
				'S_TOPIC_NOTIFY'		=> true,
				));
			$sql_t = "SELECT `userid` , `subject` , `locked` , `forumid` , `lastpost` , `moved` , `sticky` , `views`
			FROM `".$db_prefix."_forum_topics`
			WHERE `id` = ". $topic_id ."
			LIMIT 1";
			$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
			list ($topic_auth, $topic_title, $locked, $forum_id, $last_pid, $moved, $sticky, $views) = $db->sql_fetchrow($res_t);
			$forumname = $db->sql_fetchrow($db->sql_query("SELECT `name`as name FROM `torrent_forum_forums` WHERE `id` = $forum_id"));
			$sql_p = "SELECT *
			FROM `torrent_forum_posts`
			WHERE `topicid` =". $topic_id ."
			ORDER BY `torrent_forum_posts`.`added` ASC";
			$res_p = $db->sql_query($sql_p) or btsqlerror($sql_p);
			$start = $last_post = 0;
			$posts_t = $db->sql_numrows($res_p);
			while($top_p= $db->sql_fetchrow($res_p)){
			if($start == 0)$start = sql_timestamp_to_unix_timestamp($top_p['added']);
			if($last_post < sql_timestamp_to_unix_timestamp($top_p['added'])){
			$last_post = sql_timestamp_to_unix_timestamp($top_p['added']);
			$last_auth = $top_p['userid'];
			}
			}
				$template->assign_block_vars('topicrow',array(
				'PAGINATION'	=> generate_pagination('forums.php?action=viewtopic&topicid='.$forum_id,$posts_t,15,1,false),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts_t == 1) ? VIEW_FORUM_TOPIC : sprintf(VIEW_FORUM_TOPICS, $posts_t),
						'FORUM_ID'					=> $forum_id,
						'TOPIC_ID'					=> $topic_id,
						'TOPIC_AUTHOR'				=> username_is($topic_auth),
						'TOPIC_AUTHOR_COLOUR'		=> getusercolor(getlevel_name($topic_auth)),
						'TOPIC_AUTHOR_FULL'			=> username_is($topic_auth),
						'FIRST_POST_TIME'			=> $last_post,
						'LAST_POST_SUBJECT'			=> $topic_title,
						'LAST_POST_TIME'			=> format_date2($last_post),
						'LAST_VIEW_TIME'			=> format_date2($last_post),
						'LAST_POST_AUTHOR'			=> username_is($topic_auth),
						'LAST_POST_AUTHOR_COLOUR'	=> getusercolor(getlevel_name($topic_auth)),
						'LAST_POST_AUTHOR_FULL'		=> username_is($last_auth),
						'TOPIC_TITLE'				=> $topic_title,
						'TOPIC_TYPE'				=> $moved,

						'TOPIC_FOLDER_IMG'		=> '',
						'TOPIC_FOLDER_IMG_SRC'	=> '',
						'ATTACH_ICON_IMG'		=> '',
						'S_UNREAD_TOPIC'		=> '',
						'S_GLOBAL_TOPIC'		=> (!$forum_id) ? true : false,
						'LAST_POST_IMG'			=> '<img border="0" alt="Last" src="themes/eVo_blue/forums/icon_topic_latest.gif">',

						'S_USER_POSTED'		=> (!empty($row['topic_posted']) && $row['topic_posted']) ? true : false,
						'S_UNREAD'			=> '',

						'U_TOPIC_AUTHOR'		=> username_is($topic_auth),
						'U_LAST_POST'			=> $siteurl."/forums.php?action=viewtopic&topicid=$topic_id&page=last#last",
						'U_LAST_POST_AUTHOR'	=> username_is($topic_auth),
						'U_NEWEST_POST'			=> $siteurl."/forums.php?action=viewtopic&topicid=$topic_id&page=last#last",
						'U_VIEW_TOPIC'			=> $siteurl."/forums.php?action=viewtopic&topicid=$topic_id",
						'U_VIEW_FORUM'			=> $siteurl."/forums.php?action=viewforum&forumid=$forum_id",
						'FORUM_NAME'			=> $forumname[0]
));
}
}//else				$template->assign_block_vars('topicrow',array(0));
		if ($posts)
		{
			$template->assign_vars(array(
				'PAGINATION'	=> generate_pagination($siteurl.'/user.php?op=editprofile',$posts,$torrent_per_page,0),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts == 1) ? VIEW_FORUM_TOPIC : sprintf(VIEW_FORUM_TOPICS, $posts),
			));
		}
		$sql = "SELECT * FROM `".$db_prefix."_forums_watch`
				WHERE `user_id` =".$uid.";";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$forum_w = $db->sql_numrows($res);
	if ($forum_w > 0) {
				$template->assign_vars(array(
				'S_FORUM_NOTIFY'		=> true,
				));
	while($for = $db->sql_fetchrow($res)){
		$forum_id = $for['forum_id'];
		$forumname = $db->sql_fetchrow($db->sql_query("SELECT `name`as name FROM `".$db_prefix."_forum_forums` WHERE `id` = $forum_id"));				
			$sql_t = "SELECT `userid` , `subject` , `locked` , `forumid` , `lastpost` , `moved` , `sticky` , `views`
			FROM `".$db_prefix."_forum_topics`
			WHERE `id` = ". $topic_id ."
			LIMIT 1";
			$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
			list ($topic_auth, $topic_title, $locked, $forum_id_topic, $last_pid, $moved, $sticky, $views) = $db->sql_fetchrow($res_t);
			$sql_p = "SELECT *
			FROM `torrent_forum_posts`
			WHERE `topicid` =". $topic_id ."
			ORDER BY `torrent_forum_posts`.`added` ASC";
			$res_p = $db->sql_query($sql_p) or btsqlerror($sql_p);
			$start = $last_post = 0;
			$posts_t = $db->sql_numrows($res_p);
			$start = $last_post = 0;
			while($top_p= $db->sql_fetchrow($res_p)){
			if($start == 0)$start = sql_timestamp_to_unix_timestamp($top_p['added']);
			if($last_post < sql_timestamp_to_unix_timestamp($top_p['added'])){
			$last_post = sql_timestamp_to_unix_timestamp($top_p['added']);
			$last_auth = $top_p['userid'];
			}
			}
		$template->assign_block_vars('forumrow',array(
							'FORUM_ID'				=> $forum_id,
							'FORUM_FOLDER_IMG'		=> '',
							'FORUM_FOLDER_IMG_SRC'	=> '',
							'FORUM_IMAGE'			=> '',
							'FORUM_IMAGE_SRC'		=> '',
							'FORUM_NAME'			=> $forumname['name'],
							'LAST_POST_SUBJECT'		=> $topic_title,
							'LAST_POST_TIME'		=> format_date2($last_post),

							'LAST_POST_IMG'			=> '<img border="0" alt="Last" src="themes/eVo_blue/forums/icon_topic_latest.gif">',
							'LAST_POST_AUTHOR'			=> username_is($last_auth),
							'LAST_POST_AUTHOR_COLOUR'	=> getusercolor(getlevel_name($last_auth)),
							'LAST_POST_AUTHOR_FULL'		=> "<a href=\"".$siteurl."/user.php?op=profile&id=".$last_auth."\" style=\"color: ".getusercolor(getlevel_name($last_auth)).";\" class=\"username-coloured\">".username_is($last_auth)."</a>",
							'U_LAST_POST_AUTHOR'		=> '',

							'U_LAST_POST'			=> $siteurl."/forums.php?action=viewtopic&topicid=$topic_id&page=last#last",
							'U_VIEWFORUM'			=> 'forums.php?action=viewforum&forumid='.$forum_id
));
}
}//else				$template->assign_block_vars('forumrow',array(0));
?>