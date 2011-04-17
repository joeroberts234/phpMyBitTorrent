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

if (!defined('IN_PMBT')) die ("You can't access this file directly");
        global $db, $db_prefix;
OpenTable("Ratio Warnning");
if (isset($_POST['ratio']) && $_POST['ratio'] == 'config'){
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
$datacheck = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config WHERE name = 'enable'");
   if (!$db->sql_numrows($datacheck)) {
$db->sql_query( "INSERT INTO ".$db_prefix."_ratiowarn_config VALUES ('enable', '".$_POST['enable']."') ");
$db->sql_query( "INSERT INTO ".$db_prefix."_ratiowarn_config VALUES ('ratio_mini', '".$_POST['ratio_mini']."') ");
$db->sql_query( "INSERT INTO ".$db_prefix."_ratiowarn_config VALUES ('ratio_warn', '".$_POST['ratio_warn']."') ");
$db->sql_query("INSERT INTO ".$db_prefix."_ratiowarn_config VALUES ('ratio_ban', '".$_POST['ratio_ban']."') ");
bterror("No error found2.<br /><br /><a href=admin.php?op=ratiowarn_config>Back</a>","Settings Updated");
    }
while ($arr = $db->sql_fetchrow($res)) {
$name = $arr['name'];
if ($name != 'class_allowed')
$new_data = $_POST[$name];
else
$new_data = $_POST['class_allowed'];
$db->sql_query("UPDATE ".$db_prefix."_ratiowarn_config SET value = '$new_data' WHERE name = '$name'");
		
}
bterror("No error found.<br /><br /><a href=admin.php?op=ratiowarn_config>Back</a>","Settings Updated");
}
OpenTable('Warning Configs');
echo '<form action="admin.php?op=ratiowarn_config" method=post>';
print("<table width=\"100%\">\n");
    $resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
	while ($arr = $db->sql_fetchrow($resrws))$arr_config[$arr['name']] = $arr['value'];
$enable_yes = ($arr_config['enable'] == "true") ? 'checked="checked"' : '';
$enable_no  = ($arr_config['enable'] == "false") ? 'checked="checked"' : '';
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"Inable Ratio Warnning System","Activate");
echo"</td>\n<td>Enable Ratio waning</td><td align=\"right\">Yes <input type=radio name=enable value=\"true\" $enable_yes /> No <input type=radio name=enable value=\"false\" $enable_no />\n</td></tr>\n";
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"Set the ratio amount to where you want members to be added to the watched list","WATCH");
echo"</td>\n<td>RATIOWARN AMMOUNT</td><td align=\"right\"><input type=text name=ratio_mini value=\"$arr_config[ratio_mini]\" />\n</td></tr>\n";
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"How long in days do you want the user to be watched before They Are WARNNED","WARN");
echo"</td>\n<td>RATIOWARN_TIME</td><td align=\"right\"><input type=text name=ratio_warn value=\"$arr_config[ratio_warn]\" />\n</td></tr>\n";
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"How long in days do you want the user to be warnned before They Are BANNED","BAN");
echo"</td>\n<td>RATIOWARN_BAN</td><td align=\"right\"><input type=text name=ratio_ban value=\"$arr_config[ratio_ban]\" />\n</td></tr>\n";
echo "</table>\n\n";
echo "<input type=\"hidden\" name=\"ratio\" value=\"config\"><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" />\n";
echo "</form>\n";
CloseTable();
include('footer.php');
?>
