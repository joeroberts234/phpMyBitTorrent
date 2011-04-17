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
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include'header.php';
if(isset($reopen))
{
$db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET `solved` = 'no' WHERE `id` =".$id." LIMIT 1 ;");
header("Refresh: 0; url=./slove.php?a=view&id=".$id);
die();
}
if(isset($delete))
{
$db->sql_query("DELETE FROM `".$db_prefix."_helpdesk` WHERE `id` = ".$id." LIMIT 1");
$db->sql_query("DELETE FROM `".$db_prefix."_help_responce` WHERE `ticket` = ".$id."");
header("Refresh: 0; url=./helpdesk.php");
die();
}
if(isset($change_status)){
$db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET `status` = '".$newstatus."' WHERE `id` =".$id." LIMIT 1 ;");
header("Refresh: 0; url=./slove.php?a=view&id=".$id);
die();
}
$upd_sql ='INSERT INTO `'.$db_prefix.'_help_responce` (`ticket`, `reps`, `responce`, `time`) VALUES (\''.$id.'\', \''.$user->id.'\', \''.addslashes($a_answer).'\', CURRENT_TIMESTAMP);';
$db->sql_query($upd_sql);
$db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET `status` = '".$newstatus."' WHERE `id` =".$id." LIMIT 1 ;");
header("Refresh: 0; url=./slove.php?a=view&id=".$id);
?>