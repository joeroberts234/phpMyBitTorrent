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

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
if($do == "editcon"){
if(isset($active)) $active = $active;
else
$active = "false";
if(isset($by_torrent)) $by_torrent = '1';
else
$by_torrent = "0";

        $sql = "INSERT INTO ".$db_prefix."_bonus_points (active, upload, comment, offer, fill_request, seeding, by_torrent) VALUES ('".$active."', '".$upload."', '".$comment."', '".$offer."', '".$fill_request."', '".$seeding."', '".$by_torrent."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_bonus_points;");
        $db->sql_query($sql);
        header("Location: admin.php?op=bonus_system&saved=1#bonus_system");
}
                        $bon = "SELECT active, upload, comment, offer, fill_request, seeding, by_torrent FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $upload, $comment, $offer, $fill_request, $seeding, $by_torrent) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable(_admbonsetting);
echo "<table width=\"100%\"><tr><td>";
echo "<form name=\"point\" method=post action=admin.php?op=bonus_system>";
echo"<input name=\"do\" value=\"editcon\" type=\"hidden\">\n";
echo "<table width=\"100%\"><tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbononofexp,_admbononof);
echo"</td>";
echo "<td>"._admbonalo."</td><td align=\"right\"><input type=\"checkbox\" name=\"active\" value=\"true\"".(($active =="true")? "checked" : "" )."></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbonupex,_admbonupext);
echo"</td>";
echo "<td>"._admbonup."</td><td align=\"right\"><input type=\"text\" name=\"upload\" value=\"".$upload."\" size=\"40\"></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admboncoex,_admboncoext);
echo"</td>";
echo "<td>"._admbonco."</td><td align=\"right\"><input type=\"text\" name=\"comment\" value=\"".$comment."\" size=\"40\"></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbonofferex,_admbonofferext);
echo"</td>";
echo "<td>"._admbonoffer."</td><td align=\"right\"><input type=\"text\" name=\"offer\" value=\"".$offer."\" size=\"40\"></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbonseedex,_admbonseedext);
echo"</td>";
echo "<td>"._admbonseed."</td><td align=\"right\"><input type=\"text\" name=\"seeding\" value=\"".$seeding."\" size=\"40\"></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbonseedtorex,_admbonseedtorext);
echo"</td>";
echo "<td>"._admbonseedtor."</td><td align=\"right\"><input type=\"checkbox\" name=\"by_torrent\" value=\"true\"".(($by_torrent =="1")? "checked" : "" )."></td></tr>";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),_admbonreqex,_admbonreqext);
echo"</td>";
echo "<td>"._admbonreq."</td><td align=\"right\"><input type=\"text\" name=\"fill_request\" value=\"".$fill_request."\" size=\"40\"></td></tr>";
echo "</td></tr></table>";
echo "<input name=\"submit\" value=\""._admbonbongo."\" type=\"submit\">";
echo "</form>";
echo "</td></tr></table>";
CloseTable();
                        $spl = '';
						$sql = 'SELECT `id` , `bonusname` , `points` , `description` , `art` , `menge` FROM `torrent_bonus` ORDER BY `art`';
                        $row = $db->sql_query($sql);
while ($res = $db->sql_fetchrow($row)) 
						$spl .="<tr class=\"tableb\"><td>".$res['bonusname']."</td><td>".$res['points']."</td><td>".$res['description']."</td><td>".$res['art']."</td><td>".$res['menge']."</td><td>5</td><tr>\n";
						$db->sql_freeresult($row);

OpenTable("Bonus Value");
echo "<table width=\"700\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">";
echo "<form name=\"spend\" method=post action=admin.php?op=staffmess&page=pm>";
echo "<tr><td class=\"tabletitle\" align=\"left\">1</td><td class=\"tabletitle\" align=\"left\">2</td><td class=\"tabletitle\" align=\"left\">3</td><td class=\"tabletitle\" align=\"left\">4</td><td class=\"tabletitle\" align=\"left\">5</td><td class=\"tabletitle\" align=\"left\">5</td></tr>";
echo $spl;
echo "</form>";
echo "</table>";
CloseTable();
?>