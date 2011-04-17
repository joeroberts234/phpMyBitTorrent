<?php
include_once("include/forum_config.php");
if(!$user->ulanguage == '' && file_exists('language/forum/'.$user->ulanguage.'.php'))include'language/forum/'.$user->ulanguage.'.php';
elseif (file_exists('language/forum/'.$language.'.php'))include_once'language/forum/'.$language.'.php';
else
include_once'language/forum/english.php';
$themedir = "" . $siteurl . "/themes/" . $theme . "/forums/";
function encodehtml($s, $linebreaks = true)
{
  $s = str_replace(array("<",">","\""), array("&lt;","&gt;","&quot;"), str_replace("&", "&amp;", $s));
  if ($linebreaks)
    $s = nl2br($s);
  return $s;
}
/// HERE GOES THE QUERY TO RETRIEVE DATA FROM THE DATABASE AND WE START LOOPING ///
$for = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics ORDER BY lastpost DESC LIMIT 5");

while ($topicarr = $db->sql_fetchrow($for)) {
// Set minclass
$res = $db->sql_query("SELECT name,minclassread FROM ".$db_prefix."_forum_forums WHERE id=$topicarr[forumid]") or sqlerr();
$forum = $db->sql_fetchrow($res);

if ($forum["minclassread"] == '0' || in_array($user->group,explode("  ", $forum["minclassread"]))){
$forumname = "<a href=?action=viewforum&amp;forumid=$topicarr[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a>";

$topicid = $topicarr["id"];
$topic_title = stripslashes($topicarr["subject"]);
$topic_userid = $topicarr["userid"];
// Topic Views
$views = $topicarr["views"];
// End

/// GETTING TOTAL NUMBER OF POSTS ///
$res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = $db->sql_fetchrow($res);
$posts = $arr[0];
$replies = max(0, $posts - 1);

/// GETTING USERID AND DATE OF LAST POST ///   
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = $db->sql_fetchrow($res);
$postid = 0 + $arr["id"];
$userid = 0 + $arr["userid"];
$added = $arr["added"];

/// GET NAME OF LAST POSTER ///
$res = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
if ($db->sql_numrows($res) == 1) {
$arr = $db->sql_fetchrow($res);
$username = $arr['username'];
}
else
$username = "Unknown[$topic_userid]";

/// GET NAME OF THE AUTHOR ///
$res = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$topic_userid") or sqlerr(__FILE__, __LINE__);
if ($db->sql_numrows($res) == 1) {
$arr = $db->sql_fetchrow($res);
$author = $arr['username'];
$author_id = $topic_userid;
}
else
$author = "Unknown[$topic_userid]";

/// GETTING THE LAST INFO AND MAKE THE TABLE ROWS ///
$r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = $db->sql_fetchrow($r);
$new = !$a || $postid > $a[0];
$subject = encodehtml(stripslashes($topicarr["subject"]));
   $template->assign_block_vars('recent_posts', array(
   'SUBJECT'        => $subject,
   'REPLIES'        => $replies,
   'VIEWS'          => $views,
   'AUTHOR'         => $author,
   'AUTHOR_ID'      => $author_id,
   'AUTHOR_COLOR'   => getusercolor(getlevel_name($author_id)),
   'POSTER'         => $username,
   'POSTER_ID'      => $userid,
   'POSTER_COLOR'   => getusercolor(getlevel_name($userid)),
   'ADDED'          => $added,
   'TOPIC_ID'       => $topicid,
		));

} // while
}
?>