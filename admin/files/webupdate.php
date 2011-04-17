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
$serverurl = "http://phpmybittorrent.com";

OpenTable(_admwebupdate);
echo "<p>"._admupdintro."</p>\n";
echo "</p>&nbsp;</p>\n\n";

do {
        if (! $ver = @file_get_contents($serverurl."/version")) {
                echo "<p class=\"denied\">"._admupderror."</p>\n";
                break;
        }

        echo "<p>"._admupdcurver." <b>".$version."</b><br />\n";
        echo _admupdlastver." <b>".$ver."</b><br />\n";
        if (version_compare($version,$ver,'<')) echo _admupdupdate;
        else echo _admupdnoupdate;
        echo "</p>\n";
} while (false);

CloseTable();
?>