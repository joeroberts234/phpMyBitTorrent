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
// Start reports block
$type = $_GET["type"];
if ($type == "user")
$where = " WHERE type = 'user'";
else if ($type == "torrent")
$where = " WHERE type = 'torrent'";
else if ($type == "forum")
$where = " WHERE type = 'forum'";
else
$where = "";

$res = mysql_query("SELECT count(id) FROM torrent_reports $where") or die(mysql_error());
$row = mysql_fetch_array($res);

$count = $row[0];
$perpage = 25;
//list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] . "?type=" . $_GET["type"] . "&" );

print("<br><center><a href=reports-complete.php>Voir Repports Complets</a></center><br>");

//echo $pagertop;

print("<table border=1 cellspacing=0 cellpadding=1 align=center width=95%>\n");
print("<tr><td class=table_head align=center>Par</td><td class=table_head align=center>Rapport</td><td class=table_head align=center>Type</td><td class=table_head align=center>Raison</td><td class=table_head align=center>Date</td><td class=table_head align=center>Traité Par</td><td class=table_head align=center>Marquer Comme Traité</td>");
if ($user->admin)
 printf("<td class=table_head align=center>Effacer</td>");
print("</tr>");
print("<form method=post action=takedelreport.php>");
$res = mysql_query("SELECT torrent_reports.id, torrent_reports.dealtwith,torrent_reports.dealtby, torrent_reports.addedby, torrent_reports.votedfor,torrent_reports.votedfor_xtra, torrent_reports.reason, torrent_reports.type, torrent_users.username, torrent_reports.complete, torrent_reports.dealtdate FROM torrent_reports INNER JOIN torrent_users on torrent_reports.addedby = torrent_users.id $where AND complete = '0' ORDER BY id desc $limit")or btsqlerror("SELECT torrent_reports.id, torrent_reports.dealtwith,torrent_reports.dealtby, torrent_reports.addedby, torrent_reports.votedfor,torrent_reports.votedfor_xtra, torrent_reports.reason, torrent_reports.type, torrent_users.username, torrent_reports.complete, torrent_reports.dealtdate FROM torrent_reports INNER JOIN torrent_users on torrent_reports.addedby = torrent_users.id $where AND complete = '0' ORDER BY id desc $limit");

while ($arr = mysql_fetch_assoc($res))
{
if ($arr['dealtwith'])
{
$res3 = mysql_query("SELECT username FROM torrent_users WHERE id=$arr[dealtby]");
$arr3 = mysql_fetch_assoc($res3);
$dealtwith = "<font color=green><b>Oui - <a href=account-details.php?id=$arr[dealtby]><b>$arr3[username]</b></a></b></font>";
}
else
$dealtwith = "<font color=red><b>Non</b></font>";
if ($arr[type] == "user")
{
$type = "account-details";
$res2 = mysql_query("SELECT username FROM torrent_users WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$name = $arr2[username];
}
else if  ($arr[type] == "forum")
{
$type = "forums";
$res2 = mysql_query("SELECT subject FROM torrent_forum_topics WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$subject = $arr2[subject];
}
else if ($arr[type] == "torrent")
{
$type = "torrents-details";
$res2 = mysql_query("SELECT name FROM torrent_torrents WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$name = $arr2[name];
if ($name == "")
 $name = "<b>[Deleted]</b>";
}

if ($arr[type] == "forum")
  { print("<tr><td><a href=account-details.php?id=$arr[addedby]><b>$arr[username]</b></a></td><td align=left><a href=$type.php?action=viewtopic&topicid=$arr[votedfor]&page=p#$arr[votedfor_xtra]><b>$subject</b></a></td><td align=left>$arr[type]</td><td align=left>$arr[reason]</td><td align=left>$arr[dealtdate]</td><td align=left>$dealtwith</td><td align=center><input type=\"checkbox\" name=\"delreport[]\" value=\"" . $arr[id] . "\" /></td></tr>\n");
  }
else {
print("<tr><td><a href=account-details.php?id=$arr[addedby]><b>$arr[username]</b></a></td><td align=left><a href=$type.php?id=$arr[votedfor]><b>$name</b></a></td><td align=left>$arr[type]</td><td align=left>$arr[reason]</td><td align=left>$arr[dealtdate]</td><td align=left>$dealtwith</td><td align=center><input type=\"checkbox\" name=\"delreport[]\" value=\"" . $arr[id] . "\" /></td>\n");
if ($user->admin)
 printf("<td><a href=delreport.php?id=$arr[id]>Delete</a></td>");
print("</tr>");
}}

print("</table>\n");

print("<p align=right><input type=submit value=Confirm></p>");
print("</form>");

//echo $pagerbottom;
print("<center><b>Il n'y a plus besoin d'effacer les rapports, ceux-ci une fois marqué comme traités sont archivés par le système.</b></center><br>");
//end_frame();
include("footer.php");
?>