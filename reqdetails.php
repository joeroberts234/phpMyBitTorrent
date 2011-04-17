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


OpenTable("REQUEST DETAILS ");
$id = $_GET["id"];
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_requests WHERE id = $id") or sqlerr();
$num = $db->sql_fetchrow($res);

$s = $num["request"];

OpenTable2("$s");
print("<div align=center>");
print("<h1>Request: $num[request]</h1>\n");
print("<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
print("<tr><td align=left><b>Request:</b></td><td width=90% align=left >$num[request]</td></tr>");
if ($num["descr"])
?><tr><td align=left>Description</td><td width=90% align=left colspan=2><?php echo str_replace("\n","<br>",$num["descr"])?></td></tr><?php
print("<tr><td align=left><b>Date Requisted</b></td><td width=90% align=left >$num[added]</td></tr>");
$cres = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id='$num[userid]'")or die(mysql_error());
if ($db->sql_numrows($cres) == 1)
{
  $carr = $db->sql_fetchrow($cres);
  $username = "$carr[username]";
}
$url = "offedit.php?id=$id";
if (isset($_GET["returnto"])) {
$addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
$url .= $addthis;
$keepget .= $addthis;
}
$editlink = "a href=\"$url\" class=\"sublink\"";
print("<tr><td align=left><b>Requisted By</b></td><td width=90% align=left >$username");
if ($user->id != $num["userid"] && ($user->admin)) {
print(" ");}
else{
print("");}
print("</td></tr>");
if ($user->id != $num["userid"])
{
print("<tr><td align=left>Vote</td><td width=50% align=left ><b><a href=addrequest.php?id=$id>Vote</a></b></td></tr>");
}
print("<tr><td align=left><b> REQUEST: </b></td><td width=70% align=left>$num[request]</td></tr>");
if ($num["descr"])
print("<tr><td align=left><B> COMMENTS: </B></td><td width=70% align=left>$num[descr]</td></tr>");
print("<tr><td align=left><B> DATE_ADDED: </B></td><td width=70% align=left>$num[added]</td></tr>");

$cres = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$num[userid]");
   if ($db->sql_numrows($cres) == 1)
   {
     $carr = $db->sql_fetchrow($cres);
     $username = "$carr[username]";
   }
print("<tr><td align=left><B> ADDED_BY : </B></td><td width=70% align=left>$username</td></tr>");


if ($num["filled"] == NULL)
{
print("<form method=get action=reqfilled.php>");
print("<tr><td align=left><B>To Fill This Request:</B> </td><td>Enter the <b>full</b> direct URL of the torrent i.e. http://www.mysite.com/torrents-details.php?id=134 (just copy/paste from another window/tab) or modify the existing URL to have the correct ID number</td></tr>");
print("</table>");

print("<input type=text size=80 name=filledurl value=TYPE-DIRECT-URL-HERE>\n");
print("<input type=hidden value=$id name=requestid>");
print("<input type=submit value=Fill Request >\n</form>");
}
if ($num["filled"] != NULL)print("</table>");

//echo'</div>';
print("<p><hr></p><form method=get action=requests.php#add>OR <input type=submit value=\"Add A New Request\"></form>");
echo'</div>';

CloseTable();

include ("footer.php")

?>