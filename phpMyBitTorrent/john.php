<?php
include("header.php");
$last_in = $user->lastlogin;
$title = array();
$topic_id = array();
$sql = "SELECT  id AS id, subject AS subject FROM torrent_forum_topics WHERE forumid='1' ORDER BY id DESC LIMIT 3;";
$res = $db->sql_query($sql) or btsqlerror($sql);
$count = $db->sql_numrows($res);
while ($row = $db->sql_fetchrow($res)) {
$title[] = $row['subject'];
$topic_id[] = $row['id'];
}
echo $count;
echo '<br />';
print_r($title);
echo '<br />';
print_r($topic_id);
for ($i=0; $i<=$count; $i++)
{
if ($i > $count-1)break;
echo "<table width=\"100%\"><tr><td align=right frame=\"below\">";
$res = $db->sql_query("SELECT body, added FROM ".$db_prefix."_forum_posts WHERE topicid='".$topic_id[$i]."' ORDER BY added ASC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$rowe = $db->sql_fetchrow($res);
$resa = $db->sql_query("SELECT count(id) AS posts FROM ".$db_prefix."_forum_posts WHERE topicid='".$topic_id[$i]."'") or sqlerr(__FILE__, __LINE__);
$rowa = $db->sql_fetchrow($resa);
$welcome_message =  format_comment($rowe['body']);
parse_smiles($welcome_message);
echo $rowe['added']."<br />Comments : ".($rowa['posts']-1)."</td></tr><tr><td>".$title[$i]."</td></tr><tr><td><a style=\"cursor: pointer;\" onClick=\"togglen('nn".$nid."');\"><img title=\"Expand item\" id=\"nn".$nid."img\" src=\"images/".$img.".png\" width=\"11px\" height=\"8px\" alt=\"+\"></a><div id=\"nn".$nid."\" style=\"display: $show\"><h2>".$welcome_message."</h2></div></td></tr></table>\n";
}
//Showing last 3 news
include("footer.php");
?>
