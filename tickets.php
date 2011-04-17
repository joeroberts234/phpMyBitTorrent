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
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_lottery_config") or die(mysql_error());
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];

if (!$arr_config["enable"])
stderr(_btsorry, _btlottery_disabled);
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




if (!$user->user) loginrequired("user");

$ticket_amount_display = $arr_config['ticket_amount'];

if ($arr_config["ticket_amount_type"] == GB)
$arr_config['ticket_amount'] = 1024 * 1024 * 1024 * $arr_config['ticket_amount'];
else if ($arr_config["ticket_amount_type"] == MB)
$arr_config['ticket_amount'] = 1024 * 1024 * $arr_config['ticket_amount'];
$size = $arr_config['ticket_amount'];

if ($arr_config["ticket_amount_type"] == GB)
$arr_config['prize_fund'] = 1024 * 1024 * 1024 * $arr_config['prize_fund'];
else if ($arr_config["ticket_amount_type"] == MB)
$arr_config['prize_fund'] = 1024 * 1024 * $arr_config['prize_fund'];
$prize_fund = $arr_config['prize_fund'];

$ratioerr = "<font color=\"red\"><b>"._btlottery_uploaded." $arr_config[ticket_amount] $arr_config[ticket_amount_type] "._btlottery_buy."</b></font>";

OpenTable(_btlottery_page);
Opentable2(_btlottery_purchase, center);
$total = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets"));
if ($arr_config["use_prize_fund"] = 0)
$pot = $prize_fund;
else
$pot = $total * $size;
$me = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets WHERE user=".getuserid($btuser).""));
$me2 = $db->sql_query("SELECT * FROM ".$db_prefix."_tickets WHERE user=".getuserid($btuser)." ORDER BY id ASC");
while ($myrow = $db->sql_fetchrow($me2))
$ticketnumbers .= "$myrow[id] ";

$purchaseable = $arr_config['user_tickets'] - $me;

if ($me >= $arr_config["user_tickets"])
$purchaseable = 0;

if (gmdate("Y-m-d H:i:s", time()) > $arr_config['end_date'])
$purchaseable = 0;

print("<br>\n");

?>


<table border=1 width=600 cellspacing=0 cellpadding=5>
<tr><td class=tabletitle width=600 align=center>MGA Lottery</td></tr>
<tr><td align=left class=tableb>
<ul>
<li><?=_btlottery_nonrefund?></li>
<li><?=_btlottery_cost?><?php echo $ticket_amount_display . ' ' . $arr_config['ticket_amount_type']; ?><?=_btlottery_taken?></li>
<li><?=_btlottery_purchaseable?></li>
<li><?=_btlottery_amount?></li>
<li><?=_btlottery_compend?><?php echo $arr_config["end_date"]; ?></li>
<li><?=_btlottery_willbe?><?php echo $arr_config['total_winners']; ?><?=_btlottery_winners?></li>
<li><?=_btlottery_eachwinner?><?php echo mksize($pot/$arr_config['total_winners']); ?><?=_btlottery_added?></li>
<li><?=_btlottery_announced?></li>
<?php
if (!$arr_config["use_prize_fund"])
{
?>
<li><?=_btlottery_pot?></li>
<?php
}
?>
<li><?=_btlottery_own?><?= $ticketnumbers; ?></li>
</ul>
<?=_btlottery_goodluck?>
<hr>
<table align=center width=40% class=frame border=1 cellspacing=0 cellpadding=10><tr><td align=center>
<table width=100% class=tableb class=main border=1 cellspacing=0 cellpadding=5>
<tr>
<td class=tableb><?=_btlottery_totalpot?></td>
<td class=tableb><?php echo mksize($pot); ?></td>
</tr>
<tr>
<td class=tableb><?=_btlottery_totalpurchased?></td>
<td class=tableb align=right><?php echo $total; ?> <?=_btlottery_allowed_tickets?> </td>
</tr>
<tr>
<td class=tableb><?=_btlottery_owned?></td>
<td class=tableb align=right><?php echo $me; ?> <?=_btlottery_allowed_tickets?> </td>

</tr>
<tr>
<td class=tableb><?=_btlottery_allowed?></td>
<td class=tableb align=right><?php echo $purchaseable; ?><?=_btlottery_allowed_tickets?></td>
</tr>
</table>
</table>
<hr>
<?php
if ($purchaseable > 0)
{
?>
<center>
<form method="post" action="purchasetickets.php">
<?=_btlottery_purchase1?> <input type="text" name="number"><?=_btlottery_tickets?><input type="submit" value="<?=_btlottery_purchase1?>">
</form>
</center>
<?php
}
else if (gmdate("Y-m-d H:i:s", time()) > $arr_config['end_date'])
{
?>
<center><h1><font color = "red"><?=_btlottery_closed?></font></h1>
<?php
}
?>
</td></tr></table>

<?php print("<br>\n");
CloseTable2();
CloseTable();
include("footer.php");
die;

?>