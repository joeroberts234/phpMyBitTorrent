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
if (isset($_POST['lottery']) && $_POST['lottery'] == 'config')
{

$res = mysql_query("SELECT * FROM ".$db_prefix."_lottery_config") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
{
$name = $arr['name'];

if ($name != 'class_allowed')
$new_data = (isset($_POST[$name]))? $_POST[$name] : '' ;
else
$new_data = $_POST['class_allowed'];

if (($name != 'lottery_winners') && ($name != 'lottery_winners_amount') && ($name != 'lottery_winners_time'))
mysql_query("UPDATE ".$db_prefix."_lottery_config SET value = '$new_data' WHERE name = '$name'") or sqlerr(__FILE__, __LINE__);
}
bterror("Settings were successfully change.<br /><br /><a href=admin.php?op=lottery_config>Go Back</a>","Settings Changed");
}

?>
<form action="admin.php?op=lottery_config" method=post>

<?

print("<table width=\"100%\">\n");

$res = mysql_query("SELECT * FROM ".$db_prefix."_lottery_config") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
$arr_config[$arr['name']] = $arr['value'];

if (!$arr_config["enable"])
OpenTable("Lottery Configuration:");

if ($arr_config["enable"])
{
OpenTable("Lottery Enabled");
print("Lottery is currently enabled, so this configuration page is closed.<br /><br />Classes playing in this lottery, are: ");
CloseTable();
include'footer.php';
}
$selected = '';
if ($arr_config["ticket_amount_type"] != 'GB')
$selected2 = ' selected';
else
$selected = ' selected';

$use_prize_fund_yes = ($arr_config['use_prize_fund']) ? 'checked="checked"' : '';
$use_prize_fund_no = (!$arr_config['use_prize_fund']) ? 'checked="checked"' : '';

$enable_yes = ($arr_config['enable'] == 1) ? 'checked="checked"' : '';
$enable_no = ($arr_config['enable'] == 0) ? 'checked="checked"' : '';
                echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";

print("<tr><td>Enable The Lottery</td><td class=\"tableb\" align=left>Yes <input class=\"tableb\" type=radio name=enable value=\"1\" $enable_yes /> No <input class=\"tableb\" type=radio name=enable value=\"0\" $enable_no /></td></tr>");
print("<tr><td>Use Prize Fund (No, uses default pot of all users)</td><td class=\"tableb\" align=left>Yes <input class=\"tableb\" type=radio name=use_prize_fund value=\"1\" $use_prize_fund_yes /> No <input class=\"tableb\" type=radio name=use_prize_fund value=\"0\" $use_prize_fund_no /></td></tr>");
print("<tr><td>Prize Fund</td><td class=\"tableb\" align=left><input type=text name=prize_fund value=\"$arr_config[prize_fund]\" /></td></tr>");
print("<tr><td>Ticket Amount</td><td class=\"tableb\" align=left><input type=text name=ticket_amount value=\"$arr_config[ticket_amount]\" /></td></tr>");
print("<tr><td>Ticket Amount Type</td><td class=\"tableb\" align=left><select name=ticket_amount_type><option value=\"GB\"$selected>GB</option><option value=\"MB\"$selected2>MB</option></select></td></tr>");
print("<tr><td>Amount Of Tickets Allowed</td><td class=\"tableb\" align=left><input type=text name=user_tickets value=\"$arr_config[user_tickets]\" /></td></tr>");
        echo "<tr><td><p>"._btaccesslevel."</p></td><td><p>";
        echo "<select name=\"class_allowed\">";
        echo "<option "; if ($arr_config["class_allowed"] == "user") echo "selected "; echo "value=\"user\">"._btclassuser."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "premium") echo "selected "; echo "value=\"premium\">"._btclasspremium."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "moderator") echo "selected "; echo "value=\"moderator\">"._btclassmoderator."</option>";
        echo "<option "; if ($arr_config["class_allowed"] == "admin") echo "selected "; echo "value=\"admin\">"._btclassadmin."</option>";
        echo "</select>";
        echo "</p></td></tr>";


print("<tr><td>Total Winners</td><td class=\"tableb\" align=left><input type=text name=total_winners value=\"$arr_config[total_winners]\" /></td></tr>");
print("<tr><td>Current Date/Time</td><td class=\"tableb\" align=left>" . gmdate("Y-m-d H:i:s", time()) . "</td></tr>");
print("<tr><td>Start Date</td><td class=\"tableb\" align=left><input type=text name=start_date value=\"$arr_config[start_date]\" /></td></tr>");
print("<tr><td>End Date</td><td class=\"tableb\" align=left><input type=text name=end_date value=\"$arr_config[end_date]\" /></td></tr>");
?>
<tr>
<td class="tableb" colspan="4" align="center">
<input type="hidden" name="lottery" value="config"><input type="submit" name="submit" value="Apply Changes">
</td>
</tr>
</table></form>
<?


CloseTable();


?>
