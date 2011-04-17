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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
include("header.php");
include'include/textarea.php';
if(!checkaccess("offers")){
OpenErrTable(_btaccdenied);
echo "<p>"._bt_voteoffer_noaccess."/p>";
CloseErrTable();
die();
}
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
function offcommenttable($rows)
{
   global $db, $db_prefix, $forumpx, $user, $HTTP_SERVER_VARS;
   $count = 0;
   foreach ($rows as $row)
   {
print("<br>");
$postername = htmlspecialchars($row["username"]);
if ($postername == "") {
       $postername = ""._bt_offerdetails_deluser."";
 $title = ""._bt_offerdetails_delacc."";
 $privacylevel = "no";
       $avatar = "";
 $usersignature = "";
 $userdownloaded = "";
   $useruploaded = "";
     }else {
$res4 = $db->sql_query("SELECT COUNT(*) FROM " . $forumpx . "_posts WHERE poster_id='" . get_user_forum_name($row["username"]) . "'") or die(mysql_error());
$arr33 = $db->sql_fetchrow($res4);
$forumposts = $arr33[0];
$res44 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_comments WHERE user=" . $row["user"] . "") or die(mysql_error());
$arr333 = $db->sql_fetchrow($res44);
$commentposts = $arr333[0];
$commentid = $row["id"];
  $avatar = htmlspecialchars($row["avatar"]);
  $userdownloaded = mksize($row["downloaded"]);
  $useruploaded = mksize($row["uploaded"]);
  $title =  htmlspecialchars($row["name"]);
  $privacylevel = $row["accept_mail"];
  $pic = "";
                  if ($row["level"] == "premium") $pic = pic("icon_premium.gif");
                elseif ($row["level"] == "moderator") $pic = pic("icon_moderator.gif");
                elseif ($row["level"] == "admin") $pic = pic("icon_admin.gif");
}
if ($row["downloaded"] > 0)
   {
     $userratio = number_format($row["uploaded"] / $row["downloaded"], 2);
   }
else
     if ($row["uploaded"] > 0)
       $userratio = "Inf.";
     else
       $userratio = "---";
     if (!$avatar)
       $avatar = $siteurl . "/themes/".$theme."/pics/noavatar.png";
Opentable(_bt_offerdetails_comemnt);
echo "<table border=\"0\" cellpadding=\"3\" >";
        echo "<thead>\n<tr><th width=\"25%\"></th>";
        echo "<th width=\"75%\"></th>";
		echo "</tr></thead>\n<tbody>\n";
echo'<tr>';
		echo "<td valign=top align=left>";
echo'<p><a href="user.php?op=profile&username=">' . $postername .$pic. '</a></p><br />';
echo '<p><strong>'._bt_offerdetails_level.'</strong>'. $row["level"] .$pic.'</p>';
echo'<p>'.pic("pic_uploaded.gif").' ' . $useruploaded .'</font></p>';
echo'<p>'.pic("pic_downloaded.gif").' ' . $userdownloaded .'</font></p>';
echo'<p>'.pic("pic_ratio.gif").' ' . $userratio .'</font></p>';
echo'<p>'._bt_offerdetails_comemnt.'' . $commentposts .'</p>';
echo'<p><strong>Posts: </strong><a href=phpbb2.php?page=search&author_id='.get_user_forum_name($row["username"]).'&sr=posts>'.$forumposts.'</a></p><br /><br />';
echo'<p><center><img width=80 height=80 src=./avatars/' . $avatar .'></center></p>';
                echo "</td>\n" ;

                echo "<td ><table><tr><td>";
if ($user->moderator)echo '<p><a href=user.php?op=profile&username=' . $postername . '>' . $postername .$pic. '</a></strong> on '. $row["added"] .' - [<a href=offcomment.php?action=edit&amp;cid='. $row[id] .'>Edit</a>] - </p><br />';
else
echo '<p><a href=user.php?op=profile&username=' . $postername . '>' . $postername .$pic. '</a></strong> on '. $row["added"] .' </p><br />';
 if ($user->admin) {
 if ($row["editedby"]){
  $text = "<p><font size=1 class=small><>=_bt_offerdetails_edited?><a href=user.php?op=profile&id=" . $row[editedby] ."><b>" . $row[username] .$pic."</b></a>  " . $row[editedat] ." GMT</font></p>";
       print("$text");
     }
  }

echo '<p>'.$row["text"].'</p>';
echo'</tr>';
echo'</td>';
        echo "</tbody>\n</table>\n";
        echo "</table>\n";
CloseTable();
   }
}
$action = $_GET["action"];
if ($action == "add")
{
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$offid = 0 + $_POST["tid"];
if (!$offid)
bterror(_bt_offercomment_id,_bterror);
$res = $db->sql_query("SELECT name FROM ".$db_prefix."_offers WHERE id = $offid") or sqlerr(__FILE__,__LINE__);
$arr = $db->sql_fetchrow($res);
if (!$arr)
bterror(_bt_offercomment_noid,_bterror);
if (!get_magic_quotes_gpc()) $msg = escape($msg);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $msg)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
if (!$msg)
bterror("Don't leave any fields 2blank!","Error");
$db->sql_query("INSERT INTO ".$db_prefix."_comments (user, offer, added, text, ori_text) VALUES (" .
   getuserid($btuser) . ",$offid, NOW(), '" . $msg .
    "','" . $msg . "')");
$newid = $db->sql_nextid();

$db->sql_query("UPDATE ".$db_prefix."_offers SET comments = comments + 1 WHERE id = $offid");
bterror(_bt_offercomment_added,_bt_offercomment_added1,false);
header("Refresh: 3; url=offdetails.php?id=$offid&viewcomm=$newid#comm$newid");
exit();
}
$offid = 0 + $_GET["tid"];
if (!$offid)
bterror(_bt_offercomment_id,_bterror);
$res = $db->sql_query("SELECT name FROM ".$db_prefix."_offers WHERE id = $offid") or sqlerr(__FILE__,__LINE__);
$arr = $db->sql_fetchrow($res);
if (!$arr)
bterror(_bt_offercomment_id,_bterror);
OpenTable(_bt_offercomment_addedcomment .$arr["name"]);
print("<p><form name=\"Form\" method=\"post\" action=\"offcomment.php?action=add\">");
print("<input type=\"hidden\" name=\"tid\" value=\"$offid\"/>\n");
        echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\" >\n";
echo "<tr><td><p>"._btaddcomment."</p></td><td>";
                        echo "</td><td>";
echo $textarea->quick_bbcode('Form','msg');
echo $textarea->input('msg', 'center', "2", "10", "60");
echo "</table></td></tr>\n";
//						}
        echo "</table>";
print("<p><input type=\"submit\" class=btn value=\""._bt_offercomment_send."\" /></p></form>");
CloseTable();
$res = $db->sql_query("SELECT ".$db_prefix."_comments.id, text, ".$db_prefix."_comments.added, username, ".$db_prefix."_users.id as user, ".$db_prefix."_users.avatar, ".$db_prefix."_users.name,  ".$db_prefix."_users.downloaded, ".$db_prefix."_users.uploaded, ".$db_prefix."_users.accept_mail FROM ".$db_prefix."_comments LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_comments.user = ".$db_prefix."_users.id WHERE offer = $offid ORDER BY ".$db_prefix."_comments.id DESC LIMIT 5");
$allrows = array();
while ($row = $db->sql_fetchrow($res))
$allrows[] = $row;
if (count($allrows)) {
print("<p>"._bt_offercomment_reverse."</p>");
offcommenttable($allrows);
}
CloseTable();
include("footer.php");

}
elseif ($action == "edit")
{
$commentid = 0 + $_GET["cid"];
if (!$commentid)
bterror(_bt_offercomment_wrongid,_bterror);
$res = $db->sql_query("SELECT c.*, o.name FROM ".$db_prefix."_comments AS c JOIN ".$db_prefix."_offers AS o ON c.offer = o.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
$arr = $db->sql_fetchrow($res);
if (!$arr)
bterror(_bt_offercomment_wrongid,_bterror);
if ($arr["user"] != getuserid($btuser) && ($user->admin))
bterror(_btaccdenied,_bterror);
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
#$text = $_POST["msg"];
if (!get_magic_quotes_gpc()) $msg = escape($msg);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $msg)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
$returnto = $_POST["returnto"];
if ($msg == "")
bterror(_btsignup_blank_fields,_bterror);
$db->sql_query("UPDATE ".$db_prefix."_comments SET text='".$msg."', editedat=NOW(), editedby='".$user->id."' WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);
bterror(_bt_offercomment_edited,_bt_offercomment_edit,false);
if ($returnto)
header("Refresh: 3; url=" . $returnto);
die;
}
OpenTable(""._bt_offercomment_editcommen."\"" . $arr["name"] . "\"");
print("<form name=Form method=\"post\" action=\"offcomment.php?action=edit&amp;cid=$commentid\">");
print("<input type=\"hidden\" name=\"returnto\" value=\"" . $_SERVER["HTTP_REFERER"] . "\" />");
print("<input type=\"hidden\" name=\"cid\" value=\"$commentid\" />");
        echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\" >";
echo "<tr><td><p>"._btaddcomment."</p></td><td><br>";
//                if (!$allow_html) echo "<br>"._btnohtml."</p></td><td><p><textarea name=\"msg\" rows=\"20\" cols=\"90\"></textarea></p>\n</td></tr>";
//                else {
echo $textarea->quick_bbcode('Form','msg');
echo $textarea->input('msg', 'center', "2", "10", "60",$arr["text"]);
        echo "</table></td></tr>";
//						}
        echo "</table>";
print("<hr /><input type=\"submit\" class=btn value=\""._bt_offercomment_edit1."\" /></form>\n");
Closetable();
die;
}
elseif ($action == "delete")
{
if (!$user->admin)
bterror(_btaccdenied,_bterror);
$commentid = 0 + $_GET["cid"];
if (!isset($commentid) OR !is_numeric($commentid) OR $commentid < 1) error(_bterridnotset);
$sure = $_GET["sure"];
if (!$sure)
{
$referer = $_SERVER["HTTP_REFERER"];
bterror(_bt_offercomment_aboutdelete .
"<a href=?action=delete&cid=$commentid&sure=1" .
($referer ? "&returnto=" . urlencode($referer) : "") .

">"._bt_offercomment_here."</a>"._bt_offercomment_ifsure."",_bt_offercomment_delcom);
}
$res = $db->sql_query("SELECT offer FROM ".$db_prefix."_comments WHERE id=$commentid")  or sqlerr(__FILE__,__LINE__);
$arr = $db->sql_fetchrow($res);
if ($arr)
$offid = $arr["offer"];
$db->sql_query("DELETE FROM ".$db_prefix."_comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);
if ($offid && mysql_affected_rows() > 0)
$db->sql_query("UPDATE ".$db_prefix."_offers SET comments = comments - 1 WHERE id = $offid");
$returnto = $_GET["returnto"];
bterror(_bt_offercomment_comdeleted,_bt_offercomment_delete,false);
if ($returnto)
header("Refresh: 3; url=" .  $returnto);
else
header("Refresh: 3;url=" . $siteurl . "/");      // change later ----------------------
die;
}
elseif ($action == "vieworiginal")
{
if (!$user->admin) 
bterror(_btaccdenied,_bterror);
$commentid = 0 + $_GET["cid"];
if (!$commentid)
bterror(_bt_offercomment_invalid,_bterror);
$res = $db->sql_query("SELECT c.*, t.name FROM ".$db_prefix."_comments AS c JOIN ".$db_prefix."_offers AS t ON c.offer = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
$arr = $db->sql_fetchrow($res);
if (!$arr)
bterror(_bt_offercomment_invalid,_bterror);
Opentable(_bt_offercomment_original);
print("<h1>"._bt_offercomment_origid."#$commentid</h1><p>\n");
print("<table width=500 border=1 cellspacing=0 cellpadding=5>");
print("<tr><td class=comment>\n");
echo "<p>".str_replace("\n","<br>",$arr["ori_text"])."</p>";
print("</td></tr></table>\n");
$returnto = $_SERVER["HTTP_REFERER"];
if ($returnto)
print("<p><font size=small>(<a href=$returnto>"._bt_offercomment_back."/a>)</font></p>\n");
Closetable();
include("footer.php");
}
else
bterror(_bt_offercomment_unknown,_bterror);
include("footer.php");
?>