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
if (!is_user($btuser)) loginrequired("user");


function cleanit($array, $index, $maxlength)
 {
   if (isset($array["{$index}"]))
   {
      $input = substr($array["{$index}"], 0, $maxlength);
      $input = mysql_real_escape_string($input);
      return ($input);
   }
   return NULL;
 }
 
$pollid = cleanit($_GET, "id", 2);

 
OpenTable("Polls Overview");

if (!(isset($_GET['id']))) {
 
$sql = $db->sql_query("SELECT id, added, question FROM ".$db_prefix."_polls ORDER BY id DESC") or sqlerr();

print("<h1>Polls Overview</h1>\n");

print("<p><table width=750 border=1 cellspacing=0 cellpadding=5><tr>\n" .
"<td class=colhead align=center>ID</td><td class=colhead>Added</td><td class=colhead>Question</td></tr>\n");

if ($db->sql_numrows($sql) == 0) {
 print("<tr><td colspan=2>Sorry...There are no users that voted!</td></tr></table>");
 stdfoot();
 exit;
 }
 
while ($poll = $db->sql_fetchrow($sql))
{
 $added = gmdate("Y-m-d h-i-s",strtotime($poll['added'])) . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($poll["added"]))) . " ago)";
 print("<tr><td align=center><a href=\"polloverview.php?id={$poll['id']}\">{$poll['id']}</a></td><td>{$added}</td><td><a href=\"polloverview.php?id={$poll['id']}\">{$poll['question']}</a></td></tr>\n");
 
}

print("</table>\n");

} else {

if (isset($_GET['id'])) {
 
$sql = $db->sql_query("SELECT * FROM ".$db_prefix."_polls WHERE id = {$pollid} ORDER BY id DESC") or sqlerr();



print("<h1>Polls Overview</h1>\n");

print("<p><table width=750 border=1 cellspacing=0 cellpadding=5><tr>\n" .
"<td class=colhead align=center>ID</td><td class=colhead>Added</td><td class=colhead>Question</td></tr>\n");

if ($db->sql_numrows($sql) == 0) {
 print("<tr><td colspan=2>Sorry...There are no polls with that ID!</td></tr></table>");
 stdfoot();
 exit;
 }
 
while ($poll = $db->sql_fetchrow($sql))
{
 $o = array($poll["option0"], $poll["option1"], $poll["option2"], $poll["option3"], $poll["option4"],
  $poll["option5"], $poll["option6"], $poll["option7"], $poll["option8"], $poll["option9"],
  $poll["option10"], $poll["option11"], $poll["option12"], $poll["option13"], $poll["option14"],
  $poll["option15"], $poll["option16"], $poll["option17"], $poll["option18"], $poll["option19"]);
 
 $added = gmdate("Y-m-d h-i-s",strtotime($poll['added'])) . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($poll["added"]))) . " ago)";
 print("<tr><td align=center><a href=\"polloverview.php?id={$poll['id']}\">{$poll['id']}</a></td><td>{$added}</td><td><a href=\"polloverview.php?id={$poll['id']}\">{$poll['question']}</a></td></tr>\n");
 
}

print("</table><br>\n");

print("<h1>Poll Questions</h1><br>\n");
print("<table width=750 border=1 cellspacing=0 cellpadding=5><tr><td class=colhead>Option No</td><td class=colhead>Questions</td></tr>\n");
foreach($o as $key=>$value) {
 if($value != "")
 print("<tr><td>{$key}</td><td>{$value}</td></tr>\n");
 }
print("</table>\n");

$sql2 = $db->sql_query("SELECT ".$db_prefix."_pollanswers. * , ".$db_prefix."_users.username FROM ".$db_prefix."_pollanswers LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_users.id = ".$db_prefix."_pollanswers.userid WHERE pollid = {$pollid} AND selection < 20 ORDER  BY ".$db_prefix."_pollanswers.selection DESC ") or sqlerr();

print("<h1>Polls User Overview</h1>\n");

print("<p><table width=750 border=1 cellspacing=0 cellpadding=5><tr>\n" .
"<td class=colhead align=center>UserID</td><td class=colhead>Selection</td></tr>\n");

if ($db->sql_numrows($sql2) == 0) {
 print("<tr><td colspan=2>Sorry...There are no users that voted!</td></tr></table>");
 stdfoot();
 exit;
 }
 
while ($useras = $db->sql_fetchrow($sql2))
{
 $username  = ($useras['username'] ? $useras['username'] : "Unknown");
 print("<tr><td><a class=altlink href=user.php?op=profile&username=$username><b>$username</b></a></td><td>{$o[$useras['selection']]}</td></tr>\n");
}
print("</table>\n");
print("[<a class=altlink href=polloverview.php><b>Back</b></a>]\n");
}
}



CloseTable();
include("footer.php");
?>