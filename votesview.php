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
global $db_prefix;
function gmtime()
{
    return strtotime(get_date_time());
}
function get_date_time($timestamp = 0)
{
if ($timestamp)
return date("Y-m-d H:i:s", $timestamp);
else
  $idcookie = $_COOKIE['uid'];
  return gmdate("Y-m-d H:i:s", time());
}
$requestid = $_GET[requestid];

$res2 = $db->sql_query("select count(".$db_prefix."_addedrequests.id) from ".$db_prefix."_addedrequests inner join ".$db_prefix."_users on ".$db_prefix."_addedrequests.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_requests on ".$db_prefix."_addedrequests.requestid = ".$db_prefix."_requests.id WHERE ".$db_prefix."_addedrequests.requestid =$requestid") or print(mysql_error());;
$row = $db->sql_fetchrow($res2);
$count = $row[0];





$res = $db->sql_query("select ".$db_prefix."_users.id as userid,".$db_prefix."_users.username, ".$db_prefix."_users.downloaded,".$db_prefix."_users.uploaded, ".$db_prefix."_requests.id as requestid, ".$db_prefix."_requests.request from ".$db_prefix."_addedrequests inner join ".$db_prefix."_users on ".$db_prefix."_addedrequests.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_requests on ".$db_prefix."_addedrequests.requestid = ".$db_prefix."_requests.id WHERE ".$db_prefix."_addedrequests.requestid =$requestid $limit") or print(mysql_error());

OpenTable("Votes");

$res2 = $db->sql_query("select request from ".$db_prefix."_requests where id=$requestid");
$arr2 = $db->sql_fetchrow($res2);

OpenTable2(" VOTES : <a href=reqdetails.php?id=$requestid>$arr2[request]</a>");
print("<p> VOTE FOR THIS <a href=addrequest.php?id=$requestid><b> REQUEST </b></a></p>");
CloseTable2();

if ($db->sql_numrows($res) == 0)
 print("<p align=center><b> NOTHING FOUND </b></p>\n");
else
{
 print("<center><table cellspacing=0 cellpadding=3 class=table_table>\n");
 print("<tr><td class=table_head> USERNAME </td><td class=table_head align=left> UPLOADED </td><td class=table_head align=left> DOWNLOADED </td>".
   "<td class=table_head align=left> RATIO </td>\n");

 while ($arr = $db->sql_fetchrow($res))
 {

$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);
        if ($downloaded == 0)
                $ratio = "&infin;";
        elseif ($ratio < 0.1)
                $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.2)
                $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.3)
                $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.4)
                $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.5)
                $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.6)
                $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.7)
                $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.8)
                $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.9)
                $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 1)
                $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
        else
                $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
$uploaded =mksize($arr["uploaded"]);
$joindate = "$arr[added] (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"])) . " ago)";
$downloaded = mksize($arr["downloaded"]);
if ($arr["enabled"] == 'no')
 $enabled = "<font color = red>No</font>";
else
 $enabled = "<font color = green>Yes</font>";

 print("<tr><td class=table_col1><a href=user.php?op=profile&id=$arr[userid]><b>$arr[username]</b></a></td><td align=left class=table_col2>$uploaded</td><td align=left class=table_col1>$downloaded</td><td align=left class=table_col2>$ratio</td></tr>\n");
 }
 print("</table></center><BR><BR>\n");
}

CloseTable();

include ("footer.php")

?>