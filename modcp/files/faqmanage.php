<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------               Hacked For phpMyBitTorrent                     --------*
*--------                       By Joeroberts                         ---------*
*--------              http://www.moviegamesmore.net                   --------*
*------------------------------------------------------------------------------*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");

OpenTable("FAQ Management");

// make the array that has all the faq in a nice structured
$res1 = "SELECT `id`, `question`, `flag`, `order` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res, MYSQL_BOTH)) {
 $faq_categ[$arr[id]][title] = $arr[question];
 $faq_categ[$arr[id]][flag] = $arr[flag];
 $faq_categ[$arr[id]][order] = $arr[order];
}

$res1 = "SELECT `id`, `question`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `type`='item' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res, MYSQL_BOTH)) {
 $faq_categ[$arr[categ]][items][$arr[id]][question] = $arr[question];
 $faq_categ[$arr[categ]][items][$arr[id]][flag] = $arr[flag];
 $faq_categ[$arr[categ]][items][$arr[id]][order] = $arr[order];
}

if (isset($faq_categ)) {
// gather orphaned items
 foreach ($faq_categ as $id => $temp) {
  if (!array_key_exists("title", $faq_categ[$id])) {
   foreach ($faq_categ[$id][items] as $id2 => $temp) {
    $faq_orphaned[$id2][question] = $faq_categ[$id][items][$id2][question];
    $faq_orphaned[$id2][flag] = $faq_categ[$id][items][$id2][flag];
    unset($faq_categ[$id]);
   }
  }
 }

// print the faq table
 print("<form method=\"post\" action=\"faqactions.php?action=reorder\">");

 foreach ($faq_categ as $id => $temp) {
  print("<br />\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n");
  print("<tr><td class=\"colhead\" align=\"center\" colspan=\"2\">Position</td><td class=\"colhead\" align=\"left\">Section/Item Title</td><td class=\"colhead\" align=\"center\">Status</td><td class=\"colhead\" align=\"center\">Actions</td></tr>\n");

  print("<tr><td align=\"center\" width=\"40px\"><select name=\"order[". $id ."]\">");
  for ($n=1; $n <= count($faq_categ); $n++) {
   $sel = ($n == $faq_categ[$id][order]) ? " selected=\"selected\"" : "";
   print("<option value=\"$n\"". $sel .">". $n ."</option>");
  }
  $status = ($faq_categ[$id][flag] == "0") ? "<font color=\"red\">Hidden</font>" : "Normal";
  print("</select></td><td align=\"center\" width=\"40px\">&nbsp;</td><td><b>". stripslashes($faq_categ[$id][title]) ."</b></td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id ."\">edit</a> <a href=\"faqactions.php?action=delete&id=". $id ."\">delete</a></td></tr>\n");

  if (array_key_exists("items", $faq_categ[$id])) {
   foreach ($faq_categ[$id][items] as $id2 => $temp) {
    print("<tr><td align=\"center\" width=\"40px\">&nbsp;</td><td align=\"center\" width=\"40px\"><select name=\"order[". $id2 ."]\">");
    for ($n=1; $n <= count($faq_categ[$id][items]); $n++) {
     $sel = ($n == $faq_categ[$id][items][$id2][order]) ? " selected=\"selected\"" : "";
     print("<option value=\"$n\"". $sel .">". $n ."</option>");
    }
    if ($faq_categ[$id][items][$id2][flag] == "0") $status = "<font color=\"#FF0000\">Hidden</font>";
    elseif ($faq_categ[$id][items][$id2][flag] == "2") $status = "<font color=\"#0000FF\">Updated</font>";
    elseif ($faq_categ[$id][items][$id2][flag] == "3") $status = "<font color=\"#008000\">New</font>";
    else $status = "Normal";
    print("</select></td><td>". stripslashes($faq_categ[$id][items][$id2][question]) ."</td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id2 ."\">edit</a> <a href=\"faqactions.php?action=delete&id=". $id2 ."\">delete</a></td></tr>\n");
   }
  }

  print("<tr><td colspan=\"5\" align=\"center\"><a href=\"faqactions.php?action=additem&inid=". $id ."\">Add new item</a></td></tr>\n");
  print("</table>\n");
 }
}

// print the orphaned items table
if (isset($faq_orphaned)) {
 print("<br />\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n");
 print("<tr><td align=\"center\" colspan=\"3\"><b style=\"color: #FF0000\">Orphaned Items</b></td>\n");
 print("<tr><td class=\"colhead\" align=\"left\">Item Title</td><td class=\"colhead\" align=\"center\">Status</td><td class=\"colhead\" align=\"center\">Actions</td></tr>\n");
 foreach ($faq_orphaned as $id => $temp) {
  if ($faq_orphaned[$id][flag] == "0") $status = "<font color=\"#FF0000\">Hidden</font>";
  elseif ($faq_orphaned[$id][flag] == "2") $status = "<font color=\"#0000FF\">Updated</font>";
  elseif ($faq_orphaned[$id][flag] == "3") $status = "<font color=\"#008000\">New</font>";
  else $status = "Normal";
  print("<tr><td>". stripslashes($faq_orphaned[$id][question]) ."</td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id ."\">edit</a> <a href=\"faqactions.php?action=delete&id=". $id ."\">delete</a></td></tr>\n");
 }
 print("</table>\n");
}

print("<br />\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n<tr><td align=\"center\"><a href=\"faqactions.php?action=addsection\">Add new section</a></td></tr>\n</table>\n");
print("<p align=\"center\"><input type=\"submit\" name=\"reorder\" value=\"Reorder\"></p>\n");
print("</form>\n");
print("When the position numbers don't reflect the position in the table, it means the order id is bigger than the total number of sections/items and you should check all the order id's in the table and click \"reorder\"\n");

CloseTable();
?>