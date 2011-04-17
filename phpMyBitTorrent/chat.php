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
*/
if (!eregi("chat.php",$_SERVER["PHP_SELF"])) die("You can't include this file.");

include("header.php");
//if (!file_exists("include/irc.ini")) bterror(_btchatnotenabled,_btircchat);
OpenTable(_btircchat);
$ircconfig = parse_ini_file("include/irc.ini");
$nick = preg_replace("/[^a-z0-9_]/i","",$user->name);
if($user->nick != "")$nick2 = preg_replace("/[^a-z0-9_]/i","",$user->nick);
else
$nick2 = $nick."@bittorrent.".$cookiedomain;

echo "<applet code=\"IRCApplet.class\" archive=\"pjirc/irc.jar,pjirc/pixx.jar\" width=\"640\" height=\"400\">\n";
echo "<param name=\"CABINETS\" value=\"pjirc/irc.cab,pjirc/securedirc.cab,pjirc/pixx.cab\">\n";
echo "<param name=\"nick\" value=\"".$nick."\">\n";
echo "<param name=\"alternatenick\" value=\"".$nick2."\">\n";
echo "<param name=\"name\" value=\"".$user->name."\">\n";
echo "<param name=\"host\" value=\"".$ircconfig["server"]."\">\n";
echo "<param name=\"language\" value=\"pjirc/".$language."\">\n";
echo "<param name=\"pixx:language\" value=\"pjirc/pixx-".$language."\">\n";
echo "<param name=\"gui\" value=\"pixx\">\n";
echo "<param name=\"soundbeep\" value=\"pjirc/snd/bell2.au\">\n";
echo "<param name=\"soundquery\" value=\"pjirc/snd/ding.au\">\n";
echo "<param name=\"command1\" value=\"/join ".$ircconfig["channel"]."\">\n";
echo "<param name=\"style:bitmapsmileys\" value=\"true\">\n";

$sql = "SELECT code, file FROM ".$db_prefix."_smiles GROUP BY file ORDER BY code ASC;";
$res = $db->sql_query($sql);
$i = 1;

while (list($code, $file) = $db->sql_fetchrow($res)) {
        echo "<param name=\"style:smiley".$i."\" value=\"".$code." smiles/".$file."\">\n";
        $i++;
}
$db->sql_freeresult($res);

//Other eventual parameters by .ini file
foreach ($ircconfig as $key=>$val) {
        if ($key == "server" OR $key == "channel") continue;
        echo "<param name=\"".$key."\" value=\"".$val."\">\n";
}
?>
					<param name="pixx:highlightnick" value="true">
					<param name="pixx:styleselector" value="true">
					<param name="pixx:setfontonstyle" value="true">
					<param name="pixx:timestamp" value="true">
					<param name="pixx:mouseurlopen" value="1 2">
					<param name="pixx:mousechanneljoin" value="1 2">
					<param name="pixx:nickfield" value="false">
<?php
echo "</applet>";


CloseTable();

include("footer.php");
?>