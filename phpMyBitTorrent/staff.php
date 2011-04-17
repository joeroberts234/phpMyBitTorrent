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
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
global $db_prefix;
$settings['cache']=true;
$settings['cache_staff']=120;		// the cache is updaded every 120 secondes
if (!$act) {
$cache_file = "cache/staff.txt";
$expire = $settings['cache_staff'];
if ($settings['cache'] && file_exists($cache_file) && filemtime($cache_file) > (time() - $expire)) {
  $staff_table = unserialize( file_get_contents($cache_file) );
}
else
{
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 600;
$dt = date("Y-m-d H:i:s", $dt1);
$res = mysql_query("SELECT ".$db_prefix."_users.id,username,lastlogin,can_do,level,helper,help_able,".$db_prefix."_countries.name as country, ".$db_prefix."_countries.flagpic FROM ".$db_prefix."_users LEFT JOIN ".$db_prefix."_countries ON ".$db_prefix."_users.country = ".$db_prefix."_countries.id WHERE `level` IN ('admin', 'moderator', 'premium') AND active='1' ORDER BY username" ) or sqlerr();
 
 while ($arr = mysql_fetch_assoc($res))
 {
   $staff_online = ($arr['lastlogin'] > $dt ?  'online' : 'offline');
   $country = (!empty($arr['flagpic'])) ? '<img src="images/flag/'.$arr['flagpic'].'" width="22" height="15" alt="'.$arr['country'].'" title="'.$arr['country'].'"/>' : '';
   $nb_staff++;
  
   $staff_table[ $arr['can_do'] ] = $staff_table[ $arr['can_do'] ].
   '<td class="embedded"><a class="altlink" href="user.php?op=profile&amp;id='.$arr['id'].'">'.$arr['username'].'</a></td>
    <td class="embedded"><img src="images/'.$staff_online.'.png" border="0" alt="'.$staff_online.'"/></td>
    <td class="embedded"><a href="pm.php?op=send&to='.$arr['id'].'"> <img src=themes/'.$theme.'/pics/pm_write.png border=0> </a></td>
    <td class="embedded">'.$country.'</td>';
   ++ $col[$arr['can_do']];

   if ($col[$arr['can_do']]<=2)
     $staff_table[$arr['can_do']]=$staff_table[$arr['can_do']]."";
   else
   {
     $staff_table[$arr['can_do']]=$staff_table[$arr['can_do']]."</tr><tr height=15>";
     $col[$arr['can_do']]=0;
   }
   
 }
 
 
$fp = fopen($cache_file, 'w');
fwrite($fp, serialize($staff_table));
fclose($fp);
}
?>

<?php OpenTable(_btstaff); ?>
<?=_btstaff_support?><br/>
<br/>
<table width=720 cellspacing=0 align=center  bgcolor="#999999">
<tr>
   <td class="embedded" width="125">&nbsp;</td>
   <td class="embedded" width="25">&nbsp;</td>
   <td class="embedded" width="35">&nbsp;</td>
   <td class="embedded" width="85">&nbsp;</td>
   <td class="embedded" width="125">&nbsp;</td>
   <td class="embedded" width="25">&nbsp;</td>
   <td class="embedded" width="35">&nbsp;</td>
   <td class="embedded" width="85">&nbsp;</td>
   <td class="embedded" width="125">&nbsp;</td>
   <td class="embedded" width="25">&nbsp;</td>
   <td class="embedded" width="35">&nbsp;</td>
   <td class="embedded" width="85">&nbsp;</td>
 </tr>
 <tr valign="middle"><td class="embedded" colspan="12" ><font color="#e801eb"><b><?="General"?></b></color></td></tr>
 <tr><td class="embedded" colspan="12"><hr></td></tr>
 <tr>
<?php if ($staff_table[owner]) echo $staff_table[owner]; else echo"<td></td>"?>
 </tr>
  <tr><td class="embedded" colspan="12">&nbsp;</td></tr>
 <tr><td class="embedded" colspan="12"><font color="purple"><b><?="	Major "?></b></color></td></tr>
 <tr><td class="embedded" colspan="12"><hr></td></tr>
 <tr>
<?php if ($staff_table[admin]) echo $staff_table[admin]; else echo"<td></td>"?>
 </tr>
  <tr><td class="embedded" colspan="12">&nbsp;</td></tr>
 <tr><td class="embedded" colspan="12"><font color="#720101"><b><?="Chief Warrent"?></b></color></td></tr>
 <tr><td class="embedded" colspan="12"><hr></td></tr>
 <tr>
<?php if ($staff_table[Moderator]) echo $staff_table[Moderator]; else echo"<td></td>"?>
 </tr>
  <tr><td class="embedded" colspan="12">&nbsp;</td></tr>
 <tr><td class="embedded" colspan="12"><font color="#F00000"><b><?="Gunnery Sergent"?></b></color></td></tr>
 <tr><td class="embedded" colspan="12"><hr></td></tr>
 <tr>
<?php if ($staff_table[VIP]) echo $staff_table[VIP]; else echo"<td></td>"?>
 </tr>
 <tr><td class="embedded" colspan="12">&nbsp;</td></tr>
 <tr><td class="embedded" colspan="12"><font color="#008000"><b><?="lance corporal"?></b></color></td></tr>
 <tr><td class="embedded" colspan="12"><hr></td></tr>
 <tr>
<?php if ($staff_table[Power_User]) echo $staff_table[Power_User]; else echo"<td></td>"?>
 </tr>

</table>
<?php } CloseTable();
if (!$act) {
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 14700;
$dt = date("Y-m-d H:i:s", $dt1);
// LIST ALL FIRSTLINE SUPPORTERS
// Search User Database for Firstline Support and display in alphabetical order
$res = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE helper='true' AND active='1' ORDER BY username LIMIT 10") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
 $land = mysql_query("SELECT name,flagpic FROM ".$db_prefix."_countries WHERE id=$arr[country]") or sqlerr();
 $arr2 = mysql_fetch_assoc($land);
 $firstline .= "<tr><td class=\"embedded\"><a class=\"altlink\" href=\"user.php?op=profile&id=".$arr['id']."\">".$arr['username']."</a></td>
 <td class=\"embedded\"> <img src=images/o".($arr['lastlogin'] > $dt ? "n" : "ff")."line.png> </td>".
 "<td class=\"embedded\"><a href=\"pm.php?op=send&to=".$arr['id']."\" >"."<img src=themes/".$theme."/pics/pm_write.png border=0></a></td>".
 "<td class=\"embedded\">".(!empty($arr2['flagpic']) ? '<img src="images/flag/'.$arr2['flagpic'].'" width="22" height="15" alt="'.$arr2['country'].'" title="'.$arr2['country'].'"/>' : '')."</td>".
 "<td class=\"embedded\">".$arr['help_able']."</td></tr>\n";
}

OpenTable(_btstaff_fls);
?>

<table class="main" width="725" cellspacing="0">
<tr>
<td class="embedded" colspan="12"><?=_btstaff_general?><br/><br/></td></tr>
<!-- Define table column widths -->
<tr>
 <td class="embedded" width="30"><b><?=_btstaff_username?></b></td>
 <td class="embedded" width="5"><b><?=_btstaff_active?></b></td>
 <td class="embedded" width="5"><b><?=_btstaff_contact?></b></td>
 <td class="embedded" width="85"><b><?=_btstaff_language?></b></td>
 <td class="embedded" width="200"><b><?=_btstaff_supportfor?></b></td>
</tr>


<tr><td class="embedded" colspan="12"><hr size="1"></hr></td></tr>

<?=$firstline?>

</table>
<?php
CloseTable();
}

include("footer.php");
?>