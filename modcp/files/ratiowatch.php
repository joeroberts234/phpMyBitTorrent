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
OpenTable("Ratio Watch");
$id = $_GET["id"];
if($do == "edit"){
$do="DELETE FROM ".$db_prefix."_ratiowarn WHERE userid =$id LIMIT 1" ;
$res=$db->sql_query($do);
		$numDone++;
print ("Stats for user ".$id." are now updated");
header("Refresh: 0; url=modcp.php?op=ratiowatch");
CloseTable();
}
else
{

    $resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn WHERE warned='no'");
	$reqrws = $db->sql_fetchrow($resrws);
	
    if ($reqrws < 1){
        echo "There are no users currently being watched for poor ratios.";
    }else{
        $res_rws = $db->sql_query("SELECT *, TO_DAYS(NOW()) - TO_DAYS(ratiodate) as difference FROM ".$db_prefix."_ratiowarn WHERE warned='no'");
        $num = $db->sql_numrows($res_rws);
        print("<tr><td ><font size=1 face=Verdana color=white>User</td><td ><font size=1 face=Verdana color=white>Ratio</td><td ><font size=1 face=Verdana color=white>Warned</td><td ><font size=1 face=Verdana color=white>Time Until Warning</td><td ><font size=1 face=Verdana color=white>Remove From Watch</td></tr>\n");
        for ($i = 0; $i < $num; ++$i)
        {            
            $arr = $db->sql_fetchrow($res_rws);
            $userid = $arr['userid'];
            $userr = $db->sql_query("SELECT username, uploaded, downloaded FROM ".$db_prefix."_users WHERE id='$userid'");
            $userq = $db->sql_fetchrow($userr);
            $user = $userq['username'];
			if ($userq["downloaded"] > 0) {
				$ratio = number_format($userq["uploaded"] / $userq["downloaded"], 2);
			}else{
				$ratio = "---";
			}
            
            $timeleft = ($arr['difference'] - $RATIOWARN_TIME)/-1;
            print("<tr><td class=alt1><a href=user.php?op=editprofile&id=$userid>$user</a></td><td class=alt2>$ratio</td><td class=alt1 align=left>no</td><td class=alt2>$timeleft days</td><td align=left ><form name=edit-player method=post action=modcp.php?op=ratiowatch&do=edit&id=$userid><input type=hidden name=warned value=$userid> <input class=btn type=submit value=edit ></form></td></tr>\n");
        }
CloseTable();		
    }//display users with poor ratios
CloseTable();
	}
   //end rws-watched
?>