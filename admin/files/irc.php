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

$linebreak = (PHP_OS == "WIN") ? "\r\n" : "\n";
if (isset($postback)) {
        if (isset($edit)) {
                $errmsg = Array();
                if (!eregi("^[a-z][a-z0-9._-]*$",$server) AND !eregi("^(\d{1,3}\.){3}\d{1,3}$",$server)) $errmsg[] = _admircinvalidhost;
                if (!eregi("#[a-z0-9_]*$",$channel)) $errmsg[] = _admircinvalidchannel;
                if (!empty($advanced) AND !preg_match("/^[a-z0-9:_]* = [^\"\\t\\r\\n]*$/im", $advanced)) $errmsg[] = _admircinvalidadvanced;

                if (count($errmsg) > 0) bterror($errmsg,_admirc);

                $buffer = "server = ".$server.$linebreak."channel = ".$channel.$linebreak.$advanced;
                @unlink("include/irc.ini");
                @$fp = fopen("include/irc.ini","w");
                if ($fp) {
                        @fputs($fp,$buffer);
                        @fclose($fp);
                } else {
                        bterror(_admirccantsave."</p><p>&nbsp;</p><p class=\"nfo\">".nl2br($buffer)."</p>",_admirc);
                }
        }
        elseif (isset($delete) AND file_exists("include/irc.ini")) {
                if (!@unlink("include/irc.ini")) bterror(_admirccantdelete,_admirc);
        }
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}

OpenTable(_admirc);
echo "<p>"._admircintro."</p>\n";
if (file_exists("include/irc.ini")) {
        $irc_enabled = true;
        $ircconfig = parse_ini_file("include/irc.ini");
} else {
        $irc_enabled = false;
        $ircconfig = Array("server" => "", "channel" => "#");
}

$advsettings = "";
foreach ($ircconfig as $key => $val) {
        if ($key == "server" OR $key == "channel") continue;

        $advsettings .= $key." = ".$val.$linebreak;
}

echo "<p>&nbsp;</p>\n";
echo "<form action=\"admin.php?op=irc\" method=\"POST\">\n";
echo "<input type=\"hidden\" name=\"postback\" value=\"1\" />\n";
echo "<table border=\"0\" width=\"50%\">\n";
echo "<tr><td><p>"._admircserver."</p></td><td><p><input type=\"text\" name=\"server\" value=\"".$ircconfig["server"]."\" /></p></td></tr>\n";
echo "<tr><td><p>"._admircchannel."</p></td><td><p><input type=\"text\" name=\"channel\" value=\"".$ircconfig["channel"]."\" /></p></td></tr>\n";
echo "</table>\n";
echo "<p>&nbsp;</p>\n";
echo "<p>"._admircadvsettings."<br />\n";
echo "<textarea rows=\"10\" cols=\"50\" name=\"advanced\">".$advsettings."</textarea></p>\n";
echo "<p>&nbsp;</p>\n";
echo "<p><input type=\"submit\" name=\"edit\" value=\"".((!$irc_enabled) ? _admircenable : _admircedit )."\" />";
if ($irc_enabled) echo "<input type=\"submit\" name=\"delete\" value=\""._admircdisable."\" />";
echo "<input type=\"reset\" value=\""._admresetbtn."\" />";
echo "</p>\n";
echo "</form>";

CloseTable();

?>