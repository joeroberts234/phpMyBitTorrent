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

OpenTable("Tickets");
$mid = "".getuserid($btuser)."";
$msid = "".getusername($btuser)."";
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_lottery_config") or die(mysql_error());
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];

$endday = $arr_config['end_date'];

if (!$arr_config["enable"])
stderr("Sorry", "Lottery is disabled.");
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}




$ticket_amount_display = $arr_config['ticket_amount'];

if ($arr_config["ticket_amount_type"] == GB)
$arr_config['ticket_amount'] = 1024 * 1024 * 1024 * $arr_config['ticket_amount'];
else if ($arr_config["ticket_amount_type"] == MB)
$arr_config['ticket_amount'] = 1024 * 1024 * $arr_config['ticket_amount'];
$size = $arr_config['ticket_amount'];

$minupload = $size; //Minimum Upload Required to Buy Ticket!

OpenTable("Tickets Page");
OpenTable2("Lottery Tickets Purchased");

if (gmdate("Y-m-d H:i:s", time()) > $arr_config['end_date'])
{
print ("Sorry I cannot sell you any tickets!");
die();
}

$res = $db->sql_query("SELECT downloaded, uploaded FROM ".$db_prefix."_users WHERE id = ".getuserid($btuser)."");
$result = $db->sql_fetchrow($res);

$res2 = $db->sql_query("SELECT COUNT(id) AS tickets FROM ".$db_prefix."_tickets WHERE user = ".getuserid($btuser)."") or die(mysql_error());
$result2 = $db->sql_fetchrow($res2);

$purchaseable = $arr_config['user_tickets'];
if (($result2['tickets'] + $_REQUEST['number']) > $purchaseable || $_REQUEST['number'] < 1 )
{
print("<table class=frame width=737 cellspacing=0 cellpadding=5><tr><td><table class=main width=100% cellspacing=0 cellpadding=5><tr><td class=colhead align=left>ERROR</td></tr><tr><td>The max number of tickets you can purchase is $purchaseable<br></td></tr></table></td></tr></table>");
CloseTable();
die;
}

if (($minupload * $_REQUEST['number']) > $result["uploaded"] )
{
print("<table class=frame width=737 cellspacing=0 cellpadding=5><tr><td><table class=main width=100% cellspacing=0 cellpadding=5><tr><td class=colhead align=left>ERROR</td></tr><tr><td>You do not have enough upload amount to buy a ticket<br></td></tr></table></td></tr></table>");
CloseTable();
die;
}
$upload = $result["uploaded"] - $arr_config['ticket_amount'];
$db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = $upload WHERE id= ".getuserid($btuser)."") or die(mysql_error());
$tickets = $_REQUEST['number'];
for ($i = 0; $i < $tickets; $i++)
$db->sql_query("INSERT INTO ".$db_prefix."_tickets(user) VALUES (".getuserid($btuser).")");
$me = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets WHERE user=".getuserid($btuser).""));
print("<br>\n");

?>
<table border=1 width=600 cellspacing=0 cellpadding=5>
<tr><td class=tabletitle width=600 align=center>Lottery</td></tr>
<tr><td class=tableb align=left>
You just purchased <?php echo  $_REQUEST["number"]; ?> ticket<?php if ($_REQUEST["number"] > 1) echo "s"; ?>!<br>
Your new total is <?php echo $me; ?>!<br>
Your new upload total is <?php echo mksize($upload); ?>!<br><br>
<a href=tickets.php>Go Back</a>
</td></tr></table>

<?php
print("<br>\n");
CloseTable();
include("footer.php");

?>

