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
include("header.php");
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
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>\n";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>\n";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>\n";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}
function stderr($heading, $text)
{
OpenErrTable($heading);
echo $text;
CloseErrTable();
themefooter();
global $startpagetime;
  die;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset($_POST["reset"])) {
mysql_query("UPDATE ".$db_prefix."_snatched SET hitrun = '0000-00-00 00:00:00', hitrunwarn = 'no' WHERE id IN (".implode(", ", $_POST["reset"]).")") or sqlerr();
if (mysql_affected_rows())
stderr("Updated snatches", "Successfully reset ".count($_POST["warn"])." hit and runs.");
else
stderr("Error", "It appears that no hit and runs were updated.");

} elseif (isset($_POST["warn"])) {
$userids = $warnids = array();
$res = mysql_query("SELECT userid FROM ".$db_prefix."_snatched WHERE id IN (".implode(", ", $_POST["warn"]).")") or sqlerr();
while ($row = mysql_fetch_row($res))
$userids[] = $row[0];
if (!$userids)
stderr("Error", "It appears that you have selected no hit and runners to be warned.");

$msg = "You have received a 1 week warning for Hit and Running. Please try to make sure that this will not happen again.\n\nIf we notice that you do not change your behaviour we will be forced to disable your account.";
$modcomment = gmdate("d-m-Y")." - Warned by ".$user->name." for Hit and Running.\n";
if (!function_exists('gmtime')) {
function gmtime()
{
    return strtotime(get_date_time());
}
}
if (!function_exists('get_date_time')) {
function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}
}

$res = mysql_query("SELECT id FROM ".$db_prefix."_users WHERE warned = 'no' AND id IN (".implode(", ", $userids).")") or sqlerr();
while ($arr = mysql_fetch_assoc($res)) {
mysql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $arr[id], 'Hit and Run warning', '".$msg."')") or sqlerr();
$warnids[] = $arr["id"];
}
if (count($warnids)) {
mysql_query("UPDATE ".$db_prefix."_users SET warned = 1, warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "',  warn_hossz = '".get_date_time(gmtime() + (7 * 86400))."', modcomment = CONCAT('$modcomment', modcomment) WHERE id IN (".implode(", ", $warnids).")") or sqlerr();
stderr("Updated snatches", "Successfully warned ".count($warnids)." hit and runner".(count($warnids) == 1 ? "" : "s").".");
} else
stderr("Error", "It appears that no hit and runners were warned (possibly because they already have a warning).");

} else
stderr("Error", "It appears that you reached this page in the wrong way.");
}
$torrentid = 0 + $_GET["torrentid"];
$userid = 0 + $_GET["userid"];
function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

if (!is_valid_id($torrentid) && !is_valid_id($userid))
stderr("Error", "It appears that you have entered an invalid id.");

if ($userid) {
$xtra = "userid, username, seeding_time, completedat";
$join = "".$db_prefix."_users ON ".$db_prefix."_snatched.userid = ".$db_prefix."_users.id";
$where = "AND userid = $userid";
} elseif ($torrentid) {
$xtra = "torrentid, name";
$join = "".$db_prefix."_torrents ON ".$db_prefix."_snatched.torrentid = ".$db_prefix."_torrents.id";
$where = "AND torrentid = $torrentid";
}

$res = mysql_query("SELECT COUNT(*), $xtra FROM ".$db_prefix."_snatched INNER JOIN $join WHERE hitrunwarn = 'yes' $where GROUP BY ".$db_prefix."_snatched.id") or sqlerr();
$row = mysql_fetch_row($res);
$count = $row[0];
$perpage = 100;

if (!row)
{
OpenErrTable("Error");
echo "Not found.";
CloseErrTable();
include("footer.php");
}

if (!$count)
{
OpenErrTable("No hitruns");
echo "There are no hit and runs found..";
CloseErrTable();
include("footer.php");
}

list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, "?");

OpenTable("Hit and Runs");
print("<h1>Hit and Runs ".($userid ? "of user <a href=user.php?op=profile&id=$row[1]>$row[2]</a>" : "on torrent <a href=details.php?id=$row[1]>$row[2]</a>")."</h1>\n");
print("<table class=main border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>\n");
if ($count > $perpage)
print("$pagertop");
print("<table border=0 cellspacing=0 cellpadding=5>\n");
print("<tr>\n");
print("<td class=colhead align=left>Username</td>\n");
print("<td class=colhead align=center>Torrent</td>\n");
print("<td class=colhead align=center>Uploaded</td>\n");
print("<td class=colhead align=center>Downloaded</td>\n");
print("<td class=colhead align=right>Ratio</td>\n");
print("<td class=colhead align=center>Hit and Run at</td>\n");
print("<td class=colhead align=center>Last action</td>\n");
print("<td class=colhead align=center>Seed Time</td>\n");
print("<td class=colhead align=center>Warn</td>\n");
print("<td class=colhead align=center>Reset</td>\n");
print(($userid ? "<td class=colhead align=center>Demote user</td>\n":""));
print("</tr>\n");
print("<form method=post>\n");

$sql = "SELECT s.*, torrent_name, ".$db_prefix."_users.username, ".$db_prefix."_users.warned FROM ".$db_prefix."_snatched AS s INNER JOIN ".$db_prefix."_users ON s.userid = ".$db_prefix."_users.id INNER JOIN ".$db_prefix."_torrents ON s.torrentid = ".$db_prefix."_torrents.id WHERE hitrunwarn = 'yes' $where ORDER BY hitrun DESC $limit";
$res = $db->sql_query($sql) or btsqlerror($sql);
while ($arr = mysql_fetch_assoc($res)) {

$ratio = ($arr["downloaded"] > 0 ? number_format($arr["uploaded"] / $arr["downloaded"], 3) : ($arr["uploaded"] > 0 ? "Inf." : "---"));

print("<tr>\n");
print("<td align=left><a href=user.php?op=profile&id=$arr[userid]><b>$arr[username]</b></a></td>\n");
print("<td align=center><nobr><b><a title=\"$arr[name]\" href=details.php?id=$arr[torrentid]>".(strlen($arr["torrent_name"]) > 60 ? substr($arr["torrent_name"], 0, 60 - 3)."..." : $arr["torrent_name"])."</a></b></nobr></td>\n");
print("<td align=right>".mksize($arr["uploaded"])."</td>\n");
print("<td align=right>".mksize($arr["downloaded"])."</td>\n");
print("<td align=right>$ratio</td>\n");
print("<td align=center>$arr[hitrun]</td>\n");
print("<td align=center>$arr[last_action]</td>\n");
print("<td align=center>".get_formatted_timediff(sql_timestamp_to_unix_timestamp($arr['completedat']),sql_timestamp_to_unix_timestamp($arr['completedat'])+$arr['seeding_time'])."</td>\n");
print("<td align=center><input type=checkbox name=warn[] value=$arr[id]></td>\n");
print("<td align=center><input type=checkbox name=reset[] value=$arr[id]></td>\n");
print(($userid ? "<td class=colhead align=center>".pic("editprofile.png","user.php?op=demote_user_HNR&amp;id=".$arr['userid']."&amp;n=".urlencode($arr['username'])."","Demote user to SFB")."</td>\n":""));
print("</tr>\n");
}
print("</table>\n");
if($user->admin)print("<p align=right><input type=submit value=Update></p>\n");
print("</form>\n");
if ($count > $perpage)
print("$pagerbottom");
print("</td></tr></table>\n");
CloseTable();
include("footer.php");
?>