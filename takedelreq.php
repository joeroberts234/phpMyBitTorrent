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
include ("header.php");
function checkRequestOwnership ($user, $delete_req){
        global $db, $db_prefix;
$query = $db->sql_query("SELECT * FROM ".$db_prefix."_requests WHERE userid=$user AND id = $delete_req") or sqlerr();
$num = mysql_num_rows($query);
if ($num > 0)
return(true);
else
return(false);
}
OpenTable(_btrdelequest_table);
global $db, $db_prefix, $user;
if ($user->moderator){
if (empty($_POST["delreq"])){
print("<CENTER>"._btdelrequest_select_delete."</CENTER>");
die;
}
$do="DELETE FROM ".$db_prefix."_requests WHERE id IN (" . implode(", ", $_POST[delreq]) . ")";
$do2="DELETE FROM ".$db_prefix."_addedrequests WHERE requestid IN (" . implode(", ", $_POST[delreq]) . ")";
$res2=$db->sql_query($do2);
$res=$db->sql_query($do);
print("<CENTER>"._btrdelequest_dodel."</CENTER>");

echo "<BR><BR>";
} else {
foreach ($_POST[delreq] as $del_req){
$delete_ok = checkRequestOwnership($user->id,$del_req);
if ($delete_ok OR checkaccess("can_edit_others_torrents")){
$do="DELETE FROM ".$db_prefix."_requests WHERE id IN ($del_req)";
$do2="DELETE FROM ".$db_prefix."_addedrequests WHERE requestid IN ($del_req)";
$res2=$db->sql_query($do2);
$res=$db->sql_query($do);
print("<CENTER>"._btrdelequest_id."$del_req "._btdelrequest_deleted."</CENTER>");
} else {
print("<CENTER>"._btrdelequest_noperms."$del_req</CENTER>");
}
}
}

CloseTable();
header("Refresh: 0; url=viewrequests.php");
include ("footer.php");
?>