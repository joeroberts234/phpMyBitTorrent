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
global $db, $db_prefix;
OpenTable("Welcome The Casino ");

echo "<table  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\" background=\"casino/cback.jpg\">
<tr>
<td class=\"rowhead2\">";
?>
<style type="text/css">
<!--
.rowhead {
	color: #FF0000;
	font-weight: bold;
}
a:link, a:visited {

    color: #000000;
	font-weight: bold;

}
.rowhead2 {
	color: #000000;
	font-weight: bold;
}

-->
</style>
<?php
echo "<br/>";


$res = $db->sql_query("SELECT * FROM ".$db_prefix."_lottery_config");
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
$who_won = explode("|", $arr_config['lottery_winners']);
$who_won = array_unique($who_won);
$lottery_winners = '';
for ($x = 0; $x < count($who_won); $x++){	
$username = '';
$res2 = $db->sql_query("SELECT id, username FROM ".$db_prefix."_users");
while ($arr2 = $db->sql_fetchrow($res2))
{
if ($arr2['id'] == $who_won[$x])
{
$username = '<a href="user.php?op=profile&id='. $arr2['id'] .'">'. $arr2['username'] .'</a>';
$lottery_winners .= (!$lottery_winners) ? $username : ', '. $username;
break;
}
}}
if ($arr_config["ticket_amount_type"] == 'GB')
$arr_config['ticket_amount'] = 1024 * 1024 * 1024 * $arr_config['ticket_amount'];
else if ($arr_config["ticket_amount_type"] == 'MB')
$arr_config['ticket_amount'] = $arr_config['ticket_amount']*1024 * 1024;
$size = $arr_config['ticket_amount'];
$testammount = 250*1024*1024;
echo mksize($arr_config['ticket_amount']*239);
$total = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets"));
$pot = $total * $size;
$pott = mksize($pot);


$endday = $arr_config['end_date'];
if ($arr_config["enable"])
$statas = 'Running';
else
$statas = 'OFF';

if (count($who_won) > 1)
$winners = 'Winners';
else
$winners = 'Winner';
if (count($who_won) > 1)
$each = ' (Each)';
else
$each = '';
echo "<table bgcolor=\"#FFFFFF\" align=\"center\" width=\"80%\" border=\"1\">
  <tr>
    <td class=\"rowhead2\"><center>Lottery Stats</center></td>
  </tr>
</table>
<table bgcolor=#FFFFFF align=center width=80% border=1>
<tr>
<td class=\"rowhead\">Lottery Status </td>
<td class=\"rowhead\" align=\"left\">" .$statas. "</td>
</tr>
<tr>
<td class=\"rowhead\">Next Drawwing </td>
<td class=\"rowhead\" align=\"left\">" .$endday. "</td>
</tr>
<tr>
<td class=\"rowhead\">Current Prize  </td>
<td class=\"rowhead\" align=\"left\">".$pott." Extra Upload Data</td>
</tr>
<tr>
<td class=\"rowhead\">Last Lottery Winner(s)</td>
<td class=\"rowhead\" align=\"left\">" .count($who_won).$winners. "</td>
</tr>
<tr>
<td class=\"rowhead2\">LAst Lottery winners " .$winners. "</td>
<td class=\"rowhead2\" align=\"left\">".$lottery_winners."</td>
</tr>
<tr>
<td class=\"rowhead\">Pot Amount  ".$each."</td>
<td class=\"rowhead\" align=\"left\">".mksize($arr_config['lottery_winners_amount'])."</td>
</tr>
<tr>
<td class=\"rowhead2\">Last Lottery Date</td>
<td class=\"rowhead2\" align=\"left\">" .$arr_config["lottery_winners_time"]."</td>
</tr>
<tr>
<td class=\"rowhead2\">Current Tickets Bought</td>
<td class=\"rowhead2\" align=\"left\">".$total."</td>
</tr>
<tr>
<td class=\"rowhead2\">Show actuals players</td>
<td class=\"rowhead2\" align=\"left\"><a href=viewtickets.php>Click Here</a></td>
</tr>";

if ($arr_config["enable"])echo"<tr><td class=\"rowhead2\" width=\"100%\" colspan=\"2\"><font color=\"green\"><div  align=\"center\"><a href=\"tickets.php\"><b><font color=\"green\"> **** Play the Lottery NOW ****<b></a></div><br></tr></td>";
echo"</tr>
</table>
<br/>
<hr>
<!---------END DISPLAY LOTTERY WINNER------------------>
<table bgcolor=\"#FFFFFF\" align=\"center\" width=\"80%\" border=\"1\">
  <tr>
    <td class=\"rowhead2\"><center>5 Games are avalable<br/>You can Play</center></td>
  </tr>
</table>
<br/>
<hr>
<br/>
<table bgcolor=\"#FFFFFF\" width=\"40%\"  border=\"1\" align=\"center\">
  <tr>
    <td class=\"rowhead2\" align=\"center\"><a href=\"keno.php\">KENO</a></td>
  </tr>
  <tr>
    <td align=\"center\"><a href=\"casino.php\">Casino</a></td>
  </tr>
  <tr>
    <td align=\"center\"><a href=\"blackjack.php\">BlackJack</a></td>
  </tr>
  <tr>
    <td align=\"center\"><a href=\"tickets.php\">Lottery</a></td>
  </tr>
  <tr>
    <td align=\"center\"><a href=\"arcade.php\">Arcade</a></td>
  </tr>
  <tr>
    <td align=\"center\"><a href=\"casino_player.php\">Casino Players List</a></td>
  </tr>
</table>
<br/>";

if ($user->admin){
print("<hr>");
print("<table bgcolor=#FFFFFF align=center width=80% border=1>");
print("<tr>");
print("<td class=\"rowhead2\"><center>Settings</center></td>");
print("</tr>");
print("</table>");
print("<br/>");
print("<table bgcolor=#FFFFFF align=center width=80% border=1>");
print("<tr><td align=center><a href=casino_player.php>Casino Players Edit</a></td>");
print("<td align=center><a href=admin.php?op=lottery_config>Lottery Configurations</a></td>");
print("<td align=center><a href=admin.php?op=casino_config>Casino Configurations</a></td>");
print("<td align=center>&nbsp;</td></tr>");
print("</tr></table>");
print("<br/>");
}

echo "</td></tr></table>";

CloseTable();
include("footer.php");
?>