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
include("header.php");
global $db_prefix;
$sql = ("SELECT username FROM ".$db_prefix."_users WHERE clean_username = ''") ;
		$res1 = $db->sql_query($sql) or btsqlerror($sql);
		$arr1 = $db->sql_numrows($res1);

for ($i=0;$i<$arr1;$i++)
{
$arrpmbt = $db->sql_fetchrow($res1);
$oldname = $arrpmbt['username'];
$newname = strtolower($oldname);
//echo  $oldname."=". strtolower($oldname);
$sql =("UPDATE ".$db_prefix."_users SET `clean_username` = '$newname'  WHERE username = '$oldname'") ;
$db->sql_query($sql) or btsqlerror($sql);
echo 'done'.$oldname.$newname.'<br>';
}

include'footer.php';
?>