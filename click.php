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
*------              2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
include("header.php");

$mode = $_GET['mode'];



switch ($mode) {
    case "in":

        $id = htmlspecialchars($_GET[id]);
        $get = mysql_fetch_assoc(mysql_query("SELECT * FROM `torrent_affiliates` WHERE `id` = '$id' LIMIT 1"));
        $insert = mysql_query("UPDATE `torrent_affiliates` SET `in` = 'in+1' WHERE `id` = '$id'");
        header("Location: http://www.jungle-pirates.com");
    break;

    case "out":

        $id = htmlspecialchars($_GET[id]);

        $get = mysql_fetch_assoc(mysql_query("SELECT * FROM `torrent_affiliates` WHERE `id` = '$id' LIMIT 1"));

        $insert = mysql_query("UPDATE `torrent_affiliates` SET `out` = 'out+1' WHERE `id` = '$id'");

        header("Location: $get[url]");
    break;
}

include("footer.php");
?>
