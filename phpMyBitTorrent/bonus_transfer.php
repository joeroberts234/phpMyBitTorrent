<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*----------         Developed By Emad Hossam (aka emadness)          ----------*
*-------------               http://www.fulldls.com               -------------*
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
*------------------------ Mod By Nightcrawler ---------------------------------*
*------------------------------------------------------------------------------*
*/
include("header.php");
OpenTable("Bonus Transfer");
if(!isset($userid))$userid = '';
echo"<form name=transfer method=post action=bonus_transfered.php>\n";
echo"<table width=100% align=center>\n";
echo"<tr>\n";
echo"<td class=header width=50% colspan=5><b>You can transfer your seed bonus points to another member here</b>\n";
echo"</td>\n";
echo"<tr>\n";
echo"<input type=hidden name=iduser value=".$user->id.">\n";
echo"<td class=header>User: <input type=text name=username size=30 value=$userid></td>\n";
echo"</tr>\n";
echo"<tr>\n";
echo"<td class=header width=100%><div style=\"float:center;\"><textarea name=why id=why cols=60 rows=5></textarea></center></td></tr><tr>\n";
echo"<td class=header>How much points to give: <input type=text name=bonus size=6 value=1>\n";
echo"</td>\n";
echo"</tr>\n";
echo"<tr>\n";
echo"<td class=header>Use anonymous for sender ID: \n";
echo"<input type=checkbox name=anonym value=anonym></td></tr>\n";
echo"<tr><td colspan=2><center><input name=submit type=submit value=Transfer></center></td>\n";
echo"</tr>\n";
echo"</table>\n";
echo"</form>";
CloseTable();
?>