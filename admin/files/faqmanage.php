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
if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

OpenTable(_btpage_faqactions.php);

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
  print("<tr><td class=\"colhead\" align=\"center\" colspan=\"2\">"._admposition."</td><td class=\"colhead\" align=\"left\">"._adm_faq_sectile."</td><td class=\"colhead\" align=\"center\">"._admtrkstatus."</td><td class=\"colhead\" align=\"center\">"._admbanactions."</td></tr>\n");

  print("<tr><td align=\"center\" width=\"40px\"><select name=\"order[". $id ."]\">");
  for ($n=1; $n <= count($faq_categ); $n++) {
   $sel = ($n == $faq_categ[$id][order]) ? " selected=\"selected\"" : "";
   print("<option value=\"$n\"". $sel .">". $n ."</option>");
  }
  $status = ($faq_categ[$id][flag] == "0") ? "<font color=\"red\">"._adm_faq_hidden."</font>" : ""._adm_faq_norm."";
  print("</select></td><td align=\"center\" width=\"40px\">&nbsp;</td><td><b>". stripslashes($faq_categ[$id][title]) ."</b></td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id ."\">edit</a> <a href=\"faqactions.php?action=delete&id=". $id ."\">delete</a></td></tr>\n");

  if (array_key_exists("items", $faq_categ[$id])) {
   foreach ($faq_categ[$id][items] as $id2 => $temp) {
    print("<tr><td align=\"center\" width=\"40px\">&nbsp;</td><td align=\"center\" width=\"40px\"><select name=\"order[". $id2 ."]\">");
    for ($n=1; $n <= count($faq_categ[$id][items]); $n++) {
     $sel = ($n == $faq_categ[$id][items][$id2][order]) ? " selected=\"selected\"" : "";
     print("<option value=\"$n\"". $sel .">". $n ."</option>");
    }
    if ($faq_categ[$id][items][$id2][flag] == "0") $status = "<font color=\"#FF0000\">"._adm_faq_hidden."</font>";
    elseif ($faq_categ[$id][items][$id2][flag] == "2") $status = "<font color=\"#0000FF\">"._adm_faq_updated."</font>";
    elseif ($faq_categ[$id][items][$id2][flag] == "3") $status = "<font color=\"#008000\">"._adm_faq_new."</font>";
    else $status = "Normal";
    print("</select></td><td>". stripslashes($faq_categ[$id][items][$id2][question]) ."</td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id2 ."\">edit</a> <a href=\"faqactions.php?action=delete&id=". $id2 ."\">delete</a></td></tr>\n");
   }
  }

  print("<tr><td colspan=\"5\" align=\"center\"><a href=\"faqactions.php?action=additem&inid=". $id ."\">"._adm_faq_additem."</a></td></tr>\n");
  print("</table>\n");
 }
}

// print the orphaned items table
if (isset($faq_orphaned)) {
 print("<br />\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n");
 print("<tr><td align=\"center\" colspan=\"3\"><b style=\"color: #FF0000\">"._adm_faq_orphen."</b></td>\n");
 print("<tr><td class=\"colhead\" align=\"left\">"._adm_faq_tile."</td><td class=\"colhead\" align=\"center\">"._admtrkstatus."</td><td class=\"colhead\" align=\"center\">"._admbanactions."</td></tr>\n");
 foreach ($faq_orphaned as $id => $temp) {
  if ($faq_orphaned[$id][flag] == "0") $status = "<font color=\"#FF0000\">"._adm_faq_hidden."</font>";
  elseif ($faq_orphaned[$id][flag] == "2") $status = "<font color=\"#0000FF\">"._adm_faq_updated."</font>";
  elseif ($faq_orphaned[$id][flag] == "3") $status = "<font color=\"#008000\">"._adm_faq_new."</font>";
  else $status = "Normal";
  print("<tr><td>". stripslashes($faq_orphaned[$id][question]) ."</td><td align=\"center\" width=\"60px\">". $status ."</td><td align=\"center\" width=\"60px\"><a href=\"faqactions.php?action=edit&id=". $id ."\">"._btalt_edit."</a> <a href=\"faqactions.php?action=delete&id=". $id ."\">"._btalt_drop."</a></td></tr>\n");
 }
 print("</table>\n");
}

print("<br />\n<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n<tr><td align=\"center\"><a href=\"faqactions.php?action=addsection\">"._adm_faq_addsection."</a></td></tr>\n</table>\n");
print("<p align=\"center\"><input type=\"submit\" name=\"reorder\" value=\""._adm_faq_order."\"></p>\n");
print("</form>\n");
print(_adm_faq_order_no_match);

CloseTable();
?>