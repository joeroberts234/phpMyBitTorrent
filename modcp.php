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
if (!eregi("modcp.php",$_SERVER["PHP_SELF"])) die ("You can't include this file");

/* FULL ADMIN CHECK
THE STRONGEST DEFENSE AGAINST HACKED M0DS
*/

function fulladmincheck($user) {
        if (!$user->moderator) return false;
        //THIS is the full check part
        global $db, $db_prefix, $_COOKIE;
        $userdata = cookie_decode($_COOKIE["btuser"]);
        if ($userdata[0] != $user->id) return false;
        if (addslashes($userdata[1]) != $user->name) return false;
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND level = 'moderator' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n1 = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n1) {
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND level = 'admin' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n2 = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n2) return false;
		}
        return true;
}

/* ADMIN ENTRY FUNCTION
DISPLAYS THE APPROPRIATE BUTTON FOR ADMIN SCRIPT

IN:
   NAME - NAME OF THE BUTTON
   OP - OPERATOR TO APPEND IN QUERY STRING
   TITLE - TEXT TO DISPLAY
OUT: NOTHING
*/
function adminentry($name, $op, $title) {
        global $theme;
        $image = "admin_".$name.".jpg";
        if (file_exists("themes/$theme/pics/modcp/".$image)) {
                $image = "themes/$theme/pics/modcp/".$image;
        } else {
                $image = "modcp/buttons/".$image;
        }

        $img = "<img src=\"".$image."\" border=\"0\" alt=\"".$title."\" title=\"".$title."\" /></a><br>";

        echo "<td align=\"center\" width=\"16%\"><p><a href=\"modcp.php?op=".$op."#".$op."\">".$img."<b>".$title."</b></a><br /><br /></p></td>\n";
}
/* ADMIN PICTURE FUNCTION
RETRIEVES AN IMAGE FROM ADMIN FOLDER

IN:
   NAME -  FILENAME OF THE IMAGE TO DISPLAY
   URL - (OPTIONAL) URL TO POINT A LINK TO
   ALT - (OPTIONAL) ALTERNATE TEXT FOR IMAGE
OUT:
   HTML <IMG> TAG POINTING TO modcp/PICS DIRECTORY
*/
function adminpic($name, $url = "", $alt = "") {
        if ($alt == "" AND $alt != null AND defined("_btalt_".$name)) $alt = constant("_btalt_".$name);

        $ret = "<img src=\"modcp/pics/".$name."\" border=\"0\" alt=\"".$alt."\" title=\"".$alt."\" />";
        if ($url != "") {
                return "<a href=\"".$url."\">".$ret."</a>";
        }
        return $ret;
}

include("header.php");
if (!fulladmincheck($user)) loginrequired("admin");
require_once("modcp/language/$language.php");

OpenTable(_admmenu);
echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
$counter = 2;
adminentry("home","home","Home");
#Fetching operators list and displaying Admin menu

$operators = Array();
$op_keys = Array();
$opdir = "modcp/items";
$ophandle = opendir($opdir);
while ($opfile = readdir($ophandle)) {
        $op_keys = Array();
        if (!eregi("\.php$",$opfile)) continue;
        include($opdir."/".$opfile);
        foreach ($op_keys as $key) {
                $operators[$key] = $opfile;
        }
        if ($counter == 4) {
                echo "</tr>\n<tr>\n";
                $counter = 1;
        } else {
                $counter++;
        }
}
closedir($ophandle);
unset($opdir,$opfile,$op_keys);

echo"</tr>\n</table>\n";
CloseTable();

//The "Core"
if (isset($op) AND array_key_exists($op,$operators)) require_once("modcp/files/".$operators[$op]);
else {
        OpenTable(_admoverview);
        //$sql = "SELECT COUNT(U.id) AS users, COUNT(T.id) AS torrents, COUNT(P.id) AS peers, SUM(P.upload_speed) AS speed FROM torrent_users U, torrent_torrents T, torrent_peers P;";
        echo "<p>";
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalusers."</b> ".$totuser."<br />\n";
        //Total Torrents and their size
        $sql = "SELECT COUNT(id), SUM(size) FROM ".$db_prefix."_torrents;";
        $res = $db->sql_query($sql);
        list ($tottorrent, $totshare) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotaltorrents."</b> ".$tottorrent."<br />\n";
        echo "<b>"._admtotalshare."</b> ".mksize($totshare)."<br />\n";
        //Total peers and their speed
        $sql = "SELECT COUNT(id), (SUM(upload_speed)+SUM(download_speed))/2 FROM ".$db_prefix."_peers;";
        $res = $db->sql_query($sql);
        list ($totpeers, $totspeed) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalpeers."</b> ".$totpeers."<br />\n";
        echo "<b>"._admtotalspeed."</b> ".mksize($totspeed)."/s<br />\n";
        //Total seeders and total leechers
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_peers GROUP BY seeder ORDER BY seeder ASC;";
        $res = $db->sql_query($sql);
        list ($totseeders) = $db->sql_fetchrow($res);
        list ($totleechers) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalseeders."</b> ".$totseeders."<br />\n";
        echo "<b>"._admtotalleechers."</b> ".$totleechers."<br />\n";
        $sql = "SELECT COUNT(id) as cnt, client FROM ".$db_prefix."_peers WHERE client IS NOT NULL GROUP BY client ORDER BY cnt DESC LIMIT 1;";
        $res = $db->sql_query($sql);
        list ($cnt, $client) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admmostusedclient."</b> ".$client." (".$cnt.")<br />\n";
        echo "</p>\n";
        CloseTable();
		OpenTable("Logs");
		$sql = "SELECT event, action, results, ip, datetime, userid FROM `".$db_prefix."_log` ORDER BY datetime DESC LIMIT 0, 5 "; 
		$res = $db->sql_query($sql);
		//$errors = $db->sql_fetchrow($res);
        echo "<table width=\"720px\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";
        echo "<tr>";
    	echo "<td border=\"1\"><p><b>"._btusername."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btuserip."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btuserhost."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btactions."</b></p></td>";
        echo"</tr>\n";
        echo "</thead>\n";
        echo"<tbody>\n";
        while ($errors = $db->sql_fetchrow($res)) {
		if($errors['userid'] == "0")
		{
		$by2['username'] = "Unknown";
		}else{
		$sqler = ("SELECT username FROM ".$db_prefix."_users WHERE id='".$errors['userid']."'");
        $by = $db->sql_query($sqler);
        $by2 = $db->sql_fetchrow($by);
		}
	    echo "<tr>\n";
		echo "<td width=\"15%\">".$by2['username']."</td>\n";
		echo "<td width=\"30%\">".$errors['datetime']."</td>\n";
		echo "<td width=\"25%\">".long2ip($errors["ip"])."</td>\n";
		echo "<td><p><font color=\"red\">".$errors['action']."</font></p><br /><p>".$errors['results']."</p></td>\n";
    	echo "</tr>\n";
        } 
		$db->sql_freeresult($res);
        echo "</tbody>\n";
        echo "</table>\n";
		CloseTable();
}

include("footer.php");
?>