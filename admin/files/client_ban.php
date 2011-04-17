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
switch($op){
        case "addclientban": {
                if (isset($postback_ip)) { //Ban Client
                        if (!get_magic_quotes_gpc()) $reason_client = escape(strip_tags($reason_client));
                        $sql = "INSERT INTO ".$db_prefix."_client_ban (client, reason, date) VALUES ('".$ban_client."', '".$reason_client."', NOW());";
						//die($sql);
                        $db->sql_query($sql) or btsqlerror($sql);
				}
                break;
		}
		
        case "editclientban": {
                if (!isset($id) OR !is_numeric($id)) break;
                if (!isset($postback_ip)) {
                        $is_edit = true;
                        $sql = "SELECT * FROM ".$db_prefix."_client_ban WHERE id='".$id."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) $is_edit = false;
                        else $banedit_ip = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
                } elseif (isset($postback_ip)) {
                        if (!get_magic_quotes_gpc()) $reason_client = escape(strip_tags($reason_client));
                        if (!isset($ban_client) OR $ban_client == '') { //ip2long returns < 0 if input is invalid
                                bterror(_admnoclient,_admban,false);
                                break;
                        }
                        $sql = "UPDATE ".$db_prefix."_client_ban SET client = '".$ban_client."', reason = '".$reason_client."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                }
                break;
		}
        case "delclientban": {
                if (isset($id)) {
                        if (!is_numeric($id)) break;
                        $db->sql_query("DELETE FROM ".$db_prefix."_client_ban WHERE id = '".$id."';");
                }                 break;
		}
}
OpenTable(_admclientban);
$sql = "SELECT * FROM ".$db_prefix."_client_ban;";
$res = $db->sql_query($sql);
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
		echo"<tr><td>\n";
        echo "<p align=\"center\"><b>"._admbanclientexp."</b></p><br /><br /><br /><br />\n";
        echo "</td></tr>\n";
		echo"<tr><td>\n";
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnobannedclient."</b></p>\n";
} else {
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
        echo "<thead>\n";
        echo "<tr><td><p><b>"._adminclient."</b></p></td><td><p><b>"._admbanreason."</b></p></td><td><p><b>"._admbanactions."</b></p></td></tr>";
        echo "</thead>\n";
        echo "<tbody>\n";
        while ($ban = $db->sql_fetchrow($res)) {
                echo "<tr><td><p>".$ban["client"]."</p></td><td><p>".htmlspecialchars($ban["reason"])."</p></td><td><p>".pic("edit.gif","admin.php?op=editclientban&id=".$ban["id"]).pic("drop.gif","admin.php?op=delclientban&id=".$ban["id"])."</p></td></tr>\n";
        }
        echo "</tbody>\n";
        echo "</table>\n";
}
        echo "</td></tr>\n";
        echo "</table>\n";
$db->sql_freeresult($res);
CloseTable();
OpenTable(_admaddeditban);
if(!isset($is_edit)) $is_edit = false;
if (!$is_edit OR isset($id)) {
        echo "<form action=\"admin.php\" method=\"post\">\n";

        if ($is_edit) {
                echo "<input type=\"hidden\" name=\"op\" value=\"editclientban\" />";
                echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
        } else {
                echo "<input type=\"hidden\" name=\"op\" value=\"addclientban\" />";
        }

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";


        echo "<tr>";
        echo "<td width=\"50%\"><p>"._adminclient."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"ban_client\" value=\"".((isset($banedit_ip["client"]))? $banedit_ip["client"] : '')."\" /></td>";
        echo "</tr>\n";

        echo "<tr>";
        echo "<td width=\"50%\"><p>"._adminclientre."</p></td>";
        echo "<td width=\"50%\"><input type=\"text\" name=\"reason_client\" value=\"".((isset($banedit_ip["reason"]))? $banedit_ip["reason"] : '')."\" /></td>";
        echo "</tr>\n";


        echo "<tr><td width=\"50%\"><input type=\"submit\" name=\"postback_ip\" value=\""._btsend."\" /><input type=\"reset\" value=\""._btreset."\" /></td><td width=\"50%\"></td></tr>\n";

        echo "</table>\n";
        echo "</form>\n";
}


CloseTable();
?>