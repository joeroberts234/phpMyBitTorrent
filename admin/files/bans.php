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
$is_edit = false;
$banedit_ip = Array("ipstart"=>"","ipend"=>"","reason"=>"");
$banedit_user = Array("username" => "", "banreason" => "");
if(!checkaccess("banusers")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to Ban Members</p>";
CloseErrTable();
die();
}

switch ($op) {
        case "addban": {
                if (isset($postback_ip)) { //Ban IP
                        if (!get_magic_quotes_gpc()) $reason_ip = escape(strip_tags($reason_ip));
                        $ipstart = @sprintf("%u",ip2long($startip));
						//echo sprintf("%u",ip2long($ipstart));
                        $ipend = @sprintf("%u",ip2long($endip));
                        if ($ipstart < 0 OR $ipend < 0) { //ip2long returns < 0 if input is invalid
                                bterror(_admbaninvalidip,_admban,false);
                                break;
                        }
                        $sql = "INSERT INTO ".$db_prefix."_bans (ipstart, ipend, reason) VALUES ('".$ipstart."', '".$ipend."', '".$reason_ip."');";
                        $db->sql_query($sql) or btsqlerror($sql);
                } else { //Ban User
                        if (!get_magic_quotes_gpc()) $reason_user = escape(strip_tags($reason_user));
                        $sql = "SELECT ban FROM ".$db_prefix."_users WHERE username = '".escape($username)."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) {
                                //echo $sql;
                                bterror(_admbanusernoexist,_admban,false);
                                break;
                        }
                        $db->sql_freeresult($res);
                        $sql = "UPDATE ".$db_prefix."_users SET ban = 1, banreason = '".strip_tags($reason_user)."' WHERE username = '".$username."';";
                        $db->sql_query($sql) or btsqlerror($sql);
						if($forumshare)forum_ban ($username, strip_tags($reason_user)); 
                        if (isset($returnto)) switch ($returnto) {
                                case "user": {
                                        if (isset($page)) header("Location: admin.php?op=user&page=".$page);
                                        else header("Location: admin.php?op=user");
                                                die();
                                }
                        }
                }
                break;
        }
        case "editban": {
                /*
                You can 'edit' only IP ranges.
                Even if editing a user ban has sense, because you may just want to change the ban reason,
                for now you have to unban and re-ban the user manually
                */
                if (!isset($id) OR !is_numeric($id)) break;
 if(getlevel($id) == "owner" && $user->group != "owner"){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit this Person</p>";
CloseErrTable();
die();
}
               if (!isset($postback_ip)) {
                        $is_edit = true;
                        $sql = "SELECT * FROM ".$db_prefix."_bans WHERE id='".$id."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) $is_edit = false;
                        else $banedit_ip = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
                } elseif (isset($postback_ip)) {
                        if (!get_magic_quotes_gpc()) $reason_ip = escape(strip_tags($reason_ip));
                        $ipstart = @ip2long($startip);
                        $ipend = @ip2long($endip);
                        if ($ipstart < 0 OR $ipend < 0) { //ip2long returns < 0 if input is invalid
                                bterror(_admbaninvalidip,_admban,false);
                                break;
                        }
                        $sql = "UPDATE ".$db_prefix."_bans SET ipstart = '".$ipstart."', ipend = '".$ipend."', reason = '".$reason_ip."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                }
                break;
        }
        case "delban": {
                if (isset($id)) {
                        if (!is_numeric($id)) break;
                        $db->sql_query("DELETE FROM ".$db_prefix."_bans WHERE id = '".$id."';");
                } elseif (isset($uid)) { //uid should be set then
                        if (!is_numeric($uid)) break;
                        $db->sql_query("UPDATE ".$db_prefix."_users SET ban = 0, banreason = NULL WHERE id = '".$uid."';");
						if($forumshare)forum_unban ($uid); 
                        if (isset($returnto)) switch ($returnto) {
                                case "user": {
                                        if (isset($page)) header("Location: admin.php?op=user&page=".$page);
                                        else header("Location: admin.php?op=user");
                                                die();
                                }
                        }
                }

                break;
        }
}


OpenTable(_admban);
echo "<p>"._admbanintro."</p>\n";
echo "<p>&nbsp;</p>\n";

echo "<hr />\n";
echo "<p><b>"._admbannedips."</b></p>\n";
echo "<p>&nbsp;</p>\n";
$sql = "SELECT * FROM ".$db_prefix."_bans;";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnobannedips."</b></p>\n";
} else {
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
        echo "<thead>\n";
        echo "<tr><td><p><b>"._admbanipstart."</b></p></td><td><p><b>"._admbanendip."</b></p></td><td><p><b>"._admbanreason."</b></p></td><td><p><b>"._admbanactions."</b></p></td></tr>";
        echo "</thead>\n";
        echo "<tbody>\n";
        while ($ban = $db->sql_fetchrow($res)) {
                echo "<tr><td><p>".@long2ip($ban["ipstart"])."</p></td><td><p>".@long2ip($ban["ipend"])."</p></td><td><p>".htmlspecialchars($ban["reason"])."</p></td><td><p>".pic("edit.gif","admin.php?op=editban&id=".$ban["id"]).pic("drop.gif","admin.php?op=delban&id=".$ban["id"])."</p></td></tr>\n";
        }
        echo "</tbody>\n";
        echo "</table>\n";
}
$db->sql_freeresult($res);

echo "<p>&nbsp;</p>\n";
echo "<hr />\n";
echo "<p><b>"._admbannedusers."</b></p>\n";
echo "<p>&nbsp;</p>\n";
//Banned Users
$sql = "SELECT * FROM ".$db_prefix."_users WHERE ban = 1 ORDER BY id;";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnobannedusers."</b></p>\n";
} else {
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
        echo "<thead>\n";
        echo "<tr><td><p><b>"._btusername."</b></p></td><td><p><b>"._admbanreason."</b></p></td><td><p><b>"._admbanactions."</b></p></td></tr>";
        echo "</thead>\n";
        while ($ban = $db->sql_fetchrow($res)) {
                echo "<tr><td><p><a href=\"user.php?op=profile&id=".$ban["id"]."\">".$ban["username"]."</a></p></td><td><p>".htmlspecialchars($ban["banreason"])."</p></td><td><p>".pic("drop.gif","admin.php?op=delban&uid=".$ban["id"])."</p></td></tr>\n";
        }
        echo "</table>\n";
}
$db->sql_freeresult($res);
echo "<p>&nbsp;</p>\n";

CloseTable();


OpenTable(_admaddeditban);

if (!$is_edit OR isset($id)) {
        echo "<form action=\"admin.php\" method=\"post\">\n";

        if ($is_edit) {
                echo "<input type=\"hidden\" name=\"op\" value=\"editban\" />";
                echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
        } else {
                echo "<input type=\"hidden\" name=\"op\" value=\"addban\" />";
        }

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";

        echo "<tr><td width=\"50%\"><b>"._admbaniprange."</b></td><td width=\"50%\"></td></tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._admbanipstart."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"startip\" value=\"".@long2ip($banedit_ip["ipstart"])."\" /></td>";
        echo "</tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._admbanendip."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"endip\" value=\"".@long2ip($banedit_ip["ipend"])."\" /></td>";
        echo "</tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._admbanreason."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"reason_ip\" value=\"".$banedit_ip["reason"]."\" /></td>";
        echo "</tr>\n";

        echo "<tr><td width=\"50%\"><input type=\"submit\" name=\"postback_ip\" value=\""._btsend."\" /><input type=\"reset\" value=\""._btreset."\" /></td><td width=\"50%\"></td></tr>\n";

        echo "</table>\n";
        echo "</form>\n";
}

echo "<hr />\n";

if (!$is_edit OR isset($uid)) {
        echo "<form action=\"admin.php\" method=\"post\">\n";

        if ($is_edit) {
                echo "<input type=\"hidden\" name=\"op\" value=\"editban\" />";
                echo "<input type=\"hidden\" name=\"uid\" value=\"".$uid."\" />";
        } else {
                echo "<input type=\"hidden\" name=\"op\" value=\"addban\" />";
        }

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";

        echo "<tr><td width=\"50%\"><b>"._admbanuser."</b></td><td width=\"50%\"></td></tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._btusername."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"username\" value=\"".$banedit_user["username"]."\" /></td>";
        echo "</tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._admbanreason."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"reason_user\" value=\"".$banedit_user["reason"]."\" /></td>";
        echo "</tr>\n";

        echo "<tr><td width=\"50%\"><input type=\"submit\" name=\"postback_user\" value=\""._btsend."\" /><input type=\"reset\" value=\""._btreset."\" /></td><td width=\"50%\"></td></tr>\n";

        echo "</table>\n";
        echo "</form>\n";
}

CloseTable();
?>