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
if (!eregi("offdetails.php",$_SERVER["PHP_SELF"])) die ("You can't include this file");
include("header.php");
        global $db, $db_prefix, $forumpx;

if(!checkaccess("offers")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have Permissions to Access Offers at this time</p>";
CloseErrTable();
die();
}
function pager($rpp, $count, $href, $opts = array()) {
    $pages = ceil($count / $rpp);

    if (!$opts["lastpagedefault"])
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)
            $pagedefault = 0;
    }

    if (isset($_GET["page"])) {
        $page = 0 + $_GET["page"];
        if ($page < 0)
            $page = $pagedefault;
    }
    else
        $page = $pagedefault;

    $pager = "";

    $mp = $pages - 1;
    $as = "<b>&lt;&lt;&nbsp;Prev</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"{$href}page=" . ($page - 1) . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;
    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b>Next&nbsp;&gt;&gt;</b>";
    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"{$href}page=" . ($page + 1) . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;
            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                $pagerarr[] = "<a href=\"{$href}page=$i\"><b>$text</b></a>";
            else
                $pagerarr[] = "<b>$text</b>";
        }
        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}



function offcommenttable($rows)
{
   global $db, $db_prefix, $theme, $forumpx, $user, $HTTP_SERVER_VARS;
   $count = 0;
   foreach ($rows as $row)
   {
print("<br>");
$postername = htmlspecialchars($row["username"]);
if ($postername == "") {
       $postername = "Deluser";
 $title = "Deleted Account";
 $privacylevel = "no";
       $avatar = "";
 $usersignature = "";
 $userdownloaded = "";
   $useruploaded = "";
     }else {
$sql = ("SELECT COUNT(*) FROM " . $forumpx . "_posts WHERE poster_id='" . get_user_forum_name($row["username"]) . "'") ;
$res4 = $db->sql_query($sql)or btsqlerror($sql);
$arr33 = $db->sql_fetchrow($res4);
$forumposts = $arr33[0];
$res44 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_comments WHERE user=" . $row["user"] . "") ;
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
     if ($avatar == "blank.gif")$avatar = "themes/".$theme."/pics/noavatar.gif";
	 else
	 $avatar = $siteurl . "avatars/".$avatar."";
	 
Opentable('Comments');
echo "<table border=\"0\" cellpadding=\"3\" width=\"100%\">";
        echo "<thead>\n<tr><th width=\"25%\"></th>";
        echo "<th width=\"75%\"></th>";
		echo "</tr></thead>\n<tbody>\n";
echo'<tr>';
		echo "<td valign=top align=left>";
echo'<p><a href="user.php?op=profile&username=' . $postername . '">' . $postername .$pic. '</a></p><br />';
echo '<p><strong>level: </strong>'. $row["level"] .$pic.'</p>';
echo'<p>'.pic("pic_uploaded.gif").' ' . $useruploaded .'</font></p>';
echo'<p>'.pic("pic_downloaded.gif").' ' . $userdownloaded .'</font></p>';
echo'<p>'.pic("pic_ratio.gif").' ' . $userratio .'</font></p>';
echo'<p>Comments: ' . parse_smiles(format_comment($commentposts, false, true)) .'</p>';
echo'<p><strong>Posts: </strong><a href=phpBB.php?page=search&author_id='.get_user_forum_name($row["username"]).'&sr=posts>'.$forumposts.'</a></p><br /><br />';
echo'<p><center><img width=80 height=80 src=./' . $avatar .'></center></p>';
                echo "</td>\n" ;

                echo "<td ><table><tr><td>";
if ($user->moderator)echo '<p><a href=user.php?op=profile&username=' . $postername . '>' . $postername .$pic. '</a></strong> on '. $row["added"] .' - [<a href=offcomment.php?action=edit&amp;cid='. $row[id] .'>Edit</a>] -[<a href=offcomment.php?action=vieworiginal&amp;cid='. $row[id] .'>View original</a>] </p><br />';
else
echo '<p><a href=user.php?op=profile&username=' . $postername . '>' . $postername .$pic. '</a></strong> on '. $row["added"] .' </p><br />';
 if ($user->admin) {
 if ($row["editedby"]){
  $text = "<p><font size=1 class=small>Edited By: <a href=account-details.php?id=" . $row[editedby] ."><b>" . $row[username] .$pic."</b></a>  " . $row[editedat] ." GMT</font></p>";
       print("$text");
     }
  }

echo '<p>'.$row["text"].'</p>';
	    if ($user->admin)echo '<p>[<a href=offcomment.php?action=delete&amp;cid='. $row[id] .'>DELETE COMMENT</a>]</p>';

echo'</tr>';
echo'</td>';
        echo "</tbody>\n</table>\n";
        echo "</table>\n";
CloseTable();
   }
}
OpenTable("Details");
$id = $_GET["id"];
$res = $db->sql_query("SELECT * FROM `".$db_prefix."_offers` WHERE `id` = $id") ;
$num = $db->sql_fetchrow($res);
$s = $num["votes"];
print("<div align=center>");
print("<h1>Details for $num[name]</h1>");
print("<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">");
print("<tr><td align=left>Name</td><td width=90% align=left >$num[name]</td></tr>");
if ($num["descr"])
								$text = format_comment($num["descr"], false, true);
                                parse_smiles($text);

?><tr><td align=left>Description</td><td width=90% align=left colspan=2><?php echo $text;?></td></tr><?php
print("<tr><td align=left>Date Offered</td><td width=90% align=left >$num[added]</td></tr>");
$cres = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id='$num[userid]'");
if ($db->sql_numrows($cres) == 1)
{
  $carr = $db->sql_fetchrow($cres);
  $username = "$carr[username]";
}
$url = "offedit.php?id=$id";
if (isset($_GET["returnto"])) {
$addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
$url .= $addthis;
$keepget .= $addthis;
}
$editlink = "a href=\"$url\" class=\"sublink\"";
print("<tr><td align=left>Offered By</td><td width=90% align=left >$username");
if ($user->id != $num["userid"] && (!$user->admin)) {
print(" ");}
else{
print("    &nbsp;&nbsp;&nbsp;<$editlink><b>[Edit]</b></a>");}
print("</td></tr>");
if ($user->id != $num["userid"]){
print("<tr><td align=left>Vote</td><td width=50% align=left ><b><a href=addoffer.php?id=$id>Vote</a></b></td></tr>");}
if ($user->admin  || $user->id == $num["userid"]){
print("<script LANGUAGE=JavaScript SRC=ahur.js></SCRIPT>");
print("<form method=post action=deloffer.php name=deloffer><tr><td align=center colspan=2><input type=hidden value=$id name=offerid>Delete<input name=delenable type=checkbox onClick=\"if (this.checked){enabledel();}else{disabledel();}\"><input name=submit type=submit class=btn value=\"OK\" enabled></td></tr></form>");
print("</td></tr></table>");
CloseTable();
}
print"<p align=center><a class=index href=offcomment.php?action=add&amp;tid=$id>Add Comment</a></p>";
echo "<a name=\"startcomments\"></a>";
OpenTable('Comments');
$subres = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_comments WHERE offer = $id");
$subrow = $db->sql_fetchrow($subres);
$count = $subrow[0];
if (!$count) {
print("<p><h3>No Comments</h3></p>");
print("<center><a href=\"javascript: history.go(-1);\">BACK</a></center><br />");
CloseTable();

}
else{
list($pagertop, $pagerbottom, $limit) = pager(20, $count, "offdetails.php?id=$id&", array(lastpagedefault => 1));
$subres = $db->sql_query("SELECT ".$db_prefix."_comments.id, text, username, ".$db_prefix."_users.id as user, ".$db_prefix."_comments.added, ".$db_prefix."_users.avatar, editedby, editedat,  ".
               "username, ".$db_prefix."_users.name,  ".$db_prefix."_users.downloaded, ".$db_prefix."_users.uploaded, ".$db_prefix."_users.accept_mail, ".$db_prefix."_users.level FROM ".$db_prefix."_comments LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_comments.user = ".$db_prefix."_users.id WHERE offer = $id ORDER BY ".$db_prefix."_comments.id $limit")or die(mysql_error()) ;
$allrows = array();
while ($subrow = $db->sql_fetchrow($subres))
$allrows[] = $subrow;
if (count($allrows)) {
offcommenttable($allrows);
}
}
CloseTable();

print($pagerbottom);
/////////////////////////Fin Commentaires/////////////////////////
//print("</td></tr>");
print("</div>");

include("footer.php");
die;
?>

