<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
include("header.php");
global $db, $db_prefix;

$result = $db->sql_query("select * from ".$db_prefix."_casino where userid = '".$player."'") or die(mysql_error());
if ($db->sql_numrows($result) == 0)
bterror(str_replace("**id**",$player,_btcs_edit_noplr),_btsorry);
else
{
$row = $db->sql_fetchrow($result);
 $user_win = $row["win"];
 $user_lost = $row["lost"];
 $user_trys = $row["trys"];
 $user_date = $row["date"];
 $user_enableplay = $row["enableplay"];
$sql = ("SELECT * FROM ".$db_prefix."_users WHERE id = '".$player."'");
$arr=$db->sql_query($sql);
$arr1=$db->sql_fetchrow($arr);
$username=$arr1['username'];

if($_POST["player"]!=NULL&&$_POST["won"]!=NULL&&$_POST["lost"]!=NULL&&$_POST["trys"]!=NULL&&$_POST["date"]!=NULL&&$_POST["enableplay"]!=NULL)
{
 $dif_win = $won - $user_win;   ///// this is tricky
 $dif_lost = $lost - $user_lost; ///// this is tricky
 $up = $dif_win - $dif_lost;   ///// this is tricky
 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + ".$up." WHERE id=".$player) or sqlerr();
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".$date."', trys = ".$trys." ,lost = ".$lost.",win = ".$won.",enableplay= '".$enableplay."' WHERE userid=".$player) or sqlerr();

 bterror("<p>".str_replace("**id**",$player,_btcs_edit_stupdt)."</p><a href=casino_player.php>"._btcs_edit_bktl."</a>",_btcs_edit_pledok);
}
else
{
  if ($user_win > 0)
    $casino_ratio_user = number_format($user_lost / $user_win, 2);
  else
    if ($user_lost > 0)
      $casino_ratio_user = 999;
    else
      $casino_ratio_user = 0;
     
  if($user_enableplay=="yes")
  {
   $select="<option value=yes checked >"._btyes."</option>";
   $select.="<option value=no>"._btno."</option>";
  }
  else
  {
   $select="<option value=yes >"._btyes."</option>";
   $select.="<option value=no checked>"._btno."</option>";
  }

 OpenTable("Edit Player");
 print("<b>"._btcs_edit_yaediting.": <a href=user.php?op=profile&id=$player>$username</a></b>\n");
 print("<p align=center><a href=casino_player.php>"._btcs_edit_bktl."</a><br><br><a href=casino.php>"._btcs_edit_bktc."</a></p>\n");
 print("<form name=edit-player method=post action=$phpself><input type=hidden name=player value=$player>");
 print("<table  cellspacing=0 cellpadding=3 width=400>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btratio.":</td><td valign=\"top\" align=left>$casino_ratio_user</td></tr>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btcs_edit_wing.":</td><td valign=\"top\" align=left><input type=text name=won value='$user_win' >&nbsp;&nbsp;".mksize($user_win)."</td></tr>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btcs_edit_lost.":</td><td valign=\"top\" align=left><input type=text name=lost value='$user_lost' >&nbsp;&nbsp;".mksize($user_lost)."</td></tr>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btcs_edit_pls."</td><td valign=\"top\" align=left><input type=text name=trys value='$user_trys' >&nbsp;&nbsp;</td></tr>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btcs_edit_laac.":</td><td valign=\"top\" align=left><input type=text name=date value='$user_date' ></td></tr>\n");
 print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">"._btcs_edit_alow.":</td><td valign=\"top\" align=left><select name=\"enableplay\">'.$select.'</select> </td></tr>\n");
 print("<tr><td colspan=2 align=center><input type=submit value='"._btrefresh."'></td></tr>");
 print("</table>\n");
 print("</form>");
}
}
CloseTable();
include ("footer.php");
?>
