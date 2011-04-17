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
$id = $_POST["offerid"];
$res = $db->sql_query("SELECT userid, name from ".$db_prefix."_offers where id=$id");
$row = $db->sql_fetchrow($res);
if ($user->id != $row["userid"] &&  !$user->admin )
{
  OpenErrTable(_btsorry);
  echo _btnoautherized_delete_off;
  CloseErrTable();
  die();
}
else {
$db->sql_query("DELETE FROM ".$db_prefix."_offers WHERE id=$id");
$db->sql_query("DELETE FROM ".$db_prefix."_offervotes WHERE offerid=$id");
$db->sql_query("DELETE FROM ".$db_prefix."_comments WHERE offer=$id AND torrent=0");
if (getuserid($btuser) != $row["userid"]){
$msg = str_replace("**name**",$row['name'],_btofferdeleted);
$userid = $row["userid"];
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('" . $user->id . "', '" . $userid . "', '"._btoffer."', '$msg', NOW())") ;
}

header("Refresh: 0; url=offers.php");
}
?>
