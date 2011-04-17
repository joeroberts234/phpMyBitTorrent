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
OpenTable("Requests Config");
if ($_POST['ratio'] == 'config'){
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_requist_config");
$datacheck = $db->sql_query("SELECT * FROM ".$db_prefix."_requist_config WHERE name = 'enable'");
   if (!$db->sql_numrows($datacheck)) {
$db->sql_query( "INSERT INTO ".$db_prefix."_requist_config VALUES ('enable', '".$_POST['enable']."') ");
$db->sql_query( "INSERT INTO ".$db_prefix."_requist_config VALUES ('class_allowed',  '".$_POST['class_allowed']."') ");
bterror("No error found2.<br /><br /><a href=modcp.php?op=requests_config>Back</a>","Settings Updated");
    }
while ($arr = $db->sql_fetchrow($res)) {
$name = $arr['name'];
if ($name != 'class_allowed')
$new_data = $_POST[$name];
else
$new_data = $_POST['class_allowed'];
$db->sql_query("UPDATE ".$db_prefix."_requist_config SET value = '$new_data' WHERE name = '$name'");
		
}
bterror("No error found.<br /><br /><a href=modcp.php?op=requests_config>Back</a>","Settings Updated");
}
OpenTable('Requests Config');
echo '<form action="modcp.php?op=requests_config" method=post>';
print("<table width=\"100%\">\n");
    $resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_requist_config");
	while ($arr = $db->sql_fetchrow($resrws))$arr_config[$arr['name']] = $arr['value'];
$enable_yes = ($arr_config['enable'] == "true") ? 'checked="checked"' : '';
$enable_no  = ($arr_config['enable'] == "false") ? 'checked="checked"' : '';
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"Inable Requests System","Activate");
echo"</td>\n<td>Inable Requests</td><td align=\"right\">Yes <input type=radio name=enable value=\"true\" $enable_yes /> No <input type=radio name=enable value=\"false\" $enable_no />\n</td></tr>\n";
        echo "<tr>";
        echo "<td width=\"16\">";
help(pic("help.gif"),"Lowest level allowed to Use requests system",_btaccesslevel);
echo"</td>\n<td>"._btaccesslevel."</td><td align=\"right\">";
        echo "<select name=\"class_allowed\">";
        echo "<option "; if ($arr_config["class_allowed"] == "user") echo "selected "; echo "value=\"user\">"._btclassuser."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "premium") echo "selected "; echo "value=\"premium\">"._btclasspremium."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "moderator") echo "selected "; echo "value=\"moderator\">"._btclassmoderator."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "admin") echo "selected "; echo "value=\"admin\">"._btclassadmin."</option>";
        echo "</select>";
        echo "</td></tr>";
echo "</table>\n\n";
echo "<input type=\"hidden\" name=\"ratio\" value=\"config\"><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" />\n";
echo "</form>\n";
CloseTable();
include('footer.php');
?>
