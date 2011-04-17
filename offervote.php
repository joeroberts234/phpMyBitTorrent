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
        global $db, $db_prefix;
if(!checkaccess("offers")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have Permissions to Access Offers at this time</p>";
CloseErrTable();
die();
}
$offerid = $_GET[id]+0;
if ($offerid == 0)
die();
$res2 = $db->sql_query("select count(".$db_prefix."_offervotes.id) from ".$db_prefix."_offervotes inner join ".$db_prefix."_users on ".$db_prefix."_offervotes.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_offers on ".$db_prefix."_offervotes.offerid = ".$db_prefix."_offers.id WHERE ".$db_prefix."_offervotes.offerid =$offerid");
$row = $db->sql_fetchrow($res2);
$count = $row[0];
$perpage = 5;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" );
$res = $db->sql_query("select ".$db_prefix."_users.id as userid,".$db_prefix."_users.username, ".$db_prefix."_users.downloaded,".$db_prefix."_users.uploaded, ".$db_prefix."_offers.id as ".$db_prefix."_offerid, ".$db_prefix."_offers.name from ".$db_prefix."_offervotes inner join ".$db_prefix."_users on ".$db_prefix."_offervotes.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_offers on ".$db_prefix."_offervotes.offerid = ".$db_prefix."_offers.id WHERE ".$db_prefix."_offervotes.offerid =$offerid $limit");
$res2 = $db->sql_query("select name from ".$db_prefix."_offers where id=$offerid");
$arr2 = $db->sql_fetchrow($res2);
print("<h1>Votes for <a href=offdetails.php?id=$offerid><b>$arr2[name]</b></a></h1>");
echo $pagertop;
if ($db->sql_numrows($res) == 0)
print("<p align=center><b>No votes Yet</b></p>\n");
else
{
print("<div align=center>");
print("<table border=1 cellspacing=0 cellpadding=5>\n");
print("<tr><td class=colhead>Member</td><td class=colhead align=left>Uploaded</td><td class=colhead align=left>Downloaded</td>".
"<td class=colhead align=left>Ratio</td>\n");
while ($arr = $db->sql_fetchrow($res))
{
$vres = $db->sql_query("select 1 from ".$db_prefix."_offervotes where offerid=$offerid and userid=$arr[userid]");
$vrow = $db->sql_fetchrow($vres);
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
else
   if ($arr["uploaded"] > 0)
     $ratio = "Inf.";
else
$ratio = "---";
$uploaded =mksize($arr["uploaded"]);
$joindate = "$arr[added] (" . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"])) . " ago)";
$downloaded = mksize($arr["downloaded"]);
if ($arr["enabled"] == 'no')
$enabled = "<font color = red>Non</font>";
else
$enabled = "<font color = green>Oui</font>";
print("<tr><td><a href=user.php?op=profile&id=$arr[userid]><b>$arr[username]</b></a></td><td align=left>$uploaded</td><td align=left>$downloaded</td><td align=left>$ratio</td></tr>\n");
}
print("</table></div>\n");
print("<br/><center><a href=\"javascript: history.go(-1);\">BACK</a></center><br />\n");
}
CloseTable();
include("footer.php");
?>
