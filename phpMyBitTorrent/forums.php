<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
include_once("include/forum_config.php");
include_once'themes/'.$theme.'/forums/main.php';
if(!$user->ulanguage == '' && file_exists('language/forum/'.$user->ulanguage.'.php'))include'language/forum/'.$user->ulanguage.'.php';
elseif (file_exists('language/forum/'.$language.'.php'))include_once'language/forum/'.$language.'.php';
else
include_once'language/forum/english.php';
$themedir = "" . $siteurl . "/themes/" . $theme . "/forums/";
if ($user->forumbanned) {
	OpenErrTable(_bt_notice);
	echo _btf_banned;
	CloseErrTable();	
	include'footer.php';
	}else{
if ($FORUMS)
{
//define the clickable smilies
$submit		= (isset($_POST['post'])) ? true : false;
$preview	= (isset($_POST['preview'])) ? true : false;
$save		= (isset($_POST['save'])) ? true : false;
$load		= (isset($_POST['load'])) ? true : false;
$delete		= (isset($_POST['delete'])) ? true : false;
$cancel		= (isset($_POST['cancel']) && !isset($_POST['save'])) ? true : false;
$refresh	= (isset($_POST['add_file']) || isset($_POST['delete_file']) || isset($_POST['cancel_unglobalise']) || $save || $load) ? true : false;
$action		= ($delete && !$preview && !$refresh && $submit) ? 'reply' : request_var('action', '');
if($refresh)$action = 'reply';
include'include/textarea.php';
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
function CutName ($vTxt, $Car) {
	while(strlen($vTxt) > $Car) {
		return substr($vTxt, 0, $Car) . "...";
	} return $vTxt;
}
function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}
function is_booked_marcked($id){
global $db, $db_prefix, $user;
$sql = "SELECT COUNT(`forum_id`) FROM`".$db_prefix."_forums_watch` WHERE `forum_id`='".$id."' AND `user_id`='".$user->id."';";
$arr = $db->sql_query($sql);
$res = $db->sql_fetchrow($arr);
return ($res[0]>=1) ? true : false;
}
function get_topic_title($id){
global $db, $db_prefix;
			        $sql = "SELECT `subject` FROM `".$db_prefix."_forum_topics` WHERE `id`='".$id."' LIMIT 1;";
					$arr = $db->sql_query($sql);
					while ($res = $db->sql_fetchrow($arr)) {
					return $res['subject'];
					}

}


function get_row_count($table, $suffix = "")
{
global $db, $db_prefix;
  if ($suffix)
    $suffix = " $suffix";
  ($r = $db->sql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
  ($a = $db->sql_fetchrow($r)) or die(mysql_error());
  return $a[0];
}
// Mark all forums as read
function catch_up(){ 
global $db, $db_prefix, $user;
	$res = $db->sql_query("SELECT id, lastpost FROM ".$db_prefix."_forum_topics") or forumsqlerr(__FILE__, __LINE__);
	while ($arr = $db->sql_fetchrow($res)) {
		$topicid = $arr["id"];
		$postid = $arr["lastpost"];
		$r = $db->sql_query("SELECT id,lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=".$user->id." AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
		if ($db->sql_numrows($r) == 0){
			$db->sql_query("INSERT INTO ".$db_prefix."_forum_readposts (userid, topicid, lastpostread) VALUES(".$user->id.", $topicid, $postid)") or forumsqlerr(__FILE__, __LINE__);
		}else{
			$a = $db->sql_fetchrow($r);
			if ($a["lastpostread"] < $postid)
			$db->sql_query("UPDATE ".$db_prefix."_forum_readposts SET lastpostread=$postid WHERE id=" . $a["id"]) or forumsqlerr(__FILE__, __LINE__);
		}
	}
}

// Returns the minimum read/write class levels of a forum
function get_forum_access_levels($forumid){ 
global $db, $db_prefix;
	$res = $db->sql_query("SELECT minclassread, minclasswrite, moderator FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
	if ($db->sql_numrows($res) != 1)
		return false;
	$arr = $db->sql_fetchrow($res);
		return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"], "moder" => $arr['moderator']);
}

// Returns the forum ID of a topic, or false on error
function get_topic_forum($topicid) {
global $db, $db_prefix;
    $res = $db->sql_query("SELECT forumid FROM ".$db_prefix."_forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    if ($db->sql_numrows($res) != 1)
      return false;
    $arr = $db->sql_fetchrow($res);
    return $arr[0];
}

// Returns the ID of the last post of a forum
function update_topic_last_post($topicid) {
 global $db, $db_prefix;
   $res = $db->sql_query("SELECT id FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or die("No post found");
    $postid = $arr[0];
    $db->sql_query("UPDATE ".$db_prefix."_forum_topics SET lastpost=$postid WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
}

function get_forum_last_post($forumid)  {
global $db, $db_prefix;
    $res = $db->sql_query("SELECT lastpost FROM ".$db_prefix."_forum_topics WHERE forumid=$forumid ORDER BY lastpost DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
    $postid = $arr[0];
    if ($postid)
      return $postid;
    else
      return 0;
}
function encodehtml($s, $linebreaks = true)
{
  $s = str_replace(array("<",">","\""), array("&lt;","&gt;","&quot;"), str_replace("&", "&amp;", $s));
  if ($linebreaks)
    $s = nl2br($s);
  return $s;
}
//Top forum posts
//Action: New topic
if ($action == "newtopic") {
    $forumid = $_GET["forumid"];
    if (!is_valid_id($forumid)){
		OpenErrTable(_bt_notice);
	echo _btf_invalid_id;
	CloseErrTable();	
	include'footer.php';
	}
	forumheader(_btf_cnt);
    insert_compose_frame($forumid);	
	include'footer.php';
}

///////////////////////////////////////////////////////// Action: POST
if ($action == "post") {
	$forumid = $_POST["forumid"];
	$topicid = $_POST["topicid"];
	if (!is_valid_id($forumid) && !is_valid_id($topicid)){
		OpenErrTable(_bt_notice);
	echo _btf_invalid_id_post;
	CloseErrTable();	
	include'footer.php';
	}
	$newtopic = $forumid > 0;
	$subject = $_POST["subject"];
	if ($newtopic) {
		if (!$subject)
			showerror(_bterror, _btf_must_enter_subject);
		$subject = trim($subject);
		if (!$subject OR $subject == "")
			showerror(_bterror, _btf_must_enter_subject);
		if (strlen($subject) > $max_subject_length)showerror(_bterror, "Subject is limited to $max_subject_length characters.");
	}else{
      $forumid = get_topic_forum($topicid) or die("Bad topic ID");
	}
		$attachment_data = (isset($_POST['attachment_data'])) ? $_POST['attachment_data'] : array();

    ////// Make sure sure user has write access in forum
	$arr = get_forum_access_levels($forumid) or die("Bad forum ID");
      if (!$arr["write"] == "0" AND !in_array($user->group,explode(" ", $arr["write"])) AND !in_array($user->id,explode(" ", $arr["moder"])) AND !$user->admin)
		showerror(_bterror, "<p><i>You are not permitted to post in this forum.</i></p>\n");
	$body = trim($_POST["body"]);
	if (!$body)
		showerror(_bterror, "No body text.");
		if (strlen($body) > $max_post_length)showerror(_bterror, "Post's are limited to $max_post_length characters.");
	$userid = $user->id;

	if ($newtopic) { //Create topic
	    $subject2 = $db->sql_escape(stripslashes($subject));
		$subject = $db->sql_escape(stripslashes($subject));
		$db->sql_query("INSERT INTO ".$db_prefix."_forum_topics (userid, subject, forumid) VALUES ('".$userid."', '".$subject."', '".$forumid."')") or forumsqlerr(__FILE__, __LINE__);
		$topicid = $db->sql_nextid() or die("No topic ID returned");
		$mesg = '/notice *[color='.getusercolor($user->group).']'.$user->name.'[/color] Posted Thread [url='.$siteurl.'/forums.php?action=viewtopic&topicid='.$topicid.']'.$subject2.'[/url]*';
		if($shout_new_topic)$db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('".$user->id."', '".$mesg."', NOW());");

	}else{
		//Make sure topic exists and is unlocked
		$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
		$arr = $db->sql_fetchrow($res) or die("Topic id n/a");
		if ($arr["locked"] == 'yes' AND !checkaccess("modforum"))
			showerror("Topic Locked", "Topic is loced you can not post to it");
		//Get forum ID
		$forumid = $arr["forumid"];
		$topic_owner = $arr["user_id"];
    }

    //Insert the new post
    $body = $db->sql_escape(stripslashes($body));
    $db->sql_query("INSERT INTO ".$db_prefix."_forum_posts (topicid, userid, added, body) VALUES($topicid, $userid, NOW(), '".$body."')") or forumsqlerr(__FILE__, __LINE__);
    $postid = $db->sql_nextid() or die("Post id n/a");
			$mesg = '/notice *[color='.getusercolor($user->group).']'.$user->name.'[/color] replied to the thread [url='.$siteurl.'/forums.php?action=viewtopic&topicid='.$topicid.'&page=last#'.$postid.']'.$arr["subject"].'[/url]*';
		if($shout_new_post && !$newtopic)$db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('".$user->id."', '".$mesg."', NOW());");

	if(sizeof($attachment_data)){
	$i=0;
		foreach($attachment_data as $data => $val)
		{
				$attach_sql = array(
					'post_msg_id'		=> $postid,
					'topic_id'			=> $topicid,
					'is_orphan'			=> 0,
					'poster_id'			=> $user->id,
					'attach_comment'	=> $attachment_data[$data]['attach_comment'],
				);

				$sql = 'UPDATE torrent_attachments SET ' . $db->sql_build_array('UPDATE', $attach_sql) . '
					WHERE attach_id = ' . $attachment_data[$data]['attach_id'] . '
						AND is_orphan = 1
						AND poster_id = ' . $user->id;
				$db->sql_query($sql);
				$i++;
		
		}
				$db->sql_query("UPDATE ".$db_prefix."_forum_topics SET `topic_attachment` = topic_attachment + " . $i . " WHERE `id` = " . $topicid . " LIMIT 1");
				$db->sql_query("UPDATE ".$db_prefix."_forum_posts SET `post_attachment` = post_attachment + " . $i . " WHERE `id` = " . $postid . " LIMIT 1");
	}

  if($allow_bookmarks)
  {
		$res = $db->sql_query("SELECT COUNT(user_id) FROM ".$db_prefix."_bookmarks WHERE topic_id=$topicid AND user_id <> ".$user->id ." LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
		$res2 = $db->sql_query("SELECT * FROM ".$db_prefix."_bookmarks WHERE topic_id=$topicid ") or forumsqlerr(__FILE__, __LINE__);
        list ($count) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        if ($count > 0)
        {
         $arr = $db->sql_fetchrow($res2);
         $booksend = str_replace(array("**username**","**owner**","**thread**","**posts**","**lastposter**","**formlink**","**removebook**"),array(username_is($arr['user_id']),username_is($topic_owner),get_topic_title($topicid),get_row_count("".$db_prefix."_forum_posts", " WHERE topicid='$topicid'"),username_is($userid),$siteurl."/forums.php?action=viewtopic&topicid=$topicid&page=last","[url=".$siteurl."/forums.php?action=viewtopic&do=removebook&topicid=$topicid&page=last]Here[/url]"),$bookmes);
                $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0','".$arr['user_id']."','New Forum Post','".addslashes($booksend)."',NOW());");
         $db->sql_freeresult($res2);
         }
         if($book)$db->sql_query("INSERT INTO ".$db_prefix."_bookmarks (topic_id, user_id) VALUES ( ".$topicid.", ".$user->id.")");
		 }
    //Update topic last post
    update_topic_last_post($topicid);

    //All done, redirect user to the post
    $headerstr = "Location: $siteurl/forums.php?action=viewtopic&topicid=$topicid&page=last";
    if ($newtopic)
		header($headerstr);
    else
		header("$headerstr#$postid");
    die;
}

///////////////////////////////////////////////////////// Action: VIEW TOPIC
if ($action == "viewtopic") {
	$topicid = $_GET["topicid"];
	$page = $_GET["page"];
	if (!is_valid_id($topicid))
		die;
	$userid = $user->id;

    //------ Get topic info
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or showerror("Forum error", "Topic not found");
    $locked = ($arr["locked"] == 'yes');
    $subject = stripslashes($arr["subject"]);
	$sticky = $arr["sticky"] == "yes";
    $forumid = $arr["forumid"];
	$is_moder = get_forum_access_levels($forumid);
	echo $is_moder["minclassread"];
	if(!in_array($user->group,explode("  ", $is_moder["read"])))showerror(_bterror,"You do Not have access to this Section");

	// Update Topic Views
	$viewsq = $db->sql_query("SELECT views FROM ".$db_prefix."_forum_topics WHERE id=$topicid");
	$viewsa = $db->sql_fetchrow($viewsq);
	$views = $viewsa[0];
	$new_views = $views+1;
	$uviews = $db->sql_query("UPDATE ".$db_prefix."_forum_topics SET views = $new_views WHERE id=$topicid");
	// End

    //------ Get forum
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or showerror("Forum error", "Forum is empty");
    $forum = stripslashes($arr["name"]);

    //------ Get post count
    $res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
    $postcount = $arr[0];

    //------ Make page menu
    $pagemenu = "<br><small>\n";
    $perpage = $postsper_page;
    $pages = floor($postcount / $perpage);
    if ($pages * $perpage != $postcount)
		++$pages;
    if ($page == "last")
		$page = $pages;
    else {
		if($page < 1)
			$page = 1;
		elseif ($page > $pages)
			$page = $pages;
    }
    $offset = $page * $perpage - $perpage;
	//
    if ($page == 1)
      $pagemenu .= "<b>&lt;&lt; Prev</b>";
    else
      $pagemenu .= "<a href=forums.php?action=viewtopic&topicid=$topicid&page=" . ($page - 1) .
        "><b>&lt;&lt; Prev</b></a>";
	//
	$pagemenu .= "&nbsp;&nbsp;";
	    for ($i = 1; $i <= $pages; ++$i) {
      if ($i == $page)
        $pagemenu .= "<b>$i</b>\n";
      else
        $pagemenu .= "<a href=forums.php?action=viewtopic&topicid=$topicid&page=$i><b>$i</b></a>\n";
    }
	//
    $pagemenu .= "&nbsp;&nbsp;";
    if ($page == $pages)
      $pagemenu .= "<b>Next &gt;&gt;</b><br><br>\n";
    else
      $pagemenu .= "<a href=forums.php?action=viewtopic&topicid=$topicid&page=" . ($page + 1) .
        "><b>Next &gt;&gt;</b></a><br><br>\n";

//Get topic posts
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid ORDER BY id LIMIT $offset,$perpage") or forumsqlerr(__FILE__, __LINE__);

    stdhead("View Topic: $subject");
    forum_table("$forum &gt; $subject", 'center');
	forumheader("<a href=forums.php?action=viewforum&forumid=$forumid>$forum</a> > $subject");
	
	print ("<table align=center cellpadding=0 cellspacing=5 width=100% border=0 ><tr><td>");
	
	if (!$locked){
		print ("<div align='right'><a href=forums.php?action=reply&topicid=$topicid><img src=" . $themedir . "$button_reply border=0></a></div>");
	}else{
		print ("<div align='right'><img src=" . $themedir . "button_locked.gif border=0 alt=Locked></div>");
	}
	print ("</td></tr></table>");

//------ Print table of posts
    $pc = $db->sql_numrows($res);
    $pn = 0;
    $r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=" . $user->id . " AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $a = $db->sql_fetchrow($r);
    $lpr = $a[0];
    if (!$lpr)
		$db->sql_query("INSERT INTO ".$db_prefix."_forum_readposts (userid, topicid) VALUES($userid, $topicid)") or forumsqlerr(__FILE__, __LINE__);

    while ($arr = $db->sql_fetchrow($res)) {
		++$pn;
		$post_attachment = $arr['post_attachment'];
		$postid = $arr["id"];
		$posterid = $arr["userid"];
		$added = $arr["added"] . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . " ago)";

		//---- Get poster details
		$res4 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE userid=$posterid") or forumsqlerr();
		$arr33 = $db->sql_fetchrow($res4);
		$forumposts = $arr33[0];

		$res2 = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id=$posterid") or forumsqlerr(__FILE__, __LINE__);
		$arr2 = $db->sql_fetchrow($res2);
		$postername = $arr2["username"];
		if($post_attachment >= 1)
		{
		$ata_box = '';
		$sql_atta = 'SELECT `attach_id`, `real_filename`, `attach_comment`, `extension`, `filesize`, `download_count` FROM `torrent_attachments`'
        . ' WHERE `post_msg_id` = \'' . $postid . '\' AND `poster_id` = \'' . $posterid . '\' LIMIT 0, 30 ';
		$res_atta = $db->sql_query($sql_atta)or forumsqlerr();
		while(list ($attach_id, $real_filename, $attach_comment, $extension, $filesize, $download_count) = $db->sql_fetchrow($res_atta)){
		$ata_box .= "<dd>		<dl class=\"file\">\n";
		$ata_box .= "<dt><img src=\"images/upload_icons/" . $extension . ".gif\" alt=\"\" title=\"\" width=\"7\" height=\"10\"> <a class=\"postlink\" href=\"./file.php?id=" . $attach_id . "\">" . $real_filename . "</a></dt>\n";
		$ata_box .= "<dd><em>" . $attach_comment . "</em></dd>			<dd>(" . mksize($filesize) . ") ". (($download_count > 0)? $download_count ." Down loads" : "Not downloaded yet")."</dd>\n";
		$ata_box .= "</dl>\n";
		$ata_box .= "</dd>\n";
		}
		$db->sql_freeresult($res_atta);
		}
			if ($postername == "") {
				$by = "Deluser";
				$title = "Deleted Account";
				$privacylevel = "strong";
				$usersignature = " ";
				$userdownloaded = "0";
				$useruploaded = "0";
				$avatar = "";
				$nposts = "-";
				$tposts = "-";
			}else{
				$avatar = "avatars/".htmlspecialchars($arr2["avatar"]);
				$userdownloaded = mksize($arr2["downloaded"]);
				$useruploaded = mksize($arr2["uploaded"]);
				$privacylevel = $arr2["privacy"];
				$usersignature = stripslashes(format_comment($arr2["signature"]));
					if ($arr2["downloaded"] > 0) {
						$userratio = number_format($arr2["uploaded"] / $arr2["downloaded"], 2);
					}else
						if ($arr2["uploaded"] > 0)
							$userratio = "Inf.";
						else
							$userratio = "---";
        
					if(!$arr2["country"]){
						$usercountry = "unknown";
					}else{
						$res4 = $db->sql_query("SELECT name,flagpic FROM ".$db_prefix."_countries WHERE id=$arr2[country] LIMIT 1") or forumsqlerr();
						$arr4 = $db->sql_fetchrow($res4);
						$usercountry = $arr4["name"];
					}

				$title = strip_tags($arr2["title"]);
				$donated = $arr2['donated'];
				$by = "<a href=user.php?op=profile&id=$posterid><font color=\"".getusercolor(getlevel_name($posterid))."\">" . $postername . "</font></a>" . ($donated > 0 ? "<img src=".$siteurl."/images/donator.gif  height=\"16\" width=\"16\" alt='Donated'>" : "") . "";
			}

		if (!$avatar)
			$avatar = $siteurl ."/images/default_avatar.gif";
		print("<a name=$postid>\n");

		if ($pn == $pc) {
			print("<a name=last>\n");
			if ($postid > $lpr)
			$db->sql_query("UPDATE ".$db_prefix."_forum_readposts SET lastpostread=$postid WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
		}
//working here

		print("<table align=center cellpadding=3 cellspacing=0 width=100% border=1 class=\"ftopictable1\"><tr><td width=150 align=center>$by<td with=100% align=left><small>Posted at $added </small></tr></table>");

		print("<table align=center cellpadding=3 cellspacing=0 class=\"ftopictable2\" width=100% border=1>\n");

		$body = format_comment($arr["body"], false, true);
		parse_smiles($body);

		if($CENSORWORDS) {//bad word censor
			$query = "SELECT * FROM ".$db_prefix."_censor";
			$result = $db->sql_query($query);
			while ($row = $db->sql_fetchrow($result)) {
				$body = str_replace($row['word'], $row['censor'], $body);
			}
		}//censor end

		if (is_valid_id($arr['editedby'])) {
			$res2 = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$arr[editedby]");

			if ($db->sql_numrows($res2) == 1) {
				$arr2 = $db->sql_fetchrow($res2);
				//edited by comment out if needed
				$body .= "<br><br><font size=1 class=small><i>Last edited by <a href=user.php?op=profile&id=$arr[editedby]><font color=\"".getusercolor(getlevel_name($arr['editedby']))."\">" . $arr2['username'] . "</font></a> on $arr[editedat]</i></font><br>\n";
				$body .= "\n";
			}
		}

		$quote = htmlspecialchars($arr["body"]);

		$postcount1 = $db->sql_query("SELECT COUNT(".$db_prefix."_forum_posts.userid) FROM ".$db_prefix."_forum_posts WHERE id=$posterid") or forumsqlerr();

		while($row = $db->sql_fetchrow($postcount1)) {

			if  ($privacylevel == "strong" && !$user->admin){//hide stats, but not from staff
				$useruploaded = "---";
				$userdownloaded = "---";
				$userratio = "---";
				$nposts = "-";
				$tposts = "-";
			}
			print ("<tr valign=top><td width=150 align=left><center><i>$title</i></center><br><center><a href=user.php?op=profile&id=$posterid>".gen_avatar($posterid)."</a></center><br>Uploaded: $useruploaded<br>Downloaded: $userdownloaded<br>Posts: ".(($forumposts > 0)? "<a class=\"pocount\" title=\"View users Posts\" href=forums.php?action=search&search_id=".$posterid.">".$forumposts."</a>" : $posterid) ."<br><br>Ratio: $userratio<br>Location: $usercountry<br><br></td>");

			print ("<td class=fcomment>$body<br>");
			if($post_attachment >= 1){
			echo "<br><br><br><br><dl class=\"attachbox\">\n";
			echo "<dt>Attachments</dt>\n";
			echo $ata_box;
			echo "</dl><br clear=\"all\" />\n";
			}

			if (!$usersignature){
				print("<br><br></td></tr>\n");
			}else{
				print("<br><br>---------------<br>$usersignature</td></tr>\n");
			}
		}

	    print("</table>\n");

	print("<table align=center cellpadding=3 cellspacing=0 class=\"ftopictable3\" width=100% border=1 ><tr><td width=150 align=center><nobr> <a href=pm.php?op=send&to=$posterid><img src=".$themedir."$icon_pm border=0></a> </nobr><td with=100%>");

	print ("<div style='float: left;'><a href=report.php?forumid=$topicid&forumpost=$postid><img src=".$themedir."$p_report border='0' alt='Report This Post'></a>&nbsp;<a href='javascript:scroll(0,0);'><img src=".$themedir."p_up.gif border='0' alt='Go to the top of the page'></a></div><div align=right>");
	
	//define buttons and who can use them
	if ($user->id == $posterid || $user->admin || in_array($user->group,explode("  ", $is_moder["write"]))){
		print ("<a href='forums.php?action=editpost&postid=$postid'&topic=$topicid><img src=".$themedir."$p_edit border='0' ></a>&nbsp;");
	}
	if ($user->admin || in_array($user->group,explode("  ", $is_moder["write"]))){
		print ("<a href='forums.php?action=deletepost&postid=$postid&sure=0'><img src=".$themedir."$p_delete border='0' ></a>&nbsp;");
	}
	if (!$locked){
		print ("<a onclick=\"comment_smile('[quote=".htmlspecialchars(username_is($posterid))."]". str_replace(array("\r\n", "\n", "\r","'"),array('<br>','<br>','<br>','&middot;'),$quote) ."[/quote]',Form.body)\"><img src=".$themedir."$p_quote border='0' ></a>&nbsp;");
		print ("<a href='forums.php?action=reply&topicid=$topicid'><img src=".$themedir."$p_reply border='0' ></a>");
	}
		print("&nbsp;</div></td></tr></table>");
		print("</p>\n");// post seperate&middot;
	}
//-------- end posts table ---------//
	print($pagemenu);

	//quick reply
	if (!$locked || in_array($user->id,explode(" ", $is_moder["moder"]))){
	print ("<table align=center cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor=646262 width=100% border=1 class = ftableback><TR><TD><BR><CENTER><B>POST REPLY</B></CENTER><BR>");
	$newtopic = false;
	print("<a name=\"bottom\"></a>");
    print("<form name=Form method=post action=?action=post>\n");
    if ($newtopic)
		print("<input type=hidden name=forumid value=$id>\n");
    else
		print("<input type=hidden name=topicid value=$topicid>\n");

    print("<center><table border=0 cellspacing=0 cellpadding=0>");
    if ($newtopic)
		print("<tr><td class=alt2>Subject</td><td class=alt1 align=left style='padding: 0px'><input type=text size=100 maxlength=$max_subject_length name=subject style='border: 0px; height: 19px'></td></tr>\n");
                echo "  <select id=fontselect 
                        onchange=fontformat(Form,this.options[this.selectedIndex].value,'font',body)>
                        <option value=0>FONT</option>
                        <option value=arial><font face=\"arial\">Arial</font></option>
                        <option value=comic sans ms>Comic</option>
                        <option value=courier new>Courier New</option>
                        <option value=tahoma>Tahoma</option>
                        <option value=times new roman>Times New Roman</option>
                        <option value=verdana>Verdana</option>

                        </select>
						<select id=sizeselect onchange=fontformat(Form,this.options[this.selectedIndex].value,'size',body)>
                        <option value=0>Size</option>
                        <option value=1>Thery Small</option>
                        <option value=2>Small</option>
                        <option value=3>Normal</option>
                        <option value=4>Large</option>
                        <option value=5>X-Large</option>
                        </select>
                        <select id=colorselect 
                        onchange=fontformat(Form,this.options[this.selectedIndex].value,'color',body)>
                        <option value=0>COLOR</option>
                        <option value=skyblue style=color:skyblue>sky blue</option>
                        <option value=royalblue style=color:royalblue>royal blue</option>
                        <option value=blue style=color:blue>blue</option>
                        <option value=darkblue style=color:darkblue>dark-blue</option>
                        <option value=orange style=color:orange>orange</option>
                        <option value=orangered style=color:orangered>orange-red</option>
                        <option value=crimson style=color:crimson>crimson</option>
                        <option value=red style=color:red>red</option>
                        <option value=firebrick style=color:firebrick>firebrick</option>
                        <option value=darkred style=color:darkred>dark red</option>
                        <option value=green style=color:green>green</option>
                        <option value=limegreen style=color:limegreen>limegreen</option>
                        <option value=seagreen style=color:seagreen>sea-green</option>
                        <option value=deeppink style=color:deeppink>deeppink</option>
                        <option value=tomato style=color:tomato>tomato</option>
                        <option value=coral style=color:coral>coral</option>
                        <option value=purple style=color:purple>purple</option>
                        <option value=indigo style=color:indigo>indigo</option>
                        <option value=burlywood style=color:burlywood>burlywood</option>
                        <option value=sandybrown style=color:sandybrown>sandy brown</option>
                        <option value=sienna style=color:sienna>sienna</option>
                        <option value=chocolate style=color:chocolate>chocolate</option>
                        <option value=teal style=color:teal>teal</option>
                        <option value=silver style=color:silver>silver</option>
                        </select>
   						<br /><a href=bbcode.php target=\"_blank\">BBcode help</a><br /><br />";

	print("<tr><td>");
	quickbb();
	quicktags();
	?><script language=javascript>
	function PopMoreSmiles(form,text) {        
	link='moresmiles.php?form='+form+'&text='+text;        
	newWin=window.open(link,'moresmile','height=500,width=600,resizable=no,scrollbars=yes');
	if (window.focus) {
	newWin.focus()
	}
	}</script><?php echo "<center><a href=\"javascript: PopMoreSmiles('Form','body')\">More Smiles</a></center>";
	print("</td><td width=10>&nbsp;</td><td align=left><textarea name=body cols=60 rows=10></textarea></td>\n");
	print("<td>&nbsp;</td></tr>\n");
    print("<tr><td colspan=3 align=center><br>");
	echo "<input name=\"book\" value=\"yes\" type=\"checkbox\">Notify me when a reply is posted<br />";
	echo("<input type=image class=btn src=".$themedir."$button_reply border=0></td></tr>\n");
    print("</table></form></center>\n");
	//forum_table_close();
	print ("</TD></TR></TABLE>");
	}else{
	print ("<CENTER><img src=".$themedir."button_locked.gif alt=Locked></CENTER>");
	}
	//end quick reply

	if ($locked)
		print("<p>This topic is locked; no new posts are allowed.</p>\n");
    else {
      $arr = get_forum_access_levels($forumid) or die;
      if (!$arr["write"] == "0" AND !in_array($user->group,explode(" ", $arr["write"])))
		print("<p><i>You are not permitted to post in this forum2.</i></p>\n");
      else
        $maypost = true;
    }

    //insert page numbers and quick jump

   // insert_quick_jump_menu($forumid);

	// MODERATOR OPTIONS
    if ($user->admin OR in_array($user->group,explode(" ", $arr["moder"]))) {
    	forum_table_close();
		forum_table("Moderator Options");
      $res = $db->sql_query("SELECT id,name,minclasswrite FROM ".$db_prefix."_forum_forums ORDER BY name") or forumsqlerr(__FILE__, __LINE__);
      print("<table border=0 cellspacing=0 cellpadding=0>\n");
      print("<form method=post action=forums.php?action=renametopic>\n");
      print("<input type=hidden name=topicid value=$topicid>\n");
      print("<input type=hidden name=returnto value=".$HTTP_SERVER_VARS["REQUEST_URI"].">\n");
	  print("<tr><td class=embedded align=right>"._btf_renametopic."</td><td class=embedded><input type=text name=subject size=60 maxlength=$max_subject_length value=\"" . stripslashes(htmlspecialchars($subject)) . "\">\n");
      print("<input type=submit value='Apply'></td></tr>");
      print("</form>\n");
      print("<form method=post action=forums.php?action=movetopic&topicid=$topicid>\n");
      print("<tr><td class=embedded align=right>"._btf_movethread."</td><td class=embedded><select name=forumid>");
      while ($arr = $db->sql_fetchrow($res))
        if ($arr["id"] != $forumid && in_array($user->group,explode(" ", $arr["minclasswrite"])))
          print("<option value=" . $arr["id"] . ">" . $arr["name"] . "\n");
      print("</select> <input type=submit value="._bt_aply."></form></td></tr>\n");
      print("</table>\n");

//
 print("<table width=100%><tr><td align=center>\n");
			if ($locked)
				print("Locked: <a href=forums.php?action=unlocktopic&forumid=$forumid&topicid=$topicid&page=$page title='Unlock'><img src=". $themedir ."topic_unlock.gif border=0 alt=UnLock Topic></a>\n");
			else
				print("Locked: <a href=forums.php?action=locktopic&forumid=$forumid&topicid=$topicid&page=$page title='Lock'><img src=". $themedir ."topic_lock.gif border=0 alt=Lock Topic></a>\n");
			print("Delete Entire Topic: <a href=forums.php?action=deletetopic&topicid=$topicid&sure=0 title='Delete'><img src=". $themedir ."$topic_delete border=0 alt=Delete Topic></a>\n");
			if ($sticky)
			   print("Sticky: <a href=forums.php?action=unsetsticky&forumid=$forumid&topicid=$topicid&page=$page title='UnStick'><img src=". $themedir ."folder_sticky_new.gif border=0 alt=UnStick Topic></a>\n");
			else
			   print("Sticky: <a href=forums.php?action=setsticky&forumid=$forumid&topicid=$topicid&page=$page title='Stick'><img src=". $themedir ."folder_sticky.gif border=0 alt=Stick Topic></a>\n");
			print("</td></tr></table>\n");
//

    }
    forum_table_close();

    stdfoot();
	
	include'footer.php';
	die;
}
/////////////////////////////////////////////////////////Action: Remove bookmark
if (isset($do) AND $do == "removebook") {
    if(!isset($topicid) OR $topicid == "" OR !is_numeric($topicid))showerror("Delete BookMark","No Topic is set please check your link");
	if (!isset($sure) OR !$sure == "1") 
		showerror("Delete BookMark", "Sanity check: You are about to Remove your bookmark for ".get_topic_title($topicid).". Click <a href=forums.php?do=removebook&topicid=$topicid&sure=1>here</a> if you are sure.");
	$db->sql_query("DELETE FROM ".$db_prefix."_bookmarks WHERE topic_id=$topicid AND user_id=".$user->id."") or forumsqlerr(__FILE__, __LINE__);
    header("Location: $siteurl/forums.php");
	die;
}

///////////////////////////////////////////////////////// Action: REPLY
if ($action == "reply") {
	$topicid = request_var('topicid', '');
	if (!is_valid_id($topicid))
		die;
$body = request_var('body', '');
	stdhead("Post reply");
	forum_table("Post reply");
	insert_compose_frame($topicid, false,$body);
	forum_table_close();
	stdfoot();
	
	include'footer.php';
	die;
}

///////////////////////////////////////////////////////// Action: MOVE TOPIC
if ($action == "movetopic") {
    $forumid = $_POST["forumid"];
    $topicid = $_GET["topicid"];
    if (!is_valid_id($forumid) || !is_valid_id($topicid) || !$user->admin)
		die;

    // Make sure topic and forum is valid
    $res = @$db->sql_query("SELECT minclasswrite FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    if ($db->sql_numrows($res) != 1)
      showerror(_bterror, "Forum not found.");
    $arr = $db->sql_fetchrow($res);
    if (10 < $arr[0])
      die;
    $res = @$db->sql_query("SELECT subject,forumid FROM ".$db_prefix."_forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    if ($db->sql_numrows($res) != 1)
      showerror(_bterror, "Topic not found.");
    $arr = $db->sql_fetchrow($res);
    if ($arr["forumid"] != $forumid)
      @$db->sql_query("UPDATE ".$db_prefix."_forum_topics SET forumid=$forumid, moved='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);

    // Redirect to forum page
    header("Location: $siteurl/forums.php?action=viewforum&forumid=$forumid");
    die;
}

///////////////////////////////////////////////////////// Action: DELETE TOPIC
if ($action == "deletetopic") {
	$topicid = $_GET["topicid"];
	if (!is_valid_id($topicid) || !$user->admin)
		die;
	
	$sure = $_GET["sure"];
	if (!$sure == "1") 
		showerror("Delete topic", "Sanity check: You are about to delete a topic. Click <a href=forums.php?action=deletetopic&topicid=$topicid&sure=1>here</a> if you are sure.");

	$db->sql_query("DELETE FROM ".$db_prefix."_forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
	$db->sql_query("DELETE FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
	$db->sql_query("DELETE FROM ".$db_prefix."_bookmarks WHERE topic_id=$topicid") or forumsqlerr(__FILE__, __LINE__);
	header("Location: $SITEURL/forums.php");
	die;
}

///////////////////////////////////////////////////////// Action: EDIT TOPIC
if ($action == "editpost") {
	//$postid = $HTTP_GET_VARS["postid"];
	if (!is_valid_id($postid))
		die;
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
	if ($db->sql_numrows($res) != 1)
		showerror(_bterror, "No post with ID $postid.");
	$arr = $db->sql_fetchrow($res);
    if ($user->id != $arr["userid"] && !$user->admin)
		showerror(_bterror, "Denied!");

    if ($take == '1') {
		//$body = $HTTP_POST_VARS['body'];
			if ($body == "")
				showerror(_bterror, "Body cannot be empty!");
		$body = $db->sql_escape(stripslashes($body));
		//$editedat = $db->sql_escape(get_date_time());
		$db->sql_query("UPDATE ".$db_prefix."_forum_posts SET body='".$body."', editedat=NOW(), editedby=".$user->id." WHERE id='".$postid."'") or forumsqlerr(__FILE__, __LINE__);
		//$returnto = $returnto"];$topicid
			if ($returnto != ""){
				header("Location: $returnto");
				die;
				}
			else
				showerror("Success", "Post was edited successfully.");
	}

    stdhead();

    forum_table("Edit Post");
    print("<form name=Form method=post action=?action=editpost&postid=$postid>\n");
    print("<input type=hidden name=take value=\"1\">\n");
    print("<input type=hidden name=returnto value=\"$siteurl/forums.php?action=viewtopic&topicid=" . $arr["topicid"] . "\">\n");
    print("<center><table border=0 cellspacing=0 cellpadding=5>\n");
    print("<tr><td>\n");
	quicktags();
	print("</td><td style='padding: 0px'><textarea name=body cols=50 rows=20 >" . stripslashes(htmlspecialchars($arr["body"])) . "</textarea></td></tr>\n");
    print("<tr><td align=center colspan=2><input type=submit value='Submit Changes' class=btn></td></tr>\n");
    print("</table></center>\n");
    print("</form>\n");
    forum_table_close();
    stdfoot();
	
	include'footer.php';
	die;
}

///////////////////////////////////////////////////////// Action: DELETE POST
if ($action == "deletepost") {
	$postid = $_GET["postid"];
	$sure = $_GET["sure"];
    $res = $db->sql_query("SELECT userid FROM ".$db_prefix."_forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
	if ($arr['userid'] != $user->id AND !checkaccess("modforum"))showerror(_bterror, "Can't delete post access denied.\n");
	if(!is_valid_id($postid))showerror(_bterror, _btiderror);

    //SURE?
	if ($sure == "0") {
		showerror("Delete post", "Sanity check: You are about to delete a post. Click <a href=forums.php?action=deletepost&postid=$postid&sure=1>here</a> if you are sure.");
    }

	//------- Get topic id
    $res = $db->sql_query("SELECT topicid FROM ".$db_prefix."_forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or showerror(_bterror, "Post not found");
    $topicid = $arr[0];
    $res = $db->sql_query("SELECT userid FROM ".$db_prefix."_forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
    if (!$arr['userid'] == $user->id)
		showerror(_bterror, "Can't delete post; it is the only post of the topic. You should <a href=forums.php?action=deletetopic&topicid=$topicid&sure=1>delete the topic</a> instead.\n");

    //------- We can not delete the post if it is the only one of the topic
    $res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
    if ($arr[0] < 2)
		showerror(_bterror, "Can't delete post; it is the only post of the topic. You should <a href=forums.php?action=deletetopic&topicid=$topicid&sure=1>delete the topic</a> instead.\n");

    //------- Delete post
    $db->sql_query("DELETE FROM ".$db_prefix."_forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);

    //------- Update topic
    update_topic_last_post($topicid);
    header("Location: $SITEURL/forums.php?action=viewtopic&topicid=$topicid");
    die;
}

///////////////////////////////////////////////////////// Action: LOCK TOPIC
if ($action == "locktopic") {
	$forumid = $_GET["forumid"];
	$topicid = $_GET["topicid"];
	$page = $_GET["page"];
	if (!is_valid_id($topicid) || !$user->admin)
		die;
	$db->sql_query("UPDATE ".$db_prefix."_forum_topics SET locked='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
	header("Location: $siteurl/forums.php?action=viewforum&forumid=$forumid&page=$page");
	die;
}

///////////////////////////////////////////////////////// Action: UNLOCK TOPIC
if ($action == "unlocktopic") {
    $forumid = $_GET["forumid"];
    $topicid = $_GET["topicid"];
    $page = $_GET["page"];
    if (!is_valid_id($topicid) || !$user->admin)
		die;
    $db->sql_query("UPDATE ".$db_prefix."_forum_topics SET locked='no' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    header("Location: $siteurl/forums.php?action=viewforum&forumid=$forumid&page=$page");
    die;
}

///////////////////////////////////////////////////////// Action: STICK TOPIC
if ($action == "setsticky") {
   $forumid = $_GET["forumid"];
   $topicid = $_GET["topicid"];
   $page = $_GET["page"];
   $error = array();
   $moder = get_forum_access_levels($forumid);
   if (!is_valid_id($topicid))$error[] = "No Forum ID";
   if(!in_array($user->id,explode(" ", $moder["moder"]))){
   if(!$user->admin)
     $error[] = "You do not have Mod rights here";
	 }
if (count($error) > 0)
        bterror($error,_btupload);
   $db->sql_query("UPDATE ".$db_prefix."_forum_topics SET sticky='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
   header("Location: $siteurl/forums.php?action=viewforum&forumid=$forumid&page=$page");
   die;
}

///////////////////////////////////////////////////////// Action: UNSTICK TOPIC
if ($action == "unsetsticky") {
   $forumid = $_GET["forumid"];
   $topicid = $_GET["topicid"];
   $page = $_GET["page"];
   $moder = get_forum_access_levels($forumid);
   $error = array();
   if (!is_valid_id($topicid))$error[] = "No Forum ID";
   if(!in_array($user->id,explode(" ", $moder["moder"]))){
   if(!$user->admin)
     $error[] = "You do not have Mod rights here sample1";
	 }
if (count($error) > 0)
        bterror($error,_btupload);
   $db->sql_query("UPDATE ".$db_prefix."_forum_topics SET sticky='no' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
   header("Location: $siteurl/forums.php?action=viewforum&forumid=$forumid&page=$page");
   die;
}

///////////////////////////////////////////////////////// Action: RENAME TOPIC
if ($action == 'renametopic') {
	if (!$user->admin)
		die;
  	$topicid = $HTTP_POST_VARS['topicid'];
  	if (!is_valid_id($topicid))
		die;
  	$subject = $HTTP_POST_VARS['subject'];
 	if ($subject == '')
		showerror('Error', 'You must enter a new title!');
  	$subject = $db->sql_escape(stripslashes($subject));
  	$db->sql_query("UPDATE ".$db_prefix."_forum_topics SET subject='$subject' WHERE id=$topicid") or forumsqlerr();
  	$returnto = $HTTP_POST_VARS['returnto'];
  	if ($returnto)
		header("Location: $returnto");
  	die;
}
///////////////////////////////////////////////////////// Action: Watch FORUM
if ($action == "watchforum") {
	$forumid = $_GET["forumid"];
	if (!is_valid_id($forumid))
		die;
    $res = $db->sql_query("SELECT name, minclassread FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or die;
	$can_read = explode("  ", $arr["minclassread"]);
    $forumname = $arr["name"];
    if (!$arr["minclassread"] == "0" AND !in_array($user->group,$can_read))
		die("Not permitted");
    stdhead("Forum : $forumname");
$sql = "INSERT INTO `".$db_prefix."_forums_watch` (`forum_id`, `user_id`, `notify_status`) VALUES ('" . $forumid . "', '" . $user->id . "', '1');";
$db->sql_query($sql);
				echo "<meta http-equiv=\"refresh\" content=\"5;url=./forums.php?action=viewforum&forumid=" . $forumid."\">";
				OpenMessTable('Information');
				echo 'You have subscribed to be notified of new posts in this forum ' . $forumname . '.<br>';
				echo '<a href=forums.php?action=viewforum&forumid=' . $forumid . '>Return to the forum last visited</a>';
				CloseMessTable();
    insert_quick_jump_menu($forumid);
    forum_table_close();
    stdfoot();
	include'footer.php';
	die;
}
///////////////////////////////////////////////////////// Action: VIEW FORUM
if ($action == "viewforum") {
	$forumid = $_GET["forumid"];
	if (!is_valid_id($forumid))
		die;
    $page = $_GET["page"];
    $userid = $user->id;

    //------ Get forum name
    $res = $db->sql_query("SELECT name, minclassread FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res) or die;
	$can_read = explode("  ", $arr["minclassread"]);
    $forumname = $arr["name"];
    if (!$arr["minclassread"] == "0" AND !in_array($user->group,$can_read))
		die("Not permitted");

    //------ Get topic count
    $perpage = $topics_per_page;
    $res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_topics WHERE forumid=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = $db->sql_fetchrow($res);
    $num = $arr[0];
    if ($page == 0)
      $page = 1;
    $first = ($page * $perpage) - $perpage + 1;
    $last = $first + $perpage - 1;
    if ($last > $num)
      $last = $num;
    $pages = floor($num / $perpage);
    if ($perpage * $pages < $num)
      ++$pages;

    //------ Build menu
    $menu = "<p align=center><b>\n";
    $lastspace = false;
    for ($i = 1; $i <= $pages; ++$i) {
      if ($i == $page)
        $menu .= "<font class=gray>$i</font>\n";
      elseif ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3)) {
    	if ($lastspace)
          continue;
   	    $menu .= "... \n";
    	$lastspace = true;
      }
      else {
        $menu .= "<a href=forums.php?action=viewforum&forumid=$forumid&page=$i>$i</a>\n";
        $lastspace = false;
      }
      if ($i < $pages)
        $menu .= "</b>|<b>\n";
    }
    $menu .= "<br />\n";
    if ($page == 1)
      $menu .= "<font class=gray>&lt;&lt; Prev</font>";
    else
      $menu .= "<a href=forums.php?action=viewforum&forumid=$forumid&page=" . ($page - 1) . ">&lt;&lt; Prev</a>";
    $menu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($last == $num)
      $menu .= "<font class=gray>Next &gt;&gt;</font>";
    else
      $menu .= "<a href=forums.php?action=viewforum&forumid=$forumid&page=" . ($page + 1) . ">Next &gt;&gt;</a>";
    $menu .= "</b></p>\n";
    $offset = $first - 1;

    //------ Get topics data and display category
    $topicsres = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics WHERE forumid=$forumid ORDER BY sticky, lastpost DESC LIMIT $offset,$perpage") or showerror("SQL Error", mysql_error());
$arrmm = get_forum_access_levels($forumid);
    stdhead("Forum : $forumname");
    $numtopics = $db->sql_numrows($topicsres);
    forum_table("$forumname", center);
	forumheader("<a href=forums.php?action=viewforum&forumid=$forumid>$forumname</a>");
	
	print ("<table align=center cellpadding=0 cellspacing=5 width=95% border=0 ><tr><td><div align='right'>" . ((!is_booked_marcked($forumid)) ? "<a href=forums.php?action=watchforum&forumid=$forumid>Subscribe forum</a>" : "") . "<a href=forums.php?action=newtopic&forumid=$forumid><img src=". $themedir. "$button_new_topic border=0></a></div></td></tr></table>");

    if ($numtopics > 0) {
	print("<table align=center cellpadding=2 cellspacing=1 class=\"ftopictable4\" width=100% border=1 >");

	print("<tr class=\"row1\"><td align=left width=100% class= ftableback><b>Topic</b></td><td class = ftableback align=center><b>Replies</b></td><td class = ftableback align=center><b>Views</b></td><td class = ftableback align=center><b>Author</b></td><td class = ftableback align=right><b>Last post</b></td>\n");
		if ($user->admin OR in_array($user->id,explode(" ", $arrmm["moder"])))
			print("<td class = ftableback><b>Moderator</b></td>");
      print("</tr>\n");
      while ($topicarr = $db->sql_fetchrow($topicsres)) {
			$topicid = $topicarr["id"];
			$topic_userid = $topicarr["userid"];
			$locked = $topicarr["locked"] == "yes";
			$moved = $topicarr["moved"] == "yes";
			$sticky = $topicarr["sticky"] == "yes";
			$topic_attachment = $topicarr['topic_attachment'];
			//---- Get reply count
			$res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
			$arr = $db->sql_fetchrow($res);
			$posts = $arr[0];
			$replies = max(0, $posts - 1);
			$tpages = floor($posts / $postsper_page);
			if ($tpages * $postsperpage != $posts)
			  ++$tpages;
			if ($tpages > 1) {
			  $topicpages = " (<img src=". $SITEURL ."/images/multipage.gif>";
			  for ($i = 1; $i <= $tpages; ++$i)
				$topicpages .= " <a href=forums.php?action=viewtopic&topicid=$topicid&page=$i>$i</a>";
			  $topicpages .= ")";
        }
        else
          $topicpages = "";

        //---- Get userID and date of last post
        $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
        $arr = $db->sql_fetchrow($res);
        $lppostid = $arr["id"];
        $lpuserid = $arr["userid"];
        $lpadded = $arr["added"];

        //------ Get name of last poster
        $res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id=$lpuserid") or forumsqlerr(__FILE__, __LINE__);
        if ($db->sql_numrows($res) == 1) {
          $arr = $db->sql_fetchrow($res);
          $lpusername = "<a href=user.php?op=profile&id=$lpuserid><font color=\"".getusercolor(getlevel_name($lpuserid))."\">" . $arr['username'] . "</font></a>";
        }
        else
          $lpusername = "Deluser";

        //------ Get author
        $res = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$topic_userid") or forumsqlerr(__FILE__, __LINE__);
        if ($db->sql_numrows($res) == 1) {
          $arr = $db->sql_fetchrow($res);
          $lpauthor = "<a href=user.php?op=profile&id=$topic_userid><font color=\"".getusercolor(getlevel_name($topic_userid))."\">" . $arr['username'] . "</font></a>";
        }
        else
          $lpauthor = "Deluser";

		// Topic Views
		$viewsq = $db->sql_query("SELECT views FROM ".$db_prefix."_forum_topics WHERE id=$topicid");
		$viewsa = $db->sql_fetchrow($viewsq);
		$views = $viewsa[0];
		// End

        //---- Print row
        $r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
        $a = $db->sql_fetchrow($r);
        $new = !$a || $lppostid > $a[0];
        $topicpic = ($locked ? ($new ? $topic_unread_locked : $topic_read_locked) : ($new ? $topic_unread : $folder_icon));
        $subject = ($sticky ? "<b>Sticky: </b>" : "") . "<a href=forums.php?action=viewtopic&topicid=$topicid><b>" .
        encodehtml(stripslashes($topicarr["subject"])) . "</b></a>$topicpages";
        print("<tr class=\"row1\"><td align=left class=alt1><table border=0 cellspacing=0 cellpadding=0><tr>" .
         "<td style='padding-right: 5px'><img src=". $themedir ."$topicpic>".(($topic_attachment >= 1)? "<img src=images/save.gif>" : "") .
         "</td><td class=alt1 align=left>\n" .
         "$subject</td></tr></table></td><td class=alt2 align=center>$replies</td>\n" .
		 "<td class=alt1 align=center>$views</td>\n" .
         "<td class=alt1 align=center>$lpauthor</td>\n" .
         "<td class=alt2 align=right><nobr><small>by&nbsp;$lpusername<br>$lpadded</small></nobr></td>\n");
        if ($user->admin OR in_array($user->id,explode(" ", $arrmm["moder"]))) {
			  print("<td class=alt1 align=center>\n");
			if ($locked)
				print("<a href=forums.php?action=unlocktopic&forumid=$forumid&topicid=$topicid&page=$page title='Unlock'><img src=". $themedir ."topic_unlock.gif border=0 alt=UnLock Topic></a>\n");
			else
				print("<a href=forums.php?action=locktopic&forumid=$forumid&topicid=$topicid&page=$page title='Lock'><img src=". $themedir ."topic_lock.gif border=0 alt=Lock Topic></a>\n");
				print("<a href=forums.php?action=deletetopic&topicid=$topicid&sure=0 title='Delete'><img src=". $themedir ."$topic_delete border=0 alt=Delete Topic></a>\n");
			if ($sticky)
			   print("<a href=forums.php?action=unsetsticky&forumid=$forumid&topicid=$topicid&page=$page title='UnStick'><img src=". $themedir ."folder_sticky_new.gif border=0 alt=UnStick Topic></a>\n");
			else
			   print("<a href=forums.php?action=setsticky&forumid=$forumid&topicid=$topicid&page=$page title='Stick'><img src=". $themedir ."folder_sticky.gif border=0 alt=Stick Topic></a>\n");
			  print("</td>\n");
        }
        print("</tr>\n");
      } // while
   //   end_table();
   print("</table>");
      print($menu);
    } // if
    else
      print("<p align=center>No topics found</p>\n");
    print("<p><table border=0 cellspacing=0 cellpadding=0><tr valing=center>\n");
    print("<td ><img src=". $themedir ."$topic_unread style='margin-right: 5px'></td><td >New posts</td>\n");
	 print("<td ><img src=". $themedir ."$folder_icon style='margin-left: 10px; margin-right: 5px'>" .
     "</td><td >No New posts</td>\n");
    print("<td ><img src=". $themedir ."$topic_read_locked style='margin-left: 10px; margin-right: 5px'>" .
     "</td><td >Locked topic</td>\n");
    print("</tr></table></p>\n");
    $arr = get_forum_access_levels($forumid) or die;
	$maypost = false;
	if(!$arr["write"] == "0" AND in_array($user->group,explode(" ",$arr["write"])))$maypost = true;
	if($arr["write"] == "0")$maypost = true;
    if (!$maypost)
		print("<p><i>You are not permitted to post in this forum.</i></p>\n");
    print("<p><table border=0 cellspacing=0 cellpadding=0><tr>\n");

    if ($maypost)
		print("<td>" . ((!is_booked_marcked($forumid)) ? "<a href=forums.php?action=watchforum&forumid=$forumid>Subscribe forum</a>" : "") . "<a href=forums.php?action=newtopic&forumid=$forumid><img src=" . $themedir . "$button_new_topic border=0></a></td>\n");
    print("</tr></table>\n");
    insert_quick_jump_menu($forumid);
    forum_table_close();
    stdfoot();
	
	include'footer.php';
	die;
}

///////////////////////////////////////////////////////// Action: VIEW NEW POSTS
if ($action == "viewunread") {
	$userid = $user->id;
	$maxresults = 25;
	$res = $db->sql_query("SELECT id, forumid, subject, lastpost FROM ".$db_prefix."_forum_topics ORDER BY lastpost") or forumsqlerr(__FILE__, __LINE__);
    stdhead();
	forum_table("Topics with unread posts");
	forumheader("New Topics");

    $n = 0;
    $uc = $user->group;
    while ($arr = $db->sql_fetchrow($res)) {
      $topicid = $arr['id'];
      $forumid = $arr['forumid'];

      //---- Check if post is read
      $r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
      $a = $db->sql_fetchrow($r);
      if ($a && $a[0] == $arr['lastpost'])
        continue;

      //---- Check access & get forum name
      $r = $db->sql_query("SELECT name, minclassread FROM ".$db_prefix."_forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
      $a = $db->sql_fetchrow($r);
      if ($a['minclassread'] == "0" OR !in_array($uc,explode("  ", $a['minclassread'])))
        continue;
      ++$n;
      if ($n > $maxresults)
        break;
      $forumname = $a['name'];
      if ($n == 1) {
        print("<center><table border=1 cellspacing=0 cellpadding=5 width=95%>\n");
        print("<tr><td class=alt3 align=left>Topic</td><td class=alt3 align=left>Forum</td></tr>\n");
      }
      print("<tr><td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>" .
       "<img src=\"". $themedir . $topic_unread . "\" style='margin-right: 5px'></td><td class=embedded>" .
       "<a href=forums.php?action=viewtopic&topicid=$topicid&page=last#last><b>" . stripslashes(htmlspecialchars($arr["subject"])) ."</b></a></td></tr></table></td><td align=left><a href=forums.php?action=viewforum&amp;forumid=$forumid><b>$forumname</b></a></td></tr>\n");
    }
    if ($n > 0) {
      print("</table>\n");
      if ($n > $maxresults)
        print("<p>More than $maxresults items found, displaying first $maxresults.</p>\n");
      print("<p><a href=forums.php?catchup><b>Mark All Forums Read.</b></a></center><br></p>\n");
    }
    else
      print("<b>Nothing found</b>");
	 forum_table_close();
    stdfoot();
	
	include'footer.php';
	die;
}

///////////////////////////////////////////////////////// Action: SEARCH
if ($action == "search") {
$ignore = explode(' ',unesc($keywords));
$ignored = '';
$i=0;
foreach($ignore as $val){
if(in_array($val,$ignore_words)){
$ignored .= (($i > 0)? ', ':'').$val;
$keywords = str_replace($val, '', $keywords);
}
$i++;
}
	forumheader("Search Forums");
	forum_table("Search Forum");
			
	$keywords = trim(unesc($keywords));
	
	if ((isset($keywords) && $keywords != "") or (isset($search_id) && $search_id != "")){
		if(!isset($search_id) || $search_id == "")print("<p>Search Phrase: <b>" . htmlspecialchars($keywords) . "</b></p>\n");
		elseif($search_id == "egosearch")
		print("<p>View your posts</p>\n");
		if($ignored !='')print("<p>ignored: {$ignored}</p>\n");
		
		$maxresults = 50;
		$ekeywords = $db->sql_escape(stripslashes($keywords));
		if(!isset($search_id) || $search_id == "")$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE MATCH (body) AGAINST ('$ekeywords')") or forumsqlerr(__FILE__, __LINE__);
		elseif(is_numeric($search_id))$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE userid = '".$search_id."' ORDER BY `id` DESC") or forumsqlerr(__FILE__, __LINE__);
		elseif($search_id == "egosearch")$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE userid = '".$user->id."' ORDER BY `id` DESC") or forumsqlerr(__FILE__, __LINE__);
		// search and display results...
		$num = $db->sql_numrows($res);

		if ($num > $maxresults) {
			$num = $maxresults;
			print("<p>Found more than $maxresults posts; displaying first $num.</p>\n");
		}
		
		if ($num == 0)
			print("<p><b>Sorry, nothing found!</b></p>");
		else {
			print("<p><center><table border=1 cellspacing=0 cellpadding=2 width=95%>\n");
			//print("<tr><td class=colhead>Post ID</td><td class=colhead align=left>Topic</td><td class=colhead align=left>Forum</td><td class=colhead align=left>Posted by</td></tr>\n");

			for ($i = 0; $i < $num; ++$i){
				$post = $db->sql_fetchrow($res);

				$res2 = $db->sql_query("SELECT forumid, subject, views, lastpost FROM ".$db_prefix."_forum_topics WHERE id=$post[topicid]") or forumsqlerr();
				$topic = $db->sql_fetchrow($res2);

				$res2 = $db->sql_query("SELECT name,minclassread FROM ".$db_prefix."_forum_forums WHERE id=$topic[forumid]") or forumsqlerr();
				$forum = $db->sql_fetchrow($res2);
				$minread = explode("  ", $forum["minclassread"]);
				if ($forum["name"] == "" OR ($forum["minclassread"] == "0" OR !in_array($user->group,$minread)))
					continue;
				
				$res2 = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$post[userid]") or	forumsqlerr();
				$userp = $db->sql_fetchrow($res2);
$res2 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$post[topicid]") or sqlerr(__FILE__, __LINE__);
$arr = $db->sql_fetchrow($res2);
$posts = $arr[0];
$replies = max(0, $posts - 1);
			$r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=".$user->id."  AND topicid=".$post['topicid']." AND lastpostread=".$topic['lastpost']."") or forumsqlerr(__FILE__, __LINE__);
		$a = $db->sql_fetchrow($r);
		//define the images for new posts or not on index
		if ($a && $a[0] == $topic['lastpost'])
			$img = $folder_icon;
		else
		$img = $topic_unread;
				if ($userp["username"] == "")
					$userp["username"] = "Deluser";
				//print("<tr><td>$post[id]</td><td align=left><a href=forums.php?action=viewtopic&topicid=$post[topicid]#$post[id]><b>" . htmlspecialchars(stripslashes($topic["subject"])) . "</b></a></td><td align=left><a href=forums.php?action=viewforum&amp;forumid=$topic[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a><td align=left><a href=user.php?op=profile&id=$post[userid]><font color=\"".getusercolor(getlevel_name($post['userid']))."\">" . $userp['username'] . "</font></a><br />at $post[added]</tr>\n");
echo"<tr class=\"ftableback\" style=\"font-weight: normal;\"><td>		<span style=\"float: right;\">
			Forum: <a href=forums.php?action=viewforum&amp;forumid=$topic[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a>
		</span>
		<img src=\"themes/".$theme."/forums/".$subforumunread."\" style=\"margin-right: 5px;\">
		$post[added]
	</td>

</tr>
<tr>
	
	<td class=\"alt1\">
	
		<div class=\"smallfont\" style=\"float: right;\">
			Replies: <strong>$replies</strong>
		</div>
		<div>
			  <a href=forums.php?action=viewtopic&topicid=$post[topicid]><b>" . htmlspecialchars(stripslashes($topic["subject"])) . "</b></a>

		</div>
		<div class=\"smallfont\" style=\"float: right;\">
			Views: <strong>".$topic['views']."</strong>
		</div>
		<div class=\"smallfont\">
			Posted By
			<a href=user.php?op=profile&id=$post[userid]><font color=\"".getusercolor(getlevel_name($post['userid']))."\">" . $userp['username'] . "</font></a>
		</div>

		<div class=\"alt2\" style=\"border: 2px groove ; margin: 6px 0px; padding: 6px;\">
			<div class=\"smallfont\"><em>
				<img src=". $themedir ."$img style='margin-right: 5px'>
				<a href=forums.php?action=viewtopic&topicid=$post[topicid]#$post[id]>".CutName ($post['body'], 28)."<br></a>
				<br>".nl2br(CutName ($post['body'], 207))."
</em></div>
		</div>

</td></tr>";
			}
			print("</table></center></p>\n");
			print("<p><b>Search again</b></p>\n");
		}
	}

	print("<center><form method=get action=?>\n");
	print("<input type=hidden name=action value=search>\n");
	print("<table border=0 cellspacing=0 cellpadding=5>\n");
	print("<tr><td valign=bottom align=right>Search For: </td><td align=left><input type=text size=40 name=keywords><br /></td></tr>\n");
	print("<tr><td colspan=2 align=center><input type=submit value='Search' class=btn></td></tr>\n");
	print("</table>\n</form></center>\n");
	forum_table_close();	
	include'footer.php';
	die;
}

///////////////////////////////////////////////////////// Action: UNKNOWN
if ($action != "")
    showerror("Forum Error", "Unknown action '$action'.");

///////////////////////////////////////////////////////// Action: DEFAULT ACTION (VIEW FORUMS)
if (isset($_GET["catchup"]))
	catch_up();

///////////////////////////////////////////////////////// Action: SHOW MAIN FORUM INDEX
$forums_res = $db->sql_query("SELECT ".$db_prefix."_forumcats.id AS fcid, ".$db_prefix."_forumcats.name AS fcname, ".$db_prefix."_forum_forums.* FROM ".$db_prefix."_forum_forums LEFT JOIN ".$db_prefix."_forumcats ON ".$db_prefix."_forumcats.id = ".$db_prefix."_forum_forums.category ORDER BY ".$db_prefix."_forumcats.sort, ".$db_prefix."_forum_forums.sort, ".$db_prefix."_forum_forums.name") or forumsqlerr(__FILE__, __LINE__);

stdhead("Forums");
forum_table("Forum Home", center);
forumheader("Index");
if($show_latest_topic)latestforumposts();

print("<table align=center cellpadding=3 cellspacing=1 class=\"ftable1\" width=100% border=1 >");// MAIN LAYOUT
print("<tr><td align=left width=100% class = ftableback><b> Forum </b></td><td  width=37 align=right class = ftableback><b> Topics <b/></td><td width=47 align=right class = ftableback><b> Posts </b></td><td align=right width=85 class = ftableback><b> Last post </b></td></tr>\n");// head of forum index
$fcid = 0;
while ($forums_arr = $db->sql_fetchrow($forums_res)){
	if ($forums_arr['fcid'] != $fcid) {// add forum cat headers
		print("<tr><td colspan=\"4\" class=\"forumcat\" align=center class = ftableback><b><font size=\"2\">".htmlspecialchars($forums_arr['fcname'])."</font></b></td></tr>\n");
		$fcid = $forums_arr['fcid'];
	}
    if (!$forums_arr["minclassread"] == "0" AND !in_array($user->group,explode(" ", $forums_arr["minclassread"])))
		continue;
    $forumid = 0 + $forums_arr["id"];
    $forumname = htmlspecialchars($forums_arr["name"]);
    $forumdescription = htmlspecialchars($forums_arr["description"]);
	$fmoderatos = "";
	$tstring = '';
	if($forums_arr['show_topic'] == 1){
	$i=0;
	$tstring .= "<div class=\"subforums\"><br><strong>Subforum:<br></strong>";
	$tsql = $db->sql_query("SELECT * FROM `".$db_prefix."_forum_topics` WHERE forumid = ".$forums_arr['id'].";");
	while ($topic_arr = $db->sql_fetchrow($tsql)){
			$r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=".$user->id."  AND topicid=".$topic_arr['id']." AND lastpostread=".$topic_arr['lastpost']."") or forumsqlerr(__FILE__, __LINE__);
		$a = $db->sql_fetchrow($r);
		//define the images for new posts or not on index
		if ($a && $a[0] == $topic_arr['lastpost'])
			$img = $subforumunread;
		else
		$img = $subforumread;
		$i++;
	$tstring .= "<img src=". $themedir ."$img style='margin-right: 5px'><a href=\"forums.php?action=viewtopic&amp;topicid=".$topic_arr['id']."\" title=\"".stripslashes(get_topic_title($topic_arr['id']))."\"><formsub>".CutName(stripslashes(get_topic_title($topic_arr['id'])),10)."</formsub></a>  ";
	if($i >1)
	{
	$i=0;
	$tstring .= "<br>";
	}
	}
	$tstring .= "</div>";
	}
	if(!$forums_arr["moderator"] == "")
	{
	foreach(explode(" ", $forums_arr["moderator"]) as $mod)
	{
	$fmoderatos2[]= "<a href=user.php?op=profile&id=" . $mod . "><font color=\"".getusercolor(getlevel_name($mod))."\">" . username_is($mod) . "</font></a>";
	}
	$fmoderatos = "<br /><p class=\"forumdesc\"><strong>Moderators:</strong> ".implode(", ", $fmoderatos2)."</p>";
	unset($fmoderatos2);
	}
    $topicids_res = $db->sql_query("SELECT id FROM ".$db_prefix."_forum_topics WHERE forumid=$forumid") or forumsqlerr(__FILE__, __LINE__);
	$topiccount = number_format($db->sql_numrows($topicids_res));
    $postcount = 0;
		while ($topicids_arr = $db->sql_fetchrow($topicids_res)) {
			$topicid = $topicids_arr['id'];
			$postcount_res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
			$postcount_arr = $db->sql_fetchrow($postcount_res);
			$postcount += $postcount_arr[0];
		}
    $postcount = number_format($postcount);

    // Find last post ID
    $lastpostid = get_forum_last_post($forumid);

    // Get last post info
    $post_res = $db->sql_query("SELECT added,topicid,userid FROM ".$db_prefix."_forum_posts WHERE id=$lastpostid") or forumsqlerr(__FILE__, __LINE__);
    if ($db->sql_numrows($post_res) == 1) {
		$post_arr = $db->sql_fetchrow($post_res) or die("Bad forum last_post");
		$lastposterid = $post_arr["userid"];
		$lastpostdate = $post_arr["added"];
		$lasttopicid = $post_arr["topicid"];
		$user_res = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$lastposterid") or forumsqlerr(__FILE__, __LINE__);
		$user_arr = $db->sql_fetchrow($user_res);
		$lastposter = htmlspecialchars($user_arr['username']);
		$topic_res = $db->sql_query("SELECT subject FROM ".$db_prefix."_forum_topics WHERE id=$lasttopicid") or forumsqlerr(__FILE__, __LINE__);
		$topic_arr = $db->sql_fetchrow($topic_res);
		$lasttopic = stripslashes(htmlspecialchars($topic_arr['subject']));
		
		//cut last topic
		$latestleng = 10;

		$lastpost = "<nobr><small>$lastpostdate<br /><a href=user.php?op=profile&id=$lastposterid><font color=\"".getusercolor(getlevel_name(getuser($lastposter)))."\">$lastposter</font></a><a href=forums.php?action=viewtopic&topicid=$lasttopicid&page=last#last><img src=\"./themes/$theme/forums/icon_topic_latest.gif\" alt=\"View the latest post\" title=\"View the latest post\" width=\"11\" height=\"8\"></a></small></nobr>";


		$r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=".$user->id." AND topicid=$lasttopicid") or forumsqlerr(__FILE__, __LINE__);
		$a = $db->sql_fetchrow($r);
		//define the images for new posts or not on index
		if ($a && $a[0] == $lastpostid)
			$img = $folder_icon;
		else
		$img = $topic_unread;
    }else{
		$lastpost = "<small>No Posts</small>";
		$img = $folder_icon;
    }
	//following line is each forums display
    print("<tr><td class=alt1 align=left><table class=ftitle border='0' cellspacing=0 cellpadding=0><tr><td style='padding-right: 5px'><img src=". $themedir ."$img></td><td class=alt1><a href=forums.php?action=viewforum&forumid=$forumid><b>$forumname</b></a><br />\n" .
    "<SMALL>- $forumdescription</SMALL><br />$tstring$fmoderatos</td></tr></table></td><td class=alt2 align=center>$topiccount</td></td><td class=alt1 align=center>$postcount</td>" .
    "<td class=alt2 align=center>$lastpost</td></tr>\n");
}
print("</table>");
legend();
//Top posters
$r = $db->sql_query("SELECT ".$db_prefix."_users.id, ".$db_prefix."_users.username, COUNT(".$db_prefix."_forum_posts.userid) as num FROM ".$db_prefix."_forum_posts LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_users.id = ".$db_prefix."_forum_posts.userid GROUP BY userid ORDER BY num DESC LIMIT 10") or forumsqlerr();
forumpostertable($r, "Top 10 Posters");

//topic count and post counts
$postcount = number_format(get_row_count("".$db_prefix."_forum_posts"));
$topiccount = number_format(get_row_count("".$db_prefix."_forum_topics"));
print("<br><center>Our members have made " . $postcount . " posts in  " . $topiccount . " topics</center><BR>");

insert_quick_jump_menu();
forum_table_close();
stdfoot();

include'footer.php';
}ELSE{//HEY IF FORUMS ARE OFF, SHOW THIS...
	forum_table("Notice", center);
	echo '<BR>Unfortunately The Forums Are Not Currently Available<BR><BR>';
	if($board_disable_msg != ""){
	$board_disable_msg = format_comment($board_disable_msg);
	parse_smiles($board_disable_msg);
	echo $board_disable_msg;
	}
	forum_table_close();

include'footer.php';
}

}

include'footer.php';
?>