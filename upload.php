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
if(!checkaccess("upload")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have Permissions to Access Upload at this time</p>";
CloseErrTable();
die();
}

switch ($upload_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
}

OpenTable(_btupload);
echo "<table border=\"0\" width=\"100%\" height=\"100\" align=\"center\">\n";
echo "<tr><td><p align=\"center\"><a href=\"upload.php?op=torrent\"><img src=\"themes/".$theme."/pics/torrent.png\" border=\"0\" /><br />"._btuploadatorrent."</a></p></td><td><p align=\"center\"><a href=\"upload.php?op=link\"><img src=\"themes/".$theme."/pics/link.png\" border=\"0\" /><br />"._btuploadalinkarchive."</a></p></td></tr>\n";
echo "</table>\n";
CloseTable();

switch ($op) {
        case "torrent": {
                include_once("upload/torrent.php");
                break;
        }
        case "taketorrent": {
                include_once("upload/taketorrent.php");
                break;
        }
        case "takelink": {
                include_once("upload/takelink.php");
                break;
        }
        case "link": {
                include_once("upload/link.php");
                break;
        }
}
include("footer.php");
?>