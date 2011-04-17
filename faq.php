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
*-------------------   Saturday, JUN 27, 2009 1:05 AM   -----------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include ("header.php");
OpenTable(_btfaqs);
$res1 = "SELECT `id`, `question`, `flag` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res, MYSQL_BOTH)) {
 $faq_categ[$arr[id]][title] = $arr[question];
 $faq_categ[$arr[id]][flag] = $arr[flag];
}

$res1 = "SELECT `id`, `question`, `answer`, `flag`, `categ` FROM `".$db_prefix."_faq` WHERE `type`='item' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res, MYSQL_BOTH)) {
 $faq_categ[$arr[categ]][items][$arr[id]][question] = $arr[question];
 $faq_categ[$arr[categ]][items][$arr[id]][answer] = $arr[answer];
 $faq_categ[$arr[categ]][items][$arr[id]][flag] = $arr[flag];
}

if (isset($faq_categ)) {
// gather orphaned items
 foreach ($faq_categ as $id => $temp) {
  if (!array_key_exists("title", $faq_categ[$id])) {
   foreach ($faq_categ[$id][items] as $id2 => $temp) {
    $faq_orphaned[$id2][question] = $faq_categ[$id][items][$id2][question];
	$faq_orphaned[$id2][answer] = $faq_categ[$id][items][$id2][answer];
    $faq_orphaned[$id2][flag] = $faq_categ[$id][items][$id2][flag];
    unset($faq_categ[$id]);
   }
  }
 }

 foreach ($faq_categ as $id => $temp) {
  if ($faq_categ[$id][flag] == "1") {
   print("<p><ul><li><a href=\"./faq.php#". $id ."\"><b>". stripslashes($faq_categ[$id][title]) ."</b></a><ul>");
   if (array_key_exists("items", $faq_categ[$id])) {
    foreach ($faq_categ[$id][items] as $id2 => $temp) {
	 if ($faq_categ[$id][items][$id2][flag] == "1") print("<li><a href=\"./faq.php#". $id2 ."\" class=\"altlink\">". stripslashes($faq_categ[$id][items][$id2][question]) ."</a></li>");
	 elseif ($faq_categ[$id][items][$id2][flag] == "2") print("<li><a href=\"./faq.php#". $id2 ."\" class=\"altlink\">". stripslashes($faq_categ[$id][items][$id2][question]) ."</a> <img src=\"images/updated.png\" alt=\"Updated\" width=\"46\" height=\"13\" align=\"absbottom\"></li>");
	 elseif ($faq_categ[$id][items][$id2][flag] == "3") print("<li><a href=\"./faq.php#". $id2 ."\" class=\"altlink\">". stripslashes($faq_categ[$id][items][$id2][question]) ."</a> <img src=\"images/new.png\" alt=\"New\" width=\"25\" height=\"12\" align=\"absbottom\"></li>");
    }
   }
   print("</ul></li></ul></p><br />");
  }
 }
 CloseTable();

 foreach ($faq_categ as $id => $temp) {
  if ($faq_categ[$id][flag] == "1") {
   $frame = $faq_categ[$id][title] ." - <a href=\"./faq.php#top\">Top</a>";
   OpenTable($frame);
   print("<a name=\"#". $id ."\" id=\"". $id ."\"></a>");
   if (array_key_exists("items", $faq_categ[$id])) {
    foreach ($faq_categ[$id][items] as $id2 => $temp) {
	 if ($faq_categ[$id][items][$id2][flag] != "0") {
      print("<br /><p><b>". stripslashes($faq_categ[$id][items][$id2][question]) ."</b><a name=\"#". $id2 ."\" id=\"". $id2 ."\"></a></p><br />");
      print("<br /><p>". stripslashes($faq_categ[$id][items][$id2][answer]) ."</p><br /><br />");
	 }
    }
   }
   CloseTable();
  }
 }

}

include ("footer.php")

?>