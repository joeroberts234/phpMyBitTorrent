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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (!eregi("mybonus.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
include("header.php");
global $user, $db, $db_prefix;
                        $bon = "SELECT active, upload, comment, offer, fill_request, seeding, by_torrent FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $upload, $comment, $offer, $fill_request, $seeding, $by_torrent) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if($by_torrent == 1) $by_torrent = " (each torrent) ";
else
$by_torrent = " (total) ";
$bonus = $user->seedbonus;
$userid = "".getuserid($btuser)."";
OpenTable(_btbonus_exchange);
if($active =='false'){
OpenMessTable(_btbonus_exchange_closed);
echo _btbonus_exchange_closed_msg;
CloseMessTable();
CloseTable();
die();
}
print("<table align=center width=600 border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
Print("<tr><td class=tabletitle width=600>"._btbonus_."</td></tr></table>");
print("<table class=tableb align=center width=600 border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
echo _btbonus_what_is;
print("<table border=1 cellspacing=0 cellpadding=5 width=500><tr>".
"<td class=tabletitle align=left>"._btbonus_option."</td>".
"<td class=tabletitle align=left>"._btbonus_wb."</td>".
"<td class=tabletitle align=left>"._btblj_points."</td>".
"<td class=tabletitle align=left>"._btbonus_t."</td>".

"</tr>");

$sql = ("SELECT * FROM ".$db_prefix."_bonus order by id");
$res = $db->sql_query($sql);
while ($gets = $db->sql_fetchrow($res))
{
print("<tr class=tableb><td>".$gets["id"]."</td><td align='left'><b>".$gets["bonusname"]."</b><br>".$gets["description"]."</td><td align='right'>".$gets["points"]."</td>");
print("<form action=mybonus.php?action=exchange method=post>\n");
print("<input type=\"hidden\" name=\"bonus\" value=\"".$bonus."\">\n");
print("<input type=\"hidden\" name=\"userid\" value=\"".$userid."\">\n");
print("<input type=\"hidden\" name=\"points\" value=\"".$gets["points"]."\">\n");
print("<input type=\"hidden\" name=\"option\" value=\"".$gets["id"]."\">\n");
print("<input type=\"hidden\" name=\"art\" value=\"".$gets["art"]."\">\n");
if($user->seedbonus >= $gets["points"]) {
    print("<td><input type=submit name=submit value=\""._btbonus_exchange_now."\"></td></form>");
    } else {
    print("<td><input type=submit name=submit value=\""._btdisabled."\" disabled></td></form>");
    }
}
print("</table><br><br><br>");
echo "<blockquote><p align=left><b>"._btbonus_how_get."</b><br>";
if($seeding > 0)echo str_replace(array("{1}","{2}"),array($seeding,$by_torrent),_btbonus_how1);
if($upload > 0)echo str_replace("{1}",$upload,_btbonus_how2);
if($comment > 0)echo str_replace("{1}",$comment,_btbonus_how3);
if($offer > 0)echo str_replace("{1}",$offer,_btbonus_how4);
if($fill_request > 0)echo str_replace("{1}",$fill_request,_btbonus_how5);
echo "</p></blockquote>";
echo "</td></tr>";
echo "<tr><td><a href=user.php?op=profile&id=$userid>"._btbonus_btp."</a></td></tr>";
echo "</table>";
if ($action == "exchange") {
global $seedbonus, $invites;
$userid = $_POST["userid"];
$option = $_POST["option"];
$points = $_POST["points"];
$bonus = $_POST["bonus"];

$seedbonus2=$user->seedbonus-$points;

$art = $_POST["art"];
$modcomment = addslashes($user->modcomment);
$upload = $user->uploaded;
$bpoints = $user->seedbonus;
$sql = ("SELECT * FROM ".$db_prefix."_bonus WHERE id='$option'");
$res = $db->sql_query($sql);
$bytes = $db->sql_fetchrow($res);
$up = $user->uploaded+$bytes['menge'];
$invites = $user->invites;
$inv = $invites+$bytes['menge'];
if($user->seedbonus >= $points) {

    if($art == "traffic") {
          $modcomment = gmdate("Y-m-d") . str_replace(array("{1}","{2}"),array($points,$bytes['menge']),_btbonus_adm_msg1).$modcomment;
           $trupl ="UPDATE ".$db_prefix."_users SET uploaded = '".$up."', seedbonus = '$seedbonus2', modcomment = '$modcomment' WHERE id = '$userid'";
		  $db->sql_query($trupl)or sqlerr($trupl);
		  OpenSuccTable(_btsnatch);
		  echo str_replace("{1}",$points,_btbonus_sucs_trafic);
		  CloseSuccTable();
	} elseif($art == "invite") {
         $modcomment = gmdate("Y-m-d") . str_replace("{1}",$points,_btbonus_adm_msg2).$modcomment;
         $complete = $db->sql_query("UPDATE ".$db_prefix."_users SET invites = '".$inv."', seedbonus = '$seedbonus2', modcomment = '$modcomment' WHERE id = '$userid'") or sqlerr(__FILE__, __LINE__);
		 OpenSuccTable(_btsnatch);
		 echo str_replace("{1}",$points,_btbonus_sucs_invite);
		 CloseSuccTable();
    }
        else {
        echo _btbonus_no_type;
    }

} else {
      echo _btbonus_notenouph;
      }
}

CloseTable();
include("footer.php");
?>