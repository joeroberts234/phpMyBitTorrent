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

function stderr($heading = "", $text, $sort = "") {
 
  OpenTable2("<font color=red>$sort: $heading</font>", center);
  echo $text;
  CloseTable2();
 
  die;
}

if (!$user->user) loginrequired("user");

OpenTable("Tickets Sold");
OpenTable2("Purchased Lottery Tickets");
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_lottery_config") or die(mysql_error());
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];

$endday = $arr_config['end_date'];

if (!$arr_config["enable"])
stderr("Sorry", "Lottery is disabled.");
OpenTable("Tickets Sold");

print("Lottery Ends: <b>" . $endday . "</b><br /><br />");

?>
<table border="1" width="600" cellpadding="5">
<tr>
<td class="tabletitle">#</td>
<td class="tabletitle">Username</td>
<td class="tabletitle">Number of tickets</td>
<td class="tabletitle">Uploaded</td>
<td class="tabletitle">Downloaded</td>
<td class="tabletitle">Ratio</td>
</tr>
<?php

$result = $db->sql_query( "SELECT DISTINCT user FROM ".$db_prefix."_tickets" ) 
or die("SELECT Error: ".mysql_error()); 
$num_rows = $db->sql_numrows($result); 
 
while ($get_info = $db->sql_fetchrow($result )){

foreach ($get_info as $field) 
$tickets = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets WHERE user=$field"));
$tickets1 = end($db->sql_fetchrow($db->sql_query("SELECT id FROM ".$db_prefix."_tickets WHERE user=$field")));
$username = end($db->sql_fetchrow($db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$field")));
$id = end($db->sql_fetchrow($db->sql_query("SELECT id FROM ".$db_prefix."_users WHERE id=$field")));
$uploaded = mksize(end($db->sql_fetchrow($db->sql_query("SELECT uploaded FROM ".$db_prefix."_users WHERE id=$field"))));
$downloaded = mksize(end($db->sql_fetchrow($db->sql_query("SELECT downloaded FROM ".$db_prefix."_users WHERE id=$field"))));
$ratio = end($db->sql_fetchrow($db->sql_query("SELECT downloaded FROM ".$db_prefix."_users WHERE id=$field")));
$ratio2 = end($db->sql_fetchrow($db->sql_query("SELECT uploaded FROM ".$db_prefix."_users WHERE id=$field")));
if($ratio == 0)$ratio3 = "&infin;";
else
$ratio3 = number_format($ratio2 / $ratio, 3);
echo "<tr><td class=tableb>".$tickets1." </td><td class=tableb><a href=user.php?op=profile&id=$id>$username</a></td><td class=tableb>$tickets</td><td class=tableb>$uploaded</td><td class=tableb>$downloaded</td><td class=tableb>" . $ratio3 . "</td></tr>";
}
?>
</table>
<?php
CloseTable();


include("footer.php");

?>