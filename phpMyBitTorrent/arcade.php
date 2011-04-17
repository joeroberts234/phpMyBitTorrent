<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*/
include("header.php");
if(!checkaccess("arcade")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**",_btarc,_btnoautherized)."</p>\n";
CloseErrTable();
die();
}

OpenTable(_btarc);

//delete this line if you have casino installed
////////////////////NOUVELLE VERIF DES CLASSES/////////////////////////////
$res = "SELECT * FROM ".$db_prefix."_casino_config;";
$res_arcade = $db->sql_query($res);
$arr = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
while ($arr = $db->sql_fetchrow($res_arcade))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])btderr(_btsorry, _btarcadeclosed);
///////////////////////////////////////////////////////////////////
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

echo"<table align=center width=100% border=2 cellspacing=0 cellpadding=10>";
echo"<div align=center>";
echo"<p><h3><b>"._btarc_tittle."</b></h3></p>";
echo"<hr>";
echo"<tr>";
echo"<td align=center><a href=flash.php?gameURI=asteroids.swf&gamename=Asteroids&gameid=1><img src=\"flash/asteroids.gif\"></img><p><b>"._btarc_play_Asteroids."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=breakout.swf&gamename=Breakout&gameid=2><img src=\"flash/breakout.gif\"></img><p><b>"._btarc_play_Breakout."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=hexxagon.swf&gamename=Hexxagon&gameid=3><img src=\"flash/hexxagon.gif\"></img><p><b>"._btarc_play_Hexxagon."</b></p></a></td>";
echo"</tr>";
echo"<tr>";
echo"<td align=center><a href=flash.php?gameURI=DAbuddy_latest.swf&gamename=Buddy><img src=\"flash/Buddy.jpg\"></img><p><b>"._btarc_play_Interactive."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=invaders.swf&gamename=Invaders&gameid=4><img src=\"flash/space.gif\"></img><p><b>"._btarc_play_Invaders."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=moonlander.swf&gamename=Moonlander&gameid=5><img src=\"flash/moonlander.gif\"></img><p><b>"._btarc_play_Moonlander."</b></p></a></td>";
echo"</tr>";
echo"<tr>";
echo"<td align=center><a href=flash.php?gameURI=pacman.swf&gamename=Pac-Man&gameid=6><img src=\"flash/pacman.gif\"></img><p><b>"._btarc_play_Pac_Man."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=psol.swf&gamename=Solitaire&gameid=7><img src=\"flash/psol.gif\"></img><p><b>"._btarc_play_Solitaire."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=simon.swf&gamename=Simon&gameid=8><img src=\"flash/simon.gif\"></img><p><b>"._btarc_play_Simon."</b></p></a></td>";
echo"</tr>";
echo"<tr>";
echo"<td align=center><a href=flash.php?gameURI=snake.swf&gamename=Snake&gameid=9><img src=\"flash/snake.gif\"></img><p><b>"._btarc_play_Snake."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=stanjames.swf&gamename=Freekick><img src=\"flash/stanjames.gif\"></img><p><b>"._btarc_play_Free_kick."</b></p></a></td>";
echo"<td align=center><a href=flash.php?gameURI=tetris.swf&gamename=tetris&gameid=10><img src=\"flash/tetris.gif\"></img><p><b>"._btarc_play_Tetris."</b></p></a></td>";
echo"</tr>";
echo"</form>";
echo"</div>";
echo"</table>";
echo"<p><center><a href=flashscores.php><h3>"._btarc_high."</h3></a></center></p>";
echo"<p><center><a href=flashscores2.php><h3>"._btarc_stats."</h3></a></center></p>";
CloseTable();
include ("footer.php");
?>
