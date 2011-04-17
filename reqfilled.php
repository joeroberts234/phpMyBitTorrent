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
include("header.php");
global $db, $db_prefix;
OpenTable("Request Filled");

$filledurl = $_GET["filledurl"];
$requestid = (int)$_GET["requestid"];


$res = $db->sql_query("SELECT ".$db_prefix."_users.username, ".$db_prefix."_requests.userid, ".$db_prefix."_requests.request FROM ".$db_prefix."_requests inner join ".$db_prefix."_users on ".$db_prefix."_requests.userid = ".$db_prefix."_users.id where ".$db_prefix."_requests.id = $requestid") or sqlerr();
 $arr = $db->sql_fetchrow($res);

$res2 = $db->sql_query("SELECT username FROM ".$db_prefix."_users where id ='".$user->id."'") or sqlerr();
 $arr2 = $db->sql_fetchrow($res2);


$msg = "Your request, <a href=" . $siteurl . "/reqdetails.php?id=" . $requestid . "><b>" . $arr[request] . "</b></a>, has been filled by <a href=" . $siteurl . "/user.php?op=profile&id=".$user->id."><b>" . $arr2[username] . "</b></a>. You can download your request from <a href=" . $filledurl. "><b>" . $filledurl. "</b></a>.  Please do not forget to leave thanks where due.  If for some reason this is not what you requested, please reset your request so someone else can fill it by following <a href=" . $siteurl . "/reqreset.php?requestid=" . $requestid . ">this</a> link.  Do <b>NOT</b> follow this link unless you are sure that this does not match your request.";

       $db->sql_query ("UPDATE ".$db_prefix."_requests SET filled = '$filledurl', filledby = '".$user->id."' WHERE id = $requestid") or sqlerr();
                $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$user->id."','" . $arr[userid] . "','Request','".addslashes($msg)."',NOW())");
                        $bon = "SELECT active, fill_request  FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $fill_request_point) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
						if($active=='true')
						{
						$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$fill_request_point."' WHERE id= ".$user->id."" ;
                        $db->sql_query($do) or btsqlerror($do);
						}


print("<br><BR><div align=left>Request $requestid successfully filled with <a href=$filledurl>$filledurl</a>.  User <a href=user.php?op=profile&id=$arr[userid]><b>$arr[username]</b></a> automatically PMd.  <br>
Filled that accidently? No worries, <a href=reqreset.php?requestid=$requestid>CLICK HERE</a> to mark the request as unfilled.  Do <b>NOT</b> follow this link unless you are sure there is a problem.<br><BR></div>");
print("<BR><BR>Thank you for filling a request :)<br><br><a href=viewrequests.php>View More Requests</a>");
CloseTable();

include("footer.php");
?>