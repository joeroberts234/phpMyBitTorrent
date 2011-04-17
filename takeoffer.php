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

foreach(explode(":","msg:type:name") as $v) {
if (!isset($_POST[$v]))
bterror("Fill all fields.","Error!!!");
}

$name = $_POST["name"];
$descrmain = unesc($_POST["msg"]);
if (!get_magic_quotes_gpc()) $msg = escape($msg);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $msg)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
if (!$msg)
bterror("You should enter a description!","Error!!!");
$catid = (0 + $_POST["type"]);
if (!$catid)
bterror("You should select a category!","Error!!!");
if (!$name)
bterror("You should enter a name for your offer!","Error!!!");
$torrent = $_POST["name"];
$ret =$db->sql_query("INSERT INTO ".$db_prefix."_offers (userid, name, descr, category, added) VALUES ('".$user->id."', '".$torrent."', '".$msg."', $catid, NOW() )");
@$db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES('".$user->id."', ' is making a offer for " . $torrent . "', NOW())");

if (!$ret) {
if (mysql_errno() == 1062);
bterror(mysql_error(), "mysql puked: ");
}
$id = $db->sql_nextid();
header("Location: " . $siteurl . "/offdetails.php?id=" . $id . "");
include("footer.php");
?>
