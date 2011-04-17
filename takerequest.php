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
global $db, $db_prefix;
$requestartist = $_POST["requestartist"];
$requesttitle = $_POST["requesttitle"];
$request = $requesttitle;
if (!$cat) $errmsg[] = _btillegalcat;
if (count($errmsg) > 0)
        bterror($errmsg,_btupload);

if (!get_magic_quotes_gpc()) $msg = escape($msg);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $msg)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
$cat = (isset($cat)) ? intval($cat) : 0;

//$request = sqlesc($request);
$timestamp=time();    

$db->sql_query("INSERT INTO ".$db_prefix."_requests (hits,userid, cat, request, descr, added) VALUES(1, '".$user->id."', '".$cat."', '" . $request . "', '".$msg."',  NOW())")or die(mysql_error());


$id = $db->sql_nextid();

@$db->sql_query("INSERT INTO ".$db_prefix."_addedrequests VALUES(0, $id, '".$user->id."')")or print(mysql_error());

$db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('".$user->id."', ' has made a request for $requesttitle', NOW())")or print(mysql_error());




header("Refresh: 0; url=viewrequests.php");
include("footer.php");
?>