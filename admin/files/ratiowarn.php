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
    $resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn WHERE warned='yes'");
	$reqrws = $db->sql_fetchrow($resrws);
	
	OpenTable("Ratio Warn System - Warned Users");
	print("<center><table border=1  cellspacing=0 cellpadding=1>\n");

    if ($reqrws < 1){
        echo "No users have been warned for maintaining poor ratios.";
    }else{
        $res_rws = $db->sql_query("SELECT *, TO_DAYS(NOW()) - TO_DAYS(warntime) as difference FROM ".$db_prefix."_ratiowarn WHERE warned='yes'");
        $num = $db->sql_numrows($res_rws);
        print("<tr><td>User</td><td>Ratio</td><td>Warned</td><td>Banned</td><td>Time Until Ban</td></tr>\n");
        for ($i = 0; $i < $num; ++$i)
        {
            $arr = $db->sql_fetchrow($res_rws);
            $userid = $arr['userid'];
            $userr = $db->sql_query("SELECT username, uploaded, downloaded FROM ".$db_prefix."_users WHERE id='$userid'");
            $userq = $db->sql_fetchrow($userr);
            $user = $userq['username'];
			if ($userq["downloaded"] > 0) {
				$ratio = number_format($userq["uploaded"] / $userq["downloaded"], 2);
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
			}else{
				$ratio = "---";
			}
            $banned = $arr['banned'];
            
            if($banned == 'no'){
                $timeleft = ($arr['difference'] - $RATIOWARN_BAN)/-1;
            }else{
                $timeleft = "null";
            }
            print("<tr><td class=alt1><a href=user.php?op=editprofile&id=$userid>$user</a></td><td class=alt2>$ratio</td><td class=alt1 align=left>yes</td><td class=alt1 align=left>$banned</td><td class=alt2>$timeleft days</td></tr>\n");
        }
    }//display warned users
print("</table></center>\n");

CloseTable();
?>