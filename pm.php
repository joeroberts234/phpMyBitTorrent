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

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
if (!$user->user) loginrequired("user");

?>
 <SCRIPT language="JavaScript">
function submitform()
{
  document.folder.submit();
}
</SCRIPT>
<?


if (!isset($op)) {
        if (isset($mid1) AND is_numeric($mid)) $op = "readmsg";
        else $op = "inbox";
}

switch($op) {
	case "inbox_delete": {
                OpenTable(_btpmdelete);
                if (!isset($postback)) {
                        $msgs = Array();
                        foreach ($_POST as $key=>$val) {
                                if (!preg_match("/^del_([0-9]{20})$/si",$key,$match)) continue;
                                if ($_POST[$match[0]] != "true") continue;
                                $msgs[] = $match[1];
                        }
                        echo "<form action=\"pm.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"inbox_delete\" />\n";
                        echo "<input type=\"hidden\" name=\"del\" value=\"".implode(",",$msgs)."\"/>\n";
                        echo "<p align=\"center\">"._btpmdelconfirm."</p>\n";
                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btpmdelbtn."\" /></p>\n";
                        echo "</form>\n";
                } else {
                        if (!isset($del) OR !eregi("^([0-9]{20},)*[0-9]{20}$",$del)) bterror(_btinvalidpm,_btpmdelete);
                        $msgs = explode(",",$del);
                        $sql = "UPDATE ".$db_prefix."_private_messages SET `is_read` = 'true', `recipient_del` = 'true' WHERE recipient = '".$user->id."' AND id IN (".$del.");";
                        $db->sql_query($sql) or btsqlerror($sql);
                        echo "<p>"._btpmdeletedsuccessfully."</p>\n";
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=pm.php?op=inbox\">\n";
                }
                CloseTable();
                break;
        }
        case "outbox_delete": {
                OpenTable(_btpmdelete);
                if (!isset($postback)) {
                        $msgs = Array();
                        foreach ($_POST as $key=>$val) {
                                if (!preg_match("/^del_([0-9]{20})$/si",$key,$match)) continue;
                                if ($_POST[$match[0]] != "true") continue;
                                $msgs[] = $match[1];
                        }
                        echo "<form action=\"pm.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"outbox_delete\" />\n";
                        echo "<input type=\"hidden\" name=\"del\" value=\"".implode(",",$msgs)."\"/>\n";
                        echo "<p align=\"center\">"._btpmdelconfirm."</p>\n";
                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btpmdelbtn."\" /></p>\n";
                        echo "</form>\n";
                } else {
                        if (!isset($del) OR !eregi("^([0-9]{20},)*[0-9]{20}$",$del)) bterror(_btinvalidpm,_btpmdelete);
                        $msgs = explode(",",$del);
                        $sql = "UPDATE ".$db_prefix."_private_messages SET `sender_del` = 'true' WHERE sender = '".$user->id."' AND id IN (".$del.");";
                        $db->sql_query($sql) or btsqlerror($sql);
                        echo "<p>"._btpmdeletedsuccessfully."</p>\n";
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=pm.php?op=outbox\">\n";
                }
                CloseTable();
                break;
        }

        case "inbox_del": {
                if (!isset($mid) OR !is_numeric($mid)) bterror(_btinvalidpm,_btmessage);
                $sql = "UPDATE ".$db_prefix."_private_messages SET `is_read` = 'true', `recipient_del` = 'true' WHERE id = '".$mid."' AND recipient = '".$user->id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
                break;
        }
	case "outbox_del": {
                if (!isset($mid) OR !is_numeric($mid)) bterror(_btinvalidpm,_btmessage);
                $sql = "UPDATE ".$db_prefix."_private_messages SET `sender_del` = 'true' WHERE id = '".$mid."' AND sender = '".$user->id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=outbox");
                die();
                break;
        }
        case "inbox_delall": {
                OpenTable(_btpmdelall);
                if (!isset($postback)) {
                        echo "<form action=\"pm.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"inbox_delall\" />\n";
                        echo "<p align=\"center\">"._btpmdelallconfirm."</p>\n";
                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btpmdelbtn."\" /></p>\n";
                        echo "</form>\n";
                } else {
                        $sql = "UPDATE ".$db_prefix."_private_messages SET `is_read` = 'true', `recipient_del` = 'true' WHERE recipient = '".$user->id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        echo "<p>"._btpmdeletedsuccessfully."</p>\n";
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=pm.php?op=inbox\">\n";
                }
                CloseTable();
                break;
        }
	case "outbox_delall": {
                OpenTable(_btpmdelall);
                if (!isset($postback)) {
                        echo "<form action=\"pm.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"outbox_delall\" />\n";
                        echo "<p align=\"center\">"._btpmdelallconfirm."</p>\n";
                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btpmdelbtn."\" /></p>\n";
                        echo "</form>\n";
                } else {
                        $sql = "UPDATE ".$db_prefix."_private_messages SET `sender_del` = 'true' WHERE sender = '".$user->id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        echo "<p>"._btpmdeletedsuccessfully."</p>\n";
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=pm.php?op=outbox\">\n";
                }
                CloseTable();
                break;
        }
        case "send": {
                include("pm/send.php");
                break;
        }
        case "readmsg": {
                include("pm/readmsg.php");
                break;
        }
        case "blacklist": {
                if (!isset($id) OR !is_numeric($id)) bterror(_bterrusernotexists,_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror(_bterrusernotexists,_btpm);
                $sql = "INSERT INTO ".$db_prefix."_private_messages_blacklist (master, slave) VALUES ('".$user->id."','".$id."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);

                header("Location: pm.php?op=inbox");
                die();
        }
                case "removeblacklist": {
                if (!isset($id) OR !is_numeric($id)) bterror(_bterrusernotexists,_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror(_bterrusernotexists,_btpm);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }

        case "bookmark": {
                if (!isset($id) OR !is_numeric($id)) bterror(_bterrusernotexists,_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror(_bterrusernotexists,_btpm);
                $sql = "INSERT INTO ".$db_prefix."_private_messages_bookmarks (master, slave) VALUES ('".$user->id."','".$id."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }
                case "removebookmark": {
                if (!isset($id) OR !is_numeric($id)) bterror(_bterrusernotexists,_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror(_bterrusernotexists,_btpm);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master='".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }
	case "outbox": {
                include("pm/outbox.php");
                break;
        }
        case "inbox":
        default: {
                include("pm/inbox.php");
                break;
        }
}

include("footer.php");
?> 