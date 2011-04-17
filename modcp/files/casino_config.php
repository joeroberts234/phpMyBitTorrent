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

OpenTable("Casino");
if ($_POST['casino'] == 'config'){
$res = mysql_query("SELECT * FROM ".$db_prefix."_casino_config");
while ($arr = mysql_fetch_assoc($res)) {
$name = $arr['name'];
if ($name != 'class_allowed')
$new_data = $_POST[$name];
else
$new_data = $_POST['class_allowed'];
mysql_query("UPDATE ".$db_prefix."_casino_config SET value = '$new_data' WHERE name = '$name'");
}
bterror("No error found.<br /><br /><a href=modcp.php?op=casino_config>Back</a>","Settings Updated");
}
OpenTable("Casino Settings:");
echo '<form action="modcp.php?op=casino_config" method=post>';
print("<table width=\"100%\">\n");
$res = mysql_query("SELECT * FROM ".$db_prefix."_casino_config");
while ($arr = mysql_fetch_assoc($res))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])
if ($arr_config["enable"]){
print("Casino is currently enabled, so this configuration page is closed.<br /><br />Classes allowed in casino, are: ");
$class = explode("|", $arr_config['class_allowed']);
$classes_playing = '';
for ($x = 0; $x < count($class); $x++) {
$classes_playing = (!$classes_playing) ? get_user_class_name($class[$x]) : ', ' . get_user_class_name($class[$x]);
print($classes_playing);
}
die;
}
$enable_yes = ($arr_config['enable'] == 1) ? 'checked="checked"' : '';
$enable_no  = ($arr_config['enable'] == 0) ? 'checked="checked"' : '';
///////////////////////Enable/Desable Casino/////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Enable The Casino</td><td class=\"tableb\" align=left>Yes <input class=\"tableb\" type=radio name=enable value=\"1\" $enable_yes /> No <input class=\"tableb\" type=radio name=enable value=\"0\" $enable_no /></td></tr>");
/////////////////////////////////////////////////////////////////////

/////////////////////////Mini Ratio//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Minimun Ratio</td><td class=\"tableb\" align=left><input type=text name=ratio_mini value=\"$arr_config[ratio_mini]\" /></td></tr>");
//////////////////////Fin Mini Ratio////////////////////////////////

/////////////////////////Casino Max Trys//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Max Trys (How many times users can play? After that he have to wait 5hours</td><td class=\"tableb\" align=left><input type=text name=maxtrys value=\"$arr_config[maxtrys]\" /></td></tr>");
//////////////////////Fin Mini Ratio////////////////////////////////

/////////////////////////win_amount_on_number//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Win Amount in Bet on Number Game: How much do the player win in the bet on number game eg. bet 300, win_amount=3 ---->>> 300*3= 900 win</td><td class=\"tableb\" align=left><input type=text name=win_amount_on_number value=\"$arr_config[win_amount_on_number]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////win_amount//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Win Amount in Bet on a Color: How much do the player win in the bet on a color game eg. bet 300, win_amount=3 ---->>> 300*3= 900 win</td><td class=\"tableb\" align=left><input type=text name=win_amount value=\"$arr_config[win_amount]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////maxusrbet//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Amount of bets to allow per person in Bet P2P Game</td><td class=\"tableb\" align=left><input type=text name=maxusrbet value=\"$arr_config[maxusrbet]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////maxtotbet//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Amount of total open bets allowed in Bet P2P Game</td><td class=\"tableb\" align=left><input type=text name=maxtotbet value=\"$arr_config[maxtotbet]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////Cheat Value//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Cheat Value (higher value -> less winner)</td><td class=\"tableb\" align=left><input type=text name=cheat_value value=\"$arr_config[cheat_value]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////

/////////////////////////cheat_value_max//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Cheat Value MAx: then cheat value = cheat value max -->> i hope you know what i mean. ps: must be higher as cheat value.</td><td class=\"tableb\" align=left><input type=text name=cheat_value_max value=\"$arr_config[cheat_value_max]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////cheat_breakpoint//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Cheat Breackpoint very important value -> if (win MB > max download global/cheat breakpoint)</td><td class=\"tableb\" align=left><input type=text name=cheat_breakpoint value=\"$arr_config[cheat_breakpoint]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////cheat_ratio_user//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Cheat Ratio User: if casino_ratio_user > cheat ratio user -> cheat value = random(cheat_value,cheat_value_max)</td><td class=\"tableb\" align=left><input type=text name=cheat_ratio_user value=\"$arr_config[cheat_ratio_user]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////

/////////////////////////cheat_ratio_global//////////////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Casino Cheat Ratio Global: (same as user just global)</td><td class=\"tableb\" align=left><input type=text name=cheat_ratio_global value=\"$arr_config[cheat_ratio_global]\" /></td></tr>");
//////////////////////////////////////////////////////////////////////////
        echo "<tr><td><p>"._btaccesslevel."</p></td><td><p>";
        echo "<select name=\"class_allowed\">";
        echo "<option "; if ($arr_config["class_allowed"] == "user") echo "selected "; echo "value=\"user\">"._btclassuser."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "premium") echo "selected "; echo "value=\"premium\">"._btclasspremium."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "moderator") echo "selected "; echo "value=\"moderator\">"._btclassmoderator."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "admin") echo "selected "; echo "value=\"admin\">"._btclassadmin."</option>";
        echo "</select>";
        echo "</p></td></tr>";
echo '<tr>
<td class="tableb" colspan="4" align="center">
<input type="hidden" name="casino" value="config"><input type="submit" name="submit" value="Apply Changes">
</td>
</tr>
</table>
</form>';
CloseTable();
include('footer.php');
?>