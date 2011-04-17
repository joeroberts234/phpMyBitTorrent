<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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

if (eregi("catlist.php",$_SERVER["PHP_SELF"])) die("You cannot access this file directly.");

OpenTable(_bttypes);
$i = 0;
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n<tr>\n<td nowrap>\n";
echo "<p align=\"center\" class=\"categories\">";
foreach (catlist() as $c) {
        if (file_exists("themes/".$theme."/pics/cat_pics/".$c["image"])) {
                $i++;
                echo "<a href=\"torrents.php?cat=".$c["id"]."\">";
                echo "<img src=\"themes/".$theme."/pics/cat_pics/".$c["image"]."\" title=\"".$c["name"]."\" border=\"0\" alt=\"".$c["name"]."\" >";
                echo "</a>";
                if ($i == 3) {
                        echo "<br>";
                        $i = 0;
                }
        }elseif (file_exists("cat_pics/".$c["image"])) {
                $i++;
                echo "<a href=\"torrents.php?cat=".$c["id"]."\">";
                echo "<img src=\"cat_pics/".$c["image"]."\" border=\"0\" title=\"".$c["name"]."\" alt=\"".$c["name"]."\" >";
                echo "</a>";
                if ($i == 3) {
                        echo "<br>";
                        $i = 0;
                }
        }
}
echo "</p>";
echo "</td>\n</tr>\n</table>\n";
CloseTable();
?>