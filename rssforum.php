<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
require_once("include/config_lite.php");
require_once("include/functions.php");

     define( 'IN_PHPBB', true );
    $phpbb_root_path = './phpBB3test2/'; // change in your own root path.
    $phpEx = substr(strrchr(__FILE__, '.'), 1);
    include($phpbb_root_path . 'common.' . $phpEx);
    include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
    include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
    
    $user->session_begin();
    $auth->acl( $user->data );
    $user->setup();
$read_topic = true;
	global $db, $config, $template, $SID, $_SID, $user, $auth;

// select information for topic from the topics_tracking table
if ($tracking_row['mark_time'] < $topic_row['last_post_time'])
{
  $read_topic = false;
}

// select information for forum containing topic from the forums_tracking table, store in $tracking_row
if ($tracking_row['mark_time'] < $topic_row['last_post_time'])
{
  $read_topic = false;
}

    //-- Fetch the data from the specified fora
    $bbcode = new bbcode();
    $news_fora_id = array( '6','2','3','4','5','15' ); // Change in the fora id's you need
    
    $topic_count = '10'; // Change in the number of topics you want to show.
    $query = "
        SELECT p.topic_id, p.forum_id, p.post_time, p.post_subject, p.post_text, p.bbcode_bitfield, p.bbcode_uid,
            u.user_id, u.user_email, u.username, u.user_posts, u.user_rank, u.user_colour, u.user_allow_viewonline, u.user_allow_viewemail,
            t.topic_title,
                (
                    SELECT COUNT( post_id )
                    FROM " . POSTS_TABLE . "
                        WHERE topic_id = p.topic_id
                ) AS aantal_posts
        FROM " . POSTS_TABLE . " AS p, " . USERS_TABLE . " AS u, " . TOPICS_TABLE . " AS t
            WHERE u.user_id = p.poster_id
                AND t.topic_id = p.topic_id
        GROUP BY topic_id
        ORDER BY t.topic_time DESC
        LIMIT 0, {$topic_count} 
    ";
    $result = $db->sql_query( $query );
                $descr = "The Latest 10 Posts on ".$sitename." Forum";
$rss = '';
$rss .= '<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"><link rel="shortcut icon" href="themes/vista/favicon.ico" type="image/x-icon" /><?xml-stylesheet type="text/css" href="./styles/prosilver/theme/stylesheet.css"?>
<link rel="shortcut icon" href="'.$siteurl.'/images/favicon.gif" type="image/x-icon" />
 <channel>
 <link rel="shortcut icon" href="'.$siteurl.'/images/favicon.gif" type="image/x-icon" />

    <title>'.htmlspecialchars($config['sitename']).'</title>
				<image>

						<title>'.$config['sitename'].'</title>
	<url>'.$siteurl.'/themes/vista/pics/mgm_header.bmp</url>
						<link>'.htmlspecialchars($config['server_protocol'].$config['server_name']).'</link>
					</image>    
    <link>'.htmlspecialchars($config['server_protocol'].$config['server_name']).'/</link>
    <description>'.htmlspecialchars($config['site_desc']).'</description>
    <language>en-us</language>';

    while( $row = $db->sql_fetchrow($result) )
    {
	$sql_view ="SELECT * FROM " . TOPICS_TABLE . " 
	WHERE topic_id = ". $row['topic_id'] . "";
$res_views = $db->sql_query($sql_view);
$row_views = $db->sql_fetchrow($res_views);
	$sql_tracking ="SELECT * FROM " . TOPICS_TRACK_TABLE . " 
	WHERE topic_id = ". $row['topic_id'] . "";
$tracking_views = $db->sql_query($sql_tracking);
$tracking_row = $db->sql_fetchrow($tracking_views);
	$sql_session ="SELECT * FROM " . SESSIONS_TABLE . " 
	WHERE session_user_id = ". $user->data['user_id'] . "";
$res_session = $db->sql_query($sql_session);
$row_session = $db->sql_fetchrow($res_session);
		$last_visit_time = (!empty($row['session_time'])) ? $row['session_time'] : $row['user_lastvisit'];
// assume topic is read
$read_topic = true;

// select information for topic from the topics_tracking table
if ($tracking_row['mark_time'] < $row_views['last_post_time'])
{
  $read_topic = false;
}
if ($last_visit_time < $row_views['last_post_time'])
{
  $read_topic = false;
}
        // Parse the message and subject
        $message = censor_text($row['post_text']);

        // Second parse bbcode here
        if ($row['bbcode_bitfield'])
        {
            $bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
        }
        $message = smiley_text($message);
		$message = str_replace($phpbb_root_path,'./',$message);//fix for smiles
		$message = str_replace('<dl class="codebox"><dt>Code: <a href="#" onclick="selectCode(this); return false;">Select all</a></dt><dd><code>','',$message);//fix for smiles
		$message = str_replace('</code></dd></dl>','',$message);//fix for smiles
		$fids = $row['forum_id'];
        $ids = $row["topic_id"];
        $names = censor_text($row['post_subject']);
        $replies = $row['aantal_posts']-1;
        $views = $row_views['topic_views'];
		$last_post = $row_views['topic_last_post_id'];
		$last_poster = $row_views['topic_last_poster_name'];
		$last_poster_id = $row_views['topic_last_poster_id'];
		$last_poster_time = $row_views['topic_last_poster_time'];
        $url_link = $config['server_protocol'].$config['server_name'].'/phpBB.php?page=viewtopic&amp;';
		$topic_read = (!$read_topic) ? $user->img('topic_unread', 'NEW_POSTS') : $user->img('topic_read', 'NO_NEW_POSTS');

        // Send data to output var
        $descrption = htmlspecialchars($topic_read) .'&lt;br /&gt;&lt;font size="3"&gt;&lt;b&gt;Replies:&lt;/b&gt;&lt;/font&gt; '.$replies .'&lt;br /&gt;
		&lt;font size="3"&gt;&lt;b&gt;Views:&lt;/b&gt;&lt;/font&gt; '.$views .'&lt;br /&gt;
		&lt;font size="3"&gt;&lt;b&gt;Last Post By:&lt;/b&gt;&lt;/font&gt; &lt;a href="'.$config['server_protocol'].$config['server_name'].'/phpBB.php?page=memberlist&amp;mode=viewprofile&amp;u=' . $last_poster_id . '"&gt;' . $last_poster .'&lt;/a&gt;
		&lt;a href="'.$config['server_protocol'].$config['server_name'].'/phpBB.php?page=viewtopic&amp;f='.$row['forum_id'].'&amp;t='.$row["topic_id"].'&amp;p='.$last_post.'#p'.$last_post.'"&gt;&lt;img src="'.$config['server_protocol'].$config['server_name'].'/styles/prosilver/imageset/icon_topic_latest.gif" width="11" height="9" alt="View the latest post" title="View the latest post" /&gt;&lt;/a&gt;&lt;b&gt; ON: '.$user->format_date($last_poster_time).'&lt;/b&gt;&lt;br /&gt;
		&lt;font size="3"&gt;&lt;b&gt;Topic By:&lt;/b&gt;&lt;/font&gt; &lt;a href="'.$config['server_protocol'].$config['server_name'].'/phpBB.php?page=memberlist&amp;mode=viewprofile&amp;u=' . $row['user_id'] . '"&gt;' . $row['username'] .'&lt;/a&gt;&lt;b&gt; ON: '.$user->format_date($row['post_time']).'&lt;/b&gt;&lt;br /&gt;'. htmlspecialchars($message);

$rss .= '
      <item>
      <title>'.htmlspecialchars($names).'</title>
      <link>'.$url_link.'f='.$fids.'&amp;t='.$ids.'</link>
      <guid>'.$url_link.'f='.$fids.'&amp;t='.$ids.'</guid>
      <description>'. $descrption .'</description>
	  <dc:creator>'.$row['username'].'</dc:creator>
    </item>';
      }
$rss .='
</channel>
</rss>';
echo($rss);
?>