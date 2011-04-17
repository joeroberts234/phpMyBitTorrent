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
include ("header.php");
global $db, $db_prefix;
if(!checkaccess("requests")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**","Requests",_btnoautherized)."</p>\n";
CloseErrTable();
die();
}
$requestid = (int)$_GET["id"];
if(!is_numeric($requestid)){
OpenErrTable(_bterror);
echo "<p>"._bt_not_valid_num."</p>\n";
CloseErrTable();
die();
}

OpenTable(_btrequestvote);
$res_offer = "SELECT * FROM ".$db_prefix."_addedrequests WHERE requestid=$requestid and userid = '".$user->id."';";
$res = $db->sql_query($res_offer);
$arr = $db->sql_fetchrow($res);
$db->sql_freeresult($res_offer);
$voted = $arr;

if ($voted) {
echo _btrequestvoted;
}else {
$db->sql_query("UPDATE ".$db_prefix."_requests SET hits = hits + 1 WHERE id=$requestid;");
$db->sql_query("INSERT INTO ".$db_prefix."_addedrequests VALUES(0, $requestid, '".$user->id."');");

echo _btrequestvotetaken;

}

CloseTable();

include ("footer.php")
?>