<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");
        global $db, $db_prefix;

	OpenTable("Warned Accounts");
	$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE active='1' AND warned='1' ORDER BY username") or sqlerr();
$num = $db->sql_numrows($res);
print("<center><br><br><table border=1  cellspacing=0 cellpadding=1>\n");
print("<tr align=center><td class=table_head width=90>User Name</td>
 <td class=table_head width=70>Registered</td>
 <td class=table_head width=75>Last Access</td>  
 <td class=table_head width=75>User Class</td>
 <td class=table_head width=70>Downloaded</td>
 <td class=table_head width=70>Uploaded</td>
 <td class=table_head width=45>Ratio</td>
 <td class=table_head width=225>Moderator Comments</td>
</tr>\n");
for ($i = 1; $i <= $num; $i++)
{
$arr = $db->sql_fetchrow($res);
if ($arr['regdate'] == '0000-00-00 00:00:00')
  $arr['regdate'] = '-';
if ($arr['lastlogin'] == '0000-00-00 00:00:00')
  $arr['lastlogin'] = '-';


$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
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
  $uploaded = mksize($arr["uploaded"]);
  $downloaded = mksize($arr["downloaded"]);

$added = substr($arr['regdate'],0,10);
$last_access = substr($arr['lastlogin'],0,10);
$class= $arr["level"];

print("<tr><td align=left><a href=user.php?op=editprofile&id=$arr[id]><b>$arr[username]</b></a></td>
  <td align=center>$added</td>
  <td align=center>$last_access</td>
  <td align=center>$class</td>
  <td align=center>$downloaded</td>
  <td align=center>$uploaded</td>
  <td align=center>$ratio</td>
  <td align=center>$arr[modcomment]</td></tr>\n");
}

print("</table>\n");

CloseTable();
?>