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
include("header.php");
$forumbanned = $CURUSER["forumbanned"];
if ($forumbanned == "yes") {
	stdhead("Banned");
	begin_frame("Notice", center);
	echo '<BR><b>Unfortunately you have been banned from accessing the forums.  Please contact a member of staff if you do not know the reason.</b><BR><BR>';
	end_frame();
	stdfoot();
}else{
$FORUMS = true;
//Here we decide if the forums is on or off
if ($FORUMS)
{
//define the clickable smilies
function stdhead($title = '', $width = '')
{
}
function begin_frame($title = '', $width = '')
{
        global $tableopen, $siteurl;
OpenTable($title, $width);
}
function quicktags(){
	echo "<center><table border=0 cellpadding=0 cellspacing=0><tr>";
	echo "<td width=26><a href=\"javascript:Smilies(':)')\"><img src=images/smilies/smile1.gif border=0 alt=':)'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(';)')\"><img src=images/smilies/wink.gif border=0 alt=';)'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':D')\"><img src=images/smilies/grin.gif border=0 alt=':D'></a></td>";
	echo "</tr><tr>";
	echo "<td width=26><a href=\"javascript:Smilies(':P')\"><img src=images/smilies/tongue.gif border=0 alt=':P'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':lol:')\"><img src=images/smilies/laugh.gif border=0 alt=':lol:'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':yes:')\"><img src=images/smilies/yes.gif border=0 alt=':yes:'></a></td>";
	echo "</tr><tr>";
	echo "<td width=26><a href=\"javascript:Smilies(':no:')\"><img src=images/smilies/no.gif border=0 alt=':no:'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':wave:')\"><img src=images/smilies/wave.gif border=0 alt=':wave:'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':ras:')\"><img src=images/smilies/ras.gif border=0 alt=':ras:'></a></td>";
	echo "</tr><tr>";
	echo "<td width=26><a href=\"javascript:Smilies(':sick:')\"><img src=images/smilies/sick.gif border=0 alt=':sick:'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':yucky:')\"><img src=images/smilies/yucky.gif border=0 alt=':yucky:'></a></td>";
	echo "<td width=26><a href=\"javascript:Smilies(':rolleyes:')\"><img src=images/smilies/rolleyes.gif border=0 alt=':rolleyes:'></a></td>";
	echo "</tr></table>";
	echo "<br><a href=smilies.php target=_blank>[More Smilies]</a><br><br><a href=tags.php target=_blank>[BB Tags]</a></center>";
}

//define the clickable tags
function quickbb(){
	echo "<center><table border=0 cellpadding=0 cellspacing=2><tr>";
	echo "<tr>";
	echo "<td width=22><a href=\"javascript:Smilies('[b] [/b]')\"><img src=/images/bbcode/bbcode_bold.gif border=0 alt='Bold'></a></td>";
	echo "<td width=22><a href=\"javascript:Smilies('[i] [/i]')\"><img src=/images/bbcode/bbcode_italic.gif border=0 alt='Italic'></a></td>";
	echo "<td width=22><a href=\"javascript:Smilies('[u] [/u]')\"><img src=/images/bbcode/bbcode_underline.gif border=0 alt='Underline'></a></td></tr>";
	echo "<tr><td width=22><a href=\"javascript:Smilies('[center] [/center]')\"><img src=/images/bbcode/bbcode_center.gif border=0 alt='Center'></a></td>";
	echo "<td width=22><a href=\"javascript:Smilies('[url] [/url]')\"><img src=/images/bbcode/bbcode_url.gif border=0 alt='Url'></a></td>";
	echo "<td width=22><a href=\"javascript:Smilies('[img] [/img]')\"><img src=/images/bbcode/bbcode_image.gif border=0 alt='Img'></a></td>";
	echo "</tr></table>";
}

if ($CURUSER){
	$ss_a = @mysql_fetch_array(@mysql_query("select uri from stylesheets where id=" . $CURUSER["stylesheet"]));
	if ($ss_a) $ss_uri = $ss_a["uri"];
	$themedir = "" . $SITEURL . "/themes/" . $ss_uri . "/forums/";
}

//setup the forum head aread
function forumheader($location){
echo "<table align=center cellpadding=0 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1><tr><td><table  width='100%' cellspacing='5' border=0 bgcolor=#E0F1FE ><tr><td><a href='forums.php'>Welcome to our Forums</a></td><td align='right'><img src='images/atb_help.gif' border='0' alt='' />&nbsp;<a href='faq.php'>FAQ</a>&nbsp; &nbsp;&nbsp;<img src='images/atb_search.gif' border='0' alt='' />&nbsp;<a href='forums.php?action=search'>Search</a></td></tr></table><table width='100%' cellspacing='5' border=0 bgcolor=#E0F1FE><tr><td><strong>&nbsp;</td><td align='right'><b>Controls</a></b> &middot; <a href='forums.php?action=viewunread'>View New Posts</a> &middot; <a href='?catchup'>Mark All Read</a></td></tr></table></td></tr></table><br />";
print ("<table align=center cellpadding=0 cellspacing=5 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 bgcolor=#E0F1FE><tr><td><div align='left'>You are in: &nbsp;<a href='forums.php'>Forums</a> > $location</b></div></td></tr></table><br />");
}


$action = strip_tags($HTTP_GET_VARS["action"]);

//Handle SQL Errors
function forumsqlerr($file = '', $line = '')//handle errors
{
  print("<table border=0 align=left cellspacing=0 cellpadding=10>" .
    "<tr><td class=embedded><font color=white><h1>SQL Error</h1>\n" .
  "<b>" . mysql_error() . ($file != '' && $line != '' ? "<p>in $file, line $line</p>" : "") . "</b></font></td></tr></table>");
  die;
}

function showerror($heading = "Error", $text, $sort = "Error") {
  stdhead("$sort: $heading");
  begin_frame("<font color=red>$sort: $heading</font>", center);
  echo $text;
  end_frame();
  stdfoot();
  die;
}

// Mark all forums as read
function catch_up(){ 
	global $CURUSER;
	$userid = $CURUSER["id"];
	$res = mysql_query("SELECT id, lastpost FROM forum_topics") or forumsqlerr(__FILE__, __LINE__);
	while ($arr = mysql_fetch_assoc($res)) {
		$topicid = $arr["id"];
		$postid = $arr["lastpost"];
		$r = mysql_query("SELECT id,lastpostread FROM forum_readposts WHERE userid=$userid and topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($r) == 0){
			mysql_query("INSERT INTO forum_readposts (userid, topicid, lastpostread) VALUES($userid, $topicid, $postid)") or forumsqlerr(__FILE__, __LINE__);
		}else{
			$a = mysql_fetch_assoc($r);
			if ($a["lastpostread"] < $postid)
			mysql_query("UPDATE forum_readposts SET lastpostread=$postid WHERE id=" . $a["id"]) or forumsqlerr(__FILE__, __LINE__);
		}
	}
}

// Returns the minimum read/write class levels of a forum
function get_forum_access_levels($forumid){ 
	$res = mysql_query("SELECT minclassread, minclasswrite FROM forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) != 1)
		return false;
	$arr = mysql_fetch_assoc($res);
		return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"]);
}

// Returns the forum ID of a topic, or false on error
function get_topic_forum($topicid) {
    $res = mysql_query("SELECT forumid FROM forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) != 1)
      return false;
    $arr = mysql_fetch_row($res);
    return $arr[0];
}

// Returns the ID of the last post of a forum
function update_topic_last_post($topicid) {
    $res = mysql_query("SELECT id FROM forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res) or die("No post found");
    $postid = $arr[0];
    mysql_query("UPDATE forum_topics SET lastpost=$postid WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
}

function get_forum_last_post($forumid)  {
    $res = mysql_query("SELECT lastpost FROM forum_topics WHERE forumid=$forumid ORDER BY lastpost DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res);
    $postid = $arr[0];
    if ($postid)
      return $postid;
    else
      return 0;
}
function encodehtml($html)
{
return $html;
}
//Top forum posts
function forumpostertable($res, $frame_caption) {
	print("$frame_caption<br><table width=160 border=0><tr><td>\n");
	print("<table align=center cellpadding=1 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 >");
	?>
	<tr>
	<td width="10"><font size=1 face=Verdana><b>Rank</b></td>
	<td width="130" align=left><font size=1 face=Verdana><b>User</b></td>
	<td width="10" align=right><font size=1 face=Verdana><b>Posts</b></td>
	</tr>
	<?
    $num = 0;
    while ($a = mysql_fetch_assoc($res))
    {
      ++$num;
      print("<tr><td class=alt1>$num</td><td class=alt2 align=left><a href=account-details.php?id=$a[id]><b>$a[username]</b></td><td align=right class=alt1>$a[num]</td></tr>\n");
    }
  print("</table>");
	 print("</td></tr></table>\n");
}

// Inserts a quick jump menu
function insert_quick_jump_menu($currentforum = 0) {
    print("<p align=right><form method=get action=? name=jump>\n");
    print("<input type=hidden name=action value=viewforum>\n");
    print("Quick Jump: ");
    print("<select name=forumid onchange=\"if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }\">\n");
    $res = mysql_query("SELECT * FROM forum_forums ORDER BY name") or forumsqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res)) {
      if (10 >= $arr["minclassread"])
        print("<option value=" . $arr["id"] . ($currentforum == $arr["id"] ? " selected>" : ">") . $arr["name"] . "\n");
    }
    print("</select>\n");
    print("<input type=image class=btn src=images/go.gif border=0>\n");
   // print("<input type=submit value='Go!'>\n");
    print("</form>\n</p>");
}

// Inserts a compose frame
function insert_compose_frame($id, $newtopic = true) {
    global $maxsubjectlength;

	if ($newtopic) {
		$res = mysql_query("SELECT name FROM forum_forums WHERE id=$id") or forumsqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res) or die("Bad forum id");
		$forumname = stripslashes($arr["name"]);

		print("<p align=center><b>New topic in <a href=forums.php?action=viewforum&forumid=$id>$forumname</a></b></p>\n");
	}else{
		$res = mysql_query("SELECT * FROM forum_topics WHERE id=$id") or forumsqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res) or showerror("Forum error", "Topic not found.");
		$subject = stripslashes($arr["subject"]);
		print("<p align=center>Reply to topic: <a href=forums.php?action=viewtopic&topicid=$id>$subject</a></p>");
	}

    print("<p align=center>Flaming or other anti-social behavior will not be tolerated.\n");
    print("<br>Please do try not to discuss upload/release-specific stuff here, post a torrent comment instead!<br><br><B>Please make sure to read the <a href=rules.php>rules</a> before you post</B><br></p>\n");

    begin_frame("Compose Message", true);
    print("<form name=Form method=post action=?action=post>\n");
    if ($newtopic)
      print("<input type=hidden name=forumid value=$id>\n");
    else
      print("<input type=hidden name=topicid value=$id>\n");
  print("<table border=0 width=100%>");

    if ($newtopic){
			print("<center><table border=0 cellpadding=0 cellspacing=0><tr><td colspan=3>&nbsp;</td></tr><tr><td> <b>Subject:</b></td><td width=10>&nbsp;</td><td><input type=text size=70 maxlength=$maxsubjectlength name=subject ></td></tr><tr><td valign=top>");
			quickbb();
			quicktags();
			print("</td><td width=10>&nbsp;</td><td class=alt1 align=left style='padding: 0px'><textarea name=body cols=70 rows=20></textarea></td></tr><tr><td colspan=3 align=center><br><input type=submit class=btn value='Submit'><br><br></td></tr></center>");
	
	}
    print("</table>");
    print("</form>\n");

    end_frame();

	insert_quick_jump_menu();
}

//LASTEST FORUM POSTS
function latestforumposts() {
global $db_prefix;
print("<b>Latest Topics</b><br>");
print("<table align=center cellpadding=1 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 ><tr>".
"<td bgcolor=#E0F1FE align=left  width=100%><b>Topic Title</b></td>". 
"<td bgcolor=#E0F1FE align=center width=47><b>Replies</b></td>".
"<td bgcolor=#E0F1FE align=center width=47><b>Views</b></td>".
"<td bgcolor=#E0F1FE align=center width=85><b>Author</b></td>".
"<td bgcolor=#E0F1FE align=right width=85><b>Last Post</b></td>".
"</tr>");


/// HERE GOES THE QUERY TO RETRIEVE DATA FROM THE DATABASE AND WE START LOOPING ///
$for = mysql_query("SELECT * FROM forum_topics ORDER BY lastpost DESC LIMIT 5");

while ($topicarr = mysql_fetch_assoc($for)) {
// Set minclass
$res = mysql_query("SELECT name,minclassread FROM forum_forums WHERE id=$topicarr[forumid]") or sqlerr();
$forum = mysql_fetch_assoc($res);

if ($forum["minclassread"] == '0'){
$forumname = "<a href=?action=viewforum&amp;forumid=$topicarr[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a>";

$topicid = $topicarr["id"];
$topic_title = stripslashes($topicarr["subject"]);
$topic_userid = $topicarr["userid"];
// Topic Views
$views = $topicarr["views"];
// End

/// GETTING TOTAL NUMBER OF POSTS ///
$res = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
$posts = $arr[0];
$replies = max(0, $posts - 1);

/// GETTING USERID AND DATE OF LAST POST ///   
$res = mysql_query("SELECT * FROM forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
$postid = 0 + $arr["id"];
$userid = 0 + $arr["userid"];
$added = "<nobr>" . $arr["added"] . "</nobr>";

/// GET NAME OF LAST POSTER ///
$res = mysql_query("SELECT id, username FROM ".$db_prefix."_users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 1) {
$arr = mysql_fetch_assoc($res);
$username = "<a href=account-details.php?id=$userid>$arr[username]</a>";
}
else
$username = "Unknown[$topic_userid]";

/// GET NAME OF THE AUTHOR ///
$res = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$topic_userid") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 1) {
$arr = mysql_fetch_assoc($res);
$author = "<a href=account-details.php?id=$topic_userid>$arr[username]</a>";
}
else
$author = "Unknown[$topic_userid]";

/// GETTING THE LAST INFO AND MAKE THE TABLE ROWS ///
$r = mysql_query("SELECT lastpostread FROM forum_readposts WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);
$new = !$a || $postid > $a[0];
$subject = "<a href=forums.php?action=viewtopic&topicid=$topicid><b>" . stripslashes(encodehtml($topicarr["subject"])) . "</b></a>";

print("<tr class=alt1><td style='padding-right: 5px'>$subject</td>".
"<td class=alt2 align=center>$replies</td>" .
"<td class=alt1 align=center>$views</td>" .
"<td class=alt1 align=center>$author</td>" .
"<td class=alt2 align=right><nobr><small>by&nbsp;$username<br>$added</small></nobr></td>");

print("</tr>");
} // while
}
print("</table><br>");
} // end function

//Global variables
$postsperpage = 20;
$maxsubjectlength = 50;

//Action: New topic
if ($action == "newtopic") {
    $forumid = $_GET["forumid"];
    if (!is_valid_id($forumid))
      die;
    stdhead("New topic");
    begin_frame("New topic");

	forumheader("Compose New Thread");

    insert_compose_frame($forumid);
    end_frame();
    stdfoot();
    die;
}

///////////////////////////////////////////////////////// Action: POST
if ($action == "post") {
	$forumid = $_POST["forumid"];
	$topicid = $_POST["topicid"];
	if (!is_valid_id($forumid) && !is_valid_id($topicid))
		die("w00t");
	$newtopic = $forumid > 0;
	$subject = $_POST["subject"];
	if ($newtopic) {
		if (!$subject)
			showerror("Error", "You must enter a subject.");
		$subject = trim($subject);
		//if (!$subject)
			//showerror("Error", "You must enter a subject.");
		//showerror("Error", "Subject is limited to $maxsubjectlength characters.");
	}else{
      $forumid = get_topic_forum($topicid) or die("Bad topic ID");
	}

    ////// Make sure sure user has write access in forum
	$arr = get_forum_access_levels($forumid) or die("Bad forum ID");
	if (10 < $arr["write"])
		die("Not permitted");
	$body = trim($_POST["body"]);
	if (!$body)
		showerror("Error", "No body text.");
	$userid = $CURUSER["id"];

	if ($newtopic) { //Create topic
		$subject = sqlesc($subject);
		mysql_query("INSERT INTO forum_topics (userid, forumid, subject) VALUES($userid, $forumid, $subject)") or forumsqlerr(__FILE__, __LINE__);

		//IRC ANNOUNCE THE POST
		if ($IRCANNOUNCE){
			$user = mysql_fetch_array(mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$userid"));
			$user = $user["username"];
			$msg_bt = chr(3)."9".chr(2)." $SITENAME".chr(2)." -".chr(3)."7 New Forum Topic: (".chr(3)."15 ".stripslashes($subject).chr(3)."7 ) Posted By: (".chr(3)."15 $user".chr(3)."7 ) Link: (".chr(3)."15 $SITEURL/forums.php".chr(3)."7 )\r\n";
			$fs = fsockopen($ANNOUNCEIP, $ANNOUNCEPORT, $errno, $errstr);
				if($fs) {
				   fwrite($fs, $msg_bt);
				   fclose($fs);
				}
		}//END IRC ANNOUNCE

		$topicid = mysql_insert_id() or die("No topic ID returned");

	}else{
		//Make sure topic exists and is unlocked
		$res = mysql_query("SELECT * FROM forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res) or die("Topic id n/a");
		if ($arr["locked"] == 'yes')
			die;
		//Get forum ID
		$forumid = $arr["forumid"];
    }

    //Insert the new post
    $added = "'" . get_date_time() . "'";
    $body = sqlesc($body);
    mysql_query("INSERT INTO forum_posts (topicid, userid, added, body) VALUES($topicid, $userid, $added, $body)") or forumsqlerr(__FILE__, __LINE__);
    $postid = mysql_insert_id() or die("Post id n/a");

    //Update topic last post
    update_topic_last_post($topicid);

    //All done, redirect user to the post
    $headerstr = "Location: $SITEURL/forums.php?action=viewtopic&topicid=$topicid&page=last";
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
	$userid = $CURUSER["id"];

    //------ Get topic info
    $res = mysql_query("SELECT * FROM forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_assoc($res) or showerror("Forum error", "Topic not found");
    $locked = ($arr["locked"] == 'yes');
    $subject = stripslashes($arr["subject"]);
	$sticky = $arr["sticky"] == "yes";
    $forumid = $arr["forumid"];

	// Update Topic Views
	$viewsq = mysql_query("SELECT views FROM forum_topics WHERE id=$topicid");
	$viewsa = mysql_fetch_array($viewsq);
	$views = $viewsa[0];
	$new_views = $views+1;
	$uviews = mysql_query("UPDATE forum_topics SET views = $new_views WHERE id=$topicid");
	// End

    //------ Get forum
    $res = mysql_query("SELECT * FROM forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_assoc($res) or showerror("Forum error", "Forum is empty");
    $forum = stripslashes($arr["name"]);

    //------ Get post count
    $res = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res);
    $postcount = $arr[0];

    //------ Make page menu
    $pagemenu = "<br><small>\n";
    $perpage = $postsperpage;
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
    $res = mysql_query("SELECT * FROM forum_posts WHERE topicid=$topicid ORDER BY id LIMIT $offset,$perpage") or forumsqlerr(__FILE__, __LINE__);

    stdhead("View Topic: $subject");
    begin_frame("$forum &gt; $subject", center);
	forumheader("<a href=forums.php?action=viewforum&forumid=$forumid>$forum</a> > $subject");
	
	print ("<table align=center cellpadding=0 cellspacing=5 width=100% border=0 ><tr><td>");
	
	if (!$locked){
		print ("<div align='right'><a href=#bottom><img src=" . $themedir . "button_reply.gif border=0></a></div>");
	}else{
		print ("<div align='right'><img src=" . $themedir . "button_locked.gif border=0 alt=Locked></div>");
	}
	print ("</td></tr></table>");

//------ Print table of posts
    $pc = mysql_num_rows($res);
    $pn = 0;
    $r = mysql_query("SELECT lastpostread FROM forum_readposts WHERE userid=" . $CURUSER["id"] . " AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $a = mysql_fetch_row($r);
    $lpr = $a[0];
    if (!$lpr)
		mysql_query("INSERT INTO forum_readposts (userid, topicid) VALUES($userid, $topicid)") or forumsqlerr(__FILE__, __LINE__);

    while ($arr = mysql_fetch_assoc($res)) {
		++$pn;
		$postid = $arr["id"];
		$posterid = $arr["userid"];
		$added = $arr["added"] . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . " ago)";

		//---- Get poster details
		$res4 = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE userid=$posterid") or forumsqlerr();
		$arr33 = mysql_fetch_row($res4);
		$forumposts = $arr33[0];

		$res2 = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE id=$posterid") or forumsqlerr(__FILE__, __LINE__);
		$arr2 = mysql_fetch_assoc($res2);
		$postername = $arr2["username"];

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
				$avatar = htmlspecialchars($arr2["avatar"]);
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
						$res4 = mysql_query("SELECT name,flagpic FROM countries WHERE id=$arr2[country] LIMIT 1") or forumsqlerr();
						$arr4 = mysql_fetch_assoc($res4);
						$usercountry = $arr4["name"];
					}

				$title = strip_tags($arr2["title"]);
				$donated = $arr2['donated'];
				$by = "<a href=account-details.php?id=$posterid><b>$postername</b></a>" . ($donated > 0 ? "<img src=".$SITEURL."/images/star.gif alt='Donated'>" : "") . "";
			}

		if (!$avatar)
			$avatar = $SITEURL ."/images/default_avatar.gif";
		print("<a name=$postid>\n");

		if ($pn == $pc) {
			print("<a name=last>\n");
			if ($postid > $lpr)
			mysql_query("UPDATE forum_readposts SET lastpostread=$postid WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
		}
//working here

		print("<table align=center cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor=646262 width=100% border=1 bgcolor=#E0F1FE><tr><td width=150 align=center>$by<td with=100% align=left><small>Posted at $added </small></tr></table>");

		print("<table align=center cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1>\n");

		$body = stripslashes(format_comment($arr["body"]));

		if($CENSORWORDS) {//bad word censor
			$query = 'SELECT * FROM censor';
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$body = str_replace($row['word'], $row['censor'], $body);
			}
		}//censor end

		if (is_valid_id($arr['editedby'])) {
			$res2 = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$arr[editedby]");

			if (mysql_num_rows($res2) == 1) {
				$arr2 = mysql_fetch_assoc($res2);
				//edited by comment out if needed
				$body .= "<br><br><font size=1 class=small><i>Last edited by <a href=account-details.php?id=$arr[editedby]>$arr2[username]</b></a> on $arr[editedat]</i></font><br>\n";
				$body .= "\n";
			}
		}

		$quote = htmlspecialchars($arr["body"]);

		$postcount1 = mysql_query("SELECT COUNT(forum_posts.userid) FROM forum_posts WHERE id=$posterid") or forumsqlerr();

		while($row = mysql_fetch_array($postcount1)) {

			if  ($privacylevel == "strong" && !$user->admin){//hide stats, but not from staff
				$useruploaded = "---";
				$userdownloaded = "---";
				$userratio = "---";
				$nposts = "-";
				$tposts = "-";
			}
			print ("<tr valign=top><td width=150 align=left><center><i>$title</i></center><br><center><img width=80 height=80 src=\"$avatar\"></center><br>Uploaded: $useruploaded<br>Downloaded: $userdownloaded<br>Posts: $forumposts<br><br>Ratio: $userratio<br>Location: $usercountry<br><br></td>");

			print ("<td class=comment>$body<br>");

			if (!$usersignature){
				print("<br><br></td></tr>\n");
			}else{
				print("<br><br>---------------<br>$usersignature</td></tr>\n");
			}
		}

	    print("</table>\n");

	print("<table align=center cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor=646262 width=100% border=1 bgcolor=#E0F1FE><tr><td width=150 align=center><nobr> <a href=account-details.php?id=$posterid><img src=".$themedir."icon_profile.gif border=0></a> <a href=account-inbox.php?receiver=$postername><img src=".$themedir."icon_pm.gif border=0></a> </nobr><td with=100%>");

	print ("<div style='float: left;'><a href=report.php?forumid=$topicid&forumpost=$postid><img src=".$themedir."p_report.gif border='0' alt='Report This Post'></a>&nbsp;<a href='javascript:scroll(0,0);'><img src=".$themedir."p_up.gif border='0' alt='Go to the top of the page'></a></div><div align=right>");
	
	//define buttons and who can use them
	if ($CURUSER["id"] == $posterid || $user->admin){
		print ("<a href='forums.php?action=editpost&postid=$postid'><img src=".$themedir."p_edit.gif border='0' ></a>&nbsp;");
	}
	if ($user->admin){
		print ("<a href='forums.php?action=deletepost&postid=$postid&sure=0'><img src=".$themedir."p_delete.gif border='0' ></a>&nbsp;");
	}
	if (!$locked){
		print ("<a href=\"javascript:Smilies('[quote] $quote [/quote]')\"><img src=".$themedir."p_quote.gif border='0' ></a>&nbsp;");
		print ("<a href='#bottom'><img src=".$themedir."p_reply.gif border='0' ></a>");
	}
		print("&nbsp;</div></td></tr></table>");
		print("</p>\n");// post seperate
	}
//-------- end posts table ---------//
	print($pagemenu);

	//quick reply
	if (!$locked){
	//begin_frame("Reply", $newtopic = false);
	print ("<table align=center cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor=646262 width=100% border=1 bgcolor=#E0F1FE><TR><TD><BR><CENTER><B>POST REPLY</B></CENTER><BR>");
	$newtopic = false;
	print("<a name=\"bottom\"></a>");
    print("<form name=Form method=post action=?action=post>\n");
    if ($newtopic)
		print("<input type=hidden name=forumid value=$id>\n");
    else
		print("<input type=hidden name=topicid value=$topicid>\n");

    print("<center><table border=0 cellspacing=0 cellpadding=0>");
    if ($newtopic)
		print("<tr><td class=alt2>Subject</td><td class=alt1 align=left style='padding: 0px'><input type=text size=100 maxlength=$maxsubjectlength name=subject style='border: 0px; height: 19px'></td></tr>\n");

	print("<tr><td>");
	quickbb();
	quicktags();
	print("</td><td width=10>&nbsp;</td><td align=left><textarea name=body cols=60 rows=10></textarea></td>\n");
	print("<td>&nbsp;</td></tr>\n");
    print("<tr><td colspan=3 align=center><br><input type=image class=btn src=".$themedir."button_reply.gif border=0></td></tr>\n");
    print("</table></form></center>\n");
	//end_frame();
	print ("</TD></TR></TABLE>");
	}else{
	print ("<CENTER><img src=".$themedir."button_locked.gif alt=Locked></CENTER>");
	}
	//end quick reply

	if ($locked)
		print("<p>This topic is locked; no new posts are allowed.</p>\n");
    else {
      $arr = get_forum_access_levels($forumid) or die;
      if (10 < $arr["write"])
		print("<p><i>You are not permitted to post in this forum.</i></p>\n");
      else
        $maypost = true;
    }

    //insert page numbers and quick jump

   // insert_quick_jump_menu($forumid);

	// MODERATOR OPTIONS
    if ($user->admin) {
    	end_frame();
		begin_frame("Moderator Options");
      $res = mysql_query("SELECT id,name,minclasswrite FROM forum_forums ORDER BY name") or forumsqlerr(__FILE__, __LINE__);
      print("<table border=0 cellspacing=0 cellpadding=0>\n");
      print("<form method=post action=forums.php?action=renametopic>\n");
      print("<input type=hidden name=topicid value=$topicid>\n");
      print("<input type=hidden name=returnto value=$HTTP_SERVER_VARS[REQUEST_URI]>\n");
	  print("<tr><td class=embedded align=right>Rename topic:</td><td class=embedded><input type=text name=subject size=60 maxlength=$maxsubjectlength value=\"" . stripslashes(htmlspecialchars($subject)) . "\">\n");
      print("<input type=submit value='Apply'></td></tr>");
      print("</form>\n");
      print("<form method=post action=forums.php?action=movetopic&topicid=$topicid>\n");
      print("<tr><td class=embedded align=right>Move this thread to:&nbsp;</td><td class=embedded><select name=forumid>");
      while ($arr = mysql_fetch_assoc($res))
        if ($arr["id"] != $forumid && 10 >= $arr["minclasswrite"])
          print("<option value=" . $arr["id"] . ">" . $arr["name"] . "\n");
      print("</select> <input type=submit value='Apply'></form></td></tr>\n");
      print("</table>\n");

//
 print("<table width=100%><tr><td align=center>\n");
			if ($locked)
				print("Locked: <a href=forums.php?action=unlocktopic&forumid=$forumid&topicid=$topicid&page=$page title='Unlock'><img src=". $themedir ."topic_unlock.gif border=0 alt=UnLock Topic></a>\n");
			else
				print("Locked: <a href=forums.php?action=locktopic&forumid=$forumid&topicid=$topicid&page=$page title='Lock'><img src=". $themedir ."topic_lock.gif border=0 alt=Lock Topic></a>\n");
			print("Delete Entire Topic: <a href=forums.php?action=deletetopic&topicid=$topicid&sure=0 title='Delete'><img src=". $themedir ."topic_delete.gif border=0 alt=Delete Topic></a>\n");
			if ($sticky)
			   print("Sticky: <a href=forums.php?action=unsetsticky&forumid=$forumid&topicid=$topicid&page=$page title='UnStick'><img src=". $themedir ."folder_sticky_new.gif border=0 alt=UnStick Topic></a>\n");
			else
			   print("Sticky: <a href=forums.php?action=setsticky&forumid=$forumid&topicid=$topicid&page=$page title='Stick'><img src=". $themedir ."folder_sticky.gif border=0 alt=Stick Topic></a>\n");
			print("</td></tr></table>\n");
//

    }
    end_frame();

    stdfoot();
    die;
}

///////////////////////////////////////////////////////// Action: REPLY
if ($action == "reply") {
	$topicid = $_GET["topicid"];
	if (!is_valid_id($topicid))
		die;
	stdhead("Post reply");
	begin_frame("Post reply");
	insert_compose_frame($topicid, false);
	end_frame();
	stdfoot();
	die;
}

///////////////////////////////////////////////////////// Action: MOVE TOPIC
if ($action == "movetopic") {
    $forumid = $_POST["forumid"];
    $topicid = $_GET["topicid"];
    if (!is_valid_id($forumid) || !is_valid_id($topicid) || !$user->admin)
		die;

    // Make sure topic and forum is valid
    $res = @mysql_query("SELECT minclasswrite FROM forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) != 1)
      showerror("Error", "Forum not found.");
    $arr = mysql_fetch_row($res);
    if (10 < $arr[0])
      die;
    $res = @mysql_query("SELECT subject,forumid FROM forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) != 1)
      showerror("Error", "Topic not found.");
    $arr = mysql_fetch_assoc($res);
    if ($arr["forumid"] != $forumid)
      @mysql_query("UPDATE forum_topics SET forumid=$forumid, moved='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);

    // Redirect to forum page
    header("Location: $SITEURL/forums.php?action=viewforum&forumid=$forumid");
    die;
}

///////////////////////////////////////////////////////// Action: DELETE TOPIC
if ($action == "deletetopic") {
	$topicid = $_GET["topicid"];
	if (!is_valid_id($topicid) || !$user->admin)
		die;
	
	$sure = $_GET["sure"];
	if ($sure == "0") 
		showerror("Delete topic", "Sanity check: You are about to delete a topic. Click <a href=forums.php?action=deletetopic&topicid=$topicid&sure=1>here</a> if you are sure.");

	mysql_query("DELETE FROM forum_topics WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
	mysql_query("DELETE FROM forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
	header("Location: $SITEURL/forums.php");
	die;
}

///////////////////////////////////////////////////////// Action: EDIT TOPIC
if ($action == "editpost") {
	$postid = $HTTP_GET_VARS["postid"];
	if (!is_valid_id($postid))
		die;
    $res = mysql_query("SELECT * FROM forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) != 1)
		showerror("Error", "No post with ID $postid.");
	$arr = mysql_fetch_assoc($res);
    if ($CURUSER["id"] != $arr["userid"] && !$user->admin)
		showerror("Error", "Denied!");

    if ($HTTP_SERVER_VARS['REQUEST_METHOD'] == 'POST') {
		$body = $HTTP_POST_VARS['body'];
			if ($body == "")
				showerror("Error", "Body cannot be empty!");
		$body = sqlesc($body);
		$editedat = sqlesc(get_date_time());
		mysql_query("UPDATE forum_posts SET body=$body, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
		$returnto = $HTTP_POST_VARS["returnto"];
			if ($returnto != "")
				header("Location: $returnto");
			else
				showerror("Success", "Post was edited successfully.");
	}

    stdhead();

    begin_frame("Edit Post");
    print("<form name=Form method=post action=?action=editpost&postid=$postid>\n");
    print("<input type=hidden name=returnto value=\"" . htmlspecialchars($HTTP_SERVER_VARS["HTTP_REFERER"]) . "\">\n");
    print("<center><table border=0 cellspacing=0 cellpadding=5>\n");
    print("<tr><td>\n");
	quicktags();
	print("</td><td style='padding: 0px'><textarea name=body cols=50 rows=20 >" . stripslashes(htmlspecialchars($arr["body"])) . "</textarea></td></tr>\n");
    print("<tr><td align=center colspan=2><input type=submit value='Submit Changes' class=btn></td></tr>\n");
    print("</table></center>\n");
    print("</form>\n");
    end_frame();
    stdfoot();
    die;
}

///////////////////////////////////////////////////////// Action: DELETE POST
if ($action == "deletepost") {
	$postid = $_GET["postid"];
	$sure = $_GET["sure"];
	if (!$user->admin || !is_valid_id($postid))
		die;

    //SURE?
	if ($sure == "0") {
		showerror("Delete post", "Sanity check: You are about to delete a post. Click <a href=forums.php?action=deletepost&postid=$postid&sure=1>here</a> if you are sure.");
    }

	//------- Get topic id
    $res = mysql_query("SELECT topicid FROM forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res) or showerror("Error", "Post not found");
    $topicid = $arr[0];

    //------- We can not delete the post if it is the only one of the topic
    $res = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res);
    if ($arr[0] < 2)
		showerror("Error", "Can't delete post; it is the only post of the topic. You should <a href=forums.php?action=deletetopic&topicid=$topicid&sure=1>delete the topic</a> instead.\n");

    //------- Delete post
    mysql_query("DELETE FROM forum_posts WHERE id=$postid") or forumsqlerr(__FILE__, __LINE__);

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
	mysql_query("UPDATE forum_topics SET locked='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
	header("Location: $SITEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
	die;
}

///////////////////////////////////////////////////////// Action: UNLOCK TOPIC
if ($action == "unlocktopic") {
    $forumid = $_GET["forumid"];
    $topicid = $_GET["topicid"];
    $page = $_GET["page"];
    if (!is_valid_id($topicid) || !$user->admin)
		die;
    mysql_query("UPDATE forum_topics SET locked='no' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
    header("Location: $SITEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
    die;
}

///////////////////////////////////////////////////////// Action: STICK TOPIC
if ($action == "setsticky") {
   $forumid = $_GET["forumid"];
   $topicid = $_GET["topicid"];
   $page = $_GET["page"];
   if (!is_valid_id($topicid) || !$user->admin)
		die;
   mysql_query("UPDATE forum_topics SET sticky='yes' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
   header("Location: $SITEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
   die;
}

///////////////////////////////////////////////////////// Action: UNSTICK TOPIC
if ($action == "unsetsticky") {
   $forumid = $_GET["forumid"];
   $topicid = $_GET["topicid"];
   $page = $_GET["page"];
   if (!is_valid_id($topicid) || !$user->admin)
     die;
   mysql_query("UPDATE forum_topics SET sticky='no' WHERE id=$topicid") or forumsqlerr(__FILE__, __LINE__);
   header("Location: $SITEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
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
  	$subject = sqlesc($subject);
  	mysql_query("UPDATE forum_topics SET subject=$subject WHERE id=$topicid") or forumsqlerr();
  	$returnto = $HTTP_POST_VARS['returnto'];
  	if ($returnto)
		header("Location: $returnto");
  	die;
}

///////////////////////////////////////////////////////// Action: VIEW FORUM
if ($action == "viewforum") {
	$forumid = $_GET["forumid"];
	if (!is_valid_id($forumid))
		die;
    $page = $_GET["page"];
    $userid = $CURUSER["id"];

    //------ Get forum name
    $res = mysql_query("SELECT name, minclassread FROM forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_assoc($res) or die;
    $forumname = $arr["name"];
    if (10 < $arr["minclassread"])
		die("Not permitted");

    //------ Get topic count
    $perpage = 20;
    $res = mysql_query("SELECT COUNT(*) FROM forum_topics WHERE forumid=$forumid") or forumsqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res);
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
    $topicsres = mysql_query("SELECT * FROM forum_topics WHERE forumid=$forumid ORDER BY sticky, lastpost DESC LIMIT $offset,$perpage") or showerror("SQL Error", mysql_error());

    stdhead("Forum : $forumname");
    $numtopics = mysql_num_rows($topicsres);
    begin_frame("$forumname", center);
	forumheader("<a href=forums.php?action=viewforum&forumid=$forumid>$forumname</a>");
	
	print ("<table align=center cellpadding=0 cellspacing=5 width=95% border=0 ><tr><td><div align='right'><a href=forums.php?action=newtopic&forumid=$forumid><img src=". $themedir. "button_new_post.gif border=0></a></div></td></tr></table>");

    if ($numtopics > 0) {
	print("<table align=center cellpadding=2 cellspacing=1 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 >");

	print("<tr><td align=left width=100% bgcolor=#E0F1FE><b>Topic</b></td><td bgcolor=#E0F1FE align=center><b>Replies</b></td><td bgcolor=#E0F1FE align=center><b>Views</b></td><td bgcolor=#E0F1FE align=center><b>Author</b></td><td bgcolor=#E0F1FE align=right><b>Last post</b></td>\n");
		if ($user->admin)
			print("<td bgcolor=#E0F1FE><b>Moderator</b></td>");
      print("</tr>\n");
      while ($topicarr = mysql_fetch_assoc($topicsres)) {
			$topicid = $topicarr["id"];
			$topic_userid = $topicarr["userid"];
			$locked = $topicarr["locked"] == "yes";
			$moved = $topicarr["moved"] == "yes";
			$sticky = $topicarr["sticky"] == "yes";
			//---- Get reply count
			$res = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
			$arr = mysql_fetch_row($res);
			$posts = $arr[0];
			$replies = max(0, $posts - 1);
			$tpages = floor($posts / $postsperpage);
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
        $res = mysql_query("SELECT * FROM forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or forumsqlerr(__FILE__, __LINE__);
        $arr = mysql_fetch_assoc($res);
        $lppostid = $arr["id"];
        $lpuserid = $arr["userid"];
        $lpadded = $arr["added"];

        //------ Get name of last poster
        $res = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE id=$lpuserid") or forumsqlerr(__FILE__, __LINE__);
        if (mysql_num_rows($res) == 1) {
          $arr = mysql_fetch_assoc($res);
          $lpusername = "<a href=account-details.php?id=$lpuserid>$arr[username]</a>";
        }
        else
          $lpusername = "Deluser";

        //------ Get author
        $res = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$topic_userid") or forumsqlerr(__FILE__, __LINE__);
        if (mysql_num_rows($res) == 1) {
          $arr = mysql_fetch_assoc($res);
          $lpauthor = "<a href=account-details.php?id=$topic_userid>$arr[username]</a>";
        }
        else
          $lpauthor = "Deluser";

		// Topic Views
		$viewsq = mysql_query("SELECT views FROM forum_topics WHERE id=$topicid");
		$viewsa = mysql_fetch_array($viewsq);
		$views = $viewsa[0];
		// End

        //---- Print row
        $r = mysql_query("SELECT lastpostread FROM forum_readposts WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
        $a = mysql_fetch_row($r);
        $new = !$a || $lppostid > $a[0];
        $topicpic = ($locked ? ($new ? "folder_locked_new" : "folder_locked") : ($new ? "folder_new" : "folder"));
        $subject = ($sticky ? "<b>Sticky: </b>" : "") . "<a href=forums.php?action=viewtopic&topicid=$topicid><b>" .
        encodehtml(stripslashes($topicarr["subject"])) . "</b></a>$topicpages";
        print("<tr><td align=left class=alt1><table border=0 cellspacing=0 cellpadding=0><tr>" .
         "<td style='padding-right: 5px'><img src=". $themedir ."$topicpic.gif>" .
         "</td><td class=alt1 align=left>\n" .
         "$subject</td></tr></table></td><td class=alt2 align=center>$replies</td>\n" .
		 "<td class=alt1 align=center>$views</td>\n" .
         "<td class=alt1 align=center>$lpauthor</td>\n" .
         "<td class=alt2 align=right><nobr><small>by&nbsp;$lpusername<br>$lpadded</small></nobr></td>\n");
        if ($user->admin) {
			  print("<td class=alt1 align=center>\n");
			if ($locked)
				print("<a href=forums.php?action=unlocktopic&forumid=$forumid&topicid=$topicid&page=$page title='Unlock'><img src=". $themedir ."topic_unlock.gif border=0 alt=UnLock Topic></a>\n");
			else
				print("<a href=forums.php?action=locktopic&forumid=$forumid&topicid=$topicid&page=$page title='Lock'><img src=". $themedir ."topic_lock.gif border=0 alt=Lock Topic></a>\n");
				print("<a href=forums.php?action=deletetopic&topicid=$topicid&sure=0 title='Delete'><img src=". $themedir ."topic_delete.gif border=0 alt=Delete Topic></a>\n");
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
    print("<td ><img src=". $themedir ."folder_new.gif style='margin-right: 5px'></td><td >New posts</td>\n");
	 print("<td ><img src=". $themedir ."folder.gif style='margin-left: 10px; margin-right: 5px'>" .
     "</td><td >No New posts</td>\n");
    print("<td ><img src=". $themedir ."folder_locked.gif style='margin-left: 10px; margin-right: 5px'>" .
     "</td><td >Locked topic</td>\n");
    print("</tr></table></p>\n");
    $arr = get_forum_access_levels($forumid) or die;
    $maypost = 10 >= $arr["write"];
    if (!$maypost)
		print("<p><i>You are not permitted to post in this forum.</i></p>\n");
    print("<p><table border=0 cellspacing=0 cellpadding=0><tr>\n");

    if ($maypost)
		print("<td ><a href=forums.php?action=newtopic&forumid=$forumid><img src=" . $themedir . "button_new_post.gif border=0></a></td>\n");
    print("</tr></table>\n");
    insert_quick_jump_menu($forumid);
    end_frame();
    stdfoot();
    die;
}

///////////////////////////////////////////////////////// Action: VIEW NEW POSTS
if ($action == "viewunread") {
	$userid = $CURUSER['id'];
	$maxresults = 25;
	$res = mysql_query("SELECT id, forumid, subject, lastpost FROM forum_topics ORDER BY lastpost") or forumsqlerr(__FILE__, __LINE__);
    stdhead();
	begin_frame("Topics with unread posts");
	forumheader("New Topics");

    $n = 0;
    $uc = 10;
    while ($arr = mysql_fetch_assoc($res)) {
      $topicid = $arr['id'];
      $forumid = $arr['forumid'];

      //---- Check if post is read
      $r = mysql_query("SELECT lastpostread FROM forum_readposts WHERE userid=$userid AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
      $a = mysql_fetch_row($r);
      if ($a && $a[0] == $arr['lastpost'])
        continue;

      //---- Check access & get forum name
      $r = mysql_query("SELECT name, minclassread FROM forum_forums WHERE id=$forumid") or forumsqlerr(__FILE__, __LINE__);
      $a = mysql_fetch_assoc($r);
      if ($uc < $a['minclassread'])
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
       "<img src=". $SITEURL ."/images/unlockednew.gif style='margin-right: 5px'></td><td class=embedded>" .
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
	 end_frame();
    stdfoot();
    die;
}

///////////////////////////////////////////////////////// Action: SEARCH
if ($action == "search") {
	stdhead("Forum Search");
	begin_frame("Search Forum");
	forumheader("Search Forums");
			
	$keywords = trim($HTTP_GET_VARS["keywords"]);
	
	if ($keywords != ""){
		print("<p>Search Phrase: <b>" . htmlspecialchars($keywords) . "</b></p>\n");
		$maxresults = 50;
		$ekeywords = sqlesc($keywords);
		$res = mysql_query("SELECT * FROM forum_posts WHERE MATCH (body) AGAINST ($ekeywords)") or forumsqlerr(__FILE__, __LINE__);
		// search and display results...
		$num = mysql_num_rows($res);

		if ($num > $maxresults) {
			$num = $maxresults;
			print("<p>Found more than $maxresults posts; displaying first $num.</p>\n");
		}
		
		if ($num == 0)
			print("<p><b>Sorry, nothing found!</b></p>");
		else {
			print("<p><center><table border=1 cellspacing=0 cellpadding=2 width=95%>\n");
			print("<tr><td class=colhead>Post ID</td><td class=colhead align=left>Topic</td><td class=colhead align=left>Forum</td><td class=colhead align=left>Posted by</td></tr>\n");

			for ($i = 0; $i < $num; ++$i){
				$post = mysql_fetch_assoc($res);

				$res2 = mysql_query("SELECT forumid, subject FROM forum_topics WHERE id=$post[topicid]") or forumsqlerr();
				$topic = mysql_fetch_assoc($res2);

				$res2 = mysql_query("SELECT name,minclassread FROM forum_forums WHERE id=$topic[forumid]") or forumsqlerr();
				$forum = mysql_fetch_assoc($res2);

				if ($forum["name"] == "" || $forum["minclassread"] > $CURUSER["class"])
					continue;
				
				$res2 = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$post[userid]") or	forumsqlerr();
				$user = mysql_fetch_assoc($res2);
				if ($user["username"] == "")
					$user["username"] = "Deluser";
				print("<tr><td>$post[id]</td><td align=left><a href=forums.php?action=viewtopic&topicid=$post[topicid]#$post[id]><b>" . htmlspecialchars($topic["subject"]) . "</b></a></td><td align=left><a href=forums.php?action=viewforum&amp;forumid=$topic[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a><td align=left><a href=account-details.php?id=$post[userid]><b>$user[username]</b></a><br />at $post[added]</tr>\n");
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
	end_frame();
	stdfoot();
	die;
}

///////////////////////////////////////////////////////// Action: UNKNOWN
if ($action != "")
    showerror("Forum Error", "Unknown action '$action'.");

///////////////////////////////////////////////////////// Action: DEFAULT ACTION (VIEW FORUMS)
if (isset($_GET["catchup"]))
	catch_up();

///////////////////////////////////////////////////////// Action: SHOW MAIN FORUM INDEX
$forums_res = mysql_query("SELECT forumcats.id AS fcid, forumcats.name AS fcname, forum_forums.* FROM forum_forums LEFT JOIN forumcats ON forumcats.id = forum_forums.category ORDER BY forumcats.sort, forum_forums.sort, forum_forums.name") or forumsqlerr(__FILE__, __LINE__);

stdhead("Forums");
begin_frame("Forum Home", center);
forumheader("Index");
latestforumposts();

print("<table align=center cellpadding=3 cellspacing=1 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 >");// MAIN LAYOUT

print("<tr><td align=left width=100% bgcolor=#E0F1FE><b> Forum </b></td><td  width=37 align=right bgcolor=#E0F1FE><b> Topics <b/></td><td width=47 align=right bgcolor=#E0F1FE><b> Posts </b></td><td align=right width=85 bgcolor=#E0F1FE><b> Last post </b></td></tr>\n");// head of forum index

$fcid = 0;

while ($forums_arr = mysql_fetch_assoc($forums_res)){
	if ($forums_arr['fcid'] != $fcid) {// add forum cat headers
		print("<tr><td colspan=\"4\" class=\"forumcat\" align=center bgcolor=#E0F1FE><b><font size=\"2\">".htmlspecialchars($forums_arr['fcname'])."</font></b></td></tr>\n");

		$fcid = $forums_arr['fcid'];
	}

    if (10 < $forums_arr["minclassread"])
		continue;
	 
	if ($forums_arr["teamid"]!=0 && $CURUSER["team"]!=$forums_arr["teamid"] && 10 < 4)
		continue;

    $forumid = 0 + $forums_arr["id"];

    $forumname = htmlspecialchars($forums_arr["name"]);

    $forumdescription = htmlspecialchars($forums_arr["description"]);
    $topicids_res = mysql_query("SELECT id FROM forum_topics WHERE forumid=$forumid") or forumsqlerr(__FILE__, __LINE__);
	$topiccount = number_format(mysql_num_rows($topicids_res));
    $postcount = 0;
		while ($topicids_arr = mysql_fetch_assoc($topicids_res)) {
			$topicid = $topicids_arr['id'];
			$postcount_res = mysql_query("SELECT COUNT(*) FROM forum_posts WHERE topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
			$postcount_arr = mysql_fetch_row($postcount_res);
			$postcount += $postcount_arr[0];
		}
    $postcount = number_format($postcount);

    // Find last post ID
    $lastpostid = get_forum_last_post($forumid);

    // Get last post info
    $post_res = mysql_query("SELECT added,topicid,userid FROM forum_posts WHERE id=$lastpostid") or forumsqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($post_res) == 1) {
		$post_arr = mysql_fetch_assoc($post_res) or die("Bad forum last_post");
		$lastposterid = $post_arr["userid"];
		$lastpostdate = $post_arr["added"];
		$lasttopicid = $post_arr["topicid"];
		$user_res = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$lastposterid") or forumsqlerr(__FILE__, __LINE__);
		$user_arr = mysql_fetch_assoc($user_res);
		$lastposter = htmlspecialchars($user_arr['username']);
		$topic_res = mysql_query("SELECT subject FROM forum_topics WHERE id=$lasttopicid") or forumsqlerr(__FILE__, __LINE__);
		$topic_arr = mysql_fetch_assoc($topic_res);
		$lasttopic = stripslashes(htmlspecialchars($topic_arr['subject']));
		
		//cut last topic
		$latestleng = 10;

		$lastpost = "<nobr><small><a href=forums.php?action=viewtopic&topicid=$lasttopicid&page=last#last>" . CutName($lasttopic, $latestleng) . "</a> by <a href=account-details.php?id=$lastposterid>$lastposter</a><br>$lastpostdate</small></nobr>";


		$r = mysql_query("SELECT lastpostread FROM forum_readposts WHERE userid=$CURUSER[id] AND topicid=$lasttopicid") or forumsqlerr(__FILE__, __LINE__);
		$a = mysql_fetch_row($r);
		//define the images for new posts or not on index
		if ($a && $a[0] == $lastpostid)
			$img = "folder";
		else
		$img = "folder_new";
    }else{
		$lastpost = "<small>No Posts</small>";
		$img = "folder";
    }
	//following line is each forums display
    print("<tr><td class=alt1 align=left><table border=0 cellspacing=0 cellpadding=0><tr><td style='padding-right: 5px'><img src=". $themedir ."$img.gif></td><td class=alt1><a href=forums.php?action=viewforum&forumid=$forumid><b>$forumname</b></a><br />\n" .
    "<SMALL>- $forumdescription</SMALL></td></tr></table></td><td class=alt2 align=center>$topiccount</td></td><td class=alt1 align=center>$postcount</td>" .
    "<td class=alt2 align=right>$lastpost</td></tr>\n");
}
print("</table>");
//forum Key
print("<p><table border=0 cellspacing=0 cellpadding=0><tr valing=center>\n");
print("<td ><img src=". $themedir ."folder_new.gif style='margin-right: 5px'></td><td >New posts</td>\n");
print("<td ><img src=". $themedir ."folder.gif style='margin-left: 10px; margin-right: 5px'></td><td >No New posts</td>\n");
print("<td ><img src=". $themedir ."folder_locked.gif style='margin-left: 10px; margin-right: 5px'></td><td >Locked topic</td>\n");
print("</tr></table></p>\n");

//Top posters
$r = mysql_query("SELECT ".$db_prefix."_users.id, users.username, COUNT(forum_posts.userid) as num FROM forum_posts LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_users.id = forum_posts.userid GROUP BY userid ORDER BY num DESC LIMIT 10") or forumsqlerr();
forumpostertable($r, "Top 10 Posters</font>");

//topic count and post counts
$postcount = number_format(get_row_count("forum_posts"));
$topiccount = number_format(get_row_count("forum_topics"));
print("<br><center>Our members have made " . $postcount . " posts in  " . $topiccount . " topics</center><BR>");

insert_quick_jump_menu();
end_frame();
stdfoot();

}ELSE{//HEY IF FORUMS ARE OFF, SHOW THIS...
	stdhead("Forums");
	begin_frame("Notice", center);
	echo '<BR>Unfortunately The Forums Are Not Currently Available<BR><BR>';
	end_frame();
	stdfoot();
}

}//end ban check


?>