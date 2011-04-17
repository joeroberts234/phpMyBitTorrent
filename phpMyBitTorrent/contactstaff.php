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
OpenTable('contact staff');
echo'<table>';
echo "<form method=\"post\" name=\"message\" action=\"takecontact.php\">";
echo'<tr>contact&nbsp;&nbsp;&nbsp;&nbsp;<input name="group" type="text" value="'.$group.'" readonly size ="74" /></td></tr>';
echo "<tr><td>";
if ($_GET["returnto"] || $_SERVER["HTTP_REFERER"]) {
echo "<input type=\"hidden\" name=\"returnto value=\"".($_GET["returnto"] ? $_GET["returnto"] : $_SERVER["HTTP_REFERER"])."\"/>";
} 
echo "Subject&nbsp;&nbsp;&nbsp;<input type=\"text\" size=\"74\" name=\"subject\"/><br/><br/>";
echo "<textarea name=\"msg\" cols=\"80\" rows=\"15\">".htmlspecialchars($body)."</textarea></td></tr>";
echo "<tr><td class=\"row2\" align=\"center\"><input type=\"submit\" value=\"Send it!\" class=\"btn\"/></td></tr>";
echo "</form></table>";
CloseTable();
include("footer.php");
?>
